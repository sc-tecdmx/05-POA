<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller
{
	/**
	 * Constructor que instancia archivos externos
	 */
	function __construct()
	{
		parent::__construct();

		Modules::run( 'inicio/verificaIngreso' );
        // Modules::run( 'inicio/verifica_privilegios' );
        $models = array(
            'home/general',
            'inicio/ingreso_model',
            'home_inicio'
        );
		$this->load->model($models);
	}

	private function _tabla()
    {
	    $res = $this->home_inicio->get_projects($this->session->userdata('ejercicio'));
	    if($res){
	        $tabla = '';
	        foreach($res as $row){
                $tabla .= '
                <tr>
					<td>' . $row->urnum . '</td>
					<td>' . $row->ronum . '</td>
					<td>' . $row->pgnum . '</td>
					<td>' . $row->sbnum . '</td>
					<td>' . $row->pynum . '</td>
					<td>' . $row->pydes . '</td>
					<td>
					    <a><i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i></a>
					    <a><i class="fa fa-fw fa-eye" data-toggle="tooltip" data-placement="top" title="Ver"></i></a>
					    <a><i class="fa fa-fw fa-file-export" data-toggle="tooltip" data-placement="top" title="PDF"></i></a>
					    <a><i class="fa fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i></a>
					</td>
			    </tr>';
            }
	        return $tabla;
        }
    }

    /**
	 * Método que se encarga del control del home
	 * @return array Vistas con sus datos correspondientes
	 */
	public function index()
	{
		// Si llegamos hasta aqui tenemos que ver la página de logeo
		$data = array();
		// Reviso si hay mensajes y los mando a las variables de la vista
		if($this->session->userdata('mensaje')) {
			$data['mensaje'] = $this->session->userdata('mensaje');
			$this->session->unset_userdata('mensaje');
		}
		//cargo menu
		$data["menu"]    = $this->load->view('home_menu',$data,TRUE);
		//cargo header
		$data["header"]  = $this->load->view('home_header',$data,TRUE);
		//paso seccion
		$data["seccion"] = "Inicio";
		// tabla con todos los proyectos
        $data["tabla"]  = $this->_tabla();
		//paso el main
		$data["main"] 	 = $this->load->view('home_vista',$data,TRUE);
		//paso confirmacion de salir
		$data["salir"]   = $this->load->view('home_salir',$data,TRUE);
		//cargo vista general
		$this->load->view('layout_general',$data);
	}
}
