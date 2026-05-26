<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <title>GeoSync - Sobre Nós</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <style>

        /* =========================
           VARIÁVEIS UNIFICADAS
        ========================= */
        :root {
            --azul-institucional: #1C3F6E;
            --azul-tech: #2F6FB2;
            --azul-profundo: #0B1F36;
            --azul-claro: #E6EEF8;
            --azul-cinza: #7B92AD;

            --primary: #072051;
            --secondary: #328CC1;
            --accent: #D9B310;
            --light: #F4F7FA;
            --dark: #1B1B1B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            overflow-x: hidden;
            color: var(--dark);
        }

        /* =========================
           CONTAINER / FLEX
        ========================= */
        .container {
            width: 90%;
            max-width: 1200px;
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
            background: linear-gradient(90deg, var(--azul-profundo), var(--azul-institucional));
            padding: 10px 0;
            color: white;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
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
            color: white;
        }

        .top-icons a:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-3px);
        }

        /* =========================
           NAVBAR
        ========================= */
        .navbar {
            background: #ffffff;
            padding: 15px 0;
            border-bottom: 1px solid #e8e8e8;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 28px;
            font-weight: 700;
            color: var(--azul-institucional);
            text-decoration: none;
        }

        .logo img {
            width: 65px;
        }

        .menu {
            display: flex;
            gap: 35px;
        }

        .menu a {
            text-decoration: none;
            color: var(--azul-institucional);
            font-size: 15px;
            font-weight: 700;
            transition: 0.3s;
            padding-bottom: 5px;
        }

        .menu a:hover {
            color: var(--azul-tech);
        }

        .btn {
            background: linear-gradient(90deg, #0B3B7A, #022553);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* =========================
           HEADER
        ========================= */
        .jumbotron {
            background:
                linear-gradient(rgba(11,31,54,0.85), rgba(11,31,54,0.85)),
                url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 90px 0;
            margin-bottom: 0;
        }

        /* =========================
           ABOUT
        ========================= */
        .about-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .text-primary-custom {
            color: var(--primary);
        }

        /* =========================
           TEAM
        ========================= */
        .team {
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            background: white;
            height: 100%;
        }

        .team:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .team img {
            height: 280px;
            object-fit: cover;
            width: 100%;
        }

        .team-text {
            background: var(--primary);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .team-text small {
            color: var(--secondary);
        }

        /* =========================
           FOOTER (UNIFICADO)
        ========================= */
        .footer {
            background: var(--primary);
            color: #bfcbdd;
            padding: 60px 0 20px;
            margin-top: 50px;
        }

        .footer-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .footer-col {
            flex: 1;
            min-width: 220px;
        }

        .footer h3 {
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .footer p,
        .footer a {
            color: #a3b8cc;
            font-size: 14px;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }

        .footer a:hover {
            color: white;
            padding-left: 5px;
        }

        .social {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .newsletter {
            display: flex;
            margin-top: 10px;
        }

        .newsletter input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .newsletter button {
            background: var(--secondary);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        .copy {
            text-align: center;
            padding-top: 20px;
            margin-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #7b92ad;
            font-size: 13px;
        }

        /* =========================
           RESPONSIVO
        ========================= */
        @media (max-width: 768px) {
            .flex {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .menu {
                flex-direction: column;
                gap: 10px;
            }

            .about-card {
                padding: 20px;
            }
        }

    </style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="container flex">
        <div><i class="fas fa-phone-alt"></i> +55 (19) 99401-0744 | <i class="fas fa-envelope"></i> contact@geosync.com</div>
        <div class="top-icons">
            <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://x.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://br.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</div>

<div class="navbar">
    <div class="container flex">
        <a href="/" class="logo" style="text-decoration:none; display:flex; align-items:center; gap:12px;">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo" style="width: 65px;">
            <span>GeoSync</span>
        </a>

        <div class="menu">
            <a href="/" style="font-weight:600;">Início</a>
            <a href="/about" style="font-weight:600;">Sobre</a>
            <a href="/contact" style="font-weight:600;">Contato</a>
            <a href="/pagamento" style="font-weight:600;">Planos</a>
        </div>

        <a href="/login" class="btn" style="border-radius: 8px; background-color: #022553; font-weight:600;">Solicitar um Serviço</a>
    </div>
</div>

<div class="jumbotron text-center">
    <div class="container">
        <h1 class="display-4 text-white">Sobre Nós</h1>
        <p class="lead text-white">Conheça a história e a equipe por trás da GeoSync</p>
    </div>
</div>

<div class="container py-5">
    <div class="about-card shadow-lg"> <div class="row align-items-center">
            <div class="col-lg-5 mb-4">
                <img class="img-fluid rounded shadow" src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?auto=format&fit=crop&q=80&w=600" alt="Caminhão Logística">
            </div>
            <div class="col-lg-7">
                <h6 class="text-secondary text-uppercase font-weight-bold">Nossa Essência</h6> <h2 class="mb-4 text-primary-custom">Logística rápida, segura e inteligente</h2> <p class="text-dark"> Unimos tecnologia de ponta e anos de experiência no setor para otimizar entregas e reduzir custos operacionais. Na GeoSync, acreditamos que a transparência em tempo real é a chave para o sucesso logístico moderno.
                </p>
                <p class="text-dark">
                    Nossa plataforma foi desenhada para ser intuitiva, robusta e escalável, atendendo desde pequenos frotistas até grandes centros de distribuição.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-secondary text-uppercase font-weight-bold">Nossa Equipe</h6> <h2 class="text-primary-custom">Mentes que movem a GeoSync</h2> </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/mariaClara.png') }}" class="card-img-top" alt="Maria Clara">
                <div class="team-text">
                    <h5>Maria Clara</h5>
                    <small>Front-End / Banco de Dados</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/murilo.jpg') }}" class="card-img-top" alt="Murilo">
                <div class="team-text">
                    <h5>Murilo</h5>
                    <small>Full Stack Developer</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/lucas.png') }}" class="card-img-top" alt="Lucas">
                <div class="team-text">
                    <h5>Lucas</h5>
                    <small>Back-End Developer</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/mickael.png') }}" class="card-img-top" alt="Mickael">
                <div class="team-text">
                    <h5>Mickael</h5>
                    <small>Front-End / Banco de Dados</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/thayla.png') }}" class="card-img-top" alt="Thayla">
                <div class="team-text">
                    <h5>Thayla</h5>
                    <small>Back-End Developer</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/theo.png') }}" class="card-img-top" alt="Théo">
                <div class="team-text">
                    <h5>Théo</h5>
                    <small>Front-End / Banco de Dados</small>
                </div>
            </div>
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

<div class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>GeoSync</h3>
                <p>Sistema inteligente de rastreamento e logística em tempo real.</p>
                <div class="social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Links</h3>
                <a href="/">Início</a>
                <a href="/about">Sobre</a>
                <a href="/login">Serviços</a>
                <a href="/contact">Contato</a>
                <a href="/pagamento">Planos</a>
                <a href="/avaliar">Feedback</a>
            </div>
            <div class="footer-col">
                <h3>Contato</h3>
                <p>R. Cap. David, 56 - Centro, Tambaú - SP, 13710-000</p>
                <p>(19) 99401-0744</p>
                <p>contact@geosync.com</p>
            </div>
            <div class="footer-col">
                <h3>Newsletter</h3>
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
</html>