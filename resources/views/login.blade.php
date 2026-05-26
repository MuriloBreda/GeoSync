<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>GeoSync - Login</title>

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
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 10px
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
            background: #1342a8;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            text-align: center;
        }

        .btn-login:hover {
            background: #2f54b2;
        }

        .msg {
            grid-column: span 2;
            font-size: 12px;
            text-align: center;
        }

        .erro {
            color: red;
        }

        .sucesso {
            color: green;
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

        <h1>Tela de Login</h1>

        <a href="/"><img src="{{ asset('img/Logo.png') }}" alt="Logo GeoSync" style="width: 160px; margin: 5px auto" id="imagemLogo"></a>

        <form action="/login" method="POST">
            @csrf

            <div class="full">
                <label>Email</label>
                <input type="email" name="email" placeholder="Seu email" required>
            </div>

            <div class="full">
                <label>Senha</label>
                <input type="password" name="password" placeholder="Senha" required>
            </div>

            <!-- mensagens -->
            @if(session('error'))
                <div class="msg erro">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="msg sucesso">{{ session('success') }}</div>
            @endif

            <button type="submit">Entrar</button>

        </form>

        <span style="margin: 5px">Não tem conta?</span>
        <a href="/register" class="btn-login">Criar conta</a>

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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {

        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();

        if (!email || !password) {
            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Preencha todos os campos'
            });
        }

    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // bloqueia o aviso padrão do navegador

        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();

        // EMAIL vazio
        if (!email) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo obrigatório',
                text: 'Preencha o email'
            });
            return;
        }

        // SENHA vazia
        if (!password) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo obrigatório',
                text: 'Preencha a senha'
            });
            return;
        }

        // se tudo ok → envia o form
        Swal.fire({
            icon: 'question',
            title: 'Entrando...',
            text: 'Verificando dados',
            timer: 1800,
            showConfirmButton: false,
            willClose: () => {
                form.submit();
            }
        });

    });x

});
</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Bem-vindo!',
    text: @json(session('success'))
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