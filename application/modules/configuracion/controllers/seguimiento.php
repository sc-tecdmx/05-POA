<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class seguimiento extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $models = array(
            'elaboracion',
            'home/general',
            'seguimiento'
        );
        $this->load->model($models);
    }

    private function _getAniosR()
    {
        if ($query = $this->elaboracion->getAnios()) {
            $anios = array('' => ' - Seleccione uno - ');
            foreach ($query as $row) {
                $anios[$row->ejercicio] = $row->ejercicio;
            }
            return $anios;
        }
    }

    /**
     * Función para obtener todos los datos del ejercicio habilitado en seguimiento
     */
    public function getInfoSeguimiento()
    {
        $ejercicio = $this->seguimiento->getEjercicioSeguimiento();
        $configuracion = $this->seguimiento->getConfiguracion($ejercicio->ejercicio_id);
        $data = array();
        foreach ($configuracion as $config){
            $data['edicion'][] = $config->permitir_edicion_seguimiento;
            $data['visible'][] = $config->ultimo_mes_visible;
            $data['consulta'][] = $config->ultimo_mes_consulta;
            $data['captura'][] = $config->tipo_captura_seguimiento;
        }
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
        $res = $this->elaboracion->searchEjercicio($ejercicio);
        if($res) {
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
            /* $datos = array(
                'habilitado' => $this->input->post('ene')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 1
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('feb')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 2
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('mar')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 3
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('abr')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 4
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('may')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 5
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('jun')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 6
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('jul')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 7
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('ago')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 8
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('sep')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 9
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('oct')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 10
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('nov')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 11
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where);
            $datos = array(
                'habilitado' => $this->input->post('dic')
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id,
                'mes_id' => 12
            );
            $this->general->actualizaBase('meses_controles_metas', $datos, $where); */
            $datos = array(
                'ejercicio_id' => $res->ejercicio_id
            );
            $where = array(
                'operacion_ejercicio_id' => '2'
            );
            $upd = $this->general->actualizaBase('operaciones_ejercicios', $datos, $where);
            if ($upd) {
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function index()
    {
        $data = array();
        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu_c',$data,TRUE);
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        // carga de js para la funcionalidad
        $data['js'] = 'configuracion/seguimiento.js';
        // obtener los años actuales para activar seguimiento
        $data['anios'] = $this->_getAniosR();
        //paso el main
        $data["main"] 	 = $this->load->view('configuracion_seguimiento',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        //cargo vista general
        $this->load->view('home/layout_general',$data);
    }
}
