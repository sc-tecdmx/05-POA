<?php
error_reporting(E_ALL);
date_default_timezone_set('Mexico/General');

/** PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'PHPExcel/Classes/PHPExcel/Style/Border.php';
require_once 'PHPExcel/Classes/PHPExcel/Style/Color.php';

function utf8_encode_all($dat)
{
    if (is_string($dat))
        return utf8_encode($dat);
    if (!is_array($dat))
        return $dat;
    $ret = array();
    foreach ($dat as $i => $d)
        $ret[$i] = utf8_encode_all($d);
    return $ret;
}

function utf8_decode_all($dat)
{
    if (is_string($dat))
        return utf8_decode($dat);
    if (!is_array($dat))
        return $dat;
    $ret = array();
    foreach ($dat as $i => $d)
        $ret[$i] = utf8_decode_all($d);
    return $ret;
}

// Funcion para eliminar archivos y directorios no vacios
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file)
            if ($file != "." && $file != "..")
                rrmdir("$dir/$file");
        rmdir($dir);
    } else if (file_exists($dir))
        unlink($dir);
}

// Funcion para copiar archivos y directorios no vacios
function rcopy($src, $dst)
{
    if (file_exists($dst))
        rrmdir($dst);
    if (is_dir($src)) {
        mkdir($dst);
        $files = scandir($src);
        foreach ($files as $file)
            if ($file != "." && $file != "..")
                rcopy("$src/$file", "$dst/$file");
    } else if (file_exists($src))
        copy($src, $dst);
}

function odbc_mssql_num_rows($dbh)
{
    $res = odbc_exec($dbh, 'SELECT @@ROWCOUNT AS cnt');

    if (@odbc_fetch_into($res, $row)) {
        $count = trim($row[0]);
    } else {
        $count = 0;
    }

    odbc_free_result($res);
    return $count;
}

function obtenerNumeroMes($nombre_mes)
{
    $mes = "";
    switch (strtolower($nombre_mes)) {
        case "enero":
            $mes = "01";
            break;
        case "febrero":
            $mes = "02";
            break;
        case "marzo":
            $mes = "03";
            break;
        case "abril":
            $mes = "04";
            break;
        case "mayo":
            $mes = "05";
            break;
        case "junio":
            $mes = "06";
            break;
        case "julio":
            $mes = "07";
            break;
        case "agosto":
            $mes = "08";
            break;
        case "septiembre":
            $mes = "09";
            break;
        case "octubre":
            $mes = "10";
            break;
        case "noviembre":
            $mes = "11";
            break;
        case "diciembre":
            $mes = "12";
            break;
        default:
            break;
    }
    return $mes;
}

function obtenerNombreMes($numero_mes)
{
    $mes = "";
    switch ($numero_mes) {
        case "01":
            $mes = "enero";
            break;
        case "02":
            $mes = "febrero";
            break;
        case "03":
            $mes = "marzo";
            break;
        case "04":
            $mes = "abril";
            break;
        case "05":
            $mes = "mayo";
            break;
        case "06":
            $mes = "junio";
            break;
        case "07":
            $mes = "julio";
            break;
        case "08":
            $mes = "agosto";
            break;
        case "09":
            $mes = "septiembre";
            break;
        case "10":
            $mes = "octubre";
            break;
        case "11":
            $mes = "noviembre";
            break;
        case "12":
            $mes = "diciembre";
            break;
        default:
            break;
    }
    return $mes;
}

function obtenerQuincena($numero_mes, $comienzo)
{
    $adicional = 1;
    if ($comienzo == 16)
        $adicional = 2;

    return (($numero_mes - 1) * 2) + $adicional;
}

function numeroDecimal($numero)
{
    $resultado = strpos($numero, '.');

    if ($resultado) {
        return number_format($numero, 2);
    } else {
        return $numero;
    }
}

function ultimoDiaMes($mes, $anio)
{
    return strftime("%d", mktime(0, 0, 0, $mes + 1, 0, $anio));
}

function contiene_elemento($array, $elemento)
{
    foreach ($array as $e) {
        if ($elemento == $e)
            return true;
    }
    return false;
}

function usuarios_activos()
{
    //permitimos el uso de la variable portadora del numero ip en nuestra funcion
    global $REMOTE_ADDR;

    //asignamos un nombre memotecnico a la variable
    $ip = $REMOTE_ADDR;
    //definimos el momento actual
    $ahora = time();

    //conectamos a la base de datos
    //Usad vuestros propios parametros!!
    $conn = mysql_connect($host, $user, $password);
    mysql_select_db($db, $conn);

    //actualizamos la tabla
    //borrando los registros de las ip inactivas (24 minutos)
    $limite = $ahora - 24 * 60;
    $ssql = "delete from control_ip where fecha < " . $limite;
    mysql_query($ssql);

    //miramos si el ip del visitante existe en nuestra tabla
    $ssql = "select ip, fecha from control_ip where ip = '$ip'";
    $result = mysql_query($ssql);

    //si existe actualizamos el campo fecha
    if (mysql_num_rows($result) != 0)
        $ssql = "update control_ip set fecha = " . $ahora . " where ip = '$ip'";
    //si no existe insertamos el registro correspondiente a la nueva sesion
    else
        $ssql = "insert into control_ip (ip, fecha) values ('$ip', $ahora)";

    //ejecutamos la sentencia sql
    mysql_query($ssql);

    //calculamos el numero de sesiones
    $ssql = "select ip from control_ip";
    $result = mysql_query($ssql);
    $usuarios = mysql_num_rows($result);

    //liberamos memoria
    mysql_free_result($result);

    //devolvemos el resultado
    return $usuarios;
}

function convert_raw_utf8_smart_quotes($string)
{
    $search = array(chr(0xe2) . chr(0x80) . chr(0x98),
        chr(0xe2) . chr(0x80) . chr(0x99),
        chr(0xe2) . chr(0x80) . chr(0x9c),
        chr(0xe2) . chr(0x80) . chr(0x9d),
        chr(0xe2) . chr(0x80) . chr(0x93),
        chr(0xe2) . chr(0x80) . chr(0x94));

    $replace = array("'",
        "'",
        '"',
        '"',
        '-',
        '-');

    return str_replace($search, $replace, $string);
}

function xcopy($source, $dest, $permissions = 0755)
{
    // comprueba los enlaces del origen y destino
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }

    // copia archivos
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // crea el directorio en caso de no existir
    if (!is_dir($dest)) {
        mkdir($dest, $permissions);
        echo 'no existe' . "\n";
    } else {
        echo 'ya existe' . "\n";
    }

    // recorre la carpeta
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {

        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // copia los directorios profundamente
        xcopy("$source/$entry", "$dest/$entry", $permissions);
    }
    // Clean up
    $dir->close();
    return true;
}

$connection = mysqli_connect('localhost', 'root', '', 'cpoa');

$query = "SELECT e.ejercicio, oe.habilitado FROM operaciones_ejercicios oe, ejercicios e
    WHERE e.ejercicio_id = oe.ejercicio_id
    AND oe.tipo = 'seguimiento_proyectos'";
$result = mysqli_query($connection, $query);

$ejercicio_seguimiento = "";
$ejercicio_seguimiento_habilitado = "no";
while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
    $ejercicio_seguimiento = $row['ejercicio'];
    $ejercicio_seguimiento_habilitado = $row['habilitado'];
}

$ejercicio = $ejercicio_seguimiento;

/* $proyecto_id = trim(utf8_decode($_GET['proyecto_id']));
$trimestre = trim($_GET['trimestre']); */
$proyecto_id = '559';
$trimestre = 1;

