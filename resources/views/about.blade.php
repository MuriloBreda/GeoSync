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
        :root{
    --azul-institucional:#1C3F6E;
    --azul-tech:#2F6FB2;
    --azul-profundo:#0B1F36;
    --azul-claro:#E6EEF8;
    --azul-cinza:#7B92AD;

    --primary:#072051;
    --secondary:#328CC1;
    --accent:#D9B310;
    --light:#F4F7FA;
    --dark:#1B1B1B;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f5f7fb;
    color:var(--dark);
    overflow-x:hidden;
    position:relative;
}

/* GLOW BACKGROUND */

body::before{
    content:"";
    position:fixed;
    width:700px;
    height:700px;
    background:radial-gradient(circle,#2F6FB220 0%,transparent 70%);
    top:-250px;
    right:-250px;
    z-index:-1;
}

body::after{
    content:"";
    position:fixed;
    width:600px;
    height:600px;
    background:radial-gradient(circle,#0B3B7A15 0%,transparent 70%);
    bottom:-250px;
    left:-250px;
    z-index:-1;
}

/* CONTAINER */

.container{
    width:90%;
    max-width:1200px;
    margin:auto;
}

.flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

/* TOPBAR */

.topbar{
    background:linear-gradient(90deg,#0B1F36,#1C3F6E);
    padding:10px 0;
    color:white;
    font-size:14px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.topbar a{
    color:white;
    text-decoration:none;
    transition:0.3s;
}

.topbar a:hover{
    color:#7fb7ff;
}

.top-info{
    display:flex;
    gap:20px;
    align-items:center;
}

.top-icons{
    display:flex;
    gap:10px;
    align-items:center;
}

.top-icons a{
    width:34px;
    height:34px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    transition:0.3s;
}

.top-icons a:hover{
    background:rgba(255,255,255,0.15);
    transform:translateY(-3px);
}

/* NAVBAR */

.navbar{
    background:rgba(255,255,255,0.92);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);
    padding:18px 0;
    position:sticky;
    top:0;
    z-index:9999;
    border-bottom:1px solid rgba(255,255,255,0.4);
    box-shadow:0 8px 30px rgba(0,0,0,.05);
}

.logo{
    display:flex;
    align-items:center;
    gap:12px;
    font-size:30px;
    font-weight:700;
    color:var(--azul-institucional);
    text-decoration:none;
    transition:.4s;
}

.logo:hover{
    transform:scale(1.04);
}

.logo img{
    width:65px;
    transition:.5s;
}

.logo:hover img{
    transform:rotate(-8deg) scale(1.08);
}

.menu{
    display:flex;
    gap:35px;
}

.menu a{
    position:relative;
    text-decoration:none;
    color:var(--azul-institucional);
    font-size:15px;
    font-weight:700;
    transition:.3s;
    padding-bottom:6px;
}

.menu a:hover{
    color:#2F6FB2;
    transform:translateY(-2px);
}

.menu a::after{
    content:"";
    position:absolute;
    left:0;
    bottom:0;
    width:0%;
    height:2px;
    background:#2F6FB2;
    transition:0.4s;
    border-radius:10px;
}

.menu a:hover::after{
    width:100%;
}

.btn{
    position:relative;
    overflow:hidden;
    background:linear-gradient(
        135deg,
        #0B3B7A,
        #1C5CC8
    );
    color:white;
    padding:14px 28px;
    border-radius:14px;
    text-decoration:none;
    font-weight:600;
    transition:.4s;
    box-shadow:
    0 10px 25px rgba(47,111,178,.25);
}

.btn:hover{
    transform:translateY(-4px);
    box-shadow:
    0 20px 40px rgba(47,111,178,.35);
}

.btn::before{
    content:"";
    position:absolute;
    top:0;
    left:-120%;
    width:100%;
    height:100%;
    background:
    linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,.4),
        transparent
    );
    transition:.7s;
}

.btn:hover::before{
    left:120%;
}

/* HERO */

.jumbotron{
    background:
    linear-gradient(rgba(11,31,54,0.85), rgba(11,31,54,0.85)),
    url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d");
    background-size:cover;
    background-position:center;
    padding:140px 20px;
    text-align:center;
    color:white;
}

.jumbotron h1{
    font-size:70px;
    font-weight:700;
    margin-bottom:15px;
    animation:fadeUp 1s ease;
}

.jumbotron p{
    font-size:22px;
    animation:fadeUp 1.2s ease;
}

/* ABOUT CARD */

.about-card{
    background:white;

    border-radius:30px;

    padding:50px;

    box-shadow:
    0 20px 40px rgba(0,0,0,.06);

    transition:.4s;
}

.about-card:hover{
    transform:translateY(-8px);

    box-shadow:
    0 30px 60px rgba(0,0,0,.10);
}

.about-card img{
    transition:.6s;
}

.about-card:hover img{
    transform:scale(1.04);
}

.text-primary-custom{
    color:var(--primary);
}

/* TEAM */

.team{
    overflow:hidden;
    border:none;
    border-radius:25px;

    transition:.5s;

    background:white;

    box-shadow:
    0 15px 35px rgba(0,0,0,.06);
}

.team:hover{
    transform:
    translateY(-12px)
    scale(1.02);

    box-shadow:
    0 25px 50px rgba(0,0,0,.15);
}

.team img{
    width:100%;
    height:320px;
    object-fit:cover;
    transition:.6s;
}

.team:hover img{
    transform:scale(1.08);
}

.team-text{
    background:
    linear-gradient(
    135deg,
    #072051,
    #0B3B7A
    );

    color:white;

    text-align:center;

    padding:25px;
}

.team-text h5{
    margin-bottom:6px;
    font-weight:700;
}

.team-text small{
    color:#9fd2ff;
    font-size:14px;
}

/* FOOTER */

/* =========================
FOOTER
========================= */

.footer{
    background:
    linear-gradient(
    180deg,
    #08192c,
    #050f1c
    );

    color:white;
    padding:90px 0 20px;
    position:relative;
}

.footer::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:1px;

    background:
    linear-gradient(
    90deg,
    transparent,
    #2F6FB2,
    transparent
    );
}

