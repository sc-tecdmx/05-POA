<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class areas extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        Modules::run( 'inicio/verificaIngreso' );
        $models = array(
            'home/home_inicio',
            'home/general',
            'info_model'
        );
        $this->load->model($models);
    }

    private function _tabla()
    {
        $res = $this->home_inicio->getAreas();
        if($res){
            $tabla = '';
            foreach($res as $row){
                $tabla .= '
                <tr>
                    <td>' . $row->area_id .'</td>
					<td>' . $row->nombre . '</td>
					<td>' . $row->descripcion . '</td>
					<td>
					    <button class="btn btn-outline" onclick="editarArea('.$row->area_id.')">
					        <i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i>
					    </button>
					    <button class="btn btn-outline" onclick="eliminarArea('.$row->area_id.')">
					        <i class="fa fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                        </button>
                    </td>
			    </tr>';
            }
            return $tabla;
        }
    }

    public function getArea($id)
    {
        $res = $this->info_model->getArea($id);
        if($res){
            foreach($res as $row){
                $data['nombre'][] = $row->nombre;
                $data['descripcion'][] = $row->descripcion;
            }
            echo json_encode($data);
        } else {
            echo '400';
        }
    }

    public function postArea()
    {
        $data = array(
            'nombre'       => $this->input->post('nombre'),
            'descripcion'  => $this->input->post('descripcion')
        );
        $area = $this->general->insertaBase('areas', $data);
        if($area){
            echo true;
        } else {
            return false;
        }
    }

    public function putArea()
    {
        $datos = array(
            'nombre'       => $this->input->post('nombre'),
            'descripcion'  => $this->input->post('descripcion')
        );
        $where = array('area_id' => $this->input->post('area'));
        $qry = $this->main_model->update($datos, 'areas', $where);
        if($qry) {
            echo true;
        } else {
            echo false;
        }
    }

    public function deleteArea()
    {
        $where = array(
            'area_id'   => $this->input->post('area')
        );
        $query = $this->main_model->delete($where, 'areas');
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
        // tabla con todas las areas
        $data["tabla"]  = $this->_tabla();
        //paso el main
        $data["main"] 	 = $this->load->view('areas/areas',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        // js a usar
        $data['js'] = 'inicio/areas.js';
        //cargo vista general
        $this->load->view('home/layout_general',$data);
    }
}
