<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class info extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'info_model',
            'main_model',
            'home/general',
            'proyectos_model'
        );
        $this->load->model($models);
    }

    public function postProyecto()
    {
        $datos = array(
            'responsable_operativo_id'      => $this->input->post('responsable_operativo_id'),
            'subprograma_id'                => $this->input->post('subprograma_id'),
            'numero'                        => $this->input->post('numero'),
            'nombre'                        => $this->input->post('nombre'),
            'tipo'                          => $this->input->post('tipo'),
            'version'                       => $this->input->post('version'),
            'objetivo'                      => $this->input->post('objetivo'),
            'justificacion'                 => $this->input->post('justificacion'),
            'descripcion'                   => $this->input->post('descripcion'),
            'fecha'                         => $this->input->post('fecha'),
            'nombre_responsable_operativo'  => $this->input->post('nombre_responsable_operativo'),
            'cargo_responsable_operativo'   => $this->input->post('cargo_responsable_operativo'),
            'nombre_titular'                => $this->input->post('nombre_titular'),
            'responsable_ficha'             => $this->input->post('responsable_ficha'),
            'autorizado_por'                => $this->input->post('autorizado_por')
        );
        $qry = $this->proyectos_model->insertar($datos, 'proyectos');
        if(!$qry){
            echo '400';
        } else {
            echo $qry;
        }
    }

    public function putProyecto($id_pry)
    {
        $datos = array(
            'responsable_operativo_id'      => $this->input->post('responsable_operativo_id'),
            'subprograma_id'                => $this->input->post('subprograma_id'),
            'numero'                        => $this->input->post('numero'),
            'nombre'                        => $this->input->post('nombre'),
            'tipo'                          => $this->input->post('tipo'),
            'version'                       => $this->input->post('version'),
            'objetivo'                      => $this->input->post('objetivo'),
            'justificacion'                 => $this->input->post('justificacion'),
            'descripcion'                   => $this->input->post('descripcion'),
            'fecha'                         => $this->input->post('fecha'),
            'nombre_responsable_operativo'  => $this->input->post('nombre_responsable_operativo'),
            'cargo_responsable_operativo'   => $this->input->post('cargo_responsable_operativo'),
            'nombre_titular'                => $this->input->post('nombre_titular'),
            'responsable_ficha'             => $this->input->post('responsable_ficha'),
            'autorizado_por'                => $this->input->post('autorizado_por')
        );
        $where = array('proyecto_id' => $id_pry);
        $qry = $this->main_model->update($datos, 'proyectos', $where);
        if($qry){
            echo true;
        } else {
            echo '400';
        }
    }

    public function deleteProyecto()
    {
        $where = array(
            'proyecto_id'   => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'proyectos');
        if($query){
            echo true;
        }
        echo false;
    }

    public function getResponsableOperativo($unidad)
    {
        $res = $this->info_model->getResponsables($unidad);
        if($res){
            foreach ($res as $row){
                $data['responsable_operativo_id'][] = $row->responsable_operativo_id;
                $data['numero'][] = $row->numero;
                $data['nombre'][] = $row->nombre;
            }
            echo json_encode($data);
        }
    }

    public function getSubprogramas($programa)
    {
        $res = $this->info_model->getSubprogramas($programa);
        if($res){
            foreach ($res as $row){
                $data['subprograma_id'][] = $row->subprograma_id;
                $data['numero'][] = $row->numero;
                $data['nombre'][] = $row->nombre;
            }
            echo json_encode($data);
        }
    }

    public function getMetaPrincipal($meta)
    {
        $res = $this->info_model->getMetas($meta);
        if($res){
            foreach ($res as $row){
                $data['nombre'][] = $row->nombre;
                $data['tmc'][] = $row->tmc;
                $data['unidad'][] = $row->unidad_medida_id;
            }
            echo json_encode($data);
        }
    }

    public function putMetaPrincipal($meta)
    {
        $datos = array(
            'nombre'    => $this->input->post('nombre'),
            'tmc'       => $this->input->post('tmc')
        );
        $where = array('meta_id' => $meta);
        $qry = $this->main_model->update($datos, 'metas', $where);
        if($qry){
            echo true;
        }
        echo false;
    }

    public function putMetaPrincipalE($meta)
    {
        // obtener proyecto de la meta
        $proyecto = $this->info_model->getProyectoFromMeta($meta);
        // obtener metas complementarias en caso de tener
        $complementarias = $this->info_model->getMetasComplementarias($proyecto->proyecto_id);
        if($complementarias){
            foreach($complementarias as $complementaria){
                $this->info_model->deleteMetaComplementaria($complementaria->meta_id);
            }
        }
        $datos = array(
            'nombre'            => $this->input->post('nombre'),
            'tmc'               => $this->input->post('tmc'),
            'unidad_medida_id'  => $this->input->post('unidadMedida')
        );
        $where = array('meta_id' => $meta);
        $qry = $this->main_model->update($datos, 'metas', $where);
        if($qry){
            echo true;
        }
        echo false;
    }

    public function postMetaPrincipal()
    {
        $datos = array(
            'proyecto_id'       => $this->input->post('proyecto'),
            'unidad_medida_id'  => '1047',
            'tipo'              => 'principal',
            'orden'             => '1',
            'nombre'            => $this->input->post('nombre')
        );
        $meta_id = $this->proyectos_model->insertar($datos, 'metas');
        if($meta_id){
            for($i = 1; $i<=12; $i++){
                $datos = array(
                    'meta_id'   => $meta_id,
                    'mes_id'    => $i,
                    'numero'    => '1'
                );
                $datos1 = array(
                    'meta_id'   => $meta_id,
                    'mes_id'    => $i,
                    'numero'    => '0'
                );
                $this->general->insertaBase('meses_metas_programadas', $datos);
                $this->general->insertaBase('meses_metas_alcanzadas', $datos1);
            }
            echo true;
        }
        echo false;
    }

    public function postMetaPrincipalE()
    {
        $datos = array(
            'proyecto_id'       => $this->input->post('proyecto'),
            'unidad_medida_id'  => $this->input->post('unidadMedida'),
            'tipo'              => 'principal',
            'orden'             => '1',
            'nombre'            => $this->input->post('nombre')
        );
        $meta_id = $this->proyectos_model->insertar($datos, 'metas');
        if($meta_id){
            $porcentajes = $this->info_model->getTipoUnidadMedida($this->input->post('unidadMedida'));
            if($porcentajes->porcentajes == '1'){
                for($i = 1; $i<=12; $i++){
                    $datos = array(
                        'meta_id'   => $meta_id,
                        'mes_id'    => $i,
                        'numero'    => '1'
                    );
                    $datos1 = array(
                        'meta_id'   => $meta_id,
                        'mes_id'    => $i,
                        'numero'    => '0'
                    );
                    $this->general->insertaBase('meses_metas_programadas', $datos);
                    $this->general->insertaBase('meses_metas_alcanzadas', $datos1);
                    $this->general->insertaBase('meses_metas_complementarias_resueltos', $datos1);
                }
                echo true;
            } else {
                for($i = 1; $i<=12; $i++){
                    $datos = array(
                        'meta_id'   => $meta_id,
                        'mes_id'    => $i,
                        'numero'    => '1'
                    );
                    $datos1 = array(
                        'meta_id'   => $meta_id,
                        'mes_id'    => $i,
                        'numero'    => '0'
                    );
                    $this->general->insertaBase('meses_metas_programadas', $datos);
                    $this->general->insertaBase('meses_metas_alcanzadas', $datos1);
                }
                echo true;
            }

        }
        echo false;
    }

    public function getMetaComplementaria($meta)
    {
        $res = $this->info_model->getMetas($meta);
        if($res){
            foreach ($res as $row){
                $data['nombre'][] = $row->nombre;
                $data['unidad'][] = $row->unidad_medida_id;
                $data['orden'][] = $row->orden;
                $data['peso'][] = $row->peso;
            }
            echo json_encode($data);
        }
    }

    public function putMetaComplementaria($meta)
    {
        // validación
        $pry = $this->input->post('proyecto');
        if($res = $this->info_model->getPesos($pry)){
            $total = 0;
            foreach ($res as $row){
                if($row->meta_id == $meta){
                    $total += $this->input->post('peso');
                } else {
                    $total += $row->peso;
                }
            }
            if($total > 100){
                echo "420";
            } else {
                $porcentajes = $this->info_model->getTipoUnidad($this->input->post('unidad'));
                $registro = $this->info_model->getExistResueltos($meta);
                if(!$registro && $porcentajes->porcentajes == '1'){
                    for($i = 1; $i <= 12; $i++){
                        $datos = array(
                            'meta_id' => $meta,
                            'mes_id'  => $i,
                            'numero'  => 0
                        );
                        $this->general->insertaBase('meses_metas_complementarias_resueltos', $datos);
                    }
                }
                $datos = array(
                    'proyecto_id'       => $pry,
                    'unidad_medida_id'  => $this->input->post('unidad'),
                    'tipo'              => 'complementaria',
                    'peso'              => $this->input->post('peso'),
                    'nombre'    => $this->input->post('nombre')
                );
                $where = array('meta_id' => $meta);
                $qry = $this->main_model->update($datos, 'metas', $where);
                if($qry){
                    echo true;
                }
                echo false;
            }
        }
    }

    public function postMetaComplementaria()
    {
        $pry = $this->input->post('proyecto');
        $res = $this->info_model->getPesos($pry);
        if($res && is_array($res)){
            $total = 0;
            foreach ($res as $row){
                $total += $row->peso;
            }
        } else if(!$res){
            $total = 0;
        } else {
            echo false;
        }

        if($total >= 99 && $total <=100){
            echo "420";
        } else {
            $total += $this->input->post('peso');
            if($total > 100){
                echo "422";
            } else {
                $datos = array(
                    'proyecto_id'       => $this->input->post('proyecto'),
                    'unidad_medida_id'  => $this->input->post('unidad'),
                    'tipo'              => 'complementaria',
                    'orden'				=> '0',
                    'nombre'            => $this->input->post('nombre'),
                    'peso'              => $this->input->post('peso')
                );
                $meta_id = $this->proyectos_model->insertar($datos, 'metas');
                if($meta_id){
                    for($i = 1; $i<=12; $i++){
                        $datos = array(
                            'meta_id'   => $meta_id,
                            'mes_id'    => $i,
                            'numero'    => '1'
                        );
                        $datos1 = array(
                            'meta_id'   	=> $meta_id,
                            'mes_id'    	=> $i,
                            'numero'    	=> '0',
							'explicacion' 	=> ''
                        );
                        $this->general->insertaBase('meses_metas_programadas', $datos);
                        $this->general->insertaBase('meses_metas_alcanzadas', $datos1);
                    }
                    $porcentajes = $this->info_model->getTipoUnidad($this->input->post('unidad'));
                    if($porcentajes->porcentajes == '1'){
                        for($i = 1; $i<=12; $i++){
                            $datos = array(
                                'meta_id'   => $meta_id,
                                'mes_id'    => $i,
                                'numero'    => '0'
                            );
                            $this->general->insertaBase('meses_metas_complementarias_resueltos', $datos);
                        }
                    }
                    echo true;
                } else {
                    echo false;
                }
            }
        }
    }

    public function deleteMetaComplementaria()
    {
        $where = array(
            'meta_id'   => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'metas');
        if($query){
            echo true;
        }
        echo false;
    }

    public function getIndicadores($indicador)
    {
        $res = $this->info_model->getIndicadores($indicador);
        if($res){
            foreach ($res as $row){
                $data['metaId'][] = $row->meta_id;
                $data['unidad'][] = $row->unidad_medida_id;
                $data['dimension'][] = $row->dimension_id;
                $data['frecuencia'][] = $row->frecuencia_id;
                $data['nombre'][] = $row->nombre;
                $data['definicion'][] = $row->definicion;
                $data['metodo'][] = $row->metodo_calculo;
                $data['meta'][] = $row->meta;
            }
            echo json_encode($data);
        }
    }

    public function putIndicador($indicador)
    {
        $datos = array(
            'meta_id'           => $this->input->post('metaId'),
            'unidad_medida_id'  => $this->input->post('unidad'),
            'dimension_id'      => $this->input->post('dimension'),
            'frecuencia_id'     => $this->input->post('frecuencia'),
            'nombre'            => $this->input->post('nombre'),
            'definicion'        => $this->input->post('definicion'),
            'metodo_calculo'    => $this->input->post('metodo'),
            'meta'              => $this->input->post('meta')
        );
        $where = array(
            'indicador_id'     => $indicador
        );
        $qry = $this->main_model->update($datos, 'indicadores', $where);
        if($qry){
            echo true;
        }
        echo false;
    }

    public function postIndicador()
    {
        $datos = array(
            'meta_id'           => $this->input->post('metaId'),
            'proyecto_id'       => $this->input->post('proyecto'),
            'unidad_medida_id'  => $this->input->post('unidad'),
            'dimension_id'      => $this->input->post('dimension'),
            'frecuencia_id'     => $this->input->post('frecuencia'),
            'nombre'            => $this->input->post('nombre'),
            'definicion'        => $this->input->post('definicion'),
            'metodo_calculo'    => $this->input->post('metodo'),
            'meta'              => $this->input->post('meta')
        );
        $indicador = $this->proyectos_model->insertar($datos, 'indicadores');
        if($indicador){
            echo true;
        }
        echo false;
    }

    public function deleteIndicador()
    {
        $where = array(
            'indicador_id'   => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'indicadores');
        if($query){
            echo true;
        }
        echo false;
    }

    public function getAccion($accion)
    {
        $res = $this->info_model->getAccion($accion);
        if($res){
            foreach ($res as $row){
                $data['numero'][] = $row->numero;
                $data['descripcion'][] = $row->descripcion;
            }
            echo json_encode($data);
        }
    }

    public function putAccionesSustantivas($accion)
    {
        $datos = array(
            'proyecto_id'   => $this->input->post('proyecto'),
            'numero'        => $this->input->post('numero'),
            'descripcion'   => $this->input->post('descripcion')
        );
        $where = array(
            'accion_sustantiva_id'     => $accion
        );
        $qry = $this->main_model->update($datos, 'acciones_sustantivas', $where);
        if($qry){
            echo true;
        }
        echo false;
    }

    public function postAccionesSustantivas()
    {
        $datos = array(
            'proyecto_id'   => $this->input->post('proyecto'),
            'numero'        => $this->input->post('numero'),
            'descripcion'   => $this->input->post('descripcion')
        );
        $indicador = $this->proyectos_model->insertar($datos, 'acciones_sustantivas');
        if($indicador){
            echo true;
        }
        echo false;
    }

    public function deleteAccionSustantiva()
    {
        $where = array(
            'accion_sustantiva_id'   => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'acciones_sustantivas');
        if($query){
            echo true;
        }
        echo false;
    }

    public function deleteUnidadResponsable()
    {
        $where = array(
            'unidad_responsable_gasto_id' => $this->input->post('id')
        );
        $query = $this->main_model->delete($where, 'unidades_responsables_gastos');
        if($query){
            echo true;
        } else {
            echo false;
        }
    }

    public function getMesesMetas($meta, $mes)
    {
        $res = $this->info_model->getMesMeta($meta, $mes);
        if($res){
            foreach ($res as $row){
                $data['numero'][] = $row->numero;
            }
            echo json_encode($data);
        }
    }

    public function putMesMetas()
    {
        $where = array(
            'meta_id'   => $this->input->post('meta'),
            'mes_id'    => $this->input->post('mes')
        );
        $datos = array(
            'numero' => $this->input->post('numero')
        );
        $query = $this->main_model->update($datos, 'meses_metas_programadas', $where);
        if($query){
            echo true;
        } else {
            echo '420';
        }
    }

    protected function insertEjecucionProyecto($proyecto, $mes_id, $ejecuta)
    {
        $datos = array(
            'proyecto_id' => $proyecto,
            'mes_id'      => $mes_id,
            'ejecuta'     => $ejecuta
        );
        $this->main_model->insert($datos, 'meses_proyectos');
        return true;
    }

    public function postEjecucionProyecto()
    {
        $meses = $this->input->post('ejecuta');
        $j = 0;
        for($i = 1; $i <= 12; $i++){
            if($meses[$j] == '1'){
                $datos = array(
                    'proyecto_id' => $this->input->post('proyecto'),
                    'mes_id'      => $i,
                    'ejecuta'     => 'si'
                );
            } else {
                $datos = array(
                    'proyecto_id' => $this->input->post('proyecto'),
                    'mes_id'      => $i,
                    'ejecuta'     => 'no'
                );
            }
            $this->main_model->insert($datos, 'meses_proyectos');
            $j++;
        }
        echo 'true';
    }

    public function getEjecucion($proyecto)
    {
        $res = $this->info_model->getEjecucion($proyecto);
        if($res){
            foreach ($res as $row){
                $data['meses'][] = $row->mes_id;
            }
            echo json_encode($data);
        }
    }

    public function putEjecucion()
    {
        $meses = $this->input->post('meses');
        $j = 0;
        for($i = 1; $i <= 12; $i++){
            if($meses[$j] == '1'){
                $datos = array(
                    'ejecuta' => 'si'
                );
            } else {
                $datos = array(
                    'ejecuta' => 'no'
                );
            }
            $where = array(
                'proyecto_id'  => $this->input->post('proyecto'),
                'mes_id'        => $i
            );
            $this->general->actualizaBase('meses_proyectos', $datos, $where);
            $j++;
        }
       echo 'true';
    }
}
