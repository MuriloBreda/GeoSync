<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function iniciar(Request $request)
    {
        $chat = [];

        $chat[] = [
            'type' => 'me',
            'text' =>
                "Nome: {$request->nome}\n" .
                "Email: {$request->email}\n" .
                "Assunto: {$request->assunto}\n\n" .
                $request->mensagem,
            'time' => now()->format('H:i')
        ];

        $resposta = $this->gerarRespostaIA($request->mensagem);

        $chat[] = [
            'type' => 'other',
            'text' => $resposta,
            'time' => now()->format('H:i')
        ];

        session([
            'chat' => $chat
        ]);

        return redirect()->route('chat');
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'mensagem' => 'required|string'
        ]);

        $chat = session('chat', []);

        $chat[] = [
            'type' => 'me',
            'text' => $request->mensagem,
            'time' => now()->format('H:i')
        ];

        $resposta = $this->gerarRespostaIA($request->mensagem);

        $chat[] = [
            'type' => 'other',
            'text' => $resposta,
            'time' => now()->format('H:i')
        ];

        session([
            'chat' => $chat
        ]);

        return redirect()->route('chat');
    }

    private function gerarRespostaIA($mensagem)
    {
        try {

            $response = Http::timeout(120)->post(
                'http://localhost:11434/api/generate',
                [
                    'model' => 'llama3',
                    'prompt' => "
                    Você é a GeoSync I.A.

                    A GeoSync é uma plataforma de logística,
                    rastreamento de veículos,
                    gestão de entregas e monitoramento.

                    Regras:
                    - Responda sempre em português.
                    - Seja profissional.
                    - Nunca diga que é Llama ou Meta AI.
                    - Sempre diga que é a GeoSync I.A.

                    Pergunta:
                    {$mensagem}
                    ",
                    'stream' => false
                ]
            );

            return $response->json()['response']
                ?? 'Não consegui gerar uma resposta.';
        } catch (\Exception $e) {

            return 'A GeoSync I.A está indisponível no momento.';
        }
    }

    public function testeIA()
    {
        $response = Http::timeout(120)->post(
            'http://localhost:11434/api/generate',
            [
                'model' => 'llama3',
                'prompt' => 'Quem é você?',
                'stream' => false
            ]
        );

        dd($response->json());
    }
}