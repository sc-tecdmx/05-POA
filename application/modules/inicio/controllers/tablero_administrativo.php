<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tablero_administrativo extends MX_Controller
{
    /**
     * Constructor que instancia archivos externos
     */
    function __construct()
    {
        parent::__construct();

        Modules::run('inicio/verificaIngreso');
        // Modules::run( 'inicio/verifica_privilegios' );
        $models = array(
            'home/general',
            'ingreso_model',
            'main_model',
            'home/home_inicio',
            'info_model'
        );
        $this->load->model($models);
    }

    private function _tabla()
    {
        // $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->home_inicio->get_unidades($this->session->userdata('ejercicio'));
        if($res){
            $tabla = '';
            foreach($res as $row){
                $res_r = $this->info_model->getResponsables($row->unidad_responsable_gasto_id);
                $tabla .= '
                <tr class="head-tab-admin">
					<td>' . $row->numero . '</td>
					<td>' . $row->nombre . '</td>
                    <td class="' . ($row->cerrada ? 'finalizado-btn': '') . '">' . ($row->cerrada ? 'Cerrada': 'Abierta') . '</td>
			    </tr>';
                foreach($res_r as $row_r){
                    $tabla .= '
                    <tr>
                        <td>' . $row->numero . '</td>
                        <td><label style="width: 35px;">' . $row_r->numero . '</label> ' . $row_r->nombre . '</td>
                        <td></td>
                    </tr>';
                }
            }
            return $tabla;
        }
    }

    /**
     * Función principal
     */
    public function index()
    {
        $data = array();
        // Reviso si hay mensajes y los mando a las variables de la vista
        if($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }
        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu',$data,TRUE);

        $unidad = $this->home_inicio->get_unidad($this->session->userdata('area_id'));
        $data['unidad'] = $unidad ? $unidad[0]->nombre : 'No se encontró la unidad';
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Unidades Responsables";
        // tabla con todos los proyectos
        $data["tabla"]  = $this->_tabla();
        //paso el main
        $data["main"] 	 = $this->load->view('tablero_administrativo/tablero_administrativo',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        // js a usar
        $data['js'] = 'inicio/unidades_responsables.js';
        //cargo vista general
        $this->load->view('layout_general',$data);
    }
}
