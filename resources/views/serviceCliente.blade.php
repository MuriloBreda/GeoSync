<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync | Área do Cliente</title>

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

        /* SIDEBAR (PADRÃO ADMIN) */
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
            display: inline-block;
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

        .alert-card {
            display: flex;
            gap: 15px;
            background: var(--card);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 15px;
            border-left: 5px solid var(--alert-danger);
            border: 1px solid var(--border);
            border-left-width: 5px;
            box-shadow: var(--shadow-sm);
        }

        .alert-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #fee2e2;
            color: #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .alert-content {
            flex: 1;
        }

        .alert-content h3 {
            margin-bottom: 4px;
            font-size: 1rem;
        }

        .alert-footer {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #3b82f6;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            box-shadow: 0 0 10px #3b82f6;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(59, 130, 246, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
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

        .mobile-menu-toggle { display: none; }


        /* ================================
           DASHBOARD DO CLIENTE - REDESIGN
           ================================ */
        .dashboard-top {
            display:flex;
            justify-content:space-between;
            align-items:flex-end;
            gap:24px;
            margin-bottom:24px;
        }

        .dashboard-kicker {
            display:inline-flex;
            align-items:center;
            gap:8px;
            color:var(--primary-hover);
            font-size:.78rem;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:.8px;
            margin-bottom:7px;
        }

        .dashboard-kicker .dot {
            width:7px;
            height:7px;
            border-radius:50%;
            background:var(--alert-success);
            box-shadow:0 0 0 4px rgba(16,185,129,.12);
        }

        .dashboard-top h1 {
            font-size:clamp(1.65rem,2.4vw,2.2rem);
            line-height:1.15;
            letter-spacing:-.7px;
            margin-bottom:8px;
        }

        .dashboard-top p {
            color:var(--text-muted);
            font-size:.94rem;
            max-width:680px;
        }

        .dashboard-actions {
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            justify-content:flex-end;
        }

        .dashboard-action {
            display:inline-flex;
            align-items:center;
            gap:9px;
            border:1px solid var(--border);
            background:var(--card);
            color:var(--text-main);
            padding:11px 15px;
            border-radius:11px;
            font-family:inherit;
            font-weight:700;
            cursor:pointer;
            text-decoration:none;
            transition:.2s ease;
            box-shadow:var(--shadow-sm);
        }

        .dashboard-action:hover {
            border-color:rgba(47,111,178,.35);
            color:var(--primary-hover);
            transform:translateY(-1px);
        }

        .dashboard-action.primary {
            color:#fff;
            background:var(--primary);
            border-color:var(--primary);
            box-shadow:0 8px 20px rgba(28,63,110,.18);
        }

        .dashboard-action.primary:hover {
            color:#fff;
            background:var(--primary-hover);
            border-color:var(--primary-hover);
        }

        .customer-hero {
            position:relative;
            overflow:hidden;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:24px;
            padding:24px 26px;
            margin-bottom:20px;
            border-radius:18px;
            color:#fff;
            background:linear-gradient(135deg,#0B1F36 0%,#1C3F6E 58%,#2F6FB2 100%);
            box-shadow:0 14px 35px rgba(11,31,54,.14);
        }

        .customer-hero::after {
            content:"";
            position:absolute;
            width:210px;
            height:210px;
            right:-70px;
            top:-105px;
            border-radius:50%;
            background:rgba(255,255,255,.08);
        }

        .customer-hero-content { position:relative; z-index:1; }

        .customer-hero h2 {
            font-size:1.2rem;
            margin-bottom:7px;
        }

        .customer-hero p {
            color:rgba(255,255,255,.75);
            font-size:.86rem;
            line-height:1.6;
            max-width:670px;
        }

        .customer-hero-metric {
            position:relative;
            z-index:1;
            min-width:150px;
            padding:14px 18px;
            border-radius:14px;
            background:rgba(255,255,255,.1);
            border:1px solid rgba(255,255,255,.12);
            backdrop-filter:blur(8px);
        }

        .customer-hero-metric small {
            display:block;
            color:rgba(255,255,255,.68);
            font-size:.72rem;
            margin-bottom:4px;
        }

        .customer-hero-metric strong { font-size:1.45rem; }

        .client-stats-grid {
            display:grid;
            grid-template-columns:repeat(4,minmax(0,1fr));
            gap:14px;
            margin-bottom:20px;
        }

        .client-stat {
            position:relative;
            min-height:126px;
            padding:18px;
            border:1px solid var(--border);
            border-radius:16px;
            background:var(--card);
            box-shadow:var(--shadow-sm);
            overflow:hidden;
        }

        .client-stat::before {
            content:"";
            position:absolute;
            left:0;
            top:0;
            bottom:0;
            width:4px;
            background:var(--stat-color,var(--primary-hover));
        }

        .client-stat-head {
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:10px;
            margin-bottom:13px;
        }

        .client-stat-label {
            color:var(--text-muted);
            font-size:.77rem;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:.45px;
        }

        .client-stat-icon {
            width:38px;
            height:38px;
            border-radius:11px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:var(--stat-bg);
            color:var(--stat-color);
            font-size:1rem;
        }

        .client-stat-value {
            display:flex;
            align-items:baseline;
            gap:8px;
        }

        .client-stat-value strong {
            font-size:1.8rem;
            line-height:1;
            letter-spacing:-.5px;
        }

        .client-stat-value span {
            color:var(--text-muted);
            font-size:.72rem;
            font-weight:600;
        }

        .dashboard-charts {
            display:grid;
            grid-template-columns:minmax(0,1.7fr) minmax(300px,.8fr);
            gap:16px;
            margin-bottom:16px;
        }

        .dashboard-card {
            background:var(--card);
            border:1px solid var(--border);
            border-radius:16px;
            padding:20px;
            box-shadow:var(--shadow-sm);
        }

        .dashboard-card-header {
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:16px;
            margin-bottom:18px;
        }

        .dashboard-card-header h3 { font-size:1rem; margin-bottom:4px; }
        .dashboard-card-header p { color:var(--text-muted); font-size:.78rem; }

        .dashboard-card-badge {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:6px 9px;
            border-radius:9px;
            background:var(--input-bg);
            border:1px solid var(--border);
            color:var(--text-muted);
            font-size:.7rem;
            font-weight:700;
            white-space:nowrap;
        }

        .chart-wrap-line { height:275px; position:relative; }
        .chart-wrap-doughnut { height:275px; position:relative; }

        .dashboard-bottom {
            display:grid;
            grid-template-columns:minmax(0,1.65fr) minmax(290px,.8fr);
            gap:16px;
        }

        .recent-list { display:flex; flex-direction:column; gap:10px; }

        .recent-shipment {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:14px;
            padding:13px 14px;
            border:1px solid var(--border);
            border-radius:12px;
            transition:.2s ease;
        }

        .recent-shipment:hover {
            border-color:rgba(47,111,178,.35);
            background:var(--input-bg);
        }

        .shipment-main { min-width:0; }

        .shipment-code {
            display:flex;
            align-items:center;
            gap:8px;
            font-size:.84rem;
            font-weight:800;
            margin-bottom:4px;
        }

        .shipment-route {
            color:var(--text-muted);
            font-size:.74rem;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
            max-width:560px;
        }

        .mini-status {
            flex-shrink:0;
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:6px 9px;
            border-radius:999px;
            font-size:.68rem;
            font-weight:800;
        }

        .mini-status.entregue { background:rgba(16,185,129,.12); color:#059669; }
        .mini-status.transito { background:rgba(59,130,246,.12); color:#2563eb; }
        .mini-status.atrasado { background:rgba(239,68,68,.12); color:#dc2626; }

        .empty-dashboard {
            text-align:center;
            padding:34px 18px;
            color:var(--text-muted);
        }

        .empty-dashboard i {
            font-size:1.8rem;
            margin-bottom:10px;
            opacity:.45;
        }

        .client-alert {
            display:flex;
            gap:11px;
            padding:12px;
            border:1px solid var(--border);
            border-radius:12px;
            margin-bottom:10px;
            background:var(--input-bg);
        }

        .client-alert:last-child { margin-bottom:0; }

        .client-alert-icon {
            width:35px;
            height:35px;
            flex:0 0 35px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:10px;
            background:rgba(239,68,68,.11);
            color:#ef4444;
        }

        .client-alert strong { display:block; font-size:.78rem; margin-bottom:3px; }
        .client-alert p { color:var(--text-muted); font-size:.71rem; line-height:1.45; }

        .dashboard-view-all {
            display:flex;
            align-items:center;
            justify-content:center;
            gap:7px;
            width:100%;
            margin-top:12px;
            padding:10px;
            border-radius:10px;
            color:var(--primary-hover);
            background:var(--input-bg);
            border:1px solid var(--border);
            font-size:.76rem;
            font-weight:800;
            cursor:pointer;
            font-family:inherit;
        }

        .dashboard-view-all:hover { border-color:rgba(47,111,178,.35); }

        @media (max-width:1050px) {
            .client-stats-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
            .dashboard-charts,.dashboard-bottom { grid-template-columns:1fr; }
        }

        @media (max-width:768px) {
            .dashboard-top { align-items:flex-start; flex-direction:column; }
            .dashboard-actions { width:100%; justify-content:flex-start; }
            .dashboard-action { flex:1; }
            .customer-hero { align-items:flex-start; flex-direction:column; }
            .customer-hero-metric { width:100%; }
            .client-stats-grid { grid-template-columns:1fr 1fr; gap:10px; }
            .dashboard-card { padding:16px; }
            .chart-wrap-line,.chart-wrap-doughnut { height:240px; }
        }

        @media (max-width:480px) {
            .client-stats-grid { grid-template-columns:1fr; }
            .dashboard-action { flex:none; width:100%; }
            .recent-shipment { align-items:flex-start; flex-direction:column; }
        }

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
                <div class="menu-title">ÁREA DO CLIENTE</div>

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
                    <span>Rastreamento</span>
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

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="main-content">

            <!-- ABA 1: DASHBOARD DO CLIENTE -->
            <section id="dashboard" class="page active">
                <div class="dashboard-top">
                    <div>
                        <div class="dashboard-kicker"><span class="dot"></span> Área do cliente</div>
                        <h1>Olá, {{ explode(' ', trim(Auth::user()->name))[0] }} 👋</h1>
                        <p>Acompanhe suas encomendas, veja o status das entregas e saiba onde está cada remessa.</p>
                    </div>
                    <div class="dashboard-actions">
                        <button class="dashboard-action" type="button" onclick="showPage('remessas', document.querySelectorAll('.nav-link')[1])">
                            <i class="fas fa-box"></i> Minhas remessas
                        </button>
                        <button class="dashboard-action primary" type="button" onclick="showPage('localizacao-page', document.querySelectorAll('.nav-link')[2])">
                            <i class="fas fa-location-crosshairs"></i> Rastrear agora
                        </button>
                    </div>
                </div>

                <div class="customer-hero">
                    <div class="customer-hero-content">
                        <h2>Suas entregas em um só lugar</h2>
                        <p>O GeoSync acompanha suas remessas e mantém você informado sobre o andamento da entrega. Se uma encomenda estiver em rota, você pode acompanhar a localização do motorista em tempo real.</p>
                    </div>
                    <div class="customer-hero-metric">
                        <small>Remessas cadastradas</small>
                        <strong>{{ $total ?? 0 }}</strong>
                    </div>
                </div>

                <div class="client-stats-grid">
                    <div class="client-stat" style="--stat-color:#1C3F6E;--stat-bg:rgba(28,63,110,.10);">
                        <div class="client-stat-head">
                            <span class="client-stat-label">Minhas remessas</span>
                            <span class="client-stat-icon"><i class="fas fa-box"></i></span>
                        </div>
                        <div class="client-stat-value"><strong>{{ $total ?? 0 }}</strong><span>total</span></div>
                    </div>

                    <div class="client-stat" style="--stat-color:#3b82f6;--stat-bg:rgba(59,130,246,.10);">
                        <div class="client-stat-head">
                            <span class="client-stat-label">Em trânsito</span>
                            <span class="client-stat-icon"><i class="fas fa-truck-fast"></i></span>
                        </div>
                        <div class="client-stat-value"><strong>{{ $transito ?? 0 }}</strong><span>em rota</span></div>
                    </div>

                    <div class="client-stat" style="--stat-color:#10b981;--stat-bg:rgba(16,185,129,.10);">
                        <div class="client-stat-head">
                            <span class="client-stat-label">Entregues</span>
                            <span class="client-stat-icon"><i class="fas fa-circle-check"></i></span>
                        </div>
                        <div class="client-stat-value"><strong>{{ $entregues ?? 0 }}</strong><span>concluídas</span></div>
                    </div>

                    <div class="client-stat" style="--stat-color:#ef4444;--stat-bg:rgba(239,68,68,.10);">
                        <div class="client-stat-head">
                            <span class="client-stat-label">Atrasadas</span>
                            <span class="client-stat-icon"><i class="fas fa-clock"></i></span>
                        </div>
                        <div class="client-stat-value"><strong>{{ $atrasadas ?? 0 }}</strong><span>atenção</span></div>
                    </div>
                </div>

                <div class="dashboard-charts">
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <div>
                                <h3>Histórico de entregas</h3>
                                <p>Acompanhe a evolução das suas entregas</p>
                            </div>
                            <span class="dashboard-card-badge"><i class="fas fa-chart-line"></i> Últimas semanas</span>
                        </div>
                        <div class="chart-wrap-line"><canvas id="chartLinhaCliente"></canvas></div>
                    </div>

                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <div>
                                <h3>Status das minhas remessas</h3>
                                <p>Distribuição atual</p>
                            </div>
                            <span class="dashboard-card-badge"><i class="fas fa-chart-pie"></i> Agora</span>
                        </div>
                        <div class="chart-wrap-doughnut"><canvas id="chartPizzaCliente"></canvas></div>
                    </div>
                </div>

                <div class="dashboard-bottom">
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <div>
                                <h3>Últimas remessas</h3>
                                <p>Veja rapidamente o que está acontecendo com suas encomendas</p>
                            </div>
                        </div>

                        <div class="recent-list">
                            @forelse($remessas->take(5) as $r)
                                @php
                                    $statusClass = $r->status == 'Entregue' ? 'entregue' : ($r->status == 'Atrasado' ? 'atrasado' : 'transito');
                                    $statusIcon = $r->status == 'Entregue' ? 'fa-circle-check' : ($r->status == 'Atrasado' ? 'fa-clock' : 'fa-truck-fast');
                                @endphp
                                <div class="recent-shipment">
                                    <div class="shipment-main">
                                        <div class="shipment-code"><i class="fas fa-box" style="color:var(--primary-hover)"></i> #{{ $r->codigo_rastreio }}</div>
                                        <div class="shipment-route">{{ $r->origem }} <i class="fas fa-arrow-right" style="font-size:.65rem"></i> {{ $r->destino }}</div>
                                    </div>
                                    <span class="mini-status {{ $statusClass }}"><i class="fas {{ $statusIcon }}"></i> {{ $r->status }}</span>
                                </div>
                            @empty
                                <div class="empty-dashboard">
                                    <i class="fas fa-box-open"></i>
                                    <p>Você ainda não possui remessas cadastradas.</p>
                                </div>
                            @endforelse
                        </div>

                        @if($remessas->count() > 5)
                            <button class="dashboard-view-all" type="button" onclick="showPage('remessas', document.querySelectorAll('.nav-link')[1])">
                                Ver todas as remessas <i class="fas fa-arrow-right"></i>
                            </button>
                        @endif
                    </div>

                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <div>
                                <h3>Central de alertas</h3>
                                <p>Informações importantes das suas entregas</p>
                            </div>
                        </div>

                        @forelse($alertas->take(3) as $a)
                            <div class="client-alert">
                                <div class="client-alert-icon"><i class="fas fa-triangle-exclamation"></i></div>
                                <div>
                                    <strong>{{ $a->tipo }}</strong>
                                    <p>{{ $a->mensagem }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="empty-dashboard" style="padding:25px 10px;">
                                <i class="fas fa-shield-check"></i>
                                <p>Nenhum alerta importante no momento.</p>
                            </div>
                        @endforelse

                        @if($alertas->count() > 3)
                            <button class="dashboard-view-all" type="button" onclick="showPage('alertas-page', document.querySelectorAll('.nav-link')[3])">
                                Ver todos os alertas <i class="fas fa-arrow-right"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </section>

            <!-- ABA 2: MINHAS REMESSAS -->
            <section id="remessas" class="page">
                <div class="content-card">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h2>Minhas Remessas</h2>
                        <span style="color:var(--text-muted)">
                            {{ $remessas->count() }} encomendas
                        </span>
                    </div>

                    <div class="table-res">
                        <table>
                            <thead>
                                <tr>
                                    <th>Rastreio</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    <th>Motorista</th>
                                    <th>Status</th>
                                    {{-- <th>Ações</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($remessas as $r)
                                <tr>
                                    <td><strong>#{{ $r->codigo_rastreio }}</strong></td>
                                    <td>{{ $r->origem }}</td>
                                    <td>{{ $r->destino }}</td>
                                    <td>
                                        @if($r->motorista)
                                            <i class="fas fa-user-tie" style="color:var(--primary)"></i>
                                            {{ $r->motorista->name }}
                                        @else
                                            <span style="color:var(--text-muted)">Aguardando atribuição</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $r->status == 'Entregue' ? 'entregue' : ($r->status == 'Atrasado' ? 'atrasado' : 'transito') }}">
                                            {{ $r->status }}
                                        </span>
                                    </td>
                                    {{-- <td>
                                        <a href="{{ route('remessas.show', $r->id) }}" style="color: var(--primary); text-decoration: none;">
                                            <i class="fas fa-eye"></i> Visualizar
                                        </a>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ABA 3: RASTREAMENTO -->
            <section id="localizacao-page" class="page">
    <h1 style="margin-bottom: 1.5rem;">Rastreamento em Tempo Real</h1>

    <div class="content-card">

        <div style="margin-bottom: 20px;">
            <label for="selectRastreioCliente">
                <i class="fas fa-search-location"></i>
                Escolha a Encomenda para Rastrear:
            </label>

            <select id="selectRastreioCliente"
                    onchange="alterarRemessaRastreio(this.value)">
                <option value="">-- Selecione um código de rastreio --</option>

                @foreach($remessas as $r)
                    <option
                        value="{{ $r->id }}"
                        data-codigo="{{ $r->codigo_rastreio }}"
                        data-origem="{{ $r->origem }}"
                        data-destino="{{ $r->destino }}"
                        data-status="{{ $r->status }}"
                    >
                        #{{ $r->codigo_rastreio }}
                        (De: {{ $r->origem }} Para: {{ $r->destino }})
                    </option>
                @endforeach
            </select>
        </div>

        <div id="painelRotaCliente"
             style="display:none; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; margin-bottom:18px;">

            <div class="content-card" style="margin:0; padding:16px;">
                <small style="display:block; opacity:.7;">
                    <i class="fas fa-location-dot"></i> Local atual
                </small>
                <strong id="rotaLocalAtual">Aguardando GPS...</strong>
            </div>

            <div class="content-card" style="margin:0; padding:16px;">
                <small style="display:block; opacity:.7;">
                    <i class="fas fa-road"></i> Distância restante
                </small>
                <strong id="rotaDistancia">--</strong>
            </div>

            <div class="content-card" style="margin:0; padding:16px;">
                <small style="display:block; opacity:.7;">
                    <i class="fas fa-clock"></i> Tempo estimado
                </small>
                <strong id="rotaTempo">--</strong>
            </div>

            <div class="content-card" style="margin:0; padding:16px;">
                <small style="display:block; opacity:.7;">
                    <i class="fas fa-flag-checkered"></i> Chegada estimada
                </small>
                <strong id="rotaETA">--</strong>
            </div>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:15px; flex-wrap:wrap;">
            <div>
                <span class="pulse-dot"></span>
                <strong style="color:var(--text-main);">Rastreamento em tempo real</strong>
                <div id="ultimaAtualizacaoRota" style="font-size:.82rem; opacity:.65; margin-top:4px;">
                    Aguardando seleção
                </div>
            </div>

            <span id="statusPedidoCliente" class="badge transito">
                Aguardando Seleção
            </span>
        </div>

        <div id="mapaCliente"
             style="width:100%; height:500px; border-radius:12px; z-index:1;">
        </div>

        <div id="legendaRotaCliente"
             style="display:none; margin-top:14px; padding:12px 15px; border-radius:10px; background:rgba(37,99,235,.08); font-size:.9rem;">
            <i class="fas fa-truck"></i> <strong>Motorista</strong>
            &nbsp;&nbsp;&nbsp;
            <i class="fas fa-location-dot"></i> <strong>Destino</strong>
            &nbsp;&nbsp;&nbsp;
            <i class="fas fa-route"></i> Rota pelas estradas
        </div>

    </div>
</section>

            <!-- ABA 4: ALERTAS -->
            <section id="alertas-page" class="page">
                <h1 style="margin-bottom:1.5rem;">Alertas de Segurança</h1>
                <div class="content-card">
                    @forelse($alertas as $a)
                    <div class="alert-card">
                        <div class="alert-icon">
                            <i class="fas fa-triangle-exclamation"></i>
                        </div>
                        <div class="alert-content">
                            <h3>{{ $a->tipo }}</h3>
                            <p>{{ $a->mensagem }}</p>
                            <div class="alert-footer">
                                <span><i class="fas fa-truck-moving"></i> Motorista: {{ $a->remessa->motorista->name ?? 'Não atribuído' }}</span>
                                <span><i class="fas fa-box"></i> Produto: {{ $a->remessa->tipo_carga ?? '-' }}</span>
                                <span><i class="fas fa-clock"></i> {{ $a->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p style="color:var(--text-muted); text-align:center; padding:20px;">Nenhum alerta crítico detectado no momento.</p>
                    @endforelse
                </div>
            </section>

            <!-- ABA 5: CONFIGURAÇÕES (IDÊNTICA À DO ADMIN) -->
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
                                <p style="font-size:0.75rem; color:var(--text-muted);">Alertas de entrega e atraso</p>
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

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

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

            if (id === 'localizacao-page' && mapaCliente) {
                setTimeout(() => {
                    mapaCliente.invalidateSize();
                }, 200);
            }
        }

        // MÁSCARA PARA TELEFONE
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

        // SWEETALERT PARA CONFIGURAÇÕES
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

        // Flash Messages Laravel
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

        // GRÁFICOS DO CLIENTE
        const chartLinhaEl = document.getElementById('chartLinhaCliente');
        if (chartLinhaEl) {
            new Chart(chartLinhaEl, {
                type: 'line',
                data: {
                    labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana Atual'],
                    datasets: [{
                        label: 'Entregas concluídas',
                        data: [
                            {{ $entregasSemana1 ?? 0 }},
                            {{ $entregasSemana2 ?? 0 }},
                            {{ $entregasSemana3 ?? 0 }},
                            {{ $entregues ?? 0 }}
                        ],
                        borderColor: '#2F6FB2',
                        backgroundColor: 'rgba(47, 111, 178, 0.10)',
                        pointBackgroundColor: '#2F6FB2',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'start',
                            labels: { usePointStyle: true, boxWidth: 7, padding: 18 }
                        },
                        tooltip: {
                            backgroundColor: '#0B1F36',
                            padding: 12,
                            cornerRadius: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' entrega(s) concluída(s)';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { color: '#64748b', font: { size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            suggestedMax: Math.max(4, ({{ $entregues ?? 0 }}) + 1),
                            ticks: { precision: 0, color: '#64748b', stepSize: 1 },
                            grid: { color: 'rgba(148,163,184,.15)' },
                            border: { display: false }
                        }
                    }
                }
            });
        }

        const chartPizzaEl = document.getElementById('chartPizzaCliente');
        if (chartPizzaEl) {
            new Chart(chartPizzaEl, {
                type: 'doughnut',
                data: {
                    labels: ['Em trânsito', 'Entregues', 'Atrasadas'],
                    datasets: [{
                        data: [{{ $transito ?? 0 }}, {{ $entregues ?? 0 }}, {{ $atrasadas ?? 0 }}],
                        backgroundColor: ['#3b82f6', '#10b981', '#ef4444'],
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 16, boxWidth: 8, font: { size: 11 } }
                        },
                        tooltip: {
                            backgroundColor: '#0B1F36',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.parsed;
                                }
                            }
                        }
                    }
                }
            });
        }

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

    <!-- MAPA + ROTA REAL DO CLIENTE -->
<script>
let mapaCliente = null;
let marcadorMotoristaCliente = null;
let marcadorDestinoCliente = null;
let linhaRotaCliente = null;

let remessaRastreadaId = null;
let intervaloLocalizacaoCliente = null;
let primeiraLocalizacaoRecebida = false;

/*
 * Coordenadas do destino ficam separadas por remessa.
 */
const destinosCache = {};

/* Inicializa o mapa */
document.addEventListener("DOMContentLoaded", function () {

    const container = document.getElementById("mapaCliente");

    if (!container || typeof L === "undefined") {
        console.error("Leaflet/mapaCliente não encontrado.");
        return;
    }

    mapaCliente = L.map("mapaCliente").setView(
        [-14.2350, -51.9253],
        4
    );

    L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            attribution: "&copy; OpenStreetMap contributors"
        }
    ).addTo(mapaCliente);

    const select = document.getElementById("selectRastreioCliente");

    if (select && select.value) {
        alterarRemessaRastreio(select.value);
    }
});


/*
 * Busca a última localização salva pelo motorista.
 * O motorista envia latitude + longitude + remessa_id
 * para POST /api/localizacao.
 */
async function buscarLocalizacaoRemessa(remessaId) {

    if (!remessaId) return;

    try {

        const resposta = await fetch(
            "/api/localizacao?remessa_id=" +
            encodeURIComponent(remessaId) +
            "&_=" + Date.now(),
            {
                method: "GET",
                headers: {
                    "Accept": "application/json"
                },
                cache: "no-store"
            }
        );

        const dados = await resposta.json();

        if (!resposta.ok) {
            throw new Error(
                dados.message ||
                dados.error ||
                "Não foi possível consultar a localização."
            );
        }

        let localizacoes = Array.isArray(dados)
            ? dados
            : (Array.isArray(dados.data) ? dados.data : []);

        localizacoes = localizacoes.filter(function (item) {
            return String(item.remessa_id) === String(remessaId);
        });

        if (localizacoes.length === 0) {

            atualizarStatusCliente(
                "Aguardando localização do motorista",
                "transito"
            );

            return;
        }

        localizacoes.sort(function (a, b) {

            const dataA = a.created_at
                ? new Date(a.created_at).getTime()
                : 0;

            const dataB = b.created_at
                ? new Date(b.created_at).getTime()
                : 0;

            if (dataA !== dataB) {
                return dataB - dataA;
            }

            return Number(b.id || 0) - Number(a.id || 0);
        });

        const ultima = localizacoes[0];

        const latitude = parseFloat(
            ultima.latitude ?? ultima.lat
        );

        const longitude = parseFloat(
            ultima.longitude ??
            ultima.lon ??
            ultima.lng
        );

        if (
            !Number.isFinite(latitude) ||
            !Number.isFinite(longitude)
        ) {
            console.warn("Localização inválida:", ultima);
            return;
        }

        await atualizarPosicaoMotorista(
            latitude,
            longitude,
            ultima
        );

    } catch (erro) {

        console.error(
            "Erro ao consultar localização:",
            erro
        );

        atualizarStatusCliente(
            "Erro ao consultar localização",
            "atrasado"
        );
    }
}


/* Seleção da remessa */
async function alterarRemessaRastreio(remessaId) {

    remessaRastreadaId = remessaId || null;
    primeiraLocalizacaoRecebida = false;

    if (intervaloLocalizacaoCliente) {
        clearInterval(intervaloLocalizacaoCliente);
        intervaloLocalizacaoCliente = null;
    }

    limparMapaRota();

    const painel =
        document.getElementById("painelRotaCliente");

    const legenda =
        document.getElementById("legendaRotaCliente");

    if (!remessaId) {

        if (painel) painel.style.display = "none";
        if (legenda) legenda.style.display = "none";

        atualizarStatusCliente(
            "Aguardando Seleção",
            "transito"
        );

        return;
    }

    if (painel) painel.style.display = "grid";
    if (legenda) legenda.style.display = "block";

    atualizarStatusCliente(
        "Buscando localização...",
        "transito"
    );

    await buscarLocalizacaoRemessa(remessaId);

    /*
     * Atualização automática a cada 5 segundos.
     */
    intervaloLocalizacaoCliente =
        setInterval(function () {

            if (remessaRastreadaId) {
                buscarLocalizacaoRemessa(
                    remessaRastreadaId
                );
            }

        }, 5000);
}


/* Atualiza o marcador do motorista */
async function atualizarPosicaoMotorista(
    latitude,
    longitude,
    dadosLocalizacao
) {

    if (!mapaCliente) return;

    const coordenadas = [
        latitude,
        longitude
    ];

    if (marcadorMotoristaCliente) {

        marcadorMotoristaCliente.setLatLng(
            coordenadas
        );

    } else {

        marcadorMotoristaCliente =
            L.marker(
                coordenadas
            ).addTo(mapaCliente);
    }

    const horario =
        dadosLocalizacao &&
        dadosLocalizacao.created_at
            ? new Date(
                dadosLocalizacao.created_at
              ).toLocaleString("pt-BR")
            : "Agora";

    marcadorMotoristaCliente.bindPopup(
        "<strong>🚚 Motorista</strong>" +
        "<br>Localização atual da remessa." +
        "<br><small>Última sincronização: " +
        horario +
        "</small>"
    );

    if (!primeiraLocalizacaoRecebida) {

        mapaCliente.setView(
            coordenadas,
            12
        );

        primeiraLocalizacaoRecebida = true;
    }

    /*
     * Calcula a rota atual -> destino.
     */
    await calcularRotaReal(
        latitude,
        longitude
    );

    atualizarStatusCliente(
        "Motorista localizado",
        "transito"
    );

    const atualizacao =
        document.getElementById(
            "ultimaAtualizacaoRota"
        );

    if (atualizacao) {

        atualizacao.textContent =
            "Última atualização: " +
            new Date().toLocaleTimeString(
                "pt-BR"
            );
    }
}


/*
 * Converte o nome da cidade de destino
 * em latitude/longitude.
 *
 * Exemplo:
 * "São Paulo, SP" -> coordenadas.
 */
async function obterCoordenadasCidade(destino, remessaId) {

    if (!destino) {
        throw new Error("Destino não informado.");
    }

    // Cada remessa possui seu próprio destino.
    if (remessaId && destinosCache[String(remessaId)]) {
        return destinosCache[String(remessaId)];
    }

    const consulta =
        destino.trim().replace(/\s+/g, " ");

    const url =
        "https://nominatim.openstreetmap.org/search" +
        "?format=json" +
        "&limit=5" +
        "&countrycodes=br" +
        "&q=" +
        encodeURIComponent(consulta);

    const resposta = await fetch(url, {
        headers: {
            "Accept": "application/json"
        }
    });

    if (!resposta.ok) {
        throw new Error(
            "Não foi possível localizar o destino."
        );
    }

    const resultados = await resposta.json();

    if (!Array.isArray(resultados) || resultados.length === 0) {
        throw new Error(
            "Cidade de destino não encontrada."
        );
    }

    const termo = consulta.toLowerCase();

    let resultado = resultados.find(function(item) {

        const nome =
            String(item.display_name || "").toLowerCase();

        return (
            nome.includes(termo) &&
            (
                item.type === "city" ||
                item.type === "town" ||
                item.type === "municipality" ||
                item.type === "administrative"
            )
        );
    });

    if (!resultado) {
        resultado = resultados[0];
    }

    const coordenadas = {
        latitude: parseFloat(resultado.lat),
        longitude: parseFloat(resultado.lon),
        nome: resultado.display_name
    };

    if (
        !Number.isFinite(coordenadas.latitude) ||
        !Number.isFinite(coordenadas.longitude)
    ) {
        throw new Error(
            "Coordenadas do destino inválidas."
        );
    }

    if (remessaId) {
        destinosCache[String(remessaId)] = coordenadas;
    }

    return coordenadas;
}


/*
 * Calcula a rota rodoviária REAL usando OSRM.
 * A API retorna distância, duração e geometria
 * da rota pelas estradas.
 */
async function calcularRotaReal(
    latitudeMotorista,
    longitudeMotorista
) {

    const remessaDaRota = remessaRastreadaId;

    const select =
        document.getElementById(
            "selectRastreioCliente"
        );

    if (!select) return;

    const opcao =
        select.options[
            select.selectedIndex
        ];

    if (!opcao) return;

    const destinoTexto =
        opcao.dataset.destino;

    if (!destinoTexto) {
        console.warn("Destino não informado.");
        return;
    }

    try {

        const destino =
            await obterCoordenadasCidade(
                destinoTexto,
                remessaRastreadaId
            );

        /*
         * Marcador do destino.
         */
        if (marcadorDestinoCliente) {

            marcadorDestinoCliente.setLatLng([
                destino.latitude,
                destino.longitude
            ]);

        } else {

            marcadorDestinoCliente =
                L.marker([
                    destino.latitude,
                    destino.longitude
                ]).addTo(mapaCliente);
        }

        marcadorDestinoCliente.bindPopup(
            "<strong>🏁 Destino</strong>" +
            "<br>" +
            escapeHtml(destinoTexto)
        );

        /*
         * OSRM usa longitude,latitude.
         */
        const url =
            "https://router.project-osrm.org/route/v1/driving/" +
            longitudeMotorista +
            "," +
            latitudeMotorista +
            ";" +
            destino.longitude +
            "," +
            destino.latitude +
            "?overview=full&geometries=geojson";

        const resposta =
            await fetch(url);

        if (!resposta.ok) {
            throw new Error(
                "Falha no serviço de rotas."
            );
        }

        const dados =
            await resposta.json();

        if (
            dados.code !== "Ok" ||
            !dados.routes ||
            !dados.routes.length
        ) {
            throw new Error(
                "Não foi encontrada uma rota."
            );
        }

        if (
            String(remessaDaRota) !==
            String(remessaRastreadaId)
        ) {
            return;
        }

        const rota =
            dados.routes[0];

        /*
         * Remove a linha anterior.
         */
        if (linhaRotaCliente) {

            mapaCliente.removeLayer(
                linhaRotaCliente
            );
        }

        /*
         * Desenha a rota pelas estradas.
         */
        linhaRotaCliente =
            L.geoJSON(
                rota.geometry,
                {
                    style: {
                        weight: 6,
                        opacity: 0.85
                    }
                }
            ).addTo(mapaCliente);

        /*
         * Distância restante.
         */
        const distanciaKm =
            rota.distance / 1000;

        const distanciaEl =
            document.getElementById(
                "rotaDistancia"
            );

        if (distanciaEl) {
            distanciaEl.textContent =
                formatarDistancia(
                    distanciaKm
                );
        }

        /*
         * Tempo estimado.
         */
        const duracaoMinutos =
            rota.duration / 60;

        const tempoEl =
            document.getElementById(
                "rotaTempo"
            );

        if (tempoEl) {
            tempoEl.textContent =
                formatarDuracao(
                    duracaoMinutos
                );
        }

        /*
         * Horário estimado de chegada.
         */
        const etaEl =
            document.getElementById(
                "rotaETA"
            );

        if (etaEl) {

            const chegada =
                new Date(
                    Date.now() +
                    rota.duration * 1000
                );

            etaEl.textContent =
                chegada.toLocaleTimeString(
                    "pt-BR",
                    {
                        hour: "2-digit",
                        minute: "2-digit"
                    }
                );
        }

        /*
         * Local atual.
         */
        const localEl =
            document.getElementById(
                "rotaLocalAtual"
            );

        if (localEl) {

            localEl.textContent =
                latitudeMotorista.toFixed(5) +
                ", " +
                longitudeMotorista.toFixed(5);
        }

        /*
         * Mostra motorista + destino + rota.
         */
        const grupo =
            L.featureGroup([
                marcadorMotoristaCliente,
                marcadorDestinoCliente,
                linhaRotaCliente
            ]);

        mapaCliente.fitBounds(
            grupo.getBounds(),
            {
                padding: [30, 30]
            }
        );

    } catch (erro) {

        console.error(
            "Erro ao calcular rota:",
            erro
        );

        atualizarStatusCliente(
            "GPS conectado • rota indisponível",
            "transito"
        );
    }
}


/* Limpa a rota anterior */
function limparMapaRota() {

    if (!mapaCliente) return;

    if (marcadorMotoristaCliente) {
        mapaCliente.removeLayer(
            marcadorMotoristaCliente
        );
        marcadorMotoristaCliente = null;
    }

    if (marcadorDestinoCliente) {
        mapaCliente.removeLayer(
            marcadorDestinoCliente
        );
        marcadorDestinoCliente = null;
    }

    if (linhaRotaCliente) {
        mapaCliente.removeLayer(
            linhaRotaCliente
        );
        linhaRotaCliente = null;
    }

    const distancia =
        document.getElementById("rotaDistancia");

    const tempo =
        document.getElementById("rotaTempo");

    const eta =
        document.getElementById("rotaETA");

    const local =
        document.getElementById("rotaLocalAtual");

    if (distancia) distancia.textContent = "--";
    if (tempo) tempo.textContent = "--";
    if (eta) eta.textContent = "--";
    if (local) local.textContent = "Aguardando GPS...";
}


/* Formata quilômetros */
function formatarDistancia(km) {

    if (km < 1) {
        return Math.round(km * 1000) + " m";
    }

    return km.toLocaleString(
        "pt-BR",
        {
            minimumFractionDigits: 1,
            maximumFractionDigits: 1
        }
    ) + " km";
}


/* Formata horas/minutos */
function formatarDuracao(minutos) {

    const total =
        Math.max(
            1,
            Math.round(minutos)
        );

    const horas =
        Math.floor(total / 60);

    const mins =
        total % 60;

    if (horas > 0) {

        if (mins === 0) {
            return horas + "h";
        }

        return horas +
            "h " +
            mins +
            "min";
    }

    return mins + "min";
}


/* Atualiza badge */
function atualizarStatusCliente(
    texto,
    classe
) {

    const status =
        document.getElementById(
            "statusPedidoCliente"
        );

    if (!status) return;

    status.textContent = texto;

    status.className =
        "badge " +
        (classe || "transito");
}


/* Evita HTML indevido no popup */
function escapeHtml(valor) {

    return String(valor)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


/* Para o polling ao sair */
window.addEventListener(
    "beforeunload",
    function () {

        if (intervaloLocalizacaoCliente) {

            clearInterval(
                intervaloLocalizacaoCliente
            );
        }
    }
);
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
