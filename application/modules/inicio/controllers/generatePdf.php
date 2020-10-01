<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class generatePdf extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $models = array(
            'home/home_inicio',
            'proyectos_model'
        );
        $this->load->library('Pdfgenerator');
        $this->load->model($models);
    }

    private function _info($id)
    {
        $res = $this->proyectos_model->get_project($id);
        return $res;
    }

    private function _mmetap($meta_id)
    {
        $res = $this->proyectos_model->get_mesesm($meta_id);
        if($res){
            $tabla = '';
            $total = 0;
            foreach($res as $row){
                $tabla .= '<td class="text-center">' . $row->numero . '</td>';
                $total += $row->numero;
            }
            $tabla .= '<td class="text-center" rowspan="2">' . $total . '</td>';
            return $tabla;
        }
    }

    private function _metac($id_proy)
    {
        $res = $this->proyectos_model->get_meta_com($id_proy);
        if($res){
            $tabla = '';
            foreach($res as $row){
                $total = 0;
                if($row->umnomb != 'Porcentajes'){
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
                } else {
                    $tabla .= '<tr>';
                    $tabla .= '<td class="text-center" rowspan="2">' . $row->mnomb . '</td>';
                    $tabla .= '<td class="text-center" rowspan="2">' . $row->umnomb . '</td>';
                    $tabla .= '<td class="text-center">Recibidos</td>';
                    $ult = $this->proyectos_model->get_mesesm($row->meta_id);
                    foreach($ult as $ren){
                        $tabla .= '<td class="text-center">'.$ren->numero.'</td>';
                        $total += $ren->numero;
                    }
                    $tabla .= '<td class="text-center">'.$total.'</td>';
                    $tabla .= '</tr>';
                    $tabla .= '<tr>';
                    $tabla .= '<td class="text-center">Resueltos</td>';
                    $ult = $this->proyectos_model->get_mesesc($row->meta_id);
                    foreach($ult as $ren){
                        $tabla .= '<td class="text-center">'.$ren->numero.'</td>';
                        $total += $ren->numero;
                    }
                    $tabla .= '<td class="text-center">'.$total.'</td>';
                    $tabla .= '</tr>';
                }
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
                $tabla .= '<td>'.$row->nombre.'</td>';
                $tabla .= '<td>'.$row->definicion.'</td>';
                $tabla .= '<td class="text-center">'.$row->umnom.'</td>';
                $tabla .= '<td class="text-center">'.$row->metodo_calculo.'</td>';
                $tabla .= '<td class="text-center">'.$row->dnombre.'</td>';
                $tabla .= '<td class="text-center">'.$row->fnombre.'</td>';
                $tabla .= '<td class="text-center">'.$row->meta.'</td>';
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
                $tabla .= '<td>'.$row->numero.'</td>';
                $tabla .= '<td>'.$row->descripcion.'</td>';
                $tabla .= '</tr>';
            }
            return $tabla;
        }
    }

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
            $tabla .= '</tr>';
            return $tabla;
        }
    }

    public function index($id_pry = false)
    {
        $data = array();
        // detalles del proyecto
        if($id_pry){
            $data['ejercicio'] = $this->session->userdata('anio');

            $data["detalles"]  = $this->_info($id_pry);
            // meta principal del proyecto
            $data['metap'] = $this->proyectos_model->get_meta($id_pry);
            // meses meta principal
            $data['mmetap'] = $this->_mmetap($data['metap']->meta_id);
            // metas complementarias
            $data['metac'] = $this->_metac($id_pry);
            // indicadores
            $data['indicadores'] = $this->_indica($id_pry);
            // acciones sustantivas
            $data['sustantivas'] = $this->_sustantivas($id_pry);
            // ejecución del proyecto
            $data['ejecucion'] = $this->_ejecucion($id_pry);
        }

        $this->load->view('fichaPoa', $data, TRUE);
        $html = $this->output->get_output();
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'landscape');
        $this->dompdf->render();
        $this->dompdf->stream("fichaPoa.pdf", array("Attachment"=>0));
    }
}
