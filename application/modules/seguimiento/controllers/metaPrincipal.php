<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class metaPrincipal extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'home/general',
            'inicio/seguimiento_model'
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

    public function putSeguimientoPrincipalNormal()
    {
        $id_meta = $this->input->post('meta');
        $id_pry = $this->input->post('proyecto');
        $programado = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes'));
        if($this->input->post('numero') == '0'){
            $apm = 100;

            if($programado->numero == '0'){
                // obtener numero de meses de ejecución
                $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

                // avance esperado por mes de la meta complementaria
                $apmc = $apm / $me;
                $datos = array(
                    'numero'            => $this->input->post('numero'),
                    'explicacion'       => $this->input->post('explicacion'),
                    'porcentaje'        => 100,
                    'porcentaje_real'   => round($apmc,2)
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id'  => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
            } else {
                $datos = array(
                    'numero'            => $this->input->post('numero'),
                    'explicacion'       => $this->input->post('explicacion'),
                    'porcentaje'        => 0,
                    'porcentaje_real'   => 0
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id'  => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);
            }
        } else {
            if($programado->numero < $this->input->post('numero')){
                echo '422';
            } else {
                // obtener peso de la meta complementaria
                $apm = 100;

                // obtener numero de meses de ejecución
                $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

                // avance esperado por mes de la meta complementaria
                $apmc = $apm / $me;

                // obtener valor de la meta principal programada en el mes correspondiente
                $vpmc = $this->seguimiento_model->getAvanceProgramadoMetaComplementaria($id_meta, $this->input->post('mes'));

                if($this->input->post('numero') == '0'){
                    $apa = 0;
                    $aomc = 0;
                } else {
                    // operación para obtener el porcentaje de avance real de la meta principal en cuestión
                    $aomc = ($this->input->post('numero')*$apm) / $vpmc->numero;

                    $apa =  ($this->input->post('numero') * 100) / $programado->numero;
                }

                /**
                 * Avance Meta Principal
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
                $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);

                echo true;
            }
        }
    }

    public function putSeguimientoPorcentajePrincipal()
    {
        $id_meta = $this->input->post('meta');
        $id_pry = $this->input->post('proyecto');

        // obtener peso de la meta complementaria
        $apm = $this->seguimiento_model->getMetaPeso($id_meta);

        // obtener numero de meses de ejecución
        $me = $this->seguimiento_model->getMesesEjecucion($id_pry);

        // avance esperado por mes de la meta complementaria
        $apmc = 100 / $me;

        if($this->input->post('numero') == '0'){

            $datos = $datos = array(
                'numero' => $this->input->post('numero'),
                'explicacion' => $this->input->post('explicacion'),
                'porcentaje' => 100,
                'porcentaje_real'  => round($apmc,2)
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

            echo true;
        } else {
            if($this->input->post('numero') < $this->input->post('resueltos')){
                echo '422';
            } else {
                // obtener avance entre recibido y resuelto
                $porcentajeAvance = ($this->input->post('resueltos')*100) / $this->input->post('numero');

                // operación para obtener el porcentaje de avance real de la meta principal en cuestión
                $aomc = ($this->input->post('resueltos') * 100) / $this->input->post('numero');
                $porcentajeReal = ($aomc * 100) / $apmc;

                $this->_valida_numero($id_pry, $id_meta, $this->input->post('mes'), $this->input->post('numero'), $this->input->post('resueltos'));

                $datos = array(
                    'numero' => $this->input->post('numero'),
                    'explicacion' => $this->input->post('explicacion'),
                    'porcentaje'  => round($porcentajeAvance, 2),
                    'porcentaje_real'  => round($porcentajeReal,2)
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id' => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_alcanzadas', $datos, $where);

                $datos = array(
                    'numero' => $this->input->post('resueltos')
                );
                $where = array(
                    'meta_id' => $id_meta,
                    'mes_id' => $this->input->post('mes')
                );
                $this->general->actualizaBase('meses_metas_complementarias_resueltos', $datos, $where);

                echo true;
            }
        }
    }
}
