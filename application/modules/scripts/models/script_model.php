<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class script_model extends CI_Model
{
    public function getUsersId()
    {
        $this->db->select('*');
        $this->db->where('nsf !=', '1');
        $this->db->from('g_registros');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function getIdResponsableOperativo($usuarioId)
    {
        $this->db->select('responsable_operativo_id');
        $this->db->where('usuario_poa_id', $usuarioId);
        $this->db->order_by('responsable_operativo_id', 'DESC');
        $this->db->limit('1');
        $this->db->from('usuarios_responsables_operativos');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function getNameResponsableOperativo($idResponsableOperativo)
    {
        $this->db->select('*');
        $this->db->where('responsable_operativo_id', $idResponsableOperativo);
        $this->db->order_by('responsable_operativo_id', 'DESC');
        $this->db->limit('1');
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    public function getEjercicio($idUnidadResponsableGasto)
    {
        $this->db->select('ejercicio_id');
        $this->db->where('unidad_responsable_gasto_id', $idUnidadResponsableGasto);
        $this->db->limit('1');
        $this->db->from('unidades_responsables_gastos');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function getResponsableOperativo($responsableOperativoName)
    {
        $this->db->select('responsable_operativo_id');
        $this->db->where('nombre', $responsableOperativoName);
        $this->db->order_by('responsable_operativo_id', 'DESC');
        $this->db->limit('1');
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
}