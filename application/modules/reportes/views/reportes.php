<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#graficas">Graficas de proyectos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#proyectos">Proyectos</a>
        </li>
    </ul>
    <div class="tab-content clearfix">
        <div class="tab-pane active" id="graficas">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="pie" style="width: 700px;height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="proyectos">
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Reportes predeterminados</h4>
                </div>
                <div class="col-md-8">
                    <p>Apertura Programática</p>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url('reportes/elaboracion/aperturaProgramatica') ?>" target="_blank" class="btn btn-success"><i class="fa fa-fw fa-file-excel"></i>Generar</a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Generación Personalizada de Fichas POA</h4>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <!--Empieza tabla-->
                        <table class="table table-striped" id="tabla_proyectos">
                            <thead>
                            <tr>
                                <th></th>
                                <th>URG</th>
                                <th>RO</th>
                                <th>PG</th>
                                <th>SP</th>
                                <th>PY</th>
                                <th>Denominación</th>
                            </tr>
                            </thead>
                            <tbody id="lista_acciones">
                            <?php if (isset($tabla)) echo $tabla;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
