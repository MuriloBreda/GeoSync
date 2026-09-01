<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync | Criar Conta</title>

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

        .register-wrapper {
            width: min(1140px, 100%);
            min-height: 720px;
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
            font-size: clamp(32px, 3.8vw, 44px);
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
            margin-top: 32px;
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

        /* PAINEL DO FORMULÁRIO */
        .form-panel {
            padding: 48px;
            display: flex;
            align-items: center;
            background: var(--branco);
            overflow-y: auto;
        }

        .form-content {
            width: 100%;
            max-width: 480px;
            margin: auto;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--texto-secundario);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 20px;
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

        .mobile-logo {
            display: none;
        }

        .form-header {
            margin-bottom: 24px;
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
            font-size: 28px;
            line-height: 1.2;
            color: var(--azul-institucional);
            margin-bottom: 6px;
            letter-spacing: -0.8px;
            font-weight: 800;
        }

        .form-header p {
            color: var(--texto-secundario);
            font-size: 14px;
            line-height: 1.5;
        }

        /* GRID DO FORMULÁRIO */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field {
            margin-bottom: 0;
        }

        .field.full {
            grid-column: span 2;
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
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s;
            z-index: 1;
        }

        .field input,
        .field select {
            width: 100%;
            height: 46px;
            padding: 0 16px 0 44px;
            border: 1px solid var(--borda-suave);
            border-radius: 10px;
            background: #f8fafc;
            color: var(--texto-principal);
            font-family: inherit;
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s ease;
            appearance: none;
        }

        .field select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%3C%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
        }

        .field input::placeholder {
            color: #94a3b8;
        }

        .field input:hover,
        .field select:hover {
            border-color: var(--borda);
        }

        .field input:focus,
        .field select:focus {
            background: var(--branco);
            border-color: var(--azul-tech);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .field input:focus + .input-icon,
        .field select:focus + .input-icon {
            color: var(--azul-tech);
        }

        .alert {
            grid-column: span 2;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            font-weight: 500;
        }

        .alert.error {
            color: var(--erro);
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert ul {
            margin: 0;
            padding-left: 16px;
        }

        .btn-submit {
            grid-column: span 2;
            height: 48px;
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
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: var(--azul-hover);
            transform: translateY(-1px);
            box-shadow: 0 12px 22px rgba(37, 99, 235, 0.28);
        }

        .register-box {
            grid-column: span 2;
            text-align: center;
            margin-top: 16px;
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
            grid-column: span 2;
            margin-top: 12px;
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
            .register-wrapper {
                grid-template-columns: 1fr;
                max-width: 580px;
                min-height: auto;
            }

            .brand-panel {
                padding: 40px;
            }

            .brand-panel h1 {
                font-size: 32px;
            }

            .form-panel {
                padding: 36px 28px;
            }
        }

        @media (max-width: 580px) {
            body {
                padding: 12px;
            }

            .register-wrapper {
                border-radius: 18px;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                padding: 24px 18px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .field.full,
            .field,
            .btn-submit,
            .alert,
            .register-box,
            .security-note {
                grid-column: span 1;
            }

            .mobile-logo {
                display: block;
                text-align: center;
                margin-bottom: 20px;
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
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="register-wrapper">

    <!-- APRESENTAÇÃO ESQUERDA -->
    <section class="brand-panel">
        <div class="brand-content">
            <div class="logo-container">
                <a href="/" aria-label="Voltar para a página inicial">
                    <img src="{{ asset('img/Logo.png') }}" alt="Logo GeoSync" class="brand-logo">
                </a>
            </div>

            <div class="eyebrow">
                <i class="fas fa-circle"></i>
                Novo Cadastro
            </div>

            <h1>
                Conecte-se à nossa
                <span>rede de logística.</span>
            </h1>

            <p class="description">
                Crie sua conta na GeoSync e tenha acesso completo à nossa plataforma de rastreamento e telemetria inteligente.
            </p>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <span>Ambiente seguro e acesso protegido</span>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Acompanhamento de rotas em tempo real</span>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <span>Suporte técnico especializado</span>
                </div>
            </div>
        </div>

        <div class="brand-footer">
            GeoSync &copy; Monitoramento, rastreamento e telemetria avançada para o transporte rodoviário.
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
                <div class="mini-title">Cadastro de Usuário</div>
                <h2>Crie sua conta</h2>
                <p>Preencha os dados abaixo para iniciar seu cadastro.</p>
            </div>

            <form action="/register" method="POST" id="registerForm" class="form-grid">
                @csrf

                @if($errors->any())
                    <div class="alert error" role="alert">
                        <i class="fas fa-circle-exclamation" style="margin-top: 2px;"></i>
                        <ul>
                            @foreach ($errors->all() as $erro)
                                <li>{{ $erro }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="field full">
                    <label for="name">Nome completo</label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Seu nome completo"
                            required
                        >
                    </div>
                </div>

                <div class="field full">
                    <label for="email">E-mail corporativo</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="seu.email@empresa.com"
                            required
                        >
                    </div>
                </div>

                <div class="field full">
                    <label for="tipo">Tipo de Conta</label>
                    <div class="input-wrap">
                        <i class="fas fa-user-gear input-icon"></i>
                        <select name="tipo" id="tipo" required>
                            <option value="">Selecione o perfil...</option>
                            <option value="cliente" {{ old('tipo') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                            {{-- <option value="motorista" {{ old('tipo') == 'motorista' ? 'selected' : '' }}>Motorista</option> --}}
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="cpf">CPF</label>
                    <div class="input-wrap">
                        <i class="fas fa-id-card input-icon"></i>
                        <input
                            type="text"
                            name="cpf"
                            id="cpf"
                            value="{{ old('cpf') }}"
                            placeholder="000.000.000-00"
                            required
                        >
                    </div>
                </div>

                <div class="field">
                    <label for="telefone">Telefone</label>
                    <div class="input-wrap">
                        <i class="fas fa-phone input-icon"></i>
                        <input
                            type="text"
                            name="telefone"
                            id="telefone"
                            value="{{ old('telefone') }}"
                            placeholder="(00) 00000-0000"
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
                            placeholder="Mínimo 6 caracteres"
                            required
                        >
                    </div>
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmar Senha</label>
                    <div class="input-wrap">
                        <i class="fas fa-shield-halved input-icon"></i>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repita a senha"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i>
                    Finalizar Cadastro
                </button>

                <div class="register-box">
                    Já possui uma conta?
                    <a href="/login">Entrar agora</a>
                </div>

                <div class="security-note">
                    <i class="fas fa-shield-halved"></i>
                    <span>Seus dados estão protegidos sob nossa Política de Privacidade.</span>
                </div>

            </form>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Máscara de CPF
    document.getElementById('cpf').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
        e.target.value = value.substring(0, 14);
    });

    // Máscara de Telefone
    document.getElementById('telefone').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/^(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value.substring(0, 15);
    });
</script>

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Erro no cadastro',
        html: `{!! implode('<br>', $errors->all()) !!}`,
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
        title: 'Erro',
        text: @json(session('error')),
        confirmButtonColor: '#2563eb'
    });
});
</script>
@endif

</body>
</html>