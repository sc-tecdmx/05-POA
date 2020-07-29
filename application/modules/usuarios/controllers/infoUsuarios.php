<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class infoUsuarios extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'info_db',
            'home/general'
        );
        $this->load->model($models);
    }

    private function _valida($usuario, $ejercicio)
    {
        $res = $this->info_db->checkEjercicios($usuario, $ejercicio);
        if($res){
            return true;
        } else {
            return false;
        }
    }

    public function getPermisos($usuario = false)
    {
        // obtener tipo de usuario
        $res = $this->info_db->getTipoUsuario($usuario);
        $data['tipo'] = $res?$res->perfil:'';

        // obtener ejercicios a los que puede acceder
        $res = $this->info_db->getEjerciciosUsuario($usuario);
        $ejercicios = array();
        foreach($res as $row){
            array_push($ejercicios, $row->ejercicio_id);
        }
        $data['ejercicios'] = $ejercicios;

        $unidadesJson = array();
        $unidades = $this->info_db->getUnidades($this->session->userdata('ejercicio'));
        foreach($unidades as $unidad){
            $responsablesJson = array();
            $responsables = $this->info_db->getResponsablesOperativos($usuario, $unidad->unidad_responsable_gasto_id);
            if($responsables){
                foreach($responsables as $responsable){
                    array_push($responsablesJson, $responsable->responsable_operativo_id);
                }
                $nuevo = [
                    'unidad' => $unidad->unidad_responsable_gasto_id,
                    'responsables' => $responsablesJson
                ];
                array_push($unidadesJson, $nuevo);
            }
        }
        $data['unidades'] = $unidadesJson;
        /* obtener responsables operativos
        $res = $this->info_db->getResponsablesOperativos($usuario);
        $responsables = array();
        $unidades = array();
        foreach ($res as $row){
            //array_push($responsables, $row->responsable_operativo_id);
            $ro = $this->info_db->getUnidades($row->responsable_operativo_id);
            $nuevo = [
                'unidad' => $ro->unidad_responsable_gasto_id,
                'responsables' => $row->responsable_operativo_id
            ];
            // array_push($unidades, $ro->unidad_responsable_gasto_id);
            array_push($unidades, $nuevo);
        }
        $data['responsables'][] = $responsables;
        $data['unidades'] = $unidades; */
        echo json_encode($data);
    }

    private function _validaResponsables($usuario, $responsable)
    {
        $valido = $this->info_db->validacionResponsables($usuario, $responsable);
        if($valido){
            return true;
        }
        return false;
    }

    public function postPermisos()
    {
        $permiso = $this->input->post('permiso');
        $ejercicios = $this->input->post('ejercicios');
        $responsables = $this->input->post('responsables');
        $usuario = $this->input->post('usuario');

        // borrar los datos del usuario en la tabla usuarios_responsables_operativos para asignar los nuevos permisos
        $this->info_db->deletePermisosResponsablesUsuarios($usuario);

        // borrar los datos del usuario en la tabla usuarios_ejercicios para asignar los nuevo ejercicios a los que puede acceder
        $this->info_db->deleteEjerciciosUsuarios($usuario);

        $datos = array(
            'perfil' => $permiso,
        );
        $where = array(
            'nsf' => $usuario
        );
        $this->general->actualizaBase('g_registros', $datos, $where);

        $maxe = count($ejercicios);
        for($i = 0; $i < $maxe; $i++){
            /* if(!$this->_valida($usuario, $ejercicios[$i])){
                $datos = array(
                    'usuario_id'    => $usuario,
                    'ejercicio_id'  => $ejercicios[$i]
                );
                $this->general->insertaBase('usuarios_ejercicios', $datos);
            } */
            $datos = array(
                'usuario_id'    => $usuario,
                'ejercicio_id'  => $ejercicios[$i]
            );
            $this->general->insertaBase('usuarios_ejercicios', $datos);
        }

        // insertar los nuevos datos de los responsables
        $maxr = count($responsables);
        echo $responsables;
        for($i = 0; $i < $maxr; $i++){
            echo $responsables[$i];
            /* if(!$this->_validaResponsables($usuario, $responsables[$i])){
                $datos = array(
                    'usuario_poa_id'                => $usuario,
                    'responsable_operativo_id'  => $responsables[$i]
                );
                $this->general->insertaBase('usuarios_responsables_operativos', $datos);
            } */
            $datos = [
                'usuario_poa_id'            => $usuario,
                'responsable_operativo_id'  => $responsables[$i]
            ];
            $this->general->insertaBase('usuarios_responsables_operativos', $datos);
        }
        return true;
    }
}
