function editarUnidadMedida(id)
{
    $('#btnEditUnidad').css('display','block');
    $.ajax({
        url: base_url+'inicio/unidades_medida/getUnidadMedida/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            if(data != '400'){
                $('#numero').val(data.numero)
                $('#nombre').val(data.nombre)
                $('#descripcion').val(data.descripcion)
                if(data.porcentajes == '1'){
                    $('#CustomCheck').prop('checked', true)
                }
                $('#idUnidadMedida').val(id)
                $('#unidadesMedidaModal').modal('show')
            } else {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Hubo un problema al cargar los datos del subprograna, intentalo nuevamente'
                });
            }

        },
        error: function(data) {
            console.log(data);
        }
    })
}

function eliminarMedida(id)
{
    Swal.fire({
        title: '¿Estas seguro de eliminar esta unidad de medida',
        text: "No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, elíminala!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        console.log(result)
        if (result.value) {
            $.ajax({
                url: base_url+'inicio/unidades_medida/deleteUnidadMedida',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'La unidad de medida ha sido eliminado con éxito.',
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
            });
        }
    })
}

$(document).ready(function(){

    $('#tabla_medidas').DataTable({
        "language": {
            "url": "../js/spanish.json"
        }
    });

    $('#addUnidadesMedida').on('click', function () {
        $('#unidadesMedidaModal').modal('show')
        $('#btnAddUnidad').css('display', 'block')
    })

    $('#btnCancelUnidad').on('click', function () {
        $('#unidadesMedidaModal').modal('hide')
        $('#btnAddUnidad').css('display', 'none')
        $('#btnEditUnidad').css('display', 'none')
    })

    $('#btnAddUnidad').on('click', function () {
        var descripcion = $('#descripcion').val()
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        if($('#CustomCheck').is(':checked')){
            var porcentajes = '1'
        } else {
            var porcentajes = '0'
        }
        $.ajax({
            url: base_url+'inicio/unidades_medida/postUnidadMedida',
            method: "POST",
            data: { descripcion, numero, nombre, porcentajes },
            success: function(data) {
                if(data == '400'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número que ingresaste ya fue registrado, por favor cambialo'
                    });
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'La unidad de medida ha sido agregada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnAddUnidad').css('display','none');
                    $('#unidadesMedidaModal').modal('hide');
                    setTimeout(function () {
                        location.reload()
                    }, 1000);
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    $('#btnEditUnidad').on('click', function () {
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        var descripcion = $('#descripcion').val()
        var unidad = $('#idUnidadMedida').val()
        if($('#CustomCheck').is(':checked')){
            var porcentajes = '1'
        } else {
            var porcentajes = '0'
        }
        console.log(porcentajes)
        $.ajax({
            url: base_url+'inicio/unidades_medida/putUnidadMedida',
            method: "POST",
            data: { descripcion, unidad, numero, nombre, porcentajes },
            success: function(data) {
                if(data == '400'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número que ingresaste ya fue registrado, por favor cambialo'
                    });
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'La unidad de medida ha sido actualizada con éxito.',
                        showConfirmButton: false,
                        timer: 4000
                    })
                    $('#btnEditUnidad').css('display','none');
                    $('#unidadesMedidaModal').modal('hide');
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

})
