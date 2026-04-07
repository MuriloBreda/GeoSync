<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - GeoSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    height: 100vh;
    background: url('{{ asset('img/imagemFundo.png') }}') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

/* overlay escuro */
body::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(11, 31, 54, 0.7);
}

/* centralizar */
.container {
    z-index: 1;
}

/* CARD QUADRADO */
.card {
    background: #fff;
    width: 550px;   /* aumentou mais */
    height: 550px;  /* mantém quadrado */
    padding: 20px;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 12px 30px rgba(0,0,0,0.4);

    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* TITULOS */
.card h1 {
    color: #1C3F6E;
    font-size: 18px;
}

.card h2 {
    font-size: 14px;
}

/* FORM GRID */
form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px;
    text-align: left;
}

/* ocupa linha inteira */
.full {
    grid-column: span 2;
}

/* labels */
label {
    font-size: 10px;
}

/* inputs */
input {
    width: 100%;
    padding: 6px;
    font-size: 11px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* foco */
input:focus {
    outline: none;
    border: 1px solid #2F6FB2;
}

/* botão */
button {
    grid-column: span 2;
    padding: 8px;
    font-size: 12px;
    background: #1C3F6E;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #2F6FB2;
}

/* texto */
span {
    font-size: 11px;
}

/* botão login */
.btn-login {
    display: block;
    margin-top: 5px;
    padding: 10px;
    background: #0B1F36;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 11px;
    transition: 0.3s;
}

.btn-login:hover {
    background: #2F6FB2;
}

input {
    padding: 10px;
    font-size: 13px;
}

label {
    font-size: 11px;
}

button {
    padding: 12px;
    font-size: 14px;
}

.card h1 {
    font-size: 22px;
}

.card h2 {
    font-size: 16px;
}
</style>
<body>

<div class="container">
    <div class="card">

        <h1>Tela de Cadastro</h1>
        <img src="{{ asset('img/Logo.png') }}" alt="Logo GeoSync" class="logo" style="width: 100px; margin: auto">
        {{-- <h2>Tela de Cadastro</h2> --}}

        <form>
            <!-- LINHA COMPLETA -->
            <div class="full">
                <label>Nome</label>
                <input type="text" placeholder="Seu nome" required>
            </div>

            <div class="full">
                <label>Email</label>
                <input type="email" placeholder="Seu email" required>
            </div>

            <!-- 2 COLUNAS -->
            <div>
                <label>Usuário</label>
                <input type="text" placeholder="Usuário" required>
            </div>

            <div>
                <label>Senha</label required>
                <input type="password" placeholder="Senha">
            </div>

            <!-- LINHA COMPLETA -->
            <div class="full">
                <label>Confirmar</label required>
                <input type="password" placeholder="Confirmar senha">
            </div>

            <!-- BOTÃO -->
            <button type="submit">Cadastrar</button>
        </form>

        <span style="margin: 5px">Já tem conta?</span>
        <a href=lo"" class="btn-login">Entrar</a>

    </div>
</div>
z
</body>
</html>