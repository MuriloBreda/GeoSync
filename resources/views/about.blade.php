<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>GeoSync | Sobre Nós</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* =========================
   PALETA E VARIÁVEIS
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
            transition: zoom 0.2s ease-in-out;
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

        .section {
            padding: 90px 0;
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

        .menu a:hover, .menu a.active {
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
   TEXTOS & TIPOGRAFIA
========================= */
        h2 {
            font-size: 36px;
            font-weight: 800;
            color: var(--azul-institucional);
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }

        h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--azul-institucional);
            margin-bottom: 12px;
        }

        p {
            font-size: 16px;
            line-height: 1.7;
            color: var(--texto-secundario);
        }

        .sub-header {
            color: var(--azul-tech);
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            display: block;
            margin-bottom: 8px;
        }

        .section-title {
            text-align: center;
            max-width: 720px;
            margin: 0 auto 50px;
        }

        .section-title .sub-header {
            margin-bottom: 8px;
        }

        /* =========================
   HERO ABOUT
========================= */
        .hero-about {
            padding: 110px 0 90px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-about::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1920&q=80") center/cover;
            opacity: 0.12;
            mix-blend-mode: overlay;
        }

        .hero-about .container {
            position: relative;
            z-index: 1;
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

        .hero-about h1 {
            font-size: 52px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -1.5px;
            margin-bottom: 16px;
            color: white;
        }

        .hero-about h1 span {
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-about p {
            font-size: 18px;
            color: #94a3b8;
            line-height: 1.6;
            max-width: 680px;
            margin: 0 auto;
        }

        /* =========================
   SOBRE / ESSÊNCIA
========================= */
        .about-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 48px;
            border: 1px solid var(--borda-suave);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            transition: .3s ease;
        }

        .about-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.07);
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .about-image img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 12px;
            display: block;
        }

        /* =========================
   CARDS DE MISSÃO, VISÃO, VALORES
========================= */
        .mvv-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .mvv-card {
            background: white;
            border-radius: 16px;
            padding: 36px 30px;
            border: 1px solid var(--borda-suave);
            box-shadow: 0 8px 25px rgba(0,0,0,.03);
            transition: all 0.3s ease;
        }

        .mvv-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 35px rgba(0,0,0,.08);
            border-color: rgba(37,99,235,.3);
        }

        .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .icon-box.azul-bg {
            background: rgba(37, 99, 235, 0.1);
            color: var(--azul-tech);
        }

        /* =========================
   ESTATÍSTICAS / NÚMEROS
========================= */
        .stats-section {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
        }

        .stats-section h2,
        .stats-section .sub-header {
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .stat-card {
            text-align: center;
            padding: 35px 20px;
            border: 1px solid rgba(255,255,255,.1);
            background: rgba(255,255,255,.04);
            border-radius: 16px;
            transition: .3s;
        }

        .stat-card:hover {
            background: rgba(255,255,255,.07);
            transform: translateY(-4px);
        }

        .stat-number {
            display: block;
            font-size: 42px;
            font-weight: 800;
            color: #60a5fa;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #cbd5e1;
            font-size: 14px;
            font-weight: 500;
        }

        /* =========================
   EQUIPE
========================= */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .team-card {
            background: var(--card-bg);
            border: 1px solid var(--borda-suave);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
            transition: .3s ease;
        }

        .team-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, .08);
            border-color: rgba(37, 99, 235, .25);
        }

        .team-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            display: block;
        }

        .team-text {
            padding: 22px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            text-align: center;
        }

        .team-text h5 {
            color: white;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .team-text small {
            color: #60a5fa;
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================
   CTA SECTION
========================= */
        .cta-section {
            margin: 0 auto 90px;
            width: 88%;
            max-width: 1280px;
            padding: 55px;
            border-radius: 20px;
            background: linear-gradient(135deg, #0f172a, #2563eb);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
        }

        .cta-section h2 {
            color: white;
            margin-bottom: 8px;
        }

        .cta-section p {
            color: #dbeafe;
        }

        .cta-section .btn {
            background: white;
            color: var(--azul-institucional);
            white-space: nowrap;
        }

        .cta-section .btn:hover {
            background: #e2e8f0;
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
            text-decoration: none;
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
   LOADER & ACESSIBILIDADE
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
        .dark-mode .navbar, .dark-mode .about-card, .dark-mode .mvv-card, .dark-mode .team-card {
            background: #0f172a !important; border-color: #1e293b !important;
        }
        .dark-mode h1, .dark-mode h2, .dark-mode h3 { color: #f8fafc !important; }
        .dark-mode p { color: #94a3b8 !important; }

        .alto-contraste { background: #000 !important; }
        .alto-contraste .navbar, .alto-contraste .about-card, .alto-contraste .mvv-card, .alto-contraste .team-card {
            background: #111 !important; border: 1px solid #FFD700 !important;
        }
        .alto-contraste h1, .alto-contraste h2, .alto-contraste h3, .alto-contraste p, .alto-contraste a {
            color: #FFF !important;
        }

        /* =========================
   RESPONSIVIDADE
========================= */
        @media (max-width: 992px) {
            .about-content { grid-template-columns: 1fr; gap: 40px; }
            .mvv-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .team-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .hero-about h1 { font-size: 38px; }
            .cta-section { flex-direction: column; align-items: flex-start; }
        }

        @media (max-width: 768px) {
            .topbar { display: none; }
            .navbar .flex { flex-direction: column; gap: 15px; }
            .menu { gap: 15px; flex-wrap: wrap; justify-content: center; }
            .hero-about { padding: 80px 0 60px; }
            .hero-about p { font-size: 16px; }
            .about-card { padding: 28px; }
            .about-image img { height: 280px; }
            .stats-grid { grid-template-columns: 1fr; }
            .team-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .cta-section { width: 88%; padding: 35px 25px; }
        }
    </style>
</head>

<body>

    <div class="ambient-glow"></div>
    <div class="ambient-glow-bottom"></div>

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

    <!-- HERO ABOUT -->
    <section class="hero-about">
        <div class="container">
            <div class="hero-tag">
                <i class="fas fa-circle"></i> Transformando a Logística
            </div>
            <h1>Inovação e Precisão em <span>Rastreamento</span></h1>
            <p>Conheça a história, os pilares e as mentes por trás da plataforma que está redefinindo a gestão de frota inteligente.</p>
        </div>
    </section>

    <!-- SOBRE ESSÊNCIA -->
    <section class="container section">
        <div class="about-card">
            <div class="about-content">

                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?auto=format&fit=crop&q=80&w=600" alt="Caminhão Logística GeoSync">
                </div>

                <div class="about-text">
                    <span class="sub-header">Nossa Essência</span>
                    <h2>Logística rápida, segura e inteligente</h2>

                    <p>
                        Unimos tecnologia de ponta e anos de experiência no setor para otimizar entregas, reduzir custos operacionais e mitigar riscos nas estradas. Na GeoSync, acreditamos que a transparência em tempo real é a chave para o sucesso logístico moderno.
                    </p>

                    <p>
                        Nossa plataforma foi desenhada para ser intuitiva, robusta e altamente escalável, atendendo com eficiência desde pequenos frotistas até integradores de grandes centros de distribuição.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- PILARES: MISSÃO, VISÃO E VALORES -->
    <section class="container section" style="padding-top: 0;">
        <div class="section-title">
            <span class="sub-header">Nossos Compromissos</span>
            <h2>O que nos move diariamente</h2>
        </div>

        <div class="mvv-grid">
            <div class="mvv-card">
                <div class="icon-box azul-bg">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Missão</h3>
                <p>Empoderar gestores de frota com dados em tempo real, inteligência preditiva e soluções eficientes que garantam entregas pontuais e operações seguras.</p>
            </div>

            <div class="mvv-card">
                <div class="icon-box azul-bg">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Visão</h3>
                <p>Ser referência nacional no ecossistema de rastreamento e telemetria, tornando o transporte rodoviário totalmente conectado, transparente e sustentável.</p>
            </div>

            <div class="mvv-card">
                <div class="icon-box azul-bg">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Valores</h3>
                <p>Inovação contínua, compromisso com a segurança, transparência em dados, foco absoluto na satisfação do cliente e responsabilidade ambiental.</p>
            </div>
        </div>
    </section>

    <!-- METRICAS / IMPACTO -->
    <section class="section stats-section">
        <div class="container">
            <div class="section-title">
                <span class="sub-header">Nosso Impacto</span>
                <h2>Resultados que falam por si</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number">+10k</span>
                    <span class="stat-label">Veículos Monitorados</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">99.8%</span>
                    <span class="stat-label">Precisão na Telemetria</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">-25%</span>
                    <span class="stat-label">Redução de Custos de Combustível</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Suporte e Monitoramento Ativo</span>
                </div>
            </div>
        </div>
    </section>

    <!-- EQUIPE -->
    <section class="container section">
        <div class="section-title">
            <span class="sub-header">Nossa Equipe</span>
            <h2>Mentes que movem a GeoSync</h2>
        </div>

        <div class="team-grid">
            <div class="team-card">
                <img src="{{ asset('img/murilo.png') }}" alt="Murilo Moroni Breda">
                <div class="team-text">
                    <h5>Murilo Moroni Breda</h5>
                    <small>Full-Stack Developer - PO</small>
                </div>
            </div>

            <div class="team-card">
                <img src="{{ asset('img/thayla.png') }}" alt="Thayla F. de Lima Ribeiro">
                <div class="team-text">
                    <h5>Thayla F. de Lima Ribeiro</h5>
                    <small>Back-End Developer - Scrum Master</small>
                </div>
            </div>

            <div class="team-card">
                <img src="{{ asset('img/lucas.png') }}" alt="Lucas Rizzo Bertoloto">
                <div class="team-text">
                    <h5>Lucas Rizzo Bertoloto</h5>
                    <small>Back-End Developer</small>
                </div>
            </div>

            <div class="team-card">
                <img src="{{ asset('img/mickael.png') }}" alt="Mickael H. Malafatti Ezequiel">
                <div class="team-text">
                    <h5>Mickael H. Malafatti Ezequiel</h5>
                    <small>Front-End / Banco de Dados</small>
                </div>
            </div>

            <div class="team-card">
                <img src="{{ asset('img/mariaClara.png') }}" alt="Maria Clara Luz da Silva">
                <div class="team-text">
                    <h5>Maria Clara Luz da Silva</h5>
                    <small>Front-End / Banco de Dados</small>
                </div>
            </div>

            <div class="team-card">
                <img src="{{ asset('img/theo.png') }}" alt="Théo Donizetti de Souza">
                <div class="team-text">
                    <h5>Théo Donizetti de Souza</h5>
                    <small>Front-End / Banco de Dados</small>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA BANNER -->
    {{-- <section class="cta-section">
        <div>
            <h2>Pronto para otimizar sua operação?</h2>
            <p>Conheça nossos planos e descubra como a GeoSync transforma a gestão da sua frota.</p>
        </div>
        <a href="/planos" class="btn">Ver Planos e Preços</a>
    </section> --}}

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
        window.addEventListener('load', function () {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                if(loader) {
                    loader.classList.add('loader-exit');
                    setTimeout(() => { loader.remove(); }, 800);
                }
            }, 1000);
        });

        // Gerenciador do Painel de Acessibilidade
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

        // Carregamento de Preferências
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