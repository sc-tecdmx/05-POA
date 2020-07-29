<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class info_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('inicio/main_model');
    }

    public function getMetas($meta)
    {
        $this->db->select('*');
        $this->db->where('meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getPesos($pry = false)
    {
        if($pry) {
            $this->db->select('meta_id, peso');
            $this->db->where('proyecto_id', $pry);
            $this->db->where('tipo', 'complementaria');
            $this->db->from('metas');
            $query = $this->db->get();
            if($query->num_rows()>0){
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function getIndicadores($indicador)
    {
        $this->db->where('indicador_id', $indicador);
        $this->db->from('indicadores');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getAccion($accion)
    {
        $this->db->where('accion_sustantiva_id', $accion);
        $this->db->from('acciones_sustantivas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getResponsables($unidad)
    {
        $this->db->where('unidad_responsable_gasto_id', $unidad);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getSubprogramas($programa)
    {
        $this->db->where('programa_id', $programa);
        $this->db->from('subprogramas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getMesMeta($meta, $mes)
    {
        $this->db->select('numero');
        $this->db->where('meta_id', $meta);
        $this->db->where('mes_id', $mes);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getNumero($numero, $tabla)
    {
        $this->db->select('numero');
        $this->db->where('numero', $numero);
        $this->db->from($tabla);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function getNumeroV($numero, $unidad, $tabla)
    {
        $this->db->select('numero');
        $this->db->where('numero', $numero);
        $this->db->where('unidad_responsable_gasto_id', $unidad);
        $this->db->from($tabla);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function getNumeroEditUnidad($numero, $ejercicio)
    {
        $this->db->select('numero, unidad_responsable_gasto_id');
        $this->db->where('numero', $numero);
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('unidades_responsables_gastos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
    }

    public function getNumeroEditResponsable($numero, $unidad, $ejercicio)
    {
        $this->db->select('responsables_operativos.numero, responsables_operativos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->where('responsables_operativos.numero', $numero);
        $this->db->where('responsables_operativos.unidad_responsable_gasto_id', $unidad);
        $this->db->where('unidades_responsables_gastos.ejercicio_id', $ejercicio);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
    }

    public function getUnidadResponsable ($id)
    {
        $this->db->where('unidad_responsable_gasto_id', $id);
        $this->db->from('unidades_responsables_gastos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getResponsableOperativo($id)
    {
        $this->db->where('responsable_operativo_id', $id);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getPrograma($id)
    {
        $this->db->where('programa_id', $id);
        $this->db->from('programas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getNumeroEditPrograma($numero, $ejercicio)
    {
        $this->db->select('numero, programa_id');
        $this->db->where('numero', $numero);
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('programas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
    }

    public function getSubprograma($id)
    {
        $this->db->where('subprograma_id', $id);
        $this->db->from('subprogramas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getNumeroEditSubprograma($numero, $ejercicio)
    {
        $this->db->select('subprogramas.numero, subprogramas.subprograma_id');
        $this->db->join('programas', 'subprogramas.programa_id = programas.programa_id');
        $this->db->where('subprogramas.numero', $numero);
        $this->db->where('programas.ejercicio_id', $ejercicio);
        $this->db->from('subprogramas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
    }

    public function getUnidadMedida($id)
    {
        $this->db->where('unidad_medida_id', $id);
        $this->db->from('unidades_medidas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getNumeroEditUnidadMedida($numero, $ejercicio)
    {
        $this->db->select('numero, unidad_medida_id');
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->where('numero', $numero);
        $this->db->from('unidades_medidas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
    }

    public function getArea($id)
    {
        $this->db->where('area_id', $id);
        $this->db->from('areas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getEjecucion($id)
    {
        $this->db->select('mes_id');
        $this->db->where('proyecto_id', $id);
        $this->db->where('ejecuta', 'si');
        $this->db->from('meses_proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return false;
        }
    }

    public function getTipoUnidad($unidad)
    {
        $this->db->select('porcentajes');
        $this->db->where('unidad_medida_id', $unidad);
        $this->db->from('unidades_medidas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        } else {
            return false;
        }
    }

    public function getProyectoFromMeta($meta)
    {
        $this->db->select('proyecto_id');
        $this->db->where('meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getMetasComplementarias($proyecto)
    {
        $this->db->where('tipo', 'complementaria');
        $this->db->where('proyecto_id', $proyecto);
        $this->db->from('metas');
        $query = $this->db->get();
        return $query->result();
    }

    public function deleteMetaComplementaria($meta)
    {
        $this->db->where('meta_id', $meta);
        $this->db->delete('metas');
        if($this->db->affected_rows()==1){
            return true;
        }
    }

    public function getTipoUnidadMedida($meta)
    {
        $this->db->select('unidades_medidas.porcentajes');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        return $query->row();
    }

    public function getExistResueltos($meta)
    {
       $this->db->where('meta_id', $meta);
       $this->db->from('meses_metas_complementarias_resueltos');
       $query = $this->db->get();
       if($query->num_rows() > 0){
           return $query->row();
       }
       return false;
    }
}
