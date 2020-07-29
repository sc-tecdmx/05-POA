<html>
<head>
    <title>Ficha POA</title>
</head>
<body>
<style>
    body {
        font-family: 'Helvetica';
        font-size: 12px !important;
    }

    table {
     border-collapse: separate;
     border-spacing:  -0.3px -0.3px;
   }

.identificacion-responsables {
     border-collapse: collapse;
                             }

.logo {
   border: 0px !important;
      }

td.claro-vertical{
   background-color: #e8e8e8;
   border-right: 1px solid black;
   border-left: 1px solid black;
   border-bottom: 1px solid black;
   border-spacing:  -0.3px -0.3px;
   font-weight: bolder;
   text-align: center;
}

td.claro-horizontal{
   background-color: #e8e8e8;
   border-bottom: 1px solid black;
   border-spacing:  -0.3px -0.3px;
   font-weight: bolder;
   text-align: center;
}


td.dato{
   border-right: 1px solid black;
   border-bottom: 1px solid black;
   border-spacing:  -0.3px -0.3px;
}

td.top
{
border-top: 1px solid black;
}

td.bottom
{
 border-bottom: 1px solid black;
}

td.left
{
border-left: 1px solid black;
}

td.right
{
border-right: 1px solid black;
}

td.texto{
  text-align: center;
}

th.titulo
{
   background-color: #8a8a8a;
   border-right: 1px solid black;
   border-left: 1px solid black;
   border-bottom: 1px solid black;
   border-top: 1px solid black;
   color: #ffffff;
   font-weight: bolder;
}

td.encabezado{
  font-weight: bolder;
  font-size: 15px !important;
}
td.subencabezado{
  font-weight: bolder;
  font-size: 12px !important;
}

</style>
<table class="logo" cellpadding="2" style="width: 100%;">
    <tr>
        <td rowspan="4" style="width: 18;"><img src="./img/logo_ficha.png" width="80" height="50" /></td>

    <tr>
        <td class="texto encabezado">PROGRAMA OPERATIVO ANUAL</td>
          </tr>
          <tr>
        <td class="texto subencabezado">FICHA DESCRIPTIVA DE PROYECTO</span></td>
    </tr>
      </tr>
</table>

<br>
<!--  tabla Identificación de Responsables -->
<table class="identificacion-responsables" style="width: 49%;">
    <thead>
    <tr>
          <th class="titulo" style="text-align: center;">Identificación de Responsables</th>
    </tr>
    </thead>
</table>
<table style="width: 100%">
  <tr>
        <td class="claro-vertical top" valign="middle" style="background-color: #e8e8e8; width: 25%;">Unidad Responsable:</td>
        <td class="dato top"><?php echo $detalles->nombre_urg; ?></td>
    </tr>
    <tr>
        <td class="claro-vertical" valign="middle">Responsable Operativo:</td>
        <td class="dato"><?php echo $detalles->nombre_ro; ?></td>
    </tr>
    <tr>
        <td class="claro-vertical"  valign="middle">Responsable de la ficha:</td>
        <td class="dato"><?php echo $detalles->responsable_ficha; ?></td>
    </tr>
</table>

<br>
  <!--  tabla Identificación Programática -->
<table  cellpadding="2" style="width:100%;">
    <tr>
        <td rowspan="2" class="claro-vertical top">Identificaci&oacute;n Program&aacute;tica</td>
        <td class="claro-horizontal top right">UR</td>
        <td class="claro-horizontal top right">RO</td>
        <td class="claro-horizontal top right">P</td>
        <td class="claro-horizontal top right">SP</td>
        <td class="claro-horizontal top right">PY</td>
    </tr>
    <tr>
        <td class="dato texto"><?php echo $identificacion_programatica->urnum; ?></td>
        <td class="dato texto"><?php echo $identificacion_programatica->ronum; ?></td>
        <td class="dato texto"><?php echo $identificacion_programatica->pgnum; ?></td>
        <td class="dato texto"><?php echo $identificacion_programatica->sbnum; ?></td>
        <td class="dato texto"><?php echo $identificacion_programatica->pynum; ?></td>
    </tr>
</table>

