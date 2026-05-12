<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Remessa</title>

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

        <label>Tipo de Carga</label>
        <input type="text" name="tipo_carga" value="{{ $remessa->tipo_carga }}">

        <label>Peso</label>
        <input type="number" step="0.01" name="peso" value="{{ $remessa->peso }}">

        <label>Previsão de Entrega</label>
        <input type="date" name="previsao_entrega" value="{{ $remessa->previsao_entrega }}">

        <label>Status</label>
        <select name="status">
            <option value="Em transporte" {{ $remessa->status == 'Em transporte' ? 'selected' : '' }}>Em transporte</option>
            <option value="Entregue" {{ $remessa->status == 'Entregue' ? 'selected' : '' }}>Entregue</option>
            <option value="Atrasado" {{ $remessa->status == 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
        </select>

        <div class="actions">
            <button type="submit" class="btn btn-salvar">Salvar Alterações</button>
            <a href="/service" class="btn btn-voltar">
                Voltar
            </a>
        </div>
    </form>
</div>

</body>
</html>