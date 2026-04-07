<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>GeoSync | Sistema de Gestão</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modificacoes.css') }}" rel="stylesheet">

    <style>
        :root {
            --sidebar-color: #1a1a2e;
            --bg-body: #f8fafc;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --primary: #3b82f6;
        }

        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-body); margin: 0; overflow-x: hidden; }
        .main-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar-color); color: #fff; position: sticky; top: 0; height: 100vh; transition: 0.3s; }
        .sidebar-header { padding: 25px; text-align: center; font-weight: bold; font-size: 1.4rem; border-bottom: 1px solid #2e2e45; }
        .sidebar ul { list-style: none; padding: 20px 0; margin: 0; }
        .sidebar ul li { cursor: pointer; }
        .sidebar ul li a { color: #b3b3b3; text-decoration: none; display: block; padding: 15px 25px; transition: 0.3s; }
        .sidebar ul li:hover a, .sidebar ul li.active a { background: var(--primary); color: #fff; border-radius: 0 25px 25px 0; margin-right: 15px; }

        /* Área de Conteúdo */
        .content-area { flex: 1; display: flex; flex-direction: column; padding: 30px; }
        
        /* Controle de Telas (Esconder/Mostrar) */
        .page-section { display: none; }
        .page-section.active { display: block; animation: fadeIn 0.3s ease; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Estilização Geral de Caixas */
        .custom-card { background: #fff; padding: 25px; border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid #edf2f7; margin-bottom: 25px; }
        .table-ui { width: 100%; border-collapse: collapse; }
        .table-ui th { padding: 12px; color: #64748b; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid #f1f5f9; text-align: left; }
        .table-ui td { padding: 15px 12px; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-size: 0.9rem; }

        /* Badges de Status */
        .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-entregue { background: #dcfce7; color: #15803d; }
        .status-transito { background: #dbeafe; color: #1d4ed8; }
        .status-atrasado { background: #fee2e2; color: #b91c1c; }

        /* Grid do Dashboard */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .dashboard-main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <nav class="sidebar">
            {{-- fazer o link volta pra tela de inicio --}}
            <div class="sidebar-header"><a href="index.blade.php" style="color: white;">GeoSync</a></div>
            <ul id="main-menu">
                <li class="active" onclick="changeTab('dashboard', this)"><a><i class="fas fa-th-large mr-2"></i> Dashboard</a></li>
                <li onclick="changeTab('entregas', this)"><a><i class="fas fa-truck mr-2"></i> Entregas</a></li>
                <li onclick="changeTab('produtos', this)"><a><i class="fas fa-box mr-2"></i> Produtos</a></li>
                <li onclick="changeTab('motoristas', this)"><a><i class="fas fa-users mr-2"></i> Motoristas</a></li>
                <li onclick="changeTab('configuracoes', this)"><a><i class="fas fa-cog mr-2"></i> Configurações</a></li>
            </ul>
        </nav>

        <main class="content-area">
            
            <section id="dashboard" class="page-section active">
                <h2 class="font-weight-bold mb-4">Dashboard</h2>
                <div class="stats-grid">
                    <div class="custom-card text-center"><h6>Total Entregas</h6><h2>145</h2></div>
                    <div class="custom-card text-center"><h6>Em Trânsito</h6><h2 style="color: #3b82f6;">47</h2></div>
                    <div class="custom-card text-center"><h6>Entregues</h6><h2 style="color: #10b981;">98</h2></div>
                    <div class="custom-card text-center" style="background: #fff1f2;"><h6>Atrasadas</h6><h2 style="color: #ef4444;">10</h2></div>
                </div>
                <div class="dashboard-main-grid">
                    <div class="custom-card" style="padding: 10px; height: 450px;">
                        <iframe src="https://www.google.com/maps?q=100%20R.%20Bela%20Vista,%20Tambaú,%20Brasil&output=embed" style="width:100%; height:100%; border:0; border-radius:8px;"></iframe>
                    </div>
                    <div class="custom-card">
                        <h5 class="font-weight-bold mb-3"><i class="fas fa-bell text-danger mr-2"></i>Alertas</h5>
                        <div style="padding:10px; background:#f8fafc; border-radius:8px; margin-bottom:10px; border-left:4px solid #ef4444;">
                            <strong>Atraso detectado</strong><br><small>Veículo Placa ABC-1234</small>
                        </div>
                        <div style="padding:10px; background:#f8fafc; border-radius:8px; border-left:4px solid #3b82f6;">
                            <strong>Nova Rota</strong><br><small>Motorista João Silva iniciou curso</small>
                        </div>
                    </div>
                </div>
            </section>

            <section id="entregas" class="page-section">
                <h2 class="font-weight-bold mb-4">Gerenciamento de Entregas</h2>
                <div class="custom-card">
                    <table class="table-ui">
                        <thead>
                            <tr>
                                <th>Cód. Pedido</th>
                                <th>Cliente</th>
                                <th>Destino</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#88420</td>
                                <td>Supermercado Gricki</td>
                                <td>Tambaú - SP</td>
                                <td><span class="badge-status status-entregue">Concluído</span></td>
                                <td><button class="btn btn-sm btn-outline-primary">Ver Detalhes</button></td>
                            </tr>
                            <tr>
                                <td>#88421</td>
                                <td>Loja Minatel</td>
                                <td>Santa Rosa - SP</td>
                                <td><span class="badge-status status-transito">Em Rota</span></td>
                                <td><button class="btn btn-sm btn-outline-primary">Rastrear</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="produtos" class="page-section">
                <h2 class="font-weight-bold mb-4">Catálogo de Produtos</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="custom-card text-center">
                            <i class="fas fa-boxes fa-3x mb-3 text-muted"></i>
                            <h5>Carga Seca</h5>
                            <p class="text-muted">452 itens em estoque</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-card text-center">
                            <i class="fas fa-snowflake fa-3x mb-3 text-info"></i>
                            <h5>Congelados</h5>
                            <p class="text-muted">120 itens em estoque</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="motoristas" class="page-section">
                <h2 class="font-weight-bold mb-4">Equipe de Condutores</h2>
                <div class="custom-card">
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <div style="width:50px; height:50px; background:#e2e8f0; border-radius:50%; margin-right:15px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-user text-secondary"></i></div>
                        <div><strong>Ricardo Oliveira</strong><br><small>CNH: 123456789 • Caminhão Scania</small></div>
                        <div class="ml-auto text-success"><i class="fas fa-circle mr-1" style="font-size: 8px;"></i> Disponível</div>
                    </div>
                    <div class="d-flex align-items-center p-3">
                        <div style="width:50px; height:50px; background:#e2e8f0; border-radius:50%; margin-right:15px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-user text-secondary"></i></div>
                        <div><strong>Ana Paula Souza</strong><br><small>CNH: 987654321 • Van Ducato</small></div>
                        <div class="ml-auto text-primary"><i class="fas fa-truck mr-1" style="font-size: 8px;"></i> Em Viagem</div>
                    </div>
                </div>
            </section>

            <section id="configuracoes" class="page-section">
                <h2 class="font-weight-bold mb-4">Configurações</h2>
                <div class="custom-card col-md-6">
                    <form>
                        <div class="form-group">
                            <label>Nome da Empresa</label>
                            <input type="text" class="form-control" value="GeoSync Logística LTDA">
                        </div>
                        <div class="form-group">
                            <label>E-mail de Notificações</label>
                            <input type="email" class="form-control" value="admin@geosync.com">
                        </div>
                        <button type="button" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </section>

        </main>
    </div>

    <script>
        function changeTab(tabId, element) {
            // Esconde todas as seções
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.remove('active');
            });
            // Remove 'active' de todos os itens do menu
            document.querySelectorAll('#main-menu li').forEach(li => {
                li.classList.remove('active');
            });

            // Mostra a seção clicada
            document.getElementById(tabId).classList.add('active');
            // Ativa o item no menu
            element.classList.add('active');
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>