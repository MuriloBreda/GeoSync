<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync | Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            /* Paleta de Cores */
            --primary: #2563eb; 
            --primary-hover: #1d4ed8;
            --bg: #f8fafc; 
            --sidebar: #0f172a; 
            --sidebar-hover: rgba(255, 255, 255, 0.05);
            --card: #ffffff;
            --text-main: #0f172a; 
            --text-muted: #64748b; 
            --border: #e2e8f0;
            --input-bg: #f1f5f9;
            
            /* Dimensões e Efeitos */
            --radius-lg: 16px; 
            --radius-md: 10px; 
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-hover: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            
            /* Alertas */
            --alert-danger: #ef4444; 
            --alert-warning: #f59e0b; 
            --alert-info: #3b82f6;
            --alert-success: #10b981;
        }

        body.dark { 
            --bg: #0b0f19; 
            --card: #111827; 
            --text-main: #f8fafc; 
            --text-muted: #94a3b8; 
            --border: #1f2937; 
            --input-bg: #1f2937;
            --sidebar: #030712;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg); 
            color: var(--text-main); 
            transition: background-color 0.3s, color 0.3s; 
            font-size: 14px; 
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Scrollbar Customizada */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        body.dark ::-webkit-scrollbar-thumb { background: #475569; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .layout { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar); 
            padding: 2rem 1.2rem; 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            height: 100vh; 
            z-index: 100;
            border-right: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }
        .logo { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 2.5rem; display: flex; align-items: center; gap: 12px; padding: 0 10px;}
        .nav-link { 
            padding: 12px 16px; 
            color: #94a3b8; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            gap: 14px; 
            border-radius: var(--radius-md); 
            margin-bottom: 6px; 
            cursor: pointer; 
            font-weight: 500; 
            transition: all 0.2s ease;
        }
        .nav-link i { font-size: 1.1rem; width: 20px; text-align: center; }
        .nav-link:hover { background: var(--sidebar-hover); color: #f8fafc; transform: translateX(4px); }
        .nav-link.active { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); font-weight: 600; }

        /* MAIN CONTENT */
        .main-content { flex: 1; margin-left: 260px; padding: 2rem 2.5rem; transition: margin-left 0.3s; }
        .content-card { 
            background: var(--card); 
            border-radius: var(--radius-lg); 
            padding: 1.75rem; 
            box-shadow: var(--shadow-md); 
            border: 1px solid var(--border); 
            margin-bottom: 1.5rem; 
            transition: box-shadow 0.3s ease;
        }
        .content-card:hover { box-shadow: var(--shadow-hover); }
        .content-card h2, .content-card h3 { margin-bottom: 1rem; color: var(--text-main); font-weight: 700; }
        
        /* GRIDS DE ESTATÍSTICAS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { 
            background: var(--card); 
            padding: 1.5rem; 
            border-radius: var(--radius-lg); 
            border: 1px solid var(--border); 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .stat-card h4 { color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem; font-weight: 600; }
        .stat-card h2 { font-size: 1.8rem; font-weight: 800; color: var(--text-main); }
        .stat-card i { font-size: 2.2rem; color: var(--border); opacity: 0.8; }

        /* GRIDS DE GRÁFICOS */
        .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
        canvas { width: 100% !important; max-height: 300px; }

        /* TABELAS E ALERTAS */
        .table-res { overflow-x: auto; margin-top: 1rem; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 800px; }
        th { text-align: left; padding: 14px 16px; color: var(--text-muted); border-bottom: 2px solid var(--border); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-weight: 500; vertical-align: middle; transition: background 0.2s; }
        tbody tr:hover td { background: rgba(37, 99, 235, 0.03); }
        body.dark tbody tr:hover td { background: rgba(255, 255, 255, 0.02); }
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-block; text-align: center; }
        .entregue { background: rgba(16, 185, 129, 0.15); color: var(--alert-success); }
        .transito { background: rgba(59, 130, 246, 0.15); color: var(--alert-info); }
        .atrasado { background: rgba(239, 68, 68, 0.15); color: var(--alert-danger); }

        /* AÇÕES TABELA */
        .action-icons { display: flex; gap: 12px; font-size: 1.1rem; }
        .action-icons a, .action-icons button { color: var(--text-muted); transition: all 0.2s; cursor: pointer; }
        .action-icons .fa-eye:hover { color: var(--alert-info); transform: scale(1.1); }
        .action-icons .fa-pen:hover { color: var(--alert-warning); transform: scale(1.1); }
        .action-icons .fa-trash:hover { color: var(--alert-danger); transform: scale(1.1); }

        .page { display: none; }
        .page.active { display: block; animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* FORMULÁRIOS */
        label { display: block; margin-bottom: 6px; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); mt-3}
        input, select, textarea { 
            width: 100%; 
            padding: 12px 14px; 
            border-radius: var(--radius-md); 
            border: 1px solid var(--border); 
            background: var(--input-bg); 
            color: var(--text-main); 
            margin-bottom: 16px;
            font-family: inherit;
            transition: all 0.2s ease;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            background: var(--bg);
        }
        
        .btn-salvar { 
            background: var(--primary); 
            color: white; 
            border: none; 
            padding: 12px 24px; 
            border-radius: var(--radius-md); 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-salvar:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3); }
        
        #map-full { width: 100%; height: 500px; border-radius: var(--radius-md); background: #eee; }
        .profile-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary); }

        /* ACESSIBILIDADE */
        .toggle-item { display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px solid var(--border); font-weight: 500;}
        .toggle-item:last-child { border-bottom: none; }
        .toggle-item input[type="checkbox"] { width: 20px; height: 20px; cursor: pointer; accent-color: var(--primary); margin: 0; }

        /* Classe de Alto Contraste */
        body.high-contrast {
            --bg: #000000 !important;
            --card: #000000 !important;
            --text-main: #ffff00 !important; 
            --text-muted: #ffffff !important;
            --border: #ffffff !important;
            --primary: #ffffff !important;
            --input-bg: #000000 !important;
        }
        body.high-contrast .sidebar { background: #000 !important; border-right: 2px solid #fff; }
        body.high-contrast .btn-salvar { background: #fff !important; color: #000 !important; }

        /* Classe de Fontes Grandes */
        body.large-fonts { font-size: 18px !important; }
        body.large-fonts h1 { font-size: 2.5rem; }
        body.large-fonts h2 { font-size: 2rem; }
        body.large-fonts .nav-link, body.large-fonts label, body.large-fonts input { font-size: 16px; }
        body.large-fonts td, body.large-fonts th { font-size: 16px; }

        /* DESIGN RESPONSIVO */
        @media (max-width: 1024px) {
            .charts-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .layout { flex-direction: column; }
            .sidebar { 
                width: 100%; 
                height: auto; 
                position: relative; 
                padding: 1rem; 
                border-right: none;
                border-bottom: 1px solid var(--border);
            }
            .sidebar nav { display: flex; overflow-x: auto; padding-bottom: 10px; }
            .nav-link { white-space: nowrap; margin-bottom: 0; margin-right: 10px; }
            .logo { margin-bottom: 1rem; }
            .main-content { margin-left: 0; padding: 1.5rem 1rem; }
        }
    </style>
</head>
<body class="{{ Auth::user()->dark_mode ? 'dark' : '' }}">

<div class="layout">
    <aside class="sidebar">
        <a href="/" style="text-decoration: none">
            <div class="logo">
                <img src="{{ asset('img/Logo.png') }}" alt="Logo" style="width: 45px; height: auto;">
                <span>GeoSync</span>
            </div>
        </a>
        <nav>
            <div class="nav-link active" onclick="showPage('dashboard', this)"><i class="fas fa-chart-pie"></i> Dashboard</div>
            <div class="nav-link" onclick="showPage('localizacao-page', this)"><i class="fas fa-map-location-dot"></i> Localização</div>
            <div class="nav-link" onclick="showPage('entregas', this)"><i class="fas fa-truck-fast"></i> Entregas</div>
            <div class="nav-link" onclick="showPage('alertas-page', this)"><i class="fas fa-bell"></i> Alertas</div>
            <div class="nav-link" onclick="showPage('antifraude', this)"><i class="fas fa-shield-halved"></i> Anti-Fraude</div>
            <div class="nav-link" onclick="showPage('config', this)"><i class="fas fa-user-gear"></i> Configurações</div>
        </nav>
        <a href="/logout" class="nav-link" style="margin-top: auto; color: var(--alert-danger);"><i class="fas fa-power-off"></i> Sair</a>
    </aside>

    <main class="main-content">

        <section id="dashboard" class="page active">
            <h1 style="margin-bottom: 1.5rem;">Dashboard Operacional</h1>
            <div class="stats-grid">
                <div class="stat-card">
                    <div><h4>Total</h4><h2>{{ $total }}</h2></div>
                    <i class="fas fa-boxes-stacked" style="color: var(--text-muted)"></i>
                </div>
                <div class="stat-card">
                    <div><h4>Em Rota</h4><h2 style="color: var(--alert-info)">{{ $transito }}</h2></div>
                    <i class="fas fa-truck-fast" style="color: var(--alert-info); opacity: 0.3;"></i>
                </div>
                <div class="stat-card">
                    <div><h4>Concluídas</h4><h2 style="color: var(--alert-success)">{{ $entregues }}</h2></div>
                    <i class="fas fa-circle-check" style="color: var(--alert-success); opacity: 0.3;"></i>
                </div>
                <div class="stat-card">
                    <div><h4>Atrasos</h4><h2 style="color: var(--alert-danger)">{{ $atrasadas }}</h2></div>
                    <i class="fas fa-clock" style="color: var(--alert-danger); opacity: 0.3;"></i>
                </div>
            </div>
            <div class="charts-grid">
                <div class="content-card">
                    <h3>Volume de Entregas</h3>
                    <canvas id="chartLinha"></canvas>
                </div>
                <div class="content-card">
                    <h3>Status da Frota</h3>
                    <canvas id="chartPizza"></canvas>
                </div>
            </div>
        </section>

        <section id="localizacao-page" class="page">
            <h1 style="margin-bottom: 1.5rem;">Monitoramento Geográfico</h1>
            <div class="charts-grid">
                <div class="content-card" style="padding: 10px;">
                    <div id="map-full"></div>
                </div>
                <div class="content-card">
                    <h3>Atualizar Posição</h3>
                    <form action="{{ route('localizacao.store') }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        <label>Remessa</label>
                        <select name="remessa_id">
                            <option value="" disabled selected>Selecione a remessa...</option>
                            @foreach($remessas as $r) 
                                <option value="{{ $r->id }}">{{ $r->codigo_rastreio }}</option> 
                            @endforeach
                        </select>
                        
                        <label>Latitude</label>
                        <input type="number" step="0.000001" name="latitude" placeholder="Ex: -23.5505">
                        
                        <label>Longitude</label>
                        <input type="number" step="0.000001" name="longitude" placeholder="Ex: -46.6333">
                        
                        <button class="btn-salvar" style="width:100%; margin-top: 10px;">
                            <i class="fas fa-location-arrow"></i> Atualizar Mapa
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <section id="entregas" class="page">
            <div class="content-card">
                <div style="display:flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <h2 style="margin: 0;">Gestão de Remessas</h2>
                    <a href="{{ route('remessas.create') }}" class="btn-salvar" style="text-decoration:none;">
                        <i class="fas fa-plus"></i> Nova Remessa
                    </a>
                </div>
                <div class="table-res">
                    <table>
                        <thead>
                            <tr>
                                <th>Rastreio</th>
                                <th>Motorista</th>
                                <th>Origem</th>
                                <th>Destino</th>
                                <th>Previsão</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remessas as $r)
                            <tr>
                                <td><strong>#{{ $r->codigo_rastreio }}</strong></td>
                                <td>{{ $r->motorista ?? 'Não atribuído' }}</td>
                                <td>{{ $r->origem }}</td>
                                <td>{{ $r->destino }}</td>
                                <td>{{ date('d/m/y', strtotime($r->data_entrega)) }}</td>
                                <td>
                                    <span class="badge {{ $r->status == 'Entregue' ? 'entregue' : ($r->status == 'Atrasado' ? 'atrasado' : 'transito') }}">
                                        {{ $r->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-icons">
                                        <a href="{{ route('remessas.show', $r->id) }}" title="Visualizar"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('remessas.edit', $r->id) }}" title="Editar"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('remessas.destroy', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="alertas-page" class="page">
            <h1 style="margin-bottom: 1.5rem;">Alertas de Segurança</h1>
            <div class="charts-grid">
                <div class="content-card">
                    <h3>Novo Alerta</h3>
                    <form action="{{ route('alerta.store') }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        <label>Remessa</label>
                        <select name="remessa_id">
                            <option value="" disabled selected>Selecione a remessa afetada...</option>
                            @foreach($remessas as $r) 
                                <option value="{{ $r->id }}">{{ $r->codigo_rastreio }}</option> 
                            @endforeach
                        </select>
                        
                        <label>Tipo de Ocorrência</label>
                        <select name="tipo_alerta">
                            <option>Atraso</option>
                            <option>Acidente</option>
                            <option>Desvio de Rota</option>
                        </select>
                        
                        <label>Descrição</label>
                        <textarea name="descricao" rows="4" placeholder="Descreva os detalhes da ocorrência..."></textarea>
                        
                        <button class="btn-salvar" style="width: 100%; margin-top: 10px;">
                            <i class="fas fa-bullhorn"></i> Publicar Alerta
                        </button>
                    </form>
                </div>
                <div class="content-card" style="max-height: 550px; overflow-y: auto;">
                    <h3 style="margin-bottom: 1.5rem;">Histórico Recente</h3>
                    @forelse($alertas as $a)
                    <div style="padding: 16px; border-left: 4px solid {{ $a->tipo_alerta == 'Acidente' ? 'var(--alert-danger)' : ($a->tipo_alerta == 'Atraso' ? 'var(--alert-warning)' : 'var(--alert-info)') }}; 
                                background: var(--bg); margin-bottom: 12px; border-radius: 8px; box-shadow: var(--shadow-sm);">
                        <div style="display:flex; justify-content:space-between; margin-bottom: 6px;">
                            <strong style="color:var(--text-main); font-size: 0.9rem;">{{ $a->tipo_alerta }}</strong>
                            <small class="badge transito">#{{ $a->remessa->codigo_rastreio ?? 'N/A' }}</small>
                        </div>
                        <p style="font-size: 0.85rem; color:var(--text-muted); line-height: 1.4;">{{ $a->descricao }}</p>
                    </div>
                    @empty
                    <p style="text-align: center; color: var(--text-muted); padding: 20px;">Nenhum alerta registrado.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="antifraude" class="page">
            <h1 style="margin-bottom: 0.5rem;">Análise Inteligente de Veículos</h1>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Detecção de anomalias e comportamentos de risco em tempo real.</p>

            <div class="content-card" style="margin-bottom: 2rem;">
                <label>Selecione uma Remessa em Rota para análise profunda:</label>
                <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 10px;">
                    <select id="select-remessa-af" style="margin: 0; flex: 1; min-width: 250px;">
                        <option value="">Selecione um código de rastreio...</option>
                        @foreach($remessas as $r)
                            @if($r->status != 'Entregue')
                                <option value="{{ $r->id }}">#{{ $r->codigo_rastreio }} - {{ $r->motorista }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button class="btn-salvar" onclick="analisarVeiculoBanco()">
                        <i class="fa-solid fa-magnifying-glass-chart"></i> Executar Análise IA
                    </button>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card" style="flex-direction: column; align-items: flex-start; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-muted);">
                        <i class="fa-regular fa-clock" style="font-size: 1.2rem;"></i> <span style="font-size: 0.85rem; font-weight: 600;">Tempo Parado</span>
                    </div>
                    <strong id="af-tempo" style="font-size: 1.5rem; color: var(--text-main);">--</strong>
                </div>

                <div class="stat-card" style="flex-direction: column; align-items: flex-start; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-muted);">
                        <i class="fa-solid fa-gauge-high" style="font-size: 1.2rem;"></i> <span style="font-size: 0.85rem; font-weight: 600;">Velocidade Média</span>
                    </div>
                    <strong id="af-velocidade" style="font-size: 1.5rem; color: var(--text-main);">--</strong>
                </div>

                <div class="stat-card" style="flex-direction: column; align-items: flex-start; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-muted);">
                        <i class="fa-solid fa-route" style="font-size: 1.2rem;"></i> <span style="font-size: 0.85rem; font-weight: 600;">Desvio de Rota</span>
                    </div>
                    <strong id="af-rota" style="font-size: 1.5rem; color: var(--text-main);">--</strong>
                </div>

                <div class="stat-card" style="flex-direction: column; align-items: flex-start; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-muted);">
                        <i class="fa-solid fa-microchip" style="font-size: 1.2rem;"></i> <span style="font-size: 0.85rem; font-weight: 600;">Conclusão da IA</span>
                    </div>
                    <strong id="af-mensagem" style="font-size: 1.2rem; color: var(--primary);">Aguardando...</strong>
                </div>
            </div>

            <div id="status-af-alerta" style="margin-top: 1rem; padding: 16px 20px; border-radius: var(--radius-md); font-weight: 600; display: none; align-items: center; gap: 12px; box-shadow: var(--shadow-sm);"></div>
        </section>

        <section id="config" class="page">
            <h1 style="margin-bottom: 1.5rem;">Configurações do Sistema</h1>
            <div class="charts-grid">
                <div class="content-card">
                    <h3>Perfil do Usuário</h3>
                    <form action="/configuracoes" method="POST" enctype="multipart/form-data" style="margin-top: 1rem;">
                        @csrf
                        <label>Nome Completo</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required>

                        <label>E-mail de Acesso</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required>

                        <label>Foto de Perfil</label>
                        <input type="file" name="foto" accept="image/*" style="padding: 9px;">

                        <button type="submit" class="btn-salvar"><i class="fas fa-save"></i> Salvar Alterações</button>
                    </form>

                    <hr style="border: 0; border-top: 1px solid var(--border); margin: 2rem 0;">
                    
                    <h3>Segurança</h3>
                    <form action="/mudar-senha" method="POST" style="margin-top: 1rem;">
                        @csrf
                        <label>Nova Senha</label>
                        <input type="password" name="password" required placeholder="Digite a nova senha">
                        
                        <label>Confirmar Senha</label>
                        <input type="password" name="password_confirmation" required placeholder="Repita a nova senha">
                        
                        <button type="submit" class="btn-salvar" style="background: var(--text-main);"><i class="fas fa-lock"></i> Atualizar Senha</button>
                    </form>
                </div>
                
                <div class="content-card" style="height: fit-content;">
                    <h3 style="margin-bottom: 1rem;">Acessibilidade e Visual</h3>
                    <div class="toggle-item">
                        <span><i class="fas fa-moon" style="width: 20px;"></i> Modo Escuro</span>
                        <input type="checkbox" id="darkToggle" onchange="toggleDark()" {{ Auth::user()->dark_mode ? 'checked' : '' }}>
                    </div>
                    <div class="toggle-item">
                        <span><i class="fas fa-circle-half-stroke" style="width: 20px;"></i> Alto Contraste</span>
                        <input type="checkbox" id="contrastToggle" onchange="toggleContrast()">
                    </div>
                    <div class="toggle-item">
                        <span><i class="fas fa-text-height" style="width: 20px;"></i> Fontes Grandes</span>
                        <input type="checkbox" id="fontToggle" onchange="toggleFonts()">
                    </div>
                </div>
            </div>
        </section>

    </main>
