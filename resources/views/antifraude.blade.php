<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Antifraude - Sistema</title>

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
    }

    .baixo { background: #dcfce7; color: #166534; }
    .medio { background: #fef9c3; color: #854d0e; }
    .alto { background: #fee2e2; color: #991b1b; }

</style>
</head>
<body>

<header>
    <h1>Sistema de Monitoramento de Cargas</h1>
</header>

<div class="container">

    <div class="titulo">Análise Inteligente de Veículos</div>

    <div class="grid">

        <div class="card">
            <span>Tempo parado</span>
            <strong id="tempo">--</strong>
        </div>

        <div class="card">
            <span>Velocidade</span>
            <strong id="velocidade">--</strong>
        </div>

        <div class="card">
            <span>Desvio de rota</span>
            <strong id="rota">--</strong>
        </div>

        <div class="card">
            <span>Status atual</span>
            <strong id="mensagem">--</strong>
        </div>

    </div>

    <div class="acoes">
        <button class="btn btn-azul" onclick="verificar()">Analisar com IA</button>
        <button class="btn btn-preto" onclick="limpar()">Limpar</button>
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

    status.innerText = "Nível de risco: " + traduzir(data.risco);
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