<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador encargado de la gestión de usuarios para el sistema
 */
class Usuarios extends MX_Controller {

	/**
	 * Contructor donde se instancias archivos externos.
	 */
	function __construct()
	{
		parent::__construct();
		Modules::run( 'inicio/verificaIngreso' );
        Modules::run( 'inicio/verifica_privilegios' );

		$models = array(
			'home/general',
			'usuarios_db',
			'querys_db'
		);
		$this->load->model($models);

        if($this->session->userdata('modulo_acceso') != 1){
            $this->session->set_userdata('mensaje', message_session('msg_privileges'));
            redirect('home');
        }
	}

	/**
	 * Muestra a los usuarios registrados de acuerdo con su ultimo visita.
	 * @return array Se carga la vistas con los datos
	 */
	public function index()
	{
		$i = 1;
		//obtengo usuarios
		$result = $this->usuarios_db->get_info_user();
		if($result){
			foreach ($result as $reg) {
				$nfs_id = array('nsf'=>$reg->nsf);
				$accesos = $this->general->consultaCatalogo2('s_accesos', $nfs_id, "id_acceso", 1, FALSE);
				if ($accesos == FALSE) {
					$ingreso = '';
				} else {
					$ingreso = acomodaUnixtime($accesos->ingreso);
				}

				if ($reg->activo == 1) {
					$activo = 'Activo';
				} else {
					$activo = 'Inactivo';
				}

				$result_arr[$i++] = array(
					'nombre'  => $reg->nombre . ' ' .$reg->apellido,
					'correo'  => $reg->correo,
					'usuario' => $reg->usuario,
					'ingreso' => $ingreso,
					'activo'  => $activo,
					'nsf' 	  => $reg->nsf
				);
			}
			$data['listado_personal'] = $result_arr;
		}
		//var_dump($this->session->userdata('mensaje'));
		// Reviso si hay mensajes y los mando a las variables de la vista
		
		if($this->session->userdata('mensaje')){
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }
		$data = array(
			'header'  => $this->load->view('home/home_header', $data, TRUE), //$data[0]
			'menu' 	  => $this->load->view('home/home_menu', $data, TRUE), //$data[1]
			'estados' => catalogoInterno('estados'), //cargo catalogos internos, $data[2]
			'seccion' => 'Usuarios', // $data[3]
			'js'	  => 'usuario/tabla_usuarios.js', //$data[4]
			'main' 	  => $this->load->view('usuarios_vista', $data, TRUE), //paso el main
			'salir'	  => $this->load->view('home/home_salir', $data, TRUE) //paso confirmacion de salir
		);

		$this->load->view('home/layout_general', $data);
	}


    /**
	 * Método que transforma del arreglo de perfiles en un listado para dropdown.
	 * @return array 	$p_arr 	Arreglo con los perfiles
	 */
	protected function perfiles_dropdown()
	{
		$perfiles = $this->usuarios_db->get_all_perfiles();
		$p_arr = array();
		$p_arr['0'] = 'Seleciona una opción';
		foreach ($perfiles as $key) {
			if ($key->activo == 1) {
				$p_arr[$key->id_perfil] = $key->perfil;
			}
		}
		return $p_arr;
	}

	/**
	 * Método que descompone el arreglo de objetos de los modulos y lo muestra
	 * de una manera más acorde a las necesidades de la vista.
	 * @return array 	$mod_arr Arreglo con las perfiles ordenados por Id y
	 * 							 módulo y controlador.
	 */
	protected function modules_clean()
	{
		$mod = $this->usuarios_db->get_modulo();
		$i = 0;
		$mod_arr = array();
		foreach ($mod as $key) {
			if ($key->activo == 1) {
				$mod_arr[$i++] = array(
					'id_modulo' => $key->id_modulo,
					'type' => $key->modulo . " / " . $key->controlador
				);
			}
		}
		return $mod_arr;
	}

