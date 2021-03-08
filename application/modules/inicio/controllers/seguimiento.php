<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class seguimiento extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        Modules::run( 'inicio/verificaIngreso');
        $models = array(
            'seguimiento_model',
            'home/home_inicio',
            'home/general',
            'proyectos_model'
        );
        $this->load->model($models);
    }

    /**
     * Función para obtener la clave del proyecto que se muestra en el encabezado
     * @param $id_pry
     * @return string
     */
    private function _claveProyecto($id_pry)
    {
        $proyecto = $this->proyectos_model->getClaveProyecto($id_pry);
        $clave = $proyecto->urnum.'-'.$proyecto->ronum.'-'.$proyecto->pgnum.'-'.$proyecto->sbnum.'-'.$proyecto->pynum;
        return $clave;
    }

    private function _getMesesArray()
    {
        // $ejercicio = $this->home_inicio->get_ejercicio();
		$ejercicio = $this->session->userdata('ejercicio');
        $res = $this->seguimiento_model->getMesesHabilitados($ejercicio);
        if($res){
            $meses = array('' => '- Seleccione uno -');
            foreach ($res as $row){
                $meses[$row->mes_id] = ucfirst($row->nombre);
            }
            return $meses;
        }
		$mesActual = date('n');
		$meses = $this->seguimiento_model->getMesesHabilitadosNoConfigurados($mesActual);
		$arrayMeses = array('' => '- Seleccione uno -');
		foreach($meses as $mes){
			$arrayMeses[$mes->mes_id] = ucfirst($mes->nombre);
		}
		return $arrayMeses;
    }

    private function _obtenerMesesHabilitadosC($id_proy)
    {
        // $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->seguimiento_model->getMesesHabC($this->session->userdata('ejercicio'));
        if($res){
            $tabla = '<tr>';
            foreach($res as $row){
                $tabla .= '<th>'.$row->small.'</th>';
            }
            $tabla .= '</tr>';
            return $tabla;
        }
		$mesActual = date('n');
		$meses = $this->seguimiento_model->getMesesHabilitadosNoConfigurados($mesActual);
		$tabla = '<tr>';
		foreach($meses as $mes){
			$tabla .= '<th>'.$mes->small.'</th>';
		}
		$tabla .= '</tr>';
		return $tabla;
    }


    /**
     * Función para crear el encabezado de la Meta Principal
     * en este caso la meta principal cuenta con metas complementarias
     * @return string
     */
    private function _encabezadomp()
    {
        // Función para obtener el último mes habilitado
        $mesUlt = $this->seguimiento_model->getMesesMax($this->session->userdata('ejercicio'));
		$mesHabilitado = $mesUlt->mes_id ? $mesUlt->mes_id : date('n');
        $meses = $this->seguimiento_model->getMeses($this->session->userdata('ejercicio'), $mesHabilitado);
        if($meses){
            $num = 0;
            $tm = '<tr>';
            foreach($meses as $mes){
                $tm .= '<th>'.$mes->small.'</th>';
                $num++;
            }
            $tm .= '</tr>';
            $tabla = '
                <tr>
                    <th rowspan="2">Denominación de la meta</th>
                    <th rowspan="2">Unidad de Medida</th>
                    <th rowspan="2">Meta</th>
                    <th colspan="'.$num.'">Meses</th>
                    <th rowspan="2">Acumulada</th>
                    <th rowspan="2">Porcentaje</th>
                </tr>
            ';
            $tabla .= $tm;
            return $tabla;
        }
    }

    /**
     * Función para crear el encabezado de la Meta Complementaria
     * en este caso la meta principal cuenta con metas complementarias
     * @return string
     */
    private function _encabezadomc()
    {
        // Función para obtener el último mes habilitado
        $ultimo = $this->seguimiento_model->getMesesMax($this->session->userdata('ejercicio'));
		$mesHabilitado = $ultimo->mes_id ? $ultimo->mes_id : date('n');
        $meses = $this->seguimiento_model->getMeses($this->session->userdata('ejercicio'), $mesHabilitado);
        if($meses){
            $num = 0;
            $tm = '<tr>';
            foreach($meses as $mes){
                $tm .= '<th>'.$mes->small.'</th>';
                $num++;
            }
            $tm .= '</tr>';
            $tabla = '
                <tr>
                    <th rowspan="2">Denominación de la meta</th>
                    <th rowspan="2">Unidad de Medida</th>
                    <th rowspan="2">Peso</th>
                    <th rowspan="2">Meta</th>
                    <th colspan="'.$num.'">Meses</th>
                    <th rowspan="2">Acumulada</th>
                    <th rowspan="2">Porcentaje</th>
                    <th rowspan="2">Acciones</th>
                </tr>
            ';
            $tabla .= $tm;
            return $tabla;
        }
    }

    /**
     * Función para crear el encabezado de la Meta Principal
     * en este caso la meta principal no cuenta con metas complementarias
     * @return string
     */
    private function _encabezadomps()
    {
        $ultimo = $this->seguimiento_model->getMesesMax($this->session->userdata('ejercicio'));
		$mesHabilitado = $ultimo->mes_id ? $ultimo->mes_id : date('n');
        $meses = $this->seguimiento_model->getMeses($this->session->userdata('ejercicio'), $mesHabilitado);
        if($meses){
            $num = 0;
            $tm = '<tr>';
            foreach($meses as $mes){
                $tm .= '<th>'.$mes->small.'</th>';
                $num++;
            }
            $tm .= '</tr>';
            $tabla = '
                <tr>
                    <th rowspan="2">Denominación de la meta</th>
                    <th rowspan="2">Unidad de Medida</th>
                    <th rowspan="2">Meta</th>
                    <th colspan="'.$num.'">Meses</th>
                    <th rowspan="2">Acumulada</th>
                    <th rowspan="2">Acciones</th>
                </tr>
            ';
            $tabla .= $tm;
            return $tabla;
        }
    }

    /**
     * Función que pobla la tabla de metas complementarias
     * @param $id_pry
     * @return string
     */
    private function _tablamc($id_pry)
    {
        $res = $this->seguimiento_model->getMetas($id_pry, 'complementaria');
        $ultimo = $this->seguimiento_model->getMesesMax($this->session->userdata('ejercicio'));
		$mesHabilitado = $ultimo->mes_id ? $ultimo->mes_id : date('n');
		$seguimientoHabilitado = $ultimo->mes_id ? true : false;
        $tabla = '';
        if ($res) {
            foreach ($res as $row) {
                $totalmp = 0;
                $totalmc = 0;
                $totalp = 0;
                if($row->umtipo !='1'){
                    $tabla .= '
                    <tr>
                        <td rowspan="3">' . $row->mnombre . '</td>
                        <td rowspan="3">' . $row->umnombre . '</td>
                        <td rowspan="3" class="text-center">'.$row->peso.'%</td>
                        <td>Programada</td>';
                    $ren = $this->seguimiento_model->getMesesMetasProgramadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    foreach($ren as $metap){
                        $tabla .= '<td class="text-center">'.$metap->numero.'</td>';
                        $totalmp += $metap->numero;
                    }
                    $tabla .= '
                    <td class="text-center">'.$totalmp.'</td>
                    <td class="text-center">100%</td>';
                    $mesesEjecuta = $this->seguimiento_model->getMesesEjecucion($id_pry);
                    if(!$mesesEjecuta){
                        $tabla .= '<td rowspan="3">Necesitas contar con la información de meses de ejecución para darle seguimiento a este proyecto.</td>';
                    }
                    $valida = $this->seguimiento_model->getPreviousWeight($row->meta_id);
                    if($valida->peso == '0'){
                        $tabla .= '<td rowspan="3">Necesitas agregar peso a tu meta complementaria para darle seguimiento.</td>';
                    }
					if(!$seguimientoHabilitado){
						$tabla .= '<td rowspan="3">Por el momento no hay un mes configurado al que puedas dar seguimiento.</td>';
					}
                    if($mesesEjecuta && $valida->peso != '0' && $seguimientoHabilitado){
                        $tabla .= '<td rowspan="3">
                                <button class="btn btn-primary" onclick="darSeguimientoNormal('.$row->meta_id.')"><i class="fa fa-fw fa-plus"></i></button>
                        </td>';
                    }
                    $tabla .= '</tr>';
                    $tabla .= '
                    <tr>
                        <td>Alcanzada</td>
                    ';
                    $ren = $this->seguimiento_model->getMesesMetasAlcanzadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    $nx = 'No existe explicación del avance físico para este mes';
                    if($ren){
                        $i = 0;
                        $j = 1;
                        foreach($ren as $metaa){
                            $i++;
                            $tool = $metaa->explicacion!=null ? 'Dar click para ver la explicación.' : $nx;
                            $tabla .= '<td class="text-center" data-toggle="tooltip" data-placement="top" title="'.$tool.'" onclick="showDescription('.$row->meta_id.','.$j.')">'.$metaa->numero.'</td>';
                            $totalp += $metaa->porcentaje;
                            $totalmc += $metaa->numero;
                            $j++;
                        }
                        if ($totalp == 0) {
                            $totalNuevo = 0;
                        } else {
                            $totalNuevo = $totalp/$i;
                        }
                        $tabla .= '
                                <td class="text-center">'.$totalmc.'</td>
                                <td class="text-center">'.round($totalNuevo,2).'%</td>
                            </tr>
                            <tr>
                                <td>% Avance</td>
                        ';
                        foreach($ren as $metaa){
                            $tabla .= '<td class="text-center">'.$metaa->porcentaje.'</td>';
                        }
                    }
                    $tabla .='</tr>';
                } else {
                    $tabla .= '
                    <tr>
                        <td rowspan="4">' . $row->mnombre . '</td>
                        <td rowspan="4">' . $row->umnombre . '</td>
                        <td rowspan="4" class="text-center">'.$row->peso.'%</td>
                        <td>Programada</td>';
                    $ren = $this->seguimiento_model->getMesesMetasProgramadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    foreach($ren as $metap){
                        $tabla .= '<td class="text-center">'.$metap->numero.'</td>';
                        $totalmp += $metap->numero;
                    }
                    $tabla .= '
                        <td class="text-center">'.$totalmp.'</td>
                        <td class="text-center">100%</td>';
					$mesesEjecuta = $this->seguimiento_model->getMesesEjecucion($id_pry);
					if(!$mesesEjecuta){
						$tabla .= '<td rowspan="4">Necesitas contar con la información de meses de ejecución para darle seguimiento a este proyecto.</td>';
					}
                    $valida = $this->seguimiento_model->getPreviousWeight($row->meta_id);
                    if($valida->peso == '0'){
                        $tabla .= '<td rowspan="4">Necesitas agregar peso a tu meta complementaria para darle seguimiento</td>';
                    }
					if(!$seguimientoHabilitado){
						$tabla .= '<td rowspan="4">Por el momento no hay un mes configurado al que puedas dar seguimiento.</td>';
					}
					if($mesesEjecuta && $valida->peso != '0' && $seguimientoHabilitado){
                        $tabla .= '
                            <td rowspan="4">
                                <button class="btn btn-primary" onclick="darSeguimientoPorcentajes('.$row->meta_id.')"><i class="fa fa-fw fa-plus"></i></button>
                            </td>
                        ';
                    }
                    $tabla .= '</tr>';
                    $tabla .= '
                    <tr>
                        <td>Atendidos</td>';
                    $glon = $this->seguimiento_model->getMesesMetasResueltos($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    $totalr = 0;
                    if($glon){
                        foreach($glon as $mmr){
                            $tabla .= '<td class="text-center">'.$mmr->numero.'</td>';
                            $totalr += $mmr->numero;
                        }
                        $tabla .= '
                            <td class="text-center">'.$totalr.'</td>
                            <td></td>';
                    }
                    $tabla .= '</tr>';
                    $tabla .= '
                    <tr>
                        <td>Recibidos</td>';
                        $ren = $this->seguimiento_model->getMesesMetasAlcanzadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                        $nx = 'No existe explicación del avance físico para este mes para este mes';
                        if($ren){
                            $i = 0;
                            $j = 1;
                            foreach($ren as $metaa){
                                // $tool = $metaa->explicacion!=null?$metaa->explicacion:$nx;
								$tool = $metaa->explicacion!=null ? 'Dar click para ver explicación.' : $nx;
                                $tabla .= '<td class="text-center" data-toggle="tooltip" data-placement="top" title="'.$tool.'" onclick="showDescription('.$row->meta_id.','.$j.')">'.$metaa->numero.'</td>';
                                $totalp += $metaa->porcentaje;
                                $totalmc += $metaa->numero;
                                $i++;
                                $j++;
                            }
                            $tabla .= '
                        <td class="text-center">'.$totalmc.'</td>
                        <td class="text-center">'.round($totalp/$i, 2) .'%</td>
                    </tr>';
                    $tabla .='<tr>
                        <td>% Avance</td>';
                        foreach($ren as $metaa){
                            $tabla .= '<td class="text-center">'.$metaa->porcentaje.'</td>';
                        }
                    }
                    $tabla .='</tr>';
                }

            }

        } else {
            $tabla .= '<td colspan="18" class="text-center">No hay datos</td>';
        }
        return $tabla;
    }

    /**
     * Función para regresar una tabla con metas principales
     * @param $id_pry
     * @return string
     */
    private function _tablamp($id_pry)
    {
        $res = $this->seguimiento_model->getMetas($id_pry, 'principal');
        $ultimo = $this->seguimiento_model->getMesesMax($this->session->userdata('ejercicio'));
		$mesHabilitado = $ultimo->mes_id ? $ultimo->mes_id : date('n');
        $tabla = '';
        if ($res) {
            foreach ($res as $row) {
                $totalmpp = 0;
                $totalmc = 0;
                $tabla .= '
                <tr>
                <td rowspan="2">' . $row->mnombre . '</td>
                <td rowspan="2">' . $row->umnombre . '</td>
                <td>Programada</td>';
                $ren = $this->seguimiento_model->getMesesMetasProgramadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                $i = 0;
                foreach($ren as $metap){
                    $tabla .= '<td class="text-center">'.$metap->numero.'</td>';
                    $totalmpp += $metap->numero;
                    $i++;
                }
                $tabla .= '<td class="text-center">'.$totalmpp.'</td>';
                $tabla .= '<td class="text-center">'.round(($i*100/12),2).'</td>
                </tr>
                <tr>
                <td>Alcanzada</td>';
                $ren = $this->seguimiento_model->getMesesMetasAlcanzadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                if($ren){
                    $i = 1;
                    $totalpr = 0;
                    foreach($ren as $metaa){
                        $tabla .= '<td class="text-center"><button class="btn btn-outline" style="cursor: pointer" onclick="verDetallesGenerales('.$id_pry.','.$i.')">'.$metaa->porcentaje_real.'</button></td>';
                        $totalmc += $metaa->porcentaje_real;
                        $totalpr += $metaa->porcentaje_real;
                        $i++;
                    }
                    $ttpr = $totalpr / ($i-1);
                    $tabla .= '<td class="text-center">'.$totalmc.'</td>';
                    $tabla .= '<td class="text-center">'.round($ttpr, 2).'</td>
                    </tr>';
                } else {
                    $tabla .= '<td colspan="12" class="text-center">No hay datos</td>';
                }
            }
        } else {
            $tabla .= '<td colspan="16" class="text-center">No existe información</td>';
        }
        return $tabla;
    }

    /**
     * Función para poblar la tabla de Meta Principal
     * en este caso la Meta Principal no tiene metas complementarias
     * @param $id_pry
     * @return string
     */
    private function _tablamps($id_pry)
    {
        $res = $this->seguimiento_model->getMetas($id_pry, 'principal');
        $tabla = '';
        if ($res) {
            $ultimo = $this->seguimiento_model->getMesesMax($this->session->userdata('ejercicio'));
			$mesHabilitado = $ultimo->mes_id ? $ultimo->mes_id : date('n');
			$seguimientoHabilitado = $ultimo->mes_id ? true : false;
            foreach ($res as $row) {
                $totalmpp = 0;
                $totalmc = 0;
                $totalp = 0;
                $totalmp = 0;
                if($row->umtipo == '1'){
                    $tabla .= '
                    <tr>
                        <td rowspan="4">' . $row->mnombre . '</td>
                        <td rowspan="4">' . $row->umnombre . '</td>
                        <td rowspan="4" class="text-center">'.$row->peso.'%</td>
                        <td>Programada</td>';
                    $ren = $this->seguimiento_model->getMesesMetasProgramadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    foreach($ren as $metap){
                        $tabla .= '<td class="text-center">'.$metap->numero.'</td>';
                        $totalmp += $metap->numero;
                    }
                    $tabla .= '
                        <td class="text-center">'.$totalmp.'</td>
                        <td class="text-center">100%</td>';
					$mesesEjecuta = $this->seguimiento_model->getMesesEjecucion($id_pry);
					if(!$mesesEjecuta){
						$tabla .= '<td rowspan="4">Necesitas contar con la información de meses de ejecución para darle seguimiento a este proyecto.</td>';
					}
                    $valida = $this->seguimiento_model->getPreviousWeight($row->meta_id);
                    if($valida->peso == '0'){
                        $tabla .= '<td rowspan="4">Necesitas agregar peso a tu meta complementaria para darle seguimiento</td>';
                    }
					if(!$seguimientoHabilitado){
						$tabla .= '<td rowspan="4">Por el momento no hay un mes configurado al que puedas dar seguimiento.</td>';
					}
					if($mesesEjecuta && $valida->peso != '0' && $seguimientoHabilitado){
                        $tabla .= '
                            <td rowspan="4">
                                <button class="btn btn-primary" onclick="seguimientoPrincipalPorcentajes('.$row->meta_id.')"><i class="fa fa-fw fa-plus"></i></button>
                            </td>
                        ';
                    }
                    $tabla .= '</tr>';
                    $tabla .= '
                    <tr>
                        <td>Atendidos</td>';
                    $glon = $this->seguimiento_model->getMesesMetasResueltos($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    $totalr = 0;
                    if($glon){
                        foreach($glon as $mmr){
                            $tabla .= '<td class="text-center">'.$mmr->numero.'</td>';
                            $totalr += $mmr->numero;
                        }
                        $tabla .= '
                            <td class="text-center">'.$totalr.'</td>
                            <td></td>';
                    }
                    $tabla .= '</tr>';
                    $tabla .= '
                    <tr>
                        <td>Recibidos</td>';
                    $ren = $this->seguimiento_model->getMesesMetasAlcanzadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    $nx = 'No existe explicación del avance físico para este mes para este mes';
                    if($ren){
                        $i = 0;
                        foreach($ren as $metaa){
                            $tool = $metaa->explicacion!=null?$metaa->explicacion:$nx;
                            $tabla .= '<td class="text-center" data-toggle="tooltip" data-placement="top" title="'.$tool.'">'.$metaa->numero.'</td>';
                            $totalp += $metaa->porcentaje;
                            $totalmc += $metaa->numero;
                            $i++;
                        }
                        $tabla .= '
                        <td class="text-center">'.$totalmc.'</td>
                        <td class="text-center">'.round($totalp/$i, 2) .'%</td>
                    </tr>';
                        $tabla .='<tr>
                        <td>% Avance</td>';
                        foreach($ren as $metaa){
                            $tabla .= '<td class="text-center">'.$metaa->porcentaje.'</td>';
                        }
                    }
                    $tabla .='</tr>';
                } else {
                    $tabla .= '
                        <tr class="text-center">
                        <td rowspan="3">' . $row->mnombre . '</td>
                        <td rowspan="3">' . $row->umnombre . '</td>
                        <td>Programada</td>';
                    $ren = $this->seguimiento_model->getMesesMetasProgramadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    foreach($ren as $metap){
                        $tabla .= '<td>'.$metap->numero.'</td>';
                        $totalmpp += $metap->numero;
                    }
                    $tabla .= '<td>'.$totalmpp.'</td>';
                    // validación en caso de que no se pueda agregar un avance a la meta principal
                    $mesesEjecuta = $this->seguimiento_model->getMesesEjecucion($id_pry);
                    if($mesesEjecuta){
                        $tabla .= '<td><button class="btn btn-outline" onclick="seguimientoMetaPrincipal('.$row->meta_id.')"><i class="fa fa-edit"></i></button></td>';
                    } else {
                        $tabla .= '<td>Necesitas contar con la información de meses de ejecución para darle seguimiento a este proyecto.</td>';
                    }
                    $tabla .= '</tr>
                        <tr class="text-center">
                        <td>Alcanzada</td>';
                    $ren = $this->seguimiento_model->getMesesMetasAlcanzadas($row->meta_id, $this->session->userdata('ejercicio'), $mesHabilitado);
                    if($ren){
                        $i = 1;
                        foreach($ren as $metaa){
                            $tabla .= '<td><button class="btn btn-outline" style="cursor: pointer" onclick="verDetallesGenerales('.$id_pry.','.$i.')">'.$metaa->numero.'</button></td>';
                            $totalmc += $metaa->numero;
                            $i++;
                        }
                        $tabla .= '<td>'.$totalmc.'</td>
                        </tr>';
                        $tabla .= '<tr class="text-center">
                        <td>% Avance</td>';
                        foreach($ren as $metaa){
                            $tabla .= '<td class="text-center">'.$metaa->porcentaje.'</td>';
                        }
                    } else {
                        $tabla .= '<td colspan="12" class="text-center">No hay datos</td>';
                    }
                }
            }
        } else {
            $tabla .= '<td colspan="16" class="text-center">No existe información</td>';
        }
        return $tabla;
    }

    private function _valida_numero($id_pry = false, $meta = false, $mes = false, $alcanzada = false, $resueltos = false)
    {
        if($resueltos){
            if($alcanzada < $resueltos){
                $this->session->set_userdata('mensaje', message_session('msg_error_goal'));
                redirect('inicio/seguimiento/metaComplementaria/'.$meta.'/'.$id_pry, 'refresh');
            } else {
                return true;
            }
        } else {
            $programado = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($meta, $mes);
            if($programado < $alcanzada){
                $this->session->set_userdata('mensaje_password', message_session('msg_error_field_update'));
                redirect('inicio/seguimiento/metaComplementaria/'.$meta.'/'.$id_pry, 'refresh');
            } else {
                return true;
            }
        }
    }

    public function putSeguimientoNormal()
    {
        $id_meta = $this->input->post('meta');
        $id_pry = $this->input->post('proyecto');
        $programado = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes'));
        if($programado->numero < $this->input->post('numero')){
            echo '422';
        } else {
            // obtener peso de la meta complementaria
            $apm = $this->seguimiento_model->getMetaPeso($id_meta);

            // obtener numero de meses de ejecución
            $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

            // avance esperado por mes de la meta complementaria
            $apmc = $apm->peso / $me;

            // obtener valor de la meta complementaria programada en el mes correspondiente
            $vpmc = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes'));

            // operación para obtener el porcentaje de avance real de la meta complementaria en cuestión
            $aomc = ($this->input->post('numero')*$apm->peso) / $vpmc->numero;

            $pesost = [];
            $tmc = $this->seguimiento_model->getMetasComplementariasPesos($id_pry);
            foreach($tmc as $row){
                $tot1 = $row->peso / $me;
                array_push($pesost, $tot1);
            }
            $tpc = 0; // total de pesos por metas complementarias
            for($i = 0; $i < count($pesost); $i++){
                $tpc += $pesost[$i];
            }

            $apa =  ($this->input->post('numero') * 100) / $programado->numero;

            /**
             * Avance Meta Complementaria
             */
            $datos = array(
                'meta_id'           => $id_meta,
                'mes_id'            => $this->input->post('mes'),
                'numero'            => $this->input->post('numero'),
                'explicacion'       => $this->input->post('explicacion'),
                'porcentaje'        => round($apa,2),
                'porcentaje_real'   => round($aomc,2)
            );
            $where = array(
                'meta_id' => $id_meta,
                'mes_id'  => $this->input->post('mes')
            );
            // $res = $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
            $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
            /**
             * Avance Meta Principal
             */
            // recalcular avances de meta principal sin incluir el nuevo mes
            $navc = $this->seguimiento_model->getAvancesMP($id_pry, $this->input->post('mes'), $id_meta);
            // obtener avance de meta principal
            $amp = $this->seguimiento_model->getAvanceMetaPrincipal($id_pry, $this->input->post('mes'));

            // sumar avance meta principal en el mes correspondiente con el nuevo dato
            $na = ($aomc*100) / $tpc;
            // $val = $amp->numero + $na;
            $val = $navc->porcentaje_real + $aomc;
            $datos = array(
                'porcentaje_real'   => $val,
                'explicacion'       => ''
            );
            $where = array(
                'meta_id'       => $amp->meta_id,
                'mes_id'        => $this->input->post('mes')
            );
            $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
            echo true;
        }
    }

    public function putSeguimientoPorcentaje()
    {
        $id_meta = $this->input->post('meta');
        $id_pry = $this->input->post('proyecto');
        // obtener peso de la meta complementaria
        $apm = $this->seguimiento_model->getMetaPeso($id_meta);

        // obtener numero de meses de ejecución
        $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

        // avance esperado por mes de la meta complementaria
        $apmc = $apm->peso / $me;

        if($this->input->post('numero') == '0'){

            $datos = $datos = array(
                'numero' => $this->input->post('numero'),
                'explicacion' => $this->input->post('explicacion'),
                'porcentaje' => 100,
                'porcentaje_real'  => round($apm->peso,2)
            );
            $where = array(
                'meta_id' => $id_meta,
                'mes_id' => $this->input->post('mes')
            );
            $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
            $datos = array(
                'numero' => 0,
            );
            $where = array(
                'meta_id' => $id_meta,
                'mes_id' => $this->input->post('mes')
            );
            $this->general->actualizaBase('meses_metas_complementarias_resueltos', $datos, $where);

            /**
             * Avance Meta Principal
             */
            // recalcular avances de meta principal sin incluir el nuevo mes
            $navc = $this->seguimiento_model->getAvancesMP($id_pry, $this->input->post('mes'), $id_meta);
            // obtener avance de meta principal
            $amp = $this->seguimiento_model->getAvanceMetaPrincipal($id_pry, $this->input->post('mes'));

            $val = $navc->porcentaje_real + $apm->peso;
            $datos = array(
                'numero'            => $val,
                'explicacion'       => '',
                'porcentaje'        => round($val, 2),
                'porcentaje_real'   => round($val, 2)
            );
            $where = array(
                'meta_id'       => $amp->meta_id,
                'mes_id'        => $this->input->post('mes')
            );
            $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
            echo true;
        } else {
            if($this->input->post('numero') < $this->input->post('resueltos')){
                echo '422';
            } else {
                // obtener avance entre recibido y resuelto
                $avrr = ($this->input->post('resueltos')*100) / $this->input->post('numero');

                // obtener valor de la meta complementaria programada en el mes correspondiente
                $vpmc = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes'));

                // operación para obtener el porcentaje de avance real de la meta complementaria en cuestión
                $aomc = ($this->input->post('resueltos') * $apm->peso) / $this->input->post('numero');

                $pesost = [];
                $tmc = $this->seguimiento_model->getMetasComplementariasPesos($id_pry);
                foreach ($tmc as $row) {
                    $tot1 = $row->peso / $me;
                    array_push($pesost, $tot1);
                }
                $tpc = 0; // total de pesos por metas complementarias
                for ($i = 0; $i < count($pesost); $i++) {
                    $tpc += $pesost[$i];
                }

                // $apa = ($this->input->post('numero') * 100) / $programado->numero;
                $this->_valida_numero($id_pry, $id_meta, $this->input->post('mes'), $this->input->post('numero'), $this->input->post('resueltos'));
                // $existencia = $this->_existencia($id_meta, $this->input->post('mes'));
                $datos = array(
                    'numero' => $this->input->post('numero'),
                    'explicacion' => $this->input->post('explicacion'),
                    'porcentaje'  => round($avrr, 2),
                    'porcentaje_real'  => round($aomc,2)
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id' => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                $datos = array(
                    'mes_id' => $this->input->post('mes'),
                    'numero' => $this->input->post('resueltos')
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id' => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_complementarias_resueltos', $datos, $where);
                /**
                 * Avance Meta Principal
                 */
                // recalcular avances de meta principal sin incluir el nuevo mes
                $navc = $this->seguimiento_model->getAvancesMP($id_pry, $this->input->post('mes'), $id_meta);
                // obtener avance de meta principal
                $amp = $this->seguimiento_model->getAvanceMetaPrincipal($id_pry, $this->input->post('mes'));

                // sumar avance meta principal en el mes correspondiente con el nuevo dato
                $na = ($aomc*100) / $tpc;
                // $val = $amp->numero + $na;
                $val = $navc->porcentaje_real + $aomc;
                $datos = array(
                    'numero'        => $val,
                    'explicacion'   => '',
                    'porcentaje'        => round($val, 2),
                    'porcentaje_real'   => round($val, 2)
                );
                $where = array(
                    'meta_id'       => $amp->meta_id,
                    'mes_id'        => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                echo true;
            }
        }
    }

    /**
     * Función para cargar la vista de las metas complementarias
     * en este caso la Meta Complementaria tiene como unidad de medida algo diferente a porcentajes
     * @param bool $id_meta
     * @param bool $id_pry
     */
    public function metaComplementaria($id_meta = false, $id_pry = false)
    {
        $data = array();

        // Reviso si hay mensajes y los mando a las variables de la vista
        if ($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }


        if ($this->input->post('numero')) {
            $programado = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes_id'));
            if($programado->numero < $this->input->post('numero')){
                $this->session->set_userdata('mensaje', message_session('msg_error_goal'));
                redirect('inicio/seguimiento/metaComplementaria/'.$id_meta.'/'.$id_pry, 'refresh');
            } else {
                // obtener peso de la meta complementaria
                $apm = $this->seguimiento_model->getMetaPeso($id_meta);

                // obtener numero de meses de ejecución
                $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

                // avance esperado por mes de la meta complementaria
                $apmc = $apm->peso / $me;

                // obtener valor de la meta complementaria programada en el mes correspondiente
                $vpmc = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes_id'));

                // operación para obtener el porcentaje de avance real de la meta complementaria en cuestión
                $aomc = ($this->input->post('numero')*$apmc) / $vpmc->numero;

                $pesost = [];
                $tmc = $this->seguimiento_model->getMetasComplementariasPesos($id_pry);
                foreach($tmc as $row){
                    $tot1 = $row->peso / $me;
                    array_push($pesost, $tot1);
                }
                $tpc = 0; // total de pesos por metas complementarias
                for($i = 0; $i < count($pesost); $i++){
                    $tpc += $pesost[$i];
                }

                $apa =  ($this->input->post('numero') * 100) / $programado->numero;

                /**
                 * Avance Meta Complementaria
                 */
                $datos = array(
                    'meta_id'           => $id_meta,
                    'mes_id'            => $this->input->post('mes_id'),
                    'numero'            => $this->input->post('numero'),
                    'explicacion'       => $this->input->post('explicacion'),
                    'porcentaje'        => round($apa,2),
                    'porcentaje_real'   => round($aomc,2)
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id'  => $this->input->post('mes_id')
                );
                $res = $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);

                if($res){
                    /**
                     * Avance Meta Principal
                     */
                    // recalcular avances de meta principal sin incluir el nuevo mes
                    $navc = $this->seguimiento_model->getAvancesMP($id_pry, $this->input->post('mes_id'));
                    // obtener avance de meta principal
                    $amp = $this->seguimiento_model->getAvanceMetaPrincipal($id_pry, $this->input->post('mes_id'));

                    // sumar avance meta principal en el mes correspondiente con el nuevo dato
                    $na = ($aomc*100) / $tpc;
                    // $val = $amp->numero + $na;
                    $val = $navc->porcentaje_real + $na;
                    $datos = array(
                        'meta_id'       => $amp->meta_id,
                        'mes_id'        => $this->input->post('mes_id'),
                        'numero'        => $val,
                        'explicacion'   => ''
                    );
                    $where = array(
                        'meta_id'       => $amp->meta_id,
                        'mes_id'        => $this->input->post('mes_id')
                    );
                    $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                    $this->session->set_userdata('mensaje', message_session('msg_register_field'));
                    redirect('inicio/seguimiento/seguimiento/'.$id_pry, 'refresh');
                }
            }
        }

        //cargo menu
        $data["menu"] = $this->load->view('home/home_menu', $data, TRUE);
        //cargo header
        $data["header"] = $this->load->view('home/home_header', $data, TRUE);
        //paso seccion
        $data["seccion"] = "Meta Complementaria";
        // meses para arreglo
        $data['meses'] = $this->_getMesesArray();

        /**
         * Validación de vista a mostrar dependiendo el tipo de medida
         */
        $tipo_medida = $this->seguimiento_model->getTipoMeta($id_meta);
        if($tipo_medida->nombre !== 'porcentajes'){
            $data["main"] = $this->load->view('seguimiento/meta_complementaria', $data, TRUE);
        } else {
            $data["main"] = $this->load->view('seguimiento/meta_complementaria_p', $data, TRUE);
        }

        //paso confirmacion de salir
        $data["salir"] = $this->load->view('home/home_salir', $data, TRUE);
        //cargo vista general
        $this->load->view('layout_general', $data);

    }

    private function _existencia($meta, $mes)
    {
        $where = array(
            'meta_id' => $meta,
            'mes_id'  => $mes
        );
        $res = $this->proyectos_model->verificaExistencia($where);
        if($res){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Función para cargar la vista de Metas Complementarias
     * en este caso la unidad de medida es Porcentajes
     * @param bool $id_meta
     * @param bool $id_pry
     */
    public function metaComplementariaP($id_meta = false, $id_pry = false)
    {
        $data = array();

        // Reviso si hay mensajes y los mando a las variables de la vista
        if ($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }


        if($this->input->post('explicacion')){
            // obtener peso de la meta complementaria
            $apm = $this->seguimiento_model->getMetaPeso($id_meta);

            // obtener numero de meses de ejecución
            $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

            // avance esperado por mes de la meta complementaria
            $apmc = $apm->peso / $me;
            if($this->input->post('numero') == '0'){

                $datos = $datos = array(
                    'meta_id' => $id_meta,
                    'mes_id' => $this->input->post('mes_id'),
                    'numero' => $this->input->post('numero'),
                    'explicacion' => $this->input->post('explicacion'),
                    'porcentaje'  => round($apmc,2)
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id' => $this->input->post('mes_id')
                );
                $res = $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                if ($res) {
                    $datos = array(
                        'meta_id' => $id_meta,
                        'mes_id' => $this->input->post('mes_id'),
                        'numero' => 0,
                    );
                    $where = array(
                        'meta_id' => $id_meta,
                        'mes_id' => $this->input->post('mes_id')
                    );
                    $this->general->actualizaBase('meses_metas_complementarias_resueltos', $datos, $where);
                    $this->session->set_userdata('mensaje', message_session('msg_register_field'));
                    redirect('inicio/seguimiento/seguimiento/'.$id_pry, 'refresh');
                }
            } else {
                if($this->input->post('numero') < $this->input->post('numero_resueltos')){
                    $this->session->set_userdata('mensaje', message_session('msg_error_goal'));
                    redirect('inicio/seguimiento/metaComplementariaP/'.$id_meta.'/'.$id_pry, 'refresh');
                } else {
                    /* obtener peso de la meta complementaria
                    $apm = $this->seguimiento_model->getMetaPeso($id_meta);

                    // obtener numero de meses de ejecución
                    $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

                    // avance esperado por mes de la meta complementaria
                    $apmc = $apm->peso / $me; */

                    // obtener avance entre recibido y resuelto
                    $avrr = ($this->input->post('numero_resueltos')*100) / $this->input->post('numero');

                    // obtener valor de la meta complementaria programada en el mes correspondiente
                    $vpmc = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes_id'));

                    // operación para obtener el porcentaje de avance real de la meta complementaria en cuestión
                    $aomc = ($this->input->post('numero_resueltos') * $apmc) / $this->input->post('numero');

                    $pesost = [];
                    $tmc = $this->seguimiento_model->getMetasComplementariasPesos($id_pry);
                    foreach ($tmc as $row) {
                        $tot1 = $row->peso / $me;
                        array_push($pesost, $tot1);
                    }
                    $tpc = 0; // total de pesos por metas complementarias
                    for ($i = 0; $i < count($pesost); $i++) {
                        $tpc += $pesost[$i];
                    }

                    // $apa = ($this->input->post('numero') * 100) / $programado->numero;
                    $this->_valida_numero($id_pry, $id_meta, $this->input->post('mes_id'), $this->input->post('numero'), $this->input->post('numero_resueltos'));
                    $existencia = $this->_existencia($id_meta, $this->input->post('mes_id'));
                    if($existencia){
                        $datos = array(
                            'meta_id' => $id_meta,
                            'mes_id' => $this->input->post('mes_id'),
                            'numero' => $this->input->post('numero'),
                            'explicacion' => $this->input->post('explicacion'),
                            'porcentaje'  => round($avrr, 2),
                            'porcentaje_real'  => round($aomc,2)
                        );
                        $where = array(
                            'meta_id' => $id_meta,
                            'mes_id' => $this->input->post('mes_id')
                        );
                        $res = $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                        if ($res) {
                            $datos = array(
                                'meta_id' => $id_meta,
                                'mes_id' => $this->input->post('mes_id'),
                                'numero' => $this->input->post('numero_resueltos')
                            );
                            $where = array(
                                'meta_id' => $id_meta,
                                'mes_id' => $this->input->post('mes_id')
                            );
                            $res = $this->general->actualizaBase('meses_metas_complementarias_resueltos', $datos, $where);
                            if($res){
                                $this->session->set_userdata('mensaje', message_session('msg_register_field'));
                                redirect('inicio/seguimiento/seguimiento/'.$id_pry, 'refresh');
                            }
                        }
                    } else {
                        $datos = array(
                            'meta_id' => $id_meta,
                            'mes_id' => $this->input->post('mes_id'),
                            'numero' => $this->input->post('numero'),
                            'explicacion' => $this->input->post('explicacion'),
                            'porcentaje'  => round($aomc,2)
                        );
                        $res = $this->general->insertaBase('meses_metas_alcanzadas', $datos);
                        if ($res) {
                            $datos = array(
                                'meta_id' => $id_meta,
                                'mes_id' => $this->input->post('mes_id'),
                                'numero' => $this->input->post('numero_resueltos')
                            );
                            $where = array(
                                'meta_id' => $id_meta,
                                'mes_id' => $this->input->post('mes_id')
                            );
                            $res = $this->general->actualizaBase('meses_metas_complementarias_resueltos', $datos, $where);
                            if($res){
                                $this->session->set_userdata('mensaje', message_session('msg_register_field'));
                                redirect('inicio/seguimiento/seguimiento/'.$id_pry, 'refresh');
                            }
                        }
                    }
                }
            }
        }

        //cargo menu
        $data["menu"] = $this->load->view('home/home_menu', $data, TRUE);
        //cargo header
        $data["header"] = $this->load->view('home/home_header', $data, TRUE);
        //paso seccion
        $data["seccion"] = "Meta Complementaria";
        // meses para arreglo
        $data['meses'] = $this->_getMesesArray();

        /**
         * Validación de vista a mostrar dependiendo el tipo de medida
         */
        $tipo_medida = $this->seguimiento_model->getTipoMeta($id_meta);
        $data["main"] = $this->load->view('seguimiento/meta_complementaria_p', $data, TRUE);

        $data['js'] = 'seguimiento/captura.js';

        //paso confirmacion de salir
        $data["salir"] = $this->load->view('home/home_salir', $data, TRUE);
        //cargo vista general
        $this->load->view('layout_general', $data);

    }


    public function obtenerPrincipal($id_pry)
    {
        $res = $this->seguimiento_model->getInfoMetaPrincipal($id_pry);
        if($res){
            $data = [];
            foreach($res as $row){
                $data['data'][] = (int)$row->numero;
            }
            echo json_encode($data);
        }
    }

    public function obtenerPesos($id_pry){
        $res = $this->seguimiento_model->getPesos($id_pry);
        if($res){
            $i = 0;
            foreach($res as $row){
                $data[$i++] = array(
                    'name'  => $row->nombre,
                    'value' => (int)$row->peso
                );
            }
            echo json_encode($data);
        }
    }

    public function obtenerAvances($id_pry){
        $res = $this->seguimiento_model->getMetasComplementarias($id_pry);
        if($res){
            $data = [];
            $datos = [];
            foreach ($res as $row){
                $i = 0;
                $data['name'][] = substr($row->nombre, 0, 50);
                $ren = $this->seguimiento_model->getAvancesMetasComplementarias($row->meta_id);
                foreach($ren as $metap){
                    $datos[$i] = $metap->numero;
                    $i++;
                }
                $data['datos'][] = $datos;
            }
            echo json_encode($data);
        }
    }

    public function graficas($id_pry = false)
    {
        $data = array();
        // menu
        $data["menu"] = $this->load->view('home/home_menu', $data, TRUE);
        // header
        $data["header"] = $this->load->view('home/home_header', $data, TRUE);
        // seccion
        $data["seccion"] = "Gráficas";
        // js
        $data['js'] = 'seguimiento/graficas.js';
        // vista
        $data["main"] = $this->load->view('seguimiento/graficas', $data, TRUE);
        //paso confirmacion de salir
        $data["salir"] = $this->load->view('home/home_salir', $data, TRUE);
        //cargo vista general
        $this->load->view('layout_general', $data);
    }

    public function getDescripciones($proyecto, $mes)
    {
        $res = $this->seguimiento_model->getDescriptions($proyecto, $mes);
        if($res){
            foreach ($res as $row){
                $data['detalles'][] = $row->explicacion;
            }
            echo json_encode($data);
        }
    }

    public function getMesesHabilitados()
    {
        // $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->seguimiento_model->getMesesHabilitados($this->session->userdata('ejercicio'));
        if($res){
            foreach($res as $row){
                $data['mes'][] = $row->mes_id;
                $data['nombre'][] = $row->nombre;
            }
            echo json_encode($data);
        } else {
			$mesActual = date('n');
			$meses = $this->seguimiento_model->getMesesHabilitadosNoConfigurados($mesActual);
			foreach($meses as $mes){
				$data['mes'][] = $mes->mes_id;
				$data['nombre'][] = $mes->nombre;
			}
			echo json_encode($data);
		}
    }

    public function getMesesTrimestrales()
    {
        $ejercicio = $this->home_inicio->get_ejercicio();
        $mes_max = $this->seguimiento_model->getMesesMax($ejercicio->ejercicio_id);
        $mes_actual = $mes_max->mes_id;
        if($mes_actual == '01' || $mes_actual == '02' || $mes_actual == '03'){
            $data['mes'][] = 'Ene - Mar';
            $data['valor'][] = '1';
        } else if($mes_actual == '04' || $mes_actual == '05' || $mes_actual == '06'){
            $data['mes'][] = 'Ene - Mar';
            $data['valor'][] = '1';
            $data['mes'][] = 'Abr - Jun';
            $data['valor'][] = '2';
        } else if($mes_actual == '07' || $mes_actual == '08' || $mes_actual == '09'){
            $data['mes'][] = 'Ene - Mar';
            $data['valor'][] = '1';
            $data['mes'][] = 'Abr - Jun';
            $data['valor'][] = '2';
            $data['mes'][] = 'Jul - Sep';
            $data['valor'][] = '3';
        } else {
            $data['mes'][] = 'Ene - Mar';
            $data['valor'][] = '1';
            $data['mes'][] = 'Abr - Jun';
            $data['valor'][] = '2';
            $data['mes'][] = 'Jul - Sep';
            $data['valor'][] = '3';
            $data['mes'][] = 'Oct - Dic';
            $data['valor'][] = '4';
        }
        echo json_encode($data);
    }

    /**
     * Función para desplegar la información correspondiente al avance del proyecto cuando es por mes
     */
    public function getMesDetalles()
    {
        $mes = $this->seguimiento_model->getNombreMes($this->input->post('mes'));
        $proyecto = $this->input->post('proyecto');
        $res = $this->seguimiento_model->getMetaPrincipalAvance($this->input->post('mes'), $proyecto);
        $tabla = '';
        $tabla .= '
            <div class="row mt-5">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <a class="btn btn-success float-right" href="'.base_url('inicio/seguimiento_excel/mensual/'.$proyecto.'/'.$this->input->post('mes')).'"><i class="fa fa-fw fa-file-excel"></i> Excel</a>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#principal">Meta Principal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#complementaria">Meta Complementaria</a>
                </li>
            </ul>
            <div class="tab-content clearfix">
                    <div class="tab-pane active" id="principal">
        ';
        $tabla .= '
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                <tr>
                    <th rowspan="2">Denominación de la meta</th>
                    <th rowspan="2">Unidad de medida</th>
                    <th colspan="3">'.ucfirst($mes->nombre).'</th>
                    <th colspan="3">Acumulado Enero - '.ucfirst($mes->nombre).'</th>
                </tr>
                <tr>
                    <th>Programada</th>
                    <th>Alcanzada</th>
                    <th>Avance %</th>
                    <th>Programada</th>
                    <th>Alcanzada</th>
                    <th>Avance %</th>
                </tr>
                </thead>
                <tbody>';
        $tabla .= '
        <tr>
            <td>'.$res->nombre.'</td>
            <td>'.$res->umnom.'</td>';
        $row = $this->seguimiento_model->getAvanceMesProgramado($this->input->post('mes'), $res->meta_id);
        $tabla .= '
            <td>'.$row->numero.'</td>';
        $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($this->input->post('mes'), $res->meta_id);
        $tabla .= '
            <td>'.$row1->numero.'</td>
            <td>'.$row1->porcentaje.'</td>';
        // calcular acumulado
        $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($this->input->post('mes'), $res->meta_id);
        $tabla .= '
            <td>'.$acumuladop->numero.'</td>';
        $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($this->input->post('mes'), $res->meta_id);
        $tabla .= '<td>'.$acumuladoa->numero.'</td>';
        $pacm = $this->seguimiento_model->getPorcentajeAcumulado($res->meta_id, $this->input->post('mes'));
        $tabla .= '<td>'.$pacm->porcentaje.'</td>
        </tr>';
        $tabla .= '</tbody>
            </table>
            </div>
        ';
        $tabla .= '
        <div class="row mt-4">
            <div class="col-md-12">
                <h6>Explicación del avance físico</h6>
            </div>
            <div class="col-md-12">';
        $nombreMes = $this->seguimiento_model->getNombreMes($this->input->post('mes'));
        $tabla .= '<p><b>'.ucfirst($nombreMes->nombre).'</b></p>';
        $metascom = $this->seguimiento_model->getMetasComplementarias($proyecto);
        $exp = '';
        $tabla .= '<ul>';
        foreach($metascom as $metac) {
            $explicaciones = $this->seguimiento_model->getExplicacionesMP($this->input->post('mes'), $metac->meta_id);
            foreach($explicaciones as $explicacion){
                if($explicacion->explicacion != '') {
                    $exp.= '<li>'.$explicacion->explicacion.'</li>';
                } else {
                    $exp.= '<li>No existe comentario</li>';
                }
            }
        }
        $tabla .= $exp;
        $tabla .= '</ul></div></div></div>';
        $complementarias = $this->seguimiento_model->getMetasComplementariasAvance($this->input->post('mes'), $proyecto);
        $tabla .= '<div class="tab-pane" id="complementaria">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                <tr>
                                    <th rowspan="2">Denominación de la meta</th>
                                    <th rowspan="2">Unidad de medida</th>
                                    <th colspan="3">'.ucfirst($mes->nombre).'</th>
                                    <th colspan="3">Acumulado Enero - '.ucfirst($mes->nombre).'</th>
                                </tr>
                                <tr>
                                    <th>Programada</th>
                                    <th>Alcanzada</th>
                                    <th>Avance %</th>
                                    <th>Programada</th>
                                    <th>Alcanzada</th>
                                    <th>Avance %</th>
                                </tr>
                                </thead>';
        $tabla .= '<tbody>';
        $i = 1;
        foreach ($complementarias as $complementaria){
            $tabla .= '<tr>
                <td>'.$complementaria->nombre.'('.$i.')</td>
                <td>'.$complementaria->umnom.'</td>
            ';
            $row = $this->seguimiento_model->getAvanceMesProgramado($this->input->post('mes'), $complementaria->meta_id);
            $tabla .= '
            <td>'.$row->numero.'</td>';
            $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($this->input->post('mes'), $complementaria->meta_id);
            $tabla .= '
            <td>'.$row1->numero.'</td>
            <td>'.$row1->porcentaje.'</td>';
            // calcular acumulado
            $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($this->input->post('mes'), $complementaria->meta_id);
            $tabla .= '
            <td>'.$acumuladop->numero.'</td>';
            $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($this->input->post('mes'), $complementaria->meta_id);
            $tabla .= '
            <td>'.$acumuladoa->numero.'</td>';
            $pacm = $this->seguimiento_model->getPorcentajeAcumulado($complementaria->meta_id, $this->input->post('mes'));
            $tabla .= '<td>'.$pacm->porcentaje.'</td>
        </tr>';
            $i++;
        }
        $tabla .= '</tbody>';
        $tabla .= '
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h6>Explicación del Avance Físico</h6>
                    </div>
                    <div class="col-md-12">';
        $nombreMes = $this->seguimiento_model->getNombreMes($this->input->post('mes'));
        $tabla .= '<p><b>'.ucfirst($nombreMes->nombre).'</b></p>';
        $metascom = $this->seguimiento_model->getMetasComplementarias($proyecto);
        $exp = '';
        $tabla .= '<ol>';
        foreach($metascom as $metac) {
            $explicaciones = $this->seguimiento_model->getExplicacionesMP($this->input->post('mes'), $metac->meta_id);
            foreach($explicaciones as $explicacion){
                if($explicacion->explicacion != '') {
                    $exp.= '<li>'.$explicacion->explicacion.'</li>';
                } else {
                    $exp.= '<li>No existe comentario</li>';
                }
            }
        }
        $tabla .= $exp;
        $tabla .= '</ol></div>
                </div>
        </div>';
        echo $tabla;
    }

    /**
     * Función para desplegar la información del avance trimestral en los proyectos
     */
    public function getTrimestralDetalles()
    {
        if($this->input->post('mes') == '1'){
            $mes = 3;
            $mnombre = 'Enero - Marzo';
        } else if($this->input->post('mes') == '2'){
            $mes = 6;
            $mnombre = 'Abril - Junio';
        } else if($this->input->post('mes') == '3'){
            $mes = 9;
            $mnombre = 'Julio - Septiembre';
        } else if($this->input->post('mes') == '4'){
            $mes = 12;
            $mnombre = 'Octubre - Diciembre';
        }
        $proyecto = $this->input->post('proyecto');
        $res = $this->seguimiento_model->getMetaPrincipalAvance($mes, $proyecto);
        $tabla = '';
        $tabla .= '
            <div class="row mt-5">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <a class="btn btn-success float-right" href="'.base_url('inicio/seguimiento_excel/trimestral/'.$proyecto.'/'.$mes).'"><i class="fa fa-fw fa-file-excel"></i> Excel</a>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#principal">Meta Principal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#complementaria">Meta Complementaria</a>
                </li>
            </ul>
            <div class="tab-content clearfix">
                    <div class="tab-pane active" id="principal">
        ';
        $tabla .= '
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                <tr>
                    <th rowspan="2">Denominación de la meta</th>
                    <th rowspan="2">Unidad de medida</th>
                    <th colspan="3">'.ucfirst($mnombre).'</th>
                    <th colspan="3">Acumulado</th>
                </tr>
                <tr>
                    <th>Programada</th>
                    <th>Alcanzada</th>
                    <th>Avance %</th>
                    <th>Programada</th>
                    <th>Alcanzada</th>
                    <th>Avance %</th>
                </tr>
                </thead>
                <tbody>';
        $tabla .= '
        <tr>
            <td>'.$res->nombre.'</td>
            <td>'.$res->umnom.'</td>';
        $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $res->meta_id);
        $tabla .= '
            <td>'.$row->numero.'</td>';
        $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $res->meta_id);
        $tabla .= '
            <td>'.$row1->numero.'</td>
            <td>'.$row1->porcentaje.'</td>';
        // calcular acumulado
        $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $res->meta_id);
        $tabla .= '
            <td>'.$acumuladop->numero.'</td>';
        $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $res->meta_id);
        $tabla .= '<td>'.$acumuladoa->numero.'</td>';
        $pacm = $this->seguimiento_model->getPorcentajeAcumulado($res->meta_id, $mes);
        $tabla .= '<td>'.$pacm->porcentaje_real.'</td>
        </tr>';
        $tabla .= '</tbody>
            </table>
            </div>
        ';
        $tabla .= '
        <div class="row mt-4">
            <div class="col-md-12">
                <h6>Explicación del avance físico</h6>
            </div>
            <div class="col-md-12">';
        $metascom = $this->seguimiento_model->getMetasComplementarias($proyecto);
        $meses = $this->seguimiento_model->getMesesHabilitadosAvance($mes);
        foreach($meses as $nmes) {
            $tabla .= '<p><b>'.ucfirst($nmes->nombre).'</b></p>';
            $tabla .= '<ul>';
            $exp = '';
            foreach ($metascom as $metac) {
                $explicaciones = $this->seguimiento_model->getExplicacionesMP($nmes->mes_id, $metac->meta_id);
                foreach($explicaciones as $explicacion){
                    if($explicacion->explicacion != ''){
                        $exp .= '<li>'.$explicacion->explicacion.'</li>';
                    } else {
                        $exp .= '<li>No existe comentario </li>';
                    }
                }
            }
            $tabla .= $exp;
            $tabla .= '</ul>';
        }
        $tabla .= '</div></div></div>';
        $complementarias = $this->seguimiento_model->getMetasComplementariasAvance($mes, $proyecto);
        $tabla .= '<div class="tab-pane" id="complementaria">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                <tr>
                                    <th rowspan="2">Denominación de la meta</th>
                                    <th rowspan="2">Unidad de medida</th>
                                    <th colspan="3">'.$mnombre.'</th>
                                    <th colspan="3">Acumulado</th>
                                </tr>
                                <tr>
                                    <th>Programada</th>
                                    <th>Alcanzada</th>
                                    <th>Avance %</th>
                                    <th>Programada</th>
                                    <th>Alcanzada</th>
                                    <th>Avance %</th>
                                </tr>
                                </thead>';
        $tabla .= '<tbody>';
        $i = 1;
        foreach ($complementarias as $complementaria){
            $tabla .= '<tr>
                <td>'.$complementaria->nombre.'('.$i.')</td>
                <td>'.$complementaria->umnom.'</td>
            ';
            $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $complementaria->meta_id);
            $tabla .= '
            <td>'.$row->numero.'</td>';
            $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $complementaria->meta_id);
            $tabla .= '
            <td>'.$row1->numero.'</td>
            <td>'.$row1->porcentaje.'</td>';
            // calcular acumulado
            $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $complementaria->meta_id);
            $tabla .= '
            <td>'.$acumuladop->numero.'</td>';
            $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $complementaria->meta_id);
            $tabla .= '
            <td>'.$acumuladoa->numero.'</td>';
            $pacm = $this->seguimiento_model->getPorcentajeAcumulado($complementaria->meta_id, $mes);
            $tabla .= '<td>'.$pacm->porcentaje_real.'</td>
        </tr>';
            $i++;
        }
        $tabla .= '</tbody>';
        $tabla .= '
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h6>Explicación del Avance Físico</h6>  
                    </div>
                    <div class="col-md-12">';
        $metascom = $this->seguimiento_model->getMetasComplementarias($proyecto);
        $meses = $this->seguimiento_model->getMesesHabilitadosAvance($mes);
        foreach($meses as $nmes) {
            $tabla .= '<p><b>'.ucfirst($nmes->nombre).'</b></p>';
            $tabla .= '<ol>';
            $exp = '';
            foreach ($metascom as $metac) {
                $explicaciones = $this->seguimiento_model->getExplicacionesMP($nmes->mes_id, $metac->meta_id);
                foreach($explicaciones as $explicacion){
                    if($explicacion->explicacion != ''){
                        $exp .= '<li>'.$explicacion->explicacion.'</li>';
                    } else {
                        $exp .= '<li>No existe comentario </li>';
                    }
                }
            }
            $tabla .= $exp;
            $tabla .= '</ol>';
        }
        $tabla .= '</div>
                </div>
            </div>
        </div>';
        echo $tabla;
    }

    private function _searchMetasComplementarias($proyecto)
    {
        $res = $this->seguimiento_model->searchMetasComplementarias($proyecto);
        if($res){
            if($res->tmc == '1'){
                return true;
            } else {
                return false;
            }
        }
    }

    public function getMetaPrincipalD($meta)
    {
        $res = $this->seguimiento_model->getInfoMetaPrincipalD($meta);
        if($res){
            // $data['tmc'][] = $res->tmc;
            echo json_encode($res->tmc);
        }
    }

    public function putSeguimiento()
    {
        $id_pry = $this->input->post('proyecto');
        $id_meta = $this->input->post('meta');
        if($this->input->post('numero_resueltos') != ''){
            $valida = $this->_valida_numero($id_pry, $id_meta, $this->input->post('mes_id'), $this->input->post('numero'), $this->input->post('resueltos'));
            if($valida){
                $datos = array(
                    'meta_id'       => $id_meta,
                    'mes_id'        => $this->input->post('mes_id'),
                    'numero'        => $this->input->post('numero'),
                    'explicacion'   => $this->input->post('explicacion')
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id'  => $this->input->post('mes_id')
                );
                $res = $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                if($res){
                    $datos = array(
                        'meta_id'       => $id_meta,
                        'mes_id'        => $this->input->post('mes_id'),
                        'numero'        => $this->input->post('numero_resueltos')
                    );
                    $where = array(
                        'meta_id' => $id_meta,
                        'mes_id'  => $this->input->post('mes_id')
                    );
                    $res = $this->general->actualizaBase('meses_metas_complementarias_resueltos', $datos, $where);
                    if($res){
                        echo true;
                    }
                }
            } else {
                echo '422';
            }
        } else if ($this->input->post('numero')) {
            $programado = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes_id'));
            if($programado->numero < $this->input->post('numero')){
                echo '420';
                /* $this->session->set_userdata('mensaje', message_session('msg_error_goal'));
                redirect('inicio/seguimiento/metaComplementaria/'.$id_meta.'/'.$id_pry, 'refresh'); */
            } else {
                // obtener peso de la meta complementaria
                $apm = $this->seguimiento_model->getMetaPeso($id_meta);

                // obtener numero de meses de ejecución
                $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

                // avance esperado por mes de la meta complementaria
                $apmc = $apm->peso / $me;

                // obtener valor de la meta complementaria programada en el mes correspondiente
                $vpmc = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes_id'));

                // operación para obtener el porcentaje de avance real de la meta complementaria en cuestión
                $aomc = ($this->input->post('numero')*$apmc) / $vpmc->numero;

                $pesost = [];
                $tmc = $this->seguimiento_model->getMetasComplementariasPesos($id_pry);
                foreach($tmc as $row){
                    $tot1 = $row->peso / $me;
                    array_push($pesost, $tot1);
                }
                $tpc = 0; // total de pesos por metas complementarias
                for($i = 0; $i < count($pesost); $i++){
                    $tpc += $pesost[$i];
                }

                $apa =  ($this->input->post('numero') * 100) / $programado->numero;

                /**
                 * Avance Meta Complementaria
                 */
                $datos = array(
                    'meta_id'       => $id_meta,
                    'mes_id'        => $this->input->post('mes_id'),
                    'numero'        => $this->input->post('numero'),
                    'explicacion'   => $this->input->post('explicacion'),
                    'porcentaje'    => round($apa,2)
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id'  => $this->input->post('mes_id')
                );
                $res = $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);

                if($res){
                    /**
                     * Avance Meta Principal
                     */
                    // obtener avance de meta principal
                    $amp = $this->seguimiento_model->getAvanceMetaPrincipal($id_pry, $this->input->post('mes_id'));

                    // sumar avance meta principal en el mes correspondiente con el nuevo dato
                    $na = ($aomc*100) / $tpc;
                    $val = $amp->numero + $na;

                    $datos = array(
                        'meta_id'       => $amp->meta_id,
                        'mes_id'        => $this->input->post('mes_id'),
                        'numero'        => $val,
                        'explicacion'   => ''
                    );
                    $where = array(
                        'meta_id'       => $amp->meta_id,
                        'mes_id'        => $this->input->post('mes_id')
                    );
                    $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                    echo true;
                }
            }
        }
    }

	public function getAvanceMetaMesCambioNormal($meta = false, $mes = false)
	{
		$avance = $this->seguimiento_model->getAvanceMetaMesNormal($mes, $meta);
		if($avance){
			$data['numero'] = $avance->numero;
			$data['explicacion'] = $avance->explicacion;
			echo json_encode($data);
		}
	}

	public function getAvanceMetaMesCambio($meta = false, $mes = false)
	{
		$avance = $this->seguimiento_model->getAvanceMetaMesPorcentaje($mes, $meta);
		if($avance){
			$data['recibidos'] = $avance->recibidos;
			$data['atendidos'] = $avance->atendidos;
			$data['explicacion'] = $avance->explicacion;
			echo json_encode($data);
		}
	}

	public function getDescriptionGoal($meta = false, $mes = false)
	{
		$description = $this->seguimiento_model->getDescriptionGoal($meta, $mes);
		if($description){
			$data['description'] = $description->explicacion;
			echo json_encode($data);
		}
	}

    public function index($id_pry = null)
    {
		$data = array();

		// Reviso si hay mensajes y los mando a las variables de la vista
		if ($this->session->userdata('mensaje')) {
			$data['mensaje'] = $this->session->userdata('mensaje');
			$this->session->unset_userdata('mensaje');
		}

		$data['clave'] = $this->_claveProyecto($id_pry);
		//cargo menu
		$data["menu"] = $this->load->view('home/home_menu', $data, TRUE);
		//cargo header
		$data["header"] = $this->load->view('home/home_header', $data, TRUE);
		//paso seccion
		$data["seccion"] = "Seguimiento";
		// js
		$data['js'] = 'seguimiento/seguimiento.js';
		// meses habilitados para las metas complementarias
		$data['meseshc'] = $this->_obtenerMesesHabilitadosC($id_pry);
		$data['meses'] = $this->_getMesesArray();
		// validar si existen metas complementarias para mostrar una u otra vista en main
		if($this->_searchMetasComplementarias($id_pry)){
			$data['encabezadomp'] = $this->_encabezadomp();
			$data['encabezadomc'] = $this->_encabezadomc();
			// tabla con la meta principal
			$data["tablamp"] = $this->_tablamp($id_pry);
			// tabla con las metas complementarias
			$data['tablamc'] = $this->_tablamc($id_pry);
			// vista
			$data["main"] = $this->load->view('seguimiento/seguimiento', $data, TRUE);
		} else {
			$data['encabezadomp'] = $this->_encabezadomps();
			// meses para arreglo
			// $data['meses'] = $this->_getMesesArray();
			// tabla con la meta principal
			$data["tablamp"] = $this->_tablamps($id_pry);
			// vista
			$data["main"] = $this->load->view('seguimiento/seguimientop', $data, TRUE);
		}
		//paso confirmacion de salir
		$data["salir"] = $this->load->view('home/home_salir', $data, TRUE);
		//cargo vista general
		$this->load->view('layout_general', $data);
    }

}
