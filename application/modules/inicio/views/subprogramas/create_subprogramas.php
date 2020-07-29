<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="col-12">
                <h3 class="card-text">
                    <?php
                    echo (isset($update)?"Actualizar datos del subprogramas":"Agregar nuevo subprograma");
                    ?>
                    <a href="<?php echo base_url('inicio/subprogramas');?>" class="btn btn-danger float-right">
                        Cancelar
                    </a>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <h4 class="card-tittle mb-3">Introduce los siguientes datos para <?php echo (isset($update)?"actualizar":"agregar") ?> un subprograma:</h4>
            <?php validation_errors();  ?>
            <?php
            $attributes = array('id'=>'subprogramas','data-form'=>'validate');
            echo form_open('', $attributes);
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo form_error('programa_id'); ?>
                        <label class="control-label" for="programa_id">Programa:</label>
                        <?php
                        echo form_dropdown('programa_id', $programas, set_value('programa_id',isset($row->programa_id)?$row->programa_id:''),'class="form-control" id="programa_id" data-form="required"');
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
                    <button class="btn btn-success float-right" type="submit"><?php echo (isset($update)?"Actualizar":"Agregar") ?></button>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>
