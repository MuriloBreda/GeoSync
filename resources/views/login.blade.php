<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync Login</title>
    <link href="{{ asset('css/estiloTelalogin.css') }}" rel="stylesheet">

</head>
<body>
    
    <div class="container">
        <img src="C:\Users\44469307882\Downloads\Captura_de_tela_2026-02-10_080104-removebg-preview.png" alt="Logo GeoSync" class="logo">
        <h1>GeoSync</h1>
        <h2>Bem-vindo ao <span class="destaque">GeoSync</span></h2>
        <p>Faça login para continuar</p>

        <form onsubmit="return validarLogin()">
            
            <label class="label-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                </svg>
                Usuário:
            </label>
            <input type="text" id="usuario">

            <br><br>

            <label class="label-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
            </svg>
                Senha:
            </label>
            <input type="password" id="senha">

            <br><br>

            <button type="submit">Entrar</button>
            <p>não tenho conta</p>
            <button><a href="Tela_senha.html">Criar conta</a></button>
        </form>

        <p id="mensagem"></p>

        <p id="criarConta" style="display: none;">
            <a href="Tela_senha.html">Criar uma nova conta</a>
        </p>
    </div>
    <script src="validacao.js"></script>
</body>
</html>