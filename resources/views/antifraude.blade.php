<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Antifraude - Sistema</title>

<!-- ICONES -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f1f5f9;
    }

    header {
        background: rgb(0, 0, 139);
        color: white;
        padding: 20px;
        text-align: center;
    }

    header h1 {
        margin: 0;
        font-size: 20px;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    header p {
        margin: 5px 0 0;
        font-size: 14px;
        color: #94a3b8;
    }

    .container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
    }

    .titulo {
        margin-bottom: 20px;
        font-size: 22px;
        color: black;

        display: flex;
        align-items: center;
        gap: 10px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .topo-card {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .icone {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(37, 99, 235, 0.1);

        display: flex;
        align-items: center;
        justify-content: center;

        color: #2563eb;
        font-size: 16px;
    }

    .card span {
        font-size: 13px;
        color: #64748b;
    }

    .card strong {
        display: block;
        margin-top: 8px;
        font-size: 20px;
        color: rgb(0, 0, 139);
    }

    .acoes {
        margin-top: 25px;
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 12px 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;

        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-azul {
        background: #2563eb;
        color: white;
    }

    .btn-preto {
        background: red;
        color: white;
    }

    .status {
        margin-top: 25px;
        padding: 15px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;

        display: flex;
        align-items: center;
        gap: 10px;
    }

    .baixo { background: #dcfce7; color: #166534; }
    .medio { background: #fef9c3; color: #854d0e; }
    .alto { background: #fee2e2; color: #991b1b; }

    @media(max-width: 900px){

        .grid{
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 600px){

        .grid{
            grid-template-columns: 1fr;
        }

        .acoes{
            flex-direction: column;
        }
    }

</style>
</head>
<body>

<header>
    <h1>
        <i class="fa-solid fa-shield-halved"></i>
        Sistema de Monitoramento de Cargas
    </h1>
</header>

<div class="container">

    <div class="titulo">
        <i class="fa-solid fa-chart-line" style="color:#2563eb;"></i>
        Análise Inteligente de Veículos
    </div>

    <div class="grid">

        <div class="card">

            <div class="topo-card">
                <div class="icone">
                    <i class="fa-regular fa-clock"></i>
                </div>

                <span>Tempo parado</span>
            </div>

            <strong id="tempo">--</strong>

        </div>

        <div class="card">

            <div class="topo-card">
                <div class="icone">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>

                <span>Velocidade</span>
            </div>

            <strong id="velocidade">--</strong>

        </div>

        <div class="card">

            <div class="topo-card">
                <div class="icone">
                    <i class="fa-solid fa-route"></i>
                </div>

                <span>Desvio de rota</span>
            </div>

            <strong id="rota">--</strong>

        </div>

        <div class="card">

            <div class="topo-card">
                <div class="icone">
                    <i class="fa-solid fa-circle-info"></i>
                </div>

                <span>Status atual</span>
            </div>

            <strong id="mensagem">--</strong>

        </div>

    </div>

    <div class="acoes">

        <button class="btn btn-azul" onclick="verificar()">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
            Analisar
        </button>

        <button class="btn btn-preto" onclick="limpar()">
            <i class="fa-solid fa-trash"></i>
            Limpar
        </button>

    </div>

    <div id="status" class="status"></div>

</div>

<script>
async function verificar(){

    let res = await fetch('/ia-antifraude');
    let data = await res.json();

    document.getElementById("tempo").innerText = data.tempo_parado + " min";
    document.getElementById("velocidade").innerText = data.velocidade + " km/h";
    document.getElementById("rota").innerText = data.desvio_rota;
    document.getElementById("mensagem").innerText = data.mensagem;

    let status = document.getElementById("status");

    let icone = "";

    if(data.risco === "baixo"){
        icone = "🟢";
    }

    if(data.risco === "medio"){
        icone = "🟡";
    }

    if(data.risco === "alto"){
        icone = "🔴";
    }

    status.innerText = icone + " Nível de risco: " + traduzir(data.risco);

    status.className = "status " + data.risco;
}

function limpar(){

    document.getElementById("tempo").innerText = "--";
    document.getElementById("velocidade").innerText = "--";
    document.getElementById("rota").innerText = "--";
    document.getElementById("mensagem").innerText = "--";
    document.getElementById("status").innerText = "";
}

function traduzir(risco){

    if(risco === "baixo") return "Baixo";
    if(risco === "medio") return "Médio";
    if(risco === "alto") return "Alto";
}
</script>

</body>
</html>