<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeocodificadorDestino
{
    /**
     * Converte o endereco estruturado da remessa no ponto usado pelo mapa.
     * Nunca retorna CEP, bairro ou cidade como se fosse o endereco da entrega.
     *
     * @param array<string, mixed> $endereco
     * @return array{latitude_destino: float, longitude_destino: float}
     */
    public function localizar(array $endereco): array
    {
        $rua = trim((string) ($endereco['destino_rua'] ?? ''));
        $numero = trim((string) ($endereco['destino_numero'] ?? ''));
        $cidade = trim((string) ($endereco['destino_cidade'] ?? ''));
        $estado = trim((string) ($endereco['destino_estado'] ?? ''));
        $cep = preg_replace('/\D/', '', (string) ($endereco['destino_cep'] ?? ''));

        if (!$rua || !$numero || !$cidade || !$estado || strlen($cep) !== 8) {
            throw new RuntimeException('Informe rua, numero, cidade, estado e CEP para localizar o destino exato.');
        }

        $ruaNormalizada = $this->normalizar($rua);
        $numeroNormalizado = $this->normalizar($numero);

        // Primeiro tenta o imovel exato. Nem todo numero de porta esta mapeado,
        // por isso a segunda consulta aceita somente a mesma rua no mesmo CEP.
        $coordenadas = $this->coordenadasDaResposta(
            $this->consultar($numero . ' ' . $rua, $cidade, $estado, $cep),
            $ruaNormalizada,
            $numeroNormalizado,
            true,
        );

        if ($coordenadas) {
            return $coordenadas;
        }

        $coordenadas = $this->coordenadasDaResposta(
            $this->consultar($rua, $cidade, $estado, $cep),
            $ruaNormalizada,
            $numeroNormalizado,
            false,
        );

        if ($coordenadas) {
            return $coordenadas;
        }

        $coordenadas = $this->localizarPorRuaNoPhoton(
            $rua,
            $cidade,
            $estado,
            $cep,
            $ruaNormalizada,
        );

        if ($coordenadas) {
            return $coordenadas;
        }

        throw new RuntimeException('O mapa nao encontrou a rua informada nesse CEP e cidade. Revise o endereco antes de salvar.');
    }

    /** @return array<int, array<string, mixed>> */
    private function consultar(string $rua, string $cidade, string $estado, string $cep): array
    {
        try {
            $resposta = Http::acceptJson()
                ->withUserAgent('GeoSync/1.0 (geocodificacao de entregas)')
                ->timeout(3)
                ->retry(1, 200)
                ->get('https://nominatim.openstreetmap.org/search', [
                    'format' => 'jsonv2',
                    'addressdetails' => 1,
                    'limit' => 10,
                    'countrycodes' => 'br',
                    'street' => $rua,
                    'city' => $cidade,
                    'state' => $estado,
                    'postalcode' => $cep,
                ]);
        } catch (\Throwable) {
            // Permite que o provedor alternativo seja tentado.
            return [];
        }

        return $resposta->successful() && is_array($resposta->json())
            ? $resposta->json()
            : [];
    }

    /** @param array<int, array<string, mixed>> $resultados */
    private function coordenadasDaResposta(array $resultados, string $ruaNormalizada, string $numeroNormalizado, bool $exigirNumero): ?array
    {
        foreach ($resultados as $resultado) {
            $enderecoRetornado = $resultado['address'] ?? [];
            $ruaRetornada = $this->normalizar($enderecoRetornado['road'] ?? '');
            $numeroRetornado = $this->normalizar($enderecoRetornado['house_number'] ?? '');

            if (
                !$ruaRetornada ||
                !str_contains($ruaRetornada, $ruaNormalizada) ||
                ($exigirNumero && $numeroRetornado !== $numeroNormalizado)
            ) {
                continue;
            }

            $latitude = filter_var($resultado['lat'] ?? null, FILTER_VALIDATE_FLOAT);
            $longitude = filter_var($resultado['lon'] ?? null, FILTER_VALIDATE_FLOAT);

            if ($latitude !== false && $longitude !== false && $latitude >= -90 && $latitude <= 90 && $longitude >= -180 && $longitude <= 180) {
                return [
                    'latitude_destino' => (float) $latitude,
                    'longitude_destino' => (float) $longitude,
                ];
            }
        }

        return null;
    }

    /** @return array{latitude_destino: float, longitude_destino: float}|null */
    private function localizarPorRuaNoPhoton(
        string $rua,
        string $cidade,
        string $estado,
        string $cep,
        string $ruaNormalizada,
    ): ?array {
        try {
            $resposta = Http::acceptJson()
                ->timeout(3)
                ->retry(1, 200)
                ->get('https://photon.komoot.io/api/', [
                    'q' => implode(', ', [$rua, $cidade, $estado, $cep, 'Brasil']),
                    'limit' => 10,
                    'lang' => 'pt',
                ]);
        } catch (\Throwable) {
            return null;
        }

        $resultados = $resposta->json('features', []);

        if (!$resposta->successful() || !is_array($resultados)) {
            return null;
        }

        foreach ($resultados as $resultado) {
            $propriedades = $resultado['properties'] ?? [];
            $ruaRetornada = $this->normalizar((string) ($propriedades['street'] ?? $propriedades['name'] ?? ''));

            if (!$ruaRetornada || !str_contains($ruaRetornada, $ruaNormalizada)) {
                continue;
            }

            $coordenadas = $resultado['geometry']['coordinates'] ?? [];
            $longitude = filter_var($coordenadas[0] ?? null, FILTER_VALIDATE_FLOAT);
            $latitude = filter_var($coordenadas[1] ?? null, FILTER_VALIDATE_FLOAT);

            if ($latitude !== false && $longitude !== false && $latitude >= -90 && $latitude <= 90 && $longitude >= -180 && $longitude <= 180) {
                return [
                    'latitude_destino' => (float) $latitude,
                    'longitude_destino' => (float) $longitude,
                ];
            }
        }

        return null;
    }

    private function normalizar(string $valor): string
    {
        $valor = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $valor) ?: $valor;
        $valor = strtolower($valor);
        $valor = preg_replace('/[^a-z0-9]/', '', $valor) ?? '';

        return preg_replace('/^(rua|avenida|av|travessa|estrada)/', '', $valor) ?? $valor;
    }
}
