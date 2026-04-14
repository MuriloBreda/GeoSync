<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Chat Operacional</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

<style>
:root{
    --bg:#f5f7fb;
    --primary:#3b82f6;
    --border:#e5e7eb;
    --muted:#6b7280;
}

*{box-sizing:border-box;}

body{
    margin:0;
    font-family:-apple-system,"Segoe UI",Roboto;
    background:var(--bg);
}

/* APP */
.app{
    height:100dvh;
    display:flex;
    flex-direction:column;
}

/* HEADER */
.header{
    padding:12px;
    padding-top:calc(12px + env(safe-area-inset-top));
    border-bottom:1px solid var(--border);
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:#fff;
}

/* LEFT */
.left{
    display:flex;
    align-items:center;
    gap:10px;
}

.avatar{
    width:36px;
    height:36px;
    border-radius:50%;
    background:linear-gradient(135deg,#60a5fa,#2563eb);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
}

/* HOME BUTTON */
.home-btn{
    border:none;
    background:#f1f5f9;
    width:38px;
    height:38px;
    border-radius:12px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.2s;
    color:#0f172a;
}

.home-btn:hover{
    background:#e2e8f0;
    transform:translateY(-1px);
}

.home-btn:active{
    transform:scale(0.92);
}

/* CHAT */
.chat{
    flex:1;
    overflow-y:auto;
    padding:15px;
    display:flex;
    flex-direction:column;
    gap:10px;
}

/* MSG */
.msg{
    max-width:75%;
    display:flex;
    flex-direction:column;
    animation:pop .2s ease;
}

@keyframes pop{
    from{opacity:0; transform:translateY(8px);}
    to{opacity:1; transform:translateY(0);}
}

.me{align-self:flex-end; align-items:flex-end;}
.other{align-self:flex-start;}

.bubble{
    padding:10px 14px;
    border-radius:18px;
    font-size:14px;
}

.me .bubble{
    background:var(--primary);
    color:#fff;
    border-bottom-right-radius:6px;
}

.other .bubble{
    background:#fff;
    border:1px solid var(--border);
    border-bottom-left-radius:6px;
}

/* META */
.meta{
    font-size:10px;
    color:var(--muted);
    margin-top:3px;
    display:flex;
    gap:5px;
}

.status.read{
    color:#2563eb;
}

/* INPUT */
.input-area{
    display:flex;
    gap:8px;
    padding:10px;
    border-top:1px solid var(--border);
    background:#fff;
}

.input-box{
    flex:1;
    display:flex;
    background:#f1f5f9;
    border-radius:20px;
    padding:8px 12px;
}

input{
    border:none;
    outline:none;
    flex:1;
    background:transparent;
}

.send{
    width:38px;
    height:38px;
    border-radius:50%;
    background:var(--primary);
    color:#fff;
    border:none;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="app">

<!-- HEADER -->
<div class="header">

    <div class="left">
        <div class="avatar">🚚</div>
        <div>
            <strong>Central Operacional</strong>
            <div style="font-size:11px;color:#6b7280;">Online</div>
        </div>
    </div>

    <!-- HOME BUTTON (SVG PROFISSIONAL) -->
    <button class="home-btn" onclick="goHome()" title="Voltar ao início">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 10.5L12 3l9 7.5"
                stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M5 10v10a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V10"
                stroke="currentColor" stroke-width="2"
                stroke-linecap="round"/>
        </svg>
    </button>

</div>

<!-- CHAT -->
<div id="chat" class="chat"></div>

<!-- INPUT -->
<div class="input-area">
    <div class="input-box">
        <input id="input" placeholder="Mensagem">
    </div>
    <button class="send" onclick="send()">➤</button>
</div>

</div>

<script>

function time(){
    let d=new Date();
    return d.getHours().toString().padStart(2,'0')+":"+
           d.getMinutes().toString().padStart(2,'0');
}

function add(text,type){
    let msg=document.createElement("div");
    msg.className="msg "+type;

    let bubble=document.createElement("div");
    bubble.className="bubble";
    bubble.innerText=text;

    let meta=document.createElement("div");
    meta.className="meta";

    let t=document.createElement("span");
    t.innerText=time();

    let status=document.createElement("span");
    status.className="status";
    status.innerText="🕓";

    meta.appendChild(t);

    if(type==="me") meta.appendChild(status);

    msg.appendChild(bubble);
    msg.appendChild(meta);

    document.getElementById("chat").appendChild(msg);

    let chat=document.getElementById("chat");
    chat.scrollTop=chat.scrollHeight;

    if(type==="me"){
        setTimeout(()=>status.innerText="✓",500);
        setTimeout(()=>status.innerText="✓✓",1000);
        setTimeout(()=>status.classList.add("read"),1600);
    }
}

function bot(msg){
    msg=msg.toLowerCase();

    if(msg.includes("cheguei")) return "Pode iniciar descarga.";
    if(msg.includes("atraso")) return "Informe nova previsão.";

    return "Mensagem recebida.";
}

function send(){
    let i=document.getElementById("input");
    let text=i.value.trim();
    if(!text) return;

    add(text,"me");
    i.value="";

    setTimeout(()=>{
        add(bot(text),"other");
    },700);
}

document.getElementById("input")
.addEventListener("keydown",e=>{
    if(e.key==="Enter"){
        e.preventDefault();
        send();
    }
});

function goHome(){
    document.getElementById("chat").scrollTo({
        top:0,
        behavior:"smooth"
    });
}

</script>

</body>
</html>