<?php

class Cuenta_model extends CI_Model {

	function __construct(){
		parent::__construct();
		$models = array(
			'home/general',
			'inicio/main_model',
			'usuarios/usuarios_db',
            'usuarios/querys_db'
		);
		$this->load->model($models);
	}
}
