<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IAController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RemessaController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\LocalizacaoController;

// Página inicial
Route::get('/', function () {
    return view('index');
});

// Páginas
Route::get('/about', fn() => view('about'));
Route::get('/contact', fn() => view('contact'));
Route::get('/service', [RemessaController::class, 'dashboard'])->middleware('auth');
Route::get('/welcome', fn() => view('welcome')); // Tela do laravel
Route::get('/faq', fn() => view('faq'));

// AUTH
Route::get('/login', fn() => view('login'))->name('login');
Route::get('/register', fn() => view('createAccount'));

// CADASTRO E LOGIN (BACKEND)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// LOGOUT
Route::get('/logout', [AuthController::class, 'logout']);

// OUTRAS TELAS
Route::get('/avaliar', fn() => view('avaliacao'));
Route::get('/cadastroMercadoria', fn() => view('cadastromercadoria'));
Route::get('/chat', fn() => view('chat'))->name('chat');


// Tela de rastreamento de veiculo
Route::get('/antifraude', fn() => view('antifraude'));
Route::get('/ia-antifraude', [IAController::class, 'antifraude']);


// Routes do arquivo service.blade.php
Route::get('/configuracoes', [ProfileController::class, 'update']);


// CRUD DE REMESSAS
Route::resource('remessas', RemessaController::class)->middleware('auth');
Route::resource('alertas', AlertaController::class)->middleware('auth');
Route::resource('localizacoes', LocalizacaoController::class)->middleware('auth');

Route::get('/service', [RemessaController::class, 'dashboard'])->middleware('auth');

Route::post('/localizacao', [LocalizacaoController::class, 'store'])
    ->name('localizacao.store');

Route::post('/alerta', [AlertaController::class, 'store'])
    ->name('alerta.store');

// MOTORISTA 
Route::get('/motorista', function () {
    return view('motorista');
});