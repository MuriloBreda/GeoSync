<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_mobile_user_can_register_and_receive_a_token(): void
    {
        DB::table('pagamentos')->insert([
            'email' => 'cliente@example.com',
            'valor' => 100,
            'status' => 'Aprovado',
            'user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'Cliente Teste',
            'email' => 'cliente@example.com',
            'cpf' => '12345678900',
            'telefone' => '11999999999',
            'tipo' => 'cliente',
            'password' => 'senha-segura',
            'password_confirmation' => 'senha-segura',
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('token_type', 'Bearer')
            ->assertJsonStructure(['token', 'data' => ['id', 'name', 'email', 'tipo']]);

        $userId = $response->json('data.id');
        $this->assertNotNull($userId);
        $this->assertDatabaseHas('users', ['email' => 'cliente@example.com', 'tipo' => 'cliente']);
        $this->assertDatabaseHas('pagamentos', [
            'email' => 'cliente@example.com',
            'user_id' => $userId,
            'status' => 'Aprovado',
        ]);
    }
}
