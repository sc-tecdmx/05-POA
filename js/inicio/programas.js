function editarPrograma(id) {
    $('#btnEditPrograma').css('display','block');
    $.ajax({
        url: base_url+'inicio/programas/getPrograma/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            if(data != '400'){
                $('#numero').val(data.numero)
                $('#nombre').val(data.nombre)
                $('#idPrograma').val(id)
                $('#programasModal').modal('show')
            } else {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Hubo un problema al cargar el programa, intentalo nuevamente'
                });
            }

        },
        error: function(data) {
            console.log(data);
        }
    })
}

function eliminarPrograma(id) {
    Swal.fire({
        title: '¿Estas seguro de eliminar este programa',
        text: "No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, elíminalo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        console.log(result)
        if (result.value) {
            $.ajax({
                url: base_url+'inicio/programas/deletePrograma',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'El programa ha sido eliminado con éxito.',
                        showConfirmButton: false,
                        timer: 1500
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

    $('#tabla_programas').DataTable({
        "language": {
            "url": "../js/spanish.json"
        }
    });

    $('#addProgram').on('click', function () {
        $('#programasModal').modal('show')
        $('#btnAddPrograma').css('display', 'block')
    })

    $('#btnCancelPrograma').on('click', function () {
        $('#programasModal').modal('hide')
        $('#btnAddPrograma').css('display', 'none')
        $('#btnEditPrograma').css('display', 'none')
    })

    $('#btnAddPrograma').on('click', function () {
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        $.ajax({
            url: base_url+'inicio/programas/postPrograma',
            method: "POST",
            data: { numero, nombre },
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
                        title: 'El programa ha sido agregado con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnAddPrograma').css('display','none');
                    $('#programasModal').modal('hide');
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

    $('#btnEditPrograma').on('click', function () {
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        var programa = $('#idPrograma').val()
        $.ajax({
            url: base_url+'inicio/programas/putPrograma',
            method: "POST",
            data: { programa, numero, nombre },
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
                        title: 'El programa ha sido actualizado con éxito.',
                        showConfirmButton: false,
                        timer: 4000
                    })
                    $('#btnEditPrograma').css('display','none');
                    $('#programasModal').modal('hide');
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
