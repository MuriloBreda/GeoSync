<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSync - Assistente Inteligente I.A</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* =========================
           PALETA E VARIÁVEIS
        ========================= */
        :root {
            --azul-institucional: #0f172a;
            --azul-tech: #2563eb;
            --azul-hover: #1d4ed8;
            --azul-profundo: #020617;
            --azul-claro: #eff6ff;
            --texto-principal: #1e293b;
            --texto-secundario: #64748b;
            --borda-suave: #e2e8f0;
            --card-bg: #ffffff;
            --font-scale: 1;
            --shadow-subtle: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            --shadow-card: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: var(--texto-principal);
            overflow-x: hidden;
            position: relative;
            zoom: var(--font-scale);
            transition: zoom 0.2s ease-in-out, background 0.3s, color 0.3s;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* =========================
           LAYOUT BASE
        ========================= */
        .container {
            width: 90%;
            max-width: 1320px;
            margin: auto;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* =========================
           HERO SLIM SECTION
        ========================= */
        .hero-slim {
            padding: 18px 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .hero-left-box {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* BOTÃO VOLTAR REFINADO */
        .btn-voltar {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(8px);
        }

        .btn-voltar:hover {
            background: var(--azul-tech);
            border-color: var(--azul-tech);
            transform: translateX(-3px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            color: #ffffff;
        }

        .hero-title-box h1 {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-title-box p {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #10b981;
            font-weight: 700;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            padding: 6px 14px;
            border-radius: 20px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
        }

        /* =========================
           ÁREA PRINCIPAL DE CHAT
        ========================= */
        .main-chat-wrapper {
            padding: 24px 0;
            flex: 1;
            display: flex;
            align-items: stretch;
        }

        .chat-layout {
            display: grid;
            grid-template-columns: 310px 1fr;
            gap: 24px;
            width: 100%;
            height: calc(100vh - 160px);
            min-height: 560px;
        }

        /* SIDEBAR DE SUGESTÕES */
        .chat-sidebar {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--borda-suave);
            padding: 22px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: var(--shadow-card);
        }

        .sidebar-title {
            font-size: 12px;
            font-weight: 800;
            color: var(--texto-secundario);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .prompt-btn {
            background: #f8fafc;
            border: 1px solid var(--borda-suave);
            border-radius: 12px;
            padding: 14px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 500;
            color: var(--texto-principal);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-family: inherit;
            line-height: 1.4;
        }

        .prompt-btn i {
            color: var(--azul-tech);
            font-size: 15px;
            margin-top: 2px;
            transition: transform 0.2s ease;
        }

        .prompt-btn:hover {
            border-color: var(--azul-tech);
            background: var(--azul-claro);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }

        .prompt-btn:hover i {
            transform: scale(1.15);
        }

        /* CARTÃO DE CHAT */
        .chat-card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--borda-suave);
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        /* HEADER INTERNO DO CHAT */
        .chat-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--borda-suave);
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-ia {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--azul-claro);
            color: var(--azul-tech);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .chat-header-title {
            font-weight: 700;
            font-size: 15px;
            color: var(--texto-principal);
        }

        .chat-header-status {
            font-size: 12px;
            color: #10b981;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        /* CORPO DAS MENSAGENS */
        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: #f8fafc;
        }

        .chat-body::-webkit-scrollbar {
            width: 6px;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* BALÕES DE MENSAGEM */
        .msg {
            max-width: 72%;
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.25s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .me {
            align-self: flex-end;
        }

        .me .bubble {
            background: var(--azul-tech);
            color: #ffffff;
            border-radius: 18px 18px 4px 18px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.2);
        }

        .other {
            align-self: flex-start;
        }

        .other .bubble {
            background: #ffffff;
            color: var(--texto-principal);
            border-radius: 18px 18px 18px 4px;
            border: 1px solid var(--borda-suave);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .bubble {
            padding: 14px 18px;
            font-size: 14px;
            line-height: 1.6;
            white-space: pre-line;
            word-break: break-word;
        }

        .bot-name {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 800;
            color: var(--azul-tech);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .meta {
            margin-top: 6px;
            font-size: 11px;
            color: var(--texto-secundario);
            padding: 0 4px;
        }

        .me .meta {
            text-align: right;
        }

        /* ANIMAÇÃO TYPING */
        .typing-indicator {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 0;
        }

        .typing-indicator span {
            width: 6px;
            height: 6px;
            background-color: var(--azul-tech);
            border-radius: 50%;
            display: inline-block;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
        .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0.3); opacity: 0.3; }
            40% { transform: scale(1); opacity: 1; }
        }

        /* ENVIAR MENSAGEM */
        .chat-footer {
            background: #ffffff;
            border-top: 1px solid var(--borda-suave);
            padding: 18px 24px;
        }

        .input-container {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1px solid var(--borda-suave);
            border-radius: 14px;
            padding: 4px 6px 4px 18px;
            transition: all 0.2s ease;
        }

        .input-container:focus-within {
            background: #ffffff;
            border-color: var(--azul-tech);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .input-container input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            color: var(--texto-principal);
            padding: 10px 0;
            font-family: inherit;
        }

        .input-container button {
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 10px;
            background: var(--azul-tech);
            color: #ffffff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .input-container button:hover {
            background: var(--azul-hover);
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        /* MODO ESCURO COMPATÍVEL */
        .dark-mode { background: #090d16 !important; color: #e2e8f0 !important; }
        .dark-mode .chat-card, .dark-mode .chat-sidebar { background: #0f172a !important; border-color: #1e293b !important; }
        .dark-mode .chat-header { background: #0f172a !important; border-color: #1e293b !important; }
        .dark-mode .chat-header-title { color: #f8fafc !important; }
        .dark-mode .chat-body { background: #0b1120 !important; }
        .dark-mode .other .bubble { background: #1e293b !important; color: #f8fafc !important; border-color: #334155 !important; }
        .dark-mode .chat-footer { background: #0f172a !important; border-color: #1e293b !important; }
        .dark-mode .input-container { background: #1e293b !important; border-color: #334155 !important; }
        .dark-mode .input-container input { color: #ffffff !important; }
        .dark-mode .prompt-btn { background: #1e293b !important; border-color: #334155 !important; color: #cbd5e1 !important; }

        /* RESPONSIVIDADE */
        @media (max-width: 992px) {
            .chat-layout { grid-template-columns: 1fr; height: auto; }
            .chat-sidebar { display: none; }
            .chat-card { height: 550px; }
        }

        @media (max-width: 768px) {
            .msg { max-width: 88%; }
            .hero-left-box { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
    </style>
</head>

<body>

    <!-- HERO SLIM BAR -->
    <header class="hero-slim">
        <div class="container flex">
            <div class="hero-left-box">
                <!-- BOTÃO VOLTAR -->
                <button type="button" onclick="voltarPaginaAnterior()" class="btn-voltar">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Voltar</span>
                </button>

                <div class="hero-title-box">
                    <h1><i class="fa-solid fa-robot" style="color: var(--azul-tech);"></i> Assistente I.A GeoSync</h1>
                    <p>Suporte inteligente para dúvidas técnicas, análise de frota e auxílio no projeto.</p>
                </div>
            </div>

            <div class="status-badge">
                <div class="status-dot"></div>
                Sistema Operacional
            </div>
        </div>
    </header>

    <!-- MAIN CHAT SECTION -->
    <div class="main-chat-wrapper">
        <div class="container">
            <div class="chat-layout">

                <!-- SIDEBAR COM PERGUNTAS RÁPIDAS -->
                <aside class="chat-sidebar">
                    <div class="sidebar-title">
                        <i class="fa-solid fa-bolt" style="color: var(--azul-tech);"></i> Atalhos Rápidos
                    </div>

                    <button class="prompt-btn" onclick="preencherEEnviar('Como funciona o rastreamento em tempo real do GeoSync?')">
                        <i class="fa-regular fa-compass"></i>
                        <span>Como funciona o rastreamento em tempo real?</span>
                    </button>

                    <button class="prompt-btn" onclick="preencherEEnviar('Quais são as vantagens dos planos Start e Pro?')">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Quais as vantagens dos planos Start e Pro?</span>
                    </button>

                    <button class="prompt-btn" onclick="preencherEEnviar('Como a telemetria pode reduzir custos da minha frota?')">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Como a telemetria reduz custos operacionais?</span>
                    </button>

                    <button class="prompt-btn" onclick="preencherEEnviar('Pode me ajudar com ideias de documentação para o TCC?')">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Ajuda com documentação e estrutura TCC</span>
                    </button>
                </aside>

                <!-- CARTÃO DO CHAT -->
                <main class="chat-card">

                    <!-- HEADER INTERNO -->
                    <div class="chat-header">
                        <div class="chat-header-info">
                            <div class="avatar-ia">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div>
                                <div class="chat-header-title">GeoSync I.A</div>
                                <div class="chat-header-status">
                                    <span class="status-dot"></span> Online agora
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="chat" class="chat-body">
                        <!-- Mensagem Padrão Fixa de Boas-Vindas -->
                        <div class="msg other">
                            <div class="bubble">
                                <span class="bot-name"><i class="fas fa-robot"></i> GeoSync I.A</span>
                                <span class="msg-content">Olá! Sou a inteligência artificial da GeoSync. Como posso ajudar no desenvolvimento, gestão de frota ou dúvidas técnicas hoje?</span>
                            </div>
                            <div class="meta js-time"></div>
                        </div>

                        <!-- Histórico do Chat vindo da Sessão (Laravel) -->
                        @if(session('chat'))
                            @foreach(session('chat') as $msg)
                                <div class="msg {{ $msg['type'] }}">
                                    <div class="bubble">
                                        @if($msg['type'] == 'other')
                                            <span class="bot-name"><i class="fas fa-robot"></i> GeoSync I.A</span>
                                        @endif
                                        <span class="msg-content">{{ $msg['text'] }}</span>
                                    </div>
                                    <div class="meta js-time">
                                        {{ $msg['time'] ?? '' }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- FOOTER / INPUT DE TEXTO -->
                    <div class="chat-footer">
                        <form id="chatForm" action="{{ route('chat.enviar') }}" method="POST" class="input-container">
                            @csrf
                            <input
                                type="text"
                                name="mensagem"
                                id="mensagem"
                                placeholder="Digite sua mensagem aqui..."
                                autocomplete="off"
                                required
                            >
                            <button type="submit" id="btnEnviar" title="Enviar Mensagem">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </main>

            </div>
        </div>
    </div>

    <!-- SCRIPTS DE INTERAÇÃO -->
    <script>
        function voltarPaginaAnterior() {
            if (document.referrer && document.referrer !== window.location.href) {
                window.location.href = document.referrer;
            } else {
                window.history.back();
            }
        }

        function getLocalTime() {
            return new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        }

        function escapeHtml(str) {
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        function preencherEEnviar(texto) {
            const input = document.getElementById('mensagem');
            const form = document.getElementById('chatForm');
            input.value = texto;
            form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
        }

        window.onload = function() {
            const chat = document.getElementById('chat');
            const form = document.getElementById('chatForm');
            const input = document.getElementById('mensagem');
            const btnEnviar = document.getElementById('btnEnviar');

            chat.scrollTop = chat.scrollHeight;
            input.focus();

            document.querySelectorAll('.js-time').forEach(el => {
                if (!el.textContent.trim()) {
                    el.textContent = getLocalTime();
                }
            });

            // SUBMIT DO FORMULÁRIO
            form.addEventListener('submit', function() {
                const text = input.value.trim();
                if (!text) return;

                const timeNow = getLocalTime();

                const userHtml = `
                    <div class="msg me">
                        <div class="bubble">${escapeHtml(text)}</div>
                        <div class="meta">${timeNow}</div>
                    </div>
                `;
                chat.insertAdjacentHTML('beforeend', userHtml);

                const loadingHtml = `
                    <div class="msg other" id="loading-indicator">
                        <div class="bubble">
                            <span class="bot-name"><i class="fas fa-robot"></i> GeoSync I.A</span>
                            <div class="typing-indicator">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                        <div class="meta">${timeNow}</div>
                    </div>
                `;
                chat.insertAdjacentHTML('beforeend', loadingHtml);

                input.readOnly = true;
                btnEnviar.disabled = true;
                btnEnviar.style.opacity = '0.5';

                chat.scrollTop = chat.scrollHeight;
            });
        };
    </script>

</body>
</html>