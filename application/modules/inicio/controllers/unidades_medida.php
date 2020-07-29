<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unidades_medida extends MX_Controller
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
            'inicio/ingreso_model',
            'home/home_inicio',
            'info_model',
            'main_model'
        );
        $this->load->model($models);
    }

    private function _tabla()
    {
        $res = $this->home_inicio->get_umedidas();
        if($res){
            $tabla = '';
            foreach($res as $row){
                $tabla .= '
                <tr>
                    <td>' . $row->numero . '</td>
					<td>' . $row->nombre . '</td>
					<td>' . $row->descripcion . '</td>
					<td>
					    <button class="btn btn-outline" onclick="editarUnidadMedida('.$row->unidad_medida_id.')">
					        <i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i>
					    </button>
					    <button class="btn btn-outline" onclick="eliminarMedida('.$row->unidad_medida_id.')">
					        <i class="fa fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                        </button>
                    </td>
			    </tr>';
            }
            return $tabla;
        }
    }

    public function getUnidadMedida($id)
    {
        $res = $this->info_model->getUnidadMedida($id);
        if($res){
            $data = array();
            foreach($res as $row){
                $data['numero'][]       = $row->numero;
                $data['nombre'][]       = $row->nombre;
                $data['descripcion'][]  = $row->descripcion;
                $data['porcentajes'][]  = $row->porcentajes;
            }
            echo json_encode($data);
        } else {
            echo '400';
        }
    }

    public function postUnidadMedida()
    {
        $numero = $this->input->post('numero');
        $res = $this->info_model->getNumero($numero, 'unidades_medidas');
        if($res){
            echo '400';
        } else {
            // $ejercicio = $this->home_inicio->get_ejercicio();
            $data = array(
                'ejercicio_id' => $this->session->userdata('ejercicio'),
                'numero'       => $this->input->post('numero'),
                'nombre'       => $this->input->post('nombre'),
                'descripcion'  => $this->input->post('descripcion'),
                'porcentajes'  => $this->input->post('porcentajes')
            );
            $ro = $this->general->insertaBase('unidades_medidas', $data);
            if($ro){
                echo true;
            } else {
                return false;
            }
        }
    }

    public function putUnidadMedida()
    {
        $numero = $this->input->post('numero');
        $unidad = $this->input->post('unidad');
        // $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->info_model->getNumeroEditUnidadMedida($numero, $this->session->userdata('ejercicio'));
        if($res && $res->unidad_medida_id != $unidad){
            echo '400';
        } else {
            $datos = array(
                'numero'         => $this->input->post('numero'),
                'nombre'         => $this->input->post('nombre'),
                'descripcion'    => $this->input->post('descripcion'),
                'porcentajes'    => $this->input->post('porcentajes')
            );
            $where = array('unidad_medida_id' => $unidad);
            $qry = $this->main_model->update($datos, 'unidades_medidas', $where);
            if($qry) {
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function deleteUnidadMedida()
    {
        $where = array(
            'unidad_medida_id'   => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'unidades_medidas');
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
        $data["main"] 	 = $this->load->view('unidades_medida/unidades_medida',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        // js a usar
        $data['js'] = 'inicio/unidades_medida.js';
        //cargo vista general
        $this->load->view('home/layout_general',$data);
    }
}


