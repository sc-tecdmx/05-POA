<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Unidades Responsables</h3>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-outline-primary" id="addUnidadResponsable">
                Agregrar Unidad Responsable <i class="fa fa-fw fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <!--Empieza tabla-->
                <table class="table table-striped table-responsive" id="tabla_unidades">
                    <thead>
                    <tr>
                        <th>Número</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="lista_unidades">
                    <?php if (isset($tabla)) echo $tabla;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Unidades Responsables Gastos -->
    <div class="modal fade" id="unidadesResponsablesGastosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unidad Responsable</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idUnidadResponsable">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label class="control-label" for='rfc'>Número:</label>
                                <input type="text" class="form-control" id="numero" maxlength="2" placeholder="Número">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group ">
                                <label class="control-label" for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelUnidad">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnAddUnidad" style="display: none">Agregar</button>
                    <button type="button" class="btn btn-success" id="btnEditUnidad" style="display: none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>

