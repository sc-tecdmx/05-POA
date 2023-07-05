<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

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
        $this->load->library('Excel');
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
        $columnas = ['J','K','L','M','N','O','P','Q','R','S','T','U'];

        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Matriz Avance');

        // Estilos
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

        $estilo_izquierdo = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
            ),
        );

        $estilo_bordes_internos = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FF000000',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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

        $estilo_programas = array(
            'font' => array(
                'size' => 10,
                'color' => array(
                    'argb' => 'FFFFFFFF',
                ),
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FF244062',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFA5D6FE',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFD8E4BC',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFEEECE1',
                ),
            ),
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
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

        // Definición de encabezados estaticos
        $this->excel->getActiveSheet()->mergeCells("A1:O1");
        $this->excel->getActiveSheet()->mergeCells("A2:O2");
        $this->excel->getActiveSheet()->mergeCells("A3:A4");
        $this->excel->getActiveSheet()->mergeCells("B3:B4");
        $this->excel->getActiveSheet()->mergeCells("C3:C4");
        $this->excel->getActiveSheet()->mergeCells("D3:D4");
        $this->excel->getActiveSheet()->mergeCells("E3:E4");
        $this->excel->getActiveSheet()->mergeCells("F3:G4");
        $this->excel->getActiveSheet()->mergeCells("H3:H4");
        $this->excel->getActiveSheet()->mergeCells("I3:I4");

        // Definición de encabezados dinamicos
        $letra = $this->_obtenerLetra($mes);
        $this->excel->getActiveSheet()->mergeCells("J3:".$letra.'3');
        $ultimaLetra = $this->_obtenerUltimaLetra($letra);
        $this->excel->getActiveSheet()->mergeCells($ultimaLetra."3:".$ultimaLetra."4");

        $this->excel->getActiveSheet()->setCellValue("A1", 'PROGRAMA OPERATIVO ANUAL '.$this->session->userdata('anio'));
        $this->excel->getActiveSheet()->setCellValue("A2", 'AVANCE DE PROYECTOS');

        $this->excel->getActiveSheet()->setCellValue("A3", 'URG');
        $this->excel->getActiveSheet()->setCellValue("B3", 'RO');
        $this->excel->getActiveSheet()->setCellValue("C3", 'PG');
        $this->excel->getActiveSheet()->setCellValue("D3", 'SP');
        $this->excel->getActiveSheet()->setCellValue("E3", 'PY');
        $this->excel->getActiveSheet()->setCellValue("F3", 'Denominación');
        $this->excel->getActiveSheet()->setCellValue("H3", 'Unidad de medida');
        $this->excel->getActiveSheet()->setCellValue("I3", 'Meta');
        $this->excel->getActiveSheet()->setCellValue("J3", 'Meses');

        for($j = 1; $j <= $mes; $j++){
            $nombreMes = $this->home_inicio->getMesesSmall($j);
            if($nombreMes){
                $this->excel->getActiveSheet()->setCellValue($columnas[$j-1]."4", $nombreMes->small);
            }
        }

        $this->excel->getActiveSheet()->setCellValue($ultimaLetra."3", 'Total');

        $programas = $this->reportes->getProgramas($this->session->userdata('ejercicio'));
        $i = 5;
        foreach($programas as $programa) {
            $this->excel->getActiveSheet()->setCellValue("C".$i, $programa->numero);
            $this->excel->getActiveSheet()->setCellValue("F".$i, $programa->nombre);
            $subprogramas = $this->reportes->getSubprogramas($programa->programa_id);
            foreach($subprogramas as $subprograma){
                $i++;
                $this->excel->getActiveSheet()->setCellValue("D".$i, $subprograma->numero);
                $this->excel->getActiveSheet()->setCellValue("F".$i, $subprograma->nombre);
                $proyectos = $this->reportes->getProyectos($subprograma->subprograma_id);
                foreach($proyectos as $proyecto){
                    $i++;

                    $this->excel->getActiveSheet()->setCellValue("A".$i, $proyecto->urnum);
                    $this->excel->getActiveSheet()->setCellValue("B".$i, $proyecto->ronum);
                    $this->excel->getActiveSheet()->setCellValue("C".$i, $proyecto->pgnum);
                    $this->excel->getActiveSheet()->setCellValue("D".$i, $proyecto->sbnum);
                    $this->excel->getActiveSheet()->setCellValue("E".$i, $proyecto->pynum);

                    $this->excel->getActiveSheet()->mergeCells("F".$i.":G".$i);
                    $this->excel->getActiveSheet()->setCellValue("F".$i, $proyecto->pynom);

                    $metas = $this->reportes->getMetas($proyecto->proyecto_id);
                    foreach($metas as $meta){
                        $i++;
                        $indice = $i + 1;

                        $this->excel->getActiveSheet()->mergeCells("A". $i .":A". $indice);
                        $this->excel->getActiveSheet()->mergeCells("B". $i .":B". $indice);
                        $this->excel->getActiveSheet()->mergeCells("C". $i .":C". $indice);
                        $this->excel->getActiveSheet()->mergeCells("D". $i .":D". $indice);
                        $this->excel->getActiveSheet()->mergeCells("E". $i .":E". $indice);
                        $this->excel->getActiveSheet()->mergeCells("F". $i .":F". $indice);
                        $this->excel->getActiveSheet()->mergeCells("G". $i .":G". $indice);
                        $this->excel->getActiveSheet()->mergeCells("H". $i .":H". $indice);

                        /* for($j = 1; $j <= $mes; $j++){
                            $this->excel->getActiveSheet()->mergeCells($columnas[$j-1].$i.":".$columnas[$j-1].$indice);
                        } */

                        $metat = $meta->tipo == 'principal' ? 'MP' : 'MC';
                        $tituloP = $meta->porcentajes == '1' ? 'Atendido':'Programado';
                        $tituloA = $meta->porcentajes == '1' ? 'Recibido':'Alcanzado';
                        $tabla = $meta->porcentajes == '1' ? 'meses_metas_complementarias_resueltos':'meses_metas_programadas';

                        $this->excel->getActiveSheet()->setCellValue("F".$i, $metat);
                        $this->excel->getActiveSheet()->setCellValue("G".$i, $meta->nombre);
                        $this->excel->getActiveSheet()->setCellValue("H".$i, $meta->umnom);
                        $this->excel->getActiveSheet()->setCellValue("I".$i, $tituloP);
                        $this->excel->getActiveSheet()->setCellValue("I".$indice, $tituloA);


                        // Obtener el avance del mes
                        $totalProgramado = 0;
                        $totalAlcanzados = 0;
                        for($j = 1; $j <= $mes; $j++){
                            $programado = $this->reportes->getAvanceMesProgramado($j, $meta->meta_id, $tabla);
                            $alcanzado = $this->seguimiento_model->getAvanceMesAlcanzado($j, $meta->meta_id);

                            $this->excel->getActiveSheet()->setCellValue($columnas[$j-1].$i, $programado?$programado->numero:'');
                            $this->excel->getActiveSheet()->setCellValue($columnas[$j-1].$indice, $alcanzado?$alcanzado->numero:'');

                            $totalProgramado += $programado?$programado->numero:0;
                            $totalAlcanzados += $alcanzado?$alcanzado->numero:0;
                        }
                        $this->excel->getActiveSheet()->setCellValue($ultimaLetra.$i, $totalProgramado);
                        $this->excel->getActiveSheet()->setCellValue($ultimaLetra.$indice, $totalAlcanzados);
                        $i++;
                    }
                }
            }
        }

        $archivo = "matriz_avance_".$mnombre.".xls";
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }
}