	/**
	 * Método que permite el registro de usuarios por el administrador.
	 * @return array vistas
	 */
	public function nuevoUsuario()
	{
		if (!$this->form_validation->run('usuario') == FALSE && !$this->form_validation->run('cambio_password') == FALSE) {

			$usuario   = array('usuario'=>$this->input->post('usuario'));
			$mail  	   = array('correo'=>$this->input->post('correo'));
			$info_usr  = $this->general->consultaCatalogo('s_control', $usuario, FALSE, TRUE, FALSE);
			$mail_user = $this->general->consultaCatalogo('g_registros', $mail, FALSE, TRUE, FALSE);

			if($this->input->post('pass') == $this->input->post('pass2')) {
				if(!isset($mail_user->correo)) {
					if (!isset($info_usr->usuario)) {
						/**
						 * Inserción de datos en el registro de la tabla g_registros
						 * @var array
						 */
						$data_registro = array(
							'registro'			  => time(),
							'nombre'			  => $this->input->post('nombre'),
							'correo'			  => $this->input->post('correo'),
							'nombre'			  => $this->input->post('nombre'),
							'apellido'			  => $this->input->post('apellido'),
							'genero'			  => $this->input->post('genero'),
							'nacimiento'		  => $this->input->post('nacimiento'),
							'edad'	 			  => $this->input->post('edad'),
							'correo2'			  => $this->input->post('correo'),
							'info_complementaria' => $this->input->post('info_complementaria'),
							'activo'			  => '1'
						);
	
						//insertamos en g_registros
						$inserta_registro = $this->general->insertaBase('g_registros', $data_registro);
						if($inserta_registro){
							$correo 	  = array('correo'=>$this->input->post('correo'));
							$consulta_usr = $this->general->consultaCatalogo('g_registros', $correo, FALSE, TRUE, FALSE);
	
							/**
							 * Arreglo con los datos para la inserción de datos en la tabla s_control
							 * @var array
							 */
							$data_control = array(
								'registro' => time(),
								'usuario'  => $this->input->post('usuario'),
								'password' => user_hash_password($this->input->post('pass')),
								'activo'   => '1',
								'nsf'      => $consulta_usr->nsf
							);
							//ya guardado regresa a lista
							$inserta_control = $this->general->insertaBase('s_control', $data_control);
							
							if($inserta_control){
								$this->session->set_userdata('mensaje', message_session('msg_register_field'));
								redirect('usuarios');
							} /*else {
								//borramos de gregistros
								$id_nsf = array('nsf' => $info_usr->nsf);
								$this->general->consultaCatalogo('g_registros', $correo, FALSE, TRUE, FALSE);
								$this->general->borraBase('g_registros', $id_nsf);
								$this->session->set_userdata('mensaje', message_session('msg_error_field_register'));
							}*/
						} else {
							$this->session->set_userdata('mensaje', message_session('msg_error_field_register'));
							redirect('usuarios');
						}
					} else {
						$this->session->set_userdata('mensaje',  message_session('msg_avatar_exits'));
					}
				} else {
					$this->session->set_userdata('mensaje', message_session('msg_email_exits'));
				}
			} else {
				$show_me = '
								<div class="alert alert-warning alert-dismissible fade show" role="alert">
									<strong><i class="far fa-lightbulb"></i> ¡Sugerencia!</strong> Verifique que las contraseñas sean iguales por favor.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								';
					$this->session->set_userdata('mensaje', $show_me);
			}
		}

		// Reviso si hay mensajes y los mando a las variables de la vista
        if ($this->session->userdata('mensaje')) {
            $mensaje = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        } else {
            $mensaje = FALSE;
        }
		//cargo catalogos internos

		$data = array(
			'genero'   => catalogoInterno('genero'),
			'modulos'  => $this->modules_clean(),
			'perfiles' => $this->perfiles_dropdown(),
			'mensaje'  => $mensaje
		);

		//cargo menu
		$data["header"]  = $this->load->view('home/home_header',$data,TRUE);
		$data["menu"]    = $this->load->view('home/home_menu',$data,TRUE);
		//paso seccion
		$data["seccion"] = "Nueva Usuario";
		$data['js'] 	 = 'usuario/nuevo_usuario.js';
		//paso el main
		$data["main"] 	 = $this->load->view('usuario_forma',$data,TRUE);
		//paso confirmacion de salir
		$data["salir"] 	= $this->load->view('home/home_salir',$data,TRUE);
		//cargo vista general
		$this->load->view('home/layout_general',$data);
	}

