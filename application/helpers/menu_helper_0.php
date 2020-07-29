<?php
/**
 * HELPER para el MENÚ PRINCIPAL
 *
 * Controla el funcionanmiento y la vista del menú principal
 *
 */

#################################################################################################
#                           Funciones para el control de la lógica                              #
#################################################################################################
/**
 * Carga de Sesión de ID de usuario
 * @return mixed
 */
function user_id()
{
    $CI =& get_instance();
    $CI->load->library('session');
    return $CI->session->userdata('id_usr');
}


/**
 * Arreglo para buscar si existe en el arreglo en un menu
 * @param bool/array $modulo
 * @param bool/array $controlador
 * @return array
 */
function group_links($modulo = FALSE, $controlador = FALSE)
{
    $i = 1;
    $arr_new = array();
    $CI =& get_instance();
    $CI->load->model('general');
    $privilegios_db = $CI->general->get_data_all(user_id(), $modulo, $controlador);
    //print_r($privilegios_db);
    if (!empty($privilegios_db)) {
        foreach ($privilegios_db as $privilegios_arr) {
            if ($privilegios_arr->activo == 1 && $privilegios_arr->perfil < 3) {
                $arr_new[$i++] = array(
                    'modulo' => $privilegios_arr->modulo,
                    'controlador' => $privilegios_arr->controlador,
                    'ruta' => $privilegios_arr->modulo . '/' . $privilegios_arr->controlador,
                    'perfil' => $privilegios_arr->perfil
                );
            }
        }
    } else {
        $arr_new = array();
    }
    return $arr_new;
}

/**
 * Carga los módulos en la vista para crear los links de forma que si existe se carga
 * @param $modulo array
 * @return array
 */
function search_links($modulo)
{
    switch ($modulo) {
        case $modulo == 'inicio':
            $inicio = group_links($modulo);
            return $inicio;
            break;
        case $modulo == 'home':
            $home = group_links($modulo);
            return $home;
            break;
        case $modulo == 'landing':
            $landing = group_links($modulo);
            return $landing;
            break;
        case $modulo == 'avance_fisico':
            $avance_fisico = group_links($modulo);
            return $avance_fisico;
            break;
        case $modulo == 'carga_documental':
            $carga_documental = group_links($modulo);
            return $carga_documental;
            break;
        case $modulo == 'contratos':
            $contratos = group_links($modulo);
            return $contratos;
            break;
        case $modulo == 'avance_financiero':
            $ministraciones = group_links($modulo);
            return $ministraciones;
            break;
        case $modulo == 'operaciones':
            $operaciones = group_links($modulo);
            return $operaciones;
            break;
        case $modulo == 'usuarios':
            $usuarios = group_links($modulo);
            return $usuarios;
            break;
        case $modulo == 'reportes':
            $reportes = group_links($modulo);
            return $reportes;
            break;
        case $modulo == 'inversiones':
            $reportes = group_links($modulo);
            return $reportes;
            break;
        case $modulo == 'cuenta':
            $reportes = group_links($modulo);
            return $reportes;
            break;    
        default:
            redirect('inicio');
            break;
    }
}

/**
 * Se genera un nuevo arreglo para presentar en home_menu_view
 * @param $modulo
 * @return array
 */
function send_links($modulo)
{
    $i = 1;
    $qry = search_links($modulo);
    $data = array();
    if ($qry != 0) {
        foreach ($qry as $item) {
            $data[$i++] = array(
                'modulo' => $item['modulo'],
                'controlador' => $item['controlador'],
                'ruta' => $item['ruta']
            );
        }
    }
    return $data;
}

/**
 * Se verifica la la sesión si existe la condición y el filtro de estados
 * @return bool|mixed
 */
function check_acceso()
{
    $CI =& get_instance();
    $CI->load->library('session');
    $CI->load->library('form_validation');
    $CI->load->helper('form');
    $data = $CI->session->userdata('condicion');
    $estados = $CI->input->post('estado_condicion');

    if (!$CI->session->userdata('filtros_acceso')) {
        if ($estados == NULL) {
            $array = explode(",", $data);
            $CI->session->set_userdata('filtros_acceso', $data);
            return $array;
        } else {
            $CI->session->set_userdata('filtros_acceso',$data);
        }
    } else {
        $exist_filter  = $CI->session->userdata('filtros_acceso');
        if ($estados == $exist_filter) {
            $filter_current = explode(",", $exist_filter);
            return $filter_current;
        } else {
            if ($estados == FALSE) {
                $filter_current = explode(",", $exist_filter);
                return $filter_current;
            } else {
                $separado = implode(",", $estados);
                $CI->session->unset_userdata('filtros_acceso');
                $CI->session->set_userdata('filtros_acceso',$separado);
                $new_filter = explode(",", $separado);
                //echo '<meta http-equiv="refresh"/>';
               // redirect('refresh');
                return $new_filter;
            }
        }
    }
}

