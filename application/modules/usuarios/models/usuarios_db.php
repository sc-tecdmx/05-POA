<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Modelo para consultas  en la base de datos
 */
class Usuarios_db extends CI_Model
{

    private $accesos_tb;

    /**
     * Contructor, dónde se carga un modelo génerico.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('querys_db');
        $this->accesos_tb = 's_accesos';
    }

    /**
     * Asignación del nombre de la tabla g_registros
     * @return string Nombre de  g_registros
     */
    protected function registros_tb()
    {
        return $this->querys_db->set_table($tb = 'g_registros');
    }

    /**
     * Método que asigna el nombre de la base al objeto Querys_db, para usuar
     * el método set_table
     * @return string Nombre de la tabla s_control
     */
    protected function control_tb()
    {
        return $this->querys_db->set_table($tb = 's_control');
    }

    /**
     * Método que asigna el nombre de la base al objeto Querys_db, para usuar
     * el método set_table
     * @return string Nombre de la tabla s_control
     */
    protected function accesos_tb()
    {
        return $this->querys_db->set_table($tb = 's_accesos');
    }

    /**
     * Método que asigna el nombre de la base al objeto Querys_db, para usuar
     * el método set_table
     * @return string Nombre de la tabla s_privilegios
     */
    protected function privilegios_tb()
    {
        return $this->querys_db->set_table($tb = 's_privilegios');
    }

    /**
     * Método que asigna el nombre de la base al objeto Querys_db, para usuar
     * el método set_table
     * @return string Nombre de la tabla s_perfiles
     */
    protected function perfiles_tb()
    {
        return $this->querys_db->set_table($tb = 's_perfiles');
    }

    /**
     * Método que asigna el nombre de la base al objeto Querys_db, para usuar
     * el método set_table
     * @return string Nombre de la tabla s_modulos
     */
    protected function modulos_tb()
    {
        return $this->querys_db->set_table($tb = 's_modulos');
    }

    /**
     * Función protejida creada para la consulta todos los campos de la tabla.
     * @return array Arreglo de consutla de campos
     */
    protected function get_array_modulo()
    {
        $data = array(
            'id_modulo',
            'modulo',
            'controlador',
            'activo'
        );
        return $this->querys_db->set_qry($data);
    }

    /**
     * Función protejida para consulta de la tabla de perfiles.
     * @return array    Se carga en una función génerica para el uso del arreglo.
     */
    protected function get_array_perfiles()
    {
        $data = array(
            'id_perfil',
            'perfil',
            'activo'
        );
        return $this->querys_db->set_qry($data);
    }

    /**
     * Función protejida que pasa un arreglo de los campos a consultar para
     * para mostrar los usuarios.
     * @return array Arreglo de datos a consultar
     */
    private function get_data_registro()
    {
        $data = array(
            $this->registros_tb() . '.nsf',
            $this->registros_tb() . '.nombre',
            $this->registros_tb() . '.apellido',
            $this->registros_tb() . '.segundo_apellido',
            $this->registros_tb() . '.correo',
            $this->registros_tb() . '.area_id',
            $this->control_tb() . '.usuario',
            $this->control_tb() . '.activo'
        );
        return $data;
    }

    /**
     * Función protejida que consulta los datos del usuario, para su edición
     * @return array Arreglo de datos a consultar
     */
    protected function get_data_user()
    {
        $data = array(
            $this->registros_tb() . '.nsf',
            $this->registros_tb() . '.nombre',
            $this->registros_tb() . '.apellido',
            $this->registros_tb() . '.segundo_apellido',
            $this->registros_tb() . '.correo',
            $this->privilegios_tb() . '.id_modulo',
            $this->control_tb() . '.usuario',
            $this->control_tb() . '.activo',
            $this->registros_tb() . '.genero',
            $this->control_tb() . '.password',
            $this->registros_tb() . '.nacimiento',
            $this->registros_tb() . '.correo2',
            $this->registros_tb() . '.info_complementaria',
            $this->registros_tb() . '.edad'
        );
        return $data;
    }

    /**
     * Método que consulta mediante joins
     * @param array $select Arreglo de cadenas
     * @param array $data Arreglo de cadenas
     * @param string $id_usuario Cadena
     * @return array               Arreglo de objetos
     */
    public function get_info_user($id_usuario = FALSE)
    {
        $this->db->select($this->get_data_registro());
        //$this->db->join($this->privilegios_tb(), $this->registros_tb() . '.nsf =  ' . $this->privilegios_tb() . '.nsf');
        $this->db->join($this->control_tb(), $this->registros_tb() . '.nsf = ' . $this->control_tb() . '.nsf');
        $this->db->from($this->registros_tb());
        if ($id_usuario) {
            $where = array(
                $this->registros_tb() . '.nsf' => $id_usuario
            );
            $this->db->where($where);
        }
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Método que consulta todos los módulos cargados en la base
     * @return array Arreglo de objetos
     */
    protected function get_all_data($data, $table)
    {
        $this->db->select($data);
        $this->db->from($table);
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return 0;
        }
    }