	/**
	 * Método que muestra los datos del usuario registrado
	 * @param  int $nsf 	ID del nfs
	 * @return array 		vistas
	 */
	public function verUsuario()
	{
		$nsf = $this->uri->segment(3);
		
		$result = $this->usuarios_db->get_user($select = '*', $nsf);

		if($result) {
			$privilegios_tb = $this->usuarios_db->get_privilegios($nsf);
			if($privilegios_tb == 0) {
				$show_me = '
							<div class="alert alert-info alert-dismissible fade show" role="alert">
								<strong><i class="far fa-lightbulb"></i> ¡Sugerencia!</strong> Aún no se ha asignado permisos al usuario.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							';
				$this->session->set_userdata('mensaje', $show_me);
			}

			foreach ($result as $reg) {
				//$nfs_id = array('nsf'=>$reg->nsf);
				$condicion_tb =  $this->usuarios_db->get_condicion($reg->nsf);
                //var_dump($condicion_tb);
                if ($condicion_tb) {
                    $estados_tb   = $this->usuarios_db->get_estados_condicion($condicion_tb->condicion);
                } else {
                    $estados_tb = NULL;
                }

				if (is_null($reg->registro)) {
					$reg->registro = 'N/A';
				} else {
					$reg->registro = acomodaUnixtime((int)$reg->registro);
				}

				if (is_null($reg->modificacion)) {
					$reg->modificacion = 'N/A';
				} else {
					$reg->modificacion = acomodaUnixtime((int)$reg->modificacion);
				}

				if (is_null($reg->info_complementaria)) {
					$reg->info_complementaria = 'N/A';
				} else {
					$reg->info_complementaria = $reg->info_complementaria;
				}

				if (is_null($reg->correo2)) {
					$reg->correo2 = 'N/A';
				}

				if (is_null($reg->dispositivos)) {
					$reg->dispositivos = 'N/A';
				}

				if (is_null($reg->activacion)) {
					$reg->activacion = 'N/A';
				}

				if (is_null($reg->vigenciaActivacion)) {
					$reg->vigenciaActivacion = 'N/A';
				}

				$result_arr = array(
					'nombre' 			  => $reg->nombre,
					'apellido' 			  => $reg->apellido,
					'genero' 			  => $reg->genero,
					'nacimiento' 		  => $reg->nacimiento,
					'edad' 			      => $reg->edad,
					'usuario' 			  => $reg->usuario,
					'correo'  			  => $reg->correo,
					'correo2' 			  => $reg->correo2,
					'info_complementaria' => $reg->info_complementaria,
					'registro' 			  => $reg->registro,
					'modificacion' 		  => $reg->modificacion,
					'activacion' 		  => $reg->activacion,
					'vigenciaActivacion'  => $reg->vigenciaActivacion,
					'dispositivos' 	      => $reg->dispositivos,
					'bloqueado'           => $reg->bloqueado,
					'activo'  			  => $reg->activo,
					'nsf' 	  			  => $reg->nsf,
                    'estados'             => $estados_tb
				);
			}

			$obj = array((object)$result_arr);
			if(!$obj) {
				$this->session->set_userdata('mensaje', message_session('msg_user_dont_exist'));
				redirect('usuarios');
			}

			if($this->session->userdata('mensaje') != NULL) {
				$mensaje = $this->session->userdata('mensaje');
				$this->session->unset_userdata('mensaje');
			} else {
			    $mensaje = FALSE;
			}

			if($this->session->userdata('mensaje_password')) {
				$mensaje_password = $this->session->userdata('mensaje_password');
				$this->session->unset_userdata('mensaje_password');
			} else {
			    $mensaje_password = FALSE;
			}
			
			$data = array(
				'genero' 	  	    => catalogoInterno('genero'),
				'estados'     	    => catalogoInterno('estados'),
				//'edos'            => $this->usuarios_db->get_estados(),
				'usuario' 	        => $obj,
				'privilegios' 	    => $privilegios_tb,
				'mensaje'  	  	    => $mensaje,
				'mensaje_password'  => $mensaje_password,
                'table'             => $this->get_table_user($nsf)
			);

			$data = array(
				'header'  => $this->load->view('home/home_header', $data, TRUE),
				'menu' 	  => $this->load->view('home/home_menu', $data, TRUE),
				'seccion' => 'Detalle de usuario',
				'js' 	  => 'usuario/tabla_usuarios.js',
				'main' 	  => $this->load->view('detalle_usuario', $data, TRUE),
				'salir'   => $this->load->view('home/home_salir', $data, TRUE)
			);
			$this->load->view('home/layout_general',$data);
		} else {
			$this->session->set_userdata('mensaje', message_session('msg_user_dont_exist'));
			redirect('usuarios');
		}
	}

