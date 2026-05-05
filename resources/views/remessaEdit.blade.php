<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Remessa</title>

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

.form-card{
background:white;
padding:30px;
border-radius:10px;
max-width:600px;
margin:auto;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.form-group{
margin-bottom:15px;
}

input{
width:100%;
padding:10px;
border-radius:6px;
border:1px solid #ddd;
}

button{
background:var(--azul-tech);
color:white;
border:none;
padding:12px;
width:100%;
border-radius:6px;
cursor:pointer;
}
</style>
</head>

<body>

<div class="container">

<div class="form-card">

<h2>Editar Remessa</h2>

<form action="{{ route('remessas.update',$remessa->id) }}" method="POST">
@csrf
@method('PUT')

<div class="form-group">
<input type="text" name="codigo_rastreio" value="{{ $remessa->codigo_rastreio }}">
</div>

<div class="form-group">
<input type="text" name="origem" value="{{ $remessa->origem }}">
</div>

<div class="form-group">
<input type="text" name="destino" value="{{ $remessa->destino }}">
</div>

<div class="form-group">
<input type="text" name="tipo_carga" value="{{ $remessa->tipo_carga }}">
</div>

<div class="form-group">
<input type="number" step="0.01" name="peso" value="{{ $remessa->peso }}">
</div>

<div class="form-group">
<input type="date" name="previsao_entrega" value="{{ $remessa->previsao_entrega }}">
</div>

<div class="form-group">
<input type="text" name="status" value="{{ $remessa->status }}">
</div>

<button>Atualizar</button>

</form>

</div>
</div>

</body>
</html>