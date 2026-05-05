<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perfil do Motorista</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter', sans-serif;
    background:#f1f5f9;
    color:#1e293b;
}

/* HEADER */

header{
    background:#0f172a;
    color:white;

    padding:20px 40px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    box-shadow:0 4px 20px rgba(0,0,0,0.08);
}

.logo{
    font-size:24px;
    font-weight:700;
    letter-spacing:0.5px;
}

.menu{
    display:flex;
    gap:25px;
}

.menu a{
    color:#cbd5e1;
    text-decoration:none;
    font-size:14px;
    transition:0.3s ease;
    position:relative;
}

.menu a::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-6px;
    width:0%;
    height:2px;
    background:#3b82f6;
    transition:0.3s;
}

.menu a:hover{
    color:white;
}

.menu a:hover::after{
    width:100%;
}

/* CONTAINER */

.container{
    max-width:1200px;
    margin:40px auto;
    padding:0 20px;
}

/* TOPO */

.topo{
    margin-bottom:30px;
}

.topo h1{
    font-size:38px;
    font-weight:800;
    margin-bottom:10px;
    color:#0f172a;
}

.topo p{
    color:#64748b;
    font-size:15px;
}

/* GRID */

.grid{
    display:grid;
    grid-template-columns:350px 1fr;
    gap:25px;
}

/* CARD PERFIL */

.perfil{
    background:white;
    border-radius:20px;
    padding:30px;

    box-shadow:
    0 10px 30px rgba(0,0,0,0.05);

    transition:0.3s ease;
}

.perfil:hover{
    transform:translateY(-6px);

    box-shadow:
    0 20px 40px rgba(37,99,235,0.10);
}

.foto{
    width:120px;
    height:120px;

    margin:auto;
    margin-bottom:20px;

    border-radius:50%;

    background:#dbeafe;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:45px;
    color:#2563eb;

    transition:0.3s ease;
}

.perfil:hover .foto{
    transform:scale(1.06);
    background:#2563eb;
    color:white;
}

.perfil h2{
    text-align:center;
    margin-bottom:6px;
    font-size:24px;
}

.cargo{
    text-align:center;
    color:#64748b;
    font-size:14px;
    margin-bottom:25px;
}

.status{
    background:#dcfce7;
    color:#166534;

    padding:12px;
    border-radius:12px;

    text-align:center;
    font-size:14px;
    font-weight:600;

    margin-bottom:25px;

    transition:0.3s ease;
}

.status:hover{
    transform:scale(1.02);
}

/* INFO */

.info{
    display:flex;
    flex-direction:column;
    gap:18px;
}

.item{
    display:flex;
    align-items:center;
    gap:14px;

    padding:16px;
    border-radius:14px;

    background:#f8fafc;

    transition:0.3s ease;

    cursor:pointer;
}

.item:hover{
    background:#eff6ff;

    transform:translateX(6px);

    box-shadow:
    0 8px 20px rgba(37,99,235,0.08);
}

.item i{
    width:45px;
    height:45px;

    border-radius:12px;

    background:#dbeafe;
    color:#2563eb;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:16px;

    transition:0.3s ease;
}

.item:hover i{
    background:#2563eb;
    color:white;
}

.item span{
    display:block;
    font-size:13px;
    color:#64748b;
}

.item strong{
    font-size:15px;
    color:#1e293b;
}

/* DIREITA */

.direita{
    display:flex;
    flex-direction:column;
    gap:25px;
}

/* CARDS */

.card{
    background:white;
    border-radius:20px;
    padding:25px;

    box-shadow:
    0 10px 30px rgba(0,0,0,0.05);

    transition:0.3s ease;
}

.card:hover{
    transform:translateY(-5px);

    box-shadow:
    0 20px 40px rgba(37,99,235,0.08);
}

.card-topo{
    display:flex;
    align-items:center;
    justify-content:space-between;

    margin-bottom:20px;
}

.card-topo h3{
    font-size:20px;

    display:flex;
    align-items:center;
    gap:10px;
}

.card-topo i{
    color:#2563eb;
}

/* STATUS VEICULO */

.veiculo{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:18px;
}

.box{
    background:#f8fafc;
    padding:22px;
    border-radius:16px;

    transition:0.3s ease;

    cursor:pointer;
}

.box:hover{
    background:#2563eb;

    transform:translateY(-4px);
}

.box:hover span,
.box:hover strong{
    color:white;
}

.box span{
    font-size:13px;
    color:#64748b;

    transition:0.3s;
}

.box strong{
    display:block;
    margin-top:8px;
    font-size:20px;
    color:#0f172a;

    transition:0.3s;
}