	/**
	 * Método que edita los datos del usuario
	 * @param  int 	$nsf 	Número de id del usuario
	 * @return array 		Vistas
	 */
	public function editarUsuario()
	{
		$nsf = $this->uri->segment(3);

		if (isset($nsf)) {
			$result = $this->usuarios_db->get_user($select = '*', $nsf);
			if($result != 0){
				$privilegios_tb = $this->usuarios_db->get_privilegios($nsf);
	
				if($privilegios_tb == 0) {
					$show_me = '
								<div class="alert alert-info alert-dismissible fade show" role="alert">
									<strong><i class="far fa-lightbulb"></i> ¡Sugerencia!</strong> Aún no se ha asignado permisos al usuario.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								';
					$this->session->set_userdata('mensaje', $show_me);
				}
	
				
				if($result){
					foreach ($result as $campo) {
						$campo;
					}
				}
	
				if ($privilegios_tb != NULL) {
					foreach ($privilegios_tb as $key) {
						$key;
					}
				}
					
				$usuario  = array('usuario' => $result[0]->usuario);
				$info_usr = $this->general->consultaCatalogo('s_control', $usuario, FALSE, TRUE, FALSE);
				
				if ($info_usr) {
				
					if ($this->form_validation->run('usuario') == TRUE && $this->form_validation->run('cambio_password') == TRUE) {
						$change_arr = array(
							'registro'			  => time(),
							'modificacion' 		  => time(),
							'nombre'			  => $this->input->post('nombre'),
							'correo'			  => $this->input->post('correo'),
							'apellido'			  => $this->input->post('apellido'),
							'genero'			  => $this->input->post('genero'),
							'nacimiento'		  => $this->input->post('nacimiento'),
							'edad'	 			  => $this->input->post('edad'),
							'correo2'			  => $this->input->post('correo2'),
							'info_complementaria' => $this->input->post('info_complementaria'),
							'activo'			  => '1'
						);
	
						$where = array(
							'nsf' =>   $result[0]->nsf
						);
						
	
						$change_registro = $this->general->actualizaBase('g_registros', $change_arr, $where);
	
						if($change_registro){
							$correo 	  = array('correo'=>$this->input->post('correo'));
							$consulta_usr = $this->general->consultaCatalogo('g_registros', $correo, FALSE, TRUE, FALSE);
							/**
							 * Arreglo con los datos para la inserción de datos en la tabla s_control
							 * @var array
							 */
							$change_control_arr = array(
								'registro' => time(),
								'usuario'  => $this->input->post('usuario'),
								//'password' => user_hash_password($this->input->post('pass')),
								'activo'   => '1',
								//'nsf'      => $consulta_usr->nsf
							);
							//ya guardado regresa a lista
							$change_control = $this->general->actualizaBase('s_control', $change_control_arr, $where);
	
							if($change_control){
								$this->session->set_userdata('mensaje', '<div class="success"> <span>Usuario</span> <p> Se actualizo con éxito.</p></div>');
							} else {
								//borramos de gregistros
								$id_nsf = array('nsf' => $info_usr->nsf);
								$this->general->consultaCatalogo('g_registros', $correo, FALSE, TRUE, FALSE);
								//$this->general->borraBase('g_registros', $id_nsf);
								$this->session->set_userdata('mensaje', '<div class="errormsj"> <span>Usuario</span> <p> Ocurrió un problema, vuelva a intentarlo.</p></div>');
							}
						} else {
							$this->session->set_userdata('mensaje', '<div class="errormsj"> <span>Usuario</span> <p> Ocurrió un problema, vuelva a intentarlo.</p></div>');
							//redirect('Usuarios');
						}
					}
				} else {
					$this->session->set_userdata('mensaje', message_session('msg_field_dont_exits') . "++++");
					redirect('usuarios');
				}
	
				// Reviso si hay mensajes y los mando a las variables de la vista
				if ($this->session->userdata('mensaje')) {
					$mensaje = $this->session->userdata('mensaje');
					$this->session->unset_userdata('mensaje');
				} else {
					$mensaje = FALSE;
				}
				
	
				$data = array(
					'estados'  => catalogoInterno('estados'),
					'genero'   => catalogoInterno('genero'),
					'modulos'  => $this->modules_clean(),
					'perfiles' => $this->perfiles_dropdown(),
					'p_actual' => $privilegios_tb,
					'user'     => $campo,
					'mensaje'  => $mensaje
				);
				
				$data['header']  = $this->load->view('home/home_header', $data, TRUE);
				$data['menu'] 	  = $this->load->view('home/home_menu', $data, TRUE);
				$data['seccion'] = 'Editar usuario';
				$data['js'] 	  = 'usuario/nuevo_usuario.js';
				$data['main'] 	  = $this->load->view('usuario_forma', $data, TRUE);
				$data['salir']   = $this->load->view('home/home_salir', $data, TRUE);
				$this->load->view('home/layout_general',$data);
			} else {
				$this->session->set_userdata('mensaje', message_session('msg_field_dont_exits'));
				redirect('Usuarios');
			}
		} else {
			$this->session->set_userdata('mensaje', message_session('msg_user_dont_exist'));
			redirect('usuarios');

		}
	}

	/**
	 * Método que actualiza el password
	 * @param  int $nsf Número de id de usuario
	 * @return array/string Actualización del password
	 */
	public function cambiarPassword($nsf = FALSE)
	{
		$usuario  = array('nsf'=> $nsf);
		
		$info_usr = $this->general->consultaCatalogo('s_control', $usuario, FALSE, TRUE, FALSE);

		if($nsf && $info_usr != NULL){
			if (!$this->form_validation->run('cambio_password') == FALSE) {
				if($this->input->post('pass') == $this->input->post('pass2')) {
					$change = array(
						'password' 		 => user_hash_password($this->input->post('pass')),
						'cambioPassword' => time()
					);
					$where = array(
						'nsf' =>  $nsf
					);
					$this->general->actualizaBase('s_control', $change, $where);
					$this->session->set_userdata('mensaje_password', message_session('msg_update_field'));
					redirect('usuarios/verusuario/'. $nsf, 'refresh');
				} else {
					$this->session->set_userdata('mensaje_password', message_session('msg_error_field_update'));
					redirect('usuarios/verusuario/'. $nsf, 'refresh');
				}

			} else {
				$this->session->set_userdata('mensaje_password', message_session('msg_error_field_update'));
				redirect('usuarios/verusuario/'. $nsf, 'refresh');
			}

		} else {
			$this->session->set_userdata('mensaje','<div class="notice"> <span>Usuario  inexistente</span> <p>Por favor seleccióne otra opción</p></div>');
			redirect('usuarios','refresh');
		}
	}
	/**
	 * Método que edita la baja del usuario
	 * @param  int 		$nsf 	Número del id del usuario.
	 * @return array 			Control para el bóton.
	 */
	public function baja($nsf = FALSE)
	{
        if ($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        } else {
            $data['mensaje'] = FALSE;
        }

		if($nsf){
			$change = array(
				'activo' => 0
			);
			$change_reg = array(
				'activo' => 1,
				'modificacion' => time()
			);
			$where = array(
				'nsf' =>  $nsf
			);
			$registros_tb = $this->general->actualizaBase('g_registros', $change_reg, $where);
			$control_tb   = $this->general->actualizaBase('s_control', $change, $where);
			if($control_tb && $registros_tb) {
				$this->session->set_userdata('mensaje_password','<div class="notice"> <span>Usuario dado de baja</span> <p>Baja confirmada</p></div>');
				redirect('usuarios/verusuario/'. $nsf, 'refresh');
			} else {
				$this->session->set_userdata('mensaje_password', message_session('msg_error_field_update'));
				redirect('usuarios/verusuario/'. $nsf, 'refresh');
			}
			
		} else {
			$this->session->set_userdata('mensaje','<div class="notice"> <span>Usuario  inexistente</span> <p>Por favor seleccióne otra opción</p></div>');
			redirect('usuarios','refresh');
		}
	}

