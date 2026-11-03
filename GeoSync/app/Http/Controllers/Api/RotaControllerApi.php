<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RotaControllerApi extends Controller
{
    public function estimar(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'origin.latitude' => ['required', 'numeric', 'between:-90,90'],
            'origin.longitude' => ['required', 'numeric', 'between:-180,180'],
            'destination.latitude' => ['required', 'numeric', 'between:-90,90'],
            'destination.longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $chave = config('services.google.routes_key');
        if (!is_string($chave) || trim($chave) === '') {
            return response()->json(['message' => 'Serviço de rotas não configurado.'], 503);
        }

        $origem = $dados['origin'];
        $destino = $dados['destination'];
        $cacheKey = 'google_routes:' . hash('sha256', json_encode([
            round((float) $origem['latitude'], 3),
            round((float) $origem['longitude'], 3),
            round((float) $destino['latitude'], 4),
            round((float) $destino['longitude'], 4),
            now('UTC')->format('YmdHi'),
        ]));

        $cached = Cache::get($cacheKey);
        if (is_array($cached)) {
            return response()->json(['data' => $cached, 'cached' => true]);
        }

        try {
            $response = Http::timeout(8)
                ->acceptJson()
                ->withHeaders([
                    'X-Goog-Api-Key' => $chave,
                    'X-Goog-FieldMask' => 'routes.duration,routes.distanceMeters',
                ])
                ->post('https://routes.googleapis.com/directions/v2:computeRoutes', [
                    'origin' => ['location' => ['latLng' => [
                        'latitude' => (float) $origem['latitude'],
                        'longitude' => (float) $origem['longitude'],
                    ]]],
                    'destination' => ['location' => ['latLng' => [
                        'latitude' => (float) $destino['latitude'],
                        'longitude' => (float) $destino['longitude'],
                    ]]],
                    'travelMode' => 'DRIVE',
                    'routingPreference' => 'TRAFFIC_AWARE',
                    'departureTime' => now('UTC')->toIso8601String(),
                    'units' => 'METRIC',
                ]);
        } catch (\Throwable $exception) {
            Log::warning('Google Routes API indisponível.', ['exception' => $exception::class]);
            return response()->json(['message' => 'Serviço de rotas temporariamente indisponível.'], 502);
        }

        if (!$response->successful()) {
            Log::warning('Google Routes API respondeu com erro.', ['status' => $response->status()]);
            return response()->json(['message' => 'Serviço de rotas temporariamente indisponível.'], 502);
        }

        $rota = $response->json('routes.0');
        $metros = data_get($rota, 'distanceMeters');
        $segundosTexto = data_get($rota, 'duration');
        if (!is_numeric($metros) || !is_string($segundosTexto) || !preg_match('/^(\d+(?:\.\d+)?)s$/', $segundosTexto, $match)) {
            return response()->json(['message' => 'Não foi encontrada uma rota viária para esse destino.'], 404);
        }

        $estimativa = [
            'distance_km' => round(((float) $metros) / 1000, 2),
            'duration_minutes' => (int) ceil(((float) $match[1]) / 60),
        ];
        Cache::put($cacheKey, $estimativa, now()->addSeconds(60));

        return response()->json(['data' => $estimativa, 'cached' => false]);
    }
}