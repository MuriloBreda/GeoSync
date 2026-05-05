<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>GeoSync | Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

<style>
:root{
--primary:#2563eb;
--bg:#f1f5f9;
--dark:#0f172a;
--radius:12px;
}

body{margin:0;font-family:'Poppins';background:var(--bg);transition:.3s;}
.main{display:flex;}

/* SIDEBAR */
.sidebar{
width:250px;
background:var(--dark);
color:white;
min-height:100vh;
}

.sidebar h2{
text-align:center;
padding:20px;
border-bottom:1px solid #1e293b;
}

.menu-item{
padding:15px 20px;
cursor:pointer;
display:flex;
gap:10px;
color:#cbd5f5;
}

.menu-item:hover,.menu-item.active{
background:var(--primary);
color:white;
}

/* CONTENT */
.content{flex:1;padding:30px;}
.page{display:none;}
.page.active{display:block;}

.card{
background:white;
padding:20px;
border-radius:var(--radius);
margin-bottom:20px;
box-shadow:0 4px 10px rgba(0,0,0,0.05);
transition:.2s;
}
.card:hover{transform:translateY(-3px);}

/* GRID */
.stats{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
}

.grid{
display:grid;
grid-template-columns:2fr 1fr;
gap:20px;
}

/* ALERT */
.alert{padding:10px;border-radius:8px;margin-bottom:10px;}
.alert-danger{background:#fee2e2;color:#991b1b;}
.alert-info{background:#dbeafe;color:#1e3a8a;}

/* TABLE */
table{width:100%;border-collapse:collapse;}
th,td{padding:10px;border-bottom:1px solid #eee;text-align:left;}

.badge{padding:5px 10px;border-radius:20px;font-size:12px;}
.entregue{background:#dcfce7;color:#15803d;}
.transito{background:#dbeafe;color:#1d4ed8;}
.atrasado{background:#fee2e2;color:#b91c1c;}

/* BUTTON */
.btn{
display:inline-block;
background:var(--primary);
color:white;
padding:10px;
border-radius:8px;
text-decoration:none;
border:none;
cursor:pointer;
}

.btn-mini{
padding:5px 8px;
font-size:12px;
border-radius:6px;
background:#2563eb;
color:white;
border:none;
}

.btn-mini.danger{background:#ef4444;}

input,select,textarea{
width:100%;
padding:10px;
margin-bottom:10px;
border-radius:8px;
border:1px solid #ccc;
}

/* PRODUTO CARD */
.produto{
padding:10px;
background:#e2e8f0;
border-radius:8px;
margin-top:10px;
display:flex;
justify-content:space-between;
}

/* CONFIG */
.perfil{
text-align:center;
}
.perfil img{
width:90px;
height:90px;
border-radius:50%;
margin-bottom:10px;
border:3px solid var(--primary);
}

/* DARK */
.dark{
background:#0f172a;
color:white;
}
.dark .card{background:#1e293b;}
.dark .sidebar{background:#020617;}

</style>
</head>

<body>

<div class="main">

<!-- SIDEBAR -->
<div class="sidebar">
<h2>GeoSync</h2>

<div class="menu-item active" onclick="changePage('dashboard',this)">
<i class="fas fa-chart-line"></i> Dashboard
</div>

<div class="menu-item" onclick="changePage('entregas',this)">
<i class="fas fa-truck"></i> Entregas
</div>

<div class="menu-item" onclick="changePage('produtos',this)">
<i class="fas fa-box"></i> Produtos
</div>

<div class="menu-item" onclick="changePage('config',this)">
<i class="fas fa-cog"></i> Config
</div>

<div class="menu-item" onclick="window.location='/logout'" style="color:#ef4444;">
<i class="fas fa-sign-out-alt"></i> Sair
</div>
</div>

<!-- CONTENT -->
<div class="content">

<!-- DASHBOARD -->
<div id="dashboard" class="page active">

<h2>Dashboard</h2>

<div class="stats">
<div class="card"><h4>Total</h4><h2>{{ $total }}</h2></div>
<div class="card"><h4>Transito</h4><h2>{{ $transito }}</h2></div>
<div class="card"><h4>Entregues</h4><h2>{{ $entregues }}</h2></div>
<div class="card"><h4>Atrasadas</h4><h2>{{ $atrasadas }}</h2></div>
</div>

<div class="grid">

<div class="card" style="height:400px;">
<div id="map" style="height:100%;"></div>
</div>

<div>

<div class="card">
<h3>Alertas</h3>

@foreach($alertas as $a)
<div class="alert {{ $a->tipo_alerta == 'Atraso' ? 'alert-danger':'alert-info' }}">
<strong>{{ $a->tipo_alerta }}</strong><br>
{{ $a->descricao }}
</div>
@endforeach
</div>

<div class="card">
<h3>📍 Localização</h3>

<form action="{{ route('localizacao.store') }}" method="POST">
@csrf
<input type="number" step="0.000001" name="latitude" placeholder="Latitude">
<input type="number" step="0.000001" name="longitude" placeholder="Longitude">

<select name="remessa_id">
@foreach($remessas as $r)
<option value="{{ $r->id }}">{{ $r->codigo_rastreio }}</option>
@endforeach
</select>

<button class="btn">Salvar</button>
</form>
</div>

<div class="card">
<h3>🔔 Novo Alerta</h3>

<form action="{{ route('alerta.store') }}" method="POST">
@csrf

<select name="tipo_alerta">
<option value="Atraso">Atraso</option>
<option value="Rota">Mudança de rota</option>
<option value="Entrega">Entrega</option>
</select>

<input type="text" name="descricao" placeholder="Descrição">

<select name="remessa_id">
@foreach($remessas as $r)
<option value="{{ $r->id }}">{{ $r->codigo_rastreio }}</option>
@endforeach
</select>

<button class="btn">Criar</button>
</form>
</div>

</div>
</div>
</div>

<!-- ENTREGAS -->
<div id="entregas" class="page">

<h2>Entregas</h2>

<a href="{{ route('remessas.create') }}" class="btn" style="margin-bottom:20px;">+ Nova Remessa</a>

<div class="card">
<table>
<tr>
<th>Código</th>
<th>Origem</th>
<th>Destino</th>
<th>Tipo</th>
<th>Peso</th>
<th>Entrega</th>
<th>Status</th>
<th></th>
</tr>

@foreach($remessas as $r)
<tr>
<td>{{ $r->codigo_rastreio }}</td>
<td>{{ $r->origem }}</td>
<td>{{ $r->destino }}</td>
<td>{{ $r->tipo_carga }}</td>
<td>{{ $r->peso }}</td>
<td>{{ $r->previsao_entrega }}</td>

<td>
<span class="badge 
{{ $r->status=='Entregue'?'entregue':'' }}
{{ $r->status=='Em transporte'?'transito':'' }}
{{ $r->status=='Atrasado'?'atrasado':'' }}">
{{ $r->status }}
</span>
</td>

<td>
<a href="{{ route('remessas.show',$r->id) }}" class="btn-mini">Ver</a>
</td>
</tr>
@endforeach

</table>
</div>

</div>

<!-- PRODUTOS -->
<div id="produtos" class="page">

<div class="card">
<h3>Produtos</h3>

<input id="nome" placeholder="Nome do produto">
<button class="btn" onclick="addProduto()">Cadastrar</button>

<div id="lista"></div>

</div>
</div>

<!-- CONFIG -->
<div id="config" class="page">

<div class="card perfil">
<h3>Perfil</h3>

<form method="POST" action="/configuracoes" enctype="multipart/form-data">
@csrf

<img id="preview"
src="{{ Auth::user()->foto ? asset('storage/'.Auth::user()->foto) : asset('img/user.png') }}">

<input type="file" name="foto" id="fotoInput">

<input type="text" name="name" value="{{ Auth::user()->name }}">
<input type="email" name="email" value="{{ Auth::user()->email }}">
<input type="password" name="password" placeholder="Nova senha">

<button class="btn">Salvar</button>

</form>
</div>

<div class="card">
<h3>Acessibilidade</h3>

<label>
<input type="checkbox" onchange="toggleDark()"> Modo escuro
</label>

<select onchange="changeFont(this.value)">
<option value="normal">Fonte normal</option>
<option value="grande">Fonte grande</option>
</select>

</div>

</div>

</div>
</div>

<script>
function changePage(id,el){
document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
document.getElementById(id).classList.add('active');

document.querySelectorAll('.menu-item').forEach(i=>i.classList.remove('active'));
el.classList.add('active');
}

function addProduto(){
let nome = document.getElementById('nome').value;
if(!nome) return;

document.getElementById('lista').innerHTML += `
<div class="produto">
${nome}
<button class="btn-mini danger" onclick="this.parentElement.remove()">X</button>
</div>
`;
}

function toggleDark(){
document.body.classList.toggle('dark');
}

function changeFont(v){
document.body.style.fontSize = v === 'grande' ? '18px':'14px';
}

document.getElementById('fotoInput').addEventListener('change', e=>{
const file = e.target.files[0];
if(file){
document.getElementById('preview').src = URL.createObjectURL(file);
}
});
</script>

<!-- MAPA -->
<script>
window.initMap = function(){

let lat = -21.7041;
let lng = -47.2708;

@if(isset($remessa) && $remessa && $remessa->localizacoes->count())
lat = {{ $remessa->localizacoes->last()->latitude }};
lng = {{ $remessa->localizacoes->last()->longitude }};
@endif

const map = new google.maps.Map(document.getElementById("map"),{
zoom:13,
center:{lat:lat,lng:lng}
});

new google.maps.Marker({
position:{lat:lat,lng:lng},
map:map
});
}
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=SUA_API_KEY&callback=initMap"></script>

</body>
</html>