<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocalizacaoControllerApi extends Controller
{
    /**
     * Recebe a localização enviada pelo ESP32/GPS
     */
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'remessa_id' => 'required|integer|exists:remessas,id',
        ]);

        $localizacao = DB::table('localizacoes')->insertGetId([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'remessa_id' => $request->remessa_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Localização recebida com sucesso!',
            'id' => $localizacao,
            'remessa_id' => $request->remessa_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ], 201);
    }

    /**
     * Retorna as localizações para o mapa
     */
    public function index(Request $request)
    {
        $query = DB::table('localizacoes')
            ->join('remessas', 'localizacoes.remessa_id', '=', 'remessas.id')
            ->select(
                'localizacoes.id',
                'localizacoes.latitude',
                'localizacoes.longitude',
                'localizacoes.remessa_id',
                'localizacoes.created_at',
                'remessas.codigo_rastreio',
                'remessas.origem',
                'remessas.destino',
                'remessas.status'
            );

        if ($request->has('remessa_id')) {
            $query->where(
                'localizacoes.remessa_id',
                $request->remessa_id
            );
        }

        return response()->json([
            'success' => true,
            'data' => $query
                ->orderBy('localizacoes.created_at', 'desc')
                ->get()
        ]);
    }
}