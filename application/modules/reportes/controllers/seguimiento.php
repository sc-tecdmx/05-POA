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
            $programas = array('' => '-Seleccione un programa -');
            foreach ($query as $row) {
                $programas[$row->programa_id] = $row->nombre;
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
        $tabla = '';
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
        $tabla = '';
        $tabla .= '
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td></td>';
        // obtener el nombre del mes
        /* $nombreMes = $this->seguimientoModel->getNombreMes($mes);
        $tabla .= '<td class="text-center">'.ucfirst($nombreMes->nombre).'</td>';
        // consultar si es meta con porcentajes
        $porcentaje = $this->seguimientoModel->getTipoMeta($meta);
        if($porcentaje->porcentajes != '1'){
            // Obtener el avance del mes programado
            $tabla .= '
            <tbody>
            <tr>
                <td>Programado</td>
        ';
            $programados = $this->seguimientoModel->getMetasProgramados($meta, $mes);
            $tabla .= '<td class="text-center">'.$programados->numero.'</td>';
            $tabla .= '</tr>';
            // Obtener el avance del mes acumulado
            $tabla .= '<tr>
            <td>Alcanzado</td>
        ';
            $alcanzadas = $this->seguimientoModel->getMetasAlcanzadas($meta, $mes);
            $tabla .= '<td class="text-center">'.$alcanzadas->numero.'</td>';
            $tabla .= '</tr>';
        } else {
            // Obtener el avance del mes programado
            $tabla .= '
            <tbody>
            <tr>
                <td>Recibido</td>
            ';
            $programados = $this->seguimientoModel->getMetasAlcanzadas($meta, $mes);
            $tabla .= '<td class="text-center">'.$programados->numero.'</td>';
            $tabla .= '</tr>';
            // Obtener el avance del mes acumulado
            $tabla .= '<tr>
            <td>Resuelto</td>
            ';
            $alcanzadas = $this->seguimientoModel->getMetasResueltas($meta, $mes);
            $tabla .= '<td class="text-center">'.$alcanzadas->numero.'</td>';
            $tabla .= '</tr>';
        }
        // Obtener el porcentaje del mes
        $tabla .= '
            <tr>
                <td>Porcentaje de Avance respecto del mes</td>
        ';
        $porcentaje = $this->seguimientoModel->getPorcentajeAvance($meta, $mes);
        $porcentajeA = $porcentaje->porcentaje?$porcentaje->porcentaje:'0.0';
        $tabla .= '<td class="text-center">'.$porcentajeA.'%</td>';
        $tabla .= '</tr>';
        // Obtener porcentaje del mes acumulado
        $tabla .= '
            <tr>
                <td>Porcentaje de Avance Acumulado</td>
        ';
        $porcentaje = $this->seguimientoModel->getPorcentajeAvance($meta, $mes);
        $porcentajeA = $porcentaje->porcentaje?$porcentaje->porcentaje:'0.0';
        $tabla .= '<td class="text-center">'.$porcentajeA.'%</td>';
        $tabla .= '</tr>';
        $tabla .= '</tbody>';
        $tabla .= '</table></div>';
        echo $tabla; */
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

    public function getDataMetas($id)
    {
        $graph = new Graficas_model();
        $exist = $graph->getMetasComplementarias($id, $this->session->userdata('ejercicio'));
        if(is_array($exist)){
            $i = 0;
            foreach($exist as $key){
                $data[$i++] = array(
                    'name' => $this->_is_exist($key->urnum) . ' ' . $this->_is_exist($key->ronum) . ' ' . $this->_is_exist($key->pgnum) . ' ' . $this->_is_exist($key->sbnum) . ' ' . $this->_is_exist($key->pynum),
                    // 'value' => $this->_is_exist($key->porcentaje_real, TRUE),
                    // 'value' => $this->_is_exist($key->metaPor, TRUE),
                    'value' => $key->porcentaje_real
                );
            }
            echo json_encode($data);
        } else {
            echo FALSE;
        }
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
        $data['header']  = $this->load->view('home/home_header', $data, TRUE);
        $data['menu']    = $this->load->view('home/home_menu_r', $data, TRUE);
        $data['main']    = $this->load->view('seguimiento', $data, TRUE);
        $data['salir']   = $this->load->view('home/home_salir', $data, TRUE);
        $this->load->view('home/layout_general_graficas', $data);
    }
}
