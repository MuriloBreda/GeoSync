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
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

/* --- PÁGINAS PÚBLICAS --- */
Route::get('/', function () { return view('index'); });
Route::get('/about', function () { return view('about'); });
Route::get('/faq', function () { return view('faq'); });
Route::get('/welcome', function () { return view('welcome'); });
Route::get('/contact', function () { return view('contact'); });
Route::post('/contato/enviar', [ContatoController::class, 'store'])->name('contato.store');
Route::get('/pagamento', function () { return view('pagamento'); });
Route::get('/planos', function () { return view('telaPlanos'); });
Route::post('/avaliacao/store', [AvaliacaoController::class, 'store'])->name('avaliacao.store');
Route::get('/avaliar', [AvaliacaoController::class, 'index'])->name('avaliacao.index');

/* --- CHAT OPERACIONAL --- */
Route::get('/chat', [ChatController::class, 'index'])->name('chat');
Route::post('/chat/iniciar', [ChatController::class, 'iniciar'])->name('chat.iniciar');
Route::post('/chat/enviar', [ChatController::class, 'enviar'])->name('chat.enviar');
Route::get('/teste-ia', [ChatController::class, 'testeIA']);

/* --- AUTENTICAÇÃO COMUM --- */
Route::get('/login', function () { return view('login'); })->name('login');
Route::get('/register', function () { return view('createAccount'); });
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

/* --- SISTEMA DE CADASTRO E LOGIN DO ADMIN --- */
Route::get('/login-admin', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/login-admin', [AdminController::class, 'login']);

// Aceita as duas URLs para garantir que seu TCC não quebre
Route::get('/cadastro-admin', [AdminController::class, 'showRegister'])->name('admin.register');
Route::get('/register-admin', [AdminController::class, 'showRegister']); 
Route::post('/cadastro-admin', [AdminController::class, 'register']);
Route::post('/register-admin', [AdminController::class, 'register']);

/* --- ÁREA AUTENTICADA --- */
Route::middleware('auth')->group(function () {
Route::post('/configuracoes', [ProfileController::class, 'update']);
Route::post('/mudar-senha', [UserController::class, 'updatePassword'])->name('password.update');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/antifraude', function () { return view('antifraude'); });
Route::get('/ia-antifraude/{id?}', [IAController::class, 'antifraude']);

Route::resource('remessas', RemessaController::class);
Route::resource('alertas', AlertaController::class);
Route::post('/alerta', [AlertaController::class, 'store'])->name('alerta.store');
Route::resource('localizacoes', LocalizacaoController::class);
Route::post('/localizacao', [LocalizacaoController::class, 'store'])->name('localizacao.store');
Route::post('/pagamento/store', [PagamentoController::class, 'store'])->name('pagamento.store');

Route::get('/service-cliente', [RemessaController::class, 'dashboardCliente'])->name('cliente.dashboard');
// Use o middleware 'auth' para garantir que o usuário está logado
Route::middleware(['auth'])->group(function () {
    Route::get('/service-motorista', [RemessaController::class, 'dashboardMotorista'])->name('motorista.dashboard');
});
Route::post('/motorista/aceitar', [RemessaController::class, 'aceitarRemessa'])->name('motorista.aceitar');
Route::post('/motorista/status', [RemessaController::class, 'atualizarStatus'])->name('motorista.status');

Route::get('/admin-dashboard', [RemessaController::class, 'adminDashboard'])->name('admin.dashboard');
Route::post('/admin/store-motorista', [RemessaController::class, 'storeMotorista'])->name('admin.storeMotorista');

Route::delete('/admin/user/{id}',
    [AdminController::class,'deleteUser'])
    ->name('admin.deleteUser');

Route::delete('/admin/remessa/{id}',
    [AdminController::class,'deleteRemessa'])
    ->name('admin.deleteRemessa');
});

/* --- REDIRECIONAMENTO SEGURO --- */
Route::get('/dashboard', function () {
if (Auth::check()) {
if (Auth::user()->tipo === 'admin') return redirect('/admin-dashboard');
if (Auth::user()->tipo === 'motorista') return redirect('/service-motorista');
return redirect('/service-cliente');
}
return redirect('/login');
})->name('dashboard');