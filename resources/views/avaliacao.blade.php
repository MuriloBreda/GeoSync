<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Feedback do Cliente</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #eef2f7, #dfe7f3);
    color: #1e293b;
}

/* NAVBAR */
header {
    background: rgba(30, 58, 95, 0.95);
    backdrop-filter: blur(10px);
    color: white;
    padding: 20px 40px;
    font-size: 20px;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

/* CONTAINER */
.container {
    max-width: 780px;
    margin: 70px auto;
    padding: 0 20px;
}

/* TITULOS */
h1 {
    font-size: 34px;
    font-weight: 700;
    margin-bottom: 8px;
}

.subtext {
    color: #64748b;
    margin-bottom: 35px;
}

/* CARD */
.card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border-radius: 16px;
    padding: 35px;
    box-shadow: 
        0 10px 30px rgba(0,0,0,0.08),
        0 2px 8px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-4px);
}

/* LABEL */
label {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
    color: #334155;
}

/* INPUTS */
input, textarea {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    margin-bottom: 20px;
    font-size: 14px;
    background: #f8fafc;
    transition: 0.25s;
}

input::placeholder,
textarea::placeholder {
    color: #94a3b8;
}

input:focus, textarea:focus {
    outline: none;
    border-color: #3b82f6;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}

textarea {
    resize: none;
    height: 130px;
}

/* ESTRELAS */
.stars {
    display: flex;
    gap: 8px;
    font-size: 30px;
    cursor: pointer;
    margin-bottom: 25px;
}

.stars span {
    color: #cbd5e1;
    transition: 0.2s;
}

.stars span:hover {
    transform: scale(1.25);
}

.stars span.active {
    color: #f59e0b;
    text-shadow: 0 0 10px rgba(245,158,11,0.5);
}

/* BOTÃO */
button {
    width: 100%;
    padding: 15px;
    border-radius: 12px;
    border: none;
    font-size: 15px;
    font-weight: 600;
    color: white;
    background: linear-gradient(135deg, #3e75bc, #3b82f6);
    cursor: pointer;
    transition: all 0.25s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(59,130,246,0.3);
}

button:active {
    transform: scale(0.97);
}

/* RESPONSIVO */
@media (max-width: 600px) {
    h1 {
        font-size: 26px;
    }

    .card {
        padding: 25px;
    }
}
</style>
</head>

<body>

<header>GeoSync</header>

<div class="container">
    <h1>Feedback do Cliente</h1>
    <p class="subtext">Sua voz ajuda a melhora das nossas entregas e fluxos 🚀</p>

    <div class="card">
        <h2 style="margin-bottom: 10px;">Compartilhe sua experiência</h2>
        <p class="subtext">Preencha os dados abaixo e avalie sua experiência.</p>

        <label>Nome</label>
        <input type="text" placeholder="Seu nome completo">

        <label>Nota</label>
        <div class="stars" id="stars">
            <span data-value="1">★</span>
            <span data-value="2">★</span>
            <span data-value="3">★</span>
            <span data-value="4">★</span>
            <span data-value="5">★</span>
        </div>

        <label>Observações</label>
        <textarea placeholder="Conte-nos sobre sua experiência..."></textarea>

        <button onclick="enviar()">Enviar Avaliação</button>
    </div>
</div>

<script>
const stars = document.querySelectorAll('#stars span');
let notaSelecionada = 0;

stars.forEach(star => {
    star.addEventListener('click', () => {
        let value = star.getAttribute('data-value');
        notaSelecionada = value;

        stars.forEach(s => s.classList.remove('active'));

        for (let i = 0; i < value; i++) {
            stars[i].classList.add('active');
        }
    });
});

function enviar() {
    if (notaSelecionada == 0) {
        alert("Escolha uma nota para enviar sua avaliação ⭐");
        return;
    }

    alert("Avaliação enviada com sucesso, Obrigado por compartilhar sua experiência!");
}
</script>

</body>
</html>


