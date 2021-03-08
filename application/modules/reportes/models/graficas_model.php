<?php

class Graficas_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getProgramas($ejercicio_id)
    {
        $this->db->select('programas.nombre, count(*) as y');
        $this->db->join('subprogramas', 'proyectos.subprograma_id = subprogramas.subprograma_id');
        $this->db->join('programas', 'subprogramas.programa_id = programas.programa_id');
        $this->db->where('programas.ejercicio_id', $ejercicio_id);
        $this->db->from('proyectos');
        $this->db->group_by('programas.nombre', 'DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getPorcentajesMetasComplementarias()
    {

    }

    public function getMetasComplementarias($mes, $ejercicio)
    {
		$this->db->select('
			proyectos.numero as pynum,
			subprogramas.numero as sbnum,
			programas.numero as pgnum,
			responsables_operativos.numero as ronum,
			unidades_responsables_gastos.numero as urnum,
			meses_metas_alcanzadas.porcentaje_real
		');
		$this->db->join('meses_metas_alcanzadas', 'metas.meta_id = meses_metas_alcanzadas.meta_id');
		$this->db->join('proyectos', 'metas.proyecto_id = proyectos.proyecto_id');
		$this->db->join('responsables_operativos', 'proyectos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
		$this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
		$this->db->join('subprogramas', 'proyectos.subprograma_id = subprogramas.subprograma_id');
		$this->db->join('programas', 'subprogramas.programa_id = programas.programa_id');
		$this->db->join('ejercicios', 'unidades_responsables_gastos.ejercicio_id = ejercicios.ejercicio_id');
		$this->db->where('ejercicios.ejercicio_id', $ejercicio);
		$this->db->where('meses_metas_alcanzadas.mes_id', $mes);
		$this->db->where('metas.tipo', 'principal');
		$this->db->from('metas');
		$this->db->order_by('urnum', 'DESC');
		$query = $this->db->get();
		// echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result();
		}
		return false;
        /* $data = array(
            'meses_metas_alcanzadas.mes_meta_alcanzada_id',
            //'meses_metas_alcanzadas.meta_id',
            //'meses_metas_alcanzadas.mes_id',
            'meses_metas_alcanzadas.porcentaje_real',
            //'metas.meta_id as metas_meta_id',
            //'metas.nombre  as metas_nombre',
            'meses.small  as mes',
            //'proyectos.proyecto_id as proy_id',
            'unidades_responsables_gastos.numero as numUniResGas',
            'responsables_operativos.numero as numResOp',
            'programas.numero as progNum',
            'subprogramas.numero as subNum',
            'proyectos.numero as proyNum',
            'meses_metas_alcanzadas.numero as metaNum',
            'meses_metas_alcanzadas.porcentaje as metaPor'
        );
        $this->db->select($data);
        $this->db->from('meses_metas_alcanzadas');
        $this->db->join('metas', 'metas.meta_id = meses_metas_alcanzadas.meta_id');
        $this->db->join('meses', 'meses.mes_id = meses_metas_alcanzadas.mes_id');
        $this->db->join('proyectos', 'proyectos.proyecto_id = metas.proyecto_id');
        $this->db->join('responsables_operativos', 'responsables_operativos.responsable_operativo_id = proyectos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'unidades_responsables_gastos.unidad_responsable_gasto_id = responsables_operativos.unidad_responsable_gasto_id');
        $this->db->join('subprogramas', 'proyectos.subprograma_id = subprogramas.subprograma_id');
        $this->db->join('programas', 'programas.programa_id = subprogramas.subprograma_id');
        $this->db->where('meses_metas_alcanzadas.mes_id', $id);
        $this->db->where('unidades_responsables_gastos.ejercicio_id', $ejercicio);
        // $this->db->group_by('meses_metas_alcanzadas.numero', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        } */
    }

    public function getPrograms($ejercicioId) {
		$this->db->select('programa_id, numero, nombre');
		$this->db->where('programas.ejercicio_id', $ejercicioId);
		$this->db->from('programas');
		// $this->db->orderBy('numero');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	public function getSubprograms($programaId) {
    	$this->db->select('subprograma_id, numero, nombre');
    	$this->db->where('programa_id', $programaId);
    	$this->db->from('subprogramas');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	public function getProjects($subprogramaId) {
    	$this->db->select('proyectos.*, unidades_responsables_gastos.numero as numero_urg, responsables_operativos.numero as numero_ro');
		$this->db->join('responsables_operativos', 'proyectos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
		$this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
		$this->db->where('subprograma_id', $subprogramaId);
    	$this->db->from('proyectos');
		if($this->session->userdata('area')) {
			$this->db->where_in('responsables_operativos.responsable_operativo_id', $this->session->userdata('area'));
		}
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	public function getPrincipalGoal($proyectoId) {
    	$this->db->where('tipo', 'principal');
    	$this->db->where('proyecto_id', $proyectoId);
    	$this->db->from('metas');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}
	}

	public function getResults($mes, $metaId) {
    	$this->db->select('SUM(meses_metas_programadas.numero) as acumulada_programada, SUM(meses_metas_alcanzadas.numero) as acumulada alcanzada');
		$this->db->where('meses_metas_programadas.meta_id', $metaId);
		$this->db->where('meses_metas_alcanzadas.meta_id', $metaId);
		$this->db->where('mes_id <=', $mes);
		$this->db->from('meses_metas_alcanzadas, meses_metas_programadas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
	}

	public function getAccumulatedProgrammedGoal($mesId, $metaId) {
		$this->db->select_sum('numero');
		$this->db->where('mes_id <=', $mesId);
		$this->db->where('meta_id', $metaId);
		$this->db->from('meses_metas_programadas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
	}

	public function getCumulatedProgrammedGoal($mesId, $metaId) {
		$this->db->select_sum('numero');
		$this->db->where('mes_id <=', $mesId);
		$this->db->where('meta_id', $metaId);
		$this->db->from('meses_metas_alcanzadas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
	}
}
