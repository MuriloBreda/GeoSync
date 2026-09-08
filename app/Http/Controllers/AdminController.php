<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Remessa;
use App\Models\Alerta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('login-admin');
    }

    public function login(Request $request)
    {
        $credenciais = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credenciais)) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            Auth::logout();
            return redirect()->back()->with('error', 'Esta conta não possui privilégios de Administrador.');
        }

        return redirect()->back()->with('error', 'E-mail ou senha inválidos.');
    }

    public function showRegister()
    {
        return view('cadastro-admin');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'security_token' => 'required'
        ]);

        // Chave secreta para evitar cadastros admin indevidos
        if ($request->security_token !== 'GEOSYNC') {
            return redirect()->back()->withErrors(['security_token' => 'Chave de ativação inválida.']);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo' => 'admin' // Usa a sua coluna 'tipo'
        ]);

        // CORREÇÃO: Redireciona para a URL '/login' diretamente, evitando que o Laravel busque uma rota nomeada inexistente
        return redirect('/login')->with('success', 'Administrador criado com sucesso!');
    }

    public function dashboard()
    {
        // Estatísticas para os cards do seu MySQL
        $totalRemessas = Remessa::count();
        $motoristasAtivos = User::where('tipo', 'motorista')->count();
        $alertasCriticos = Remessa::where('status', 'Atrasado')->count();

        // Listas para alimentar o formulário de cadastro de remessa do painel
        $motoristas = User::where('tipo', 'motorista')->get();
        $clientes = User::where('tipo', 'cliente')->get();

        return view('dashboard-admin', [
            'total' => $totalRemessas,
            'motoristasAtivos' => $motoristasAtivos,
            'alertasCriticos' => $alertasCriticos,
            'motoristas' => $motoristas,
            'clientes' => $clientes,
            'usuarios' => User::all(),
            'remessas' => Remessa::all(),
            'alertas' => Alerta::latest()->get(),
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        abort_if($user->id === Auth::id(), 422, 'Você não pode excluir a própria conta.');
        $user->delete();

        return back()->with(
            'success',
            'Usuário removido!'
        );
    }

    public function deleteRemessa($id)
    {
        Remessa::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Remessa removida!'
        );
    }

    public function storeMotorista(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'cpf' => 'required|string|max:14|unique:users',
            'telefone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'password' => Hash::make($request->password),
            'tipo' => 'motorista' // Força a gravação como motorista
        ]);

        return redirect()->back()->with('success', 'Motorista homologado com sucesso!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