$trimestre_acumulada = "";
$titulo_trimestre = "";
if ($trimestre == 1) {
    $trimestre = "'enero', 'febrero', 'marzo'";
    $trimestre_acumulada = "'enero', 'febrero', 'marzo'";
    $titulo_trimestre = "Enero-Marzo";
} else if ($trimestre == 2) {
    $trimestre = "'abril', 'mayo', 'junio'";
    $trimestre_acumulada = "'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio'";
    $titulo_trimestre = "Abril-Junio";
} else if ($trimestre == 3) {
    $trimestre = "'julio', 'agosto', 'septiembre'";
    $trimestre_acumulada = "'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre'";
    $titulo_trimestre = "Julio-Septiembre";
} else if ($trimestre == 4) {
    $trimestre = "'octubre', 'noviembre', 'diciembre'";
    $titulo_trimestre = "Octubre-Diciembre";
    $trimestre_acumulada = "'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'";
}

// Obtenemos los datos de la URG y RO del proyecto
$query = "SELECT urg.unidad_responsable_gasto_id, urg.numero as 'numero_urg', urg.nombre as 'nombre_urg',
    ro.responsable_operativo_id, ro.numero as 'numero_ro', ro.nombre as 'nombre_ro'
    FROM unidades_responsables_gastos urg, responsables_operativos ro, proyectos p
    WHERE p.responsable_operativo_id = ro.responsable_operativo_id
    AND urg.unidad_responsable_gasto_id = ro.unidad_responsable_gasto_id
    AND p.proyecto_id = $proyecto_id";
