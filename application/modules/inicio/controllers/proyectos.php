<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyectos extends MX_Controller
{
	/**
	 * Constructor que instancia archivos externos
	 */
	function __construct()
	{
		parent::__construct();

		Modules::run( 'inicio/verificaIngreso' );
        // Modules::run( 'inicio/verifica_privilegios' );
        $models = array(
            'home/general',
            'ingreso_model',
            'home/home_inicio',
            'proyectos_model'
        );
		$this->load->model($models);
        $this->load->library('Pdfgenerator');
	}

    private function _mmetap_($meta_id)
    {
        return $this->proyectos_model->get_mesesm($meta_id);

    }

    private function _metac_($id_proy)
    {
        // return $this->proyectos_model->get_meta_com($id_proy);
        $res = $this->proyectos_model->get_meta_com($id_proy);
        // meses metas complementarias
        if($res){
            $tabla = '';
            foreach($res as $row){
                $total = 0;
                $mes = $this->proyectos_model->get_mesesm($row->meta_id);
                $tabla .= '<br><br>';
                $tabla .= '<table style="width: 100%">';
                $tabla .= '
                    <tr >
                        <td colspan="8" class="claro-vertical top" >METAS COMPLEMENTARIAS</td>
                    </tr>';
                $tabla .= '
                    <tr>
                        <td class="claro-vertical left" style="width: 40%;">Denominación de la Meta</td>
                        <td class="claro-horizontal right" style="width: 10%;" >UM</td>
                        <td class="claro-horizontal right" >ENE</td>
                        <td class="claro-horizontal right" >FEB</td>
                        <td class="claro-horizontal right" >MAR</td>
                        <td class="claro-horizontal right" >ABR</td>
                        <td class="claro-horizontal right" >MAY</td>
                        <td class="claro-horizontal right" >JUN</td>
                    </tr>';
                $tabla .= '
                    <tr>
                        <td class="dato left" style="width: 40%;" rowspan="3">'.$row->mnomb.'</td>
                        <td class="dato texto" style="width: 10%;" rowspan="3">'.$row->umnomb.'</td>';
                        foreach ($mes as $idx => $array){
                            if($array->mes_id <= 6){
                                $tabla .= '<td class="dato texto">'.$array->numero.'</td>';
                                $total += $array->numero;
                            }
                        }
                $tabla .= '</tr>';
                $tabla .= '
                    <tr>
                        <td class="claro-horizontal right left">JUL</td>
                        <td class="claro-horizontal right">AGO</td>
                        <td class="claro-horizontal right">SEP</td>
                        <td class="claro-horizontal right">OCT</td>
                        <td class="claro-horizontal right">NOV</td>
                        <td class="claro-horizontal right">DIC</td>
                    </tr>
                ';
                $tabla.= '
                    <tr >';
                foreach ($mes as $idx => $array){
                    if($array->mes_id > 6){
                        $tabla .= '<td class="dato texto">'.$array->numero.'</td>';
                        $total += $array->numero;
                    }
                }
                        /* <td class="dato left texto" rowspan="2">15</td>
                        <td class="dato texto" rowspan="2">20</td>
                        <td class="dato texto" rowspan="2">15</td>
                        <td class="dato texto" rowspan="2">15</td>
                        <td class="dato texto" rowspan="2">10</td>
                        <td class="dato texto" rowspan="2">5</td> */
                 $tabla .= '</tr>';
                $tabla .= '</table>';
                $tabla .= '
                    <table class="identificacion-responsables" style="width: 22%;" align="right">
                        <tr>
                              <td class="claro-vertical" style="text-align: center;">TOTAL ANUAL</td>
                              <td class="claro-vertical" style="text-align: center; width: 37%;">'.$total.'</td>
                        </tr>
                    </table>
                ';
            }
            return $tabla;
        }
    }



    private function _tabla()
    {
        if ($this->session->userdata('permiso') == 1 || ($this->session->userdata('permiso') != 1 && $this->session->userdata('area'))) {
            $res = $this->home_inicio->get_projects($this->session->userdata('ejercicio'));
            $edicion = $this->home_inicio->get_verificacionElaboracion($this->session->userdata('ejercicio'));
            if($res){
                $tabla = '';
                foreach($res as $row){
                    $tabla .= '
                    <tr>
                        <td style="display:none">' . $row->urnum . '' . $row->ronum . '' . $row->pgnum . '' . $row->sbnum . '' . $row->pynum . '</td>
                        <td>' . $row->urnum . '</td>
                        <td>' . $row->ronum . '</td>
                        <td>' . $row->pgnum . '</td>
                        <td>' . $row->sbnum . '</td>
                        <td>' . $row->pynum . '</td>
                        <td>' . $row->pynom . '</td>
                        <td>';
                    $tabla .= '
                        <a href="'.base_url('inicio/proyectos/view/'.$row->proyecto_id).'">
                            <i class="fa fa-fw fa-eye" data-toggle="tooltip" data-placement="top" title="Ver"></i>
                        </a>
                        <a href="'.base_url('inicio/proyectos/generatePdf/'.$row->proyecto_id).'" target="_blank">
                            <i class="fa fa-fw fa-file-export" data-toggle="tooltip" data-placement="top" title="PDF"></i>
                        </a>
                    ';
                    if($this->session->userdata('modo') === 'seguimiento'){
                        $tabla .= '
                            <a href="'.base_url('inicio/seguimiento/index/'.$row->proyecto_id).'">
                                <i class="fa fa-fw fa-arrow-circle-right" data-toggle="tooltip" data-placement="top" title="Seguimiento"></i>
                            </a>
                            <a href="'.base_url('inicio/seguimiento/graficas/'.$row->proyecto_id).'">
                                <i class="fa fa-fw fa-chart-pie" data-toggle="tooltip" data-placement="top" title="Graficas"></i>
                            </a>';
                    } else {
                        if($edicion->permitir_edicion_elaboracion == 'si' && $this->session->userdata('cerrado') == 0){
                            $tabla .= '
                                <a href="'.base_url('inicio/proyectos/action/'.$row->proyecto_id).'">
                                    <i class="fa fa-fw fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i>
                                </a>
                            ';
                        }
                        if($this->session->userdata('permiso') == 1 && $this->session->userdata('cerrado') == 0){
                            $tabla .= '
                            <btn class="btn btn-outline" style="cursor: pointer" onclick="eliminarProyecto('.$row->proyecto_id.')">
                                <i class="fa fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                            </btn>
                            ';
                        }
                    }
                    $tabla .= '
                        </td>
                    </tr>  
                    ';
                }
                return $tabla;
            }
        }

        $tabla = '
            <tr>
                <td colspan=7>No hay información</td>
            </tr>
        ';
        return $tabla;
    }

    private function _unidadesmp()
    {
        if ($query = $this->home_inicio->get_umedidas_principal()) {
            $unidades = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $unidades[$row->unidad_medida_id] = $row->numero.' - '.$row->nombre;
            }
            return $unidades;
        }
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

    private function _unidades($ejercicio)
    {
        if ($query = $this->home_inicio->get_unidades($ejercicio)) {
            $unidades = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $unidades[$row->unidad_responsable_gasto_id] = $row->numero.' - '.$row->nombre;
            }
            return $unidades;
        }
    }

    private function _responsables()
    {
        if ($query = $this->home_inicio->get_responsables($this->session->userdata('ejercicio'))) {
            $responsables = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $responsables[$row->responsable_operativo_id] = $row->ronum.' - '.$row->ronom;
            }
            return $responsables;
        }
    }

    private function _programas()
    {
        if ($query = $this->home_inicio->get_programas()) {
            $programas = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $programas[$row->programa_id] = $row->numero.' - '.$row->nombre;
            }
            return $programas;
        }
    }

    private function _subprogramas()
    {
        if ($query = $this->home_inicio->get_subprogramas()) {
            $subprogramas = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $subprogramas[$row->subprograma_id] = $row->sbnum.' - '.$row->sbnom;
            }
            return $subprogramas;
        }
    }

    private function _dimensiones()
    {
        if ($query = $this->home_inicio->get_dimensiones()) {
            $subprogramas = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $subprogramas[$row->dimension_id] = $row->dimension_id.' - '.$row->nombre;
            }
            return $subprogramas;
        }
    }

    private function _frecuencias()
    {
        if ($query = $this->home_inicio->get_frecuencias()) {
            $subprogramas = array('' => '-Seleccione uno-');
            foreach ($query as $row) {
                $subprogramas[$row->frecuencia_id] = $row->frecuencia_id.' - '.$row->nombre;
            }
            return $subprogramas;
        }
    }

    private function _metas($id_pry)
    {
        $query = $this->home_inicio->get_metas($id_pry);
        $metas = array('' => '- Seleccione uno -');
        if ($query) {
            foreach ($query as $row) {
                $metas[$row->meta_id] = $row->nombre;
            }
        }
        return $metas;
    }

    private function _special_insert()
    {
        if($this->form_validation->run('create_proyectos')){
            $data = array(
                'responsable_operativo_id'      => $this->input->post('responsable_operativo_id'),
                'subprograma_id'                => $this->input->post('subprograma_id'),
                'numero'                        => $this->input->post('numero'),
                'nombre'                        => $this->input->post('nombre'),
                'tipo'                          => $this->input->post('tipo'),
                'version'                       => $this->input->post('version'),
                'objetivo'                      => $this->input->post('objetivo'),
                'justificacion'                 => $this->input->post('justificacion'),
                'descripción'                   => $this->input->post('descripcion'),
                'fecha'                         => $this->input->post('fecha'),
                'nombre_responsable_operativo'  => $this->input->post('nombre_responsable_operativo'),
                'cargo_responsable_operativo'   => $this->input->post('cargo_responsable_operativo'),
                'nombre_titulat'                => $this->input->post('nombre_titular'),
                'responsable_ficha'             => $this->input->post('responsbale_ficha'),
                'autorizado_por'                => $this->input->post('autorizado_por')
            );
            $proyecto_id = $this->proyectos_model->insertar($data, 'proyectos');
            for($i = 1; $i <= 12; $i++){
                $data = array(
                    'proyecto_id'   => $proyecto_id,
                    'mes_id'        => $i,
                    'ejecuta'       => 'si'
                );
                $this->proyectos_model->insertar($data, 'meses_proyectos');
            }
            $this->session->set_userdata('mensaje', message_session('msg_register_field'));
            redirect('inicio/proyectos', 'refresh');
        }
    }

    private function _insert()
    {
        //si es correcta la validacion, inserta datos en la base
        if($this->form_validation->run('create_proyectos')){
            $datos = array(
                'responsable_operativo_id'      => $this->input->post('responsable_operativo_id'),
                'subprograma_id'                => $this->input->post('subprograma_id'),
                'numero'                        => $this->input->post('numero'),
                'nombre'                        => $this->input->post('nombre'),
                'tipo'                          => $this->input->post('tipo'),
                'version'                       => $this->input->post('version'),
                'objetivo'                      => $this->input->post('objetivo'),
                'justificacion'                 => $this->input->post('justificacion'),
                'descripcion'                   => $this->input->post('descripcion'),
                'fecha'                         => $this->input->post('fecha'),
                'nombre_responsable_operativo'  => $this->input->post('nombre_responsable_operativo'),
                'cargo_responsable_operativo'   => $this->input->post('cargo_responsable_operativo'),
                'nombre_titular'                => $this->input->post('nombre_titular'),
                'responsable_ficha'             => $this->input->post('responsbale_ficha'),
                'autorizado_por'                => $this->input->post('autorizado_por')
            );
            $proyecto_id = $this->proyectos_model->insertar($datos, 'proyectos');
            for($i = 1; $i <= 12; $i++){
                $datos = array(
                    'proyecto_id'   => $proyecto_id,
                    'mes_id'        => $i,
                    'ejecuta'       => 'si'
                );
                $this->general->insertaBase('meses_proyectos', $datos);
            }
            if($proyecto_id === ''){
                $this->session->set_userdata('mensaje', message_session( 'msg_error_field_register'));
                redirect('inicio/proyectos/action', 'refresh');
            }
            $this->session->set_userdata('mensaje', message_session('msg_register_field'));
            redirect('inicio/proyectos', 'refresh');
        }
    }

    private function _update($id_pry)
    {
        //si es correcta la validacion, trata de actualizar los proyectos
        if ($this->form_validation->run('create_proyectos') == TRUE) {
            $datos = array(
                'responsable_operativo_id'      => $this->input->post('responsable_operativo_id'),
                'subprograma_id'                => $this->input->post('subprograma_id'),
                'numero'                        => $this->input->post('numero'),
                'nombre'                        => $this->input->post('descripcion'),
                'tipo'                          => $this->input->post('tipo'),
                'version'                       => $this->input->post('version'),
                'objetivo'                      => $this->input->post('objetivo'),
                'justificacion'                 => $this->input->post('justificacion'),
                'descripcion'                   => $this->input->post('descripcion'),
                'fecha'                         => $this->input->post('fecha'),
                'nombre_responsable_operativo'  => $this->input->post('nombre_responsable_operativo'),
                'cargo_responsable_operativo'   => $this->input->post('cargo_responsable_operativo'),
                'nombre_titular'                => $this->input->post('nombre_titular'),
                'responsable_ficha'             => $this->input->post('responsbale_ficha'),
                'autorizado_por'                => $this->input->post('autorizado_por')
            );
            $where = array('proyecto_id' => $id_pry);
            $qry = $this->main_model->update($datos, 'proyectos', $where);
            if(!$qry){
                $this->session->set_userdata('mensaje', message_session('msg_error_field_update'));
                redirect('inicio/proyectos/action', 'refresh');
            }
            $this->session->set_userdata('mensaje', message_session('msg_update_field'));
            redirect('inicio/proyectos', 'refresh');
        }
    }

    private function _info($id)
    {
        $res = $this->proyectos_model->get_project($id);
        return $res;
    }

    private function _infod($id)
    {
        $res = $this->proyectos_model->getProjectDetails($id);
        return $res;
    }

    /**
     * Datos que se muestran a meta principal de proyectos que esta en proyectos/view_projects
     * @param $meta_id
     * @return bool|string
     */
    private function _mmetap($meta_id)
    {
        //var_dump($meta_id);
        if (! is_null($meta_id)) {
            $res = $this->proyectos_model->get_mesesm($meta_id);
            if($res){
                $tabla = '';
                $total = 0;
                foreach($res as $row){
                    $tabla .= '<td class="text-center">' .  $row->numero . '</td>';
                    $total += $row->numero;
                }
                //var_dump($total);
                $tabla .= '<td class="text-center">' . $total . '</td>';
                return $tabla;
            }
        } else {
            return FALSE;
        }

    }

    private function _metac($id_proy)
    {
        $res = $this->proyectos_model->get_meta_com($id_proy);
        if($res){
            $tabla = '';
            foreach($res as $row){
                $total = 0;
                $tabla .= '<tr>';
                $tabla .= '<td>' . $row->mnomb . '</td>';
                $tabla .= '<td class="text-center">' . $row->umnomb . '</td>';
                $tabla .= '<td class="text-center">NA</td>';
                $ult = $this->proyectos_model->get_mesesm($row->meta_id);
                foreach($ult as $ren){
                    $tabla .= '<td class="text-center">'.$ren->numero.'</td>';
                    $total += $ren->numero;
                }
                $tabla .= '<td class="text-center">'.$total.'</td>';
                $tabla .= '</tr>';
            }
            return $tabla;
        }
    }

    private function _indica($id_proy)
    {
        $res = $this->proyectos_model->get_indicadores($id_proy);
        if($res){
            $tabla = '';
            foreach ($res as $row){
                $tabla .= '<tr>';
                $tabla .= '<td class="dato texto left">'.$row->nombre.'</td>';
                $tabla .= '<td class="dato texto">'.$row->definicion.'</td>';
                $tabla .= '<td class="dato texto">'.$row->umnom.'</td>';
                $tabla .= '<td class="dato texto">'.$row->metodo_calculo.'</td>';
                $tabla .= '<td class="dato texto">'.$row->dnombre.'</td>';
                $tabla .= '<td class="dato texto">'.$row->fnombre.'</td>';
                if ($row->tipo == 'principal') {
                    $tabla .= '<td class="dato texto">'.$row->meta.'</td>';
                } else {
                    $tabla .= '<td class="dato texto">'.$row->peso.'</td>';
                }
                $tabla .= '</tr>';
            }
            return $tabla;
        }
    }

    private function _tablain($id_proy)
    {
        $res = $this->proyectos_model->get_indicadores($id_proy);
        if($res){
            $tabla = '';
            foreach ($res as $row){
                $tabla .= '<tr>';
                $tabla .= '<td>'.$row->nombre.'</td>';
                $tabla .= '<td>'.$row->definicion.'</td>';
                $tabla .= '<td class="text-center">'.$row->umnom.'</td>';
                $tabla .= '<td class="text-center">'.$row->metodo_calculo.'</td>';
                $tabla .= '<td class="text-center">'.$row->dnombre.'</td>';
                $tabla .= '<td class="text-center">'.$row->fnombre.'</td>';
                $tabla .= '<td class="text-center">'.$row->meta.'</td>';
                $tabla .= '
                    <td>
                        <btn class="btn btn-outline" onclick="editaIndicadores('.$row->indicador_id.')" style="cursor: pointer"><i class="fa fa-fw fa-edit"></i></btn>';
                if($row->tipo != 'principal'){
                    $tabla .= '<btn class="btn btn-outline" onclick="eliminarIndicadores('.$row->indicador_id.')" style="cursor: pointer"><i class="fa fa-fw fa-trash"></i></btn>';
                }
                $tabla .='</td>';
                $tabla .= '</tr>';
            }
            return $tabla;
        }
    }

    private function _sustantivas($id_proyecto)
    {
        $res = $this->proyectos_model->get_asustantivas($id_proyecto);
        if($res){
            $tabla = '';
            foreach ($res as $row){
                $tabla .= '<tr>';
                $tabla .= '<td class="dato texto left">'.$row->numero.'</td>';
                $tabla .= '<td class="dato">'.$row->descripcion.'</td>';
                $tabla .= '</tr>';
            }
            return $tabla;
        }
    }

    private function _tablaas($id_proyecto)
    {
        $res = $this->proyectos_model->get_asustantivas($id_proyecto);
        if($res){
            $tabla = '';
            foreach ($res as $row){
                $tabla .= '<tr>';
                $tabla .= '<td>'.$row->numero.'</td>';
                $tabla .= '<td>'.$row->descripcion.'</td>';
                $tabla .= '
                    <td>
                        <btn class="btn btn-outline" onclick="editaAcciones('.$row->accion_sustantiva_id.')" style="cursor: pointer"><i class="fa fa-fw fa-edit"></i></btn>
                        <btn class="btn btn-outline" onclick="eliminarAccionesSustantivas('.$row->accion_sustantiva_id.')" style="cursor: pointer"><i class="fa fa-fw fa-trash"></i></btn>
                    </td>';
                $tabla .= '</tr>';
            }
            return $tabla;
        }
    }

    private function _programaEsp($proyecto)
    {
        $res = $this->proyectos_model->getProgramaEspecial($proyecto);
        if($res){
            $tabla = '';
            foreach ($res as $row)
            {
                $tabla .= '<tr>';
                $tabla .= '
                    <td>
                        '.$row->numero.'-'.$row->nombre.'
                    </td>';
                $tabla .= '
                    <td>'.$row->descripcion.'</td>';
                $tabla .= '</tr>';
            }
            return $tabla;
        }
    }

    private function _equidadGenero()
    {

    }

    /**
     * Envía resultados de la consulta Ejecución del Proyecto por la vista proyectos/edit_proyectos
     * para la variable $ejecucion
     * @param $proyecto_id
     * @return string
     */
    private function _ejecucion($proyecto_id)
    {
        $res = $this->proyectos_model->get_ejecucion($proyecto_id);
        if($res){
            $tabla = '';
            $tabla .= '<tr>';
            foreach($res as $row){
                $ejecuta = $row->ejecuta == 'si' ? 'x' : '';
                $tabla .= '<td class="text-center">'.$ejecuta.'</td>';
            }
            $tabla .= '
                <td>
                    <btn class="btn btn-outline" id="editarEjecucion" style="cursor: pointer"><i class="fa fa-fw fa-edit"></i></btn>    
                </td>';
            $tabla .= '</tr>';
            //var_dump($res);
            return $tabla;
        }
    }

    private function _ejecuciond($proyecto_id)
    {
        $res = $this->proyectos_model->get_ejecucion($proyecto_id);
        if($res){
            $tabla = '';
            $tabla .= '<tr>';
            foreach($res as $row){
                $ejecuta = $row->ejecuta == 'si' ? 'x' : '';
                $tabla .= '<td class="text-center">'.$ejecuta.'</td>';
            }
            $tabla .= '</tr>';
            return $tabla;
        }
    }

    private function _ejecucionPrimeros($proyecto_id)
    {
        $res = $this->proyectos_model->getEjecucion($proyecto_id, 6, 1);
        if($res){
            $tabla = '';
            $tabla .= '<tr>';
            foreach($res as $row){
                $ejecuta = $row->ejecuta == 'si' ? 'X' : '<br>';
                $tabla .= '<td class="dato texto">'.$ejecuta.'</td>';
            }
            $tabla .= '</tr>';
            return $tabla;
        }
    }

    private function _ejecucionSegundos($proyecto_id)
    {
        $res = $this->proyectos_model->getEjecucion($proyecto_id, 12, 7);
        if($res){
            $tabla = '';
            $tabla .= '<tr>';
            foreach($res as $row){
                $ejecuta = $row->ejecuta == 'si' ? 'X' : '<br>';
                $tabla .= '<td class="dato texto">'.$ejecuta.'</td>';
            }
            $tabla .= '</tr>';
            return $tabla;
        }
    }

    public function seguimiento($id_pry = false)
    {
        $data = array();

        // Reviso si hay mensajes y los mando a las variables de la vista
        if ($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        //cargo menu
        $data["menu"] = $this->load->view('home/home_menu', $data, TRUE);
        //cargo header
        $data["header"] = $this->load->view('home/home_header', $data, TRUE);
        //paso seccion
        $data["seccion"] = "Inicio";
        // tabla con la meta principal
        // $data["tablamp"] = $this->_tablamp($id_pry);
        // meses habilitados para las metas complementarias
        // $data['meseshc'] = $this->_obtenerMesesHabilitadosC($id_pry);
        // tabla con las metas complementarias
        // $data['tablamc'] = $this->_tablamc($id_pry);
        // vista
        $data["main"] = $this->load->view('seguimiento/seguimiento', $data, TRUE);
        //paso confirmacion de salir
        $data["salir"] = $this->load->view('home/home_salir', $data, TRUE);
        //cargo vista general
        $this->load->view('home/layout_general', $data);
    }

    public function generatePdf($id_pry = false)
    {
        $data = array();
        // detalles del proyecto
        if($id_pry){
            $data['leyenda_nombre_cargo_firma_ro'] = "Nombre, Cargo y Firma del Responsable Operativo";
            if ($this->session->userdata('anio') >= 2016) {
                $data['leyenda_nombre_cargo_firma_ro'] = "Nombre, Cargo y Firma de quien revisó";
            }
            $data["detalles"]  = $this->_infod($id_pry);
            // meta principal del proyecto
            $data['metap'] = $this->proyectos_model->get_meta($id_pry);
            // meses meta principal
            if($data['metap']){
                $data['mmetap'] = $this->_mmetap_($data['metap']->meta_id);
            }
            // metas complementarias
            $data['metac'] = $this->_metac_($id_pry);

            // indicadores
            $data['indicadores'] = $this->_indica($id_pry);
            // acciones sustantivas
            $data['sustantivas'] = $this->_sustantivas($id_pry);
            // ejecución del proyecto
            $data['primeros'] = $this->_ejecucionPrimeros($id_pry);
            $data['segundos'] = $this->_ejecucionSegundos($id_pry);
            //identificacion programatica
            $data['identificacion_programatica'] = $this->proyectos_model->get_metasp_proyecto($id_pry);
        }

        // var_dump($data['identificacion_programatica']);
        $this->load->view('fichaPoa', $data);
        $html = $this->output->get_output();
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream("fichaPoa.pdf", array("Attachment"=>0));
    }

    public function view($id_pry = false)
    {
        $data = array();
        // Reviso si hay mensajes y los mando a las variables de la vista
        if($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        if($id_pry){
            $check_data = $this->proyectos_model->get_meta($id_pry);
            // detalles del proyecto
            $data["detalles"]  = $this->_infod($id_pry);
            // meta principal del proyecto
            $data['metap'] = (isset($check_data))? $check_data : FALSE;
            // meses meta principal
            $data['mmetap'] = ($check_data)? $this->_mmetap($data['metap']->meta_id) : FALSE;
            // metas complementarias
            $data['metac'] = $this->_metac($id_pry);
            // indicadores
            $data['indicadores'] = $this->_indica($id_pry);
            // acciones sustantivas
            $data['sustantivas'] = $this->_sustantivas($id_pry);
            // ejecución del proyecto
            $data['ejecucion'] = $this->_ejecuciond($id_pry);
            // vista
            $data["main"] 	 = $this->load->view('proyectos/view_project',$data,TRUE);
        }
        //cargo menu
        $data["menu"]    = $this->load->view('home/home_menu',$data,TRUE);
        //cargo header
        $data["header"]  = $this->load->view('home/home_header',$data,TRUE);
        //paso seccion
        $data["seccion"] = "Proyectos";
        //paso confirmacion de salir
        $data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
        //cargo vista general
        $this->load->view('layout_general',$data);
    }

    private function _tablamp($id_pry)
    {
        $res = $this->proyectos_model->getMetas($id_pry, 'principal');
        if($res){
            $tabla = '';
            foreach($res as $row){
                if($row->tmc == '0'){
                    $tabla .= '<tr>';
                    $tabla .= '
                    <td>'.$row->nombre.'</td>
                    <td>'.$row->umnombre.'</td>';
                    $ren = $this->proyectos_model->getMesesP($id_pry, 'principal');
                    $i = 1;
                    foreach ($ren as $mesp){
                        // $tabla .= '<td class="text-center"><button class="btn btn-outline" onclick="editarMesesMetaPrincipal('.$row->meta_id.','.$i.')">'.$mesp->numero.'</button></td>';
                        $tabla .= '<td class="text-center">'.$mesp->numero.'</td>';
                        $i++;
                    }
                    $tabla .= '<td>100%</td>';
                    $tabla .= '
                    <td>
                        <btn class="btn btn-outline" data-info="'.$row->meta_id.'" style="cursor: pointer" id="editarMetaPrincipal"><i class="fa fa-fw fa-edit"></i></btn>
                    </td>';
                    $tabla .= '</tr>';
                } else {
                    $tabla .= '<tr>';
                    $tabla .= '
                    <td>'.$row->nombre.'</td>
                    <td>'.$row->umnombre.'</td>';
                    $ren = $this->proyectos_model->getMesesP($id_pry, 'principal');
                    foreach ($ren as $mesp){
                        $tabla .= '<td class="text-center">'.$mesp->numero.'</td>';
                    }
                    $tabla .= '<td>100%</td>';
                    $tabla .= '
                    <td>
                        <btn class="btn btn-outline" data-info="'.$row->meta_id.'" style="cursor: pointer" id="editarMetaPrincipal"><i class="fa fa-fw fa-edit"></i></btn>
                    </td>';
                    $tabla .= '</tr>';
                }
            }
            return $tabla;
        }
    }

    private function _tablamc($id_pry)
    {
        $res = $this->proyectos_model->get_meta_com($id_pry);
        if($res){
            $tabla = '';
            foreach($res as $row){
                $total = 0;
                $tabla .= '<tr>';
                $tabla .= '<td>' . $row->mnomb . '</td>';
                $tabla .= '<td class="text-center">' . $row->umnomb . '</td>';
                $ult = $this->proyectos_model->get_mesesm($row->meta_id);
                if($row->umnomb != 'Porcentajes'){
                    $i = 1;
                    foreach($ult as $ren){
                        $tabla .= '<td class="text-center"><button class="btn btn-outline" onclick="editarMesesMetaComplementaria('.$row->meta_id.','.$i.')">'.$ren->numero.'</button></td>';
                        $total += $ren->numero;
                        $i++;
                    }
                } else {
                    foreach($ult as $ren){
                        $tabla .= '<td class="text-center">'.$ren->numero.'</td>';
                        $total = '100';
                    }
                }
                $tabla .= '<td class="text-center">'.$row->peso.'</td>';
                $tabla .= '<td class="text-center">'.$total.'</td>';
                $tabla .= '
                    <td>
                        <btn class="btn btn-outline" data-info="'.$row->meta_id.'" style="cursor: pointer" onclick="editarMetaComplementaria('.$row->meta_id.')" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-fw fa-edit"></i></btn>
                        <btn class="btn btn-outline" data-info="'.$row->meta_id.'" style="cursor: pointer" onclick="eliminarMetaComplementaria('.$row->meta_id.')" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-fw fa-trash"></i></btn>
                    </td>';
                $tabla .= '</tr>';
            }
            return $tabla;
        }
    }

    private function _claveProyecto($id_pry)
    {
        $proyecto = $this->proyectos_model->getClaveProyecto($id_pry);
        $clave = $proyecto->urnum.'-'.$proyecto->ronum.'-'.$proyecto->pgnum.'-'.$proyecto->sbnum.'-'.$proyecto->pynum;
        return $clave;
    }

    private function _validarMetaPrincipal($id_pry)
    {
        $res = $this->proyectos_model->getMetas($id_pry, 'principal');
        if($res){
            foreach($res as $row){
                if($row->tmc == '1'){
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function action($id_pry = false)
    {
        $data = array();
        //checa si hay mensajes de session de algun otro controlador
        if ($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        // $ejercicio = $this->home_inicio->get_ejercicio();

        $data['unidadesmp'] = $this->_unidadesmp();
        $data['unidadesm'] = $this->_unidadesm();
        $data['unidades'] = $this->_unidades($this->session->userdata('ejercicio'));
        $data['responsables'] = $this->_responsables();
        $data['programas'] = $this->_programas();
        $data['subprogramas'] = $this->_subprogramas();
        $data['dimensiones'] = $this->_dimensiones();
        $data['frecuencias'] = $this->_frecuencias();

        if($id_pry != FALSE) {
            $data['update'] = TRUE;
            $where = array('proyecto_id' => $id_pry);
            $data['row']    = $this->main_model->get_data_all_row(FALSE, 'proyectos', $where);
            $data['tablamp'] = $this->_tablamp($id_pry);
            $data['tablamc'] = $this->_tablamc($id_pry);
            $data['indicadores'] = $this->_tablain($id_pry);
            $data['sustantivas'] = $this->_tablaas($id_pry);
            $data['programaEspecial'] = $this->_programaEsp($id_pry);
            $data['metas'] = $this->_metas($id_pry); // catalogo de metas para usar dependiendo el proyecto
            // ejecución del proyecto
            $data['ejecucion'] = $this->_ejecucion($id_pry);
            $data['clave'] = $this->_claveProyecto($id_pry);
            $data['valida'] = $this->_validarMetaPrincipal($id_pry);
            $data['main'] = $this->load->view('proyectos/edit_proyectos', $data, TRUE);
            $this->_update($id_pry);
        } else {
            $data["main"]   = $this->load->view('proyectos/create_proyectos', $data, TRUE);
            $this->_insert();
            // $data["main"]   = $this->load->view('proyectos/create_proyectos', $data, TRUE);
            // $this->_special_insert();
        }

        // $ejercicio = $this->home_inicio->get_ejercicio();
        $data['ejercicio_id'] = $this->session->userdata('ejercicio');

        // js
        $data['js']     = 'inicio/proyectos.js';

        $unidad = $this->home_inicio->get_unidad($this->session->userdata('area_id'));
        $data['unidad'] = $unidad ? $unidad[0]->nombre : 'No se encontró la unidad';

        //se cargan datos y vistas
        $data["header"] = $this->load->view('home/home_header', $data, TRUE);
        $data["menu"]   = $this->load->view('home/home_menu', $data, TRUE);
        // $data["main"]   = $this->load->view('proyectos/create_proyectos', $data, TRUE);
        $data["salir"]  = $this->load->view('home/home_salir', $data, TRUE);
        $this->load->view('home/layout_general', $data);
    }

    /**
     * Es ajax
     */
    public function getMesesEjecucion($id_pry){
        echo json_encode(['success' => true,'meses' => $this->proyectos_model->get_meses_habilitados($id_pry)]);
    }

    public function updateMesEjecucionProyAjax(){
        if($this->input->post('proyecto_id') && $this->input->post('mes_id')){
            //recibimos el mes a habilitar y el proyecto.
            $update = $this->proyectos_model->update_mes_ejecucion($this->input->post('proyecto_id'),$this->input->post('mes_id'),$this->input->post('ejecuta'));

            if(!$update['success']){
                echo json_encode($update);
            }

            echo json_encode(["success"=>true,"msg" => "Actualización correcta"]);
        }
        else{
            echo json_encode(['success' => false, 'msg' => 'No se recibió mes o proyecto']);
        }


    }

    /**
	 * Método que se encarga del control del home
	 * @return array Vistas con sus datos correspondientes
	 */
	public function index()
	{
		// Si llegamos hasta aqui tenemos que ver la página de logeo
		$data = array();
		// Reviso si hay mensajes y los mando a las variables de la vista
		if($this->session->userdata('mensaje')) {
			$data['mensaje'] = $this->session->userdata('mensaje');
			$this->session->unset_userdata('mensaje');
		}
		//cargo menu
		$data["menu"]    = $this->load->view('home/home_menu',$data,TRUE);

        $unidad = $this->home_inicio->get_unidad($this->session->userdata('area_id'));
        $data['unidad'] = $unidad ? $unidad[0]->nombre : 'No se encontró la unidad';

		//cargo header
		$data["header"]  = $this->load->view('home/home_header',$data,TRUE);
		//paso seccion
		$data["seccion"] = "Inicio";
		// tabla con todos los proyectos
        $data["tabla"]  = $this->_tabla();
        // js
        $data['js']     = 'inicio/proyectos.js';
		// vista
		$data["main"] 	 = $this->load->view('proyectos/home_vista',$data,TRUE);
		//paso confirmacion de salir
		$data["salir"]   = $this->load->view('home/home_salir',$data,TRUE);
		//cargo vista general
		$this->load->view('layout_general',$data);
	}
}
