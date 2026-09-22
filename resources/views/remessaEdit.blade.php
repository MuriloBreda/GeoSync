<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Remessa</title>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f1f5f9;
        padding: 40px;
    }

    .card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        max-width: 700px;
        margin: auto;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        box-sizing: border-box; /* Garante que o padding não aumente o tamanho do input */
    }

    /* Estilo base para ambos os botões */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center; /* Centraliza o texto/ícone internamente */
        gap: 8px;
        padding: 12px 18px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        border: none;
        cursor: pointer;
        height: 45px; /* Altura fixa para garantir que fiquem iguais */
        box-sizing: border-box;
        vertical-align: middle;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    /* Cores específicas */
    .btn-salvar {
        background: #2563eb;
        color: white;
        width: 65%; /* Ajuste conforme preferir */
    }

    .btn-salvar:hover {
        background: #15447d;
    }

    .btn-voltar {
        background: #e2e8f0;
        color: #0f172a;
        width: 30%; /* Ajuste conforme preferir */
    }

    .btn-voltar:hover {
        background: #cbd5e1;
    }

    /* Container para os botões ficarem na mesma linha */
    .actions {
        display: flex;
        gap: 4%; /* Espaço entre os botões */
        margin-top: 10px;
    }

    #mapaDestinoEdicao {
        height: 320px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        margin: 8px 0 15px;
    }

    .mapa-ajuda {
        color: #475569;
        display: block;
        font-size: 13px;
        margin: -5px 0 10px;
    }
</style>

</head>
<body>

<div class="card">
    <h2>Editar Remessa</h2>

    <form action="{{ route('remessas.update',$remessa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Código de Rastreio</label>
        <input type="text" name="codigo_rastreio" value="{{ $remessa->codigo_rastreio }}">

        <label>Origem</label>
        <input type="text" name="origem" value="{{ $remessa->origem }}">

        <label>Destino</label>
        <input type="text" name="destino" value="{{ $remessa->destino }}">

        <label>Posição exata de entrega</label>
        <small class="mapa-ajuda">Clique no mapa ou arraste o marcador até o local correto. A posição escolhida será usada para calcular a rota.</small>
        <div id="mapaDestinoEdicao"></div>

        <label>Latitude do destino</label>
        <input type="number" id="latitudeDestino" name="latitude_destino" step="0.0000001" min="-90" max="90" value="{{ $remessa->latitude_destino }}">

        <label>Longitude do destino</label>
        <input type="number" id="longitudeDestino" name="longitude_destino" step="0.0000001" min="-180" max="180" value="{{ $remessa->longitude_destino }}">

        <label>Tipo de Carga</label>
        <input type="text" name="tipo_carga" value="{{ $remessa->tipo_carga }}">

        <label>Peso</label>
        <input type="number" step="0.01" name="peso" value="{{ $remessa->peso }}">

        <label>Previsão de Entrega</label>
        <input type="date" name="previsao_entrega" value="{{ $remessa->previsao_entrega }}">

        <label>Status</label>
        <select name="status">
            <option value="Pendente" {{ $remessa->status == 'Pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="Em Rota" {{ $remessa->status == 'Em Rota' ? 'selected' : '' }}>Em rota</option>
            <option value="Em transporte" {{ $remessa->status == 'Em transporte' ? 'selected' : '' }}>Em transporte</option>
            <option value="Entregue" {{ $remessa->status == 'Entregue' ? 'selected' : '' }}>Entregue</option>
            <option value="Atrasado" {{ $remessa->status == 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
        </select>

        <div class="actions">
            <button type="submit" class="btn btn-salvar">Salvar Alterações</button>
            <a href="{{ route('dashboard') }}" class="btn btn-voltar">
                Voltar
            </a>
        </div>
    </form>
</div>

<div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>

<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');

    const latitudeInput = document.getElementById('latitudeDestino');
    const longitudeInput = document.getElementById('longitudeDestino');
    const latitudeSalva = Number(latitudeInput.value);
    const longitudeSalva = Number(longitudeInput.value);
    const pontoInicial = Number.isFinite(latitudeSalva) && Number.isFinite(longitudeSalva)
        ? [latitudeSalva, longitudeSalva]
        : [-14.2350, -51.9253];

    const mapaDestino = L.map('mapaDestinoEdicao').setView(
        pontoInicial,
        Number.isFinite(latitudeSalva) && Number.isFinite(longitudeSalva) ? 17 : 4
    );

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapaDestino);

    let marcadorDestino = null;

    function definirDestinoNoMapa(latitude, longitude, centralizar = true) {
        latitudeInput.value = Number(latitude).toFixed(7);
        longitudeInput.value = Number(longitude).toFixed(7);

        if (!marcadorDestino) {
            marcadorDestino = L.marker([latitude, longitude], { draggable: true }).addTo(mapaDestino);
            marcadorDestino.on('dragend', function () {
                const ponto = marcadorDestino.getLatLng();
                definirDestinoNoMapa(ponto.lat, ponto.lng, false);
            });
        } else {
            marcadorDestino.setLatLng([latitude, longitude]);
        }

        if (centralizar) mapaDestino.setView([latitude, longitude], 17);
    }

    if (Number.isFinite(latitudeSalva) && Number.isFinite(longitudeSalva)) {
        definirDestinoNoMapa(latitudeSalva, longitudeSalva, false);
    }

    mapaDestino.on('click', function (evento) {
        definirDestinoNoMapa(evento.latlng.lat, evento.latlng.lng);
    });

    function atualizarMarcadorPelosCampos() {
        const latitude = Number(latitudeInput.value);
        const longitude = Number(longitudeInput.value);
        if (Number.isFinite(latitude) && Number.isFinite(longitude)) {
            definirDestinoNoMapa(latitude, longitude, false);
        }
    }

    latitudeInput.addEventListener('change', atualizarMarcadorPelosCampos);
    longitudeInput.addEventListener('change', atualizarMarcadorPelosCampos);
</script>

</body>
</html>
