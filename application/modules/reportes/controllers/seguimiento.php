<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class seguimiento extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        Modules::run( 'inicio/verificaIngreso' );
        $models = array(
            'graficas_model',
            'seguimientoModel',
            'home/home_inicio',
            'home/general',
            'inicio/proyectos_model',
            'inicio/seguimiento_model',
            'reportes/reportes'
        );
        $this->load->model($models);
        $this->load->library('Excel');
    }

    private function _programas()
    {
        if ($query = $this->seguimientoModel->getProgramas($this->session->userdata('ejercicio'))) {
            /* $programas = array('' => '-Seleccione un programa -');
            foreach ($query as $row) {
                $programas[$row->programa_id] = $row->nombre;
            } */
			$programas = array();
			foreach ($query as $row) {
				$detail = array(
					"id" => $row->programa_id,
					"nombre" => $row->nombre
				);
				array_push($programas, $detail);
			}
            return $programas;
        }
    }

    private function _is_exist($data, $type = FALSE)
    {
        if (isset($data)) {
            return $data;
        } else {
            if (! $type) {
                return '  ';
            } else {
                return 0;
            }
        }
    }

    private function _getProyectos($subprograma)
    {
        $res = $this->seguimientoModel->getProyectos($subprograma);
        $j = 1;
        $tabla = '';
        foreach($res as $row){
            if($j == 1){
                $tabla .= '
                <div class="card">
                    <div class="card-header" id="heading'.$j.'">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$j.'" aria-expanded="true" aria-controls="collapse'.$j.'">
                              '.$row->nombre.'
                            </button>
                        </h5>
                    </div>

                    <div id="collapse'.$j.'" class="collapse show" aria-labelledby="heading'.$j.'" data-parent="#accordion">
                        <div class="card-body">
                            <p>Hola</p>
                        </div>
                    </div>
                </div>';
            } else {
                $tabla .= '
                <div class="card">
                    <div class="card-header" id="heading'.$j.'">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$j.'" aria-expanded="true" aria-controls="collapse'.$j.'">
                              '.$row->nombre.'
                            </button>
                        </h5>
                    </div>

                    <div id="collapse'.$j.'" class="collapse" aria-labelledby="heading'.$j.'" data-parent="#accordion">
                        <div class="card-body">
                            <p>Hola</p>
                        </div>
                    </div>
                </div>';
            }
            $j++;
        }
        $tabla .= '</div>';
        return $tabla;
    }

    private function _getSubprogramas($programa)
    {
        $res = $this->seguimientoModel->getSubprogramas($programa);
        $tabla = '<div id="accordion1">';
        for($j=0;$j<count($res);$j++){
            if($j == 0){
                $tabla .= '
                <div class="card">
                    <div class="card-header" id="heading'.$j.'">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$j.'" aria-expanded="true" aria-controls="collapse'.$j.'">
                              '.$res[$j]->nombre.'
                            </button>
                        </h5>
                    </div>
                            
                    <div id="collapse'.$j.'" class="collapse show" aria-labelledby="heading'.$j.'" data-parent="#accordion1">
                        <div class="card-body">';
                $proyectos = $this->_getProyectos($res[$j]->subprograma_id);
                $tabla .= '</div>
                    </div>
                </div>';
            } else {
                $tabla .= '
                <div class="card">
                    <div class="card-header" id="heading'.$j.'">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$j.'" aria-expanded="true" aria-controls="collapse'.$j.'">
                              '.$res[$j]->nombre.'
                            </button>
                        </h5>
                    </div>
                            
                    <div id="collapse'.$j.'" class="collapse" aria-labelledby="heading'.$j.'" data-parent="#accordion1">
                        <div class="card-body">';
                $proyectos = $this->_getProyectos($res[$j]->subprograma_id);
                $tabla .= $proyectos;
                $tabla .= '</div>
                    </div>
                </div>';
            }
        }
        $tabla .= '</div>';
        return $tabla;
    }

    public function getConsolidadoSubprogramas($programa = false)
    {
        $res = $this->seguimientoModel->getSubprogramas($programa);
        $data = array();
        if($res){
            foreach ($res as $row){
                $data['subprograma_id'][] = $row->subprograma_id;
                $data['nombre'][] = $row->nombre;
            }
            echo json_encode($data);
        }
    }

    public function getConsolidadoProyectos($subprograma = false)
    {
        $res = $this->seguimientoModel->getProyectos($subprograma);
        $data = array();
        if($res){
            foreach ($res as $row){
                $data['clave'][] = $row->urnum.'-'.$row->ronum.'-'.$row->pgnum.'-'.$row->sbnum.'-'.$row->pynum;
                $data['nombre'][] = $row->pynom;
                $data['id'][] = $row->proyecto_id;
            }
            echo json_encode($data);
        }
    }

    public function getConsolidadoMetas($meta = false, $proyecto = false)
    {
        $res = $this->seguimientoModel->getMetas($meta, $proyecto);
        $data = array();
        if($res){
            foreach ($res as $row){
                $data['meta'][] = $row->meta_id;
                $data['nombre'][] = $row->nombre;
            }
            echo json_encode($data);
        }
    }

    public function getConsolidadoRespuesta($meta = false)
    {
        $mesVisible = $this->seguimientoModel->getMesVisible($this->session->userdata('ejercicio'));
        $mes = $mesVisible ? $mesVisible->mes_id : date('n');
        $mesesVisibles = array();
        if($mes == '1'){
            array_push($mesesVisibles, $mesVisible->mes_id);
        } else {
            for($i = 1; $i <= $mes; $i++){
                array_push($mesesVisibles, $i);
            }
        }
        $meses = array();
        if ($mes == '1') {
            $nombreMes = 'Enero';
            $nombreAcumulado = $nombreMes;
        } else {
            $nombreMes = $this->seguimientoModel->getNombreMes($mes);
            $nombreAcumulado = 'Enero - '.ucfirst($nombreMes->nombre);
        }
        $unidadMedida = $this->seguimientoModel->getUnidadMedida($meta) ? $this->seguimientoModel->getUnidadMedida($meta)->nombre : '';
        $tabla = '
        <div>
            <h4>Periodo: '.$nombreAcumulado.'</h4>
            <h4>Unidad de Medida: '.$unidadMedida.'</h4>
        </div>';
        $tabla .= '
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td></td>';
        /* $meses = $this->seguimientoModel->getMesVisible($this->session->userdata('ejercicio'));
        $mesesVisibles = array();
        foreach($meses as $mes){
            $tabla .= '<td class="text-center">'.ucfirst($mes->nombre).'</td>';
            array_push($mesesVisibles, $mes->mes_id);
        } */
        // obtener los nombres de los meses
        for($i = 0; $i < count($mesesVisibles); $i++){
            $mes = $this->seguimientoModel->getNombreMes($mesesVisibles[$i]);
            $tabla .= '<td class="text-center">'.ucfirst($mes->nombre).'</td>';
        }
        $tabla .= '</tr></thead>';
        $porcentaje = $this->seguimientoModel->getTipoMeta($meta);
        if($porcentaje->porcentajes != '1'){
            $tabla .= '
            <tbody>
            <tr>
                <td>Programado</td>
        ';
            for($i = 0; $i < count($mesesVisibles); $i++){
                $programados = $this->seguimientoModel->getMetasProgramados($meta, $mesesVisibles[$i]);
                $tabla .= '<td class="text-center">'.$programados->numero.'</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '<tr>
            <td>Alcanzado</td>
        ';
            for($i = 0; $i < count($mesesVisibles); $i++){
                $alcanzadas = $this->seguimientoModel->getMetasAlcanzadas($meta, $mesesVisibles[$i]);
                $tabla .= '<td class="text-center">'.$alcanzadas->numero.'</td>';
            }
            $tabla .= '</tr>';
        } else {
            $tabla .= '
            <tbody>
            <tr>
                <td>Recibidos</td>
            ';
            for($i = 0; $i < count($mesesVisibles); $i++){
                $programados = $this->seguimientoModel->getMetasAlcanzadas($meta, $mesesVisibles[$i]);
                $tabla .= '<td class="text-center">'.$programados->numero.'</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '<tr>
            <td>Resueltos</td>
            ';
            for($i = 0; $i < count($mesesVisibles); $i++){
                $alcanzadas = $this->seguimientoModel->getMetasResueltas($meta, $mesesVisibles[$i]);
                $tabla .= '<td class="text-center">'.$alcanzadas->numero.'</td>';
            }
            $tabla .= '</tr>';
        }
        $tabla .= '
            <tr>
                <td>Porcentaje de Avance respecto del mes</td>
        ';
        for($i = 0; $i < count($mesesVisibles); $i++){
            $porcentaje = $this->seguimientoModel->getPorcentajeAvance($meta, $mesesVisibles[$i]);
            $porcentajeA = $porcentaje->porcentaje?$porcentaje->porcentaje:'0.0';
            $tabla .= '<td class="text-center">'.$porcentajeA.'%</td>';
        }
        $tabla .= '</tr>';
        $tabla .= '
            <tr>
                <td>Porcentaje de Avance Acumulado</td>
        ';
        for($i = 0; $i < count($mesesVisibles); $i++){
            $porcentajeReal = $this->seguimientoModel->getPorcentajeReal($meta, $mesesVisibles[$i]);
            $porcentajeR = $porcentajeReal->porcentaje_real?$porcentajeReal->porcentaje_real:'0.0';
            $tabla .= '<td class="text-center">'.$porcentajeR.'%</td>';
        }
        $tabla .= '</tr>';
        $tabla .= '</tbody>';
        $tabla .= '</table></div>';
        echo $tabla;
    }

    public function getAvanceMensualRespuesta($meta = false, $mes = false)
    {
        $unidadMedida = $this->seguimientoModel->getUnidadMedida($meta) ? $this->seguimientoModel->getUnidadMedida($meta)->nombre : '';
        $tabla = '
            <div>
                <h4>Unidad de medida: '.$unidadMedida.'</h4>
            </div>
        ';
        $tabla .= '
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td></td>';
        $mesesVisibles = array();
        if($mes == '1'){
            array_push($mesesVisibles, $mes);
        } else {
            for($i = 1; $i <= $mes; $i++){
                array_push($mesesVisibles, $i);
            }
        }
        $meses = array();
        // obtener los nombres de los meses
        for($i = 0; $i < count($mesesVisibles); $i++){
            $mes = $this->seguimientoModel->getNombreMes($mesesVisibles[$i]);
            $tabla .= '<td class="text-center">'.ucfirst($mes->nombre).'</td>';
        }
        $tabla .= '</tr></thead>';
        $porcentaje = $this->seguimientoModel->getTipoMeta($meta);
        if($porcentaje->porcentajes != '1'){
            $tabla .= '
            <tbody>
            <tr>
                <td>Programado</td>
        ';
            for($i = 0; $i < count($mesesVisibles); $i++){
                $programados = $this->seguimientoModel->getMetasProgramados($meta, $mesesVisibles[$i]);
                $tabla .= '<td class="text-center">'.$programados->numero.'</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '<tr>
            <td>Alcanzado</td>
        ';
            for($i = 0; $i < count($mesesVisibles); $i++){
                $alcanzadas = $this->seguimientoModel->getMetasAlcanzadas($meta, $mesesVisibles[$i]);
                $tabla .= '<td class="text-center">'.$alcanzadas->numero.'</td>';
            }
            $tabla .= '</tr>';
        } else {
            $tabla .= '
            <tbody>
            <tr>
                <td>Recibidos</td>
            ';
            for($i = 0; $i < count($mesesVisibles); $i++){
                $programados = $this->seguimientoModel->getMetasAlcanzadas($meta, $mesesVisibles[$i]);
                $tabla .= '<td class="text-center">'.$programados->numero.'</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '<tr>
            <td>Resueltos</td>
            ';
            for($i = 0; $i < count($mesesVisibles); $i++){
                $alcanzadas = $this->seguimientoModel->getMetasResueltas($meta, $mesesVisibles[$i]);
                $tabla .= '<td class="text-center">'.$alcanzadas->numero.'</td>';
            }
            $tabla .= '</tr>';
        }
        $tabla .= '
            <tr>
                <td>Porcentaje de Avance respecto del mes</td>
        ';
        for($i = 0; $i < count($mesesVisibles); $i++){
            $porcentaje = $this->seguimientoModel->getPorcentajeAvance($meta, $mesesVisibles[$i]);
            $porcentajeA = $porcentaje->porcentaje?$porcentaje->porcentaje:'0.0';
            $tabla .= '<td class="text-center">'.$porcentajeA.'%</td>';
        }
        $tabla .= '</tr>';
        $tabla .= '
            <tr>
                <td>Porcentaje de Avance Acumulado</td>
        ';
        for($i = 0; $i < count($mesesVisibles); $i++){
            $porcentajeReal = $this->seguimientoModel->getPorcentajeReal($meta, $mesesVisibles[$i]);
            $porcentajeR = $porcentajeReal->porcentaje_real?$porcentajeReal->porcentaje_real:'0.0';
            $tabla .= '<td class="text-center">'.$porcentajeR.'%</td>';
        }
        $tabla .= '</tr>';
        $tabla .= '</tbody>';
        $tabla .= '</table></div>';
        echo $tabla;
    }

    public function getConsolidado()
    {
        $res = $this->seguimientoModel->getProgramas($this->session->userdata('ejercicio'));
        if($res){
            $tabla = '';
            $tabla .= '
            <div class="col-md-6">
               <select id="programasConsolidado" class="form-control">
                    <option value=""> - Selecciona un programa -</option>';
                foreach ($res as $row){
                    $tabla .= '<option value="'.$row->programa_id.'">'.$row->nombre.'</option>';
                }
            $tabla .= '</select>
            </div>';
            echo $tabla;
        }
    }

    public function getDataMetas($mesId)
    {
        $graph = new Graficas_model();
		$programas = $graph->getPrograms($this->session->userdata('ejercicio'));
		if ($programas) {
			$elementos = 0;
			$altura = 0;
			$contenido = array();
			foreach ($programas as $programa) {
				$numero_programa = $programa->numero;
				$nombre_programa = $programa->nombre;
				$subprogramas = $graph->getSubprograms($programa->programa_id);
				if ($subprogramas) {
					foreach ($subprogramas as $subprograma) {
						$numero_subprograma = $subprograma->numero;
						$nombre_subprograma = $subprograma->nombre;
						$proyectos = $graph->getProjects($subprograma->subprograma_id);
						if ($proyectos) {
							foreach ($proyectos as $proyecto) {
								$numero_urg = $proyecto->numero_urg;
								$numero_ro = $proyecto->numero_ro;
								$numero_proyecto = $proyecto->numero;
								$nombre_proyecto = $proyecto->nombre;

								$palabras_array = explode(" ", $proyecto->nombre);
								$palabras = "";
								foreach($palabras_array as $key => $value) {
									if ($key % 5 == 0 && $key != 0) {
										$palabras .= "<br />" . $value . " ";
									} else {
										$palabras .= $value . " ";
									}
								}

								$palabras = trim($palabras);

								$meta_principal = $graph->getPrincipalGoal($proyecto->proyecto_id);
								$avance = 0;
								if ($meta_principal) {
									foreach($meta_principal as $meta) {
										$programadas = $graph->getAccumulatedProgrammedGoal($mesId, $meta->meta_id);
										$acumuladas = $graph->getCumulatedProgrammedGoal($mesId, $meta->meta_id);
										if ($programadas && $acumuladas) {
											$acumulada_programada = $programadas->numero;
											$acumulada_alcanzada = $acumuladas->numero;
											$avance = $acumulada_programada == 0 ? "-2" : number_format(($acumulada_alcanzada / $acumulada_programada), 1) . "%";
										}
									}
								}

								$palabras_2 = "<span style=\"color: #305ACB;\">Meta programada acumulada: $acumulada_programada</span><br />"
									. "<span style=\"color: #2195DA;\">Meta alcanzada acumulada: $acumulada_alcanzada</span>";

								$palabras = $palabras_2 . "<br />" . $palabras;

								//if ($avance != "no-aplica") {
								$contenido[] = array(
									'name' => $palabras,
									'y' => floatval(str_replace(",", "", $avance))
								);
								//}

								$elementos++;
								$clave[] = $numero_urg . "-" . $numero_ro . "-" . $numero_programa . "-" . $numero_subprograma . "-" . $numero_proyecto;
							}
						}
					}
				}
			}
			$altura = $elementos * 45;
			if ($altura <= 400) {
				$altura = 400;
			}

			$mes = $this->seguimiento_model->getNombreMes($mesId);

			$datos = array(
				"contenido" => $contenido,
				"clave" => $clave,
				"altura" => $altura,
				"mes" => ucfirst($mes->nombre)
			);

			echo json_encode($datos);
		}
    }

    private function _avanceFichaPoa()
	{
    	$tabla = '';
    	$numero_mes = 1;
		$tabla .= '
			<div class="avance-ficha-poa">
				<div class="periodo-avance">
					Periodo: Enero - Enero					
				</div>
				<ul class="collapse-programas treeview" id="tree-programas">
					<li class="open">
						<span>Programa Operativo Anual '.$this->session->userdata('anio').'</span>
						<ul class="primer-nivel">';
		if ($programas = $this->seguimientoModel->getProgramas($this->session->userdata('ejercicio'))) {
			foreach ($programas as $programa) {
				$tabla .= '<li><span>'.$programa->numero.' - '.$programa->nombre.'</span>';
				$tabla .= "<ul class='segundo-nivel'>";
				$subprogramas = $this->seguimientoModel->getSubprogramas($programa->programa_id);
				if ($subprogramas) {
					foreach ($subprogramas as $subprograma) {
						$tabla .= '<li><span>'.$subprograma->numero.'-'. $subprograma->nombre.'</span>';
						$tabla .= "<ul class='tercer-nivel'>";

						$proyectos = $this->seguimientoModel->getProyectos($subprograma->subprograma_id);
						foreach($proyectos as $proyecto) {
							$tabla .= "<li class='my-proyecto' rel='$proyecto->proyecto_id' rev='$numero_mes'><span>{$proyecto->urnum}-{$proyecto->ronum}-{$programa->numero}-{$subprograma->numero}-{$proyecto->pynum} - {$proyecto->pynom}</span>";
							$tabla .= "<ul class='cuarto-nivel'>";
							$tabla .= "</ul></li>";
						}
						$tabla .= '</ul></li>';
					}
				}
				$tabla .= '</ul></li>';
			}
			$tabla .= '</ul></li>';
		}
		$tabla .= '</ul></li></div>';
		return $tabla;
	}

    public function index()
    {
        $data = array();
        if($this->session->userdata('mensaje')){
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data['seccion'] = 'Reportes Seguimiento';
        $data['js']      = 'graficas/0002_bar.js';
        $data['programas'] = $this->_programas();
        $data['avance_ficha_poa'] = $this->_avanceFichaPoa();
        $data['header']  = $this->load->view('home/home_header', $data, TRUE);
        $data['menu']    = $this->load->view('home/home_menu_r', $data, TRUE);
        $data['main']    = $this->load->view('seguimiento', $data, TRUE);
        $data['salir']   = $this->load->view('home/home_salir', $data, TRUE);
        $this->load->view('home/layout_general_graficas', $data);
    }
}
