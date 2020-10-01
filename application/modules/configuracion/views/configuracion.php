<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Ejercicios</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo form_error('anio'); ?>
                        <?php
                        echo form_dropdown('ejercicio', $anios, '2020', 'class="form-control" id="ejercicio"');
                        ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="habilitarElaboracion">
                        <label class="form-check-label" for="defaultCheck1">
                            Habilitar elaboración de fichas POA
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Permisos</h3>
            <div class="col-md-8">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="editElaboracion">
                    <label class="form-check-label" for="defaultCheck1">
                        Permitir edición sobre Elaboración de Fichas POA
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-success float-right" id="configurarElaboracion">Configurar</button>
        </div>
        <!--<div class="col-md-12">
            <a href="<?php echo base_url('inicio/script_actualizacion'); ?>" class="btn btn-success">Actualizar</a>
        </div>-->
    </div>
</div>
