<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Tablero administrativo</h3>
        </div>
        <!--<div class="col-md-6 text-right">
            <button class="btn btn-outline-primary" id="addUnidadResponsable">
                Agregrar Unidad Responsable <i class="fa fa-fw fa-plus"></i>
            </button>
        </div>-->
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
                        <th>Estado</th>
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
                        <?php if($this->session->userdata('validacion') == 1): ?>
                            <div class="col-md-8" style="display: none" id="content-cerrada">
                                <div class="form-group">
                                    <?php echo form_error('cerrada'); ?>
                                    <label class="control-label" for="cerrada">Estatus de Edición y Registro:</label>
                                    <?php
                                    $options = array(
                                        '0' => 'Abierta',
                                        '1' => 'Cerrada'
                                    );

                                    // Asegúrate de que el valor seleccionado sea '0' o '1'
                                    $selected_value = set_value('cerrada', isset($row->cerrada) ? strval($row->cerrada) : '0');

                                    echo form_dropdown('cerrada', $options, $selected_value, 'class="form-control" id="cerrada" data-form="required"');
                                    ?>
                                    <small class="form-text text-muted">*Campo obligatorio</small>
                                </div>
                            </div>
                        <?php endif; ?>
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

