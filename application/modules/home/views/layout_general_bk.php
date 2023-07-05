<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="<?php echo base_url('favicon.ico'); ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title><?php echo NOMBRE_SISTEMA; ?> :. <?php echo  catalogoInterno('escuelas')[ESCUELA]; ?></title>
    <link href="<?php echo base_url("css/bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/load.css'); ?>" rel="stylesheet" type="text/css">
    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url("vendor/fontawesome-free/css/all.min.css"); ?>" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="<?php echo base_url("vendor/datatables/dataTables.bootstrap4.css"); ?>" rel="stylesheet">

    <!-- Page level plugin-->
    <link href="<?php echo base_url("vendor/jquery-ui/jquery-ui.min.css"); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url("vendor/jquery-ui/jquery-ui.structure.min.css"); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url("vendor/jquery-ui/jquery-ui.theme.min.css"); ?>" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="<?php echo base_url("css/sb-admin.css"); ?>" rel="stylesheet">
</head>

<body id="page-top">
    <!-- navbar -->
    <?php if (isset($header)) echo $header; ?>
    <div id="wrapper">
        <!--sidebar-->
        <?php if (isset($menu)) echo $menu; ?>

        <div id="content-wrapper">
            <div class="container-fluid">
                <?php if (isset($seccion)) { ?>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('home'); ?>">PNR</a>
                        </li>
                        <li class="breadcrumb-item active"><?php if (isset($seccion)) echo $seccion; ?></li>
                    </ol>
                <?php } ?>
                <!--main-->
                <?php if (isset($main)) echo $main; ?>
            </div>
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span><?php echo LEGAL; ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <?php if (isset($salir)) echo $salir; ?>
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url("vendor/jquery/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("vendor/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url("vendor/jquery-easing/jquery.easing.min.js"); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url("vendor/jquery-easing/jquery.easing.min.js"); ?>"></script>
    <!-- Page level plugin JavaScript-->
    <script src="<?php echo base_url("vendor/chart.js/Chart.min.js"); ?>"></script>
    <script src="<?php echo base_url("vendor/datatables/jquery.dataTables.js"); ?>"></script>
    <script src="<?php echo base_url("vendor/datatables/dataTables.bootstrap4.js"); ?>"></script>
    <script src="<?php echo base_url("vendor/datatables/dataTables.buttons.min.js"); ?>"></script>
    <script src="<?php echo base_url("vendor/datatables/buttons.html5.min.js"); ?>"></script>
    <script src="<?php echo base_url("vendor/datatables/jszip.min.js"); ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url("js/sb-admin.min.js"); ?>"></script>
    <!--jQuery-UI-->
    <script src="<?php echo base_url("vendor/jquery-ui/jquery-ui.min.js"); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("vendor/jquery-form/jquery-form.min.js"); ?>" type="text/javascript"></script>
    <!--Modernizer-->
    <script src="<?php echo base_url('vendor/modernizr/modernizr-2.7.0.js'); ?>"></script>
    <!--Modernizer-->
    <script src="<?php echo base_url('vendor/formvalidation/formValidation.js'); ?>"></script>
	<script src="<?php echo base_url('vendor/formvalidation/bootstrap.min.js'); ?>"></script>
    <!--ready-->
    <script src="<?php echo base_url('js/home/layout_general.js'); ?>"></script>
    <!--Variable global JS-->
    <script>
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <script>
        (function($) {
            <?php if (isset($js)) : ?>
                Modernizr.load([{
                    load: '<?php echo base_url("js/$js"); ?>'
                }]);
            <?php endif; ?>
        })(jQuery);
    </script>
</body>

</html>