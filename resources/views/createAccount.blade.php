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
            min-height: 100vh;
            background: url('/img/imagemFundo.png') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 20px;
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
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .card {
            background: #fff;
            width: 550px;
            min-height: 550px;
            padding: 20px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0,0,0,0.4);

            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .card h1 {
            color: #1C3F6E;
            font-size: 22px;
        }

        .logo {
            width: 150px;
            margin: 0 auto;
            display: block;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            text-align: left;
            margin-bottom: 10px;
        }

        .full {
            grid-column: span 2;
        }

        label {
            font-size: 14px;
            margin-bottom: 4px;
            display: block;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        select {
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

        select:focus {
            outline: none;
            border: 1px solid #2F6FB2;
        }

        button {
            grid-column: span 2;
            padding: 12px;
            font-size: 15px;
            background: #0f3970;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #2F6FB2;
        }

        .btn-login {
            display: block;
            padding: 12px;
            background: #1342a8;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 15px;
        }

        .btn-login:hover {
            background: #397bc3;
        }

        .errors {
            grid-column: span 2;
            background: #ffe5e5;
            border: 1px solid #ffb3b3;
            color: #cc0000;
            padding: 10px;
            border-radius: 6px;
        }

        .errors ul {
            padding-left: 18px;
        }

        span {
            font-size: 13px;
            color: #333;
        }

        @media (max-width: 768px){

            body{
                padding: 15px;
                align-items: flex-start;
            }

            .container{
                width: 100%;
            }

            .card{
                width: 100%;
                min-height: auto;
                padding: 20px;
            }

            form{
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .full,
            button,
            .errors{
                grid-column: span 1;
            }

            h1{
                font-size: 20px;
            }

            .logo{
                width: 120px;
            }

            input,
            select{
                font-size: 16px;
            }

            button,
            .btn-login{
                width: 100%;
            }

            .errors{
                font-size: 13px;
            }

            span{
                text-align: center;
                display: block;
            }
        }

        #imagemLogo:hover {
            transform: scale(1.05);
            transition: 0.3s;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Tela de Cadastro</h1>

        <a href="/">
            <img src="{{ asset('img/Logo.png') }}" class="logo" alt="Logo GeoSync" id="imagemLogo">
        </a>

        <form action="/register" method="POST">

            @csrf

            @if($errors->any())
                <div class="errors">
                    <ul>
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="full">
                <label>Nome</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Seu nome" required>
            </div>

            <div class="full">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Seu email" required>
            </div>

            <div class="full">
                <label>Tipo de Conta</label>
                <select name="tipo" required>
                    <option value="">Selecione...</option>
                    <option value="cliente" {{ old('tipo') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                    <option value="motorista" {{ old('tipo') == 'motorista' ? 'selected' : '' }}>Motorista</option>
                </select>
            </div>

            <div>
                <label>CPF</label>
                <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" required>
            </div>

            <div>
                <label>Telefone</label>
                <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" required>
            </div>

            <div>
                <label>Senha</label>
                <input type="password" name="password" placeholder="Mínimo 6 caracteres" required>
            </div>

            <div>
                <label>Confirmar</label>
                <input type="password" name="password_confirmation" placeholder="Confirmar senha" required>
            </div>

            <button type="submit">Cadastrar</button>

        </form>

        <span>Já tem conta?</span>

        <a href="/login" class="btn-login">Entrar</a>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Máscara de CPF (000.000.000-00)
    document.getElementById('cpf').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
        e.target.value = value.substring(0, 14);
    });

    // Máscara de Telefone ((00) 00000-0000)
    document.getElementById('telefone').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/^(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value.substring(0, 15);
    });
</script>

@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Erro no cadastro',
    html: `{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Erro',
    text: @json(session('error'))
});
</script>
@endif

</body>
</html>