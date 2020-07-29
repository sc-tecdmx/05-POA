<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subprogramas extends MX_Controller
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
        $res = $this->home_inicio->get_subprogramas();
        if($res){
            $tabla = '';
            foreach($res as $row){
                $tabla .= '
                <tr>
                    <td>' . $row->pgnum . '</td>
					<td>' . $row->sbnum . '</td>
					<td>' . $row->sbnom . '</td>
					<td>
					    <button class="btn btn-outline" onclick="editSubprogram('.$row->subprograma_id.')" >
					        <i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i>
					    </button>
					    <button class="btn btn-outline" onclick="deleteSubprogram('.$row->subprograma_id.')">
					        <i class="fa fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                        </button>
                    </td>
			    </tr>';
            }
            return $tabla;
        }
    }

    private function _programas()
    {
        if ($query = $this->home_inicio->get_programas()) {
            $programas = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $programas[$row->programa_id] = $row->numero.' - '.$row->nombre;
            }
            return $programas;
        }
    }

    public function getSubprogram($id)
    {
        $res = $this->info_model->getSubprograma($id);
        if($res){
            $data = array();
            foreach($res as $row){
                $data['programa'][] = $row->programa_id;
                $data['nombre'][]   = $row->nombre;
                $data['numero'][]   = $row->numero;
            }
            echo json_encode($data);
        } else {
            echo '400';
        }
    }

    public function postSubprogram()
    {
        $numero = $this->input->post('numero');
        $res = $this->info_model->getNumero($numero, 'subprogramas');
        if($res){
            echo '400';
        } else {
            $data = array(
                'programa_id'  => $this->input->post('programa'),
                'numero'       => $this->input->post('numero'),
                'nombre'       => $this->input->post('nombre')
            );
            $ro = $this->general->insertaBase('subprogramas', $data);
            if($ro){
                echo true;
            } else {
                return false;
            }
        }
    }

    public function putSubprogram()
    {
        $numero = $this->input->post('numero');
        $subprograma = $this->input->post('subprograma');
        // $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->info_model->getNumeroEditSubprograma($numero, $this->session->userdata('ejercicio'));
        if($res && $res->subprograma_id != $subprograma){
            echo '400';
        } else {
            $datos = array(
                'programa_id'    => $this->input->post('programa'),
                'numero'         => $this->input->post('numero'),
                'nombre'         => $this->input->post('nombre')
            );
            $where = array('subprograma_id' => $subprograma);
            $qry = $this->main_model->update($datos, 'subprogramas', $where);
            if($qry) {
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function deleteSubprogram()
    {
        $where = array(
            'subprograma_id'   => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'subprogramas');
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
        // programas
        $data['programas'] = $this->_programas();
        //paso el main
        $data["main"] 	 = $this->load->view('subprogramas/subprogramas',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        // js a usar
        $data['js'] = 'inicio/subprogramas.js';
        //cargo vista general
        $this->load->view('home/layout_general',$data);
    }
}


