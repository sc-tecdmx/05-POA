<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clase que se encarga de controlar las sesiones y sus permisos
 */
class Cuenta extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $models = array(
            'home/general',
            'cuenta_model',
            'inicio/main_model',
            'home/home_inicio',
            'querys_db',
            'usuarios_db'

        );
		$this->load->model($models);

    }


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

	function _send_email($to,$subject,$data,$from='contacto@inifed.info',$from_name='SIPE')
    {

		$this->email->clear();
		$this->email->from($from,$from_name);
		$this->email->reply_to($from,$from_name);
		$this->email->bcc($from,$from_name);
		$this->email->to($to);
		$this->email->subject($subject);
        $this->email->message($this->load->view('cuenta_email', $data, TRUE));
        $this->email->send();
		//$this->email->view('cuenta_email', $data);
		//$this->load->view('cuenta_email', $data);
    }

    /**
	 * Método que actualiza el password
	 * @param  int $nsf Número de id de usuario
	 * @return array/string Actualización del password
	 */
	public function cambiarPassword()
	{
        $usuario  = $this->session->userdata('id_usr');

		$info_usr = $this->general->consultaCatalogo('g_registros', array('nsf'=>$usuario), FALSE, TRUE, FALSE);
		$user_tb = $this->general->consultaCatalogo('s_control', array('nsf'=>$usuario), FALSE, TRUE, FALSE);

		if($usuario && $info_usr != NULL){
			if (!$this->form_validation->run('cambio_password') == FALSE) {
				if($this->input->post('pass') == $this->input->post('pass2')) {
					$change = array(
						'password' 		 => user_hash_password($this->input->post('pass')),
						'cambioPassword' => time()
					);
					$where = array(
						'nsf' => $info_usr->nsf
					);
					$up = $this->general->actualizaBase('s_control', $change, $where);
					//print_r($info_usr);
					if($up) {
						$mail_data['usuario'] =  $user_tb->usuario;
						$mail_data['password'] =  $this->input->post('pass');
						$this->_send_email($info_usr->correo2, 'Cambio de contraseña de SIPE', $mail_data, $from='contacto@inifed.info', $from_name='SIPE');
					}
					$this->session->set_userdata('mensaje_password', message_session('msg_update_field'));
					redirect('cuenta/cuenta/editarUsuario', 'refresh');
				} else {
					$this->session->set_userdata('mensaje_password', message_session('msg_error_field_update'));
					redirect('cuenta/cuenta/editarUsuario', 'refresh');
				}

			} else {
				$this->session->set_userdata('mensaje_password', message_session('msg_error_field_update'));
				redirect('cuenta/cuenta/editarUsuario', 'refresh');
			}

		} else {
			$this->session->set_userdata('mensaje','<div class="notice"> <span>Usuario  inexistente</span> <p>Por favor seleccióne otra opción</p></div>');
			redirect('cuenta/cuenta/editarUsuario','refresh');
		}
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

    public function editarUsuario()
	{
		$nsf =  $this->session->userdata('id_usr');
        // Reviso si hay mensajes y los mando a las variables de la vista
        if ($this->session->userdata('mensaje')) {
            $mensaje = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        } else {
            $mensaje = FALSE;
        }

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

					if ($this->form_validation->run('cuenta') == TRUE && $this->form_validation->run('cambio_password') == TRUE) {
						$change_arr = array(
							'registro'			  => time(),
							'modificacion' 		  => time(),
							'nombre'			  => $this->input->post('nombre'),
							'correo'			  => $this->input->post('correo'),
							'apellido'			  => $this->input->post('apellido'),
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
								//'usuario'  => $this->input->post('usuario'),
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
					redirect('cuenta/cuenta/editarUsuario');
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

				$unidad = $this->home_inicio->get_unidad($this->session->userdata('area_id'));
        		$data['unidad'] = $unidad ? $unidad[0]->nombre : 'No se encontró la unidad';

				$data['header']  = $this->load->view('home/home_header', $data, TRUE);
				$data['menu'] 	  = $this->load->view('home/home_menu', $data, TRUE);
				$data['seccion'] = 'Editar usuario';
				$data['js'] 	  = 'usuario/nuevo_usuario.js';
				$data['main'] 	  = $this->load->view('usuario_forma', $data, TRUE);
				$data['salir']   = $this->load->view('home/home_salir', $data, TRUE);
				$this->load->view('home/layout_general',$data);
			} else {
				$this->session->set_userdata('mensaje', message_session('msg_field_dont_exits'));
				redirect('cuenta/cuenta/editarUsuario');
			}
		} else {
			$this->session->set_userdata('mensaje', message_session('msg_user_dont_exist'));
			redirect('cuenta/cuenta/editarUsuario');

		}
	}

    public function index()
    {
        $data=array();

        //$data['tabla']  = $this->_tabla();
        if($this->session->userdata('mensaje')){
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }
        $data["header"] = $this->load->view('home/home_header',$data,TRUE);
        $data["menu"]   = $this->load->view('home/home_menu',$data,TRUE);
        $data["salir"]  = $this->load->view('home/home_salir',$data,TRUE);
        $data["main"]   = $this->load->view('show_view',$data,TRUE);
        // $data['js']     = 'ministraciones/ministraciones.js';
        $this->load->view('home/layout_general',$data);
	}
}
