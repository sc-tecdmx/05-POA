<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet

		$sheet = $spreadsheet->getActiveSheet();

        // $this->excel->setActiveSheetIndex(0);
        $ejercicio = $this->session->userdata('anio');
        $sheet->setTitle('Avance de Indicadores');

        $sheet->getStyle("B1")->getFont()->setBold(true);
        $sheet->getStyle("B2")->getFont()->setBold(true);
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->getStyle("A5")->getFont()->setBold(true);
        $sheet->getStyle("A6")->getFont()->setBold(true);
        $sheet->getStyle("A7")->getFont()->setBold(true);

        $sheet->mergeCells("A1:I1");
        $sheet->mergeCells("A2:I2");

        $sheet->mergeCells("A3:A4");
        $sheet->mergeCells("B3:B4");
        $sheet->mergeCells("C3:C4");
        $sheet->mergeCells("D3:D4");
        $sheet->mergeCells("E3:E4");
        $sheet->mergeCells("F3:F4");
        $sheet->mergeCells("G3:G4");
        $sheet->mergeCells("H3:I3");

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $sheet->setCellValue("A1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio);
        $sheet->setCellValue("A2", 'INDICADORES DEL TEDF AL  '.$ultimoDiaMes.$ejercicio);

        $sheet->setCellValue("A3", 'Número de Proyecto');
        $sheet->setCellValue("B3", 'PERIODO QUE SE REPORTA (MENSUAL, TRIMESTRAL Y ANUAL)');
        $sheet->setCellValue("C3", 'TIPO DE INDICADOR');
        $sheet->setCellValue("D3", 'DENOMINACIÓN DEL INDICADOR');
        $sheet->setCellValue("E3", 'OBJETIVO DEL INDICADOR');
        $sheet->setCellValue("F3", 'FÓRMULA');
        $sheet->setCellValue("G3", 'METAS');
        $sheet->setCellValue("H3", 'RESULTADOS');
        $sheet->setCellValue("H4", 'TRIMESTRAL');
        $sheet->setCellValue("I4", 'ACUMULADO');

        $proyectos = $this->home_inicio->get_projects($this->session->userdata('ejercicio'));
        $i = 5;
        foreach($proyectos as $proyecto) {
            $clave = $proyecto->urnum.'-'.$proyecto->ronum.'-'.$proyecto->pgnum.'-'.$proyecto->sbnum.'-'.$proyecto->pynum;
            $sheet->setCellValue("A".$i, $clave);
            $indicadores = $this->reportes->getIndicadores($proyecto->proyecto_id);
            foreach($indicadores as $indicador){
                $sheet->setCellValue("B".$i, $indicador->frecuenciaNombre);
                $sheet->setCellValue("C".$i, $indicador->medidaNombre);
                $sheet->setCellValue("D".$i, $indicador->indicadorNombre);
                $sheet->setCellValue("E".$i, $indicador->definicion);
                $sheet->setCellValue("F".$i, $indicador->metodo_calculo);
                $sheet->setCellValue("G".$i, $indicador->meta);
                $i++;
            }
        }

        /* header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output'); */

		$writer = new Xlsx($spreadsheet); // instantiate Xlsx

		$filename = 'avance_indicadores_'.$mnombre; // set filename for excel file to be exported

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');    // download file
    }

}
