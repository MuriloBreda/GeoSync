<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pagamento;
use Illuminate\Http\Request;

class PagamentoControllerApi extends Controller
{
    public function index(Request $request)
    {
        $query = Pagamento::with('user:id,name,email')->latest();
        if ($request->user()->tipo !== 'admin') $query->where('user_id', $request->user()->id);
        return response()->json(['success' => true, 'data' => $query->paginate(20)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['valor' => 'required|numeric|min:0.01']);
        $payment = Pagamento::create(['user_id' => $request->user()->id, 'valor' => $data['valor'], 'status' => 'Aprovado']);
        return response()->json(['success' => true, 'message' => 'Pagamento registrado.', 'data' => $payment], 201);
    }

    public function show(Request $request, Pagamento $pagamento)
    {
        abort_unless($request->user()->tipo === 'admin' || $pagamento->user_id === $request->user()->id, 403);
        return response()->json(['success' => true, 'data' => $pagamento]);
    }
}
