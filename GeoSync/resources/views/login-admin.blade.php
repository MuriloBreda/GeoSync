<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>GeoSync - Login Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body {
            height: 100vh; background: url('/img/imagemFundo.png') no-repeat center center/cover;
            display: flex; justify-content: center; align-items: center; position: relative;
        }
        body::before { content: ""; position: absolute; width: 100%; height: 100%; background: rgba(11, 31, 54, 0.8); }
        .container { z-index: 1; }
        .card {
            background: #fff; width: 450px; padding: 35px; border-radius: 14px; text-align: center;
            box-shadow: 0 12px 30px rgba(0,0,0,0.4); display: flex; flex-direction: column; gap: 20px;
        }
        .card h1 { color: #1C3F6E; font-size: 22px; }
        .badge-admin { background: #ef4444; color: white; font-size: 11px; font-weight: bold; padding: 3px 8px; border-radius: 12px; width: fit-content; margin: -10px auto 0; text-transform: uppercase; }
        form { display: flex; flex-direction: column; gap: 12px; text-align: left; }
        label { font-size: 14px; color: #1C3F6E; font-weight: 600; }
        input { width: 100%; padding: 12px; font-size: 13px; border-radius: 6px; border: 1px solid #ccc; }
        input:focus { outline: none; border: 1px solid #2F6FB2; }
        button { padding: 12px; font-size: 14px; background: #1C3F6E; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        button:hover { background: #2F6FB2; }
        .msg { font-size: 13px; text-align: center; padding: 8px; border-radius: 4px; }
        .erro { color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; }
        .link-cadastro { font-size: 13px; color: #2F6FB2; text-decoration: none; }
        .link-cadastro:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <a href="/"><img src="{{ asset('img/Logo.png') }}" alt="Logo GeoSync" style="width: 150px; margin: 0 auto"></a>
        <h1>Painel de Controle</h1>
        <div class="badge-admin">Módulo Administrativo</div>

        <form action="/login-admin" method="POST">
            @csrf

            <div>
                <label>E-mail Administrativo</label>
                <input type="email" name="email" placeholder="seu.admin@geosync.com" required>
            </div>

            <div>
                <label>Senha</label>
                <input type="password" name="password" placeholder="Sua senha secreta" required>
            </div>

            @if(session('error'))
                <div class="msg erro">{{ session('error') }}</div>
            @endif

            <button type="submit">Acessar Sistema</button>
        </form>

        <a href="/cadastro-admin" class="link-cadastro">Configurar nova conta master</a>
    </div>
</div>

<div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper><div class="vw-plugin-top-wrapper"></div></div>
</div>
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>
</body>
</html>