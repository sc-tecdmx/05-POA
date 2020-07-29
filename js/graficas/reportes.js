$(document).ready(function() {
    $.ajax({
        url: base_url+'reportes/getData',
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            console.log(data)
            var color = ['#e1d8ea', '#c4b3d5', '#a68fc0', '#896bab', '#6b4996', '#4c2882', '#4b0082'];

            var objeto = new Object();
            const arreglo = [];

            for(var i = 0; i < data.label.length; i++){
                arreglo[i] = color[i];
            }

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'pie',

                // The data for our dataset
                data: {
                    labels: data.label,
                    datasets: [{
                        label: 'Programas',
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

    /* var ctx = document.getElementById('myChart').getContext('2d');
    var myDoughnutChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: [10, 20, 30],
                backgroundColor: [
                    "#FF6384",
                    "#63FF84",
                    "#84FF63"
                ]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Red',
                'Yellow',
                'Blue'
            ]
        },
    }); */

    /* var url =  "reportes/getData";
    $.ajax({
        type: 'GET',
        url: url,
        success: function(resp) {
            console.log(JSON.parse(resp));
            $.each(JSON.parse(resp), function(i, o) {
                console.log(resp[i]);
              if(o.name) {
                  resp[i].name = toString(o.name)
              }
              if(o.y) {
                  o.y = parseFloat(o.y)
              }
            });
            console.log(resp);

            $('#pruebag').highcharts({
                chart: {
                    renderTo: 'pruebag',
                    type: 'pie',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Browser market shares in January, 2018'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: resp
                }]
            })
            /*console.log(JSON.parse(resp));
            options.series[0].data = resp;
            var chart = new Highcharts.Chart(options);
        }
    }); */

    /* $.getJSON(url,  function(data) {
        console.log("entre");
        options.series[0].data = data;
        console.log(data.nombre);
        var chart = new Highcharts.Chart(options);
    }); */
});
