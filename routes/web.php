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
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('index'));
Route::get('/about', fn() => view('about'));
Route::get('/faq', fn() => view('faq'));
Route::get('/welcome', fn() => view('welcome'));

Route::get('/contact', fn() => view('contact'));
Route::post('/contato/enviar', [ContatoController::class, 'store'])->name('contato.store');

Route::get('/chat', fn() => view('chat'))->name('chat');
Route::get('/pagamento', fn() => view('pagamento'));
Route::get('/avaliar', fn() => view('avaliacao'));
Route::post('/avaliacao/store', [AvaliacaoController::class, 'store'])->name('avaliacao.store');

/*
|--------------------------------------------------------------------------
| AUTH (AUTENTICAÇÃO)
|--------------------------------------------------------------------------
*/

Route::get('/login', fn() => view('login'))->name('login');
Route::get('/register', fn() => view('createAccount'));
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| ÁREA LOGADA (PROTEGIDA POR AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /* --- DASHBOARDS --- */
    Route::get('/admin', [RemessaController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/service-cliente', [RemessaController::class, 'dashboardCliente'])->name('cliente.dashboard');
    Route::get('/service-motorista', [RemessaController::class, 'dashboardMotorista'])->name('motorista.dashboard');

    /* --- CONFIGURAÇÕES --- */
    Route::post('/configuracoes', [ProfileController::class, 'update']);
    Route::post('/mudar-senha', [UserController::class, 'updatePassword'])->name('password.update');

    Route::post('/profile/update', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

    /* --- IA & ANTIFRAUDE --- */
    Route::get('/antifraude', fn() => view('antifraude'));
    Route::get('/ia-antifraude/{id?}', [IAController::class, 'antifraude']);

    /* --- RECURSOS / CRUD DE REMESSAS --- */
    // Essa linha do resource cria automaticamente as rotas: remessas.create, remessas.store, remessas.show, etc.
    Route::resource('remessas', RemessaController::class);

    /* --- AÇÕES DO MOTORISTA --- */
    Route::post('/motorista/aceitar', [RemessaController::class, 'aceitarRemessa'])->name('motorista.aceitar');
    Route::post('/motorista/status', [RemessaController::class, 'atualizarStatus'])->name('motorista.status');

    /* --- ALERTAS --- */
    Route::resource('alertas', AlertaController::class);
    Route::post('/alerta', [AlertaController::class, 'store'])->name('alerta.store');

    /* --- LOCALIZAÇÕES --- */
    Route::resource('localizacoes', LocalizacaoController::class);
    Route::post('/localizacao', [LocalizacaoController::class, 'store'])->name('localizacao.store');

    /* --- PAGAMENTOS --- */
    Route::post('/pagamento/store', [PagamentoController::class, 'store'])->name('pagamento.store');
});