$result = mysqli_query($connection, $query);

$unidad_responsable_gasto_id = "";
$numero_urg = "";
$nombre_urg = "";
$responsable_operativo_id = "";
$numero_ro = "";
$nombre_ro = "";
while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
    $numero_urg = $row['numero_urg'];
    $nombre_urg = $row['nombre_urg'];
    $numero_ro = $row['numero_ro'];
    $nombre_ro = $row['nombre_ro'];
    if ($numero_urg == '01' && $ejercicio_seguimiento == 2014 && $trimestre >= 4) {
        if ($numero_ro == '01') {
            $nombre_ro = "Ponencia del Magistrado Armando Hernández Cruz";
        }
        if ($numero_ro == '02') {
            $nombre_ro = "Ponencia del Magistrado Eduardo Arana Miraval";
        }
        if ($numero_ro == '03') {
            $nombre_ro = "Ponencia de la Magistrada María del Carmen Carreón Castro";
        }
        if ($numero_ro == '04') {
            $nombre_ro = "Ponencia del Magistrado Gustavo Anzaldo Hernández";
        }
        if ($numero_ro == '05') {
            $nombre_ro = "Ponencia de la Magistrada Gabriela Eugenia del Valle Pérez";
        }
    }
    $unidad_responsable_gasto_id = $row['unidad_responsable_gasto_id'];
    $responsable_operativo_id = $row['responsable_operativo_id'];
}

// Obtenemos los datos del Programa y Subprograma del proyecto
$query = "SELECT pg.programa_id, pg.numero as 'numero_programa', pg.nombre as 'nombre_programa',
    sp.subprograma_id, sp.numero as 'numero_subprograma', sp.nombre as 'nombre_subprograma'
    FROM programas pg, subprogramas sp, proyectos p
    WHERE p.subprograma_id = sp.subprograma_id
    AND pg.programa_id = sp.programa_id
    AND p.proyecto_id = $proyecto_id";
$result = mysqli_query($connection, $query);

$programa_id = "";
$numero_programa = "";
$nombre_programa = "";
$subprograma_id = "";
$numero_subprograma = "";
$nombre_subprograma = "";
while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
    $numero_programa = $row['numero_programa'];
    $nombre_programa = $row['nombre_programa'];
    $numero_subprograma = $row['numero_subprograma'];
    $nombre_subprograma = $row['nombre_subprograma'];
    $programa_id = $row['programa_id'];
    $subprograma_id = $row['subprograma_id'];
}

// Obtenemos los datos del proyecto
$query = "SELECT * FROM proyectos WHERE proyecto_id = $proyecto_id";
$result = mysqli_query($connection, $query);

$numero_proyecto = "";
$nombre_proyecto = "";
$tipo_proyecto = "";
$version_proyecto = "";
$justificacion_proyecto = "";
$descripcion_proyecto = "";
$responsable_ficha = "";
$fecha_elaboracion = "";
$autorizado_por = "";
$nombre_responsable_operativo = "";
$nombre_titular = "";
while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
    $numero_proyecto = $row['numero'];
    $nombre_proyecto = $row['nombre'];
    $tipo_proyecto = ucwords($row['tipo']);
    $version_proyecto = $row['version'];
    $responsable_ficha = $row['responsable_ficha'];
    $justificacion_proyecto = $row['justificacion'];
    $descripcion_proyecto = $row['descripcion'];
    $fecha_elaboracion = $row['fecha'];
    $autorizado_por = $row['autorizado_por'];
    $nombre_responsable_operativo = $row['nombre_responsable_operativo'];
    $nombre_titular = $row['nombre_titular'];
}

