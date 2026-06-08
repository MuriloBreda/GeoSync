<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync | Dashboard Motorista</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- INCLUSÃO DO LEAFLET (MAPA GRATUITO) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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

        /* ALTO CONTRASTE */
body.alto-contraste {
    --bg: #000000 !important;
    --card: #000000 !important;
    --text-main: #ffff00 !important;
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
    background: #000000 !important;
    color: #ffff00 !important;
    border: 2px solid #ffff00 !important;
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
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
        .entregue { background: rgba(16, 185, 129, 0.15); color: var(--alert-success); }
        .transito { background: rgba(59, 130, 246, 0.15); color: var(--alert-info); }
        .atrasado { background: rgba(239, 68, 68, 0.15); color: var(--alert-danger); }

        .btn-salvar { background: var(--primary); color: white; border: none; padding: 12px 24px; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-salvar:hover { background: var(--primary-hover); }
        
        label { display: block; margin-bottom: 6px; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); margin-top: 10px; }
        input, select, textarea { width: 100%; padding: 12px 14px; border-radius: var(--radius-md); border: 1px solid var(--border); background: var(--input-bg); color: var(--text-main); margin-bottom: 16px; font-family: inherit; }

        .page { display: none; }
        .page.active { display: block; animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .toggle-item { display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px solid var(--border); }
        .toggle-item input { width: 20px; height: 20px; cursor: pointer; }

        body.sidebar-collapsed .sidebar { width: 90px; }
        body.sidebar-collapsed .main-content { margin-left: 90px; }
        body.sidebar-collapsed .logo span, body.sidebar-collapsed .user-info, body.sidebar-collapsed .menu-title, body.sidebar-collapsed .nav-link span, body.sidebar-collapsed .sidebar-status { display: none; }
        body.sidebar-collapsed .nav-link, body.sidebar-collapsed .user-card, body.sidebar-collapsed .logo { justify-content: center; }

        /* Ajuste do container para renderizar o Leaflet perfeitamente */
        .map-container {
            width: 100%;
            height: 450px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        @media(max-width:768px){
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0 !important; }
            .sidebar nav { display: flex; overflow-x: auto; gap: 8px; }
            .menu-title { display: none; }
            .nav-link { white-space: nowrap; }
            .charts-grid { grid-template-columns: 1fr; }
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
            <div class="menu-title">MOTORISTA</div>
            <div class="nav-link active" onclick="showPage('overview', this)">
                <i class="fas fa-route"></i>
                <span>Minhas Viagens</span>
            </div>
            <div class="nav-link" onclick="showPage('localizacao', this)">
                <i class="fas fa-map-location-dot"></i>
                <span>Localização</span>
            </div>
            <div class="nav-link" onclick="showPage('status-page', this)">
                <i class="fas fa-pen-to-square"></i>
                <span>Atualizar Status</span>
            </div>
            <div class="nav-link" onclick="showPage('criar-alerta-page', this)">
                <i class="fas fa-triangle-exclamation"></i>
                <span>Emitir Alerta</span>
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
        <section id="overview" class="page active">
            <h1 style="margin-bottom: 1.5rem;">Minhas Viagens Atribuídas</h1>
            <div class="stats-grid">
                <div class="stat-card">
                    <div><h4>Total Atribuído</h4><h2>{{ $total }}</h2></div>
                    <i class="fas fa-boxes-stacked" style="color: var(--text-muted)"></i>
                </div>
                <div class="stat-card">
                    <div><h4>Em Rota</h4><h2 style="color: var(--alert-info)">{{ $transito }}</h2></div>
                    <i class="fas fa-truck-fast" style="color: var(--alert-info); opacity: 0.3;"></i>
                </div>
            </div>
            <div class="content-card">
                <div class="table-res">
                    <table>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Origem</th>
                                <th>Destino</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remessas as $r)
                            <tr>
                                <td>#{{ $r->codigo_rastreio }}</td>
                                <td>{{ $r->origem }}</td>
                                <td>{{ $r->destino }}</td>
                                <td>
                                    @if($r->status == 'Entregue')
                                        <span class="badge entregue">
                                            <i class="fas fa-circle-check"></i> {{ $r->status }}
                                        </span>
                                    @elseif($r->status == 'Atrasado')
                                        <span class="badge atrasado">
                                            <i class="fas fa-circle-exclamation"></i> {{ $r->status }}
                                        </span>
                                    @else
                                        <span class="badge transito">
                                            <i class="fas fa-truck-fast"></i> {{ $r->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="localizacao" class="page">
            <h1 style="margin-bottom: 1.5rem;">Rastreamento e Localização em Tempo Real</h1>
            <div class="content-card">
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                    As cargas agora são direcionadas automaticamente para o seu perfil. Utilize esta tela para acompanhar sua rota e atualizar sua geolocalização no sistema.
                </p>
                
                <!-- CONTAINER ONDE O LEAFLET VAI INJETAR O MAPA -->
                <div class="map-container" id="mapaBox"></div>

                <div style="margin-top: 1.5rem; display: flex; gap: 12px; flex-wrap: wrap;">
                    <button class="btn-salvar" onclick="obterLocalizacaoAtual()">
                        <i class="fas fa-location-crosshairs"></i> Sincronizar Minha Posição Atual
                    </button>
                    <span id="geoStatus" style="align-self: center; font-weight: 600; color: var(--text-muted);"></span>
                </div>
            </div>
        </section>

        <section id="status-page" class="page">
            <h1 style="margin-bottom: 1.5rem;">Atualizar Estado da Entrega</h1>
            <div class="content-card" style="max-width: 600px;">
                <form id="formAtualizarStatus" action="{{ route('motorista.status') }}" method="POST">
                    @csrf
                    
                    <label>Selecione a Remessa</label>
                    <select name="remessa_id" id="selectRemessa" required>
                        <option value="">-- Escolha uma viagem ativa --</option>
                        @foreach($minhasRemessas as $mr)
                        <option value="{{ $mr->id }}">#{{ $mr->codigo_rastreio }} - de {{ $mr->origem }} para {{ $mr->destino }}</option>
                        @endforeach
                    </select>

                    <label>Novo Status</label>
                    <select name="status" required>
                        <option value="Em Rota">Em Rota</option>
                        <option value="Entregue">Entregue</option>
                        <option value="Atrasado">Atrasado</option>
                    </select>

                    <button type="submit" class="btn-salvar" style="margin-top:10px;">
                        <i class="fas fa-sync"></i> Atualizar Status
                    </button>
                </form>
            </div>
        </section>

        <section id="criar-alerta-page" class="page">
            <h1 style="margin-bottom: 1.5rem;">Emitir Alerta de Ocorrência</h1>
            <div class="content-card" style="max-width: 600px;">
                <form action="{{ route('alertas.store') }}" method="POST">
                    @csrf
                    <label>Selecione a Remessa Vinculada</label>
                    <select name="remessa_id" required>
                        <option value="">-- Escolha a viagem do incidente --</option>
                        @foreach($minhasRemessas as $mr)
                        <option value="{{ $mr->id }}">#{{ $mr->codigo_rastreio }} - para {{ $mr->destino }}</option>
                        @endforeach
                    </select>

                    <label>Tipo de Ocorrência</label>
                    <select name="tipo" required>
                        <option value="Acidente na pista">Acidente na pista</option>
                        <option value="Problema mecânico">Problema mecânico</option>
                        <option value="Condições climáticas ruins">Condições climáticas ruins</option>
                        <option value="Suspeita de sinistro / Perigo">Suspeita de sinistro / Perigo</option>
                        <option value="Outro atraso logístico">Outro atraso logístico</option>
                    </select>

                    <label>Detalhes da Mensagem</label>
                    <textarea name="mensagem" rows="4" placeholder="Descreva brevemente o que aconteceu..." required></textarea>

                    <button type="submit" class="btn-salvar" style="margin-top:10px;">
                        <i class="fas fa-paper-plane"></i> Enviar Alerta Crítico
                    </button>
                </form>
            </div>
        </section>

        <section id="config" class="page">
    <h1 style="margin-bottom: 1.5rem;">Configurações do Sistema</h1>

    <div class="charts-grid" style="grid-template-columns: 2fr 1fr;">

        <!-- PERFIL -->
        <div class="content-card">
            <h3>Perfil do Motorista</h3>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="display:flex;gap:20px;align-items:center;margin-bottom:20px;background:var(--input-bg);padding:15px;border-radius:var(--radius-md);">

                    <div style="position:relative;">
                        <img id="previewFoto"
                             src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2563eb&color=fff' }}"
                             style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid var(--primary);">

                        <label for="inputFoto"
                               style="position:absolute;bottom:0;right:0;background:var(--primary);color:#fff;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;margin-top:0;">
                            <i class="fas fa-camera"></i>
                        </label>
                    </div>

                    <input type="file"
                           id="inputFoto"
                           name="foto"
                           accept="image/*"
                           style="display:none"
                           onchange="previewImagem(this)">

                    <div>
                        <h4>Foto de Perfil</h4>
                        <small style="color:var(--text-muted)">
                            JPG ou PNG até 2MB
                        </small>
                    </div>
                </div>

                <label>Nome Completo</label>
                <input type="text"
                       name="name"
                       value="{{ Auth::user()->name }}"
                       required>

                <label>E-mail</label>
                <input type="email"
                       name="email"
                       value="{{ Auth::user()->email }}"
                       required>

                <label>Telefone</label>
                <input type="text"
                       name="telefone"
                       value="{{ Auth::user()->telefone ?? '' }}">

                <div style="border-top:1px solid var(--border);margin-top:25px;padding-top:20px;">
                    <h4 style="margin-bottom:15px;">
                        <i class="fas fa-lock"></i>
                        Alterar Senha
                    </h4>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
                        <div>
                            <label>Nova Senha</label>
                            <input type="password"
                                   name="password"
                                   placeholder="Minimo 6 caracteres">
                        </div>

                        <div>
                            <label>Confirmar Senha</label>
                            <input type="password"
                                   name="password_confirmation">
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="btn-salvar"
                        style="margin-top:15px;">
                    <i class="fas fa-save"></i>
                    Salvar Alterações
                </button>

            </form>
        </div>

        <!-- ACESSIBILIDADE -->
        <div class="content-card">
            <h3>Visual e Acessibilidade</h3>

            <div class="toggle-item">
                <span>
                    <i class="fas fa-moon"></i>
                    Modo Escuro
                </span>

                <input type="checkbox"
                       id="darkToggle"
                       onchange="toggleDark()"
                       {{ Auth::user()->dark_mode ? 'checked' : '' }}>
            </div>

            <div class="toggle-item">
                <span>
                    <i class="fas fa-circle-half-stroke"></i>
                    Alto Contraste
                </span>

                <input type="checkbox"
                       id="altoContrasteToggle"
                       onchange="toggleAltoContraste()">
            </div>

            <div style="margin-top:20px;">
                <label style="font-weight:600;">
                    <i class="fas fa-text-height"></i>
                    Tamanho do Texto
                </label>

                <div style="display:flex;gap:8px;margin-top:10px;">
                    <button type="button"
                            onclick="alterarFonte('diminuir')"
                            style="flex:1;padding:10px;background:var(--input-bg);border:1px solid var(--border);border-radius:6px;cursor:pointer;">
                        A-
                    </button>

                    <button type="button"
                            onclick="alterarFonte('normal')"
                            style="flex:1;padding:10px;background:var(--input-bg);border:1px solid var(--border);border-radius:6px;cursor:pointer;">
                        Normal
                    </button>

                    <button type="button"
                            onclick="alterarFonte('aumentar')"
                            style="flex:1;padding:10px;background:var(--input-bg);border:1px solid var(--border);border-radius:6px;cursor:pointer;">
                        A+
                    </button>
                </div>
            </div>

            <div style="background:rgba(37,99,235,.08);
                        padding:12px;
                        border-radius:10px;
                        margin-top:20px;
                        border:1px dashed var(--primary);">

                <i class="fas fa-info-circle"></i>
                Recursos de acessibilidade disponíveis para facilitar a navegação.
            </div>
        </div>

    </div>
</section>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Sucesso!', text: @json(session('success')) });
</script>
@endif

<script>
    function toggleSidebar() { document.body.classList.toggle('sidebar-collapsed'); }
    
    // Variáveis globais do mapa para controle do Leaflet
    let mapa, marcador;

    function showPage(id, el) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        el.classList.add('active');

        // Correção crucial para o Leaflet recalcular o tamanho correto do mapa ao mudar de aba oculta
        if (id === 'localizacao' && mapa) {
            setTimeout(() => {
                mapa.invalidateSize();
            }, 200);
        }
    }
    
    function toggleDark() { document.body.classList.toggle('dark'); }

    // Inicialização do Mapa Leaflet
    document.addEventListener("DOMContentLoaded", function() {
        // Inicia o mapa mirando no centro do Brasil por padrão [Latitude, Longitude], Zoom
        mapa = L.map('mapaBox').setView([-14.2350, -51.9253], 4);

        // Adiciona as "Telhas" (Tiles) visuais do OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapa);
    });

    // Função que captura o GPS real do dispositivo e plota no mapa
    function obterLocalizacaoAtual() {
    const statusSpan = document.getElementById('geoStatus');
    statusSpan.style.color = 'var(--alert-info)';
    statusSpan.textContent = "Buscando satélites GPS...";

    navigator.geolocation.getCurrentPosition(
        (position) => {
            configurarMarcadorMapa(position.coords.latitude, position.coords.longitude);
        },
        (error) => {
            // SE DER ERRO DE PERMISSÃO, ELE USA COORDENADAS DE TESTE (MOCK) PARA VOCÊ NÃO FICAR TRAVADO
            console.warn("GPS Real bloqueado. Usando coordenadas simuladas de teste.");
            
            const latSimulada = -23.55052; // Coordenada simulada (Ex: São Paulo)
            const lonSimulada = -46.63330;
            
            configurarMarcadorMapa(latSimulada, lonSimulada);
        },
        { enableHighAccuracy: true }
    );
}

// Procure a função do clique do botão azul no seu serviceMotorista.blade.php
function sincronizarPosicaoMotorista() {
    // Coordenadas exatas da barra verde de São Paulo
    const latSimulada = -23.55052;
    const lonSimulada = -46.63330;
    
    // IMPORTANTE: Aqui deve ser o código de rastreio (999999) 
    // Você pode colocar fixo para testar, ou puxar do seu Blade: "{{ $remessa->codigo_rastreio ?? '999999' }}"
    const codigoPacote = "999999"; 

    // Atualiza o mapa do motorista na hora
    if (typeof marcador !== 'undefined' && marcador) {
        marcador.setLatLng([latSimulada, lonSimulada]);
    } else {
        marcador = L.marker([latSimulada, lonSimulada]).addTo(mapa);
    }
    mapa.setView([latSimulada, lonSimulada], 16);

    // Envia para o servidor usando a nova estrutura
    fetch('/motorista/atualizar-coordenadas', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            codigo_rastreio: codigoPacote, // Enviando o código correto
            latitude: latSimulada,
            longitude: lonSimulada
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Servidor respondeu:", data);
    })
    .catch(error => {
        console.error("Erro ao sincronizar:", error);
    });
}

// Isolamos a lógica que move o mapa em uma função própria para reaproveitar
function configurarMarcadorMapa(lat, lon) {
    const statusSpan = document.getElementById('geoStatus');
    statusSpan.style.color = 'var(--alert-success)';
    statusSpan.innerHTML = `<i class="fas fa-circle-check"></i> Sincronizado (Simulado)! Lat: ${lat.toFixed(5)} | Lon: ${lon.toFixed(5)}`;
    
    if (marcador) {
        marcador.setLatLng([lat, lon]);
    } else {
        marcador = L.marker([lat, lon]).addTo(mapa);
    }

    mapa.setView([lat, lon], 16);
    marcador.bindPopup("<b>Motorista</b><br>Posição atualizada.").openPopup();
}

function previewImagem(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('previewFoto').src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

let tamanhoFonteAtual = 100;

function alterarFonte(acao) {

    if (acao === 'aumentar' && tamanhoFonteAtual < 130) {
        tamanhoFonteAtual += 10;
    }

    if (acao === 'diminuir' && tamanhoFonteAtual > 85) {
        tamanhoFonteAtual -= 10;
    }

    if (acao === 'normal') {
        tamanhoFonteAtual = 100;
    }

    document.body.style.fontSize = tamanhoFonteAtual + '%';
}

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