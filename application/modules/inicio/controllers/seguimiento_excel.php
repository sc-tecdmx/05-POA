<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class seguimiento_excel extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $models = array(
            'seguimiento_model',
            'home/home_inicio',
            'home/general',
            'proyectos_model'
        );
        $this->load->model($models);
    }

    public function mensual($proyecto = false, $mes = false)
    {
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

		$sheet->setTitle('Avance Mensual y Acumulado');

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

		$styleArray2 = array(
			'font' => array(
				'bold' => true,
				'size' => 10
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'allborders' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
		);

		$styleArray3 = array(
			'font' => array(
				'size' => 10
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'allborders' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
		);

		$styleArray4 = array(
			'font' => array(
				'size' => 9,
				'color' => array(
					'argb' => '00000000',
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
					'argb' => 'FF808080',
				),
			),
			'borders' => array(
				'outline' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
		);

		$styleArray5 = array(
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

		$styleArray6 = array(
			'font' => array(
				'bold' => true,
				'size' => 10
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
			),
		);

		$styleArray7 = array(
			'font' => array(
				'size' => 10
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_TOP,
			),
			'borders' => array(
				'allborders' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
			'fill' => array(
				'type' => Fill::FILL_SOLID,
				'rotation' => 90,
				'startcolor' => array(
					'argb' => 'FFEFFFEF',
				),
			),
		);

		$styleArray8 = array(
			'font' => array(
				'size' => 9,
				'color' => array(
					'argb' => 'FF000000',
				),
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_TOP,
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

		$styleArray9 = array(
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
		);

		$styleArray10 = array(
			'font' => array(
				'bold' => true,
				'size' => 11,
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
		);

        $cont = 1;

        $sheet->mergeCells("A1:R1");
        $sheet->mergeCells("A2:R2");
        $sheet->mergeCells("A3:R3");

		$sheet->getStyle('A1:R1')->applyFromArray($styleArray);
		$sheet->getStyle('A2:R2')->applyFromArray($styleArray);

		$sheet->mergeCells("A4:C4");
		$sheet->mergeCells("A5:C5");
		$sheet->mergeCells("A6:C6");
		$sheet->mergeCells("A7:C7");
		$sheet->mergeCells("A8:C8");

		$sheet->mergeCells("D4:R4");
		$sheet->mergeCells("D5:R5");
		$sheet->mergeCells("D6:R6");
		$sheet->mergeCells("D7:R7");
		$sheet->mergeCells("D8:R8");

        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->getStyle("A5")->getFont()->setBold(true);
        $sheet->getStyle("A6")->getFont()->setBold(true);
        $sheet->getStyle("A7")->getFont()->setBold(true);
        $sheet->getStyle("A8")->getFont()->setBold(true);

        $ejercicio = $this->home_inicio->get_ejercicio();

        $sheet->setCellValue("A1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio->ejercicio);
        $sheet->setCellValue("A2", 'AVANCE DE PROYECTOS');
        $sheet->setCellValue("A4", 'UNIDAD RESPONSABLE:');
        $sheet->setCellValue("A5", 'RESPONSABLE OPERATIVO:');
        $sheet->setCellValue("A6", 'CLAVE DEL PROYECTO:');
        $sheet->setCellValue("A7", 'DENOMINACIÓN DEL PROYECTO:');
        $sheet->setCellValue("A8", 'NOMBRE DE LA META PRINCIPAL:');

		$sheet->getStyle('A10:R10')->applyFromArray($styleArray9);
		$sheet->getStyle('A18:R18')->applyFromArray($styleArray9);
		$sheet->getStyle('A19:R19')->applyFromArray($styleArray9);

        $info = $this->seguimiento_model->getInfoProyecto($proyecto);
        $pry = $this->proyectos_model->getClaveProyecto($proyecto);
        $clave = $pry->urnum.'-'.$pry->ronum.'-'.$pry->pgnum.'-'.$pry->sbnum.'-'.$pry->pynum;

        $sheet->setCellValue('D4', $info->urnom);
        $sheet->setCellValue('D5', $info->ronom);
        $sheet->setCellValue('D6', $clave);

		$sheet->getStyle('D7')->getAlignment()->setWrapText(true);
		$caracteres_nombre_proyecto = strlen($info->pynom);
		if ($caracteres_nombre_proyecto > 185) {
			$sheet->getRowDimension(7)->setRowHeight(intval($caracteres_nombre_proyecto / 185) * 14 + 14);
		}

        $sheet->setCellValue('D7', trim($info->pynom));
        $sheet->setCellValue('D8', $info->mtnom);

        // Espacio para la meta principal
        $sheet->mergeCells("A10:R10");
        $sheet->mergeCells("A11:C13");
        $sheet->mergeCells("D11:F13");
        $sheet->mergeCells("G11:L11");
        $sheet->mergeCells("G12:H12");
        $sheet->mergeCells("G13:H13");
        $sheet->mergeCells("I12:J12");
        $sheet->mergeCells("I13:J13");
        $sheet->mergeCells("K12:L12");
        $sheet->mergeCells("K13:L13");
        $sheet->mergeCells("M11:R11");
        $sheet->mergeCells("M12:N12");
        $sheet->mergeCells("M13:N13");
        $sheet->mergeCells("O12:P12");
        $sheet->mergeCells("O13:P13");
        $sheet->mergeCells("Q12:R12");
        $sheet->mergeCells("Q13:R13");
        $sheet->mergeCells("A14:C14");
        $sheet->mergeCells("D14:F14");
        $sheet->mergeCells("G14:H14");
        $sheet->mergeCells("I14:J14");
        $sheet->mergeCells("K14:L14");
        $sheet->mergeCells("M14:N14");
        $sheet->mergeCells("O14:P14");
        $sheet->mergeCells("Q14:R14");
        $sheet->mergeCells("A15:R15");
        $sheet->mergeCells("A16:R16");

        // Espacio para las metas complementarias
        $sheet->mergeCells("A18:R18");
        $sheet->mergeCells("A19:R19");
        $sheet->mergeCells("A20:C22");
        $sheet->mergeCells("D20:F22");
        $sheet->mergeCells("G20:L20");
        $sheet->mergeCells("G21:H21");
        $sheet->mergeCells("G22:H22");
        $sheet->mergeCells("I21:J21");
        $sheet->mergeCells("I22:J22");
        $sheet->mergeCells("K21:L21");
        $sheet->mergeCells("K22:L22");
        $sheet->mergeCells("M20:R20");
        $sheet->mergeCells("M21:N21");
        $sheet->mergeCells("M22:N22");
        $sheet->mergeCells("O21:P21");
        $sheet->mergeCells("O22:P22");
        $sheet->mergeCells("Q21:R21");
        $sheet->mergeCells("Q22:R22");

        $sheet->getStyle("A10")->getFont()->setBold(true);

		$sheet->getStyle('A11:C13')->applyFromArray($styleArray4);
		$sheet->getStyle('D11:F13')->applyFromArray($styleArray4);
		$sheet->getStyle('G11:L11')->applyFromArray($styleArray4);
		$sheet->getStyle('G12:H13')->applyFromArray($styleArray4);
		$sheet->getStyle('I12:J13')->applyFromArray($styleArray4);
		$sheet->getStyle('K12:L13')->applyFromArray($styleArray4);
		$sheet->getStyle('M12:N13')->applyFromArray($styleArray4);
		$sheet->getStyle('O12:P13')->applyFromArray($styleArray4);
		$sheet->getStyle('Q12:R13')->applyFromArray($styleArray4);
		$sheet->getStyle('M11:R11')->applyFromArray($styleArray4);

        $meses = $this->seguimiento_model->getNombreMes($mes);

        // META PRINCIPAL
        $sheet->setCellValue("A10", 'META PRINCIPAL');
        $sheet->setCellValue("A11", 'Denominación de la meta');
        $sheet->setCellValue("D11", 'Unidad de medida');
        $sheet->setCellValue("G11", ucfirst($meses->nombre));
        $sheet->setCellValue("G12", 'Programada');
        $sheet->setCellValue("G13", '(1)');
        $sheet->setCellValue("I12", 'Alcanzada');
        $sheet->setCellValue("I13", '(2)');
        $sheet->setCellValue("K12", 'Avance %');
        $sheet->setCellValue("K13", '(2)(1)');
        $sheet->setCellValue("M11", 'Acumulado Enero - '.$meses->nombre);
        $sheet->setCellValue("M12", 'Programada');
        $sheet->setCellValue("M13", '(3)');
        $sheet->setCellValue("O12", 'Alcanzada');
        $sheet->setCellValue("O13", '(4)');
        $sheet->setCellValue("Q12", 'Avance %');
        $sheet->setCellValue("Q13", '(4)(3)');
        $sheet->setCellValue("A15", 'EXPLICACIÓN DEL AVANCE FÍSICO');

        $res = $this->seguimiento_model->getMetaPrincipalAvance($mes, $proyecto);

		$sheet->getStyle('A14')->getAlignment()->setWrapText(true);
		$caracteres_nombre_proyecto = strlen($info->pynom);
		if ($caracteres_nombre_proyecto > 60) {
			$sheet->getRowDimension(14)->setRowHeight(intval($caracteres_nombre_proyecto / 60) * 27 + 27);
		}

        $sheet->setCellValue("A14", $res->nombre);
        $sheet->setCellValue("D14", $res->umnom);

        $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $res->meta_id);
        $sheet->setCellValue("G14", $row->numero);
        $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $res->meta_id);
        $sheet->setCellValue("I14", $row1->numero);
        $sheet->setCellValue("K14", $row1->porcentaje);
        $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $res->meta_id);
        $sheet->setCellValue("M14", $acumuladop->numero);
        $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $res->meta_id);
        $sheet->setCellValue("O14", $acumuladoa->numero);
        $pacm = $this->seguimiento_model->getPorcentajeAcumulado($res->meta_id, $mes);
        $sheet->setCellValue("Q14", $pacm->porcentaje);

        $explicaciones = $this->seguimiento_model->getExplicacionesMP($mes, $res->meta_id);
        $cadena = '';
        foreach ($explicaciones as $explicacion){
            $cadena .= $explicacion->nombre.' '.$explicacion->explicacion."\n";
        }
        $sheet->setCellValue("A16", $cadena);

		$sheet->getStyle("A19")->getFont()->setBold(true);

		$sheet->getStyle('A20:C22')->applyFromArray($styleArray4);
		$sheet->getStyle('D20:F22')->applyFromArray($styleArray4);
		$sheet->getStyle('G20:L20')->applyFromArray($styleArray4);
		$sheet->getStyle('M20:R20')->applyFromArray($styleArray4);
		$sheet->getStyle('G21:H22')->applyFromArray($styleArray4);
		$sheet->getStyle('I21:J22')->applyFromArray($styleArray4);
		$sheet->getStyle('K21:L22')->applyFromArray($styleArray4);
		$sheet->getStyle('M21:N22')->applyFromArray($styleArray4);
		$sheet->getStyle('O21:P22')->applyFromArray($styleArray4);
		$sheet->getStyle('Q21:R22')->applyFromArray($styleArray4);
		$sheet->getStyle('M21:R21')->applyFromArray($styleArray4);

        // METAS COMPLEMENTARIAS
        $sheet->setCellValue("A18", 'METAS COMPLEMENTARIAS');
        $sheet->setCellValue("A19", 'AVANCE MENSUAL Y ACUMULADO');
        $sheet->setCellValue("A20", 'Denominación de la meta');
        $sheet->setCellValue("D20", 'Unidad de medida');
        $sheet->setCellValue("G20", 'Mes');
        $sheet->setCellValue("G21", 'Programada');
        $sheet->setCellValue("G22", '(1)');
        $sheet->setCellValue("I21", 'Alcanzada');
        $sheet->setCellValue("I22", '(2)');
        $sheet->setCellValue("K21", 'Avance %');
        $sheet->setCellValue("K22", '(2)(1)');
        $sheet->setCellValue("M20", 'Acumulado Mes - '.$meses->nombre);
        $sheet->setCellValue("M21", 'Programada');
        $sheet->setCellValue("M22", '(3)');
        $sheet->setCellValue("O21", 'Alcanzada');
        $sheet->setCellValue("O22", '(4)');
        $sheet->setCellValue("Q21", 'Avance %');
        $sheet->setCellValue("Q22", '(4)(3)');

        $complementarias = $this->seguimiento_model->getMetasComplementariasAvance($mes, $proyecto);
        $i = 23;
        foreach ($complementarias as $complementaria){
            $sheet->mergeCells("A".$i.":C".$i);
            $sheet->mergeCells("D".$i.":F".$i);
            $sheet->mergeCells("G".$i.":H".$i);
            $sheet->mergeCells("I".$i.":J".$i);
            $sheet->mergeCells("K".$i.":L".$i);
            $sheet->mergeCells("M".$i.":N".$i);
            $sheet->mergeCells("O".$i.":P".$i);
            $sheet->mergeCells("Q".$i.":R".$i);

            $sheet->setCellValue("A".$i, $complementaria->nombre);
            $sheet->setCellValue("D".$i, $complementaria->umnom);
            $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $complementaria->meta_id);
            $sheet->setCellValue("G".$i, $row->numero);
            $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $complementaria->meta_id);
            $sheet->setCellValue("I".$i, $row1->numero);
            $sheet->setCellValue("K".$i, $row1->porcentaje);
            $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $complementaria->meta_id);
            $sheet->setCellValue("M".$i, $acumuladop->numero);
            $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $complementaria->meta_id);
            $sheet->setCellValue("O".$i, $acumuladoa->numero);
            $pacm = $this->seguimiento_model->getPorcentajeAcumulado($complementaria->meta_id, $mes);
            $sheet->setCellValue("Q".$i, $pacm->porcentaje);
            $i++;
        }

        $sheet->mergeCells("A".$i.":R".$i);
        $sheet->setCellValue("A".$i, 'EXPLICACIÓN DEL AVANCE FÍSICO');
        $i++;

		$writer = new Xls($spreadsheet);

		$filename = 'Avance_mensual_y_acumulado';

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function trimestral($proyecto = false, $mes = false)
    {
        if($mes == '3'){
            $mnombre = 'Enero - Marzo';
        } else if($mes == '6'){
            $mnombre = 'Abril - Junio';
        } else if($mes == '9'){
            $mnombre = 'Julio - Septiembre';
        } else if($mes == '12'){
            $mnombre = 'Octubre - Diciembre';
        }

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

		$sheet->setTitle('Avance Trimestral y Acumulado');

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

		$styleArray2 = array(
			'font' => array(
				'bold' => true,
				'size' => 10
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'allborders' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
		);

		$styleArray3 = array(
			'font' => array(
				'size' => 10
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'allborders' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
		);

		$styleArray4 = array(
			'font' => array(
				'size' => 9,
				'color' => array(
					'argb' => '00000000',
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
					'argb' => 'FF808080',
				),
			),
			'borders' => array(
				'outline' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
		);

		$styleArray5 = array(
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

		$styleArray6 = array(
			'font' => array(
				'bold' => true,
				'size' => 10
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
			),
		);

		$styleArray7 = array(
			'font' => array(
				'size' => 10
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_TOP,
			),
			'borders' => array(
				'allborders' => array(
					'style' => Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
			'fill' => array(
				'type' => Fill::FILL_SOLID,
				'rotation' => 90,
				'startcolor' => array(
					'argb' => 'FFEFFFEF',
				),
			),
		);

		$styleArray8 = array(
			'font' => array(
				'size' => 9,
				'color' => array(
					'argb' => 'FF000000',
				),
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_TOP,
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

		$styleArray9 = array(
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
		);

		$styleArray10 = array(
			'font' => array(
				'bold' => true,
				'size' => 11,
			),
			'alignment' => array(
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			),
		);

        $sheet->mergeCells("A1:R1");
        $sheet->mergeCells("A2:R2");
        $sheet->mergeCells("A3:R3");

		$sheet->getStyle('A1:R1')->applyFromArray($styleArray);
		$sheet->getStyle('A2:R2')->applyFromArray($styleArray);

        $sheet->mergeCells("A4:C4");
        $sheet->mergeCells("A5:C5");
        $sheet->mergeCells("A6:C6");
        $sheet->mergeCells("A7:C7");
        $sheet->mergeCells("A8:C8");

		$sheet->mergeCells("D4:R4");
		$sheet->mergeCells("D5:R5");
		$sheet->mergeCells("D6:R6");
		$sheet->mergeCells("D7:R7");
		$sheet->mergeCells("D8:R8");

        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->getStyle("A5")->getFont()->setBold(true);
        $sheet->getStyle("A6")->getFont()->setBold(true);
        $sheet->getStyle("A7")->getFont()->setBold(true);
        $sheet->getStyle("A8")->getFont()->setBold(true);

        $ejercicio = $this->home_inicio->get_ejercicio();

        $sheet->setCellValue("A1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio->ejercicio);
        $sheet->setCellValue("A2", 'AVANCE DE PROYECTOS');
        $sheet->setCellValue("A4", 'UNIDAD RESPONSABLE:');
        $sheet->setCellValue("A5", 'RESPONSABLE OPERATIVO:');
        $sheet->setCellValue("A6", 'CLAVE DEL PROYECTO:');
        $sheet->setCellValue("A7", 'DENOMINACIÓN DEL PROYECTO:');
        $sheet->setCellValue("A8", 'NOMBRE DE LA META PRINCIPAL:');

        $sheet->getStyle('A10:R10')->applyFromArray($styleArray9);
        $sheet->getStyle('A18:R18')->applyFromArray($styleArray9);
        $sheet->getStyle('A19:R19')->applyFromArray($styleArray9);

        $info = $this->seguimiento_model->getInfoProyecto($proyecto);
        $pry = $this->proyectos_model->getClaveProyecto($proyecto);
        $clave = $pry->urnum.'-'.$pry->ronum.'-'.$pry->pgnum.'-'.$pry->sbnum.'-'.$pry->pynum;

        $sheet->setCellValue('D4', $info->urnom);
        $sheet->setCellValue('D5', $info->ronom);
        $sheet->setCellValue('D6', $clave);

		$sheet->getStyle('D7')->getAlignment()->setWrapText(true);
		$caracteres_nombre_proyecto = strlen($info->pynom);
		if ($caracteres_nombre_proyecto > 185) {
			$sheet->getRowDimension(7)->setRowHeight(intval($caracteres_nombre_proyecto / 185) * 14 + 14);
		}

        $sheet->setCellValue('D7', $info->pynom);
        $sheet->setCellValue('D8', $info->mtnom);

        // Espacio para la meta principal
        $sheet->mergeCells("A10:R10");
        $sheet->mergeCells("A11:C13");
        $sheet->mergeCells("D11:F13");
        $sheet->mergeCells("G11:L11");
        $sheet->mergeCells("G12:H12");
        $sheet->mergeCells("G13:H13");
        $sheet->mergeCells("I12:J12");
        $sheet->mergeCells("I13:J13");
        $sheet->mergeCells("K12:L12");
        $sheet->mergeCells("K13:L13");
        $sheet->mergeCells("M11:R11");
        $sheet->mergeCells("M12:N12");
        $sheet->mergeCells("M13:N13");
        $sheet->mergeCells("O12:P12");
        $sheet->mergeCells("O13:P13");
        $sheet->mergeCells("Q12:R12");
        $sheet->mergeCells("Q13:R13");
        $sheet->mergeCells("A14:C14");
        $sheet->mergeCells("D14:F14");
        $sheet->mergeCells("G14:H14");
        $sheet->mergeCells("I14:J14");
        $sheet->mergeCells("K14:L14");
        $sheet->mergeCells("M14:N14");
        $sheet->mergeCells("O14:P14");
        $sheet->mergeCells("Q14:R14");
        $sheet->mergeCells("A15:R15");
        $sheet->mergeCells("A16:R16");
        // Espacio para las metas complementarias
        $sheet->mergeCells("A18:R18");
        $sheet->mergeCells("A19:R19");
        $sheet->mergeCells("A20:C22");
        $sheet->mergeCells("D20:F22");
        $sheet->mergeCells("G20:L20");
        $sheet->mergeCells("G21:H21");
        $sheet->mergeCells("G22:H22");
        $sheet->mergeCells("I21:J21");
        $sheet->mergeCells("I22:J22");
        $sheet->mergeCells("K21:L21");
        $sheet->mergeCells("K22:L22");
        $sheet->mergeCells("M20:R20");
        $sheet->mergeCells("M21:N21");
        $sheet->mergeCells("M22:N22");
        $sheet->mergeCells("O21:P21");
        $sheet->mergeCells("O22:P22");
        $sheet->mergeCells("Q21:R21");
        $sheet->mergeCells("Q22:R22");

        $sheet->getStyle("A10")->getFont()->setBold(true);

		$sheet->getStyle('A11:C13')->applyFromArray($styleArray4);
		$sheet->getStyle('D11:F13')->applyFromArray($styleArray4);
		$sheet->getStyle('G11:L11')->applyFromArray($styleArray4);
		$sheet->getStyle('G12:H13')->applyFromArray($styleArray4);
		$sheet->getStyle('I12:J13')->applyFromArray($styleArray4);
		$sheet->getStyle('K12:L13')->applyFromArray($styleArray4);
		$sheet->getStyle('M12:N13')->applyFromArray($styleArray4);
		$sheet->getStyle('O12:P13')->applyFromArray($styleArray4);
		$sheet->getStyle('Q12:R13')->applyFromArray($styleArray4);
		$sheet->getStyle('M11:R11')->applyFromArray($styleArray4);

        $meses = $this->seguimiento_model->getNombreMes($mes);

        // META PRINCIPAL
        $sheet->setCellValue("A10", 'META PRINCIPAL');
        $sheet->setCellValue("A11", 'Denominación de la meta');
        $sheet->setCellValue("D11", 'Unidad de medida');
        $sheet->setCellValue("G11", $mnombre);
        $sheet->setCellValue("G12", 'Programada');
        $sheet->setCellValue("G13", '(1)');
        $sheet->setCellValue("I12", 'Alcanzada');
        $sheet->setCellValue("I13", '(2)');
        $sheet->setCellValue("K12", 'Avance %');
        $sheet->setCellValue("K13", '(2)(1)');
        $sheet->setCellValue("M11", 'Acumulado');
        $sheet->setCellValue("M12", 'Programada');
        $sheet->setCellValue("M13", '(3)');
        $sheet->setCellValue("O12", 'Alcanzada');
        $sheet->setCellValue("O13", '(4)');
        $sheet->setCellValue("Q12", 'Avance %');
        $sheet->setCellValue("Q13", '(4)(3)');
        $sheet->setCellValue("A15", 'EXPLICACIÓN DEL AVANCE FÍSICO');

        $res = $this->seguimiento_model->getMetaPrincipalAvance($mes, $proyecto);

		$sheet->getStyle('A14')->getAlignment()->setWrapText(true);
		$caracteres_nombre_proyecto = strlen($info->pynom);
		if ($caracteres_nombre_proyecto > 60) {
			$sheet->getRowDimension(14)->setRowHeight(intval($caracteres_nombre_proyecto / 60) * 27 + 27);
		}

        $sheet->setCellValue("A14", $res->nombre);
        $sheet->setCellValue("D14", $res->umnom);

        $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $res->meta_id);
        $sheet->setCellValue("G14", $row->numero);
        $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $res->meta_id);
        $sheet->setCellValue("I14", $row1->numero);
        $sheet->setCellValue("K14", $row1->porcentaje);
        $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $res->meta_id);
        $sheet->setCellValue("M14", $acumuladop->numero);
        $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $res->meta_id);
        $sheet->setCellValue("O14", $acumuladoa->numero);
        $pacm = $this->seguimiento_model->getPorcentajeAcumulado($res->meta_id, $mes);
        $sheet->setCellValue("Q14", $pacm->porcentaje);

        $explicaciones = $this->seguimiento_model->getExplicacionesMP($mes, $res->meta_id);
        $cadena = '';
        foreach ($explicaciones as $explicacion){
            $cadena .= $explicacion->nombre.' '.$explicacion->explicacion."\n";
        }
        $sheet->setCellValue("A16", $cadena);

		$sheet->getStyle("A19")->getFont()->setBold(true);

		$sheet->getStyle('A20:C22')->applyFromArray($styleArray4);
		$sheet->getStyle('D20:F22')->applyFromArray($styleArray4);
		$sheet->getStyle('G20:L20')->applyFromArray($styleArray4);
		$sheet->getStyle('M20:R20')->applyFromArray($styleArray4);
		$sheet->getStyle('G21:H22')->applyFromArray($styleArray4);
		$sheet->getStyle('I21:J22')->applyFromArray($styleArray4);
		$sheet->getStyle('K21:L22')->applyFromArray($styleArray4);
		$sheet->getStyle('M21:N22')->applyFromArray($styleArray4);
		$sheet->getStyle('O21:P22')->applyFromArray($styleArray4);
		$sheet->getStyle('Q21:R22')->applyFromArray($styleArray4);
		$sheet->getStyle('M21:R21')->applyFromArray($styleArray4);

        // METAS COMPLEMENTARIAS
        // $sheet->setCellValue("A18", '');
        $sheet->setCellValue("A19", 'METAS COMPLEMENTARIAS');
        $sheet->setCellValue("A20", 'Denominación de la meta');
        $sheet->setCellValue("D20", 'Unidad de medida');
        $sheet->setCellValue("G20", $mnombre);
        $sheet->setCellValue("G21", 'Programada');
        $sheet->setCellValue("G22", '(1)');
        $sheet->setCellValue("I21", 'Alcanzada');
        $sheet->setCellValue("I22", '(2)');
        $sheet->setCellValue("K21", 'Avance %');
        $sheet->setCellValue("K22", '(2)(1)');
        $sheet->setCellValue("M20", 'Acumulado');
        $sheet->setCellValue("M21", 'Programada');
        $sheet->setCellValue("M22", '(3)');
        $sheet->setCellValue("O21", 'Alcanzada');
        $sheet->setCellValue("O22", '(4)');
        $sheet->setCellValue("Q21", 'Avance %');
        $sheet->setCellValue("Q22", '(4)(3)');

        $complementarias = $this->seguimiento_model->getMetasComplementariasAvance($mes, $proyecto);
        $i = 23;
        foreach ($complementarias as $complementaria){
            $sheet->mergeCells("A".$i.":C".$i);
            $sheet->mergeCells("D".$i.":F".$i);
            $sheet->mergeCells("G".$i.":H".$i);
            $sheet->mergeCells("I".$i.":J".$i);
            $sheet->mergeCells("K".$i.":L".$i);
            $sheet->mergeCells("M".$i.":N".$i);
            $sheet->mergeCells("O".$i.":P".$i);
            $sheet->mergeCells("Q".$i.":R".$i);

            $sheet->setCellValue("A".$i, $complementaria->nombre);
            $sheet->setCellValue("D".$i, $complementaria->umnom);
            $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $complementaria->meta_id);
            $sheet->setCellValue("G".$i, $row->numero);
            $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $complementaria->meta_id);
            $sheet->setCellValue("I".$i, $row1->numero);
            $sheet->setCellValue("K".$i, $row1->porcentaje);
            $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $complementaria->meta_id);
            $sheet->setCellValue("M".$i, $acumuladop->numero);
            $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $complementaria->meta_id);
            $sheet->setCellValue("O".$i, $acumuladoa->numero);
            $pacm = $this->seguimiento_model->getPorcentajeAcumulado($complementaria->meta_id, $mes);
            $sheet->setCellValue("Q".$i, $pacm->porcentaje);
            $i++;
        }

        $sheet->mergeCells("A".$i.":R".$i);
        $sheet->setCellValue("A".$i, 'EXPLICACIÓN DEL AVANCE FÍSICO');
        $i++;

        $writer = new Xls($spreadsheet);

        $filename = 'Avance_trimestral_y_acumulado';

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }
}
