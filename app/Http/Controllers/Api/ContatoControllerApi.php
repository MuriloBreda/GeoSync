<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contato;
use Illuminate\Http\Request;

class ContatoControllerApi extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate(['nome' => 'required|string|max:100', 'email' => 'required|email|max:100', 'mensagem' => 'required|string']);
        $data['created_at'] = now();
        return response()->json(['success' => true, 'message' => 'Mensagem enviada.', 'data' => Contato::create($data)], 201);
    }
}
