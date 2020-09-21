function getDatos()
{
    $.ajax({
        url: base_url+'configuracion/configuracion/getInfoConfiguracionElaboracion/',
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            console.log(data)
            if(data.habilitado == 'si'){
                $('#habilitarElaboracion').prop('checked', true)
            }
            if(data.edicion == 'si'){
                $('#editElaboracion').prop('checked', true)
            }
        },
        error: function(data) {
            console.log(data);
        }
    })
}

$(document).ready(function () {
    getDatos()

    $("input[name=detalles]").on('change', function () {
        if($("input[name=detalles]").val() == "captura_global"){
            $("#activar").style.display = 'block';
        }
    });

    $('#configurarElaboracion').on('click', function () {
        var ejercicio = $('#ejercicio').val()
        if($('#habilitarElaboracion').prop('checked')){
            var habilitar = 'si'
        } else {
            var habilitar = 'no'
        }
        if($('#editElaboracion').prop('checked')){
            var edicion = 'si'
        } else {
            var edicion = 'no'
        }
        $.ajax({
            url: base_url+'configuracion/configuracion/elaboracion',
            method: "POST",
            data: { ejercicio, habilitar, edicion },
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
                }, 5000);
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $("[name='my-checkbox']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });

    $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
        console.log(this); // DOM element
        console.log(event); // jQuery event
        console.log(state); // true | false
        var estatus = state === true ? 'si' : 'no'
        var ejercicio = $('#anio').val();
        /* $.ajax({
            url: base_url+'configuracion/configuracion/putElaboracionPoa',
            method: "POST",
            data: { ejercicio, estatus },
            success: function(data) {
                console.log(data)
                // location.reload()
            },
            error: function(data) {
                console.log(data);
            }
        }) */
    });
});
