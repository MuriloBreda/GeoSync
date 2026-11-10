<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProfilePhotoControllerApi extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $arquivo = $data['foto'];
        $diretorio = public_path('uploads/perfis');
        File::ensureDirectoryExists($diretorio);

        $nome = Str::uuid().'.'.$arquivo->extension();
        $arquivo->move($diretorio, $nome);

        $usuario = $request->user();
        $fotoAnterior = $usuario->foto;
        $usuario->update(['foto' => 'uploads/perfis/'.$nome]);
        $this->removerArquivoLocal($fotoAnterior);

        return response()->json([
            'success' => true,
            'message' => 'Foto do perfil atualizada.',
            'data' => $usuario->fresh(),
        ]);
    }

    public function destroy(Request $request)
    {
        $usuario = $request->user();
        $fotoAnterior = $usuario->foto;
        $usuario->update(['foto' => null]);
        $this->removerArquivoLocal($fotoAnterior);

        return response()->json([
            'success' => true,
            'message' => 'Foto do perfil removida.',
            'data' => $usuario->fresh(),
        ]);
    }

    private function removerArquivoLocal(?string $caminho): void
    {
        if ($caminho === null || !str_starts_with($caminho, 'uploads/perfis/')) {
            return;
        }

        $nome = basename($caminho);
        if ($nome !== '' && $nome !== '.' && $nome !== '..') {
            File::delete(public_path('uploads/perfis/'.$nome));
        }
    }
}