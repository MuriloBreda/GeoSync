<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>GeoSync - Planos</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">


<style>

/* =========================
PALETA
========================= */

:root{
--azul-institucional:#1C3F6E;
--azul-tech:#2F6FB2;
--azul-profundo:#0B1F36;
--azul-claro:#E6EEF8;
--azul-cinza:#7B92AD;
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
    font-family:'Poppins', sans-serif;
    background:#f5f7fb;
    overflow-x:hidden;
    position:relative;
}

.container{
    width:90%;
    margin:auto;
}

.flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

/* Glow Background */

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

/* =========================
TOPBAR
========================= */

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

/* =========================
NAVBAR
========================= */

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

/* =========================
PLANOS
========================= */

.planos-hero{
    background:
    linear-gradient(rgba(11,31,54,0.85), rgba(11,31,54,0.85)),
    url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d");
    background-size:cover;
    background-position:center;
    padding:140px 20px;
    text-align:center;
    color:white;
}

.planos-hero h1{
    font-size:60px;
    margin-bottom:20px;
}

.planos-hero p{
    max-width:800px;
    margin:auto;
    text-align:center;
    color:#d8e5f7;
}

.planos-section{
    padding:90px 0;
}

.planos-grid{
    display:flex;
    justify-content:center;
    gap:35px;
    flex-wrap:wrap;
}

.plano-card{
    width:350px;
    background:white;
    border-radius:30px;
    padding:40px;
    position:relative;
    transition:.4s;

    box-shadow:
    0 15px 35px rgba(0,0,0,.08);
}

.plano-card:hover{
    transform:translateY(-10px);
    box-shadow:
    0 25px 50px rgba(0,0,0,.15);
}

.plano-card.destaque{
    background:
    linear-gradient(
        135deg,
        #1C5CC8,
        #0B3B7A
    );
}

.plano-card.destaque:hover{
    transform:scale(1.05) translateY(-10px);
}

.badge{
    position:absolute;
    top:20px;
    right:20px;

    background:#2F6FB2;
    color:white;

    padding:8px 16px;
    border-radius:50px;
    font-size:12px;
    font-weight:700;
}

.plano-icon{
    width:90px;
    height:90px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#E6EEF8;

    margin-bottom:25px;
}

.plano-icon i{
    font-size:38px;
    color:#0B3B7A;
}

.plano-card h3{
    font-size:30px;
    margin-bottom:15px;
}

.preco{
    font-size:40px;
    font-weight:700;
    margin-bottom:15px;
}

.preco span{
    font-size:18px;
    font-weight:400;
}

.descricao{
    text-align:left;
    margin-bottom:25px;
    color:#666;
}

.plano-card.destaque .descricao{
    color:#d7e4f8;
}

.plano-card ul{
    list-style:none;
    margin-bottom:30px;
}

.plano-card ul li{
    margin-bottom:15px;
    display:flex;
    align-items:center;
    gap:10px;
}

.plano-card ul li i{
    color:#2F6FB2;
}

.plano-card.destaque ul li i{
    color:#7fb7ff;
}

.btn-plano{
    display:block;
    width:100%;

    text-align:center;

    padding:16px;
    border-radius:14px;

    text-decoration:none;
    font-weight:600;

    background:#2F6FB2;
    color:white;

    transition:.3s;
}

.btn-plano:hover{
    transform:translateY(-3px);
}

.plano-card.destaque .btn-plano{
    background:white;
    color:#0B3B7A;
}

.comparativo{
    margin-top:100px;
}

.comparativo h2{
    text-align:center;
    margin-bottom:40px;
}

.tabela{
    overflow-x:auto;
}

.tabela table{
    width:100%;
    background:white;
    border-radius:20px;
    overflow:hidden;
    border-collapse:collapse;

    box-shadow:
    0 10px 25px rgba(0,0,0,.08);
}

.tabela th{
    background:#0B3B7A;
    color:white;
    padding:20px;
}

.tabela td{
    padding:18px;
    text-align:center;
    border-bottom:1px solid #eee;
}

