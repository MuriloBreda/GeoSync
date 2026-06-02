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
        return view('alertas', compact('alertas'));
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
            'remessa_id' => 'required|exists:remessas,id',
            'tipo'       => 'required|max:100',
            'mensagem'   => 'required'
        ]);

        Alerta::create([
            'remessa_id' => $request->remessa_id,
            'tipo'       => $request->tipo,
            'mensagem'   => $request->mensagem,
        ]);

        return back()->with('success', 'Alerta enviado com sucesso!');
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
        // Corrigido para validar os campos corretos da tabela
        $request->validate([
            'tipo'     => 'required|max:100',
            'mensagem' => 'required'
        ]);

        $alerta = Alerta::findOrFail($id);
        $alerta->update([
            'tipo'     => $request->tipo,
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->route('alertas.index')->with('success', 'Alerta atualizado!');
    }

    // ❌ EXCLUIR
    public function destroy($id)
    {
        $alerta = Alerta::findOrFail($id);
        $alerta->delete();
        return redirect()->back()->with('success', 'Alerta removido!');
    }
}