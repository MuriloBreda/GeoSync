<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;

class PagamentoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email:rfc|max:255',
            'valor' => 'required|numeric|in:149.99,599.99',
            'plano' => 'required|string|in:GeoSync Start,GeoSync Pro',
            'metodo' => 'required|string|in:credito,pix,boleto',
        ]);

        // 2. Criação do registro no banco
        try {
            Pagamento::create([
                'user_id' => null,
                'email' => strtolower($data['email']),
                'valor' => $data['valor'],
                'status' => 'Aprovado', // Aprovação simulada no checkout do TCC.
            ]);

            // 3. Retorna para a página com uma mensagem de sucesso
            return redirect()->route('register', ['email' => strtolower($data['email'])])
                ->with('success', 'Pagamento aprovado! Agora crie sua conta usando o mesmo e-mail.');

        } catch (\Exception $e) {
            // Caso dê erro no banco de dados
            return back()->withInput()->withErrors(['erro' => 'Não foi possível registrar o pagamento. Tente novamente.']);
        }
    }
}
