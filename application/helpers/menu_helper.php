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
            $inversiones = group_links($modulo);
            return $inversiones;
            break;
        case $modulo == 'cuenta':
            $cuenta = group_links($modulo);
            return $cuenta;
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


?>