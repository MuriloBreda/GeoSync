<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GeoSync - Pagamento Premium</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

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
</style>
</head>
<body>

<div class="wrapper">
<div class="checkout">

<div class="card">
<form id="mainForm" action="{{ route('pagamento.store') }}" method="POST">
@csrf

<input type="hidden" name="valor" id="db_valor" value="150">
<input type="hidden" name="plano" id="db_plano" value="mensal">
<input type="hidden" name="metodo" id="db_metodo" value="credito">

<div id="conteudo">
<div class="hero">
<h1>Assine o GeoSync</h1>
<p>Monitoramento e rastreamento em tempo real.</p>
</div>

<div class="plans">
<div class="plan active" onclick="selectPlan(this,'mensal',150)"><strong>Mensal</strong><br>R$150</div>
<div class="plan" onclick="selectPlan(this,'semestral',420)"><strong>6 Meses</strong><br>R$420</div>
<div class="plan destaque" onclick="selectPlan(this,'anual',840)"><strong>Anual</strong><br>R$840</div>
</div>

<div class="payments">
<div class="payment active" onclick="selectPayment(this,'credito')"><i class="fa-solid fa-credit-card"></i><br>Cartão</div>
<div class="payment" onclick="selectPayment(this,'pix')"><i class="fa-brands fa-pix"></i><br>PIX</div>
<div class="payment" onclick="selectPayment(this,'boleto')"><i class="fa-solid fa-barcode"></i><br>Boleto</div>
</div>

<div id="area-credito" class="input-group">
<input class="card-input" placeholder="Número do cartão">
<input class="card-input" placeholder="Nome impresso">
<div style="display:flex;gap:10px">
<input class="card-input" placeholder="MM/AA">
<input class="card-input" placeholder="CVV">
</div>
<select id="selectParcelas"></select>
</div>

<button type="button" class="btn" onclick="processar()">Confirmar Pagamento</button>
</div>
</form>

<div id="pixBox">
<h2>Pagamento PIX</h2>
<div id="qrcode"></div>
<button class="btn" onclick="finalizarNoBanco()">Já paguei</button>
</div>

<div id="boletoBox">
<h2>Boleto Gerado</h2>
<code id="linhaBoleto"></code>
<button class="btn" onclick="finalizarNoBanco()">Confirmar</button>
</div>

<div id="sucesso">
<h2>Pagamento Realizado!</h2>
<a href="/service" class="btn">Ir para o Dashboard</a>
</div>
</div>

<div class="card summary">
<h2>Resumo</h2>
<div class="row"><span>Plano</span><strong id="txtPlano">Mensal</strong></div>
<div class="row"><span>Total</span></div>
<div class="total" id="txtTotal">R$ 150,00</div>
<p style="margin-top:20px;color:#64748b">Pagamento protegido e criptografado.</p>
</div>

</div>
</div>

<script>
let currentValor=150,currentMetodo='credito';
updateParcelas(150);

function selectPlan(el,plano,preco){
document.querySelectorAll('.plan').forEach(x=>x.classList.remove('active'));
el.classList.add('active');
currentValor=preco;
db_plano.value=plano;
db_valor.value=preco;
txtPlano.innerText=el.querySelector('strong').innerText;
txtTotal.innerText='R$ '+preco.toFixed(2);
updateParcelas(preco);
}

function selectPayment(el,metodo){
document.querySelectorAll('.payment').forEach(x=>x.classList.remove('active'));
el.classList.add('active');
currentMetodo=metodo;
db_metodo.value=metodo;
document.getElementById('area-credito').style.display=metodo==='credito'?'block':'none';
}

function updateParcelas(preco){
let s=document.getElementById('selectParcelas');
s.innerHTML='';
[1,2,3,6,12].forEach(p=>{
let o=document.createElement('option');
o.text=p+'x de R$ '+(preco/p).toFixed(2);
s.appendChild(o);
});
}

function processar(){
if(currentMetodo==='credito'){finalizarNoBanco();return;}
if(currentMetodo==='pix'){
conteudo.style.display='none';
pixBox.style.display='block';
qrcode.innerHTML='';
new QRCode(document.getElementById('qrcode'),{text:'PIX-'+Date.now(),width:220,height:220});
return;
}
conteudo.style.display='none';
boletoBox.style.display='block';
linhaBoleto.innerText='00190.00009 02313.400006 45848.400002';
}

function finalizarNoBanco(){document.getElementById('mainForm').submit();}
</script>

</body>
</html>