    /**
     * Función de consulta para traer los campos de la tabla modulo.
     * @return array/object Regresa un arreglo de objetos.
     */
    public function get_modulo()
    {
        return $this->get_all_data($this->get_array_modulo(), $this->modulos_tb());
    }

    /**
     * Método de consulta para traer los campos de la tabla perfiles
     * @return array/object     Regresa un arreglo de objetos
     */
    public function get_all_perfiles()
    {
        return $this->get_all_data($this->get_array_perfiles(), $this->perfiles_tb());
    }

    /**
     * Método que asigna el nombre de la base al objeto Querys_db, para usuar
     * el método set_table
     * @return string Nombre de la tabla cat_estados
     */
    protected function estados_tb()
    {
        return $this->querys_db->set_table($tb = 'cat_estados');
    }

    /**
     * Método que asigna el nombre de la base al objeto Querys_db, para usuar
     * el método set_table
     * @return string Nombre de la tabla cat_estados
     */
    protected function areas_tb()
    {
        return $this->querys_db->set_table($tb = 'areas');
    }

    /**
     * Función protejida creada para la consulta todos los campos de la tabla.
     * @return array Arreglo de consutla de campos
     */
    protected function get_array_estados()
    {
        $data = array(
            'id_estados',
            'nombre_estado'
        );
        return $this->querys_db->set_qry($data);
    }

    /**
     * Función protejida creada para la consulta todos los campos de la tabla.
     * @return array Arreglo de consutla de campos
     */
    protected function get_array_areas()
    {
        $data = array(
            'area_id',
            'nombre'
        );
        return $this->querys_db->set_qry($data);
    }

    /**
     * Función de consulta para traes los campos de la tabla areas
     * @return array/object Regresa un arreglo de objetos
     */
    public function get_areas()
    {
        return $this->get_all_data($this->get_array_areas(), $this->areas_tb());
    }

    /**
     * Función de consulta para traer los campos de la tabla modulo.
     * @return array/object Regresa un arreglo de objetos.
     */
    public function get_estados()
    {
        return $this->get_all_data($this->get_array_estados(), $this->estados_tb());
    }

    /**
     * Método génerico de consulta que permite traer los datos en especifico de
     * un campo en una tabla relacionada con otra por medio de INNER JOIN
     * @param array $select Arreglo con los campos a consultar.
     * @param int $id_usuario Id del campo a consultar en la tabla.
     * @return array/object        Regresa un arreglo de objetos con la
     *                             información resultante de la consulta.
     */
    public function get_user($select, $id_usuario = FALSE)
    {
        $this->db->select($select);
        $this->db->join($this->control_tb(), $this->registros_tb() . '.nsf = ' . $this->control_tb() . '.nsf');
        $this->db->from($this->registros_tb());
        if ($id_usuario) {
            $where = array(
                $this->registros_tb() . '.nsf' => $id_usuario
            );
            $this->db->where($where);
        }
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Método que consulta por medio de INNER JOIN  como eje la tabla de
     * s_privilegios.
     * @param int $id_usuario Id de la campo a consultar de la tabla.
     * @return array/object              Regresa arreglo de objetos con la
     *                                   información consultada.
     */
    public function get_privilegios($id_usuario = FALSE)
    {
        $this->db->select('*');
        if ($id_usuario) {
            $where = array(
                'nsf' => $id_usuario
            );
            $this->db->where($where);
        }
        $this->db->join($this->perfiles_tb(), $this->privilegios_tb() . '.perfil = ' . $this->perfiles_tb() . '.id_perfil');
        $this->db->join($this->modulos_tb(), $this->privilegios_tb() . '.id_modulo = ' . $this->modulos_tb() . '.id_modulo');
        $this->db->from($this->privilegios_tb());
        $query = $this->db->get();
        //print_r($query->result());
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return 0;
        }
    }

    /**
     * Método que consulta los estados de acuerdo a la condición que recibe
     * @param $condicion string
     * @return int
     */
    public function get_estados_condicion($condicion)
    {
        $this->db->select('*');
        $this->db->where('id_estados IN (' . $condicion . ')');
        $this->db->from($this->estados_tb());
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return 0;
        }
    }

    /**
     * Se obtiene la condición que exista con los estados
     * @param integer $nsf
     * @return int
     */
    public function get_condicion($nsf = FALSE)
    {
        $this->db->select('*');
        if ($nsf) {
            $this->db->where('nsf', $nsf);
        }
        $this->db->from($this->privilegios_tb());
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->row();
        } else {
            return 0;
        }
    }

    public function get_user_conection($id)
    {
        $this->db->select();
        $this->db->from($this->accesos_tb);
        if ($id) {
            $this->db->where($this->accesos_tb . '.nsf', $id);
        }
        $this->db->order_by('ultimaActividad', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getAreas($area)
    {
        $this->db->where('unidad_responsable_gasto_id', $area);
        $this->db->from('unidades_responsables_gastos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getUnidades($ejercicio)
    {
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('unidades_responsables_gastos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getResponsablesOperativos($unidades)
    {
        $this->db->where('unidad_responsable_gasto_id', $unidades);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getEjercicios()
    {
        $this->db->select('ejercicio_id, ejercicio');
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
