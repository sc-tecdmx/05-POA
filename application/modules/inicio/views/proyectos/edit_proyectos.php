<div class="container">
    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <h4>Clave del proyecto: <?php echo $clave; ?></h4>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
            <a class="nav-link active" id="tabProyectos" data-toggle="tab" href="#details">Detalles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tabMetaPrincipal" data-toggle="tab" href="#metaPrincipal">Meta Principal</a>
        </li>
        <?php if($valida): ?>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#metasComplementarias">Metas Complementarias</a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" id="tabIndica" data-toggle="tab" href="#indicadores">Indicadores</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#acciones">Acciones Sustantivas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#programaEspecial">Programa Especial</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#ejecucion">Ejecución del Proyecto</a>
        </li>
    </ul>

    <div class="tab-content clearfix">
        <div class="tab-pane active" id="details">
            <br><br>
            <form id="actualizaProyectoForm">
                <div class="row">
                    <div class="col-md-3">
                        <label>Responsable Operativo</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <?php echo form_error('responsable_operativo_id');
                            echo form_dropdown('responsable_operativo_id', $responsables, set_value('responsable_operativo_id',isset($row->responsable_operativo_id)?$row->responsable_operativo_id:''),'class="form-control" id="responsable_operativo_id" data-form="required"');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>
                    <!--<div class="col-md-3">
                        <label>Programa</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <?php echo form_error('id_programa');
                    echo form_dropdown('id_programa', $programas, set_value('id_programas',isset($row->programa_id)?$row->programa_id:''),'class="form-control" id="id_programa" data-form="required"');
                    ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>-->
                    <div class="col-md-3">
                        <label>Subprograma</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <?php echo form_error('subprograma_id');
                            echo form_dropdown('subprograma_id', $subprogramas, set_value('subprograma_id',isset($row->subprograma_id)?$row->subprograma_id:''),'class="form-control" id="subprograma_id" data-form="required"');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Número de Proyecto</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('numero');
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
                    <div class="col-md-3">
                        <label>Nombre de Proyecto</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('nombre');
                            $data = array(
                                'name'        => 'nombre',
                                'class'       => 'form-control',
                                'id'          => 'nombre',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Nombre'
                            );
                            echo form_textarea($data,set_value('nombre',isset($row->nombre)?$row->nombre:''), 'rows="05"');
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Tipo de Proyecto</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('tipo');
                            $option = array(
                                ''          => '- Seleccionar -',
                                'normal'    => 'NORMAL',
                                'especial'  => 'ESPECIAL'
                            );
                            echo form_dropdown('tipo', $option,set_value('tipo',isset($row->tipo)?$row->tipo:''),'class="form-control" id="tipo" data-form="required"');
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Versión</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('version');
                            $data = array(
                                'name'        => 'version',
                                'class'       => 'form-control',
                                'id'          => 'version',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Versión'
                            );
                            echo form_input($data,set_value('version',isset($row->version)?$row->version:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Objetivo del Proyecto</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('objetivo');
                            $data = array(
                                'name'        => 'objetivo',
                                'class'       => 'form-control',
                                'id'          => 'objetivo',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Objetivo'
                            );
                            echo form_input($data,set_value('objetivo',isset($row->objetivo)?$row->objetivo:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Justificación del Proyecto</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('justificacion');
                            $data = array(
                                'name'        => 'justificacion',
                                'class'       => 'form-control',
                                'id'          => 'justificacion',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Justificación'
                            );
                            echo form_textarea($data,set_value('justificacion',isset($row->justificacion)?$row->justificacion:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Descripción y Alcance del Proyecto</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('descripcion');
                            $data = array(
                                'name'        => 'descripcion',
                                'class'       => 'form-control',
                                'id'          => 'descripcion',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Descripción'
                            );
                            echo form_textarea($data,set_value('descricpion',isset($row->descripcion)?$row->descripcion:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Fecha</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('fecha');
                            $data = array(
                                'name'        => 'fecha',
                                'class'       => 'form-control',
                                'id'          => 'fecha',
                                'type'        => 'date',
                                'data-form'   => 'required',
                                'placeholder' => 'Fecha'
                            );
                            echo form_input($data,set_value('fecha',isset($row->fecha)?$row->fecha:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Nombre de quién revisó</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('nombre_responsable_operativo');
                            $data = array(
                                'name'        => 'nombre_responsable_operativo',
                                'class'       => 'form-control',
                                'id'          => 'nombre_responsable_operativo',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Nombre Responsable Operativo'
                            );
                            echo form_input($data,set_value('nombre_responsable_operativo',isset($row->nombre_responsable_operativo)?$row->nombre_responsable_operativo:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Cargo de quién revisó</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('cargo_responsable_operativo');
                            $data = array(
                                'name'        => 'cargo_responsable_operativo',
                                'class'       => 'form-control',
                                'id'          => 'cargo_responsable_operativo',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Cargo Responsable Operativo'
                            );
                            echo form_input($data,set_value('cargo_responsable_operativo',isset($row->cargo_responsable_operativo)?$row->cargo_responsable_operativo:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Titular de la unidad responsable</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('nombre_titular');
                            $data = array(
                                'name'        => 'nombre_titular',
                                'class'       => 'form-control',
                                'id'          => 'nombre_titular',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Nombre Titular'
                            );
                            echo form_input($data,set_value('nombre_titular',isset($row->nombre_titular)?$row->nombre_titular:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Responsable Ficha</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('responsable_ficha');
                            $data = array(
                                'name'        => 'responsable_ficha',
                                'class'       => 'form-control',
                                'id'          => 'responsable_ficha',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Responsable Ficha'
                            );
                            echo form_input($data,set_value('responsable_ficha',isset($row->responsable_ficha)?$row->responsable_ficha:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Autorizado por</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <?php echo form_error('autorizado_por');
                            $data = array(
                                'name'        => 'autorizado_por',
                                'class'       => 'form-control',
                                'id'          => 'autorizado_por',
                                'type'        => 'text',
                                'data-form'   => 'required',
                                'placeholder' => 'Autorizado por'
                            );
                            echo form_input($data,set_value('autorizado_por',isset($row->autorizado_por)?$row->autorizado_por:''));
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-6">
                        <a href="<?php echo base_url('inicio/proyectos'); ?>" class="btn btn-danger">Cancelar</a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" id="actualizarProyecto">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="metaPrincipal">
            <br><br>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <?php if(!$tablamp): ?>
                    <btn style="cursor: pointer" class="btn btn-primary" id="addMetaPrincipal"><i class="fa fa-plus"></i></btn>
                    <?php endif; ?>
                </div>
                <br><br>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table border="1" class="table">
                            <thead>
                            <tr>
                                <th rowspan="2">Denominación de la meta</th>
                                <th rowspan="2">Unidad de medida</th>
                                <th colspan="12" class="text-center">Meses</th>
                                <th rowspan="2">Total Anual</th>
                                <th rowspan="2">Acciones</th>
                            </tr>
                            <tr>
                                <th>Ene</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Abr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Ago</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dic</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo isset($tablamp)?$tablamp:''; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="metasComplementarias">
            <br><br>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <btn class="btn btn-primary" id="addMetaComplementaria"><i class="fa fa-plus"></i></btn>
                </div>
                <br><br>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table border="1" class="table">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">Denominación de la meta</th>
                                <th rowspan="2">Unidad de medida</th>
                                <th colspan="12">Meses</th>
                                <th rowspan="2">Peso</th>
                                <th rowspan="2">Total Anual</th>
                                <th rowspan="2">Acciones</th>
                            </tr>
                            <tr>
                                <th>Ene</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Abr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Ago</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dic</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo isset($tablamc)?$tablamc:''; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="indicadores">
            <br><br>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <btn class="btn btn-primary" id="addIndicador" style="cursor: pointer"><i class="fa fa-plus"></i></btn>
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table border="1" class="table">
                            <thead class="text-center">
                            <tr>
                                <th>Nombre del indicador</th>
                                <th>Definición del indicador</th>
                                <th>Unidad de medida</th>
                                <th>Método de cálculo</th>
                                <th>Dimensión a medir</th>
                                <th>Frecuencia de medición</th>
                                <th>Meta del indicador</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $indicadores; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="acciones">
            <div class="row mt-3">
                <div class="col-sm-12 text-right">
                    <btn class="btn btn-primary" id="addAccion" style="cursor: pointer"><i class="fa fa-plus"></i></btn>
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table border="1" class="table">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-center">Acciones Sustantivas</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $sustantivas; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="programaEspecial">
            <div class="row mt-3">
                <div class="col-sm-12 text-right">
                    <div class="col-sm-12 text-right">
                        <btn class="btn btn-primary" id="addProgramaEspecial" style="cursor: pointer"><i class="fa fa-plus"></i></btn>
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <div class="table-responsive">
                        <table border="1" class="table">
                            <thead>
                            <tr>
                                <th>Política Pública</th>
                                <th>Acción Sustantiva POA - Enfoque de Genéro</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo isset($programaEspecial)?$programaEspecial:''; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ejecucion">
            <div class="row mt-3">
                <?php if (! isset($ejecucion)):?>
                <div class="col-sm-12 text-right">
                    <btn class="btn btn-primary" id="addEjecucion" style="cursor: pointer"><i class="fa fa-plus"></i></btn>
                </div>
                <?php endif;?>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table border="1" class="table">
                            <thead class="text-center">
                            <tr>
                                <th>ENE </th>
                                <th>FEB</th>
                                <th>MAR</th>
                                <th>ABR</th>
                                <th>MAY</th>
                                <th>JUN</th>
                                <th>JUL</th>
                                <th>AGO</th>
                                <th>SEP</th>
                                <th>OCT</th>
                                <th>NOV</th>
                                <th>DIC</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $ejecucion; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Meta Principal -->
    <div class="modal fade" id="metaPrincipalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Meta Principal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for='nombre' class="control-label">Nombre:</label>
                                <textarea id="tMetaPrincipal" name="tMetaPrincipal" class="form-control" placeholder="Meta Principal" rows="10" cols="50"></textarea>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>¿Cuenta con metas complementarias?</label>
                        </div>
                        <div class="col-md-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="customRadioInline1">Si</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="customRadioInline2">No</label>
                            </div>
                        </div>
                        <div class="col-md-12" style="display: none" id="selectUnidad">
                            <div class="form-group">
                                <label class="control-label">Unidad Medida:</label>
                                <?php echo form_dropdown('unidadMedidaP', $unidadesmp, set_value('unidadMedidaP',isset($row->unidad_medida_id)?$row->unidad_medida_id:''),'class="form-control" id="unidadMedidaP" data-form="required"'); ?>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelMetaPrincipal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnCrearMetaPrincipal" style="display: none">Guardar</button>
                    <button type="button" class="btn btn-success" id="btnEditMetaPrincipal" style="display: none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Meta Complementaria -->
    <div class="modal fade" id="metaComplementariaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Meta Complementaria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idMetaComplementaria" id="idMetaComplementaria">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Unidad Medida:</label>
                                <?php echo form_dropdown('unidad_medida_id', $unidadesm, set_value('unidad_medida_id',isset($row->unidad_medida_id)?$row->unidad_medida_id:''),'class="form-control" id="unidad_medida_id" data-form="required"'); ?>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for='nombre' class="control-label">Nombre:</label>
                                <textarea id="tMetaComplementaria" name="tMetaComplementaria" class="form-control" placeholder="Meta Complementaria" rows="10" cols="50"></textarea>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <!--<div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Orden:</label>
                                <input type="text" id="ordenMetaC" name="ordenMetaC" class="form-control" placeholder="Orden" rows="10" cols="50"></input>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Peso:</label>
                                <input type="text" id="pesoMetaC" name="pesoMetaC" class="form-control" placeholder="Peso" rows="10" cols="50"></input>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelMetaComplementaria">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnCrearMetaComplementaria" style="display: none">Guardar</button>
                    <button type="button" class="btn btn-success" id="btnEditMetaComplementaria" style="display: none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Indicadores -->
    <div class="modal fade" id="indicadoresModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Indicadores</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="identificador" id="idIndicador">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Meta:</label>
                                <?php echo form_dropdown('meta_id', $metas, set_value('meta_id',isset($row->meta_id)?$row->meta_id:''),'class="form-control" id="metaIdIndicador" data-form="required"'); ?>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Unidad Medida:</label>
                                <?php echo form_dropdown('unidad_medida_id', $unidadesm, set_value('unidad_medida_id',isset($row->unidad_medida_id)?$row->unidad_medida_id:''),'class="form-control" id="unidadIndicador" data-form="required"'); ?>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Dimensión:</label>
                                <?php echo form_dropdown('dimension_id', $dimensiones, set_value('dimension_id',isset($row->dimension_id)?$row->unidad_medida_id:''),'class="form-control" id="dimension_id" data-form="required"'); ?>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Frecuencia:</label>
                                <?php echo form_dropdown('frecuencia_id', $frecuencias, set_value('frecuencia_id',isset($row->frecuencia_id)?$row->frecuencia_id:''),'class="form-control" id="frecuencia_id" data-form="required"'); ?>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for='nombre' class="control-label">Nombre:</label>
                                <textarea id="tIndicador" name="tIndicador" class="form-control" placeholder="Indicador" rows="10" cols="50"></textarea>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Definición:</label>
                                <textarea type="text" id="definicionIndicador" name="definicionIndicador" class="form-control" placeholder="Orden" rows="10" cols="50"></textarea>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Método Cálculo:</label>
                                <textarea type="text" id="metodoCalculoIndicador" name="metodoCalculoIndicador" class="form-control" placeholder="Método Cálculo" rows="10" cols="50"></textarea>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Meta:</label>
                                <input type="text" id="metaIndicador" name="metaIndicador" class="form-control" placeholder="Meta" rows="10" cols="50"></input>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelIndicadores">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnCrearIndicador" style="display: none">Guardar</button>
                    <button type="button" class="btn btn-success" id="btnEditIndicador" style="display: none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Acciones Sustantivas -->
    <div class="modal fade" id="accionesSustantivasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Acciones Sustantivas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idAccion" id="idAccion">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for='nombre' class="control-label">Número:</label>
                                <textarea id="numeroAccion" name="numeroAccion" class="form-control" placeholder="Número" rows="10" cols="50"></textarea>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Descripción:</label>
                                <textarea type="text" id="descripcionAccion" name="descripcionAccion" class="form-control" placeholder="Descripcion" rows="10" cols="50"></textarea>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelAccion">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnCrearAccion" style="display: none">Guardar</button>
                    <button type="button" class="btn btn-success" id="btnEditAccion" style="display: none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Ejecución del Proyecto -->
    <div class="modal fade" id="ejecucionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ejecución del Proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php
                        $meses = catalogoInterno('meses_nombres');
                        for($i = 1; $i <= 12; $i++):
                            ?>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="CustomCheck<?php echo $i; ?>">
                                    <label class="custom-control-label" for="CustomCheck<?php echo $i; ?>"><?php echo $meses[$i]; ?></label>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelEjecucion">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnCrearEjecucion" style="display: none">Guardar</button>
                    <button type="button" class="btn btn-success" id="btnEditEjecucion" style="display: none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Meses Metas Principales -->
    <div class="modal fade" id="mesesMetaPrincipalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" name="pmeta" id="pmeta">
                        <input type="hidden" name="pmes" id="pmes">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Meta:</label>
                                <input type="text" id="numeroMetaP" name="numeroMetaP" class="form-control" placeholder="Meta">
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelMesesMetaP">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnEditMesesMetaP">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Meses Metas Complementarias -->
    <div class="modal fade" id="mesesMetasComplementariasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" name="cmeta" id="cmeta">
                        <input type="hidden" name="cmes" id="cmes">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Meta:</label>
                                <input type="text" id="numeroMetaC" name="numeroMetaC" class="form-control" placeholder="Meta" rows="10" cols="50"></input>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelMesesMetas">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnEditMesesMetas">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Programa Especial -->
    <div class="modal fade" id="specialProgramModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Programa Especial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- <input type="hidden" name="cmeta" id="cmeta">
                        <input type="hidden" name="cmes" id="cmes">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Meta:</label>
                                <input type="text" id="numeroMetaC" name="numeroMetaC" class="form-control" placeholder="Meta" rows="10" cols="50"></input>
                                <small class="form-text text-muted">*Campo obligatorio</small>
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCancelMesesMetas">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnEditMesesMetas">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>
