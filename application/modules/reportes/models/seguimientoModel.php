<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class seguimientoModel extends CI_Model
{
    public function getProgramas($ejercicio)
    {
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('programas');
        $query = $this->db->get();
        return $query->result();
    }

    public function getSubprogramas($programa)
    {
        $this->db->where('programa_id', $programa);
        $this->db->from('subprogramas');
        $query = $this->db->get();
        return $query->result();
    }

    public function getProyectos($subprograma)
    {
        $this->db->select('proyectos.numero as pynum, subprogramas.numero as sbnum, programas.numero as pgnum, responsables_operativos.numero as ronum, unidades_responsables_gastos.numero as urnum, proyectos.nombre as pynom, proyectos.proyecto_id');
        $this->db->join('subprogramas', 'proyectos.subprograma_id = subprogramas.subprograma_id');
        $this->db->join('programas', 'subprogramas.programa_id = programas.programa_id');
        $this->db->join('responsables_operativos', 'proyectos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->join('ejercicios', 'programas.ejercicio_id = ejercicios.ejercicio_id');
        $this->db->join('operaciones_ejercicios', 'ejercicios.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('operaciones_ejercicios.habilitado', 'SI');
        $this->db->where('proyectos.subprograma_id', $subprograma);
        $this->db->from('proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getMetas($meta, $proyecto)
    {
        $this->db->select('meta_id, nombre');
        $this->db->where('proyecto_id', $proyecto);
        $this->db->where('tipo', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getMesVisible($ejercicio)
    {
        $this->db->select('meses.nombre, meses.mes_id');
        $this->db->join('meses', 'ejercicios.ultimo_mes_visible = meses.mes_id');
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getMetasProgramados($meta, $mes)
    {
        $this->db->select('numero');
        $this->db->where('meta_id', $meta);
        $this->db->where('mes_id', $mes);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getMetasAlcanzadas($meta, $mes)
    {
        $this->db->select('numero');
        $this->db->where('meta_id', $meta);
        $this->db->where('mes_id', $mes);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getPorcentajeAvance($meta, $mes)
    {
        $this->db->select('porcentaje');
        $this->db->where('meta_id', $meta);
        $this->db->where('mes_id', $mes);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getPorcentajeReal($meta, $mes)
    {
        $this->db->select('porcentaje_real');
        $this->db->where('meta_id', $meta);
        $this->db->where('mes_id', $mes);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getNombreMes($mes)
    {
        $this->db->select('nombre');
        $this->db->where('mes_id', $mes);
        $this->db->from('meses');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getTipoMeta($meta)
    {
        $this->db->select('unidades_medidas.porcentajes');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        return $query->row();
    }

    public function getMetasResueltas($meta, $mes)
    {
        $this->db->select('numero');
        $this->db->where('meta_id', $meta);
        $this->db->where('mes_id', $mes);
        $this->db->from('meses_metas_complementarias_resueltos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }
}
