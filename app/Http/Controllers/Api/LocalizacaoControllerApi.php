<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alerta;
use App\Models\Remessa;
use App\Notifications\EntregaProximaNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocalizacaoControllerApi extends Controller
{
    /**
     * Recebe a localização enviada pelo ESP32/GPS
     */
    public function store(Request $request)
    {
        // Firmware ESP32 mais antigo envia somente as coordenadas e a remessa.
        // Mantemos compatibilidade sem deixar de identificar o ponto como GPS.
        $request->mergeIfMissing(['fonte' => 'esp32_gps']);

        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'remessa_id' => 'required|integer|exists:remessas,id',
            'fonte' => 'required|in:esp32_gps',
        ]);

        $localizacao = DB::table('localizacoes')->insertGetId([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'remessa_id' => $request->remessa_id,
            'fonte' => $request->fonte,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $proximidade = $this->notificarProximidadeDoDestino(
            (int) $request->remessa_id,
            (float) $request->latitude,
            (float) $request->longitude,
        );

        return response()->json([
            'success' => true,
            'message' => 'Localização recebida com sucesso!',
            'id' => $localizacao,
            'remessa_id' => $request->remessa_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'proximidade_destino' => $proximidade,
        ], 201);
    }

    /**
     * Notifica uma única vez quando o GPS entra no raio de 100 metros.
     * O cálculo fica no servidor para não depender do firmware do ESP32.
     */
    private function notificarProximidadeDoDestino(int $remessaId, float $latitude, float $longitude): array
    {
        $remessa = Remessa::with('cliente')->find($remessaId);

        if (!$remessa || !$remessa->cliente || !$remessa->latitude_destino || !$remessa->longitude_destino) {
            return ['disponivel' => false];
        }

        $distancia = $this->distanciaEmMetros(
            $latitude,
            $longitude,
            (float) $remessa->latitude_destino,
            (float) $remessa->longitude_destino,
        );

        if ($distancia > 100 || $remessa->status === 'Entregue') {
            return ['disponivel' => true, 'distancia_metros' => round($distancia, 1), 'notificado' => false];
        }

        // Impede disparos repetidos a cada envio de GPS (normalmente a cada 5 s).
        $marcada = Remessa::whereKey($remessa->id)
            ->whereNull('proximidade_notificada_at')
            ->update(['proximidade_notificada_at' => now()]);

        if (!$marcada) {
            return ['disponivel' => true, 'distancia_metros' => round($distancia, 1), 'notificado' => false];
        }

        try {
            $remessa->cliente->notify(new EntregaProximaNotification($remessa, $distancia));
            Alerta::create([
                'remessa_id' => $remessa->id,
                'tipo' => 'Proximidade do destino',
                'mensagem' => 'A remessa está a aproximadamente ' . round($distancia) . ' metros do destino.',
            ]);

            return ['disponivel' => true, 'distancia_metros' => round($distancia, 1), 'notificado' => true];
        } catch (\Throwable $e) {
            // Libera uma nova tentativa no próximo ponto de GPS se o e-mail falhar.
            Remessa::whereKey($remessa->id)->update(['proximidade_notificada_at' => null]);
            Log::warning('Falha ao enviar alerta de proximidade.', ['remessa_id' => $remessa->id, 'exception' => $e->getMessage()]);

            return ['disponivel' => true, 'distancia_metros' => round($distancia, 1), 'notificado' => false, 'erro_email' => true];
        }
    }

    private function distanciaEmMetros(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $raioTerra = 6371000;
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);
        $a = sin($deltaLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($deltaLon / 2) ** 2;

        return $raioTerra * 2 * atan2(sqrt($a), sqrt(1 - $a));
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
                'localizacoes.fonte',
                'localizacoes.created_at',
                'remessas.codigo_rastreio',
                'remessas.origem',
                'remessas.destino',
                'remessas.status'
            );

        // Pontos criados antes da coluna "fonte" também são pontos de GPS.
        $query->where(function ($query) {
            $query->where('localizacoes.fonte', 'esp32_gps')
                ->orWhereNull('localizacoes.fonte');
        });

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

    public function porRemessa(int $remessa_id)
    {
        return $this->index(new Request(['remessa_id' => $remessa_id]));
    }

    public function ultimaPorRemessa(int $remessa_id)
    {
        $localizacao = DB::table('localizacoes')
            ->where('remessa_id', $remessa_id)
            ->where(function ($query) {
                $query->where('fonte', 'esp32_gps')
                    ->orWhereNull('fonte');
            })
            ->latest('created_at')
            ->first();

        return response()->json(['success' => true, 'data' => $localizacao]);
    }
}
