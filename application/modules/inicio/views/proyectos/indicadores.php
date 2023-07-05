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
                    Indicadores
                    <a href="<?php echo base_url('inicio/proyectos');?>" class="btn btn-danger float-right">
                        Cancelar
                    </a>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <h4 class="card-tittle mb-3">Introduce los siguientes datos para agregar una meta principal:</h4>
            <?php validation_errors();
            $attributes = array('id'=>'indicadores','data-form'=>'validate');
            echo form_open('', $attributes);
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo form_error('meta_id'); ?>
                        <label for='meta_id' class="control-label">Meta:</label>
                        <?php echo form_dropdown('meta_id', $metas, set_value('meta_id',isset($row->meta_id)?$row->meta_id:''),'class="form-control" id="meta_id" data-form="required"'); ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo form_error('unidad_medida_id'); ?>
                        <label for='unidad_medida_id' class="control-label">Unidad Medida:</label>
                        <?php echo form_dropdown('unidad_medida_id', $umedidas, set_value('unidad_medida_id',isset($row->unidad_medida_id)?$row->unidad_medida_id:''),'class="form-control" id="unidad_medida_id" data-form="required"'); ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo form_error('dimension'); ?>
                        <label for='dimension' class="control-label">Dimensión:</label>
                        <?php echo form_dropdown('dimension_id', $dimension, set_value('dimension_id',isset($row->dimension_id)?$row->dimension_id:''),'class="form-control" id="dimension_id" data-form="required"'); ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo form_error('frecuencia'); ?>
                        <label for='frecuencia' class="control-label">Frecuencia:</label>
                        <?php echo form_dropdown('frecuencia_id', $frecuencia, set_value('frecuencia_id',isset($row->dimension_id)?$row->dimension_id:''),'class="form-control" id="dimension_id" data-form="required"'); ?>
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
                    <div class="form-group">
                        <?php echo form_error('definicion'); ?>
                        <label for='definicion' class="control-label">Definición:</label>
                        <?php
                        $data = array(
                            'name'        => 'definicion',
                            'class'       => 'form-control',
                            'id'          => 'definicion',
                            'type'        => 'text',
                            'data-form'   => 'required',
                            'placeholder' => 'Definicion'
                        );
                        echo form_textarea($data,set_value('definicion',isset($row->definicion)?$row->definicion:''));
                        ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo form_error('metodo_calculo'); ?>
                        <label for='metodo_calculo' class="control-label">Método de Cálculo:</label>
                        <?php
                        $data = array(
                            'name'        => 'metodo_calculo',
                            'class'       => 'form-control',
                            'id'          => 'metodo_calculo',
                            'type'        => 'text',
                            'data-form'   => 'required',
                            'placeholder' => 'Método de Cálculo'
                        );
                        echo form_textarea($data,set_value('metodo_calculo',isset($row->metodo_calculo)?$row->metodo_calculo:''));
                        ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo form_error('meta'); ?>
                        <label for='definicion' class="control-label">Meta:</label>
                        <?php
                        $data = array(
                            'name'        => 'meta',
                            'class'       => 'form-control',
                            'id'          => 'meta',
                            'type'        => 'text',
                            'data-form'   => 'required',
                            'placeholder' => 'Meta'
                        );
                        echo form_textarea($data,set_value('meta',isset($row->meta)?$row->meta:''));
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
                                <th>Nombre del Indicador</th>
                                <th>Definición del Indicador</th>
                                <th>Unidad de Medida</th>
                                <th>Método de Cálculo</th>
                                <th>Dimensión a Medir</th>
                                <th>Frecuencia de Medición</th>
                                <th>Meta del Indicador</th>
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
    </div>
</div>


