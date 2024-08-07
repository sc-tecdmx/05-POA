<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="p-4 pt-5">
        <ul class="list-unstyled components mb-5">
            <li class="active">
                <a href="<?php echo base_url('inicio/proyectos') ?>">Proyectos</a>
            </li>
            <?php if($this->session->userdata('permiso') == 1): ?>
                <li>
                    <a href="<?php echo base_url('inicio/unidades_responsables'); ?>">Unidades Responsables</a>
                </li>
                <li>
                    <a href="<?php echo base_url('inicio/responsables_operativos') ?>">Responsables Operativos</a>
                </li>
                <li>
                    <a href="<?php echo base_url('inicio/programas') ?>">Programas</a>
                </li>
                <li>
                    <a href="<?php echo base_url('inicio/subprogramas') ?>">Subprogramas</a>
                </li>
                <li>
                    <a href="<?php echo base_url('inicio/unidades_medida') ?>">Unidades de Medida</a>
                </li>
                <!--<li>
                    <a href="<?php echo base_url('inicio/areas') ?>">Áreas</a>
                </li>-->
                <li>
                    <a href="#">Derechos Humanos</a>
                </li>
                <li>
                    <a href="#">Equidad de Género</a>
                </li>
                <li>
                    <a href="<?php echo base_url('usuarios') ?>">Usuarios</a>
                </li>
                <?php if($this->session->userdata('id_usr') == 97): ?>
                    <li>
                        <a href="<?php echo base_url('inicio/tablero_administrativo') ?>">Tablero de administración</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>

        <div class="footer">
            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | TECDMX
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
        </div>

    </div>
</nav>
