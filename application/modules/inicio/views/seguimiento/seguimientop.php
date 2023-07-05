<!--<div class="container">-->
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Meta principal
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-center">
                        <?php echo $encabezadomp; ?>
                        </thead>
                        <tbody>
                        <?php echo $tablamp; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Mes Meta Principal -->
    <div class="modal fade" id="detallesMetaPrincipal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Explicaciones Meta Principal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul id="descripcion">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelDetalles">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!-- Modal Avance Meta Complementaria Normal -->
<div class="modal fade" id="seguimientoPrincipalNormalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguimiento de Meta</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="idMetaPrincipalNormal">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo form_error('mes_id'); ?>
                            <label class="control-label" for="mes_id">Mes:</label>
                            <?php
                            echo form_dropdown('mes_id', $meses, set_value('mes_id',isset($row->mes_id)?$row->mes_id:''),'class="form-control" id="mes_id" data-form="required"');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-6">
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
                    <div class="col-md-12">
                        <div class="form-group ">
                            <?php echo form_error('explicacion'); ?>
                            <label class="control-label" for="expliacion">Explicación:</label>
                            <?php
                            $data = array(
                                'name'        => 'explicacion',
                                'class'       => 'form-control',
                                'id'          => 'explicacion',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Explicación'
                            );
                            echo form_textarea($data,set_value('explicacion',isset($row->explicacion)?$row->explicacion:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnCancelSeguimientoPrincipalNormal">Cancelar</button>
                <button class="btn btn-success float-right" id="btnAddSeguimientoPrincipalNormal">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Avance Meta Complementaria Nueva Medida -->
<div class="modal fade" id="seguimientoPrincipalPorcentajesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguimiento de Meta</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="idMetaPrincipalPorcentaje">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo form_error('mes_id'); ?>
                            <label class="control-label" for="mes_id">Mes:</label>
                            <?php
                            echo form_dropdown('mes_id', $meses, set_value('mes_id',isset($row->mes_id)?$row->mes_id:''),'class="form-control" id="mesIdR" data-form="required"');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <?php echo form_error('numero_resueltos'); ?>
                            <label class="control-label" for='numero_resueltos'>Atendidos:</label>
                            <?php
                            $data = array(
                                'name'        => 'numero_resueltos',
                                'class'       => 'form-control',
                                'id'          => 'numero_resueltos',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Número'
                            );
                            echo form_input($data,set_value('numero_resueltos',isset($row->numero_resueltos)?$row->numero_resueltos:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <?php echo form_error('numero'); ?>
                            <label class="control-label" for='numero'>Recibidos:</label>
                            <?php
                            $data = array(
                                'name'        => 'numeror',
                                'class'       => 'form-control',
                                'id'          => 'numeror',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Número'
                            );
                            echo form_input($data,set_value('numero',isset($row->numero)?$row->numero:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <?php echo form_error('explicacion'); ?>
                            <label class="control-label" for="expliacion">Explicación:</label>
                            <?php
                            $data = array(
                                'name'        => 'explicacion',
                                'class'       => 'form-control',
                                'id'          => 'explicacionR',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Explicación'
                            );
                            echo form_textarea($data,set_value('explicacion',isset($row->explicacion)?$row->explicacion:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnCancelSeguimientoPorcentaje">Cancelar</button>
                <button class="btn btn-success float-right" id="btnAddSeguimientoPrincipalPorcentaje">Guardar</button>
            </div>
        </div>
    </div>
</div>