// Obtenemos meses habilitados para el control del seguimientoModel POA
/* $query = "SELECT MAX(mcm.mes_id) as 'numero_mes' FROM meses_controles_metas mcm, ejercicios e, meses m
  WHERE mcm.ejercicio_id = e.ejercicio_id
  AND mcm.mes_id = m.mes_id
  AND mcm.habilitado = 'si'
  AND e.ejercicio = '$ejercicio'";
  $result = mysqli_query($connection, $query);

  while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
  $my_numero_mes = $row['numero_mes'];
  }

  if ($my_numero_mes == 0) {
  $my_numero_mes = "12"; // Si ningun mes esta habilitado, mostrar todos los meses
  } */

$sql = "SELECT proyecto_id, numero, nombre FROM proyectos";
$result = mysqli_query($connection, $sql);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("TEDF")
    ->setLastModifiedBy("TEDF")
    ->setTitle("Office 2007 XLSX Reporte")
    ->setSubject("Office 2007 XLSX Reporte")
    ->setDescription("Reporte en Excel")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Documento de salida");

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('images/logo11-TEDF.png');
$objDrawing->setHeight(25);
$objDrawing->setOffsetX(25);
$objDrawing->setOffsetY(7);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Proteccion del documento en Excel
/*$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);

$objPHPExcel->getSecurity()->setLockWindows(true);
$objPHPExcel->getSecurity()->setLockStructure(true);
$objPHPExcel->getSecurity()->setWorkbookPassword("PHPExcel");

$objPHPExcel->getActiveSheet()->getProtection()->setPassword('PHPExcel');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);*/

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);

$styleArray = array(
    'font' => array(
        'type' => 'Arial',
        'bold' => true,
        'size' => 12
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    /* 'borders' => array(
      'top' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      ), */
    /* 'bottom' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('argb' => '7cc75459'),
      ), */
    // ),
    /* 'fill' => array(
      'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
      'rotation' => 90,
      'startcolor' => array(
      'argb' => 'e1e6e900',
      ),
      'endcolor' => array(
      'argb' => 'FFFFFFFF',
      ),
      ), */
    /* 'borders' => array(
      'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THICK,
      'color' => array('argb' => 'FFFF0000'),
      ),
      ), */
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

//$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
// Encabezado de la hoja
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'PROGRAMA OPERATIVO ANUAL ' . $ejercicio)
    ->setCellValue('A2', 'AVANCE DE PROYECTOS')
    ->setCellValue('A3', 'UNIDAD RESPONSABLE:')
    ->setCellValue('A4', 'RESPONSABLE OPERATIVO:')
    ->setCellValue('A5', 'CLAVE DEL PROYECTO:')
    ->setCellValue('A6', 'DENOMINACIÓN DEL PROYECTO:')
    ->setCellValue('A7', 'NOMBRE DE LA META PRINCIPAL:');

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B3', $numero_urg . " " . $nombre_urg)
    ->setCellValue('B4', $numero_ro . " " . $nombre_ro)
    ->setCellValue('B5', $numero_urg . "-" . $numero_ro . "-" . $numero_programa . "-" . $numero_subprograma . "-" . $numero_proyecto)
    ->setCellValue('B6', $nombre_proyecto);

$i = 9;

$objPHPExcel->getActiveSheet()
    ->setCellValue('A' . $i, "AVANCE MENSUAL Y ACUMULADO");
$objPHPExcel->getActiveSheet()
    ->mergeCells('A' . $i . ':R' . $i);
$objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)->applyFromArray($styleArray9);

