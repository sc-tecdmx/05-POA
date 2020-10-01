<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Anteproyecto extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $models = array(
            'elaboracion'
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

    public function index()
    {
        $data = array();

        if($this->input->post('ejercicio')){
            $this->elaboracion->genera_nuevo_ejercicio($this->input->post('ejercicio'));
            print_r($this->input->post('ejercicio'));
            die();
        }

        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu_c',$data,TRUE);
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Configuración";
        // carga de js para la funcionalidad
        $data['js'] = 'configuracion/configuracion.js';
        // obtener los años actuales para activar seguimiento
        $data['anios'] = $this->_getAniosR();
        //paso el main
        $data["main"] 	 = $this->load->view('configuracion_anteproyecto',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        //cargo vista general
        $this->load->view('layout_general',$data);
    }
}
