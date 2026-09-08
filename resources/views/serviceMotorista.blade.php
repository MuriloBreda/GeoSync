<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync | Painel do Motorista</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    
    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #1C3F6E;
            --primary-hover: #2F6FB2;
            --bg: #f8fafc;
            --sidebar: #0B1F36;
            --card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --input-bg: #f8fafc;
            --radius-lg: 16px;
            --radius-md: 10px;
            --alert-danger: #ef4444;
            --alert-warning: #f59e0b;
            --alert-success: #10b981;
            --alert-info: #3b82f6;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            --font-scale: 1;
        }

        /* Suporte aos Modos de Acessibilidade */
        body.dark-mode {
            --bg: #0f172a;
            --card: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: #334155;
            --input-bg: #0f172a;
        }

        body.alto-contraste {
            --bg: #000000;
            --card: #000000;
            --text-main: #ffff00;
            --text-muted: #ffffff;
            --border: #ffffff;
            --input-bg: #111111;
            --primary: #ffff00;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: calc(14px * var(--font-scale));
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-main);
            transition: background 0.3s, color 0.3s;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            background: rgba(11, 31, 54, .98);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-right: 1px solid rgba(255, 255, 255, .05);
            transition: width 0.3s, left 0.3s;
            z-index: 1000;
        }

        body.sidebar-collapsed .sidebar {
            width: 80px;
        }

        body.sidebar-collapsed .sidebar .logo span,
        body.sidebar-collapsed .sidebar .user-info,
        body.sidebar-collapsed .sidebar .menu-title,
        body.sidebar-collapsed .sidebar .nav-link span,
        body.sidebar-collapsed .sidebar .sidebar-status span {
            display: none;
        }

        body.sidebar-collapsed .sidebar .user-card {
            justify-content: center;
            padding: 8px;
        }

        body.sidebar-collapsed .sidebar .nav-link {
            justify-content: center;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 80px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 24px;
            text-decoration: none;
        }

        .logo img {
            width: 42px;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .05);
        }

        .user-card img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info strong {
            display: block;
            color: #fff;
            font-size: .9rem;
        }

        .user-info small {
            color: #94a3b8;
            font-size: .75rem;
        }

        .collapse-btn {
            background: rgba(255, 255, 255, .05);
            border: none;
            color: #fff;
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            cursor: pointer;
            margin-bottom: 18px;
            transition: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .collapse-btn:hover {
            background: rgba(255, 255, 255, .1);
        }

        .menu-title {
            color: #475569;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 10px 12px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #94a3b8;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 4px;
            cursor: pointer;
            transition: .25s;
            position: relative;
            font-weight: 600;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, .05);
            color: #fff;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: rgba(47, 111, 178, .25);
            color: #3b82f6;
            border-left: 3px solid #3b82f6;
        }

        .sidebar-footer {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-status {
            padding: 12px;
            border-radius: 12px;
            background: rgba(16, 185, 129, .12);
            color: #10b981;
            font-size: .85rem;
            font-weight: 600;
            text-align: center;
        }

        .online-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            box-shadow: 0 0 10px #10b981;
        }

        .logout-link {
            color: #ef4444;
            margin-bottom: 0;
        }

        .logout-link:hover {
            background: rgba(239, 68, 68, .15);
            color: #ef4444;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2.5rem;
            transition: margin-left 0.3s;
        }

        .content-card {
            background: var(--card);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card);
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
        }

        .stat-card h4 {
            color: var(--text-muted);
            font-size: 0.85rem;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .stat-card h2 {
            font-size: 1.8rem;
            font-weight: 800;
        }

        .stat-card i {
            font-size: 2rem;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .table-res {
            overflow-x: auto;
            margin-top: 1rem;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 700px;
        }

        th {
            text-align: left;
            padding: 14px 16px;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border);
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            background: var(--bg);
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-weight: 500;
        }

        table tr:hover td {
            background: rgba(0, 0, 0, 0.01);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .entregue {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }

        .transito {
            background: rgba(59, 130, 246, 0.15);
            color: #2563eb;
        }

        .atrasado {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
        }

        .btn-salvar, .btn-acao {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: 0.2s;
            box-shadow: 0 4px 12px rgba(28, 63, 110, 0.15);
        }

        .btn-salvar:hover, .btn-acao:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary);
            margin-top: 10px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 14px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            background: var(--input-bg);
            color: var(--text-main);
            margin-bottom: 14px;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-hover);
            box-shadow: 0 0 0 3px rgba(47, 111, 178, 0.15);
        }

        .toggle-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border-radius: 12px;
            background: var(--input-bg);
            border: 1px solid var(--border);
            margin-bottom: 12px;
        }

        /* Switch Toggle Estilizado */
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-hover);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* BARRA FLUTUANTE DE FERRAMENTAS */
        .ferramentas-flutuantes-container {
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 999999;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .robo-floating-btn {
            width: 60px;
            height: 60px;
            background-color: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .robo-floating-btn:hover {
            transform: scale(1.08) translateY(-2px);
            background-color: #1d4ed8;
        }

        .robo-floating-btn svg {
            width: 28px;
            height: 28px;
        }

        .accessibility-container {
            position: relative;
        }

        #accessibility-toggle {
            width: 60px;
            height: 60px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            color: white;
            font-size: 26px;
            background: linear-gradient(135deg, #0B3B7A, #2F6FB2);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .3s;
        }

        #accessibility-toggle:hover {
            transform: scale(1.08) translateY(-2px);
        }

        .accessibility-panel {
            position: absolute;
            right: 0;
            bottom: 75px;
            width: 280px;
            background: var(--card);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .2);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: .3s;
            border: 1px solid var(--border);
        }

        .accessibility-panel.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .accessibility-header {
            background: linear-gradient(135deg, #0B3B7A, #2F6FB2);
            color: white;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .accessibility-btn-item {
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--border);
            padding: 14px 18px;
            text-align: left;
            color: var(--text-main);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background 0.2s;
            width: 100%;
        }

        .accessibility-btn-item:last-child {
            border-bottom: none;
        }

        .accessibility-btn-item i {
            color: #2F6FB2;
            width: 20px;
            text-align: center;
        }

        .accessibility-btn-item:hover {
            background: var(--bg);
        }

        .map-container {
            width: 100%;
            height: 480px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .mobile-menu-toggle { display: none; }

        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
                position: fixed;
                width: 280px !important;
                z-index: 1000002 !important;
            }

            body.sidebar-open .sidebar {
                left: 0;
            }

            .mobile-menu-toggle {
                display: inline-flex !important;
                position: fixed;
                top: 16px;
                left: 16px;
                z-index: 1000003;
                width: 44px;
                height: 44px;
                align-items: center;
                justify-content: center;
                border: 0;
                border-radius: 12px;
                background: var(--sidebar);
                color: #fff;
                box-shadow: 0 8px 22px rgba(11, 31, 54, .28);
                font-size: 1.1rem;
            }

            .mobile-menu-backdrop { display: none; }
            body.sidebar-open .mobile-menu-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1000001;
                background: rgba(11, 31, 54, .45);
            }

            .main-content {
                margin-left: 0 !important;
                padding: 15px;
            }

            .stats-grid, .charts-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>

