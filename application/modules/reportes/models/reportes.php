<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class reportes extends CI_Model
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
        $this->db->where('proyectos.subprograma_id', $subprograma);
        $this->db->from('proyectos');
        $query = $this->db->get();
        return $query->result();
    }

    public function getMetas($proyecto)
    {
        $this->db->select('metas.*, unidades_medidas.nombre as umnom, unidades_medidas.porcentajes');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.proyecto_id', $proyecto);
        $this->db->from('metas');
        $query = $this->db->get();
        return $query->result();
    }

    public function getProgramadas($meta)
    {
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAvanceMesResuelto($mes, $meta)
    {
        $this->db->select('numero');
        $this->db->where('mes_id', $mes);
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_complementarias_resueltos');
        $query = $this->db->get();
        return $query->row();
    }

    public function getAvanceMesProgramado($mes, $meta, $tabla)
    {
        $this->db->select('numero');
        $this->db->where('mes_id', $mes);
        $this->db->where('meta_id', $meta);
        $this->db->from($tabla);
        $query = $this->db->get();
        return $query->row();
    }

    public function getIndicadores($proyecto)
    {
        $this->db->select(
            'indicadores.nombre as indicadorNombre,
            indicadores.definicion,
            indicadores.metodo_calculo,
            indicadores.meta,
            frecuencias.nombre as frecuenciaNombre,
            unidades_medidas.nombre as medidaNombre,
            indicadores.meta_id'
        );
        $this->db->join('frecuencias', 'indicadores.frecuencia_id = frecuencias.frecuencia_id');
        $this->db->join('unidades_medidas', 'indicadores.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('indicadores.proyecto_id', $proyecto);
        $this->db->from('indicadores');
        $query = $this->db->get();
        return $query->result();
    }

    public function getTipoMetas($meta)
    {
        $this->db->select('unidades_medidas.porcentajes');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        return $query->row();
    }
}
