<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remessa;
use App\Models\Alerta;

class RemessaController extends Controller
{
    // 📊 DASHBOARD
    public function dashboard()
    {
        $userId = auth()->id();

        $remessas = Remessa::where('user_id', $userId)->get();

        $total = $remessas->count();
        $transito = $remessas->where('status', 'Em transporte')->count();
        $entregues = $remessas->where('status', 'Entregue')->count();
        $atrasadas = $remessas->where('status', 'Atrasado')->count();

        $remessa = Remessa::with('localizacoes')
            ->where('user_id', $userId)
            ->first();

        $alertas = Alerta::latest()->take(5)->get();

        return view('service', compact(
            'total',
            'transito',
            'entregues',
            'atrasadas',
            'remessa',
            'alertas',
            'remessas'
        ));
    }

    // 🔥 INDEX CORRIGIDO
    public function index()
    {
        return $this->dashboard();
    }

    public function create()
    {
        return view('cadastroMercadoria');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_rastreio' => 'required|max:100',
            'origem' => 'required|max:100',
            'destino' => 'required|max:100',
            'tipo_carga' => 'required|max:100',
            'peso' => 'required|numeric',
            'previsao_entrega' => 'required|date',
            'status' => 'required|max:50'
        ]);

        Remessa::create([
            'codigo_rastreio' => $request->codigo_rastreio,
            'origem' => $request->origem,
            'destino' => $request->destino,
            'tipo_carga' => $request->tipo_carga,
            'peso' => $request->peso,
            'previsao_entrega' => $request->previsao_entrega,
            'status' => $request->status,
            'user_id' => auth()->id()
        ]);

        return redirect('/service')->with('success', 'Remessa cadastrada!');
    }

    public function show($id)
    {
        $remessa = Remessa::with(['localizacoes', 'alertas'])->findOrFail($id);
        return view('remessaShow', compact('remessa'));
    }

    public function edit($id)
    {
        $remessa = Remessa::findOrFail($id);
        return view('remessas.edit', compact('remessa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo_rastreio' => 'required|max:100',
            'origem' => 'required|max:100',
            'destino' => 'required|max:100',
            'tipo_carga' => 'required|max:100',
            'peso' => 'required|numeric',
            'previsao_entrega' => 'required|date',
            'status' => 'required|max:50'
        ]);

        $remessa = Remessa::findOrFail($id);
        $remessa->update($request->all());

        return redirect('/service')->with('success', 'Remessa atualizada!');
    }

    public function destroy($id)
    {
        $remessa = Remessa::findOrFail($id);
        $remessa->delete();

        return redirect('/service')->with('success', 'Remessa removida!');
    }
}