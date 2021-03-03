$(document).ready(function() {
    $('#tablaConsolidado').empty();
    $('#tablaAvanceMensual').empty();

    $('#jstree').jstree()

	$('#jstree').on("changed.jstree", function (e, data){
		console.log(data.selected)
	})

	$('#demoButton').on('click', function () {
		$('#jstree').jstree(true).select_node('child_node_1');
		$('#jstree').jstree('select_node', 'child_node_1');
		$.jstree.reference('#jstree').select_node('child_node_1');
	});

    $("#monthSel").change(function () {
        var id = $('#monthSel').val();
        $.ajax({
            url: base_url+'reportes/seguimiento/getDataMetas/' + id,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            method: "GET",
            success: function(data) {
                var arr = [];
                var arr0 = [];
                data.forEach(function(e, i){
                    arr.push(e.name);
                    arr0.push(e.value);
                });

                var densityCanvas = document.getElementById("bar");

                var densityData = {
                    label: 'Avance de Metas del Mes ',
                    data: arr0,
                    borderWidth: 2,
                    hoverBorderWidth: 0,
                    backgroundColor: 'rgba(110, 0, 101, 1)'
                };

                var chartOptions = {
                    scales: {
                        yAxes: [{
                            barPercentage: 0.5
                        }]
                    },
                    elements: {
                        rectangle: {
                            borderSkipped: 'left',
                        }
                    }
                };

                var barChart = new Chart(densityCanvas, {
                    type: 'horizontalBar',
                    data: {
                        labels: arr,
                        datasets: [densityData],
                    },
                    options: chartOptions
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
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