.tabela tr:hover{
    background:#f7faff;
}

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

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(40px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.section{
    animation:fadeUp 1s ease;
}

@media (max-width: 768px){

    .container{
        width:95%;
    }

    /* TOPBAR */

    .topbar{
        padding:12px 0;
    }

    .top-info{
        width:100%;
        flex-direction:column;
        gap:8px;
        text-align:center;
    }

    .top-info a{
        font-size:13px;
    }

    .top-icons{
        width:100%;
        justify-content:center;
        margin-top:10px;
    }

    /* NAVBAR */

    .navbar{
        padding:15px 0;
    }

    .navbar .flex{
        flex-direction:column;
        gap:15px;
    }

    .logo{
        font-size:24px;
    }

    .logo img{
        width:50px;
    }

    .menu{
        width:100%;
        justify-content:center;
        gap:15px;
        flex-wrap:wrap;
    }

    .menu a{
        font-size:14px;
    }

    .btn{
        width:100%;
        text-align:center;
        padding:14px;
    }

    /* HERO */

    .header,
    .hero-about,
    .planos-hero{
        padding:80px 15px;
    }

    .header h1,
    .hero-about h1,
    .planos-hero h1{
        font-size:32px !important;
        line-height:1.2;
    }

    .header p,
    .hero-about p,
    .planos-hero p{
        font-size:15px;
    }

    /* TITULOS */

    h2{
        font-size:28px !important;
    }

    h3{
        font-size:22px !important;
    }

    p{
        font-size:15px !important;
        text-align:left;
    }

    /* ABOUT */

    .about-card{
        padding:25px;
    }

    .about-content{
        flex-direction:column;
        gap:25px;
    }

    .team-grid{
        grid-template-columns:1fr;
    }

    .team-card img,
    .team img{
        height:280px;
    }

    /* INDEX */

    .diferenciais-topo{
        flex-direction:column;
        gap:25px;
    }

    .diferenciais-texto h2,
    .diferenciais-texto h2 span{
        font-size:36px !important;
    }

    .diferenciais-imagem img{
        height:280px;
    }

    .cards{
        gap:20px;
    }

    .card{
        width:100%;
        max-width:none;
    }

    .services{
        flex-direction:column;
    }

    .service{
        min-width:100%;
    }

    /* CONTATO */

    .contact-wrapper{
        flex-direction:column;
        margin:35px 0;
    }

    .contact-card{
        min-width:100%;
        padding:20px;
    }

    iframe{
        height:280px;
    }

    /* AVALIAÇÃO */

    .stats{
        grid-template-columns:1fr;
    }

    .content{
        grid-template-columns:1fr !important;
    }

    .left-panel,
    .right-panel{
        padding:25px;
    }

    .page-header h1{
        font-size:30px;
    }

    .form-title{
        font-size:24px;
    }

    .stars{
        justify-content:center;
    }

    .stars span{
        font-size:40px;
    }

    /* PLANOS */

    .planos-grid{
        gap:20px;
    }

    .plano-card{
        width:100%;
        padding:25px;
    }

    .preco{
        font-size:32px;
    }

    .tabela{
        overflow-x:auto;
    }

    .tabela table{
        min-width:700px;
    }

    /* FOOTER */

    .footer{
        padding:60px 0 20px;
    }

    .footer-grid{
        flex-direction:column;
        gap:25px;
    }

    .footer-col{
        min-width:100%;
    }

    .newsletter{
        flex-direction:column;
        gap:10px;
    }

    .newsletter input{
        border-radius:8px;
    }

    .newsletter button{
        border-radius:8px;
        padding:14px;
    }

}

</style>
</head>

<body>

<!-- TOPBAR -->

<div class="topbar">
<div class="container flex">

<div class="top-info">

<a href="https://wa.me/551994010744?text=Olá!%20Seja%20Bem-vindo(a)%20à%20GeoSync!%20Como%20posso%20ajudar?" target="_blank">
<i class="fas fa-phone-alt"></i>
+55 (19) 99401-0744
</a>

<a href="mailto:murilo.breda@aluno.senai.br" target="_blank">
<i class="fas fa-envelope"></i>
contact@geosync.com
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
<a href="/contact">Contato</a>
<a href="/planos">Planos</a>
</div>

<a href="/login" class="btn">
Solicitar um Serviço
</a>

</div>
</div>

<!-- HERO -->

<section class="planos-hero">

    <div class="container">

        <h1>Planos GeoSync</h1>

        <p>
            Escolha a solução ideal para monitorar sua operação,
            rastrear veículos em tempo real e otimizar sua logística.
        </p>

    </div>

</section>

<!-- PLANOS -->

<section class="planos-section">

    <div class="container">

        <div class="planos-grid">

            <!-- START -->

            <div class="plano-card">

                <div class="plano-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>

                <h3>GeoSync Start</h3>

                <div class="preco">
                    R$149,99
                    <span>/mês</span>
                </div>

                <p class="descricao">
                    Ideal para pequenas empresas e autônomos.
                </p>

                <ul>
                    <li><i class="fas fa-check"></i> Até 10 entregas</li>
                    <li><i class="fas fa-check"></i> Rastreamento em tempo real</li>
                    <li><i class="fas fa-check"></i> Alertas inteligentes</li>
                    <li><i class="fas fa-check"></i> Dashboard</li>
                </ul>

                <a href="/pagamento" class="btn-plano">
                    Começar Agora
                </a>

            </div>

            <!-- PRO -->

            <div class="plano-card destaque">

                <span class="badge">
                    MAIS POPULAR
                </span>

                <div class="plano-icon">
                    <i class="fas fa-truck"></i>
                </div>

                <h3>GeoSync Pro</h3>

                <div class="preco">
                    R$599,99
                    <span>/6 mês</span>
                </div>

                <p class="descricao">
                    Controle completo para empresas em crescimento.
                </p>

                <ul>
                    <li><i class="fas fa-check"></i> Até 65 entregas</li>
                    <li><i class="fas fa-check"></i> Rastreamento em tempo real</li>
                    <li><i class="fas fa-check"></i> Alertas inteligentes</li>
                    <li><i class="fas fa-check"></i> Dashboard</li>
                    <li><i class="fas fa-check"></i> Suporte prioritário</li>
                </ul>

                <a href="/pagamento" class="btn-plano">
                    Assinar Pro
                </a>

            </div>

            <!-- ENTERPRISE -->

            <div class="plano-card">

                <div class="plano-icon">
                    <i class="fas fa-building"></i>
                </div>

                <h3>Enterprise</h3>

                <div class="preco">
                    Personalizado
                </div>

                <p class="descricao">
                    Para grandes operações logísticas.
                </p>

                <ul>
                    <li><i class="fas fa-check"></i> Entregas ilimitados</li>
                    <li><i class="fas fa-check"></i> Rastreamento em tempo real</li>
                    <li><i class="fas fa-check"></i> Alertas inteligentes</li>
                    <li><i class="fas fa-check"></i> Dashboard</li>
                    <li><i class="fas fa-check"></i> Suporte prioritário</li>
                </ul>

                <a href="https://wa.me/551994010744?text=Olá,%20quero%20mais%20informações%20sobre%20o%20plano%20Enterprise" target="_blank" class="btn-plano">
                    Falar com Consultor
                </a>

            </div>

        </div>

        <!-- TABELA COMPARATIVA -->

        <div class="comparativo">

            <h2>Compare os planos</h2>

            <div class="tabela">

                <table>

                    <tr>
                        <th>Recursos</th>
                        <th>Start</th>
                        <th>Pro</th>
                        <th>Enterprise</th>
                    </tr>

                    <tr>
                        <td>Rastreamento em tempo real</td>
                        <td>✔</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>

                    <tr>
                        <td>Alertas inteligentes</td>
                        <td>✔</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>

                    <tr>
                        <td>Dashboard</td>
                        <td>✔</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>

                    <tr>
                        <td>Suporte prioritário</td>
                        <td>✖</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>

                    <tr>
                        <td>Entregas</td>
                        <td>10</td>
                        <td>65</td>
                        <td>Ilimitado</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</section>

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