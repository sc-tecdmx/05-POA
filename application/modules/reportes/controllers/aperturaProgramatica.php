<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

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

        $ejercicio = $this->session->userdata('ejercicio');
        // $sheet->setTitle('Apertura Programatica '.$this->session->userdata('anio'));

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

		$sheet->getColumnDimension('A')->setWidth(4);
		$sheet->getColumnDimension('B')->setWidth(3);
		$sheet->getColumnDimension('C')->setWidth(3);
		$sheet->getColumnDimension('D')->setWidth(3);
		$sheet->getColumnDimension('E')->setWidth(3);
		$sheet->getColumnDimension('F')->setWidth(3);
		$sheet->getColumnDimension('G')->setWidth(70);
		$sheet->getColumnDimension('H')->setWidth(30);
		$sheet->getColumnDimension('I')->setWidth(10);
		$sheet->getColumnDimension('J')->setWidth(10);
		$sheet->getColumnDimension('K')->setWidth(10);
		$sheet->getColumnDimension('L')->setWidth(10);
		$sheet->getColumnDimension('M')->setWidth(10);
		$sheet->getColumnDimension('N')->setWidth(10);
		$sheet->getColumnDimension('O')->setWidth(10);
		$sheet->getColumnDimension('P')->setWidth(10);
		$sheet->getColumnDimension('Q')->setWidth(10);
		$sheet->getColumnDimension('R')->setWidth(10);
		$sheet->getColumnDimension('S')->setWidth(10);
		$sheet->getColumnDimension('T')->setWidth(10);
		$sheet->getColumnDimension('U')->setWidth(10);

        $sheet->setCellValue("B1", 'PROGRAMA OPERATIVO ANUAL '.$this->session->userdata('anio'));
        $sheet->setCellValue("B2", 'PROYECTOS');

        $sheet->setCellValue("A3", 'URG');
        $sheet->setCellValue("B3", 'RO');
        $sheet->setCellValue("C3", 'PG');
        $sheet->setCellValue("D3", 'SP');
        $sheet->setCellValue("E3", 'PY');
        $sheet->setCellValue("F3", 'Denominación');
        $sheet->setCellValue("H3", 'Unidad de medida');
        $sheet->setCellValue("I3", 'Meses');
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

        $programas = $this->reportes->getProgramas($ejercicio);
        $i = 5;
        foreach($programas as $programa) {
			$sheet->mergeCells("F".$i.":G".$i);
            $sheet->setCellValue("C".$i, $programa->numero);
            $sheet->setCellValue("F".$i, $programa->nombre);
			$sheet->getStyle('A'.$i.':U'.$i)->applyFromArray($estilo_programas);
			$sheet->getStyle('A'.$i.':U'.$i)->applyFromArray($estilo_bordes_internos);
			$sheet->getStyle('A'.$i.':U'.$i)->getAlignment()->setWrapText(true);
            $subprogramas = $this->reportes->getSubprogramas($programa->programa_id);
            foreach($subprogramas as $subprograma){
                $i++;
				$sheet->mergeCells("F".$i.":G".$i);
                $sheet->setCellValue("D".$i, $subprograma->numero);
                $sheet->setCellValue("F".$i, $subprograma->nombre);
				$sheet->getStyle('A'.$i.':U'.$i)->applyFromArray($estilo_subprogramas);
				$sheet->getStyle('A'.$i.':U'.$i)->applyFromArray($estilo_bordes_internos);
				$sheet->getStyle('A'.$i.':U'.$i)->getAlignment()->setWrapText(true);
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

					$sheet->getStyle('A'.$i.':U'.$i)->applyFromArray($estilo_proyectos);
					$sheet->getStyle('A'.$i.':U'.$i)->applyFromArray($estilo_bordes_internos);

					$sheet->getStyle('F'.$i)->getAlignment()->setWrapText(true);
					$caracteres_nombre_proyecto = strlen($proyecto->pynom);
					if ($caracteres_nombre_proyecto > 93) {
						$sheet->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_proyecto / 93) * 13 + 13);
					}

                    $metas = $this->reportes->getMetas($proyecto->proyecto_id);
                    foreach($metas as $meta){
                        $i++;
                        if($meta->tipo == 'principal'){
                            $metat = 'MP';
							$sheet->getStyle('A'.$i.':U'.$i)->applyFromArray($estilo_meta_principal);
                        } else {
                            $metat = 'MC';
                        }
                        $sheet->setCellValue("F".$i, $metat);
                        $sheet->setCellValue("G".$i, $meta->nombre);
                        $sheet->setCellValue("H".$i, $meta->umnom);
                        $programadas = $this->reportes->getProgramadas($meta->meta_id);
                        $arrm = array('I','J','K','L','M','N','O','P','Q','R','S','T');
                        $j = 0;
                        $total = 0;
                        foreach($programadas as $programada){
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

        $filename = 'apertura_programatica_'.$this->session->userdata('anio');

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
