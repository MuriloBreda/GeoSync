<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;
use Illuminate\Http\Request;

class AvaliacaoControllerApi extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'data' => Avaliacao::latest()->paginate(20)]);
    }

    public function resumo()
    {
        $total = Avaliacao::count();
        $satisfeitas = Avaliacao::where('nota', '>=', 4)->count();
        return response()->json(['success' => true, 'data' => ['media' => round((float) Avaliacao::avg('nota'), 2), 'total' => $total, 'percentual_satisfacao' => $total ? round($satisfeitas / $total * 100) : 0]]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nota' => 'required|integer|between:1,5', 'comentario' => 'required|string|max:1000', 'nome_exibicao' => 'nullable|string|max:255']);
        $data['nome_exibicao'] ??= $request->user()?->name ?? 'Anônimo';
        return response()->json(['success' => true, 'message' => 'Avaliação enviada.', 'data' => Avaliacao::create($data)], 201);
    }
}
