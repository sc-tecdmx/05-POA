function getDatos()
{
    $.ajax({
        url: base_url+'configuracion/prueba/getInfoConfiguracionSeguimiento/',
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            console.log(data)
            if(data.edicion == 'si'){
                $('#habilitarSeguimiento').prop('checked', true)
            }
            if(data.captura == 'global'){
                $('#capturag').prop('checked', true)
            } else if(data.captura == 'especifica'){
                $('#capturae').prop('checked', true)
            }
            $('#ejercicio').selectpicker('val', data.ejercicio)
            $('#ultimo_mes_consulta').selectpicker('val', data.consulta)
            $('#ultimo_mes_seguimiento').selectpicker('val', data.visible)
            $.each(data.meses, function(i,m){
                $('#CustomCheck'+m).prop('checked', true)
            })
        },
        error: function(data) {
            console.log(data);
        }
    })
}

$(document).ready(function () {

    getDatos()

    $('#btnConfigurarSeguimiento').on('click', function (){
        var ejercicio = $('#ejercicio').val()
        var captura = $('input:radio[name=captura]:checked').val()
        var ultimoMesSeguimiento = $('#ultimo_mes_seguimiento').val()
        var ultimoMesConsulta = $('#ultimo_mes_consulta').val()
        var meses = []
        for(var i = 1; i <= 12; i++){
            if($('#CustomCheck'+i).is(':checked')){
                meses.push('1')
            } else {
                meses.push('0')
            }
        }
        console.log(meses)
        /* if($('#CustomCheck1').is(':checked')){
            var ene = 'si'
        } else {
            var ene = 'no'
        }
        if($('#CustomCheck2').is(':checked')){
            var feb = 'si'
        } else {
            var feb = 'no'
        }
        if($('#CustomCheck3').is(':checked')){
            var mar = 'si'
        } else {
            var mar = 'no'
        }
        if($('#CustomCheck4').is(':checked')){
            var abr = 'si'
        } else {
            var abr = 'no'
        }
        if($('#CustomCheck5').is(':checked')){
            var may = 'si'
        } else {
            var may = 'no'
        }
        if($('#CustomCheck6').is(':checked')){
            var jun = 'si'
        } else {
            var jun = 'no'
        }
        if($('#CustomCheck7').is(':checked')){
            var jul = 'si'
        } else {
            var jul = 'no'
        }
        if($('#CustomCheck8').is(':checked')){
            var ago = 'si'
        } else {
            var ago = 'no'
        }
        if($('#CustomCheck9').is(':checked')){
            var sep = 'si'
        } else {
            var sep = 'no'
        }
        if($('#CustomCheck10').is(':checked')){
            var oct = 'si'
        } else {
            var oct = 'no'
        }
        if($('#CustomCheck11').is(':checked')){
            var nov = 'si'
        } else {
            var nov = 'no'
        }
        if($('#CustomCheck12').is(':checked')){
            var dic = 'si'
        } else {
            var dic = 'no'
        } */
        if($('#habilitarSeguimiento').prop('checked')){
            var habilitar = 'si'
        } else {
            var habilitar = 'no'
        }
        $.ajax({
            url: base_url+'configuracion/prueba/configuracionSeguimiento',
            method: "POST",
            data: { ejercicio, habilitar, captura, meses, ultimoMesSeguimiento, ultimoMesConsulta },
            success: function(data) {
                console.log(data)
                swal.fire({
                    icon: 'success',
                    title: 'La configuración ha sido aplicada correctamente',
                    showConfirmButton: false,
                    timer: 4500
                })
                setTimeout(function () {
                    location.reload()
                }, 1000);
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    $('input:radio[name=captura]').on('click', function () {
        if($('input:radio[name=captura]:checked').val() == 'especifica'){
            $('#usuarios').css('display','block')
        } else {
            $('#usuarios').css('display','none')
        }
    })
})
