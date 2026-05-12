<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // ... outros métodos (updateProfile) ...

    /**
     * Altera a senha do usuário
     */
    public function updatePassword(Request $request)
{
    // Adicione um dd($request->all()); aqui para testar se os dados chegam
    // dd($request->all()); 

    $request->validate([
        'password' => 'required|confirmed|min:8',
    ]);

    $user = Auth::user();
    // Importante: use Hash::make para criptografar
    $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
    
    // ESTA LINHA É A MAIS IMPORTANTE:
    $user->save(); 

    return back()->with('success', 'Senha alterada!');
}
}