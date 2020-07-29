<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="<?php echo base_url('favicon.ico');?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="lare">
    <title><?php echo NOMBRE_SISTEMA ?></title>
    <!-- Font Awesome Icons -->
    <link href="<?php echo base_url("vendor/fontawesome-free/css/all.min.css");?>" rel="stylesheet" type="text/css">
    <!-- Google Fonts -->
    <link href="<?php echo base_url("vendor/google_fonts/font1.css?family=Merriweather+Sans:400,700");?>" rel="stylesheet">
    <link href="<?php echo base_url("vendor/google_fonts/font1.css?family=Merriweather:400,300,300italic,400italic,700,700italic");?>" rel='stylesheet' type='text/css'>
    <!-- Plugin CSS -->
    <link href="<?php echo base_url("vendor/magnific-popup/magnific-popup.css");?>" rel="stylesheet">
    <!-- Theme CSS - Includes Bootstrap -->
    <link href="<?php echo base_url("css/creative.css");?>" rel="stylesheet">
    <link href="<?php echo base_url("css/form.css");?>" rel="stylesheet">
    <!-- Custom User -->
    <link href="<?php echo base_url("css/carousel.css");?>" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="User" aria-label="User">
                <input class="form-control mr-sm-2" type="password" placeholder="Password" aria-label="Password">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </nav>
    <!-- Carousel -->
    <div class="container-fluid">
        <h1 class="text-center mb-3">Módulo POA</h1>
        <!--Carousel Wrapper-->
        <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
            <!--Indicators-->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-2" data-slide-to="1"></li>
                <li data-target="#carousel-example-2" data-slide-to="2"></li>
            </ol>
            <!--/.Indicators-->
            <!--Slides-->
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class="view">
                        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(68).jpg"
                             alt="First slide">
                        <div class="mask rgba-black-light"></div>
                    </div>
                    <div class="carousel-caption">
                        <h3 class="h3-responsive">Light mask</h3>
                        <p>First text</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <!--Mask color-->
                    <div class="view">
                        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(6).jpg"
                             alt="Second slide">
                        <div class="mask rgba-black-strong"></div>
                    </div>
                    <div class="carousel-caption">
                        <h3 class="h3-responsive">Strong mask</h3>
                        <p>Secondary text</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <!--Mask color-->
                    <div class="view">
                        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(9).jpg"
                             alt="Third slide">
                        <div class="mask rgba-black-slight"></div>
                    </div>
                    <div class="carousel-caption">
                        <h3 class="h3-responsive">Slight mask</h3>
                        <p>Third text</p>
                    </div>
                </div>
            </div>
            <!--/.Slides-->
            <!--Controls-->
            <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <!--/.Controls-->
        </div>
        <!--/.Carousel Wrapper-->
    </div>

    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <?php echo LEGAL; ?>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url("vendor/jquery/jquery.min.js");?>"></script>
    <script src="<?php echo base_url("vendor/bootstrap/js/bootstrap.bundle.min.js");?>"></script>


    <!-- Plugin JavaScript -->
    <script src="<?php echo base_url("vendor/jquery-easing/jquery.easing.min.js");?>"></script>
    <script src="<?php echo base_url("vendor/magnific-popup/jquery.magnific-popup.min.js");?>"></script>

    <!-- Custom scripts for this template -->
    <script src="<?php echo base_url("js/creative.min.js");?>"></script>

    <!-- User custom scripts -->
    <script src="<?php echo base_url("js/carousel.js"); ?>"></script>

</body>

</html>
