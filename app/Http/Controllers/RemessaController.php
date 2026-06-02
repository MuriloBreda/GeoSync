<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remessa;
use App\Models\Alerta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RemessaController extends Controller
{
    // DASHBOARD PRINCIPAL
    public function dashboard()
    {
        $user = Auth::user();
        if ($user->tipo == 'admin') {
            return $this->dashboardCliente(); // Altere para a lógica do Admin se reativar o método
        }
        if ($user->tipo == 'motorista') {
            return $this->dashboardMotorista();
        }
        return $this->dashboardCliente();
    }

    // CLIENTE
    public function dashboardCliente()
    {
        $userId = Auth::id();
        $remessas = Remessa::with(['cliente', 'motorista', 'localizacoes', 'alertas'])
            ->where('cliente_id', $userId)
            ->get();

        $total     = $remessas->count();
        $transito  = $remessas->where('status', 'Em Rota')->count();
        $entregues = $remessas->where('status', 'Entregue')->count();
        $atrasadas = $remessas->where('status', 'Atrasado')->count();
        $alertas   = Alerta::latest()->take(5)->get();

        return view('serviceCliente', compact('total', 'transito', 'entregues', 'atrasadas', 'alertas', 'remessas'));
    }

    // MOTORISTA
    public function dashboardMotorista()
{
    $motoristaId = Auth::id();

    // 1. Todas as viagens que pertencem a ESTE motorista logado
    $remessas = Remessa::where('motorista_id', $motoristaId)->get();

    // 2. Estatísticas para os cards superiores
    $total = $remessas->count();
    $transito = $remessas->where('status', 'Em Rota')->count();

    // 3. Novas Cargas Disponíveis (onde o motorista_id ainda é NULL)
    $remessasDisponiveis = Remessa::whereNull('motorista_id')->get();

    // 4. Viagens ativas deste motorista para preencher o SELECT de atualizar status
    // (Filtramos para não mostrar as que já foram 'Entregues')
    $minhasRemessas = Remessa::where('motorista_id', $motoristaId)
                             ->where('status', '!=', 'Entregue')
                             ->get();

    return view('serviceMotorista', compact('remessas', 'total', 'transito', 'remessasDisponiveis', 'minhasRemessas'));
}

    public function atualizarCoordenadas(Request $request) 
{
    $request->validate([
        'codigo_rastreio' => 'required', // Mudamos de remessa_id para codigo_rastreio
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    // Procura no banco usando o código que veio da tela (ex: 999999)
    $remessa = Remessa::where('codigo_rastreio', $request->codigo_rastreio)->first();

    if ($remessa) {
        $remessa->latitude = $request->latitude;
        $remessa->longitude = $request->longitude;
        $remessa->save();
        return response()->json(['status' => 'Sucesso', 'mensagem' => 'Posição atualizada!']);
    }

    return response()->json(['status' => 'Erro', 'mensagem' => 'Remessa não encontrada'], 404);
}

    public function consultarLocalizacaoJson($codigo_rastreio) {
    $remessa = Remessa::where('codigo_rastreio', $codigo_rastreio)->firstOrFail();
    
    return response()->json([
        'latitude' => $remessa->latitude,
        'longitude' => $remessa->longitude,
        'status' => $remessa->status
    ]);
}

    public function aceitarRemessa(Request $request)
    {
        $request->validate([
            'remessa_id' => 'required|exists:remessas,id'
        ]);

        $remessa = Remessa::findOrFail($request->remessa_id);
        $remessa->update([
            'motorista_id' => Auth::id(),
            'status'       => 'Em Rota'
        ]);

        return redirect()->back()->with('success', 'Você aceitou a remessa com sucesso! Boa viagem.');
    }

    public function index()
    {
        return $this->dashboard();
    }

    public function create()
    {
        $motoristas = User::where('tipo', 'motorista')->get();
        return view('cadastroMercadoria', compact('motoristas'));
    }

    // 💾 SALVAR REMESSA
    public function store(Request $request)
    {
        // Removido o 'codigo_rastreio' daqui pois ele é gerado de forma automática abaixo
        $request->validate([
            'codigo_rastreio'  => 'required|max:15',
            'origem'           => 'required|max:100',
            'destino'          => 'required|max:100',
            'tipo_carga'       => 'required|max:100',
            'peso'             => 'required|numeric',
            'previsao_entrega' => 'required|date',
            'status'           => 'required|max:50',
            'motorista_id'     => 'nullable|exists:users,id'
        ]);

        Remessa::create([
            'codigo_rastreio'  => $request->codigo_rastreio, // Agora o código de rastreio é gerado automaticamente
            'origem'           => $request->origem,
            'destino'          => $request->destino,
            'tipo_carga'       => $request->tipo_carga,
            'peso'             => $request->peso,
            'previsao_entrega' => $request->previsao_entrega,
            'status'           => $request->status,
            'cliente_id'       => Auth::id(),
            'motorista_id'     => $request->motorista_id
        ]);

        return redirect('/service-cliente')->with('success', 'Remessa cadastrada com sucesso!');
    }

    public function show($id)
    {
        $remessa = Remessa::with(['cliente', 'motorista', 'localizacoes', 'alertas'])->findOrFail($id);
        return view('remessaShow', compact('remessa'));
    }

    public function edit($id)
    {
        $remessa    = Remessa::findOrFail($id);
        $motoristas = User::where('tipo', 'motorista')->get();
        return view('remessaEdit', compact('remessa', 'motoristas'));
    }

    public function update(Request $request, $id)
{
    $remessa = Remessa::findOrFail($id);
    $user = Auth::user();

    // Se for motorista, ele só pode/precisa atualizar o Status (e opcionalmente o motorista_id)
    if ($user->tipo == 'motorista') {
        $request->validate([
            'status' => 'required|max:50'
        ]);

        $remessa->update([
            'status' => $request->status
        ]);

        return redirect('/service-motorista')
            ->with('success', 'Status da remessa atualizado com sucesso!');
    }

    // Se for Cliente ou Admin, atualiza todos os campos do formulário completo
    $request->validate([
        'origem' => 'required|max:100',
        'destino' => 'required|max:100',
        'status' => 'required|max:50'
    ]);

    $remessa->update([
        'origem' => $request->origem,
        'destino' => $request->destino,
        'tipo_carga' => $request->tipo_carga,
        'peso' => $request->peso,
        'previsao_entrega' => $request->previsao_entrega,
        'status' => $request->status,
        'motorista_id' => $request->motorista_id
    ]);

    return redirect('/service-cliente')
        ->with('success', 'Remessa atualizada com sucesso!');
}

    // Rota para o motorista atualizar o status de uma remessa que já é dele
public function atualizarStatus(Request $request)
{
    $request->validate([
        'remessa_id' => 'required|exists:remessas,id',
        'status' => 'required|max:50'
    ]);

    // Encontra a remessa enviada pelo formulário do motorista
    $remessa = Remessa::findOrFail($request->remessa_id);
    
    // Atualiza o status
    $remessa->status = $request->status;
    $remessa->save(); // Salva permanentemente no banco de dados

    // Redireciona de volta para o painel do motorista com mensagem de sucesso
    return redirect('/service-motorista')->with('success', 'Status da entrega atualizado com sucesso!');
}

    public function destroy($id)
    {
        $remessa = Remessa::findOrFail($id);
        $remessa->delete();
        return redirect('/service-cliente')->with('success', 'Remessa removida com sucesso!');
    }
}