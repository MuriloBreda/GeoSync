<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>GeoSync | Planos e Soluções</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fontes -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>

        /* =========================================================
           VARIÁVEIS
        ========================================================= */

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


        /* =========================================================
           RESET
        ========================================================= */

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
            background: #f8fafc;
            color: var(--texto-principal);
            overflow-x: hidden;
            position: relative;

            zoom: var(--font-scale);

            transition: background .3s ease, color .3s ease;
        }


        /* =========================================================
           BACKGROUND AMBIENT
        ========================================================= */

        .ambient-glow {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37, 99, 235, .08) 0%,
                    rgba(255, 255, 255, 0) 70%
                );

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

            background:
                radial-gradient(
                    circle,
                    rgba(15, 23, 42, .05) 0%,
                    rgba(255, 255, 255, 0) 70%
                );

            bottom: -200px;
            left: -200px;

            z-index: -1;
            pointer-events: none;
        }


        /* =========================================================
           CONTAINER
        ========================================================= */

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


        /* =========================================================
           TOPBAR
        ========================================================= */

        .topbar {
            background: var(--azul-profundo);
            padding: 9px 0;

            color: #94a3b8;
            font-size: 12px;

            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .topbar a {
            color: #cbd5e1;
            text-decoration: none;
            transition: .3s;
            font-weight: 500;
        }

        .topbar a:hover {
            color: #60a5fa;
        }

        .top-info {
            display: flex;
            gap: 28px;
            align-items: center;
        }

        .top-info i {
            margin-right: 6px;
            color: #60a5fa;
        }

        .top-icons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .top-icons a {
            width: 29px;
            height: 29px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 7px;

            background: rgba(255,255,255,.05);

            transition: .3s;
        }

        .top-icons a:hover {
            background: var(--azul-tech);
            color: white;
            transform: translateY(-2px);
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .navbar {
            background: rgba(255,255,255,.92);

            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            padding: 17px 0;

            position: sticky;
            top: 0;

            z-index: 9999;

            border-bottom: 1px solid rgba(226,232,240,.85);

            transition: .3s;
        }

        .logo {
            display: flex;
            align-items: center;

            gap: 10px;

            font-size: 25px;
            font-weight: 800;

            color: var(--azul-institucional);

            text-decoration: none;

            letter-spacing: -.8px;
        }

        .logo img {
            width: 40px;
            height: auto;
        }

        .menu {
            display: flex;
            gap: 34px;
        }

        .menu a {
            position: relative;

            text-decoration: none;

            color: #475569;

            font-size: 14px;
            font-weight: 600;

            transition: .3s;
        }

        .menu a::after {
            content: "";

            position: absolute;

            left: 0;
            bottom: -8px;

            width: 0;
            height: 2px;

            background: var(--azul-tech);

            transition: .3s;
        }

        .menu a:hover {
            color: var(--azul-tech);
        }

        .menu a:hover::after {
            width: 100%;
        }


        /* =========================================================
           BOTÃO
        ========================================================= */

        .btn {
            display: inline-block;

            background: var(--azul-tech);

            color: white;

            padding: 10px 24px;

            border-radius: 8px;

            text-decoration: none;

            font-weight: 600;
            font-size: 14px;

            transition: .3s;

            box-shadow:
                0 4px 14px rgba(37,99,235,.25);
        }

        .btn:hover {
            background: var(--azul-hover);

            transform: translateY(-2px);

            box-shadow:
                0 6px 20px rgba(37,99,235,.35);
        }


        /* =========================================================
           HERO DOS PLANOS
        ========================================================= */

        .planos-hero {
            position: relative;

            padding: 105px 0 95px;

            background:
                linear-gradient(
                    135deg,
                    #0f172a 0%,
                    #1e293b 100%
                );

            color: white;

            overflow: hidden;

            text-align: center;
        }

        .planos-hero::before {
            content: "";

            position: absolute;

            inset: 0;

            background:
                url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1920&q=80")
                center/cover;

            opacity: .10;
        }

        .planos-hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-tag {
            display: inline-flex;

            align-items: center;
            gap: 8px;

            padding: 6px 15px;

            margin-bottom: 18px;

            border-radius: 30px;

            background: rgba(37,99,235,.15);

            border:
                1px solid rgba(96,165,250,.2);

            color: #60a5fa;

            font-size: 13px;
            font-weight: 600;
        }

        .hero-tag i {
            font-size: 7px;
        }

        .planos-hero h1 {
            font-size: 50px;

            line-height: 1.15;

            font-weight: 800;

            letter-spacing: -1.5px;

            margin-bottom: 18px;
        }

        .planos-hero h1 span {
            background:
                linear-gradient(
                    90deg,
                    #60a5fa,
                    #3b82f6
                );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .planos-hero p {
            max-width: 720px;

            margin: auto;

            color: #94a3b8;

            font-size: 17px;

            line-height: 1.7;
        }


        /* =========================================================
           SEÇÃO DOS PLANOS
        ========================================================= */

        .planos-section {
            padding: 85px 0 100px;
        }

        .section-heading {
            text-align: center;

            max-width: 700px;

            margin:
                0 auto 50px;
        }

        .sub-header {
            display: block;

            margin-bottom: 8px;

            color: var(--azul-tech);

            font-size: 13px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 1.5px;
        }

        .section-heading h2 {
            color: var(--azul-institucional);

            font-size: 36px;

            font-weight: 800;

            letter-spacing: -.5px;

            margin-bottom: 12px;
        }

        .section-heading p {
            color: var(--texto-secundario);

            line-height: 1.7;
        }


        /* =========================================================
           GRID DOS PLANOS
        ========================================================= */

        .planos-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 25px;

            align-items: stretch;
        }


        /* =========================================================
           CARD
        ========================================================= */

        .plano-card {
            position: relative;

            background: white;

            border:
                1px solid var(--borda-suave);

            border-radius: 16px;

            padding: 34px;

            display: flex;
            flex-direction: column;

            box-shadow:
                0 8px 25px rgba(15,23,42,.04);

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;
        }

        .plano-card:hover {
            transform: translateY(-7px);

            box-shadow:
                0 20px 40px rgba(15,23,42,.09);

            border-color:
                rgba(37,99,235,.3);
        }


        /* =========================================================
           PLANO DESTAQUE
        ========================================================= */

        .plano-card.destaque {
            background:
                linear-gradient(
                    145deg,
                    #0f172a,
                    #1e3a68
                );

            border:
                1px solid rgba(96,165,250,.2);

            box-shadow:
                0 18px 40px rgba(15,23,42,.18);
        }

        .plano-card.destaque:hover {
            transform: translateY(-9px);
        }


        /* =========================================================
           BADGE
        ========================================================= */

        .badge {
            position: absolute;

            top: 20px;
            right: 20px;

            padding: 6px 12px;

            border-radius: 20px;

            background:
                rgba(37,99,235,.18);

            border:
                1px solid rgba(96,165,250,.25);

            color: #93c5fd;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: .5px;
        }


        /* =========================================================
           ÍCONE
        ========================================================= */

        .plano-icon {
            width: 56px;
            height: 56px;

            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 22px;

            background:
                rgba(37,99,235,.1);

            color:
                var(--azul-tech);
        }

        .plano-icon i {
            font-size: 21px;
        }

        .plano-card.destaque .plano-icon {
            background:
                rgba(96,165,250,.13);

            color: #60a5fa;
        }


        /* =========================================================
           TÍTULO / PREÇO
        ========================================================= */

        .plano-card h3 {
            color: var(--azul-institucional);

            font-size: 22px;

            font-weight: 700;

            margin-bottom: 12px;
        }

        .plano-card.destaque h3 {
            color: white;
        }

        .preco {
            color: var(--azul-institucional);

            font-size: 32px;

            font-weight: 800;

            letter-spacing: -.7px;

            margin-bottom: 14px;
        }

        .preco span {
            color: var(--texto-secundario);

            font-size: 14px;

            font-weight: 500;
        }

        .plano-card.destaque .preco {
            color: white;
        }

        .plano-card.destaque .preco span {
            color: #94a3b8;
        }


        /* =========================================================
           DESCRIÇÃO
        ========================================================= */

        .descricao {
            min-height: 48px;

            color: var(--texto-secundario);

            font-size: 14px;

            line-height: 1.7;

            margin-bottom: 22px;
        }

        .plano-card.destaque .descricao {
            color: #94a3b8;
        }


        /* =========================================================
           LISTA
        ========================================================= */

        .plano-card ul {
            list-style: none;

            margin-bottom: 28px;

            flex: 1;
        }

        .plano-card ul li {
            display: flex;

            align-items: center;

            gap: 10px;

            padding: 9px 0;

            color: var(--texto-principal);

            font-size: 14px;

            border-bottom:
                1px solid #f1f5f9;
        }

        .plano-card ul li:last-child {
            border-bottom: none;
        }

        .plano-card ul li i {
            color: var(--azul-tech);

            font-size: 13px;
        }

        .plano-card.destaque ul li {
            color: #e2e8f0;

            border-bottom-color:
                rgba(255,255,255,.08);
        }

        .plano-card.destaque ul li i {
            color: #60a5fa;
        }


        /* =========================================================
           BOTÃO DO PLANO
        ========================================================= */

        .btn-plano {
            display: block;

            width: 100%;

            padding: 13px 18px;

            text-align: center;

            border-radius: 8px;

            background: var(--azul-tech);

            color: white;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            transition: .3s;
        }

        .btn-plano:hover {
            background: var(--azul-hover);

            transform: translateY(-2px);
        }

        .plano-card.destaque .btn-plano {
            background: white;

            color: var(--azul-institucional);
        }

        .plano-card.destaque .btn-plano:hover {
            background: #e2e8f0;
        }


        /* =========================================================
           COMPARATIVO
        ========================================================= */

        .comparativo {
            margin-top: 90px;
        }

        .comparativo-heading {
            text-align: center;

            margin-bottom: 35px;
        }

        .comparativo-heading h2 {
            color: var(--azul-institucional);

            font-size: 32px;

            font-weight: 800;
        }

        .comparativo-heading p {
            color: var(--texto-secundario);

            margin-top: 8px;
        }

        .tabela {
            overflow-x: auto;
        }

        .tabela table {
            width: 100%;

            min-width: 700px;

            background: white;

            border-collapse: collapse;

            overflow: hidden;

            border-radius: 14px;

            box-shadow:
                0 8px 25px rgba(15,23,42,.05);
        }

        .tabela th {
            padding: 17px;

            background: var(--azul-institucional);

            color: white;

            text-align: center;

            font-size: 13px;
        }

        .tabela th:first-child {
            text-align: left;
        }

        .tabela td {
            padding: 16px 18px;

            border-bottom:
                1px solid #eef2f7;

            text-align: center;

            color: var(--texto-secundario);

            font-size: 14px;
        }

        .tabela td:first-child {
            text-align: left;

            color: var(--texto-principal);

            font-weight: 600;
        }

        .tabela tr:hover td {
            background: #f8fbff;
        }

        .check {
            color: #2563eb;

            font-weight: 800;
        }

        .no-check {
            color: #94a3b8;

            font-weight: 700;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            background: #020617;

            color: #94a3b8;

            padding: 75px 0 30px;

            border-top:
                1px solid rgba(255,255,255,.08);
        }

        .footer-grid {
            display: grid;

            grid-template-columns:
                1.5fr 1fr 1fr 1.2fr;

            gap: 40px;

            margin-bottom: 55px;
        }

        .footer h3 {
            color: white;

            font-size: 16px;

            margin-bottom: 18px;
        }

        .footer .brand-title {
            font-size: 22px;

            font-weight: 800;

            margin-bottom: 14px;
            color: white;
        }

        .footer p {
            color: #64748b;

            font-size: 14px;

            line-height: 1.7;
        }

        .footer a {
            display: block;

            color: #94a3b8;

            text-decoration: none;

            font-size: 14px;

            margin-bottom: 11px;

            transition: .3s;
        }

        .footer a:hover {
            color: white;

            transform: translateX(3px);
        }

        .social {
            display: flex;

            gap: 9px;

            margin-top: 20px;
        }

        .social a {
            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background:
                rgba(255,255,255,.05);

            color: white;

            margin: 0;
        }

        .social a:hover {
            background: var(--azul-tech);

            transform: translateY(-2px);
        }

        .newsletter {
            display: flex;

            gap: 8px;

            margin-top: 15px;
        }

        .newsletter input {
            flex: 1;

            min-width: 0;

            padding: 11px 13px;

            border-radius: 8px;

            border:
                1px solid rgba(255,255,255,.1);

            background:
                rgba(255,255,255,.05);

            color: white;

            outline: none;

            font-family: inherit;
        }

        .newsletter button {
            border: none;

            border-radius: 8px;

            padding: 0 18px;

            background: var(--azul-tech);

            color: white;

            cursor: pointer;

            font-weight: 600;
        }

        .newsletter button:hover {
            background: var(--azul-hover);
        }

        .copy {
            padding-top: 25px;

            border-top:
                1px solid rgba(255,255,255,.05);

            text-align: center;

            color: #475569;

            font-size: 13px;
        }


        /* =========================================================
           LOADER
        ========================================================= */


        /* =========================================================
           FERRAMENTAS FLUTUANTES
        ========================================================= */

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

        .robo-floating-btn,
        #accessibility-toggle {
            width: 56px;
            height: 56px;

            display: flex;

            align-items: center;
            justify-content: center;

            border: none;

            border-radius: 14px;

            color: white;

            cursor: pointer;

            text-decoration: none;

            box-shadow:
                0 10px 25px rgba(0,0,0,.15);

            transition: .3s;
        }

        .robo-floating-btn {
            background: var(--azul-tech);
        }

        #accessibility-toggle {
            background: var(--azul-institucional);

            font-size: 20px;
        }

        .robo-floating-btn:hover,
        #accessibility-toggle:hover {
            transform: translateY(-3px);

            box-shadow:
                0 15px 30px rgba(0,0,0,.2);
        }

        .robo-floating-btn svg {
            width: 25px;
            height: 25px;
        }


        /* =========================================================
           ACESSIBILIDADE
        ========================================================= */

        .accessibility-container {
            position: relative;
        }

        .accessibility-panel {
            position: absolute;

            right: 0;

            bottom: 68px;

            width: 280px;

            background: white;

            border-radius: 12px;

            overflow: hidden;

            border:
                1px solid var(--borda-suave);

            box-shadow:
                0 20px 40px rgba(0,0,0,.15);

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
            display: flex;

            align-items: center;

            gap: 8px;

            padding: 14px;

            background: var(--azul-institucional);

            color: white;

            font-size: 14px;

            font-weight: 700;
        }

        .accessibility-panel button {
            width: 100%;

            padding: 12px 16px;

            border: none;

            border-bottom:
                1px solid var(--borda-suave);

            background: white;

            color: var(--texto-principal);

            text-align: left;

            cursor: pointer;

            font-family: inherit;

            font-size: 13px;

            transition: .2s;
        }

        .accessibility-panel button:hover {
            background: var(--azul-claro);

            color: var(--azul-tech);

            padding-left: 20px;
        }


        /* =========================================================
           MODO ESCURO
        ========================================================= */

        .dark-mode {
            background: #090d16 !important;

            color: #e2e8f0 !important;
        }

        .dark-mode .navbar {
            background: #0f172a !important;

            border-color: #1e293b !important;
        }

        .dark-mode .menu a {
            color: #e2e8f0;
        }

        .dark-mode .logo {
            color: white;
        }

        .dark-mode .plano-card {
            background: #0f172a !important;

            border-color: #1e293b !important;
        }

        .dark-mode .plano-card:not(.destaque) h3,
        .dark-mode .plano-card:not(.destaque) .preco {
            color: #f8fafc;
        }

        .dark-mode .plano-card:not(.destaque) .descricao,
        .dark-mode .plano-card:not(.destaque) li {
            color: #94a3b8;
        }

        .dark-mode .section-heading h2,
        .dark-mode .comparativo-heading h2 {
            color: #f8fafc;
        }

        .dark-mode .section-heading p,
        .dark-mode .comparativo-heading p {
            color: #94a3b8;
        }

        .dark-mode .tabela table {
            background: #0f172a;
        }

        .dark-mode .tabela td {
            border-color: #1e293b;

            color: #94a3b8;
        }

        .dark-mode .tabela td:first-child {
            color: #e2e8f0;
        }

        .dark-mode .tabela tr:hover td {
            background: #162033;
        }

        .dark-mode .accessibility-panel {
            background: #0f172a;

            border-color: #1e293b;
        }

        .dark-mode .accessibility-panel button {
            background: #0f172a;

            color: #e2e8f0;

            border-color: #1e293b;
        }

        .dark-mode .accessibility-panel button:hover {
            background: #1e293b;
        }


        /* =========================================================
           ALTO CONTRASTE
        ========================================================= */

        .alto-contraste {
            background: #000 !important;
        }

        .alto-contraste .navbar,
        .alto-contraste .plano-card,
        .alto-contraste .tabela table,
        .alto-contraste .accessibility-panel {
            background: #111 !important;

            border:
                1px solid #FFD700 !important;
        }

        .alto-contraste h1,
        .alto-contraste h2,
        .alto-contraste h3,
        .alto-contraste p,
        .alto-contraste a,
        .alto-contraste span,
        .alto-contraste li {
            color: #fff !important;
        }

        .alto-contraste .btn,
        .alto-contraste .btn-plano {
            background: #FFD700 !important;

            color: #000 !important;
        }

        .alto-contraste .tabela td,
        .alto-contraste .tabela th {
            border-color: #FFD700;
        }

        .alto-contraste .accessibility-panel button {
            background: #111;

            color: white;

            border-bottom:
                1px solid #FFD700;
        }

        .alto-contraste .accessibility-panel button:hover {
            background: #FFD700;

            color: #000;
        }


        /* =========================================================
           RESPONSIVIDADE
        ========================================================= */

        @media (max-width: 992px) {

            .planos-grid {
                grid-template-columns: 1fr 1fr;
            }

            .planos-grid .destaque {
                grid-column: span 2;
                max-width: 520px;
                width: 100%;
                margin: auto;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

        }


        @media (max-width: 768px) {

            .container {
                width: 92%;
            }

            .topbar {
                display: none;
            }

            .navbar .flex {
                flex-direction: column;

                gap: 15px;
            }

            .logo {
                font-size: 24px;
            }

            .menu {
                gap: 18px;

                flex-wrap: wrap;

                justify-content: center;
            }

            .menu a {
                font-size: 13px;
            }

            .navbar .btn {
                width: 100%;

                text-align: center;
            }

            .planos-hero {
                padding: 75px 15px;
            }

            .planos-hero h1 {
                font-size: 34px;
            }

            .planos-hero p {
                font-size: 15px;
            }

            .planos-section {
                padding: 60px 0 70px;
            }

            .section-heading h2 {
                font-size: 28px;
            }

            .planos-grid {
                grid-template-columns: 1fr;
            }

            .planos-grid .destaque {
                grid-column: auto;
                max-width: none;
            }

            .plano-card {
                padding: 28px;
            }

            .preco {
                font-size: 30px;
            }

            .comparativo {
                margin-top: 65px;
            }

            .comparativo-heading h2 {
                font-size: 27px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .newsletter {
                flex-direction: column;
            }

            .newsletter button {
                padding: 12px;
            }

            .ferramentas-flutuantes-container {
                right: 15px;
                bottom: 15px;
            }

            .robo-floating-btn,
            #accessibility-toggle {
                width: 52px;
                height: 52px;
            }

            .accessibility-panel {
                width: 260px;

                right: 0;

                bottom: 64px;
            }

        }

    </style>
</head>


<body>

    <!-- =========================================================
         BACKGROUND
    ========================================================= -->

    <div class="ambient-glow"></div>
    <div class="ambient-glow-bottom"></div>


    <!-- =========================================================
         LOADER
    ========================================================= -->


    <!-- =========================================================
         FERRAMENTAS FLUTUANTES
    ========================================================= -->

    <div class="ferramentas-flutuantes-container">

        <!-- ROBÔ -->

        <a href="{{ url('/chat') }}"
            class="robo-floating-btn"
            title="Conversar com a I.A"
            aria-label="Conversar com a inteligência artificial">

            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">

                <path d="M12 8V4H8" />

                <rect
                    width="16"
                    height="12"
                    x="4"
                    y="8"
                    rx="2" />

                <path d="M2 14h2" />
                <path d="M20 14h2" />
                <path d="M15 13v2" />
                <path d="M9 13v2" />

            </svg>

        </a>


        <!-- ACESSIBILIDADE -->

        <div class="accessibility-container">

            <button id="accessibility-toggle"
                aria-label="Abrir acessibilidade"
                aria-expanded="false">

                <i class="fas fa-universal-access"></i>

            </button>


            <div class="accessibility-panel"
                id="accessibility-panel">

                <div class="accessibility-header">

                    <i class="fas fa-universal-access"></i>

                    <span>Acessibilidade</span>

                </div>

                <button onclick="alterarFonte(0.1)">
                    🔍 Aumentar Fonte
                </button>

                <button onclick="alterarFonte(-0.1)">
                    🔎 Diminuir Fonte
                </button>

                <button onclick="toggleDark()">
                    🌙 Modo Escuro
                </button>

                <button onclick="toggleContraste()">
                    ◐ Alto Contraste
                </button>

                <button onclick="lerPagina()">
                    🔊 Ler Página
                </button>

                <button onclick="pararLeitura()">
                    ⏹ Parar Leitura
                </button>

                <button onclick="resetarAcessibilidade()">
                    ↺ Restaurar Padrão
                </button>

            </div>

        </div>

    </div>


    <!-- =========================================================
         TOPBAR
    ========================================================= -->

    <div class="topbar">

        <div class="container flex">

            <div class="top-info">

                <a href="https://wa.me/551994010744?text=Olá!%20Seja%20Bem-vindo(a)%20à%20GeoSync!%20Como%20posso%20ajudar?"
                    target="_blank">

                    <i class="fas fa-phone-alt"></i>

                    +55 (19) 99401-0744

                </a>


                <a href="mailto:murilo.breda@aluno.senai.br"
                    target="_blank">

                    <i class="fas fa-envelope"></i>

                    contatogeosync@gmail.com

                </a>

            </div>


            <div class="top-icons">

                <a href="https://www.facebook.com"
                    target="_blank"
                    aria-label="Facebook">

                    <i class="fab fa-facebook-f"></i>

                </a>

                <a href="https://x.com"
                    target="_blank"
                    aria-label="X">

                    <i class="fab fa-twitter"></i>

                </a>

                <a href="https://br.linkedin.com"
                    target="_blank"
                    aria-label="LinkedIn">

                    <i class="fab fa-linkedin-in"></i>

                </a>

                <a href="https://www.instagram.com/geosync_tambau/"
                    target="_blank"
                    aria-label="Instagram">

                    <i class="fab fa-instagram"></i>

                </a>

            </div>

        </div>

    </div>


    <!-- =========================================================
         NAVBAR
    ========================================================= -->

    <div class="navbar">

        <div class="container flex">

            <a href="/" class="logo">

                <img src="{{ asset('img/Logo.png') }}"
                    alt="Logo GeoSync">

                <span>GeoSync</span>

            </a>


            <div class="menu">

                <a href="/">
                    Início
                </a>

                <a href="/about">
                    Sobre
                </a>

                <a href="/avaliar">
                    Comentários
                </a>

                <a href="/planos" class="active" aria-current="page">
                    Planos
                </a>

            </div>


            <a href="/login" class="btn">
                Área do Cliente
            </a>

        </div>

    </div>


    <!-- =========================================================
         HERO
    ========================================================= -->

    <section class="planos-hero">

        <div class="container planos-hero-content">

            <span class="hero-tag">

                <i class="fas fa-circle"></i>

                Soluções GeoSync

            </span>

            <h1>
                Planos para sua
                <span>operação logística</span>
            </h1>

            <p>

                Escolha a solução ideal para monitorar sua operação,
                rastrear veículos em tempo real e otimizar seus
                processos logísticos.

            </p>

        </div>

    </section>


    <!-- =========================================================
         PLANOS
    ========================================================= -->

    <section class="planos-section">

        <div class="container">


            <div class="section-heading">

                <span class="sub-header">
                    Nossos planos
                </span>

                <h2>
                    Escolha o nível ideal para sua operação
                </h2>

                <p>
                    Comece com os recursos essenciais e evolua
                    conforme sua operação cresce.
                </p>

            </div>


            <div class="planos-grid">


                <!-- =================================================
                     START
                ================================================= -->

                <div class="plano-card">

                    <div class="plano-icon">

                        <i class="fas fa-map-marker-alt"></i>

                    </div>


                    <h3>
                        GeoSync Start
                    </h3>


                    <div class="preco">

                        R$149,99

                        <span>
                            /mês
                        </span>

                    </div>


                    <p class="descricao">

                        Ideal para pequenas empresas
                        e profissionais autônomos.

                    </p>


                    <ul>

                        <li>
                            <i class="fas fa-check"></i>
                            Até 10 entregas
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Rastreamento em tempo real
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Alertas inteligentes
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Dashboard
                        </li>

                    </ul>


                    <!-- MANTIDA A LÓGICA ORIGINAL -->

                    <a href="/pagamento?plano=start"
                        class="btn-plano">

                        Assinar Start

                    </a>

                </div>


                <!-- =================================================
                     PRO
                ================================================= -->

                <div class="plano-card destaque">

                    <span class="badge">
                        MAIS POPULAR
                    </span>


                    <div class="plano-icon">

                        <i class="fas fa-truck"></i>

                    </div>


                    <h3>
                        GeoSync Pro
                    </h3>


                    <div class="preco">

                        R$599,99

                        <span>
                            /6 mês
                        </span>

                    </div>


                    <p class="descricao">

                        Controle completo para empresas
                        em crescimento.

                    </p>


                    <ul>

                        <li>
                            <i class="fas fa-check"></i>
                            Até 65 entregas
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Rastreamento em tempo real
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Alertas inteligentes
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Dashboard
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Suporte prioritário
                        </li>

                    </ul>


                    <!-- MANTIDA A LÓGICA ORIGINAL -->

                    <a href="/pagamento?plano=pro"
                        class="btn-plano">

                        Assinar Pro

                    </a>

                </div>


                <!-- =================================================
                     ENTERPRISE
                ================================================= -->

                <div class="plano-card">

                    <div class="plano-icon">

                        <i class="fas fa-building"></i>

                    </div>


                    <h3>
                        Enterprise
                    </h3>


                    <div class="preco">
                        Personalizado
                    </div>


                    <p class="descricao">

                        Para grandes operações
                        logísticas que precisam de
                        uma solução personalizada.

                    </p>


                    <ul>

                        <li>
                            <i class="fas fa-check"></i>
                            Entregas ilimitadas
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Rastreamento em tempo real
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Alertas inteligentes
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Dashboard
                        </li>

                        <li>
                            <i class="fas fa-check"></i>
                            Suporte prioritário
                        </li>

                    </ul>


                    <!-- MANTIDA A LÓGICA ORIGINAL -->

                    <a href="https://wa.me/551994010744?text=Olá,%20quero%20mais%20informações%20sobre%20o%20plano%20Enterprise"
                        target="_blank"
                        class="btn-plano">

                        Falar com Consultor

                    </a>

                </div>

            </div>


            <!-- =================================================
                 COMPARATIVO
            ================================================= -->

            <div class="comparativo">

                <div class="comparativo-heading">

                    <span class="sub-header">
                        Comparação
                    </span>

                    <h2>
                        Compare os planos
                    </h2>

                    <p>
                        Veja rapidamente os recursos disponíveis
                        em cada opção.
                    </p>

                </div>


                <div class="tabela">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    Recursos
                                </th>

                                <th>
                                    Start
                                </th>

                                <th>
                                    Pro
                                </th>

                                <th>
                                    Enterprise
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <tr>

                                <td>
                                    Rastreamento em tempo real
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                            </tr>


                            <tr>

                                <td>
                                    Alertas inteligentes
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                            </tr>


                            <tr>

                                <td>
                                    Dashboard
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                            </tr>


                            <tr>

                                <td>
                                    Suporte prioritário
                                </td>

                                <td class="no-check">
                                    ✖
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                                <td class="check">
                                    ✔
                                </td>

                            </tr>


                            <tr>

                                <td>
                                    Entregas
                                </td>

                                <td>
                                    10
                                </td>

                                <td>
                                    65
                                </td>

                                <td>
                                    Ilimitado
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         VLibras
    ========================================================= -->

    <div vw class="enabled">

        <div vw-access-button class="active"></div>

        <div vw-plugin-wrapper>

            <div class="vw-plugin-top-wrapper"></div>

        </div>

    </div>


    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>

    <script>

        if (window.VLibras) {

            new window.VLibras.Widget(
                'https://vlibras.gov.br/app'
            );

        }

    </script>


    <!-- =========================================================
         FOOTER
    ========================================================= -->

    <footer class="footer">

        <div class="container">

            <div class="footer-grid">


                <div>

                    <div class="brand-title">
                        GeoSync
                    </div>

                    <p>

                        Ecossistema inteligente de
                        rastreamento, monitoramento
                        e gestão logística em tempo real.

                    </p>


                    <div class="social">

                        <a href="https://www.facebook.com/geosync"
                            target="_blank">

                            <i class="fab fa-facebook-f"></i>

                        </a>

                        <a href="https://x.com/geosync"
                            target="_blank">

                            <i class="fab fa-twitter"></i>

                        </a>

                        <a href="https://br.linkedin.com/company/geosync"
                            target="_blank">

                            <i class="fab fa-linkedin-in"></i>

                        </a>

                        <a href="https://www.instagram.com/geosync_tambau/"
                            target="_blank">

                            <i class="fab fa-instagram"></i>

                        </a>

                    </div>

                </div>


                <div>

                    <h3>
                        Navegação
                    </h3>

                    <a href="/">
                        Início
                    </a>

                    <a href="/about">
                        Sobre
                    </a>

                    <a href="/login">
                        Serviço
                    </a>

                    <a href="/avaliar">
                        Comentários
                    </a>

                    <a href="/planos">
                        Planos
                    </a>

                    <a href="/cadastro-admin">
                        Cadastro Admin
                    </a>

                </div>


                <div>

                    <h3>
                        Contato
                    </h3>

                    <p>
                        R. Cap. David, 56 - Centro
                    </p>

                    <p>
                        Tambaú - SP
                    </p>

                    <p>
                        (19) 99401-0744
                    </p>

                    <p>
                        contact@geosync.com
                    </p>

                </div>


                <div>

                    <h3>
                        Informativo
                    </h3>

                    <p>
                        Receba novidades e atualizações
                        sobre a plataforma GeoSync.
                    </p>


                    <div class="newsletter">

                        <input
                            type="email"
                            placeholder="Seu e-mail profissional">

                        <button type="button">
                            Assinar
                        </button>

                    </div>

                </div>

            </div>


            <div class="copy">

                © 2026 GeoSync -
                Todos os direitos reservados.

            </div>

        </div>

    </footer>


    <!-- =========================================================
         JAVASCRIPT
    ========================================================= -->

    <script>


        /* =====================================================
           ACESSIBILIDADE
        ===================================================== */

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const accessBtn =
                    document.getElementById(
                        'accessibility-toggle'
                    );

                const accessPanel =
                    document.getElementById(
                        'accessibility-panel'
                    );


                if (accessBtn && accessPanel) {

                    accessBtn.setAttribute(
                        'aria-expanded',
                        'false'
                    );


                    accessBtn.addEventListener(
                        'click',
                        function (event) {

                            event.stopPropagation();

                            const active =
                                accessPanel.classList.toggle(
                                    'active'
                                );

                            accessBtn.setAttribute(
                                'aria-expanded',
                                String(active)
                            );

                        }
                    );


                    document.addEventListener(
                        'click',
                        function (event) {

                            if (
                                !accessBtn.contains(
                                    event.target
                                ) &&
                                !accessPanel.contains(
                                    event.target
                                )
                            ) {

                                accessPanel.classList.remove(
                                    'active'
                                );

                                accessBtn.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );

                            }

                        }
                    );

                }


                /* Recuperar tamanho da fonte */

                const escala =
                    localStorage.getItem(
                        'fontScale'
                    ) || '1';

                document.documentElement.style.setProperty(
                    '--font-scale',
                    escala
                );


                /* Recuperar modo escuro */

                if (
                    localStorage.getItem(
                        'darkMode'
                    ) === 'true'
                ) {

                    document.body.classList.add(
                        'dark-mode'
                    );

                }


                /* Recuperar contraste */

                if (
                    localStorage.getItem(
                        'contraste'
                    ) === 'true'
                ) {

                    document.body.classList.add(
                        'alto-contraste'
                    );

                }

            }
        );


        /* =====================================================
           AUMENTAR / DIMINUIR FONTE
        ===================================================== */

        function alterarFonte(valor) {

            const atual =
                parseFloat(
                    getComputedStyle(
                        document.documentElement
                    ).getPropertyValue(
                        '--font-scale'
                    )
                ) || 1;


            let novaEscala =
                atual + valor;


            if (novaEscala < 0.7) {
                novaEscala = 0.7;
            }


            if (novaEscala > 1.7) {
                novaEscala = 1.7;
            }


            novaEscala =
                parseFloat(
                    novaEscala.toFixed(2)
                );


            document.documentElement.style.setProperty(
                '--font-scale',
                novaEscala
            );


            localStorage.setItem(
                'fontScale',
                String(novaEscala)
            );

        }


        /* =====================================================
           MODO ESCURO
        ===================================================== */

        function toggleDark() {

            document.body.classList.toggle(
                'dark-mode'
            );


            localStorage.setItem(
                'darkMode',
                String(
                    document.body.classList.contains(
                        'dark-mode'
                    )
                )
            );

        }


        /* =====================================================
           ALTO CONTRASTE
        ===================================================== */

        function toggleContraste() {

            document.body.classList.toggle(
                'alto-contraste'
            );


            localStorage.setItem(
                'contraste',
                String(
                    document.body.classList.contains(
                        'alto-contraste'
                    )
                )
            );

        }


        /* =====================================================
           LEITURA DA PÁGINA
        ===================================================== */

        function lerPagina() {

            if (!window.speechSynthesis) {
                return;
            }


            window.speechSynthesis.cancel();


            let texto =
                window.getSelection()
                    .toString()
                    .trim();


            if (!texto) {

                const elementos =
                    document.querySelectorAll(
                        'h1, h2, h3, p, li, span'
                    );


                let blocos = [];


                elementos.forEach(function (elemento) {

                    if (
                        elemento.innerText &&
                        elemento.innerText.trim().length > 3 &&
                        !elemento.closest(
                            '.accessibility-panel'
                        )
                    ) {

                        blocos.push(
                            elemento.innerText.trim()
                        );

                    }

                });


                texto =
                    blocos.join('. ');

            }


            if (!texto) {
                return;
            }


            const fala =
                new SpeechSynthesisUtterance(
                    texto
                );


            fala.lang = 'pt-BR';

            fala.rate = 1.05;

            fala.pitch = 1;


            window.speechSynthesis.speak(
                fala
            );

        }


        /* =====================================================
           PARAR LEITURA
        ===================================================== */

        function pararLeitura() {

            if (
                window.speechSynthesis
            ) {

                window.speechSynthesis.cancel();

            }

        }


        /* =====================================================
           RESTAURAR ACESSIBILIDADE
        ===================================================== */

        function resetarAcessibilidade() {

            pararLeitura();


            localStorage.removeItem(
                'fontScale'
            );

            localStorage.removeItem(
                'darkMode'
            );

            localStorage.removeItem(
                'contraste'
            );


            document.body.classList.remove(
                'dark-mode',
                'alto-contraste'
            );


            document.documentElement.style.setProperty(
                '--font-scale',
                '1'
            );

        }

    </script>

</body>

</html>