<body class="{{ Auth::user()->dark_mode ? 'dark-mode' : '' }}">

    <!-- BARRA FLUTUANTE DE FERRAMENTAS -->
    <div class="ferramentas-flutuantes-container">
        <!-- Botão do Robô -->
        <a href="{{ url('/chat') }}" class="robo-floating-btn" title="Conversar com a I.A">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 8V4H8" />
                <rect width="16" height="12" x="4" y="8" rx="2" />
                <path d="M2 14h2" />
                <path d="M20 14h2" />
                <path d="M15 13v2" />
                <path d="M9 13v2" />
            </svg>
        </a>

        <!-- Botão de Acessibilidade -->
        <div class="accessibility-container">
            <button id="accessibility-toggle" aria-label="Abrir acessibilidade">
                <i class="fas fa-universal-access"></i>
            </button>
            <div class="accessibility-panel" id="accessibility-panel">
                <div class="accessibility-header">
                    <i class="fas fa-universal-access"></i>
                    <span>Acessibilidade</span>
                </div>
                <div class="accessibility-list">
                    <button class="accessibility-btn-item" onclick="alterarFonte(0.1)"><i class="fas fa-search-plus"></i> Aumentar Fonte</button>
                    <button class="accessibility-btn-item" onclick="alterarFonte(-0.1)"><i class="fas fa-search-minus"></i> Diminuir Fonte</button>
                    <button class="accessibility-btn-item" onclick="toggleDark()"><i class="fas fa-moon"></i> Modo Escuro</button>
                    <button class="accessibility-btn-item" onclick="toggleContraste()"><i class="fas fa-adjust"></i> Alto Contraste</button>
                    <button class="accessibility-btn-item" onclick="lerPagina()"><i class="fas fa-volume-up"></i> Ler Página</button>
                    <button class="accessibility-btn-item" onclick="pararLeitura()"><i class="fas fa-stop-circle"></i> Parar Leitura</button>
                    <button class="accessibility-btn-item" onclick="resetarAcessibilidade()"><i class="fas fa-undo"></i> Restaurar Padrão</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="mobile-menu-toggle" onclick="document.body.classList.toggle('sidebar-open')" aria-label="Abrir ou fechar menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="mobile-menu-backdrop" onclick="document.body.classList.remove('sidebar-open')"></div>

    <div class="layout">
        <aside class="sidebar">
            <a href="/" class="logo">
                <img src="{{ asset('img/Logo.png') }}" alt="Logo">
                <span>GeoSync</span>
            </a>

            <div class="user-card">
                <img id="sidebarFoto"
                    src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=2563eb&color=fff' }}"
                    alt="Perfil">
                <div class="user-info">
                    <strong>{{ Auth::user()->name }}</strong>
                    <small>{{ ucfirst(Auth::user()->tipo) }}</small>
                </div>
            </div>

            <!-- Botão Menu Hambúrguer -->
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

            <div class="sidebar-footer">
                <a href="/logout" class="nav-link logout-link">
                    <i class="fas fa-power-off"></i><span>Sair</span>
                </a>

                <div class="sidebar-status">
                    <span class="online-dot"></span>
                    <span>Sistema Online</span>
                </div>
            </div>
        </aside>

        <main class="main-content">

            <!-- ABA 1: MINHAS VIAGENS -->
            <section id="overview" class="page active">
                <h1 style="margin-bottom: 1.5rem;">Minhas Viagens Atribuídas</h1>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div>
                            <h4>Total Atribuído</h4>
                            <h2>{{ $total }}</h2>
                        </div>
                        <i class="fas fa-boxes-stacked" style="color: var(--alert-info)"></i>
                    </div>
                    <div class="stat-card">
                        <div>
                            <h4>Entregues</h4>
                            <h2>{{ $entregues }}</h2>
                        </div>
                        <i class="fas fa-circle-check" style="color: var(--alert-success)"></i>
                    </div>
                </div>

                <div class="content-card">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                        <h2>Histórico e Cargas</h2>
                        <span style="color:var(--text-muted)">Total: {{ count($remessas) }}</span>
                    </div>

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
                                        <td><strong>#{{ $r->codigo_rastreio }}</strong></td>
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

            <!-- ABA 2: LOCALIZAÇÃO -->
            <section id="localizacao" class="page">

                <h1 style="margin-bottom: 1.5rem;">
                    Rastreamento e Localização em Tempo Real
                </h1>

                <div class="content-card">

                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                        Selecione a remessa que você está transportando e inicie o
                        rastreamento. O sistema irá enviar sua localização
                        automaticamente para o GeoSync.
                    </p>

                    <!-- SELECIONAR REMESSA -->
                    <label>
                        <i class="fas fa-box"></i>
                        Remessa que está sendo transportada
                    </label>

                    <select id="remessaGPS">

                        <option value="">
                            -- Selecione uma remessa --
                        </option>

                        @foreach($remessas->where('status', '!=', 'Entregue') as $r)

                            <option value="{{ $r->id }}">
                                #{{ $r->codigo_rastreio }}
                                |
                                {{ $r->origem }}
                                →
                                {{ $r->destino }}
                            </option>

                        @endforeach

                    </select>


                    <!-- MAPA -->
                    <div
                        class="map-container"
                        id="mapaBox">
                    </div>


                    <!-- CONTROLES -->
                    <div style="
                        margin-top: 1.5rem;
                        display: flex;
                        gap: 12px;
                        flex-wrap: wrap;
                        align-items: center;
                    ">

                        <button
                            id="btnIniciarGPS"
                            class="btn-salvar"
                            onclick="iniciarRastreamento()">

                            <i class="fas fa-location-crosshairs"></i>

                            Iniciar Rastreamento

                        </button>


                        <button
                            id="btnPararGPS"
                            class="btn-salvar"
                            onclick="pararRastreamento()"
                            style="
                                background: var(--alert-danger);
                                display: none;
                            ">

                            <i class="fas fa-stop"></i>

                            Parar Rastreamento

                        </button>


                        <span
                            id="geoStatus"
                            style="
                                font-weight: 600;
                                color: var(--text-muted);
                            ">

                            GPS parado

                        </span>

                    </div>


                    <!-- INFORMAÇÕES GPS -->
                    <div
                        id="infoGPS"
                        style="
                            display: none;
                            margin-top: 20px;
                            padding: 15px;
                            border-radius: 12px;
                            background: var(--input-bg);
                            border: 1px solid var(--border);
                        "
                    >

                        <strong>
                            <i class="fas fa-satellite-dish"></i>
                            Dados da localização
                        </strong>

                        <div style="margin-top: 10px;">

                            <span>
                                Latitude:
                                <strong id="latitudeAtual">-</strong>
                            </span>

                            <br>

                            <span>
                                Longitude:
                                <strong id="longitudeAtual">-</strong>
                            </span>

                            <br>

                            <span>
                                Última sincronização:
                                <strong id="ultimaSincronizacao">-</strong>
                            </span>

                        </div>

                    </div>

                </div>

            </section>

            <!-- ABA 3: ATUALIZAR STATUS -->
            <section id="status-page" class="page">
                <h1 style="margin-bottom: 1.5rem; text-align: center;">Atualizar Estado da Entrega</h1>

                @php
                    $temPendentes = $remessas->where('status', '!=', 'Entregue')->count() > 0;
                @endphp

                @if($temPendentes)
                    <div class="content-card" style="max-width: 600px; margin: 0 auto;">
                        <form id="formAtualizarStatus" action="{{ route('motorista.status') }}" method="POST" onsubmit="processarEnvioStatus(event)">
                            @csrf
                            <label><i class="fas fa-box"></i> Selecione a Remessa</label>
                            <select name="remessa_id" required>
                                <option value="">-- Escolha uma viagem ativa --</option>
                                @foreach($remessas->where('status', '!=', 'Entregue') as $r)
                                    <option value="{{ $r->id }}">
                                        📦 Cód: {{ $r->codigo_rastreio }} | 📍 Destino: {{ $r->destino }}
                                    </option>
                                @endforeach
                            </select>

                            <label><i class="fas fa-tag"></i> Novo Status da Entrega</label>
                            <select name="status" required>
                                <option value="Em Rota">🚚 Em Rota</option>
                                <option value="Entregue">✅ Entregue</option>
                                <option value="Atrasado">⚠️ Atrasado</option>
                            </select>

                            <button type="submit" class="btn-salvar" style="width: 100%; margin-top: 10px;">
                                <i class="fas fa-sync"></i> Atualizar Status
                            </button>
                        </form>
                    </div>
                @else
                    <div class="content-card" style="text-align: center; padding: 40px;">
                        <i class="fas fa-info-circle" style="font-size: 2rem; color: var(--primary-hover); margin-bottom: 10px;"></i>
                        <p style="color: var(--text-muted);">Nenhuma entrega pendente para atualizar no momento.</p>
                    </div>
                @endif
            </section>

            <!-- ABA 4: EMITIR ALERTA -->
            <section id="criar-alerta-page" class="page">
                <h1 style="margin-bottom: 1.5rem; color: var(--alert-danger); text-align: center;">
                    <i class="fas fa-triangle-exclamation"></i> Emitir Alerta de Ocorrência
                </h1>

                <div class="content-card" style="max-width: 650px; margin: 0 auto;">
                    <form id="formEnviarAlerta" action="{{ route('alertas.store') }}" method="POST" onsubmit="processarEnvioAlerta(event)">
                        @csrf
                        
                        <label><i class="fas fa-box-open"></i> Selecione a Remessa Vinculada</label>
                        <select name="remessa_id" required>
                            <option value="">-- Escolha a viagem do incidente --</option>
                            @foreach($remessas->where('status', '!=', 'Entregue') as $remessa)
                                <option value="{{ $remessa->id }}">
                                    📦 Cód: {{ $remessa->codigo_rastreio }} | 📍 Destino: {{ $remessa->destino }}
                                </option>
                            @endforeach
                        </select>

                        <label><i class="fas fa-list-ul"></i> Tipo de Ocorrência</label>
                        <select name="tipo" required>
                            <option value="Acidente na pista">⚠️ Acidente na pista</option>
                            <option value="Problema mecânico">🔧 Problema mecânico</option>
                            <option value="Condições climáticas ruins">🌧️ Condições climáticas ruins</option>
                            <option value="Suspeita de sinistro / Perigo">🚨 Suspeita de sinistro / Perigo</option>
                            <option value="Outro atraso logístico">🕒 Outro atraso logístico</option>
                        </select>

                        <label><i class="fas fa-pen"></i> Detalhes da Mensagem</label>
                        <textarea name="mensagem" rows="4" placeholder="Ex: Pneu furado no km 120 da BR-101..." required></textarea>

                        <button type="submit" class="btn-salvar" style="width: 100%; margin-top: 10px; background: var(--alert-danger);">
                            <i class="fas fa-paper-plane"></i> Enviar Alerta Crítico
                        </button>
                    </form>
                </div>
            </section>

            <!-- ABA 5: CONFIGURAÇÕES (IDENTICA AO ADMIN) -->
            <section id="config" class="page">
                <h1 style="margin-bottom: 1.5rem;">Configurações do Sistema</h1>
                <div class="charts-grid" style="grid-template-columns: 2fr 1fr;">

                    <div class="content-card">
                        <h3 style="margin-bottom:20px;">Perfil do Usuário</h3>
                        <form id="formConfigPerfil" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" onsubmit="salvarConfiguracoes(event)">
                            @csrf

                            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px; background: var(--input-bg); padding: 15px; border-radius: var(--radius-md); border: 1px solid var(--border);">
                                <div style="position: relative;">
                                    <img id="previewFoto"
                                        src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                        style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary);">
                                    <label for="inputFoto"
                                        style="position: absolute; bottom: 0; right: 0; background: var(--primary); color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; margin-top:0;">
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
                            <input type="text" name="telefone" id="telefoneConfig" value="{{ Auth::user()->telefone ?? '' }}">

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

                    <div class="content-card">
                        <h3 style="margin-bottom:20px;">Preferências</h3>
                        
                        <div class="toggle-item">
                            <div>
                                <strong>Notificações por Email</strong>
                                <p style="font-size:0.75rem; color:var(--text-muted);">Alertas de atraso em tempo real</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked onchange="Swal.fire({icon:'success', title:'Preferência atualizada', toast:true, position:'top-end', showConfirmButton:false, timer:2000})">
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="toggle-item">
                            <div>
                                <strong>Autenticação 2FA</strong>
                                <p style="font-size:0.75rem; color:var(--text-muted);">Segurança reforçada para a conta</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" onchange="Swal.fire({icon:'info', title:'Recurso 2FA alterado', toast:true, position:'top-end', showConfirmButton:false, timer:2000})">
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="toggle-item">
                            <div>
                                <strong>Modo Escuro Padrão</strong>
                                <p style="font-size:0.75rem; color:var(--text-muted);">Ativar tema escuro na interface</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="switchDark" onchange="toggleDark()">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                </div>
            </section>

        </main>
    </div>

    <!-- VLIBRAS -->
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- SCRIPTS DE INTERFACE E SWEETALERTS -->
    <script>
        // CONTROLES DE INTERFACE
        function toggleSidebar() { 
            if (window.innerWidth <= 768) {
                document.body.classList.toggle('sidebar-open');
            } else {
                document.body.classList.toggle('sidebar-collapsed'); 
            }
        }

        function showPage(id, el) {
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            document.getElementById(id).classList.add('active');
            if(el) el.classList.add('active');

            if (window.innerWidth <= 768) {
                document.body.classList.remove('sidebar-open');
            }

            if (id === 'localizacao' && mapa) {
                setTimeout(() => {
                    mapa.invalidateSize();
                }, 200);
            }
        }

        // MÁSCARAS DE INPUT
        function aplicarMascaras() {
            const telEl = document.getElementById('telefoneConfig');
            if (telEl) {
                telEl.addEventListener('input', function (e) {
                    let v = e.target.value.replace(/\D/g, '');
                    v = v.replace(/^(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2');
                    e.target.value = v.substring(0, 15);
                });
            }
        }
        document.addEventListener('DOMContentLoaded', aplicarMascaras);

        // SWEETALERTS DE CONFIRMAÇÃO & AÇÃO
        function processarEnvioStatus(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Atualizando...',
                text: 'Enviando a atualização da entrega.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            document.getElementById('formAtualizarStatus').submit();
        }

        function processarEnvioAlerta(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Transmitindo Alerta...',
                text: 'Notificando a central sobre o incidente.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            document.getElementById('formEnviarAlerta').submit();
        }

        function salvarConfiguracoes(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Salvando...',
                text: 'Atualizando as informações do perfil.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            document.getElementById('formConfigPerfil').submit();
        }

        // Mensagens Flash capturadas pelo SweetAlert
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                timer: 3500,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#1C3F6E'
            });
        @endif

        function previewImagem(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('previewFoto').src = e.target.result;
                    document.getElementById('sidebarFoto').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- MAPA + GPS EM TEMPO REAL -->
    <script>

        let mapa = null;
        let marcador = null;
        let watchId = null;

        let ultimaLatitude = null;
        let ultimaLongitude = null;


        // ==========================================
        // INICIALIZAR MAPA
        // ==========================================

        document.addEventListener("DOMContentLoaded", function () {

            const mapBox = document.getElementById('mapaBox');

            if (!mapBox) {
                return;
            }

            mapa = L.map('mapaBox').setView(
                [-14.2350, -51.9253],
                4
            );

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    attribution: '&copy; OpenStreetMap'
                }
            ).addTo(mapa);

        });


        // ==========================================
        // INICIAR RASTREAMENTO
        // ==========================================

        function iniciarRastreamento() {

            const remessaId =
                document.getElementById('remessaGPS').value;

            const statusSpan =
                document.getElementById('geoStatus');


            // Verifica se selecionou remessa

            if (!remessaId) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione uma remessa',
                    text: 'Escolha a remessa que você está transportando.',
                    confirmButtonColor: '#1C3F6E'
                });

                return;
            }


            // Em computadores sem GPS, usa uma posição aproximada pela rede/IP.
            let fallbackPorIpAtivo = false;

            const usarLocalizacaoPorIp = async () => {
                if (fallbackPorIpAtivo) return;
                fallbackPorIpAtivo = true;

                statusSpan.style.color = 'var(--alert-info)';
                statusSpan.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Obtendo localização aproximada pela rede...';

                try {
                    const resposta = await fetch('https://ipwho.is/');
                    const dados = await resposta.json();
                    const latitude = Number(dados.latitude);
                    const longitude = Number(dados.longitude);

                    if (!resposta.ok || !dados.success || !Number.isFinite(latitude) || !Number.isFinite(longitude)) {
                        throw new Error('Serviço de localização por IP indisponível.');
                    }

                    ultimaLatitude = latitude;
                    ultimaLongitude = longitude;
                    configurarMarcadorMapa(latitude, longitude);
                    await enviarLocalizacao(latitude, longitude, remessaId);

                    statusSpan.style.color = 'var(--alert-warning)';
                    statusSpan.innerHTML = '<i class="fas fa-triangle-exclamation"></i> Localização aproximada por IP sincronizada.';
                } catch (erro) {
                    console.error('Erro ao localizar pelo IP:', erro);
                    statusSpan.style.color = 'var(--alert-danger)';
                    statusSpan.innerHTML = '<i class="fas fa-ban"></i> GPS e localização por IP indisponíveis.';
                }
            };

            if (!navigator.geolocation) {
                usarLocalizacaoPorIp();
                return;
            }

            // Verifica suporte ao GPS

            if (!navigator.geolocation) {

                Swal.fire({
                    icon: 'error',
                    title: 'GPS indisponível',
                    text: 'Seu navegador não possui suporte à localização.'
                });

                return;
            }


            statusSpan.style.color =
                'var(--alert-info)';

            statusSpan.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Obtendo localização...';


            document.getElementById('btnIniciarGPS').style.display =
                'none';

            document.getElementById('btnPararGPS').style.display =
                'inline-flex';


            // Registra uma posição já no início, sem aguardar a próxima atualização.
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    ultimaLatitude = latitude;
                    ultimaLongitude = longitude;
                    configurarMarcadorMapa(latitude, longitude);
                    enviarLocalizacao(latitude, longitude, remessaId);
                },
                () => usarLocalizacaoPorIp(),
                { enableHighAccuracy: true, maximumAge: 0, timeout: 30000 }
            );

            // ==========================================
            // WATCH POSITION
            // ==========================================

            watchId = navigator.geolocation.watchPosition(

                function (position) {

                    console.log("GPS recebido:", position);

                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    ultimaLatitude = latitude;
                    ultimaLongitude = longitude;

                    configurarMarcadorMapa(
                        latitude,
                        longitude
                    );

                    enviarLocalizacao(
                        latitude,
                        longitude,
                        remessaId
                    );

                },

                function (error) {

                    console.error(
                        "ERRO COMPLETO DO GPS:",
                        error
                    );

                    if ([1, 2, 3].includes(error.code)) {
                        usarLocalizacaoPorIp();
                        return;
                    }

                    switch (error.code) {

                        case 1:

                            statusSpan.innerHTML =
                                '<i class="fas fa-ban"></i> Permissão de localização negada.';

                            break;

                        case 2:

                            statusSpan.innerHTML =
                                '<i class="fas fa-location-dot"></i> Localização indisponível.';

                            break;

                        case 3:

                            statusSpan.innerHTML =
                                '<i class="fas fa-clock"></i> Tempo limite para obter GPS.';

                            break;

                        default:

                            statusSpan.innerHTML =
                                '<i class="fas fa-circle-xmark"></i> Erro desconhecido no GPS.';

                    }

                    statusSpan.style.color =
                        'var(--alert-danger)';

                },

                {
                    enableHighAccuracy: true,
                    maximumAge: 5000,
                    timeout: 30000
                }

            );

        }


        // ==========================================
        // PARAR RASTREAMENTO
        // ==========================================

        function pararRastreamento() {

            if (watchId !== null) {

                navigator.geolocation.clearWatch(
                    watchId
                );

                watchId = null;

            }


            const statusSpan =
                document.getElementById('geoStatus');


            statusSpan.style.color =
                'var(--text-muted)';

            statusSpan.innerHTML =
                '<i class="fas fa-location-dot"></i> GPS parado';


            document.getElementById('btnIniciarGPS').style.display =
                'inline-flex';

            document.getElementById('btnPararGPS').style.display =
                'none';

        }


        // ==========================================
        // CONFIGURAR MARCADOR
        // ==========================================

        function configurarMarcadorMapa(
            lat,
            lon
        ) {

            if (!mapa) {
                return;
            }


            const statusSpan =
                document.getElementById('geoStatus');


            statusSpan.style.color =
                'var(--alert-success)';


            statusSpan.innerHTML =
                '<i class="fas fa-circle-check"></i> GPS conectado';


            // Atualiza marcador existente

            if (marcador) {

                marcador.setLatLng([
                    lat,
                    lon
                ]);

            }

            // Cria marcador

            else {

                marcador = L.marker([
                    lat,
                    lon
                ])
                .addTo(mapa);

            }


            marcador
                .bindPopup(
                    '<b>Localização atual</b><br>' +
                    'GPS sincronizado.'
                );


            mapa.setView(
                [lat, lon],
                15
            );


            // Informações

            document.getElementById(
                'infoGPS'
            ).style.display = 'block';


            document.getElementById(
                'latitudeAtual'
            ).textContent =
                lat.toFixed(8);


            document.getElementById(
                'longitudeAtual'
            ).textContent =
                lon.toFixed(8);


            const agora =
                new Date();


            document.getElementById(
                'ultimaSincronizacao'
            ).textContent =
                agora.toLocaleTimeString('pt-BR');

        }


        // ==========================================
        // ENVIAR LOCALIZAÇÃO PARA API
        // ==========================================

        async function enviarLocalizacao(
            latitude,
            longitude,
            remessaId
        ) {

            const statusSpan =
                document.getElementById('geoStatus');


            try {

                const resposta =
                    await fetch(
                        '/api/localizacao',
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json'

                            },

                            body: JSON.stringify({

                                latitude:
                                    latitude,

                                longitude:
                                    longitude,

                                remessa_id:
                                    remessaId

                            })

                        }
                    );


                const dados =
                    await resposta.json();


                if (!resposta.ok) {

                    console.error(
                        'Erro da API:',
                        dados
                    );

                    statusSpan.style.color =
                        'var(--alert-danger)';

                    statusSpan.innerHTML =
                        '<i class="fas fa-circle-xmark"></i> Erro ao sincronizar GPS';

                    return;
                }


                console.log(
                    'Localização enviada:',
                    dados
                );


                statusSpan.style.color =
                    'var(--alert-success)';

                statusSpan.innerHTML =
                    '<i class="fas fa-circle-check"></i> Localização sincronizada';


            }
            catch (erro) {

                console.error(
                    'Erro ao enviar localização:',
                    erro
                );


                statusSpan.style.color =
                    'var(--alert-danger)';

                statusSpan.innerHTML =
                    '<i class="fas fa-wifi"></i> Erro de conexão com o servidor';

            }

        }

    </script>

    <!-- PAINEL DE ACESSIBILIDADE E TEMAS -->
    <script>
        const accessBtn = document.getElementById("accessibility-toggle");
        const accessPanel = document.getElementById("accessibility-panel");

        if (accessBtn && accessPanel) {
            accessBtn.addEventListener("click", (e) => {
                e.stopPropagation();
                accessPanel.classList.toggle("active");
            });

            document.addEventListener("click", (e) => {
                if (!accessPanel.contains(e.target) && !accessBtn.contains(e.target)) {
                    accessPanel.classList.remove("active");
                }
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            let escala = localStorage.getItem("fontScale") || "1";
            document.documentElement.style.setProperty("--font-scale", escala);

            if (localStorage.getItem("darkMode") === "true") {
                document.body.classList.add("dark-mode");
                const sw = document.getElementById("switchDark");
                if (sw) sw.checked = true;
            }
            if (localStorage.getItem("contraste") === "true") {
                document.body.classList.add("alto-contraste");
            }
        });

        function alterarFonte(valor) {
            let atual = parseFloat(getComputedStyle(document.documentElement).getPropertyValue("--font-scale")) || 1;
            atual += valor;
            if (atual < 0.7) atual = 0.7;
            if (atual > 1.7) atual = 1.7;

            atual = parseFloat(atual.toFixed(2));
            document.documentElement.style.setProperty("--font-scale", atual);
            localStorage.setItem("fontScale", atual);
        }

        function toggleDark() {
            document.body.classList.remove("alto-contraste");
            localStorage.setItem("contraste", "false");

            const isDark = document.body.classList.toggle("dark-mode");
            localStorage.setItem("darkMode", isDark);
            
            const sw = document.getElementById("switchDark");
            if (sw) sw.checked = isDark;
        }

        function toggleContraste() {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("darkMode", "false");

            const isContraste = document.body.classList.toggle("alto-contraste");
            localStorage.setItem("contraste", isContraste);
        }

        function lerPagina() {
            window.speechSynthesis.cancel();
            let texto = window.getSelection().toString().trim();
            if (!texto) {
                texto = document.querySelector('main').innerText;
            }
            if (texto) {
                const fala = new SpeechSynthesisUtterance(texto);
                fala.lang = "pt-BR";
                fala.rate = 1.0;
                window.speechSynthesis.speak(fala);
            }
        }

        function pararLeitura() {
            window.speechSynthesis.cancel();
        }

        function resetarAcessibilidade() {
            pararLeitura();
            localStorage.removeItem("fontScale");
            localStorage.removeItem("darkMode");
            localStorage.removeItem("contraste");
            document.body.classList.remove("dark-mode", "alto-contraste");
            document.documentElement.style.setProperty("--font-scale", "1");
            const sw = document.getElementById("switchDark");
            if (sw) sw.checked = false;
        }
    </script>
</body>

</html>
