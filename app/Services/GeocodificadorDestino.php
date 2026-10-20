<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Converte QUALQUER endereço brasileiro em latitude/longitude.
 *
 * Cadeia de tentativas (para no primeiro resultado confiável):
 *  1. Nominatim estruturado (rua + número)      -> precisão "exato"
 *  2. Nominatim estruturado (só a rua)          -> precisão "rua"
 *  3. Nominatim texto livre                     -> "exato" / "rua"
 *  4. Photon (Komoot)                           -> "exato" / "rua"
 *  5. Coordenadas do CEP (BrasilAPI v2)         -> "cep"
 *  6. Nominatim por CEP                         -> "cep"
 *  7. Centro da cidade                          -> "cidade"
 *
 * Retorna apenas: latitude_destino, longitude_destino, destino_precisao.
 * Lança \RuntimeException se nada for encontrado.
 */
class GeocodificadorDestino
{
    private const ESTADOS = [
        'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas',
        'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo',
        'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
        'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina',
        'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins',
    ];

    private const ABREVIACOES = [
        'av' => 'avenida', 'r' => 'rua', 'rod' => 'rodovia', 'estr' => 'estrada', 'trav' => 'travessa',
        'al' => 'alameda', 'pc' => 'praca', 'pca' => 'praca', 'lgo' => 'largo', 'jd' => 'jardim',
        'vl' => 'vila', 'dr' => 'doutor', 'dra' => 'doutora', 'prof' => 'professor', 'profa' => 'professora',
        'sta' => 'santa', 'sto' => 'santo', 'cel' => 'coronel', 'gal' => 'general', 'eng' => 'engenheiro',
        'pres' => 'presidente', 'min' => 'ministro', 'cap' => 'capitao', 'ten' => 'tenente',
    ];

    private const IGNORAR = ['de', 'da', 'do', 'dos', 'das', 'e', 'rua', 'avenida', 'travessa', 'alameda',
        'praca', 'estrada', 'rodovia', 'largo', 'via', 'beco'];

    // ------------------------------------------------------------------
    // API pública
    // ------------------------------------------------------------------

    public function localizar(array $dados): array
    {
        $endereco = $this->normalizarEndereco($dados);

        if ($endereco['rua'] === '' && $endereco['cidade'] === '' && $endereco['cep'] === '') {
            throw new \RuntimeException('Endereço insuficiente para localizar o destino.');
        }

        $chave = 'geocode:v2:' . md5(json_encode($endereco));

        if ($cache = Cache::get($chave)) {
            return $cache;
        }

        $resultado = $this->buscar($endereco);

        // Resultado aproximado expira cedo para permitir nova tentativa.
        Cache::put($chave, $resultado, $resultado['destino_precisao'] === 'cidade' ? now()->addHours(6) : now()->addDays(30));

        return $resultado;
    }

