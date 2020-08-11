<?php

class seguimiento_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getMetas($id_pry, $tipom)
    {
        $this->db->select('metas.nombre as mnombre, unidades_medidas.nombre as umnombre, metas.meta_id, metas.proyecto_id, metas.peso, unidades_medidas.porcentajes as umtipo');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.proyecto_id', $id_pry);
        $this->db->where('metas.tipo', $tipom);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMesesHabC($ejercicio)
    {
        $this->db->select('meses.small');
        $this->db->join('meses', 'meses_controles_metas.mes_id = meses.mes_id');
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('meses_controles_metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMesesMetasProgramadas($meta, $ejercicio, $mes)
    {
        $this->db->select('meses_metas_programadas.numero');
        $this->db->join('meses_controles_metas','meses_metas_programadas.mes_id = meses_controles_metas.mes_id');
        $this->db->where('meses_controles_metas.ejercicio_id', $ejercicio);
        $this->db->where('meses_controles_metas.mes_id <=', $mes);
        $this->db->where('meses_metas_programadas.meta_id', $meta);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMesesMetasAlcanzadas($meta, $ejercicio, $mes)
    {
        $this->db->select('meses_metas_alcanzadas.numero, meses_metas_alcanzadas.porcentaje, meses_metas_alcanzadas.porcentaje_real, meses_metas_alcanzadas.explicacion');
        $this->db->join('meses_controles_metas','meses_metas_alcanzadas.mes_id = meses_controles_metas.mes_id');
        $this->db->where('meses_controles_metas.ejercicio_id', $ejercicio);
        $this->db->where('meses_controles_metas.mes_id <=', $mes);
        $this->db->where('meses_metas_alcanzadas.meta_id', $meta);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMesesMetasResueltos($meta, $ejercicio, $mes)
    {
        $this->db->select('meses_metas_complementarias_resueltos.numero');
        $this->db->join('meses_controles_metas','meses_metas_complementarias_resueltos.mes_id = meses_controles_metas.mes_id');
        $this->db->where('meses_controles_metas.ejercicio_id', $ejercicio);
        $this->db->where('meses_controles_metas.mes_id <=', $mes);
        $this->db->where('meses_metas_complementarias_resueltos.meta_id', $meta);
        $this->db->from('meses_metas_complementarias_resueltos');
        $query = $this->db->get();
        // echo $this->db->last_query();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMeses($ejercicio, $mes)
    {
        $this->db->select('meses.mes_id, meses.nombre, meses.small');
        $this->db->join('meses', 'meses_controles_metas.mes_id = meses.mes_id');
        $this->db->where('meses_controles_metas.ejercicio_id', $ejercicio);
        $this->db->where('meses_controles_metas.mes_id <=', $mes);
        $this->db->from('meses_controles_metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMesesMax($ejercicio)
    {
        $this->db->select_max('meses.mes_id');
        $this->db->join('meses', 'meses_controles_metas.mes_id = meses.mes_id');
        $this->db->where('meses_controles_metas.ejercicio_id', $ejercicio);
        $this->db->where('meses_controles_metas.habilitado', 'si');
        $this->db->from('meses_controles_metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function getAvanceMes($where)
    {
        $this->db->select('meses_metas_alcanzadas.numero');
        $this->db->join('meses_metas_alcanzadas', 'metas.meta_id = meses_metas_alcanzadas.meta_id');
        $this->db->where($where);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getMetaPrincipal($id_pry)
    {
        $this->db->select('*');
        $this->db->where('proyecto_id', $id_pry);
        $this->db->where('tipo', 'principal');
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function getTipoMeta($meta)
    {
        $this->db->select('unidades_medidas.*');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function getMetaPeso($meta)
    {
        $this->db->select('*');
        $this->db->where('meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function getMesesEjecucion($proyecto)
    {
        $this->db->where('proyecto_id', $proyecto);
        $this->db->from('meses_proyectos');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->num_rows();
        }
        return false;
    }

    public function getMetasComplementariasPesos($proyecto)
    {
        $this->db->select('peso');
        $this->db->where('proyecto_id', $proyecto);
        $this->db->where('tipo', 'complementaria');
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function getAvanceMetaPrincipal($proyecto, $mes)
    {
        $this->db->select('meses_metas_alcanzadas.numero, metas.meta_id');
        $this->db->join('meses_metas_alcanzadas', 'metas.meta_id = meses_metas_alcanzadas.meta_id');
        $this->db->where('metas.proyecto_id', $proyecto);
        $this->db->where('meses_metas_alcanzadas.mes_id', $mes);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function getAvanceProgramadoMetaComplementaria($meta, $mes)
    {
        $this->db->select('numero');
        $this->db->where('meta_id', $meta);
        $this->db->where('mes_id', $mes);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function getInfoMetaPrincipal($pry)
    {
        $this->db->select('meses_metas_programadas.numero');
        $this->db->join('meses_metas_programadas', 'metas.meta_id = meses_metas_programadas.meta_id');
        $this->db->where('metas.proyecto_id', $pry);
        $this->db->where('metas.tipo', 'principal');
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getPesos($pry)
    {
        $this->db->select('nombre, peso');
        $this->db->where('proyecto_id', $pry);
        $this->db->where('tipo', 'complementaria');
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getMetasComplementarias($pry)
    {
        $this->db->select('nombre, meta_id');
        $this->db->where('proyecto_id', $pry);
        $this->db->where('tipo', 'complementaria');
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getAvancesMetasComplementarias($meta)
    {
        $this->db->select('numero');
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getPreviousWeight($meta)
    {
        $this->db->where('meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
    }

    public function getDescriptions($proyecto, $mes)
    {
        $this->db->select('meses_metas_alcanzadas.explicacion');
        $this->db->join('meses_metas_alcanzadas', 'metas.meta_id = meses_metas_alcanzadas.meta_id');
        $this->db->where('metas.proyecto_id', $proyecto);
        $this->db->where('meses_metas_alcanzadas.mes_id', $mes);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getMesesHabilitados($ejercicio)
    {
        $this->db->select('meses.nombre, meses.mes_id');
        $this->db->join('meses', 'meses_controles_metas.mes_id = meses.mes_id');
        $this->db->where('meses_controles_metas.habilitado', 'si');
        $this->db->where('meses_controles_metas.ejercicio_id', $ejercicio);
        $this->db->from('meses_controles_metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function searchMetasComplementarias($proyecto)
    {
        $this->db->where('proyecto_id', $proyecto);
        $this->db->where('tipo', 'principal');
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getInfoMetaPrincipalD($meta)
    {
        $this->db->where('meta_id', $meta);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getMetaPrincipalAvance($mes, $proyecto)
    {
        $this->db->select('metas.*, unidades_medidas.nombre as umnom');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.proyecto_id', $proyecto);
        $this->db->where('metas.tipo', 'principal');
        $this->db->from('metas');
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

    public function getAvanceMetaPrincipalDetalle($mes, $meta)
    {
        $this->db->select('meses_metas_programadas.numero as mmpnum, meses_metas_alcanzadas.numero as mmanum, meses_metas_alcanzadas.porcentaje');
        $this->db->join('meses_metas_alcanzadas', 'meses_metas_programadas.meta_id = meses_metas_alcanzadas.meta_id');
        $this->db->where('meses_metas_programadas.mes_id', $mes);
        $this->db->where('meses_metas_programadas.meta_id', $meta);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getAvanceMesProgramado($mes, $meta)
    {
        $this->db->select('numero');
        $this->db->where('mes_id', $mes);
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        return $query->row();
    }

    public function getAvanceMesAlcanzado($mes, $meta)
    {
        $this->db->select('numero,porcentaje,porcentaje_real,explicacion');
        $this->db->where('mes_id', $mes);
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }


    public function getAvanceProgramadoAcumulado($mes, $meta)
    {
        $this->db->select_sum('numero');
        $this->db->where('mes_id <=', $mes);
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_programadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getAvanceAlcanzadoAcumulado($mes, $meta)
    {
        $this->db->select_sum('numero');
        $this->db->where('mes_id <=', $mes);
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getAvanceResueltoAcumulado($mes, $meta)
    {
        $this->db->select_sum('numero');
        $this->db->where('mes_id <=', $mes);
        $this->db->where('meta_id', $meta);
        $this->db->from('meses_metas_complementarias_resueltos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getMesesHabilitadosAvance($mes)
    {
        $this->db->select('nombre, mes_id');
        $this->db->where('mes_id <=', $mes);
        $this->db->from('meses');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getExplicacionesMP($mes, $meta)
    {
        $this->db->select('meses_metas_alcanzadas.explicacion, meses.nombre');
        $this->db->join('meses', 'meses_metas_alcanzadas.mes_id = meses.mes_id');
        $this->db->where('meses_metas_alcanzadas.mes_id', $mes);
        $this->db->where('meses_metas_alcanzadas.meta_id', $meta);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        return $query->result();
    }

    public function getContarMeses($proyecto)
    {
        $this->db->select('count(*) as conteo');
        $this->db->where('ejecuta', 'si');
        $this->db->where('proyecto_id', $proyecto);
        $this->db->from('meses_proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getMetasComplementariasAvance($mes, $proyecto)
    {
        $this->db->select('metas.*, unidades_medidas.nombre as umnom');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.proyecto_id', $proyecto);
        $this->db->where('metas.tipo', 'complementaria');
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getPorcentajeAcumulado($meta, $mes)
    {
        $this->db->select_sum('porcentaje');
        $this->db->where('meta_id', $meta);
        $this->db->where('mes_id <=', $mes);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getAvancesMP($proyecto, $mes, $meta)
    {
        $this->db->select_sum('meses_metas_alcanzadas.porcentaje_real');
        $this->db->join('metas', 'meses_metas_alcanzadas.meta_id = metas.meta_id');
        $this->db->where('metas.proyecto_id', $proyecto);
        $this->db->where('metas.tipo', 'complementaria');
        $this->db->where('metas.meta_id !=', $meta);
        $this->db->where('meses_metas_alcanzadas.mes_id', $mes);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getInfoProyecto($proyecto)
    {
        $this->db->select('proyectos.nombre as pynom, unidades_responsables_gastos.nombre as urnom, responsables_operativos.nombre as ronom, metas.nombre as mtnom');
        $this->db->join('responsables_operativos', 'proyectos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->join('metas', 'proyectos.proyecto_id = metas.proyecto_id');
        $this->db->where('proyectos.proyecto_id', $proyecto);
        $this->db->where('metas.tipo', 'principal');
        $this->db->from('proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

	public function getAvanceMetaMes($mes, $meta)
	{
		$this->db->select('numero');
		$this->db->where('mes_id', $mes);
		$this->db->where('meta_id', $meta);
		$this->db->from('meses_metas_alcanzadas');
		$query = $this->db->get();
		return $query->row();
	}

	public function getAvanceMetaMesNormal($mes, $meta)
	{
		$this->db->select('numero, explicacion');
		$this->db->where('mes_id', $mes);
		$this->db->where('meta_id', $meta);
		$this->db->from('meses_metas_alcanzadas');
		$query = $this->db->get();
		return $query->row();
	}

	public function getAvanceMetaMesPorcentaje($mes, $meta)
	{
		$this->db->select('meses_metas_alcanzadas.numero as recibidos, meses_metas_complementarias_resueltos.numero as atendidos, meses_metas_alcanzadas.explicacion');
		$this->db->join('meses_metas_complementarias_resueltos', 'meses_metas_alcanzadas.meta_id = meses_metas_complementarias_resueltos.meta_id');
		$this->db->where('meses_metas_alcanzadas.mes_id', $mes);
		$this->db->where('meses_metas_alcanzadas.meta_id', $meta);
		$this->db->from('meses_metas_alcanzadas');
		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->row();
	}

	public function getDescriptionGoal($meta, $mes)
	{
		$this->db->select('explicacion');
		$this->db->where('meta_id', $meta);
		$this->db->where('mes_id', $mes);
		$this->db->from('meses_metas_alcanzadas');
		$query = $this->db->get();
		return $query->row();
	}
}
