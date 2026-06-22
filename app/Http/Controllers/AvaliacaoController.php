<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaliacao;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    /**
     * Salva a avaliação no banco de dados.
     */
    
    public function store(Request $request)
    {
        // 1. Validação dos dados
        $request->validate([
            'nota' => 'required|integer|between:1,5',
            'comentario' => 'nullable|string|max:255',
        ], [
            'nota.required' => 'A nota é obrigatória.',
            'nota.between' => 'A nota deve ser entre 1 e 5 estrelas.',
        ]);

        try {
            // 2. Criação do registro
            Avaliacao::create([
                // Tenta pegar o ID do usuário logado. 
                // Se não houver login (teste), usa o ID 1 (Murilo).
                'user_id'    => Auth::id() ?? 1, 
                'nota'       => $request->nota,
                'comentario' => $request->comentario,
            ]);

            // 3. Redireciona com mensagem de sucesso
            return back()->with('success', 'Avaliação enviada com sucesso! Obrigado pelo feedback.');

        } catch (\Exception $e) {
            // Caso ocorra algum erro inesperado no banco
            return back()->withErrors(['error' => 'Erro ao salvar avaliação: ' . $e->getMessage()]);
        }

        
    }

    /**
     * Opcional: Lista todas as avaliações (pode ser útil para a index)
     */
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