	/**
	 * Método que edita la alta del usuario.	
	 * @param  int 		$nsf 	Número del id del usuario.
	 * @return array 			Control para el bóton.
	 */
	public function reactivar($nsf)
	{
		if($nsf){
			$change = array(
				'activo' => 1
			);
			$change_reg = array(
				'activo' => 1,
				'modificacion' => time()
			);
			$where = array(
				'nsf' =>  $nsf
			);
			$registros_tb = $this->general->actualizaBase('g_registros', $change_reg, $where);
			$control_tb   = $this->general->actualizaBase('s_control', $change, $where);
			if($control_tb && $registros_tb) {
				$this->session->set_userdata('mensaje_password','<div class="notice"> <span>Usuario reactivado</span> <p>Reactivación confirmada</p></div>');
				redirect('usuarios/verusuario/'. $nsf, 'refresh');
			} else {
				$this->session->set_userdata('mensaje_password', message_session('msg_error_field_update'));
				redirect('usuarios/verusuario/'. $nsf, 'refresh');
			}
		} else {
			$this->session->set_userdata('mensaje','<div class="notice"> <span>Usuario  inexistente</span> <p>Por favor seleccióne otra opción</p></div>');
			redirect('usuarios','refresh');
		}
	}

	/**
	 * Método que  asigna los roles del usuario
	 * @return array/string Inserción de datos para los privilegios
	 */
	public function rol()
	{
		$nsf        = $this->uri->segment(3);
		$privilegio = $this->uri->segment(4);

        if ($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        } else {
            $data['mensaje'] = FALSE;
        }

		if ($nsf != NULL && $privilegio != NULL) {
			$get_privilegios = $this->usuarios_db->get_privilegios($nsf);

			if ($get_privilegios == 0) {
				$modulo_tb = $this->usuarios_db->get_modulo();
				$k         = 1;

				foreach ($modulo_tb as $modulo) {
					if($modulo->id_modulo < 29) {
						$data_privilegios = array(
							'id_modulo' => $modulo->id_modulo,
							'activo'	=> '1',
							'perfil'    => $privilegio,
							'nsf' 		=> $nsf,
							'condicion' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32'
	
						);
						$insert[$k++] = $this->general->insertaBase('s_privilegios', $data_privilegios);
					}
				}
				if ($privilegio == 1) {
                    $this->session->set_userdata('mensaje', message_session('msg_permission_read'));
                    redirect('usuarios/verusuario/' . $nsf);
                } elseif ($privilegio == 2) {
                    $this->session->set_userdata('mensaje', message_session('msg_permission_write_read'));
                    redirect('usuarios/verusuario/' . $nsf);
                } else {
                    $this->session->set_userdata('mensaje', message_session('msg_permission_not_access'));
                    redirect('usuarios/verusuario/' . $nsf);
                }
			}
		} else {
			$this->session->set_userdata('mensaje','<div class="notice"> <span>Usuario  inexistente</span> <p>Por favor seleccióne otra opción</p></div>');
			redirect('usuarios');
		}
	}

	/**
	 * Método para actualizar los roles del usuario uno por uno
	 * @return array Se actualiza roles uno por uno
	 */
	public function actualiza()
	{
		$nsf        = $this->uri->segment(3);
		$privilegio = $this->uri->segment(4);
		$id_mod     = $this->uri->segment(5);

        if ($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        } else {
            $data['mensaje'] = FALSE;
        }

		if ($nsf != NULL && $privilegio != NULL) {
			$get_privilegios = $this->usuarios_db->get_privilegios($nsf);
			if ($get_privilegios) {
				foreach ($get_privilegios as $privilegio_arr) {
					$privilegio_arr->ids_privilegios;
				}
				$this->usuarios_db->get_modulo();
				$data_privilegios = array(
					'perfil'    => $privilegio,
				);
				$nsf_arr = array(
					'nsf'             => $nsf,
					'ids_privilegios' => $id_mod
				);
				$this->general->actualizaBase('s_privilegios', $data_privilegios, $nsf_arr);

                if ($privilegio == 1) {
                    $string = message_session('msg_permission_read');
                } elseif ($privilegio == 2) {
                    $string = message_session('msg_permission_write_read');
                } else {
					$string_0 = message_session('msg_permission_not_access');
					$this->session->set_userdata('mensaje', $string_0 );
                }
				$this->session->set_userdata('mensaje_password', $string );
				redirect('usuarios/verUsuario/' . $nsf);
			}
		} else {
			$this->session->set_userdata('mensaje','<div class="notice"> <span>Usuario  inexistente</span> <p>Por favor seleccióne otra opción</p></div>');
			redirect('usuarios');
		}
	}

