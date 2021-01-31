<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getLastOperativeResponsive extends MX_Controller {
    
    function __construct()
    {
        parent::__construct();

        $models = array(
            'script_model',
            'home/general'
        );
        $this->load->model($models);
    }

    public function index () 
    {
         $users = $this->script_model->getUsersId();
         if ($users) {
            foreach ($users as $user) {
                $responsable_operativo_id = $this->script_model->getIdResponsableOperativo($user->nsf);
                if ($responsable_operativo_id) {
                    $nombre_responsable_operativo = $this->script_model->getNameResponsableOperativo($responsable_operativo_id->responsable_operativo_id);
                    if ($nombre_responsable_operativo) {
                        $ro = $this->script_model->getResponsableOperativo($nombre_responsable_operativo->nombre);
                        if ($ro) {
                            $data = array(
                                'usuario_poa_id'            =>  $user->nsf,
                                'responsable_operativo_id'  => $ro->responsable_operativo_id
                            );
                            $this->general->insertaBase('usuarios_responsables_operativos', $data);
                        }
                    }
                }
            }
         }
    }
}