</div>

<div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
</div>

<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Sucesso!',
        text: @json(session('success'))
    });
});
</script>
@endif

<script>
    // Configurações globais para os gráficos Chart.js combinarem com o tema
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';

    // Gráficos
    new Chart(document.getElementById('chartLinha'), {
        type: 'line',
        data: { 
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana Atual'], 
            datasets: [{ 
                label: 'Entregas Concluídas', 
                data: [12, 19, 15, {{ $entregues ?? 0 }}], 
                borderColor: '#2563eb', 
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4 
            }] 
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('chartPizza'), {
        type: 'doughnut',
        data: { 
            labels: ['Em Rota', 'Entregues', 'Atrasadas'], 
            datasets: [{ 
                data: [{{ $transito ?? 0 }}, {{ $entregues ?? 0 }}, {{ $atrasadas ?? 0 }}], 
                backgroundColor: ['#3b82f6', '#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }] 
        },
        options: { cutout: '70%', plugins: { legend: { position: 'bottom' } } }
    });

    // Mapa
    window.initMap = function() {
        new google.maps.Map(document.getElementById("map-full"), { 
            zoom: 12, 
            center: { lat: -23.5505, lng: -46.6333 }, 
            disableDefaultUI: true,
            styles: [
                { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] }
            ]
        });
    }

    // Navegação Sidebar
    function showPage(id, el) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        el.classList.add('active');
    }

    // Toggles de Acessibilidade
    function toggleDark() { document.body.classList.toggle('dark'); }
    function toggleContrast() { document.body.classList.toggle('high-contrast'); }
    function toggleFonts() { document.body.classList.toggle('large-fonts'); }

    // Função IA Antifraude
    async function analisarVeiculoBanco() {
        const remessaId = document.getElementById('select-remessa-af').value;
        
        if (!remessaId) {
            alert("Por favor, selecione uma remessa para analisar.");
            return;
        }

        // Feedback de carregamento
        document.getElementById("af-mensagem").innerText = "Processando...";
        document.getElementById("af-mensagem").style.color = "var(--text-muted)";

        try {
            let res = await fetch(`/ia-antifraude/${remessaId}`);
            let data = await res.json();

            document.getElementById("af-tempo").innerText = data.tempo_parado + " min";
            document.getElementById("af-velocidade").innerText = data.velocidade + " km/h";
            document.getElementById("af-rota").innerText = data.desvio_rota ? "Sim" : "Não";
            document.getElementById("af-mensagem").innerText = data.mensagem;
            document.getElementById("af-mensagem").style.color = "var(--text-main)";

            // Alerta visual
            let statusBox = document.getElementById("status-af-alerta");
            let config = {
                baixo: { icon: "🟢", bg: 'rgba(16, 185, 129, 0.15)', text: 'var(--alert-success)', label: 'Baixo' },
                medio: { icon: "🟡", bg: 'rgba(245, 158, 11, 0.15)', text: 'var(--alert-warning)', label: 'Médio' },
                alto:  { icon: "🔴", bg: 'rgba(239, 68, 68, 0.15)', text: 'var(--alert-danger)', label: 'Alto' }
            };

            const r = config[data.risco] || config.baixo;
            
            statusBox.style.display = "flex";
            statusBox.style.backgroundColor = r.bg;
            statusBox.style.color = r.text;
            statusBox.innerHTML = `${r.icon} <span><strong>RISCO ${r.label.toUpperCase()}:</strong> ${data.detalhes_ia}</span>`;

        } catch (e) {
            console.error("Erro na integração:", e);
            document.getElementById("af-mensagem").innerText = "Falha ao conectar.";
            document.getElementById("af-mensagem").style.color = "var(--alert-danger)";
        }
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=SUA_API_KEY&callback=initMap"></script>
</body>
</html>