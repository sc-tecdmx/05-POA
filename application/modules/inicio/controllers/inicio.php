<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clase que se encarga de controlar las sesiones y sus permisos
 */
class inicio extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $models = array(
            'ingreso_model',
            'home/general'
        );
        $this->load->model($models);
    }

    private function _limpiaVariablesSesion()
    {
        $this->session->unset_userdata('id_acceso');
        $this->session->unset_userdata('id_usr');
        $this->session->unset_userdata('nombre_usr');
        $this->session->unset_userdata('tipo_usr');
        $this->session->unset_userdata('modulo_acceso');
        $this->session->unset_userdata('perfil');
        $this->session->unset_userdata('condicion');
        $this->session->unset_userdata('ejercicio');
        $this->session->unset_userdata('anio');
        $this->session->unset_userdata('area');
        $this->session->unset_userdata('modo');
    }

    private function _cierraSesion()
    {
        if($this->session->userdata('id_acceso')){
            $this->load->model('ingreso_model');
            $this->ingreso_model->cierraAcceso();
        }
    }

    private function _verificaPermisos($user)
    {
        $verifica = $this->ingreso_model->verificaPermisos($user);
        if($verifica){
            return true;
        } else {
            return false;
        }
    }

    private function _login_in()
    {//REGRESA $edo FALSE SI FALLA EL LOGUEO, TRUE EN EXITO
        $edo           = false;
        $user_name     = $this->input->post('usuario');//SETEA USUARIO COMO unidades_responsable
        $user_password = $this->input->post('pass');//SETEA PASS COMO user_password
        // validación de asignación de permisos
        echo "<br>debug";

        if($this->_verificaPermisos($user_name)){
            $data          = $this->ingreso_model->getPassUsr($user_name);//CONSULTA s_control con el $user_name
            if($data){
                if($data->activo != 0){//FILTRO DE USUARIO ACTIVO->1, INACTIVO->0
                    $compara = user_check_password($user_password, $data->password);//CHECA EL PASS QUE VIENE EN HASH
                    if($compara){
                        $nombre = $this->ingreso_model->getPassData($data->nsf);//CONSULTA g_registros con el $nsf
                        //Registramos el accseso del usuario y obtenemos su identificador de acceso
                        /*echo "<br>fdsa:" . $nombre->perfil; //Poner estos para debuguear
                        exit;*/
                        $this->session->set_userdata('permiso', $nombre->perfil);
                        $this->session->set_userdata('validacion', $nombre->validacion);
                        $this->session->set_userdata('cerrado', $nombre->cerrado);
                        $this->session->set_userdata('area_id', $nombre->area_id);
                        if($nombre->perfil != '1'){
                            // obtener las areas que puede consultar
                            $areas = $this->ingreso_model->getAreaAccesos($data->nsf);
                            
                            if($areas){
                                $ro = array();
                                foreach($areas as $area){
                                    array_push($ro, $area->responsable_operativo_id);
                                }
                                $this->session->set_userdata('area', $ro);
                            }
                        }
                        $nombre = $nombre->nombre." ".$nombre->apellido;
                        // if($id_acceso = $this->ingreso_model->setAcceso($data->nsf, $this->session->userdata('ip_address'), $this->session->userdata('user_agent'))){
						if($id_acceso = $this->ingreso_model->setAcceso($data->nsf, $this->input->ip_address(), $this->input->user_agent())){
                            // Obtengo datos de identificacion del usuario para usarlos como variable sesion
                            $this->session->set_userdata('id_acceso',$id_acceso);//SE OTORGA UN id_acceso POR SESSION
                            $this->session->set_userdata('id_usr',$data->nsf);
                            $this->session->set_userdata('nombre_usr',$nombre);

                            if($this->input->post('modo') === 'elaboracion'){
                                $ejercicio = $this->ingreso_model->get_ejercicio();
                                $this->session->set_userdata('ejercicio', $ejercicio->ejercicio_id);
                                $this->session->set_userdata('anio', $ejercicio->ejercicio);
                                $this->session->set_userdata('modo', 'elaboracion');
                            } else {
                                $seguimiento = $this->ingreso_model->getEjercicioSeguimiento();
                                $this->session->set_userdata('ejercicio', $seguimiento->ejercicio_id);
                                $this->session->set_userdata('anio', $seguimiento->ejercicio);
                                $this->session->set_userdata('modo', 'seguimiento');
                            }

                            if($this->input->post('modo') === 'seguimiento'){
                                redirect(base_url('inicio/proyectos'), 'refresh');
                            }

                            //ROMPE FLUJO, REDIRECCIONA
                            redirect(base_url('inicio/proyectos'), 'refresh');
                        }
                    }
                } else {
                    $msg ='<div class="notice"><span>Usuario bloqueado</span>
                <p>El sistema ha detectado una operación poco común de su cuenta o las secciones
                a las que tiene acceso se encuentran en mantenimiento. Le pedimos contactar
                al administrador del sistema.</p></div>';
                    $this->session->set_userdata('mensaje',$msg);
                    redirect(site_url().'inicio','refresh');
                }
            }
            return $edo;//FALSE-->USUARIO INACTIVO
        }
        return $edo;//FALSE-->USUARIO INACTIVO
    }

    private function _validaSesion()
    {
        //checa que esas dos variables de session existan
        if( $this->session->userdata('id_usr') && $this->session->userdata('id_acceso') ){
            $this->load->model('home/general');
            //checa en la tabla s_privilegios con el nsf que es el id_usuario
            if($data = $this->general->consultaCatalogo('s_privilegios',array('nsf'=>$this->session->userdata('id_usr')),FALSE,1,FALSE)){
                //asigna el id del modulo a una variable de sesion
                $this->session->set_userdata('modulo_acceso',$data->id_modulo);
            }
            if($this->ingreso_model->refreshActividad()){
                return true;
            }
            else{
                return true;
            }
        }
        return false;
    }

    public function cierraPorSistema()
    {
        $msg = '<div class="notice"><span>Sesión cerrada</span>
        <p>Automáticamente se ha cerrado su sesión por inactividad en el sistema.</p></div>';
        $this->session->set_userdata('mensaje',$msg);
        redirect('inicio','refresh');
    }

    public function verificaIngreso()
    {//ESTA ES EL METODO QUE SE INVOCA DESDE CADA MOUDULO
        //Valido sesion activo
        $this->load->model('ingreso_model');
        if($this->_validaSesion()){
            return true;
        } else {
            // No esta logeado lo mando a ingreso
            redirect('inicio');
        }
    }

    private function _ejercicios()
    {
        if ($query = $this->ingreso_model->getEjercicios()) {
            $ejercicios = array();
            foreach ($query as $row) {
                if($row->operacion_ejercicio_id == '1'){
                    $ejercicios['elaboracion'] = 'Elaboracion '.$row->ejercicio;
                } else if($row->operacion_ejercicio_id == '2') {
                    $ejercicios['seguimiento'] = 'Seguimiento '.$row->ejercicio;
                }

            }
            return $ejercicios;
        }
    }

    public function index()
    {
        $data = array();
        // Borramos variables de sesion
        $this->_limpiaVariablesSesion();
        // Reviso si hay mensajes y los mando a las variables de la vista
        if($this->session->userdata('mensaje')){
            $data2['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        if($this->form_validation->run('inicio')==TRUE){
            //PASO LA VALIDACION DEL BACK
            if($this->_login_in()){
                //_log_in() GUARDÓ DATOS EN TABLAS DE SISTEMA Y VARIABLES DE SESION ADEMAS DE QUE SE REDIRECCIONÓ
            } else {
                //redigimos a la vista un mensaje de error en la autenticasion
                $msg = '<div class="notice"><span>Ingreso</span>
                <p>Usuario o contraseña incorrectos. Favor de intentarlo nuevamente</p></div>';
                $data2['mensaje'] = $msg;
                $this->_cierraSesion(); // Cierra sesion de usuario en la base
                $this->_limpiaVariablesSesion(); // Limpia las variables que usamos para verificar sesión activo
                $data['main'] = $this->load->view('inicio_view',$data2,true);
            }
        } else {
            //limpiar session y direccionar a la vista principal
            $data2['check'] = true;
            $this->_cierraSesion(); // Cierra sesion de usuario en la base
            $this->_limpiaVariablesSesion(); // Limpia las variables que usamos para verificar sesión activo
            $data['main'] = $this->load->view('inicio_view',$data2,true);
        }

        //Reviso si hay mensajes y los mando a las variables de la vista
        if($this->session->userdata('mensaje')){
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $elaboracion = $this->ingreso_model->get_ejercicio();
        if($elaboracion){
            $data['ejercicios'] = $this->_ejercicios();
        }

        $data['js'] = 'ingreso/ingreso.js';
        $this->load->view('inicio_view',$data);
    }

    /**
     * Método que consulta al modelo los privilegios que tiene cada usuario.
     * @return mixed
     */
    public function verifica_privilegios()
    {
        $nsf = $this->session->userdata('id_usr');
        $url = $this->uri->uri_string();

        if (!empty($url)) {
            $explode_url = explode('/', $url);
            switch ($explode_url) {
                case !empty($explode_url[0]):
                    $privilegios_tb = $this->ingreso_model->get_data_all($nsf, $explode_url[0]);
                    break;

                case !empty($explode_url[0]) && !empty($explode_url[1]):
                    $privilegios_tb = $this->ingreso_model->get_data_all($nsf, $explode_url[0], $explode_url[1]);
                    break;
                default:
                    $this->_cierraSesion();
                    $this->session->set_userdata('mensaje', message_session('msg_privileges'));
                    redirect('inicio');
                    break;
            }
            if ($privilegios_tb[0]->perfil != 3 && !empty($privilegios_tb[0]->perfil)) {
                $newdata = array(
                    'perfil'    => $privilegios_tb[0]->perfil,
                    'condicion' => $privilegios_tb[0]->condicion,
                );
                $this->session->unset_userdata($newdata);
                return $this->session->set_userdata($newdata);
            } else {
                $this->_cierraSesion();
                $this->session->set_userdata('mensaje', message_session('msg_privileges'));
                redirect('inicio');
            }

        } else {
            $this->_cierraSesion();
            $this->session->set_userdata('mensaje', message_session('msg_privileges'));
            redirect('inicio');
        }
    }

}
