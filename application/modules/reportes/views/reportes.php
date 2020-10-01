<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#graficas">Graficas de proyectos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#proyectos">Apertura Programática</a>
        </li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#fichas">Fichas POA</a>
		</li>
    </ul>
    <div class="tab-content clearfix">
        <div class="tab-pane active" id="graficas">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="pie" style="width: 700px;height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="proyectos">
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Reportes predeterminados</h4>
                </div>
                <div class="col-md-8">
                    <p>Apertura Programática</p>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url('reportes/aperturaProgramatica/index') ?>" target="_blank" class="btn btn-success"><i class="fa fa-fw fa-file-excel"></i>Generar</a>
                </div>
            </div>
			<div class="row mt-3">
				<div class="col-md-6">
					<?php echo form_dropdown('programasConsolidado', $programas, set_value('programasConsolidado',isset($row->programa_id)?$row->programa_id:''),'class="form-control" id="programasConsolidado" data-form="required"'); ?>
				</div>
				<div class="col-md-6">
					<select id="subprogramasConsolidado" class="form-control">
						<option value=""> - Selecciona un subprograma -</option>
					</select>
				</div>
				<div class="col-md-6 mt-2">
					<select id="proyectosConsolidado" class="form-control">
						<option value=""> - Selecciona un proyecto -</option>
					</select>
				</div>
				<div class="col-md-6 mt-2">
					<select id="tiposMetasConsolidado" class="form-control">
						<option value=""> - Selecciona un tipo de meta -</option>
						<option value="principal">Principal</option>
						<option value="complementaria">Complementaria</option>
					</select>
				</div>
				<div class="col-md-6 mt-2">
					<select id="metaConsolidado" class="form-control">
						<option value=""> - Selecciona una meta -</option>
					</select>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-md-12 mt-4" id="tablaConsolidado">

				</div>
			</div>
        </div>
		<div class="tab-pane" id="fichas">
			<div class="row mt-4">
				<div class="col-md-12">
					<h4>Generación Personalizada de Fichas POA</h4>
				</div>
				<div class="col-md-12 text-right">
					<button class="btn btn-info" id="construirPdf">Construir PDF</button>
				</div>
				<div class="col-md-12 mt-3">
					<div class="table-responsive">
						<!--Empieza tabla-->
						<table class="table table-striped" id="tabla_proyectos">
							<thead>
							<tr>
								<th></th>
								<th>URG</th>
								<th>RO</th>
								<th>PG</th>
								<th>SP</th>
								<th>PY</th>
								<th>Denominación</th>
							</tr>
							</thead>
							<tbody id="lista_acciones">
							<?php if (isset($tabla)) echo $tabla;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
