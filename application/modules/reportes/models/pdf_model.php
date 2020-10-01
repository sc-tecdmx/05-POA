<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class pdf_model extends CI_Model
{
	public function getInfoOfProject($ejercicio, $proyectoId)
	{
		$this->db->select('
			e.ejercicio, 
			py.*, 
			urg.numero as numero_urg, 
			urg.nombre as nombre_urg, 
			ro.numero as numero_ro, 
			ro.nombre as nombre_ro,
			pg.numero as numero_programa,
		 	pg.nombre as nombre_programa,
        	sp.numero as numero_subprograma,
        	sp.nombre as nombre_subprograma'
		);
		$this->db->join('responsables_operativos as ro', 'py.responsable_operativo_id = ro.responsable_operativo_id');
		$this->db->join('unidades_responsables_gastos as urg', 'ro.unidad_responsable_gasto_id = urg.unidad_responsable_gasto_id');
		$this->db->join('subprogramas as sp', 'py.subprograma_id = sp.subprograma_id');
		$this->db->join('programas as pg', 'sp.programa_id = pg.programa_id');
		$this->db->join('ejercicios as e', 'urg.ejercicio_id = e.ejercicio_id');
		$this->db->where('e.ejercicio_id', $ejercicio);
		$this->db->where('py.proyecto_id', $proyectoId);
		$this->db->from('proyectos as py');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
		return FALSE;
	}

	public function getMetasPrincipales($proyecto)
	{
		$this->db->where('proyecto_id', $proyecto);
		$this->db->where('tipo', 'principal');
		$this->db->from('metas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}

	public function getUnidadesMedida($meta)
	{
		$this->db->select('unidades_medidas.*');
		$this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
		$this->db->where('metas.meta_id', $meta);
		$this->db->from('metas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
		return FALSE;
	}

	public function getMetasArregloProgramadas($meta, $meses)
	{
		$this->db->where_in('mes_id', $meses);
		$this->db->where('meta_id', $meta);
		$this->db->from('meses_metas_programadas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}

	public function getMetas($tipo, $proyecto)
	{
		$this->db->where('proyecto_id', $proyecto);
		$this->db->where('tipo', $tipo);
		$this->db->from('metas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}

	public function getMetasArreglo($meta, $meses, $tabla)
	{
		$this->db->where_in('mes_id', $meses);
		$this->db->where('meta_id', $meta);
		$this->db->from($tabla);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}

	public function getIndicadores($proyectoId)
	{
		$this->db->where('proyecto_id', $proyectoId);
		$this->db->from('indicadores');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}
	public function getUnidadesMedidasIndicadores($indicador)
	{
		$this->db->select('unidades_medidas.*');
		$this->db->join('unidades_medidas', 'indicadores.unidad_medida_id = unidades_medidas.unidad_medida_id');
		$this->db->where('indicadores.indicador_id', $indicador);
		$this->db->from('indicadores');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
		return FALSE;
	}

	public function getMedicionIndicador($indicador)
	{
		$this->db->select('
			dimensiones.nombre as nombre_dimension,
			frecuencias.nombre as nombre_frecuencia	
		');
		$this->db->join('dimensiones', 'indicadores.dimension_id = dimensiones.dimension_id');
		$this->db->join('frecuencias', 'indicadores.frecuencia_id = frecuencias.frecuencia_id');
		$this->db->where('indicador_id', $indicador);
		$this->db->from('indicadores');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
		return FALSE;
	}

	public function getAccionesSustantivas($proyectoId)
	{
		$this->db->where('proyecto_id', $proyectoId);
		$this->db->from('acciones_sustantivas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}

	public function getAccionesSustantivasDerechosHumanos($proyectoId)
	{
		$this->db->where('proyecto_id', $proyectoId);
		$this->db->from('acciones_sustantivas_derechos_humanos');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}

	public function getLineasAccion($accionSustantivaId)
	{
		$this->db->select('lineas_acciones_derechos_humanos.*');
		$this->db->join('lineas_acciones_derechos_humanos', 'acciones_sustantivas_derechos_humanos.linea_accion_derecho_humano_id = lineas_acciones_derechos_humanos.linea_accion_derecho_humano_id');
		$this->db->where('acciones_sustantivas_derechos_humanos.accion_sustantiva_derecho_humano_id', $accionSustantivaId);
		$this->db->from('acciones_sustantivas_derechos_humanos');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
		return FALSE;
	}

	public function getEquidadesGenero($proyectoId)
	{
		$this->db->where('proyecto_id', $proyectoId);
		$this->db->from('equidades_generos');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}

	public function getAccionesEquidadGenero($equidadGeneroId)
	{
		$this->db->select('acciones_equidades_generos.*');
		$this->db->join('acciones_equidades_generos', 'equidades_generos.accion_equidad_genero_id = acciones_equidades_generos.accion_equidad_genero_id');
		$this->db->where('equidades_generos.equidad_genero_id', $equidadGeneroId);
		$this->db->from('equidades_generos');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}
		return FALSE;
	}

	public function getMesesEjecucion($proyectoId)
	{
		$this->db->select('
			meses_proyectos.*,
			meses.nombre
		');
		$this->db->join('meses_proyectos', 'proyectos.proyecto_id = meses_proyectos.proyecto_id');
		$this->db->join('meses', 'meses_proyectos.mes_id = meses.mes_id');
		$this->db->where('proyectos.proyecto_id', $proyectoId);
		$this->db->from('proyectos');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		return FALSE;
	}
}
