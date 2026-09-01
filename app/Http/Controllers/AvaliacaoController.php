<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaliacao;

class AvaliacaoController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validação dos dados
        $request->validate([
            'nota' => 'required|integer|between:1,5',
            'comentario' => 'required|string|max:1000',
            'nome_exibicao' => 'nullable|string|max:255',
        ], [
            'nota.required' => 'A nota é obrigatória.',
            'nota.between' => 'A nota deve ser entre 1 e 5 estrelas.',
            'comentario.required' => 'Escreva um comentário.',
        ]);

        try {
            // 2. Criação do registro sem o user_id
            Avaliacao::create([
                'nome_exibicao' => $request->nome_exibicao ?? 'Anônimo',
                'nota'          => $request->nota,
                'comentario'    => $request->comentario,
            ]);

            return back()->with('success', 'Avaliação enviada com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro no Banco: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $media = Avaliacao::avg('nota') ?? 0;
        $total = Avaliacao::count();
        $satisfacao = Avaliacao::where('nota', '>=', 4)->count();

        $percentualSatisfacao = $total > 0
            ? round(($satisfacao / $total) * 100)
            : 0;

        return view('avaliacao', compact(
            'media',
            'total',
            'percentualSatisfacao'
        ));
    }
}