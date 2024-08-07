<!--<div class="container"> -->
    <?php if(isset($mensaje)):?>
        <div class="row">
            <div class="col">
                <?php echo $mensaje;?>
            </div>
        </div>
    <?php endif;?>
    <div class="card">
        <div class="card-header">
            <div class="col-12">
                <h3 class="card-text">
                    <?php
                    echo (isset($update)?"Actualizar datos del proyecto":"Agregar nuevo proyectox");
                    ?>
                    <a href="<?php echo base_url('inicio/proyectos');?>" class="btn btn-danger float-right">
                        Cancelar
                    </a>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <h4 class="card-tittle mb-3">Introduce los siguientes datos para <?php echo (isset($update)?"actualizar":"agregar") ?> un proyecto:</h4>
            <form id="createProjectForm">
                <div class="row">
                    <div class="col-md-3">
                        <label>Unidad Responsable del Gasto</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <?php echo form_error('unidad_responsable_gasto_id');
                            echo form_dropdown('unidad_responsable_gasto_id', $unidades, set_value('unidad_responsable_gasto_id',isset($row->unidad_responsable_gasto_id)?$row->unidad_responsable_gasto_id:''),'class="form-control" id="unidad_responsable_gasto_id" required');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Responsable Operativo</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <?php echo form_error('responsable_operativo_id'); ?>
                            <select id="responsable_operativo_id" name="responsable_operativo_id" class="form-control" required>
                                <option value=""> - Selecciona uno -</option>
                            </select>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Programa</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <?php echo form_error('programa_id');
                            echo form_dropdown('programa_id', $programas, set_value('programa_id',isset($row->programa_id)?$row->programa_id:''),'class="form-control" id="programa_id" data-form="required" required');
                            ?>
                            <small class="form-text text-muted">*Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Subprograma</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <?php echo form_error('subprograma_id'); ?>
                            <select id="subprograma_id" class="form-control" name="subprograma_id" required>
                                <option value=""> - Selecciona uno -</option>
                            </select>
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
                            echo form_input($data,set_value('numero',isset($row->numero)?$row->numero:''), 'required');
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
                            echo form_textarea($data,set_value('nombre',isset($row->nombre)?$row->nombre:''), 'rows="05" required');
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
                            echo form_dropdown('tipo', $option,set_value('tipo',isset($row->tipo)?$row->tipo:''),'class="form-control" id="tipo" data-form="required" required');
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
                            echo form_input($data,set_value('version',isset($row->version)?$row->version:''), 'required');
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
                            echo form_input($data,set_value('objetivo',isset($row->objetivo)?$row->objetivo:''), 'required');
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
                            echo form_textarea($data,set_value('justificacion',isset($row->justificacion)?$row->justificacion:''), 'required');
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
                            echo form_textarea($data,set_value('descricpion',isset($row->descripcion)?$row->descripcion:''), 'required');
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
                            echo form_input($data,set_value('fecha',isset($row->fecha)?$row->fecha:''), 'required');
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Nombre Responsable Operativo</label>
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
                            echo form_input($data,set_value('nombre_responsable_operativo',isset($row->nombre_responsable_operativo)?$row->nombre_responsable_operativo:''), 'required');
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Cargo Responsable Operativo</label>
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
                            echo form_input($data,set_value('cargo_responsable_operativo',isset($row->cargo_responsable_operativo)?$row->cargo_responsable_operativo:''), 'required');
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Nombre Titular</label>
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
                            echo form_input($data,set_value('nombre_titular',isset($row->nombre_titular)?$row->nombre_titular:''), 'required');
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
                            echo form_input($data,set_value('responsable_ficha',isset($row->responsable_ficha)?$row->responsable_ficha:''), 'required');
                            ?>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Autorizado por</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group ">
                            <input type="text" class="form-control" name="autorizado_por" id="autorizado_por" placeholder="Autorizado por" required>
                            <small class="form-text text-muted">* Campo obligatorio</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-success float-right" id="agregarProyecto">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!--</div>-->
