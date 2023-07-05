<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if ( ! function_exists('quita_campos_vacios')){
		function quita_campos_vacios($var){
			if($var!="") return $var;
			else return false;
		}
	}

	if ( ! function_exists('catalogoInterno')){
		function catalogoInterno($catalogo=false){
	 		switch($catalogo){
				case 'meses_nombres':
					return array(
						'1' 	=> 'Ene',
						'2' 	=> 'Feb',
						'3' 	=> 'Mar',
						'4'		=> 'Abr',
						'5'		=> 'May',
						'6'		=> 'Jun',
						'7'		=> 'Jul',
						'8'		=> 'Ago',
						'9'		=> 'Sep',
						'10'	=> 'Oct',
						'11'	=> 'Nov',
						'12'	=> 'Dic'
					);
					break;
				case 'meses_ids':
					return array(
						'ene' => '1',
						'feb' => '2',
						'mar' => '3',
						'abr' => '4',
						'may' => '5',
						'jun' => '6',
						'jul' => '7',
						'ago' => '8',
						'sep' => '9',
						'oct' => '10',
						'nov' => '11',
						'dic' => '12'
					);
					break;
				case 'meses':
					return array(
			        	''  => '-Seleccione-',
			        	'01'    => 'Enero',
			        	'02'    => 'Febrero',
			        	'03'    => 'Marzo',
			        	'04'    => 'Abril',
			        	'05'    => 'Mayo',
			        	'06'    => 'Junio',
			        	'07'    => 'Julio',
			        	'08'    => 'Agosto',
			        	'09'    => 'Septiembre',
			        	'10'    => 'Octubre',
			        	'11'    => 'Noviembre',
			        	'12'    => 'Diciembre'
            		);
					break;

				case 'meses_lista':
					return array(
						'1'    => 'Enero',
						'2'    => 'Febrero',
						'3'    => 'Marzo',
						'4'    => 'Abril',
						'5'    => 'Mayo',
						'6'    => 'Junio',
						'7'    => 'Julio',
						'8'    => 'Agosto',
						'9'    => 'Septiembre',
						'10'    => 'Octubre',
						'11'    => 'Noviembre',
						'12'    => 'Diciembre'
					);
					break;

				case 'smallMeses':
					return array(
			    		'1'    => 'Ene',
			    		'2'    => 'Feb',
			    		'3'    => 'Mar',
			    		'4'    => 'Abr',
			    		'5'    => 'May',
			    		'6'    => 'Jun',
			    		'7'    => 'Jul',
			    		'8'    => 'Ago',
			    		'9'    => 'Sep',
			    		'10'    => 'Oct',
			    		'11'    => 'Nov',
			    		'12'    => 'Dic'
					);
					break;

				case 'estados_list':
					return array(
						''  => '-Seleccione-',
						'1'    => 'Activo',
						'2'    => 'Inactivo'
					);
					break;

				case 'tipo_accion':
					return array(
						''	=> 'NA',
						'1' => 'Construcción',
						'2' => 'Reconstrucción',
						'3'	=> 'Rehabilitación',
						'4'	=> 'Mantenimiento',
						'5' => 'Equipamiento',
						'6' => 'Evaluación',
						'7' => 'Certificación',
						'8' => 'Levantamiento información Técnica',
						'9'	=> 'NA'
					);
					break;

				case 'estados':
					return array(
						'0'  => 'Inactivo',
						'1'  => 'Activo',
					);
						break;

				case 'sexos':
					return array(
						''  => '-Seleccione-',
						'1'    => 'Hombre',
						'2'    => 'Mujer'
					);
					break;

				/**
				 * Géneros
				 * @var string
				 */
				case 'genero':
					return array(
						'0' => '-Seleccione-',
						'1' => 'Masculino',
						'2' => 'Femenino'
					);
					break;

				case 'estados_civil':
					return array(
	                  ''  => '-Seleccione-',
	                  '1' => 'Soltero',
	                  '2' => 'Casado',
	                  '3' => 'En unión libre/pareja',
                  	  '4' => ' Divorciado(a) ',
                  	  '5' => 'Otro'
				  	);
					break;

				case 'estados_civil2':
					return array(
						''  => '-Seleccione-',
						'1'    => 'Casado(a) ',
						'2'    => 'Vive con su pareja en unión libre ',
						'3'	=>'Soltero(a) ',
						'4'	=>' Viudo(a)  ',
						'5'	=>'No responde'
					);
					break;

				case 'si_no':
					return array(
						'0'  => '-Seleccione-',
						'1'    => 'Sí',
						'2'    => 'No'
					);
					break;
				case 'si_no_pnr':
					return array(
						'2'    => 'No',
						'1'    => 'Sí'
					);
					break;

				case 'si_no2':
					return array(
	                	''  => '-Seleccione-',
	                  	'1'    => 'Sí',
	                  	'2'    => 'No',
	                  	'3'    => 'No Sabe'
					);
					break;

				case 'acciones_estatus':
					return array(
						'0' => 'Inactivo',
						'1' => 'Activo',
						'2' => 'En programación',
					);
					break;

				case 'escuelas_estudio':
					return array(
						''  => '-Seleccione-',
						'1'    => 'Escuela Normal en dónde estudié ',
						'2'    => 'SEP',
						'3'    => 'CECAM',
						'4'	=>	'IIIEPE',
						'5'	=>	'Sindicato',
						'6'	=>	'En línea',
						'7'	=>	'Otros'
					);
					break;

				   case 'trabajos': return array(
	                  '0'  => '-Seleccione-',
	                  '1'    => 'Funcionario público, gerente, jefe de departamento',
					  '2'    => 'Profesionista en el área de la educación',
					  '3'    => 'Profesionista fuera del área de la educación',
	                  '4'    => 'Técnico',
					  '5'    => 'Trabajador auxiliar en actividades administrativas',
					  '6'   => 'Comerciante, empleado en ventas y agente de ventas',
	                  '7'    => 'Trabajador en servicios personales y vigilancia',
	                  '8' => 'Trabajador en actividades agrícolas, ganaderas, forestales, caza y pesca',
					  '9' => 'Trabajador artesanal',
					  '10' => 'Operador de maquinaria industrial, ensamblador, chofer y conductor de transporte',
				      '11' => 'Trabajador en actividades elementales y de apoyo. ',
					  '12' => 'Trabajador en servicios de protección y vigilancia y fuerzas armadas',
					  '13' => 'Otro trabajador con ocupaciones insuficientemente especificadas'
    			   );
				   break;
				    case 'trabajos2': return array(
	                  '0'  => '--Igual que cuando estudiaba--',
	                  '1'    => 'Funcionario público, gerente, jefe de departamento',
					  '2'    => 'Profesional de la educación',
	                  '3'    => 'Técnico',
	                  '4'    => 'Trabajador auxiliar en actividades administrativas',
	                  '5'    => 'Comerciante, empleado en ventas y agente de ventas',
	                  '6'    => 'Trabajador en servicios personales y vigilancia',
	                  '7'    => 'Trabajador en actividades agrícolas, ganaderas, forestales, caza y pesca',
	                  '8'    => 'Trabajador artesanal',
	                  '9'    => 'Operador de maquinaria industrial, ensamblador, chofer y conductor de transporte',
	                  '10'    => 'Trabajador en actividades elementales y de apoyo. ',
	                  '11'    => 'Trabajador en servicios de protección y vigilancia y fuerzas armadas',
	                  '12'    => 'Otro trabajador con ocupaciones insuficientemente especificadas',
	                  '13'    => 'Trabajador de la educación '


    			   );
				   break;
				   case 'tipos_institucion': return array(
					  '0'  => '-Seleccione-',
	                  '1'    => 'Universidad Pública',
	                  '2'    => ' Universidad Privada ',
	                  '3'    => 'Instituto Tecnológico y/o  Politécnico Público',
	                  '4'    => 'Instituto Tecnológico Privado',
	                  '5'    => 'Otro'


    			   );
				   break;
				   case 'niveles_estudios': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'No estudió',
	                  '2'    => ' Primaria ',
	                  '3'    => 'Secundaria',
	                  '4'    => 'Educación Media Superior',
	                  '5'    => 'Superior Universitaria'

    			   );
				   break;
                case 'tipos_institucion_2': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Pública',
	                  '2'    => 'Particular',


    			   );
				   break;
				   case 'tipos_titulacion': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Informe de prácticas profesionales',
	                  '2'    => 'Portafolio de evidencias',
	                  '3'	=>'Tesis de investigación',
	                  '4'	=>'Documento recepcional'


    			   );
				   break;
                case 'anos_bachillerato': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => '2 años',
	                  '2'    => '3 años',
                      '3'    => '4 años o más',

    			   );
				   break;
                 case 'valoracion_docente': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Pésimo',
	                  '2'    => 'Malo',
                      '3'    => 'Regular',
                      '4'    => 'Bueno',
                      '5'    => 'Excelente',

    			   );
				   break;
                   case 'eleccion_institucion': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'El prestigio de la institución',
	                  '2'    => 'La carrera sólo se ofrecía en esa institución',
                      '3'    => 'Ubicación geográfica',
                      '4'    => 'El costo de la inscripción y cuotas',
                      '5'    => 'Fecha de ingreso',
                      '6'    => 'Facilidad de ingreso',
                      '7'    => 'Consejo de profesores y orientadores',
                      '8'    => 'Consejo de familiares y amigos',
                      '9'    => 'Otra',

    			   );
				   break;
                 case 'eleccion_carrera': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Prestigio de la carrera',
                      '3'    => 'Remuneración económica (salario)',
                      '4'    => 'Facilidad de ingreso',
                      '5'    => 'Plan de estudios',
                      '6'    => 'Vocación y habilidades personales',
                      '7'    => 'Alta demanda en el mercado laboral',
                      '8'    => 'Consejo de familiares y amigos',
                      '9'    => 'Consejo de profesores',
                     '10'    => 'Consejo de orientadores',
                     '11'    => 'Tradición familiar',
                     '12'    => 'Otra',

    			   );
				   break;
                      case 'noexamen_oposicion': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'No tenía título',
	                  '2'    => 'No habia acabado el trabajo recepcional ',
                      '3'    => 'No se sentía preparado ',
                      '4'    => 'Otro',

    			   );
				   break;
                     case 'curso_examenoposicion': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Escuela Normal donde estudió la carrera ',
	                  '2'    => 'Otra institución'

    			   );
				   break;
                     case 'apreciacion_curso': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Inadecuado ',
	                  '2'    => 'Poco adecuado  ',
                      '3'    => 'Regular   ',
                      '4'    => 'Adecuado',
                      '5'    => 'Totalmente adecuado'

    			   );
				   break;
				   case 'parentesco': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Es Jefe(a) ',
	                  '2'    => 'Esposo(a) o Compañero(a)',
                      '3'    => 'Hijo(a)',
                      '4'    => 'Otro'
    			   );
				   break;
				   //inican catalogos internos lalo
				   case 'sugerencias': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Disminuir',
	                  '2'    => 'Mantener',
                      '3'    => 'Aumentar',
    			   );
				   break;
				   case 'nivel_satisfecho': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Nada satisfecho',
	                  '2'    => 'Poco satisfecho ',
                      '3'    => 'Algo satisfecho',
                      '4'    => 'Satisfecho',
                      '5'    => 'Muy satisfecho',
    			   );
				   break;
				   case 'nivel_exigencia': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Ninguna exigencia',
	                  '2'    => 'Poca exigencia  ',
                      '3'    => 'Alguna exigencia ',
                      '4'    => 'Aceptable   exigencia',
                      '5'    => 'Mucha exigencia ',
    			   );
				   break;
				   case 'nivel_frecuencia': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Insuficiente ',
	                  '2'    => 'Poco suficiente',
	                  '3'    => 'Algo suficiente',
	                  '4'    => 'Suficiente',
	                  '5'    => 'Muy suficiente',
    			   );
				   break;
				   case 'escala_5': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => '1',
	                  '2'    => '2',
	                  '3'    => '3',
	                  '4'    => '4',
	                  '5'    => '5',
    			   );
				   break;
					case 'escala_10': return array(
	                  ''  => '--Seleccione--',

	                  '0'    => '0',
	                  '1'    => '1',
	                  '2'    => '2',
	                  '3'    => '3',
	                  '4'    => '4',
	                  '5'    => '5',
	                  '6'    => '6',
	                  '7'    => '7',
	                  '8'    => '8',
	                  '9'    => '9',
	                  '10'    => '10',

    			   );
				   break;
				   case 'poca_mucha': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Poca',
	                  '2'    => 'Regular',
                      '3'    => 'Mucha',
    			   );
				   break;
				   case 'tipo_contrato': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Temporal o por obra determinada',
	                  '2'    => 'De base, planta o por tiempo indefinido',
                      '3'    => 'No Sabe',
    			   );
				   break;
				   case 'cargos': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Alto (medio) directivo ',
	                  '2'    => 'Profesionista de educación, de salud, otro ',
                      '3'    => 'Técnico y auxil',
                      '4'	=>	'Comerciante',
                      '5'	=>	'Trabajador no especializado',
                      '6'	=>	'Otro'
    			   );
				   break;
				   case 'actividades': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Docencia',
	                  '2'    => 'Dirección o coordinación ',
                      '3'    => '  Administración',
                      '4'	=>	'Asesoría ',
                      '5'	=>	'Supervisión',
                      '6'	=>	'Otras'
    			   );
				   break;
				   case 'motivos': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Quiere seguir estudiando',
	                  '2'    => 'No quiere (no puede)  trabajar',
                      '3'    => 'No necesita trabajar',
                      '4'	=>	'Otro'
    			   );
				   break;
				   case 'motivos_no': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Ha encontrado trabajo, pero no le gusta ',
	                  '2'    => 'Espera respuesta del examen de oposición',
                      '3'    => 'Fue aprobado en el examen de oposición para ingreso a SPD, pero no hay plaza',
                      '4'	=>	'Espera respuesta a una solicitud; lo llamarán en fecha próxima',
                      '5'	=>	'No tiene tiempo para buscar',
                      '6'	=>	'Otro'
    			   );
				   break;
				    case 'tipo_plaza': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Tiempo completo ',
	                  '2'    => 'Medio Tiempo  ',
                      '3'    => 'Por horas    ',


    			   );
				   break;
                case 'tipo_evaluacion': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Evaluación para el ingreso al Servicio Profesional Docente SPD',
	                  '2'    => 'Evaluación de desempeño/permanencia',
                      '3'    => 'Concurso de Oposición para la Promoción',
                      '4'    => 'No realicé examen'
    			   );
				   break;
                case 'tipo_plaza_2': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Plaza de docente',
	                  '2'    => 'Plaza de Director ',
                      '3'    => 'Plaza de subdirector',
                      '4'    => 'Plaza de Asesor Pedagógico',
	                  '5'    => 'Plaza de Supervisor',
                      '6'    => 'Otra (especifique)',
                      '7'    => 'No obtuvo plaza docente',
    			   );
				   break;
                case 'numero_curso': return array(
	                  ''  => '--Seleccione--',
	                  '1'    => 'Uno',
	                  '2'    => 'Dos',
                      '3'    => 'Tres',
                      '4'    => 'Cuatro y más',
    			   );
				   break;
				  case 'tipo_encuestas': return array(
	                  ''  => '--Seleccione--',
	                  'salida_v1'    => 'Salida',
	                  'seguimiento_v1'    => 'Seguimiento',

				   );
				   break;
				   case 'escuelas': return array(
					''  => '-Seleccione-',
					'1'    => '',
					'2'    => 'Escuela Normal "Pablo Livas"',
					'3'    => 'Escuela Normal "Prof. Serafín Peña"',
					'4'    => 'Escuela Normal "Miguel F. Martínez"',
					'5'    => 'Escuela Normal de Especialización "Humberto Ramos Lozano"'
				 );
				break;

				 /**
				 * Catálogo para los perfiles de los permisos
				 * @var array/string
				 */
				case 'perfiles': return array(
					'0'  => '-Seleccione-',
					'1'  => 'Director', //Lectura
					'2'  => 'Coordinador', //Lectrua y Escritura
					'3'  => 'Operador' //Sin acceso
				);
				break;
				/**
				 * Catálogo para marginacion
				 * @var array/string
				 */
				case 'marginacion': return array(
					''  => '-Seleccione-',
					'ALTO'  => 'ALTO', //Lectura
					'BAJO'  => 'BAJO', //Lectrua y Escritura
					'MEDIO'  => 'MEDIO', //Sin acceso
					'MUY ALTO'  => 'MUY ALTO',
					'MUY BAJO'  => 'MUY BAJO'
				);
				break;
			default: return false;

					break;
	 	}
	 }

}
if ( ! function_exists('comboDias')){
	function comboDias(){


			$data=array();
			$data[""]="-Seleccione-";
			for ($i=1; $i <= 31; $i++) {
				if($i<10)
				{
					$data['0'.$i]=$i;
				}
				else {
					$data[$i]=$i;
				}

			}
			return $data;


	}
}
if ( ! function_exists('comboYears')){
	function comboYears($inicio=false,$fin=false){
		if(!$fin) $fin=date('Y');
		if($inicio && is_numeric($inicio) && ($inicio>$fin)){
			$data=array();
			$data[""]="-Seleccione-";
			for ($i=$inicio; $i >= $fin; $i--) {
				 $data[$i]=$i;
			}
			return $data;
		}
		else{
			return $fin;
		}
	}
}

if ( ! function_exists('yearProduccion')){
	function yearProduccion(){
		return date('Y')-1;
	}
}
if ( ! function_exists('hora')){
	function hora(){
		$ahora=date("Y-m-d H:i:s");
		$nueva = strtotime ( '-11 minute -20 second' , strtotime ( $ahora ) ) ;
		$hora=date("Y-m-d H:i:s",$nueva);
		return $hora;
	}
}

?>
