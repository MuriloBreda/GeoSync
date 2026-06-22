<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // CADASTRO
    public function register(Request $request)
{

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

    // 2. Criação do Usuário
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'tipo' => $request->tipo, // <--- CERTIFIQUE-SE DE QUE ESTÁ ASSIM
        'cpf' => $request->cpf,
        'telefone' => $request->telefone,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/login')->with('success', 'Cadastro realizado!');
}

    // LOGIN
    public function login(Request $request)
    {
        $credenciais = $request->only('email', 'password');

        if (Auth::attempt($credenciais)) {

            $user = Auth::user();

            if ($user->tipo == 'admin') {
                return redirect('/admin')
                    ->with('success', 'Login realizado com sucesso!');
            }

            if ($user->tipo == 'motorista') {
                return redirect('/service-motorista')
                    ->with('success', 'Login realizado com sucesso!');
            }

            return redirect('/service-cliente')
                ->with('success', 'Login realizado com sucesso!');
        }

        return back()->with(
            'error',
            'Email ou senha inválidos'
        );
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}