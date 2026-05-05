<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Remessas - GeoSync</title>

<style>
:root{
--azul-institucional:#1C3F6E;
--azul-tech:#2F6FB2;
--azul-profundo:#0B1F36;
--azul-claro:#E6EEF8;
}

body{
margin:0;
font-family:Poppins, sans-serif;
background:#f5f7fb;
}

/* NAV */
.navbar{
background:#f1f1f1;
padding:15px;
display:flex;
justify-content:space-between;
}

.logo{font-size:22px;color:var(--azul-institucional);}

/* CONTAINER */
.container{
width:90%;
margin:auto;
margin-top:30px;
}

.page-title{
font-size:28px;
color:var(--azul-institucional);
margin-bottom:20px;
}

/* TABLE */
.table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:10px;
overflow:hidden;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.table th{
background:var(--azul-institucional);
color:white;
padding:12px;
}

.table td{
padding:10px;
border-bottom:1px solid #eee;
text-align:center;
}

.table tr:hover{
background:var(--azul-claro);
}

/* BUTTONS */
.btn{
padding:6px 12px;
border-radius:6px;
text-decoration:none;
color:white;
font-size:13px;
border:none;
cursor:pointer;
}

.btn-view{background:#2ecc71;}
.btn-edit{background:#3498db;}
.btn-delete{background:#e74c3c;}
.btn-primary{background:var(--azul-tech);}

/* ALERT */
.alert{
background:#d4edda;
padding:10px;
border-radius:5px;
margin-bottom:15px;
}
</style>
</head>

<body>

<div class="navbar">
<div class="logo"><a href="/" style="text-decoration: none; color:#0B1F36;">GeoSync</a></div>
<a href="{{ route('remessas.create') }}" class="btn btn-primary">+ Nova</a>
</div>

<div class="container">

<h2 class="page-title">Minhas Remessas</h2>

@if(session('success'))
<div class="alert">{{ session('success') }}</div>
@endif

<table class="table">
<tr>
<th>Código</th>
<th>Origem</th>
<th>Destino</th>
<th>Status</th>
<th>Ações</th>
</tr>

@foreach($remessas as $r)
<tr>
<td>{{ $r->codigo_rastreio }}</td>
<td>{{ $r->origem }}</td>
<td>{{ $r->destino }}</td>
<td>{{ $r->status }}</td>

<td>
<a href="{{ route('remessas.show',$r->id) }}" class="btn btn-view">Ver</a>
<a href="{{ route('remessas.edit',$r->id) }}" class="btn btn-edit">Editar</a>

<form action="{{ route('remessas.destroy',$r->id) }}" method="POST" style="display:inline;" onsubmit="return confirmar()">
@csrf
@method('DELETE')
<button class="btn btn-delete">Excluir</button>
</form>
</td>

</tr>
@endforeach

</table>
</div>

<script>
function confirmar(){
return confirm("Excluir essa remessa?");
}
</script>

</body>
</html>