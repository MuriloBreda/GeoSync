<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>GeoSync - Chat I.A</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --azul-institucional: #1C3F6E;
            --azul-tech: #2F6FB2;
            --azul-profundo: #0B1F36;
            --azul-claro: #E6EEF8;
            --azul-cinza: #7B92AD;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--azul-profundo);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Topo / Header */
        .header {
            padding: 16px 24px;
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            z-index: 10;
        }

        .logo {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--azul-institucional);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .logo img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #10b981;
            font-weight: 600;
            background: #e6fbf4;
            padding: 6px 14px;
            border-radius: 30px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
        }

        /* Área Principal de Mensagens */
        .chat {
            flex: 1;
            overflow-y: auto;
            padding: 30px 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: #fdfdfd;
        }

        /* Customização da Scrollbar */
        .chat::-webkit-scrollbar {
            width: 6px;
        }
        .chat::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Balões de Mensagem */
        .msg {
            max-width: 70%;
            display: flex;
            flex-direction: column;
            animation: fadin 0.25s ease-out;
        }

        @keyframes fadin {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mensagem do Usuário (Direita) */
        .me {
            align-self: flex-end;
        }

        .me .bubble {
            background: var(--azul-institucional);
            color: #ffffff;
            border-radius: 18px 18px 4px 18px;
            box-shadow: 0 4px 12px rgba(28, 63, 110, 0.15);
        }

        /* Mensagem da IA (Esquerda) */
        .other {
            align-self: flex-start;
        }

        .other .bubble {
            background: #ffffff;
            color: #111827;
            border-radius: 18px 18px 18px 4px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .bubble {
            padding: 14px 20px;
            font-size: 0.95rem;
            line-height: 1.6;
            white-space: pre-line;
            word-break: break-word;
        }

        .bot-name {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            color: var(--azul-tech);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .meta {
            margin-top: 6px;
            font-size: 0.75rem;
            color: #9ca3af;
            padding: 0 6px;
        }

        .me .meta {
            text-align: right;
        }

        /* Rodapé com Campo de Texto */
        .footer-area {
            background: #ffffff;
            border-top: 1px solid var(--border);
            padding: 20px 24px;
            display: flex;
            justify-content: center;
        }

        .input-container {
            width: 100%;
            max-width: 900px;
            display: flex;
            align-items: center;
            background: #f3f4f6;
            border: 1px solid transparent;
            border-radius: 30px;
            padding: 6px 6px 6px 20px;
            transition: all 0.2s ease;
        }

        .input-container:focus-within {
            background: #ffffff;
            border-color: var(--azul-tech);
            box-shadow: 0 0 0 4px rgba(47, 111, 178, 0.1);
        }

        .input-container input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.95rem;
            color: #111827;
            padding: 10px 0;
            font-family: inherit;
        }

        .input-container input::placeholder {
            color: #9ca3af;
        }

        .input-container button {
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 50%;
            background: var(--azul-institucional);
            color: #ffffff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.1s;
        }

        .input-container button:hover {
            background: var(--azul-tech);
            transform: scale(1.03);
        }

        .input-container button i {
            font-size: 1rem;
            margin-left: 2px; /* Ajuste óptico do ícone de envio */
        }

        /* Responsividade Básica */
        @media (max-width: 768px) {
            .msg {
                max-width: 85%;
            }
            .chat {
                padding: 20px 16px;
            }
            .footer-area {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="/" class="logo">
            <img src="{{ asset('img/Logo.png') }}" alt="GeoSync">
            <span>GeoSync Chat</span>
        </a>
        <div class="status-badge">
            <div class="status-dot"></div>
            Ativo
        </div>
    </div>

    <div id="chat" class="chat">
        @if(session('chat'))
            @foreach(session('chat') as $msg)
                <div class="msg {{ $msg['type'] }}">
                    <div class="bubble">
                        @if($msg['type'] == 'other')
                            <span class="bot-name"><i class="fas fa-robot"></i> GeoSync I.A</span>
                        @endif
                        {{ $msg['text'] }}
                    </div>
                    <div class="meta">
                        {{ $msg['time'] }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="msg other">
                <div class="bubble">
                    <span class="bot-name"><i class="fas fa-robot"></i> GeoSync I.A</span>
                    Olá! Sou a inteligência artificial do GeoSync. Como posso ajudar no desenvolvimento ou análise do seu TCC hoje?
                </div>
            </div>
        @endif
    </div>

    <div class="footer-area">
        <form action="{{ route('chat.enviar') }}" method="POST" class="input-container">
            @csrf
            <input
                type="text"
                name="mensagem"
                id="mensagem"
                placeholder="Escreva a sua mensagem aqui..."
                autocomplete="off"
                required
            >
            <button type="submit" title="Enviar Mensagem">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>

    <script>
        window.onload = function() {
            const chat = document.getElementById('chat');
            chat.scrollTop = chat.scrollHeight;
            document.getElementById('mensagem').focus();
        };
    </script>

</body>
</html>