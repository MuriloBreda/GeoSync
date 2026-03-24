<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>GeoSync</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modificacoes.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-dark">
        <div class="row py-2 px-lg-5">
            <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center text-white">
                    <small><i class="fa fa-phone-alt mr-2"></i>+55 (19) 99401-0744</small>
                    <small class="px-3">|</small>
                    <small><i class="fa fa-envelope mr-2"></i>contact@geosync.com</small>
                </div>
            </div>
            <!-- Criar nossas contas em redes sociais -->
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-white px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-white pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.html" class="navbar-brand ml-lg-3">
                <h1 class="m-0 display-5 text-uppercase text-primary"><i class="fa fa-truck mr-2"></i>GeoSync</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav m-auto py-0">
                    <a href="index.html" class="nav-item nav-link">Inicio</a>
                    <a href="about.html" class="nav-item nav-link">Sobre</a>
                    <a href="service.html" class="nav-item nav-link">Serviço</a>
                    <a href="price.html" class="nav-item nav-link">Preço</a>
                    <a href="contact.html" class="nav-item nav-link">Contato</a>
                </div>
                <a href="" class="btn btn-primary py-2 px-4 d-none d-lg-block">Solicite um Orçamento</a>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid mb-5">
        <div class="container text-center py-5">
            <h1 class="text-white display-3">Serviço</h1>
        </div>
    </div>
    <!-- Header End -->


    <!-- Services Start -->
    <!-- Dashboard Services Start -->
<div class="container my-5 dashboard">

    <h2 class="fw-bold">Dashboard</h2>
    <p class="text-muted mb-4">Visão geral das operações logísticas</p>

    <!-- Cards -->
    <div class="row text-center mb-4">

        <div class="col-md-3 mb-3">
            <div class="card-box">
                <p>Total entregas</p>
                <h2>145 <i class="fas fa-box text-warning"></i></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card-box">
                <p>Em trânsito</p>
                <h2>47 <i class="fas fa-clock"></i></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card-box">
                <p>Entregas</p>
                <h2>98 <i class="fas fa-check text-success"></i></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card-box">
                <p>Atrasadas</p>
                <h2>10 <i class="fas fa-exclamation-triangle text-warning"></i></h2>
            </div>
        </div>

    </div>

    <!-- Mapa + Alertas -->
    <div class="row">

        <!-- Mapa -->
        <div class="col-md-8 mb-4">
            <div class="map-box">
    <h5 class="mb-3">Rastreamento em tempo real</h5>

    <div class="mapa-container">

        <!-- MAPA -->
        <iframe
            src="https://www.google.com/maps?q=100%20R.%20Bela%20Vista,%20Tambaú,%20Brasil&output=embed"
            width="600"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
        </iframe>

    </div>
</div>
        </div>

        <!-- Alertas -->
        <div class="col-md-4">
            <div class="alert-box">
                <h5 class="mb-3">Alertas recentes</h5>

                <div class="alert-item">
                    Veículo atrasado há 2 horas
                </div>

                <div class="alert-item">
                    Veículo fora da rota planejada
                </div>

                <div class="alert-item">
                    Veículo parado há 45 minutos
                </div>

                <div class="alert-item">
                    Manutenção programada
                </div>

            </div>
        </div>

    </div>

</div>
<!-- Dashboard Services End -->
    <!-- Services End -->


    <!--  Quote Request Start -->
    <div class="container-fluid bg-secondary my-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 py-5 py-lg-0">
                    <h6 class="text-primary text-uppercase font-weight-bold">Obter Uma Cotação</h6>
                    <h1 class="mb-4">Solicite um Orçamento Grátis</h1>
                    <p class="mb-4">A GeoSync otimiza o transporte de mercadorias com rastreamento em tempo real, garantindo mais controle, segurança e eficiência nas entregas.</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <h1 class="text-primary mb-2" data-toggle="counter-up">225</h1>
                            <h6 class="font-weight-bold mb-4">Especialistas Qualificados</h6>
                        </div>
                        <div class="col-sm-4">
                            <h1 class="text-primary mb-2" data-toggle="counter-up">1050</h1>
                            <h6 class="font-weight-bold mb-4">Clientes Felizes</h6>
                        </div>
                        <div class="col-sm-4">
                            <h1 class="text-primary mb-2" data-toggle="counter-up">2500</h1>
                            <h6 class="font-weight-bold mb-4">Projeto Completos</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="bg-primary py-5 px-4 px-sm-5">
                        <form class="py-5">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 p-4" placeholder="Seu Nome" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 p-4" placeholder="Seu Email" required="required" />
                            </div>
                            <div class="form-group">
                                <select class="custom-select border-0 px-4" style="height: 47px;">
                                    <option selected>Selecione Um Serviço</option>
                                    <option value="1">Serviço 1</option>
                                    <option value="2">Serviço 2</option>
                                    <option value="3">Serviço 3</option>
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-dark btn-block border-0 py-3" type="submit">Obter Uma Cotação</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quote Request Start -->


    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center pb-2">
                <h6 class="text-primary text-uppercase font-weight-bold">Comentários</h6>
                <h1 class="mb-4">Nossos Clientes Dizem</h1>
            </div>

            <!-- Depoimentos de clientes sobre o sistema GeoSync -->
