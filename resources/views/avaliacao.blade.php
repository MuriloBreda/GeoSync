<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback do Cliente | GeoSync</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* =========================
           PALETA E VARIÁVEIS (PADRÃO INDEX)
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
           TOPBAR (PADRÃO INDEX)
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
           NAVBAR (PADRÃO INDEX)
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

        .btn {
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

        .btn:hover {
            background: var(--azul-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        /* =========================
           HERO SECTION (PADRÃO INDEX)
        ========================= */
        .hero {
            padding: 90px 0 110px;
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
            background: url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1920&q=80") center/cover;
            opacity: 0.12;
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
            font-size: 48px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -1.5px;
            margin-bottom: 18px;
        }

        .hero h1 span {
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 17px;
            color: #94a3b8;
            line-height: 1.6;
        }

        /* =========================
           STATS & CARDS
        ========================= */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 50px;
            margin-top: -60px;
            position: relative;
            z-index: 10;
        }

        .stat-card {
            background: white;
            padding: 28px 20px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--borda-suave);
            transition: 0.3s ease;
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.08);
            border-color: rgba(37, 99, 235, 0.25);
        }

        .stat-card h3 {
            font-size: 38px;
            color: var(--azul-tech);
            font-weight: 800;
            line-height: 1;
        }

        .stat-card p {
            color: var(--texto-secundario);
            margin-top: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        /* =========================
           FEEDBACK FORM CARD
        ========================= */
        .feedback-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            margin-bottom: 90px;
            border: 1px solid var(--borda-suave);
        }

        .content {
            display: grid;
            grid-template-columns: 360px 1fr;
        }

        .left-panel {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 45px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .left-panel h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 800;
            color: white;
        }

        .left-panel p {
            color: #94a3b8;
            line-height: 1.6;
            font-size: 15px;
        }

        .rating-box {
            margin-top: 35px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .rating-box h3 {
            font-size: 13px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #60a5fa;
            font-weight: 700;
        }

        .rating-value {
            font-size: 56px;
            font-weight: 800;
            color: #f59e0b;
            line-height: 1;
        }

        .rating-label {
            margin-top: 10px;
            color: #cbd5e1;
            font-weight: 600;
            font-size: 14px;
        }

        /* FORM PANEL */
        .right-panel {
            padding: 45px;
        }

        .form-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 25px;
            color: var(--azul-institucional);
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--texto-principal);
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--borda-suave);
            border-radius: 8px;
            background: #f8fafc;
            font-size: 15px;
            font-family: inherit;
            color: var(--texto-principal);
            transition: 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--azul-tech);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        textarea {
            resize: vertical;
            min-height: 130px;
        }

        /* STARS */
        .stars {
            display: flex;
            gap: 12px;
            margin-top: 5px;
        }

        .stars span {
            font-size: 40px;
            cursor: pointer;
            color: #cbd5e1;
            transition: .25s ease;
            user-select: none;
        }

        .stars span:hover,
        .stars span.active {
            color: #f59e0b;
            transform: scale(1.1);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 8px;
            background: var(--azul-tech);
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        }

        .btn-submit:hover {
            background: var(--azul-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        /* =========================
           FOOTER (PADRÃO INDEX)
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
           FERRAMENTAS FLUTUANTES (PADRÃO INDEX)
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
        .dark-mode .navbar, .dark-mode .stat-card, .dark-mode .feedback-card, .dark-mode .right-panel {
            background: #0f172a !important; border-color: #1e293b !important;
        }
        .dark-mode .form-title, .dark-mode label { color: #f8fafc !important; }
        .dark-mode input, .dark-mode textarea { background: #1e293b !important; border-color: #334155 !important; color: white !important; }
        .dark-mode p { color: #94a3b8 !important; }

        .alto-contraste { background: #000 !important; }
        .alto-contraste .navbar, .alto-contraste .stat-card, .alto-contraste .feedback-card, .alto-contraste .right-panel {
            background: #111 !important; border: 1px solid #FFD700 !important;
        }
        .alto-contraste h1, .alto-contraste h2, .alto-contraste h3, .alto-contraste p, .alto-contraste a, .alto-contraste label {
            color: #FFF !important;
        }

        /* =========================
           RESPONSIVIDADE
        ========================= */
        @media (max-width: 992px) {
            .content {
                grid-template-columns: 1fr;
            }
            .stats {
                grid-template-columns: 1fr;
                margin-top: 20px;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
            .hero h1 { font-size: 38px; }
        }

        @media (max-width: 768px) {
            .topbar { display: none; }
            .navbar .flex { flex-direction: column; gap: 15px; }
            .menu { gap: 15px; flex-wrap: wrap; justify-content: center; }
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
            <a href="/login" class="btn">Área do Cliente</a>
        </div>
    </div>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <span class="hero-tag"><i class="fa-solid fa-comments"></i> Central de Feedback</span>
                <h1>Sua Opinião Faz a <span>Diferença</span></h1>
                <p>Ajude a GeoSync a aprimorar continuadamente nossas ferramentas de rastreamento e gestão em tempo real.</p>
            </div>
        </div>
    </section>

    <!-- CONTENT CONTAINER -->
    <div class="container">
        <!-- STATS -->
        <div class="stats">
            <div class="stat-card">
                <h3>{{ $percentualSatisfacao ?? 98 }}%</h3>
                <p>Usuários Satisfeitos</p>
            </div>
            <div class="stat-card">
                <h3>{{ $total ?? 1250 }}</h3>
                <p>Avaliações Recebidas</p>
            </div>
            <div class="stat-card">
                <h3>{{ number_format($media ?? 4.9, 1) }}</h3>
                <p>Avaliação Média</p>
            </div>
        </div>

        <!-- FORM CARD -->
        <div class="feedback-card">
            <div class="content">
                <div class="left-panel">
                    <div>
                        <h2>Sua Avaliação</h2>
                        <p>Compartilhe sua experiência e dê sugestões para melhorar nossos serviços.</p>
                    </div>
                    <div class="rating-box">
                        <h3>Nota Selecionada</h3>
                        <div class="rating-value" id="ratingNumber">0</div>
                        <div class="rating-label" id="ratingText">Nenhuma avaliação</div>
                    </div>
                </div>

                <div class="right-panel">
                    <div class="form-title">Envie seu comentário</div>
                    <form action="{{ route('avaliacao.store') }}" method="POST" id="formAvaliacao">
                        @csrf
                        <input type="hidden" name="nota" id="inputNota" value="0">

                        <div class="form-group">
                            <label><i class="fa-regular fa-user"></i> Nome (opcional)</label>
                            <input type="text" name="nome_exibicao" placeholder="Seu nome completo">
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-star"></i> Sua Nota</label>
                            <div class="stars" id="stars">
                                <span data-value="1">★</span>
                                <span data-value="2">★</span>
                                <span data-value="3">★</span>
                                <span data-value="4">★</span>
                                <span data-value="5">★</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-regular fa-comment"></i> Mensagem</label>
                            <textarea name="comentario" id="comentario" placeholder="Escreva seu depoimento sobre a plataforma..."></textarea>
                        </div>

                        <button type="button" class="btn-submit" onclick="validarEnvio()">Enviar Avaliação</button>
                    </form>
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
        // LOADER
        window.addEventListener('load', function () {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                if (loader) {
                    loader.classList.add('loader-exit');
                    setTimeout(() => { loader.remove(); }, 800);
                }
            }, 1000);
        });

        // ESTRELAS
        const stars = document.querySelectorAll('#stars span');
        const inputNota = document.getElementById('inputNota');
        const ratingNumber = document.getElementById('ratingNumber');
        const ratingText = document.getElementById('ratingText');

        const ratingLabels = {
            1: "Péssimo 😞",
            2: "Ruim 🙁",
            3: "Regular 😐",
            4: "Muito Bom 🙂",
            5: "Excelente 🚀"
        };

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                inputNota.value = value;
                ratingNumber.textContent = value;
                ratingText.textContent = ratingLabels[value];

                stars.forEach(s => {
                    if (parseInt(s.getAttribute('data-value')) <= parseInt(value)) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });

        // ENVIO DO FORMULÁRIO
        function validarEnvio() {
            const nota = parseInt(inputNota.value);
            const comentario = document.getElementById('comentario').value.trim();

            if (nota === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione uma nota',
                    text: 'Por favor, marque uma nota de 1 a 5 estrelas.',
                    confirmColor: '#2563eb'
                });
                return;
            }

            if (comentario === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Comentário em branco',
                    text: 'Por favor, digite seu comentário antes de enviar.',
                    confirmColor: '#2563eb'
                });
                return;
            }

            document.getElementById('formAvaliacao').submit();
        }

        // ACESSIBILIDADE
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

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                confirmColor: '#2563eb'
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Erro ao Salvar',
                text: "{{ session('error') }}",
                confirmColor: '#2563eb'
            });
        });
    </script>
    @endif
</body>

</html>