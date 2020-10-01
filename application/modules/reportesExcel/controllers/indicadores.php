<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class indicadores extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'home/home_inicio',
            'reportes'
        );
        $this->load->model($models);
        $this->load->library('Excel');
    }

    public function index($trimestre = false)
    {
        if($trimestre == '1'){
            $mnombre = 'Enero-Marzo';
            // $mes = 3;
            $ultimoDiaMes = '31 DE MARZO DEL ';
        } else if($trimestre == '2'){
            $mnombre = 'Abril-Junio';
            // $mes = 6;
            $ultimoDiaMes = '30 DE JUNIO DEL ';
        } else if($trimestre == '3'){
            $mnombre = 'Julio-Septiembre';
            // $mes = 9;
            $ultimoDiaMes = '30 DE SEPTIEMBRE DEL ';
        } else if($trimestre == '4'){
            $mnombre = 'Octubre-Diciembre';
            // $mes = 12;
            $ultimoDiaMes = '31 DE DICIEMBRE DEL ';
        }

        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $ejercicio = $this->session->userdata('anio');
        $this->excel->getActiveSheet()->setTitle('Avance de Indicadores');

        $this->excel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A4")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A7")->getFont()->setBold(true);

        $this->excel->getActiveSheet()->mergeCells("A1:I1");
        $this->excel->getActiveSheet()->mergeCells("A2:I2");

        $this->excel->getActiveSheet()->mergeCells("A3:A4");
        $this->excel->getActiveSheet()->mergeCells("B3:B4");
        $this->excel->getActiveSheet()->mergeCells("C3:C4");
        $this->excel->getActiveSheet()->mergeCells("D3:D4");
        $this->excel->getActiveSheet()->mergeCells("E3:E4");
        $this->excel->getActiveSheet()->mergeCells("F3:F4");
        $this->excel->getActiveSheet()->mergeCells("G3:G4");
        $this->excel->getActiveSheet()->mergeCells("H3:I3");

        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $this->excel->getActiveSheet()->setCellValue("A1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio);
        $this->excel->getActiveSheet()->setCellValue("A2", 'INDICADORES DEL TEDF AL  '.$ultimoDiaMes.$ejercicio);

        $this->excel->getActiveSheet()->setCellValue("A3", 'Número de Proyecto');
        $this->excel->getActiveSheet()->setCellValue("B3", 'PERIODO QUE SE REPORTA (MENSUAL, TRIMESTRAL Y ANUAL)');
        $this->excel->getActiveSheet()->setCellValue("C3", 'TIPO DE INDICADOR');
        $this->excel->getActiveSheet()->setCellValue("D3", 'DENOMINACIÓN DEL INDICADOR');
        $this->excel->getActiveSheet()->setCellValue("E3", 'OBJETIVO DEL INDICADOR');
        $this->excel->getActiveSheet()->setCellValue("F3", 'FÓRMULA');
        $this->excel->getActiveSheet()->setCellValue("G3", 'METAS');
        $this->excel->getActiveSheet()->setCellValue("H3", 'RESULTADOS');
        $this->excel->getActiveSheet()->setCellValue("H4", 'TRIMESTRAL');
        $this->excel->getActiveSheet()->setCellValue("I4", 'ACUMULADO');

        $proyectos = $this->home_inicio->get_projects($this->session->userdata('ejercicio'));
        $i = 5;
        foreach($proyectos as $proyecto) {
            $clave = $proyecto->urnum.'-'.$proyecto->ronum.'-'.$proyecto->pgnum.'-'.$proyecto->sbnum.'-'.$proyecto->pynum;
            $this->excel->getActiveSheet()->setCellValue("A".$i, $clave);
            $indicadores = $this->reportes->getIndicadores($proyecto->proyecto_id);
            foreach($indicadores as $indicador){
                $this->excel->getActiveSheet()->setCellValue("B".$i, $indicador->frecuenciaNombre);
                $this->excel->getActiveSheet()->setCellValue("C".$i, $indicador->medidaNombre);
                $this->excel->getActiveSheet()->setCellValue("D".$i, $indicador->indicadorNombre);
                $this->excel->getActiveSheet()->setCellValue("E".$i, $indicador->definicion);
                $this->excel->getActiveSheet()->setCellValue("F".$i, $indicador->metodo_calculo);
                $this->excel->getActiveSheet()->setCellValue("G".$i, $indicador->meta);
                $i++;
            }
        }

        $archivo = "avance_indicadores_".$mnombre.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }

}
