<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Localizacao;
use App\Models\Remessa;
use App\Services\GeocodificadorDestino;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

/**
 * Formato padrão das respostas (facilita o parse no Flutter):
 *  listas  -> { success, data: [...], meta: { current_page, last_page, per_page, total } }
 *  objetos -> { success, data: {...} }
 *  erros   -> { success:false, message }
 */
class RemessaControllerApi extends Controller
{
    private const RELACOES = ['cliente:id,name,email', 'motorista:id,name,email'];

    /** Status que o motorista pode aplicar na própria viagem. */
    private const STATUS_MOTORISTA = ['Em Rota', 'Atrasado', 'Entregue'];

    // ------------------------------------------------------------------
    // Listagens
    // ------------------------------------------------------------------

    /** Admin vê tudo; cliente/motorista recebem apenas as suas remessas. */
    public function index(Request $request): JsonResponse
    {
        if ($request->user()->tipo !== 'admin') {
            return $this->minhas($request);
        }

        $query = Remessa::with(self::RELACOES);

        if ($request->filled('status')) {
            $query->where('status', (string) $request->input('status'));
        }

        return $this->lista($query->latest('id')->paginate($this->porPagina($request)));
    }

    public function minhas(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = Remessa::with(self::RELACOES)->latest('id');

        if ($user->tipo === 'motorista') {
            $query->where('motorista_id', $user->id);
        } elseif ($user->tipo === 'cliente') {
            $query->where('cliente_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', (string) $request->input('status'));
        }

        return $this->lista($query->paginate($this->porPagina($request)));
    }

    public function disponiveis(Request $request): JsonResponse
    {
        $this->somente($request, 'motorista');

        return $this->lista(
            Remessa::with('cliente:id,name')
                ->whereNull('motorista_id')
                ->where('status', Remessa::STATUS_PENDENTE)
                ->latest('id')
                ->paginate($this->porPagina($request))
        );
    }

    // ------------------------------------------------------------------
    // CRUD
    // ------------------------------------------------------------------

    public function store(Request $request): JsonResponse
    {
        $this->somente($request, 'admin', 'cliente');

        $data = $this->validar($request);

        if ($request->user()->tipo === 'cliente') {
            $data['cliente_id'] = $request->user()->id;
            unset($data['motorista_id']);
            $data['status'] = Remessa::STATUS_PENDENTE;
        } else {
            $data['status'] = $data['status'] ?? Remessa::STATUS_PENDENTE;
        }

        $remessa = Remessa::create($data);
        $this->garantirCoordenadas($remessa);

        return response()->json([
            'success' => true,
            'message' => 'Remessa criada.',
            'data' => $remessa->fresh(self::RELACOES),
        ], 201);
    }

    public function show(Request $request, Remessa $remessa): JsonResponse
    {
        $this->podeVer($request, $remessa, true);

        return response()->json([
            'success' => true,
            'data' => $remessa->load([...self::RELACOES]),
        ]);
    }

    public function update(Request $request, Remessa $remessa): JsonResponse
    {
        $this->podeGerenciar($request, $remessa);

        $data = $this->validar($request, $remessa);

        // Cliente não reatribui motorista nem altera status por aqui.
        if ($request->user()->tipo === 'cliente') {
            unset($data['motorista_id'], $data['cliente_id'], $data['status']);
        }

        $enderecoAntes = $remessa->enderecoParaGeocodificar();
        $remessa->fill($data);

        $enderecoMudou = $remessa->enderecoParaGeocodificar() !== $enderecoAntes;
        $coordenadaInformada = $request->filled('latitude_destino') && $request->filled('longitude_destino');

        if ($enderecoMudou && !$coordenadaInformada) {
            // Não deixa coordenadas antigas apontando para o endereço anterior.
            $remessa->latitude_destino = null;
            $remessa->longitude_destino = null;
            $remessa->destino_precisao = null;
            $remessa->proximidade_notificada_at = null;
        }

        $remessa->save();
        $this->garantirCoordenadas($remessa);

        return response()->json([
            'success' => true,
            'message' => 'Remessa atualizada.',
            'data' => $remessa->fresh(self::RELACOES),
        ]);
    }

    public function destroy(Request $request, Remessa $remessa): JsonResponse
    {
        $this->somente($request, 'admin');
        $remessa->delete();

        return response()->json(['success' => true, 'message' => 'Remessa excluída.']);
    }

