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
		console.log($('input:checkbox[name=fichas]').val())
	})
});
