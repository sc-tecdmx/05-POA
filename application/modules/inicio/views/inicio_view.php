<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="<?php echo base_url('img/favicon.ico');?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="lare">
    <title><?php echo NOMBRE_SISTEMA; ?> </title>
    <!-- Bootstrap core CSS-->
    <link href="<?php echo base_url("css/bootstrap.css");?>" rel="stylesheet">

    <link href="<?php echo base_url('vendor/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" type="text/css" media="all"/>
    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url("vendor/fontawesome-free/css/fontawesome.min.css");?>" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="<?php echo base_url("vendor/datatables/dataTables.bootstrap4.css");?>" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?php echo base_url("css/sb-admin.css");?>" rel="stylesheet">
    <!-- Bootstrap core JavaScript-->
    <script type="text/javascript" src="<?php echo base_url('js/jquery-2.2.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('vendor/jquery-ui/jquery-ui.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("vendor/bootstrap/js/bootstrap.js");?>"></script>
    <script src="<?php echo base_url("vendor/formvalidation/formValidation.js");?>"></script>
    <script src="<?php echo base_url("vendor/formvalidation/bootstrap.min.js");?>"></script>
    <script src="<?php echo base_url("js/modernizr-2.7.0.js");?>"></script>

    <script>
    (function($){
        <?php if(isset($js)):?>
        Modernizr.load([{
            load: '<?php echo base_url("js/$js");?>'
        }]);
        <?php endif;?>
    })(jQuery);
    </script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><img src="img/LOGO-BLANCO.PNG" height="40"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="col align-self-end">
                <?php
                $attributes = array('id' => 'ingreso', 'data-form'=>'validate', 'class' => 'form-inline my-2 my-lg-0 float-right');
                echo form_open('', $attributes,);

                if(isset($mensaje)) echo $mensaje;
                if(validation_errors()!=""){
                    echo '<div class="errormsj" > <span> Error </span>'.validation_errors().'</div>';
                }
                ?>

                <div class="form-group">
                    <?php
                    $field = array(
                        'name'        => 'usuario',
                        'class'       => 'form-control mr-sm-2',
                        'id'          => 'usuario',
                        'maxlength'   => '30',
                        'type'        => 'text',
                        'data-form'   => 'required',
                        'placeholder' => 'Usuario'
                    );
                    echo form_input($field,set_value('usuario'));
                    ?>
                </div>

                <div class="form-group">
                    <?php
                    $field = array(
                        'name'        => 'pass',
                        'class'       => 'form-control mr-sm-2',
                        'id'          => 'pass',
                        'maxlength'   => '18',
                        'type'        => 'password',
                        'data-form'   => 'required',
                        'placeholder' => 'Contraseña'
                    );
                    echo form_input($field);
                    ?>
                </div>

                <?php if(isset($ejercicios)): ?>
                <div class="form-group">
                    <?php
                    echo form_dropdown('modo', $ejercicios, 'seguimiento', 'class="form-control mr-sm-2"');
                    ?>
                </div>
                <?php endif; ?>

                <?php
                echo '<input type="submit" value="Ingresar"  class="btn btn-outline-light my-2 my-sm-0">';
                echo form_close();
                ?>
            </div>
        </div>
    </nav>
    <!-- Carousel -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Módulo POA</h1>
            </div>
        </div><br>
        <!--Carousel Wrapper-->
        <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
            <!--Indicators-->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-2" data-slide-to="1"></li>
                <li data-target="#carousel-example-2" data-slide-to="2"></li>
                <li data-target="#carousel-example-2" data-slide-to="3"></li>
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
                        <h3 class="h3-responsive">ACERCA DEL MÓDULO</h3>
                        <p>Derivado de la experiencia obtenida en la integración del POA en ejercicios anteriores se diseñó el Módulo del Programa Operativo Anual.</p>
                        <btn class="btn" style=" background-color: #194891; color: white" data-toggle="modal" data-target="#aboutModal">Más...</btn>
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
                        <h3 class="h3-responsive">MARCO LEGAL Y NORMATIVO</h3>
                        <p>Leyes, reglamentos, normas y lineamientos, entre otros, que regulan la elaboración y seguimiento del Programa Operativo Anual.</p>
                        <btn class="btn" style=" background-color: #194891; color: white" data-toggle="modal" data-target="#legalModal">Más...</btn>
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
                        <h3 class="h3-responsive">MISIÓN</h3>
                        <p>El motivo o la razón de la existencia del TECDMX.</p>
                        <btn class="btn" style=" background-color: #194891; color: white" data-toggle="modal" data-target="#misionModal">Más...</btn>
                    </div>
                </div>
                <div class="carousel-item">
                    <!--Mask color-->
                    <div class="view">
                        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(8).jpg"
                             alt="Third slide">
                        <div class="mask rgba-black-slight"></div>
                    </div>
                    <div class="carousel-caption">
                        <h3 class="h3-responsive">VISIÓN</h3>
                        <p>Lo que el TECDMX debe ser y hacia dónde debe dirigirse.</p>
                        <btn class="btn" style=" background-color: #194891; color: white" data-toggle="modal" data-target="#visionModal">Más...</btn>
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

    <!-- Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ACERCA DEL MÓDULO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-justify">El Programa Operativo Anual (POA) es el instrumento que cuantifica los objetivos y metas concretas a desarrollar en el corto plazo, donde se definen responsables, temporalidad y especialidad de acciones, para lo cual se asignan recursos humanos, materiales y financieros.</p><br>
                    <p class="text-justify">Derivado de la experiencia obtenida en la integración del POA en ejercicios anteriores, y con el propósito de contar con un instrumento informático que aproveche los datos proporcionados por las Unidades Responsables de Gasto (URGs) durante el proceso de diseño de sus Proyectos 2012, se diseñó este Módulo del Programa Operativo Anual, donde se podrán capturar los avances de los proyectos que conforman el POA del Tribunal Electoral de la Ciudad de México.</p><br>
                    <p class="text-justify">Con este módulo se pretende, por una parte, facilitar a las URGs las actividades para reportar mensualmente los avances físicos obtenidos en la ejecución de sus proyectos durante el año y, por otro lado, proporcionar información ejecutiva que apoye la toma de decisiones en las instancias correspondientes.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="legalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">MARCO LEGAL Y NORMATIVO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-justify">El Programa Operativo Anual (POA) es el instrumento que cuantifica los objetivos y metas concretas a desarrollar en el corto plazo, donde se definen responsables, temporalidad y especialidad de acciones, para lo cual se asignan recursos humanos, materiales y financieros.</p><br>
                    <p class="text-justify">Derivado de la experiencia obtenida en la integración del POA en ejercicios anteriores, y con el propósito de contar con un instrumento informático que aproveche los datos proporcionados por las Unidades Responsables de Gasto (URGs) durante el proceso de diseño de sus Proyectos 2012, se diseñó este Módulo del Programa Operativo Anual, donde se podrán capturar los avances de los proyectos que conforman el POA del Tribunal Electoral de la Ciudad de México.</p><br>
                    <p class="text-justify">Con este módulo se pretende, por una parte, facilitar a las URGs las actividades para reportar mensualmente los avances físicos obtenidos en la ejecución de sus proyectos durante el año y, por otro lado, proporcionar información ejecutiva que apoye la toma de decisiones en las instancias correspondientes.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="misionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">MISIÓN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li class="text-justify">Fortalecer la cultura democrática en el Distrito Federal; impartir justicia electoral; garantizar el apego a la legalidad, la transparencia en materia electoral y laboral; así como la rendición de cuentas; actualizar y complementar nuestra normatividad; y elevar la eficiencia de nuestros procesos jurisdiccionales y administrativos adoptando el uso de la tecnología más avanzada.</li><br>
                        <li class="text-justify">Establecer un programa de trabajo de largo plazo (2010 -2015) que permita al Tribunal alcanzar su Visión.</li><br>
                        <li class="text-justify">Difundir a todo el personal del Tribunal el programa de trabajo de largo plazo, haciendo hincapié en que los proyectos contenidos en dicho programa son adicionales a los proyectos que se han presentado hasta ahora en el Programa Operativo Anual.</li><br>
                        <li class="text-justify">Difundir a todo el personal los Valores y Principios Éticos del Tribunal.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="visionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">VISIÓN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li class="text-justify">Ser el Tribunal número uno del país en materia de impartición de justicia con apego a la legalidad, comprometido con la transparencia, la rendición de cuentas, y administrado con la mayor eficacia; así como una institución sólida que responda a las expectativas de la sociedad.</li><br>
                        <li class="text-justify">Un Tribunal con un Pleno unido en el propósito de garantizar la legalidad e imparcialidad en los juicios, de ganarse la confianza de la ciudadanía y de guiar y dirigir al órgano jurisdiccional hacia la excelencia en todos los ámbitos.</li><br>
                        <li class="text-justify">Un Tribunal que con su actuar fortalezca el estado democrático en el Distrito Federal.</li><br>
                        <li class="text-justify">Un Tribunal que garantice la legalidad en sus actuaciones, que resuelva con toda oportunidad los juicios electorales, los juicios relacionados con los derechos políticos y electorales de los ciudadanos, los juicios laborales y de inconformidad administrativa.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5">
        <div class="container">
            <p class="m-0 text-center">© TECDMX</p>
        </div>
    </footer>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url("vendor/bootstrap/js/bootstrap.bundle.min.js");?>"></script>
    <script src="<?php echo base_url("vendor/jquery-easing/jquery.easing.min.js");?>"></script>
    <!-- Page level plugin JavaScript-->
    <!-- Custom scripts for this page-->
    <script src="<?php echo base_url("js/sb-admin.min.js");?>"></script>
</body>
</html>