    /** Distância em metros entre dois pontos (Haversine). */
    public static function distanciaEmMetros(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;

        return 6371000 * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    // ------------------------------------------------------------------
    // Normalização do endereço
    // ------------------------------------------------------------------

    private function normalizarEndereco(array $d): array
    {
        $e = [
            'rua' => trim((string) ($d['destino_rua'] ?? '')),
            'numero' => trim((string) ($d['destino_numero'] ?? '')),
            'bairro' => trim((string) ($d['destino_bairro'] ?? '')),
            'cidade' => trim((string) ($d['destino_cidade'] ?? '')),
            'estado' => strtoupper(trim((string) ($d['destino_estado'] ?? ''))),
            'cep' => preg_replace('/\D/', '', (string) ($d['destino_cep'] ?? '')),
            'texto' => trim((string) ($d['destino'] ?? '')),
        ];

        // Complementa o que faltar lendo o texto livre do destino.
        if ($e['texto'] !== '') {
            $extraido = $this->extrairDoTexto($e['texto']);
            foreach (['rua', 'numero', 'bairro', 'cidade', 'estado', 'cep'] as $campo) {
                if ($e[$campo] === '' && !empty($extraido[$campo])) {
                    $e[$campo] = $extraido[$campo];
                }
            }
        }

        if (strlen($e['cep']) !== 8) {
            $e['cep'] = '';
        }

        return $e;
    }

    /**
     * Entende formatos como:
     *  "Rua X, 123 - Compl - Bairro - Cidade - SP - CEP: 13000-000"
     *  "Av. Y, 45, Bairro, Cidade - SP, 13000-000, Brasil"
     *  "Rua Z 10, Cidade/SP"
     */
    private function extrairDoTexto(string $texto): array
    {
        $r = [];

        if (preg_match('/(\d{5})-?(\d{3})/', $texto, $m)) {
            $r['cep'] = $m[1] . $m[2];
        }

        $limpo = preg_replace('/CEP:?\s*\d{5}-?\d{3}/i', '', $texto);
        $limpo = preg_replace('/\d{5}-?\d{3}/', '', $limpo);
        $limpo = preg_replace('/\b(brasil|brazil)\b/i', '', $limpo);
        $limpo = preg_replace('#\b([^\s/,\-]+)\s*/\s*([A-Za-z]{2})\b#u', '$1 - $2', $limpo); // Cidade/UF

        $partes = array_values(array_filter(
            array_map('trim', preg_split('/\s+-\s+|,|;/u', $limpo)),
            fn ($p) => $p !== ''
        ));

        if (!$partes) {
            return $r;
        }

        $indiceUf = null;
        foreach ($partes as $i => $parte) {
            if (preg_match('/^[A-Za-z]{2}$/', $parte) && isset(self::ESTADOS[strtoupper($parte)])) {
                $indiceUf = $i;
            }
        }

        if ($indiceUf !== null && $indiceUf > 0) {
            $r['estado'] = strtoupper($partes[$indiceUf]);
            $r['cidade'] = $partes[$indiceUf - 1];
            if ($indiceUf - 2 >= 2 && !preg_match('/^\d+/', $partes[$indiceUf - 2])) {
                $r['bairro'] = $partes[$indiceUf - 2];
            }
        }

        $r['rua'] = $partes[0];
        foreach (array_slice($partes, 1) as $parte) {
            if (preg_match('/^(\d+[\w\/\-]*|s\/?n)$/iu', $parte)) {
                $r['numero'] = $parte;
                break;
            }
        }

        // "Rua X 123" (número colado na rua, sem vírgula)
        if (empty($r['numero']) && preg_match('/^(.+?)\s+(\d+[A-Za-z]?)$/u', $r['rua'], $m)) {
            $r['rua'] = trim($m[1]);
            $r['numero'] = $m[2];
        }

        return $r;
    }

    // ------------------------------------------------------------------
    // Cadeia de busca
    // ------------------------------------------------------------------

    private function buscar(array $e): array
    {
        $cepInfo = $e['cep'] !== '' ? $this->consultarCep($e['cep']) : null;

        // O CEP preenche lacunas (rua/cidade/UF) e corrige cidade errada.
        if ($cepInfo) {
            foreach (['rua', 'bairro', 'cidade', 'estado'] as $campo) {
                if ($e[$campo] === '' && !empty($cepInfo[$campo])) {
                    $e[$campo] = $cepInfo[$campo];
                }
            }
        }

        $estadoNome = self::ESTADOS[$e['estado']] ?? $e['estado'];
        $temRua = $e['rua'] !== '' && $e['cidade'] !== '';

        if ($temRua) {
            $tentativas = [];

            if ($e['numero'] !== '') {
                $tentativas[] = ['street' => trim($e['numero'] . ' ' . $e['rua']), 'city' => $e['cidade'], 'state' => $estadoNome];
            }
            $tentativas[] = ['street' => $e['rua'], 'city' => $e['cidade'], 'state' => $estadoNome];
            $tentativas[] = ['q' => implode(', ', array_filter([$e['rua'], $e['numero'], $e['bairro'], $e['cidade'], $estadoNome, 'Brasil']))];
            $tentativas[] = ['q' => implode(', ', array_filter([$e['rua'], $e['cidade'], $e['estado'], 'Brasil']))];

            foreach ($tentativas as $params) {
                if ($r = $this->escolherNominatim($this->nominatim($params), $e, true)) {
                    return $r;
                }
            }

            $consultaPhoton = implode(', ', array_filter([$e['rua'], $e['numero'], $e['bairro'], $e['cidade'], $e['estado'], 'Brasil']));
            if ($r = $this->escolherPhoton($this->photon($consultaPhoton), $e)) {
                return $r;
            }
        }

        if ($cepInfo && isset($cepInfo['lat'], $cepInfo['lon'])) {
            return $this->montar($cepInfo['lat'], $cepInfo['lon'], 'cep');
        }

        if ($e['cep'] !== '') {
            if ($r = $this->escolherNominatim($this->nominatim(['postalcode' => $e['cep']]), $e, false, 'cep')) {
                return $r;
            }
        }

        // Última rede de segurança: centro do bairro/cidade (a rota nunca fica "sem destino").
        if ($e['cidade'] !== '') {
            $consultas = [];
            if ($e['bairro'] !== '') {
                $consultas[] = ['q' => implode(', ', array_filter([$e['bairro'], $e['cidade'], $estadoNome, 'Brasil']))];
            }
            $consultas[] = ['city' => $e['cidade'], 'state' => $estadoNome];
            $consultas[] = ['q' => implode(', ', array_filter([$e['cidade'], $e['estado'], 'Brasil']))];

            foreach ($consultas as $params) {
                if ($r = $this->escolherNominatim($this->nominatim($params), $e, false, 'cidade')) {
                    return $r;
                }
            }
        }

        throw new \RuntimeException('Não foi possível localizar o endereço informado.');
    }

    // ------------------------------------------------------------------
    // Provedores
    // ------------------------------------------------------------------

    private function nominatim(array $params): array
    {
        $this->respeitarIntervalo();

        try {
            $resposta = Http::withHeaders([
                'User-Agent' => config('services.geocoding.user_agent', 'GeoSync-TCC/1.0 (contato@exemplo.com)'),
                'Accept-Language' => 'pt-BR',
            ])->timeout(8)->retry(2, 500, throw: false)->get(
                config('services.geocoding.nominatim_url', 'https://nominatim.openstreetmap.org/search'),
                array_merge(['format' => 'jsonv2', 'addressdetails' => 1, 'limit' => 6, 'countrycodes' => 'br'], $params)
            );

            return $resposta->successful() ? ($resposta->json() ?? []) : [];
        } catch (\Throwable $ex) {
            Log::info('Nominatim indisponível', ['erro' => $ex->getMessage()]);
            return [];
        }
    }

    private function photon(string $consulta): array
    {
        if ($consulta === '') {
            return [];
        }

        try {
            $resposta = Http::withHeaders(['User-Agent' => config('services.geocoding.user_agent', 'GeoSync-TCC/1.0')])
                ->timeout(8)->retry(1, 300, throw: false)
                ->get(config('services.geocoding.photon_url', 'https://photon.komoot.io/api/'), ['q' => $consulta, 'limit' => 8]);

            return $resposta->successful() ? ($resposta->json('features') ?? []) : [];
        } catch (\Throwable $ex) {
            Log::info('Photon indisponível', ['erro' => $ex->getMessage()]);
            return [];
        }
    }

    private function consultarCep(string $cep): ?array
    {
        return Cache::remember("geocode:cep:$cep", now()->addDays(90), function () use ($cep) {
            try {
                $r = Http::timeout(6)->get("https://brasilapi.com.br/api/cep/v2/$cep");
                if ($r->successful() && $r->json('city')) {
                    $info = [
                        'rua' => (string) $r->json('street'),
                        'bairro' => (string) $r->json('neighborhood'),
                        'cidade' => (string) $r->json('city'),
                        'estado' => strtoupper((string) $r->json('state')),
                    ];
                    $lat = $r->json('location.coordinates.latitude');
                    $lon = $r->json('location.coordinates.longitude');
                    if (is_numeric($lat) && is_numeric($lon) && $this->dentroDoBrasil((float) $lat, (float) $lon)) {
                        $info['lat'] = (float) $lat;
                        $info['lon'] = (float) $lon;
                    }
                    return $info;
                }
            } catch (\Throwable $ex) {
                // tenta o ViaCEP
            }

            try {
                $r = Http::timeout(6)->get("https://viacep.com.br/ws/$cep/json/");
                if ($r->successful() && !$r->json('erro') && $r->json('localidade')) {
                    return [
                        'rua' => (string) $r->json('logradouro'),
                        'bairro' => (string) $r->json('bairro'),
                        'cidade' => (string) $r->json('localidade'),
                        'estado' => strtoupper((string) $r->json('uf')),
                    ];
                }
            } catch (\Throwable $ex) {
                // sem CEP: segue a cadeia normal
            }

            return null;
        });
    }

    /** Nominatim pede no máximo 1 requisição por segundo. */
    private function respeitarIntervalo(): void
    {
        $ultimo = Cache::get('geocode:ultimo_nominatim');
        if ($ultimo) {
            $espera = 1.1 - (microtime(true) - $ultimo);
            if ($espera > 0) {
                usleep((int) ($espera * 1_000_000));
            }
        }
        Cache::put('geocode:ultimo_nominatim', microtime(true), 10);
    }

    // ------------------------------------------------------------------
    // Escolha do melhor resultado
    // ------------------------------------------------------------------

    private function escolherNominatim(array $resultados, array $e, bool $exigeRua, ?string $precisaoFixa = null): ?array
    {
        $melhor = null;
        $melhorNota = -1;

        foreach ($resultados as $item) {
            $lat = (float) ($item['lat'] ?? 0);
            $lon = (float) ($item['lon'] ?? 0);
            if (!$this->dentroDoBrasil($lat, $lon)) {
                continue;
            }

            $end = $item['address'] ?? [];

            // Estado precisa bater (evita "Rua das Flores" de outro estado).
            $iso = $end['ISO3166-2-lvl4'] ?? null;
            if ($e['estado'] !== '' && $iso && strtoupper($iso) !== 'BR-' . $e['estado']) {
                continue;
            }

            if (!$this->cidadeConfere($e['cidade'], [
                $end['city'] ?? '', $end['town'] ?? '', $end['village'] ?? '', $end['municipality'] ?? '',
                $end['city_district'] ?? '', $end['county'] ?? '', $end['suburb'] ?? '',
            ])) {
                continue;
            }

            $rua = $end['road'] ?? $end['pedestrian'] ?? $end['residential'] ?? $end['footway'] ?? $end['path'] ?? '';
            $nota = $this->similaridade($e['rua'], $rua);
            $temNumero = $e['numero'] !== '' && isset($end['house_number'])
                && $this->normalizar($end['house_number']) === $this->normalizar($e['numero']);

            if ($exigeRua && $nota < 0.5) {
                continue;
            }

            $nota += $temNumero ? 1 : 0;
            if ($nota > $melhorNota) {
                $melhorNota = $nota;
                $melhor = [$lat, $lon, $precisaoFixa ?? ($temNumero ? 'exato' : 'rua')];
            }
        }

        return $melhor ? $this->montar(...$melhor) : null;
    }

    private function escolherPhoton(array $features, array $e): ?array
    {
        $melhor = null;
        $melhorNota = -1;

        foreach ($features as $f) {
            $p = $f['properties'] ?? [];
            [$lon, $lat] = array_map('floatval', $f['geometry']['coordinates'] ?? [0, 0]);

            if (!$this->dentroDoBrasil($lat, $lon) || strtoupper($p['countrycode'] ?? 'BR') !== 'BR') {
                continue;
            }

            $estadoEsperado = self::ESTADOS[$e['estado']] ?? null;
            if ($estadoEsperado && !empty($p['state']) && $this->normalizar($p['state']) !== $this->normalizar($estadoEsperado)) {
                continue;
            }

            if (!$this->cidadeConfere($e['cidade'], [$p['city'] ?? '', $p['county'] ?? '', $p['district'] ?? ''])) {
                continue;
            }

            $nota = $this->similaridade($e['rua'], $p['street'] ?? $p['name'] ?? '');
            if ($nota < 0.5) {
                continue;
            }

            $temNumero = $e['numero'] !== '' && isset($p['housenumber'])
                && $this->normalizar((string) $p['housenumber']) === $this->normalizar($e['numero']);
            $nota += $temNumero ? 1 : 0;

            if ($nota > $melhorNota) {
                $melhorNota = $nota;
                $melhor = [$lat, $lon, $temNumero ? 'exato' : 'rua'];
            }
        }

        return $melhor ? $this->montar(...$melhor) : null;
    }

    private function cidadeConfere(string $esperada, array $candidatas): bool
    {
        $candidatas = array_filter($candidatas);
        if ($esperada === '' || !$candidatas) {
            return true; // sem dado para comparar: não descarta
        }
        foreach ($candidatas as $c) {
            if ($this->similaridade($esperada, $c, false) >= 0.5) {
                return true;
            }
        }
        return false;
    }

    // ------------------------------------------------------------------
    // Utilidades
    // ------------------------------------------------------------------

    private function montar(float $lat, float $lon, string $precisao): array
    {
        return [
            'latitude_destino' => round($lat, 7),
            'longitude_destino' => round($lon, 7),
            'destino_precisao' => $precisao,
        ];
    }

    private function dentroDoBrasil(float $lat, float $lon): bool
    {
        return $lat >= -35 && $lat <= 6 && $lon >= -75 && $lon <= -30;
    }

    private function normalizar(string $valor): string
    {
        return trim(preg_replace('/[^a-z0-9 ]/', '', strtolower(Str::ascii($valor))));
    }

    /** Palavras relevantes (sem acento, abreviações expandidas, sem "rua/de/da..."). */
    private function tokens(string $valor, bool $removerTipo = true): array
    {
        $palavras = array_filter(explode(' ', $this->normalizar($valor)));
        $saida = [];
        foreach ($palavras as $p) {
            $p = self::ABREVIACOES[$p] ?? $p;
            if (in_array($p, ['de', 'da', 'do', 'dos', 'das', 'e'], true)) {
                continue;
            }
            if ($removerTipo && in_array($p, self::IGNORAR, true)) {
                continue;
            }
            $saida[] = $p;
        }
        return $saida;
    }

    /** Fração das palavras esperadas encontradas no texto retornado (0 a 1). */
    private function similaridade(string $esperado, string $retornado, bool $removerTipo = true): float
    {
        $a = $this->tokens($esperado, $removerTipo);
        $b = $this->tokens($retornado, $removerTipo);

        if (!$a || !$b) {
            return 0.0;
        }

        $achadas = 0;
        foreach ($a as $palavra) {
            if (in_array($palavra, $b, true)) {
                $achadas++;
            }
        }

        return $achadas / count($a);
    }
}
