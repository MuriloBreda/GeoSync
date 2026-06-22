<!DOCTYPE html>

<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>GeoSync - Chat</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --bg:#f5f7fb;
    --primary:#3b82f6;
    --border:#e5e7eb;
    --muted:#6b7280;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:var(--bg);
}

.app{
    height:100vh;
    display:flex;
    flex-direction:column;
}

.header{
    padding:12px 20px;
    background:#fff;
    border-bottom:1px solid var(--border);
    display:flex;
    align-items:center;
}

.logo{
    text-decoration:none;
    display:flex;
    align-items:center;
    gap:12px;
    color:#111827;
    font-weight:600;
}

.chat{
    flex:1;
    overflow-y:auto;
    padding:20px;
    display:flex;
    flex-direction:column;
    gap:12px;
}

.msg{
    max-width:75%;
}

.me{
    align-self:flex-end;
}

.other{
    align-self:flex-start;
}

.bubble{
    padding:12px 15px;
    border-radius:15px;
    white-space:pre-line;
    word-break:break-word;
    background:#fff;
    box-shadow:0 2px 6px rgba(0,0,0,.05);
}

.me .bubble{
    background:var(--primary);
    color:#fff;
}

.meta{
    margin-top:4px;
    font-size:11px;
    color:var(--muted);
}

.me .meta{
    text-align:right;
}

.input-area{
    display:flex;
    gap:10px;
    padding:15px;
    background:#fff;
    border-top:1px solid var(--border);
}

.input-area input{
    flex:1;
    border:none;
    background:#f1f5f9;
    padding:12px 16px;
    border-radius:25px;
    outline:none;
}

.input-area button{
    width:45px;
    height:45px;
    border:none;
    border-radius:50%;
    background:var(--primary);
    color:#fff;
    cursor:pointer;
    font-size:18px;
}

.input-area button:hover{
    opacity:.9;
}
</style>

</head>

<body>

<div class="app">

<div class="header">
    <a href="/" class="logo">
        <img src="{{ asset('img/Logo.png') }}"
             alt="GeoSync"
             style="width:65px;">
        <span>GeoSync I.A</span>
    </a>
</div>

<div id="chat" class="chat">

    @if(session('chat'))

        @foreach(session('chat') as $msg)

            <div class="msg {{ $msg['type'] }}">

                <div class="bubble">

                    @if($msg['type'] == 'other')
                        <strong>GeoSync I.A</strong>

                        <br><br>
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
                <strong>GeoSync I.A</strong>

                <br><br>

                Olá! Sou a GeoSync I.A.
                Como posso ajudar você hoje?
            </div>
        </div>

    @endif

</div>

<form action="{{ route('chat.enviar') }}"
      method="POST"
      class="input-area">

    @csrf

    <input
        type="text"
        name="mensagem"
        id="mensagem"
        placeholder="Digite sua mensagem..."
        autocomplete="off"
        required
    >

    <button type="submit">
        ➤
    </button>

</form>

</div>

<script>

window.onload = function()
{
    const chat = document.getElementById('chat');

    chat.scrollTop = chat.scrollHeight;

    document.getElementById('mensagem').focus();
};

</script>

</body>
</html>


    

</div>

{{-- <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>

<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>

<script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
</script> --}}


</body>
</html>