<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;
use Illuminate\Support\Facades\Log;

class PagamentoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email:rfc|max:100',
            'telefone' => 'required|string|max:20',
            'cnpj' => ['nullable', 'string', 'max:18', 'regex:/^[0-9.\/-]+$/'],
            'valor' => 'required|numeric|in:149.99,599.99',
            'plano' => 'required|string|in:GeoSync Start,GeoSync Pro',
            'metodo' => 'required|string|in:credito,pix,boleto',
        ]);

        // 2. Criação do registro no banco
        try {
            Pagamento::create([
                'user_id' => null,
                'email' => strtolower($data['email']),
                'telefone' => $data['telefone'],
                'cnpj' => $data['cnpj'] ?? null,
                'plano' => $data['plano'],
                'metodo' => $data['metodo'],
                'valor' => $data['valor'],
                'status' => 'Aprovado', // Aprovação simulada no checkout do TCC.
            ]);

            $mensagem = implode("\n", [
                'Olá! Confirmei o pagamento e quero dar andamento à compra do GPS GeoSync.',
                'Plano: ' . $data['plano'],
                'Valor: R$ ' . number_format((float) $data['valor'], 2, ',', '.'),
                'Forma de pagamento: ' . $data['metodo'],
                'E-mail: ' . strtolower($data['email']),
                'Telefone: ' . $data['telefone'],
                'CNPJ: ' . ($data['cnpj'] ?? 'Não informado'),
                'Gostaria de receber as orientações para entrega do GPS e acesso ao acompanhamento da encomenda.',
            ]);

            $whatsappUrl = 'https://wa.me/5519994010744?text=' . rawurlencode($mensagem);

            if ($request->expectsJson()) {
                return response()->json(['whatsapp_url' => $whatsappUrl]);
            }

            return redirect()->away($whatsappUrl);

        } catch (\Exception $e) {
            Log::error('Falha ao registrar pagamento GeoSync', ['exception' => $e]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Não foi possível registrar o pagamento. Tente novamente.',
                ], 500);
            }

            // Caso dê erro no banco de dados
            return back()->withInput()->withErrors(['erro' => 'Não foi possível registrar o pagamento. Tente novamente.']);
        }
    }
}
