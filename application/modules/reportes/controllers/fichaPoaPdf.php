<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class fichaPoaPdf extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$models = array(
			'home/home_inicio',
			'inicio/proyectos_model',
			'pdf_model'
		);
		$this->load->model($models);
	}

	private function _obtenerNombreMes($numero_mes) {
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

	public function index()
	{
		$dir = 'fichasPOA/';
		$filename = 'fichaPOA' . microtime(TRUE) . '.pdf';

		if (!is_dir(FCPATH . $dir))
			mkdir(FCPATH . $dir, 0777, TRUE);

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('TECDMX');
		$pdf->SetTitle('Ficha POA');
		$pdf->SetSubject('Ficha POA');
		$pdf->SetKeywords('Ficha POA');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//set auto page breaks
		///$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAutoPageBreak(TRUE, 15);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		// $pdf->setLanguageArray($l);

		// ---------------------------------------------------------
		// set font
		$pdf->SetFont('helvetica', '', 10);

		$proyectos = $this->input->post('proyectos');
		$ejercicio = $this->session->userdata('ejercicio');

		foreach ($proyectos as $proyecto) {
			$pdf->AddPage();
			$projectInfo = $this->pdf_model->getInfoOfProject($ejercicio, $proyecto);
			if ($projectInfo) {
				if ($projectInfo->ejercicio >= 2014) {
					$clase_indicador = '-new';
				}

				if ($projectInfo->ejercicio == 2016) {
					if ($projectInfo->nombre_ro == trim("Ponencia de la Magistrada Gabriela Eugenia Del Valle Pérez")) {
						$projectInfo->nombre_ro = "Ponencia de la Magistrada Martha Alejandra Chávez Camarena";
					}
				}

				$tabla_objetivo = "";

				if ($projectInfo->ejercicio >= 2017) {
					$tabla_objetivo .= '<table class="tabla objetivo-proyecto" cellpadding="2">' .
						'<tr><td colspan="2" class="borde titulo-tabla">Objetivo de la Unidad Responsable</td><td></td></tr>' .
						'<tr><td colspan="3" class="borde dato-completo">' . $projectInfo->objetivo . '</td></tr>' .
						'</table><table class="espacio"><tr><td></td></tr></table>';
				}

				$metasPrincipales = $this->pdf_model->getMetas('principal', $proyecto);
				if ($metasPrincipales) {
					$tabla_meta_principal = "";
					$tabla_meta_principal .= '<table class="tabla meta-principal" cellpadding="2">';
					$tabla_meta_principal .= '<tr>';
					$tabla_meta_principal .= '<td colspan="4" class="borde titulo-tabla">Cuantificaci&oacute;n de Metas</td>';
					$tabla_meta_principal .= '<td colspan="5"></td>';
					$tabla_meta_principal .= '</tr>';
					$tabla_meta_principal .= '<tr>';
					$tabla_meta_principal .= '<td colspan="9" class="borde encabezado encabezado-completo">META PRINCIPAL</td>';
					$tabla_meta_principal .= '</tr>';
					$tabla_meta_principal .= '<tr>';
					$tabla_meta_principal .= '<td class="borde encabezado encabezado-meta">Denominaci&oacute;n de la Meta</td>';
					$tabla_meta_principal .= '<td class="borde encabezado encabezado-unidad">UM</td>';
					$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">ENE</td>';
					$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">FEB</td>';
					$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">MAR</td>';
					$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">ABR</td>';
					$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">MAY</td>';
					$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">JUN</td>';
					$tabla_meta_principal .= '</tr>';

					foreach ($metasPrincipales as $metaPrincipal) {
						$unidadMedida = $this->pdf_model->getUnidadesMedida($metaPrincipal->meta_id);
						if ($unidadMedida) {
							$tabla_meta_principal .= '<tr>';
							$tabla_meta_principal .= '<td colspan="2" rowspan="3" class="borde dato-meta izquierda">' . $metaPrincipal->nombre . '</td>';
							$tabla_meta_principal .= '<td rowspan="3" class="borde dato-unidad">' . $unidadMedida->nombre . '</td>';

							$meses = array('1', '2', '3', '4', '5', '6');
							$primerosMeses = $this->pdf_model->getMetasArreglo($metaPrincipal->meta_id, $meses, 'meses_metas_programadas');

							if ($primerosMeses) {
								$acumulado = 0;
								foreach ($primerosMeses as $primerMes) {
									$acumulado += $primerMes->numero;
									$tabla_meta_principal .= '<td  class="borde dato-mes">' . $primerMes->numero . '</td>';
								}

								$tabla_meta_principal .= '</tr>';

								$tabla_meta_principal .= '<tr>';
								$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">JUL</td>';
								$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">AGO</td>';
								$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">SEP</td>';
								$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">OCT</td>';
								$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">NOV</td>';
								$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">DIC</td>';
								$tabla_meta_principal .= '</tr>';

								$meses = array('7', '8', '9', '10', '11', '12');
								$segundosMeses = $this->pdf_model->getMetasArreglo($metaPrincipal->meta_id, $meses, 'meses_metas_programadas');
								if ($segundosMeses) {
									$tabla_meta_principal .= '<tr>';
									foreach ($segundosMeses as $segundoMes) {
										$acumulado += $segundoMes->numero;
										$tabla_meta_principal .= '<td  class="borde dato-mes">' . $segundoMes->numero . '</td>';
									}

									$tabla_meta_principal .= '</tr>';

									$tabla_meta_principal .= '<tr>';
									$tabla_meta_principal .= '<td colspan="6"></td>';
									$tabla_meta_principal .= '<td colspan="2" class="borde encabezado encabezado-doble-mes">TOTAL ANUAL</td>';
									$tabla_meta_principal .= '<td class="borde encabezado encabezado-mes">' . $acumulado . '</td>';
									$tabla_meta_principal .= '</tr>';
									$tabla_meta_principal .= '</table>';
									$tabla_meta_principal .= '<table class="espacio"><tr><td></td></tr></table>';

								}
							}
						}
					}
				}

				$metasComplementarias = $this->pdf_model->getMetas('complementaria', $proyecto);
				$tabla_meta_complementaria = "";
				if ($metasComplementarias) {
					foreach ($metasComplementarias as $metaComplementaria) {
						$tabla_meta_complementaria .= '<table class="tabla meta-complementaria" cellpadding="2">';
						$tabla_meta_complementaria .= '<tr>';
						$tabla_meta_complementaria .= '<td colspan="9" class="borde encabezado encabezado-completo">METAS COMPLEMENTARIAS</td>';
						$tabla_meta_complementaria .= '</tr>';
						$tabla_meta_complementaria .= '<tr>';
						$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-meta">Denominación de la Meta</td>';
						$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-unidad">UM</td>';
						$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">ENE</td>';
						$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">FEB</td>';
						$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">MAR</td>';
						$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">ABR</td>';
						$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">MAY</td>';
						$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">JUN</td>';
						$tabla_meta_complementaria .= '</tr>';

						$unidadMedida = $this->pdf_model->getUnidadesMedida($metaComplementaria->meta_id);

						if ($unidadMedida) {
							$tabla_meta_complementaria .= '<tr>';
							$tabla_meta_complementaria .= '<td colspan="2" rowspan="3" class="borde dato-meta izquierda">' . $metaComplementaria->nombre . '</td>';
							$tabla_meta_complementaria .= '<td rowspan="3" class="borde dato-unidad">' . $unidadMedida->nombre . '</td>';

							$meses = array('1', '2', '3', '4', '5', '6');
							$primerosMeses = $this->pdf_model->getMetasArreglo($metaComplementaria->meta_id, $meses, 'meses_metas_programadas');
							if ($primerosMeses) {
								$acumulado = 0;
								foreach ($primerosMeses as $primerMes) {
									$acumulado += $primerMes->numero;
									$tabla_meta_complementaria .= '<td  class="borde dato-mes">' . $primerMes->numero . '</td>';
								}

								$tabla_meta_complementaria .= '</tr>';

								$tabla_meta_complementaria .= '<tr>';
								$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">JUL</td>';
								$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">AGO</td>';
								$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">SEP</td>';
								$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">OCT</td>';
								$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">NOV</td>';
								$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">DIC</td>';
								$tabla_meta_complementaria .= '</tr>';

								$meses = array('7', '8', '9', '10', '11', '12');
								$segundosMeses = $this->pdf_model->getMetasArreglo($metaComplementaria->meta_id, $meses, 'meses_metas_programadas');
								if ($segundosMeses) {
									$tabla_meta_complementaria .= '<tr>';
									foreach ($segundosMeses as $segundoMes) {
										$acumulado += $segundoMes->numero;
										$tabla_meta_complementaria .= '<td  class="borde dato-mes">' . $segundoMes->numero . '</td>';
									}
									$tabla_meta_complementaria .= '</tr>';

									$tabla_meta_complementaria .= '<tr>';
									$tabla_meta_complementaria .= '<td colspan="6"></td>';
									$tabla_meta_complementaria .= '<td colspan="2" class="borde encabezado encabezado-doble-mes">TOTAL ANUAL</td>';
									$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">' . $acumulado . '</td>';
									$tabla_meta_complementaria .= '</tr>';

									$tabla_meta_complementaria .= '</table>';
									$tabla_meta_complementaria .= '<table class="espacio"><tr><td></td></tr></table>';
								}
							}
						}
					}
				} else {
					$tabla_meta_complementaria .= '<table class="tabla meta-complementaria" cellpadding="2">';
					$tabla_meta_complementaria .= '<tr>';
					$tabla_meta_complementaria .= '<td colspan="9" class="borde encabezado encabezado-completo">METAS COMPLEMENTARIAS</td>';
					$tabla_meta_complementaria .= '</tr>';
					$tabla_meta_complementaria .= '<tr>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-meta">Denominaci&oacute;n de la Meta</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-unidad">UM</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">ENE</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">FEB</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">MAR</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">ABR</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">MAY</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">JUN</td>';
					$tabla_meta_complementaria .= '</tr>';
					$tabla_meta_complementaria .= '<tr>';
					$tabla_meta_complementaria .= '<td colspan="2" rowspan="3" class="borde dato-meta izquierda">No aplica</td>';
					$tabla_meta_complementaria .= '<td rowspan="3" class="borde dato-unidad">No aplica</td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '</tr>';
					$tabla_meta_complementaria .= '<tr>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">JUL</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">AGO</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">SEP</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">OCT</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">NOV</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes">DIC</td>';
					$tabla_meta_complementaria .= '</tr>';
					$tabla_meta_complementaria .= '<tr>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '<td  class="borde dato-mes"></td>';
					$tabla_meta_complementaria .= '</tr>';
					$tabla_meta_complementaria .= '<tr>';
					$tabla_meta_complementaria .= '<td colspan="6"></td>';
					$tabla_meta_complementaria .= '<td colspan="2" class="borde encabezado encabezado-doble-mes">TOTAL ANUAL</td>';
					$tabla_meta_complementaria .= '<td class="borde encabezado encabezado-mes"></td>';
					$tabla_meta_complementaria .= '</tr>';
					$tabla_meta_complementaria .= '</table>';
					$tabla_meta_complementaria .= '<table class="espacio"><tr><td></td></tr></table>';
				}

				$indicadores = $this->pdf_model->getIndicadores($projectInfo->proyecto_id);
				$tabla_indicadores = '';
				if ($indicadores) {
					$tabla_indicadores .= '<table class="tabla indicadores" cellpadding="2">';
					$tabla_indicadores .= '<tr>';
					if ($projectInfo->ejercicio >= 2014) {
						$tabla_indicadores .= '<td colspan="7" class="borde encabezado encabezado-completo">INDICADORES</td>';
					} else {
						$tabla_indicadores .= '<td colspan="6" class="borde encabezado encabezado-completo">INDICADORES</td>';
					}
					$tabla_indicadores .= '</tr>';
					$tabla_indicadores .= '<tr>';
					$tabla_indicadores .= '<td class="borde encabezado encabezado-indicador' . $clase_indicador . '">Nombre del Indicador</td>';
					if ($projectInfo->ejercicio >= 2014) {
						$tabla_indicadores .= '<td class="borde encabezado encabezado-definicion-indicador' . $clase_indicador . '">Definici&oacute;n del Indicador</td>';
					}
					$tabla_indicadores .= '<td class="borde encabezado encabezado-unidad-indicador' . $clase_indicador . '">Unidad de medida</td>';
					$tabla_indicadores .= '<td class="borde encabezado encabezado-metodo-indicador' . $clase_indicador . '">M&eacute;todo de c&aacute;lculo</td>';
					$tabla_indicadores .= '<td class="borde encabezado encabezado-uno-indicador' . $clase_indicador . '">Dimensi&oacute;n a medir</td>';
					$tabla_indicadores .= '<td class="borde encabezado encabezado-uno-indicador' . $clase_indicador . '">Frecuencia de medici&oacute;n</td>';
					$tabla_indicadores .= '<td class="borde encabezado encabezado-uno-par-indicador' . $clase_indicador . '">Meta del Indicador</td>';
					$tabla_indicadores .= '</tr>';

					foreach ($indicadores as $indicador) {
						$tabla_indicadores .= '<tr>';
						$tabla_indicadores .= '<td class="borde dato-indicador' . $clase_indicador . '">' . $indicador->nombre . '</td>';
						if ($projectInfo->ejercicio >= 2014) {
							$tabla_indicadores .= '<td class="borde dato-definicion-indicador' . $clase_indicador . '">' . $indicador->definicion . '</td>';
						}

						$unidadMedida = $this->pdf_model->getUnidadesMedidasIndicadores($indicador->indicador_id);

						$mediciones = $this->pdf_model->getMedicionIndicador($indicador->indicador_id);
						if ($mediciones) {
							$tabla_indicadores .= '<td class="borde dato-unidad-indicador' . $clase_indicador . '">' . $unidadMedida->nombre . '</td>';
							$tabla_indicadores .= '<td class="borde dato-metodo-indicador' . $clase_indicador . '">' . $indicador->metodo_calculo . '</td>';
							$tabla_indicadores .= '<td class="borde dato-uno-indicador' . $clase_indicador . '">' . $mediciones->nombre_dimension . '</td>';
							$tabla_indicadores .= '<td class="borde dato-uno-indicador' . $clase_indicador . '">' . $mediciones->nombre_frecuencia . '</td>';
							$tabla_indicadores .= '<td class="borde dato-uno-par-indicador' . $clase_indicador . '">' . $indicador->meta . '</td>';
							$tabla_indicadores .= '</tr>';
						}
					}
					$tabla_indicadores .= '</tbody>';
					$tabla_indicadores .= '</table>';
					$tabla_indicadores .= '<table class="espacio"><tr><td></td></tr></table>';
				}

				$accionesSustantivas = $this->pdf_model->getAccionesSustantivas($projectInfo->proyecto_id);
				$tabla_acciones_sustantivas = '';
				if ($accionesSustantivas) {
					$tabla_acciones_sustantivas .= '<table class="tabla acciones_sustantivas" cellpadding="2">';
					$tabla_acciones_sustantivas .= '<tr>';
					$tabla_acciones_sustantivas .= '<td colspan="4" class="borde titulo-tabla">Contenido y Temporalidad del Proyecto</td>';
					$tabla_acciones_sustantivas .= '<td colspan="5"></td>';
					$tabla_acciones_sustantivas .= '</tr>';
					$tabla_acciones_sustantivas .= '<tr>';
					$tabla_acciones_sustantivas .= '<td colspan="9" class="borde encabezado encabezado-completo izquierda">Acciones Sustantivas del Proyecto</td>';
					$tabla_acciones_sustantivas .= '</tr>';

					foreach ($accionesSustantivas as $accionSustantiva) {
						$tabla_acciones_sustantivas .= '<tr>';
						$tabla_acciones_sustantivas .= '<td class="borde dato-numero-accion">' . $accionSustantiva->numero . '</td>';
						$tabla_acciones_sustantivas .= '<td class="borde dato-accion-sustantiva">' . $accionSustantiva->descripcion . '</td>';
						$tabla_acciones_sustantivas .= '</tr>';
					}
					$tabla_acciones_sustantivas .= '</table>';
					$tabla_acciones_sustantivas .= '<table class="espacio"><tr><td></td></tr></table>';
				} else {
					$tabla_acciones_sustantivas .= '<table class="tabla acciones_sustantivas" cellpadding="2">';
					$tabla_acciones_sustantivas .= '<tr>';
					$tabla_acciones_sustantivas .= '<td colspan="4" class="borde titulo-tabla">Contenido y Temporalidad del Proyecto</td>';
					$tabla_acciones_sustantivas .= '<td colspan="5"></td>';
					$tabla_acciones_sustantivas .= '</tr>';
					$tabla_acciones_sustantivas .= '<tr>';
					$tabla_acciones_sustantivas .= '<td colspan="9" class="borde encabezado encabezado-completo izquierda">Acciones Sustantivas del Proyecto</td>';
					$tabla_acciones_sustantivas .= '</tr>';
					$tabla_acciones_sustantivas .= '<tr>';
					$tabla_acciones_sustantivas .= '<td class="borde dato-numero-accion"></td>';
					$tabla_acciones_sustantivas .= '<td class="borde dato-accion-sustantiva"></td>';
					$tabla_acciones_sustantivas .= '</tr>';
					$tabla_acciones_sustantivas .= '</table>';
					$tabla_acciones_sustantivas .= '<table class="espacio"><tr><td></td></tr></table>';
				}

				$tabla_derechos_humanos = '';
				if ($projectInfo->ejercicio <= 2013) {
					$accionesSustantivasDerechosHumanos = $this->pdf_model->getAccionesSustantivasDerechosHumanos($projectInfo->proyecto_id);
					if ($accionesSustantivasDerechosHumanos) {
						$tabla_derechos_humanos .= '<table class="tabla derechos-humano" cellpadding="2">';
						$tabla_derechos_humanos .= '<tr>';
						$tabla_derechos_humanos .= '<td colspan="6" class="borde encabezado encabezado-completo cursiva">Programa de Derechos Humanos del Distrito Federal</td>';
						$tabla_derechos_humanos .= '</tr>';
						$tabla_derechos_humanos .= '<tr>';
						$tabla_derechos_humanos .= '<td class="borde encabezado encabezado-uno-derecho">L&iacute;nea de Acci&oacute;n</td>';
						$tabla_derechos_humanos .= '<td class="borde encabezado encabezado-derecho">Acci&oacute;n Sustantiva POA - PDHDF</td>';
						$tabla_derechos_humanos .= '</tr>';

						foreach ($accionesSustantivasDerechosHumanos as $accionSustantivaDerechosHumanos) {
							$lineasAccion = $this->pdf_model->getLineasAccion($accionSustantivaDerechosHumanos->accion_sustantiva_derecho_humano_id);
							if ($lineasAccion) {
								$tabla_derechos_humanos .= '<tr>';
								$tabla_derechos_humanos .= '<td class="borde dato-uno-derecho">' . $lineasAccion->numero . '</td>';
								$tabla_derechos_humanos .= '<td class="borde dato-derecho">' . $lineasAccion->nombre . '</td>';
								$tabla_derechos_humanos .= '</tr>';
							}
						}
						$tabla_derechos_humanos .= '</table>';
						$tabla_derechos_humanos .= '<table class="espacio"><tr><td></td></tr></table>';
					} else {
						$tabla_derechos_humanos .= '<table class="tabla derechos-humano" cellpadding="2">';
						$tabla_derechos_humanos .= '<tr>';
						$tabla_derechos_humanos .= '<td colspan="6" class="borde encabezado encabezado-completo cursiva">Programa de Derechos Humanos del Distrito Federal</td>';
						$tabla_derechos_humanos .= '</tr>';
						$tabla_derechos_humanos .= '<tr>';
						$tabla_derechos_humanos .= '<td class="borde encabezado encabezado-uno-derecho">L&iacute;nea de Acci&oacute;n</td>';
						$tabla_derechos_humanos .= '<td class="borde encabezado encabezado-derecho">Acci&oacute;n Sustantiva POA - PDHDF</td>';
						$tabla_derechos_humanos .= '</tr>';
						$tabla_derechos_humanos .= '<tr>';
						$tabla_derechos_humanos .= '<td class="borde dato-uno-derecho">No aplica</td>';
						$tabla_derechos_humanos .= '<td class="borde dato-derecho">No aplica</td>';
						$tabla_derechos_humanos .= '</tr>';
						$tabla_derechos_humanos .= '</table>';
						$tabla_derechos_humanos .= '<table class="espacio"><tr><td></td></tr></table>';
					}
				}

				$equidadesGeneros = $this->pdf_model->getEquidadesGenero($projectInfo->proyecto_id);
				$tabla_equidad_genero = '';
				if ($equidadesGeneros) {
					if ($projectInfo->ejercicio >= 2017) {
						$tabla_equidad_genero .= '<table class="tabla equidad-genero" cellpadding="2">';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td colspan="6" class="borde encabezado encabezado-completo cursiva">Programa Especial de Igualdad de Oportunidades y no Discriminaci&oacute;n hacia <br />las Mujeres de la Ciudad de M&eacute;xico, 2015-2018</td>';
						$tabla_equidad_genero .= '</tr>';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td class="borde encabezado encabezado-uno-derecho">Pol&iacute;tica P&uacute;blica</td>';
						$tabla_equidad_genero .= '<td class="borde encabezado encabezado-derecho">Acci&oacute;n Sustantiva POA - Enfoque de G&eacute;nero</td>';
						$tabla_equidad_genero .= '</tr>';
					} else {
						$tabla_equidad_genero .= '<table class="tabla equidad-genero" cellpadding="2">';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td colspan="6" class="borde encabezado encabezado-completo cursiva">Programa General de Igualdad de Oportunidades y no Discriminaci&oacute;n hacia <br />las Mujeres de la Ciudad de M&eacute;xico</td>';
						$tabla_equidad_genero .= '</tr>';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td class="borde encabezado encabezado-uno-derecho">L&iacute;nea de Acci&oacute;n</td>';
						$tabla_equidad_genero .= '<td class="borde encabezado encabezado-derecho">Acci&oacute;n Sustantiva POA - Equidad de G&eacute;nero</td>';
						$tabla_equidad_genero .= '</tr>';
					}

					foreach ($equidadesGeneros as $equidadGenero) {
						$accionesEquidadGenero = $this->pdf_model->getAccionesEquidadGenero($equidadGenero->equidad_genero_id);
						if ($accionesEquidadGenero) {
							$tabla_equidad_genero .= '<tr>';
							$tabla_equidad_genero .= '<td class="borde dato-uno-derecho">' . $accionesEquidadGenero->numero . '</td>';
							$tabla_equidad_genero .= '<td class="borde dato-derecho">' . $accionesEquidadGenero->descripcion . '</td>';
							$tabla_equidad_genero .= '</tr>';
						}
					}
					$tabla_equidad_genero .= '</table>';
					$tabla_equidad_genero .= '<table class="espacio"><tr><td></td></tr></table>';
				} else {
					if ($projectInfo->ejercicio >= 2017) {
						$tabla_equidad_genero .= '<table class="tabla equidad-genero" cellpadding="2">';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td colspan="6" class="borde encabezado encabezado-completo cursiva">Programa Especial de Igualdad de Oportunidades y no Discriminaci&oacute;n hacia <br />las Mujeres de la Ciudad de M&eacute;xico, 2015-2018</td>';
						$tabla_equidad_genero .= '</tr>';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td class="borde encabezado encabezado-uno-derecho">Pol&iacute;tica P&uacute;blica</td>';
						$tabla_equidad_genero .= '<td class="borde encabezado encabezado-derecho">Acci&oacute;n Sustantiva POA - Enfoque de G&eacute;nero</td>';
						$tabla_equidad_genero .= '</tr>';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td class="borde dato-uno-derecho">No aplica</td>';
						$tabla_equidad_genero .= '<td class="borde dato-derecho">No aplica</td>';
						$tabla_equidad_genero .= '</tr>';
						$tabla_equidad_genero .= '</table>';
						$tabla_equidad_genero .= '<table class="espacio"><tr><td></td></tr></table>';
					} else {
						$tabla_equidad_genero .= '<table class="tabla equidad-genero" cellpadding="2">';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td colspan="6" class="borde encabezado encabezado-completo cursiva">Programa General de Igualdad de Oportunidades y no Discriminaci&oacute;n hacia <br />las Mujeres de la Ciudad de M&eacute;xico</td>';
						$tabla_equidad_genero .= '</tr>';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td class="borde encabezado encabezado-uno-derecho">L&iacute;nea de Acci&oacute;n</td>';
						$tabla_equidad_genero .= '<td class="borde encabezado encabezado-derecho">Acci&oacute;n Sustantiva POA - Equidad de G&eacute;nero</td>';
						$tabla_equidad_genero .= '</tr>';
						$tabla_equidad_genero .= '<tr>';
						$tabla_equidad_genero .= '<td class="borde dato-uno-derecho">No aplica</td>';
						$tabla_equidad_genero .= '<td class="borde dato-derecho">No aplica</td>';
						$tabla_equidad_genero .= '</tr>';
						$tabla_equidad_genero .= '</table>';
						$tabla_equidad_genero .= '<table class="espacio"><tr><td></td></tr></table>';
					}
				}

				$ejecucionesProyectos = $this->pdf_model->getMesesEjecucion($projectInfo->proyecto_id);
				if ($ejecucionesProyectos) {
					$periodo_array = array();
					foreach ($ejecucionesProyectos as $ejecucionProyecto) {
						$ejecuta = $ejecucionProyecto->ejecuta == 'si' ? 'x' : '';
						$periodo_array[$ejecucionProyecto->nombre] = $ejecuta;
					}
				}

				$fecha = "";
				if ($projectInfo->proyecto_id != 351 && $projectInfo->proyecto_id != 352) {
					$fecha .= date('d \d\e ', strtotime($projectInfo->fecha));
					$fecha .= $this->_obtenerNombreMes(date('m', strtotime($projectInfo->fecha)));
					$fecha .= date(' \d\e Y', strtotime($projectInfo->fecha));
				} else {
					if ($projectInfo->proyecto_id == 351 || $projectInfo->proyecto_id == 352) {
						$fecha .= "Se precisa que la Magistrada Martha Alejandra Chávez Camarena fue protestada por el Senado de la República el 29 de abril de 2016";
					}
				}

				$leyenda_nombre_cargo_firma_ro = "Nombre, Cargo y Firma del Responsable Operativo";
				if ($projectInfo->ejercicio >= 2016) {
					$leyenda_nombre_cargo_firma_ro = "Nombre, Cargo y Firma de quien revis&oacute;";
				} else {
					$cargo_responsable_operativo = $projectInfo->nombre_ro;
				}
			}

			$html = '
				<style>
					table.tabla {
						font-size: 10px;
					}
					td.borde {
						border: 0.5px solid #000;
					}
					td.borde-inferior {
						border-top: 0.5px solid #000;
						border-left: 0.5px solid #000;
						border-right: 0.5px solid #000;
					}
					td.borde-superior {
						border-bottom: 0.5px solid #000;
						border-left: 0.5px solid #000;
						border-right: 0.5px solid #000;
					}
					td.titulo-tabla {
						width: 45%;
						text-align: center;
						color: #fff;
						background-color: #8a8a8a;
						font-weight: bold;
					}
					td.encabezado {
						text-align: center;
						background-color: #e8e8e8;
						font-weight: bold;
					}
					td.encabezado-uno {
						width: 11%;
					}
					td.encabezado-unidad {
						width: 14%;
					}
					td.encabezado-unidad-indicador {
						width: 14%;
					}
					td.encabezado-unidad-indicador-new {
						width: 12%;
					}    
					td.encabezado-mes {
						width: 9%;
					}
					td.encabezado-uno-indicador {
						width: 10%;
					}
					td.encabezado-uno-indicador-new {
						width: 10%;
					}
					td.encabezado-uno-par-indicador {
						width: 10%;
					}
					td.encabezado-uno-par-indicador-new {
						width: 9%;
					}
					td.encabezado-uno-derecho {
						width: 15%;
					}
					td.encabezado-derecho {
						width: 85%;
					}
					td.encabezado-dos {
						width: 23%;
					}
					td.encabezado-meta {
						width: 32%;
					}
					td.encabezado-indicador {
						width: 32%;
					}
					td.encabezado-indicador-new {
						width: 22%;
					}
					td.encabezado-periodo {
						width: 40%;
					}
					td.encabezado-mes-periodo {
						width: 10%;
					}
					td.encabezado-metodo-indicador {
						width: 24%;
					}
					td.encabezado-metodo-indicador-new {
						width: 18%;
					}
					td.encabezado-definicion-indicador-new {
						width: 19%;
					}
					td.encabezado-medio {
						width: 22%;
					}
					td.encabezado-doble-mes {
						width: 18%;
					}
					td.encabezado-tres {
						width: 33%;
					}
					td.encabezado-cuatro {
						width: 45%;
					}
					td.encabezado-completo {
						width: 100%;
					}
					td.encabezado-fecha {
						width: 40%;
						text-align: right;
					}
					td.encabezado-fecha-2 {
						width: 60%;
					}
					td.dato {
						width: 77%;
					}
					td.dato-uno {
						width: 11%;
						text-align: center;
					}
					td.dato-numero-accion {
						width: 4%;
						text-align: center;
					}
					td.dato-accion-sustantiva {
						width: 96%;
					}
					td.dato-uno-indicador {
						width: 10%;
						text-align: center;
					}
					td.dato-uno-indicador-new {
						width: 10%;
						text-align: center;
					}
					td.dato-uno-par-indicador {
						width: 10%;
						text-align: center;
					}
					td.dato-uno-par-indicador-new {
						width: 9%;
						text-align: center;
					}
					td.dato-unidad {
						width: 14%;
						text-align: center;
					}
					td.dato-unidad-indicador {
						width: 14%;
						text-align: center;
					}
					td.dato-unidad-indicador-new {
						width: 12%;
						text-align: center;
					}
					td.dato-uno-derecho {
						width: 15%;
						text-align: center;
					}
					td.dato-derecho {
						width: 85%;
					}
					td.dato-mes {
						width: 9%;
						text-align: center;
					}
					td.dato-mes-periodo {
						width: 10%;
						text-align: center;
					}
					td.dato-dos {
						width: 23%;
						text-align: center;
					}
					td.dato-meta {
						width: 32%;
						text-align: center;
					}
					td.dato-indicador {
						width: 32%;
					}    
					td.dato-indicador-new {
						width: 22%;
					}
					td.dato-metodo-indicador {
						width: 24%;
						text-align: center;
					}
					td.dato-metodo-indicador-new {
						width: 18%;
						text-align: center;
					}
					td.dato-definicion-indicador-new {
						width: 19%;
						text-align: center;
					}
					td.dato-medio {
						width: 22%;
						text-align: center;
					}
					td.dato-tres {
						width: 33%;
						text-align: center;
					}
					td.dato-completo {
						width: 100%;
					}
					table.espacio {
						font-size: 18px;
						padding: 0px;
						margin: 0px;
					}
					td.izquierda {
						text-align: left;
					}
					td.derecha {
						text-align: right;
					}
					td.titulo-poa {
						width: 44%;
						text-align: center; 
						font-weight: bold;
						font-size: 15px;
					}
					td.imagen-poa {
						width: 30%;
					}
					td.cursiva {
						font-style: italic;
					}
					td.dato-firma, td.dato-firma-2 {
						width: 50%;
						text-align: center; 
					}
					td.dato-responsable, td.dato-titular {
						width: 50%;
						text-align: center; 
					}
				</style>
				<table class="tabla logo" cellpadding="2" style="width: 100%;">
					<tr>
						<td class="imagen-poa"><!--<img src="'.base_url('img/logo-te-sin-fondo_0.png').'" height="32" />--></td>
						<td class="titulo-poa">PROGRAMA OPERATIVO ANUAL '.$projectInfo->ejercicio.'<br /><span style="font-size: 15px;">FICHA DESCRIPTIVA DE PROYECTO</span></td>
					</tr>
				</table>
				<table class="espacio"><tr><td></td></tr></table>
				<table class="tabla identificacion-responsables" cellpadding="2">
					<tr>
						<td colspan="2" class="borde titulo-tabla">Identificación de Responsables</td>
						<td></td>
					</tr>
					<tr>
						<td class="borde encabezado encabezado-dos" valign="middle">Unidad Responsable:</td>
						<td colspan="2" class="borde dato">'.$projectInfo->numero_urg.' - '.$projectInfo->nombre_urg.'</td>
					</tr>
					<tr>
						<td class="borde encabezado encabezado-dos" valign="middle">Responsable Operativo:</td>
						<td colspan="2" class="borde dato">'.$projectInfo->numero_ro.' - '.$projectInfo->nombre_ro.'</td>
					</tr>
					<tr>
						<td class="borde encabezado encabezado-dos" valign="middle">Responsable de la ficha:</td>
						<td colspan="2" class="borde dato">'.$projectInfo->responsable_ficha.'</td>
					</tr>
				</table>
				<table class="espacio"><tr><td></td></tr></table>
				<table class="tabla identificacion-programatica" cellpadding="2">
					<tr>
						<td rowspan="2" class="borde encabezado encabezado-cuatro">Identificación Programática</td>
						<td class="borde encabezado encabezado-uno">UR</td>
						<td class="borde encabezado encabezado-uno">RO</td>
						<td class="borde encabezado encabezado-uno">P</td>
						<td class="borde encabezado encabezado-uno">SP</td>
						<td class="borde encabezado encabezado-uno">PY</td>
					</tr>
					<tr>
						<td class="borde dato-uno">'.$projectInfo->numero_urg.'</td>
						<td class="borde dato-uno">'.$projectInfo->numero_ro.'</td>
						<td class="borde dato-uno">'.$projectInfo->numero_programa.'</td>
						<td class="borde dato-uno">'.$projectInfo->numero_subprograma.'</td>
						<td class="borde dato-uno">'.$projectInfo->numero.'</td>
					</tr>
				</table>
				<table class="espacio"><tr><td></td></tr></table>
				<table class="tabla descripcion-claves" cellpadding="2">
					<tr>
						<td colspan="5" class="borde encabezado encabezado-completo">Descripción de claves</td>
					</tr>
					<tr>
						<td class="borde encabezado encabezado-dos">Programa</td>
						<td class="borde encabezado encabezado-medio">Subprograma</td>
						<td class="borde encabezado encabezado-tres">Proyecto</td>
						<td class="borde encabezado encabezado-uno">TP</td>
						<td class="borde encabezado encabezado-uno">Versión</td>
					</tr>
					<tr>
						<td class="borde dato-dos">'.$projectInfo->numero_programa.' - '.$projectInfo->nombre_programa.'</td>
						<td class="borde dato-medio">'.$projectInfo->numero_subprograma.' - '. $projectInfo->nombre_subprograma.'</td>
						<td class="borde dato-tres">'.$projectInfo->numero.' - '.$projectInfo->nombre.'</td>
						<td class="borde dato-uno">'.$projectInfo->tipo.'</td>
						<td class="borde dato-uno">'.$projectInfo->version.'</td>
					</tr>
				</table>
				<table class="espacio"><tr><td></td></tr></table>
				'.$tabla_objetivo.'  
				<table class="tabla justificacion-proyecto" cellpadding="2">
					<tr>
						<td colspan="2" class="borde titulo-tabla">Justificación del Proyecto</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="3" class="borde dato-completo">'.$projectInfo->justificacion.'</td>
					</tr>
				</table>
				<table class="espacio"><tr><td></td></tr></table>
				<table class="tabla descripcion-proyecto" cellpadding="2">
					<tr>
						<td colspan="2" class="borde titulo-tabla">Descripción y Alcance del Proyecto</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="3" class="borde dato-completo">'.$projectInfo->descripcion.'</td>
					</tr>
				</table>
				<table class="espacio"><tr><td></td></tr></table>'
				.$tabla_meta_principal.''
				.$tabla_meta_complementaria.''
				.$tabla_indicadores.''
				.$tabla_acciones_sustantivas.''
				.$tabla_derechos_humanos.''
				.$tabla_equidad_genero.'
				<table class="tabla periodo-ejecucion" cellpadding="2">
					<tr>
						<td rowspan="4" class="borde encabezado encabezado-periodo izquierda">Periodo de Ejecución del Proyecto</td>
						<td class="borde encabezado encabezado-mes-periodo">ENE</td>
						<td class="borde encabezado encabezado-mes-periodo">FEB</td>
						<td class="borde encabezado encabezado-mes-periodo">MAR</td>
						<td class="borde encabezado encabezado-mes-periodo">ABR</td>
						<td class="borde encabezado encabezado-mes-periodo">MAY</td>
						<td class="borde encabezado encabezado-mes-periodo">JUN</td>
					</tr>
					<tr>
						<td class="borde dato-mes-periodo">'.$periodo_array['enero'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['febrero'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['marzo'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['abril'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['mayo'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['junio'].'</td>
					</tr>
					<tr>
						<td class="borde encabezado encabezado-mes-periodo">JUL</td>
						<td class="borde encabezado encabezado-mes-periodo">AGO</td>
						<td class="borde encabezado encabezado-mes-periodo">SEP</td>
						<td class="borde encabezado encabezado-mes-periodo">OCT</td>
						<td class="borde encabezado encabezado-mes-periodo">NOV</td>
						<td class="borde encabezado encabezado-mes-periodo">DIC</td>
					</tr>
					<tr>
						<td class="borde dato-mes-periodo">'.$periodo_array['julio'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['agosto'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['septiembre'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['octubre'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['noviembre'].'</td>
						<td class="borde dato-mes-periodo">'.$periodo_array['diciembre'].'</td>
					</tr>
				</table>
				<table class="espacio"><tr><td></td></tr></table>
				<table class="tabla periodo-ejecucion" cellpadding="2">
					<tr>
						<td class="borde encabezado encabezado-fecha derecha">FECHA DE ELABORACIÓN DE LA FICHA:</td>
						<td class="borde encabezado encabezado-fecha-2">'.$fecha.'</td>
					</tr>
				</table>
				<table class="espacio"><tr><td></td></tr></table>
				<table class="tabla firmas" cellpadding="2">
					<tr>
						<td class="borde-inferior dato-firma"><br /><br /><br /><br /><br /><br />'.$projectInfo->nombre_responsable_operativo.'<br />'.$projectInfo->cargo_responsable_operativo.'</td>
						<td class="borde-inferior dato-firma-2"><br /><br /><br /><br /><br /><br /><br />'.$projectInfo->nombre_titular.'</td>
					</tr>
					<tr>
						<td class="borde-superior dato-responsable">'.$leyenda_nombre_cargo_firma_ro.'</td>
						<td class="borde-superior dato-titular">Nombre y Firma del Titular de la Unidad Responsable</td>
					</tr>
				</table>';

			// output the HTML content
			$pdf->SetXY(10, 5);
			$pdf->Image('img/logo-te-sin-fondo_0.png', '', '', 30, 0, '', '', 'L', false, 300, '', false, false, 1, false, false, false);
			$pdf->writeHTML($html, true, false, true, false, '');
		}

		$pdf->Output(FCPATH . $dir . $filename, 'F');

		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$filename.'"');

		$salida = base_url('fichasPOA/'.$filename);
		// $file = readfile($salida);

		$this->load->helper('url');
		echo json_encode(array(
			'path' => FCPATH . $dir . $filename,
			'url' => base_url($dir . $filename),
			'file' => $salida
		));
	}

}
