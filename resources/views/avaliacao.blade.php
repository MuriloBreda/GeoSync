<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback do Cliente | GeoSync</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
CONTAINER
========================= */

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

/* PAGE HEADER */

.page-header{
    margin-bottom:35px;
}

.page-header h1{
    font-size:42px;
    font-weight:800;
    color:#0B234F;
}

.page-header p{
    margin-top:8px;
    color:#64748b;
    font-size:17px;
}

/* STATS */

.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:35px;
}

.stat-card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.stat-card h3{
    font-size:34px;
    color:#0B234F;
}

.stat-card p{
    color:#64748b;
    margin-top:5px;
}

/* MAIN CARD */

.feedback-card{
    background:white;
    border-radius:24px;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
    overflow:hidden;
}

.content{
    display:grid;
    grid-template-columns:320px 1fr;
}

.left-panel{
    background:#0B234F;
    color:white;
    padding:40px;
}

.left-panel h2{
    font-size:24px;
    margin-bottom:20px;
}

.left-panel p{
    color:#dbe4ff;
    line-height:1.7;
}

.rating-box{
    margin-top:35px;
    background:rgba(255,255,255,.08);
    border-radius:18px;
    padding:20px;
}

.rating-box h3{
    font-size:18px;
    margin-bottom:15px;
}

.rating-value{
    font-size:52px;
    font-weight:800;
}

.rating-label{
    margin-top:10px;
    color:#dbe4ff;
}

/* FORM */

.right-panel{
    padding:40px;
}

.form-title{
    font-size:30px;
    font-weight:700;
    margin-bottom:25px;
    color:#0f172a;
}

.form-group{
    margin-bottom:22px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
    color:#334155;
}

.form-group input,
.form-group textarea{
    width:100%;
    padding:15px;
    border:1px solid #dbe4f0;
    border-radius:14px;
    background:#f8fafc;
    font-size:15px;
}

.form-group input:focus,
.form-group textarea:focus{
    outline:none;
    border-color:#0B234F;
    box-shadow:0 0 0 4px rgba(11,35,79,.08);
}

textarea{
    resize:none;
    min-height:140px;
}

/* STARS */

.stars{
    display:flex;
    gap:10px;
    margin-top:10px;
}

.stars span{
    font-size:52px;
    cursor:pointer;
    color:#d1d5db;
    transition:.25s;
}

.stars span:hover{
    transform:scale(1.12);
}

.stars span.active{
    color:#F59E0B;
}

/* BUTTON */

.btn-submit{
    width:100%;
    padding:18px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#0B234F,#173A7A);
    color:white;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn-submit:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(11,35,79,.25);
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

/* loader */

#loader{
    position:fixed;
    inset:0;
    background: #fff;
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:999999;
    transition:all .8s ease;
}

.loader-logo{
    text-align:center;
    transition:all .8s ease;
}

.loader-logo img{
    width:140px;
    animation:pulse 1.5s infinite;
}

.loader-exit{
    opacity:0;
    backdrop-filter:blur(10px);
}

.loader-exit .loader-logo{
    transform:scale(1.5);
    opacity:0;
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
<a href="/contact">Contato</a>
<a href="/planos">Planos</a>
</div>

<a href="/login" class="btn">
Solicitar um Serviço
</a>

</div>
</div>

<div class="container">

    <div class="page-header">
        <h1 style="margin-top: 50px;"><i class="fa-solid fa-chart-line"></i> Feedback do Cliente</h1>
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
                    Compartilhe sua experiência utilizando os serviços da GeoSync.
                    Seu feedback é essencial para aprimorar nosso monitoramento,
                    rastreamento e gerenciamento em tempo real.
                </p>

                <div class="rating-box">
                    <h3>Nota Selecionada</h3>

                    <div class="rating-value" id="ratingNumber">0</div>

                    <div class="rating-label" id="ratingText">
                        Nenhuma avaliação
                    </div>
                </div>

            </div>

            <div class="right-panel">

                <div class="form-title">
                    Compartilhe sua experiência
                </div>

                <form action="{{ route('avaliacao.store') }}" method="POST" id="formAvaliacao">
                    @csrf

                    <input type="hidden" name="nota" id="inputNota" value="0">

                    <div class="form-group">
                        <label>
                            <i class="fa-regular fa-user"></i>
                            Nome
                        </label>

                        <input
                            type="text"
                            name="nome_exibicao"
                            placeholder="Seu nome completo (opcional)">
                    </div>

                    <div class="form-group">

                        <label>
                            <i class="fa-solid fa-star"></i>
                            Avaliação
                        </label>

                        <div class="stars" id="stars">
                            <span data-value="1">★</span>
                            <span data-value="2">★</span>
                            <span data-value="3">★</span>
                            <span data-value="4">★</span>
                            <span data-value="5">★</span>
                        </div>

                    </div>

                    <div class="form-group">

                        <label>
                            <i class="fa-regular fa-comment"></i>
                            Comentário
                        </label>

                        <textarea
                            name="comentario"
                            placeholder="Conte-nos sobre sua experiência..."></textarea>

                    </div>

                    <button type="button" class="btn-submit" onclick="validarEnvio()">
                        <i class="fa-solid fa-paper-plane"></i>
                        Enviar Avaliação
                    </button>

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

<script>

const stars = document.querySelectorAll('#stars span');
const inputNota = document.getElementById('inputNota');

const ratingNumber = document.getElementById('ratingNumber');
const ratingText = document.getElementById('ratingText');

const textos = {
    1:'Muito Ruim',
    2:'Ruim',
    3:'Regular',
    4:'Bom',
    5:'Excelente'
};

stars.forEach(star => {

    star.addEventListener('click', () => {

        let value = star.getAttribute('data-value');

        inputNota.value = value;

        ratingNumber.innerText = value;
        ratingText.innerText = textos[value];

        stars.forEach(s => s.classList.remove('active'));

        for(let i=0;i<value;i++){
            stars[i].classList.add('active');
        }

    });

});

function validarEnvio(){

    if(inputNota.value == "0"){

        Swal.fire({
            icon:'warning',
            title:'Avaliação necessária',
            text:'Selecione uma nota de 1 a 5 estrelas.'
        });

        return;
    }

    document.getElementById('formAvaliacao').submit();
}

</script>

@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Obrigado!',
    text:"{{ session('success') }}",
    timer:2500,
    showConfirmButton:false
}).then(() => {
    window.location.href="/";
});
</script>
@endif
</body>
</html>

