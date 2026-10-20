<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IAController extends Controller
{
    public function antifraude()
    {
        $tempoParado = rand(0, 120); 
        $desvioRota = rand(0, 1); 
        $velocidade = rand(0, 120); 

        $risco = "baixo";
        $mensagem = "Operação normal";

        if ($tempoParado > 60) {
            $risco = "alto";
            $mensagem = "Caminhão parado por muito tempo em local suspeito";
        }

        if ($desvioRota) {
            $risco = "alto";
            $mensagem = "Mudança de rota detectada fora do padrão";
        }

        if ($velocidade > 100) {
            $risco = "medio";
            $mensagem = "Velocidade acima do limite permitido";
        }

        return response()->json([
            'mensagem' => $mensagem,
            'risco' => $risco,
            'tempo_parado' => $tempoParado,
            'velocidade' => $velocidade,
            'desvio_rota' => $desvioRota ? 'Sim' : 'Não'
        ]);
    }
}
