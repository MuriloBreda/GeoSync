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

body{
    margin:0;
    font-family:Segoe UI;
    background:var(--bg);
}

.app{
    height:100vh;
    display:flex;
    flex-direction:column;
}

.header{
    padding:12px;
    background:#fff;
    border-bottom:1px solid var(--border);
    display:flex;
    justify-content:space-between;
}

.chat{
    flex:1;
    overflow:auto;
    padding:10px;
    display:flex;
    flex-direction:column;
    gap:10px;
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
    padding:10px;
    border-radius:14px;
    background:#fff;
    white-space:pre-line;
}

.me .bubble{
    background:var(--primary);
    color:#fff;
}

.input-area{
    display:flex;
    padding:10px;
    background:#fff;
    border-top:1px solid var(--border);
}

input{
    flex:1;
    padding:10px;
    border-radius:20px;
    border:none;
    background:#f1f5f9;
}

button{
    margin-left:5px;
    border:none;
    background:var(--primary);
    color:#fff;
    border-radius:50%;
    width:40px;
    cursor:pointer;
}

.meta{
    font-size:10px;
    color:var(--muted);
}
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
// BANCO + CONTEXTO
// =======================
let db = JSON.parse(localStorage.getItem("logisticaDB")) || {
    pedidos:{
        "123":{status:"Em rota", motorista:"Carlos", carga:"Alimentos"},
        "456":{status:"Aguardando coleta", motorista:"João", carga:"Eletrônicos"}
    },
    contexto:{
        pedidoAtual:null,
        ultimoComando:null
    }
};

// =======================
// HISTÓRICO
// =======================
let historico = JSON.parse(localStorage.getItem("chat")) || [];

// =======================
// UTIL
// =======================
function time(){
    let d = new Date();
    return d.getHours().toString().padStart(2,"0") + ":" +
           d.getMinutes().toString().padStart(2,"0");
}

// =======================
// RENDER
// =======================
function render(){
    chat.innerHTML = "";

    historico.forEach(m => {
        let msg = document.createElement("div");
        msg.className = "msg " + m.type;

        let bubble = document.createElement("div");
        bubble.className = "bubble";
        bubble.innerText = m.text;

        let meta = document.createElement("div");
        meta.className = "meta";
        meta.innerText = m.time;

        msg.appendChild(bubble);
        msg.appendChild(meta);

        chat.appendChild(msg);
    });

    chat.scrollTop = chat.scrollHeight;
}

// =======================
// ADD MSG
// =======================
function add(text, type){
    historico.push({ text, type, time: time() });

    localStorage.setItem("chat", JSON.stringify(historico));
    localStorage.setItem("logisticaDB", JSON.stringify(db));

    render();
}

// =======================
// COMANDOS
// =======================
const comandos = {

    pedido: (args) => {
        let id = args[0];

        if(db.pedidos[id]){
            db.contexto.pedidoAtual = id;

            let p = db.pedidos[id];

            return `📦 Pedido ${id}
Status: ${p.status}
Motorista: ${p.motorista}
Carga: ${p.carga}`;
        }

        return "❌ Pedido não encontrado.";
    },

    status: () => {
        let id = db.contexto.pedidoAtual;

        if(!id) return "⚠️ Informe o número do pedido.";

        return "📍 Status: " + db.pedidos[id].status;
    },

    atualizar: (args) => {
        let id = db.contexto.pedidoAtual;

        if(!id) return "⚠️ Selecione um pedido primeiro.";

        let novo = args.join(" ");
        db.pedidos[id].status = novo;

        return "✅ Status atualizado para: " + novo;
    },

    motorista: () => {
        let id = db.contexto.pedidoAtual;

        if(!id) return "⚠️ Selecione um pedido.";

        return "🚚 Motorista: " + db.pedidos[id].motorista;
    },

    chegou: () => {
        return "📍 Local confirmado. Iniciar operação.";
    },

    problema: () => {
        return "⚠️ Ocorrência registrada.";
    }

};

// =======================
// PARSER
// =======================
function interpretar(msg){

    msg = msg.toLowerCase().trim();

    // detectar "pedido 123"
    if(msg.match(/pedido\s+\d+/)){
        let id = msg.match(/\d+/)[0];
        return comandos.pedido([id]);
    }

    let partes = msg.split(" ");
    let cmd = partes[0];
    let args = partes.slice(1);

    if(comandos[cmd]){
        return comandos[cmd](args);
    }

    // fallback inteligente
    if(msg.includes("status")) return comandos.status();
    if(msg.includes("motorista")) return comandos.motorista();
    if(msg.includes("problema")) return comandos.problema();
    if(msg.includes("cheguei")) return comandos.chegou();

    return "🤖 Não entendi.\nTente:\n- pedido 123\n- status\n- atualizar entregue";
}

// =======================
// SEND
// =======================
function send(){
    let text = input.value.trim();
    if(!text) return;

    add(text, "me");
    input.value = "";

    setTimeout(() => {
        add(interpretar(text), "other");
    }, 400);
}

// ENTER
input.addEventListener("keydown", e => {
    if(e.key === "Enter") send();
});

// INIT
window.onload = () => {
    render();
    input.focus();
};

</script>

</body>
</html>