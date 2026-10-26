<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pagamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        $email = strtolower((string) $request->query('email', ''));
        $hasApprovedPayment = $email !== '' && Pagamento::whereRaw('LOWER(email) = ?', [$email])
            ->where('status', 'Aprovado')->whereNull('user_id')->exists();

        return view('createAccount', [
            'paymentEmail' => $hasApprovedPayment ? $email : null,
            'paymentRequired' => !$hasApprovedPayment,
        ]);
    }

    // CADASTRO
    public function register(Request $request)
{

    $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);

    $request->validate(
        [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'cpf' => 'required|unique:users',
            'password' => 'required|min:6'
        ],
        [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Digite um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.'
        ]
    );

    // 1. Validação
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'tipo' => 'required|in:cliente,motorista', // Valida se é um dos dois
        'cpf' => 'required|string|max:14|unique:users',
        'telefone' => 'required|string|max:20',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($request->tipo !== 'cliente') {
        throw ValidationException::withMessages(['tipo' => 'O cadastro pelo checkout está disponível para clientes.']);
    }

    DB::transaction(function () use ($request) {
        $payment = Pagamento::whereRaw('LOWER(email) = ?', [$request->email])
            ->where('status', 'Aprovado')->whereNull('user_id')->lockForUpdate()->first();

        if (!$payment) {
            throw ValidationException::withMessages([
                'email' => 'Este e-mail não possui um pagamento aprovado disponível. Faça o pagamento antes de criar a conta.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tipo' => 'cliente',
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'password' => Hash::make($request->password),
        ]);

        $payment->user_id = $user->id;
        $payment->save();
    });

    return redirect('/login')->with('success', 'Cadastro realizado!');
}

    // LOGIN
    public function login(Request $request)
{
    // 1. Valida se os campos foram preenchidos
    $credenciais = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 2. Tenta fazer o login com as credenciais no MySQL
    if (Auth::attempt($credenciais)) {
        
        // CORREÇÃO CRÍTICA: Limpa a memória de redirecionamentos antigos do Laravel
        $request->session()->regenerate();
        $request->session()->forget('url.intended'); 

        // 3. Pega o utilizador que acabou de logar
        $user = Auth::user();

        // 4. Faz o desvio exato baseado na tua coluna 'tipo'
        if ($user->tipo === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->tipo === 'motorista') {
            return redirect()->route('motorista.dashboard');
        } else {
            return redirect()->route('cliente.dashboard');
        }
    }

    // Se falhar o login, volta com a mensagem de erro
    return redirect()->back()->with('error', 'E-mail ou senha incorretos.');
}

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
