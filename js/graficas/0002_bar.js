$(document).ready(function() {
    $('#tablaConsolidado').empty();
    $('#tablaAvanceMensual').empty();

    $("#monthSel").change(function () {
        var id = $('#monthSel').val();
        //console.log(id);
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
                console.log(arr0);
                var myChart = echarts.init(document.getElementById('bar'));

                // specify chart configuration item and data
                var option = {
                    title: {
                        text: 'Avance',
                        //subtext: ''
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    legend: {
                        data: ['% de avance de metas']
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'value',
                        boundaryGap: [0, 0.01]
                    },
                    yAxis: {
                        type: 'category',
                        data: arr
                    },
                    series: [
                        {
                            name: '% de avance de metas',
                            type: 'bar',
                            data: arr0
                        },
                        /*
                        {
                            name: '2012年',
                            type: 'bar',
                            data: [19325, 23438, 31000, 121594, 134141, 681807]
                        }
                         */
                    ]
                };

// use configuration item and data specified to show chart
                myChart.setOption(option);
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
