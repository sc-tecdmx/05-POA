<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Seguimiento extends CI_Model
{
    public function searchEjercicio($ejercicio)
    {
        $this->db->where('ejercicio', $ejercicio);
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function getEjercicioSeguimiento()
    {
        $this->db->select('ejercicio_id');
        $this->db->where('operacion_ejercicio_id', '2');
        $this->db->from('operaciones_ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getConfiguracion($ejercicio)
    {
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getUsuarios()
    {
        $this->db->select('nsf,nombre,apellido');
        $this->db->from('g_registros');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getMesesControlesMetas($ejercicio)
    {
        $this->db->select('mes_id');
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->where('habilitado', 'si');
        $this->db->from('meses_controles_metas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
