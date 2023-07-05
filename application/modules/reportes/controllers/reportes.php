<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'graficas_model',
            'home/home_inicio',
            'reportes'
        );
        $this->load->model($models);
    }

    private function _calculaPorcentajes($ejercicio, $valor)
    {
        $res = $this->graficas_model->getProgramas($ejercicio);
        if($res){
            $total = 0;
            foreach($res as $row){
                $total += $row->y;
            }
            return ($valor / $total) * 100;
        }
    }

    public function getData()
    {
        $ejercicio = $this->home_inicio->get_ejercicio();
        $res = $this->graficas_model->getProgramas($ejercicio->ejercicio_id);
        $i = 0;
        if($res){
            foreach ($res as $row){
                $data[$i++] = array(
                    'name'  =>$row->nombre,
                    'value' => number_format($this->_calculaPorcentajes($ejercicio->ejercicio_id, $row->y), 2)
                );
            }
            echo json_encode($data);
        }
    }

    private function _is_exist($data, $type = FALSE)
    {
        if (isset($data)) {
            return $data;
        } else {
            if (! $type) {
                return '  ';
            } else {
                return 0;
            }
        }
    }

    public function getDataMetas($id)
    {
        $graph = new Graficas_model();
        $exist = $graph->getMetasComplementarias($id);
        if (is_array($exist)) {
            foreach ($exist as $key) {
                $data[] = array(
                    'name' => $this->_is_exist($key->numUniResGas) . ' ' . $this->_is_exist($key->numResOp) . ' ' . $this->_is_exist($key->progNum) . ' ' . $this->_is_exist($key->subNum) . ' ' . $this->_is_exist($key->proyNum) . ' ' . $this->_is_exist($key->metaNum),
                    'value' => $this->_is_exist($key->porcentaje, TRUE),
                );
            }
            echo json_encode($data);
        } else  {
            echo FALSE;
        }

    }

    public function seguimiento()
    {
        $data = array();
        // Reviso si hay mensajes y los mando a las variables de la vista
        if($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data = array(
            'header'    => $this->load->view('home/home_header', $data, TRUE),
            'seccion'   => "Reportes",
            'menu'      => $this->load->view('home/home_menu_r', $data, TRUE),
            'main'      => $this->load->view('seguimientoModel', $data, TRUE),
            'salir'     => $this->load->view('home/home_salir', $data, TRUE),
            //'js'        => 'graficas/reportes.js',
            'js_k'      => array(
                '<script src="' . base_url('js/graficas/0002_bar.js').'"></script>',
            )
        );
        $this->load->view('home/layout_general_graficas', $data);
    }

    public function index()
    {
        $data = array();
        // Reviso si hay mensajes y los mando a las variables de la vista
        if($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data = array(
            'header'    => $this->load->view('home/home_header', $data, TRUE),
            'seccion'   => "Reportes",
            'menu'      => $this->load->view('home/home_menu_r', $data, TRUE),
            'main'      => $this->load->view('reportes', $data, TRUE),
            'salir'     => $this->load->view('home/home_salir', $data, TRUE),
            'js_k'      => array(
                '<script src="' . base_url('js/graficas/0001_pie.js').'"></script>',
                '<script src="' . base_url('js/graficas/0002_bar.js').'"></script>',
            )
        );
        $this->load->view('home/layout_general_graficas', $data);
    }
}
