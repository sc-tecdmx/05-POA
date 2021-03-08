function obtenerMetasCollapse(proyecto_id, mes) {
	return $.get(base_url + 'reportes/seguimiento/obtenerMetasCollapse/'+proyecto_id+'/'+mes);
}

$(document).ready(function() {
    $('#tablaConsolidado').empty();
    $('#tablaAvanceMensual').empty();

	$("#monthSel").change(function () {
		var id = $('#monthSel').val();
		$.ajax({
			url: base_url+'reportes/seguimiento/getDataMetas/' + id,
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			method: "GET",
			success: function(data) {
				var colors = Highcharts.getOptions().colors;
				$.each(colors, function(i, color) {
					colors[i] = {
						linearGradient: { x1: 0, y1: 1, x2: 0, y2: 0},
						stops: [
							[0, '#A696C0'],
							[1, '#4D2C82'/*Highcharts.Color(color).brighten(-0.3).get('rgb')*/]
						]
					};
				});
				var chart = new Highcharts.Chart({
					chart: {
						height: data.altura,
						type: 'bar',
						renderTo: 'chart-avance',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					colors: colors,
					title: {
						text: 'Avance de Proyectos'
					},
					subtitle: {
						text: 'Enero - ' + data.mes
					},
					yAxis: {
						title: {
							text: 'Porcentaje de avance'
						},
						gridLineColor: '#d3d3d3'
					},
					xAxis: {
						categories: data.clave,
						labels: {
							style: {
								color: '#4D2C82'
							}
						}
					},
					plotOptions: {
						column: {}
					},
					legend: {
						borderWidth: 0
					},
					tooltip: {
						formatter: function() {
							if (this.point.y == -2) {
								return '' + this.point.name + ': <b>No aplica</b>'
							}
							return '' + this.point.name + ': <b>' + this.point.y + '%</b>';
						}
					},
					series: [{
						type: 'column',
						name: 'Proyectos',
						data: data.contenido,
						dataLabels: {
							shadow: true,
							borderRadius: 5,
							x: 5,
							backgroundColor: 'rgba(255, 255, 255, 0.7)',
							borderWidth: 1,
							borderColor: '#aaa',
							enabled: true,
							color: '#4D2C82',
							style: {
								//fontWeight: 'bold'
							},
							formatter: function() {
								if (this.y == -2) {
									return 'N/A';
								}
								return this.y + '%';
							}
						}
					}]
				});
			}
		})
	})

	$('#tree-programas').treeview({
		animated: "fast",
		collapsed: true,
		unique: true,
		toggle: function() {
			if ($(this).hasClass('my-proyecto')) {
				$(this).removeClass('my-proyecto');
				var $ul = $(this).children('ul');
				var proyecto_id = $(this).attr('rel');
				var mes = $(this).attr('rev');

				$.when(obtenerMetasCollapse(proyecto_id, mes)).then(function(data) {
					$ul.html(data);
					$ul.treeview({
						animated: "fast",
						collapsed: true,
						unique: true
					});
				});
			}
		}
	});

    $('#seguimientOption').on('change', function () {
        const option = $('#seguimientOption').val()
        if(option == '1'){
            var direccion = base_url+'reportes/seguimiento/getConsolidado/'
        } else if(option == '2'){
            var direccion = base_url+'reportes/seguimiento/getAvanceMensual/'
        } else if(option == '3'){
            var direccion = base_url+'reportes/seguimiento/getAvanceTrimestral/'
        } else if(option == '4'){
            var direccion = base_url+'reportes/seguimiento/getMatriz/'
        } else if(option == '5'){
            var direccion = base_url+'reportes/seguimiento/getAvanceIndicadores/'
        } else if(option == '6'){
            var direccion = base_url+'reportes/seguimiento/getAvanceLapdhdf/'
        }
        $.ajax({
            url: direccion,
            method: "GET",
            success: function(data) {
                if(data != '400'){
                    $('#proyectosSeguimiento').html(data)
                } else {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Hubo un problema al cargar el àrea, intentalo nuevamente'
                    });
                }

            },
            error: function(data) {
                console.log(data);
            }
        })
    })

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
            url: base_url+'reportes/seguimiento/getConsolidadoRespuesta/'+meta,
            method: "GET",
            success: function(data) {
                $('#tablaConsolidado').html(data)
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    /**
     * Funciones para el Avance Mensual
     */
    $('#mesAvanceMensual').on('change', function () {
    	$('#colExportExcelMonthly').css('display', 'block')
	})

    $('#programasAvanceMensual').on('change', function () {
        $('#subprogramasAvanceMensual').empty();
        $('#subprogramasAvanceMensual').append('<option value=""> - Seleccione un subprograma - </option>');
        var programa = $('#programasAvanceMensual').val()
        $.ajax({
            url: base_url+'reportes/seguimiento/getConsolidadoSubprogramas/'+programa,
            method: "GET",
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                const tot = data.subprograma_id.length;
                for(let i = 0; i < tot; i++){
                    $('#subprogramasAvanceMensual').append('<option value="'+data.subprograma_id[i]+'">'+data.nombre[i]+'</option>');
                }

            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    $('#subprogramasAvanceMensual').on('change', function () {
        $('#proyectosAvanceMensual').empty();
        $('#proyectosAvanceMensual').append('<option value=""> - Seleccione un proyecto - </option>');
        const subprograma = $('#subprogramasAvanceMensual').val()
        $.ajax({
            url: base_url+'reportes/seguimiento/getConsolidadoProyectos/'+subprograma,
            method: "GET",
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                // console.log(data);
                const tot = data.id.length;
                for(let i = 0; i < tot; i++){
                    $('#proyectosAvanceMensual').append('<option value="'+data.id[i]+'">'+data.clave[i]+' '+data.nombre[i]+'</option>');
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    $('#tiposMetasAvanceMensual').on('change', function () {
        $('#metaAvanceMensual').empty();
        $('#metaAvanceMensual').append('<option value=""> - Seleccione una meta - </option>');
        const tipo = $('#tiposMetasAvanceMensual').val()
        const proyecto = $('#proyectosAvanceMensual').val()
        $.ajax({
            url: base_url+'reportes/seguimiento/getConsolidadoMetas/'+tipo+'/'+proyecto,
            method: "GET",
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                // console.log(data);

                const tot = data.meta.length;
                for(let i = 0; i < tot; i++){
                    $('#metaAvanceMensual').append('<option value="'+data.meta[i]+'">'+data.nombre[i]+'</option>');
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    /* $('#metaAvanceMensual').on('change', function () {
        const meta = $('#metaAvanceMensual').val()
        $.ajax({
            url: base_url+'reportes/seguimiento/getConsolidadoRespuesta/'+meta,
            method: "GET",
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                // console.log(data);
                const tot = data.meta.length;
                for(let i = 0; i < tot; i++){
                    $('#metaAvanceMensual').append('<option value="'+data.meta[i]+'">'+data.nombre[i]+'</option>');
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }) */

    $('#metaAvanceMensual').on('change', function () {
        const meta = $('#metaAvanceMensual').val()
        const mes = $('#mesAvanceMensual').val()
        $.ajax({
            url: base_url+'reportes/seguimiento/getAvanceMensualRespuesta/'+meta+'/'+mes,
            method: "GET",
            success: function(data) {
                // console.log(data);
                $('#tablaAvanceMensual').html(data)
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

	$('#exportExcelMonthly').on('click', function () {
		const mes = $('#mesAvanceMensual').val()
		window.open(base_url+'reportes/avanceMensual/index/'+mes, '_blank');
	})

    /**
     * Función para mostrar el avance trimestral y acumulado
     */
    $('#trimestreAvanceTrimestral').on('change', function () {
        const trimestre = $('#trimestreAvanceTrimestral').val()
		window.open(base_url+'reportes/avanceTrimestral/index/'+trimestre, '_blank');
        /* $.ajax({
            url: base_url+'reportes/avanceTrimestral/index/'+trimestre,
            method: "GET",
            success: function(data) {
                window.open(base_url+'reportes/avanceTrimestral/index/'+trimestre, '_blank');
            },
            error: function(data) {
                console.log(data);
            }
        }) */
    })

    /**
     * Función para mostrar las opciones en matriz metas programadas y alcanzadas
     */
    $('#mesMatrizMetas').on('change', function () {
        const mes = $('#mesMatrizMetas').val()
		window.open(base_url+'reportes/matrizMetas/index/'+mes, '_blank');
        /* $.ajax({
            url: base_url+'reportes/matrizMetas/matrizMetas/'+mes,
            method: "GET",
            success: function(data) {
                window.open(base_url+'reportes/matrizMetas/matrizMetas/index/'+mes, '_blank');
            },
            error: function(data) {
                console.log(data);
            }
        }) */
    })

    /**
     * Función para mostrar las opciones en indicadores
     */
    $('#trimestreAvanceIndicadores').on('change', function () {
        const mes = $('#trimestreAvanceIndicadores').val()
		window.open(base_url+'reportes/indicadores/index/'+mes, '_blank');
    })

});
