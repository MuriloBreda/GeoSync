<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Premium | GeoSync</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* =========================
           PALETA E VARIÁVEIS (PADRÃO GEOSYNC)
        ========================= */
        :root {
            --azul-institucional: #0f172a;
            --azul-tech: #2563eb;
            --azul-hover: #1d4ed8;
            --azul-profundo: #020617;
            --azul-claro: #f0f6ff;
            --texto-principal: #334155;
            --texto-secundario: #64748b;
            --borda-suave: #e2e8f0;
            --card-bg: #ffffff;
            --font-scale: 1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: var(--texto-principal);
            overflow-x: hidden;
            position: relative;
            zoom: var(--font-scale);
            transition: zoom 0.2s ease-in-out, background 0.3s, color 0.3s;
        }

        /* Ambient Glows */
        .ambient-glow {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            top: -200px;
            right: -200px;
            z-index: -1;
            pointer-events: none;
        }

        .ambient-glow-bottom {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(15, 23, 42, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
            bottom: -200px;
            left: -200px;
            z-index: -1;
            pointer-events: none;
        }

        /* =========================
           LOADER
        ========================= */
        #loader {
            position: fixed;
            inset: 0;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999999;
            transition: all .8s ease;
        }

        .loader-logo {
            text-align: center;
        }

        .loader-logo img {
            width: 80px;
            animation: pulse 1.5s infinite;
        }

        .loader-exit {
            opacity: 0;
            visibility: hidden;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }

        /* =========================
           LAYOUT BASE
        ========================= */
        .container {
            width: 88%;
            max-width: 1280px;
            margin: auto;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* =========================
           TOPBAR
        ========================= */
        .topbar {
            background: var(--azul-profundo);
            padding: 10px 0;
            color: #94a3b8;
            font-size: 13px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .topbar a {
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.3s;
            font-weight: 500;
        }

        .topbar a:hover {
            color: #60a5fa;
        }

        .top-info {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .top-icons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .top-icons a {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            transition: 0.3s;
        }

        .top-icons a:hover {
            background: var(--azul-tech);
            color: white;
        }

        /* =========================
           NAVBAR
        ========================= */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 9999;
            border-bottom: 1px solid var(--borda-suave);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 26px;
            font-weight: 800;
            color: var(--azul-institucional);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .logo img {
            width: 42px;
            height: auto;
        }

        .menu {
            display: flex;
            gap: 32px;
        }

        .menu a {
            position: relative;
            text-decoration: none;
            color: var(--texto-principal);
            font-size: 15px;
            font-weight: 600;
            transition: .3s;
        }

        .menu a:hover {
            color: var(--azul-tech);
        }

        .btn-nav {
            background: var(--azul-tech);
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: .3s ease;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
            display: inline-block;
        }

        .btn-nav:hover {
            background: var(--azul-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        /* =========================
           HERO SECTION
        ========================= */
        .hero {
            padding: 70px 0 90px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: url("https://images.unsplash.com/photo-1563013544-824ae1b704d3?auto=format&fit=crop&w=1920&q=80") center/cover;
            opacity: 0.1;
            mix-blend-mode: overlay;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 780px;
            margin: auto;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(37, 99, 235, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(96, 165, 250, 0.2);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: 42px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 15px;
        }

        .hero h1 span {
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 16px;
            color: #94a3b8;
            line-height: 1.6;
        }

        /* =========================
           CHECKOUT GRID
        ========================= */
        .checkout-container {
            margin-top: -60px;
            margin-bottom: 90px;
            position: relative;
            z-index: 10;
        }

        .checkout {
            display: grid;
            grid-template-columns: 1.8fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 35px;
            border: 1px solid var(--borda-suave);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .btn-voltar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #f1f5f9;
            color: var(--texto-principal);
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
            transition: .3s;
            border: 1px solid var(--borda-suave);
        }

        .btn-voltar:hover {
            background: #e2e8f0;
            color: var(--azul-tech);
        }

        .section-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--azul-institucional);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--azul-tech);
        }

        /* SELEÇÃO DE PLANOS */
        .plans {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .plan {
            border: 2px solid var(--borda-suave);
            border-radius: 14px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            background: #f8fafc;
        }

        .plan:hover {
            border-color: rgba(37, 99, 235, 0.5);
            transform: translateY(-2px);
        }

        .plan.active {
            border-color: var(--azul-tech);
            background: var(--azul-claro);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.12);
        }

        .plan strong {
            display: block;
            font-size: 16px;
            color: var(--azul-institucional);
            margin-bottom: 6px;
        }

        .plan .price {
            font-size: 20px;
            font-weight: 800;
            color: var(--azul-tech);
        }

        .plan .price span {
            font-size: 12px;
            color: var(--texto-secundario);
            font-weight: 500;
        }

        /* SELEÇÃO DE PAGAMENTO */
        .payments {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .payment {
            border: 2px solid var(--borda-suave);
            border-radius: 14px;
            padding: 18px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .payment:hover {
            border-color: rgba(37, 99, 235, 0.5);
            transform: translateY(-2px);
        }

        .payment.active {
            border-color: var(--azul-tech);
            background: var(--azul-claro);
            color: var(--azul-tech);
        }

        .payment i {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
        }

        .payment span {
            font-size: 13px;
            font-weight: 700;
        }

        /* INPUTS E FORMULÁRIO */
        .input-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .field-box {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-box label {
            font-size: 13px;
            font-weight: 700;
            color: var(--texto-principal);
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--borda-suave);
            border-radius: 10px;
            background: #f8fafc;
            font-size: 14px;
            font-family: inherit;
            color: var(--texto-principal);
            transition: 0.3s;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: var(--azul-tech);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 10px;
            background: var(--azul-tech);
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 25px;
            transition: .3s ease;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background: var(--azul-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        /* BOX DE PIX E BOLETO */
        #pixBox, #boletoBox, #sucessoBox {
            display: none;
            text-align: center;
            padding: 20px 10px;
        }

        #qrcode {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        #qrcode img {
            border: 8px solid white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .code-display {
            background: #f1f5f9;
            padding: 14px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 13px;
            word-break: break-all;
            margin: 15px 0 25px;
            border: 1px dashed var(--borda-suave);
            color: var(--azul-institucional);
        }

        /* RESUMO DA COMPRA */
        .summary h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--azul-institucional);
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--borda-suave);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            font-size: 14px;
            color: var(--texto-secundario);
        }

        .summary-row strong {
            color: var(--texto-principal);
        }

        .summary-divider {
            height: 1px;
            background: var(--borda-suave);
            margin: 20px 0;
        }

        .total-box {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 25px;
        }

        .total-box span {
            font-size: 14px;
            font-weight: 700;
            color: var(--texto-principal);
        }

        .total-price {
            font-size: 28px;
            font-weight: 800;
            color: var(--azul-tech);
            line-height: 1;
        }

        .security-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--azul-claro);
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--azul-tech);
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================
           FOOTER
        ========================= */
        .footer {
            background: #020617;
            color: #94a3b8;
            padding: 80px 0 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer h3 {
            color: white;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer p {
            color: #64748b;
            font-size: 14px;
        }

        .footer a {
            display: block;
            color: #94a3b8;
            margin-bottom: 12px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .footer a:hover {
            color: white;
        }

        .social {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .social a {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0;
        }

        .social a:hover {
            background: var(--azul-tech);
        }

        .newsletter {
            display: flex;
            margin-top: 15px;
            gap: 8px;
        }

        .newsletter input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            outline: none;
            border-radius: 8px;
            color: white;
            font-size: 14px;
        }

        .newsletter button {
            background: var(--azul-tech);
            border: none;
            color: white;
            padding: 0 20px;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }

        .newsletter button:hover {
            background: var(--azul-hover);
        }

        .copy {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 13px;
            color: #475569;
        }

        /* =========================
           FERRAMENTAS FLUTUANTES
        ========================= */
        .ferramentas-flutuantes-container {
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 999999;
            display: flex;
            align-items: center;
            gap: 12px;
            zoom: 1 !important;
        }

        .robo-floating-btn, #accessibility-toggle {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .robo-floating-btn { background: var(--azul-tech); }
        #accessibility-toggle { background: var(--azul-institucional); font-size: 20px; }

        .robo-floating-btn:hover, #accessibility-toggle:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .accessibility-container { position: relative; }

        .accessibility-panel {
            position: absolute;
            right: 0;
            bottom: 70px;
            width: 280px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--borda-suave);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: .3s;
        }

        .accessibility-panel.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .accessibility-header {
            background: var(--azul-institucional);
            color: white;
            padding: 14px;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .accessibility-panel button {
            width: 100%;
            border: none;
            background: white;
            text-align: left;
            padding: 12px 16px;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            color: var(--texto-principal);
            border-bottom: 1px solid var(--borda-suave);
            transition: .2s;
        }

        .accessibility-panel button:hover {
            background: var(--azul-claro);
            color: var(--azul-tech);
        }

        /* MODOS VISUAIS */
        .dark-mode { background: #090d16 !important; color: #e2e8f0 !important; }
        .dark-mode .navbar, .dark-mode .card {
            background: #0f172a !important; border-color: #1e293b !important;
        }
        .dark-mode .section-title, .dark-mode .plan strong, .dark-mode .summary h2, .dark-mode .total-box span, .dark-mode .field-box label {
            color: #f8fafc !important;
        }
        .dark-mode input, .dark-mode select {
            background: #1e293b !important; border-color: #334155 !important; color: white !important;
        }
        .dark-mode .plan, .dark-mode .payment {
            background: #1e293b !important; border-color: #334155 !important;
        }
        .dark-mode .btn-voltar {
            background: #1e293b !important; color: white !important; border-color: #334155 !important;
        }

        .alto-contraste { background: #000 !important; }
        .alto-contraste .navbar, .alto-contraste .card {
            background: #111 !important; border: 1px solid #FFD700 !important;
        }
        .alto-contraste h1, .alto-contraste h2, .alto-contraste h3, .alto-contraste p, .alto-contraste a, .alto-contraste label, .alto-contraste span, .alto-contraste strong {
            color: #FFF !important;
        }

        /* =========================
           RESPONSIVIDADE
        ========================= */
        @media (max-width: 992px) {
            .checkout {
                grid-template-columns: 1fr;
            }
            .plans {
                grid-template-columns: 1fr;
            }
            .hero h1 { font-size: 34px; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .topbar { display: none; }
            .navbar .flex { flex-direction: column; gap: 15px; }
            .menu { gap: 15px; flex-wrap: wrap; justify-content: center; }
            .payments { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

    <div class="ambient-glow"></div>
    <div class="ambient-glow-bottom"></div>

    <!-- LOADER -->
    {{-- <div id="loader">
        <div class="loader-logo">
            <img src="{{ asset('img/Logo.png') }}" alt="GeoSync">
            <h2 style="font-size: 24px; margin-top: 10px;">Geo<span style="color: var(--azul-tech)">Sync</span></h2>
        </div>
    </div> --}}

    <!-- FERRAMENTAS FLUTUANTES -->
    <div class="ferramentas-flutuantes-container">
        <a href="{{ url('/chat') }}" class="robo-floating-btn" title="Conversar com a I.A">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 8V4H8" />
                <rect width="16" height="12" x="4" y="8" rx="2" />
                <path d="M2 14h2" />
                <path d="M20 14h2" />
                <path d="M15 13v2" />
                <path d="M9 13v2" />
            </svg>
        </a>

        <div class="accessibility-container">
            <button id="accessibility-toggle" aria-label="Abrir acessibilidade">
                <i class="fas fa-universal-access"></i>
            </button>
            <div class="accessibility-panel" id="accessibility-panel">
                <div class="accessibility-header">
                    <i class="fas fa-universal-access"></i>
                    <span>Acessibilidade</span>
                </div>
                <button onclick="alterarFonte(0.1)">🔍 Aumentar Fonte</button>
                <button onclick="alterarFonte(-0.1)">🔎 Diminuir Fonte</button>
                <button onclick="toggleDark()">🌙 Modo Escuro</button>
                <button onclick="toggleContraste()">◐ Alto Contraste</button>
                <button onclick="lerPagina()">🔊 Ler Página</button>
                <button onclick="pararLeitura()">⏹ Parar Leitura</button>
                <button onclick="resetarAcessibilidade()">↺ Restaurar Padrão</button>
            </div>
        </div>
    </div>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="container flex">
            <div class="top-info">
                <a href="https://wa.me/551994010744?text=Olá!%20Seja%20Bem-vindo(a)%20à%20GeoSync!%20Como%20posso%20ajudar?" target="_blank">
                    <i class="fas fa-phone-alt"></i> +55 (19) 99401-0744
                </a>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=contatogeosync@gmail.com" target="_blank">
                    <i class="fas fa-envelope"></i> contatogeosync@gmail.com
                </a>
            </div>
            <div class="top-icons">
                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://x.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://br.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.instagram.com/geosync_tambau/" target="_blank"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="container flex">
            <a href="/" class="logo">
                <img src="{{ asset('img/Logo.png') }}" alt="Logo">
                <span>GeoSync</span>
            </a>
            <div class="menu">
                <a href="/">Início</a>
                <a href="/about">Sobre</a>
                <a href="/avaliar">Comentários</a>
                <a href="/planos">Planos</a>
            </div>
            <a href="/login" class="btn-nav">Área do Cliente</a>
        </div>
    </div>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <span class="hero-tag"><i class="fa-solid fa-shield-halved"></i> Ambiente 100% Seguro</span>
                <h1>Checkout <span>Premium</span></h1>
                <p>Escolha o plano ideal para a sua frota e libere o monitoramento em tempo real instantaneamente.</p>
            </div>
        </div>
    </section>

    <!-- CHECKOUT MAIN -->
    <div class="container checkout-container">
        <div class="checkout">

            <!-- PAINEL ESQUERDO: FORMULÁRIO -->
            <div class="card">
                <a href="/planos" class="btn-voltar">
                    <i class="fa-solid fa-arrow-left"></i> Alterar Plano
                </a>

                <form id="mainForm" action="{{ route('pagamento.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="valor" id="db_valor" value="149.99">
                    <input type="hidden" name="plano" id="db_plano" value="GeoSync Start">
                    <input type="hidden" name="metodo" id="db_metodo" value="credito">

                    <div id="conteudo">
                        <div class="section-title">
                            <i class="fa-solid fa-cube"></i> Plano Selecionado
                        </div>

                        <div class="plans">
                            <div class="plan" onclick="selectPlan(this,'GeoSync Start',149.99)">
                                <strong>GeoSync Start</strong>
                                <div class="price">R$ 149,99 <span>/mês</span></div>
                            </div>
                            <div class="plan" onclick="selectPlan(this,'GeoSync Pro',599.99)">
                                <strong>GeoSync Pro</strong>
                                <div class="price">R$ 599,99 <span>/6 mês</span></div>
                            </div>
                        </div>

                        <div class="section-title">
                            <i class="fa-solid fa-wallet"></i> Forma de Pagamento
                        </div>

                        <div class="payments">
                            <div class="payment active" onclick="selectPayment(this,'credito')">
                                <i class="fa-solid fa-credit-card"></i>
                                <span>Cartão de Crédito</span>
                            </div>
                            <div class="payment" onclick="selectPayment(this,'pix')">
                                <i class="fa-brands fa-pix"></i>
                                <span>PIX Instantâneo</span>
                            </div>
                            <div class="payment" onclick="selectPayment(this,'boleto')">
                                <i class="fa-solid fa-barcode"></i>
                                <span>Boleto Bancário</span>
                            </div>
                        </div>

                        <!-- DADOS CARTÃO -->
                        <div id="area-credito" class="input-group">
                            <div class="field-box">
                                <label>Número do Cartão</label>
                                <input id="numeroCartao" placeholder="0000 0000 0000 0000" autocomplete="off">
                            </div>

                            <div class="field-box">
                                <label>Nome do Titular</label>
                                <input id="nomeCartao" placeholder="Como impresso no cartão" autocomplete="off">
                            </div>

                            <div class="grid-2">
                                <div class="field-box">
                                    <label>Validade</label>
                                    <input id="validadeCartao" placeholder="MM/AA" autocomplete="off">
                                </div>
                                <div class="field-box">
                                    <label>Código CVV</label>
                                    <input id="cvvCartao" placeholder="123" autocomplete="off">
                                </div>
                            </div>

                            <div class="field-box">
                                <label>Opções de Parcelamento</label>
                                <select id="selectParcelas"></select>
                            </div>
                        </div>

                        <button type="button" class="btn-submit" onclick="processar()">
                            <i class="fa-solid fa-lock"></i> Finalizar Pagamento
                        </button>
                    </div>
                </form>

                <!-- DADOS PIX -->
                <div id="pixBox">
                    <div class="section-title" style="justify-content: center;">
                        <i class="fa-brands fa-pix"></i> Pagamento via PIX
                    </div>
                    <p style="font-size: 14px; color: var(--texto-secundario);">Escaneie o QR Code abaixo pelo aplicativo do seu banco para ativar instantaneamente.</p>
                    
                    <div id="qrcode"></div>

                    <div class="code-display" id="chavePix">00020126580014br.gov.bcb.pix0136geosync-pix-key-random-id-102938475</div>

                    <button class="btn-submit" onclick="copiarCodigo('chavePix')">
                        <i class="fa-regular fa-copy"></i> Copiar Chave PIX
                    </button>
                    
                    <button class="btn-submit" style="background: var(--azul-institucional); margin-top: 10px;" onclick="finalizarNoBanco()">
                        Confirmar Pagamento Realizado
                    </button>
                </div>

                <!-- DADOS BOLETO -->
                <div id="boletoBox">
                    <div class="section-title" style="justify-content: center;">
                        <i class="fa-solid fa-barcode"></i> Boleto Bancário Gerado
                    </div>
                    <p style="font-size: 14px; color: var(--texto-secundario);">Utilize a linha digitável abaixo para efetuar o pagamento pelo Internet Banking.</p>

                    <div class="code-display" id="linhaBoleto">00190.00009 02313.400006 45848.400002 8 89000000014999</div>

                    <button class="btn-submit" onclick="copiarCodigo('linhaBoleto')">
                        <i class="fa-regular fa-copy"></i> Copiar Linha Digitável
                    </button>

                    <button class="btn-submit" style="background: var(--azul-institucional); margin-top: 10px;" onclick="finalizarNoBanco()">
                        Confirmar Pagamento
                    </button>
                </div>
            </div>

            <!-- PAINEL DIREITO: RESUMO -->
            <div class="card summary">
                <h2>Resumo da Compra</h2>
                
                <div class="summary-row">
                    <span>Plano Contratado</span>
                    <strong id="txtPlano">GeoSync Start</strong>
                </div>

                <div class="summary-row">
                    <span>Método</span>
                    <strong id="txtMetodo">Cartão de Crédito</strong>
                </div>

                <div class="summary-row">
                    <span>Renovação</span>
                    <strong>Mensal (Recorrente)</strong>
                </div>

                <div class="summary-divider"></div>

                <div class="total-box">
                    <span>Valor Total</span>
                    <div class="total-price" id="txtTotal">R$ 149,99</div>
                </div>

                <div class="security-badge">
                    <i class="fa-solid fa-lock"></i>
                    <span>Criptografia SSL de 256 bits. Transação 100% Protegida.</span>
                </div>
            </div>

        </div>
    </div>

    <!-- VLIBRAS -->
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

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h2 style="color: white; font-size: 22px; margin-bottom: 15px;">GeoSync</h2>
                    <p>Ecossistema inteligente de rastreamento, telemetria e gestão de frota em tempo real.</p>
                    <div class="social">
                        <a href="https://www.facebook.com/geosync" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/geosync" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://br.linkedin.com/company/geosync" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/geosync_tambau/" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h3>Navegação</h3>
                    <a href="/">Início</a>
                    <a href="/about">Sobre</a>
                    <a href="/login">Serviço</a>
                    <a href="/avaliar">Comentários</a>
                    <a href="/planos">Planos</a>
                    <a href="/cadastro-admin">Cadastro Admin</a>
                </div>
                <div>
                    <h3>Contato</h3>
                    <p style="margin-bottom: 8px;">R. Cap. David, 56 - Centro</p>
                    <p style="margin-bottom: 8px;">Tambaú - SP</p>
                    <p style="margin-bottom: 8px;">(19) 99401-0744</p>
                    <p>contact@geosync.com</p>
                </div>
                <div>
                    <h3>Informativo</h3>
                    <p>Assine para receber atualizações técnicas e novos recursos.</p>
                    <div class="newsletter">
                        <input type="email" placeholder="Seu e-mail profissional">
                        <button>Assinar</button>
                    </div>
                </div>
            </div>
            <div class="copy">
                © 2026 GeoSync - Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script>
        let currentValor = 149.99;
        let currentMetodo = 'credito';

        // LOADER
        window.addEventListener('load', function () {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                if (loader) {
                    loader.classList.add('loader-exit');
                    setTimeout(() => { loader.remove(); }, 800);
                }
            }, 800);
        });

        document.addEventListener("DOMContentLoaded", function () {
            // MÁSCARAS
            IMask(document.getElementById('numeroCartao'), { mask: '0000 0000 0000 0000' });
            IMask(document.getElementById('nomeCartao'), { mask: /^[a-zA-Z\s]*$/ });
            IMask(document.getElementById('validadeCartao'), {
                mask: 'MM/YY',
                blocks: {
                    MM: { mask: IMask.MaskedRange, from: 1, to: 12 },
                    YY: { mask: IMask.MaskedRange, from: 0, to: 99 }
                }
            });
            IMask(document.getElementById('cvvCartao'), { mask: '0000' });

            // URL PARAMS PARA SELEÇÃO AUTOMÁTICA
            const urlParams = new URLSearchParams(window.location.search);
            const planoParam = urlParams.get('plano');
            const valorParam = parseFloat(urlParams.get('valor'));

            const planosCards = document.querySelectorAll('.plan');
            
            if (planoParam && !isNaN(valorParam)) {
                let planoEncontrado = false;
                planosCards.forEach(card => {
                    const titulo = card.querySelector('strong').innerText.toLowerCase();
                    if (titulo.includes(planoParam.toLowerCase())) {
                        selectPlan(card, card.querySelector('strong').innerText, valorParam);
                        planoEncontrado = true;
                    }
                });
                if (!planoEncontrado) selectPlan(planosCards[0], 'GeoSync Start', 149.99);
            } else {
                selectPlan(planosCards[0], 'GeoSync Start', 149.99);
            }
        });

        function selectPlan(el, plano, preco) {
            document.querySelectorAll('.plan').forEach(x => x.classList.remove('active'));
            if (el) el.classList.add('active');

            currentValor = preco;
            document.getElementById('db_plano').value = plano;
            document.getElementById('db_valor').value = preco;

            document.getElementById('txtPlano').innerText = plano;
            document.getElementById('txtTotal').innerText = 'R$ ' + preco.toFixed(2).replace('.', ',');

            updateParcelas(preco);
        }

        function selectPayment(el, metodo) {
            document.querySelectorAll('.payment').forEach(x => x.classList.remove('active'));
            el.classList.add('active');
            currentMetodo = metodo;
            document.getElementById('db_metodo').value = metodo;

            const labels = {
                'credito': 'Cartão de Crédito',
                'pix': 'PIX Instantâneo',
                'boleto': 'Boleto Bancário'
            };
            document.getElementById('txtMetodo').innerText = labels[metodo];

            document.getElementById('area-credito').style.display = metodo === 'credito' ? 'flex' : 'none';
        }

        function updateParcelas(preco) {
            let s = document.getElementById('selectParcelas');
            if (!s) return;
            s.innerHTML = '';
            [1, 2, 3, 6, 12].forEach(p => {
                let o = document.createElement('option');
                let valorParcela = (preco / p).toFixed(2).replace('.', ',');
                o.text = p + 'x de R$ ' + valorParcela + (p === 1 ? ' (Sem juros)' : '');
                s.appendChild(o);
            });
        }

        function processar() {
            if (currentMetodo === 'credito') {
                const num = document.getElementById('numeroCartao').value;
                const nome = document.getElementById('nomeCartao').value;
                const val = document.getElementById('validadeCartao').value;
                const cvv = document.getElementById('cvvCartao').value;

                if (!num || !nome || !val || !cvv) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos incompletos',
                        text: 'Por favor, preencha todos os dados do cartão de crédito.',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }
                finalizarNoBanco();
                return;
            }

            if (currentMetodo === 'pix') {
                document.getElementById('conteudo').style.display = 'none';
                document.getElementById('pixBox').style.display = 'block';
                document.getElementById('qrcode').innerHTML = '';
                new QRCode(document.getElementById('qrcode'), { 
                    text: '00020126580014br.gov.bcb.pix0136geosync-pix-key-random-id-' + Date.now(),
                    width: 200, 
                    height: 200 
                });
                return;
            }

            if (currentMetodo === 'boleto') {
                document.getElementById('conteudo').style.display = 'none';
                document.getElementById('boletoBox').style.display = 'block';
                return;
            }
        }

        function copiarCodigo(id) {
            const texto = document.getElementById(id).innerText;
            navigator.clipboard.writeText(texto).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Copiado!',
                    text: 'Código copiado para a área de transferência.',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        }

        function finalizarNoBanco() {
            Swal.fire({
                icon: 'success',
                title: 'Pagamento Concluído!',
                text: 'Seu plano GeoSync foi ativado com sucesso.',
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Ir para a Área do Cliente'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/login';
                }
            });
        }

        /* ACESSIBILIDADE */
        const accessBtn = document.getElementById("accessibility-toggle");
        const accessPanel = document.getElementById("accessibility-panel");

        if (accessBtn && accessPanel) {
            accessBtn.addEventListener("click", () => {
                const isActive = accessPanel.classList.toggle("active");
                accessBtn.setAttribute("aria-expanded", isActive);
            });

            document.addEventListener("click", (e) => {
                if (!accessBtn.contains(e.target) && !accessPanel.contains(e.target)) {
                    accessPanel.classList.remove("active");
                    accessBtn.setAttribute("aria-expanded", "false");
                }
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            const escala = localStorage.getItem("fontScale") || "1";
            document.documentElement.style.setProperty("--font-scale", escala);

            if (localStorage.getItem("darkMode") === "true") toggleDark(true);
            if (localStorage.getItem("contraste") === "true") toggleContraste(true);
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

        function toggleDark(force = false) {
            if (document.body.classList.contains("alto-contraste") && !force) toggleContraste(true);
            const isDark = force === true ? true : document.body.classList.toggle("dark-mode");
            if (force === true) document.body.classList.add("dark-mode");
            localStorage.setItem("darkMode", document.body.classList.contains("dark-mode"));
        }

        function toggleContraste(force = false) {
            if (document.body.classList.contains("dark-mode") && !force) toggleDark(true);
            const isContraste = force === true ? true : document.body.classList.toggle("alto-contraste");
            if (force === true) document.body.classList.add("alto-contraste");
            localStorage.setItem("contraste", document.body.classList.contains("alto-contraste"));
        }

        let sintoVoz = null;
        function lerPagina() {
            window.speechSynthesis.cancel();
            let textoParaLer = window.getSelection().toString().trim();

            if (!textoParaLer) {
                const elementosFoco = document.querySelectorAll('h1, h2, h3, p, span:not(.accessibility-panel span)');
                let blocosTexto = [];
                elementosFoco.forEach(el => {
                    if (el.innerText && el.innerText.trim().length > 3) blocosTexto.push(el.innerText.trim());
                });
                textoParaLer = blocosTexto.join('. ');
            }

            if (textoParaLer) {
                sintoVoz = new SpeechSynthesisUtterance(textoParaLer);
                sintoVoz.lang = "pt-BR";
                sintoVoz.rate = 1.05;
                window.speechSynthesis.speak(sintoVoz);
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
        }
    </script>

</body>
</html>