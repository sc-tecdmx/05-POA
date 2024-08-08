<!--<div class="container">-->
    <div class="row">
        <div class="col-md-6">
            <h3>Proyectos</h3>
        </div>
        <div class="col-md-6 text-right">
            <?php if($this->session->userdata('modo') === 'elaboracion' && $this->session->userdata('permiso') == 1 && $this->session->userdata('cerrado') == 0): ?>
                <a class="btn btn-outline-primary rounded" href="<?php echo base_url('inicio/proyectos/action'); ?>">
                    Agregar Proyecto <i class="fa fa-fw fa-plus"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <!--Empieza tabla-->
                <table class="table table-striped table-responsive" id="tabla_proyectos">
                    <thead>
                    <tr>
                        <th style="display: none;">URG</th>
                        <th>URG</th>
                        <th>RO</th>
                        <th>PG</th>
                        <th>SP</th>
                        <th>PY</th>
                        <th>Denominación</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="lista_acciones">
                    <?php if (isset($tabla)) echo $tabla;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!--</div>-->
