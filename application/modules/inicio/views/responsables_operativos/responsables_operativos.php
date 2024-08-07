<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Responsables Operativos</h3>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-outline-primary" id="addResponsableOperativo">
                Agregar Responsable Operativo <i class="fa fa-fw fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <!--Empieza tabla-->
                <table class="table table-striped table-responsive" id="tabla_responsables">
                    <thead>
                    <tr>
                        <th>URG</th>
                        <th>RO</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="lista_responsables">
                    <?php if (isset($tabla)) echo $tabla;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Responsable Operativo -->
    <div class="modal fade" id="responsableOperativoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Responsables Operativos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idResponsableOperativo" id="idResponsableOperativo">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo form_error('id_unidad_responsable'); ?>
                                <label class="control-label" for="id_unidad_responsable">Unidad Responsable Gasto:</label>
                                <?php
                                echo form_dropdown('id_unidad_responsable', $unidades, set_value('id_unidad_responsable',isset($row->unidad_responsable_gasto_id)?$row->unidad_responsable_gasto_id:''),'class="form-control" id="unidad_responsable_id" data-form="required"');
                                ?>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <?php echo form_error('numero'); ?>
                                <label class="control-label" for='numero'>Número:</label>
                                <?php
                                $data = array(
                                    'name'        => 'numero',
                                    'class'       => 'form-control',
                                    'id'          => 'numero',
                                    'type'        => 'text',
                                    'data-form'   => 'required',
                                    'placeholder' => 'Número'
                                );
                                echo form_input($data,set_value('numero',isset($row->numero)?$row->numero:''));
                                ?>
                                <small class="form-text text-muted">* Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group ">
                                <?php echo form_error('nombre'); ?>
                                <label class="control-label" for="nombre">Nombrex:</label>
                                <?php
                                $data = array(
                                    'name'        => 'nombre',
                                    'class'       => 'form-control',
                                    'id'          => 'nombre',
                                    'type'        => 'text',
                                    'data-form'   => 'required',
                                    'placeholder' => 'Nombre'
                                );
                                echo form_input($data,set_value('nombre',isset($row->nombre)?$row->nombre:''));
                                ?>
                                <small class="form-text text-muted">* Campo obligatorio</small>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelResponsableOperativo">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnAddResponsableOperativo" style="display: none">Guardar</button>
                    <button type="button" class="btn btn-success" id="btnEditResponsableOperativo" style="display: none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>


