function editSubprogram(id){
    $('#btnEditSubprogram').css('display','block');
    $.ajax({
        url: base_url+'inicio/subprogramas/getSubprogram/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            if(data != '400'){
                $('#numero').val(data.numero)
                $('#nombre').val(data.nombre)
                $('#programa_id').val(data.programa)
                $('#idSubprogram').val(id)
                $('#subprogramModal').modal('show')
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

function deleteSubprogram(id){
    Swal.fire({
        title: '¿Estas seguro de eliminar este subprograma',
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
                url: base_url+'inicio/subprogramas/deleteSubprogram',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'El subprograma ha sido eliminado con éxito.',
                        showConfirmButton: false,
                        timer: 5500
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

    $('#tabla_subprogramas').DataTable({
        "language": {
            "url": "../js/spanish.json"
        }
    });

    $('#addSubprogram').on('click', function () {
        $('#subprogramModal').modal('show')
        $('#btnAddSubprogram').css('display', 'block')
    })

    $('#btnCancelSubprogram').on('click', function () {
        $('#subprogramModal').modal('hide')
        $('#btnAddSubprogram').css('display', 'none')
        $('#btnEditSubprogram').css('display', 'none')
    })

    $('#btnAddSubprogram').on('click', function () {
        var programa = $('#programa_id').val()
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        $.ajax({
            url: base_url+'inicio/subprogramas/postSubprogram',
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
                        title: 'El subprograma ha sido agregado con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnAddSubprogram').css('display','none');
                    $('#subprogramModal').modal('hide');
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

    $('#btnEditSubprogram').on('click', function () {
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        var programa = $('#programa_id').val()
        var subprograma = $('#idSubprogram').val()
        $.ajax({
            url: base_url+'inicio/subprogramas/putSubprogram',
            method: "POST",
            data: { subprograma, programa, numero, nombre },
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
                        title: 'El subprograma ha sido actualizado con éxito.',
                        showConfirmButton: false,
                        timer: 4000
                    })
                    $('#btnEditSubprogram').css('display','none');
                    $('#subprogramModal').modal('hide');
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
