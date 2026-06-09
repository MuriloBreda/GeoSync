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
   HEADER
========================= */

.header{
    background:
    linear-gradient(rgba(11,31,54,0.85), rgba(11,31,54,0.85)),
    url("https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d");
    background-size:cover;
    background-position:center;
    padding:140px 20px;
    text-align:center;
    color:white;
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

/* =========================
   RESPONSIVO
========================= */

@media(max-width:992px){

    .navbar .flex{
        flex-direction:column;
        gap:20px;
    }

    .menu{
        flex-wrap:wrap;
        justify-content:center;
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