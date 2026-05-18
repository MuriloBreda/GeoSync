<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync | Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #2563eb; --bg: #f8fafc; --sidebar: #0f172a; --card: #ffffff;
            --text-main: #1e293b; --text-muted: #64748b; --border: #e2e8f0;
            --radius-lg: 20px; --radius-md: 12px; --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            --alert-danger: #ef4444; --alert-warning: #f59e0b; --alert-info: #3b82f6;
        }

        body.dark { --bg: #0b0f1a; --card: #161e2d; --text-main: #f1f5f9; --text-muted: #94a3b8; --border: #2d3748; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text-main); transition: 0.3s; font-size: 14px; }
        .layout { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar { width: 260px; background: var(--sidebar); padding: 2rem 1.2rem; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 100; }
        .logo { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 3rem; display: flex; align-items: center; gap: 10px; }
        .nav-link { padding: 14px 16px; color: #94a3b8; text-decoration: none; display: flex; align-items: center; gap: 12px; border-radius: var(--radius-md); margin-bottom: 8px; cursor: pointer; font-weight: 600; }
        .nav-link:hover, .nav-link.active { background: rgba(37, 99, 235, 0.2); color: #fff; }
        .nav-link.active { background: var(--primary); }

        /* MAIN CONTENT */
        .main-content { flex: 1; margin-left: 260px; padding: 2rem; }
        .content-card { background: var(--card); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow); border: 1px solid var(--border); margin-bottom: 1.5rem; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 1.5rem; }
        .stat-card { background: var(--card); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        
        /* GRIDS DE GRÁFICOS */
        .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
        canvas { width: 100% !important; max-height: 280px; }

        /* TABELAS E ALERTAS */
        .table-res { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th { text-align: left; padding: 12px; color: var(--text-muted); border-bottom: 2px solid var(--border); font-size: 11px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid var(--border); }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; }
        .entregue { background: #dcfce7; color: #166534; }
        .transito { background: #dbeafe; color: #1e40af; }
        .atrasado { background: #fee2e2; color: #991b1b; }

        /* AÇÕES TABELA */
        .action-icons { display: flex; gap: 10px; font-size: 16px; }
        .action-icons a { color: var(--text-muted); transition: 0.2s; }
        .action-icons .fa-eye:hover { color: var(--alert-info); }
        .action-icons .fa-pen:hover { color: var(--alert-warning); }
        .action-icons .fa-trash:hover { color: var(--alert-danger); }

        .page { display: none; }
        .page.active { display: block; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        input, select, textarea { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text-main); margin-top: 5px; margin-bottom: 10px;}
        .btn-salvar { background: var(--primary); color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; }
        #map-full { width: 100%; height: 500px; border-radius: var(--radius-md); background: #eee; }
        .profile-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary); }

        /* ACESSIBILIDADE */
        .toggle-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--border); }


        /* Classe de Alto Contraste */
body.high-contrast {
    --bg: #000000 !important;
    --card: #000000 !important;
    --text-main: #ffff00 !important; /* Amarelo no preto para leitura crítica */
    --text-muted: #ffffff !important;
    --border: #ffffff !important;
    --primary: #ffffff !important;
}

body.high-contrast .sidebar {
    background: #000 !important;
    border-right: 2px solid #fff;
}

/* Classe de Fontes Grandes */
body.large-fonts {
    font-size: 18px !important;
}

body.large-fonts h1 { font-size: 2.5rem; }
body.large-fonts .nav-link { font-size: 16px; }
body.large-fonts td, body.large-fonts th { font-size: 16px; }
    </style>
</head>
<body class="{{ Auth::user()->dark_mode ? 'dark' : '' }}">

<div class="layout">
    <aside class="sidebar">
        <a href="/" style="text-decoration: none">
            <div class="logo">
                <img src="{{ asset('img/Logo.png') }}" alt="Logo" style="width: 65px;">
                <span>GeoSync</span>
            </div>
        </a>
        <nav>
            <div class="nav-link active" onclick="showPage('dashboard', this)"><i class="fas fa-chart-pie"></i> Dashboard</div>
            <div class="nav-link" onclick="showPage('localizacao-page', this)"><i class="fas fa-map-location-dot"></i> Localização</div>
            <div class="nav-link" onclick="showPage('entregas', this)"><i class="fas fa-truck-fast"></i> Entregas</div>
            <div class="nav-link" onclick="showPage('alertas-page', this)"><i class="fas fa-triangle-exclamation"></i> Alertas</div>
            <div class="nav-link" onclick="showPage('antifraude', this)"><i class="fas fa-triangle-exclamation"></i> Anti-Fraude</div>
            <div class="nav-link" onclick="showPage('config', this)"><i class="fas fa-user-gear"></i> Configurações</div>
        </nav>
        <a href="/logout" class="nav-link" style="margin-top: auto; color: #ef4444;"><i class="fas fa-power-off"></i> Sair</a>
    </aside>

    <main class="main-content">

        <section id="dashboard" class="page active">
            <h1>Dashboard Operacional</h1>
            <div class="stats-grid" style="margin-top: 20px;">
                <div class="stat-card"><div><h4>Total</h4><h2>{{ $total }}</h2></div><i class="fas fa-boxes-stacked"></i></div>
                <div class="stat-card"><div><h4>Em Rota</h4><h2 style="color:var(--primary)">{{ $transito }}</h2></div><i class="fas fa-truck-fast"></i></div>
                <div class="stat-card"><div><h4>Concluídas</h4><h2 style="color:#10b981">{{ $entregues }}</h2></div><i class="fas fa-circle-check"></i></div>
                <div class="stat-card"><div><h4>Atrasos</h4><h2 style="color:#ef4444">{{ $atrasadas }}</h2></div><i class="fas fa-clock"></i></div>
            </div>
            <div class="charts-grid">
                <div class="content-card"><h3>Volume de Entregas</h3><canvas id="chartLinha"></canvas></div>
                <div class="content-card"><h3>Status da Frota</h3><canvas id="chartPizza"></canvas></div>
            </div>
        </section>

        <section id="localizacao-page" class="page">
            <h1>Monitoramento Geográfico</h1>
            <div class="charts-grid">
                <div class="content-card" style="padding: 10px;"><div id="map-full"></div></div>
                <div class="content-card">
                    <h3>Atualizar Posição</h3>
                    <form action="{{ route('localizacao.store') }}" method="POST">
                        @csrf
                        <label>Remessa</label>
                        <select name="remessa_id">@foreach($remessas as $r) <option value="{{ $r->id }}">{{ $r->codigo_rastreio }}</option> @endforeach</select>
                        <label>Latitude</label><input type="number" step="0.000001" name="latitude" placeholder="-23.5505">
                        <label>Longitude</label><input type="number" step="0.000001" name="longitude" placeholder="-46.6333">
                        <button class="btn-salvar" style="width:100%">Atualizar Mapa</button>
                    </form>
                </div>
            </div>
        </section>

        <section id="entregas" class="page">
            <div class="content-card">
                <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Gestão de Remessas</h2>
                    <a href="{{ route('remessas.create') }}" class="btn-salvar" style="text-decoration:none;">+ Nova</a>
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
                                <td>{{ $r->motorista ?? 'N/A' }}</td>
                                <td>{{ $r->origem }}</td>
                                <td>{{ $r->destino }}</td>
                                <td>{{ date('d/m/y', strtotime($r->data_entrega)) }}</td>
                                <td><span class="badge {{ $r->status == 'Entregue' ? 'entregue' : ($r->status == 'Atrasado' ? 'atrasado' : 'transito') }}">{{ $r->status }}</span></td>
                                <td>
                                    <div class="action-icons">
                                        <a href="{{ route('remessas.show', $r->id) }}"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('remessas.edit', $r->id) }}"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('remessas.destroy', $r->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;"><i class="fas fa-trash" style="color:var(--text-muted)"></i></button>
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
            <h1>Alertas de Segurança</h1>
            <div class="charts-grid">
                <div class="content-card">
                    <h3>Novo Alerta</h3>
                    <form action="{{ route('alerta.store') }}" method="POST">
                        @csrf
                        <label>Remessa</label><select name="remessa_id">@foreach($remessas as $r) <option value="{{ $r->id }}">{{ $r->codigo_rastreio }}</option> @endforeach</select>
                        <label>Tipo</label><select name="tipo_alerta"><option>Atraso</option><option>Acidente</option><option>Rota</option></select>
                        <label>Descrição</label><textarea name="descricao" rows="3"></textarea>
                        <button class="btn-salvar">Publicar</button>
                    </form>
                </div>
                <div class="content-card" style="max-height: 500px; overflow-y: auto;">
                    <h3>Histórico</h3>
                    @foreach($alertas as $a)
                    <div style="padding:15px; border-left:5px solid {{ $a->tipo_alerta == 'Acidente' ? 'var(--alert-danger)' : ($a->tipo_alerta == 'Atraso' ? 'var(--alert-warning)' : 'var(--alert-info)') }}; 
                                background: {{ $a->tipo_alerta == 'Acidente' ? '#fef2f2' : ($a->tipo_alerta == 'Atraso' ? '#fffbeb' : '#eff6ff') }}; 
                                margin-bottom:10px; border-radius:8px;">
                        <div style="display:flex; justify-content:space-between;">
                            <strong style="color:var(--text-main)">{{ $a->tipo_alerta }}</strong>
                            <small>#{{ $a->remessa->codigo_rastreio ?? 'N/A' }}</small>
                        </div>
                        <p style="font-size:12px; margin-top:5px; color:var(--text-main);">{{ $a->descricao }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="antifraude" class="page">
            <h1>Análise Inteligente de Veículos</h1>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Detecção de anomalias em tempo real via banco de dados</p>

            <div class="content-card" style="margin-bottom: 20px;">
                <label>Selecione uma Remessa em Rota para analisar:</label>
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <select id="select-remessa-af" style="margin: 0; flex: 1;">
                        <option value="">Selecione um código de rastreio...</option>
                        @foreach($remessas as $r)
                            @if($r->status != 'Entregue')
                                <option value="{{ $r->id }}">#{{ $r->codigo_rastreio }} - {{ $r->motorista }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button class="btn-salvar" onclick="analisarVeiculoBanco()">
                        <i class="fa-solid fa-magnifying-glass-chart"></i> Analisar
                    </button>
                </div>
            </div>
            
            <div class="antifraude-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="content-card" style="margin-bottom: 0;">
                    <div class="af-icon"><i class="fa-regular fa-clock"></i></div>
                    <span style="color: var(--text-muted); font-size: 12px;">Tempo Parado</span>
                    <strong class="af-val" id="af-tempo">--</strong>
                </div>

                <div class="content-card" style="margin-bottom: 0;">
                    <div class="af-icon"><i class="fa-solid fa-gauge-high"></i></div>
                    <span style="color: var(--text-muted); font-size: 12px;">Velocidade Atual</span>
                    <strong class="af-val" id="af-velocidade">--</strong>
                </div>

                <div class="content-card" style="margin-bottom: 0;">
                    <div class="af-icon"><i class="fa-solid fa-route"></i></div>
                    <span style="color: var(--text-muted); font-size: 12px;">Desvio de Rota</span>
                    <strong class="af-val" id="af-rota">--</strong>
                </div>

                <div class="content-card" style="margin-bottom: 0;">
                    <div class="af-icon"><i class="fa-solid fa-circle-info"></i></div>
                    <span style="color: var(--text-muted); font-size: 12px;">Conclusão da IA</span>
                    <strong class="af-val" id="af-mensagem" style="font-size: 1rem;">--</strong>
                </div>
            </div>

            <div id="status-af-alerta" style="margin-top: 20px; padding: 15px; border-radius: 12px; font-weight: 700; display: none; align-items: center; gap: 10px;"></div>
        </section>

        <section id="config" class="page">
            <h1>Configurações do Perfil</h1>
            <div class="charts-grid">
                <div class="content-card">
                    <h3>Dados Pessoais</h3>
                    <form action="/configuracoes" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <label>Nome</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required>

                        <label>E-mail</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required>

                        <label>Foto de Perfil</label>
                        <input type="file" name="foto" accept="image/*">

                        <button type="submit" class="btn-salvar">Salvar Dados</button>
                    </form>
                    <br>
                    <h3>Segurança</h3>
                    <form action="/mudar-senha" method="POST">
                        @csrf
                        <input type="password" name="password" required placeholder="Nova Senha">
                        <input type="password" name="password_confirmation" required placeholder="Confirme a Senha">
                        <button type="submit" class="btn-salvar">Mudar Senha</button>
                    </form>
                </div>
                <div class="content-card">
    <h3>Acessibilidade</h3>
    <div class="toggle-item">
        <span>Modo Escuro</span>
        <input type="checkbox" id="darkToggle" onchange="toggleDark()" {{ Auth::user()->dark_mode ? 'checked' : '' }}>
    </div>
    <div class="toggle-item">
        <span>Alto Contraste</span>
        <input type="checkbox" id="contrastToggle" onchange="toggleContrast()">
    </div>
    <div class="toggle-item">
        <span>Fontes Grandes</span>
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

<script>
    function showPage(id, el) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        el.classList.add('active');
    }
    function toggleDark() { document.body.classList.toggle('dark'); }

    // GRÁFICOS (MANTIDO)
    new Chart(document.getElementById('chartLinha'), {
        type: 'line',
        data: { labels: ['S1', 'S2', 'S3', 'S4'], datasets: [{ label: 'Entregas', data: [12, 19, 15, {{ $entregues }}], borderColor: '#2563eb', tension: 0.4 }] }
    });
    new Chart(document.getElementById('chartPizza'), {
        type: 'doughnut',
        data: { labels: ['Rota', 'OK', 'Atraso'], datasets: [{ data: [{{ $transito }}, {{ $entregues }}, {{ $atrasadas }}], backgroundColor: ['#3b82f6', '#10b981', '#ef4444'] }] }
    });

    // MAPA (MANTIDO)
    window.initMap = function() {
        new google.maps.Map(document.getElementById("map-full"), { zoom: 12, center: { lat: -23.5505, lng: -46.6333 }, disableDefaultUI: true });
    }

    // Alternar Modo Escuro
function toggleDark() {
    document.body.classList.toggle('dark');
}

// Alternar Alto Contraste
function toggleContrast() {
    document.body.classList.toggle('high-contrast');
}

// Alternar Tamanho da Fonte
function toggleFonts() {
    document.body.classList.toggle('large-fonts');
}

// Navegação (Mantida)
function showPage(id, el) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    el.classList.add('active');
}

