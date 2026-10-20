<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync | Acesso à Plataforma</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --azul-institucional: #0f172a;
            --azul-tech: #2563eb;
            --azul-hover: #1d4ed8;
            --azul-profundo: #020617;
            --azul-claro: #eff6ff;
            --texto-principal: #1e293b;
            --texto-secundario: #64748b;
            --borda: #cbd5e1;
            --borda-suave: #e2e8f0;
            --branco: #ffffff;
            --sucesso: #15803d;
            --erro: #dc2626;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            color: var(--texto-principal);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* EFEITOS ILUMINADOS DE FUNDO */
        body::before {
            content: "";
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.12) 0%, rgba(37, 99, 235, 0) 70%);
            top: -200px;
            right: -150px;
            pointer-events: none;
        }

        body::after {
            content: "";
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(15, 23, 42, 0.08) 0%, rgba(15, 23, 42, 0) 70%);
            bottom: -200px;
            left: -150px;
            pointer-events: none;
        }

        .login-wrapper {
            width: min(1140px, 100%);
            min-height: 690px;
            background: var(--branco);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px -10px rgba(15, 23, 42, 0.12);
            border: 1px solid var(--borda-suave);
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            position: relative;
            z-index: 1;
        }

        /* PAINEL ESQUERDO DE APRESENTAÇÃO */
        .brand-panel {
            position: relative;
            padding: 56px;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(145deg, #020617 0%, #0f172a 100%);
            overflow: hidden;
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            right: -180px;
            top: -120px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.45), rgba(37, 99, 235, 0) 70%);
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            left: -160px;
            bottom: -140px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.15), rgba(96, 165, 250, 0) 70%);
        }

        .brand-content,
        .brand-footer {
            position: relative;
            z-index: 2;
        }

        /* LOGO CENTRALIZADA NO PAINEL */
        .logo-container {
            text-align: center;
            width: 100%;
            margin-bottom: 28px;
        }

        .brand-logo {
            width: 88px;
            height: 88px;
            object-fit: contain;
            margin: 0 auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.05);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #60a5fa;
            margin-bottom: 16px;
            background: rgba(37, 99, 235, 0.15);
            padding: 6px 12px;
            border-radius: 20px;
            border: 1px solid rgba(96, 165, 250, 0.2);
        }

        .eyebrow i {
            font-size: 7px;
            color: #60a5fa;
        }

        .brand-panel h1 {
            font-size: clamp(32px, 3.8vw, 48px);
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 18px;
            font-weight: 800;
        }

        .brand-panel h1 span {
            color: #60a5fa;
        }

        .brand-panel .description {
            font-size: 15px;
            line-height: 1.7;
            color: #94a3b8;
            max-width: 460px;
        }

        .features {
            display: grid;
            gap: 14px;
            margin-top: 36px;
        }

        .feature {
            display: flex;
            gap: 14px;
            align-items: center;
            color: #e2e8f0;
            font-size: 14px;
            font-weight: 500;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #60a5fa;
            flex-shrink: 0;
            font-size: 15px;
        }

        .brand-footer {
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }

        /* PAINEL DE FORMULÁRIO DE LOGIN */
        .form-panel {
            padding: 56px;
            display: flex;
            align-items: center;
            background: var(--branco);
        }

        .form-content {
            width: 100%;
            max-width: 440px;
            margin: auto;
        }

        /* BOTÃO VOLTAR À TELA INICIAL */
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--texto-secundario);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 24px;
            padding: 8px 14px;
            border-radius: 8px;
            background: #f1f5f9;
            border: 1px solid var(--borda-suave);
            transition: all 0.2s ease;
            width: fit-content;
        }

        .btn-home:hover {
            color: var(--azul-tech);
            background: var(--azul-claro);
            border-color: rgba(37, 99, 235, 0.2);
            transform: translateX(-3px);
        }

        .btn-home i {
            font-size: 12px;
            transition: transform 0.2s ease;
        }

        .btn-home:hover i {
            transform: translateX(-2px);
        }

        .mobile-logo {
            display: none;
        }

        .form-header {
            margin-bottom: 28px;
        }

        .form-header .mini-title {
            color: var(--azul-tech);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .form-header h2 {
            font-size: 30px;
            line-height: 1.2;
            color: var(--azul-institucional);
            margin-bottom: 8px;
            letter-spacing: -0.8px;
            font-weight: 800;
        }

        .form-header p {
            color: var(--texto-secundario);
            font-size: 14px;
            line-height: 1.6;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
            font-weight: 500;
        }

        .alert.error {
            color: var(--erro);
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert.success {
            color: var(--sucesso);
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .field {
            margin-bottom: 18px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 700;
            color: var(--texto-principal);
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .field input {
            width: 100%;
            height: 48px;
            padding: 0 46px 0 46px;
            border: 1px solid var(--borda-suave);
            border-radius: 10px;
            background: #f8fafc;
            color: var(--texto-principal);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }

        .field input::placeholder {
            color: #94a3b8;
        }

        .field input:hover {
            border-color: var(--borda);
        }

        .field input:focus {
            background: var(--branco);
            border-color: var(--azul-tech);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .field input:focus + .input-icon {
            color: var(--azul-tech);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            padding: 6px;
            font-size: 14px;
            border-radius: 6px;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: var(--azul-tech);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--texto-secundario);
            cursor: pointer;
            user-select: none;
        }

        .remember-me input {
            accent-color: var(--azul-tech);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--azul-tech);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: var(--azul-hover);
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            background: var(--azul-tech);
            color: white;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--azul-hover);
            transform: translateY(-1px);
            box-shadow: 0 12px 22px rgba(37, 99, 235, 0.28);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";
            height: 1px;
            background: var(--borda-suave);
            flex: 1;
        }

        .btn-google {
            width: 100%;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            background: var(--branco);
            color: var(--texto-principal);
            border: 1px solid var(--borda-suave);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-google:hover {
            border-color: var(--borda);
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .btn-google img {
            width: 18px;
            height: 18px;
        }

        .register-box {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: var(--texto-secundario);
        }

        .register-box a {
            color: var(--azul-tech);
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
        }

        .register-box a:hover {
            color: var(--azul-hover);
            text-decoration: underline;
        }

        .security-note {
            margin-top: 24px;
            padding: 10px 14px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid var(--borda-suave);
            color: var(--texto-secundario);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 11px;
            text-align: center;
        }

        .security-note i {
            color: var(--azul-tech);
        }

        /* VLibras */
        [vw-access-button] {
            z-index: 99999 !important;
        }

        /* RESPONSIVIDADE */
        @media (max-width: 960px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                max-width: 580px;
                min-height: auto;
            }

            .brand-panel {
                padding: 40px;
            }

            .brand-panel h1 {
                font-size: 36px;
            }

            .form-panel {
                padding: 40px;
            }
        }

        @media (max-width: 580px) {
            body {
                padding: 12px;
            }

            .login-wrapper {
                border-radius: 18px;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                padding: 28px 20px;
            }

            .mobile-logo {
                display: block;
                text-align: center;
                margin-bottom: 24px;
            }

            .mobile-logo img {
                width: 80px;
                max-height: 80px;
                object-fit: contain;
                margin: 0 auto;
            }

            .form-header {
                text-align: center;
            }

            .form-header h2 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <!-- APRESENTAÇÃO ESQUERDA -->
    <section class="brand-panel">
        <div class="brand-content">
            <!-- LOGO CENTRALIZADA -->
            <div class="logo-container">
                <a href="/" aria-label="Voltar para a página inicial">
                    <img src="{{ asset('img/Logo.png') }}" alt="Logo GeoSync" class="brand-logo">
                </a>
            </div>

            <div class="eyebrow">
                <i class="fas fa-circle"></i>
                Plataforma Inteligente
            </div>

            <h1>
                Gestão logística
                <span>conectada.</span>
            </h1>

            <p class="description">
                Acesse a GeoSync para acompanhar suas operações de transporte,
                cargas, rotas e inteligência logística em tempo real.
            </p>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-location-dot"></i>
                    </div>
                    <span>Rastreamento e localização contínua</span>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <span>Tecnologia IoT integrada à frota</span>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <span>Mais segurança e controle operacional</span>
                </div>
            </div>
        </div>

        <div class="brand-footer">
            GeoSync &copy; Monitoramento, rastreamento e telemetria avançada
            para o transporte rodoviário.
        </div>
    </section>

    <!-- FORMULÁRIO DIREITA -->
    <section class="form-panel">
        <div class="form-content">

            <!-- BOTÃO VOLTAR À TELA INICIAL -->
            <a href="/" class="btn-home" aria-label="Voltar para a página inicial">
                <i class="fas fa-arrow-left"></i>
                <span>Voltar ao início</span>
            </a>

            <!-- LOGO MOBILE CENTRALIZADA -->
            <div class="mobile-logo">
                <a href="/" aria-label="Voltar para a página inicial">
                    <img src="{{ asset('img/Logo.png') }}" alt="Logo GeoSync">
                </a>
            </div>

            <div class="form-header">
                <div class="mini-title">Acesso Restrito</div>
                <h2>Bem-vindo de volta</h2>
                <p>Insira suas credenciais para acessar seu painel.</p>
            </div>

            @if(session('error'))
                <div class="alert error" role="alert">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="alert success" role="alert">
                    <i class="fas fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="/login" method="POST" id="loginForm">
                @csrf

                <div class="field">
                    <label for="email">E-mail corporativo</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="seu.email@empresa.com"
                            autocomplete="email"
                            required
                        >
                    </div>
                </div>

                <div class="field">
                    <label for="password">Senha</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Sua senha de acesso"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Mostrar senha"
                            title="Mostrar senha"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Lembrar-me</span>
                    </label>
                    <a href="/forgot-password" class="forgot-link">Esqueceu a senha?</a>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-right-to-bracket"></i>
                    Entrar na Plataforma
                </button>
            </form>

            <div class="divider">
                <span>ou acesse com</span>
            </div>

            <a href="/auth/google" class="btn-google">
                <img
                    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
                    alt="Google"
                >
                Entrar com o Google
            </a>

            <div class="register-box">
                Ainda não tem conta na GeoSync?
                <a href="/register">Criar conta</a>
            </div>

            <div class="security-note">
                <i class="fas fa-shield-halved"></i>
                <span>Conexão criptografada de ponta a ponta.</span>
            </div>

        </div>
    </section>

</div>

<!-- VLibras -->
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

    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    /* Ocultar / Mostrar Senha */
    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';

        this.innerHTML = isPassword
            ? '<i class="fas fa-eye-slash"></i>'
            : '<i class="fas fa-eye"></i>';

        const label = isPassword ? 'Ocultar senha' : 'Mostrar senha';
        this.setAttribute('aria-label', label);
        this.setAttribute('title', label);
    });

    /* Validação e Alertas do Formulário */
    form.addEventListener('submit', function (e) {
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        if (!email) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Campo obrigatório',
                text: 'Por favor, informe seu e-mail de acesso.',
                confirmButtonText: 'Entendi',
                confirmButtonColor: '#2563eb'
            });
            emailInput.focus();
            return;
        }

        if (!password) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Campo obrigatório',
                text: 'Por favor, informe sua senha.',
                confirmButtonText: 'Entendi',
                confirmButtonColor: '#2563eb'
            });
            passwordInput.focus();
            return;
        }

        e.preventDefault();

        Swal.fire({
            title: 'Autenticando...',
            text: 'Aguarde um momento enquanto validamos seu acesso.',
            timer: 1200,
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                form.submit();
            }
        });
    });

});
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Sessão Iniciada!',
            text: @json(session('success')),
            confirmButtonText: 'Continuar',
            confirmButtonColor: '#2563eb'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Falha na Autenticação',
            text: @json(session('error')),
            confirmButtonText: 'Tentar Novamente',
            confirmButtonColor: '#2563eb'
        });
    });
</script>
@endif

</body>
</html>