<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback do Cliente | GeoSync</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* =========================
PALETA
========================= */

        :root {
            --azul-institucional: #1C3F6E;
            --azul-tech: #2F6FB2;
            --azul-profundo: #0B1F36;
            --azul-claro: #E6EEF8;
            --azul-cinza: #7B92AD;
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
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            overflow-x: hidden;
            position: relative;
        }

        /* Glow Background */

        body::before {
            content: "";
            position: fixed;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, #2F6FB220 0%, transparent 70%);
            top: -250px;
            right: -250px;
            z-index: -1;
        }

        body::after {
            content: "";
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #0B3B7A15 0%, transparent 70%);
            bottom: -250px;
            left: -250px;
            z-index: -1;
        }

        /* =========================
CONTAINER
========================= */

        .container {
            width: 90%;
            margin: auto;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        /* =========================
TOPBAR
========================= */

        .topbar {
            background: linear-gradient(90deg, #0B1F36, #1C3F6E);
            padding: 10px 0;
            color: white;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .topbar a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .topbar a:hover {
            color: #7fb7ff;
        }

        .top-info {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .top-icons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .top-icons a {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: 0.3s;
        }

        .top-icons a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px);
        }

        /* =========================
NAVBAR
========================= */

        .navbar {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            padding: 18px 0;
            position: sticky;
            top: 0;
            z-index: 9999;
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 30px;
            font-weight: 700;
            color: var(--azul-institucional);
            text-decoration: none;
            transition: .4s;
        }

        .logo:hover {
            transform: scale(1.04);
        }

        .logo img {
            width: 65px;
            transition: .5s;
        }

        .logo:hover img {
            transform: rotate(-8deg) scale(1.08);
        }

        .menu {
            display: flex;
            gap: 35px;
        }

        .menu a {
            position: relative;
            text-decoration: none;
            color: var(--azul-institucional);
            font-size: 15px;
            font-weight: 700;
            transition: .3s;
            padding-bottom: 6px;
        }

        .menu a:hover {
            color: #2F6FB2;
            transform: translateY(-2px);
        }

        .menu a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 2px;
            background: #2F6FB2;
            transition: 0.4s;
            border-radius: 10px;
        }


        .menu a:hover::after {
            width: 100%;
        }

        .btn {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0B3B7A, #1C5CC8);
            color: white;
            padding: 14px 28px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            transition: .4s;
            box-shadow: 0 10px 25px rgba(47, 111, 178, .25);
        }

        .btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(47, 111, 178, .35);
        }

        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .4), transparent);
            transition: .7s;
        }

        .btn:hover::before {
            left: 120%;
        }

        /* PAGE HEADER */

        .page-header {
            margin-bottom: 35px;
        }

        .page-header h1 {
            font-size: 42px;
            font-weight: 800;
            color: #0B234F;
        }

        .page-header p {
            margin-top: 8px;
            color: #64748b;
            font-size: 17px;
        }

        /* STATS */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        }

        .stat-card h3 {
            font-size: 34px;
            color: #0B234F;
        }

        .stat-card p {
            color: #64748b;
            margin-top: 5px;
        }

        /* MAIN CARD */

        .feedback-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .content {
            display: grid;
            grid-template-columns: 320px 1fr;
        }

        .left-panel {
            background: #0B234F;
            color: white;
            padding: 40px;
        }

        .left-panel h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .left-panel p {
            color: #dbe4ff;
            line-height: 1.7;
        }

        .rating-box {
            margin-top: 35px;
            background: rgba(255, 255, 255, .08);
            border-radius: 18px;
            padding: 20px;
        }

        .rating-box h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .rating-value {
            font-size: 52px;
            font-weight: 800;
        }

        .rating-label {
            margin-top: 10px;
            color: #dbe4ff;
        }

        /* FORM */

        .right-panel {
            padding: 40px;
        }

        .form-title {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #0f172a;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #dbe4f0;
            border-radius: 14px;
            background: #f8fafc;
            font-size: 15px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #0B234F;
            box-shadow: 0 0 0 4px rgba(11, 35, 79, .08);
        }

        textarea {
            resize: none;
            min-height: 140px;
        }

        /* STARS */

        .stars {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .stars span {
            font-size: 52px;
            cursor: pointer;
            color: #d1d5db;
            transition: .25s;
        }

        .stars span:hover {
            transform: scale(1.12);
        }

        .stars span.active {
            color: #F59E0B;
        }

        /* BUTTON */

        .btn-submit {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #0B234F, #173A7A);
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: .3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(11, 35, 79, .25);
        }

        /* =========================
FOOTER
========================= */

        .footer {
            background: linear-gradient(180deg, #08192c, #050f1c);
            color: white;
            padding: 90px 0 20px;
            position: relative;
        }

        .footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #2F6FB2, transparent);
        }

        .footer-grid {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }

        .footer-col {
            flex: 1;
            min-width: 250px;
        }

        .footer h3 {
            color: #2F6FB2;
            margin-bottom: 15px;
        }

        .footer p {
            color: #c7d2df;
            font-size: 15px;
        }

        .footer a {
            display: block;
            color: #a7b4c5;
            margin-bottom: 10px;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer a:hover {
            color: #2F6FB2;
            padding-left: 5px;
        }

        .social {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .social a {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #7B92AD;
            transition: 0.3s;
        }

        .social a:hover {
            background: #2F6FB2;
            border-color: #2F6FB2;
            transform: translateY(-3px);
        }

        .newsletter {
            display: flex;
            margin-top: 15px;
        }

        .newsletter input {
            flex: 1;
            padding: 12px;
            border: none;
            outline: none;
            border-radius: 8px 0 0 8px;
        }

        .newsletter button {
            background: #2F6FB2;
            border: none;
            color: white;
            padding: 0 20px;
            cursor: pointer;
            border-radius: 0 8px 8px 0;
        }

        .copy {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #9db0c7;
        }

        /* loader */

        #loader {
            position: fixed;
            inset: 0;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999999;
            transition: all .8s ease;
        }

        .loader-logo {
            text-align: center;
            transition: all .8s ease;
        }

        .loader-logo img {
            width: 140px;
            animation: pulse 1.5s infinite;
        }

        .loader-exit {
            opacity: 0;
            backdrop-filter: blur(10px);
        }

        .loader-exit .loader-logo {
            transform: scale(1.5);
            opacity: 0;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section {
            animation: fadeUp 1s ease;
        }

        @media (max-width: 768px) {

            .container {
                width: 95%;
            }

            /* TOPBAR */

            .topbar {
                padding: 12px 0;
            }

            .top-info {
                width: 100%;
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }

            .top-info a {
                font-size: 13px;
            }

            .top-icons {
                width: 100%;
                justify-content: center;
                margin-top: 10px;
            }

            /* NAVBAR */

            .navbar {
                padding: 15px 0;
            }

            .navbar .flex {
                flex-direction: column;
                gap: 15px;
            }

            .logo {
                font-size: 24px;
            }

            .logo img {
                width: 50px;
            }

            .menu {
                width: 100%;
                justify-content: center;
                gap: 15px;
                flex-wrap: wrap;
            }

            .menu a {
                font-size: 14px;
            }

            .btn {
                width: 100%;
                text-align: center;
                padding: 14px;
            }

            /* AVALIAÇÃO REPOSITÓRIO MOBILE */
            .stats {
                grid-template-columns: 1fr;
            }

            .content {
                grid-template-columns: 1fr !important;
            }

            .left-panel,
            .right-panel {
                padding: 25px;
            }

            .page-header h1 {
                font-size: 30px;
            }

            .form-title {
                font-size: 24px;
            }

            .stars {
                justify-content: center;
            }

            .stars span {
                font-size: 40px;
            }

            /* FOOTER */

            .footer {
                padding: 60px 0 20px;
            }

            .footer-grid {
                flex-direction: column;
                gap: 25px;
            }

            .footer-col {
                min-width: 100%;
            }

            .newsletter {
                flex-direction: column;
                gap: 10px;
            }

            .newsletter input {
                border-radius: 8px;
            }

            .newsletter button {
                border-radius: 8px;
                padding: 14px;
            }
        }

        

        /* ==========================================================
   ACESSIBILIDADE UNIFICADA GEOSYNC (MODO ZOOM IGUAL INDEX)
========================================================== */
        :root {
            --font-scale: 1;
        }

        body {
            zoom: var(--font-scale);
            transition: zoom 0.2s ease-in-out;
        }

        /* Evita que o painel flutuante sofra alteração de tamanho junto com o body */
        

        

        #accessibility-toggle:hover {
            transform: scale(1.08);
        }

        

        .accessibility-panel.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .accessibility-header {
            background: linear-gradient(135deg, #0B3B7A, #2F6FB2);
            color: white;
            padding: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .accessibility-panel button {
            width: 100%;
            border: none;
            background: white;
            text-align: left;
            padding: 16px 20px;
            cursor: pointer;
            font-family: Poppins, sans-serif;
            font-size: 15px;
            border-bottom: 1px solid #eee;
            transition: .2s;
        }

        .accessibility-panel button:hover {
            background: #f5f7fb;
            padding-left: 28px;
        }

        /* MODOS VISUAIS CRÍTICOS */
        .dark-mode {
            background: #121212 !important;
        }

        .dark-mode .navbar,
        .dark-mode .block,
        .dark-mode .card,
        .dark-mode .footer,
        .dark-mode .topbar,
        .dark-mode .feedback-card,
        .dark-mode .stat-card,
        .dark-mode .right-panel,
        .dark-mode .accessibility-panel {
            background: #1e1e1e !important;
        }

        .dark-mode p,
        .dark-mode h1,
        .dark-mode h2,
        .dark-mode h3,
        .dark-mode a,
        .dark-mode span,
        .dark-mode label,
        .dark-mode .form-title {
            color: white !important;
        }

        .dark-mode input,
        .dark-mode textarea {
            background: #2a2a2a !important;
            border-color: #3a3a3a !important;
            color: white !important;
        }

        .dark-mode .accessibility-panel button {
            background: #1e1e1e !important;
            color: white !important;
            border-bottom-color: #3a3a3a !important;
        }

        .dark-mode .accessibility-panel button:hover {
            background: #2a2a2a !important;
        }

        .alto-contraste {
            background: #111 !important;
        }

        .alto-contraste .navbar,
        .alto-contraste .block,
        .alto-contraste .card,
        .alto-contraste .footer,
        .alto-contraste .topbar,
        .alto-contraste .feedback-card,
        .alto-contraste .stat-card,
        .alto-contraste .right-panel,
        .alto-contraste .accessibility-panel {
            background: #1b1b1b !important;
            border: 1px solid #FFD700 !important;
        }

        .alto-contraste h1,
        .alto-contraste h2,
        .alto-contraste h3,
        .alto-contraste p,
        .alto-contraste span,
        .alto-contraste label,
        .alto-contraste .form-title {
            color: #ffffff !important;
        }

        .alto-contraste a {
            color: #FFD700 !important;
        }

        .alto-contraste .btn,
        .alto-contraste .btn-submit {
            background: #FFD700 !important;
            color: #000 !important;
        }

        .alto-contraste img {
            filter: contrast(110%);
        }

        .alto-contraste .accessibility-panel button {
            background: #1b1b1b !important;
            color: #fff !important;
            border-bottom: 1px solid #FFD700 !important;
        }

        .alto-contraste .accessibility-panel button:hover {
            background: #FFD700 !important;
            color: #000 !important;
        }

        @media(max-width:768px) {
            .accessibility-container {
                right: 15px;
                bottom: 15px;
            }

            .accessibility-panel {
                width: 260px;
                right: 80px;
            }
        }

        /* <!-- Estilo para o botão ficar fixo no canto inferior direito da tela --> */
        

        .robo-floating-btn:hover {
            transform: scale(1.1) translateY(-3px);
            background-color: #1d4ed8;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
        }

        .robo-floating-btn svg {
            width: 30px;
            height: 30px;
        }

        /* ==========================================================
           BARRA FLUTUANTE DE FERRAMENTAS (ROBÔ + ACESSIBILIDADE)
        ========================================================== */

        /* Container que une os dois e os coloca lado a lado */
        .ferramentas-flutuantes-container {
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 999999;
            display: flex;
            align-items: center;
            gap: 15px;
            /* Espaço milimétrico entre os dois botões */
            zoom: 1 !important;
            /* Protege contra o zoom do body */
        }

        /* Botão do Robô */
        .robo-floating-btn {
            width: 70px;
            height: 70px;
            background-color: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .robo-floating-btn:hover {
            transform: scale(1.08) translateY(-2px);
            background-color: #1d4ed8;
            box-shadow: 0 12px 35px rgba(37, 99, 235, 0.5);
        }

        .robo-floating-btn svg {
            width: 32px;
            height: 32px;
        }

        /* Container Interno da Acessibilidade */
        .accessibility-container {
            position: relative;
        }

        /* Botão de Acessibilidade */
        #accessibility-toggle {
            width: 70px;
            height: 70px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            color: white;
            font-size: 30px;
            background: linear-gradient(135deg, #0B3B7A, #2F6FB2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .3s;
        }

        #accessibility-toggle:hover {
            transform: scale(1.08) translateY(-2px);
        }

        /* Painel de Opções (Aparece em cima da barra ao clicar) */
        .accessibility-panel {
            position: absolute;
            right: 0;
            bottom: 85px;
            /* Abre perfeitamente posicionado acima do botão */
            width: 300px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, .15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: .3s;
        }

        .accessibility-panel.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Ajustes para telas de celulares */
        @media(max-width: 768px) {
            .ferramentas-flutuantes-container {
                right: 15px;
                bottom: 15px;
                gap: 10px;
            }

            .robo-floating-btn,
            #accessibility-toggle {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }

            .robo-floating-btn svg {
                width: 26px;
                height: 26px;
            }

            .accessibility-panel {
                width: 260px;
                bottom: 75px;
            }
        }
    </style>
</head>

<body>

    <!-- BARRA FLUTUANTE DE FERRAMENTAS (Robô e Acessibilidade Lado a Lado) -->
    <div class="ferramentas-flutuantes-container">

        <!-- Botão do Robô (Chat I.A) -->
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

    <div class="topbar">
        <div class="container flex">
            <div class="top-info">
                <a href="https://wa.me/551994010744?text=Olá!%20Seja%20Bem-vindo(a)%20à%20GeoSync!%20Como%20posso%20ajudar?"
                    target="_blank">
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
            <a href="/login" class="btn">Login</a>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h1 style="margin-top: 50px;"><i class="fa-solid fa-chart-line"></i> Comentário do Cliente</h1>
            <p>Sua opinião ajuda a GeoSync a evoluir continuamente.</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>{{ $percentualSatisfacao }}%</h3>
                <p>Usuários Satisfeitos</p>
            </div>
            <div class="stat-card">
                <h3>{{ $total }}</h3>
                <p>Avaliações Recebidas</p>
            </div>
            <div class="stat-card">
                <h3>{{ number_format($media, 1) }}</h3>
                <p>Avaliação Média</p>
            </div>
        </div>

        <div class="feedback-card">
            <div class="content">
                <div class="left-panel">
                    <h2>Sua Avaliação</h2>
                    <p>
                        Compartilhe sua experiência utilizando os serviços da GeoSync. Seu comentario é essencial para
                        aprimorar nosso monitoramento, rastreamento e gerenciamento em tempo real.
                    </p>
                    <div class="rating-box">
                        <h3>Nota Selecionada</h3>
                        <div class="rating-value" id="ratingNumber">0</div>
                        <div class="rating-label" id="ratingText">Nenhuma avaliação</div>
                    </div>
                </div>

                <div class="right-panel">
                    <div class="form-title">Compartilhe sua experiência</div>
                    <form action="{{ route('avaliacao.store') }}" method="POST" id="formAvaliacao">
                        @csrf
                        <input type="hidden" name="nota" id="inputNota" value="0">

                        <div class="form-group">
                            <label><i class="fa-regular fa-user"></i> Nome</label>
                            <input type="text" name="nome_exibicao" placeholder="Seu nome completo (opcional)">
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-star"></i> Avaliação</label>
                            <div class="stars" id="stars">
                                <span data-value="1">★</span>
                                <span data-value="2">★</span>
                                <span data-value="3">★</span>
                                <span data-value="4">★</span>
                                <span data-value="5">★</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-regular fa-comment"></i> Comentário</label>
                            <textarea name="comentario" placeholder="Conte-nos o que achou do sistema..."></textarea>
                        </div>

                        <button type="button" class="btn-submit" onclick="validarEnvio()">Enviar Avaliação</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->

    <div class="footer" style="margin-top: 50px;">

        <div class="container">

            <div class="footer-grid">

                <div class="footer-col">

                    <h3>GeoSync</h3>

                    <p>
                        Sistema inteligente de rastreamento e logística em tempo real.
                    </p>

                    <div class="social">

                        <a href="https://www.facebook.com/geosync" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/geosync" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://br.linkedin.com/company/geosync" target="_blank"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/geosync_tambau/" target="_blank"><i
                                class="fab fa-instagram"></i></a>

                    </div>

                </div>

                <div class="footer-col">

                    <h3>Links</h3>

                    <a href="/">Início</a>
                    <a href="/about">Sobre</a>
                    <a href="/login">Serviço</a>
                    <a href="/avaliar">Comentários</a>
                    <a href="/planos">Planos</a>
                    <a href="/cadastro-admin">Cadastro Admin</a>


                </div>

                <div class="footer-col">

                    <h3>Contato</h3>

                    <p>R. Cap. David, 56 - Centro, Tambaú - SP</p>
                    <p>(19) 99401-0744</p>
                    <p>contact@geosync.com</p>

                </div>

                <div class="footer-col">

                    <h3>Boletim informativo</h3>

                    <p>Receba novidades da plataforma.</p>

                    <div class="newsletter">
                        <input type="text" placeholder="Seu email">
                        <button>Enviar</button>
                    </div>

                </div>

            </div>

            <div class="copy">
                © 2026 GeoSync - Todos os direitos reservados
            </div>

        </div>

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

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro ao enviar',
                text: @json($errors->first()),
                confirmButtonColor: '#0B234F'
            });
        </script>
    @endif

    <script>
        // Gerenciador do Painel
        const accessBtn = document.getElementById("accessibility-toggle");
        const accessPanel = document.getElementById("accessibility-panel");

        if (accessBtn && accessPanel) {
            accessBtn.addEventListener("click", () => {
                accessPanel.classList.toggle("active");
            });
        }

        // Carregamento de Estados Salvos
        document.addEventListener("DOMContentLoaded", () => {
            let escala = localStorage.getItem("fontScale") || "1";
            document.documentElement.style.setProperty("--font-scale", escala);

            if (localStorage.getItem("darkMode") === "true") {
                document.body.classList.add("dark-mode");
            }
            if (localStorage.getItem("contraste") === "true") {
                document.body.classList.add("alto-contraste");
            }
        });

        // Modificação Numérica Uniforme para a Propriedade Zoom
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
            document.body.classList.toggle("dark-mode");
            localStorage.setItem("darkMode", document.body.classList.contains("dark-mode"));
        }

        function toggleContraste() {
            document.body.classList.toggle("alto-contraste");
            localStorage.setItem("contraste", document.body.classList.contains("alto-contraste"));
        }

        function lerPagina() {
            speechSynthesis.cancel();
            const texto = document.body.innerText;
            const fala = new SpeechSynthesisUtterance(texto);
            fala.lang = "pt-BR";
            fala.rate = 1;
            speechSynthesis.speak(fala);
        }

        function pararLeitura() {
            speechSynthesis.cancel();
        }

        function resetarAcessibilidade() {
            pararLeitura();
            localStorage.removeItem("fontScale");
            localStorage.removeItem("darkMode");
            localStorage.removeItem("contraste");
            document.body.classList.remove("dark-mode", "alto-contraste");
            document.documentElement.style.setProperty("--font-scale", "1");
        }

        // ==========================================
// LÓGICA DAS ESTRELAS DE AVALIAÇÃO
// ==========================================
const stars = document.querySelectorAll('#stars span');
const inputNota = document.getElementById('inputNota');
const ratingNumber = document.getElementById('ratingNumber');
const ratingText = document.getElementById('ratingText');

// Rótulos explicativos para cada nota
const labels = {
    1: 'Péssimo 😞',
    2: 'Ruim 🙁',
    3: 'Regular 😐',
    4: 'Bom 🙂',
    5: 'Excelente! 😄'
};

// Evento de clique nas estrelas
stars.forEach(star => {
    star.addEventListener('click', () => {
        const value = parseInt(star.getAttribute('data-value'));

        // Atualiza o valor do input hidden
        inputNota.value = value;

        // Atualiza o painel visual
        if (ratingNumber) ratingNumber.innerText = value;
        if (ratingText) ratingText.innerText = labels[value] || 'Nenhuma avaliação';

        // Pinta/destaca as estrelas até a selecionada
        stars.forEach(s => {
            const sValue = parseInt(s.getAttribute('data-value'));
            if (sValue <= value) {
                s.classList.add('active');
            } else {
                s.classList.remove('active');
            }
        });
    });
});

// Função para validar e enviar a avaliação
function validarEnvio() {
    const nota = parseInt(inputNota.value);

    if (!nota || nota === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Por favor, selecione uma nota de 1 a 5 estrelas antes de enviar.',
            confirmButtonColor: '#0B234F'
        });
        return;
    }

    // Se estiver válido, submete o formulário
    document.getElementById('formAvaliacao').submit();
}

    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Obrigado!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "/";
            });
        </script>
    @endif
</body>

</html>