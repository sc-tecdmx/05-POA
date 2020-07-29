<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {
    /**
     * Variable protegida para asignarle el nombre de la tabla
     */
    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('home/general');
        $this->table = '';
    }

    #############################################################################
    #                        NOMBRE DE TABLAS                                   #
    #############################################################################




    #############################################################################
    #                        ARREGLOS                                           #
    #############################################################################

    /**
     * ARRAY para S_MODULOS
     * Método que contiene el arreglo de datos a consultar en un select
     * @return array
     */
    public function get_arr_modulos()
    {
        $data = array(
            's_modulos.id_modulo',
            's_modulos.modulo',
            's_modulos.controlador',
            's_modulos.activo'
        );
        return $data;
    }

    /**
     * ARRAY para S_PERFILES
     * Método que contiene el arreglo de datos a consultar en un select
     * @return array
     */
    public function get_arr_perfiles()
    {
        $data = array(
            's_perfiles.id_perfil',
            's_perfiles.perfil',
            's_perfiles.activo'
        );
        return $data;
    }

    /**
     * ARRAY para S_PRIVILEGIOS
     * Método que contiene el arreglo de datos a consultar en un select
     * @return array
     */
    public function get_arr_privilegios()
    {
        $data = array(
            's_privilegios.id_privilegios',
            's_privilegios.id_modulo',
            's_privilegios.nsf',
            's_privilegios.perfil',
            's_privilegios.activo',
            's_privilegios.condicion'
        );
        return $data;
    }

    #############################################################################
    #                        QUERYS   RESULTS                                   #
    #############################################################################

    /**
     * result()
     * Método que emite una consulta como un arreglo de objetos
     * @param $query array
     * @return bool/array-object
     */
    public function res_array_obj($query)
    {
        if ($query->num_rows() >= 1){
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * row()
     * Método que emite una consulta como un objeto
     * @param $query array
     * @return bool/object
     */
    public function res_row_obj($query)
    {
        if ($query->num_rows() >= 1){
            return $query->row();
        } else {
            return FALSE;
        }
    }

    #############################################################################
    #                       CRUDS GENERALES  Y ÚNICOS                           #
    #############################################################################

    /**
     * SELECT DE TODA LA TABLA
     * Método para consultar la tabla en general con los campos que necesitemos
     * @param bool/array $arr
     * @param bool/string $tb
     * @param bool/array $where
     * @return int/object
     */
    public function get_data_all($arr = FALSE, $tb = FALSE, $where = FALSE)
    {
        if ($arr) {
            $this->db->select($arr);
        } else {
            $this->db->select('*');
        }
        if ($tb) {
            $this->db->from($tb);
        }
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        echo $this->db->last_query();

        if ($query->num_rows() >= 1){
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * SELECT DE TODA LA TABLA con regreso de una sola información
     * Método para consultar la tabla en general con los campos que necesitemos
     * @param bool/array $arr
     * @param bool/string $tb
     * @param bool/array $where
     * @return int/object
     */
    public function get_data_all_row($arr = FALSE, $tb = FALSE, $where = FALSE)
    {
        if ($arr) {
            $this->db->select($arr);
        } else {
            $this->db->select('*');
        }
        if ($tb) {
            $this->db->from($tb);
        }
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();

        if ($query->num_rows() >= 1){
            return $query->row();
        } else {
            return FALSE;
        }
    }

    /**
     * Inserción general de información en la Base de Datos
     * @param bool $data
     * @param bool $tb
     * @return bool
     */
    public function insert($data = FALSE, $tb = FALSE)
    {
        $this->db->insert($tb, $data);

        if($this->db->affected_rows() !== 0){
            return true;
        }
        return false;
    }

    /**
     * Actualización general de datos en la base de datos
     * @param bool $data
     * @param bool $tb
     * @param bool $where
     * @return bool
     */
    public function update($data = FALSE, $tb = FALSE, $where = FALSE)
    {
        $this->db->where($where);
        $this->db->update($tb, $data);

        $resp = $this->db->affected_rows();

        if($resp > 0){
            return true;
        }

        return false;
    }

    public function delete($where = FALSE, $tb = FALSE)
    {
        $this->db->where($where);
        $this->db->delete($tb);
        $resp = $this->db->affected_rows();

        if($resp > 0){
            return true;
        }

        return false;
    }
}