<div class="owl-carousel testimonial-carousel">

    <!-- Cliente 1 -->
    <div class="position-relative bg-secondary p-4">
        <i class="fa fa-3x fa-quote-right text-primary position-absolute" style="top: -6px; right: 0;"></i>
        <div class="d-flex align-items-center mb-3">
            <img class="img-fluid rounded-circle" src="img/testimonial-1.jpg" style="width: 60px; height: 60px;" alt="">
            <div class="ml-3">
                <h6 class="font-weight-semi-bold m-0">Carlos Mendes</h6>
                <small>- Gerente de Logística</small>
            </div>
        </div>
        <p class="m-0">
        O GeoSync facilitou muito o controle das nossas entregas. Agora conseguimos acompanhar nossos produtos em tempo real.
        </p>
    </div>

    <!-- Cliente 2 -->
    <div class="position-relative bg-secondary p-4">
        <i class="fa fa-3x fa-quote-right text-primary position-absolute" style="top: -6px; right: 0;"></i>
        <div class="d-flex align-items-center mb-3">
            <img class="img-fluid rounded-circle" src="img/testimonial-2.jpg" style="width: 60px; height: 60px;" alt="">
            <div class="ml-3">
                <h6 class="font-weight-semi-bold m-0">Fernanda Alves</h6>
                <small>- Supervisora de Transporte</small>
            </div>
        </div>
        <p class="m-0">
        Com o GeoSync conseguimos monitorar todas as rotas dos motoristas.
        O sistema é simples de usar e ajudou muito na organização da empresa.
        </p>
    </div>

    <!-- Cliente 3 -->
    <div class="position-relative bg-secondary p-4">
        <i class="fa fa-3x fa-quote-right text-primary position-absolute" style="top: -6px; right: 0;"></i>
        <div class="d-flex align-items-center mb-3">
            <img class="img-fluid rounded-circle" src="img/testimonial-3.jpg" style="width: 60px; height: 60px;" alt="">
            <div class="ml-3">
                <h6 class="font-weight-semi-bold m-0">Ricardo Souza</h6>
                <small>- Empresário do Setor de Transportes</small>
            </div>
        </div>
        <p class="m-0">
        O rastreamento em tempo real melhorou muito nossa eficiência.
        Hoje temos mais segurança e controle sobre nossas cargas.
        </p>
    </div>

    <!-- Cliente 4 -->
    <div class="position-relative bg-secondary p-4">
        <i class="fa fa-3x fa-quote-right text-primary position-absolute" style="top: -6px; right: 0;"></i>
        <div class="d-flex align-items-center mb-3">
            <img class="img-fluid rounded-circle" src="img/testimonial-4.jpg" style="width: 60px; height: 60px;" alt="">
            <div class="ml-3">
                <h6 class="font-weight-semi-bold m-0">Juliana Martins</h6>
                <small>- Coordenadora de Operações</small>
            </div>
        </div>
        <p class="m-0">
        Excelente sistema para empresas que trabalham com transporte.
        O GeoSync trouxe mais organização e controle para nossa logística.
        </p>
    </div>

</div>
</div>
</div>
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white mt-5 py-5 px-sm-3 px-md-5">
        <div class="row pt-5">
            <div class="col-lg-7 col-md-6">
                <div class="row">
                    <div class="col-md-6 mb-5">
                        <h3 class="text-primary mb-4">Entre Em Contato</h3>
                        <p><i class="fa fa-map-marker-alt mr-2"></i>100 R. Bela Vista, Tambaú, Brasil</p>
                        <p><i class="fa fa-phone-alt mr-2"></i>+55 (19) 99401-0744</p>
                        <p><i class="fa fa-envelope mr-2"></i>contact@geosync.com</p>
                        <!-- colocar nossas redes sociais -->
                        <div class="d-flex justify-content-start mt-4">
                            <a class="btn btn-outline-light btn-social mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5">
                        <h3 class="text-primary mb-4">Links Rápidos</h3>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-white mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Inicio</a>
                            <a class="text-white mb-2" href="about.html"><i class="fa fa-angle-right mr-2"></i>Sobre nós</a>
                            <a class="text-white mb-2" href="service.html"><i class="fa fa-angle-right mr-2"></i>Nosso Serviço</a>
                            <a class="text-white mb-2" href="price.html"><i class="fa fa-angle-right mr-2"></i>Plano de Preços</a>
                            <a class="text-white" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contate-nos</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 mb-5">
                
                <div class="w-100">
                    <div class="input-group">
                        <input type="text" class="form-control border-light" style="padding: 30px;" placeholder="Seu Endereço de E-mail">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Entrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5" style="border-color: #3E3E4E !important;">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white" style="text-align: center;">&copy; 2026 GeoSync. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>