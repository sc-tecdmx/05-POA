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
                    Meta Principal
                    <a href="<?php echo base_url('inicio/proyectos');?>" class="btn btn-danger float-right">
                        Cancelar
                    </a>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <h4 class="card-tittle mb-3">Introduce los siguientes datos para agregar una meta principal:</h4>
            <?php validation_errors();
            $attributes = array('id'=>'accionesSustantivas','data-form'=>'validate');
            echo form_open('', $attributes);
            ?>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <?php echo form_error('numero'); ?>
                        <label for='nombre' class="control-label">Número:</label>
                        <?php
                        $data = array(
                            'name'        => 'numero',
                            'class'       => 'form-control',
                            'id'          => 'numero',
                            'type'        => 'text',
                            'data-form'   => 'required',
                            'placeholder' => 'Número'
                        );
                        echo form_textarea($data,set_value('numero',isset($row->numero)?$row->numero:''));
                        ?>
                        <small class="form-text text-muted">*Campo obligatorio</small>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <?php echo form_error('descripcion'); ?>
                        <label for='descripcion' class="control-label">Descripción:</label>
                        <?php
                        $data = array(
                            'name'        => 'descripcion',
                            'class'       => 'form-control',
                            'id'          => 'descripcion',
                            'type'        => 'text',
                            'data-form'   => 'required',
                            'placeholder' => 'Descripción'
                        );
                        echo form_textarea($data,set_value('descripcion',isset($row->descripcion)?$row->descricpion:''));
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
                        <table class="table" id="elaboracionAccionesSustantivas">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Acción Sustantiva</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $acciones; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


