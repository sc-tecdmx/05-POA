<?php
require_once ('./pdf/1/dompdf_config.inc.php');
# Instanciamos un objeto de la clase DOMPDF.
$mipdf = new DOMPDF();
# Definimos el tamaño y orientación del papel que queremos.

# O por defecto cogerá el que está en el fichero de configuración.
$mipdf ->set_paper("A4", "portrait");

# Cargamos el contenido HTML.
$mipdf ->load_html($reporte);

$mipdf ->render();

$mipdf->set_base_path(base_url("vendor/bootstrap/css/bootstrap.min.css"));
$mipdf->set_base_path(base_url("/css/bootstrap.css"));
$mipdf->set_base_path(base_url("vendor/datatables/dataTables.bootstrap4.css"));
$mipdf->set_base_path(base_url("css/sb-admin.css"));
$mipdf->stream("hello.pdf");
//echo $mipdf->output();


;
# Enviamos el fichero PDF al navegador.
//$mipdf ->stream($archivo.'.pdf',array('Attachment'=>1, 'compress'=>1));

?>