<br>
<!--  tabla Descripción de Claves-->
<table  style="width:100%;" >
  <thead>
  <tr>
        <td colspan="5" class="claro-vertical top">Descripci&oacute;n de claves</td>
    </tr>
  </thead>
    <tr>
        <td class="claro-horizontal left right">Programa</td>
        <td class="claro-horizontal right">Subprograma</td>
        <td class="claro-horizontal right">Proyecto</td>
        <td class="claro-horizontal right">TP</td>
        <td class="claro-horizontal right">Versi&oacute;n</td>
    </tr>
    <tr>
        <td class="dato texto left"><?php echo $detalles->numero_programa.'-'.$detalles->nombre_programa; ?></td>
        <td class="dato texto"> <?php echo $detalles->numero_subprograma.'-'.$detalles->nombre_subprograma; ?> </td>
        <td class="dato texto"> <?php echo $detalles->nombre; ?> </td>
        <td class="dato texto"><?php echo $detalles->tipo; ?></td>
        <td class="dato texto"> <?php echo $detalles->version; ?> </td>
    </tr>
</table>

<br>
<!--  tabla Objetivo de la Unidad Responsable-->
<table class="identificacion-responsables" style="width: 49%;">
    <thead>
    <tr>
          <th class="titulo" style="text-align: center;">Objetivo de la Unidad Responsable</th>
    </tr>
    </thead>
</table>
<table  style="width: 100%;">
    <tr>
        <td class="dato top  left"> <?php echo $detalles->objetivo; ?></td>
    </tr>
</table>

<!--  tabla Justificacion del Proyecto-->
<br>

<table class="identificacion-responsables" style="width: 49%;">
    <thead>
    <tr>
          <th class="titulo" style="text-align: center;">Justificación del Proyecto</th>
    </tr>
    </thead>
</table>
<table  style="width: 100%;">
    <tr>
        <td class="dato top  left"><?php echo $detalles->justificacion; ?></td>
    </tr>
</table>

<!--  tabla Descripción y Alcance del Proyecto-->
<br>
<table class="identificacion-responsables" style="width: 49%;">
    <thead>
    <tr>
          <th class="titulo" style="text-align: center;">Descripción y Alcance del Proyecto</th>
    </tr>
    </thead>
</table>
<table  style="width: 100%;">
    <tr>
      <td class="dato top  left"><?php echo $detalles->descripcion; ?></td>
    </tr>
</table>
<!--  tabla Cuantificación de Metas-->
<br>
<table class="identificacion-responsables" style="width: 49%;">
    <thead>
    <tr>
          <th class="titulo" style="text-align: center;">Cuantificación de Metas</th>
    </tr>
    </thead>
</table>
<table style="width: 100%;">
    <tr >
        <td colspan="8" class="claro-vertical top" >META PRINCIPAL</td>
    </tr>
    <tr>
        <td class="claro-vertical left" style="width: 40%;">Denominación de la Meta</td>
        <td class="claro-horizontal right" style="width: 10%;" >UM</td>
        <td class="claro-horizontal right" >ENE</td>
        <td class="claro-horizontal right" >FEB</td>
        <td class="claro-horizontal right" >MAR</td>
        <td class="claro-horizontal right" >ABR</td>
        <td class="claro-horizontal right" >MAY</td>
        <td class="claro-horizontal right" >JUN</td>
    </tr>
    <tr>
        <?php if($metap): ?>
        <td class="dato left" style="width: 40%;" rowspan="3"><?php echo $metap->mnombre; ?></td>
        <td class="dato texto" style="width: 10%;" rowspan="3"><?php echo $metap->unidad_medida; ?></td>
        <?php
        foreach ($mmetap as $idx => $array):
            if($array->mes_id <= 6): ?>
                <td class="dato texto"><?php echo $array->numero?></td>
            <?php
            endif;
        endforeach; else: ?>
        <td rowspan="4" class="dato left" style="width: 40%;" class="dato texto"></td>
        <td rowspan="4" class="dato left" style="width: 40%;" class="dato texto"></td>
        <td colspan="6" class="dato left" style="width: 40%;" class="dato texto">No hay datos</td>
        <?php
        endif;
        ?>
    </tr>
    <tr>
        <td class="claro-horizontal right left">JUL</td>
        <td class="claro-horizontal right">AGO</td>
        <td class="claro-horizontal right">SEP</td>
        <td class="claro-horizontal right">OCT</td>
        <td class="claro-horizontal right">NOV</td>
        <td class="claro-horizontal right">DIC</td>
    </tr>
    <tr >
        <?php
        if(isset($mmetap)){
        foreach ($mmetap as $idx => $array):
            if($array->mes_id > 6):?>
        <td class="dato texto"><?php echo $array->numero?></td>
        <?php
        endif;
        endforeach;
        } else { ?>
        <td colspan="6" class="dato left" style="width: 40%;" class="dato texto">No hay datos</td>
        <?php } ?>
    </tr>