async function analisarVeiculoBanco() {
    const remessaId = document.getElementById('select-remessa-af').value;
    
    if (!remessaId) {
        alert("Por favor, selecione uma remessa para analisar.");
        return;
    }

    // Feedback visual de carregamento
    document.getElementById("af-mensagem").innerText = "Analisando dados...";

    try {
        // Enviando o ID para a rota que processa a lógica de banco
        let res = await fetch(`/ia-antifraude/${remessaId}`);
        let data = await res.json();

        // Preenchendo com dados vindos do Controller (Banco de Dados)
        document.getElementById("af-tempo").innerText = data.tempo_parado + " min";
        document.getElementById("af-velocidade").innerText = data.velocidade + " km/h";
        document.getElementById("af-rota").innerText = data.desvio_rota ? "Sim (Detectado)" : "Não";
        document.getElementById("af-mensagem").innerText = data.mensagem;

        // Estilização do Alerta de Risco
        let statusBox = document.getElementById("status-af-alerta");
        let config = {
            baixo: { icon: "🟢", bg: '#dcfce7', text: '#166534', label: 'Baixo' },
            medio: { icon: "🟡", bg: '#fffbeb', text: '#854d0e', label: 'Médio' },
            alto:  { icon: "🔴", bg: '#fef2f2', text: '#991b1b', label: 'Alto' }
        };

        const r = config[data.risco] || config.baixo;
        
        statusBox.style.display = "flex";
        statusBox.style.backgroundColor = r.bg;
        statusBox.style.color = r.text;
        statusBox.innerHTML = `${r.icon} RISCO ${r.label.toUpperCase()}: ${data.detalhes_ia}`;

    } catch (e) {
        console.error("Erro na integração com o banco:", e);
        document.getElementById("af-mensagem").innerText = "Erro ao conectar.";
    }
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=SUA_API_KEY&callback=initMap"></script>
</body>
</html>