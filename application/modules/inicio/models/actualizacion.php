<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class actualizacion extends CI_Model
{
    public function getMetasPrincipales($ejercicio)
    {
        $this->db->select('meses_metas_programadas.meta_id');
        $this->db->join('metas', 'meses_metas_programadas.meta_id = metas.meta_id');
        $this->db->join('proyectos', 'metas.proyecto_id = proyectos.proyecto_id');
        $this->db->join('responsables_operativos', 'proyectos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->where('unidades_responsables_gastos.ejercicio_id', $ejercicio);
        $this->db->where('metas.tipo', 'principal');
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        // echo $this->db->last_query();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function updateMetasPrincipales($data, $where)
    {
        $this->db->where($where);
        $this->db->update('meses_metas_programadas', $data);

        $resp = $this->db->affected_rows();

        if($resp > 0){
            return true;
        }

        return false;
    }
}
