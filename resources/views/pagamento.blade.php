<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GeoSync - Pagamento Premium</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<!-- Biblioteca de Máscaras -->
<script src="https://unpkg.com/imask"></script>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI,sans-serif}
body{
background:radial-gradient(circle at top left,#2563eb,transparent 30%),
radial-gradient(circle at bottom right,#1d4ed8,transparent 30%),#0f172a;
min-height:100vh;padding:30px;color:#0f172a}
.wrapper{max-width:1300px;margin:auto}
.checkout{display:grid;grid-template-columns:2fr 1fr;gap:25px}
.card{background:rgba(255,255,255,.96);backdrop-filter:blur(16px);border-radius:24px;padding:30px;box-shadow:0 20px 50px rgba(0,0,0,.25)}
.hero h1{font-size:2rem}.hero p{color:#64748b;margin-top:8px}
.plans,.payments{display:grid;gap:15px}
.plans{grid-template-columns:repeat(3,1fr);margin:25px 0}
.payments{grid-template-columns:repeat(3,1fr)}
.plan,.payment{border:2px solid #e2e8f0;border-radius:18px;padding:18px;text-align:center;cursor:pointer;transition:.3s}
.plan:hover,.payment:hover{transform:translateY(-4px)}
.active{border-color:#2563eb;background:#eff6ff}
.plan.destaque{position:relative}
.plan.destaque:before{content:"MAIS VENDIDO";position:absolute;top:10px;right:-35px;transform:rotate(35deg);background:#22c55e;color:#fff;padding:4px 40px;font-size:11px}
.input-group input,.input-group select{width:100%;padding:14px;border:1px solid #cbd5e1;border-radius:12px;margin-top:10px}
.btn{width:100%;padding:16px;border:none;border-radius:14px;background:#2563eb;color:#fff;font-weight:700;cursor:pointer;margin-top:20px}
.summary h2{margin-bottom:15px}
.row{display:flex;justify-content:space-between;margin:12px 0}
.total{font-size:2rem;font-weight:700;color:#2563eb}
#pixBox,#boletoBox,#sucesso{display:none;text-align:center}
@media(max-width:900px){.checkout{grid-template-columns:1fr}.plans,.payments{grid-template-columns:1fr}}

.btn-voltar{
display:inline-flex;
align-items:center;
gap:8px;
padding:10px 18px;
background:#e2e8f0;
color:#0f172a;
text-decoration:none;
border-radius:12px;
margin-bottom:20px;
font-weight:600;
transition:.3s;
}

.btn-voltar:hover{
background:#cbd5e1;
}
</style>
</head>
<body>

<div class="wrapper">
<div class="checkout">

<div class="card">
    <a href="/planos" class="btn-voltar">
    <i class="fa-solid fa-arrow-left"></i> Voltar
</a>
<form id="mainForm" action="{{ route('pagamento.store') }}" method="POST">
@csrf

<input type="hidden" name="valor" id="db_valor" value="149.99">
<input type="hidden" name="plano" id="db_plano" value="GeoSync Start">
<input type="hidden" name="metodo" id="db_metodo" value="credito">

<div id="conteudo">
<div class="hero">
<h1>Planos GeoSync</h1>
<p>Rastreamento, monitoramento e gerenciamento em tempo real.</p>
</div>

<div class="plans">
<div class="plan" onclick="selectPlan(this,'GeoSync Start',149.99)"><strong>GeoSync Start</strong><br>R$149,99</div>
<div class="plan" onclick="selectPlan(this,'GeoSync Pro',599.99)"><strong>GeoSync Pro</strong><br>R$599,99</div>
</div>

<div class="payments">
<div class="payment" onclick="selectPayment(this,'credito')"><i class="fa-solid fa-credit-card"></i><br>Cartão</div>
<div class="payment" onclick="selectPayment(this,'pix')"><i class="fa-brands fa-pix"></i><br>PIX</div>
<div class="payment" onclick="selectPayment(this,'boleto')"><i class="fa-solid fa-barcode"></i><br>Boleto</div>
</div>

<div id="area-credito" class="input-group">
<input id="numeroCartao" class="card-input" placeholder="0000 0000 0000 0000" autocomplete="off">
<input id="nomeCartao" class="card-input" placeholder="Nome impresso no cartão" autocomplete="off">
<div style="display:flex;gap:10px">
<input id="validadeCartao" class="card-input" placeholder="MM/AA" autocomplete="off">
<input id="cvvCartao" class="card-input" placeholder="CVV" autocomplete="off">
</div>
<select id="selectParcelas"></select>
</div>

<button type="button" class="btn" onclick="processar()">Confirmar Pagamento</button>
</div>
</form>

<div id="pixBox">
<h2>Pagamento PIX</h2>
<div id="qrcode"></div>
<button class="btn" onclick="finalizarNoBanco()">
    Confirmar Pagamento PIX
</button>
</div>

<div id="boletoBox">
<h2>Boleto Gerado</h2>
<code id="linhaBoleto"></code>
<button class="btn" onclick="finalizarNoBanco()">
    Confirmar Pagamento Boleto
</button>
</div>

<div id="sucesso">
<h2>Pagamento Realizado!</h2>
<a href="/service" class="btn">Ir para o Dashboard</a>
</div>
</div>

<div class="card summary">
<h2>Resumo</h2>
<div class="row"><span>Plano</span><strong id="txtPlano">GeoSync Start</strong></div>
<div class="row"><span>Total</span></div>
<div class="total" id="txtTotal">R$ 149,99</div>
<p style="margin-top:20px;color:#64748b">Pagamento protegido e criptografado.</p>
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

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let currentValor = 149.99;
let currentMetodo = 'credito';

document.addEventListener("DOMContentLoaded", function () {
    // --- Aplicação das Máscaras e Limites ---
    IMask(document.getElementById('numeroCartao'), {
        mask: '0000 0000 0000 0000'
    });

    IMask(document.getElementById('nomeCartao'), {
        mask: /^[a-zA-Z\s]*$/ // Apenas letras e espaços
    });

    IMask(document.getElementById('validadeCartao'), {
        mask: 'MM/YY',
        blocks: {
            MM: {
                mask: IMask.MaskedRange,
                from: 1,
                to: 12
            },
            YY: {
                mask: IMask.MaskedRange,
                from: 0,
                to: 99
            }
        }
    });

    IMask(document.getElementById('cvvCartao'), {
        mask: '0000' // Aceita 3 ou 4 dígitos (padrão MasterCard/Visa/Amex)
    });

    // --- Lógica Inicial dos Planos ---
    const urlParams = new URLSearchParams(window.location.search);
    const planoParam = urlParams.get('plano');
    const valorParam = parseFloat(urlParams.get('valor'));

    const planosCards = document.querySelectorAll('.plan');
    planosCards.forEach(c => c.classList.remove('active'));

    if (planoParam && !isNaN(valorParam)) {
        let planoEncontrado = false;

        planosCards.forEach(card => {
            const titulo = card.querySelector('strong').innerText.toLowerCase();
            if (titulo.includes(planoParam.toLowerCase())) {
                selectPlan(card, card.querySelector('strong').innerText, valorParam);
                planoEncontrado = true;
            }
        });

        if (!planoEncontrado) {
            selectPlan(planosCards[0], 'GeoSync Start', 149.99);
        }
    } else {
        selectPlan(planosCards[0], 'GeoSync Start', 149.99);
    }
});

function selectPlan(el, plano, preco) {
    document.querySelectorAll('.plan').forEach(x => x.classList.remove('active'));
    if (el) el.classList.add('active');

    currentValor = preco;
    
    document.getElementById('db_plano').value = plano;
    document.getElementById('db_valor').value = preco;

    document.getElementById('txtPlano').innerText = plano;
    document.getElementById('txtTotal').innerText = 'R$ ' + preco.toFixed(2).replace('.', ',');

    updateParcelas(preco);
}

function selectPayment(el, metodo) {
    document.querySelectorAll('.payment').forEach(x => x.classList.remove('active'));
    el.classList.add('active');
    currentMetodo = metodo;
    document.getElementById('db_metodo').value = metodo;
    document.getElementById('area-credito').style.display = metodo === 'credito' ? 'block' : 'none';
}

function updateParcelas(preco) {
    let s = document.getElementById('selectParcelas');
    if (!s) return;
    s.innerHTML = '';
    [1, 2, 3, 6, 12].forEach(p => {
        let o = document.createElement('option');
        let valorParcela = (preco / p).toFixed(2).replace('.', ',');
        o.text = p + 'x de R$ ' + valorParcela;
        s.appendChild(o);
    });
}

function processar() {
    if (currentMetodo === 'credito') { finalizarNoBanco(); return; }
    if (currentMetodo === 'pix') {
        document.getElementById('conteudo').style.display = 'none';
        document.getElementById('pixBox').style.display = 'block';
        document.getElementById('qrcode').innerHTML = '';
        new QRCode(document.getElementById('qrcode'), { text: 'PIX-' + Date.now(), width: 220, height: 220 });
        return;
    }
    document.getElementById('conteudo').style.display = 'none';
    document.getElementById('boletoBox').style.display = 'block';
    document.getElementById('linhaBoleto').innerText = '00190.00009 02313.400006 45848.400002';
}

function finalizarNoBanco() {
    Swal.fire({
        icon: 'success',
        title: 'Pagamento realizado!',
        text: 'Seu plano GeoSync foi ativado com sucesso.',
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'Continuar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/login';
        }
    });
}
</script>

</body>
</html>