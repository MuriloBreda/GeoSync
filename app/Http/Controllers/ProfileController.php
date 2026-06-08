<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'nullable|max:20',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => $request->telefone,
        ];

        // Atualizar senha
        if ($request->filled('password')) {

            $request->validate([
                'password' => 'confirmed|min:6',
            ]);

            $data['password'] = Hash::make($request->password);
        }

        // Upload da foto
        if ($request->hasFile('foto')) {

            $path = $request->file('foto')->store('users', 'public');

            $data['foto'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}