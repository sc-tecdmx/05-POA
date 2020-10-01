<?php


class prueba extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        Modules::run( 'inicio/verificaIngreso' );
        $models = array(
            'elaboracion',
            'seguimiento',
            'home/general'
        );
        $this->load->model($models);
    }

    private function _getAniosR()
    {
        if($query = $this->elaboracion->getAnios()){
            $anios = array('' => ' - Seleccione uno - ');
            foreach ($query as $row) {
                $anios[$row->ejercicio] = $row->ejercicio;
            }
            return $anios;
        }
    }

    private function _getUsuarios()
    {
        if($query = $this->seguimiento->getUsuarios()){
            $usuarios = array('' => ' - Seleccione uno - ');
            foreach ($query as $row) {
                $usuarios[$row->nsf] = $row->nombre.' '.$row->apellido;
            }
            return $usuarios;
        }
    }

    /**
     * Función para obtener todos los datos del ejercicio habilitado en seguimiento
     */
    public function getInfoConfiguracionSeguimiento()
    {
        $ejercicio = $this->seguimiento->getEjercicioSeguimiento();
        $configuracion = $this->seguimiento->getConfiguracion($ejercicio->ejercicio_id);
        $data = array();
        foreach ($configuracion as $config){
            $data['ejercicio'][] = $config->ejercicio;
            $data['edicion'][]   = $config->permitir_edicion_seguimiento;
            $data['visible'][]   = $config->ultimo_mes_visible;
            $data['consulta'][]  = $config->ultimo_mes_consulta;
            $data['captura'][]   = $config->tipo_captura_seguimiento;
        }
        $meses = $this->seguimiento->getMesesControlesMetas($ejercicio->ejercicio_id);
        $mh = array();
        foreach ($meses as $mes){
            array_push($mh, $mes->mes_id);
        }
        $data['meses'] = $mh;
        echo json_encode($data);
    }

    /**
     * Función para actualizar la información del ejercicio habilitado en seguimiento
     */
    public function configuracionSeguimiento()
    {
        $ejercicio = $this->input->post('ejercicio');
        $captura = $this->input->post('captura');
        $ultimoMesSeguimiento = $this->input->post('ultimoMesSeguimiento');
        $ultimoMesConsulta = $this->input->post('ultimoMesConsulta');
        $habilitar = $this->input->post('habilitar');
        $res = $this->seguimiento->searchEjercicio($ejercicio);
        if($res!='') {
            $datos = array(
                'tipo_captura_seguimiento' => $captura,
                'permitir_edicion_seguimiento' => $habilitar,
                'ultimo_mes_visible' => $ultimoMesSeguimiento,
                'ultimo_mes_consulta' => $ultimoMesConsulta
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id
            );
            $this->general->actualizaBase('ejercicios', $datos, $where);
            $meses = $this->input->post('meses');
            $j = 0;
            for($i = 1; $i <= 12; $i++){
                if($meses[$j] == '1'){
                    $datos = array(
                        'habilitado' => 'si'
                    );
                } else {
                    $datos = array(
                        'habilitado' => 'no'
                    );
                }
                $where = array(
                    'ejercicio_id'  => $res->ejercicio_id,
                    'mes_id'        => $i
                );
                $this->general->actualizaBase('meses_controles_metas', $datos, $where);
                $j++;
            }
            $datos = array(
                'ejercicio_id' => $res->ejercicio_id
            );
            $where = array(
                'operacion_ejercicio_id' => '2'
            );
            $this->general->actualizaBase('operaciones_ejercicios', $datos, $where);
            echo true;
        }
    }

    public function index()
    {
        $data = array();
        $data['menu']   = $this->load->view('home/home_menu_c', $data, TRUE);
        $data['header'] = $this->load->view('home/home_header', $data, TRUE);
        $data['js']     = 'configuracion/seguimiento.js';
        $data['anios']  = $this->_getAniosR();
        $data['users']  = $this->_getUsuarios();
        $data['main']   = $this->load->view('configuracion_seguimiento', $data, TRUE);
        $data['salir']  = $this->load->view('home/home_salir', $data, TRUE);
        $this->load->view('home/layout_general', $data);
    }
}
