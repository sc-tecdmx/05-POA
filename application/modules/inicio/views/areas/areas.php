<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>Áreas</h3>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-outline-primary" id="addArea">
                Agregar Área <i class="fa fa-fw fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <!--Empieza tabla-->
                <table class="table table-striped table-responsive" id="tabla_areas">
                    <thead>
                    <tr>
                        <th>Número</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="lista_areas">
                    <?php if (isset($tabla)) echo $tabla;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Programas -->
    <div class="modal fade" id="areasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Programas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idArea" id="idArea">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <?php echo form_error('nombre'); ?>
                                <label class="control-label" for="nombre">Nombre:</label>
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
                        <div class="col-md-12">
                            <div class="form-group ">
                                <?php echo form_error('descripcion'); ?>
                                <label class="control-label" for="nombre">Descripción:</label>
                                <?php
                                $data = array(
                                    'name'        => 'descripcion',
                                    'class'       => 'form-control',
                                    'id'          => 'descripcion',
                                    'type'        => 'text',
                                    'data-form'   => 'required',
                                    'placeholder' => 'Descripción'
                                );
                                echo form_textarea($data,set_value('descripcion',isset($row->descripcion)?$row->descripcion:''));
                                ?>
                                <small class="form-text text-muted">* Campo obligatorio</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelArea">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnAddArea" style="display: none">Guardar</button>
                    <button type="button" class="btn btn-success" id="btnEditArea" style="display: none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>


