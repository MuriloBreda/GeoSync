<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>GeoSync</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

<style>

/* PALETA */
:root{
--azul-institucional:#1C3F6E;
--azul-tech:#2F6FB2;
--azul-profundo:#0B1F36;
--azul-claro:#E6EEF8;
--azul-cinza:#7B92AD;
}

body{
margin: 0;
font-family: 'Poppins', sans-serif;
background: #f5f7fb;
overflow-x: hidden;
}

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
background: var(--azul-profundo);
color:white;
padding:8px 0;
font-size:14px;
}

/* Icones do index */
.top-icons i{
margin-left:12px;
cursor:pointer;
transition:0.3s;
color: white
}

.top-icons i:hover{
color:var(--azul-tech);
}

/* NAVBAR */
.navbar{
background:#f1f1f1;
padding:15px 0;
}

.logo{
font-size:26px;
font-weight:bold;
color:var(--azul-institucional);
}

.menu{
display:flex;
gap:30px;
}

.menu a{
text-decoration:none;
color:var(--azul-institucional);
font-size:15px;
}

.btn{
background:var(--azul-institucional);
color:white;
padding:10px 20px;
border-radius:4px;
text-decoration:none;
background-color: #022553
}

/* HEADER */
.header{
background:
linear-gradient(rgba(11,31,54,0.85), rgba(11,31,54,0.85)),
url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d");
background-size:cover;
background-position:center;
padding:120px 20px;
text-align:center;
color:white;
}

.header h1{
font-size:40px;
}

/* SEÇÕES */
.section{
padding:35px 0;
}

/* BLOCO */
.block{
background:white;
border-radius:10px;
padding:30px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
margin-bottom:15px;
text-align:center;
}

.block-left{
text-align:left;
}

.block img{
width:100%;
max-height:180px;
object-fit:cover;
border-radius:10px;
margin-bottom:15px;
}

/* TEXTOS */
h2{
font-size:28px;
margin-bottom:10px;
}

h3{
font-size:22px;
}

p{
font-size:18px;
line-height:1.6;
}

.texto-grande{
font-size:20px;
line-height:1.8;
}

/* SERVIÇOS */
.services{
display:flex;
gap:10px;
flex-wrap:wrap;
}

.service{
flex:1;
min-width:250px;
}

/* EQUIPE */
.team{
display:flex;
justify-content:center;
gap:20px;
flex-wrap:wrap;
margin-top:25px;
}

.member{
text-align:center;
background:white;
padding:15px;
border-radius:10px;
width:160px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
transition:0.3s;
}

.member:hover{
transform:translateY(-8px);
}

.member img{
width:100px;
height:100px;
border-radius:50%;
object-fit:cover;
border:3px solid var(--azul-tech);
}

/* ===== FOOTER MELHORADO ===== */

