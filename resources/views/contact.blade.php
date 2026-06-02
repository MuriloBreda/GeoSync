<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>GeoSync - Contato</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

<style>
:root{
    --azul-institucional:#1C3F6E;
    --azul-tech:#2F6FB2;
    --azul-profundo:#0B1F36;
    --azul-claro:#E6EEF8;
    --azul-cinza:#7B92AD;

    --primary:#072051;
    --secondary:#328CC1;
    --light:#F4F7FA;
    --dark:#1B1B1B;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f5f7fb;
    color:var(--dark);
    overflow-x:hidden;
}

/* =========================
   CONTAINER
========================= */

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

/* =========================
   TOPBAR
========================= */

.topbar{
    background:linear-gradient(90deg,var(--azul-profundo),var(--azul-institucional));
    padding:10px 0;
    color:#fff;
    font-size:14px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.top-info{
    display:flex;
    gap:20px;
}

.topbar a{
    color:#fff;
    text-decoration:none;
    transition:.3s;
}

.topbar a:hover{
    color:#7fb7ff;
}

.top-icons{
    display:flex;
    gap:10px;
}

.top-icons a{
    width:34px;
    height:34px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    transition:.3s;
}

.top-icons a:hover{
    background:rgba(255,255,255,.15);
    transform:translateY(-3px);
}

/* =========================
   NAVBAR
========================= */

.navbar{
    background:#fff;
    padding:15px 0;
    border-bottom:1px solid #e8e8e8;
    position:sticky;
    top:0;
    z-index:1000;
}

.logo{
    display:flex;
    align-items:center;
    gap:12px;
    text-decoration:none;
    color:var(--azul-institucional);
    font-size:28px;
    font-weight:700;
}

.logo img{
    width:65px;
}

.menu{
    display:flex;
    gap:35px;
}

.menu a{
    text-decoration:none;
    color:var(--azul-institucional);
    font-size:15px;
    font-weight:700;
    transition:.3s;
}

.menu a:hover{
    color:var(--azul-tech);
}

.btn{
    background:linear-gradient(90deg,#0B3B7A,#022553);
    color:#fff;
    padding:12px 24px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}

/* =========================
   HEADER
========================= */

.header{
    background:
    linear-gradient(rgba(11,31,54,.85),rgba(11,31,54,.85)),
    url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d");
    background-size:cover;
    background-position:center;
    color:white;
    padding:90px 0;
    margin-bottom:0;
    text-align:center;
}

.header h1{
    font-size:56px;
    font-weight:700;
    margin-bottom:10px;
}

.header p{
    font-size:18px;
    opacity:.9;
}

/* =========================
   CONTACT
========================= */

.contact-wrapper{
    display:flex;
    gap:30px;
    flex-wrap:wrap;
    margin:60px 0;
}

.contact-card{
    flex:1;
    min-width:320px;
    background:white;
    padding:40px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    transition:.3s;
}

.contact-card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 30px rgba(0,0,0,.12);
}

.location-box{
    background:linear-gradient(90deg,var(--azul-tech),var(--azul-institucional));
    color:#fff;
    padding:14px;
    border-radius:10px;
    text-align:center;
    font-weight:600;
    margin-bottom:20px;
}

iframe{
    width:100%;
    height:380px;
    border:none;
    border-radius:12px;
}

.contact-card h2{
    color:var(--primary);
    margin-bottom:20px;
    font-size:28px;
}

.input{
    width:100%;
    padding:14px;
    border:1px solid #d7dfea;
    border-radius:10px;
    margin-bottom:15px;
    font-size:15px;
    font-family:'Poppins',sans-serif;
    transition:.3s;
}

select.input{
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;
    background:white;
    cursor:pointer;
}

.input:focus{
    outline:none;
    border-color:var(--azul-tech);
    box-shadow:0 0 0 4px rgba(47,111,178,.12);
}

.textarea{
    height:140px;
    resize:none;
}

.btn-enviar{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:linear-gradient(90deg,#0B3B7A,#022553);
    color:#fff;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn-enviar:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}

/* =========================
   FOOTER
========================= */

.footer{
    background:var(--primary);
    color:#bfcbdd;
    padding:60px 0 20px;
    margin-top:50px;
}

.footer-grid{
    display:flex;
    flex-wrap:wrap;
    gap:30px;
}

.footer-col{
    flex:1;
    min-width:220px;
}

.footer h3{
    color:var(--secondary);
    margin-bottom:20px;
}

.footer p,
.footer a{
    color:#a3b8cc;
    text-decoration:none;
    display:block;
    margin-bottom:10px;
    transition:.3s;
}

.footer a:hover{
    color:white;
    padding-left:5px;
}

.social{
    display:flex;
    gap:15px;
    margin-top:15px;
}

.newsletter{
    display:flex;
    margin-top:10px;
}

.newsletter input{
    flex:1;
    padding:10px;
    border:none;
    outline:none;
    border-radius:4px 0 0 4px;
}

.newsletter button{
    background:var(--secondary);
    border:none;
    color:#fff;
    padding:10px 15px;
    cursor:pointer;
    border-radius:0 4px 4px 0;
}

.copy{
    text-align:center;
    margin-top:40px;
    padding-top:20px;
    border-top:1px solid rgba(255,255,255,.1);
    color:#7b92ad;
    font-size:13px;
}

/* =========================
   RESPONSIVO
========================= */

@media(max-width:768px){

    .flex{
        flex-direction:column;
        gap:15px;
        text-align:center;
    }

    .menu{
        flex-direction:column;
        gap:12px;
    }

    .top-info{
        flex-direction:column;
        gap:8px;
    }

    .header h1{
        font-size:36px;
    }

    .contact-card{
        padding:20px;
    }
}
</style>
</head>

<body>

<!-- TOPBAR -->

<div class="topbar">
<div class="container flex">

<div class="top-info">

<a href="#">
<i class="fas fa-phone-alt"></i>
+55 (19) 99401-0744
</a>

<a href="#">
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

<a href="https://www.instagram.com" target="_blank">
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
<a href="/pagamento">Planos</a>
</div>

<a href="/login" class="btn">
Solicitar um Serviço
</a>

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
            <form action="{{ route('contato.store') }}" method="POST" id="contactForm">
                @csrf
                <h2>Envie uma mensagem</h2>
                <input type="text" name="nome" placeholder="Seu nome" class="input" required>
                <input type="email" name="email" placeholder="Seu email" class="input" required>
                
                <select name="assunto" class="input" required>
                    <option value="">Selecione um assunto</option>
                    <option value="duvida">Dúvida</option>
                    <option value="suporte">Suporte</option>
                    <option value="comercial">Comercial</option>
                    <option value="outro">Outro</option>
                </select>

                <textarea name="mensagem" placeholder="Mensagem" class="input textarea" required></textarea>
                <button type="submit" class="btn-enviar">Enviar Mensagem</button>
            </form>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("contactForm");

    if (!form) return;

    form.addEventListener("submit", function (e) {

        // 🔥 impede o reload imediato (ESSENCIAL)
        e.preventDefault();

        Swal.fire({
            title: "Enviando mensagem...",
            text: "Aguarde um momento",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // 🔥 espera 600ms pra UX e envia depois
        setTimeout(() => {
            form.submit();
        }, 600);
    });

});
</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Sucesso!',
    text: "{{ session('success') }}",
    confirmButtonColor: '#2F6FB2'
});
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Erro!',
    text: 'Verifique os campos e tente novamente',
    confirmButtonColor: '#d33'
});
</script>
@endif

</body>
</html>