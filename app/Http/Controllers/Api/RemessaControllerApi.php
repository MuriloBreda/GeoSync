<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Remessa;
use Illuminate\Http\Request;

class RemessaControllerApi extends Controller
{
    public function index(Request $request)
    {
        $query = Remessa::with(['cliente:id,name,email', 'motorista:id,name,email']);
        if ($request->filled('status')) $query->where('status', $request->string('status'));
        return response()->json(['success' => true, 'data' => $query->latest()->paginate(20)]);
    }

    public function minhas(Request $request)
    {
        $user = $request->user();
        $field = $user->tipo === 'motorista' ? 'motorista_id' : 'cliente_id';
        return response()->json(['success' => true, 'data' => Remessa::where($field, $user->id)->latest()->paginate(20)]);
    }

    public function disponiveis(Request $request)
    {
        $this->only($request, 'motorista');
        return response()->json(['success' => true, 'data' => Remessa::whereNull('motorista_id')->where('status', 'Pendente')->latest()->paginate(20)]);
    }

    public function store(Request $request)
    {
        $this->only($request, 'admin', 'cliente');
        $data = $this->validated($request);
        if ($request->user()->tipo === 'cliente') $data['cliente_id'] = $request->user()->id;
        $remessa = Remessa::create($data);
        return response()->json(['success' => true, 'message' => 'Remessa criada.', 'data' => $remessa], 201);
    }

    public function show(Request $request, Remessa $remessa)
    {
        $this->canAccess($request, $remessa);
        return response()->json(['success' => true, 'data' => $remessa->load(['cliente:id,name,email', 'motorista:id,name,email', 'localizacoes'])]);
    }

    public function update(Request $request, Remessa $remessa)
    {
        $this->canManage($request, $remessa);
        $remessa->update($this->validated($request, true));
        return response()->json(['success' => true, 'message' => 'Remessa atualizada.', 'data' => $remessa->fresh()]);
    }

    public function destroy(Request $request, Remessa $remessa)
    {
        $this->only($request, 'admin');
        $remessa->delete();
        return response()->json(['success' => true, 'message' => 'Remessa excluída.']);
    }

    public function aceitar(Request $request, Remessa $remessa)
    {
        $this->only($request, 'motorista');
        if ($remessa->motorista_id || $remessa->status !== 'Pendente') return response()->json(['success' => false, 'message' => 'Remessa não está disponível.'], 422);
        $remessa->update(['motorista_id' => $request->user()->id, 'status' => 'Em Rota']);
        return response()->json(['success' => true, 'message' => 'Remessa aceita.', 'data' => $remessa->fresh()]);
    }

    public function atualizarStatus(Request $request, Remessa $remessa)
    {
        $this->only($request, 'motorista', 'admin');
        if ($request->user()->tipo === 'motorista' && $remessa->motorista_id !== $request->user()->id) abort(403);
        $data = $request->validate(['status' => 'required|string|max:50']);
        $remessa->update($data);
        return response()->json(['success' => true, 'message' => 'Status atualizado.', 'data' => $remessa->fresh()]);
    }

    private function validated(Request $request, bool $partial = false): array
    {
        $prefix = $partial ? 'sometimes|' : 'required|';
        return $request->validate([
            'codigo_rastreio' => $prefix . 'string|max:100' . ($partial ? '' : '|unique:remessas,codigo_rastreio'),
            'origem' => $prefix . 'string|max:100', 'destino' => $prefix . 'string|max:100',
            'tipo_carga' => 'nullable|string|max:100', 'peso' => 'nullable|numeric', 'previsao_entrega' => 'nullable|date',
            'status' => $partial ? 'sometimes|string|max:50' : 'required|string|max:50',
            'cliente_id' => 'nullable|exists:users,id', 'motorista_id' => 'nullable|exists:users,id',
        ]);
    }

    private function only(Request $request, string ...$types): void { abort_unless(in_array($request->user()->tipo, $types, true), 403); }
    private function canAccess(Request $request, Remessa $r): void { if ($request->user()->tipo !== 'admin' && $r->cliente_id !== $request->user()->id && $r->motorista_id !== $request->user()->id) abort(403); }
    private function canManage(Request $request, Remessa $r): void { $this->canAccess($request, $r); $this->only($request, 'admin', 'cliente'); }
}
