/*
$(document).ready(function() {
    var url = window.location.pathname;
    var id = url.substring(url.lastIndexOf('/') + 1);
    $.ajax({
        url: base_url+'inicio/seguimiento/obtenerPesos/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            console.log(data);
            var color = ['#e1d8ea', '#c4b3d5', '#a68fc0', '#896bab', '#6b4996', '#4c2882', '#4b0082'];
            var bordercolor = ['rgba(255,99,132,1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];

            var arreglo = [];
            for(var i = 0; i < data.name.length; i++){
                arreglo[i] = color[i];
            }

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'pie',

                // The data for our dataset
                data: {
                    labels: data.name,
                    datasets: [{
                        label: 'Pesos',
                        backgroundColor: arreglo,
                        borderColor: 'rgb(234, 190, 63)',
                        data: data.data
                    }]
                },

                // Configuration options go here
                options: {}
            });
        },
        error: function(data) {
            console.log(data);
        }
    });

    $.ajax({
        url: base_url+'inicio/seguimiento/obtenerAvances/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var color = ['#e1d8ea', '#c4b3d5', '#a68fc0', '#896bab', '#6b4996', '#4c2882'];
            var bordercolor = ['rgba(255,99,132,1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];

            var objeto = new Object();
            const arreglo = [];

            for(var i = 0; i < data.name.length; i++){
                var objeto = new Object();
                objeto.label = data.name[i];
                objeto.backgroundColor = color[i];
                objeto.data = Object.values(data.datos[i]);
                arreglo.push(objeto);
            }

            var data = {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                datasets: arreglo
            };

            var ctx = document.getElementById('chartProgress').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});
*/

$(document).ready(function() {
    var url = window.location.pathname;
    var id = url.substring(url.lastIndexOf('/') + 1);
    $.ajax({
        url: base_url+'inicio/seguimiento/obtenerPesos/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            //console.log(data);
            var arr = [];
            console.log(arr)
            data.forEach(function(e, i){
                arr.push(e.name);
            });

            var myChart = echarts.init(document.getElementById('pie'));

            var option = {
                title: {
                    text: 'Pesos',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)'
                },
                legend: {
                    top:50,
                    orient: 'vertical',
                    left: 'left',
                    data: arr
                },
                series: [
                    {
                        name: 'Proyectos',
                        type: 'pie',
                        radius: '50%',
                        center: ['40%', '75%'],
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

    $.ajax({
        url: base_url+'inicio/seguimiento/obtenerAvances/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var color = ['#e1d8ea', '#c4b3d5', '#a68fc0', '#896bab', '#6b4996', '#4c2882'];
            var bordercolor = ['rgba(255,99,132,1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];

            var objeto = new Object();
            const arreglo = [];

            for(var i = 0; i < data.name.length; i++){
                var objeto = new Object();
                objeto.label = data.name[i];
                objeto.backgroundColor = color[i];
                objeto.data = Object.values(data.datos[i]);
                arreglo.push(objeto);
            }

            var data = {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                datasets: arreglo
            };

            var ctx = document.getElementById('chartProgress').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});