    public function especial()
    {
        $nsf                 = $this->uri->segment(3);
        $data['areas']       = $this->usuarios_db->get_areas();
        $data['perfiles']    = $this->usuarios_db->get_all_perfiles();
        $estado              = $this->input->post();
        if ($this->input->post()) {
            if ($estado != NULL){
                $condicion =  $estado;
                if ($condicion['perfiles'] != NULL) {
                    if (!is_null($nsf)) {
                        $get_privilegios = $this->usuarios_db->get_privilegios($nsf);

                        if ($condicion['estados'] != NULL && $condicion['perfiles'] != NULL) {
                            $separado = implode(",", $condicion['estados']);
                            //print_r($privilegio);
                            //print_r($separado);
                            if ($get_privilegios == 0) {
                                $modulo_tb = $this->usuarios_db->get_modulo();
                                $k = 1;
                                //print_r($modulo_tb);
                                foreach ($modulo_tb as $modulo) {
                                    if($modulo->id_modulo < 29) {
										$data_privilegios = array(
											'id_modulo' => $modulo->id_modulo,
											'activo'	=> '1',
											'perfil'    => $condicion['perfiles'],
											'nsf' 		=> $nsf,
											'condicion' => $separado
										);
										$insert[$k++] = $this->general->insertaBase('s_privilegios', $data_privilegios);
									}
                                }
                                if ($condicion['perfiles'] == 1) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } elseif ($condicion['perfiles'] == 2) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_write_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } else {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_not_access'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                }
                            }
                        } else {
                            $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados</p></div>');
                            redirect('usuarios/especial/' . $nsf);
                        }

                    } else {
                        $this->session->set_userdata('mensaje', message_session('msg_field_dont_exits'));
                        redirect('usuarios');
                    }

                } else {
                    $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de privilegios</p></div>');
                    redirect('usuarios/especial/' . $nsf);
                }
            } else {
                $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados y privilegios</p></div>');
                redirect('usuarios/especial/' . $nsf);
            }
        }

