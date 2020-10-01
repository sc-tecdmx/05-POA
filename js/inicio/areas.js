function editarArea(id) {
    $('#btnEditArea').css('display','block');
    $.ajax({
        url: base_url+'inicio/areas/getArea/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            if(data != '400'){
                $('#nombre').val(data.nombre)
                $('#descripcion').val(data.descripcion)
                $('#idArea').val(id)
                $('#areasModal').modal('show')
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
}

function eliminarArea(id) {
    Swal.fire({
        title: '¿Estas seguro de eliminar esta área',
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
                url: base_url+'inicio/areas/deleteArea',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'El área ha sido eliminado con éxito.',
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

    $('#tabla_areas').DataTable({
        "language": {
            "url": "../js/spanish.json"
        }
    });

    $('#addArea').on('click', function () {
        $('#areasModal').modal('show')
        $('#btnAddArea').css('display', 'block')
    })

    $('#btnCancelArea').on('click', function () {
        $('#areasModal').modal('hide')
        $('#btnAddArea').css('display', 'none')
        $('#btnEditArea').css('display', 'none')
    })

    $('#btnAddArea').on('click', function () {
        var nombre = $('#nombre').val()
        var descripcion = $('#descripcion').val()
        $.ajax({
            url: base_url+'inicio/areas/postArea',
            method: "POST",
            data: { nombre, descripcion },
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
                        title: 'El área ha sido agregada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnAddArea').css('display','none');
                    $('#areasModal').modal('hide');
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

    $('#btnEditArea').on('click', function () {
        var nombre = $('#nombre').val()
        var descripcion = $('#descripcion').val()
        var area = $('#idArea').val()
        $.ajax({
            url: base_url+'inicio/areas/putArea',
            method: "POST",
            data: { area, nombre, descripcion },
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
                        title: 'El área ha sido actualizada con éxito.',
                        showConfirmButton: false,
                        timer: 4000
                    })
                    $('#btnEditArea').css('display','none');
                    $('#areasModal').modal('hide');
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
