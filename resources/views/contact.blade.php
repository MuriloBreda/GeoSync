<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>GeoSync - Contato</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

<style>
/* ===== PALETA ===== */
:root{
    --azul-institucional:#1C3F6E;
    --azul-tech:#2F6FB2;
    --azul-profundo:#0B1F36;
    --azul-claro:#E6EEF8;
    --azul-cinza:#7B92AD;
}

body{
    margin:0;
    font-family:'Poppins', sans-serif;
    background:#f5f7fb;
    overflow-x: hidden; /* Remove rolagem lateral */
}

.container{
    width:90%;
    max-width: 1200px; /* Limite para telas grandes */
    margin:auto;
}

/* ===== TOPBAR ===== */
.topbar{
    background: var(--azul-profundo);
    color:white;
    padding:8px 0;
    font-size:14px;
}

.top-icons i{
    margin-left:12px;
    cursor:pointer;
    transition:0.3s;
    color:white
}

.top-icons i:hover{
    color:var(--azul-tech);
}

.flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

/* ===== NAVBAR ===== */
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
    color: #0B1F36;
    font-weight: 500;
    font-weight: 700;
}

/* mnjvcsihfvbshfvbsfvbhsbchbshfvbsf */
.menu a:hover{
    color: var(--secondary);
    color: #2F6FB2;
}

.btn{
    background:var(--azul-institucional);
    color:white;
    padding:10px 20px;
    border-radius:4px;
    text-decoration:none;
}

/* ===== HEADER ===== */
.header{
    background: linear-gradient(rgba(11,31,54,0.85), rgba(11,31,54,0.85)),
    url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d");
    background-size:cover;
    background-position:center;
    padding:80px 20px;
    text-align:center;
    color:white;
}

.header h1{
    font-size:38px;
    margin-bottom: 10px;
}

/* ===== CONTACT SECTION ===== */
.contact-wrapper{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    margin-top:40px;
    margin-bottom: 40px;
}

.contact-card{
    flex:1;
    min-width:300px;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
    box-sizing: border-box; /* Garante que o padding não aumente o tamanho real */
}

/* LOCALIZAÇÃO E MAPA */
.location-box{
    background: var(--azul-tech);
    color:white;
    padding:10px;
    border-radius:8px;
    text-align:center;
    font-weight:500;
    margin-bottom:15px;
}

iframe{
    width:100%;
    height:300px; /* Tamanho proporcional à caixa */
    border:none;
    border-radius:10px;
    display: block;
}

/* FORMULÁRIO */
.contact-card h2{
    margin-bottom:15px;
    color: var(--azul-institucional);
    font-size: 22px;
}

.input{
    width:100%;
    padding:10px; /* Input menor */
    margin-bottom:12px;
    border-radius:6px;
    border:1px solid #d0d7e2;
    font-size:14px;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif
}

.input:focus{
    border-color: #1e3e63;
    outline: none;
}

.textarea{
    height:80px; /* Textarea menor */
    resize:none;
}

.btn-enviar{
    width:100%;
    padding:12px;
    background: var(--azul-tech);
    color:white;
    border:none;
    border-radius:8px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

.btn-enviar:hover{
    background: var(--azul-institucional);
}

/* ===== FOOTER ===== */
.footer{
    background: var(--azul-profundo);
    color:white;
    padding-top:40px;
}

.footer-grid{
    display:flex;
    flex-wrap:wrap;
    gap:30px;
    padding-bottom:40px;
}

.footer-col{
    flex:1;
    min-width:220px;
}

.footer-col h3{
    color:var(--azul-tech);
    margin-bottom:15px;
}

.footer-col a, .footer-col p{
    color:var(--azul-cinza);
    margin-bottom:8px;
    text-decoration:none;
    font-size: 14px;
}

/* Ícones lado a lado */
.social {
    display: flex;
    gap: 15px;
    margin-top: 15px;
}

.social a{
    color:white;
    font-size:18px;
    transition: 0.3s;
}

.social a:hover {
    color: var(--azul-tech);
}

.newsletter{
    display:flex;
    margin-top:10px;
}

.newsletter input{
    flex:1;
    padding:10px;
    border:none;
    border-radius:4px 0 0 4px;
}

.newsletter button{
    background:var(--azul-tech);
    border:none;
    color:white;
    padding:10px;
    border-radius:0 4px 4px 0;
    cursor: pointer;
}

.copy{
    text-align:center;
    padding:15px;
    border-top:1px solid rgba(255,255,255,0.1);
    color:var(--azul-cinza);
    font-size: 13px;
}

.footer-col a {
    display: block; /* Garante que cada link ocupe uma linha própria */
    color: var(--azul-cinza);
    margin-bottom: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.footer-col a:hover {
    color: var(--azul-tech);
    padding-left: 5px; /* Efeito de destaque ao passar o mouse */
}
</style>
</head>

<body>

<div class="topbar">
    <div class="container flex">
        <div>
            <i class="fa fa-phone-alt"></i> +55 (19) 99401-0744 | 
            <i class="fa fa-envelope"></i> contact@geosync.com
        </div>
        <div class="top-icons">
            <a href="https://www.facebook.com/?locale=pt_BR" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://x.com/?lang=pt" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://br.linkedin.com/?mcid=6821526239111716925&src=go-pa&trk=sem-ga_campid.12619604099_asid.149519181115_crid.725790844702_kw.linkedin_d.c_tid.kwd-148086543_n.g_mt.e_geo.1032087&cid=&gclsrc=aw.ds&gad_source=1&gad_campaignid=12619604099&gbraid=0AAAAABhL5JN4wzyXHl9v3KlEu0Ue8Qcgx&gclid=Cj0KCQjwy_fOBhC6ARIsAHKFB7-eoK4pgfFGsLmdO-reXead95oZ4BqlwNmRZrwmbZPk-SWcKZa35ykaAtqrEALw_wcB" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</div>

<div class="navbar">
    <div class="container flex">
        <div class="logo"><i class="fa fa-truck"></i> GEOSYNC</div>
        <div class="menu">
            <a href="/">Início</a>
            <a href="/about">Sobre</a>
            <a href="/contact">Contato</a>
        </div>
        <a href="/login" class="btn">Solicite um Serviço</a>
    </div>
</div>

<div class="header">
    <h1>Entre em Contato</h1>
    <p>Fale com nossa equipe e leve sua logística para o próximo nível</p>
</div>

<div class="container">
    <div class="contact-wrapper">
        <div class="contact-card">
            <div class="location-box">
                <i class="fa fa-map-marker-alt"></i> Nossa Localização: Tambaú - SP
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14781.401446152286!2d-47.2798!3d-21.7056!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDQyJzIwLjEiUyA0N8KwMTYnNDcuMyJX!5e0!3m2!1spt-BR!2sbr!4v1700000000000"></iframe>
        </div>

        <div class="contact-card">
            <form action="/chat" method="GET">
                <h2>Envie uma mensagem</h2>
                <input type="text" placeholder="Seu nome" class="input" required>
                <input type="email" placeholder="Seu email" class="input" required>
                <input type="text" placeholder="Assunto" class="input" required>
                <textarea placeholder="Mensagem" class="input textarea" required></textarea>
                <button class="btn-enviar">Enviar Mensagem</button>
            </form>
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
                <a href="/service">Serviços</a>
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