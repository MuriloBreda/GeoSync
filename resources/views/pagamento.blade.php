<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>GeoSync - Pagamento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #0f172a, #1e293b); min-height: 100vh; }
        .wrapper { display: flex; justify-content: center; align-items: flex-start; padding: 40px 20px; }
        .container { background: #fff; max-width: 750px; width: 100%; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        h2 { text-align: center; margin-bottom: 20px; color: #1e293b; }
        
        /* Planos */
        .plans { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
        .plan { border: 2px solid #e2e8f0; border-radius: 10px; padding: 15px; cursor: pointer; text-align: center; transition: 0.3s; }
        .plan.active { border-color: #3b82f6; background: #eff6ff; }
        
        /* Pagamentos */
        .payments { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 20px; }
        .payment { border: 2px solid #e2e8f0; padding: 12px; border-radius: 8px; cursor: pointer; display: flex; gap: 10px; justify-content: center; align-items: center; }
        .payment.active { border-color: #3b82f6; background: #eff6ff; }
        
        /* Inputs */
        .input-group input, .input-group select { width: 100%; padding: 12px; margin-top: 10px; border: 1px solid #cbd5e1; border-radius: 6px; }
        
        /* Resumo */
        .summary { margin-top: 20px; padding: 15px; background: #f1f5f9; border-radius: 8px; }
        .total { font-size: 24px; font-weight: bold; color: #1e293b; }
        .parcelas-info { color: #16a34a; font-weight: 500; margin-top: 5px; }

        .btn { width: 100%; margin-top: 15px; padding: 14px; background: #3b82f6; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; transition: 0.3s; }
        .btn:hover { background: #2563eb; }

        /* Modais de visualização */
        #pixBox, #boletoBox, #sucesso, .hidden { display: none; text-align: center; }
        .success-icon { font-size: 60px; color: #22c55e; margin-bottom: 15px; }
        .error-msg { background:#fee2e2; color:#b91c1c; padding:10px; border-radius:8px; text-align:center; font-weight:bold; margin-bottom: 15px; display: none; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="container">
        
        <form id="mainForm" action="{{ route('pagamento.store') }}" method="POST">
            @csrf
            <input type="hidden" name="valor" id="db_valor" value="150">
            <input type="hidden" name="plano" id="db_plano" value="mensal">
            <input type="hidden" name="metodo" id="db_metodo" value="credito">

            <div id="conteudo">
                <h2>Finalizar Pagamento</h2>
                
                <div id="erroCartao" class="error-msg">Os dados do cartão são obrigatórios.</div>

                <div class="plans">
                    <div class="plan active" onclick="selectPlan(this, 'mensal', 150)">
                        <strong>Mensal</strong><br>R$ 150
                    </div>
                    <div class="plan" onclick="selectPlan(this, 'semestral', 420)">
                        <strong>6 meses</strong><br>R$ 420
                    </div>
                    <div class="plan" onclick="selectPlan(this, 'anual', 840)">
                        <strong>12 meses</strong><br>R$ 840
                    </div>
                </div>

                <div class="payments">
                    <div class="payment active" onclick="selectPayment(this, 'credito')">
                        <i class="fa-solid fa-credit-card"></i> Crédito
                    </div>
                    <div class="payment" onclick="selectPayment(this, 'boleto')">
                        <i class="fa-solid fa-barcode"></i> Boleto
                    </div>
                    <div class="payment" onclick="selectPayment(this, 'pix')">
                        <i class="fa-brands fa-pix"></i> PIX
                    </div>
                </div>

                <div id="area-credito" class="input-group">
                    <input type="text" placeholder="Número do cartão" class="card-input">
                    <input type="text" placeholder="Nome no cartão" class="card-input">
                    <div style="display: flex; gap: 10px;">
                        <input type="text" placeholder="Validade (MM/AA)" class="card-input">
                        <input type="text" placeholder="CVV" class="card-input">
                    </div>
                    <select id="selectParcelas" onchange="calcParcelas()">
                        <option value="1">1x de R$ 150,00 (sem juros)</option>
                    </select>
                </div>

                <div class="summary">
                    <p>Plano Selecionado: <strong id="txtPlano">Mensal</strong></p>
                    <p>Total a pagar:</p>
                    <div class="total" id="txtTotal">R$ 150,00</div>
                </div>

                <button type="button" class="btn" onclick="processar()">Confirmar Pagamento</button>
            </div>
        </form>

        <div id="pixBox">
            <h2>Escaneie o QR Code</h2>
            <div id="qrcode" style="display: flex; justify-content: center; margin: 20px 0;"></div>
            <p>Valor: <strong id="pixValorTxt"></strong></p>
            <button class="btn" onclick="finalizarNoBanco()">Já paguei</button>
        </div>

        <div id="boletoBox">
            <h2>Boleto Gerado</h2>
            <p>Linha digitável:</p>
            <code id="linhaBoleto" style="display:block; background:#f1f5f9; padding:10px; margin:10px 0;"></code>
            <button class="btn" onclick="finalizarNoBanco()">Confirmar após pagamento</button>
        </div>

        <div id="sucesso" class="success-content">
            <i class="fa-solid fa-circle-check success-icon"></i>
            <h2>Pagamento Realizado!</h2>
            <p>Sua assinatura GeoSync está ativa.</p>
            <a href="/service" class="btn" style="display:block; text-decoration:none;">Ir para o Dashboard</a>
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

<script>
    let currentValor = 150;
    let currentMetodo = 'credito';

    function selectPlan(el, plano, preco) {
        document.querySelectorAll('.plan').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        
        currentValor = preco;
        document.getElementById('db_plano').value = plano;
        document.getElementById('db_valor').value = preco;
        document.getElementById('txtPlano').innerText = el.querySelector('strong').innerText;
        document.getElementById('txtTotal').innerText = "R$ " + preco.toFixed(2);
        
        updateParcelas(preco);
    }

    function selectPayment(el, metodo) {
        document.querySelectorAll('.payment').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        
        currentMetodo = metodo;
        document.getElementById('db_metodo').value = metodo;
        document.getElementById('area-credito').style.display = (metodo === 'credito') ? 'block' : 'none';
    }

    function updateParcelas(preco) {
        const select = document.getElementById('selectParcelas');
        select.innerHTML = '';
        [1, 2, 3, 6, 12].forEach(p => {
            let valorP = (preco / p).toFixed(2);
            let option = document.createElement('option');
            option.value = p;
            option.text = `${p}x de R$ ${valorP}`;
            select.appendChild(option);
        });
    }

    function processar() {
        if (currentMetodo === 'credito') {
            let inputs = document.querySelectorAll('.card-input');
            let erro = false;
            inputs.forEach(i => {
                if(i.value === "") { i.style.borderColor = 'red'; erro = true; }
                else { i.style.borderColor = '#cbd5e1'; }
            });
            if(erro) { document.getElementById('erroCartao').style.display = 'block'; return; }
            finalizarNoBanco();
        } else if (currentMetodo === 'pix') {
            document.getElementById('conteudo').style.display = 'none';
            document.getElementById('pixBox').style.display = 'block';
            document.getElementById('pixValorTxt').innerText = "R$ " + currentValor.toFixed(2);
            new QRCode(document.getElementById("qrcode"), { text: "geosync-pix-payload-" + Date.now(), width: 200, height: 200 });
        } else {
            document.getElementById('conteudo').style.display = 'none';
            document.getElementById('boletoBox').style.display = 'block';
            document.getElementById('linhaBoleto').innerText = "00190.00009 02313.400006 45848.400002 8 934200000" + currentValor;
        }
    }

    function finalizarNoBanco() {
        // Envia o formulário para o Laravel salvar no MySQL
        document.getElementById('mainForm').submit();
    }
</script>

@if(session('success'))
<script>
    document.getElementById('conteudo').style.display = 'none';
    document.getElementById('pixBox').style.display = 'none';
    document.getElementById('boletoBox').style.display = 'none';
    document.getElementById('sucesso').style.display = 'block';
</script>
@endif

</body>
</html>