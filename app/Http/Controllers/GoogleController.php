<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->email)->first();

        // Se o email não estiver cadastrado
        if (!$user) {
            return redirect('/login')
                ->with('error', 'Este e-mail Google não está cadastrado no sistema.');
        }

        Auth::login($user);

        // Redireciona conforme o tipo
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
}