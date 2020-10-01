<?php
$this->load->helper('menu');
group_links($modulo = FALSE, $controlador = FALSE);
$inversiones      = send_links($modulo = 'inversiones');
?>
<ul class="sidebar navbar-nav" id="sidebar">
    <?php if(isset($inversiones) && !empty($inversiones)):?>
        <?php foreach ($inversiones as $inversion):?>
            <?php if($inversion['controlador'] == 'inmuebles'):?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('inversiones/inmuebles'); ?>">
                        <i class="far fa-file-excel"></i>
                        <span>Inmuebles</span>
                    </a>
                </li>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>

    <?php if($this->session->userdata('perfil_inversiones')<3): ?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('inversiones/padron_empresas'); ?>">
            <i class="fa fa-industry"></i>
            <span>Empresas</span>
        </a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('inversiones/reportes_gral'); ?>">
            <i class="fa fa-file-excel"></i>
            <span>Reportes</span>
        </a>
    </li>
   <!-- <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModal1">
            <i class="fa fa-fw fa-search"></i>
            <span>Filtrar</span>
        </a>
    </li>
    <ul>
        <p class="text-white">Filtro activo:</p>
        <?php if (is_array($states)):?>
            <?php foreach ($states as $std):?>
                <?php $obj_std = (object)$std;?>
                <?php if (isset($obj_std->nombre_estado)):?>
                    <li class="text-white">
                        <span class="nav-link-text"><?php echo $i++ . ' - ' . $obj_std->nombre_estado;?></span><br>
                    </li>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>

    </ul>-->

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModal1">
            <i class="fa fa-fw fa-search"></i>
            <span>Filtrar</span>
        </a>
    </li>
    <ul class="estadoName">
        <p class="text-white">Filtro activo:</p>
    </ul>
    <li class="nav-item">
        <a class="nav-link" id="refresh-filter">
            <i class="fa fa-fw fa-ban"></i>
            <span>Limpiar filtro</span>
        </a>
    </li>
</ul>

<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Escoje los estados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="selector-estados" action=""  method="post">
                <div class="modal-body">
                    <div id="estados-select" class="row m-1">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input id="filtro" type="submit"  class="btn btn-primary" name="subir" value="Filtrar">
                </div>
                <?php echo form_close();?>
        </div>
    </div>
</div>
