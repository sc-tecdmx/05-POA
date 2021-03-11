<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#graficas">Graficas del avance</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#proyectos">Avance</a>
        </li>
    </ul>
    <div class="tab-content clearfix">
        <div class="tab-pane active" id="graficas">
            <div class="row mt-4">
                <div class="col-10 offset-1">
                    <select name="estado" id="monthSel" class="form-control">
                        <option value="" selected="selected">Selecciona un mes</option>
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
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <div id="chart-avance"></div>
                        <!--<canvas id="bar" width="400" height="400"></canvas>-->
                    </div>

                </div>
            </div>
        </div>
        <div class="tab-pane" id="proyectos">
            <div class="row mt-3">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Consolidado a la última fecha de corte (fin de mes)</a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Avance mensual y acumulado</a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Avance trimestral y acumulado</a>
                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Matriz de metas programadas y alcanzadas</a>
                        <a class="nav-link" id="v-pills-indicadores-tab" data-toggle="pill" href="#v-pills-indicadores" role="tab" aria-controls="v-pills-indicadores" aria-selected="false">Avance trimestral y acumulado de indicadores</a>
                        <a class="nav-link" id="v-pills-lapdhdf-tab" data-toggle="pill" href="#v-pills-lapdhdf" role="tab" aria-controls="v-pills-lapdhdf" aria-selected="false">Avance trimestral de implementación de las LAPDHDF</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
							<?php echo $avance_ficha_poa; ?>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="mesAvanceMensual" class="form-control">
                                        <option value=""> - Selecciona un mes -</option>
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
                                <div class="col-md-6">
                                    <?php echo form_dropdown('programasAvanceMensual', $selectProgramas, set_value('programasAvanceMensual',isset($row->programa_id)?$row->programa_id:''),'class="form-control" id="programasAvanceMensual" data-form="required"'); ?>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <select id="subprogramasAvanceMensual" class="form-control">
                                        <option value=""> - Selecciona un subprograma -</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <select id="proyectosAvanceMensual" class="form-control">
                                        <option value=""> - Selecciona un proyecto -</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <select id="tiposMetasAvanceMensual" class="form-control">
                                        <option value=""> - Selecciona un tipo de meta -</option>
                                        <option value="principal">Principal</option>
                                        <option value="complementaria">Complementaria</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <select id="metaAvanceMensual" class="form-control">
                                        <option value=""> - Selecciona una meta -</option>
                                    </select>
                                </div>
								<div class="col-md-6 mt-2" id="colExportExcelMonthly" style="display: none">
									<button class="btn btn-success" id="exportExcelMonthly"><i class="mdi mdi-file-excel"></i> Excel</button>
								</div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 mt-4" id="tablaAvanceMensual">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="trimestreAvanceTrimestral" class="form-control">
                                        <option value=""> - Selecciona el trimestre -</option>
                                        <option value="1">Enero - Marzo</option>
                                        <option value="2">Abril - Junio</option>
                                        <option value="3">Julio - Septiembre</option>
                                        <option value="4">Octubre - Diciembre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="mesMatrizMetas" class="form-control">
                                        <option value=""> - Selecciona un mes -</option>
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
                        <div class="tab-pane fade" id="v-pills-indicadores" role="tabpanel" aria-labelledby="v-pills-indicadores-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="trimestreAvanceIndicadores" class="form-control">
                                        <option value=""> - Selecciona el trimestre -</option>
                                        <option value="1">Enero - Marzo</option>
                                        <option value="2">Abril - Junio</option>
                                        <option value="3">Julio - Septiembre</option>
                                        <option value="4">Octubre - Diciembre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-lapdhdf" role="tabpanel" aria-labelledby="v-pills-lapdhdf-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="trimestreAvanceLapdhdf" class="form-control">
                                        <option value=""> - Selecciona el trimestre -</option>
                                        <option value="1">Enero - Marzo</option>
                                        <option value="2">Abril - Junio</option>
                                        <option value="3">Julio - Septiembre</option>
                                        <option value="4">Octubre - Diciembre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

