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


        /* DASHBOARD DO MOTORISTA */
        .driver-hero {
            background: linear-gradient(135deg, var(--sidebar), var(--primary));
            border-radius: 22px;
            padding: 2rem;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .driver-hero::after {
            content: '';
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
            right: -90px;
            top: -130px;
        }
        .driver-hero h1 { color:#fff; margin:0 0 .45rem; font-size:1.8rem; }
        .driver-hero p { color:#cbd5e1; margin:0; max-width:620px; }
        .driver-live { position:relative; z-index:1; display:flex; align-items:center; gap:10px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.12); padding:12px 16px; border-radius:14px; white-space:nowrap; }
        .driver-live .online-dot { width:9px; height:9px; margin:0; }
        .driver-stat { position:relative; overflow:hidden; }
        .driver-stat::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; background:var(--primary-hover); }
        .driver-stat .stat-caption { font-size:.78rem; color:var(--text-muted); margin-top:4px; }
        .dashboard-driver-grid { display:grid; grid-template-columns:1.35fr .85fr; gap:1.5rem; margin-bottom:1.5rem; }
        .current-trip { background:var(--card); border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.75rem; box-shadow:var(--shadow-md); }
        .section-kicker { color:var(--primary-hover); font-size:.75rem; font-weight:800; letter-spacing:.08em; text-transform:uppercase; margin-bottom:.45rem; }
        .trip-route { display:flex; align-items:center; gap:14px; margin:1.25rem 0; }
        .route-point { min-width:0; flex:1; }
        .route-point span { display:block; color:var(--text-muted); font-size:.75rem; margin-bottom:4px; }
        .route-point strong { display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .route-line { flex:0 0 70px; height:2px; background:var(--border); position:relative; }
        .route-line::after { content:'➜'; position:absolute; right:-3px; top:50%; transform:translateY(-58%); color:var(--primary-hover); background:var(--card); padding-left:5px; }
        .trip-meta { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; margin-top:1rem; }
        .trip-meta-item { background:var(--input-bg); border:1px solid var(--border); border-radius:12px; padding:12px; }
        .trip-meta-item small { color:var(--text-muted); display:block; margin-bottom:3px; }
        .trip-actions { display:flex; gap:10px; margin-top:1.25rem; flex-wrap:wrap; }
        .btn-driver { border:none; border-radius:11px; padding:11px 16px; cursor:pointer; font-weight:700; font-family:inherit; background:var(--primary); color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
        .btn-driver.secondary { background:var(--input-bg); color:var(--text-main); border:1px solid var(--border); }
        .driver-panel { background:var(--card); border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem; box-shadow:var(--shadow-md); }
        .quick-actions { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:1rem; }
        .quick-action { background:var(--input-bg); border:1px solid var(--border); border-radius:12px; padding:15px; cursor:pointer; text-align:left; font:inherit; color:var(--text-main); }
        .quick-action i { color:var(--primary-hover); font-size:1.15rem; margin-bottom:9px; display:block; }
        .quick-action strong { display:block; font-size:.88rem; }
        .quick-action small { color:var(--text-muted); display:block; margin-top:4px; font-size:.72rem; }
        .empty-trip { text-align:center; padding:2.3rem 1rem; color:var(--text-muted); }
        .empty-trip i { font-size:2.3rem; color:var(--primary-hover); margin-bottom:12px; }
        @media (max-width: 900px) { .dashboard-driver-grid { grid-template-columns:1fr; } }
        @media (max-width: 600px) { .driver-hero { padding:1.4rem; align-items:flex-start; flex-direction:column; } .trip-route { gap:8px; } .route-line { flex-basis:32px; } .trip-meta { grid-template-columns:1fr; } .quick-actions { grid-template-columns:1fr 1fr; } }

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


        /* PAINEL DE VIAGEM / ROTA */
        .viagem-info {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin: 18px 0;
        }

        .viagem-info-card {
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 15px;
        }

        .viagem-info-card .icone {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(47, 111, 178, .12);
            color: var(--primary-hover);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 9px;
        }

        .viagem-info-card small {
            display: block;
            color: var(--text-muted);
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .viagem-info-card strong {
            display: block;
            font-size: 1rem;
        }

        .rota-status {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 12px 0 0;
            color: var(--text-muted);
            font-size: .85rem;
            font-weight: 600;
        }

        .destino-marker {
            background: var(--alert-danger);
            color: #fff;
            width: 34px;
            height: 34px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #fff;
            box-shadow: 0 3px 10px rgba(0,0,0,.25);
        }

        .destino-marker i {
            transform: rotate(45deg);
            font-size: 14px;
        }

        .motorista-marker {
            background: var(--primary);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #fff;
            box-shadow: 0 3px 12px rgba(0,0,0,.28);
            font-size: 16px;
        }

        @media (max-width: 900px) {
            .viagem-info {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 520px) {
            .viagem-info {
                grid-template-columns: 1fr;
            }
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

            <!-- ABA 1: PAINEL DO MOTORISTA -->
            <section id="overview" class="page active">
                @php
                    $emRota = $remessas->filter(fn($r) => in_array(strtolower(trim($r->status ?? '')), ['em rota','em trânsito','em transito']))->count();
                    $atrasadasMotorista = $remessas->filter(fn($r) => strtolower(trim($r->status ?? '')) === 'atrasado')->count();
                    $viagemAtual = $remessas->first(function($r) {
                        return !in_array(strtolower(trim($r->status ?? '')), ['entregue','concluída','concluida']);
                    });
                @endphp

                <div class="driver-hero">
                    <div>
                        <h1>Olá, {{ explode(' ', trim(Auth::user()->name))[0] }}! <i class="fas fa-road"></i></h1>
                        <p>Este é o seu centro de viagens. Acompanhe suas entregas, atualize o status e mantenha sua localização sincronizada.</p>
                    </div>
                    <div class="driver-live"><span class="online-dot"></span> Sistema operacional</div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card driver-stat">
                        <div><h4>Minhas Viagens</h4><h2>{{ $total ?? $remessas->count() }}</h2><div class="stat-caption">Total atribuído a você</div></div>
                        <i class="fas fa-route" style="color:var(--primary-hover)"></i>
                    </div>
                    <div class="stat-card driver-stat">
                        <div><h4>Em Rota</h4><h2>{{ $emRota }}</h2><div class="stat-caption">Viagens em andamento</div></div>
                        <i class="fas fa-truck-fast" style="color:var(--alert-info)"></i>
                    </div>
                    <div class="stat-card driver-stat">
                        <div><h4>Entregues</h4><h2>{{ $entregues ?? 0 }}</h2><div class="stat-caption">Entregas concluídas</div></div>
                        <i class="fas fa-circle-check" style="color:var(--alert-success)"></i>
                    </div>
                    <div class="stat-card driver-stat">
                        <div><h4>Ocorrências</h4><h2>{{ $atrasadasMotorista }}</h2><div class="stat-caption">Viagens com atraso</div></div>
                        <i class="fas fa-triangle-exclamation" style="color:var(--alert-danger)"></i>
                    </div>
                </div>

                <div class="dashboard-driver-grid">
                    <div class="current-trip">
                        <div class="section-kicker">Viagem em foco</div>
                        @if($viagemAtual)
                            <div style="display:flex;justify-content:space-between;gap:15px;align-items:flex-start;">
                                <div><h2 style="margin:0;">#{{ $viagemAtual->codigo_rastreio }}</h2><p style="color:var(--text-muted);margin:.35rem 0 0;">Carga atribuída para acompanhamento</p></div>
                                <span class="badge {{ $viagemAtual->status == 'Atrasado' ? 'atrasado' : ($viagemAtual->status == 'Entregue' ? 'entregue' : 'transito') }}"><i class="fas fa-circle"></i> {{ $viagemAtual->status }}</span>
                            </div>
                            <div class="trip-route">
                                <div class="route-point"><span>ORIGEM</span><strong>{{ $viagemAtual->origem }}</strong></div>
                                <div class="route-line"></div>
                                <div class="route-point"><span>DESTINO</span><strong>{{ $viagemAtual->destino }}</strong></div>
                            </div>
                            <div class="trip-meta">
                                <div class="trip-meta-item"><small>Tipo de carga</small><strong>{{ $viagemAtual->tipo_carga ?? 'Não informado' }}</strong></div>
                                <div class="trip-meta-item"><small>Previsão</small><strong>{{ !empty($viagemAtual->previsao_entrega) ? \Carbon\Carbon::parse($viagemAtual->previsao_entrega)->format('d/m/Y') : 'Não informada' }}</strong></div>
                            </div>
                            <div class="trip-actions">
                                <button class="btn-driver" onclick="showPage('localizacao', document.querySelector('[onclick*=localizacao]'))"><i class="fas fa-location-crosshairs"></i> Iniciar rastreamento</button>
                                <button class="btn-driver secondary" onclick="showPage('status-page', document.querySelector('[onclick*=status-page]'))"><i class="fas fa-pen-to-square"></i> Atualizar status</button>
                            </div>
                        @else
                            <div class="empty-trip"><i class="fas fa-truck"></i><h3 style="color:var(--text-main);margin-bottom:7px;">Nenhuma viagem ativa</h3><p>Quando uma nova remessa for atribuída, ela aparecerá aqui.</p></div>
                        @endif
                    </div>

                    <div class="driver-panel">
                        <div class="section-kicker">Ações rápidas</div>
                        <h2 style="margin:0;">Controle da viagem</h2>
                        <div class="quick-actions">
                            <button class="quick-action" onclick="showPage('localizacao', document.querySelector('[onclick*=localizacao]'))"><i class="fas fa-map-location-dot"></i><strong>Localização</strong><small>Enviar posição</small></button>
                            <button class="quick-action" onclick="showPage('status-page', document.querySelector('[onclick*=status-page]'))"><i class="fas fa-arrows-rotate"></i><strong>Status</strong><small>Atualizar entrega</small></button>
                            <button class="quick-action" onclick="showPage('criar-alerta-page', document.querySelector('[onclick*=criar-alerta-page]'))"><i class="fas fa-triangle-exclamation"></i><strong>Ocorrência</strong><small>Avisar a central</small></button>
                            <button class="quick-action" onclick="showPage('config', document.querySelector('[onclick*=config]'))"><i class="fas fa-user-gear"></i><strong>Perfil</strong><small>Configurações</small></button>
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:15px;">
                        <div><div class="section-kicker">Resumo operacional</div><h2 style="margin:0;">Minhas últimas viagens</h2></div>
                        <span style="color:var(--text-muted);font-size:.85rem;">{{ $remessas->count() }} remessas encontradas</span>
                    </div>
                    <div class="table-res">
                        <table>
                            <thead><tr><th>Rastreio</th><th>Rota</th><th>Previsão</th><th>Status</th><th>Ação</th></tr></thead>
                            <tbody>
                                @forelse($remessas->take(6) as $r)
                                    <tr>
                                        <td><strong>#{{ $r->codigo_rastreio }}</strong></td>
                                        <td><strong>{{ $r->origem }}</strong><div style="font-size:.78rem;color:var(--text-muted);margin-top:4px;"><i class="fas fa-arrow-right"></i> {{ $r->destino }}</div></td>
                                        <td>{{ !empty($r->previsao_entrega) ? \Carbon\Carbon::parse($r->previsao_entrega)->format('d/m/Y') : '-' }}</td>
                                        <td>@if($r->status == 'Entregue')<span class="badge entregue"><i class="fas fa-circle-check"></i> Entregue</span>@elseif($r->status == 'Atrasado')<span class="badge atrasado"><i class="fas fa-triangle-exclamation"></i> Atrasado</span>@else<span class="badge transito"><i class="fas fa-truck-fast"></i> {{ $r->status }}</span>@endif</td>
                                        <td><button class="btn-driver secondary" style="padding:8px 11px;" onclick="showPage('localizacao', document.querySelector('[onclick*=localizacao]'))"><i class="fas fa-map"></i></button></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px;">Nenhuma viagem atribuída no momento.</td></tr>
                                @endforelse
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

                            <option
                                value="{{ $r->id }}"
                                data-codigo="{{ $r->codigo_rastreio }}"
                                data-origem="{{ $r->origem }}"
                                data-destino="{{ $r->destino }}"
                                data-status="{{ $r->status }}"
                                data-lat-destino="{{ $r->latitude_destino ?? '' }}"
                                data-lng-destino="{{ $r->longitude_destino ?? '' }}"
                                data-cep-destino="{{ $r->destino_cep ?? '' }}"
                            >
                                #{{ $r->codigo_rastreio }}
                                |
                                {{ $r->origem }}
                                →
                                {{ $r->destino }}
                            </option>

                        @endforeach

                    </select>

                    <!-- INFORMAÇÕES DA VIAGEM -->
                    <div class="viagem-info" id="viagemInfo" style="display:none;">
                        <div class="viagem-info-card">
                            <div class="icone"><i class="fas fa-location-dot"></i></div>
                            <small>Local atual</small>
                            <strong id="viagemLocalAtual">Aguardando GPS</strong>
                        </div>

                        <div class="viagem-info-card">
                            <div class="icone"><i class="fas fa-road"></i></div>
                            <small>Distância restante</small>
                            <strong id="viagemDistancia">--</strong>
                        </div>

                        <div class="viagem-info-card">
                            <div class="icone"><i class="fas fa-clock"></i></div>
                            <small>Tempo estimado</small>
                            <strong id="viagemTempo">--</strong>
                        </div>

                        <div class="viagem-info-card">
                            <div class="icone"><i class="fas fa-flag-checkered"></i></div>
                            <small>Chegada estimada</small>
                            <strong id="viagemETA">--</strong>
                        </div>
                    </div>

                    <div class="rota-status" id="rotaStatus">
                        <i class="fas fa-circle-info"></i>
                        Selecione uma remessa e inicie o rastreamento para calcular a rota.
                    </div>

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

    <!-- MAPA + GPS EM TEMPO REAL + ROTA DO MOTORISTA -->
    <script>
        let mapa = null;
        let marcador = null;
        let marcadorDestino = null;
        let rotaLinha = null;
        let watchId = null;

        let ultimaLatitude = null;
        let ultimaLongitude = null;
        let remessaAtivaId = null;

        // Cada remessa possui seu próprio destino.
        const destinosCacheMotorista = {};

        // ==========================================
        // INICIALIZAR MAPA
        // ==========================================
        document.addEventListener("DOMContentLoaded", function () {
            const mapBox = document.getElementById('mapaBox');

            if (!mapBox) return;

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

            const select = document.getElementById('remessaGPS');

            if (select) {
                select.addEventListener('change', function () {
                    prepararRemessaSelecionada(this.value);
                });
            }
        });

        // ==========================================
        // SELECIONAR REMESSA
        // ==========================================
        function prepararRemessaSelecionada(remessaId) {
            remessaAtivaId = remessaId || null;

            limparRota();

            const info = document.getElementById('viagemInfo');
            const rotaStatus = document.getElementById('rotaStatus');

            if (!remessaId) {
                if (info) info.style.display = 'none';

                if (rotaStatus) {
                    rotaStatus.innerHTML =
                        '<i class="fas fa-circle-info"></i> Selecione uma remessa para visualizar a viagem.';
                }

                return;
            }

            if (info) info.style.display = 'grid';

            const option = document.querySelector(
                '#remessaGPS option[value="' + CSS.escape(String(remessaId)) + '"]'
            );

            if (option) {
                const destino = option.dataset.destino || 'Destino não informado';

                if (rotaStatus) {
                    rotaStatus.innerHTML =
                        '<i class="fas fa-location-arrow"></i> Destino: <strong>' +
                        escaparHTML(destino) +
                        '</strong>. Inicie o rastreamento para calcular a rota.';
                }
            }
        }

        // ==========================================
        // INICIAR RASTREAMENTO
        // ==========================================
        function iniciarRastreamento() {
            const remessaId = document.getElementById('remessaGPS').value;
            const statusSpan = document.getElementById('geoStatus');

            if (!remessaId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione uma remessa',
                    text: 'Escolha a remessa que você está transportando.',
                    confirmButtonColor: '#1C3F6E'
                });
                return;
            }

            // Se já havia outro rastreamento, encerra antes de começar.
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }

            remessaAtivaId = remessaId;
            prepararRemessaSelecionada(remessaId);

            document.getElementById('btnIniciarGPS').style.display = 'none';
            document.getElementById('btnPararGPS').style.display = 'inline-flex';

            statusSpan.style.color = 'var(--alert-info)';
            statusSpan.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Obtendo localização...';

            // Se o navegador não possui geolocalização, usa a posição aproximada por IP.
            if (!navigator.geolocation) {
                usarLocalizacaoPorIp(remessaId);
                return;
            }

            // Obtém uma posição imediatamente.
            navigator.geolocation.getCurrentPosition(
                async function (position) {
                    if (remessaAtivaId !== remessaId) return;

                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    ultimaLatitude = latitude;
                    ultimaLongitude = longitude;

                    configurarMarcadorMapa(latitude, longitude);
                    await enviarLocalizacao(latitude, longitude, remessaId);
                    calcularRotaReal(latitude, longitude, remessaId);
                },
                function (error) {
                    console.error('Erro inicial do GPS:', error);

                    // Só usa IP como fallback quando o GPS não conseguiu obter posição.
                    if ([1, 2, 3].includes(error.code)) {
                        usarLocalizacaoPorIp(remessaId);
                    }
                },
                {
                    enableHighAccuracy: true,
                    maximumAge: 0,
                    timeout: 30000
                }
            );

            // ==========================================
            // WATCH POSITION
            // ==========================================
            watchId = navigator.geolocation.watchPosition(
                async function (position) {
                    if (remessaAtivaId !== remessaId) return;

                    console.log('GPS recebido:', position);

                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    ultimaLatitude = latitude;
                    ultimaLongitude = longitude;

                    configurarMarcadorMapa(latitude, longitude);

                    await enviarLocalizacao(latitude, longitude, remessaId);

                    // Recalcula a rota a cada atualização do GPS.
                    calcularRotaReal(latitude, longitude, remessaId);
                },

                function (error) {
                    console.error('ERRO COMPLETO DO GPS:', error);

                    const statusSpan = document.getElementById('geoStatus');

                    if ([1, 2, 3].includes(error.code)) {
                        usarLocalizacaoPorIp(remessaId);
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

                    statusSpan.style.color = 'var(--alert-danger)';
                },

                {
                    enableHighAccuracy: true,
                    maximumAge: 5000,
                    timeout: 30000
                }
            );
        }

        // ==========================================
        // FALLBACK POR IP
        // ==========================================
        let fallbackPorIpAtivo = false;

        async function usarLocalizacaoPorIp(remessaId) {
            if (fallbackPorIpAtivo || remessaAtivaId !== remessaId) return;

            fallbackPorIpAtivo = true;

            const statusSpan = document.getElementById('geoStatus');

            statusSpan.style.color = 'var(--alert-info)';
            statusSpan.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Obtendo localização aproximada pela rede...';

            try {
                const resposta = await fetch('https://ipwho.is/');
                const dados = await resposta.json();

                const latitude = Number(dados.latitude);
                const longitude = Number(dados.longitude);

                if (
                    !resposta.ok ||
                    !dados.success ||
                    !Number.isFinite(latitude) ||
                    !Number.isFinite(longitude)
                ) {
                    throw new Error('Serviço de localização por IP indisponível.');
                }

                if (remessaAtivaId !== remessaId) return;

                ultimaLatitude = latitude;
                ultimaLongitude = longitude;

                configurarMarcadorMapa(latitude, longitude);

                await enviarLocalizacao(latitude, longitude, remessaId);

                calcularRotaReal(latitude, longitude, remessaId);

                statusSpan.style.color = 'var(--alert-warning)';
                statusSpan.innerHTML =
                    '<i class="fas fa-triangle-exclamation"></i> Localização aproximada por IP sincronizada.';
            } catch (erro) {
                console.error('Erro ao localizar pelo IP:', erro);

                statusSpan.style.color = 'var(--alert-danger)';
                statusSpan.innerHTML =
                    '<i class="fas fa-ban"></i> GPS e localização por IP indisponíveis.';
            } finally {
                fallbackPorIpAtivo = false;
            }
        }

        // ==========================================
        // PARAR RASTREAMENTO
        // ==========================================
        function pararRastreamento() {
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }

            const statusSpan = document.getElementById('geoStatus');

            statusSpan.style.color = 'var(--text-muted)';
            statusSpan.innerHTML =
                '<i class="fas fa-location-dot"></i> GPS parado';

            document.getElementById('btnIniciarGPS').style.display = 'inline-flex';
            document.getElementById('btnPararGPS').style.display = 'none';

            const rotaStatus = document.getElementById('rotaStatus');

            if (rotaStatus && remessaAtivaId) {
                rotaStatus.innerHTML =
                    '<i class="fas fa-pause-circle"></i> Rastreamento pausado. A última posição continua no mapa.';
            }
        }

        // ==========================================
        // MARCADOR DO MOTORISTA
        // ==========================================
        function configurarMarcadorMapa(lat, lon) {
            if (!mapa) return;

            const statusSpan = document.getElementById('geoStatus');

            statusSpan.style.color = 'var(--alert-success)';
            statusSpan.innerHTML =
                '<i class="fas fa-circle-check"></i> GPS conectado';

            const iconeMotorista = L.divIcon({
                className: '',
                html: '<div class="motorista-marker"><i class="fas fa-truck"></i></div>',
                iconSize: [38, 38],
                iconAnchor: [19, 19],
                popupAnchor: [0, -20]
            });

            if (marcador) {
                marcador.setLatLng([lat, lon]);
                marcador.setIcon(iconeMotorista);
            } else {
                marcador = L.marker([lat, lon], {
                    icon: iconeMotorista
                }).addTo(mapa);
            }

            marcador.bindPopup(
                '<b>Você está aqui</b><br>Localização do motorista.'
            );

            document.getElementById('infoGPS').style.display = 'block';

            document.getElementById('latitudeAtual').textContent =
                lat.toFixed(8);

            document.getElementById('longitudeAtual').textContent =
                lon.toFixed(8);

            const agora = new Date();

            document.getElementById('ultimaSincronizacao').textContent =
                agora.toLocaleTimeString('pt-BR');

            const localAtual = document.getElementById('viagemLocalAtual');

            if (localAtual) {
                localAtual.textContent =
                    lat.toFixed(5) + ', ' + lon.toFixed(5);
            }
        }

        // ==========================================
        // DESTINO DA REMESSA
        // ==========================================
        // Primeiro usa latitude/longitude salvas na remessa.
        // Assim o mapa nunca precisa adivinhar a cidade pelo texto.
        // Para remessas antigas sem coordenadas, tenta geocodificar o endereço.
        async function obterCoordenadasDestino(destino, remessaId) {
            if (destinosCacheMotorista[remessaId]) {
                return destinosCacheMotorista[remessaId];
            }

            const option = document.querySelector(
                '#remessaGPS option[value="' + CSS.escape(String(remessaId)) + '"]'
            );

            if (!option) {
                throw new Error('Remessa não encontrada.');
            }

            const latSalva = Number(option.dataset.latDestino);
            const lngSalva = Number(option.dataset.lngDestino);

            // CAMINHO PRINCIPAL: coordenadas exatas cadastradas pelo administrador.
            if (
                Number.isFinite(latSalva) &&
                Number.isFinite(lngSalva) &&
                latSalva >= -35 &&
                latSalva <= 6 &&
                lngSalva >= -75 &&
                lngSalva <= -30
            ) {
                const coordenadasSalvas = {
                    lat: latSalva,
                    lon: lngSalva,
                    nome: destino || 'Destino da remessa',
                    origem: 'Coordenadas cadastradas na remessa'
                };

                destinosCacheMotorista[remessaId] = coordenadasSalvas;
                return coordenadasSalvas;
            }

            // FALLBACK: remessa antiga sem latitude/longitude.
            if (!destino) {
                throw new Error('Esta remessa não possui destino informado.');
            }

            const cep = String(option.dataset.cepDestino || '')
                .replace(/\D/g, '');

            const consultas = [];

            // O CEP reduz bastante a chance de escolher outra cidade.
            if (cep.length === 8) {
                consultas.push(cep + ', Brasil');
            }

            consultas.push(destino + ', Brasil');

            let ultimoErro = null;

            for (const consulta of consultas) {
                try {
                    const params = new URLSearchParams({
                        q: consulta,
                        format: 'jsonv2',
                        addressdetails: '1',
                        limit: '1',
                        countrycodes: 'br'
                    });

                    const resposta = await fetch(
                        'https://nominatim.openstreetmap.org/search?' + params.toString(),
                        { headers: { 'Accept': 'application/json' } }
                    );

                    if (!resposta.ok) {
                        throw new Error('Serviço de geocodificação indisponível.');
                    }

                    const resultados = await resposta.json();

                    if (!Array.isArray(resultados) || resultados.length === 0) {
                        throw new Error('Endereço não encontrado.');
                    }

                    const resultado = resultados[0];
                    const lat = Number(resultado.lat);
                    const lon = Number(resultado.lon);

                    if (!Number.isFinite(lat) || !Number.isFinite(lon)) {
                        throw new Error('Coordenadas do destino inválidas.');
                    }

                    const coordenadas = {
                        lat: lat,
                        lon: lon,
                        nome: resultado.display_name || destino,
                        origem: 'Geocodificação do endereço'
                    };

                    destinosCacheMotorista[remessaId] = coordenadas;
                    return coordenadas;

                } catch (erro) {
                    ultimoErro = erro;
                }
            }

            throw ultimoErro || new Error(
                'Não foi possível localizar o endereço do destino.'
            );
        }

        // ==========================================
        // CALCULAR ROTA REAL PELAS ESTRADAS
        // ==========================================
        async function calcularRotaReal(lat, lon, remessaId) {
            if (!mapa || !remessaId) return;

            const remessaDaRota = String(remessaId);

            if (String(remessaAtivaId) !== remessaDaRota) return;

            const option = document.querySelector(
                '#remessaGPS option[value="' + CSS.escape(remessaDaRota) + '"]'
            );

            if (!option) return;

            const destinoTexto = option.dataset.destino || '';

            if (!destinoTexto) return;

            const rotaStatus = document.getElementById('rotaStatus');

            try {
                if (rotaStatus) {
                    rotaStatus.innerHTML =
                        '<i class="fas fa-spinner fa-spin"></i> Calculando rota até ' +
                        escaparHTML(destinoTexto) + '...';
                }

                const destino = await obterCoordenadasDestino(
                    destinoTexto,
                    remessaDaRota
                );

                if (rotaStatus) {
                    const fonte = destino.origem === 'Coordenadas cadastradas na remessa'
                        ? 'Destino exato cadastrado'
                        : 'Destino localizado pelo endereço';

                    rotaStatus.innerHTML =
                        '<i class="fas fa-location-dot"></i> ' +
                        escaparHTML(fonte) +
                        ': <strong>' +
                        escaparHTML(destinoTexto) +
                        '</strong>';
                }

                // Impede que uma resposta antiga desenhe a rota de outra remessa.
                if (String(remessaAtivaId) !== remessaDaRota) return;

                const url =
                    'https://router.project-osrm.org/route/v1/driving/' +
                    lon + ',' + lat + ';' +
                    destino.lon + ',' + destino.lat +
                    '?overview=full&geometries=geojson';

                const resposta = await fetch(url);

                if (!resposta.ok) {
                    throw new Error('Servidor de rotas indisponível.');
                }

                const dados = await resposta.json();

                if (
                    !dados.routes ||
                    !dados.routes.length ||
                    String(remessaAtivaId) !== remessaDaRota
                ) {
                    throw new Error('Rota não encontrada.');
                }

                const rota = dados.routes[0];

                // Remove a rota anterior.
                if (rotaLinha) {
                    mapa.removeLayer(rotaLinha);
                }

                rotaLinha = L.geoJSON(rota.geometry, {
                    style: {
                        weight: 6,
                        opacity: 0.85
                    }
                }).addTo(mapa);

                // Marcador do destino.
                const iconeDestino = L.divIcon({
                    className: '',
                    html: '<div class="destino-marker"><i class="fas fa-flag"></i></div>',
                    iconSize: [34, 34],
                    iconAnchor: [17, 34],
                    popupAnchor: [0, -34]
                });

                if (marcadorDestino) {
                    marcadorDestino.setLatLng([
                        destino.lat,
                        destino.lon
                    ]);
                    marcadorDestino.setIcon(iconeDestino);
                } else {
                    marcadorDestino = L.marker(
                        [destino.lat, destino.lon],
                        { icon: iconeDestino }
                    ).addTo(mapa);
                }

                marcadorDestino.bindPopup(
                    '<b>Destino</b><br>' +
                    escaparHTML(destinoTexto)
                );

                // Distância em km.
                const distanciaKm = rota.distance / 1000;

                // Duração em minutos.
                const duracaoMin = Math.max(
                    1,
                    Math.round(rota.duration / 60)
                );

                document.getElementById('viagemDistancia').textContent =
                    formatarDistancia(distanciaKm);

                document.getElementById('viagemTempo').textContent =
                    formatarDuracao(duracaoMin);

                const eta = new Date(
                    Date.now() + rota.duration * 1000
                );

                document.getElementById('viagemETA').textContent =
                    eta.toLocaleTimeString('pt-BR', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                if (rotaStatus) {
                    rotaStatus.innerHTML =
                        '<i class="fas fa-route"></i> Rota ativa até <strong>' +
                        escaparHTML(destinoTexto) +
                        '</strong>. Última atualização: ' +
                        new Date().toLocaleTimeString('pt-BR');
                }

                // Enquadra motorista + destino + rota.
                const grupo = L.featureGroup([
                    marcador,
                    marcadorDestino,
                    rotaLinha
                ].filter(Boolean));

                mapa.fitBounds(grupo.getBounds(), {
                    padding: [35, 35]
                });

            } catch (erro) {
                console.error('Erro ao calcular rota:', erro);

                if (String(remessaAtivaId) !== remessaDaRota) return;

                if (rotaStatus) {
                    rotaStatus.innerHTML =
                        '<i class="fas fa-triangle-exclamation"></i> ' +
                        escaparHTML(erro.message || 'Não foi possível calcular a rota.');
                }
            }
        }

        // ==========================================
        // FORMATADORES
        // ==========================================
        function formatarDistancia(km) {
            if (!Number.isFinite(km)) return '--';

            if (km < 1) {
                return Math.round(km * 1000) + ' m';
            }

            return km.toLocaleString('pt-BR', {
                minimumFractionDigits: km < 10 ? 1 : 0,
                maximumFractionDigits: 1
            }) + ' km';
        }

        function formatarDuracao(minutos) {
            if (!Number.isFinite(minutos)) return '--';

            const horas = Math.floor(minutos / 60);
            const mins = minutos % 60;

            if (horas <= 0) {
                return mins + ' min';
            }

            if (mins === 0) {
                return horas + (horas === 1 ? ' hora' : ' horas');
            }

            return horas + (horas === 1 ? ' hora e ' : ' horas e ') +
                mins + ' min';
        }

        function escaparHTML(valor) {
            return String(valor ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // ==========================================
        // LIMPAR ROTA
        // ==========================================
        function limparRota() {
            if (!mapa) return;

            if (rotaLinha) {
                mapa.removeLayer(rotaLinha);
                rotaLinha = null;
            }

            if (marcadorDestino) {
                mapa.removeLayer(marcadorDestino);
                marcadorDestino = null;
            }

            if (marcador) {
                mapa.removeLayer(marcador);
                marcador = null;
            }

            ultimaLatitude = null;
            ultimaLongitude = null;

            const distancia = document.getElementById('viagemDistancia');
            const tempo = document.getElementById('viagemTempo');
            const eta = document.getElementById('viagemETA');
            const local = document.getElementById('viagemLocalAtual');

            if (distancia) distancia.textContent = '--';
            if (tempo) tempo.textContent = '--';
            if (eta) eta.textContent = '--';
            if (local) local.textContent = 'Aguardando GPS';
        }

        // ==========================================
        // ENVIAR LOCALIZAÇÃO PARA API
        // ==========================================
        async function enviarLocalizacao(latitude, longitude, remessaId) {
            const statusSpan = document.getElementById('geoStatus');

            try {
                const resposta = await fetch(
                    '/api/localizacao',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            latitude: latitude,
                            longitude: longitude,
                            remessa_id: remessaId
                        })
                    }
                );

                const dados = await resposta.json();

                if (!resposta.ok) {
                    console.error('Erro da API:', dados);

                    statusSpan.style.color = 'var(--alert-danger)';
                    statusSpan.innerHTML =
                        '<i class="fas fa-circle-xmark"></i> Erro ao sincronizar GPS';

                    return;
                }

                console.log('Localização enviada:', dados);

                statusSpan.style.color = 'var(--alert-success)';
                statusSpan.innerHTML =
                    '<i class="fas fa-circle-check"></i> Localização sincronizada';

            } catch (erro) {
                console.error('Erro ao enviar localização:', erro);

                statusSpan.style.color = 'var(--alert-danger)';
                statusSpan.innerHTML =
                    '<i class="fas fa-wifi"></i> Erro de conexão com o servidor';
            }
        }

        // Se a página for fechada, encerra o watch do navegador.
        window.addEventListener('beforeunload', function () {
            if (watchId !== null && navigator.geolocation) {
                navigator.geolocation.clearWatch(watchId);
            }
        });
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
