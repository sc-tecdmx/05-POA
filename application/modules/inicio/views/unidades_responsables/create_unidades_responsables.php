<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="col-12">
                <h3 class="card-text">
                    <?php
                    echo (isset($update)?"Actualizar datos de la unidad responsable":"Agregar nueva unidad responsable");
                    ?>
                    <a href="<?php echo base_url('inicio/unidades_responsables');?>" class="btn btn-danger float-right">
                        Cancelar
                    </a>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <h4 class="card-tittle mb-3">Introduce los siguientes datos para <?php echo (isset($update)?"actualizar":"agregar") ?> una unidad responsable:</h4>
            <?php validation_errors();  ?>
            <?php $attributes = array('id'=>'unidad_responsable','data-form'=>'validate'); ?>
            <form id="unidad_responsable">
                <input type="hidden" id="umode" value="<?php echo (isset($update)?"edit":"add") ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <?php echo form_error('rfc'); ?>
                            <label class="control-label" for='rfc'>Número:</label>
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
                        <?php if(isset($update)): ?>
                        <button class="btn btn-success float-right" id="editUnidad">Actualizar</button>
                        <?php else: ?>
                        <button class="btn btn-success float-right" id="addUnidad">Agregar</button>
                        <?php endif; ?>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>
