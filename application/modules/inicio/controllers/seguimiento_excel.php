<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

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
        $this->load->library('Excel');
    }

    public function excelAvanceTrimestral()
    {
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Acciones');

        // Set properties
        $this->excel->getProperties()->setCreator("TEDF")
            ->setLastModifiedBy("TEDF")
            ->setTitle("Office 2007 XLSX Reporte")
            ->setSubject("Office 2007 XLSX Reporte")
            ->setDescription("Reporte en Excel")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Documento de salida");

        /* $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('../../../../../../images/logo11-TEDF.png');
        $objDrawing->setHeight(25);
        $objDrawing->setOffsetX(25);
        $objDrawing->setOffsetY(7);
        $objDrawing->setWorksheet($this->excel->getActiveSheet()); */

        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);

        $styleArray = array(
            'font' => array(
                'type' => 'Arial',
                'bold' => true,
                'size' => 12
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $styleArray2 = array(
            'font' => array(
                'bold' => true,
                'size' => 10
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $styleArray3 = array(
            'font' => array(
                'size' => 10
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $styleArray4 = array(
            'font' => array(
                'size' => 9,
                'color' => array(
                    'argb' => 'FFFFFFFF',
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FF808080',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFFFFFFF',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );

        $styleArray7 = array(
            'font' => array(
                'size' => 10
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
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
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFFFFFFF',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );

        $styleArray9 = array(
            'font' => array(
                'size' => 10,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $styleArray10 = array(
            'font' => array(
                'bold' => true,
                'size' => 11,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        //$this->excel->getDefaultStyle()->getFont()->setName('Arial');
        // Encabezado de la hoja
        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'PROGRAMA OPERATIVO ANUAL')
            ->setCellValue('A2', 'AVANCE DE PROYECTOS')
            ->setCellValue('A3', 'UNIDAD RESPONSABLE:')
            ->setCellValue('A4', 'RESPONSABLE OPERATIVO:')
            ->setCellValue('A5', 'CLAVE DEL PROYECTO:')
            ->setCellValue('A6', 'DENOMINACIÓN DEL PROYECTO:')
            ->setCellValue('A7', 'NOMBRE DE LA META PRINCIPAL:');

        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('B3', 'Prueba')
            ->setCellValue('B4', 'Prueba')
            ->setCellValue('B5', 'Prueba')
            ->setCellValue('B6', 'Prueba');

        $i = 9;

        $this->excel->getActiveSheet()
            ->setCellValue('A' . $i, "AVANCE MENSUAL Y ACUMULADO");
        $this->excel->getActiveSheet()
            ->mergeCells('A' . $i . ':R' . $i);
        $this->excel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)->applyFromArray($styleArray9);

        $i++;
        $this->excel->getActiveSheet()
            ->setCellValue('A' . $i, "Denominación de la meta")
            ->setCellValue('D' . $i, "Unidad de medida")
            ->setCellValue('G' . $i, "Trimestre ")
            ->setCellValue('G' . ($i + 1), "Programada")
            ->setCellValue('G' . ($i + 2), "(1)")
            ->setCellValue('I' . ($i + 1), "Alcanzada")
            ->setCellValue('I' . ($i + 2), "(2)")
            ->setCellValue('K' . ($i + 1), "Avance %")
            ->setCellValue('K' . ($i + 2), "(2)(1)")
            ->setCellValue('M' . ($i + 1), "Programada")
            ->setCellValue('M' . ($i + 2), "(3)")
            ->setCellValue('O' . ($i + 1), "Alcanzada")
            ->setCellValue('O' . ($i + 2), "(4)")
            ->setCellValue('Q' . ($i + 1), "Avance %")
            ->setCellValue('Q' . ($i + 2), "(4)(3)")
            ->setCellValue('M' . $i, "Acumulado");

        $this->excel->getActiveSheet()
            ->mergeCells('A' . $i . ':C' . ($i + 2))
            ->mergeCells('D' . $i . ':F' . ($i + 2))
            ->mergeCells('G' . $i . ':L' . $i)
            ->mergeCells('G' . ($i + 1) . ':H' . ($i + 1))
            ->mergeCells('G' . ($i + 2) . ':H' . ($i + 2))
            ->mergeCells('I' . ($i + 1) . ':J' . ($i + 1))
            ->mergeCells('I' . ($i + 2) . ':J' . ($i + 2))
            ->mergeCells('K' . ($i + 1) . ':L' . ($i + 1))
            ->mergeCells('K' . ($i + 2) . ':L' . ($i + 2))
            ->mergeCells('M' . ($i + 1) . ':N' . ($i + 1))
            ->mergeCells('M' . ($i + 2) . ':N' . ($i + 2))
            ->mergeCells('O' . ($i + 1) . ':P' . ($i + 1))
            ->mergeCells('O' . ($i + 2) . ':P' . ($i + 2))
            ->mergeCells('Q' . ($i + 1) . ':R' . ($i + 1))
            ->mergeCells('Q' . ($i + 2) . ':R' . ($i + 2))
            ->mergeCells('M' . $i . ':R' . $i);

        $this->excel->getActiveSheet()->getStyle('A' . $i . ':C' . ($i + 2))->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('D' . $i . ':F' . ($i + 2))->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('G' . $i . ':L' . $i)->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('G' . ($i + 1) . ':H' . ($i + 2))->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('I' . ($i + 1) . ':J' . ($i + 2))->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('K' . ($i + 1) . ':L' . ($i + 2))->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('M' . ($i + 1) . ':N' . ($i + 2))->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('O' . ($i + 1) . ':P' . ($i + 2))->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('Q' . ($i + 1) . ':R' . ($i + 2))->applyFromArray($styleArray4);
        $this->excel->getActiveSheet()->getStyle('M' . $i . ':R' . $i)->applyFromArray($styleArray4);

        /* $i = $i + 3;
        while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
            $meta_id = $row['meta_id'];
            $nombre_meta = $row['nombre'];

            $query_2 = "SELECT um.* FROM metas m, unidades_medidas um
                        WHERE um.unidad_medida_id = m.unidad_medida_id
                        AND m.meta_id = $meta_id";
            $result_2 = mysqli_query($connection, $query_2);

            $numero_unidad_medida = "";
            $nombre_unidad_medida = "";
            while ($row_2 = utf8_encode_all(mysqli_fetch_array($result_2))) {
                $numero_unidad_medida = $row_2['numero'];
                $nombre_unidad_medida = $row_2['nombre'];
            }

            $this->excel->getActiveSheet()
                ->setCellValue('B7', $nombre_meta);

            $this->excel->getActiveSheet()
                ->setCellValue('A' . $i, $nombre_meta)
                ->setCellValue('D' . $i, $nombre_unidad_medida);
            $this->excel->getActiveSheet()
                ->mergeCells('A' . $i . ':C' . $i)
                ->mergeCells('D' . $i . ':F' . $i);
            $this->excel->getActiveSheet()->getStyle('A' . $i . ':C' . $i)->applyFromArray($styleArray8);
            $this->excel->getActiveSheet()->getStyle('D' . $i . ':F' . $i)->applyFromArray($styleArray5);

            $caracteres_nombre_meta = strlen($nombre_meta);
            if ($caracteres_nombre_meta > 74) {
                $this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_meta / 74) * 13 + 13);
            }

            // Mejorar formato de celdas (denominacion de meta y unidad de medida)
            $this->excel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setWrapText(true);

            // Avance trimestral
            $query_2 = "SELECT SUM(mmp.numero) as 'trimestre_programada', SUM(mma.numero) as 'trimestre_alcanzada'
                    FROM metas m, meses_metas_programadas mmp, meses_metas_alcanzadas mma, meses
                        WHERE mmp.meta_id = m.meta_id
                        AND mma.meta_id = m.meta_id
                        AND mma.mes_id = meses.mes_id
                        AND mmp.mes_id = meses.mes_id
                        AND meses.nombre IN ($trimestre)
                        AND m.meta_id = $meta_id";
            $result_2 = mysqli_query($connection, $query_2);

            while ($row_2 = utf8_encode_all(mysqli_fetch_array($result_2))) {
                $trimestre_programada = $row_2['trimestre_programada'];
                $trimestre_alcanzada = $row_2['trimestre_alcanzada'];
                $avance = $trimestre_programada == 0 ? "No aplica" : number_format(($trimestre_alcanzada / $trimestre_programada) * 100, 1) . "%";

                $this->excel->getActiveSheet()
                    ->setCellValue('G' . $i, $trimestre_programada)
                    ->setCellValue('I' . $i, $trimestre_alcanzada)
                    ->setCellValue('K' . $i, $avance);

                $this->excel->getActiveSheet()
                    ->mergeCells('G' . $i . ':H' . $i)
                    ->mergeCells('I' . $i . ':J' . $i)
                    ->mergeCells('K' . $i . ':L' . $i);

                $this->excel->getActiveSheet()->getStyle('G' . $i . ':H' . $i)->applyFromArray($styleArray5);
                $this->excel->getActiveSheet()->getStyle('I' . $i . ':J' . $i)->applyFromArray($styleArray5);
                $this->excel->getActiveSheet()->getStyle('K' . $i . ':L' . $i)->applyFromArray($styleArray5);
            }

            // Avance acumulado
            $query_2 = "SELECT SUM(mmp.numero) as 'acumulada_programada', SUM(mma.numero) as 'acumulada_alcanzada'
                    FROM metas m, meses_metas_programadas mmp, meses_metas_alcanzadas mma, meses
                        WHERE mmp.meta_id = m.meta_id
                        AND mma.meta_id = m.meta_id
                        AND mma.mes_id = meses.mes_id
                        AND mmp.mes_id = meses.mes_id
                        AND meses.nombre IN ($trimestre_acumulada)
                        AND m.meta_id = $meta_id";
            $result_2 = mysqli_query($connection, $query_2);

            while ($row_2 = utf8_encode_all(mysqli_fetch_array($result_2))) {
                $acumulada_programada = $row_2['acumulada_programada'];
                $acumulada_alcanzada = $row_2['acumulada_alcanzada'];
                $avance = $acumulada_programada == 0 ? "No aplica" : number_format(($acumulada_alcanzada / $acumulada_programada) * 100, 1) . "%";

                $this->excel->getActiveSheet()
                    ->setCellValue('M' . $i, $acumulada_programada)
                    ->setCellValue('O' . $i, $acumulada_alcanzada)
                    ->setCellValue('Q' . $i, $avance);

                $this->excel->getActiveSheet()
                    ->mergeCells('M' . $i . ':N' . $i)
                    ->mergeCells('O' . $i . ':P' . $i)
                    ->mergeCells('Q' . $i . ':R' . $i);

                $this->excel->getActiveSheet()->getStyle('M' . $i . ':N' . $i)->applyFromArray($styleArray5);
                $this->excel->getActiveSheet()->getStyle('O' . $i . ':P' . $i)->applyFromArray($styleArray5);
                $this->excel->getActiveSheet()->getStyle('Q' . $i . ':R' . $i)->applyFromArray($styleArray5);
            }
            $i++;
        }

        $this->excel->getActiveSheet()
            ->setCellValue('A' . $i, "EXPLICACIÓN DEL AVANCE FÍSICO");
        $this->excel->getActiveSheet()
            ->mergeCells('A' . $i . ':R' . $i);
        $this->excel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
            ->applyFromArray($styleArray6);

        $i++;

        $query_3 = "SELECT m.* FROM proyectos p, metas m
                    WHERE p.proyecto_id = m.proyecto_id
                    AND m.tipo = 'principal'
                    AND p.proyecto_id = $proyecto_id";
        $result_3 = mysqli_query($connection, $query_3);

        $entra_ciclo = false;
        if (mysqli_num_rows($result_3) > 0) {
            $explicacion_global = "";
            while ($row_3 = utf8_encode_all(mysqli_fetch_array($result_3))) {
                $meta_id = $row_3['meta_id'];
                $nombre_meta = $row_3['nombre'];

                $query_4 = "SELECT meses.nombre as 'nombre_mes', mma.explicacion
                                FROM metas m, meses_metas_alcanzadas mma, meses
                                    WHERE mma.meta_id = m.meta_id
                                    AND mma.mes_id = meses.mes_id
                                    AND meses.nombre IN ($trimestre_acumulada)
                                    AND m.meta_id = $meta_id ORDER BY mma.mes_id";
                $result_4 = mysqli_query($connection, $query_4);

                while ($row_4 = utf8_encode_all(mysqli_fetch_array($result_4))) {
                    $nombre_mes = ucwords($row_4['nombre_mes']);
                    $explicacion = $row_4['explicacion'];

                    if ($explicacion != "") {
                        if (!$entra_ciclo) {
                            $entra_ciclo = true;
                        }
                        $explicacion_global = "$nombre_mes: $explicacion\r\n";

                        $this->excel->getActiveSheet()
                            ->setCellValue('A' . $i, $explicacion_global);
                        $this->excel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);

                        $this->excel->getActiveSheet()
                            ->mergeCells('A' . $i . ':R' . $i);
                        $this->excel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
                            ->applyFromArray($styleArray7);

                        $caracteres_explicacion = strlen($explicacion_global);
                        if ($caracteres_explicacion > 227) {
                            $this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(intval($caracteres_explicacion / 227) * 13 + 18);
                        } else {
                            $this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(18);
                        }
                        $i++;
                    }
                }
            }
        }

        if (!$entra_ciclo) {
            $this->excel->getActiveSheet()
                ->mergeCells('A' . $i . ':R' . $i);
            $this->excel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
                ->applyFromArray($styleArray7);
            $i++;
        }

        // Metas Complementarias
        // AGREGADO 29/FEBRERO/2012 -> El nombre de la meta no debe estar vacío (Correccion de inconsistencia de version anterior)
        $query = "SELECT m.* FROM proyectos p, metas m
                    WHERE p.proyecto_id = m.proyecto_id
                    AND m.tipo = 'complementaria'
                    AND m.nombre != ''
                    AND m.nombre != 'No aplica'
                    AND p.proyecto_id = $proyecto_id ORDER BY m.orden";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {

            $i += 1;

            $this->excel->getActiveSheet()
                ->setCellValue('A' . $i, "METAS COMPLEMENTARIAS")
                ->setCellValue('A' . ($i + 1), "AVANCE MENSUAL Y ACUMULADO");
            $this->excel->getActiveSheet()
                ->mergeCells('A' . $i . ':R' . $i)
                ->mergeCells('A' . ($i + 1) . ':R' . ($i + 1));
            $this->excel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)->applyFromArray($styleArray10);
            $this->excel->getActiveSheet()->getStyle('A' . ($i + 1) . ':R' . ($i + 1))->applyFromArray($styleArray9);

            $i += 2;

            $this->excel->getActiveSheet()
                ->setCellValue('A' . $i, "Denominación de la meta")
                ->setCellValue('D' . $i, "Unidad de medida")
                ->setCellValue('G' . $i, "Trimestre $titulo_trimestre")
                ->setCellValue('G' . ($i + 1), "Programada")
                ->setCellValue('G' . ($i + 2), "(1)")
                ->setCellValue('I' . ($i + 1), "Alcanzada")
                ->setCellValue('I' . ($i + 2), "(2)")
                ->setCellValue('K' . ($i + 1), "Avance %")
                ->setCellValue('K' . ($i + 2), "(2)(1)")
                ->setCellValue('M' . ($i + 1), "Programada")
                ->setCellValue('M' . ($i + 2), "(3)")
                ->setCellValue('O' . ($i + 1), "Alcanzada")
                ->setCellValue('O' . ($i + 2), "(4)")
                ->setCellValue('Q' . ($i + 1), "Avance %")
                ->setCellValue('Q' . ($i + 2), "(4)(3)")
                ->setCellValue('M' . $i, "Acumulado");

            $this->excel->getActiveSheet()
                ->mergeCells('A' . $i . ':C' . ($i + 2))
                ->mergeCells('D' . $i . ':F' . ($i + 2))
                ->mergeCells('G' . $i . ':L' . $i)
                ->mergeCells('G' . ($i + 1) . ':H' . ($i + 1))
                ->mergeCells('G' . ($i + 2) . ':H' . ($i + 2))
                ->mergeCells('I' . ($i + 1) . ':J' . ($i + 1))
                ->mergeCells('I' . ($i + 2) . ':J' . ($i + 2))
                ->mergeCells('K' . ($i + 1) . ':L' . ($i + 1))
                ->mergeCells('K' . ($i + 2) . ':L' . ($i + 2))
                ->mergeCells('M' . ($i + 1) . ':N' . ($i + 1))
                ->mergeCells('M' . ($i + 2) . ':N' . ($i + 2))
                ->mergeCells('O' . ($i + 1) . ':P' . ($i + 1))
                ->mergeCells('O' . ($i + 2) . ':P' . ($i + 2))
                ->mergeCells('Q' . ($i + 1) . ':R' . ($i + 1))
                ->mergeCells('Q' . ($i + 2) . ':R' . ($i + 2))
                ->mergeCells('M' . $i . ':R' . $i);

            $this->excel->getActiveSheet()->getStyle('A' . $i . ':C' . ($i + 2))->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('D' . $i . ':F' . ($i + 2))->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('G' . $i . ':L' . $i)->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('G' . ($i + 1) . ':H' . ($i + 2))->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('I' . ($i + 1) . ':J' . ($i + 2))->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('K' . ($i + 1) . ':L' . ($i + 2))->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('M' . ($i + 1) . ':N' . ($i + 2))->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('O' . ($i + 1) . ':P' . ($i + 2))->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('Q' . ($i + 1) . ':R' . ($i + 2))->applyFromArray($styleArray4);
            $this->excel->getActiveSheet()->getStyle('M' . $i . ':R' . $i)->applyFromArray($styleArray4);

            $i = $i + 3;
            $j = 1;
            while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
                $meta_id = $row['meta_id'];
                $nombre_meta = $row['nombre'];

                $query_2 = "SELECT um.* FROM metas m, unidades_medidas um
                            WHERE um.unidad_medida_id = m.unidad_medida_id
                            AND m.meta_id = $meta_id";
                $result_2 = mysqli_query($connection, $query_2);

                $numero_unidad_medida = "";
                $nombre_unidad_medida = "";
                while ($row_2 = utf8_encode_all(mysqli_fetch_array($result_2))) {
                    $numero_unidad_medida = $row_2['numero'];
                    $nombre_unidad_medida = $row_2['nombre'];
                }

                $objRichText = new PHPExcel_RichText();
                $objRichText->createText($nombre_meta);

                $objCubed = $objRichText->createTextRun($j);
                $objCubed->getFont()->setSuperScript(true);

                $this->excel->getActiveSheet()->getCell('A' . $i)->setValue($objRichText);

                $this->excel->getActiveSheet()
                    //->setCellValue('A' . $i, "($j) " . $nombre_meta)
                    ->setCellValue('D' . $i, $nombre_unidad_medida);
                $this->excel->getActiveSheet()
                    ->mergeCells('A' . $i . ':C' . $i)
                    ->mergeCells('D' . $i . ':F' . $i);
                $this->excel->getActiveSheet()->getStyle('A' . $i . ':C' . $i)->applyFromArray($styleArray8);
                $this->excel->getActiveSheet()->getStyle('D' . $i . ':F' . $i)->applyFromArray($styleArray5);

                $caracteres_nombre_meta = strlen($nombre_meta);
                if ($caracteres_nombre_meta > 74) {
                    $this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_meta / 74) * 13 + 18);
                } else {
                    $this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(18);
                }

                // Mejorar formato de celdas (denominacion de meta y unidad de medida)
                $this->excel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setWrapText(true);

                // Avance de metas
                $query_2 = "SELECT SUM(mmp.numero) as 'trimestre_programada', SUM(mma.numero) as 'trimestre_alcanzada'
                            FROM metas m, meses_metas_programadas mmp, meses_metas_alcanzadas mma, meses
                                WHERE mmp.meta_id = m.meta_id
                                AND mma.meta_id = m.meta_id
                                AND mma.mes_id = meses.mes_id
                                AND mmp.mes_id = meses.mes_id
                                AND meses.nombre IN ($trimestre)
                                AND m.meta_id = $meta_id";
                $result_2 = mysqli_query($connection, $query_2);

                while ($row_2 = utf8_encode_all(mysqli_fetch_array($result_2))) {
                    $trimestre_programada = $row_2['trimestre_programada'];
                    $trimestre_alcanzada = $row_2['trimestre_alcanzada'];
                    $avance = $trimestre_programada == 0 ? "No aplica" : number_format(($trimestre_alcanzada / $trimestre_programada) * 100, 1) . "%";

                    $this->excel->getActiveSheet()
                        ->setCellValue('G' . $i, $trimestre_programada)
                        ->setCellValue('I' . $i, $trimestre_alcanzada)
                        ->setCellValue('K' . $i, $avance);

                    $this->excel->getActiveSheet()
                        ->mergeCells('G' . $i . ':H' . $i)
                        ->mergeCells('I' . $i . ':J' . $i)
                        ->mergeCells('K' . $i . ':L' . $i);

                    $this->excel->getActiveSheet()->getStyle('G' . $i . ':H' . $i)->applyFromArray($styleArray5);
                    $this->excel->getActiveSheet()->getStyle('I' . $i . ':J' . $i)->applyFromArray($styleArray5);
                    $this->excel->getActiveSheet()->getStyle('K' . $i . ':L' . $i)->applyFromArray($styleArray5);

                }

                $query_2 = "SELECT SUM(mmp.numero) as 'acumulada_programada', SUM(mma.numero) as 'acumulada_alcanzada'
                        FROM metas m, meses_metas_programadas mmp, meses_metas_alcanzadas mma, meses
                            WHERE mmp.meta_id = m.meta_id
                            AND mma.meta_id = m.meta_id
                            AND mma.mes_id = meses.mes_id
                            AND mmp.mes_id = meses.mes_id
                            AND meses.nombre IN ($trimestre_acumulada)
                            AND m.meta_id = $meta_id";
                $result_2 = mysqli_query($connection, $query_2);

                while ($row_2 = utf8_encode_all(mysqli_fetch_array($result_2))) {
                    $acumulada_programada = $row_2['acumulada_programada'];
                    $acumulada_alcanzada = $row_2['acumulada_alcanzada'];
                    $avance = $acumulada_programada == 0 ? "No aplica" : number_format(($acumulada_alcanzada / $acumulada_programada) * 100, 1) . "%";

                    $this->excel->getActiveSheet()
                        ->setCellValue('M' . $i, $acumulada_programada)
                        ->setCellValue('O' . $i, $acumulada_alcanzada)
                        ->setCellValue('Q' . $i, $avance);

                    $this->excel->getActiveSheet()
                        ->mergeCells('M' . $i . ':N' . $i)
                        ->mergeCells('O' . $i . ':P' . $i)
                        ->mergeCells('Q' . $i . ':R' . $i);

                    $this->excel->getActiveSheet()->getStyle('M' . $i . ':N' . $i)->applyFromArray($styleArray5);
                    $this->excel->getActiveSheet()->getStyle('O' . $i . ':P' . $i)->applyFromArray($styleArray5);
                    $this->excel->getActiveSheet()->getStyle('Q' . $i . ':R' . $i)->applyFromArray($styleArray5);
                }
                $i++;
                $j++;
            }
        }

        $query_3 = "SELECT m.* FROM proyectos p, metas m
                    WHERE p.proyecto_id = m.proyecto_id
                    AND m.tipo = 'complementaria'
                    AND m.nombre != ''
                    AND m.nombre != 'No aplica'
                    AND p.proyecto_id = $proyecto_id ORDER BY m.orden";
        $result_3 = mysqli_query($connection, $query_3);

        $entra_ciclo = false;
        if (mysqli_num_rows($result_3) > 0) {
            $this->excel->getActiveSheet()
                ->setCellValue('A' . $i, "EXPLICACIÓN DEL AVANCE FÍSICO");
            $this->excel->getActiveSheet()
                ->mergeCells('A' . $i . ':R' . $i);
            $this->excel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
                ->applyFromArray($styleArray6);

            $i++;

            $j = 1;
            $explicacion_global = "";
            while ($row_3 = utf8_encode_all(mysqli_fetch_array($result_3))) {
                $meta_id = $row_3['meta_id'];
                $nombre_meta = $row_3['nombre'];

                $query_4 = "SELECT meses.nombre as 'nombre_mes', mma.explicacion
                                FROM metas m, meses_metas_alcanzadas mma, meses
                                    WHERE mma.meta_id = m.meta_id
                                    AND mma.mes_id = meses.mes_id
                                    AND meses.nombre IN ($trimestre_acumulada)
                                    AND m.meta_id = $meta_id ORDER BY mma.mes_id";
                $result_4 = mysqli_query($connection, $query_4);

                while ($row_4 = utf8_encode_all(mysqli_fetch_array($result_4))) {
                    $nombre_mes = ucwords($row_4['nombre_mes']);
                    $explicacion = $row_4['explicacion'];

                    if ($explicacion != "") {
                        if (!$entra_ciclo) {
                            $entra_ciclo = true;
                        }
                        //echo "<div>$nombre_mes<sup class='bold'>$j</sup>: $explicacion</div>";
                        $explicacion_global = "$nombre_mes ($j): $explicacion\r\n";

                        $this->excel->getActiveSheet()
                            ->setCellValue('A' . $i, $explicacion_global);
                        $this->excel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);

                        $this->excel->getActiveSheet()
                            ->mergeCells('A' . $i . ':R' . $i);
                        $this->excel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
                            ->applyFromArray($styleArray7);

                        $caracteres_explicacion = strlen($explicacion_global);
                        if ($caracteres_explicacion > 227) {
                            $this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(intval($caracteres_explicacion / 227) * 13 + 18);
                        } else {
                            $this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(18);
                        }
                        $i++;
                    }
                }
                $j++;
            }
        }

        if (!$entra_ciclo) {
            $this->excel->getActiveSheet()
                ->mergeCells('A' . $i . ':R' . $i);
            $this->excel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
                ->applyFromArray($styleArray7);
            $i++;
        }
        */

        $this->excel->getActiveSheet()
            ->mergeCells('A1:R1')
            ->mergeCells('A2:R2')
            ->mergeCells('B3:R3')
            ->mergeCells('B4:R4')
            ->mergeCells('B5:R5')
            ->mergeCells('B6:R6')
            ->mergeCells('B7:R7');

        $this->excel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('A3:A7')->applyFromArray($styleArray2);
        $this->excel->getActiveSheet()->getStyle('B3:R7')->applyFromArray($styleArray3);

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(8);

        $i = 10;
        while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
            $this->excel->setActiveSheetIndex(0)
                ->setCellValue('B' . $i, "");
            $this->excel->getActiveSheet()->getCell('A' . $i)->setValueExplicit("", PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
            //$row["clave_primera_id"], $row["numero"], $row["nombre"]);
        }
        $i--;
        $this->excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 2);

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),
                ),
            ),
        );
        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "prueba.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }

    public function mensual($proyecto = false, $mes = false)
    {
        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Avance_mensual_y_acumulado');

        $cont = 1;

        /* $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('imgNotice');
        $objDrawing->setDescription('Noticia');
        $img = base_url('images/logo1-TEDF.png'); // Provide path to your logo file
        $objDrawing->setPath($img);
        $objDrawing->setOffsetX(28);    // setOffsetX works properly
        $objDrawing->setOffsetY(300);  //setOffsetY has no effect
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(150); // logo height
        $objDrawing->setWorksheet($this->excel->setActiveSheetIndex($cont)); */

        $this->excel->getActiveSheet()->mergeCells("B1:R1");
        $this->excel->getActiveSheet()->mergeCells("B2:R2");

        $this->excel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A4")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A7")->getFont()->setBold(true);

        $ejercicio = $this->home_inicio->get_ejercicio();

        $this->excel->getActiveSheet()->setCellValue("B1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio->ejercicio);
        $this->excel->getActiveSheet()->setCellValue("B2", 'AVANCE DE PROYECTOS');
        $this->excel->getActiveSheet()->setCellValue("A3", 'UNIDAD RESPONSABLE:');
        $this->excel->getActiveSheet()->setCellValue("A4", 'RESPONSABLE OPERATIVO:');
        $this->excel->getActiveSheet()->setCellValue("A5", 'CLAVE DEL PROYECTO:');
        $this->excel->getActiveSheet()->setCellValue("A6", 'DENOMINACIÓN DEL PROYECTO:');
        $this->excel->getActiveSheet()->setCellValue("A7", 'NOMBRE DE LA META PRINCIPAL:');

        $info = $this->seguimiento_model->getInfoProyecto($proyecto);
        $pry = $this->proyectos_model->getClaveProyecto($proyecto);
        $clave = $pry->urnum.'-'.$pry->ronum.'-'.$pry->pgnum.'-'.$pry->sbnum.'-'.$pry->pynum;

        $this->excel->getActiveSheet()->setCellValue('B3', $info->urnom);
        $this->excel->getActiveSheet()->setCellValue('B4', $info->ronom);
        $this->excel->getActiveSheet()->setCellValue('B5', $clave);
        $this->excel->getActiveSheet()->setCellValue('B6', $info->pynom);
        $this->excel->getActiveSheet()->setCellValue('B7', $info->mtnom);

        // Espacio para la meta principal
        $this->excel->getActiveSheet()->mergeCells("A9:R9");
        $this->excel->getActiveSheet()->mergeCells("A10:C12");
        $this->excel->getActiveSheet()->mergeCells("D10:F12");
        $this->excel->getActiveSheet()->mergeCells("G10:L10");
        $this->excel->getActiveSheet()->mergeCells("G11:H11");
        $this->excel->getActiveSheet()->mergeCells("G12:H12");
        $this->excel->getActiveSheet()->mergeCells("I11:J11");
        $this->excel->getActiveSheet()->mergeCells("I12:J12");
        $this->excel->getActiveSheet()->mergeCells("K11:L11");
        $this->excel->getActiveSheet()->mergeCells("K12:L12");
        $this->excel->getActiveSheet()->mergeCells("M10:R10");
        $this->excel->getActiveSheet()->mergeCells("M11:N11");
        $this->excel->getActiveSheet()->mergeCells("M12:N12");
        $this->excel->getActiveSheet()->mergeCells("O11:P11");
        $this->excel->getActiveSheet()->mergeCells("O12:P12");
        $this->excel->getActiveSheet()->mergeCells("Q11:R11");
        $this->excel->getActiveSheet()->mergeCells("Q12:R12");
        $this->excel->getActiveSheet()->mergeCells("A13:C13");
        $this->excel->getActiveSheet()->mergeCells("D13:F13");
        $this->excel->getActiveSheet()->mergeCells("G13:H13");
        $this->excel->getActiveSheet()->mergeCells("I13:J13");
        $this->excel->getActiveSheet()->mergeCells("K13:L13");
        $this->excel->getActiveSheet()->mergeCells("M13:N13");
        $this->excel->getActiveSheet()->mergeCells("O13:P13");
        $this->excel->getActiveSheet()->mergeCells("Q13:R13");
        $this->excel->getActiveSheet()->mergeCells("A14:R14");
        $this->excel->getActiveSheet()->mergeCells("A15:R15");
        // Espacio para las metas complementarias
        $this->excel->getActiveSheet()->mergeCells("A17:R17");
        $this->excel->getActiveSheet()->mergeCells("A18:R18");
        $this->excel->getActiveSheet()->mergeCells("A19:C21");
        $this->excel->getActiveSheet()->mergeCells("D19:F21");
        $this->excel->getActiveSheet()->mergeCells("G19:L19");
        $this->excel->getActiveSheet()->mergeCells("G20:H20");
        $this->excel->getActiveSheet()->mergeCells("G21:H21");
        $this->excel->getActiveSheet()->mergeCells("I20:J20");
        $this->excel->getActiveSheet()->mergeCells("I21:J21");
        $this->excel->getActiveSheet()->mergeCells("K20:L20");
        $this->excel->getActiveSheet()->mergeCells("K21:L21");
        $this->excel->getActiveSheet()->mergeCells("M19:R19");
        $this->excel->getActiveSheet()->mergeCells("M20:N20");
        $this->excel->getActiveSheet()->mergeCells("M21:N21");
        $this->excel->getActiveSheet()->mergeCells("O20:P20");
        $this->excel->getActiveSheet()->mergeCells("O21:P21");
        $this->excel->getActiveSheet()->mergeCells("Q20:R20");
        $this->excel->getActiveSheet()->mergeCells("Q21:R21");

        $this->excel->getActiveSheet()->getStyle("A9")->getFont()->setBold(true);

        $meses = $this->seguimiento_model->getNombreMes($mes);

        // META PRINCIPAL
        $this->excel->getActiveSheet()->setCellValue("A9", 'META PRINCIPAL');
        $this->excel->getActiveSheet()->setCellValue("A10", 'Denominación de la meta');
        $this->excel->getActiveSheet()->setCellValue("D10", 'Unidad de medida');
        $this->excel->getActiveSheet()->setCellValue("G10", ucfirst($meses->nombre));
        $this->excel->getActiveSheet()->setCellValue("G11", 'Programada');
        $this->excel->getActiveSheet()->setCellValue("G12", '(1)');
        $this->excel->getActiveSheet()->setCellValue("I11", 'Alcanzada');
        $this->excel->getActiveSheet()->setCellValue("I12", '(2)');
        $this->excel->getActiveSheet()->setCellValue("K11", 'Avance %');
        $this->excel->getActiveSheet()->setCellValue("K12", '(2)(1)');
        $this->excel->getActiveSheet()->setCellValue("M10", 'Acumulado Enero - '.$meses->nombre);
        $this->excel->getActiveSheet()->setCellValue("M11", 'Programada');
        $this->excel->getActiveSheet()->setCellValue("M12", '(3)');
        $this->excel->getActiveSheet()->setCellValue("O11", 'Alcanzada');
        $this->excel->getActiveSheet()->setCellValue("O12", '(4)');
        $this->excel->getActiveSheet()->setCellValue("Q11", 'Avance %');
        $this->excel->getActiveSheet()->setCellValue("Q12", '(4)(3)');
        $this->excel->getActiveSheet()->setCellValue("A14", 'EXPLICACIÓN DEL AVANCE FÍSICO');

        $res = $this->seguimiento_model->getMetaPrincipalAvance($mes, $proyecto);
        $this->excel->getActiveSheet()->setCellValue("A13", $res->nombre);
        $this->excel->getActiveSheet()->setCellValue("D13", $res->umnom);

        $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $res->meta_id);
        $this->excel->getActiveSheet()->setCellValue("G13", $row->numero);
        $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $res->meta_id);
        $this->excel->getActiveSheet()->setCellValue("I13", $row1->numero);
        $this->excel->getActiveSheet()->setCellValue("K13", $row1->porcentaje);
        $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $res->meta_id);
        $this->excel->getActiveSheet()->setCellValue("M13", $acumuladop->numero);
        $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $res->meta_id);
        $this->excel->getActiveSheet()->setCellValue("O13", $acumuladoa->numero);
        $pacm = $this->seguimiento_model->getPorcentajeAcumulado($res->meta_id, $mes);
        $this->excel->getActiveSheet()->setCellValue("Q13", $pacm->porcentaje);

        $explicaciones = $this->seguimiento_model->getExplicacionesMP($mes, $res->meta_id);
        $cadena = '';
        foreach ($explicaciones as $explicacion){
            $cadena .= $explicacion->nombre.' '.$explicacion->explicacion."\n";
        }
        $this->excel->getActiveSheet()->setCellValue("A15", $cadena);

        // METAS COMPLEMENTARIAS
        $this->excel->getActiveSheet()->setCellValue("A17", 'METAS COMPLEMENTARIAS');
        $this->excel->getActiveSheet()->setCellValue("A18", 'AVANCE MENSUAL Y ACUMULADO');
        $this->excel->getActiveSheet()->setCellValue("A19", 'Denominación de la meta');
        $this->excel->getActiveSheet()->setCellValue("D19", 'Unidad de medida');
        $this->excel->getActiveSheet()->setCellValue("G19", 'Mes');
        $this->excel->getActiveSheet()->setCellValue("G20", 'Programada');
        $this->excel->getActiveSheet()->setCellValue("G21", '(1)');
        $this->excel->getActiveSheet()->setCellValue("I20", 'Alcanzada');
        $this->excel->getActiveSheet()->setCellValue("I21", '(2)');
        $this->excel->getActiveSheet()->setCellValue("K20", 'Avance %');
        $this->excel->getActiveSheet()->setCellValue("K21", '(2)(1)');
        $this->excel->getActiveSheet()->setCellValue("M19", 'Acumulado Mes - '.$meses->nombre);
        $this->excel->getActiveSheet()->setCellValue("M20", 'Programada');
        $this->excel->getActiveSheet()->setCellValue("M21", '(3)');
        $this->excel->getActiveSheet()->setCellValue("O20", 'Alcanzada');
        $this->excel->getActiveSheet()->setCellValue("O21", '(4)');
        $this->excel->getActiveSheet()->setCellValue("Q20", 'Avance %');
        $this->excel->getActiveSheet()->setCellValue("Q21", '(4)(3)');

        $complementarias = $this->seguimiento_model->getMetasComplementariasAvance($mes, $proyecto);
        $i = 22;
        foreach ($complementarias as $complementaria){
            $this->excel->getActiveSheet()->mergeCells("A".$i.":C".$i);
            $this->excel->getActiveSheet()->mergeCells("D".$i.":F".$i);
            $this->excel->getActiveSheet()->mergeCells("G".$i.":H".$i);
            $this->excel->getActiveSheet()->mergeCells("I".$i.":J".$i);
            $this->excel->getActiveSheet()->mergeCells("K".$i.":L".$i);
            $this->excel->getActiveSheet()->mergeCells("M".$i.":N".$i);
            $this->excel->getActiveSheet()->mergeCells("O".$i.":P".$i);
            $this->excel->getActiveSheet()->mergeCells("Q".$i.":R".$i);

            $this->excel->getActiveSheet()->setCellValue("A".$i, $complementaria->nombre);
            $this->excel->getActiveSheet()->setCellValue("D".$i, $complementaria->umnom);
            $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $complementaria->meta_id);
            $this->excel->getActiveSheet()->setCellValue("G".$i, $row->numero);
            $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $complementaria->meta_id);
            $this->excel->getActiveSheet()->setCellValue("I".$i, $row1->numero);
            $this->excel->getActiveSheet()->setCellValue("K".$i, $row1->porcentaje);
            $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $complementaria->meta_id);
            $this->excel->getActiveSheet()->setCellValue("M".$i, $acumuladop->numero);
            $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $complementaria->meta_id);
            $this->excel->getActiveSheet()->setCellValue("O".$i, $acumuladoa->numero);
            $pacm = $this->seguimiento_model->getPorcentajeAcumulado($complementaria->meta_id, $mes);
            $this->excel->getActiveSheet()->setCellValue("Q".$i, $pacm->porcentaje);
            $i++;
        }

        $this->excel->getActiveSheet()->mergeCells("A".$i.":R".$i);
        $this->excel->getActiveSheet()->setCellValue("A".$i, 'EXPLICACIÓN DEL AVANCE FÍSICO');
        $i++;


        $archivo = "Avance_mensual_y_acumulado.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
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

        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Avance_mensual_y_acumulado');

        /* $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('imgNotice');
        $objDrawing->setDescription('Noticia');
        $img = base_url('images/logo1-TEDF.png'); // Provide path to your logo file
        $objDrawing->setPath($img);
        $objDrawing->setOffsetX(28);    // setOffsetX works properly
        $objDrawing->setOffsetY(300);  //setOffsetY has no effect
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(150); // logo height
        $objDrawing->setWorksheet($this->excel->setActiveSheetIndex($cont)); */

        $this->excel->getActiveSheet()->mergeCells("B1:R1");
        $this->excel->getActiveSheet()->mergeCells("B2:R2");

        $this->excel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B2")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A4")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("A7")->getFont()->setBold(true);

        $ejercicio = $this->home_inicio->get_ejercicio();

        $this->excel->getActiveSheet()->setCellValue("B1", 'PROGRAMA OPERATIVO ANUAL '.$ejercicio->ejercicio);
        $this->excel->getActiveSheet()->setCellValue("B2", 'AVANCE DE PROYECTOS');
        $this->excel->getActiveSheet()->setCellValue("A3", 'UNIDAD RESPONSABLE:');
        $this->excel->getActiveSheet()->setCellValue("A4", 'RESPONSABLE OPERATIVO:');
        $this->excel->getActiveSheet()->setCellValue("A5", 'CLAVE DEL PROYECTO:');
        $this->excel->getActiveSheet()->setCellValue("A6", 'DENOMINACIÓN DEL PROYECTO:');
        $this->excel->getActiveSheet()->setCellValue("A7", 'NOMBRE DE LA META PRINCIPAL:');

        $info = $this->seguimiento_model->getInfoProyecto($proyecto);
        $pry = $this->proyectos_model->getClaveProyecto($proyecto);
        $clave = $pry->urnum.'-'.$pry->ronum.'-'.$pry->pgnum.'-'.$pry->sbnum.'-'.$pry->pynum;

        $this->excel->getActiveSheet()->setCellValue('B3', $info->urnom);
        $this->excel->getActiveSheet()->setCellValue('B4', $info->ronom);
        $this->excel->getActiveSheet()->setCellValue('B5', $clave);
        $this->excel->getActiveSheet()->setCellValue('B6', $info->pynom);
        $this->excel->getActiveSheet()->setCellValue('B7', $info->mtnom);

        // Espacio para la meta principal
        $this->excel->getActiveSheet()->mergeCells("A9:R9");
        $this->excel->getActiveSheet()->mergeCells("A10:C12");
        $this->excel->getActiveSheet()->mergeCells("D10:F12");
        $this->excel->getActiveSheet()->mergeCells("G10:L10");
        $this->excel->getActiveSheet()->mergeCells("G11:H11");
        $this->excel->getActiveSheet()->mergeCells("G12:H12");
        $this->excel->getActiveSheet()->mergeCells("I11:J11");
        $this->excel->getActiveSheet()->mergeCells("I12:J12");
        $this->excel->getActiveSheet()->mergeCells("K11:L11");
        $this->excel->getActiveSheet()->mergeCells("K12:L12");
        $this->excel->getActiveSheet()->mergeCells("M10:R10");
        $this->excel->getActiveSheet()->mergeCells("M11:N11");
        $this->excel->getActiveSheet()->mergeCells("M12:N12");
        $this->excel->getActiveSheet()->mergeCells("O11:P11");
        $this->excel->getActiveSheet()->mergeCells("O12:P12");
        $this->excel->getActiveSheet()->mergeCells("Q11:R11");
        $this->excel->getActiveSheet()->mergeCells("Q12:R12");
        $this->excel->getActiveSheet()->mergeCells("A13:C13");
        $this->excel->getActiveSheet()->mergeCells("D13:F13");
        $this->excel->getActiveSheet()->mergeCells("G13:H13");
        $this->excel->getActiveSheet()->mergeCells("I13:J13");
        $this->excel->getActiveSheet()->mergeCells("K13:L13");
        $this->excel->getActiveSheet()->mergeCells("M13:N13");
        $this->excel->getActiveSheet()->mergeCells("O13:P13");
        $this->excel->getActiveSheet()->mergeCells("Q13:R13");
        $this->excel->getActiveSheet()->mergeCells("A14:R14");
        $this->excel->getActiveSheet()->mergeCells("A15:R15");
        // Espacio para las metas complementarias
        $this->excel->getActiveSheet()->mergeCells("A17:R17");
        $this->excel->getActiveSheet()->mergeCells("A18:R18");
        $this->excel->getActiveSheet()->mergeCells("A19:C21");
        $this->excel->getActiveSheet()->mergeCells("D19:F21");
        $this->excel->getActiveSheet()->mergeCells("G19:L19");
        $this->excel->getActiveSheet()->mergeCells("G20:H20");
        $this->excel->getActiveSheet()->mergeCells("G21:H21");
        $this->excel->getActiveSheet()->mergeCells("I20:J20");
        $this->excel->getActiveSheet()->mergeCells("I21:J21");
        $this->excel->getActiveSheet()->mergeCells("K20:L20");
        $this->excel->getActiveSheet()->mergeCells("K21:L21");
        $this->excel->getActiveSheet()->mergeCells("M19:R19");
        $this->excel->getActiveSheet()->mergeCells("M20:N20");
        $this->excel->getActiveSheet()->mergeCells("M21:N21");
        $this->excel->getActiveSheet()->mergeCells("O20:P20");
        $this->excel->getActiveSheet()->mergeCells("O21:P21");
        $this->excel->getActiveSheet()->mergeCells("Q20:R20");
        $this->excel->getActiveSheet()->mergeCells("Q21:R21");

        $this->excel->getActiveSheet()->getStyle("A9")->getFont()->setBold(true);

        $meses = $this->seguimiento_model->getNombreMes($mes);

        // META PRINCIPAL
        $this->excel->getActiveSheet()->setCellValue("A9", 'META PRINCIPAL');
        $this->excel->getActiveSheet()->setCellValue("A10", 'Denominación de la meta');
        $this->excel->getActiveSheet()->setCellValue("D10", 'Unidad de medida');
        $this->excel->getActiveSheet()->setCellValue("G10", $mnombre);
        $this->excel->getActiveSheet()->setCellValue("G11", 'Programada');
        $this->excel->getActiveSheet()->setCellValue("G12", '(1)');
        $this->excel->getActiveSheet()->setCellValue("I11", 'Alcanzada');
        $this->excel->getActiveSheet()->setCellValue("I12", '(2)');
        $this->excel->getActiveSheet()->setCellValue("K11", 'Avance %');
        $this->excel->getActiveSheet()->setCellValue("K12", '(2)(1)');
        $this->excel->getActiveSheet()->setCellValue("M10", 'Acumulado');
        $this->excel->getActiveSheet()->setCellValue("M11", 'Programada');
        $this->excel->getActiveSheet()->setCellValue("M12", '(3)');
        $this->excel->getActiveSheet()->setCellValue("O11", 'Alcanzada');
        $this->excel->getActiveSheet()->setCellValue("O12", '(4)');
        $this->excel->getActiveSheet()->setCellValue("Q11", 'Avance %');
        $this->excel->getActiveSheet()->setCellValue("Q12", '(4)(3)');
        $this->excel->getActiveSheet()->setCellValue("A14", 'EXPLICACIÓN DEL AVANCE FÍSICO');

        $res = $this->seguimiento_model->getMetaPrincipalAvance($mes, $proyecto);
        $this->excel->getActiveSheet()->setCellValue("A13", $res->nombre);
        $this->excel->getActiveSheet()->setCellValue("D13", $res->umnom);

        $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $res->meta_id);
        $this->excel->getActiveSheet()->setCellValue("G13", $row->numero);
        $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $res->meta_id);
        $this->excel->getActiveSheet()->setCellValue("I13", $row1->numero);
        $this->excel->getActiveSheet()->setCellValue("K13", $row1->porcentaje);
        $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $res->meta_id);
        $this->excel->getActiveSheet()->setCellValue("M13", $acumuladop->numero);
        $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $res->meta_id);
        $this->excel->getActiveSheet()->setCellValue("O13", $acumuladoa->numero);
        $pacm = $this->seguimiento_model->getPorcentajeAcumulado($res->meta_id, $mes);
        $this->excel->getActiveSheet()->setCellValue("Q13", $pacm->porcentaje_real);

        $explicaciones = $this->seguimiento_model->getExplicacionesMP($mes, $res->meta_id);
        $cadena = '';
        foreach ($explicaciones as $explicacion){
            $cadena .= $explicacion->nombre.' '.$explicacion->explicacion."\n";
        }
        $this->excel->getActiveSheet()->setCellValue("A15", $cadena);

        // METAS COMPLEMENTARIAS
        $this->excel->getActiveSheet()->setCellValue("A17", 'METAS COMPLEMENTARIAS');
        $this->excel->getActiveSheet()->setCellValue("A18", 'AVANCE MENSUAL Y ACUMULADO');
        $this->excel->getActiveSheet()->setCellValue("A19", 'Denominación de la meta');
        $this->excel->getActiveSheet()->setCellValue("D19", 'Unidad de medida');
        $this->excel->getActiveSheet()->setCellValue("G19", $mnombre);
        $this->excel->getActiveSheet()->setCellValue("G20", 'Programada');
        $this->excel->getActiveSheet()->setCellValue("G21", '(1)');
        $this->excel->getActiveSheet()->setCellValue("I20", 'Alcanzada');
        $this->excel->getActiveSheet()->setCellValue("I21", '(2)');
        $this->excel->getActiveSheet()->setCellValue("K20", 'Avance %');
        $this->excel->getActiveSheet()->setCellValue("K21", '(2)(1)');
        $this->excel->getActiveSheet()->setCellValue("M19", 'Acumulado');
        $this->excel->getActiveSheet()->setCellValue("M20", 'Programada');
        $this->excel->getActiveSheet()->setCellValue("M21", '(3)');
        $this->excel->getActiveSheet()->setCellValue("O20", 'Alcanzada');
        $this->excel->getActiveSheet()->setCellValue("O21", '(4)');
        $this->excel->getActiveSheet()->setCellValue("Q20", 'Avance %');
        $this->excel->getActiveSheet()->setCellValue("Q21", '(4)(3)');

        $complementarias = $this->seguimiento_model->getMetasComplementariasAvance($mes, $proyecto);
        $i = 22;
        foreach ($complementarias as $complementaria){
            $this->excel->getActiveSheet()->mergeCells("A".$i.":C".$i);
            $this->excel->getActiveSheet()->mergeCells("D".$i.":F".$i);
            $this->excel->getActiveSheet()->mergeCells("G".$i.":H".$i);
            $this->excel->getActiveSheet()->mergeCells("I".$i.":J".$i);
            $this->excel->getActiveSheet()->mergeCells("K".$i.":L".$i);
            $this->excel->getActiveSheet()->mergeCells("M".$i.":N".$i);
            $this->excel->getActiveSheet()->mergeCells("O".$i.":P".$i);
            $this->excel->getActiveSheet()->mergeCells("Q".$i.":R".$i);

            $this->excel->getActiveSheet()->setCellValue("A".$i, $complementaria->nombre);
            $this->excel->getActiveSheet()->setCellValue("D".$i, $complementaria->umnom);
            $row = $this->seguimiento_model->getAvanceMesProgramado($mes, $complementaria->meta_id);
            $this->excel->getActiveSheet()->setCellValue("G".$i, $row->numero);
            $row1 = $this->seguimiento_model->getAvanceMesAlcanzado($mes, $complementaria->meta_id);
            $this->excel->getActiveSheet()->setCellValue("I".$i, $row1->numero);
            $this->excel->getActiveSheet()->setCellValue("K".$i, $row1->porcentaje);
            $acumuladop = $this->seguimiento_model->getAvanceProgramadoAcumulado($mes, $complementaria->meta_id);
            $this->excel->getActiveSheet()->setCellValue("M".$i, $acumuladop->numero);
            $acumuladoa = $this->seguimiento_model->getAvanceAlcanzadoAcumulado($mes, $complementaria->meta_id);
            $this->excel->getActiveSheet()->setCellValue("O".$i, $acumuladoa->numero);
            $pacm = $this->seguimiento_model->getPorcentajeAcumulado($complementaria->meta_id, $mes);
            $this->excel->getActiveSheet()->setCellValue("Q".$i, $pacm->porcentaje_real);
            $i++;
        }

        $this->excel->getActiveSheet()->mergeCells("A".$i.":R".$i);
        $this->excel->getActiveSheet()->setCellValue("A".$i, 'EXPLICACIÓN DEL AVANCE FÍSICO');
        $i++;


        $archivo = "Avance_trimestral_y_acumulado.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }
}
