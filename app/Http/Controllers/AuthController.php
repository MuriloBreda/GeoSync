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