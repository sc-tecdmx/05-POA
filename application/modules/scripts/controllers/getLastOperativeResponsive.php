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
                       $ejercicio = $this->script_model->getEjercicio($nombre_responsable_operativo->unidad_responsable_gasto_id);
                       	 $ro = $this->script_model->getResponsableOperativo($nombre_responsable_operativo->nombre);
                     	 if ($ro) {
                           $data = array(
                               'usuario_poa_id'            =>  $user->nsf,
                               'responsable_operativo_id'  => $ro->responsable_operativo_id
                            );
                            if($ejercicio && ($ejercicio->ejercicio_id == 14) ){
			      echo "<br><br>Inserto para NSF:".$user->nsf ." Nombre: ".$user->nombre." ".$user->apellido." ".$user->segundo_apellido." Puesto:". $nombre_responsable_operativo->nombre." Ejercicio:".$ejercicio->ejercicio_id."<br>";
			      print_r($data);
 
                              //$this->general->insertaBase('usuarios_responsables_operativos', $data);
                            }
                            else {
                              
                              // echo "<br><br>Borrar para :".$user->nsf ." ". $nombre_responsable_operativo->nombre." Ejercicio:".$ejercicio->ejercicio_id."<br>";
			      //print_r($data);
                            }
                         
                         }
                      
                    }
                 }
                
            }
         }
         echo "Concluyo Script";
    }
}