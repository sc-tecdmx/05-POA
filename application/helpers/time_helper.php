<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('obtenTextoMes')){
	function obtenTextoMes($mes)
	{
		switch($mes){
			case "01": return "Enero";
			break;
			case "02": return "Febrero";
			break;
			case "03": return "Marzo";
			break;
			case "04": return "Abril";
			break;
			case "05": return "Mayo";
			break;
			case "06": return "Junio";
			break;
			case "07": return "Julio";
			break;
			case "08": return "Agosto";
			break;
			case "09": return "Septiembre";
			break;
			case "10": return "Octubre";
			break;
			case "11": return "Noviembre";
			break;
			case "12": return "Diciembre";
			break;
			default: return "undefined";
			break;
		}
	}
}
if ( ! function_exists('obtenTextoDia')){
	function obtenTextoDia($mes)
	{
		switch($mes){
			case "1": return "Lunes";
			break;
			case "2": return "Martes";
			break;
			case "3": return "Miercolés";
			break;
			case "4": return "Jueves";
			break;
			case "5": return "Viernes";
			break;
			case "6": return "Sábado";
			break;
			case "7": return "Domingo";
			
			default: return "undefined";
			break;
		}
	}
}
if ( ! function_exists('acomodaFechaPeriodo')){
	function acomodaFechaPeriodo($timestamp)
	{
			if($timestamp){
				$fecha=explode("-",$timestamp);
				$mes=obtenTextoMes($fecha[1]);
				return $mes." ".$fecha[0];
			}
			return false;
	}

}
if ( ! function_exists('acomodaFecha')){
	function acomodaFecha($time)
	{
			if($time){
				$fecha=explode("-",$time);
				$mes=obtenTextoMes($fecha[1]);
				$salida=$fecha[2]." de ".$mes." ".$fecha[0];
				if($time==date('Y-m-d')){
					return "hoy";
				}
				else return $salida; 
			}
			return false;
	}

}
if ( ! function_exists('acomodaFecha3')){
	function acomodaFecha3($time)
	{
			if($time){
				$fecha=explode("-",$time);
				$mes=obtenTextoMes($fecha[1]);
				$salida=$fecha[2]." de ".$mes." ".$fecha[0];
				
				 return $salida; 
			}
			return false;
	}

}
if ( ! function_exists('acomodaFechaHora')){
	function acomodaFechaHora($time)
	{
			if($time){
				list($fecha_org,$hora)=explode(' ', $time);
				$fecha=explode("-",$fecha_org);
				$mes=obtenTextoMes($fecha[1]);
				$salida=$fecha[2]." de ".$mes." ".$fecha[0];
				return $salida." a las ".$hora; 
			}
			return false;
	}

}
if ( ! function_exists('acomodaFecha2')){
	function acomodaFecha2($time)
	{
			if($time){
				$fecha=explode("-",$time);
				$mes=obtenTextoMes($fecha[1]);
				$salida=$mes." ".$fecha[0];
				return $salida; 
			}
			return false;
	}

}
if ( ! function_exists('dameDia')){
	function dameDia($time)
	{
			if($time){
				$fecha=explode("-",$time);
				return $fecha[2];
			}
			return false;
	}

}
if ( ! function_exists('acomodaTimestamp')){
	function acomodaTimestamp($timestamp)
	{
		if($timestamp){
			$fechaCompleta=explode(" ",$timestamp);
			$fechaPartida=explode("-",$fechaCompleta[0]);
			$mes=obtenTextoMes($fechaPartida[1]);
			return $fechaPartida[2]." de ".$mes." ".$fechaPartida[0]." ".$fechaCompleta[1]." GMT-6";
		}
		return false;
	}
	
}

if ( ! function_exists('acomodaTimestamp2')){
	function acomodaTimestamp2($timestamp)
	{
		if($timestamp){
			$fechaCompleta=explode(" ",$timestamp);
			$fechaPartida=explode("-",$fechaCompleta[0]);
			$mes=obtenTextoMes($fechaPartida[1]);
			return $fechaPartida[2]." de ".$mes." ".$fechaPartida[0]." ".$fechaCompleta[1]." GMT-6";
		}
		return false;
	}
	
}
if ( ! function_exists('acomodaTimestamp3')){
	function acomodaTimestamp3($timestamp)
	{
		if($timestamp){
			$fechaCompleta=explode(" ",$timestamp);
			$fecha=acomodaFecha($fechaCompleta[0]);
			return $fecha." a las ".$fechaCompleta[1]." GMT-6";
		}
		return false;
	}
	
}

