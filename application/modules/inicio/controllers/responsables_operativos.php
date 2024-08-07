<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Responsables_operativos extends MX_Controller
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
            'info_model'
        );
        $this->load->model($models);
    }

    private function _tabla()
    {
        $res = $this->home_inicio->get_responsables($this->session->userdata('ejercicio'));
        if($res){
            $tabla = '';
            foreach($res as $row){
                $tabla .= '
                <tr>
                    <td>' . $row->urnum . '</td>
					<td>' . $row->ronum . '</td>
					<td>' . $row->ronom . '</td>
					<td>
					    <button class="btn btn-outline" onclick="editarResponsableOperativo('.$row->responsable_operativo_id.')">
					        <i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i>
					    </button>
					    <button class="btn btn-outline" onclick="eliminarResponsableOperativo('.$row->responsable_operativo_id.')">
					        <i class="fa fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                        </button>
                    </td>
			    </tr>';
            }
            return $tabla;
        }
    }

    private function _unidades()
    {
        // $ejercicio = $this->home_inicio->get_ejercicio();
        if ($query = $this->home_inicio->get_unidades($this->session->userdata('ejercicio'))) {
            $unidades = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $unidades[$row->unidad_responsable_gasto_id] = $row->numero.' - '.$row->nombre;
            }
            return $unidades;
        }
    }

    public function getResponsableOperativo($id)
    {
        $res = $this->info_model->getResponsableOperativo($id);
        if($res){
            foreach($res as $row){
                $data['unidad'][] = $row->unidad_responsable_gasto_id;
                $data['nombre'][] = $row->nombre;
                $data['numero'][] = $row->numero;
            }
            echo json_encode($data);
        } else {
            echo '400';
        }
    }

    public function postResponsableOperativo()
    {
        $numero = $this->input->post('numero');
        $unidad = $this->input->post('unidad');
        $res = $this->info_model->getNumeroV($numero, $unidad, 'responsables_operativos');
        if($res){
            echo '400';
        } else {
            $data = array(
                'unidad_responsable_gasto_id'   => $this->input->post('unidad'),
                'numero'                        => $this->input->post('numero'),
                'nombre'                        => $this->input->post('nombre')
            );
            $ro = $this->general->insertaBase('responsables_operativos', $data);
            if($ro){
                echo true;
            } else {
                return false;
            }
        }
    }

    public function putResponsableOperativo()
    {
        $numero = $this->input->post('numero');
        $ro = $this->input->post('ro');
        $unidad = $this->input->post('unidad');
        // $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->info_model->getNumeroEditResponsable($numero, $unidad,$this->session->userdata('ejercicio'));
        if($res && $res->responsable_operativo_id != $ro){
            echo '400';
        } else {
            $datos = array(
                'unidad_responsable_gasto_id'   => $this->input->post('unidad'),
                'numero'                        => $this->input->post('numero'),
                'nombre'                        => $this->input->post('nombre'),
            );
            $where = array('responsable_operativo_id' => $ro);
            $qry = $this->main_model->update($datos, 'responsables_operativos', $where);
            if($qry) {
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function deleteResponsableOperativo()
    {
        $where = array(
            'responsable_operativo_id'   => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'responsables_operativos');
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

        $unidad = $this->home_inicio->get_unidad($this->session->userdata('area_id'));
        $data['unidad'] = $unidad ? $unidad[0]->nombre : 'No se encontró la unidad';
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Inicio / Responsables Operativos";
        // tabla con todos los proyectos
        $data["tabla"]  = $this->_tabla();
        /*print_r($data["tabla"]);
        exit;*/
        // obtención del catalogo de unidades
        $data['unidades'] = $this->_unidades();
        //paso el main
        $data["main"] 	 = $this->load->view('responsables_operativos/responsables_operativos',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        // js a usar
        $data['js'] = 'inicio/responsables_operativos.js';
        //cargo vista general
        $this->load->view('home/layout_general',$data);
    }
}

