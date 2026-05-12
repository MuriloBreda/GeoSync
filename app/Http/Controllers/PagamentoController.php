<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validação dos dados que vem do formulário
        $request->validate([
            'valor' => 'required|numeric',
            'metodo' => 'required|string',
        ]);

        // 2. Criação do registro no banco
        try {
            Pagamento::create([
                // Pega o ID do usuário logado, se não houver, usa o ID 1 para teste de TCC
                'user_id' => Auth::id() ?? 1, 
                'valor'   => $request->valor,
                'status'  => 'Aprovado', // No TCC simulamos a aprovação imediata
            ]);

            // 3. Retorna para a página com uma mensagem de sucesso
            return back()->with('success', 'Pagamento realizado com sucesso!');

        } catch (\Exception $e) {
            // Caso dê erro no banco de dados
            return back()->withErrors(['erro' => 'Falha ao salvar pagamento: ' . $e->getMessage()]);
        }
    }
}