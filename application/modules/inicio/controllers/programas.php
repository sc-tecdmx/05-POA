<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Programas extends MX_Controller
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
            'home/home_inicio',
            'info_model',
            'main_model'
        );
        $this->load->model($models);
    }

    private function _tabla()
    {
        $res = $this->home_inicio->get_programas();
        if($res){
            $tabla = '';
            foreach($res as $row){
                $tabla .= '
                <tr>
					<td>' . $row->numero . '</td>
					<td>' . $row->nombre . '</td>
					<td>
					    <button class="btn btn-outline" onclick="editarPrograma('.$row->programa_id.')">
					        <i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i>
					    </button>
					    <button class="btn btn-outline" onclick="eliminarPrograma('.$row->programa_id.')">
					        <i class="fa fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                        </button>
                    </td>
			    </tr>';
            }
            return $tabla;
        }
    }

    public function getPrograma($id)
    {
        $res = $this->info_model->getPrograma($id);
        if($res){
            foreach($res as $row){
                $data['nombre'][] = $row->nombre;
                $data['numero'][] = $row->numero;
            }
            echo json_encode($data);
        } else {
            echo '400';
        }
    }

    public function postPrograma()
    {
        $numero = $this->input->post('numero');
        $res = $this->info_model->getNumero($numero, 'programas');
        if($res){
            echo '400';
        } else {
            $data = array(
                'ejercicio_id' => $this->session->userdata('ejercicio'),
                'numero'       => $this->input->post('numero'),
                'nombre'       => $this->input->post('nombre')
            );
            $ro = $this->general->insertaBase('programas', $data);
            if($ro){
                echo true;
            } else {
                return false;
            }
        }
    }

    public function putPrograma()
    {
        $numero = $this->input->post('numero');
        $programa = $this->input->post('programa');
        // $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->info_model->getNumeroEditPrograma($numero, $this->session->userdata('ejercicio'));
        if($res && $res->programa_id != $programa){
            echo '400';
        } else {
            $datos = array(
                'ejercicio_id'   => $this->session->userdata('ejercicio'),
                'numero'         => $this->input->post('numero'),
                'nombre'         => $this->input->post('nombre')
            );
            $where = array('programa_id' => $this->input->post('programa'));
            $qry = $this->main_model->update($datos, 'programas', $where);
            if($qry) {
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function deletePrograma()
    {
        $where = array(
            'programa_id'   => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'programas');
        if($query){
            echo true;
        }
        echo false;
    }

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
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Inicio";
        // tabla con todos los proyectos
        $data["tabla"]  = $this->_tabla();
        //paso el main
        $data["main"] 	 = $this->load->view('programas/programas',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        // js a usar
        $data['js'] = 'inicio/programas.js';
        //cargo vista general
        $this->load->view('home/layout_general',$data);
    }
}

