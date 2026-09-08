<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlertaControllerApi;
use App\Http\Controllers\Api\AuthControllerApi;
use App\Http\Controllers\Api\AvaliacaoControllerApi;
use App\Http\Controllers\Api\ContatoControllerApi;
use App\Http\Controllers\Api\PagamentoControllerApi;
use App\Http\Controllers\Api\RemessaControllerApi;
use App\Http\Controllers\Api\LocalizacaoControllerApi;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthControllerApi::class, 'register']);
    Route::post('login', [AuthControllerApi::class, 'login']);
});
Route::post('contatos', [ContatoControllerApi::class, 'store']);
Route::get('avaliacoes', [AvaliacaoControllerApi::class, 'index']);
Route::get('avaliacoes/resumo', [AvaliacaoControllerApi::class, 'resumo']);

// Envie Authorization: Bearer {token} nos endpoints abaixo.
Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/me', [AuthControllerApi::class, 'me']);
    Route::post('auth/logout', [AuthControllerApi::class, 'logout']);
    Route::put('perfil', [AuthControllerApi::class, 'updateProfile']);

    Route::get('remessas/minhas', [RemessaControllerApi::class, 'minhas']);
    Route::get('remessas/disponiveis', [RemessaControllerApi::class, 'disponiveis']);
    Route::post('remessas/{remessa}/aceitar', [RemessaControllerApi::class, 'aceitar']);
    Route::patch('remessas/{remessa}/status', [RemessaControllerApi::class, 'atualizarStatus']);
    // Os recursos web usam os nomes "remessas.*" e "alertas.*".
    // Prefixar os nomes da API evita que route('remessas.store') no painel
    // administrativo seja resolvido como /api/remessas (rota Sanctum).
    Route::apiResource('remessas', RemessaControllerApi::class)->names('api.remessas');
    Route::apiResource('alertas', AlertaControllerApi::class)->names('api.alertas');

    Route::get('pagamentos', [PagamentoControllerApi::class, 'index']);
    Route::post('pagamentos', [PagamentoControllerApi::class, 'store']);
    Route::get('pagamentos/{pagamento}', [PagamentoControllerApi::class, 'show']);
    Route::post('avaliacoes', [AvaliacaoControllerApi::class, 'store']);
});


// LISTAR TODAS
Route::get('/localizacao', [
    LocalizacaoControllerApi::class,
    'index'
]);


// CADASTRAR
Route::post('/localizacao', [
    LocalizacaoControllerApi::class,
    'store'
]);


// HISTÓRICO DA REMESSA
Route::get('/localizacao/remessa/{remessa_id}', [
    LocalizacaoControllerApi::class,
    'porRemessa'
]);


// ÚLTIMA LOCALIZAÇÃO
Route::get('/localizacao/remessa/{remessa_id}/ultima', [
    LocalizacaoControllerApi::class,
    'ultimaPorRemessa'
]);


// BUSCAR POR ID
Route::get('/localizacao/{id}', [
    LocalizacaoControllerApi::class,
    'show'
]);


// ATUALIZAR
Route::put('/localizacao/{id}', [
    LocalizacaoControllerApi::class,
    'update'
]);


// EXCLUIR
Route::delete('/localizacao/{id}', [
    LocalizacaoControllerApi::class,
    'destroy'
]);
