<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Localizacao;
use Illuminate\Http\Request;

class LocalizacaoControllerApi extends Controller
{
    // ==========================================
    // LISTAR TODAS AS LOCALIZAÇÕES
    // ==========================================

    public function index()
    {
        $localizacoes = Localizacao::all();

        return response()->json([
            'success' => true,
            'message' => 'Localizações encontradas com sucesso.',
            'data' => $localizacoes
        ], 200);
    }


    // ==========================================
    // CADASTRAR LOCALIZAÇÃO
    // ==========================================

    public function store(Request $request)
    {
        $dados = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'remessa_id' => 'required|integer|exists:remessas,id'
        ]);

        $localizacao = Localizacao::create($dados);

        return response()->json([
            'success' => true,
            'message' => 'Localização cadastrada com sucesso.',
            'data' => $localizacao
        ], 201);
    }


    // ==========================================
    // BUSCAR LOCALIZAÇÃO PELO ID
    // ==========================================

    public function show($id)
    {
        $localizacao = Localizacao::find($id);

        if (!$localizacao) {
            return response()->json([
                'success' => false,
                'message' => 'Localização não encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Localização encontrada com sucesso.',
            'data' => $localizacao
        ], 200);
    }


    // ==========================================
    // ATUALIZAR LOCALIZAÇÃO
    // ==========================================

    public function update(Request $request, $id)
    {
        $localizacao = Localizacao::find($id);

        if (!$localizacao) {
            return response()->json([
                'success' => false,
                'message' => 'Localização não encontrada.'
            ], 404);
        }

        $dados = $request->validate([
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
            'remessa_id' => 'sometimes|integer|exists:remessas,id'
        ]);

        $localizacao->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Localização atualizada com sucesso.',
            'data' => $localizacao
        ], 200);
    }


    // ==========================================
    // EXCLUIR LOCALIZAÇÃO
    // ==========================================

    public function destroy($id)
    {
        $localizacao = Localizacao::find($id);

        if (!$localizacao) {
            return response()->json([
                'success' => false,
                'message' => 'Localização não encontrada.'
            ], 404);
        }

        $localizacao->delete();

        return response()->json([
            'success' => true,
            'message' => 'Localização excluída com sucesso.'
        ], 200);
    }


    // ==========================================
    // HISTÓRICO DE UMA REMESSA
    // ==========================================

    public function porRemessa($remessa_id)
    {
        $localizacoes = Localizacao::where(
            'remessa_id',
            $remessa_id
        )
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Histórico de localização da remessa.',
            'data' => $localizacoes
        ], 200);
    }


    // ==========================================
    // ÚLTIMA LOCALIZAÇÃO DE UMA REMESSA
    // ==========================================

    public function ultimaPorRemessa($remessa_id)
    {
        $localizacao = Localizacao::where(
            'remessa_id',
            $remessa_id
        )
        ->orderBy('created_at', 'desc')
        ->first();

        if (!$localizacao) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma localização encontrada para esta remessa.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Última localização encontrada.',
            'data' => $localizacao
        ], 200);
    }
}