<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


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

		if (file_exists($logo = __DIR__.'/../../../../img/logo-te-sin-fondo_0.png')) {
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

        // Definición de encabezados dinamicos
        $letra = $this->_obtenerLetra($mes);
        $sheet->mergeCells("J4:".$letra.'4');
        $ultimaLetra = $this->_obtenerUltimaLetra($letra);

		// Definición de encabezados estaticos
		$sheet->mergeCells("A1:".$ultimaLetra."1");
		$sheet->mergeCells("A2:".$ultimaLetra."2");
		$sheet->mergeCells("A3:".$ultimaLetra."3");
		$sheet->mergeCells("A4:A5");
		$sheet->mergeCells("B4:B5");
		$sheet->mergeCells("C4:C5");
		$sheet->mergeCells("D4:D5");
		$sheet->mergeCells("E4:E5");
		$sheet->mergeCells("F4:G5");
		$sheet->mergeCells("H4:H5");
		$sheet->mergeCells("I4:I5");

        $sheet->mergeCells($ultimaLetra."4:".$ultimaLetra."5");
        $sheet->getStyle('A1:'.$ultimaLetra.'2')->applyFromArray($styleArray);
		$sheet->getStyle('A4:'.$ultimaLetra.'5')->applyFromArray($estilo_encabezado);

        $sheet->setCellValue("A1", 'PROGRAMA OPERATIVO ANUAL '.$this->session->userdata('anio'));
        $sheet->setCellValue("A2", 'AVANCE DE PROYECTOS');

        $sheet->setCellValue("A4", 'URG');
        $sheet->setCellValue("B4", 'RO');
        $sheet->setCellValue("C4", 'PG');
        $sheet->setCellValue("D4", 'SP');
        $sheet->setCellValue("E4", 'PY');
        $sheet->setCellValue("F4", 'Denominación');
        $sheet->setCellValue("H4", 'Unidad de medida');
        $sheet->setCellValue("I4", 'Meta');
        $sheet->setCellValue("J4", 'Meses');

        for($j = 1; $j <= $mes; $j++){
            $nombreMes = $this->home_inicio->getMesesSmall($j);
            if($nombreMes){
                $sheet->setCellValue($columnas[$j-1]."5", $nombreMes->small);
				$sheet->getColumnDimension($columnas[$j-1])->setWidth(6);
            }
        }

        $sheet->setCellValue($ultimaLetra."4", 'Total');
		$sheet->getColumnDimension($ultimaLetra)->setWidth(6);

        $programas = $this->reportes->getProgramas($this->session->userdata('ejercicio'));
        $i = 5;
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

					$sheet->getStyle('F' . $i)->getAlignment()->setWrapText(true);
					$caracteres_nombre_proyecto = strlen($proyecto->pynom);
					if ($caracteres_nombre_proyecto > 93) {
						$sheet->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_proyecto / 93) * 13 + 13);
					}

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
						if($meta->tipo == 'principal' || $meta->tipo == 'Principal'){
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

						$caracteres_nombre_meta = strlen($meta->nombre);
						if ($caracteres_nombre_meta > 89) {
							$sheet->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_meta / 89) * 14 + 14);
						}

						// Mejorar formato de celdas (denominacion de meta y unidad de medida)
						$sheet->getStyle('G' . $i)->getAlignment()->setWrapText(true);
						$sheet->getStyle('H' . $i)->getAlignment()->setWrapText(true);

						$uno = $sheet->getRowDimension($i)->getRowHeight();
						$dos = $sheet->getRowDimension($i + 1)->getRowHeight();

						$altura = ($uno + $dos) / 2;
						$sheet->getRowDimension($i)->setRowHeight($altura);
						$sheet->getRowDimension($i + 1)->setRowHeight($altura);


                        // Obtener el avance del mes
                        $totalProgramado = 0;
                        $totalAlcanzados = 0;
                        for($j = 1; $j <= $mes; $j++){
                            $programado = $this->reportes->getAvanceMesProgramado($j, $meta->meta_id, $tabla);
                            $alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);

                            $sheet->setCellValue($columnas[$j-1].$i, $programado?$programado->numero:'');
                            $sheet->setCellValue($columnas[$j-1].$indice, $alcanzado?$alcanzado->numero:'');

                            if($meta->tipo != 'principal' || $meta->tipo != 'Principal') {
								$sheet->getComment($columnas[$j-1].$indice)->setAuthor('TECDMX');
								$commentRichText = $sheet
									->getComment($columnas[$j-1].$indice)
									->getText()->createTextRun('Explicación:');
								$commentRichText->getFont()->setBold(true);
								$spreadsheet->getActiveSheet()
									->getComment($columnas[$j-1].$indice)
									->getText()->createTextRun("\r\n");
                                $sheet->getComment($columnas[$j-1].$indice)->getText()->createTextRun($alcanzado?$alcanzado->explicacion:'');
								$sheet->getComment($columnas[$j-1].$indice)->setWidth('252pt');

								if ($alcanzado) {
									$caracteres_explicacion = strlen($alcanzado->explicacion);
									if ($caracteres_explicacion > 56) {
										$sheet->getComment($columnas[$j-1].$indice)->setHeight(ceil($caracteres_explicacion / 53) * 17 + 32 . "pt");
									} else {
										$sheet->getComment($columnas[$j-1].$indice)->setHeight('32pt');
									}
								}
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

		$sheet->getColumnDimension('A')->setWidth(4);
		$sheet->getColumnDimension('B')->setWidth(3);
		$sheet->getColumnDimension('C')->setWidth(3);
		$sheet->getColumnDimension('D')->setWidth(3);
		$sheet->getColumnDimension('E')->setWidth(3);
		$sheet->getColumnDimension('F')->setWidth(3);
		$sheet->getColumnDimension('G')->setWidth(70);
		$sheet->getColumnDimension('H')->setWidth(20);
		$sheet->getColumnDimension('I')->setWidth(16);

		$writer = new Xlsx($spreadsheet); // instantiate Xlsx

		$filename = 'matriz_avance_'.$mnombre; // set filename for excel file to be exported

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');    // download file
    }
}
