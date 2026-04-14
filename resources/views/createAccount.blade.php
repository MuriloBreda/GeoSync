<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - GeoSync</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            height: 100vh;
            background: url('/img/imagemFundo.png') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(11, 31, 54, 0.7);
        }

        .container {
            z-index: 1;
        }

        .card {
            background: #fff;
            width: 550px;
            height: 550px;
            padding: 20px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0,0,0,0.4);

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card h1 {
            color: #1C3F6E;
            font-size: 22px;
        }

        .card h2 {
            font-size: 16px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            text-align: left;
        }

        .full {
            grid-column: span 2;
        }

        label {
            font-size: 11px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        input:focus {
            outline: none;
            border: 1px solid #2F6FB2;
        }

        button {
            grid-column: span 2;
            padding: 12px;
            font-size: 14px;
            background: #1C3F6E;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #2F6FB2;
        }

        .btn-login {
            display: block;
            margin-top: 5px;
            padding: 10px;
            background: #0B1F36;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 11px;
        }

        .btn-login:hover {
            background: #2F6FB2;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card">

        <h1>Tela de Cadastro</h1>

        <img src="{{ asset('img/Logo.png') }}" alt="Logo GeoSync" style="width: 100px; margin: auto">

        <form action="/login" method="GET">

            <div class="full">
                <label>Nome</label>
                <input type="text" name="nome" placeholder="Seu nome" required>
            </div>

            <div class="full">
                <label>Email</label>
                <input type="email" name="email" placeholder="Seu email" required>
            </div>

            <div>
                <label>Usuário</label>
                <input type="text" name="usuario" placeholder="Usuário" required>
            </div>

            <div>
                <label>Senha</label>
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <div class="full">
                <label>Confirmar</label>
                <input type="password" name="confirmar" placeholder="Confirmar senha" required>
            </div>

            <button type="submit">Cadastrar</button>

        </form>

        <span style="margin: 5px">Já tem conta?</span>
        <a href="/login" class="btn-login">Entrar</a>

    </div>
</div>

</body>
</html>