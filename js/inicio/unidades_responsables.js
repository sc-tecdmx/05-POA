function editaUnidadResponsable(id) {
    $('#btnEditUnidad').css('display','block');
    $.ajax({
        url: base_url+'inicio/unidades_responsables/getUnidadResponsable/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            $('#numero').val(data.numero)
            $('#nombre').val(data.nombre)
            $('#idUnidadResponsable').val(id)
            $('#unidadesResponsablesGastosModal').modal('show')
        },
        error: function(data) {
            console.log(data);
        }
    })
}

function eliminaUnidadResponsable(id) {
    Swal.fire({
        title: '¿Estas seguro de eliminar esta unidad responsable?',
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
                url: base_url+'inicio/info/deleteUnidadResponsable',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'La unidad responsable ha sido eliminada con éxito.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    })
}

$(document).ready(function(){

    $('#tabla_unidades').DataTable({
        "language": {
            "url": "../js/spanish.json"
        }
    });

    $('#addUnidadResponsable').on('click', function () {
        $('#unidadesResponsablesGastosModal').modal('show')
        $('#btnAddUnidad').css('display','block');
    })

    $('#btnCancelUnidad').on('click', function () {
        $('#unidadesResponsablesGastosModal').modal('hide')
        $('#btnAddUnidad').css('display','none');
        $('#btnEditUnidad').css('display','none');
    })

    $('#btnAddUnidad').on('click', function () {
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        $.ajax({
            url: base_url+'inicio/unidades_responsables/postUnidadResponsable',
            method: "POST",
            data: { numero, nombre },
            success: function(data) {
                if(data === '400'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número que ingresaste ya fue registrado, por favor cambialo'
                    });
                }else {
                    swal.fire({
                        icon: 'success',
                        title: 'La unidad responsable del gasto ha sido registrada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnAddUnidad').css('display', 'block')
                    $('#unidadesResponsablesGastosModal').modal('hide')
                    setTimeout(function () {
                        window.location.href = 'unidades_responsables'
                    }, 1000)
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $('#btnEditUnidad').on('click', function () {
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        var unidad = $('#idUnidadResponsable').val()
        $.ajax({
            url: base_url+'inicio/unidades_responsables/putUnidadResponsable',
            method: "POST",
            data: { numero, nombre, unidad },
            success: function(data) {
                if(data === '400'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número que ingresaste ya fue registrado, por favor cambialo'
                    });
                }else {
                    swal.fire({
                        icon: 'success',
                        title: 'La unidad responsable del gasto ha sido actualizada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnEditUnidad').css('display', 'block')
                    $('#unidadesResponsablesGastosModal').modal('hide')
                    setTimeout(function () {
                        location.reload()
                        // window.location.href = 'unidades_responsables'
                    },1000)

                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

})
