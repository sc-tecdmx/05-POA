<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filtro extends MX_Controller {
    function __construct()
    {
        parent::__construct();

        //Modules::run( 'inicio/verificaIngreso' );
        //Modules::run( 'inicio/verifica_privilegios' );
        $models = array(
            'inicio/main_model',
            'inicio/ingreso_model',
            'general'
        );
        $this->load->model($models);
    }

    /**
     * Método que verifica si existe alguna acción con el estaddo que se consulta, para hacer un conteo
     * @param $where
     * @return bool
     */
    protected  function get_states($where)
    {
        if ($where) {
            if ($this->ingreso_model->get_menu_states($where)) {
                return $this->ingreso_model->get_states($where);
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Método que consulta los estados si existen y los recarga con los datos que se necesitan para mostrar en la vista
     * @param $string
     * @return bool
     */
    public function load_states($string)
    {
        $array = explode(",", $string);
        if (is_array($array)) {
            $i = 0;
            foreach ($array as $item) {
                $estados = $this->get_states($item);
                if ($estados){
                    foreach ($estados as $single) {
                        $cantidad = $this->ingreso_model->get_menu_states($single->id_estados);
                        $estado[$i++] = array(
                            'id_estados'    => $single->id_estados,
                            'nombre_estado' => strtoupper($single->nombre_estado),
                            'cantidad'      => $cantidad
                        );
                    }
                }
            }

            $res  = $estado; //str_replace(array("\r", "\n"), '',  $estado);
        } else {
            $res =  FALSE;
        }
        return $res;
        //echo json_encode(str_replace(array("\r", "\n"), '',  $res));
    }

    /**
     * Método para enviar información al modal de filtro
     */
    public function get_menu_qry()
    {
        $condicion = $this->session->userdata('condicion');
        echo json_encode($this->load_states($condicion));
    }

    public function get_filtro()
    {
        $filtro = $this->session->userdata('filtros_acceso');
        $condicion = $this->session->userdata('condicion');
        if ($filtro) {
            echo json_encode($this->load_states($filtro));
        } else {
            echo json_encode($this->load_states($condicion));
        }
        //echo json_encode($this->load_states($qry));
        //echo json_encode($qry);
    }

    public function post_states()
    {
        $edo = $this->input->post('edo');
        //var_dump($edo);
        $qry = json_decode($edo);
        if(is_array($qry) && ! empty($qry)) {
            $i = 0;
            $data = array();
            foreach ($qry as $item) {
                $data[$i++] = $item->value;
            }
            $separado = implode(",", $data);
            $this->session->unset_userdata('filtros_acceso');
            $this->session->set_userdata('filtros_acceso', $separado);
        } else {
            $separado  = NULL;
        }
        echo json_encode( $separado);

        //return $separado;
    }

    public function first_condition()
    {
        $req = $this->input->post('req');
        if($req == TRUE) {
            $this->session->unset_userdata('filtros_acceso');
            $condicion = $this->session->userdata('condicion');
            echo json_encode($this->load_states($condicion));
        }
        
    }
}
