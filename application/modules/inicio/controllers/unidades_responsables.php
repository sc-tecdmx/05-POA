<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unidades_responsables extends MX_Controller
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
                $tabla .= '
                <tr>
					<td>' . $row->numero . '</td>
					<td>' . $row->nombre . '</td>
                    <td class="' . ($row->cerrada ? 'finalizado-btn': '') . '">' . ($row->cerrada ? 'Cerrada': 'Abierta') . '</td>
					<td>
					    <button class="btn btn-outline" style="cursor: pointer" onclick="editaUnidadResponsable('.$row->unidad_responsable_gasto_id.')"><i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i></button>
					    <button class="btn btn-outline" style="cursor: pointer" onclick="eliminaUnidadResponsable('.$row->unidad_responsable_gasto_id.')"><i class="fa fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i></button>
                    </td>
			    </tr>';
            }
            return $tabla;
        }
    }

    public function getUnidadResponsable ($id)
    {
        $res = $this->info_model->getUnidadResponsable($id);
        if($res){
            foreach ($res as $row){
                $data['numero'][] = $row->numero;
                $data['nombre'][] = $row->nombre;
                $data['cerrada'][] = $row->cerrada;
            }
            echo json_encode($data);
        }
    }

    public function postUnidadResponsable ()
    {
        $numero = $this->input->post('numero');
        $res = $this->info_model->getNumero($numero, 'unidades_responsables_gastos');
        if($res){
            echo '400';
        } else {
            // $ejercicio = $this->home_inicio->get_ejercicio();
            $datos = array(
                'ejercicio_id' => $this->session->userdata('ejercicio'),
                'numero'    => $numero,
                'nombre'    => $this->input->post('nombre')
            );
            $unidad = $this->main_model->insert($datos, 'unidades_responsables_gastos');
            if($unidad){
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function putUnidadResponsable ()
    {
        $numero = $this->input->post('numero');
        $unidad = $this->input->post('unidad');
        // $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->info_model->getNumeroEditUnidad($numero, $this->session->userdata('ejercicio'));
        if($res && $res->unidad_responsable_gasto_id != $unidad){
            echo '400';
        } else {

            $datos = array(
                'ejercicio_id' => $this->session->userdata('ejercicio'),
                'numero'       => $numero,
                'nombre'       => $this->input->post('nombre')
            );

            // Condición para la actualización
            $where = array('unidad_responsable_gasto_id' => $unidad);

            // Verifica la validación antes de actualizar 'cerrada'
            if ($this->session->userdata('validacion') == 1) {
                $datos['cerrada'] = $this->input->post('cerrada');
            }

            // Realiza la actualización en 'unidades_responsables_gastos'
            $query = $this->main_model->update($datos, 'unidades_responsables_gastos', $where);

            if($this->session->userdata('validacion') == 1) {
                $this->db->set('cerrado', $this->input->post('cerrada'));
                $this->db->where('area_id', $unidad);
                $this->db->update('g_registros');
            }


            if($query){
                echo true;
            } else {
                echo '420';
            }
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
        $data["main"] 	 = $this->load->view('unidades_responsables/unidades_responsables',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        // js a usar
        $data['js'] = 'inicio/unidades_responsables.js';
        //cargo vista general
        $this->load->view('layout_general',$data);
    }
}
