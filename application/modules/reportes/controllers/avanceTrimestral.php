<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
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
        // $sheet->setActiveSheetIndex(0);
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

		/* $logo = base_url('images/logo1-TEDF.png');
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$drawing->setPath($logo);
		$drawing->setCoordinates('A1:B1');
		$drawing->setOffsetX(110);
		$drawing->setRotation(25);
		$drawing->getShadow()->setVisible(true);
		$drawing->getShadow()->setDirection(45); */

        $sheet->getStyle("B1")->getFont()->setBold(true);
        $sheet->getStyle("B2")->getFont()->setBold(true);
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->getStyle("A5")->getFont()->setBold(true);
        $sheet->getStyle("A6")->getFont()->setBold(true);
        $sheet->getStyle("A7")->getFont()->setBold(true);

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

		$sheet->getStyle('A1:N3')->applyFromArray($styleArray);
		$sheet->getStyle('A4:N6')->applyFromArray($estilo_encabezado);

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
        $sheet->setCellValue("I5", 'Programada o Recibido (1)');
        $sheet->setCellValue("J5", 'Alcanzada o Atendido (2)');
        $sheet->setCellValue("K5", 'Avance % (2)(1)');
        $sheet->setCellValue("L5", 'Programada o Recibido (3)');
        $sheet->setCellValue("M5", 'Alcanzda o Atendido (4)');
        $sheet->setCellValue("N5", 'Avance % (4)(3)');

        $programas = $this->reportes->getProgramas($this->session->userdata('ejercicio'));
        $i = 6;
        foreach($programas as $programa) {
			$i++;
			$sheet->mergeCells('F'.$i.':G'.$i);
            $sheet->setCellValue("C".$i, $programa->numero);
            $sheet->setCellValue("F".$i, $programa->nombre);
			$sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($estilo_programas);
			$sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($estilo_bordes_internos);
			$sheet->getStyle('A'.$i.':N'.$i)->getAlignment()->setWrapText(true);
            $subprogramas = $this->reportes->getSubprogramas($programa->programa_id);
            foreach($subprogramas as $subprograma){
				$i++;
				$sheet->mergeCells('F'.$i.':G'.$i);
                $sheet->setCellValue("D".$i, $subprograma->numero);
                $sheet->setCellValue("F".$i, $subprograma->nombre);
				$sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($estilo_subprogramas);
				$sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($estilo_bordes_internos);
				$sheet->getStyle('A'.$i.':N'.$i)->getAlignment()->setWrapText(true);
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
					$sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($estilo_proyectos);
					$sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($estilo_bordes_internos);
					$sheet->getStyle('A'.$i.':N'.$i)->getAlignment()->setWrapText(true);

                    $metas = $this->reportes->getMetas($proyecto->proyecto_id);
                    foreach($metas as $meta){
						$i++;
						$sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($estilo_bordes_internos);
                        if($meta->tipo == 'principal'){
                            $metat = 'MP';
							$sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($estilo_meta_principal);
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
                            $primerMes = 1;
                        } else if ($mes == '6') {
                            $primerMes = 4;
                        } else if($mes == '9') {
                            $primerMes = 7;
                        } else if($mes == '12') {
                            $primerMes = 10;
                        }

						for($j = $primerMes; $j <= $mes; $j++){
							if($meta->porcentajes == '1'){
								$programado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);
								$alcanzado = $this->reportes->getAvanceMesResuelto($j, $meta->meta_id);
								$programadoNumero += $programado->numero;
								$alcanzadoNumero += $alcanzado?$alcanzado->numero:0;
								$alcanzadoPorcentaje += $programado->porcentaje;
							} else {
								$programado = $this->seguimiento_model->getAvanceMesProgramado($j, $meta->meta_id);
								$alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);
								$programadoNumero += $programado->numero;
								$alcanzadoNumero += $alcanzado->numero;
								$alcanzadoPorcentaje += $alcanzado->porcentaje;
							}
						}
						$sheet->setCellValue("I".$i, $programadoNumero);
						$sheet->setCellValue("J".$i, $alcanzadoNumero);
						$sheet->setCellValue("K".$i, $alcanzadoPorcentaje);

						if($meta->porcentajes == '1'){
							$acumulado = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $meta->meta_id);
							$acumuladoa = $this->seguimiento_model->getAvanceResueltoAcumulado($mes, $meta->meta_id);
						} else {
							$acumulado = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $meta->meta_id);
							$acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $meta->meta_id);
						}
						$pacm = $this->seguimiento_model->getPorcentajeAcumulado($meta->meta_id, $mes);
						
                        $sheet->setCellValue("L".$i, $acumulado->numero);
                        $sheet->setCellValue("M".$i, $acumuladoa->numero);
                        $sheet->setCellValue("N".$i, $pacm->porcentaje);
                    }
                }
            }
        }

		$writer = new Xlsx($spreadsheet); // instantiate Xlsx

		$filename = 'avance_trimestral_'.$mnombre; // set filename for excel file to be exported

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');    // download file
    }
}
