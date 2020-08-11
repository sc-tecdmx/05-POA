<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class matrizMetas extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $models = array(
            'home/home_inicio',
            'reportes',
            'inicio/seguimiento_model'
        );
        $this->load->model($models);
    }

    private function _obtenerNombre($mes)
    {
        switch($mes){
            case 1:
                return 'enero';
                break;
            case 2:
                return 'enero-febrero';
                break;
            case 3:
                return 'enero-marzo';
                break;
            case 4:
                return 'enero-abril';
                break;
            case 5:
                return 'enero-mayo';
                break;
            case 6:
                return 'enero-junio';
                break;
            case 7:
                return 'enero-julio';
                break;
            case 8:
                return 'enero-agosto';
                break;
            case 9:
                return 'enero-septiembre';
                break;
            case 10:
                return 'enero-octubre';
                break;
            case 11:
                return 'enero-noviembre';
                break;
            case 12:
                return 'enero-diciembre';
                break;
        }
    }

    private function _obtenerLetra($mes = false)
    {
        switch ($mes){
            case 1:
                return 'J';
                break;
            case 2:
                return 'K';
                break;
            case 3:
                return 'L';
                break;
            case 4:
                return 'M';
                break;
            case 5:
                return 'N';
                break;
            case 6:
                return 'O';
                break;
            case 7:
                return 'P';
                break;
            case 8:
                return 'Q';
                break;
            case 9:
                return 'R';
                break;
            case 10:
                return 'S';
                break;
            case 11:
                return 'T';
                break;
            case 12:
                return 'U';
                break;
        }
    }

    private function _obtenerUltimaLetra($letra = false)
    {
        switch ($letra){
            case 'J':
                return 'K';
                break;
            case 'K':
                return 'L';
                break;
            case 'L':
                return 'M';
                break;
            case 'M':
                return 'N';
                break;
            case 'N':
                return 'O';
                break;
            case 'O':
                return 'P';
                break;
            case 'P':
                return 'Q';
                break;
            case 'Q':
                return 'R';
                break;
            case 'R':
                return 'S';
                break;
            case 'S':
                return 'T';
                break;
            case 'T':
                return 'U';
                break;
            case 'U':
                return 'V';
                break;
        }
    }

    public function index($mes = false)
    {
        $mnombre = $this->_obtenerNombre($mes);
        $columnas = array('J','K','L','M','N','O','P','Q','R','S','T','U');

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet

		$sheet = $spreadsheet->getActiveSheet();

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
					'borderStyle' => Border::BORDER_THIN,
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

        /* $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath(base_url('/images/logo1-TEDF.png'));
        $objDrawing->setHeight(45);
        $objDrawing->setOffsetX(30);
        $objDrawing->setOffsetY(12);
        $objDrawing->setWorksheet($this->excel->getActiveSheet()); */

        // Definición de encabezados estaticos
        $sheet->mergeCells("A1:O1");
        $sheet->mergeCells("A2:O2");
        $sheet->mergeCells("A3:A4");
        $sheet->mergeCells("B3:B4");
        $sheet->mergeCells("C3:C4");
        $sheet->mergeCells("D3:D4");
        $sheet->mergeCells("E3:E4");
        $sheet->mergeCells("F3:G4");
        $sheet->mergeCells("H3:H4");
        $sheet->mergeCells("I3:I4");

        // Definición de encabezados dinamicos
        $letra = $this->_obtenerLetra($mes);
        $sheet->mergeCells("J3:".$letra.'3');
        $ultimaLetra = $this->_obtenerUltimaLetra($letra);
        $sheet->mergeCells($ultimaLetra."3:".$ultimaLetra."4");
        $sheet->getStyle('A1:'.$ultimaLetra.'2')->applyFromArray($styleArray);
		$sheet->getStyle('A3:'.$ultimaLetra.'4')->applyFromArray($estilo_encabezado);

        $sheet->setCellValue("A1", 'PROGRAMA OPERATIVO ANUAL '.$this->session->userdata('anio'));
        $sheet->setCellValue("A2", 'AVANCE DE PROYECTOS');

        $sheet->setCellValue("A3", 'URG');
        $sheet->setCellValue("B3", 'RO');
        $sheet->setCellValue("C3", 'PG');
        $sheet->setCellValue("D3", 'SP');
        $sheet->setCellValue("E3", 'PY');
        $sheet->setCellValue("F3", 'Denominación');
        $sheet->setCellValue("H3", 'Unidad de medida');
        $sheet->setCellValue("I3", 'Meta');
        $sheet->setCellValue("J3", 'Meses');

        for($j = 1; $j <= $mes; $j++){
            $nombreMes = $this->home_inicio->getMesesSmall($j);
            if($nombreMes){
                $sheet->setCellValue($columnas[$j-1]."4", $nombreMes->small);
            }
        }

        $sheet->setCellValue($ultimaLetra."3", 'Total');

        $programas = $this->reportes->getProgramas($this->session->userdata('ejercicio'));
        $i = 4;
        foreach($programas as $programa) {
            $i++;
            $sheet->mergeCells('F'.$i.':G'.$i);
            $sheet->setCellValue("C".$i, $programa->numero);
            $sheet->setCellValue("F".$i, $programa->nombre);
            $sheet->getStyle('A'.$i.':'.$ultimaLetra.$i)->applyFromArray($estilo_programas);
            $sheet->getStyle('A'.$i.':'.$ultimaLetra.$i)->applyFromArray($estilo_bordes_internos);
            $subprogramas = $this->reportes->getSubprogramas($programa->programa_id);
            foreach($subprogramas as $subprograma){
                $i++;
                $sheet->mergeCells('F'.$i.':G'.$i);
                $sheet->setCellValue("D".$i, $subprograma->numero);
                $sheet->setCellValue("F".$i, $subprograma->nombre);
                $sheet->getStyle('A'.$i.':'.$ultimaLetra.$i)->applyFromArray($estilo_subprogramas);
                $sheet->getStyle('A'.$i.':'.$ultimaLetra.$i)->applyFromArray($estilo_bordes_internos);
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

                    $sheet->getStyle('A'.$i.':'.$ultimaLetra.$i)->applyFromArray($estilo_proyectos);
                    $sheet->getStyle('A'.$i.':'.$ultimaLetra.$i)->applyFromArray($estilo_bordes_internos);

                    $metas = $this->reportes->getMetas($proyecto->proyecto_id);
                    foreach($metas as $meta){
                        $i++;
                        $indice = $i + 1;
                        $sheet->getStyle('A'.$i.':'.$ultimaLetra.$indice)->applyFromArray($estilo_bordes_internos);

                        $sheet->mergeCells("A". $i .":A". $indice);
                        $sheet->mergeCells("B". $i .":B". $indice);
                        $sheet->mergeCells("C". $i .":C". $indice);
                        $sheet->mergeCells("D". $i .":D". $indice);
                        $sheet->mergeCells("E". $i .":E". $indice);
                        $sheet->mergeCells("F". $i .":F". $indice);
                        $sheet->mergeCells("G". $i .":G". $indice);
                        $sheet->mergeCells("H". $i .":H". $indice);

                        /* for($j = 1; $j <= $mes; $j++){
                            $this->excel->getActiveSheet()->mergeCells($columnas[$j-1].$i.":".$columnas[$j-1].$indice);
                        } */

                        // $metat = $meta->tipo == 'principal' ? 'MP' : 'MC';
						if($meta->tipo == 'principal'){
							$metat = 'MP';
							$sheet->getStyle('A'.$i.':'.$ultimaLetra.$indice)->applyFromArray($estilo_meta_principal);
						} else {
							$metat = 'MC';
						}
                        $tituloP = $meta->porcentajes == '1' ? 'Atendido':'Programado';
                        $tituloA = $meta->porcentajes == '1' ? 'Recibido':'Alcanzado';
                        $tabla = $meta->porcentajes == '1' ? 'meses_metas_complementarias_resueltos':'meses_metas_programadas';

                        $sheet->setCellValue("F".$i, $metat);
                        $sheet->setCellValue("G".$i, $meta->nombre);
                        $sheet->setCellValue("H".$i, $meta->umnom);
                        $sheet->setCellValue("I".$i, $tituloP);
                        $sheet->setCellValue("I".$indice, $tituloA);


                        // Obtener el avance del mes
                        $totalProgramado = 0;
                        $totalAlcanzados = 0;
                        for($j = 1; $j <= $mes; $j++){
                            $programado = $this->reportes->getAvanceMesProgramado($j, $meta->meta_id, $tabla);
                            $alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);

                            $sheet->setCellValue($columnas[$j-1].$i, $programado?$programado->numero:'');
                            $sheet->setCellValue($columnas[$j-1].$indice, $alcanzado?$alcanzado->numero:'');
                            
                            if($meta->tipo != 'principal') {
                                $sheet->getComment($columnas[$j-1].$indice)->getText()->createTextRun($alcanzado?$alcanzado->explicacion:'');
                            }

                            $totalProgramado += $programado?$programado->numero:0;
                            $totalAlcanzados += $alcanzado?$alcanzado->numero:0;
                        }
                        $sheet->setCellValue($ultimaLetra.$i, $totalProgramado);
                        $sheet->setCellValue($ultimaLetra.$indice, $totalAlcanzados);
                        $i++;
                    }
                }
            }
        }

		$writer = new Xlsx($spreadsheet); // instantiate Xlsx

		$filename = 'matriz_avance_'.$mnombre; // set filename for excel file to be exported

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');    // download file
    }
}