$i++;
// Meta Principal
$query = "SELECT m.* FROM proyectos p, metas m 
    WHERE p.proyecto_id = m.proyecto_id 
    AND m.tipo = 'principal'
    AND p.proyecto_id = $proyecto_id";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    $objPHPExcel->getActiveSheet()
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

    $objPHPExcel->getActiveSheet()
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

    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':C' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $i . ':F' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $i . ':L' . $i)->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('G' . ($i + 1) . ':H' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('I' . ($i + 1) . ':J' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('K' . ($i + 1) . ':L' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('M' . ($i + 1) . ':N' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('O' . ($i + 1) . ':P' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('Q' . ($i + 1) . ':R' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $i . ':R' . $i)->applyFromArray($styleArray4);

    //echo "<table class='resultado-metas'>";
    //echo "<thead>";
    //echo "<tr>";
    //echo "<th class='seis' rowspan='2'>Denominaci&oacute;n de la meta</th>";
    //echo "<th class='siete' rowspan='2'>Unidad de medida</th>";
    //echo "<th class='ocho' colspan='3'>$titulo_mes</th>";
    //echo "<th class='nueve' colspan='3'>Acumulada $titulo_acumulada</th>";
    //echo "</tr>";
    //echo "<tr>";
    //echo "<th class='dato-trimestre diez'>Programada<br />(1)</th>";
    //echo "<th class='dato-trimestre diez'>Alcanzada<br />(2)</th>";
    //echo "<th class='dato-trimestre diez'>Avance %<br />(2)(1)</th>";
    //echo "<th class='dato-trimestre diez'>Programada<br />(3)</th>";
    //echo "<th class='dato-trimestre diez'>Alcanzada<br />(4)</th>";
    //echo "<th class='dato-trimestre diez'>Avance %<br />(4)(3)</th>";
    //echo "</tr>";
    //echo "</thead>";
    //echo "<tbody>";

    $i = $i + 3;
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

        //echo "<tr>";
        //echo "<td class='denominacion-meta'>" . $nombre_meta . "</td>";
        //echo "<td>" . $nombre_unidad_medida . "</td>";

        $objPHPExcel->getActiveSheet()
            ->setCellValue('B7', $nombre_meta);

        $objPHPExcel->getActiveSheet()
            ->setCellValue('A' . $i, $nombre_meta)
            ->setCellValue('D' . $i, $nombre_unidad_medida);
        $objPHPExcel->getActiveSheet()
            ->mergeCells('A' . $i . ':C' . $i)
            ->mergeCells('D' . $i . ':F' . $i);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':C' . $i)->applyFromArray($styleArray8);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i . ':F' . $i)->applyFromArray($styleArray5);

        $caracteres_nombre_meta = strlen($nombre_meta);
        if ($caracteres_nombre_meta > 74) {
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_meta / 74) * 13 + 13);
        }

        // Mejorar formato de celdas (denominacion de meta y unidad de medida)
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setWrapText(true);

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

            $objPHPExcel->getActiveSheet()
                ->setCellValue('G' . $i, $trimestre_programada)
                ->setCellValue('I' . $i, $trimestre_alcanzada)
                ->setCellValue('K' . $i, $avance);

            $objPHPExcel->getActiveSheet()
                ->mergeCells('G' . $i . ':H' . $i)
                ->mergeCells('I' . $i . ':J' . $i)
                ->mergeCells('K' . $i . ':L' . $i);

            $objPHPExcel->getActiveSheet()->getStyle('G' . $i . ':H' . $i)->applyFromArray($styleArray5);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $i . ':J' . $i)->applyFromArray($styleArray5);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $i . ':L' . $i)->applyFromArray($styleArray5);

            //echo "<td>$trimestre_programada</td>";
            //echo "<td>$trimestre_alcanzada</td>";
            //echo "<td>$avance</td>";
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

            $objPHPExcel->getActiveSheet()
                ->setCellValue('M' . $i, $acumulada_programada)
                ->setCellValue('O' . $i, $acumulada_alcanzada)
                ->setCellValue('Q' . $i, $avance);

            $objPHPExcel->getActiveSheet()
                ->mergeCells('M' . $i . ':N' . $i)
                ->mergeCells('O' . $i . ':P' . $i)
                ->mergeCells('Q' . $i . ':R' . $i);

            $objPHPExcel->getActiveSheet()->getStyle('M' . $i . ':N' . $i)->applyFromArray($styleArray5);
            $objPHPExcel->getActiveSheet()->getStyle('O' . $i . ':P' . $i)->applyFromArray($styleArray5);
            $objPHPExcel->getActiveSheet()->getStyle('Q' . $i . ':R' . $i)->applyFromArray($styleArray5);

            //echo "<td>$acumulada_programada</td>";
            //echo "<td>$acumulada_alcanzada</td>";
            //echo "<td>$avance</td>";
        }
        //echo "</tr>";
        $i++;
    }
    //echo "</tbody>";
    //echo "</table>";
}

$objPHPExcel->getActiveSheet()
    ->setCellValue('A' . $i, "EXPLICACIÓN DEL AVANCE FÍSICO");
$objPHPExcel->getActiveSheet()
    ->mergeCells('A' . $i . ':R' . $i);
$objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
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

                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A' . $i, $explicacion_global);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()
                    ->mergeCells('A' . $i . ':R' . $i);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
                    ->applyFromArray($styleArray7);

                $caracteres_explicacion = strlen($explicacion_global);
                if ($caracteres_explicacion > 227) {
                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(intval($caracteres_explicacion / 227) * 13 + 18);
                } else {
                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(18);
                }
                $i++;
            }
        }
    }
    /*$objPHPExcel->getActiveSheet()
            ->setCellValue('A' . $i, $explicacion_global);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);*/
}

if (!$entra_ciclo) {
    $objPHPExcel->getActiveSheet()
        ->mergeCells('A' . $i . ':R' . $i);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
        ->applyFromArray($styleArray7);
    $i++;
}
/*$objPHPExcel->getActiveSheet()
        ->mergeCells('A' . $i . ':R' . $i);
$objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
        ->applyFromArray($styleArray7);
$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(130);*/

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

    $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $i, "METAS COMPLEMENTARIAS")
        ->setCellValue('A' . ($i + 1), "AVANCE MENSUAL Y ACUMULADO");
    $objPHPExcel->getActiveSheet()
        ->mergeCells('A' . $i . ':R' . $i)
        ->mergeCells('A' . ($i + 1) . ':R' . ($i + 1));
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)->applyFromArray($styleArray10);
    $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1) . ':R' . ($i + 1))->applyFromArray($styleArray9);

    $i += 2;

    $objPHPExcel->getActiveSheet()
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

    $objPHPExcel->getActiveSheet()
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

    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':C' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $i . ':F' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $i . ':L' . $i)->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('G' . ($i + 1) . ':H' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('I' . ($i + 1) . ':J' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('K' . ($i + 1) . ':L' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('M' . ($i + 1) . ':N' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('O' . ($i + 1) . ':P' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('Q' . ($i + 1) . ':R' . ($i + 2))->applyFromArray($styleArray4);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $i . ':R' . $i)->applyFromArray($styleArray4);

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

        //echo "<tr>";
        //echo "<td class='denominacion-meta'><sup class='bold'>$j</sup> " . $nombre_meta . "</td>";
        //echo "<td>" . $nombre_unidad_medida . "</td>";

        $objRichText = new PHPExcel_RichText();
        $objRichText->createText($nombre_meta);

        $objCubed = $objRichText->createTextRun($j);
        $objCubed->getFont()->setSuperScript(true);

        $objPHPExcel->getActiveSheet()->getCell('A' . $i)->setValue($objRichText);

        $objPHPExcel->getActiveSheet()
            //->setCellValue('A' . $i, "($j) " . $nombre_meta)
            ->setCellValue('D' . $i, $nombre_unidad_medida);
        $objPHPExcel->getActiveSheet()
            ->mergeCells('A' . $i . ':C' . $i)
            ->mergeCells('D' . $i . ':F' . $i);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':C' . $i)->applyFromArray($styleArray8);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i . ':F' . $i)->applyFromArray($styleArray5);

        $caracteres_nombre_meta = strlen($nombre_meta);
        if ($caracteres_nombre_meta > 74) {
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(intval($caracteres_nombre_meta / 74) * 13 + 18);
        } else {
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(18);
        }

        // Mejorar formato de celdas (denominacion de meta y unidad de medida)
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setWrapText(true);

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

            $objPHPExcel->getActiveSheet()
                ->setCellValue('G' . $i, $trimestre_programada)
                ->setCellValue('I' . $i, $trimestre_alcanzada)
                ->setCellValue('K' . $i, $avance);

            $objPHPExcel->getActiveSheet()
                ->mergeCells('G' . $i . ':H' . $i)
                ->mergeCells('I' . $i . ':J' . $i)
                ->mergeCells('K' . $i . ':L' . $i);

            $objPHPExcel->getActiveSheet()->getStyle('G' . $i . ':H' . $i)->applyFromArray($styleArray5);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $i . ':J' . $i)->applyFromArray($styleArray5);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $i . ':L' . $i)->applyFromArray($styleArray5);

            //echo "<td>$trimestre_programada</td>";
            //echo "<td>$trimestre_alcanzada</td>";
            //echo "<td>$avance</td>";
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

            $objPHPExcel->getActiveSheet()
                ->setCellValue('M' . $i, $acumulada_programada)
                ->setCellValue('O' . $i, $acumulada_alcanzada)
                ->setCellValue('Q' . $i, $avance);

            $objPHPExcel->getActiveSheet()
                ->mergeCells('M' . $i . ':N' . $i)
                ->mergeCells('O' . $i . ':P' . $i)
                ->mergeCells('Q' . $i . ':R' . $i);

            $objPHPExcel->getActiveSheet()->getStyle('M' . $i . ':N' . $i)->applyFromArray($styleArray5);
            $objPHPExcel->getActiveSheet()->getStyle('O' . $i . ':P' . $i)->applyFromArray($styleArray5);
            $objPHPExcel->getActiveSheet()->getStyle('Q' . $i . ':R' . $i)->applyFromArray($styleArray5);

            //echo "<td>$acumulada_programada</td>";
            //echo "<td>$acumulada_alcanzada</td>";
            //echo "<td>$avance</td>";
        }

        //echo "</tr>";
        $i++;
        $j++;
    }
    //echo "</tbody>";
    //echo "</table>";
}

