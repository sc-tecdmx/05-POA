$(document).ready(function() {
    $.ajax({
        url: base_url+'reportes/elaboracion/getData',
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var arr = [];
            data.forEach(function(e, i){
                arr.push(e.name);
            });

            var myChart = echarts.init(document.getElementById('pie'));

            var option = {
                title: {
                    text: 'Proyectos',
                    subtext: '',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: arr
                },
                series: [
                    {
                        name: 'Proyectos',
                        type: 'pie',
                        radius: '50%',
                        center: ['40%', '70%'],
                        data: data,
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };

            // use configuration item and data specified to show chart
            myChart.setOption(option);

        },
        error: function(data) {
            console.log(data);
        }
    });

	/* var chart = new Highcharts.Chart({
		colors: ['#C4B9D5', '#B5A7CB', '#A696C0', '#9E8DBB', '#8872AC', '#826CA8', '#6B4F97', '#5C3E8C'],
		chart: {
			renderTo: 'chart',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: 'Proyectos por programas'
		},
		tooltip: {
			formatter: function() {
				var proy = "proyecto";
				if (this.point.y > 1) {
					proy = 'proyectos';
				}
				return '' + this.point.name + ': <b>' + this.point.y + ' ' + proy + '</b>';
			}
		},
		plotOptions: {
			series: {
				//animation: false,
				events: {
					click: function() {
						//alert('xxx');
					}
				}
			},
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function() {
						return '' + this.point.name + ': <b>' + this.point.y + '</b>';
					}
				},
				point: {
					events: {
						click: function() {
							nombre_programa = this.name;
							$.when(obtenerMatrizColores()).then(function(colores) {
								$.when(obtenerGraficaProyectos('php/menu/reportes/graficas/obtener_grafica_proyectos.php?nombre=' + nombre_programa)).then(function(data) {
									var chart = new Highcharts.Chart({
										colors: colores,
										chart: {
											renderTo: 'chart',
											plotBackgroundColor: null,
											plotBorderWidth: null,
											plotShadow: false,
											height: 380,
											width: 295,
											animation: false,
											spaceRight: 0,
											spaceLeft: 0,
											marginLeft: 0,
											events: {
												load: function() {
													////
													$('#chart-2, #regresar-chart-1').remove();
													$('#chart').prepend('<div id="regresar-chart-1">&laquo; Regresar</div>');
													$('#chart').append('<div id="chart-2"></div>');
													$.when(obtenerMatrizColores()).then(function(colores) {
														$.when(obtenerGraficaProyectos('php/menu/reportes/graficas/obtener_grafica_proyectos_subprogramas.php?nombre=' + nombre_programa)).then(function(data) {
															var chart = new Highcharts.Chart({
																colors: colores,
																chart: {
																	renderTo: 'chart-2',
																	plotBackgroundColor: null,
																	plotBorderWidth: null,
																	plotShadow: false,
																	width: 800
																},
																title: {
																	text: 'Programa: ' + nombre_programa + ' - Proyectos por subprogramas'
																},
																tooltip: {
																	formatter: function() {
																		var proy = "proyecto";
																		if (this.point.y > 1) {
																			proy = 'proyectos';
																		}
																		return '' + this.point.name + ': <b>' + this.point.y + ' ' + proy + '</b>';
																	}
																},
																plotOptions: {
																	pie: {
																		allowPointSelect: true,
																		cursor: 'pointer',
																		dataLabels: {
																			enabled: true,
																			color: '#000000',
																			connectorColor: '#000000',
																			formatter: function() {
																				return '' + this.point.name + ': <b>' + this.point.y + '</b>';
																			}
																		},
																		point: {
																			events: {
																				click: function() {
																					//////
																				}
																			}
																		}
																	}
																},
																series: [{
																	type: 'pie',
																	name: 'Browser share',
																	data: data
																}]
															});
														});
													}); /////
												}
											}
										},
										title: {
											text: 'Proyectos por programas'
										},
										legend: {
											layout: 'vertical',
											borderWidth: 0,
											margin: 5,
											labelFormatter: function() {
												return this.name + ': <b>' + this.y + '</b>';
											}
										},
										tooltip: {
											enabled: false
										},
										plotOptions: {
											pie: {
												allowPointSelect: true,
												cursor: 'pointer',
												dataLabels: {
													enabled: true,
													color: '#000000',
													connectorColor: '#000000',
													formatter: function() {
														return '' + this.point.name + ': <b>' + this.point.y + '</b>';
													}
												},
												point: {
													events: {
														click: function() {
															var nombre = this.name;
															$('#chart-2').remove();
															$('#chart').append('<div id="chart-2"></div>');
															$.when(obtenerMatrizColores()).then(function(colores) {
																$.when(obtenerGraficaProyectos('php/menu/reportes/graficas/obtener_grafica_proyectos_subprogramas.php?nombre=' + nombre)).then(function(data) {
																	var chart = new Highcharts.Chart({
																		colors: colores,
																		chart: {
																			renderTo: 'chart-2',
																			plotBackgroundColor: null,
																			plotBorderWidth: null,
																			plotShadow: false
																		},
																		title: {
																			text: 'Programa: ' + nombre + ' - Proyectos por subprogramas'
																		},
																		tooltip: {
																			formatter: function() {
																				var proy = "proyecto";
																				if (this.point.y > 1) {
																					proy = 'proyectos';
																				}
																				return '' + this.point.name + ': <b>' + this.point.y + ' ' + proy + '</b>';
																			}
																		},
																		plotOptions: {
																			pie: {
																				allowPointSelect: true,
																				cursor: 'pointer',
																				dataLabels: {
																					enabled: true,
																					color: '#000000',
																					connectorColor: '#000000',
																					formatter: function() {
																						return '' + this.point.name + ': <b>' + this.point.y + '</b>';
																					}
																				},
																				point: {
																					events: {
																						click: function() {
																							//////
																						}
																					}
																				}
																			}
																		},
																		series: [{
																			type: 'pie',
																			name: 'Browser share',
																			data: data
																		}]
																	});
																});
															}); /////
														}
													}
												},
												dataLabels: {
													enabled: false
												},
												showInLegend: true
											},
											series: {
												//animation: false,
												events: {
													click: function() {
														//alert('xxx');
													}
												},
												visible: true
											}
										},
										series: [{
											pointPadding: 0,
											groupPadding: 0,
											type: 'pie',
											name: 'Browser share',
											data: data
										}]
									});
								});
							});
						}
					}
				}
			}
		},
		series: [{
			type: 'pie',
			name: 'Browser share',
			data: data
		}]
	}); */

    $('#tabla_proyectos').DataTable({
        "language": {
            "url": "../js/spanish.json"
        }
    });

	/**
	 * Funciones para obtener los select de Consolidado
	 */
	$('#programasConsolidado').on('change', function () {
		$('#subprogramasConsolidado').empty();
		$('#subprogramasConsolidado').append('<option value=""> - Seleccione uno - </option>');
		var programa = $('#programasConsolidado').val()
		$.ajax({
			url: base_url+'reportes/seguimiento/getConsolidadoSubprogramas/'+programa,
			method: "GET",
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			success: function(data) {
				const tot = data.subprograma_id.length;
				for(let i = 0; i < tot; i++){
					$('#subprogramasConsolidado').append('<option value="'+data.subprograma_id[i]+'">'+data.nombre[i]+'</option>');
				}

			},
			error: function(data) {
				console.log(data);
			}
		})
	})

	$('#subprogramasConsolidado').on('change', function () {
		$('#proyectosConsolidado').empty();
		$('#proyectosConsolidado').append('<option value=""> - Seleccione uno - </option>');
		const subprograma = $('#subprogramasConsolidado').val()
		$.ajax({
			url: base_url+'reportes/seguimiento/getConsolidadoProyectos/'+subprograma,
			method: "GET",
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			success: function(data) {
				// console.log(data);
				const tot = data.id.length;
				for(let i = 0; i < tot; i++){
					$('#proyectosConsolidado').append('<option value="'+data.id[i]+'">'+data.clave[i]+' '+data.nombre[i]+'</option>');
				}
			},
			error: function(data) {
				console.log(data);
			}
		})
	})

	$('#tiposMetasConsolidado').on('change', function () {
		$('#metaConsolidado').empty()
		$('#metaConsolidado').append('<option value=""> - Seleccione uno - </option>');
		const tipo = $('#tiposMetasConsolidado').val()
		const proyecto = $('#proyectosConsolidado').val()
		$.ajax({
			url: base_url+'reportes/seguimiento/getConsolidadoMetas/'+tipo+'/'+proyecto,
			method: "GET",
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			success: function(data) {
				// console.log(data);
				const tot = data.meta.length;
				for(let i = 0; i < tot; i++){
					$('#metaConsolidado').append('<option value="'+data.meta[i]+'">'+data.nombre[i]+'</option>');
				}
			},
			error: function(data) {
				console.log(data);
			}
		})
	})

	$('#metaConsolidado').on('change', function () {
		const meta = $('#metaConsolidado').val()
		$.ajax({
			// url: base_url+'reportes/seguimiento/getConsolidadoRespuesta/'+meta,
			url: base_url+'reportes/elaboracion/getAperturaProgramatica/'+meta,
			method: "GET",
			success: function(data) {
				$('#tablaConsolidado').html(data)
			},
			error: function(data) {
				console.log(data);
			}
		})
	})

	$('#construirPdf').on('click', function () {
		const fichas = document.getElementsByName('fichas[]')
		let selected = []
		for (var ficha of fichas) {
			if (ficha.checked)
				selected.push(ficha.value)
		}
		if (selected.length === 0) {
			swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'No has seleccionado ningún proyecto para generar las fichas.'
			});
			return
		}
		console.log(selected)
		$.ajax({
			url: base_url+'reportes/fichaPoaPdf/index',
			type: 'POST',
			data: { proyectos: selected },
			success: function(response) {
				console.log(response)
				if(response === '422'){
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'El número alcanzado es mayor al programado.'
					});
				} else {
					if( response.url ){
						window.location = response.url;
					}
				}
			},
			error: function(data) {
				console.log(data);
			}
		})
	})
});