    // ------------------------------------------------------------------
    // Ações do motorista
    // ------------------------------------------------------------------

    public function aceitar(Request $request, Remessa $remessa): JsonResponse
    {
        $this->somente($request, 'motorista');

        // UPDATE condicional: dois motoristas não conseguem aceitar a mesma carga.
        $atualizadas = Remessa::whereKey($remessa->id)
            ->whereNull('motorista_id')
            ->where('status', Remessa::STATUS_PENDENTE)
            ->update(['motorista_id' => $request->user()->id, 'status' => Remessa::STATUS_EM_ROTA]);

        if (!$atualizadas) {
            return response()->json(['success' => false, 'message' => 'Remessa não está disponível.'], 422);
        }

        $remessa = $remessa->fresh(self::RELACOES);
        $this->garantirCoordenadas($remessa);

        return response()->json(['success' => true, 'message' => 'Remessa aceita.', 'data' => $remessa->fresh(self::RELACOES)]);
    }

    public function atualizarStatus(Request $request, Remessa $remessa): JsonResponse
    {
        $this->somente($request, 'motorista', 'admin');

        $user = $request->user();

        if ($user->tipo === 'motorista' && $remessa->motorista_id !== $user->id) {
            abort(403, 'Esta remessa não é sua.');
        }

        $regra = $user->tipo === 'motorista'
            ? ['required', 'string', Rule::in(self::STATUS_MOTORISTA)]
            : ['required', 'string', 'max:50'];

        $data = $request->validate(['status' => $regra]);

        if ($remessa->status === Remessa::STATUS_ENTREGUE) {
            return response()->json(['success' => false, 'message' => 'Esta carga já foi entregue.'], 422);
        }

        $remessa->update($data);

        return response()->json(['success' => true, 'message' => 'Status atualizado.', 'data' => $remessa->fresh(self::RELACOES)]);
    }

    // ------------------------------------------------------------------
    // Rastreamento (Flutter)
    // ------------------------------------------------------------------

