<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class avanceTrimestral extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'reportes',
            'inicio/seguimiento_model',
            'home/home_inicio'
        );
        $this->load->model($models);
    }

    public function index($trimestre = false)
    {
        if($trimestre == '1'){
            $mnombre = 'Enero-Marzo';
            $mes = 3;
        } else if($trimestre == '2'){
            $mnombre = 'Abril-Junio';
            $mes = 6;
        } else if($trimestre == '3'){
            $mnombre = 'Julio-Septiembre';
            $mes = 9;
        } else if($trimestre == '4'){
            $mnombre = 'Octubre-Diciembre';
            $mes = 12;
        }


		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$sheet = $spreadsheet->getActiveSheet();

		if (file_exists($logo = __DIR__.'/../../../../images/logo11-TEDF.png')) {
			$drawing = new Drawing();
			$drawing->setName('Logo');
			$drawing->setDescription('Logo');
			$drawing->setPath($logo);
			$drawing->setCoordinates('A1');
			$drawing->setHeight(55);
			$drawing->setOffsetX(55);
			$drawing->setOffsetY(7);
			$drawing->setWorksheet($sheet);
		}

        $ejercicio = $this->home_inicio->get_ejercicio();
        $sheet->setTitle('Avance Trimestral y Acumulado');

        // Estilos
        $styleArray = array(
            'font' => array(
                'type' => 'Arial',
                'bold' => true,
                'size' => 12
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
        );

        $estilo_izquierdo = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ),
        );

        $estilo_bordes_internos = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $estilo_encabezado = array(
            'font' => array(
                'size' => 10,
                'color' => array(
                    'argb' => 'FFFFFFFF',
                ),
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FF000000',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '00FFFFFF'),
                ),
            ),
        );

        $estilo_celda = array(
            'font' => array(
                'size' => 9,
                'color' => array(
                    'argb' => 'FF000000',
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFFFFFFF',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $estilo_programas = array(
            'font' => array(
                'size' => 10,
                'color' => array(
                    'argb' => 'FFFFFFFF',
                ),
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FF244062',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $estilo_subprogramas = array(
            'font' => array(
                'size' => 10,
                'color' => array(
                    'argb' => 'FF000000',
                ),
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFA5D6FE',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $estilo_proyectos = array(
            'font' => array(
                'size' => 9,
                'color' => array(
                    'argb' => 'FF000000',
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFD8E4BC',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $estilo_meta_principal = array(
            'font' => array(
                'size' => 9,
                'color' => array(
                    'argb' => 'FF000000',
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFEEECE1',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        /* $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(base_url('/images/logo1-TEDF.png'));
        $objDrawing->setHeight(45);
        $objDrawing->setOffsetX(30);
        $objDrawing->setOffsetY(12);
        $objDrawing->setWorksheet($this->excel->getActiveSheet()); */

        /* $this->excel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A4")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A7")->getFont()->setBold(true); */

        $sheet->mergeCells("A1:N1");
        $sheet->mergeCells("A2:N2");
        $sheet->mergeCells("A3:N3");
        $sheet->mergeCells("A4:A6");
        $sheet->mergeCells("B4:B6");
        $sheet->mergeCells("C4:C6");
        $sheet->mergeCells("D4:D6");
        $sheet->mergeCells("E4:E6");
        $sheet->mergeCells("F4:G6");
        $sheet->mergeCells("H4:H6");
        $sheet->mergeCells("I4:K4");
        $sheet->mergeCells("I5:I6");
        $sheet->mergeCells("J5:J6");
        $sheet->mergeCells("K5:K6");
        $sheet->mergeCells("L4:N4");
        $sheet->mergeCells("L5:L6");
        $sheet->mergeCells("M5:M6");
        $sheet->mergeCells("N5:N6");

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $sheet->setCellValue("A1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio->ejercicio);
        $sheet->setCellValue("A2", 'AVANCE DE PROYECTOS AL '.$ejercicio->ejercicio);
        $sheet->setCellValue("A3", 'Metas Principales y Complementarias');

        $sheet->setCellValue("A4", 'URG');
        $sheet->setCellValue("B4", 'RO');
        $sheet->setCellValue("C4", 'PG');
        $sheet->setCellValue("D4", 'SP');
        $sheet->setCellValue("E4", 'PY');
        $sheet->setCellValue("F4", 'Denominación');
        $sheet->setCellValue("H4", 'Unidad de medida');
        $sheet->setCellValue("I4", 'Avance Trimestral '.$mnombre);
        $sheet->setCellValue("L4", 'Avance Acumulado '.$mnombre);
        $sheet->setCellValue("I5", 'Programada (1)');
        $sheet->setCellValue("J5", 'Alcanzada (2)');
        $sheet->setCellValue("K5", 'Avance % (2)(1)');
        $sheet->setCellValue("L5", 'Programada (3)');
        $sheet->setCellValue("M5", 'Alcanzda (4)');
        $sheet->setCellValue("N5", 'Avance % (4)(3)');

        $programas = $this->reportes->getProgramas($this->session->userdata('ejercicio'));
        $i = 7;
        foreach($programas as $programa) {
            $sheet->setCellValue("C".$i, $programa->numero);
            $sheet->setCellValue("F".$i, $programa->nombre);
            $subprogramas = $this->reportes->getSubprogramas($programa->programa_id);
            foreach($subprogramas as $subprograma){
                $i++;
                $sheet->setCellValue("D".$i, $subprograma->numero);
                $sheet->setCellValue("F".$i, $subprograma->nombre);
                $proyectos = $this->reportes->getProyectos($subprograma->subprograma_id);
                foreach($proyectos as $proyecto){
                    $i++;
                    $sheet->setCellValue("A".$i, $proyecto->urnum);
                    $sheet->setCellValue("B".$i, $proyecto->ronum);
                    $sheet->setCellValue("C".$i, $proyecto->pgnum);
                    $sheet->setCellValue("D".$i, $proyecto->sbnum);
                    $sheet->setCellValue("E".$i, $proyecto->pynum);

                    $sheet->mergeCells("F".$i.":G".$i);
                    $sheet->setCellValue("F".$i, $proyecto->pynom);

                    $metas = $this->reportes->getMetas($proyecto->proyecto_id);
                    foreach($metas as $meta){
                        $i++;
                        if($meta->tipo == 'principal'){
                            $metat = 'MP';
                        } else {
                            $metat = 'MC';
                        }
                        $sheet->setCellValue("F".$i, $metat);
                        $sheet->setCellValue("G".$i, $meta->nombre);
                        $sheet->setCellValue("H".$i, $meta->umnom);
                        // Obtener el avance del mes acorde al trimestre seleccionado
                        $programadoNumero = 0;
                        $alcanzadoNumero = 0;
                        $alcanzadoPorcentaje = 0;
                        $numeroResueltos = 0;
                        if($mes == '3'){
                            for($j = 1; $j <= 3; $j++){
                                $programado = $this->seguimiento_model->getAvanceMesProgramado($j, $meta->meta_id);
                                $alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);
                                $programadoNumero += $programado->numero;
                                $alcanzadoNumero += $alcanzado->numero;
                                $alcanzadoPorcentaje += $alcanzado->porcentaje_real;
                                if($meta->tipo != 'principal' && $meta->porcentajes == '1'){
                                    $resuelto = $this->reportes->getAvanceMesResuelto($j, $meta->meta_id);
                                    $numeroResueltos += $resuelto->numero?$resuelto->numero:0;
                                }
                            }
                        } else if ($mes == '6') {
                            for($j = 4; $j <= 6; $j++){
                                $programado = $this->seguimiento_model->getAvanceMesProgramado($j, $meta->meta_id);
                                $alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);
                                $programadoNumero += $programado->numero;
                                $alcanzadoNumero += $alcanzado->numero;
                                $alcanzadoPorcentaje += $alcanzado->porcentaje_real;
                                if($meta->tipo != 'principal' && $meta->porcentajes == '1'){
                                    $resuelto = $this->reportes->getAvanceMesResuelto($j, $meta->meta_id);
                                    $numeroResueltos += $resuelto->numero;
                                }
                            }
                        } else if($mes == '9') {
                            for($j = 7; $j <= 9; $j++){
                                $programado = $this->seguimiento_model->getAvanceMesProgramado($j, $meta->meta_id);
                                $alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);
                                $programadoNumero += $programado->numero;
                                $alcanzadoNumero += $alcanzado->numero;
                                $alcanzadoPorcentaje += $alcanzado->porcentaje_real;
                                if($meta->tipo != 'principal' && $meta->tipo != 'principal' &&$meta->tipo != 'principal' &&$meta->tipo != 'principal' &&$meta->porcentajes == '1'){
                                    $resuelto = $this->reportes->getAvanceMesResuelto($j, $meta->meta_id);
                                    $numeroResueltos += $resuelto->numero;
                                }
                            }
                        } else if($mes == '12') {
                            for($j = 10; $j <= 12; $j++){
                                $programado = $this->seguimiento_model->getAvanceMesProgramado($j, $meta->meta_id);
                                $alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);
                                $programadoNumero += $programado->numero;
                                $alcanzadoNumero += $alcanzado->numero;
                                $alcanzadoPorcentaje += $alcanzado->porcentaje_real;
                                if($meta->tipo != 'principal' && $meta->porcentajes == '1'){
                                    $resuelto = $this->reportes->getAvanceMesResuelto($j, $meta->meta_id);
                                    $numeroResueltos += $resuelto->numero;
                                }
                            }
                        }
                        $sheet->setCellValue("I".$i, $programadoNumero);
                        if($numeroResueltos == 0){
                            $sheet->setCellValue("J".$i, $alcanzadoNumero);
                            $sheet->setCellValue("K".$i, $alcanzadoPorcentaje);
                        } else {
                            $sheet->setCellValue("J".$i, $alcanzadoNumero.'/'.$numeroResueltos);
                            $sheet->setCellValue("K".$i, $alcanzadoPorcentaje);
                        }
                        // Obtener el avance acumulado desde enero
                        $acumuladoProgramado = 0;
                        $acumuladoAlcanzado = 0;
                        $acumuladoPorcentaje = 0;
                        /* for($j = 1; $j <= $mes; $j++){
                            $acumulado = $this->seguimiento_model->getAvanceProgramadoAcumulado($j, $meta->meta_id);
                            $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($j, $meta->meta_id);
                            $pacm = $this->seguimiento_model->getPorcentajeAcumulado($meta->meta_id, $j);
                            $acumuladoProgramado += $acumulado->numero;
                            $acumuladoAlcanzado += $acumuladoa->numero;
                            $acumuladoPorcentaje += $pacm->porcentaje_real;
                        } */
                        $acumulado = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $meta->meta_id);
                        $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $meta->meta_id);
                        $pacm = $this->seguimiento_model->getPorcentajeAcumulado($meta->meta_id, $mes);
                        $sheet->setCellValue("L".$i, $acumulado->numero);
                        $sheet->setCellValue("M".$i, $acumuladoa->numero);
                        $sheet->setCellValue("N".$i, $pacm->porcentaje_real);
                    }
                }
            }
        }

        /* $archivo = "avance_trimestral_".$mnombre.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output'); */

		$writer = new Xlsx($spreadsheet); // instantiate Xlsx

		$filename = 'avance_trimestral_'.$mnombre; // set filename for excel file to be exported

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');    // download file
    }
}
