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

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    background:#f4f7fc;
    color:#1e293b;
}

/* HEADER */

header{
    background:#0B234F;
    padding:18px 40px;
    box-shadow:0 4px 20px rgba(0,0,0,.12);
}

.logo{
    display:flex;
    align-items:center;
    gap:15px;
    text-decoration:none;
}

.logo img{
    width:70px;
    background:white;
    padding:8px;
    border-radius:12px;
}

.logo span{
    color:white;
    font-size:28px;
    font-weight:700;
}

/* CONTAINER */

.container{
    max-width:1200px;
    margin:50px auto;
    padding:0 25px;
}

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

@media(max-width:900px){

    .stats{
        grid-template-columns:1fr;
    }

    .content{
        grid-template-columns:1fr;
    }

    .left-panel{
        text-align:center;
    }

    .page-header h1{
        font-size:32px;
    }
}

</style>
</head>
<body>

<header>
    <a href="/" class="logo">
        <img src="{{ asset('img/Logo.png') }}" alt="Logo">
        <span>GeoSync</span>
    </a>
</header>

<div class="container">

    <div class="page-header">
        <h1><i class="fa-solid fa-chart-line"></i> Feedback do Cliente</h1>
        <p>Sua opinião ajuda a GeoSync a evoluir continuamente.</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <h3>98%</h3>
            <p>Satisfação dos Clientes</p>
        </div>

        <div class="stat-card">
            <h3>1.250+</h3>
            <p>Avaliações Recebidas</p>
        </div>

        <div class="stat-card">
            <h3>4.8</h3>
            <p>Média Geral</p>
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
    window.location.href="/chat";
});
</script>
@endif
</body>
</html>