/* TIMELINE */

.timeline{
    display:flex;
    flex-direction:column;
    gap:18px;
}

.timeline-item{
    display:flex;
    gap:15px;
}

.bola{
    width:16px;
    height:16px;
    border-radius:50%;
    background:#2563eb;
    margin-top:5px;

    animation:pulse 2s infinite;
}

@keyframes pulse{
    0%{
        box-shadow:0 0 0 0 rgba(37,99,235,0.4);
    }

    70%{
        box-shadow:0 0 0 12px rgba(37,99,235,0);
    }

    100%{
        box-shadow:0 0 0 0 rgba(37,99,235,0);
    }
}

.timeline-conteudo{
    background:#f8fafc;
    padding:15px;
    border-radius:14px;
    width:100%;

    transition:0.3s ease;
}

.timeline-conteudo:hover{
    background:#eff6ff;

    transform:translateX(5px);
}

.timeline-conteudo strong{
    display:block;
    margin-bottom:5px;
}

.timeline-conteudo p{
    font-size:14px;
    color:#64748b;
}

/* RESPONSIVO */

@media(max-width:950px){

    .grid{
        grid-template-columns:1fr;
    }

    .veiculo{
        grid-template-columns:1fr;
    }

    header{
        flex-direction:column;
        gap:15px;
    }
}

</style>
</head>

<body>

<header>

    <div class="logo">
        GeoSync
    </div>

    <div class="menu">
        <a href="#">Motorista</a>
        <a href="#">Relatórios</a>
    </div>

</header>

<div class="container">

    <div class="topo">

        <h1>
            Perfil do Motorista
        </h1>

        <p>
            Informações completas do motorista e monitoramento operacional em tempo real.
        </p>

    </div>

    <div class="grid">

        <!-- PERFIL -->

        <div class="perfil">

            <div class="foto">
                <i class="fa-solid fa-user"></i>
            </div>

            <h2>Carlos Henrique</h2>

            <div class="cargo">
                Motorista Logístico • Transporte Rodoviário
            </div>

            <div class="status">
                <i class="fa-solid fa-circle-check"></i>
                Motorista em rota
            </div>

            <div class="info">

                <div class="item">

                    <i class="fa-solid fa-id-card"></i>

                    <div>
                        <span>CNH</span>
                        <strong>54892734100</strong>
                    </div>

                </div>

                <div class="item">

                    <i class="fa-solid fa-phone"></i>

                    <div>
                        <span>Telefone</span>
                        <strong>(11) 99999-9999</strong>
                    </div>

                </div>

                <div class="item">

                    <i class="fa-solid fa-location-dot"></i>

                    <div>
                        <span>Última localização</span>
                        <strong>Campinas - SP</strong>
                    </div>

                </div>

                <div class="item">

                    <i class="fa-solid fa-calendar"></i>

                    <div>
                        <span>Última atualização</span>
                        <strong>Hoje às 14:32</strong>
                    </div>

                </div>

            </div>

        </div>

        <!-- DIREITA -->

        <div class="direita">

            <!-- STATUS VEICULO -->

            <div class="card">

                <div class="card-topo">

                    <h3>
                        <i class="fa-solid fa-truck"></i>
                        Status do Veículo
                    </h3>

                </div>

                <div class="veiculo">

                    <div class="box">
                        <span>Velocidade</span>
                        <strong>72 km/h</strong>
                    </div>

                    <div class="box">
                        <span>Temperatura</span>
                        <strong>23°C</strong>
                    </div>

                    <div class="box">
                        <span>Combustível</span>
                        <strong>68%</strong>
                    </div>

                </div>

            </div>

            <!-- ATIVIDADES -->

            <div class="card">

                <div class="card-topo">

                    <h3>
                        <i class="fa-solid fa-route"></i>
                        Histórico de Atividades
                    </h3>

                </div>

                <div class="timeline">

                    <div class="timeline-item">

                        <div class="bola"></div>

                        <div class="timeline-conteudo">

                            <strong>Saída do Centro Logístico</strong>

                            <p>
                                Veículo iniciou rota com destino a Ribeirão Preto - SP.
                            </p>

                        </div>

                    </div>

                    <div class="timeline-item">

                        <div class="bola"></div>

                        <div class="timeline-conteudo">

                            <strong>Parada Registrada</strong>

                            <p>
                                Veículo permaneceu parado por 12 minutos no km 210.
                            </p>

                        </div>

                    </div>

                    <div class="timeline-item">

                        <div class="bola"></div>

                        <div class="timeline-conteudo">

                            <strong>Rota Normalizada</strong>

                            <p>
                                Sistema confirmou retorno para a rota prevista.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>