<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_inicio extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('inicio/main_model');
    }

    /**
     * ARRAY para SELECT
     * Método que contiene los campos de los datos a extraer para get_projects
     * @return array
     */
    protected function arr_projects_join()
    {
        $data = array(
            'proyectos.numero',
            'proyectos.descripcion'
        );
        return $data;
    }

    public function get_projects($ejercicio)
    {
        $this->db->select('
            proyectos.proyecto_id,
            proyectos.numero as pynum,
            proyectos.descripcion as pydes,
            subprogramas.numero as sbnum,
            programas.numero as pgnum,
            responsables_operativos.numero as ronum,
            unidades_responsables_gastos.numero as urnum,
            proyectos.nombre as pynom');
        $this->db->join('responsables_operativos', 'proyectos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->join('subprogramas', 'proyectos.subprograma_id = subprogramas.subprograma_id');
        $this->db->join('programas', 'subprogramas.programa_id = programas.programa_id');
        $this->db->join('ejercicios', 'unidades_responsables_gastos.ejercicio_id = ejercicios.ejercicio_id');
        $this->db->where('ejercicios.ejercicio_id', $ejercicio);
        if($this->session->userdata('area')) {
            $this->db->where_in('responsables_operativos.responsable_operativo_id', $this->session->userdata('area'));
        }
        $this->db->from('proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Función para obtener las unidades responsables de los gastos
     * @return mixed
     */
    public function get_unidades($ejercicio)
    {
        $this->db->select('unidad_responsable_gasto_id, numero, nombre');
        $this->db->from('unidades_responsables_gastos');
        $this->db->join('ejercicios', 'unidades_responsables_gastos.ejercicio_id = ejercicios.ejercicio_id');
        $this->db->join('operaciones_ejercicios', 'ejercicios.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('unidades_responsables_gastos.ejercicio_id', $ejercicio);
        $query = $this->db->get();
        if($query->num_rows() >= 1){
            return $query->result();
        }
    }

    /**
     * Función para obtener los responsables operativos
     * @return mixed
     */
    public function get_responsables()
    {
        $query = $this->db->query('SELECT unidades_responsables_gastos.numero as urnum, responsables_operativos.responsable_operativo_id, responsables_operativos.numero as ronum, responsables_operativos.nombre as ronom, responsables_operativos.responsable_operativo_id as roid
        FROM responsables_operativos 
        JOIN unidades_responsables_gastos ON responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id
        JOIN ejercicios ON unidades_responsables_gastos.ejercicio_id = ejercicios.ejercicio_id
        JOIN operaciones_ejercicios ON ejercicios.ejercicio_id = operaciones_ejercicios.ejercicio_id AND operaciones_ejercicios.tipo = \'elaboracion_proyectos\'');
        if($this->db->affected_rows() >= 0){
            return $query->result();
        }
    }

    /**
     * Función para obtener los programas
     * @return mixed
     */
    public function get_programas()
    {
        $this->db->select('*');
        $this->db->from('programas');
        $this->db->join('operaciones_ejercicios', 'programas.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('operaciones_ejercicios.tipo', 'elaboracion_proyectos');
        $query = $this->db->get();
        if($query->num_rows() >= 1){
            return $query->result();
        }
    }

    /**
     * Función para obtener los subprogramas
     * @return mixed
     */
    public function get_subprogramas()
    {
        $query = $this->db->query('SELECT programas.numero as pgnum, subprogramas.subprograma_id as sbid, subprogramas.numero as sbnum, subprogramas.nombre as sbnom, subprogramas.subprograma_id
        FROM subprogramas 
        JOIN programas ON subprogramas.programa_id = programas.programa_id 
        JOIN operaciones_ejercicios ON programas.ejercicio_id = operaciones_ejercicios.ejercicio_id AND operaciones_ejercicios.tipo = \'elaboracion_proyectos\'');
        if($this->db->affected_rows() >= 0){
            return $query->result();
        }
    }

    /**
     * Función para obtener todas las unidades de medida
     * @return mixed
     */
    public function get_umedidas()
    {
        $this->db->select('unidades_medidas.*');
        $this->db->from('unidades_medidas');
        $this->db->join('operaciones_ejercicios', 'unidades_medidas.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('operaciones_ejercicios.tipo', 'elaboracion_proyectos');
        $this->db->where('unidades_medidas.nombre !=', 'porcentajes');
        $query = $this->db->get();
        if($query->num_rows() >= 1){
            return $query->result();
        }
    }

    /**
     * Función para obtener todas las unidades de medida sin porcentajes
     * @return mixed
     */
    public function get_umedidas_principal()
    {
        $this->db->select('unidades_medidas.*');
        $this->db->from('unidades_medidas');
        $this->db->join('operaciones_ejercicios', 'unidades_medidas.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('operaciones_ejercicios.tipo', 'elaboracion_proyectos');
        $this->db->where('unidades_medidas.porcentajes', '0');
        $query = $this->db->get();
        if($query->num_rows() >= 1){
            return $query->result();
        }
    }

    /**
     * Función para obtener el ejercicio id actualmente habilitado
     * @return mixed
     */
    public function get_ejercicio()
    {
        $this->db->select('ejercicios.ejercicio_id, ejercicios.ejercicio');
        $this->db->join('operaciones_ejercicios', 'ejercicios.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('operaciones_ejercicios.tipo', 'elaboracion_proyectos');
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    /**
     * Función para obtener las dimensiones
     * @return mixed
     */
    public function get_dimensiones()
    {
        $this->db->select('*');
        $this->db->from('dimensiones');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    /**
     * Función para obtener las frecuencias
     * @return mixed
     */
    public function get_frecuencias()
    {
        $this->db->select('*');
        $this->db->from('frecuencias');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    /**
     * Función para obtener las metas dado el proyecto
     * @param $pry
     * @return bool
     */
    public function get_metas($pry)
    {
        $this->db->select('meta_id, nombre');
        $this->db->where('proyecto_id', $pry);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMetasComplementarias($pry)
    {
        $this->db->where('proyecto_id', $pry);
        $this->db->where('tipo', 'complementaria');
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_verificacionElaboracion($ejercicio)
    {
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function getAreas()
    {
        $this->db->where('estado', 'activo');
        $this->db->from('areas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getPermisos()
    {
        $this->db->where('activo', '1');
        $this->db->from('s_perfiles');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMesesSmall($mes = false)
    {
        $this->db->select('small');
        $this->db->where('mes_id', $mes);
        $this->db->from('meses');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }
}
