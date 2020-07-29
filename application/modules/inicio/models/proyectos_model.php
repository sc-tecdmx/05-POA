<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Proyectos_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('inicio/main_model');
    }

    public function insertar($data = false, $tb = false)
    {
        if($data && $tb){
            $this->db->insert($tb, $data);
            if($this->db->affected_rows() > 0){
                return $this->db->insert_id();
            }
        } else {
            return false;
        }
    }

    public function get_project($proyecto_id)
    {
        $this->db->select('*');
        $this->db->where('proyecto_id', $proyecto_id);
        $this->db->from('proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        /* $query = 'SELECT e.ejercicio, py.*, urg.numero as \'numero_urg\', urg.nombre as \'nombre_urg\',
        ro.numero as \'numero_ro\', ro.nombre as \'nombre_ro\', pg.numero as \'numero_programa\', pg.nombre as \'nombre_programa\',
        sp.numero as \'numero_subprograma\', sp.nombre as \'nombre_subprograma\'
        FROM proyectos py, responsables_operativos ro, unidades_responsables_gastos urg, programas pg, subprogramas sp, ejercicios e
        WHERE e.ejercicio_id = urg.ejercicio_id
        AND urg.ejercicio_id = e.ejercicio_id
        AND urg.unidad_responsable_gasto_id = ro.unidad_responsable_gasto_id
        AND ro.responsable_operativo_id = py.responsable_operativo_id
        AND py.subprograma_id = sp.subprograma_id
        AND pg.programa_id = sp.programa_id
        AND py.proyecto_id ='.$proyecto_id;
        $sql = $this->db->query($query);
        return $sql->row(); */
    }

    public function getProjectDetails($proyecto)
    {
        $query = 'SELECT e.ejercicio, py.*, urg.numero as numero_urg, urg.nombre as nombre_urg,
        ro.numero as numero_ro, ro.nombre as nombre_ro, pg.numero as numero_programa, pg.nombre as nombre_programa,
        sp.numero as numero_subprograma, sp.nombre as nombre_subprograma
        FROM proyectos py, responsables_operativos ro, unidades_responsables_gastos urg, programas pg, subprogramas sp, ejercicios e
        WHERE e.ejercicio_id = urg.ejercicio_id
        AND urg.ejercicio_id = e.ejercicio_id
        AND urg.unidad_responsable_gasto_id = ro.unidad_responsable_gasto_id
        AND ro.responsable_operativo_id = py.responsable_operativo_id
        AND py.subprograma_id = sp.subprograma_id
        AND pg.programa_id = sp.programa_id
        AND py.proyecto_id ='.$proyecto;
        $sql = $this->db->query($query);
        return $sql->row();
    }

    public function get_metasp_proyecto($proyecto)
    {
        $this->db->select('proyectos.proyecto_id, proyectos.numero as pynum, proyectos.descripcion as pydes, subprogramas.numero as sbnum, programas.numero as pgnum, responsables_operativos.numero as ronum, unidades_responsables_gastos.numero as urnum, proyectos.nombre as pynom');
        $this->db->join('subprogramas', 'proyectos.subprograma_id = subprogramas.subprograma_id');
        $this->db->join('programas', 'subprogramas.programa_id = programas.programa_id');
        $this->db->join('responsables_operativos', 'proyectos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->join('ejercicios', 'programas.ejercicio_id = ejercicios.ejercicio_id');
        $this->db->join('operaciones_ejercicios', 'ejercicios.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('proyectos.proyecto_id', $proyecto);
        $this->db->from('proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        } else {
            return FALSE;
        }
    }


    /**
     * Consulta que trea todas las metas que existen en acerca de un proyecto
     * @param $proyecto_id
     * @return bool
     */
    public function get_meta($proyecto_id)
    {
        $this->db->select('m.*, um.*,um.nombre as unidad_medida, mmp.*, m.nombre as mnombre');
        $this->db->from('proyectos p');
        $this->db->join('metas m','p.proyecto_id = m.proyecto_id');
        $this->db->join('unidades_medidas um', 'm.unidad_medida_id = um.unidad_medida_id');
        $this->db->join('meses_metas_programadas mmp', 'm.meta_id = mmp.meta_id');
        $this->db->where('m.tipo', 'principal');
        $this->db->where('p.proyecto_id', $proyecto_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            if (! empty($query->num_rows)) {
                return $query->row();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_mesesm($meta_id)
    {
        $this->db->select('*');
        $this->db->from('meses_metas_programadas');
        $this->db->where('meta_id', $meta_id);
        $this->db->where_in('mes_id', ['1','2','3','4','5','6','7','8','9','10','11','12']);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function get_meta_com($proyecto_id)
    {
        $this->db->select('metas.nombre as mnomb, metas.meta_id, unidades_medidas.nombre as umnomb, metas.peso');
        $this->db->join('metas', 'proyectos.proyecto_id = metas.proyecto_id');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.tipo', 'complementaria');
        $this->db->where('metas.nombre !=', '');
        $this->db->where('metas.nombre !=', 'No aplica');
        $this->db->where('proyectos.proyecto_id', $proyecto_id);
        $this->db->from('proyectos');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function get_mesesc($meta_id)
    {
        $this->db->select('*');
        $this->db->from('meses_metas_complementarias_resueltos');
        $this->db->where('meta_id', $meta_id);
        $this->db->where_in('mes_id', ['1','2','3','4','5','6','7','8','9','10','11','12']);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function get_indicadores($proyecto_id)
    {
        $this->db->select('indicadores.*, unidades_medidas.nombre as umnom, dimensiones.nombre as dnombre, frecuencias.nombre as fnombre, metas.tipo');
        $this->db->join('metas', 'proyectos.proyecto_id = metas.proyecto_id');
        $this->db->join('indicadores', 'metas.meta_id = indicadores.meta_id');
        $this->db->join('unidades_medidas', 'indicadores.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->join('dimensiones', 'indicadores.dimension_id = dimensiones.dimension_id');
        $this->db->join('frecuencias', 'indicadores.frecuencia_id = frecuencias.frecuencia_id');
        $this->db->where('proyectos.proyecto_id', $proyecto_id);
        $this->db->from('proyectos');
        $this->db->order_by('metas.tipo', 'DESC');
        $this->db->order_by('indicadores.indicador_id', 'DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function get_asustantivas($proyecto_id)
    {
        $this->db->select('numero, descripcion, accion_sustantiva_id');
        $this->db->from('acciones_sustantivas');
        $this->db->where('proyecto_id', $proyecto_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function get_ejecucion($proyecto_id)
    {
        $this->db->select('*');
        $this->db->where('proyecto_id', $proyecto_id);
        $this->db->from('meses_proyectos');
        $this->db->order_by('mes_id', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getMetas($id_pry, $tipo)
    {
        $this->db->select('metas.*, unidades_medidas.nombre as umnombre');
        $this->db->join('unidades_medidas', 'metas.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('metas.tipo', $tipo);
        $this->db->where('metas.proyecto_id', $id_pry);
        $this->db->from('metas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getIndicadores($id_pry)
    {
        $this->db->select('indicadores.*, frecuencias.nombre as fnombre, dimensiones.nombre as dnombre, unidades_medidas.nombre as unombre');
        $this->db->join('frecuencias', 'indicadores.frecuencia_id = frecuencias.frecuencia_id');
        $this->db->join('dimensiones', 'indicadores.dimension_id = dimensiones.dimension_id');
        $this->db->join('unidades_medidas', 'indicadores.unidad_medida_id = unidades_medidas.unidad_medida_id');
        $this->db->where('proyecto_id', $id_pry);
        $this->db->from('indicadores');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getAccionesSustantivas($id_pry)
    {
        $this->db->select('numero, descripcion');
        $this->db->where('proyecto_id', $id_pry);
        $this->db->from('acciones_sustantivas');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getMesesP($id_pry, $tipo)
    {
        $this->db->select('meses_metas_programadas.numero');
        $this->db->join('metas', 'proyectos.proyecto_id = metas.proyecto_id');
        $this->db->join('meses_metas_programadas', 'metas.meta_id = meses_metas_programadas.meta_id');
        $this->db->where('proyectos.proyecto_id', $id_pry);
        $this->db->where('metas.tipo', $tipo);
        $this->db->where_in('meses_metas_programadas.mes_id', ['1','2','3','4','5','6','7','8','9','10','11','12']);
        $this->db->from('proyectos');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getClaveProyecto($proyecto)
    {
        $this->db->select('proyectos.numero as pynum, subprogramas.numero as sbnum, programas.numero as pgnum, responsables_operativos.numero as ronum, unidades_responsables_gastos.numero as urnum');
        $this->db->join('subprogramas', 'proyectos.subprograma_id = subprogramas.subprograma_id');
        $this->db->join('programas', 'subprogramas.programa_id = programas.programa_id');
        $this->db->join('responsables_operativos', 'proyectos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->join('ejercicios', 'programas.ejercicio_id = ejercicios.ejercicio_id');
        $this->db->join('operaciones_ejercicios', 'ejercicios.ejercicio_id = operaciones_ejercicios.ejercicio_id');
        $this->db->where('operaciones_ejercicios.habilitado', 'SI');
        $this->db->where('proyectos.proyecto_id', $proyecto);
        $this->db->from('proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function getProgramaEspecial($proyecto)
    {
        $this->db->select('lineas_acciones_derechos_humanos.numero, lineas_acciones_derechos_humanos.nombre, acciones_sustantivas_derechos_humanos.descripcion');
        $this->db->join('lineas_acciones_derechos_humanos', 'acciones_sustantivas_derechos_humanos.linea_accion_derecho_humano_id = lineas_acciones_derechos_humanos.linea_accion_derecho_humano_id');
        $this->db->where('acciones_sustantivas_derechos_humanos.proyecto_id', $proyecto);
        $this->db->from('acciones_sustantivas_derechos_humanos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function verificaExistencia($where)
    {
        $this->db->where($where);
        $this->db->from('meses_metas_alcanzadas');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return true;
        } else {
            return FALSE;
        }
    }

    public function get_meses_habilitados($proyecto){
        $this->db->select('meses_proyectos.*,meses.nombre as mes_nombre,proyectos.nombre as nombre_proyecto, proyectos.proyecto_id as id_pry');
        $this->db->join('proyectos', 'proyectos.proyecto_id = meses_proyectos.proyecto_id');
        $this->db->join('meses', 'meses_proyectos.mes_id = meses.mes_id');
        $this->db->where('meses_proyectos.proyecto_id', $proyecto);
        $this->db->from('meses_proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function update_mes_ejecucion($proyecto,$mes,$ejecuta){
        $data = [
            'ejecuta' => $ejecuta,
        ];
        $where = ['proyecto_id' => $proyecto,'mes_id' => $mes];

        try{
            return ['success' => $this->main_model->update($data, 'meses_proyectos', $where), 'msg' => 'Update ok'];
        }catch(\Exception $e){
            return ['success' => false,'response'=>'Error: '.$e->getMessage()];
        }
    }

    public function getEjecucion($proyecto, $mes, $min)
    {
        $this->db->where('proyecto_id', $proyecto);
        $this->db->where('mes_id >=', $min);
        $this->db->where('mes_id <=', $mes);
        $this->db->from('meses_proyectos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }
}
