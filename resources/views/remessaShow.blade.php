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
font-family:Poppins;
background:#f5f7fb;
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

</body>
</html>