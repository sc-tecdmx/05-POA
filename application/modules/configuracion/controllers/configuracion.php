<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        Modules::run( 'inicio/verificaIngreso' );
        $models = array(
            'elaboracion',
            'home/general',
            'inicio/proyectos_model'
        );
        $this->load->model($models);
    }

    private function _getAnios()
    {
        if ($query = $this->elaboracion->getAnios()) {
            $anios = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $anios[$row->ejercicio] = $row->ejercicio;
            }
            $nuevo = date('Y')+1;
            if(!$clave = array_search($nuevo, $anios)){
                $anios[$nuevo] = $nuevo;
            }
            return $anios;
        }
    }

    private function _getAniosR()
    {
        if ($query = $this->elaboracion->getAnios()) {
            $anios = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $anios[$row->ejercicio] = $row->ejercicio;
            }
            return $anios;
        }
    }

    public function _get_ejercicio(){
        $ejercicio_inicio = date('y',strtotime('2012-12-01'));
        $ejercicio_final = date('y',strtotime('+1year'));
        $ejercicios = [];

        for($i = $ejercicio_inicio; $i <= $ejercicio_final; $i++){
            $ejercicios[$i] = '20'.$i;
        }

        return $ejercicios;
    }

    public function putElaboracionPoa()
    {
        $datos = array(
            'ejercicio'                     => $this->input->post('ejercicio'),
            'permitir_edicion_elaboracion'  => $this->input->post('estatus')
        );
        $where = array(
            'ejercicio'                     => $this->input->post('ejercicio')
        );
        $qry = $this->main_model->update($datos, 'ejercicios', $where);
        if($qry){
            return true;
        }
        return false;
    }

    public function getInfoConfiguracionElaboracion()
    {
        $ejercicio = $this->elaboracion->getEjercicioElaboracion();
        $configuracion = $this->elaboracion->getConfiguracion($ejercicio->ejercicio_id);
        /* foreach ($configuracion as $config){
            $data['edicion'][] = $config->permitir_edicion_elaboracion;
            $data['anio'][] = $config->ejercicio;
            $data['habilitado'][] = $config->habilitado;
        } */
        $data['edicion'][] = $configuracion->permitir_edicion_elaboracion;
        $data['anio'][] = $configuracion->ejercicio;
        $data['habilitado'][] = $configuracion->habilitado;
        echo json_encode($data);
    }

    private function _verifyPercentages($unidadId)
	{
		$percentages = $this->elaboracion->getTypeUnity($unidadId);
		return $percentages->porcentajes != '0';
	}

    public function elaboracion()
    {
        $ejercicio = $this->input->post('ejercicio');
        $elaboracion = $this->input->post('habilitar');
        $edicion = $this->input->post('edicion');
        /**
         * Proceso para la configuración de la elaboración de fichas POA
         *   1. Validar si el ejercicio ya esta registrado en la BD
         *      1.1 Si no existe el ejercicio lo que tenemos que hacer es copiar y pegar todos los datos del ejercicio anterior
         *      1.2 Si el ejercicio ya existe solo es cuestión de actualizar los permisos
         */
        $res = $this->elaboracion->searchEjercicio($ejercicio);
        if($res){ // si el ejercicio ya esta registrado
            $datos = array(
                'habilitado'    => $elaboracion,
                'ejercicio_id' => $res->ejercicio_id
            );
            $where = array(
                'operacion_ejercicio_id' => '1'
            );
            // actualizar elaboración
            $edit = $this->general->actualizaBase('operaciones_ejercicios', $datos, $where);
            $datos = array(
                'permitir_edicion_elaboracion' => $edicion
            );
            $where = array(
                'ejercicio_id' => $res->ejercicio_id
            );
            // actualizar seguimiento
            $act = $this->general->actualizaBase('ejercicios', $datos, $where);
            if($edit && $act){
                echo true;
            } else {
                echo false;
            }
        } else { // el ejercicio no esta registrado
            $datos = array(
                'ejercicio'                                         => $ejercicio,
                'permitir_edicion_seguimiento'                      => 'no',
                'permitir_edicion_seguimiento_derechos_humanos'     => 'no',
                'permitir_edicion_elaboracion'                      => 'no',
                'ultimo_mes_visible'                                => '1',
                'ultimo_mes_consulta'                               => '1',
                'tipo_captura_seguimiento'                          => 'global'
            );
            $insert = $this->proyectos_model->insertar($datos, 'ejercicios');

            if(!$insert){
                echo '400';
            }

            // Creamos registros en la tabla de control de meses para el seguimiento de metas
            for($i = 1; $i <= 12; $i++){
                $datos = array(
                    'ejercicio_id'  => $insert,
                    'mes_id'        => $i,
                    'habilitado'    => 'no'
                );
                $this->general->insertaBase('meses_controles_metas', $datos);
            }

            // Creamos registros en la tabla de control de meses para el seguimiento de derechos humanos
            for($i = 1; $i <= 12; $i++){
                $datos = array(
                    'ejercicio_id'  => $insert,
                    'mes_id'        => $i,
                    'habilitado'    => 'no'
                );
                $this->general->insertaBase('meses_controles_derechos_humanos', $datos);
            }

            // Replicamos los datos de los Programas, Subprogramas, Unidades Responsables del Gasto y Responsables Operativos del ejercicio anterior al nuevo;
            // solamente en caso de que exista uno anterior
            $ejercicio_anterior = $ejercicio - 1;
            $bus = $this->elaboracion->searchEjercicio($ejercicio_anterior);
            if ($bus) {
                $programas = $this->elaboracion->getProgramas($bus->ejercicio_id);
                foreach($programas as $row){
                    $datos = array(
                        'ejercicio_id'  => $insert,
                        'numero'        => $row->numero,
                        'nombre'        => $row->nombre
                    );
                    $programa_id = $this->elaboracion->insert('programas', $datos);

                    $subprogramas = $this->elaboracion->getSubprogramas($row->programa_id);
                    foreach($subprogramas as $subprograma){
                        $data = array(
                            'programa_id'   => $programa_id,
                            'nombre'        => $subprograma->nombre,
                            'numero'        => $subprograma->numero
                        );
                        $this->general->insertaBase('subprogramas', $data);
                    }
                }

                // $urgs = $this->elaboracion->getUnidadesResponsablesGastos($bus->ejercicio_id);
				$urgs = $this->elaboracion->getInfo('unidades_responsables_gastos', $bus->ejercicio_id);
                foreach($urgs as $urg){
                    $datos = array(
                        'ejercicio_id'      => $insert,
                        'numero'            => $urg->numero,
                        'nombre'            => $urg->nombre,
                        'repite_proyecto'   => $urg->repite_proyecto
                    );
                    $urg_id = $this->elaboracion->insert('unidades_responsables_gastos', $datos);

                    $responsables_operativos = $this->elaboracion->getResponsablesOperativos($urg->unidad_responsable_gasto_id);
                    foreach ($responsables_operativos as $responsable_operativo){
                        $data = array(
                            'unidad_responsable_gasto_id'   => $urg_id,
                            'numero'                        => $responsable_operativo->numero,
                            'nombre'                        => $responsable_operativo->nombre
                        );
                        $this->general->insertaBase('responsables_operativos', $data);
                    }
                }

                // Replicación de usuarios en caso de que sea necesario
				// Actualización de usuarios en tabla usuarios ejercicios
				$users = $this->elaboracion->getPreviousUsers($bus->ejercicio_id);
                if ($users) {
                	foreach ($users as $user) {
						$datos = array(
							'usuario_id'    => $user->usuario_id,
							'ejercicio_id'  => $insert
						);
						$this->general->insertaBase('usuarios_ejercicios', $datos);
					}
				}

                // Replicación de Unidades de Medida
                $unidades_medidas = $this->elaboracion->getInfo('unidades_medidas', $bus->ejercicio_id);
                foreach ($unidades_medidas as $unidad_medida){
                    $datos = array(
                        'ejercicio_id'  => $insert,
                        'numero'        => $unidad_medida->numero,
                        'nombre'        => $unidad_medida->nombre,
                        'descripcion'   => $unidad_medida->descripcion,
                        'porcentajes'   => $unidad_medida->porcentajes
                    );
                    $this->general->insertaBase('unidades_medidas', $datos);
                }

                // Replicación de Proyectos
                $proyectos = $this->elaboracion->get_projects($bus->ejercicio_id);
                foreach($proyectos as $proyecto){
                	$responsable = $this->elaboracion->getInfoOperativeResponsable($proyecto->responsable_operativo_id);
                	$nuevo_responsable = $this->elaboracion->getOperativeResponsable($responsable->nombre, $insert);
                	$subprograma = $this->elaboracion->getInfoSubprogram($proyecto->subprograma_id);
                	$nuevo_subprograma = $this->elaboracion->getSubprogram($subprograma->nombre, $insert);
					$datos = array(
                        'responsable_operativo_id'      => $nuevo_responsable->responsable_operativo_id,
                        'subprograma_id'                => $nuevo_subprograma->subprograma_id,
                        'numero'                        => $proyecto->numero,
                        'nombre'                        => $proyecto->nombre,
                        'tipo'                          => $proyecto->tipo,
                        'version'                       => $proyecto->version,
                        'objetivo'                      => $proyecto->objetivo,
                        'justificacion'                 => $proyecto->justificacion,
                        'descripcion'                   => $proyecto->descripcion,
                        'fecha'                         => $proyecto->fecha,
                        'nombre_responsable_operativo'  => $proyecto->nombre_responsable_operativo,
                        'cargo_responsable_operativo'   => $proyecto->cargo_responsable_operativo,
                        'nombre_titular'                => $proyecto->nombre_titular,
                        'responsable_ficha'             => $proyecto->responsable_ficha,
                        'autorizado_por'                => $proyecto->autorizado_por,
                        'status'                        => $proyecto->status
                    );
                    $proyecto_id = $this->elaboracion->insert('proyectos', $datos);

                    // Replicacion del Periodo de Ejecucion del Proyecto
                    $meses_proyectos = $this->elaboracion->getMesesProyectos($proyecto->proyecto_id);
                    foreach($meses_proyectos as $mes_proyecto){
                        $data = array(
                            'proyecto_id'   => $proyecto_id,
                            'mes_id'        => $mes_proyecto->mes_id,
                            'ejecuta'       => $mes_proyecto->ejecuta
                        );
                        $this->general->insertaBase('meses_proyectos', $data);
                    }

                    // Replicacion de Metas Principales y Complementarias
                    $metas = $this->elaboracion->getMetas($proyecto->proyecto_id);
                    if ($metas) {
						foreach($metas as $meta){
							$obtener_unidad = $this->elaboracion->getUnidad($meta->unidad_medida_id);
							$unidad_actual = $this->elaboracion->getUnidadActual($obtener_unidad->nombre, $insert);
							$data = array(
								'proyecto_id'       => $proyecto_id,
								'unidad_medida_id'  => $unidad_actual->unidad_medida_id, // obtener la nueva unidad de medida
								'tipo'              => $meta->tipo,
								'orden'             => $meta->orden,
								'nombre'            => $meta->nombre,
								'peso'				=> $meta->peso,
								'tmc'				=> $meta->tmc
							);
							$meta_id = $this->elaboracion->insert('metas', $data);

							// Replicacion de Metas Programadas
							$metas_programadas = $this->elaboracion->getMetasProgramadas($meta->meta_id);
							foreach ($metas_programadas as $meta_programada){
								$data1 = array(
									'meta_id'   => $meta_id,
									'mes_id'    => $meta_programada->mes_id,
									'numero'    => $meta_programada->numero
								);
								$this->general->insertaBase('meses_metas_programadas', $data1);
							}

							// Poblar nuevos registros para las Metas Alcanzadas
							for($i = 1; $i <= 12; $i++){
								$data2 = array(
									'meta_id'       => $meta_id,
									'mes_id'        => $i,
									'numero'        => '0',
									'explicacion'   => ''
								);
								$this->general->insertaBase('meses_metas_alcanzadas', $data2);
							}

							if ($this->_verifyPercentages($meta->unidad_medida_id)) {
								for($i = 1; $i <= 12; $i++){
									$data2 = array(
										'meta_id'       => $meta_id,
										'mes_id'        => $i,
										'numero'        => '0'
									);
									$this->general->insertaBase('meses_metas_complementarias_resueltos', $data2);
								}
							}

							// Replicacion de Indicadores
							$indicadores = $this->elaboracion->getIndicadores($meta->meta_id);
							if ($indicadores) {
								foreach($indicadores as $indicador){
									$obtener_unidad = $this->elaboracion->getUnidad($indicador->unidad_medida_id);
									$unidad_actual = $this->elaboracion->getUnidadActual($obtener_unidad->nombre, $insert);
									$data3 = array(
                                        'meta_id'           => $meta_id,
                                        'proyecto_id'       => $proyecto->proyecto_id,
										'unidad_medida_id'  => $unidad_actual->unidad_medida_id, // obtener nueva unidad medida
										'dimension_id'      => $indicador->dimension_id,
										'frecuencia_id'     => $indicador->frecuencia_id,
										'nombre'            => $indicador->nombre,
										'definicion'        => $indicador->definicion,
										'metodo_calculo'    => $indicador->metodo_calculo,
										'meta'              => $indicador->meta
									);
									$this->general->insertaBase('indicadores', $data3);
								}
							}
						}

						// Replicacion de las Acciones Sustantivas del Proyecto
						$acciones_sustantivas = $this->elaboracion->getAccionesSustantivas($proyecto->proyecto_id);
						if ($acciones_sustantivas) {
							foreach ($acciones_sustantivas as $accion_sustantiva){
								$data = array(
									'proyecto_id'   => $proyecto_id,
									'numero'        => $accion_sustantiva->numero,
									'descripcion'   => $accion_sustantiva->descripcion
								);
								$this->general->insertaBase('acciones_sustantivas', $data);
							}
						}
					}
                }
                echo true;
            }

        }
    }

    public function index()
    {
        $data = array();
        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu_c',$data,TRUE);
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Configuración";
        // carga de js
        $data['js'] = 'configuracion/configuracion.js';
        // arreglo con los años registrados
        $data['anios'] = $this->_getAnios();
        //paso el main
        $data["main"] 	 = $this->load->view('configuracion',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        //cargo vista general
        $this->load->view('home/layout_general',$data);
    }
}
