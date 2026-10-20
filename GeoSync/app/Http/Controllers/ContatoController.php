<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contato;

class ContatoController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validação
        $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'mensagem' => 'required|string',
        ]);

        // 2. Salva no Banco de Dados (tabela contatos)
        Contato::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'mensagem' => $request->mensagem,
            'created_at' => now()
        ]);

        // 3. Redireciona para a tela de chat que você criou
        return redirect()->route('chat')->with('success', 'Mensagem enviada! Inicie seu atendimento.');
    }
}