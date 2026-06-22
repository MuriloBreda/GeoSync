<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Detalhes</title>

<style>
:root{
--azul-institucional:#1C3F6E;
--azul-tech:#2F6FB2;
}

body{
    font-family:'Poppins', sans-serif;
    background:#f5f7fb;
    overflow-x:hidden;
}

.container{
width:90%;
margin:auto;
margin-top:40px;
}

.card{
background:white;
padding:30px;
border-radius:10px;
max-width:600px;
margin:auto;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

p{
margin-bottom:10px;
}

strong{
color:var(--azul-institucional);
}

.btn{
background:var(--azul-tech);
color:white;
padding:10px 15px;
text-decoration:none;
border-radius:6px;
}

@media (max-width: 768px){

    body{
        margin:0;
        padding:15px;
    }

    .container{
        width:100%;
        margin-top:20px;
    }

    .card{
        width:100%;
        max-width:100%;
        padding:20px;
        border-radius:15px;
    }

    h2{
        font-size:24px;
        text-align:center;
        margin-bottom:20px;
    }

    p{
        font-size:15px;
        line-height:1.6;
        word-break:break-word;
    }

    strong{
        display:block;
        margin-bottom:3px;
    }

    .btn{
        display:block;
        width:100%;
        text-align:center;
        padding:14px;
        margin-top:20px;
        font-size:15px;
    }

    [vw-access-button]{
        transform:scale(.85);
        right:10px !important;
        bottom:10px !important;
    }
}

@media (max-width: 480px){

    .card{
        padding:15px;
    }

    h2{
        font-size:20px;
    }

    p{
        font-size:14px;
    }

    .btn{
        padding:12px;
    }
}

</style>
</head>

<body>

<div class="container">

<div class="card">

<h2>Detalhes da Remessa</h2>

<p><strong>Código:</strong> {{ $remessa->codigo_rastreio }}</p>
<p><strong>Origem:</strong> {{ $remessa->origem }}</p>
<p><strong>Destino:</strong> {{ $remessa->destino }}</p>
<p><strong>Tipo:</strong> {{ $remessa->tipo_carga }}</p>
<p><strong>Peso:</strong> {{ $remessa->peso }}</p>
<p><strong>Previsão:</strong> {{ $remessa->previsao_entrega }}</p>
<p><strong>Status:</strong> {{ $remessa->status }}</p>

<br>

<a href="{{ route('remessas.index') }}" class="btn">Voltar</a>

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

</body>
</html>