<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class aperturaProgramatica extends MX_Controller
{

    function __construct() {
        parent::__construct();
        $models = array(
            'reportes',
        );
        $this->load->model($models);
    }

    public function index() {

        $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet

        $sheet = $spreadsheet->getActiveSheet();
        $ejercicio = $this->session->userdata('ejercicio');
        $sheet->setTitle('Apertura Programatica '.$ejercicio->ejercicio);

        // Estilos
		$styleArray = array(
			'font' => array(
				'type' => 'Arial',
				'bold' => true,
				'size' => 12
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_CENTER,
			),
		);

		$estilo_izquierdo = array(
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_TOP,
			),
		);

		$estilo_bordes_internos = array(
			'borders' => array(
				'allBorders' => array(
					'borderStyle' => Border::BORDER_THIN,
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
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
			'fill' => array(
				'fillType' => Fill::FILL_SOLID,
				'rotation' => 90,
				'startColor' => array(
					'argb' => '00000000'
				),
			),
			'borders' => array(
				'outline' => array(
					'borderStyle' => Border::BORDER_THIN,
					'color' => array('argb' => '00FFFFFF')
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
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
			'fill' => array(
				'type' => Fill::FILL_SOLID,
				'rotation' => 90,
				'startcolor' => array(
					'argb' => 'FFFFFFFF',
				),
			),
			'borders' => array(
				'outline' => array(
					'style' => Border::BORDER_THIN,
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
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
			'fill' => array(
				'fillType' => Fill::FILL_SOLID,
				'rotation' => 90,
				'startColor' => array(
					'argb' => 'FF244062'
				),
			),
			'borders' => array(
				'outline' => array(
					'style' => Border::BORDER_THIN,
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
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
			'fill' => array(
				'fillType' => Fill::FILL_SOLID,
				'rotation' => 90,
				'startColor' => array(
					'argb' => 'FFA5D6FE',
				),
			),
			'borders' => array(
				'outline' => array(
					'style' => Border::BORDER_THIN,
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
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
			'fill' => array(
				'fillType' => Fill::FILL_SOLID,
				'rotation' => 90,
				'startColor' => array(
					'argb' => 'FFD8E4BC',
				),
			),
			'borders' => array(
				'outline' => array(
					'style' => Border::BORDER_THIN,
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
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
			'fill' => array(
				'fillType' => Fill::FILL_SOLID,
				'rotation' => 90,
				'startColor' => array(
					'argb' => 'FFEEECE1',
				),
			),
			'borders' => array(
				'outline' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			)
		);

        $sheet->getStyle("B1")->getFont()->setBold(true);
        $sheet->getStyle("B2")->getFont()->setBold(true);
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->getStyle("A5")->getFont()->setBold(true);
        $sheet->getStyle("A6")->getFont()->setBold(true);
        $sheet->getStyle("A7")->getFont()->setBold(true);

        $sheet->mergeCells("B1:R1");
        $sheet->mergeCells("B2:R2");
        $sheet->mergeCells("A3:A4");
        $sheet->mergeCells("B3:B4");
        $sheet->mergeCells("C3:C4");
        $sheet->mergeCells("D3:D4");
        $sheet->mergeCells("E3:E4");
        $sheet->mergeCells("F3:G4");
        $sheet->mergeCells("H3:H4");
        $sheet->mergeCells("I3:T3");
        $sheet->mergeCells("U3:U4");

        $sheet->getStyle('B1:R2')->applyFromArray($styleArray);
		$sheet->getStyle('A3:U4')->applyFromArray($estilo_encabezado);

        $sheet->setCellValue("B1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio->ejercicio);
        $sheet->setCellValue("B2", 'PROYECTOS');

        $sheet->setCellValue("A3", 'URG');
        $sheet->setCellValue("B3", 'RO');
        $sheet->setCellValue("C3", 'PG');
        $sheet->setCellValue("D3", 'SP');
        $sheet->setCellValue("E3", 'PY');
        $sheet->setCellValue("F3", 'Denominación');
        $sheet->setCellValue("H3", 'Unidad de medida');
        $sheet->setCellValue("I4", 'Ene');
        $sheet->setCellValue("J4", 'Feb');
        $sheet->setCellValue("K4", 'Mar');
        $sheet->setCellValue("L4", 'Abr');
        $sheet->setCellValue("M4", 'May');
        $sheet->setCellValue("N4", 'Jun');
        $sheet->setCellValue("O4", 'Jul');
        $sheet->setCellValue("P4", 'Ago');
        $sheet->setCellValue("Q4", 'Sep');
        $sheet->setCellValue("R4", 'Oct');
        $sheet->setCellValue("S4", 'Nov');
        $sheet->setCellValue("T4", 'Dic');
        $sheet->setCellValue("U3", 'Total');

        $programas = $this->reportes->getProgramas($this->session->userdata('ejercicio'));
        $i = 5;
        foreach($programas as $programa) {
            $sheet->setCellValue("C".$i, $programa->numero);
            $sheet->setCellValue("F".$i, $programa->nombre);
            $subprogramas = $this->reportes->getSubprogramas($programa->programa_id);
            // echo json_encode($programas);
            // print_r($subprogramas);
            // $lonsub = count($subprogramas);
            foreach($subprogramas as $subprograma){
            // for($j = 0; $j < $lonsub; $j++){
                $i++;
                $sheet->setCellValue("D".$i, $subprograma->numero);
                $sheet->setCellValue("F".$i, $subprograma->nombre);
                $proyectos = $this->reportes->getProyectos($subprograma->subprograma_id);
                // $lonpry = count($proyectos);
                foreach($proyectos as $proyecto){
                //for($k = 0; $k < $lonpry; $k++){
                    $i++;
                    $sheet->setCellValue("A".$i, $proyecto->urnum);
                    $sheet->setCellValue("B".$i, $proyecto->ronum);
                    $sheet->setCellValue("C".$i, $proyecto->pgnum);
                    $sheet->setCellValue("D".$i, $proyecto->sbnum);
                    $sheet->setCellValue("E".$i, $proyecto->pynum);

                    $sheet->mergeCells("F".$i.":G".$i);
                    $sheet->setCellValue("F".$i, $proyecto->pynom);

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
                        $sheet->setCellValue("F".$i, $metat);
                        $sheet->setCellValue("G".$i, $meta->nombre);
                        $sheet->setCellValue("H".$i, $meta->umnom);
                        $programadas = $this->reportes->getProgramadas($meta->meta_id);
                        $lonprg = count($programadas);
                        $arrm = ['I','J','K','L','M','N','O','P','Q','R','S','T'];
                        $j = 0;
                        $total = 0;
                        foreach($programadas as $programada){
                        // for($m = 0; $m < $lonprg; $m++){
                            $sheet->setCellValue($arrm[$j].$i, $programada->numero);
                            $total += $programada->numero;
                            $j++;
                        }
                        $sheet->setCellValue("U".$i, $total);
                    }
                }
            }
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'apertura_programatica_'.$ejercicio;

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');    // download file

        /* $archivo = "apertura_programatica_".$ejercicio->ejercicio.".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output'); */
    }

}