/**
 * Método que trae la consulta de los datos que tiene el mismo id
 * @return mixed
 */
function get_privilegios_data()
{
    $CI =& get_instance();
    $CI->load->model('general');
    return $CI->general->get_data_all(user_id());
}

/**
 * Método que carga el estado que se consulta
 * @param $where
 * @return bool
 */
function get_states($where)
{
    if ($where) {
        $CI =& get_instance();
        $CI->load->model('main_model');
        $CI->load->model('inicio/ingreso_model');
        if ($CI->ingreso_model->get_menu_states($where)) {
            return $CI->ingreso_model->get_states($where);
        }
    } else {
        return FALSE;
    }
}

/**
 * Función que permite vincula los nombres de los estados para el modal
 * @return bool/array
 */
function get_states_user_condicion()
{
    $i = 0;
    $CI =& get_instance();
    $CI->load->library('session');
    $CI->load->model('inicio/ingreso_model');
    $data = $CI->session->userdata('condicion');
    if ($data) {
        $array = explode(",", $data);
    } else {
        $array = FALSE;
    }

    if ($array) {
        foreach ($array as $item) {
            $estados = get_states($item);
            if ($estados){
                foreach ($estados as $single) {
                    $cantidad = $CI->ingreso_model->get_menu_states($single->id_estados);
                    $estado[$i++] = array(
                        'id_estados' => $single->id_estados,
                        'nombre_estado' => $single->nombre_estado,
                        'cantidad' => $cantidad
                    );
                    //print_r($estado);
                }
            }
        }
    } else {
        $estado = FALSE;
    }
    return $estado;
}

function foreach_estates($data)
{
    $i = 0;
    $CI =& get_instance();
    $CI->load->model('inicio/ingreso_model');
    if ($data) {
        foreach ($data as $item) {
            $estados = get_states($item);
            if ($estados) {
                foreach ($estados as $single) {
                    $cantidad = $CI->ingreso_model->get_menu_states($single->id_estados);
                    $estado[$i++] = array(
                        'id_estados' => $single->id_estados,
                        'nombre_estado' => $single->nombre_estado,
                        'cantidad' => $cantidad
                    );
                    //print_r($estado);
                }
            }
        }
    } else {
        $estado = FALSE;
    }
    return $estado;
}

function array_objects_estados()
{
    return foreach_estates(check_acceso());
}

/**
 * Método que reempaqueta la consulta de los modulos que están cargados por usuario
 * @param bool $data
 * @return bool|mixed
 */
function check_foreach($data = FALSE)
{
    if (!empty($data)) {
        $i = 0;
        foreach ($data as $privilegios_arr) {
            if ($privilegios_arr->activo == 1 && $privilegios_arr->perfil < 3) {
                $arr_new[$i++] = array(
                    'id_modulo' => $privilegios_arr->id_modulo,
                    'modulo' => $privilegios_arr->modulo,
                    'controlador' => $privilegios_arr->controlador,
                    'perfil' => $privilegios_arr->perfil
                );
            }
        }
        $json = json_encode($arr_new);
        $arr_new = json_decode($json);
    } else {
        $arr_new = FALSE;
    }
    return $arr_new;
}

/**
 * Método que carga los id de los estados que seleccionen los usuarios
 * @param $acceso
 * @return bool
 */
function create_filter($acceso)
{
    if ($acceso) {
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->session->unset_userdata('filtros_acceso');
        return $CI->session->set_userdata('filtros_acceso', $acceso);
    } else {
        return FALSE;
    }
}

/**
 * Método que para accesar a los datos de los estados que se cargan en el filtro
 * @return mixed
 */
function filter_states()
{
    $CI =& get_instance();
    $CI->load->library('session');
    return $CI->session->userdata('filtros_acceso');
}

function clean_filter()
{
    $CI =& get_instance();
    $CI->load->library('session');
    if ($CI->session->userdata('filtros_acceso')) {
        $CI->session->unset_userdata('filtros_acceso');
        array_objects_estados();
    }
}
/**
 * Método que carga todas las funciones involucradas en la carga de filtros por estado
 * @return bool|mixed
 */
function load_filter_states()
{
    //$condicion_id = foreach_estates(check_acceso());
    //return get_states($condicion_id);
    //return check_acceso()[0];
    //return create_filter(check_acceso());
    //return check_foreach(get_privilegios_data());
    //return filter_states();
    //return group_links(FALSE, FALSE);
    //return user_id();
    //return get_privilegios_data();
    create_filter(check_acceso());
    //return check_acceso();
    return filter_states();
}

?>
