<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clase que contrala la vista principal
 */
class Landing extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		//Modules::run( 'inicio/verificaIngreso' );
	}

	/**
	 * Método que carga la vista principal.
	 * @return array Vista general
	 */
	public function index()
	{
		$data = array();
		//cargo vista general
		$this->load->view('layout_general',$data);
	}
}