.footer{
background: linear-gradient(180deg,#0B1F36,#08192c);
color:white;
padding:60px 0 20px;
margin-top:40px;
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
color:var(--azul-tech);
margin-bottom:15px;
}

.footer p{
color:var(--azul-claro);
font-size:15px;
}

.footer a{
display:block;
color:var(--azul-cinza);
margin-bottom:8px;
text-decoration:none;
transition:0.3s;
}

.footer a:hover{
color:var(--azul-tech);
padding-left:5px;
}

/* SOCIAL */
.social{
display:flex;
gap:10px;
margin-top:10px;
}

.social i{
width:35px;
height:35px;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
border:1px solid var(--azul-cinza);
cursor:pointer;
transition:0.3s;
}

.social i:hover{
background:var(--azul-tech);
border-color:var(--azul-tech);
}

/* NEWSLETTER */
.newsletter{
display:flex;
margin-top:15px;
}

.newsletter input{
flex:1;
padding:12px;
border:none;
outline:none;
}

.newsletter button{
background:var(--azul-tech);
border:none;
color:white;
padding:0 20px;
cursor:pointer;
}

/* COPYRIGHT */
.copy{
text-align:center;
margin-top:30px;
font-size:14px;
color:var(--azul-cinza);
}

</style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
<div class="container flex">
<div>+55 (19) 99401-0744 | contact@geosync.com</div>
<div class="top-icons">
<a href="https://www.facebook.com/?locale=pt_BR" target="_blank"><i class="fab fa-facebook-f"></i></a>
<a href="https://x.com/?lang=pt" target="_blank"><i class="fab fa-twitter"></i></a>
<a href="https://br.linkedin.com/?mcid=6821526239111716925&src=go-pa&trk=sem-ga_campid.12619604099_asid.149519181115_crid.725790844702_kw.linkedin_d.c_tid.kwd-148086543_n.g_mt.e_geo.1032087&cid=&gclsrc=aw.ds&gad_source=1&gad_campaignid=12619604099&gbraid=0AAAAABhL5JN4wzyXHl9v3KlEu0Ue8Qcgx&gclid=Cj0KCQjwy_fOBhC6ARIsAHKFB7-eoK4pgfFGsLmdO-reXead95oZ4BqlwNmRZrwmbZPk-SWcKZa35ykaAtqrEALw_wcB" target="_blank"><i class="fab fa-linkedin-in"></i></a>
<a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
</div>
</div>
</div>

<!-- NAVBAR -->
<div class="navbar">
<div class="container flex">
<div class="logo"><i class="fa fa-truck"></i> GeoSync</div>

<div class="menu">
<a href="/">Início</a>
<a href="/about">Sobre</a>
<a href="/contact">Contato</a>
</div>

<a href="/login" class="btn" style="border-radius: 8px;">Solicitar um Serviço</a>
</div>
</div>

<!-- HEADER -->
<div class="header">
<h1>Rastreamento Inteligente</h1>
<p>Controle total da sua logística em tempo real</p>
</div>

<!-- SOBRE -->
<div class="container section">
<div class="block">
<img src="https://images.unsplash.com/photo-1553413077-190dd305871c">
<h2>Sobre a GeoSync</h2>
<p class="texto-grande">
A GeoSync é uma plataforma inteligente de rastreamento e monitoramento logístico desenvolvida para oferecer total controle sobre operações de transporte e armazenamento.
Com tecnologia moderna e interface intuitiva, nossa solução permite acompanhar veículos, cargas e rotas em tempo real, garantindo mais segurança, eficiência e transparência em toda a cadeia logística.
Nosso objetivo é transformar a forma como empresas gerenciam sua logística, reduzindo custos operacionais, otimizando processos e aumentando a confiabilidade nas entregas.
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
<p class="texto-grande">O módulo de transporte terrestre da GeoSync permite o gerenciamento completo da sua frota com rastreamento em tempo real.
Acompanhe rotas, monitore paradas, identifique desvios e tenha acesso a dados estratégicos que ajudam na tomada de decisões mais rápidas e eficientes.
Com mais controle e visibilidade, sua operação se torna mais segura, reduzindo riscos e garantindo entregas dentro do prazo.</p>
</div>
</div>

<div class="service">
<div class="block">
<img src="https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc">
<h3>Armazenamento</h3>
<p class="texto-grande">A GeoSync também oferece soluções para controle de armazenamento, proporcionando organização e eficiência na gestão de estoques.
Tenha total visibilidade sobre entradas, saídas e localização dos produtos, evitando perdas, retrabalho e falhas operacionais.
Com integração logística, sua empresa ganha mais produtividade e controle em todas as etapas do processo.</p>
</div>
</div>

</div>
</div>

<!-- EQUIPE -->
<div class="container section">
<div class="block">
<h2>Nossa equipe</h2>
<p>Nossa equipe é formada por profissionais especializados em tecnologia, logística e análise de dados, comprometidos em desenvolver soluções eficientes e inovadoras.
Trabalhamos com foco em resultados, buscando constantemente melhorias para entregar uma plataforma cada vez mais completa, segura e intuitiva.
Acreditamos que a união entre conhecimento técnico e visão estratégica é essencial para transformar desafios logísticos em oportunidades de crescimento.</p>

<div class="team">
<div class="member"><img src="https://randomuser.me/api/portraits/men/1.jpg"></div>
<div class="member"><img src="https://randomuser.me/api/portraits/women/2.jpg"></div>
<div class="member"><img src="https://randomuser.me/api/portraits/men/3.jpg"></div>
<div class="member"><img src="https://randomuser.me/api/portraits/women/4.jpg"></div>
<div class="member"><img src="https://randomuser.me/api/portraits/men/5.jpg"></div>
<div class="member"><img src="https://randomuser.me/api/portraits/women/6.jpg"></div>
</div>

</div>
</div>

<!-- FOOTER -->
<div class="footer">
<div class="container">

<div class="footer-grid">

<div class="footer-col">
<h3>GeoSync</h3>
<p>Sistema inteligente de rastreamento e logística em tempo real.</p>
<div class="social">
<a href="https://www.facebook.com/?locale=pt_BR" target="_blank"><i class="fab fa-facebook-f"></i></a>
<a href="https://x.com/?lang=pt" target="_blank"><i class="fab fa-twitter"></i></a>
<a href="https://br.linkedin.com/?mcid=6821526239111716925&src=go-pa&trk=sem-ga_campid.12619604099_asid.149519181115_crid.725790844702_kw.linkedin_d.c_tid.kwd-148086543_n.g_mt.e_geo.1032087&cid=&gclsrc=aw.ds&gad_source=1&gad_campaignid=12619604099&gbraid=0AAAAABhL5JN4wzyXHl9v3KlEu0Ue8Qcgx&gclid=Cj0KCQjwy_fOBhC6ARIsAHKFB7-eoK4pgfFGsLmdO-reXead95oZ4BqlwNmRZrwmbZPk-SWcKZa35ykaAtqrEALw_wcB" target="_blank"><i class="fab fa-linkedin-in"></i></a>
<a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
</div>
</div>

<div class="footer-col">
<h3>Links</h3>
<a href="/">Início</a>
<a href="/about">Sobre</a>
<a href="/login">Serviços</a>
<a href="/contact">Contato</a>
<a href="/avaliar">Feedback</a>
</div>

<div class="footer-col">
<h3>Contato</h3>
<p>📍 Tambaú - SP</p>
<p>📞 (19) 99401-0744</p>
<p>📧 contact@geosync.com</p>
</div>

<div class="footer-col">
<h3>Newsletter</h3>
<p>Receba novidades da plataforma</p>
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