<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remessa;
use App\Models\User;
use App\Models\Alerta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RemessaController extends Controller
{
    /**
     * Exibe o Dashboard Geral do ADMINISTRADOR
     */
    public function adminDashboard()
    {
        $totalRemessas = Remessa::count();
        $motoristasAtivos = User::where('tipo', 'motorista')->count();
        $alertasCriticos = Remessa::where('status', 'Atrasado')->count();

        $motoristas = User::where('tipo', 'motorista')->get();
        $clientes = User::where('tipo', 'cliente')->get();

        // NOVAS VARIÁVEIS
        $usuarios = User::all();
        $remessas = Remessa::all();
        $alertas = \App\Models\Alerta::latest()->get();

        return view('dashboard-admin', [
            'total' => $totalRemessas,
            'motoristasAtivos' => $motoristasAtivos,
            'alertasCriticos' => $alertasCriticos,

            'motoristas' => $motoristas,
            'clientes' => $clientes,

            // ADICIONAR ESTAS
            'usuarios' => $usuarios,
            'remessas' => $remessas,
            'alertas' => $alertas
        ]);
    }

    /**
     * Admin cadastrando um motorista de forma privada dentro do Painel
     */
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
            'tipo' => 'motorista'
        ]);

        return redirect()->back()->with('success', 'Motorista homologado com sucesso!');
    }

    public function dashboardCliente()
    {
        // Pega o ID do usuário logado
        $userId = auth()->id();

        // SUBSTITUÍMOS 'user_id' POR 'cliente_id' (que é o nome real da coluna no seu SQL)
        $remessas = Remessa::where('cliente_id', $userId)->get();

        $total = Remessa::where('cliente_id', $userId)->count();
        $transito = Remessa::where('cliente_id', $userId)->where('status', 'Em trânsito')->count();
        $entregues = Remessa::where('cliente_id', $userId)->where('status', 'Entregue')->count();
        $atrasadas = Remessa::where('cliente_id', $userId)->where('status', 'Pendente')->count();

        // Busca os alertas vinculados às remessas desse cliente
        $alertas = \App\Models\Alerta::whereIn('remessa_id', $remessas->pluck('id'))->get();

        return view('serviceCliente', [
            'remessas' => $remessas,
            'total' => $total,
            'transito' => $transito,
            'entregues' => $entregues,
            'atrasadas' => $atrasadas,
            'alertas' => $alertas
        ]);
    }

    public function dashboardMotorista()
    {
        $motoristaId = auth()->id();
        $remessas = \App\Models\Remessa::where('motorista_id', $motoristaId)->get();

        return view('serviceMotorista', [
            'remessas' => $remessas, // Este é o nome que a view vai usar
            'total' => $remessas->count(),
            'pendentes' => $remessas->where('status', 'Pendente')->count(),
            'emRota' => $remessas->where('status', 'Em Rota')->count(),
            'entregues' => $remessas->where('status', 'Entregue')->count()
        ]);
    }

    /**
     * Grava uma nova remessa/mercadoria no Banco de Dados
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo_rastreio' => 'required|string|max:100|unique:remessas',
            'origem' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'tipo_carga' => 'nullable|string|max:100',
            'peso' => 'nullable|numeric',
            'previsao_entrega' => 'nullable|date',
            'status' => 'required|string|max:50',
            'cliente_id' => 'nullable|exists:users,id',
            'motorista_id' => 'nullable|exists:users,id',
        ]);

        Remessa::create([
            'codigo_rastreio' => $request->codigo_rastreio,
            'origem' => $request->origem,
            'destino' => $request->destino,
            'tipo_carga' => $request->tipo_carga,
            'peso' => $request->peso,
            'previsao_entrega' => $request->previsao_entrega,
            'status' => $request->status,
            'cliente_id' => $request->cliente_id,
            'motorista_id' => $request->motorista_id,
        ]);

        return redirect()->back()->with('success', 'Nova ordem de remessa registrada no sistema!');
    }

    public function index() { return redirect()->route('dashboard'); }
    public function create() { return view('cadastromercadoria'); }
    public function show($id) { return view('welcome'); }
    public function edit($id) { return view('welcome'); }
    public function update(Request $request, $id) { return redirect()->back(); }
    public function destroy($id) { return redirect()->back(); }
    
    public function aceitarRemessa(Request $request)
    {
        $request->validate(['remessa_id' => 'required|exists:remessas,id']);
        $remessa = Remessa::findOrFail($request->remessa_id);
        $remessa->update(['motorista_id' => Auth::id(), 'status' => 'Em Rota']);
        return redirect()->back()->with('success', 'Viagem aceita!');
    }

    public function atualizarStatus(Request $request)
    {
        $remessa = Remessa::findOrFail($request->remessa_id);
        if($remessa->status === 'Entregue') {
            return redirect()->back()->with('error', 'Esta carga já foi entregue!');
        }

        $request->validate(['remessa_id' => 'required|exists:remessas,id', 'status' => 'required|string']);
        
        $remessa->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status atualizado!');
    }

    public function storeAlerta(Request $request)
    {
        $remessa = \App\Models\Remessa::findOrFail($request->remessa_id);

        // TRAVA DE SEGURANÇA: Se estiver entregue, barra o envio!
        if ($remessa->status === 'Entregue') {
            return redirect()->back()->with('error', 'Atenção: Não é permitido emitir alertas para remessas já entregues.');
        }

        // Caso contrário, salva o alerta...
        Alerta::create([
            'remessa_id' => $request->remessa_id,
            'tipo' => $request->tipo,
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->back()->with('success', 'Alerta enviado com sucesso!');
    }
}