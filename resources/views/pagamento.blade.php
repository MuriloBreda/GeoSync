<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Pagamento</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- QR CODE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: linear-gradient(135deg, #0f172a, #1e293b);
}

.wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    height: 100vh;
    padding: 40px 20px;
}

.container {
    background: #fff;
    max-width: 750px;
    width: 100%;
    padding: 10px;
    border-radius: 12px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* Plans */
.plans {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}

.plan {
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    cursor: pointer;
    text-align: center;
}

.plan.active {
    border-color: #3b82f6;
    background: #eff6ff;
}

/* Payments */
.payments {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.payment {
    border: 2px solid #ddd;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    gap: 10px;
    justify-content: center;
}

.payment.active {
    border-color: #3b82f6;
    background: #eff6ff;
}

/* Inputs */
.input-group input, select {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
}

/* Summary */
.summary {
    margin-top: 20px;
    padding: 15px;
    background: #f1f5f9;
    border-radius: 8px;
}

.total {
    font-size: 20px;
    font-weight: bold;
}

.parcelas {
    color: #16a34a;
    margin-top: 5px;
}

/* Button */
.btn {
    width: 100%;
    margin-top: 15px;
    padding: 12px;
    background: #3b82f6;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

/* Success */
.success {
    text-align: center;
    display: none;
}

.success i {
    font-size: 60px;
    color: #22c55e;
    margin-bottom: 15px;
}

/* PIX */
#pixBox, #boletoBox {
    display: none;
    text-align: center;
}

.hidden {
    display: none;
}
</style>

<script>
let plans = {
    mensal: { price: 150, label: "Mensal" },
    semestral: { price: 420, label: "6 meses" },
    anual: { price: 840, label: "12 meses" }
};

let selectedPlan = "mensal";

function selectPlan(el, planKey) {
    document.querySelectorAll('.plan').forEach(p => p.classList.remove('active'));
    el.classList.add('active');

    selectedPlan = planKey;
    updateSummary();
}

function updateSummary() {
    let plan = plans[selectedPlan];
    document.getElementById("planName").innerText = plan.label;
    document.getElementById("totalPrice").innerText = "R$ " + plan.price.toFixed(2);
    calculateInstallments();
}

function selectPayment(el, type) {
    document.querySelectorAll('.payment').forEach(p => p.classList.remove('active'));
    el.classList.add('active');

    document.querySelectorAll('.payment-details').forEach(d => d.classList.add('hidden'));
    document.getElementById(type).classList.remove('hidden');
}

function calculateInstallments() {
    let plan = plans[selectedPlan];
    let parcelas = document.getElementById("parcelas").value;

    if (!parcelas) return;

    let valorParcela = plan.price / parcelas;

    document.getElementById("parcelamentoInfo").innerText =
        parcelas + "x de R$ " + valorParcela.toFixed(2);
}

/* ================= FINALIZAR ================= */
function finalizarPagamento() {
    let metodo = document.querySelector(".payment.active").innerText;

    // ================= VALIDAÇÃO CARTÃO =================
    if (metodo.includes("Crédito")) {

        let campos = document.querySelectorAll("#credito input");
        let valido = true;

        campos.forEach(campo => {
            if (campo.value.trim() === "") {
                valido = false;
                campo.style.border = "2px solid #ef4444";
            } else {
                campo.style.border = "1px solid #ccc";
            }
        });

        if (!valido) {
            document.getElementById("erroCartao").style.display = "block";
            return;
        } else {
            document.getElementById("erroCartao").style.display = "none";
        }
    }

    // ================= FLUXO NORMAL =================
    document.getElementById("conteudo").style.display = "none";

    if (metodo.includes("PIX")) {
        gerarPix();
    } 
    else if (metodo.includes("Boleto")) {
        gerarBoleto();
    } 
    else {
        mostrarSucesso();
    }
}
/* ================= SUCESSO ================= */
function mostrarSucesso() {
    document.getElementById("sucesso").style.display = "block";
}

/* ================= PIX ================= */
function gerarPix() {
    document.getElementById("pixBox").style.display = "block";

    let valor = plans[selectedPlan].price;
    let payload = `PIX|VALOR:${valor}|PLANO:${selectedPlan}|ID:${Date.now()}`;

    document.getElementById("qrcode").innerHTML = "";

    new QRCode(document.getElementById("qrcode"), {
        text: payload,
        width: 220,
        height: 220
    });

    document.getElementById("pixValor").innerText = "R$ " + valor.toFixed(2);
}

/* ================= BOLETO ================= */
function gerarBoleto() {
    document.getElementById("boletoBox").style.display = "block";

    let valor = plans[selectedPlan].price;

    let numero = Math.floor(Math.random() * 999999999999).toString();

    let linha = numero.padStart(47, '0');

    document.getElementById("linhaDigitavel").innerText = linha;
    document.getElementById("valorBoleto").innerText = "R$ " + valor.toFixed(2);

    let hoje = new Date();
    hoje.setDate(hoje.getDate() + 3);

    document.getElementById("vencimento").innerText =
        hoje.toLocaleDateString("pt-BR");
}

window.onload = updateSummary;
</script>

</head>

<body>

<div class="wrapper">
<div class="container">

<!-- CONTEÚDO -->
<div id="conteudo">

<h2>Finalizar Pagamento</h2>
<div id="erroCartao" style="
    display:none;
    background:#fee2e2;
    color:#b91c1c;
    padding:10px;
    border-radius:8px;
    text-align:center;
    font-weight:bold;
">
    Os dados do cartão são obrigatórios.
</div>

<!-- PLANOS -->
<div class="plans">
    <div class="plan active" onclick="selectPlan(this,'mensal')">
        <strong>Mensal</strong><br>R$ 150
    </div>

    <div class="plan" onclick="selectPlan(this,'semestral')">
        <strong>6 meses</strong><br>R$ 420
    </div>

    <div class="plan" onclick="selectPlan(this,'anual')">
        <strong>12 meses</strong><br>R$ 840
    </div>
</div>

<!-- PAGAMENTOS -->
<div class="payments">
    <div class="payment active" onclick="selectPayment(this,'credito')">
        <i class="fa-solid fa-credit-card"></i> Crédito
    </div>

    <div class="payment" onclick="selectPayment(this,'debito')">
        <i class="fa-solid fa-credit-card"></i> Débito
    </div>

    <div class="payment" onclick="selectPayment(this,'boleto')">
        <i class="fa-solid fa-barcode"></i> Boleto
    </div>

    <div class="payment" onclick="selectPayment(this,'pix')">
        <i class="fa-brands fa-pix"></i> PIX
    </div>
</div>

<!-- CRÉDITO -->
<div id="credito" class="payment-details input-group">
    <input type="text" placeholder="Número do cartão">
    <input type="text" placeholder="Nome no cartão">
    <input type="text" placeholder="Validade">
    <input type="text" placeholder="CVV">

    <select id="parcelas" onchange="calculateInstallments()">
        <option value="">Parcelar em...</option>
        <option value="1">1x sem juros</option>
        <option value="2">2x</option>
        <option value="3">3x</option>
        <option value="6">6x</option>
        <option value="12">12x</option>
    </select>

    <div class="parcelas" id="parcelamentoInfo"></div>
</div>

<!-- PIX -->
<div id="pix" class="payment-details hidden"></div>

<!-- BOLETO -->
<div id="boleto" class="payment-details hidden"></div>

<!-- RESUMO -->
<div class="summary">
    <p>Plano: <strong id="planName"></strong></p>
    <p>Total:</p>
    <div class="total" id="totalPrice"></div>
</div>

<button class="btn" onclick="finalizarPagamento()">Confirmar Pagamento</button>

</div>

<!-- PIX BOX -->
<div id="pixBox">
    <h2>PIX Gerado</h2>
    <p>Valor: <span id="pixValor"></span></p>
    <div id="qrcode" style="margin:20px auto;"></div>
    <button class="btn" onclick="mostrarSucesso()">Já paguei</button>
</div>

<!-- BOLETO BOX -->
<div id="boletoBox">
    <h2>Boleto Gerado</h2>
    <p><strong>Valor:</strong> <span id="valorBoleto"></span></p>
    <p><strong>Vencimento:</strong> <span id="vencimento"></span></p>

    <p style="margin-top:10px;"><strong>Linha digitável:</strong></p>
    <p id="linhaDigitavel" style="font-family:monospace;"></p>

    <button class="btn" onclick="mostrarSucesso()">Confirmar Pagamento</button>
</div>

<!-- SUCESSO -->
<div id="sucesso" class="success">
    <i class="fa-solid fa-circle-check"></i>
    <h2>Pagamento concluído com sucesso!</h2>
    <p>Seu plano foi ativado.</p>
    <button class="btn" onclick="location.reload()">Voltar</button>
</div>

</div>
</div>

</body>
</html>