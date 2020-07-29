<?php
$config = array(
	/**
	 * Módulo cuenta
	 */
	'cuenta' => array(
		array(
			'field' => 'nombre',
			'label' => 'Nombre',
			'rules' => 'trim|required|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'apellido',
			'label' => 'Apellido',
			'rules' => 'trim|required|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'correo',
			'label' => 'Correo',
			'rules' => 'trim|required|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'nacimiento',
			'label' => 'nacimiento',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'correo2',
			'label' => 'correo alaternativo',
			'rules' => 'trim|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'info_complementaria',
			'label' => 'información complementaria',
			'rules' => 'trim'
		),
		array(
			'field' => 'usuario',
			'label' => 'Usuario',
			'rules' => 'trim|min_length[4]|max_length[80]'
		)
	),

	/**
	 * Módulo usuarios
	 */
	'usuario' => array(
		array(
			'field' => 'nombre',
			'label' => 'Nombre',
			'rules' => 'trim|required|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'apellido',
			'label' => 'Apellido',
			'rules' => 'trim|required|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'genero',
			'label' => 'género',
			'rules' => 'trim|required|min_length[1]|max_length[1]|integer'
		),
		array(
			'field' => 'correo',
			'label' => 'Correo',
			'rules' => 'trim|required|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'nacimiento',
			'label' => 'nacimiento',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'edad',
			'label' => 'edad',
			'rules' => 'trim|min_length[2]|max_length[2]|integer'
		),
		array(
			'field' => 'correo2',
			'label' => 'correo alaternativo',
			'rules' => 'trim|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'info_complementaria',
			'label' => 'información complementaria',
			'rules' => 'trim'
		),
		array(
			'field' => 'usuario',
			'label' => 'Usuario',
			'rules' => 'trim|required|min_length[4]|max_length[80]'
		)
	),

	'cambio_password' => array(
		array(
			'field' => 'pass',
			'label' => 'Contraseña',
			'rules' => 'trim|required|min_length[4]|max_length[80]'
		),
		array(
			'field' => 'pass2',
			'label' => 'Confirmar Contraseña',
			'rules' => 'trim|required|min_length[4]|max_length[80]|matches[pass]'
		)
	),

	/**
	 * Módulo inicio
	 */
	'inicio' => array(
		array(
			'field' => 'usuario',
			'label' => 'Usuario',
			'rules' => 'trim|required|min_length[4]|max_length[30]'
		),
		array(
			'field' => 'pass',
			'label' => 'Contraseña',
			'rules' => 'required|min_length[4]|max_length[50]'
		)
	),
);
?>