// AGREGADO 29/FEBRERO/2012 -> El nombre de la meta no debe estar vacío (Correccion de inconsistencia de version anterior)
$query_3 = "SELECT m.* FROM proyectos p, metas m 
                    WHERE p.proyecto_id = m.proyecto_id 
                    AND m.tipo = 'complementaria'
                    AND m.nombre != ''
                    AND m.nombre != 'No aplica'
                    AND p.proyecto_id = $proyecto_id ORDER BY m.orden";
$result_3 = mysqli_query($connection, $query_3);

$entra_ciclo = false;
if (mysqli_num_rows($result_3) > 0) {
    $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $i, "EXPLICACIÓN DEL AVANCE FÍSICO");
    $objPHPExcel->getActiveSheet()
        ->mergeCells('A' . $i . ':R' . $i);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
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

                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A' . $i, $explicacion_global);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()
                    ->mergeCells('A' . $i . ':R' . $i);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
                    ->applyFromArray($styleArray7);

                $caracteres_explicacion = strlen($explicacion_global);
                if ($caracteres_explicacion > 227) {
                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(intval($caracteres_explicacion / 227) * 13 + 18);
                } else {
                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(18);
                }
                $i++;
            }
        }
        $j++;
    }
    /*$objPHPExcel->getActiveSheet()
            ->setCellValue('A' . $i, $explicacion_global);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setWrapText(true);*/
}

if (!$entra_ciclo) {
    $objPHPExcel->getActiveSheet()
        ->mergeCells('A' . $i . ':R' . $i);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
        ->applyFromArray($styleArray7);
    $i++;
}
/*$objPHPExcel->getActiveSheet()
        ->mergeCells('A' . $i . ':R' . $i);
$objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':R' . $i)
        ->applyFromArray($styleArray7);
$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(130);*/

//$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(35);

$objPHPExcel->getActiveSheet()
    ->mergeCells('A1:R1')
    ->mergeCells('A2:R2')
    ->mergeCells('B3:R3')
    ->mergeCells('B4:R4')
    ->mergeCells('B5:R5')
    ->mergeCells('B6:R6')
    ->mergeCells('B7:R7');

$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A3:A7')->applyFromArray($styleArray2);
$objPHPExcel->getActiveSheet()->getStyle('B3:R7')->applyFromArray($styleArray3);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);

$i = 10;
while ($row = utf8_encode_all(mysqli_fetch_array($result))) {
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B' . $i, "");
    $objPHPExcel->getActiveSheet()->getCell('A' . $i)->setValueExplicit("", PHPExcel_Cell_DataType::TYPE_STRING);
    $i++;
    //$row["clave_primera_id"], $row["numero"], $row["nombre"]);
}
$i--;
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 2);

$styleArray = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => '00000000'),
        ),
    ),
);

//$objPHPExcel->getActiveSheet()->getStyle('A2:A' . $i)->applyFromArray($styleArray);
//$objPHPExcel->getActiveSheet()->getStyle('B2:B' . $i)->applyFromArray($styleArray);
// Autodimensionar las columnas
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

mysqli_free_result($result);
mysqli_close($connection);  //Cierre de la Conexión
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Avance trimestral y acumulado');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
/* header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="avance_trimestral_y_acumulado.xlsx"');
header('Cache-Control: max-age=0'); */
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="avance_trimestral_y_acumulado.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

memory_get_peak_usage(true) / 1024 / 1024;
exit;
