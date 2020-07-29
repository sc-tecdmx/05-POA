<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Permisos sobre el seguimiento de fichas POA</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mt-3">
                    Ejercicio
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-check form-check-inline">
                        <?php echo form_error('anio'); ?>
                        <?php
                        echo form_dropdown('ejercicio', $anios, date('Y'), 'class="selectpicker" id="ejercicio"');
                        ?>
                        <input class="form-check-input ml-3" type="checkbox" id="habilitarSeguimiento">
                        <label class="form-check-label" for="defaultCheck1">
                            Habilitar seguimiento POA
                        </label>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    Permisos sobre la captura de metar principales y complementarias
                </div>
                <div class="col-md-3 mt-3">
                    <?php
                    $data = [
                        'name'  => 'captura',
                        'id'    => 'capturag',
                        'value' => 'global'
                    ];

                    echo form_radio($data);
                    ?>
                    <label class="control-label">Captura Global</label><br>
                    <?php
                    $data = [
                        'name'  => 'captura',
                        'id'    => 'capturae',
                        'value' => 'especifica'
                    ];

                    echo form_radio($data);
                    ?>
                    <label class="control-label">Captura Específica</label>
                </div>
                <div class="col-md-3" style="display: none" id="usuarios">
                    <?php echo form_dropdown('users', $users, '', 'class="selectpicker" id="users" multiple'); ?>
                    <!--<select class="selectpicker" name="users" id="users" multiple>
                        <option value="">- Selecciona uno -</option>
                    </select>-->
                </div>
                <div class="col-md-12 mt-3">
                    <p>Control de meses habilitados para la captura del seguimiento físico de metas</p>
                    <div class="row">
                        <?php
                        $meses = catalogoInterno('meses_nombres');
                        for($i = 1; $i <= 12; $i++):
                            ?>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="CustomCheck<?php echo $i; ?>">
                                    <label class="custom-control-label" for="CustomCheck<?php echo $i; ?>"><?php echo $meses[$i]; ?></label>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    Control de meses habilitados para la captura del seguimiento al programa de Derechos Humanos
                </div>
                <div class="col-md-6 mt-3">
                    <select name="mesesDH" id="mesesDH" class="selectpicker" multiple>
                        <option value=""> - Seleccione uno - </option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="col-md-6 mt-3">
                    Último mes visible en la consulta de reportes al seguimiento físico de metas
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <select name="ultimo_mes_seguimiento" id="ultimo_mes_seguimiento" class="selectpicker">
                            <option value=""> - Seleccione uno - </option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    Último mes visible para la consulta integral
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <select name="ultimo_mes_consulta" id="ultimo_mes_consulta" class="selectpicker">
                            <option value=""> - Seleccione uno - </option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <button class="btn btn-success float-right" id="btnConfigurarSeguimiento">Configurar</button>
        </div>
    </div>
</div>
