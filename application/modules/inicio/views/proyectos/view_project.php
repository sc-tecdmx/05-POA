<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#details">Detalles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#metaPrincipal">Meta Principal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#metasComplementarias">Metas Complementarias</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#indicadores">Indicadores</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#sustantivas">Acciones Sustantivas del Proyecto</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#programaEspecial">Programa Especial</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#ejecucion">Ejecución del Proyecto</a>
        </li>
    </ul>

    <div class="tab-content clearfix">
        <div class="tab-pane active" id="details">
            <div class="row text-right">
                <div class="col-md-3">
                    <label>Responsable de la Ficha</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->responsable_ficha; ?>
                </div>
                <div class="col-md-3">
                    <label>Unidad Responsable del Gasto</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->numero_urg.' - '.$detalles->nombre_urg; ?>
                </div>
                <div class="col-md-3">
                    <label>Responsable Operativo</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->numero_ro.' - '.$detalles->nombre_ro; ?>
                </div>
                <div class="col-md-3">
                    <label>Programa</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->numero_programa.' - '.$detalles->nombre_programa; ?>
                </div>
                <div class="col-md-3">
                    <label>Subprograma</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->numero_subprograma.' - '.$detalles->nombre_subprograma; ?>
                </div>
                <div class="col-md-3">
                    <label>Proyecto</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->numero.' - '.$detalles->nombre; ?>
                </div>
                <div class="col-md-3">
                    <label>Tipo de Proyecto</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->tipo; ?>
                </div>
                <div class="col-md-3">
                    <label>Versión</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->version; ?>
                </div>
                <div class="col-md-3">
                    <label>Objetivo de la Unidad Responsable</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->objetivo ?>
                </div>
                <div class="col-md-3">
                    <label>Justificación del Proyecto</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->justificacion; ?>
                </div>
                <div class="col-md-3">
                    <label>Descripción y Alcance del Proyecto</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->descripcion; ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="metaPrincipal">
            <br><br>
            <div class="table-responsive">
                <table border="1" class="table">
                    <thead class="text-center">
                    <tr>
                        <th rowspan="2">Denominación de la meta</th>
                        <th rowspan="2">Unidad de medida</th>
                        <th colspan="12">Meses</th>
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
                    <tr>
                        <td>
                            <?php echo (isset($metap->mnombre))? $metap->mnombre : FALSE ;?>
                        </td>
                        <td class="text-center">
                            <?php echo (isset($metap->nombre))? $metap->nombre : FALSE; ?>
                        </td>
                        <?php echo $mmetap; ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="metasComplementarias">
            <br><br>
            <table border="1" class="table">
                <thead class="text-center">
                <tr>
                    <th rowspan="2">Denominación de la meta</th>
                    <th rowspan="2">Unidad de medida</th>
                    <th rowspan="2">Medida</th>
                    <th colspan="12">Meses</th>
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
                <?php echo $metac; ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="indicadores">
            <br><br>
            <div class="table-responsive">
                <table border="1" class="table">
                    <thead class="text-center">
                    <tr>
                        <th>Nombre del indicador</th>
                        <th>Definición del indicador</th>
                        <th>Unidad de medida</th>
                        <th>Método de cálculo</th>
                        <th>Dimensión a medir</th>
                        <th>Frecuencia de medición</th>
                        <th>Meta del indicador</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo $indicadores; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="sustantivas">
            <br><br>
            <div class="table-responsive">
                <table border="1" class="table">
                    <thead>
                    <tr>
                        <th colspan="2" class="text-center">Acciones Sustantivas</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo $sustantivas; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="programaEspecial">
            <div class="row mt-3">
                <div class="col-sm-12 mt-3">
                    <div class="table-responsive">
                        <table border="1" class="table">
                            <thead>
                            <tr>
                                <th>Política Pública</th>
                                <th>Acción Sustantiva POA - Enfoque de Genéro</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo isset($programaEspecial)?$programaEspecial:''; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ejecucion">
            <br><br>
            <div class="row">
                <div class="col-md-3">
                    <label>Período de ejecución del proyecto</label>
                </div>
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table border="1" class="table">
                            <thead class="text-center">
                            <tr>
                                <th>ENE</th>
                                <th>FEB</th>
                                <th>MAR</th>
                                <th>ABR</th>
                                <th>MAY</th>
                                <th>JUN</th>
                                <th>JUL</th>
                                <th>AGO</th>
                                <th>SEP</th>
                                <th>OCT</th>
                                <th>NOV</th>
                                <th>DIC</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $ejecucion; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Fecha de elaboración de la ficha</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->fecha; ?>
                </div>
                <div class="col-md-3">
                    <label>Nombre de quien revisó</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->nombre_responsable_operativo; ?>
                </div>
                <div class="col-md-3">
                    <label>Cargo de quien revisó</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->cargo_responsable_operativo; ?>
                </div>
                <div class="col-md-3">
                    <label>Titular de la Unidad Responsable</label>
                </div>
                <div class="col-md-9">
                    <?php echo $detalles->nombre_titular; ?>
                </div>
            </div>
        </div>
    </div>
</div>
