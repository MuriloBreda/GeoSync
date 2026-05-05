<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Remessa;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    // 📋 LISTAR
    public function index()
    {
        $alertas = Alerta::with('remessa')->latest()->get();
        return view('alertas.index', compact('alertas'));
    }

    // ➕ FORM
    public function create()
    {
        $remessas = Remessa::all();
        return view('alertas.create', compact('remessas'));
    }

    // 💾 SALVAR
    public function store(Request $request)
    {
        $request->validate([
            'tipo_alerta' => 'required|max:100',
            'descricao' => 'required|max:255',
            'remessa_id' => 'required|exists:remessas,id'
        ]);

        Alerta::create($request->all());

        return redirect()->back()->with('success', 'Alerta criado!');
    }

    // 🔍 MOSTRAR
    public function show($id)
    {
        $alerta = Alerta::with('remessa')->findOrFail($id);
        return view('alertas.show', compact('alerta'));
    }

    // ✏️ EDITAR
    public function edit($id)
    {
        $alerta = Alerta::findOrFail($id);
        $remessas = Remessa::all();

        return view('alertas.edit', compact('alerta', 'remessas'));
    }

    // 🔄 ATUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_alerta' => 'required|max:100',
            'descricao' => 'required|max:255'
        ]);

        $alerta = Alerta::findOrFail($id);
        $alerta->update($request->all());

        return redirect()->route('alertas.index')
            ->with('success', 'Alerta atualizado!');
    }

    // ❌ EXCLUIR
    public function destroy($id)
    {
        $alerta = Alerta::findOrFail($id);
        $alerta->delete();

        return redirect()->back()->with('success', 'Alerta removido!');
    }
}