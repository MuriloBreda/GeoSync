<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IAController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RemessaController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\LocalizacaoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ContatoController;

// Página inicial
Route::get('/', function () {
    return view('index');
});

// Páginas
Route::get('/about', fn() => view('about'));
Route::get('/pagamento', fn() => view('pagamento'));

Route::get('/contact', fn() => view('contact'));
// Rota para salvar o contato
Route::post('/contato/enviar', [ContatoController::class, 'store'])->name('contato.store');

// Rota para exibir a página de chat
Route::get('/chat', function () {
    return view('chat'); // Certifique-se que o arquivo é chat.blade.php
})->name('chat.index');

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
Route::post('/avaliacao/store', [App\Http\Controllers\AvaliacaoController::class, 'store'])->name('avaliacao.store');

Route::get('/cadastroMercadoria', fn() => view('cadastromercadoria'));
Route::get('/chat', fn() => view('chat'))->name('chat');


// Tela de rastreamento de veiculo
Route::get('/antifraude', fn() => view('antifraude'));
Route::get('/ia-antifraude', [IAController::class, 'antifraude']);


// Routes do arquivo service.blade.php
Route::post('/configuracoes', [ProfileController::class, 'update']);


// CRUD DE REMESSAS
Route::resource('remessas', RemessaController::class)->middleware('auth');
Route::resource('alertas', AlertaController::class)->middleware('auth');
Route::resource('localizacoes', LocalizacaoController::class)->middleware('auth');

Route::get('/service', [RemessaController::class, 'dashboard'])->middleware('auth');

Route::post('/localizacao', [LocalizacaoController::class, 'store'])
    ->name('localizacao.store');

Route::post('/alerta', [AlertaController::class, 'store'])
    ->name('alerta.store');

Route::get('/remessas/{id}/edit', [RemessaController::class, 'edit'])
    ->name('remessas.edit');

Route::put('/remessas/{id}', [RemessaController::class, 'update'])
    ->name('remessas.update');

// MOTORISTA 
Route::get('/motorista', function () {
    return view('motorista');
});

// Pagamento
Route::post('/pagamento/store', [PagamentoController::class, 'store'])->name('pagamento.store');


// MUDAR A SENHA
use App\Http\Controllers\UserController;

// Rota para mudar a senha
Route::post('/mudar-senha', [UserController::class, 'updatePassword'])->name('password.update');