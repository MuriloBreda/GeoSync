<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use App\Models\Remessa;
use Illuminate\Http\Request;

class LocalizacaoController extends Controller
{
    // 📋 LISTAR
    public function index()
    {
        $localizacoes = Localizacao::with('remessa')->latest()->get();
        return view('localizacoes.index', compact('localizacoes'));
    }

    // ➕ FORM
    public function create()
    {
        $remessas = Remessa::all();
        return view('localizacoes.create', compact('remessas'));
    }

    // 💾 SALVAR
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'remessa_id' => 'required|exists:remessas,id'
        ]);

        Localizacao::create($request->all());

        return redirect()->back()->with('success', 'Localização adicionada!');
    }

    // 🔍 MOSTRAR
    public function show($id)
    {
        $localizacao = Localizacao::with('remessa')->findOrFail($id);
        return view('localizacoes.show', compact('localizacao'));
    }

    // ✏️ EDITAR
    public function edit($id)
    {
        $localizacao = Localizacao::findOrFail($id);
        $remessas = Remessa::all();

        return view('localizacoes.edit', compact('localizacao', 'remessas'));
    }

    // 🔄 ATUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $localizacao = Localizacao::findOrFail($id);
        $localizacao->update($request->all());

        return redirect()->route('localizacoes.index')
            ->with('success', 'Localização atualizada!');
    }

    // ❌ EXCLUIR
    public function destroy($id)
    {
        $localizacao = Localizacao::findOrFail($id);
        $localizacao->delete();

        return redirect()->back()->with('success', 'Localização removida!');
    }
}