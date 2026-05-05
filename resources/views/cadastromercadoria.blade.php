<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>GeoSync - Nova Remessa</title>

    <style>
        :root {
            --azul-institucional:#1C3F6E;
            --azul-tech:#2F6FB2;
            --azul-profundo:#0B1F36;
            --azul-claro:#E6EEF8;
            --azul-cinza:#7B92AD;
        }

        * {
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body {
            background:linear-gradient(180deg,#f5f7fb,#eef3f9);
        }

        /* NAVBAR */
        .navbar {
            background:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            border-bottom:1px solid #eee;
        }

        .logo {
            font-size:22px;
            font-weight:bold;
            color:var(--azul-institucional);
        }

        .menu a {
            margin-left:20px;
            text-decoration:none;
            color:var(--azul-institucional);
            font-weight:500;
            position:relative;
        }

        .menu a::after {
            content:"";
            position:absolute;
            width:0%;
            height:2px;
            bottom:-4px;
            left:0;
            background:var(--azul-tech);
            transition:0.3s;
        }

        .menu a:hover::after {
            width:100%;
        }

        /* CONTAINER */
        .container {
            width:90%;
            max-width:900px;
            margin:40px auto;
        }

        /* CARD */
        .card {
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 8px 20px rgba(0,0,0,0.05);
            border:1px solid #eef1f5;
        }

        /* TITULOS */
        h2 {
            color:var(--azul-institucional);
            font-size:28px;
            margin-bottom:5px;
        }

        .subtitle {
            color:var(--azul-cinza);
            margin-bottom:25px;
            font-size:14px;
        }

        .section {
            margin-bottom:25px;
            padding-bottom:15px;
            border-bottom:1px solid #eee;
        }

        .section h3 {
            font-size:16px;
            margin-bottom:10px;
            color:var(--azul-tech);
        }

        /* GRID */
        .form-grid {
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:15px;
        }

        .full {
            grid-column:1 / -1;
        }

        /* INPUTS */
        .form-group {
            display:flex;
            flex-direction:column;
        }

        label {
            font-weight:600;
            margin-bottom:5px;
            color:var(--azul-institucional);
        }

        input, select {
            padding:14px;
            border-radius:10px;
            border:1px solid #ddd;
            background:#f9fbff;
            transition:0.3s;
        }

        input::placeholder, select::placeholder {
            color:#aaa;
        }

        input:focus, select:focus {
            outline:none;
            border-color:var(--azul-tech);
            background:white;
            box-shadow:0 0 5px rgba(47,111,178,0.2);
        }

        /* BOTÃO */
        button {
            width:100%;
            margin-top:20px;
            background:var(--azul-tech);
            color:white;
            border:none;
            padding:14px;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
            font-weight:600;
            letter-spacing:0.5px;
            box-shadow:0 4px 10px rgba(47,111,178,0.3);
            transition:0.3s;
        }

        button:hover {
            background:#1d4f85;
            transform:translateY(-1px);
        }

        /* ALERTAS */
        .alert {
            padding:12px;
            border-radius:6px;
            margin-bottom:15px;
        }

        .success {
            background:#d4edda;
            color:#155724;
            border-left:5px solid #28a745;
        }

        .error {
            background:#f8d7da;
            color:#721c24;
            border-left:5px solid #dc3545;
        }

        /* RESPONSIVO */
        @media(max-width:700px) {
            .form-grid {
                grid-template-columns:1fr;
            }

            .container {
                width:95%;
            }

            .card {
                padding:20px;
            }

            h2 {
                font-size:22px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo">
            <a href="/" style="text-decoration:none;">GeoSync</a>
        </div>

        <div class="menu">
            <a href="{{ route('remessas.index') }}">Remessas</a>
        </div>
    </div>

    <div class="container">
        <div class="card">

            <h2>Cadastro de Remessa</h2>
            <p class="subtitle">Preencha os dados para registrar uma nova entrega</p>

            {{-- ERROS --}}
            @if($errors->any())
                <div class="alert error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SUCESSO --}}
            @if(session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('remessas.store') }}" method="POST">
                @csrf

                <!-- DADOS -->
                <div class="section">
                    <h3>📦 Dados da Remessa</h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Código de Rastreio</label>
                            <input type="text" name="codigo_rastreio" value="{{ old('codigo_rastreio') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" required id="status">
                                <option value="">Selecione o status</option>
                                <option value="Em transporte">🚚 Em transporte</option>
                                <option value="Entregue">✅ Entregue</option>
                                <option value="Atrasado">⚠️ Atrasado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- LOGÍSTICA -->
                <div class="section">
                    <h3>🚚 Logística</h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Origem</label>
                            <input type="text" name="origem" value="{{ old('origem') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Destino</label>
                            <input type="text" name="destino" value="{{ old('destino') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tipo de Carga</label>
                            <input type="text" name="tipo_carga" value="{{ old('tipo_carga') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Peso (kg)</label>
                            <input type="number" step="0.01" name="peso" value="{{ old('peso') }}" required>
                        </div>
                    </div>
                </div>

                <!-- ENTREGA -->
                <div class="section">
                    <h3>📅 Entrega</h3>

                    <div class="form-grid">
                        <div class="form-group full">
                            <label>Previsão de Entrega</label>
                            <input type="date" name="previsao_entrega" value="{{ old('previsao_entrega') }}" required>
                        </div>
                    </div>
                </div>

                <button type="submit">Cadastrar Remessa</button>

            </form>
        </div>
    </div>

    <script>
        document.querySelector("form").addEventListener("submit", function(){
            const btn = this.querySelector("button");
            btn.innerText = "Salvando...";
            btn.disabled = true;
        });
    </script>

</body>
</html>