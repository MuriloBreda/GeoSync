<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <!-- Navbar End -->


    <!-- Header Start -->
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
    <!-- Quote Request Start -->


    <!-- Testimonial Start -->
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