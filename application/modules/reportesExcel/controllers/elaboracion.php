<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class elaboracion extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        Modules::run( 'inicio/verificaIngreso' );
        $models = array(
            'graficas_model',
            'home/home_inicio',
            'reportes'
        );
        $this->load->model($models);
    }

    private function _tablaProyectos()
    {
        $res = $this->home_inicio->get_projects($this->session->userdata('ejercicio'));
        if($res){
            $tabla = '';
            foreach($res as $row){
                $tabla .= '
                <tr>
					<td>' . $row->urnum . '</td>
					<td>' . $row->ronum . '</td>
					<td>' . $row->pgnum . '</td>
					<td>' . $row->sbnum . '</td>
					<td>' . $row->pynum . '</td>
					<td>' . $row->pynom . '</td>
                </tr>';
            }
            return $tabla;
        }
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
            foreach ($res as $row) {
                $data[$i++] = array(
                    'name'  => $row->nombre,
                    'value' => $row->y,
                    // 'value' => number_format($this->_calculaPorcentajes($ejercicio->ejercicio_id, $row->y), 2)
                );
            }
            echo json_encode($data);
        }
    }

    public function aperturaProgramatica()
    {
        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $ejercicio = $this->home_inicio->get_ejercicio();
        $this->excel->getActiveSheet()->setTitle('Apertura Programatica '.$ejercicio->ejercicio);

        $this->excel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A4")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A7")->getFont()->setBold(true);

        $this->excel->getActiveSheet()->mergeCells("B1:R1");
        $this->excel->getActiveSheet()->mergeCells("B2:R2");
        $this->excel->getActiveSheet()->mergeCells("A3:A4");
        $this->excel->getActiveSheet()->mergeCells("B3:B4");
        $this->excel->getActiveSheet()->mergeCells("C3:C4");
        $this->excel->getActiveSheet()->mergeCells("D3:D4");
        $this->excel->getActiveSheet()->mergeCells("E3:E4");
        $this->excel->getActiveSheet()->mergeCells("F3:G4");
        $this->excel->getActiveSheet()->mergeCells("H3:H4");
        $this->excel->getActiveSheet()->mergeCells("I3:T3");
        $this->excel->getActiveSheet()->mergeCells("U3:U4");

        $this->excel->getActiveSheet()->setCellValue("B1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio->ejercicio);
        $this->excel->getActiveSheet()->setCellValue("B2", 'PROYECTOS');

        $this->excel->getActiveSheet()->setCellValue("A3", 'URG');
        $this->excel->getActiveSheet()->setCellValue("B3", 'RO');
        $this->excel->getActiveSheet()->setCellValue("C3", 'PG');
        $this->excel->getActiveSheet()->setCellValue("D3", 'SP');
        $this->excel->getActiveSheet()->setCellValue("E3", 'PY');
        $this->excel->getActiveSheet()->setCellValue("F3", 'Denominación');
        $this->excel->getActiveSheet()->setCellValue("H3", 'Unidad de medida');
        $this->excel->getActiveSheet()->setCellValue("I4", 'Ene');
        $this->excel->getActiveSheet()->setCellValue("J4", 'Feb');
        $this->excel->getActiveSheet()->setCellValue("K4", 'Mar');
        $this->excel->getActiveSheet()->setCellValue("L4", 'Abr');
        $this->excel->getActiveSheet()->setCellValue("M4", 'May');
        $this->excel->getActiveSheet()->setCellValue("N4", 'Jun');
        $this->excel->getActiveSheet()->setCellValue("O4", 'Jul');
        $this->excel->getActiveSheet()->setCellValue("P4", 'Ago');
        $this->excel->getActiveSheet()->setCellValue("Q4", 'Sep');
        $this->excel->getActiveSheet()->setCellValue("R4", 'Oct');
        $this->excel->getActiveSheet()->setCellValue("S4", 'Nov');
        $this->excel->getActiveSheet()->setCellValue("T4", 'Dic');
        $this->excel->getActiveSheet()->setCellValue("U3", 'Total');

        $programas = $this->reportes->getProgramas($this->session->userdata('ejercicio'));
        $i = 5;
        foreach($programas as $programa) {
            $this->excel->getActiveSheet()->setCellValue("C".$i, $programa->numero);
            $this->excel->getActiveSheet()->setCellValue("F".$i, $programa->nombre);
            $subprogramas = $this->reportes->getSubprogramas($programa->programa_id);
            // echo json_encode($programas);
            // print_r($subprogramas);
            // $lonsub = count($subprogramas);
            foreach($subprogramas as $subprograma){
            // for($j = 0; $j < $lonsub; $j++){
                $i++;
                $this->excel->getActiveSheet()->setCellValue("D".$i, $subprograma->numero);
                $this->excel->getActiveSheet()->setCellValue("F".$i, $subprograma->nombre);
                $proyectos = $this->reportes->getProyectos($subprograma->subprograma_id);
                // $lonpry = count($proyectos);
                foreach($proyectos as $proyecto){
                //for($k = 0; $k < $lonpry; $k++){
                    $i++;
                    $this->excel->getActiveSheet()->setCellValue("A".$i, $proyecto->urnum);
                    $this->excel->getActiveSheet()->setCellValue("B".$i, $proyecto->ronum);
                    $this->excel->getActiveSheet()->setCellValue("C".$i, $proyecto->pgnum);
                    $this->excel->getActiveSheet()->setCellValue("D".$i, $proyecto->sbnum);
                    $this->excel->getActiveSheet()->setCellValue("E".$i, $proyecto->pynum);

                    $this->excel->getActiveSheet()->mergeCells("F".$i.":G".$i);
                    $this->excel->getActiveSheet()->setCellValue("F".$i, $proyecto->pynom);

                    $metas = $this->reportes->getMetas($proyecto->proyecto_id);
                    /* echo '<pre>';
                    var_dump($metas[3]);
                    exit; */
                    // $lonmet = count($metas);
                    foreach($metas as $meta){
                    // for($l = 0; $l < $lonmet; $l++){
                        $i++;
                        if($meta->tipo == 'principal'){
                            $metat = 'MP';
                        } else {
                            $metat = 'MC';
                        }
                        $this->excel->getActiveSheet()->setCellValue("F".$i, $metat);
                        $this->excel->getActiveSheet()->setCellValue("G".$i, $meta->nombre);
                        $this->excel->getActiveSheet()->setCellValue("H".$i, $meta->umnom);
                        $programadas = $this->reportes->getProgramadas($meta->meta_id);
                        $lonprg = count($programadas);
                        $arrm = ['I','J','K','L','M','N','O','P','Q','R','S','T'];
                        $j = 0;
                        $total = 0;
                        foreach($programadas as $programada){
                        // for($m = 0; $m < $lonprg; $m++){
                            $this->excel->getActiveSheet()->setCellValue($arrm[$j].$i, $programada->numero);
                            $total += $programada->numero;
                            $j++;
                        }
                        $this->excel->getActiveSheet()->setCellValue("U".$i, $total);
                    }
                }
            }
        }

        $archivo = "apertura_programatica_".$ejercicio->ejercicio.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }

    public function index()
    {
        $data = array();
        if($this->session->userdata('mensaje')) {
            $data['mensaje'] = $this->session->userdata('mensaje');
            $this->session->unset_userdata('mensaje');
        }

        $data['tabla']   = $this->_tablaProyectos();
        $data['seccion'] = 'Reportes Elaboración';
        $data['js']      = 'graficas/0001_pie.js';
        $data['header']  = $this->load->view('home/home_header', $data, TRUE);
        $data['menu']    = $this->load->view('home/home_menu_r', $data, TRUE);
        $data['main']    = $this->load->view('reportes', $data, TRUE);
        $data['salir']   = $this->load->view('home/home_salir', $data, TRUE);
        /* $data = array(
            'header'    => $this->load->view('home/home_header', $data, TRUE),
            'seccion'   => "Reportes",
            'tabla'     => $this->_tablaProyectos(),
            'menu'      => $this->load->view('home/home_menu_r', $data, TRUE),
            'main'      => $this->load->view('reportes', $data, TRUE),
            'salir'     => $this->load->view('home/home_salir', $data, TRUE),
            'js_k'      => array(
                '<script src="' . base_url('js/graficas/0001_pie.js').'"></script>',
                '<script src="' . base_url('js/graficas/0002_bar.js').'"></script>',
            )
        );*/
        $this->load->view('home/layout_general_graficas', $data);
    }
}
