<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class edit_projects extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'home/home_inicio',
            'proyectos_model',
            'home/general'
        );
        $this->load->model($models);
    }

    private function _unidadesm()
    {
        if ($query = $this->home_inicio->get_umedidas()) {
            $unidades = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $unidades[$row->unidad_medida_id] = $row->numero.' - '.$row->nombre;
            }
            return $unidades;
        }
    }

    private function _dimensiones()
    {
        if ($query = $this->home_inicio->get_dimensiones()) {
            $dimensiones = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $dimensiones[$row->dimension_id] = $row->dimension_id.' - '.$row->nombre;
            }
            return $dimensiones;
        }
    }

    private function _frecuencias()
    {
        if ($query = $this->home_inicio->get_frecuencias()) {
            $frecuencias = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $frecuencias[$row->frecuencia_id] = $row->frecuencia_id.' - '.$row->nombre;
            }
            return $frecuencias;
        }
    }

    private function _metas($pry)
    {
        if($query = $this->home_inicio->get_metas($pry)){
            $metas = array('' => '- Seleccione uno -');
            foreach($query as $row) {
                $metas[$row->meta_id] = $row->nombre;
            }
            return $metas;
        }
    }

    private function _tablaMetaPrincipal($id_pry)
    {
        $res = $this->proyectos_model->getMetas($id_pry, 'principal');
        if($res){
            $tabla = '';
            foreach ($res as $row){
                $tabla .= '
                    <td>'.$row->nombre.'</td>
                    <td>'.$row->umnombre.'</td>';
                $ans = $this->proyectos_model->get_mesesm($row->meta_id);
                foreach ($ans as $an){
                    $tabla .= '<td>'.$an->numero.'</td>';
                }
                $tabla .= '<td>100%</td>';
            }
            $tabla .= '</tr>';
            return $tabla;
        }
    }

    private function _tablaMetasComplementarias($id_pry)
    {
        $res = $this->proyectos_model->getMetas($id_pry, 'complementaria');
        if($res){
            $tabla = '';
            $total = 0;
            foreach ($res as $row){
                $tabla .= '<tr>
                    <td>'.$row->nombre.'</td>
                    <td>'.$row->umnombre.'</td>';
                $ans = $this->proyectos_model->get_mesesm($row->meta_id);
                foreach ($ans as $an){
                    $tabla .= '<td>'.$an->numero.'</td>';
                    $total += $an->numero;
                }
                $tabla .= '<td>'.$row->peso.'</td>
                    <td>'.$total.'</td>
                </tr>';
            }
            return $tabla;
        }
    }

    private function _tablaIndicadores($id_pry)
    {
        $res = $this->proyectos_model->getIndicadores($id_pry);
        if($res){
            $tabla = '';
            foreach($res as $row){
                $tabla .= '
                    <tr>
                        <td>'.$row->nombre.'</td>
                        <td>'.$row->definicion.'</td>
                        <td>'.$row->unombre.'</td>
                        <td>'.$row->metodo_calculo.'</td>
                        <td>'.$row->dnombre.'</td>
                        <td>'.$row->fnombre.'</td>
                        <td>'.$row->meta.'</td>
                    </tr>
                ';
            }
            return $tabla;
        }
    }

    private function _tablaAcciones($id_pry)
    {
        $res = $this->proyectos_model->getAccionesSustantivas($id_pry);
        if($res){
            $tabla = '';
            foreach ($res as $row){
                $tabla .= '
                    <tr>
                        <td>'.$row->numero.'</td>
                        <td>'.$row->descripcion.'</td>
                    </tr>
                ';
            }
            return $tabla;
        }
    }

    public function metaPrincipal($id_pry = false)
    {
        $data = array();

        if($this->input->post('numero')){
            $datos = array(
                'unidad_medida_id'  => '1047',
                'tipo'              => 'principal',
                'orden'             => '1',
                'peso'              => '',
                'numero'            => ''
            );
            $meta = $this->general->insertaBase('metas', $datos);
        }

        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu',$data,TRUE);
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Meta Principal";
        // tabla de meta principal
        $data["tablamp"] = $this->_tablaMetaPrincipal($id_pry);
        // js
        $data['js']     = 'inicio/proyectos.js';
        // vista
        $data["main"] 	 = $this->load->view('proyectos/meta_principal',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        //cargo vista general
        $this->load->view('layout_general',$data);
    }

    public function metaComplementaria($id_pry = false)
    {
        $data = array();

        if($this->input->post('numero')){
            $datos = array(
                'proyecto_id'       => $id_pry,
                'unidad_medida_id'  => $this->input->post('unidad_medida_id'),
                'tipo'              => 'complementaria',
                'orden'             => $this->input->post('orden'),
                'nombre'            => $this->input->post('nombre'),
                'peso'              => $this->input->post('peso')
            );
            $meta = $this->general->insertaBase('metas', $datos);
        }
        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu',$data,TRUE);
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Inicio";
        // unidades medidas
        $data['unidadesm'] = $this->_unidadesm();
        // tabla de metas complementarias
        $data['tablamc'] = $this->_tablaMetasComplementarias($id_pry);
        // js
        $data['js']     = 'inicio/proyectos.js';
        // vista
        $data["main"] 	 = $this->load->view('proyectos/metas_complementarias',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        //cargo vista general
        $this->load->view('layout_general',$data);
    }

    public function indicadores($id_pry = false)
    {
        $data = array();
        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu',$data,TRUE);
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Indicadores";
        // unidades medidas
        $data['umedidas'] = $this->_unidadesm();
        // dimensiones
        $data['dimension'] = $this->_dimensiones();
        // frecuencias
        $data['frecuencia'] = $this->_frecuencias();
        // metas
        $data['metas'] = $this->_metas($id_pry);
        // indicadores
        $data['indicadores'] = $this->_tablaIndicadores($id_pry);
        // js
        $data['js']     = 'inicio/proyectos.js';
        // vista
        $data["main"] 	 = $this->load->view('proyectos/indicadores',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        //cargo vista general
        $this->load->view('layout_general',$data);
    }

    public function accionesSustantivas($id_pry = false)
    {
        $data = array();
        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu',$data,TRUE);
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Acciones Sustantivas";
        // tabla de acciones
        $data['acciones'] = $this->_tablaAcciones($id_pry);
        // js
        $data['js']     = 'inicio/proyectos.js';
        // vista
        $data["main"] 	 = $this->load->view('proyectos/acciones_sustantivas',$data,TRUE);
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        //cargo vista general
        $this->load->view('layout_general',$data);
    }
}