.footer-grid{
    display:flex;
    gap:40px;
    flex-wrap:wrap;
}

.footer-col{
    flex:1;
    min-width:250px;
}

.footer h3{
    color:#2F6FB2;
    margin-bottom:15px;
}

.footer p{
    color:#c7d2df;
    font-size:15px;
}

.footer a{
    display:block;
    color:#a7b4c5;
    margin-bottom:10px;
    text-decoration:none;
    transition:0.3s;
}

.footer a:hover{
    color:#2F6FB2;
    padding-left:5px;
}

.social{
    display:flex;
    gap:10px;
    margin-top:15px;
}

.social a{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    border:1px solid #7B92AD;
    transition:0.3s;
}

.social a:hover{
    background:#2F6FB2;
    border-color:#2F6FB2;
    transform:translateY(-3px);
}

.newsletter{
    display:flex;
    margin-top:15px;
}

.newsletter input{
    flex:1;
    padding:12px;
    border:none;
    outline:none;
    border-radius:8px 0 0 8px;
}

.newsletter button{
    background:#2F6FB2;
    border:none;
    color:white;
    padding:0 20px;
    cursor:pointer;
    border-radius:0 8px 8px 0;
}

.copy{
    text-align:center;
    margin-top:40px;
    font-size:14px;
    color:#9db0c7;
}

/* RESPONSIVO */

@media(max-width:992px){

    .navbar .flex{
        flex-direction:column;
        gap:20px;
    }

    .top-info{
        flex-direction:column;
        gap:8px;
    }

    .menu{
        flex-wrap:wrap;
        justify-content:center;
    }

    .jumbotron{
        padding:120px 20px;
    }

    .jumbotron h1{
        font-size:42px;
    }

    .about-card{
        padding:25px;
    }

    .footer-grid{
        flex-direction:column;
    }

}


    </style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="container flex">
        <div class="top-info">

<a href="https://wa.me/551994010744?text=Olá%20GeoSync" target="_blank">
<i class="fas fa-phone-alt"></i>
+55 (19) 99401-0744
</a>

<a href="mailto:murilo.breda@aluno.senai.br" target="_blank">
<i class="fas fa-envelope"></i>
contact@geosync.com
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
        <a href="/" class="logo" style="text-decoration:none; display:flex; align-items:center; gap:12px;">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo" style="width: 65px;">
            <span>GeoSync</span>
        </a>

        <div class="menu">
            <a href="/" style="font-weight:600;">Início</a>
            <a href="/about" style="font-weight:600;">Sobre</a>
            <a href="/contact" style="font-weight:600;">Contato</a>
            <a href="/planos" style="font-weight:600;">Planos</a>
        </div>

        <a href="/login" class="btn" >Solicitar um Serviço</a>
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
                <img src="{{ asset('img/murilo.jpg') }}" class="card-img-top" alt="Murilo">
                <div class="team-text">
                    <h5>Murilo Moroni Breda</h5>
                    <small>Full-Stack Developer - PO</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/thayla.png') }}" class="card-img-top" alt="Thayla">
                <div class="team-text">
                    <h5>Thayla F. de Lima Ribeiro</h5>
                    <small>Back-End Developer - Scrum Master</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/lucas.png') }}" class="card-img-top" alt="Lucas">
                <div class="team-text">
                    <h5>Lucas Rizzo Bertoloto</h5>
                    <small>Back-End Developer</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/mickael.png') }}" class="card-img-top" alt="Mickael">
                <div class="team-text">
                    <h5>Mickael H. Malafatti Ezequiel</h5>
                    <small>Front-End / Banco de Dados</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/mariaClara.png') }}" class="card-img-top" alt="Maria Clara">
                <div class="team-text">
                    <h5>Maria Clara Luz da Silva</h5>
                    <small>Front-End / Banco de Dados</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="team card shadow">
                <img src="{{ asset('img/theo.png') }}" class="card-img-top" alt="Théo">
                <div class="team-text">
                    <h5>Théo Donizetti de Souza</h5>
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

                <p>
                Sistema inteligente de rastreamento e logística em tempo real.
                </p>

                <div class="social">

                    <a href="https://www.facebook.com/geosync" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/geosync" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://br.linkedin.com/company/geosync" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/geosync_tambau/" target="_blank"><i class="fab fa-instagram"></i></a>

                </div>

            </div>

            <div class="footer-col">

                <h3>Links</h3>

                <a href="/">Início</a>
                <a href="/about">Sobre</a>
                <a href="/login">Serviço</a>
                <a href="/contact">Contato</a>
                <a href="/planos">Planos</a>
                <a href="/avaliar">Feedback</a>

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
</html>