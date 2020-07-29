<!DOCTYPE html>
<html lang="es">

<head>


    <link rel="icon" href="<?php echo base_url('favicon.ico');?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="laleichin_marduk">
    <title><?php echo NOMBRE_SISTEMA; ?> :. <?php echo  catalogoInterno('escuelas')[ESCUELA]; ?></title>
    <!-- Bootstrap core CSS-->
    <link href="<?php echo base_url("vendor/bootstrap/css/bootstrap.min.css");?>" rel="stylesheet">
    <link href="<?php echo base_url("css/bootstrap.css");?>" rel="stylesheet">

    <link href="<?php echo base_url('/css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css" media="all"/>
    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url("vendor/font-awesome/css/font-awesome.min.css");?>" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="<?php echo base_url("vendor/datatables/dataTables.bootstrap4.css");?>" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?php echo base_url("css/sb-admin.css");?>" rel="stylesheet">
    <script src="<?php echo base_url('js/modernizr-2.7.0.js');?>"></script>
    <!-- Bootstrap core JavaScript-->
    <script type="text/javascript" src="<?php echo base_url('js/jquery-2.2.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/jquery-ui.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url("vendor/formvalidation/formValidation.js");?>"></script>
    <script src="<?php echo base_url("vendor/formvalidation/bootstrap.min.js");?>"></script>
    <script src="<?php echo base_url("vendor/chart.js/Chart.min.js");?>"></script>


</head>

<body class="" id="page-top" >
    <!-- Navigation-->





    <div class="row">
        <?php if(isset($main)) echo $main; ?>

    </div>




    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url("vendor/bootstrap/js/bootstrap.bundle.min.js");?>"></script>
    <script src="<?php echo base_url("vendor/jquery-easing/jquery.easing.min.js");?>"></script>
    <!-- Page level plugin JavaScript-->

    <!-- Custom scripts for this page-->
    <script src="<?php echo base_url("js/sb-admin.min.js");?>"></script>

</body>

</html>
