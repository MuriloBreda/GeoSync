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
        :root {
            --primary: #072051; /* Azul Escuro Institucional */
            --secondary: #328CC1; /* Azul Mais Claro */
            --accent: #D9B310;
            --light: #F4F7FA;
            --dark: #1B1B1B;
            --azul-cinza: #7B92AD;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            overflow-x: hidden;
        }

        /* CSS FORÇADO PARA PADRONIZAÇÃO */

.topbar {
    background: #0B1F36 !important;
    color: white !important;
    padding: 8px 0 !important;
    font-size: 14px !important;
    display: block !important;
}

.top-icons i {
    margin-left: 12px !important;
    color: white !important;
    transition: 0.3s !important;
}

.navbar {
    background: #f1f1f1 !important;
    padding: 15px 0 !important;
    border-bottom: 1px solid #e1e1e1 !important;
}

.logo {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    font-size: 26px !important;
    font-weight: bold !important;
    color: #1C3F6E !important;
    text-decoration: none !important;
}

.logo img {
    width: 65px !important;
    height: auto !important;
}

.menu {
    display: flex !important;
    gap: 30px !important;
}

.menu a {
    text-decoration: none !important;
    color: #1C3F6E !important;
    font-size: 15px !important;
    font-weight: 700 !important; /* Peso igual ao seu index */
}

.btn {
    background-color: #022553 !important;
    color: white !important;
    padding: 10px 20px !important;
    border-radius: 8px !important; /* Arredondamento solicitado */
    text-decoration: none !important;
    display: inline-block !important;
    font-weight: 600 !important;
}

        /* NAVBAR */
        .navbar-custom {
            background: #fff;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }

        .menu a {
            margin: 0 15px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .menu a:hover {
            color: var(--secondary);
        }

        .btn-custom {
            background: var(--primary);
            color: white !important;
            padding: 10px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background: var(--secondary);
            transform: scale(1.05);
        }

        /* HEADER */
        .jumbotron {
            background: linear-gradient(rgba(7, 32, 81, 0.9), rgba(7, 32, 81, 0.9)),
            url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d');
            background-size: cover;
            background-position: center;
            color: white;
            border-radius: 0;
            padding: 80px 0;
            margin-bottom: 0;
        }

        h1, h2, h3 { font-weight: 700; }

        /* NOVA CLASSE PARA CAIXA SOBRE NÓS */
        .about-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .text-primary-custom {
            color: var(--primary) !important;
        }

        /* TEAM CARDS - Fundo Branco */
        .team {
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            background: white; /* Garante o fundo branco */
        }

        .team:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .team-text {
            background: var(--primary); /* Mantém o azul escuro para o texto */
            color: white;
            padding: 20px;
            text-align: center;
        }

        .team-text h5 { font-weight: 600; margin-bottom: 5px; }
        .team-text small { color: var(--secondary); font-weight: 500; }

        /* FOOTER ESTILIZADO */
        .footer {
            background: var(--primary);
            color: #0B1F36;
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
            color: #2f6fb2;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .footer p {
            color: #7b92ad;
            font-size: 14px;
        }

        .footer a {
            display: block;
            color: #7b92ad;
            margin-bottom: 10px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .footer a:hover {
            color: var(--secondary);
            padding-left: 5px;
        }

        .social {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social a {
            display: inline-block;
            color: white;
            font-size: 18px;
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
        }

        .newsletter button {
            background: var(--secondary);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 0 4px 4px 0;
            font-weight: 600;
        }

        .copy {
            text-align: center;
            padding-top: 20px;
            margin-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #aaa;
            font-size: 13px;
        }

        /* CONTAINER */
.container{
width:90%;
margin:auto;
}

/* FLEX */
.flex{
display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
}

/* TOPBAR */
.topbar{
background: var(--primary);
color:white;
padding:8px 0;
font-size:14px;
}

/* ICONES */
.top-icons i{
margin-left:12px;
cursor:pointer;
transition:0.3s;
color:white;
}

.top-icons i:hover{
color:var(--secondary);
}

/* NAVBAR */
.navbar{
background:#f1f1f1;
padding:15px 0;
}

.logo{
font-size:26px;
font-weight:bold;
color:var(--primary);
}

.menu{
display:flex;
gap:30px;
}

.menu a{
text-decoration:none;
color:var(--primary);
font-size:15px;
font-weight:500;
transition:0.3s;
}

.menu a:hover{
color:var(--secondary);
}

/* BOTÃO */
.btn{
background:var(--primary);
color:white;
padding:10px 20px;
border-radius:4px;
text-decoration:none;
background-color:#022553;
transition:0.3s;
}

.btn:hover{
background:var(--secondary);
color:white;
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