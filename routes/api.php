<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocalizacaoControllerApi;


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