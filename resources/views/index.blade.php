<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>GeoSync</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

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
            background: linear-gradient(135deg,
                    #0B3B7A,
                    #1C5CC8);
            color: white;
            padding: 14px 28px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            transition: .4s;
            box-shadow:
                0 10px 25px rgba(47, 111, 178, .25);
        }

        .btn:hover {
            transform: translateY(-4px);
            box-shadow:
                0 20px 40px rgba(47, 111, 178, .35);
        }

        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, .4),
                    transparent);
            transition: .7s;
        }

        .btn:hover::before {
            left: 120%;
        }


        /* =========================
HEADER
========================= */

        .header {
            background:
                linear-gradient(rgba(11, 31, 54, 0.85), rgba(11, 31, 54, 0.85)),
                url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d");
            background-size: cover;
            background-position: center;
            padding: 140px 20px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 58px;
            margin-bottom: 15px;
        }

        .header p {
            font-size: 22px;
            text-align: center;
        }

        /* =========================
SEÇÕES
========================= */

        .section {
            padding: 70px 0;
        }

        /* =========================
BLOCOS
========================= */

        .block {
            background: white;
            border-radius: 24px;
            padding: 35px;
            margin-bottom: 20px;

            transition: .4s;

            box-shadow:
                0 12px 30px rgba(0, 0, 0, .06);
        }

        .block:hover {
            transform: translateY(-8px);

            box-shadow:
                0 25px 50px rgba(0, 0, 0, .12);
        }

        .block img {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        /* =========================
TEXTOS
========================= */

        h2 {
            font-size: 40px;
            margin-bottom: 20px;
            color: #0B1F36;
        }

        h3 {
            font-size: 26px;
            margin-bottom: 15px;
        }

        p {
            font-size: 18px;
            line-height: 1.9;
            text-align: justify;
            color: #444;
        }

        .texto-grande {
            font-size: 20px;
            line-height: 1.9;
            text-align: justify;
        }

        /* =========================
SERVIÇOS
========================= */

        .services {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .service {
            flex: 1;
            min-width: 300px;
        }

        .service .block {
            transition: 0.4s;
            cursor: pointer;
        }

        .service .block:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        /* =========================
DIFERENCIAIS
========================= */

        .diferenciais-topo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
            margin-bottom: 60px;
        }

        .diferenciais-texto {
            flex: 1;
            min-width: 320px;
        }

        .diferenciais-texto span {
            color: #2F6FB2;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 15px;
        }

        .diferenciais-texto h2 {
            font-size: 60px;
            line-height: 1.1;
            margin: 20px 0;
        }

        .diferenciais-texto h2 span {
            font-size: 60px;
        }

        .diferenciais-imagem {
            flex: 1;
            min-width: 320px;
        }

        .diferenciais-imagem img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        /* CARDS */

        .cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .card {
            width: 320px;
            padding: 35px;
            border-radius: 25px;
            transition: .5s;
            cursor: pointer;
            position: relative;
            overflow: hidden;

            box-shadow:
                0 15px 35px rgba(0, 0, 0, .08);
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, .25),
                    transparent);
            transition: .7s;
        }

        .card:hover::before {
            left: 120%;
        }

        .card:hover {
            transform:
                translateY(-12px) scale(1.03);

            box-shadow:
                0 30px 50px rgba(0, 0, 0, .15);
        }

        .card.azul {
            background: linear-gradient(180deg, #0B3B7A, #022553);
            color: white;
        }

        .card.branco {
            background: white;
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: white;

            box-shadow:
                0 10px 25px rgba(47, 111, 178, .18);

            margin-bottom: 25px;

            transition: .4s;
        }

        .card:hover .icon-circle {
            transform: rotate(10deg) scale(1.1);
        }

        .icon-circle.borda {
            border: 2px solid #2F6FB2;
        }

        .icon-circle i {
            font-size: 38px;
            color: #0B3B7A;
        }

        .card p {
            font-size: 18px;
            line-height: 1.8;
            text-align: justify;
        }

        .card.azul p {
            color: #f1f1f1;
        }

        /* =========================
FOOTER
========================= */

        .footer {
            background:
                linear-gradient(180deg,
                    #08192c,
                    #050f1c);

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

            background:
                linear-gradient(90deg,
                    transparent,
                    #2F6FB2,
                    transparent);
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

            /* HERO */

            .header,
            .hero-about,
            .planos-hero {
                padding: 80px 15px;
            }

            .header h1,
            .hero-about h1,
            .planos-hero h1 {
                font-size: 32px !important;
                line-height: 1.2;
            }

            .header p,
            .hero-about p,
            .planos-hero p {
                font-size: 15px;
            }

            /* TITULOS */

            h2 {
                font-size: 28px !important;
            }

            h3 {
                font-size: 22px !important;
            }

            p {
                font-size: 15px !important;
                text-align: left;
            }

            /* ABOUT */

            .about-card {
                padding: 25px;
            }

            .about-content {
                flex-direction: column;
                gap: 25px;
            }

            .team-grid {
                grid-template-columns: 1fr;
            }

            .team-card img,
            .team img {
                height: 280px;
            }

            /* INDEX */

            .diferenciais-topo {
                flex-direction: column;
                gap: 25px;
            }

            .diferenciais-texto h2,
            .diferenciais-texto h2 span {
                font-size: 36px !important;
            }

            .diferenciais-imagem img {
                height: 280px;
            }

            .cards {
                gap: 20px;
            }

            .card {
                width: 100%;
                max-width: none;
            }

            .services {
                flex-direction: column;
            }

            .service {
                min-width: 100%;
            }

            /* CONTATO */

            .contact-wrapper {
                flex-direction: column;
                margin: 35px 0;
            }

            .contact-card {
                min-width: 100%;
                padding: 20px;
            }

            iframe {
                height: 280px;
            }

            /* AVALIAÇÃO */

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

            /* PLANOS */

            .planos-grid {
                gap: 20px;
            }

            .plano-card {
                width: 100%;
                padding: 25px;
            }

            .preco {
                font-size: 32px;
            }

            .tabela {
                overflow-x: auto;
            }

            .tabela table {
                min-width: 700px;
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

    <!-- LOADER -->
    <div id="loader">
        <div class="loader-logo">
            <img src="{{ asset('img/Logo.png') }}" alt="GeoSync">
            <h1><span>Geo</span><span style="color: #1C3F6E">Sync</span></h1>
        </div>
    </div>

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

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="container flex">

            <div class="top-info">

                <a href="https://wa.me/551994010744?text=Olá!%20Seja%20Bem-vindo(a)%20à%20GeoSync!%20Como%20posso%20ajudar?"
                    target="_blank">
                    <i class="fas fa-phone-alt"></i>
                    +55 (19) 99401-0744
                </a>

                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=contatogeosync@gmail.com" target="_blank">
                    <i class="fas fa-envelope"></i>
                    contatogeosync@gmail.com
                </a>

            </div>

            <div class="top-icons">

                <a href="https://www.facebook.com" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a href="https://x.com" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>

                <a href="https://br.linkedin.com" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>

                <a href="https://www.instagram.com/geosync_tambau/" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>

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

            <a href="/login" class="btn">
                Login
            </a>

        </div>
    </div>

    <!-- HEADER -->

    <div class="header">
        <h1>Rastreamento Inteligente</h1>
        <p style="color: white">Controle total da sua logística em tempo real</p>
    </div>

    <!-- SOBRE -->

    <div class="container section">

        <div class="block">

            <img src="https://images.unsplash.com/photo-1553413077-190dd305871c">

            <h2>Sobre a GeoSync</h2>

            <p class="texto-grande">
                A GeoSync é uma plataforma inteligente de rastreamento e monitoramento logístico desenvolvida para
                oferecer total controle sobre operações de transporte e armazenamento.
                Com tecnologia moderna e interface intuitiva, nossa solução permite acompanhar veículos, cargas e rotas
                em tempo real, garantindo mais segurança, eficiência e transparência em toda a cadeia logística.
                Nosso objetivo é transformar a forma como empresas gerenciam sua logística, reduzindo custos
                operacionais, otimizando processos e aumentando a confiabilidade nas entregas.
            </p>

        </div>

    </div>

    <!-- SERVIÇOS -->

    <div class="container section">

        <div class="services">

            <div class="service">
                <div class="block">

                    <img src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7">

                    <h3>Transporte Terrestre</h3>

                    <p class="texto-grande">
                        O módulo de transporte terrestre da GeoSync permite o gerenciamento completo da sua frota com
                        rastreamento em tempo real.
                        Acompanhe rotas, monitore paradas, identifique desvios e tenha acesso a dados estratégicos.
                    </p>

                </div>
            </div>

            <div class="service" >
                <div class="block">

                    <img src="https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc">

                    <h3>Armazenamento</h3>

                    <p class="texto-grande">
                        A GeoSync também oferece soluções para controle de armazenamento, proporcionando organização e
                        eficiência na gestão de estoques.
                    </p>

                </div>
            </div>

        </div>

    </div>

    <!-- DIFERENCIAIS -->

    <div class="container section">

        <div class="diferenciais-topo">

            <div class="diferenciais-texto">

                <span>NOSSOS DIFERENCIAIS</span>

                <h2>
                    Por que escolher <br>
                    <span style="color:#2F6FB2;">a GeoSync?</span>
                </h2>

                <p class="texto-grande">
                    A GeoSync se destaca por integrar tecnologia IoT com inteligência preditiva, permitindo
                    monitoramento em tempo real e identificação antecipada de falhas.
                </p>

                <p class="texto-grande">
                    Com tecnologia moderna e uma plataforma intuitiva, ajudamos empresas a otimizar processos e reduzir
                    custos.
                </p>

            </div>

            <div class="diferenciais-imagem">
                <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c">
            </div>

        </div>

        <!-- CARDS -->

        <div class="cards">

            <div class="card azul">

                <div class="icon-circle">
                    <i class="fas fa-shield-alt"></i>
                </div>

                <h3>Segurança</h3>

                <p>
                    Monitoramento contínuo e proteção das operações logísticas.
                </p>

            </div>

            <div class="card branco">

                <div class="icon-circle borda">
                    <i class="fas fa-chart-line"></i>
                </div>

                <h3>Eficiência</h3>

                <p>
                    Mais produtividade e redução de custos através da tecnologia.
                </p>

            </div>

            <div class="card azul">

                <div class="icon-circle">
                    <i class="fas fa-map-marker-alt"></i>
                </div>

                <h3>Rastreamento</h3>

                <p>
                    Acompanhamento em tempo real de cargas, rotas e veículos.
                </p>

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

    <!-- FOOTER -->

    <div class="footer">

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

</body>

<script>
    window.addEventListener('load', function () {

        setTimeout(() => {

            const loader = document.getElementById('loader');

            // animação de saída
            loader.classList.add('loader-exit');

            // remove totalmente
            setTimeout(() => {
                loader.remove();
            }, 800);

        }, 1500);

    });
</script>

<script>
    // Gerenciador de Abertura/Fechamento do Painel com Aria-States
    const accessBtn = document.getElementById("accessibility-toggle");
    const accessPanel = document.getElementById("accessibility-panel");

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

    // Carregamento Inicial das Configurações em Cache
    document.addEventListener("DOMContentLoaded", () => {
        // Busca a escala numérica (padrão é 1)
        const escala = localStorage.getItem("fontScale") || "1";
        document.documentElement.style.setProperty("--font-scale", escala);

        if (localStorage.getItem("darkMode") === "true") toggleDark(true);
        if (localStorage.getItem("contraste") === "true") toggleContraste(true);
    });

    // Função de Zoom com variação de passos decimais (0.1)
    function alterarFonte(valor) {
        let atual = parseFloat(getComputedStyle(document.documentElement).getPropertyValue("--font-scale")) || 1;
        atual += valor;

        // Limites de Segurança: Mínimo 70% de zoom, Máximo 170% de zoom
        if (atual < 0.7) atual = 0.7;
        if (atual > 1.7) atual = 1.7;

        // Arredonda para evitar dízimas periódicas no CSS (ex: 1.200000000002)
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

    // Leitor de Telas Inteligente
    let sintoVoz = null;
    function lerPagina() {
        window.speechSynthesis.cancel();
        let textoParaLer = window.getSelection().toString().trim();

        if (!textoParaLer) {
            const elementosFoco = document.querySelectorAll('h1, h2, h3, p, li, span:not(.accessibility-panel span):not(.topbar span)');
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
</script>

</html>