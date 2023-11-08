<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class info_db extends CI_Model
{
    public function getTipoUsuario($usuario)
    {
        $this->db->select('perfil');
        $this->db->where('nsf', $usuario);
        $this->db->from('g_registros');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function getEjerciciosUsuario($usuario)
    {
        $this->db->select('ejercicio_id');
        $this->db->where('usuario_id', $usuario);
        $this->db->from('usuarios_ejercicios');
        $query = $this->db->get();
        return $query->result();
    }

    /* public function getResponsablesOperativos($usuario)
    {
        $this->db->select('responsable_operativo_id');
        $this->db->where('usuario_poa_id', $usuario);
        $this->db->from('usuarios_responsables_operativos');
        $query = $this->db->get();
        return $query->result();
    } */

    public function getResponsablesOperativos($usuario, $area)
    {
        $this->db->select('usuarios_responsables_operativos.responsable_operativo_id');
        $this->db->join('responsables_operativos', 'usuarios_responsables_operativos.responsable_operativo_id = responsables_operativos.responsable_operativo_id');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->where('unidades_responsables_gastos.unidad_responsable_gasto_id', $area);
        $this->db->where('usuarios_responsables_operativos.usuario_poa_id', $usuario);
        $this->db->from('usuarios_responsables_operativos');
        $query = $this->db->get();
        return $query->result();
    }

    /* public function getUnidades($responsable)
    {
        $this->db->select('unidad_responsable_gasto_id');
        $this->db->where('responsable_operativo_id', $responsable);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        return $query->row();
    } */

    public function getUnidades($ejercicio)
    {
        $this->db->select('unidad_responsable_gasto_id');
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('unidades_responsables_gastos');
        $query = $this->db->get();
        return $query->result();
    }

    public function checkEjercicios($usuario, $ejercicio)
    {
        $this->db->where('usuario_id', $usuario);
        $this->db->where('ejercicio_id', $ejercicio);
        $this->db->from('usuarios_ejercicios');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function validacionResponsables($usuario, $responsable)
    {
        $this->db->where('usuario_poa_id', $usuario);
        $this->db->where('responsable_operativo_id', $responsable);
        $this->db->from('usuarios_responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function getPermisosResponsablesUsuarios($usuario)
    {
        $this->db->select('usuario_responsable_operativo_id');
        $this->db->where('usuario_poa_id', $usuario);
        $this->db->from('usuarios_responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    public function deletePermisosResponsablesUsuarios($usuario)
    {
        $this->db->where('usuario_poa_id',$usuario);
        $this->db->delete('usuarios_responsables_operativos');
        if ($this->db->affected_rows()==1){
            return true;
        }
    }

    public function deleteEjerciciosUsuarios($usuario)
    {
        $this->db->where('usuario_id', $usuario);
        $this->db->delete('usuarios_ejercicios');
        if ($this->db->affected_rows()==1){
            return true;
        }
    }

    public function obtenerInformacionResponsableOperativo($responsableId)
    {
        $this->db->where('responsable_operativo_id', $responsableId);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
    }

    public function obtenerResponsablesEjercicios($numeroResponsable, $ejercicios)
    {
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->where('responsables_operativos.numero', $numeroResponsable);
        $this->db->where_in('unidades_responsables_gastos.ejercicio_id', $ejercicios);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
    }

    /* public function obtenerNombreResponsableOperativo($responsableId)
    {
        $this->db->where('responsable_operativo_id', $responsableId);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function obtenerIdEjercicioResponsableOperativo($nombre, $ejercicio)
    {
        $this->db->select('responsables_operativos.*');
        $this->db->join('unidades_responsables_gastos', 'responsables_operativos.unidad_responsable_gasto_id = unidades_responsables_gastos.unidad_responsable_gasto_id');
        $this->db->where('responsables_operativos.nombre', $nombre);
        $this->db->where('unidades_responsables_gastos.ejercicio_id', $ejercicio);
        $this->db->from('responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
    }

    public function consultaUsuariosResponsablesOperativos($responsableOperativoId, $usuario)
    {
        $this->db->where('responsable_operativo_id', $responsableOperativoId);
        $this->db->where('usuario_poa_id', $usuario);
        $this->db->from('usuarios_responsables_operativos');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return true;
        }
        return false;
    } */
}