if ( ! function_exists('dameSemanaYEARWEEK')){
	function dameSemanaYEARWEEK($yearweek)
	{
			if($yearweek){
				$semana=substr($yearweek,4,5);
				return $semana;
			}
			return false;
	}

}

if ( ! function_exists('dameYearYEARWEEK')){
	function dameYearYEARWEEK($yearweek)
	{
			if($yearweek){
				$year=substr($yearweek,0,4);
				return $year;
			}
			return false;
	}

}
if ( ! function_exists('para_calendar')){
	function para_calendar($date)
	{
		if($date){
			$fecha=explode("-",$date);
			return $fecha[2]."/".$fecha[1]."/".$fecha[0];
		}
		return false;
	}

}
if ( ! function_exists('de_calendar')){
	function de_calendar($date)
	{
		if($date){
			$fecha=explode("/",$date);
			return $fecha[2]."-".$fecha[1]."-".$fecha[0];
		}
		return false;
	}

}
if ( ! function_exists('valida_fecha')){
	function valida_fecha($date)
	{
		if($date){
			$fecha=explode("-",$date);
			
			return checkdate((int)$fecha[1],(int)$fecha[2],(int)$fecha[0]);
		}
		return false;
	}

}

if ( ! function_exists('getLastLog')){
	function getLastLog($log=flase){
		if($log){
			$mensajes=explode('||',$log);
			if(isset($mensajes[0])){
				$contenido=explode('~~',$mensajes[0]);
				 $fecha=acomodaTimestamp3($contenido[0]);
				return $fecha.": ".$contenido[1];
			}
		}
		return false;
	}

}
/*
	 * convierte una fecha formato aaaa-mm-dd a dd/mm/aaaa
	 * @param $date
	 * @return fecha con otro formato
	 * */
if ( ! function_exists('fechaToCalendar')){
	function fechaToCalendar($date=flase){
		if($date){
			list($year,$mes,$dia)=explode('-',$date);
			return $dia.'/'.$mes.'/'.$year;
		}
		return false;
	}

}



/*
	 * convierte una fecha formato aaaa-mm-dd a  mes aaaa
	 * @param $date
	 * @return fecha con otro formato
	 * */
if ( ! function_exists('timestampToDiMeYe')){
	function timestampToDiMeYe($date=flase){
		if($date){
			$meses=catalogoInterno('smallMeses');
			list($year,$mes,$dia)=explode('-',$date);
			return $dia.'/'.$meses[$mes].'/'.$year;
		}
		return false;
	}

}


/*
	 * convierte una fecha formato aaaa-mm-dd a  dss/mes/aaaa
	 * @param $date
	 * @return fecha con otro formato
	 * */
if ( ! function_exists('timestampToMeYe')){
	function timestampToMeYe($date=flase){
		if($date){
			$meses=catalogoInterno('meses');
			list($year,$mes,$dia)=explode('-',$date);
			return $meses[$mes].' '.$year;
		}
		return false;
	}

}


/*
	 * Calcula fecha de nacimiento a partir de una fecha en formato dd/mm/aaaa
	 * @param $fechanacimiento
	 * @return $ano_diferencia
	 * 				edad 
	 * */
if( ! function_exists('calcula_edad')){
	 function calcula_edad($fechanacimiento){
	    list($dia,$mes,$ano) = explode("/",$fechanacimiento);
	    $ano_diferencia  = date("Y") - $ano;
	    $mes_diferencia = date("m") - $mes;
	    $dia_diferencia   = date("d") - $dia;
	    if ($mes_diferencia < 0)
	        $ano_diferencia--;
		else if($mes_diferencia==0 && $dia_diferencia < 0 )
		 	$ano_diferencia--;
	    return $ano_diferencia;
	}
}
/*
	 * Acomoda fecha de unixtimestamp a fecha mes en letra o si es la fecha de hoy 
	 * @param $unixtimestam
	 * @return texto de fecha acomodado para la vista
	 * 				 
	 * */
if ( ! function_exists('acomodaUnixtime')){
	function acomodaUnixtime($unixtime)
	{
			if($unixtime != 0){
				$fecha=date("Y-m-d",$unixtime);
				$hora=date("h:i:s",$unixtime);
				$time=$fecha." ".$hora;
				return acomodaFechaHora($time); 
			}
			return false;
	}

}

?>