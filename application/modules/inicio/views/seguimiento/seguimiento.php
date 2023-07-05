<!--<div class="container">-->
    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <h4>Clave del proyecto: <?php echo $clave; ?></h4>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#seguimiento">Seguimiento POA</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#avance">Avance POA</a>
        </li>
    </ul>

    <div class="tab-content clearfix">
        <div class="tab-pane active" id="seguimiento">
            <ul class="nav nav-tabs mt-5">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#metaPrincipal">Meta Principal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#metasComplementarias">Metas Complementarias</a>
                </li>
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="metaPrincipal">
                    <div class="card mt-3">
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
                <div class="tab-pane" id="metasComplementarias">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                    <?php echo $encabezadomc; ?>
                                    <!--<?php echo $meseshc; ?>-->
                                    </thead>
                                    <tbody>
                                    <?php echo $tablamc; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="avance">
            <div class="card">
                <div class="card-body">
                    <fieldset class="form-group mt-4">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="radio" name="gridRadios" id="gridRadios1" value="mensual">
                                    <label for="gridRadios1">
                                        Avance Mensual y Acumulado
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <input type="radio" name="gridRadios" id="gridRadios2" value="trimestral">
                                    <label for="gridRadios2">
                                        Avance Trimestral y Acumulado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row mt-4">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <select class="form-control" id="selectAvance">
                                <option value="">- Selecciona uno -</option>
                            </select>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="row mt-4" id="tablaAvances" style="display: none">
                        <!--<ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#principal">Meta Principal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#complementaria">Meta Complementaria</a>
                            </li>
                        </ul>
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="principal">
                                <div class="table-responsive">

                                </div>
                                <br><br>
                                <h6>Explicación del Avance Físico</h6>
                            </div>
                            <div class="tab-pane" id="complementaria">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th rowspan="2">Denominación de la meta</th>
                                            <th rowspan="2">Unidad de medida</th>
                                            <th colspan="3">Mes</th>
                                            <th colspan="3">Acumulado Enero - Mes</th>
                                        </tr>
                                        <tr>
                                            <th>Programada</th>
                                            <th>Alcanzada</th>
                                            <th>Avance %</th>
                                            <th>Programada</th>
                                            <th>Alcanzada</th>
                                            <th>Avance %</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <br><br>
                                <h6>Explicación del Avance Físico</h6>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Mes Meta Principal -->
    <div class="modal fade" id="detallesMetaPrincipal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Meses Metas Complementarias</h5>
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
<div class="modal fade" id="seguimientoNormalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguimiento de Meta</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="idMetaComplementariaNormal">
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
                <button type="button" class="btn btn-danger" id="btnCancelSeguimientoNormal">Cancelar</button>
                <button class="btn btn-success float-right" id="btnAddSeguimientoNormal">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Avance Meta Complementaria Nueva Medida -->
<div class="modal fade" id="seguimientoPorcentajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguimiento de Meta</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="idMetaComplementariaPorcentaje">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo form_error('mes_id'); ?>
                            <label class="control-label" for="mes_id">Mes:</label>
                            <?php
                            echo form_dropdown('mes_id', $meses, set_value('mes_id',isset($row->mes_id)?$row->mes_id:''),'class="form-control" id="mesIdR" data-form="required" onchange="changeMonthPercentage()"');
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
                <button class="btn btn-success float-right" id="btnAddSeguimientoPorcentaje">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--</div>-->

<!-- Modal Explicación -->
<div class="modal fade" id="explicacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Explicación de Meta</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<p id="explicacionMes"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="btnCancelExplicacionModal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
