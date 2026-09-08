<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alerta;
use App\Models\Remessa;
use Illuminate\Http\Request;

class AlertaControllerApi extends Controller
{
    public function index(Request $request)
    {
        $query = Alerta::with('remessa:id,codigo_rastreio,cliente_id,motorista_id')->latest();
        if ($request->user()->tipo !== 'admin') {
            $query->whereHas('remessa', fn ($q) => $q->where('cliente_id', $request->user()->id)->orWhere('motorista_id', $request->user()->id));
        }
        return response()->json(['success' => true, 'data' => $query->paginate(20)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['remessa_id' => 'required|exists:remessas,id', 'tipo' => 'required|string|max:100', 'mensagem' => 'required|string']);
        $remessa = Remessa::findOrFail($data['remessa_id']);
        $this->canManage($request, $remessa);
        if ($remessa->status === 'Entregue') return response()->json(['success' => false, 'message' => 'Não é permitido alertar uma remessa entregue.'], 422);
        return response()->json(['success' => true, 'message' => 'Alerta criado.', 'data' => Alerta::create($data)], 201);
    }

    public function show(Request $request, Alerta $alerta)
    {
        $this->canAccess($request, $alerta->remessa);
        return response()->json(['success' => true, 'data' => $alerta->load('remessa')]);
    }

    public function update(Request $request, Alerta $alerta)
    {
        $this->canManage($request, $alerta->remessa);
        $alerta->update($request->validate(['tipo' => 'sometimes|string|max:100', 'mensagem' => 'sometimes|string']));
        return response()->json(['success' => true, 'message' => 'Alerta atualizado.', 'data' => $alerta->fresh()]);
    }

    public function destroy(Request $request, Alerta $alerta)
    {
        $this->canManage($request, $alerta->remessa);
        $alerta->delete();
        return response()->json(['success' => true, 'message' => 'Alerta excluído.']);
    }

    private function canAccess(Request $request, Remessa $r): void { abort_unless($request->user()->tipo === 'admin' || $r->cliente_id === $request->user()->id || $r->motorista_id === $request->user()->id, 403); }
    private function canManage(Request $request, Remessa $r): void { $this->canAccess($request, $r); abort_unless(in_array($request->user()->tipo, ['admin', 'motorista'], true), 403); }
}
