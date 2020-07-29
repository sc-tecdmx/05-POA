<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo para la consulta de las base de datos con las mas simples y comunes
 * para instanciar en otros modelos.
 */
class Querys_db extends CI_Model{

    /**
     * Variable para almacenar el nombre de la tabla.
     * @var string
     */
    private $table_name;

    /**
     * Varible para almacenar el arreglo a consultar
     * @var array
     */
    private $qry;

    public function __construct()
    {
        parent::__construct();

        /**
         * Instacia del nombre de la tabla.
         * @var string
         */
        $this->table_name = '';

        /**
         * Instancia del arreglo de consulta en la tabla
         * @var string
         */
        $this->qry = '';
    }

    /**
     * Método que contiene le nombre de la tabla
     * @param string $tb Nombre de la tabla
     */
    public function set_table($tb)
    {
        $this->table_name = $tb;
        return $this->table_name;
    }

    /**
     * Método que limpia el nombre de la tabla
     */
    public function unset_table()
    {
        unset($this->table_name);
        $this->table_name = '';
        return $this->table_name;
    }

    /**
     * Método que consulta  todos los campos por medio de un arreglo en la tabla
     * @param array $q Arreglo con compos de la tabla
     */
    public function set_qry($q)
    {
        $this->qry = $q;
        return $this->qry;
    }

    /**
     * Método que limpia la consulta del arreglo.
     */
    public function unset_qry()
    {
        unset($this->qry);
        $this->qry = '';
        return $this->qry;
    }

    /**
     * Método que consulta todos los campos en una base
     * @return array Arreglo de objetos
     */
    public function get_qry()
    {
        $this->db->select($this->set_qry());
        $this->db->from($this->set_table());
        $query = $this->db->get();

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return 0;
        }
    }
}