</table>
<table class="identificacion-responsables" style="width: 22%;" align="right">
    <tr>
        <td class="claro-vertical" style="text-align: center;">TOTAL ANUAL</td>
        <td class="claro-vertical" style="text-align: center; width: 37%;">
            <?php
                if(isset($mmetap)){
                    $suma = 0;
                    foreach ($mmetap as $idx => $array):
                        $suma += $array->numero;
                    endforeach;
                    echo $suma;
                } else {
                    echo '';
                }
            ?>
        </td>
    </tr>
</table>
<!--  tabla METAS COMPLEMENTARIAS 1 -->
<?php if($metac) echo $metac; ?>
<!--  tabla INIDCADORES -->
<br>
<br>
<table >
    <tr>
        <td colspan="7" class="claro-vertical top">INDICADORES</td>
    </tr>
    <tr>
        <td class="claro-vertical">Nombre del Indicador</td>
        <td class="claro-vertical">Definici&oacute;n del Indicador</td>
        <td class="claro-vertical">Unidad de medida</td>
        <td class="claro-vertical">M&eacute;todo de c&aacute;lculo</td>
        <td class="claro-vertical">Dimensi&oacute;n a medir</td>
        <td class="claro-vertical">Frecuencia de medici&oacute;n</td>
        <td class="claro-vertical">Meta del Indicador</td>
    </tr>
    <?php if($indicadores) echo $indicadores; ?>
</table>


<br>
<!--  tabla Contenido y Temporalidad del Proyecto-->
<table class="identificacion-responsables" style="width: 49%;">
    <thead>
    <tr>
            <th class="titulo" style="text-align: center;">Contenido y Temporalidad del Proyecto</th>
    </tr>
    </thead>
</table>
<table style="width: 100%;">
    <tr >
        <td colspan="2" class="claro-vertical top" style="text-align: left;">Acciones Sustantivas del Proyecto</td>
    </tr>
    <?php if($sustantivas) echo $sustantivas; ?>
</table>

<br>
<!--  tabla Periodo de Ejecución del Proyecto-->
<table  cellpadding="2" style="width:100%;">
    <tr>
        <td rowspan="4" class="claro-vertical top">Periodo de Ejecución del Proyecto</td>
        <td class="claro-horizontal top right">ENE</td>
        <td class="claro-horizontal top right">FEB</td>
        <td class="claro-horizontal top right">MAR</td>
        <td class="claro-horizontal top right">ABR</td>
        <td class="claro-horizontal top right">MAY</td>
        <td class="claro-horizontal top right">JUN</td>
    </tr>
    <?php echo $primeros ?>
    <tr>
        <td class="claro-horizontal right ">JUL</td>
        <td class="claro-horizontal right">AGO</td>
        <td class="claro-horizontal right">SEP</td>
        <td class="claro-horizontal right">OCT</td>
        <td class="claro-horizontal right">NOV</td>
        <td class="claro-horizontal right">DIC</td>
    </tr>
    <?php echo $segundos; ?>
</tr>
</table>



<br>
<!--  tabla FECHA DE ELABORACIÓN DE LA FICHA-->
<table   style="width:100%;">
    <tr>
        <td class="claro-vertical top"  style="width:48%;" >FECHA DE ELABORACIÓN DE LA FICHA:</td>
        <td class="claro-horizontal top right"><?php echo $detalles->fecha; ?></td>
  </tr>
</table>


<br>
<!--  tabla elaboracion-->
<table style="width:100%;" cellpadding="2" align="center">
    <tr>
        <td class="texto top left "><br /><br /><br /><br /><br /><br /><?php echo $detalles->nombre_responsable_operativo; ?><br /><?php echo $detalles->cargo_responsable_operativo; ?></td>
        <td class="texto top left right"><br /><br /><br /><br /><br /><br /><br /><?php echo $detalles->nombre_titular; ?></td>
    </tr>
    <tr>
        <td class="texto bottom left "><?php echo $leyenda_nombre_cargo_firma_ro; ?></td>
        <td class="texto bottom left right">Nombre y Firma del Titular de la Unidad Responsable</td>
    </tr>
</table>
</body>
</html>
