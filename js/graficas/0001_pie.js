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

});
