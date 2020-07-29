<div class="container">
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
                    Metas Complementarias
                    <a href="<?php echo base_url('inicio/proyectos');?>" class="btn btn-danger float-right">
                        Cancelar
                    </a>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <h4 class="card-tittle mb-3">Introduce los siguientes datos para agregar una meta complementaria:</h4>
            <?php validation_errors();
            $attributes = array('id'=>'metaPrincipal','data-form'=>'validate');
            echo form_open('', $attributes);
            ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo form_error('unidad_medida_id'); ?>
                        <label for='nombre' class="control-label">Unidad Medida:</label>
                        <?php echo form_dropdown('unidad_medida_id', $unidadesm, set_value('unidad_medida_id',isset($row->unidad_medida_id)?$row->unidad_medida_id:''),'class="form-control" id="unidad_medida_id" data-form="required"'); ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo form_error('orden'); ?>
                        <label for='orden' class="control-label">Orden:</label>
                        <?php
                        $data = array(
                            'name'        => 'orden',
                            'class'       => 'form-control',
                            'id'          => 'orden',
                            'type'        => 'text',
                            'data-form'   => 'required',
                            'placeholder' => 'Orden'
                        );
                        echo form_input($data,set_value('orden',isset($row->orden)?$row->orden:''));
                        ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo form_error('nombre'); ?>
                        <label for='peso' class="control-label">Peso:</label>
                        <?php
                        $data = array(
                            'name'        => 'peso',
                            'class'       => 'form-control',
                            'id'          => 'pes',
                            'type'        => 'text',
                            'data-form'   => 'required',
                            'placeholder' => 'Peso'
                        );
                        echo form_input($data,set_value('peso',isset($row->peso)?$row->peso:''));
                        ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo form_error('nombre'); ?>
                        <label for='nombre' class="control-label">Nombre:</label>
                        <?php
                        $data = array(
                            'name'        => 'nombre',
                            'class'       => 'form-control',
                            'id'          => 'nombre',
                            'type'        => 'text',
                            'data-form'   => 'required',
                            'placeholder' => 'Nombre'
                        );
                        echo form_textarea($data,set_value('nombre',isset($row->nombre)?$row->nombre:''));
                        ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-success float-right" type="submit"><?php echo (isset($update)?"Actualizar":"Agregar") ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="elaboracionMetaPrincipal">
                            <thead>
                            <tr>
                                <th rowspan="2">Denominación de la meta</th>
                                <th rowspan="2">Unidad de medida</th>
                                <th colspan="12" class="text-center">Meses</th>
                                <th rowspan="2">Peso</th>
                                <th rowspan="2">Total Anual</th>
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
                            <?php echo $tablamc; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


