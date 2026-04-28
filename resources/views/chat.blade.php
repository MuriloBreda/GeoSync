<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Central Logística</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --bg:#f5f7fb;
    --primary:#3b82f6;
    --border:#e5e7eb;
    --muted:#6b7280;
}
body{margin:0;font-family:Segoe UI;background:var(--bg);}
.app{height:100vh;display:flex;flex-direction:column;}

.header{
    padding:12px;
    background:#fff;
    border-bottom:1px solid var(--border);
    display:flex;justify-content:space-between;
}

.chat{flex:1;overflow:auto;padding:10px;display:flex;flex-direction:column;gap:10px;}

.msg{max-width:75%;}
.me{align-self:flex-end;}
.other{align-self:flex-start;}

.bubble{
    padding:10px;
    border-radius:14px;
    background:#fff;
}
.me .bubble{background:var(--primary);color:#fff;}

.input-area{display:flex;padding:10px;background:#fff;border-top:1px solid var(--border);}
input{flex:1;padding:10px;border-radius:20px;border:none;background:#f1f5f9;}
button{margin-left:5px;border:none;background:var(--primary);color:#fff;border-radius:50%;width:40px;}

.meta{font-size:10px;color:var(--muted);}
</style>
</head>

<body>

<div class="app">

<div class="header">
<strong>🚚 Central Logística</strong>
</div>

<div id="chat" class="chat"></div>

<div class="input-area">
<input id="input" placeholder="Ex: pedido 123">
<button onclick="send()">➤</button>
</div>

</div>

<script>

// =======================
// BANCO SIMULADO
// =======================
let db = JSON.parse(localStorage.getItem("logisticaDB")) || {
    pedidos:{
        "123":{status:"Em rota", motorista:"Carlos", carga:"Alimentos"},
        "456":{status:"Aguardando coleta", motorista:"João", carga:"Eletrônicos"}
    },
    atual:null
};

// =======================
// CHAT STORAGE
// =======================
function saveChat(){
    localStorage.setItem("chat", chat.innerHTML);
    localStorage.setItem("logisticaDB", JSON.stringify(db));
}

function loadChat(){
    chat.innerHTML = localStorage.getItem("chat") || "";
}

// =======================
// UI
// =======================
function time(){
    let d=new Date();
    return d.getHours()+":"+d.getMinutes();
}

function add(text,type){
    let msg=document.createElement("div");
    msg.className="msg "+type;

    let bubble=document.createElement("div");
    bubble.className="bubble";
    bubble.innerText=text;

    let meta=document.createElement("div");
    meta.className="meta";
    meta.innerText=time();

    msg.appendChild(bubble);
    msg.appendChild(meta);

    chat.appendChild(msg);
    chat.scrollTop=chat.scrollHeight;

    saveChat();
}

// =======================
// LÓGICA LOGÍSTICA
// =======================
function sistema(msg){

    msg = msg.toLowerCase();

    // selecionar pedido
    if(msg.startsWith("pedido")){
        let id = msg.split(" ")[1];

        if(db.pedidos[id]){
            db.atual = id;
            let p = db.pedidos[id];
            return `Pedido ${id}\nStatus: ${p.status}\nMotorista: ${p.motorista}\nCarga: ${p.carga}`;
        }
        return "Pedido não encontrado.";
    }

    // status
    if(msg.includes("status")){
        if(!db.atual) return "Informe o número do pedido.";
        return "Status atual: "+db.pedidos[db.atual].status;
    }

    // atualizar status
    if(msg.startsWith("atualizar")){
        if(!db.atual) return "Selecione um pedido primeiro.";

        let novo = msg.replace("atualizar ","");
        db.pedidos[db.atual].status = novo;

        return "Status atualizado para: "+novo;
    }

    // chegou
    if(msg.includes("cheguei")){
        return "Local confirmado. Iniciar operação.";
    }

    // problema
    if(msg.includes("problema")){
        return "Ocorrência registrada. Central irá analisar.";
    }

    return "Comando não reconhecido.";
}

// =======================
// SEND
// =======================
function send(){
    let text=input.value.trim();
    if(!text) return;

    add(text,"me");
    input.value="";

    setTimeout(()=>{
        add(sistema(text),"other");
    },500);
}

// ENTER
input.addEventListener("keydown",e=>{
    if(e.key==="Enter") send();
});

// INIT
window.onload=()=>{
    loadChat();
    input.focus();
}

</script>

</body>
</html>