<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Ejercicio</h3>
            <?php validation_errors();  ?>
            <?php
            $attributes = array('id'=>'anteproyecto','data-form'=>'validate');
            echo form_open('', $attributes);
            ?>
            <div class="row">
                <div class="col-md-10">
                    <div class="form-inline">
                        <?php echo form_error('anio'); ?>
                        <?php echo form_dropdown('anio', $anios, date('Y'), 'class="selectpicker"'); ?>
                        <button class="btn btn-outline-success float-right ml-4" type="submit">Generar</button>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>

