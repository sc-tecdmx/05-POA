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
                    <?php
                    echo (isset($update)?"Actualizar meta complementaria":"Agregar meta complementaria");
                    ?>
                    <a href="javascript:history.go(-1)" class="btn btn-danger float-right">
                        Cancelar
                    </a>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <h4 class="card-tittle mb-3">Introduce los siguientes datos para <?php echo (isset($update)?"actualizar":"agregar") ?> una meta complementaria:</h4>
            <?php validation_errors();  ?>
            <?php
            $attributes = array('id'=>'meta_complementaria','data-form'=>'validate');
            echo form_open('', $attributes);
            ?>
            <div class="row">
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
