<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Unidades de Medida</h3>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-outline-primary" id="addUnidadesMedida">
                Agregar Unidad Medida<i class="fa fa-fw fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <!--Empieza tabla-->
                <table class="table table-striped table-responsive" id="tabla_medidas">
                    <thead>
                    <tr>
                        <th>Número</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
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
    <!-- Modal Unidades Medidas -->
    <div class="modal fade" id="unidadesMedidaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unidad de Medida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idUnidadMedida">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label class="control-label" for='rfc'>Número:</label>
                                <input type="text" name="numero" class="form-control" placeholder="Número" id="numero">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group ">
                                <label class="control-label" for="nombre">Nombre:</label>
                                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="descripcion">Descripción:</label>
                                <textarea type="text" name="descripcion" class="form-control" id="descripcion" placeholder="Nombre"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="CustomCheck">
                                <label class="custom-control-label" for="CustomCheck">¿Se medirá por porcentajes?</label>
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



