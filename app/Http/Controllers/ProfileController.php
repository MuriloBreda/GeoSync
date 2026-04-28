<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // senha
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        // foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('users', 'public');
            $data['foto'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Atualizado com sucesso!');
    }
}