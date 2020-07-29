<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class metasComplementarias extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'inicio/seguimiento_model',
            'home/general'
        );
        $this->load->model($models);
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

    /**
     * Función que permite dar seguimiento normal a metas complementarias que no tienen porcentajes en su unidad de
     * medida
     */
    public function putSeguimientoNormal()
    {
        $id_meta = $this->input->post('meta');
        $id_pry = $this->input->post('proyecto');
        $programado = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes'));
        if($this->input->post('numero') == '0'){
            $pesoMetaComplementaria = $this->seguimiento_model->getMetaPeso($id_meta);
            if($programado->numero == '0'){
                /**
                 * Avance Meta Complementaria
                 */
                $datos = array(
                    'meta_id'           => $id_meta,
                    'mes_id'            => $this->input->post('mes'),
                    'numero'            => $this->input->post('numero'),
                    'explicacion'       => $this->input->post('explicacion'),
                    'porcentaje'        => 100,
                    'porcentaje_real'   => round($pesoMetaComplementaria->peso,2)
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id'  => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                /**
                 * Avance Meta Principal
                 */
                // recalcular avances de meta principal sin incluir el nuevo mes
                $navc = $this->seguimiento_model->getAvancesMP($id_pry, $this->input->post('mes'), $id_meta);
                // obtener avance de meta principal
                $amp = $this->seguimiento_model->getAvanceMetaPrincipal($id_pry, $this->input->post('mes'));

                // $val = $amp->numero + $na;
                $val = $navc->porcentaje_real + $pesoMetaComplementaria->peso;
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
            } else {
                /**
                 * Avance Meta Complementaria
                 */
                $datos = array(
                    'meta_id'           => $id_meta,
                    'mes_id'            => $this->input->post('mes'),
                    'numero'            => $this->input->post('numero'),
                    'explicacion'       => $this->input->post('explicacion'),
                    'porcentaje'        => $this->input->post('numero'),
                    'porcentaje_real'   => $this->input->post('numero')
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id'  => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
                /**
                 * Avance Meta Principal
                 */
                // recalcular avances de meta principal sin incluir el nuevo mes
                $navc = $this->seguimiento_model->getAvancesMP($id_pry, $this->input->post('mes'), $id_meta);
                // obtener avance de meta principal
                $amp = $this->seguimiento_model->getAvanceMetaPrincipal($id_pry, $this->input->post('mes'));

                // $val = $amp->numero + $na;
                $val = $navc->porcentaje_real;
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
            }
            echo true;
        } else {
            if($programado->numero < $this->input->post('numero')){
                echo '422';
            } else {
                // obtener peso de la meta complementaria
                $pesoMetaComplementaria = $this->seguimiento_model->getMetaPeso($id_meta);

                // obtener numero de meses de ejecución
                $mesesEjecucion = $this->seguimiento_model->getMesesEjecucion($id_pry);

                // valor programado de la meta complementaria en el mes correspondiente
                $programado = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes'));

                if($programado->numero == '0'){
                    $apa = 0;
                    $aomc = 0;
                } else {
                    $apa =  ($this->input->post('numero') * 100) / $programado->numero;
                    // operación para obtener el porcentaje de avance real de la meta complementaria en cuestión
                    $aomc = ($this->input->post('numero')*$pesoMetaComplementaria->peso) / $programado->numero;
                }

                $pesost = [];
                $tmc = $this->seguimiento_model->getMetasComplementariasPesos($id_pry);
                foreach($tmc as $row){
                    $tot1 = $row->peso / $mesesEjecucion;
                    array_push($pesost, $tot1);
                }
                $tpc = 0; // total de pesos por metas complementarias
                for($i = 0; $i < count($pesost); $i++){
                    $tpc += $pesost[$i];
                }

                /**
                 * Avance Meta Complementaria
                 */
                $datos = array(
                    'meta_id'           => $id_meta,
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

                $val = $navc->porcentaje_real + $aomc;
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
            }
        }
    }

    /**
     * Función para dar seguimiento a la meta complementaria que tenga porcentajes en su unidad de medida
     */
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
}