    /**
     * Uma chamada só devolve: remessa + destino (com coordenadas) + última posição + distância.
     * O Flutter chama este endpoint a cada ~5 s para atualizar o mapa.
     */
    public function rastreamento(Request $request, Remessa $remessa): JsonResponse
    {
        $this->podeVer($request, $remessa);

        $this->garantirCoordenadas($remessa);

        $ultima = Localizacao::where('remessa_id', $remessa->id)
            ->orderByDesc('created_at')->orderByDesc('id')->first();

        $distancia = null;
        if ($ultima && $remessa->temCoordenadasDestino()) {
            $distancia = round(GeocodificadorDestino::distanciaEmMetros(
                (float) $ultima->latitude, (float) $ultima->longitude,
                (float) $remessa->latitude_destino, (float) $remessa->longitude_destino
            ), 1);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'remessa' => [
                    'id' => $remessa->id,
                    'codigo_rastreio' => $remessa->codigo_rastreio,
                    'origem' => $remessa->origem,
                    'destino' => $remessa->destino,
                    'status' => $remessa->status,
                ],
                'destino' => [
                    'disponivel' => $remessa->temCoordenadasDestino(),
                    'latitude' => $remessa->latitude_destino,
                    'longitude' => $remessa->longitude_destino,
                    'precisao' => $remessa->destino_precisao,
                ],
                'ultima_localizacao' => $ultima,
                'distancia_metros' => $distancia,
            ],
        ]);
    }

    public function localizacoes(Request $request, Remessa $remessa): JsonResponse
    {
        $this->podeVer($request, $remessa);

        $limite = min(max((int) $request->input('limit', 200), 1), 1000);

        return response()->json([
            'success' => true,
            'data' => Localizacao::where('remessa_id', $remessa->id)
                ->orderByDesc('created_at')->orderByDesc('id')->limit($limite)->get(),
        ]);
    }

    /** App do motorista enviando a posição do celular (alternativa ao ESP32). */
    public function enviarLocalizacao(Request $request, Remessa $remessa): JsonResponse
    {
        $this->somente($request, 'motorista');

        if ($remessa->motorista_id !== $request->user()->id) {
            abort(403, 'Esta remessa não é sua.');
        }

        $data = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $localizacao = Localizacao::create($data + ['remessa_id' => $remessa->id, 'fonte' => 'app']);

        return response()->json(['success' => true, 'data' => $localizacao], 201);
    }

    /** Força (re)geocodificação do destino; útil quando o endereço foi corrigido. */
    public function geocodificar(Request $request, Remessa $remessa): JsonResponse
    {
        $this->podeGerenciar($request, $remessa);

        try {
            $coords = app(GeocodificadorDestino::class)->localizar($remessa->enderecoParaGeocodificar());
            $remessa->update($coords);
            $remessa->update(['proximidade_notificada_at' => null]);
        } catch (\RuntimeException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        return response()->json(['success' => true, 'data' => $remessa->fresh(self::RELACOES)]);
    }

    // ------------------------------------------------------------------
    // Internos
    // ------------------------------------------------------------------

    private function validar(Request $request, ?Remessa $remessa = null): array
    {
        $parcial = $remessa !== null;
        $obrigatorio = $parcial ? 'sometimes|required' : 'required';

        return $request->validate([
            'codigo_rastreio' => [$obrigatorio, 'string', 'max:100', Rule::unique('remessas', 'codigo_rastreio')->ignore($remessa?->id)],
            'origem' => [$obrigatorio, 'string', 'max:100'],
            'destino' => [$obrigatorio, 'string', 'max:255'],
            'destino_cep' => 'nullable|string|max:9',
            'destino_rua' => 'nullable|string|max:150',
            'destino_numero' => 'nullable|string|max:20',
            'destino_complemento' => 'nullable|string|max:150',
            'destino_bairro' => 'nullable|string|max:100',
            'destino_cidade' => 'nullable|string|max:100',
            'destino_estado' => 'nullable|string|size:2',
            'latitude_destino' => 'nullable|numeric|between:-35,6|required_with:longitude_destino',
            'longitude_destino' => 'nullable|numeric|between:-75,-30|required_with:latitude_destino',
            'tipo_carga' => 'nullable|string|max:100',
            'peso' => 'nullable|numeric|min:0',
            'previsao_entrega' => 'nullable|date',
            'status' => ['sometimes', 'string', 'max:50'],
            'cliente_id' => 'nullable|exists:users,id',
            'motorista_id' => 'nullable|exists:users,id',
        ]);
    }

    /** Geocodifica no servidor quando a remessa ainda não tem coordenadas. Nunca derruba a requisição. */
    private function garantirCoordenadas(Remessa $remessa): void
    {
        if ($remessa->temCoordenadasDestino() || $remessa->status === Remessa::STATUS_ENTREGUE) {
            return;
        }

        try {
            $remessa->update(app(GeocodificadorDestino::class)->localizar($remessa->enderecoParaGeocodificar()));
        } catch (\Throwable $e) {
            // Serviço de mapas fora do ar: a remessa continua válida e será localizada depois.
        }
    }

    private function lista(LengthAwarePaginator $p): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $p->items(),
            'meta' => [
                'current_page' => $p->currentPage(),
                'last_page' => $p->lastPage(),
                'per_page' => $p->perPage(),
                'total' => $p->total(),
            ],
        ]);
    }

    private function porPagina(Request $request): int
    {
        return min(max((int) $request->input('per_page', 20), 1), 100);
    }

    private function somente(Request $request, string ...$tipos): void
    {
        abort_unless(in_array($request->user()->tipo, $tipos, true), 403, 'Sem permissão para esta ação.');
    }

    /** Motorista também enxerga cargas disponíveis (para decidir se aceita). */
    private function podeVer(Request $request, Remessa $remessa, bool $permitirDisponivel = false): void
    {
        $user = $request->user();

        $ehDono = $user->tipo === 'admin'
            || $remessa->cliente_id === $user->id
            || $remessa->motorista_id === $user->id;

        $disponivel = $permitirDisponivel && $user->tipo === 'motorista'
            && $remessa->motorista_id === null && $remessa->status === Remessa::STATUS_PENDENTE;

        abort_unless($ehDono || $disponivel, 403, 'Sem acesso a esta remessa.');
    }

    private function podeGerenciar(Request $request, Remessa $remessa): void
    {
        $this->podeVer($request, $remessa);
        $this->somente($request, 'admin', 'cliente');
    }
}
