<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class indicadores extends MX_Controller
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
        $this->load->library('Excel');
    }

    public function index($trimestre = false)
    {
        if($trimestre == '1'){
            $mnombre = 'Enero-Marzo';
            $ultimoDiaMes = '31 DE MARZO DEL ';
            $primerMes = 1;
            $mes = 3;
        } else if($trimestre == '2'){
            $mnombre = 'Abril-Junio';
            $ultimoDiaMes = '30 DE JUNIO DEL ';
            $primerMes = 4;
            $mes = 6;
        } else if($trimestre == '3'){
            $mnombre = 'Julio-Septiembre';
            $ultimoDiaMes = '30 DE SEPTIEMBRE DEL ';
            $primerMes = 7;
            $mes = 9;
        } else if($trimestre == '4'){
            $mnombre = 'Octubre-Diciembre';
            $ultimoDiaMes = '31 DE DICIEMBRE DEL ';
            $primerMes = 10;
            $mes = 12;
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

		$i = 3;
		$sheet->getStyle('A' . $i . ':A' . ($i + 1))->getAlignment()->setWrapText(true);
		$sheet->getStyle('B' . $i . ':B' . ($i + 1))->getAlignment()->setWrapText(true);
		$sheet->getStyle('C' . $i . ':C' . ($i + 1))->getAlignment()->setWrapText(true);
		$sheet->getStyle('D' . $i . ':D' . ($i + 1))->getAlignment()->setWrapText(true);
		$sheet->getStyle('E' . $i . ':E' . ($i + 1))->getAlignment()->setWrapText(true);
		$sheet->getStyle('F' . $i . ':F' . ($i + 1))->getAlignment()->setWrapText(true);
		$sheet->getStyle('G' . $i . ':G' . ($i + 1))->getAlignment()->setWrapText(true);
		$sheet->getStyle('H' . ($i + 1) . ':H' . ($i + 1))->getAlignment()->setWrapText(true);
		$sheet->getStyle('I' . ($i + 1) . ':I' . ($i + 1))->getAlignment()->setWrapText(true);

		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->getColumnDimension('B')->setWidth(18);
		$sheet->getColumnDimension('C')->setWidth(11);
		$sheet->getColumnDimension('D')->setWidth(40);
		$sheet->getColumnDimension('E')->setWidth(50);
		$sheet->getColumnDimension('F')->setWidth(20);
		$sheet->getColumnDimension('G')->setWidth(8);
		$sheet->getColumnDimension('H')->setWidth(12);
		$sheet->getColumnDimension('I')->setWidth(12);

		$sheet->getRowDimension($i)->setRowHeight(30);
		$sheet->getRowDimension($i + 1)->setRowHeight(30);

        $sheet->getStyle('A1:I2')->applyFromArray($styleArray);
		$sheet->getStyle('A3:I4')->applyFromArray($estilo_encabezado);

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
            $sheet->getStyle('A' . $i . ':I' . $i)->applyFromArray($estilo_meta_principal);
            $sheet->getStyle('A' . $i . ':I' . $i)->applyFromArray($estilo_bordes_internos);
            $indicadores = $this->reportes->getIndicadores($proyecto->proyecto_id);
            foreach($indicadores as $indicador){
                $sheet->setCellValue("B".$i, $indicador->frecuenciaNombre);
                $sheet->setCellValue("C".$i, $indicador->medidaNombre);
                $sheet->setCellValue("D".$i, $indicador->indicadorNombre);
                $sheet->setCellValue("E".$i, $indicador->definicion);
                $sheet->setCellValue("F".$i, $indicador->metodo_calculo);
                $sheet->setCellValue("G".$i, $indicador->meta);
                $sheet->getStyle('A' . $i . ':I' . $i)->applyFromArray($estilo_bordes_internos);

				$caracteres_nombre_indicador = strlen($indicador->indicadorNombre);
				if ($caracteres_nombre_indicador > 47) {
					$sheet->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_indicador / 47) * 13 + 13);
				}

				$caracteres_nombre_meta = strlen($indicador->definicion);
				if ($caracteres_nombre_meta > 61 && (intval($caracteres_nombre_indicador / 47) * 13 + 13) < (intval($caracteres_nombre_meta / 61) * 13 + 13)) {
					$sheet->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_meta / 61) * 13 + 13);
				}

				$caracteres_metodo_calculo = strlen($indicador->metodo_calculo);
				if ($caracteres_metodo_calculo > 21 && (intval($caracteres_nombre_meta / 61) * 13 + 13) < (intval($caracteres_metodo_calculo / 21) * 15 + 18)) {
					$sheet->getRowDimension($i)->setRowHeight(intval($caracteres_metodo_calculo / 21) * 15 + 18);
				}

				$sheet->getStyle('D' . $i)->getAlignment()->setWrapText(true);
				$sheet->getStyle('E' . $i)->getAlignment()->setWrapText(true);
				$sheet->getStyle('F' . $i)->getAlignment()->setWrapText(true);


				$programadoNumero = 0;
                $alcanzadoNumero = 0;

                $meta = $this->reportes->getTipoMetas($indicador->meta_id);
                if($meta){
                    for($j = $primerMes; $j <= $mes; $j++){
                        if($meta->porcentajes == '1'){
                            $programado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $indicador->meta_id);
                            $alcanzado = $this->reportes->getAvanceMesResuelto($j, $indicador->meta_id);
                            $acumulado = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $indicador->meta_id);
                            $acumuladoa = $this->seguimiento_model->getAvanceResueltoAcumulado($mes, $indicador->meta_id);
                            $programadoNumero += $programado ? $programado->numero : 0;
                            $alcanzadoNumero += $alcanzado ? $alcanzado->numero : 0;
                        } else {
                            $programado = $this->seguimiento_model->getAvanceMesProgramado($j, $indicador->meta_id);
                            $alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $indicador->meta_id);
                            $acumulado = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $indicador->meta_id);
                            $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $indicador->meta_id);
                            $programadoNumero += $programado ? $programado->numero : 0;
                            $alcanzadoNumero += $alcanzado ? $alcanzado->numero : 0;
                        }
                    }

                    if($alcanzadoNumero == 0 && $programadoNumero == 0){
                        $avance = 100;
                    } else {
                        $avance = number_format(($alcanzadoNumero / $programadoNumero) * 100, 1);
                    }
                    if($acumulado->numero == 0){
                        $trimestreAcumulado = number_format(($acumuladoa->numero / 100) * 100, 1);
                    } else {
                        $trimestreAcumulado = number_format(($acumuladoa->numero / $acumulado->numero) * 100, 1);
                    }

                    $sheet->setCellValue("H".$i, $avance);
                    $sheet->setCellValue("I".$i, $trimestreAcumulado);
                }
                $i++;
            }
        }

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(11);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(8);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);

		$writer = new Xlsx($spreadsheet); // instantiate Xlsx

		$filename = 'avance_indicadores_'.$mnombre; // set filename for excel file to be exported

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');    // download file
    }

}
