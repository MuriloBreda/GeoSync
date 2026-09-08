<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>GeoSync | Rastreamento Inteligente e Logística</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>

        /* =====================================================
           VARIÁVEIS
        ===================================================== */

        :root {
            --azul-institucional: #0f172a;
            --azul-tech: #2563eb;
            --azul-hover: #1d4ed8;
            --azul-profundo: #020617;

            --azul-claro: #eef5ff;
            --azul-suave: #f5f8fc;

            --texto-principal: #172033;
            --texto-secundario: #687994;

            --borda-suave: #e5eaf1;

            --branco: #ffffff;

            --font-scale: 1;
        }


        /* =====================================================
           RESET
        ===================================================== */

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
            background: #ffffff;
            color: var(--texto-principal);
            overflow-x: hidden;
            position: relative;
            zoom: var(--font-scale);
            transition: background .3s ease, color .3s ease;
        }


        /* =====================================================
           FUNDOS AMBIENTAIS
        ===================================================== */

        .ambient-glow {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37, 99, 235, .07) 0%,
                    rgba(255, 255, 255, 0) 70%
                );

            top: -250px;
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
                    rgba(15, 23, 42, .04) 0%,
                    rgba(255, 255, 255, 0) 70%
                );

            bottom: -250px;
            left: -200px;

            z-index: -1;
            pointer-events: none;
        }


        /* =====================================================
           CONTAINER
        ===================================================== */

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
            padding: 100px 0;
        }


        /* =====================================================
           TOPBAR
        ===================================================== */

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


        /* =====================================================
           BOTÕES
        ===================================================== */

        .btn {
            background: var(--azul-tech);

            color: white;

            padding: 11px 24px;

            border-radius: 8px;

            text-decoration: none;

            font-weight: 600;
            font-size: 14px;

            transition: .3s ease;

            box-shadow:
                0 5px 16px rgba(37,99,235,.18);

            display: inline-block;
        }

        .btn:hover {
            background: var(--azul-hover);

            transform: translateY(-2px);

            box-shadow:
                0 9px 25px rgba(37,99,235,.28);
        }


        /* =====================================================
           HERO
        ===================================================== */

        .hero {
            padding: 105px 0 95px;

            background:
                linear-gradient(
                    135deg,
                    #07111f 0%,
                    #142238 100%
                );

            color: white;

            position: relative;

            overflow: hidden;
        }

        .hero::before {
            content: '';

            position: absolute;

            inset: 0;

            background:
                url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1920&q=80")
                center/cover;

            opacity: .09;

            mix-blend-mode: screen;
        }

        .hero::after {
            content: "";

            position: absolute;

            width: 500px;
            height: 500px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.22),
                    transparent 70%
                );

            right: -200px;
            top: -180px;
        }

        .hero-grid {
            display: grid;

            grid-template-columns: 1.05fr .95fr;

            gap: 70px;

            align-items: center;

            position: relative;

            z-index: 2;
        }

        .hero-tag {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            background: rgba(37,99,235,.12);

            color: #75a8ff;

            border: 1px solid rgba(96,165,250,.18);

            padding: 7px 15px;

            border-radius: 30px;

            font-size: 12px;
            font-weight: 600;

            margin-bottom: 22px;
        }

        .hero-tag i {
            font-size: 7px;
        }

        .hero h1 {
            font-size: clamp(42px, 5vw, 58px);

            line-height: 1.08;

            font-weight: 800;

            letter-spacing: -2px;

            max-width: 700px;

            margin-bottom: 22px;
        }

        .hero h1 span {
            background:
                linear-gradient(
                    90deg,
                    #60a5fa,
                    #3b82f6
                );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 17px;

            color: #a5b4c9;

            line-height: 1.8;

            max-width: 650px;

            margin-bottom: 35px;
        }


        /* =====================================================
           MOCKUP
        ===================================================== */

        .hero-mockup {
            background: rgba(255,255,255,.035);

            border: 1px solid rgba(255,255,255,.12);

            border-radius: 18px;

            padding: 17px;

            box-shadow:
                0 30px 70px rgba(0,0,0,.35);

            backdrop-filter: blur(10px);
        }

        .mockup-header {
            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 14px;

            padding: 3px 5px 12px;

            border-bottom:
                1px solid rgba(255,255,255,.08);
        }

        .mockup-dot {
            width: 9px;
            height: 9px;

            border-radius: 50%;
        }

        .dot-red {
            background: #ef4444;
        }

        .dot-yellow {
            background: #f59e0b;
        }

        .dot-green {
            background: #10b981;
        }

        .mockup-img {
            width: 100%;

            height: 330px;

            object-fit: cover;

            border-radius: 10px;
        }


        /* =====================================================
           TIPOGRAFIA
        ===================================================== */

        h2 {
            font-size: 37px;

            line-height: 1.2;

            font-weight: 800;

            color: var(--azul-institucional);

            letter-spacing: -1.1px;

            margin-bottom: 17px;
        }

        h3 {
            font-size: 20px;

            line-height: 1.3;

            font-weight: 700;

            color: var(--azul-institucional);

            margin-bottom: 11px;
        }

        p {
            font-size: 15.5px;

            line-height: 1.8;

            color: var(--texto-secundario);
        }

        .sub-header {
            color: var(--azul-tech);

            font-weight: 700;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 1.8px;

            display: block;

            margin-bottom: 10px;
        }


        /* =====================================================
           SOBRE
        ===================================================== */

        .block-about {
            background: #fff;

            border-radius: 20px;

            padding: 48px;

            border: 1px solid var(--borda-suave);

            box-shadow:
                0 15px 40px rgba(15,23,42,.045);

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 55px;

            align-items: center;
        }

        .block-about img {
            width: 100%;

            height: 370px;

            object-fit: cover;

            border-radius: 14px;
        }


        /* =====================================================
           SERVIÇOS
        ===================================================== */

        .services-grid {
            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(320px, 1fr));

            gap: 28px;
        }

        .service-card {
            background: white;

            border-radius: 18px;

            padding: 25px;

            border: 1px solid var(--borda-suave);

            transition: .35s ease;

            box-shadow:
                0 6px 25px rgba(15,23,42,.035);
        }

        .service-card:hover {
            transform: translateY(-7px);

            box-shadow:
                0 20px 45px rgba(15,23,42,.09);

            border-color:
                rgba(37,99,235,.25);
        }

        .service-card img {
            width: 100%;

            height: 210px;

            object-fit: cover;

            border-radius: 12px;

            margin-bottom: 23px;
        }


        /* =====================================================
           DIFERENCIAIS — NOVO DESIGN
        ===================================================== */

        .diferenciais-section {
            background:
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    #f8fafc 100%
                );

            position: relative;

            overflow: hidden;
        }

        .diferenciais-section::before {
            content: "";

            position: absolute;

            width: 550px;
            height: 550px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.055),
                    transparent 70%
                );

            right: -250px;
            top: -150px;

            pointer-events: none;
        }

        .diferenciais-topo {
            display: grid;

            grid-template-columns:
                .95fr 1.05fr;

            gap: 85px;

            align-items: center;

            position: relative;

            z-index: 1;

            margin-bottom: 65px;
        }

        .diferenciais-conteudo {
            max-width: 620px;
        }

        .diferenciais-conteudo h2 {
            font-size: clamp(38px, 4vw, 48px);

            letter-spacing: -1.8px;

            margin-bottom: 22px;
        }

        .diferenciais-conteudo p {
            font-size: 16px;

            line-height: 1.9;

            color: #687994;

            margin-bottom: 16px;
        }

        .diferenciais-conteudo p:last-child {
            margin-bottom: 0;
        }

        .diferenciais-imagem {
            position: relative;
        }

        .diferenciais-imagem::before {
            content: "";

            position: absolute;

            width: 90px;
            height: 90px;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );

            top: -18px;
            right: -18px;

            z-index: 0;

            opacity: .12;
        }

        .diferenciais-imagem::after {
            content: "";

            position: absolute;

            width: 130px;
            height: 130px;

            border-radius: 50%;

            border: 1px solid rgba(37,99,235,.12);

            bottom: -35px;
            left: -35px;

            z-index: 0;
        }

        .diferenciais-imagem img {
            width: 100%;

            height: 525px;

            object-fit: cover;

            border-radius: 20px;

            display: block;

            position: relative;

            z-index: 1;

            box-shadow:
                0 25px 55px rgba(15,23,42,.12);

            transition: transform .5s ease;
        }

        .diferenciais-imagem:hover img {
            transform: scale(1.015);
        }


        /* =====================================================
           CARDS DE DIFERENCIAIS
        ===================================================== */

        .cards-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 22px;

            position: relative;

            z-index: 2;
        }

        .card-feature {
            padding: 30px;

            border-radius: 17px;

            transition: .35s ease;

            position: relative;

            overflow: hidden;
        }

        .card-feature.azul {
            background:
                linear-gradient(
                    145deg,
                    #0b1728,
                    #162b47
                );

            color: white;

            box-shadow:
                0 15px 35px rgba(15,23,42,.12);
        }

        .card-feature.azul::after {
            content: "";

            position: absolute;

            width: 130px;
            height: 130px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(59,130,246,.2),
                    transparent 70%
                );

            right: -55px;
            bottom: -55px;
        }

        .card-feature.azul p {
            color: #9cafc7;
        }

        .card-feature.azul h3 {
            color: white;
        }

        .card-feature.branco {
            background: white;

            border: 1px solid var(--borda-suave);

            box-shadow:
                0 10px 30px rgba(15,23,42,.04);
        }

        .card-feature:hover {
            transform: translateY(-6px);

            box-shadow:
                0 20px 40px rgba(15,23,42,.11);
        }

        .icon-box {
            width: 54px;
            height: 54px;

            border-radius: 13px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin-bottom: 19px;

            font-size: 20px;
        }

        .icon-box.azul-bg {
            background: #eef5ff;

            color: var(--azul-tech);
        }

        .icon-box.white-bg {
            background: rgba(255,255,255,.09);

            color: #60a5fa;
        }


        /* =====================================================
           SEÇÕES ADICIONAIS
        ===================================================== */

        .info-section {
            padding: 95px 0;
        }

        .section-title-center {
            text-align: center;

            max-width: 720px;

            margin: 0 auto 52px;
        }

        .section-title-center p {
            margin-top: 10px;
        }

        .iot-grid,
        .process-grid,
        .benefits-grid,
        .stats-grid,
        .alert-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 24px;
        }

        .info-card {
            background: white;

            border: 1px solid var(--borda-suave);

            border-radius: 17px;

            padding: 30px;

            box-shadow:
                0 8px 25px rgba(15,23,42,.035);

            transition: .35s ease;
        }

        .info-card:hover {
            transform: translateY(-6px);

            box-shadow:
                0 18px 40px rgba(15,23,42,.08);

            border-color:
                rgba(37,99,235,.22);
        }

        .info-card .icon-box {
            background: #eef5ff;

            color: var(--azul-tech);
        }

        .info-card h3 {
            margin-bottom: 10px;
        }

        .info-card ul {
            padding-left: 18px;

            margin-top: 15px;

            color: var(--texto-secundario);

            line-height: 1.9;

            font-size: 14px;
        }


        /* =====================================================
           PROCESSO
        ===================================================== */

        .process-number {
            width: 48px;
            height: 48px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            color: white;

            font-weight: 800;

            font-size: 15px;

            margin-bottom: 20px;

            box-shadow:
                0 8px 18px rgba(37,99,235,.2);
        }


        /* =====================================================
           ESTATÍSTICAS
        ===================================================== */

        .stats-section {
            background:
                linear-gradient(
                    135deg,
                    #081322,
                    #152944
                );

            color: white;

            position: relative;

            overflow: hidden;
        }

        .stats-section::before {
            content: "";

            position: absolute;

            width: 500px;
            height: 500px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(37,99,235,.18),
                    transparent 70%
                );

            right: -200px;
            top: -200px;
        }

        .stats-section h2,
        .stats-section .sub-header {
            color: white;
        }

        .stat-card {
            text-align: center;

            padding: 32px 20px;

            border:
                1px solid rgba(255,255,255,.09);

            background:
                rgba(255,255,255,.035);

            border-radius: 16px;

            backdrop-filter: blur(8px);

            transition: .3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);

            background:
                rgba(255,255,255,.055);
        }

        .stat-number {
            display: block;

            font-size: 39px;

            font-weight: 800;

            color: #60a5fa;

            margin-bottom: 8px;

            letter-spacing: -1px;
        }

        .stat-label {
            color: #cbd5e1;

            font-size: 13px;
        }


        /* =====================================================
           ALERTAS
        ===================================================== */

        .alert-card {
            display: flex;

            gap: 18px;

            align-items: flex-start;

            background: white;

            border: 1px solid var(--borda-suave);

            border-radius: 16px;

            padding: 25px;

            transition: .35s;
        }

        .alert-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 15px 35px rgba(15,23,42,.07);
        }

        .alert-card i {
            font-size: 22px;

            color: var(--azul-tech);

            margin-top: 3px;
        }


        /* =====================================================
           FAQ
        ===================================================== */

        .faq-container {
            max-width: 850px;

            margin: auto;
        }

        .faq-item {
            background: white;

            border: 1px solid var(--borda-suave);

            border-radius: 13px;

            margin-bottom: 12px;

            overflow: hidden;

            transition: .3s;
        }

        .faq-item:has(.faq-question.active) {
            border-color: rgba(37,99,235,.25);

            box-shadow:
                0 10px 30px rgba(37,99,235,.06);
        }

        .faq-question {
            width: 100%;

            padding: 21px;

            background: white;

            border: none;

            display: flex;

            align-items: center;

            justify-content: space-between;

            text-align: left;

            font-family: inherit;

            font-weight: 700;

            color: var(--azul-institucional);

            cursor: pointer;
        }

        .faq-answer {
            display: none;

            padding: 0 21px 21px;
        }

        .faq-answer.active {
            display: block;
        }

        .faq-question i {
            transition: .3s;

            color: var(--azul-tech);
        }

        .faq-question.active i {
            transform: rotate(180deg);
        }


        /* =====================================================
           CTA
        ===================================================== */

        .cta-section {
            margin: 0 auto 90px;

            width: 88%;

            max-width: 1280px;

            padding: 58px;

            border-radius: 22px;

            background:
                linear-gradient(
                    135deg,
                    #0b1728,
                    #2563eb
                );

            color: white;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 30px;

            box-shadow:
                0 20px 50px rgba(37,99,235,.14);
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
            background: #f1f5f9;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            background: #020617;

            color: #94a3b8;

            padding: 80px 0 30px;

            border-top:
                1px solid rgba(255,255,255,.07);
        }

        .footer-grid {
            display: grid;

            grid-template-columns:
                1.5fr 1fr 1fr 1.2fr;

            gap: 40px;

            margin-bottom: 60px;
        }

        .footer h3 {
            color: white;

            font-size: 15px;

            font-weight: 700;

            margin-bottom: 20px;
        }

        .footer p {
            color: #64748b;

            font-size: 13px;
        }

        .footer a {
            display: block;

            color: #94a3b8;

            margin-bottom: 12px;

            text-decoration: none;

            font-size: 13px;

            transition: .3s;
        }

        .footer a:hover {
            color: white;

            transform: translateX(2px);
        }

        .social {
            display: flex;

            gap: 9px;

            margin-top: 20px;
        }

        .social a {
            width: 36px;
            height: 36px;

            border-radius: 9px;

            background: rgba(255,255,255,.05);

            display: flex;

            align-items: center;
            justify-content: center;

            color: white;

            margin: 0;

            transition: .3s;
        }

        .social a:hover {
            background: var(--azul-tech);

            transform: translateY(-3px);
        }

        .newsletter {
            display: flex;

            margin-top: 15px;

            gap: 8px;
        }

        .newsletter input {
            flex: 1;

            padding: 12px 15px;

            border:
                1px solid rgba(255,255,255,.1);

            background:
                rgba(255,255,255,.04);

            outline: none;

            border-radius: 8px;

            color: white;

            font-size: 13px;
        }

        .newsletter input:focus {
            border-color:
                rgba(96,165,250,.5);
        }

        .newsletter button {
            background: var(--azul-tech);

            border: none;

            color: white;

            padding: 0 19px;

            cursor: pointer;

            border-radius: 8px;

            font-weight: 600;

            transition: .3s;
        }

        .newsletter button:hover {
            background: var(--azul-hover);
        }

        .copy {
            text-align: center;

            padding-top: 30px;

            border-top:
                1px solid rgba(255,255,255,.05);

            font-size: 12px;

            color: #475569;
        }


        /* =====================================================
           LOADER
        ===================================================== */

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

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }


        /* =====================================================
           FERRAMENTAS FLUTUANTES
        ===================================================== */

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

            border-radius: 14px;

            display: flex;

            align-items: center;
            justify-content: center;

            color: white;

            border: none;

            cursor: pointer;

            box-shadow:
                0 10px 25px rgba(0,0,0,.15);

            transition: .3s;

            text-decoration: none;
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

            transform: translateY(-4px);

            box-shadow:
                0 15px 30px rgba(0,0,0,.2);
        }

        .accessibility-container {
            position: relative;
        }

        .accessibility-panel {

            position: absolute;

            right: 0;

            bottom: 70px;

            width: 285px;

            background: white;

            border-radius: 14px;

            overflow: hidden;

            box-shadow:
                0 20px 50px rgba(15,23,42,.18);

            border:
                1px solid var(--borda-suave);

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

            background:
                linear-gradient(
                    135deg,
                    #0f172a,
                    #1e3a5f
                );

            color: white;

            padding: 15px;

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

            padding: 13px 16px;

            cursor: pointer;

            font-family: inherit;

            font-size: 13px;

            color: var(--texto-principal);

            border-bottom:
                1px solid var(--borda-suave);

            transition: .2s;
        }

        .accessibility-panel button:hover {

            background: var(--azul-claro);

            color: var(--azul-tech);
        }


        /* =====================================================
           DARK MODE
        ===================================================== */

        .dark-mode {
            background: #090d16 !important;

            color: #e2e8f0 !important;
        }

        .dark-mode .navbar {
            background: rgba(15,23,42,.94) !important;

            border-color: #1e293b !important;
        }

        .dark-mode .logo,
        .dark-mode .menu a {
            color: #e2e8f0;
        }

        .dark-mode .menu a:hover {
            color: #60a5fa;
        }

        .dark-mode .block-about,
        .dark-mode .service-card,
        .dark-mode .card-feature.branco,
        .dark-mode .info-card,
        .dark-mode .alert-card,
        .dark-mode .faq-item,
        .dark-mode .faq-question {

            background: #0f172a !important;

            border-color: #1e293b !important;
        }

        .dark-mode h2,
        .dark-mode h3,
        .dark-mode .faq-question {
            color: #f8fafc !important;
        }

        .dark-mode p,
        .dark-mode .info-card ul {
            color: #94a3b8 !important;
        }

        .dark-mode .diferenciais-section {
            background:
                linear-gradient(
                    180deg,
                    #090d16,
                    #0b1220
                );
        }


        /* =====================================================
           ALTO CONTRASTE
        ===================================================== */

        .alto-contraste {
            background: #000 !important;
        }

        .alto-contraste .navbar,
        .alto-contraste .block-about,
        .alto-contraste .service-card,
        .alto-contraste .card-feature,
        .alto-contraste .info-card,
        .alto-contraste .alert-card,
        .alto-contraste .faq-item {

            background: #111 !important;

            border:
                1px solid #FFD700 !important;
        }

        .alto-contraste h1,
        .alto-contraste h2,
        .alto-contraste h3,
        .alto-contraste p,
        .alto-contraste a,
        .alto-contraste .faq-question {

            color: #FFF !important;
        }


        /* =====================================================
           RESPONSIVIDADE
        ===================================================== */

        @media (max-width: 1100px) {

            .diferenciais-topo {
                gap: 50px;
            }

            .diferenciais-imagem img {
                height: 470px;
            }
        }


        @media (max-width: 992px) {

            .hero-grid,
            .block-about,
            .diferenciais-topo {

                grid-template-columns: 1fr;

                gap: 45px;
            }

            .hero-grid {
                text-align: center;
            }

            .hero p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-mockup {
                max-width: 720px;
                margin: auto;
            }

            .diferenciais-conteudo {
                max-width: 760px;
            }

            .diferenciais-imagem img {
                height: 460px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }

            .iot-grid,
            .process-grid,
            .benefits-grid,
            .stats-grid,
            .alert-grid {

                grid-template-columns: 1fr 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .hero h1 {
                font-size: 43px;
            }
        }


        @media (max-width: 768px) {

            .topbar {
                display: none;
            }

            .navbar .flex {
                flex-direction: column;
                gap: 16px;
            }

            .menu {
                gap: 18px;

                flex-wrap: wrap;

                justify-content: center;
            }

            .hero {
                padding: 75px 0;
            }

            .hero h1 {
                font-size: 36px;

                letter-spacing: -1.2px;
            }

            .hero p {
                font-size: 15px;
            }

            .hero-mockup {
                padding: 10px;
            }

            .mockup-img {
                height: 240px;
            }

            .section,
            .info-section {
                padding: 70px 0;
            }

            h2 {
                font-size: 31px;
            }

            .block-about {
                padding: 28px;
            }

            .block-about img {
                height: 280px;
            }

            .diferenciais-topo {
                gap: 35px;
            }

            .diferenciais-conteudo h2 {
                font-size: 34px;
            }

            .diferenciais-imagem img {
                height: 350px;

                border-radius: 16px;
            }

            .iot-grid,
            .process-grid,
            .benefits-grid,
            .stats-grid,
            .alert-grid {

                grid-template-columns: 1fr;
            }

            .cta-section {
                width: 88%;

                padding: 35px 25px;

                flex-direction: column;

                align-items: flex-start;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .ferramentas-flutuantes-container {
                right: 15px;
                bottom: 15px;
            }

            .robo-floating-btn,
            #accessibility-toggle {
                width: 50px;
                height: 50px;
            }
        }

        #loader {
        position: fixed;
        inset: 0;
        background: radial-gradient(circle at center, #0a1120 0%, #020617 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999999;
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }

    .loader-content {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 300px;
        width: 100%;
    }

    .glow-effect {
        position: absolute;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.35) 0%, rgba(37, 99, 235, 0) 70%);
        border-radius: 50%;
        top: -20px;
        animation: ambientPulse 3s ease-in-out infinite alternate;
        pointer-events: none;
    }

    .loader-icon-wrapper {
        position: relative;
        width: 110px;
        height: 110px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), inset 0 0 15px rgba(37, 99, 235, 0.2);
        margin-bottom: 24px;
    }

    .radar-sweep {
        position: absolute;
        inset: -2px;
        border-radius: 50%;
        border: 2px solid transparent;
        border-top-color: #2563eb;
        border-right-color: rgba(37, 99, 235, 0.3);
        animation: radarSpin 1.2s linear infinite;
    }

    .loader-img {
        width: 54px;
        height: auto;
        z-index: 2;
        filter: drop-shadow(0 0 12px rgba(37, 99, 235, 0.6));
        animation: logoBounce 2s ease-in-out infinite;
    }

    .loader-text h2 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 26px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.5px;
        margin: 0 0 6px 0;
        text-align: center;
    }

    .loader-text h2 span {
        color: #3b82f6;
        background: linear-gradient(90deg, #60a5fa, #2563eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .status-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .status-container p {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: #94a3b8;
        font-weight: 500;
        margin: 0;
        letter-spacing: 0.2px;
    }

    .status-dots {
        display: inline-flex;
        gap: 4px;
    }

    .dot {
        width: 4px;
        height: 4px;
        background-color: #3b82f6;
        border-radius: 50%;
        animation: dotPulse 1.4s infinite ease-in-out both;
    }

    .dot:nth-child(1) { animation-delay: -0.32s; }
    .dot:nth-child(2) { animation-delay: -0.16s; }

    .progress-bar-container {
        width: 100%;
        height: 3px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar {
        position: absolute;
        height: 100%;
        width: 40%;
        background: linear-gradient(90deg, transparent, #2563eb, #60a5fa, transparent);
        border-radius: 10px;
        animation: progressSlide 1.5s infinite ease-in-out;
    }

    .loader-exit {
        opacity: 0 !important;
        visibility: hidden !important;
    }

    @keyframes radarSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes logoBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.06); }
    }

    @keyframes ambientPulse {
        0% { opacity: 0.3; transform: scale(0.9); }
        100% { opacity: 0.8; transform: scale(1.2); }
    }

    @keyframes dotPulse {
        0%, 80%, 100% { transform: scale(0); opacity: 0.3; }
        40% { transform: scale(1); opacity: 1; }
    }

    @keyframes progressSlide {
        0% { left: -40%; }
        100% { left: 100%; }
    }

    </style>