        if($this->session->userdata('mensaje') != NULL) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data = array(
            'header'  => $this->load->view('home/home_header', $data, TRUE),
            'menu' 	  => $this->load->view('home/home_menu', $data, TRUE),
            'seccion' => 'Detalle de usuario',
            'js' 	  => 'usuario/usuario_egresado.js',
            'main' 	  => $this->load->view('estados_vista', $data, TRUE),
            'salir'   => $this->load->view('home/home_salir', $data, TRUE)
        );
        $this->load->view('home/layout_general',$data);
	}
	
	public function inversiones_uno()
    {
        $nsf                 = $this->uri->segment(3);
        $data['estados_mex'] = $this->usuarios_db->get_estados();
        $data['perfiles']    = $this->usuarios_db->get_all_perfiles();
        $estado              = $this->input->post();
        if ($this->input->post()) {
            if ($estado != NULL){
                $condicion =  $estado;
                if ($condicion['perfiles'] != NULL) {
                    if (!is_null($nsf)) {
                        $get_privilegios = $this->usuarios_db->get_privilegios($nsf);

                        if ($condicion['estados'] != NULL && $condicion['perfiles'] != NULL) {
                            $separado = implode(",", $condicion['estados']);
                            //print_r($privilegio);
                            //print_r($separado);
                            if ($get_privilegios == 0) {
                                $modulo_tb = $this->usuarios_db->get_modulo();
                                $k = 1;
                                //print_r($modulo_tb);
                                foreach ($modulo_tb as $modulo) {
									if($modulo->id_modulo >= 29 && $modulo->id_modulo <= 36) {
										$data_privilegios = array(
											'id_modulo'             => $modulo->id_modulo,
											'activo'	            => '1',
											'perfil'                => $condicion['perfiles'],
											'nsf' 		            => $nsf,
                                            'perfil_inversiones'    => 1,
											'condicion'             => ($separado == NULL)? '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32': $separado
										);
										$insert[$k++] = $this->general->insertaBase('s_privilegios', $data_privilegios);
									}
                                }
                                if ($condicion['perfiles'] == 1) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } elseif ($condicion['perfiles'] == 2) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_write_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } else {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_not_access'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                }
                            }
                        } else {
                            $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados</p></div>');
                            redirect('usuarios/especial/' . $nsf);
                        }

                    } else {
                        $this->session->set_userdata('mensaje', message_session('msg_field_dont_exits'));
                        redirect('usuarios');
                    }

                } else {
                    $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de privilegios</p></div>');
                    redirect('usuarios/especial/' . $nsf);
                }
            } else {
                $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados y privilegios</p></div>');
                redirect('usuarios/especial/' . $nsf);
            }
        }

        if($this->session->userdata('mensaje') != NULL) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data = array(
            'header'  => $this->load->view('home/home_header', $data, TRUE),
            'menu' 	  => $this->load->view('home/home_menu', $data, TRUE),
            'seccion' => 'Detalle de usuario',
            'js' 	  => 'usuario/usuario_egresado.js',
            'main' 	  => $this->load->view('estados_vista', $data, TRUE),
            'salir'   => $this->load->view('home/home_salir', $data, TRUE)
        );
        $this->load->view('home/layout_general',$data);
    }

    public function inversiones_dos()
    {
        $nsf                 = $this->uri->segment(3);
        $data['estados_mex'] = $this->usuarios_db->get_estados();
        $data['perfiles']    = $this->usuarios_db->get_all_perfiles();
        $estado              = $this->input->post();
        if ($this->input->post()) {
            if ($estado != NULL){
                $condicion =  $estado;
                if ($condicion['perfiles'] != NULL) {
                    if (!is_null($nsf)) {
                        $get_privilegios = $this->usuarios_db->get_privilegios($nsf);

                        if ($condicion['estados'] != NULL && $condicion['perfiles'] != NULL) {
                            $separado = implode(",", $condicion['estados']);
                            //print_r($privilegio);
                            //print_r($separado);
                            if ($get_privilegios == 0) {
                                $modulo_tb = $this->usuarios_db->get_modulo();
                                $k = 1;
                                //print_r($modulo_tb);
                                foreach ($modulo_tb as $modulo) {
                                    if($modulo->id_modulo >= 29 && $modulo->id_modulo <= 36) {
                                        $data_privilegios = array(
                                            'id_modulo' => $modulo->id_modulo,
                                            'activo'	=> '1',
                                            'perfil'    => $condicion['perfiles'],
                                            'nsf' 		=> $nsf,
                                            'perfil_inversiones' => 2,
                                            'condicion' => ($separado == NULL)? '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32': $separado
                                        );
                                        $insert[$k++] = $this->general->insertaBase('s_privilegios', $data_privilegios);
                                    }
                                }
                                if ($condicion['perfiles'] == 1) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } elseif ($condicion['perfiles'] == 2) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_write_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } else {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_not_access'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                }
                            }
                        } else {
                            $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados</p></div>');
                            redirect('usuarios/especial/' . $nsf);
                        }

                    } else {
                        $this->session->set_userdata('mensaje', message_session('msg_field_dont_exits'));
                        redirect('usuarios');
                    }

                } else {
                    $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de privilegios</p></div>');
                    redirect('usuarios/especial/' . $nsf);
                }
            } else {
                $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados y privilegios</p></div>');
                redirect('usuarios/especial/' . $nsf);
            }
        }

        if($this->session->userdata('mensaje') != NULL) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data = array(
            'header'  => $this->load->view('home/home_header', $data, TRUE),
            'menu' 	  => $this->load->view('home/home_menu', $data, TRUE),
            'seccion' => 'Detalle de usuario',
            'js' 	  => 'usuario/usuario_egresado.js',
            'main' 	  => $this->load->view('estados_vista', $data, TRUE),
            'salir'   => $this->load->view('home/home_salir', $data, TRUE)
        );
        $this->load->view('home/layout_general',$data);
    }

    public function inversiones_tres()
    {
        $nsf                 = $this->uri->segment(3);
        $data['estados_mex'] = $this->usuarios_db->get_estados();
        $data['perfiles']    = $this->usuarios_db->get_all_perfiles();
        $estado              = $this->input->post();
        if ($this->input->post()) {
            if ($estado != NULL){
                $condicion =  $estado;
                if ($condicion['perfiles'] != NULL) {
                    if (!is_null($nsf)) {
                        $get_privilegios = $this->usuarios_db->get_privilegios($nsf);

                        if ($condicion['estados'] != NULL && $condicion['perfiles'] != NULL) {
                            $separado = implode(",", $condicion['estados']);
                            
                            if ($get_privilegios == 0) {
                                $modulo_tb = $this->usuarios_db->get_modulo();
                                $k = 1;
                                //print_r($modulo_tb);
                                foreach ($modulo_tb as $modulo) {
                                    if($modulo->id_modulo >= 29 && $modulo->id_modulo <= 36) {
                                        $data_privilegios = array(
                                            'id_modulo' => $modulo->id_modulo,
                                            'activo'	=> '1',
                                            'perfil'    => $condicion['perfiles'],
                                            'nsf' 		=> $nsf,
                                            'perfil_inversiones' => 3,
                                            'condicion' => ($separado == NULL)? '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32': $separado
                                        );
                                        $insert[$k++] = $this->general->insertaBase('s_privilegios', $data_privilegios);
                                    }
                                }
                                if ($condicion['perfiles'] == 1) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } elseif ($condicion['perfiles'] == 2) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_write_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } else {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_not_access'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                }
                            }
                        } else {
                            $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados</p></div>');
                            redirect('usuarios/especial/' . $nsf);
                        }

                    } else {
                        $this->session->set_userdata('mensaje', message_session('msg_field_dont_exits'));
                        redirect('usuarios');
                    }

                } else {
                    $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de privilegios</p></div>');
                    redirect('usuarios/especial/' . $nsf);
                }
            } else {
                $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados y privilegios</p></div>');
                redirect('usuarios/especial/' . $nsf);
            }
        }

        if($this->session->userdata('mensaje') != NULL) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data = array(
            'header'  => $this->load->view('home/home_header', $data, TRUE),
            'menu' 	  => $this->load->view('home/home_menu', $data, TRUE),
            'seccion' => 'Detalle de usuario',
            'js' 	  => 'usuario/usuario_egresado.js',
            'main' 	  => $this->load->view('estados_vista', $data, TRUE),
            'salir'   => $this->load->view('home/home_salir', $data, TRUE)
        );
        $this->load->view('home/layout_general',$data);
    }

    public function inversiones_cuatro()
    {
        $nsf                 = $this->uri->segment(3);
        $data['estados_mex'] = $this->usuarios_db->get_estados();
        $data['perfiles']    = $this->usuarios_db->get_all_perfiles();
        $estado              = $this->input->post();
        if ($this->input->post()) {
            if ($estado != NULL){
                $condicion =  $estado;
                if ($condicion['perfiles'] != NULL) {
                    if (!is_null($nsf)) {
                        $get_privilegios = $this->usuarios_db->get_privilegios($nsf);

                        if ($condicion['estados'] != NULL && $condicion['perfiles'] != NULL) {
                            $separado = implode(",", $condicion['estados']);
                            //print_r($privilegio);
                            //print_r($separado);
                            if ($get_privilegios == 0) {
                                $modulo_tb = $this->usuarios_db->get_modulo();
                                $k = 1;
                                //print_r($modulo_tb);
                                foreach ($modulo_tb as $modulo) {
                                    if($modulo->id_modulo >= 29 && $modulo->id_modulo <= 36) {
                                        $data_privilegios = array(
                                            'id_modulo' => $modulo->id_modulo,
                                            'activo'	=> '1',
                                            'perfil'    => $condicion['perfiles'],
                                            'nsf' 		=> $nsf,
                                            'perfil_inversiones' => 4,
                                            'condicion' => ($separado == NULL)? '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32': $separado
                                        );
                                        $insert[$k++] = $this->general->insertaBase('s_privilegios', $data_privilegios);
                                    }
                                }
                                if ($condicion['perfiles'] == 1) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } elseif ($condicion['perfiles'] == 2) {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_write_read'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                } else {
                                    $this->session->set_userdata('mensaje', message_session('msg_permission_not_access'));
                                    redirect('usuarios/verusuario/' . $nsf);
                                }
                            }
                        } else {
                            $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados</p></div>');
                            redirect('usuarios/especial/' . $nsf);
                        }

                    } else {
                        $this->session->set_userdata('mensaje', message_session('msg_field_dont_exits'));
                        redirect('usuarios');
                    }

                } else {
                    $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de privilegios</p></div>');
                    redirect('usuarios/especial/' . $nsf);
                }
            } else {
                $this->session->set_userdata('mensaje','<div class="notice"> <span>Selección:</span> <p>Por favor seleccione o marque una casilla de estados y privilegios</p></div>');
                redirect('usuarios/especial/' . $nsf);
            }
        }

        if($this->session->userdata('mensaje') != NULL) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data = array(
            'header'  => $this->load->view('home/home_header', $data, TRUE),
            'menu' 	  => $this->load->view('home/home_menu', $data, TRUE),
            'seccion' => 'Detalle de usuario',
            'js' 	  => 'usuario/usuario_egresado.js',
            'main' 	  => $this->load->view('estados_vista', $data, TRUE),
            'salir'   => $this->load->view('home/home_salir', $data, TRUE)
        );
        $this->load->view('home/layout_general',$data);
    }

    private function get_table_user($id){
        $res = $this->usuarios_db->get_user_conection($id);
        $i = 0;
        if ($res) {
            $table 	= '';
            $table .= '<table class="table table-striped table-responsive" id="tabla_acciones">
	                        <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Última conexión</th>
                                    <th>Última url</th>
                                </tr>
							</thead>
                            <tbody id="lista_acciones">';
            foreach ($res as $row) {

                $i++;
                $table .= '<tr>
                               <td>' . $i . '</td>
                               <td>' . acomodaUnixtime($row->ultimaActividad) . '</td>
                               <td>' . $row->ultimaUrl . '</td>
                           </tr>';
            }
            $table .= '</tbody></table>';
        } else {
            $table = FALSE;
        }

        return $table;
    }
}
