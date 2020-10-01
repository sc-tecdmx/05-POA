function editarResponsableOperativo(id) {
    $('#btnEditResponsableOperativo').css('display','block');
    $.ajax({
        url: base_url+'inicio/responsables_operativos/getResponsableOperativo/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            if(data != '400'){
                $('#unidad_responsable_id').val(data.unidad)
                $('#numero').val(data.numero)
                $('#nombre').val(data.nombre)
                $('#idResponsableOperativo').val(id)
                $('#responsableOperativoModal').modal('show')
            } else {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Hubo un problema al cargar los datos de la unidad responsable, intentalo nuevamente'
                });
            }

        },
        error: function(data) {
            console.log(data);
        }
    })
}

function eliminarResponsableOperativo(id) {
    Swal.fire({
        title: '¿Estas seguro de eliminar este responsable operativo',
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
                url: base_url+'inicio/responsables_operativos/deleteResponsableOperativo',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'El responsable operativo ha sido eliminado con éxito.',
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

    $('#tabla_responsables').DataTable({
        "language": {
            "url": "../js/spanish.json"
        }
    });

    $('#addResponsableOperativo').on('click', function () {
        $('#responsableOperativoModal').modal('show')
        $('#btnAddResponsableOperativo').css('display', 'block')
    })

    $('#btnCancelResponsableOperativo').on('click', function () {
        $('#responsableOperativoModal').modal('hide')
        $('#btnAddResponsableOperativo').css('display', 'none')
        $('#btnEditResponsableOperativo').css('display', 'none')
    })

    $('#btnAddResponsableOperativo').on('click', function () {
        var unidad = $('#unidad_responsable_id').val()
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        $.ajax({
            url: base_url+'inicio/responsables_operativos/postResponsableOperativo',
            method: "POST",
            data: { unidad, numero, nombre },
            success: function(data) {
                console.log(data);
                if(data == '400'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número que ingresaste ya fue registrado, por favor cambialo'
                    });
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'El responsable operativos ha sido agregado con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnCrearMetaComplementaria').css('display','none');
                    $('#metaComplementariaModal').modal('hide');
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

    $('#btnEditResponsableOperativo').on('click', function () {
        var unidad = $('#unidad_responsable_id').val()
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        var ro = $('#idResponsableOperativo').val()
        $.ajax({
            url: base_url+'inicio/responsables_operativos/putResponsableOperativo',
            method: "POST",
            data: { ro, unidad, numero, nombre },
            success: function(data) {
                console.log(data);
                if(data == '400'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número que ingresaste ya fue registrado, por favor cambialo'
                    });
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'El responsable operativos ha sido actualizado con éxito.',
                        showConfirmButton: false,
                        timer: 4000
                    })
                    $('#btnCrearMetaComplementaria').css('display','none');
                    $('#metaComplementariaModal').modal('hide');
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