</head>


<body>

    <div class="ambient-glow"></div>
    <div class="ambient-glow-bottom"></div>


    <!-- =====================================================
         LOADER
    ====================================================== -->

    <div id="loader">
        <div class="loader-content">
            <div class="glow-effect"></div>
            <div class="loader-icon-wrapper">
                <div class="radar-sweep"></div>
                <img src="{{ asset('img/Logo.png') }}" alt="GeoSync Logo" class="loader-img">
            </div>
            <div class="loader-text">
                <h2>Geo<span>Sync</span></h2>
                <div class="status-container">
                    <span class="status-dots">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </span>
                    <p>Sincronizando telemetria em tempo real</p>
                </div>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar"></div>
            </div>
        </div>
    </div>


    <!-- =====================================================
         FERRAMENTAS FLUTUANTES
    ====================================================== -->

    <div class="ferramentas-flutuantes-container">

        <a href="{{ url('/chat') }}"
           class="robo-floating-btn"
           title="Conversar com a I.A"
           aria-label="Conversar com a Inteligência Artificial">

            <svg xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">

                <path d="M12 8V4H8" />

                <rect width="16"
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


    <!-- =====================================================
         TOPBAR
    ====================================================== -->

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


    <!-- =====================================================
         NAVBAR
    ====================================================== -->

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


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="hero">

        <div class="container hero-grid">

            <div>

                <span class="hero-tag">

                    <i class="fas fa-circle"></i>

                    Plataforma Inteligente v2.4

                </span>


                <h1>

                    Rastreamento e Logística

                    <span>
                        em Tempo Real
                    </span>

                </h1>


                <p>

                    Monitore frotas, cargas e rotas com
                    inteligência preditiva. Reduza custos
                    operacionais e aumente a precisão das
                    entregas.

                </p>


                <a href="/planos"
                   class="btn"
                   style="padding:14px 32px;font-size:15px;">

                    Conheça Nossos Planos

                </a>

            </div>


            <div class="hero-mockup">

                <div class="mockup-header">

                    <span class="mockup-dot dot-red"></span>

                    <span class="mockup-dot dot-yellow"></span>

                    <span class="mockup-dot dot-green"></span>

                    <span style="
                        font-size:10px;
                        color:#64748b;
                        margin-left:10px;
                        font-weight:600;
                    ">

                        GEOSYNC LIVE MONITORING

                    </span>

                </div>


                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80"
                     class="mockup-img"
                     alt="Monitoramento logístico">

            </div>

        </div>

    </section>


    <!-- =====================================================
         SOBRE
    ====================================================== -->

    <section class="container section">

        <div class="block-about">

            <div>

                <span class="sub-header">
                    Sobre a Plataforma
                </span>

                <h2>
                    Sua Operação Conectada de Ponta a Ponta
                </h2>

                <p>

                    A GeoSync é uma plataforma inteligente
                    desenvolvida para oferecer controle total
                    sobre operações de transporte e armazenamento.

                    Com tecnologia de ponta e interface intuitiva,
                    nossa solução permite acompanhar veículos e
                    cargas com visibilidade em tempo real,
                    otimizando processos e promovendo a máxima
                    eficiência em toda a cadeia de suprimentos.

                </p>

            </div>


            <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&w=800&q=80"
                 alt="Gestão logística">

        </div>

    </section>


    <!-- =====================================================
         SERVIÇOS
    ====================================================== -->

    <section class="container section"
             style="padding-top:0;">

        <div style="
            text-align:center;
            max-width:600px;
            margin:0 auto 50px;
        ">

            <span class="sub-header">
                Módulos do Sistema
            </span>

            <h2>
                Soluções para Toda a Cadeia
            </h2>

        </div>


        <div class="services-grid">

            <div class="service-card">

                <img src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=600&q=80"
                     alt="Transporte terrestre">

                <h3>
                    Transporte Terrestre
                </h3>

                <p>

                    Gerenciamento completo de frotas com
                    rastreamento contínuo. Acompanhe rotas
                    em execução, monitore paradas e acesse
                    métricas estratégicas em tempo real.

                </p>

            </div>


            <div class="service-card">

                <img src="https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?auto=format&fit=crop&w=600&q=80"
                     alt="Armazenamento">

                <h3>
                    Gestão de Armazenamento
                </h3>

                <p>

                    Controle integrado de estoques e galpões
                    logísticos. Proporcione organização,
                    rastreabilidade e máxima eficiência nos
                    processos de armazenagem.

                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         DIFERENCIAIS
    ====================================================== -->

    <section class="diferenciais-section section">

        <div class="container">

            <div class="diferenciais-topo">

                <div class="diferenciais-conteudo">

                    <span class="sub-header">
                        Tecnologia Preditiva
                    </span>

                    <h2>
                        Por que Escolher a GeoSync?
                    </h2>

                    <p>

                        Integramos IoT, intelignência
                        preditiva e dados em tempo real
                        para identificar desvios, prever
                        e antecipar possíveis falhas na  
                        operação, permitindo que gestores
                        tomem decisões antes que pequenos
                        problemas se trasformem em grandes
                        gargalos.

                    </p>

                    <p>

                        Nosso ecossistema intuitivo facilita
                        decisões estratégicas mais rápidas,
                        melhora a visibilidade da operação
                        e reduz o tempo de inatividade da frota.

                    </p>

                </div>


                <div class="diferenciais-imagem">

                    <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?auto=format&fit=crop&w=1000&q=85"
                         alt="Caminhão em uma rodovia representando o monitoramento logístico">

                </div>

            </div>


            <div class="cards-grid">

                <div class="card-feature azul">

                    <div class="icon-box white-bg">

                        <i class="fas fa-shield-alt"></i>

                    </div>

                    <h3>
                        Segurança
                    </h3>

                    <p>

                        Proteção constante de ativos através
                        de protocolos automatizados e
                        monitoramento contínuo.

                    </p>

                </div>


                <div class="card-feature branco">

                    <div class="icon-box azul-bg">

                        <i class="fas fa-chart-line"></i>

                    </div>

                    <h3>
                        Eficiência
                    </h3>

                    <p>

                        Otimização constante de rotas que
                        reduz o consumo de combustível
                        e custos operacionais.

                    </p>

                </div>


                <div class="card-feature azul">

                    <div class="icon-box white-bg">

                        <i class="fas fa-map-marker-alt"></i>

                    </div>

                    <h3>
                        Rastreamento
                    </h3>

                    <p>

                        Visibilidade de localização em
                        tempo real com alertas configuráveis
                        de desvios e prazos.

                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         TECNOLOGIA IoT
    ====================================================== -->

    <section class="container info-section"
             id="tecnologia">

        <div class="section-title-center">

            <span class="sub-header">
                Internet das Coisas
            </span>

            <h2>
                IoT para uma Logística Mais Inteligente
            </h2>

            <p>

                A GeoSync utiliza dispositivos conectados
                para coletar informações da operação e
                disponibilizar dados importantes para
                acompanhamento em tempo real.

            </p>

        </div>


        <div class="iot-grid">

            <div class="info-card">

                <div class="icon-box">

                    <i class="fas fa-satellite-dish"></i>

                </div>

                <h3>
                    GPS em Tempo Real
                </h3>

                <p>

                    Acompanhe a localização dos veículos
                    e cargas durante todo o percurso.

                </p>

                <ul>

                    <li>Localização atualizada</li>
                    <li>Histórico de trajetos</li>
                    <li>Identificação de paradas</li>

                </ul>

            </div>


            <div class="info-card">

                <div class="icon-box">

                    <i class="fas fa-microchip"></i>

                </div>

                <h3>
                    Sensores Conectados
                </h3>

                <p>

                    Dispositivos IoT podem coletar informações
                    importantes sobre a operação.

                </p>

                <ul>

                    <li>Monitoramento de condições</li>
                    <li>Coleta automática de dados</li>
                    <li>Comunicação entre dispositivos</li>

                </ul>

            </div>


            <div class="info-card">

                <div class="icon-box">

                    <i class="fas fa-cloud"></i>

                </div>

                <h3>
                    Dados Integrados
                </h3>

                <p>

                    As informações coletadas são centralizadas
                    para facilitar a análise.

                </p>

                <ul>

                    <li>Dados centralizados</li>
                    <li>Visualização simplificada</li>
                    <li>Monitoramento contínuo</li>

                </ul>

            </div>

        </div>

    </section>


    <!-- =====================================================
         INTELIGÊNCIA ARTIFICIAL
    ====================================================== -->

    <section class="container info-section">

        <div class="diferenciais-topo">

            <div>

                <span class="sub-header">
                    Inteligência Preditiva
                </span>

                <h2>
                    Antecipe Problemas Antes que Eles Aconteçam
                </h2>

                <p style="margin-bottom:15px;">

                    A inteligência da GeoSync pode auxiliar
                    na identificação de comportamentos fora
                    do padrão e situações que precisam
                    de atenção.

                </p>

                <p>

                    Dessa forma, gestores conseguem agir
                    mais rapidamente e acompanhar
                    ocorrências importantes da operação.

                </p>

            </div>


            <div class="info-card">

                <div class="icon-box">

                    <i class="fas fa-robot"></i>

                </div>

                <h3>
                    Análise Inteligente
                </h3>

                <p>

                    O sistema pode analisar informações
                    de localização, velocidade, paradas
                    e rotas para destacar situações
                    que merecem atenção.

                </p>

            </div>

        </div>


        <div class="benefits-grid">

            <div class="info-card">

                <div class="icon-box">
                    <i class="fas fa-route"></i>
                </div>

                <h3>
                    Desvio de Rota
                </h3>

                <p>
                    Identificação de trajetos diferentes
                    do percurso planejado.
                </p>

            </div>


            <div class="info-card">

                <div class="icon-box">
                    <i class="fas fa-stopwatch"></i>
                </div>

                <h3>
                    Paradas Suspeitas
                </h3>

                <p>
                    Monitoramento de paradas prolongadas
                    ou fora dos pontos previstos.
                </p>

            </div>


            <div class="info-card">

                <div class="icon-box">
                    <i class="fas fa-tachometer-alt"></i>
                </div>

                <h3>
                    Controle de Velocidade
                </h3>

                <p>
                    Acompanhamento da velocidade para
                    apoiar uma operação mais segura.
                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         COMO FUNCIONA
    ====================================================== -->

    <section class="container info-section">

        <div class="section-title-center">

            <span class="sub-header">
                Funcionamento
            </span>

            <h2>
                Como a GeoSync Funciona?
            </h2>

            <p>
                Um fluxo simples para transformar dados
                da operação em informações úteis.
            </p>

        </div>


        <div class="process-grid">

            <div class="info-card">

                <div class="process-number">
                    01
                </div>

                <h3>
                    Coleta
                </h3>

                <p>

                    Dispositivos, sistemas e usuários fornecem
                    informações relacionadas ao transporte
                    e às mercadorias.

                </p>

            </div>


            <div class="info-card">

                <div class="process-number">
                    02
                </div>

                <h3>
                    Processamento
                </h3>

                <p>

                    Os dados são organizados e analisados
                    para apresentar uma visão mais clara
                    da operação.

                </p>

            </div>


            <div class="info-card">

                <div class="process-number">
                    03
                </div>

                <h3>
                    Monitoramento
                </h3>

                <p>

                    O gestor acompanha as informações e
                    identifica ocorrências durante o transporte.

                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         INDICADORES
    ====================================================== -->

    <section class="info-section stats-section">

        <div class="container">

            <div class="section-title-center">

                <span class="sub-header">
                    Visão Operacional
                </span>

                <h2>
                    Informações em um Único Ambiente
                </h2>

                <p>
                    A plataforma reúne diferentes dados
                    para facilitar o gerenciamento das
                    operações logísticas.
                </p>

            </div>


            <div class="stats-grid">

                <div class="stat-card">

                    <span class="stat-number">
                        24/7
                    </span>

                    <span class="stat-label">
                        Monitoramento contínuo
                    </span>

                </div>


                <div class="stat-card">

                    <span class="stat-number">
                        GPS
                    </span>

                    <span class="stat-label">
                        Localização dos veículos
                    </span>

                </div>


                <div class="stat-card">

                    <span class="stat-number">
                        IoT
                    </span>

                    <span class="stat-label">
                        Dispositivos conectados
                    </span>

                </div>


                <div class="stat-card">

                    <span class="stat-number">
                        IA
                    </span>

                    <span class="stat-label">
                        Análise inteligente
                    </span>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         ALERTAS
    ====================================================== -->

    <section class="container info-section">

        <div class="section-title-center">

            <span class="sub-header">
                Monitoramento Proativo
            </span>

            <h2>
                Alertas para Situações Importantes
            </h2>

            <p>
                Tenha maior controle sobre acontecimentos
                que podem impactar o transporte e o prazo
                das entregas.
            </p>

        </div>


        <div class="alert-grid">

            <div class="alert-card">

                <i class="fas fa-exclamation-triangle"></i>

                <div>

                    <h3>
                        Atraso na Entrega
                    </h3>

                    <p>
                        Identifique situações que podem
                        comprometer o prazo planejado.
                    </p>

                </div>

            </div>


            <div class="alert-card">

                <i class="fas fa-map-signs"></i>

                <div>

                    <h3>
                        Desvio de Rota
                    </h3>

                    <p>
                        Receba alertas sobre mudanças
                        no percurso planejado.
                    </p>

                </div>

            </div>


            <div class="alert-card">

                <i class="fas fa-clock"></i>

                <div>

                    <h3>
                        Parada Prolongada
                    </h3>

                    <p>
                        Acompanhe paradas que ultrapassem
                        o tempo esperado.
                    </p>

                </div>

            </div>


            <div class="alert-card">

                <i class="fas fa-truck-moving"></i>

                <div>

                    <h3>
                        Status da Frota
                    </h3>

                    <p>
                        Tenha uma visão organizada dos
                        veículos em operação.
                    </p>

                </div>

            </div>


            <div class="alert-card">

                <i class="fas fa-box"></i>

                <div>

                    <h3>
                        Status da Carga
                    </h3>

                    <p>
                        Acompanhe as etapas relacionadas
                        ao transporte da mercadoria.
                    </p>

                </div>

            </div>


            <div class="alert-card">

                <i class="fas fa-bell"></i>

                <div>

                    <h3>
                        Notificações
                    </h3>

                    <p>
                        Centralize informações relevantes
                        para facilitar a tomada de decisão.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         BENEFÍCIOS
    ====================================================== -->

    <section class="container info-section">

        <div class="section-title-center">

            <span class="sub-header">
                Benefícios
            </span>

            <h2>
                Mais Controle para Sua Operação
            </h2>

            <p>
                A GeoSync foi pensada para conectar
                pessoas, veículos, cargas e informações.
            </p>

        </div>


        <div class="benefits-grid">

            <div class="info-card">

                <div class="icon-box">

                    <i class="fas fa-eye"></i>

                </div>

                <h3>
                    Maior Visibilidade
                </h3>

                <p>
                    Visualize o andamento das operações
                    de forma centralizada.
                </p>

            </div>


            <div class="info-card">

                <div class="icon-box">

                    <i class="fas fa-coins"></i>

                </div>

                <h3>
                    Redução de Custos
                </h3>

                <p>
                    Identifique oportunidades para melhorar
                    rotas e processos.
                </p>

            </div>


            <div class="info-card">

                <div class="icon-box">

                    <i class="fas fa-users"></i>

                </div>

                <h3>
                    Integração
                </h3>

                <p>
                    Facilite a comunicação entre gestores,
                    motoristas e clientes.
                </p>

            </div>

        </div>

    </section>


    <!-- =====================================================
         FAQ
    ====================================================== -->

    <section class="container info-section"
             id="faq">

        <div class="section-title-center">

            <span class="sub-header">
                Dúvidas
            </span>

            <h2>
                Perguntas Frequentes
            </h2>

            <p>
                Confira algumas informações sobre
                a plataforma GeoSync.
            </p>

        </div>


        <div class="faq-container">

            <div class="faq-item">

                <button class="faq-question">

                    O que é a GeoSync?

                    <i class="fas fa-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    <p>

                        A GeoSync é uma plataforma voltada
                        ao rastreamento, monitoramento e
                        gerenciamento de mercadorias no
                        transporte rodoviário.

                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    A GeoSync utiliza IoT?

                    <i class="fas fa-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    <p>

                        Sim. A proposta da plataforma contempla
                        a utilização de dispositivos conectados
                        para coleta e transmissão de informações
                        da operação.

                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    É possível acompanhar uma carga em tempo real?

                    <i class="fas fa-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    <p>

                        Sim. O sistema foi desenvolvido com foco
                        no acompanhamento da localização e do
                        status das cargas durante o transporte.

                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    O sistema possui acessibilidade?

                    <i class="fas fa-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    <p>

                        Sim. A página possui recursos de aumento
                        e redução de fonte, modo escuro, alto
                        contraste, leitura de conteúdo e VLibras.

                    </p>

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    Quem pode utilizar a plataforma?

                    <i class="fas fa-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    <p>

                        A solução pode atender empresas de
                        transporte, gestores de frota,
                        responsáveis por logística, motoristas
                        e clientes que precisam acompanhar entregas.

                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         VLibras
    ====================================================== -->

    <div vw class="enabled">

        <div vw-access-button class="active"></div>

        <div vw-plugin-wrapper>

            <div class="vw-plugin-top-wrapper"></div>

        </div>

    </div>


    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>

    <script>

        new window.VLibras.Widget(
            'https://vlibras.gov.br/app'
        );

    </script>


    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer class="footer">

        <div class="container">

            <div class="footer-grid">

                <div>

                    <h2 style="
                        color:white;
                        font-size:22px;
                        margin-bottom:15px;
                    ">
                        GeoSync
                    </h2>

                    <p>
                        Ecossistema inteligente de rastreamento,
                        telemetria e gestão de frota em tempo real.
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

                    <p style="margin-bottom:8px;">
                        R. Cap. David, 56 - Centro
                    </p>

                    <p style="margin-bottom:8px;">
                        Tambaú - SP
                    </p>

                    <p style="margin-bottom:8px;">
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
                        Assine para receber atualizações técnicas
                        e novos recursos.
                    </p>


                    <div class="newsletter">

                        <input type="email"
                               placeholder="Seu e-mail profissional">

                        <button>
                            Assinar
                        </button>

                    </div>

                </div>

            </div>


            <div class="copy">

                © 2026 GeoSync - Todos os direitos reservados.

            </div>

        </div>

    </footer>


    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script>

        /* =====================================================
           LOADER
        ===================================================== */

        window.addEventListener('load', function () {

            setTimeout(() => {

                const loader =
                    document.getElementById('loader');

                if (!loader) return;

                loader.classList.add('loader-exit');

                setTimeout(() => {

                    loader.remove();

                }, 800);

            }, 700);

        });


        /* =====================================================
           ACESSIBILIDADE
        ===================================================== */

        const accessBtn =
            document.getElementById("accessibility-toggle");

        const accessPanel =
            document.getElementById("accessibility-panel");


        if (accessBtn && accessPanel) {

            accessBtn.addEventListener("click", () => {

                const isActive =
                    accessPanel.classList.toggle("active");

                accessBtn.setAttribute(
                    "aria-expanded",
                    isActive
                );

            });


            document.addEventListener("click", (e) => {

                if (
                    !accessBtn.contains(e.target) &&
                    !accessPanel.contains(e.target)
                ) {

                    accessPanel.classList.remove("active");

                    accessBtn.setAttribute(
                        "aria-expanded",
                        "false"
                    );

                }

            });

        }


        /* =====================================================
           CARREGAR PREFERÊNCIAS
        ====================================================== */

        document.addEventListener(
            "DOMContentLoaded",
            () => {

                const escala =
                    localStorage.getItem("fontScale") || "1";

                document.documentElement.style.setProperty(
                    "--font-scale",
                    escala
                );


                if (
                    localStorage.getItem("darkMode")
                    === "true"
                ) {

                    document.body.classList.add(
                        "dark-mode"
                    );

                }


                if (
                    localStorage.getItem("contraste")
                    === "true"
                ) {

                    document.body.classList.add(
                        "alto-contraste"
                    );

                }

            }
        );


        /* =====================================================
           TAMANHO DA FONTE
        ====================================================== */

        function alterarFonte(valor) {

            let atual =
                parseFloat(
                    getComputedStyle(
                        document.documentElement
                    ).getPropertyValue(
                        "--font-scale"
                    )
                ) || 1;


            atual += valor;


            if (atual < 0.7)
                atual = 0.7;


            if (atual > 1.7)
                atual = 1.7;


            atual =
                parseFloat(
                    atual.toFixed(2)
                );


            document.documentElement.style.setProperty(
                "--font-scale",
                atual
            );


            localStorage.setItem(
                "fontScale",
                atual
            );

        }


        /* =====================================================
           MODO ESCURO
        ====================================================== */

        function toggleDark() {

            const ativar =
                !document.body.classList.contains(
                    "dark-mode"
                );


            document.body.classList.toggle(
                "dark-mode",
                ativar
            );


            if (ativar) {

                document.body.classList.remove(
                    "alto-contraste"
                );

                localStorage.setItem(
                    "contraste",
                    "false"
                );

            }


            localStorage.setItem(
                "darkMode",
                ativar
            );

        }


        /* =====================================================
           ALTO CONTRASTE
        ====================================================== */

        function toggleContraste() {

            const ativar =
                !document.body.classList.contains(
                    "alto-contraste"
                );


            document.body.classList.toggle(
                "alto-contraste",
                ativar
            );


            if (ativar) {

                document.body.classList.remove(
                    "dark-mode"
                );

                localStorage.setItem(
                    "darkMode",
                    "false"
                );

            }


            localStorage.setItem(
                "contraste",
                ativar
            );

        }


        /* =====================================================
           LEITURA DE PÁGINA
        ====================================================== */

        let sintoVoz = null;


        function lerPagina() {

            window.speechSynthesis.cancel();


            let textoParaLer =
                window.getSelection()
                    .toString()
                    .trim();


            if (!textoParaLer) {

                const elementosFoco =
                    document.querySelectorAll(
                        'h1, h2, h3, p, span:not(.accessibility-panel span)'
                    );


                let blocosTexto = [];


                elementosFoco.forEach(el => {

                    if (
                        el.innerText &&
                        el.innerText.trim().length > 3
                    ) {

                        blocosTexto.push(
                            el.innerText.trim()
                        );

                    }

                });


                textoParaLer =
                    blocosTexto.join('. ');

            }


            if (textoParaLer) {

                sintoVoz =
                    new SpeechSynthesisUtterance(
                        textoParaLer
                    );


                sintoVoz.lang = "pt-BR";

                sintoVoz.rate = 1.05;

                window.speechSynthesis.speak(
                    sintoVoz
                );

            }

        }


        function pararLeitura() {

            window.speechSynthesis.cancel();

        }


        /* =====================================================
           RESET ACESSIBILIDADE
        ====================================================== */

        function resetarAcessibilidade() {

            pararLeitura();


            localStorage.removeItem(
                "fontScale"
            );

            localStorage.removeItem(
                "darkMode"
            );

            localStorage.removeItem(
                "contraste"
            );


            document.body.classList.remove(
                "dark-mode",
                "alto-contraste"
            );


            document.documentElement.style.setProperty(
                "--font-scale",
                "1"
            );

        }


        /* =====================================================
           FAQ
        ====================================================== */

        document.addEventListener(
            "DOMContentLoaded",
            () => {

                const perguntas =
                    document.querySelectorAll(
                        ".faq-question"
                    );


                perguntas.forEach(pergunta => {

                    pergunta.addEventListener(
                        "click",
                        () => {

                            const resposta =
                                pergunta.nextElementSibling;


                            const aberta =
                                resposta.classList.contains(
                                    "active"
                                );


                            document
                                .querySelectorAll(
                                    ".faq-answer"
                                )
                                .forEach(item => {

                                    item.classList.remove(
                                        "active"
                                    );

                                });


                            document
                                .querySelectorAll(
                                    ".faq-question"
                                )
                                .forEach(item => {

                                    item.classList.remove(
                                        "active"
                                    );

                                });


                            if (!aberta) {

                                resposta.classList.add(
                                    "active"
                                );

                                pergunta.classList.add(
                                    "active"
                                );

                            }

                        }
                    );

                });

            }
        );

    </script>

    <script>
        window.addEventListener('load', function () {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                if (!loader) return;
                
                loader.classList.add('loader-exit');
                
                setTimeout(() => {
                    loader.remove();
                }, 600);
            }, 800);
        });
    </script>

</body>

</html>