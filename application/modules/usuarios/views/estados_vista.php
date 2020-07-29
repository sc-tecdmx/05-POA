<div class="row mt-1">
    <div class="col">
        <?php
        if(isset($mensaje)) echo $mensaje;
        ?>
        <?php if (validation_errors()!=""): ?>
            <div class="errormsj" > <span> Error </span><?php echo validation_errors();?></div>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <?php echo form_open();?>
        <div class="row m-4">
            <div class="col">
                <div class="card">
                    <div class="row m-1">
                        <div class="col">
                            <h5>Seleccione los privilegios:</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="row m-1">
                        <?php foreach ($perfiles as $perfil):?>
                            <div class="col">
                                <div class="form-group">
                                    <label for="<?php echo 'm' . $perfil->id_perfil;?>">
                                        <?php
                                        $data = array(
                                            'name'    => 'perfiles',
                                            'id'      => 'm' . $perfil->id_perfil,
                                            'value'   => $perfil->id_perfil,
                                            'checked' => TRUE,
                                            //'class'   => 'form-control'
                                        );

                                        echo form_radio($data);
                                        ?>
                                        <?php echo $perfil->perfil;?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-4">
            <div class="col">
                <div class="card">
                    <div class="row m-1">
                        <div class="col">
                            <h5>Seleccione los estados:</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="row m-1">
                        <?php foreach ($areas as $estado):?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="<?php echo $estado->area_id;?>">
                                        <?php
                                        $data = array(
                                            'name'    => 'estados[' . $estado->nombre . ']',
                                            'id'      => $estado->area_id,
                                            'value'   => $estado->area_id,
                                            'checked' => TRUE,
                                            //'class'   => 'form-control'
                                        );

                                        echo form_checkbox($data);
                                        ?>
                                        <?php echo $estado->nombre;?>
                                    </label>
                                </div>
                                <hr>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 offset-sm-3 col-md-3 offset-md-3">
            <button type="submit"  class="btn btn-success pull-right"><span class="glyphicon glyphicon-saved"></span>Guardar</button>
        </div>
        <?php echo form_close();?>
    </div>
</div>
