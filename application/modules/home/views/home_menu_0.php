<?php
    $this->load->helper('menu');
    group_links($modulo = FALSE, $controlador = FALSE);
    $avance_fisico      = send_links($modulo = 'avance_fisico');
    $usuarios           = send_links($modulo = 'usuarios');
    $operaciones        = send_links($modulo = 'operaciones');
    $avance_financiero  = send_links($modulo = 'avance_financiero');
    $carga_documental   = send_links($modulo = 'carga_documental');
    $contratos          = send_links($modulo = 'contratos');
    $reportes           = send_links($modulo = 'reportes');
    $cuenta             = send_links($modulo = 'cuenta');
?>
<ul class="sidebar navbar-nav" id="sidebar">
    <?php if(isset($operaciones) && !empty($operaciones)):?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder-open"></i>
            <span class="nav-link-text">Operaciones</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">

        <?php foreach ($operaciones as $operacion):?>
            <?php if($operacion['ruta'] == 'operaciones/inmuebles'):?>
                <a class="dropdown-item" href="<?php echo base_url($operacion['ruta']);?>">
                    <i class="fas fa-house-damage"></i>
                    <span class="nav-link-text">Inmuebles</span>
                </a>
            <?php endif;?>
            <?php if($operacion['ruta'] == 'operaciones/cct'):?>
                <a class="dropdown-item" href="<?php echo base_url($operacion['ruta']);?>">
                    <i class="fas fa-school"></i>
                    <span class="nav-link-text">Centros de trabajo</span>
                </a>
            <?php endif;?>
            <?php if($operacion['ruta'] == 'operaciones/acciones'):?>
                <a class="dropdown-item" href="<?php echo base_url($operacion['ruta']);?>">
                    <i class="fas fa-location-arrow"></i>
                    <span class="nav-link-text">Acciones</span>
                </a>
            <?php endif;?>
            <?php if($operacion['ruta'] == 'operaciones/inversiones'):?>
                <a class="dropdown-item" href="<?php echo base_url($operacion['ruta']);?>">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span class="nav-link-text">Inversiones</span>
                </a>
            <?php endif;?>
            <?php if($operacion['ruta'] == 'operaciones/padron_empresas'):?>
            <a class="dropdown-item" href="<?php echo base_url($operacion['ruta']);?>">
                <i class="fas fa-fw fa-industry"></i>
                <span class="nav-link-text">Empresas</span>
            </a>
            <?php endif;?>
            <?php if($operacion['ruta'] == 'operaciones/padron_comites'):?>
                <a class="dropdown-item" href="<?php echo base_url($operacion['ruta']);?>">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span class="nav-link-text">Cómites de padres</span>
                </a>
            <?php endif;?>
        <?php endforeach;?>

        <?php if(isset($contratos) && !empty($contratos)):?>
            <?php foreach ($contratos as $contrato):?>
                <?php if($contrato['ruta'] == 'contratos/contratos'):?>
                    <a class="dropdown-item" href="<?php echo base_url('operaciones/' . $contrato['modulo']);?>">
                        <i class="fas fa-fw fa-file-contract"></i>
                        <span class="nav-link-text">Contratos</span>
                    </a>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
        </div>
    </li>
    <?php endif;?>

    <!-- Carga Documental -->
    <?php if(isset($carga_documentals) &&  !empty($carga_documental)):?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-file-upload"></i>
                <span class="nav-link-text">Carga Documental</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <?php foreach ($carga_documental as $carga):?>
                    <?php if($carga['ruta'] == 'carga_documental/tabla_inversiones'):?>
                        <a class="dropdown-item" href="<?php echo base_url($carga['ruta']);?>">
                            <i class="fas fa-fw fa-file"></i>
                            <span class="nav-link-text">Inversiones</span>
                        </a>
                    <?php endif;?>
                    <?php if($carga['ruta'] == 'carga_documental/tabla_acciones'):?>
                        <a class="dropdown-item" href="<?php echo base_url($carga['ruta']);?>">
                            <i class="fas fa-fw fa-file"></i>
                            <span class="nav-link-text">Acciones</span>
                        </a>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </li>
    <?php endif;?>

    <!-- Usuarios -->
    <?php if(isset($usuarios) && !empty($usuarios)):?>
        <?php foreach ($usuarios as $user):?>
            <?php if($user['controlador'] == 'usuarios'):?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('usuarios'); ?>">
                        <i class="fa fa-fw fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>

    <?php if(isset($reportes) && !empty($reportes)):?>
        <?php foreach ($reportes as $reporte):?>
            <?php if($reporte['controlador'] == 'reporte'):?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('reportes/reporte'); ?>">
                        <i class="far fa-file-excel"></i>
                        <span>Reportes</span>
                    </a>
                </li>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>

    <!--<?php if(isset($cuenta) && !empty($cuenta)):?>
        <?php foreach ($cuenta as $cuenta_):?>
            <?php if($cuenta_['controlador'] == 'cuenta'):?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('cuenta/cuenta'); ?>">
                        <i class="fa fa-fw fa-users"></i>
                        <span>Cuenta</span>
                    </a>
                </li>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>-->

    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('graficas/principal'); ?>">
            <i class="fa fa-fw fa-chart-pie"></i> <span>Gráficas</span>
        </a>
    </li>

    <?php
    $states = array_objects_estados();
    $condicion = get_states_user_condicion();
    $i = 1;
    ?>

    <li class="nav-item">
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

    </ul>
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
                <div class="row m-1">
                    <?php $i = 0;?>
                    <?php foreach ($condicion as $estado):?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">
                                    <?php
                                    $edo = (object)$estado;

                                    $data = array(
                                        'name'    => 'estado_condicion[' . $edo->id_estados. ']',
                                        'id'      => $edo->id_estados,
                                        'value'   => $edo->id_estados,
                                        'checked' => set_value('estado_condicion[' . $edo->id_estados. ']', (isset($states[$i++]['id_estados'])) ? TRUE : FALSE),
                                        //'class'   => 'form-control'
                                    );
                                    echo form_checkbox($data);
                                    ?>
                                    <?php echo $edo->nombre_estado;?>
                                </label>
                                <span class="badge badge-pill badge-primary"><?php echo $edo->cantidad;?></span>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <a href="<?php clean_filter();?>">
                        Limpiar filtros
                    </a>
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
