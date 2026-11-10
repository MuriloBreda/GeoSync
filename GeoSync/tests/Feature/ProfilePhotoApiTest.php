<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProfilePhotoApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var list<string> */
    private array $fotosCriadas = [];

    protected function tearDown(): void
    {
        foreach ($this->fotosCriadas as $foto) {
            File::delete(public_path($foto));
        }

        parent::tearDown();
    }

    public function test_clientes_e_motoristas_podem_adicionar_consultar_e_remover_foto(): void
    {
        foreach (['cliente', 'motorista'] as $tipo) {
            $usuario = User::factory()->create(['tipo' => $tipo]);

            $resposta = $this->actingAs($usuario, 'sanctum')->post(
                '/api/perfil/foto',
                ['foto' => UploadedFile::fake()->image('perfil.png')],
                ['Accept' => 'application/json'],
            );

            $resposta->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('data.tipo', $tipo);

            $foto = $resposta->json('data.foto');
            $this->assertIsString($foto);
            $this->assertStringStartsWith('uploads/perfis/', $foto);
            $this->fotosCriadas[] = $foto;
            $this->assertFileExists(public_path($foto));
            $this->assertDatabaseHas('users', [
                'id' => $usuario->id,
                'foto' => $foto,
            ]);

            $this->getJson('/api/auth/me')
                ->assertOk()
                ->assertJsonPath('data.foto', $foto);

            $this->deleteJson('/api/perfil/foto')
                ->assertOk()
                ->assertJsonPath('data.foto', null);
            $this->assertDatabaseHas('users', [
                'id' => $usuario->id,
                'foto' => null,
            ]);
            $this->assertFileDoesNotExist(public_path($foto));
        }
    }

    public function test_upload_da_foto_exige_autenticacao_e_imagem_valida(): void
    {
        $this->post('/api/perfil/foto', [
            'foto' => UploadedFile::fake()->image('perfil.jpg'),
        ], ['Accept' => 'application/json'])->assertUnauthorized();

        $usuario = User::factory()->create();
        $this->actingAs($usuario, 'sanctum')->post(
            '/api/perfil/foto',
            ['foto' => UploadedFile::fake()->create('not-image.txt', 10, 'text/plain')],
            ['Accept' => 'application/json'],
        )->assertUnprocessable()
            ->assertJsonValidationErrors('foto');
    }
}