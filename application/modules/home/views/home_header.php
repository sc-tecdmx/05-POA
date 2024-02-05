<div class="wrapper">
    <div class="row">
        <div class="col-md-8">
            <h3 style="color: #194891"><img src="<?php echo base_url('img/TECDMX_400px.png') ?>" height="50" style="margin-top: 5px; margin-left: 3px;"> Módulo POA / <?php echo $this->session->userdata('modo')==='elaboracion' ? "Elaboración" : 'Seguimiento' ?> <?php echo $this->session->userdata('anio'); ?></h3>
        </div>
        <div class="col-md-4">
            <div style="background-color: yellow; width: 50%" class="mt-3 text-center float-right mr-3">
                <?php if($this->session->userdata('modo')==='elaboracion'): ?>
                <a href="<?php echo base_url('docs/Manual_de_Usuario(Elaboración)-Sistema_Integral_POA_v11.pdf'); ?>" target="_blank">
                    Ayuda
                </a>
                <?php else: ?>
                    <a href="<?php echo base_url('docs/Manual_de_usuario(Seguimiento)-Sistema_Integral_POA_v11.pdf'); ?>" target="_blank">
                        Ayuda
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('inicio/proyectos') ?>">Inicio</a>
            </li>
            <?php if($this->session->userdata('permiso') == 1): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('reportes/elaboracion') ?>">Reportes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('configuracion') ?>">Configuración</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('cuenta/cuenta/editarUsuario')?>">
                    <i class="fa fa-fw fa-user"></i><?php echo $this->session->userdata('nombre_usr'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal" style="cursor: pointer">
                    <i class="fa fa-fw fa-sign-out"></i>Salir
                </a>
            </li>
        </ul>
    </div>
</div>
