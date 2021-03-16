function obtenerMatrizColores () {
	return $.get(base_url + 'reportes/elaboracion/obtenerMatrizColores')
}

function obtenerGraficaProyectos (programa) {
	return $.get(base_url + 'reportes/elaboracion/getData/'+programa);
}

$(document).ready(function() {
    $.ajax({
        url: base_url+'reportes/elaboracion/getData',
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
			Highcharts.chart('chart', {
				colors: ['#C4B9D5', '#B5A7CB', '#A696C0', '#9E8DBB', '#8872AC', '#826CA8', '#6B4F97', '#5C3E8C'],
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'Proyectos por programa'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y}</b>'
				},
				accessibility: {
					point: {
						valueSuffix: '%'
					}
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.y}'
						},
						events: {
							click: function (program) {
								console.log(program)
							}
						}
					}
				},
				series: [{
					name: 'Proyectos',
					colorByPoint: true,
					data: data
				}]
			});
		},
        error: function(data) {
            console.log(data);
        }
    });

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
				// window.location.href = response.url;
				/* if(response === '422'){
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'El número alcanzado es mayor al programado.'
					});
				} else {
					if( response.url ){
						window.location.href = response.url;
					}
				} */
			},
			error: function(data) {
				console.log(data);
			}
		})
	})
});
