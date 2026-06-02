<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync | Dashboard Cliente</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <link href="https://fonts.googleapis.com/css2=family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
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
            
            --radius-lg: 16px; 
            --radius-md: 10px; 
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-hover: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            
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

        /* REGRAS ESTRUTURAIS PARA ALTO CONTRASTE ACESSÍVEL */
        body.alto-contraste {
            --bg: #000000 !important;
            --card: #000000 !important;
            --text-main: #ffff00 !important; /* Texto Amarelo */
            --text-muted: #ffffff !important;
            --border: #ffff00 !important;
            --input-bg: #000000 !important;
            --sidebar: #000000 !important;
            --primary: #ffff00 !important;
            --primary-hover: #ffffff !important;
        }

        body.alto-contraste .content-card, 
        body.alto-contraste .sidebar,
        body.alto-contraste .stat-card,
        body.alto-contraste .page {
            background: #000000 !important;
            color: #ffff00 !important;
            border: 2px solid #ffff00 !important;
        }

        body.alto-contraste input, 
        body.alto-contraste select, 
        body.alto-contraste textarea {
            background: #000000 !important;
            color: #ffffff !important;
            border: 2px solid #ffff00 !important;
        }

        body.alto-contraste .btn-salvar,
        body.alto-contraste button[type="submit"] {
            background: #ffff00 !important;
            color: #000000 !important;
            font-weight: 900 !important;
            border: 2px solid #ffffff !important;
        }

        body.alto-contraste .nav-link {
            color: #ffffff !important;
        }
        body.alto-contraste .nav-link.active {
            border: 2px solid #ffff00 !important;
            background: #000000 !important;
            color: #ffff00 !important;
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

        .layout { display: flex; min-height: 100vh; }

        .sidebar { 
            width: 280px; 
            height: 100vh; 
            position: fixed; 
            left: 0; 
            top: 0; 
            padding: 24px 18px; 
            display: flex; 
            flex-direction: column; 
            background: rgba(15,23,42,.97); 
            backdrop-filter: blur(18px); 
            -webkit-backdrop-filter: blur(18px); 
            border-right: 1px solid rgba(255,255,255,.05); 
            transition: .3s; 
            z-index: 1000;
        }
        .logo { display: flex; align-items: center; gap: 12px; color: #fff; font-size: 1.4rem; font-weight: 800; margin-bottom: 24px; text-decoration: none; }
        .logo img { width: 42px; }
        .user-card { display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: 14px; margin-bottom: 20px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.05); }
        .user-card img { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
        .user-info strong { display: block; color: #fff; font-size: .9rem; }
        .user-info small { color: #94a3b8; font-size: .75rem; }
        .collapse-btn { background: rgba(255,255,255,.05); border: none; color: #fff; width: 100%; padding: 12px; border-radius: 12px; cursor: pointer; margin-bottom: 18px; transition: .3s; }
        .collapse-btn:hover { background: rgba(255,255,255,.08); }
        .menu-title { color: #475569; font-size: .72rem; font-weight: 700; letter-spacing: 1px; padding: 14px 12px 8px; }
        .nav-link { display: flex; align-items: center; gap: 14px; color: #94a3b8; text-decoration: none; padding: 13px 16px; border-radius: 14px; margin-bottom: 6px; cursor: pointer; transition: .25s; position: relative; font-weight: 600; }
        .nav-link i { width: 20px; text-align: center; font-size: 1rem; }
        .nav-link:hover { background: rgba(255,255,255,.05); color: #fff; transform: translateX(4px); }
        .nav-link.active { background: rgba(37,99,235,.18); color: #fff; }
        .sidebar-status { margin-top: auto; margin-bottom: 12px; padding: 14px; border-radius: 12px; background: rgba(16,185,129,.12); color: #10b981; font-size: .85rem; font-weight: 600; text-align: center; }
        .online-dot { width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; margin-right: 8px; box-shadow: 0 0 10px #10b981; }
        .logout-link { color: #ef4444; }
        .logout-link:hover { background: rgba(239,68,68,.1); color: #fff; }

        .main-content { flex: 1; margin-left: 280px; padding: 2rem 2.5rem; transition: margin-left 0.3s; }
        .content-card { background: var(--card); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--shadow-md); border: 1px solid var(--border); margin-bottom: 1.5rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: var(--card); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow-sm); }
        .stat-card h4 { color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.25rem; font-weight: 600; }
        .stat-card h2 { font-size: 1.8rem; font-weight: 800; }
        .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }

        .table-res { overflow-x: auto; margin-top: 1rem; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 800px; }
        th { text-align: left; padding: 14px 16px; color: var(--text-muted); border-bottom: 2px solid var(--border); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-weight: 500; }
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
        .entregue { background: rgba(16, 185, 129, 0.15); color: var(--alert-success); }
        .transito { background: rgba(59, 130, 246, 0.15); color: var(--alert-info); }
        .atrasado { background: rgba(239, 68, 68, 0.15); color: var(--alert-danger); }

        .btn-salvar { background: var(--primary); color: white; border: none; padding: 12px 24px; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-salvar:hover { background: var(--primary-hover); }
        
        label { display: block; margin-bottom: 6px; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 10px; }
        input, select, textarea { width: 100%; padding: 12px 14px; border-radius: var(--radius-md); border: 1px solid var(--border); background: var(--input-bg); color: var(--text-main); margin-bottom: 16px; }

        .page { display: none; }
        .page.active { display: block; animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .toggle-item { display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px solid var(--border); }
        .toggle-item input[type="checkbox"] { width: 20px; height: 20px; cursor: pointer; margin-bottom: 0; }

        body.sidebar-collapsed .sidebar { width: 90px; }
        body.sidebar-collapsed .main-content { margin-left: 90px; }
        body.sidebar-collapsed .logo span, body.sidebar-collapsed .user-info, body.sidebar-collapsed .menu-title, body.sidebar-collapsed .nav-link span, body.sidebar-collapsed .sidebar-status { display: none; }
        body.sidebar-collapsed .nav-link, body.sidebar-collapsed .user-card, body.sidebar-collapsed .logo { justify-content: center; }

        @media(max-width:768px){
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0 !important; }
            .sidebar nav { display: flex; overflow-x: auto; gap: 8px; }
            .menu-title { display: none; }
            .nav-link { white-space: nowrap; }
            .charts-grid { grid-template-columns: 1fr; }
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            background: #2563eb;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7);
            animation: pulse 1.5s infinite;
            vertical-align: middle;
            margin-right: 6px;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(37, 99, 235, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
        }
    </style>
</head>
<body class="{{ Auth::user()->dark_mode ? 'dark' : '' }}">

<div class="layout">
    <aside class="sidebar">
        <a href="/" class="logo">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo">
            <span>GeoSync</span>
        </a>

        <div class="user-card">
            <img id="sidebarFoto" src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2563eb&color=fff' }}" alt="Perfil">
            <div class="user-info">
                <strong>{{ Auth::user()->name }}</strong>
                <small>{{ ucfirst(Auth::user()->tipo) }}</small>
            </div>
        </div>

        <button class="collapse-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <nav>
            <div class="menu-title">CLIENTE</div>
            <div class="nav-link active" onclick="showPage('dashboard', this)">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </div>
            <div class="nav-link" onclick="showPage('remessas', this)">
                <i class="fas fa-box"></i>
                <span>Minhas Remessas</span>
            </div>
            <div class="nav-link" onclick="showPage('localizacao-page', this)">
                <i class="fas fa-map-location-dot"></i>
                <span>Localização</span>
            </div>
            <div class="nav-link" onclick="showPage('alertas-page', this)">
                <i class="fas fa-bell"></i>
                <span>Alertas</span>
            </div>
            <div class="nav-link" onclick="showPage('config', this)">
                <i class="fas fa-user-gear"></i>
                <span>Configurações</span>
            </div>
        </nav>

        <div class="sidebar-status">
            <span class="online-dot"></span><span>Sistema Online</span>
        </div>

        <a href="/logout" class="nav-link logout-link">
            <i class="fas fa-power-off"></i><span>Sair</span>
        </a>
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
            <h1>Rastreamento em Tempo Real</h1>
            <div class="content-card">
                <div style="margin-bottom: 20px;">
                    <label for="selectRastreioCliente">
                        <i class="fas fa-search-location"></i> Escolha a Encomenda para Rastrear:
                    </label>
                    <select id="selectRastreioCliente" onchange="alterarRemessaRastreio(this.value)">
                        <option value="" disabled selected>-- Selecione um código de rastreio --</option>
                        @foreach($remessas as $r)
                            <option value="{{ $r->codigo_rastreio }}" 
                                    data-lat="{{ $r->latitude ?? -14.2350 }}" 
                                    data-lon="{{ $r->longitude ?? -51.9253 }}"
                                    data-status="{{ $r->status }}">
                                #{{ $r->codigo_rastreio }} (De: {{ $r->origem }} Para: {{ $r->destino }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div>
                        <span class="pulse-dot"></span>
                        <span style="font-weight: 700; color: var(--text-muted)">Rastreamento em Tempo Real</span>
                    </div>
                    <span id="statusPedidoCliente" class="badge transito">Aguardando Seleção</span>
                </div>

                <div id="mapa" class="map-container" style="width: 100%; height: 400px; border-radius: 12px; z-index: 1;"></div>
            </div>
        </section>

        <section id="remessas" class="page">
            <div class="content-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <h2>Minhas Remessas</h2>
                    <a href="{{ route('remessas.create') }}" class="btn-salvar">
                        <i class="fas fa-plus"></i> Nova Remessa
                    </a>
                </div>
                <div class="table-res">
                    <table>
                        <thead>
                            <tr>
                                <th>Rastreio</th>
                                <th>Origem</th>
                                <th>Destino</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remessas as $r)
                            <tr>
                                <td>#{{ $r->codigo_rastreio }}</td>
                                <td>{{ $r->origem }}</td>
                                <td>{{ $r->destino }}</td>
                                <td>
                                    <span class="badge {{ $r->status == 'Entregue' ? 'entregue' : ($r->status == 'Atrasado' ? 'atrasado' : 'transito') }}">
                                        {{ $r->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('remessas.show', $r->id) }}" style="color: var(--primary)">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="alertas-page" class="page">
            <h1>Alertas de Segurança</h1>
            <div class="content-card">
                @forelse($alertas as $a)
                <div style="padding:15px; margin-bottom:10px; border-left:4px solid #ef4444; background:var(--input-bg); border-radius:4px;">
                    <strong>{{ $a->tipo }}</strong>
                    <p>{{ $a->mensagem }}</p>
                    <small style="color: var(--text-muted)">{{ $a->created_at ? $a->created_at->format('d/m/Y H:i') : 'Agora mesmo' }}</small>
                </div>
                @empty
                <p>Nenhum alerta crítico detetado no momento.</p>
                @endforelse
            </div>
        </section>

        <section id="config" class="page">
            <h1 style="margin-bottom: 1.5rem;">Configurações do Sistema</h1>
            <div class="charts-grid" style="grid-template-columns: 2fr 1fr;">
                
                <div class="content-card">
                    <h3>Perfil do Usuário</h3>
                    <form action="/configuracoes/atualizar" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px; background: var(--input-bg); padding: 15px; border-radius: var(--radius-md);">
                            <div style="position: relative;">
                                <img id="previewFoto" src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : 'https://via.placeholder.com/100' }}" 
                                     style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary);">
                                <label for="inputFoto" style="position: absolute; bottom: 0; right: 0; background: var(--primary); color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; margin-top:0;">
                                    <i class="fas fa-camera" style="font-size: 12px;"></i>
                                </label>
                            </div>
                            <input type="file" id="inputFoto" name="foto" accept="image/*" style="display: none;" onchange="previewImagem(this)">
                            <div>
                                <h4 style="margin-bottom: 4px;">Foto de Perfil</h4>
                                <small style="color: var(--text-muted)">Selecione arquivos JPG ou PNG de até 2MB.</small>
                            </div>
                        </div>

                        <label>Nome Completo</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required>
                        
                        <label>E-mail Corporativo</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required>

                        <label>Telefone / WhatsApp</label>
                        <input type="text" name="telefone" value="{{ Auth::user()->telefone ?? '' }}">

                        <div style="border-top: 1px solid var(--border); margin-top: 25px; padding-top: 20px;">
                            <h4 style="margin-bottom: 15px;"><i class="fas fa-lock"></i> Alterar Senha de Acesso</h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div>
                                    <label>Nova Senha</label>
                                    <input type="password" name="password" placeholder="Mínimo 6 caracteres">
                                </div>
                                <div>
                                    <label>Confirmar Nova Senha</label>
                                    <input type="password" name="password_confirmation" placeholder="Repita a nova senha">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-salvar" style="margin-top: 15px;"><i class="fas fa-save"></i> Gravar Alterações</button>
                    </form>
                </div>

                <div class="content-card" style="display: flex; flex-direction: column; gap: 20px;">
                    <h3>Visual e Acessibilidade</h3>
                    
                    <div class="toggle-item">
                        <span><i class="fas fa-moon"></i> Modo Escuro</span>
                        <input type="checkbox" id="darkToggle" onchange="toggleDark()" {{ Auth::user()->dark_mode ? 'checked' : '' }}>
                    </div>

                    <div class="toggle-item">
                        <span><i class="fas fa-circle-half-stroke"></i> Alto Contraste</span>
                        <input type="checkbox" id="altoContrasteToggle" onchange="toggleAltoContraste()">
                    </div>

                    <div>
                        <label style="font-weight: 600; margin-bottom: 10px; display: block;"><i class="fas fa-text-height"></i> Tamanho do Texto</label>
                        <div style="display: flex; gap: 8px;">
                            <button onclick="alterarFonte('diminuir')" style="flex: 1; padding: 10px; background: var(--input-bg); border: 1px solid var(--border); color: var(--text-main); border-radius: 6px; font-weight: bold; cursor: pointer;"><i class="fas fa-minus"></i> A-</button>
                            <button onclick="alterarFonte('normal')" style="flex: 1; padding: 10px; background: var(--input-bg); border: 1px solid var(--border); color: var(--text-main); border-radius: 6px; font-weight: bold; cursor: pointer;">Padrão</button>
                            <button onclick="alterarFonte('aumentar')" style="flex: 1; padding: 10px; background: var(--input-bg); border: 1px solid var(--border); color: var(--text-main); border-radius: 6px; font-weight: bold; cursor: pointer;"><i class="fas fa-plus"></i> A+</button>
                        </div>
                    </div>

                    <div style="background: rgba(37,99,235,0.06); padding: 12px; border-radius: var(--radius-md); font-size: 0.8rem; border: 1px dashed var(--primary);">
                        <i class="fas fa-info-circle"></i> O assistente de tradução de Libras (VLibras) está ativo no canto inferior direito da sua tela.
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
    Swal.fire({ icon: 'success', title: 'Sucesso!', text: @json(session('success')) });
</script>
@endif

<script>
    // CONTROLES DE INTERFACE DO DASHBOARD
    function toggleSidebar() { document.body.classList.toggle('sidebar-collapsed'); }
    
    function toggleDark() { 
        document.body.classList.toggle('dark');
        // Mantém o checkbox sincronizado caso mude de abas
        const dkBtn = document.getElementById('darkToggle');
        if(dkBtn) dkBtn.checked = document.body.classList.contains('dark');
    }

    // ALTERNAR PÁGINAS COM AJUSTE DE TAMANHO DO MAPA (SOLUÇÃO DO MAPA CINZA)
    function showPage(id, el) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        
        const paginaAlvo = document.getElementById(id);
        if (paginaAlvo) paginaAlvo.classList.add('active');
        if (el) el.classList.add('active');

        // SOLUÇÃO DO MAPA CINZENTO UNIVERSAL: Força o Leaflet a recalcular as dimensões da div visível
        if (typeof mapa !== 'undefined' && mapa) {
            mapa.invalidateSize();
            
            setTimeout(() => {
                mapa.invalidateSize();
                if (typeof marcador !== 'undefined' && marcador) {
                    mapa.panTo(marcador.getLatLng());
                }
            }, 300);
        }
    }

    // CONFIGURAÇÃO DOS GRÁFICOS (CHART.JS)
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';

    new Chart(document.getElementById('chartLinha'), {
        type: 'line',
        data: { 
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana Atual'], 
            datasets: [{ 
                label: 'Entregas', 
                data: [12, 19, 15, {{ $entregues ?? 0 }}], 
                borderColor: '#2563eb', 
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 3, fill: true, tension: 0.4 
            }] 
        }
    });

    new Chart(document.getElementById('chartPizza'), {
        type: 'doughnut',
        data: { 
            labels: ['Em Rota', 'Entregues', 'Atrasadas'], 
            datasets: [{ 
                data: [{{ $transito ?? 0 }}, {{ $entregues ?? 0 }}, {{ $atrasadas ?? 0 }}], 
                backgroundColor: ['#3b82f6', '#10b981', '#ef4444'], borderWidth: 0
            }] 
        },
        options: { cutout: '70%' }
    });


    // LÓGICA DE RASTREAMENTO MAPA DO CLIENTE
    let mapa, marcador; 
    let intervaloRastreio = null;   
    let codigoRastreioAtivo = "";   

    const latPadraoSp = -23.55052;
    const lonPadraoSp = -46.63330;

    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById('mapa')) {
            // Inicializa diretamente focado no ponto urbano operacional correto
            mapa = L.map('mapa').setView([latPadraoSp, lonPadraoSp], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapa);
            
            marcador = L.marker([latPadraoSp, lonPadraoSp]).addTo(mapa);
            marcador.bindPopup("<b>Selecione uma encomenda para iniciar o rastreio.</b>").openPopup();

            const selectRastreio = document.getElementById('selectRastreioCliente');
            if (selectRastreio && selectRastreio.value) {
                alterarRemessaRastreio(selectRastreio.value);
            }
        }

        // Recupera estado salvo do Alto Contraste
        if (localStorage.getItem('altoContraste') === 'ativado') {
            document.body.classList.add('alto-contraste');
            const acBtn = document.getElementById('altoContrasteToggle');
            if(acBtn) acBtn.checked = true;
        }
    });

    function alterarRemessaRastreio(codigo) {
        if (!codigo) return;
        codigoRastreioAtivo = codigo;

        if (intervaloRastreio) clearInterval(intervaloRastreio);
        
        atualizarRastreioEmTempoReal();
        intervaloRastreio = setInterval(atualizarRastreioEmTempoReal, 5000); // Consulta a cada 5 segundos
    }

    function atualizarRastreioEmTempoReal() {
        if (!codigoRastreioAtivo) return;

        fetch(`/api/rastreio/${codigoRastreioAtivo}`)
            .then(response => response.json())
            .then(data => {
                if (data.latitude && data.longitude) {
                    const novaLat = parseFloat(data.latitude);
                    const novaLon = parseFloat(data.longitude);

                    marcador.setLatLng([novaLat, novaLon]);
                    marcador.setPopupContent(`<b>Motorista com a Carga: #${codigoRastreioAtivo}</b>`);
                    marcador.openPopup();
                    
                    mapa.panTo([novaLat, novaLon]);
                    
                    const statusPedido = document.getElementById('statusPedidoCliente');
                    if (statusPedido && data.status) {
                        statusPedido.textContent = data.status;
                    }
                }
            })
            .catch(error => console.error("Erro ao sincronizar localização com o servidor:", error));
    }

    // JAVASCRIPT EXCLUSIVO: FUNÇÕES DE CONFIGURAÇÕES E ACESSIBILIDADE
    
    // Preview da Imagem de Upload em Tempo Real
    function previewImagem(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Atualiza a foto tanto no formulário de edição quanto no card lateral da sidebar
                document.getElementById('previewFoto').src = e.target.result;
                document.getElementById('sidebarFoto').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Alteração de Tamanho Proporcional do Texto
    let tamanhoFonteAtual = 100;
    function alterarFonte(acao) {
        if (acao === 'aumentar' && tamanhoFonteAtual < 130) {
            tamanhoFonteAtual += 10;
        } else if (acao === 'diminuir' && tamanhoFonteAtual > 85) {
            tamanhoFonteAtual -= 10;
        } else if (acao === 'normal') {
            tamanhoFonteAtual = 100;
        }
        document.body.style.fontSize = tamanhoFonteAtual + '%';
    }

    // Toggle de Alto Contraste com armazenamento local
    function toggleAltoContraste() {
        document.body.classList.toggle('alto-contraste');
        
        if (document.body.classList.contains('alto-contraste')) {
            localStorage.setItem('altoContraste', 'ativado');
        } else {
            localStorage.setItem('altoContraste', 'desativado');
        }
    }
</script>
</body>
</html>