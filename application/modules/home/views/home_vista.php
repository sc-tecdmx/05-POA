<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Proyectos</h3>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-outline-primary rounded"><i class="fa fa-fw fa-plus"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <!--Empieza tabla-->
                <table class="table table-striped table-responsive" id="tabla_proyectos">
                    <thead>
                    <tr>
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
</div>
