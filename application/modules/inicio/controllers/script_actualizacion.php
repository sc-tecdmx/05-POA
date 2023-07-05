<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class script_actualizacion extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $models = array(
            'actualizacion'
        );
        $this->load->model($models);
    }

    public function index()
    {
        $metas = $this->actualizacion->getMetasPrincipales($this->session->userdata('ejercicio'));
        foreach ($metas as $meta){
            echo $meta->meta_id.'<br>';
            $data = array(
              'numero' => 1
            );
            $where = array(
                'meta_id'   => $meta->meta_id
            );
            $this->actualizacion->updateMetasPrincipales($data, $where);
        }
    }
}
