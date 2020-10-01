function editarMetaComplementaria(id) {
    $('#btnEditMetaComplementaria').css('display','block');
    $.ajax({
        url: base_url+'inicio/info/getMetaComplementaria/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            $('#tMetaComplementaria').val(data.nombre)
            $('#unidad_medida_id').val(data.unidad)
            $('#ordenMetaC').val(data.orden)
            $('#pesoMetaC').val(data.peso)
            $('#idMetaComplementaria').val(id)
            $('#metaComplementariaModal').modal('show')
        },
        error: function(data) {
            console.log(data);
        }
    })
}

function editarMesesMetaPrincipal(meta, mes) {
    $.ajax({
        url: base_url+'inicio/info/getMesesMetas/'+meta+'/'+mes,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            $('#mesesMetaPrincipalModal').modal('show')
            $('#pmeta').val(meta)
            $('#pmes').val(mes)
            $('#numeroMetaP').val(data.numero)
        },
        error: function(data) {
            console.log(data);
        }
    })
}

function editarMesesMetaComplementaria(meta, mes) {
    $.ajax({
        url: base_url+'inicio/info/getMesesMetas/'+meta+'/'+mes,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            $('#mesesMetasComplementariasModal').modal('show')
            $('#cmeta').val(meta)
            $('#cmes').val(mes)
            $('#numeroMetaC').val(data.numero)
        },
        error: function(data) {
            console.log(data);
        }
    })
}

function editaIndicadores(id) {
    $('#btnEditIndicador').css('display','block');
    $.ajax({
        url: base_url+'inicio/info/getIndicadores/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            $('#metaIdIndicador').val(data.metaId)
            $('#unidadIndicador').val(data.unidad)
            $('#dimension_id').val(data.dimension)
            $('#frecuencia_id').val(data.frecuencia)
            $('#tIndicador').val(data.nombre)
            $('#definicionIndicador').val(data.definicion)
            $('#metodoCalculoIndicador').val(data.metodo)
            $('#metaIndicador').val(data.meta)
            $('#idIndicador').val(id)
            $('#indicadoresModal').modal('show')

        },
        error: function(data) {
            console.log(data);
        }
    })
}

function editaAcciones(id) {
    $('#btnEditAccion').css('display','block');
    $.ajax({
        url: base_url+'inicio/info/getAccion/'+id,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            $('#idAccion').val(id)
            $('#numeroAccion').val(data.numero)
            $('#descripcionAccion').val(data.descripcion)
            $('#accionesSustantivasModal').modal('show')
        },
        error: function(data) {
            console.log(data);
        }
    })
}

function eliminarMetaComplementaria(id) {
    Swal.fire({
        title: '¿Estas seguro de eliminar esta meta complementaria?',
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
                url: base_url+'inicio/info/deleteMetaComplementaria',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        /*'Eliminado!',
                        'La meta complementaria ha sido eliminada con éxito.',
                        'success'*/
                        icon: 'success',
                        title: 'La meta complementaria ha sido eliminada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
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

function eliminarAccionesSustantivas(id) {
    Swal.fire({
        title: '¿Estas seguro de eliminar esta acción sustantiva?',
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
                url: base_url+'inicio/info/deleteAccionSustantiva',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'La acción sustantiva ha sido eliminada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
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

function eliminarIndicadores(id){
    Swal.fire({
        title: '¿Estas seguro de eliminar este indicador?',
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
                url: base_url+'inicio/info/deleteIndicador',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'El indicador ha sido eliminado con éxito.',
                        showConfirmButton: false,
                        timer: 4500
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

function eliminarProyecto(id){
    Swal.fire({
        title: '¿Estas seguro de eliminar este proyecto?',
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
                url: base_url+'inicio/info/deleteProyecto',
                method: "POST",
                data: { id },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'El proyecto ha sido eliminado con éxito.',
                        showConfirmButton: false,
                        timer: 5000
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

function getMesesEjecucion(id_proy){
    $.ajax({
        url: base_url+'inicio/proyectos/getMesesEjecucion/'+id_proy,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            $.each(data.meses, function(idx, value){
                if(value.ejecuta == 'si'){
                    $('#'+value.mes_nombre).bootstrapSwitch('state', true);
                }
                else{
                    $('#'+value.mes_nombre).bootstrapSwitch('state',false);
                }

            });
            $('#id_proyecto_ejecucion').val(id_proy);
            $('#ejecucionModal').modal('show')
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function updateMesEjecucion(id_mes,ejecuta){
    var id_proyecto = $('#id_proyecto_ejecucion').val();

    $.ajax({
        url: base_url+'inicio/proyectos/updateMesEjecucionProyAjax/',
        dataType: 'json',
        data: {'proyecto_id': id_proyecto,'mes_id':id_mes,'ejecuta':ejecuta},
        method: "POST",
        success: function(data) {
            console.log(data);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

$(document).ready(function(){

    if(localStorage.getItem('activeTab')){
        $('#myTab a[href="' + localStorage.getItem('activeTab') + '"]').tab('show');
    }

    $('#tabla_proyectos').DataTable({
        "language": {
            "url": "../js/spanish.json"
        }
    });

    $('#unidad_responsable_gasto_id').on('change', function () {
        $('#responsable_operativo_id').empty();
        $('#responsable_operativo_id').append('<option value=""> - Seleccione uno - </option>');
        var unidad = $('#unidad_responsable_gasto_id').val()
        $.ajax({
            url: base_url+'inicio/info/getResponsableOperativo/'+unidad,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            method: "GET",
            success: function(data) {
                for(var i = 0; i < data.numero.length; i++){
                    $('#responsable_operativo_id').append('<option value="'+data.responsable_operativo_id[i]+'">'+data.numero[i]+'-'+data.nombre[i]+'</option>');
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    })

    $('#programa_id').on('change', function () {
        $('#subprograma_id').empty();
        $('#subprograma_id').append('<option value=""> - Seleccione uno - </option>');
        var programa = $('#programa_id').val()
        $.ajax({
            url: base_url+'inicio/info/getSubprogramas/'+programa,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            method: "GET",
            success: function(data) {
                for(var i = 0; i < data.numero.length; i++){
                    $('#subprograma_id').append('<option value="'+data.subprograma_id[i]+'">'+data.numero[i]+'-'+data.nombre[i]+'</option>');
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    })

    $('#createProjectForm').formValidation({
        // I am validating Bootstrap form
        framework: 'bootstrap',

        // Feedback icons
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        autoFocus: true,
        fields: {
            unidad_responsable_gasto_id: {
                validators: {
                    notEmpty: {
                        message: 'Este campo es requerido'
                    }
                }
            },
            responsable_operativo_id: {
                validators: {
                    notEmpty: {
                        message: 'Este campo es requerido'
                    }
                }
            },
            programa_id: {
                validators: {
                    notEmpty: {
                        message: 'Este campo es requerido'
                    }
                }
            },
            subprograma_id: {
                validators: {
                    notEmpty: {
                        message: 'Este campo es requerido'
                    }
                }
            },
            numero: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese un numero de proyecto'
                    }
                }
            },
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese un nombre de proyecto'
                    }
                }
            },
            tipo: {
                validators: {
                    notEmpty: {
                        message: 'Por favor selecciona un tipo de proyecto'
                    }
                }
            },
            version: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese una versión del proyecto'
                    }
                }
            },
            objetivo: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese el objetivo del proyecto'
                    }
                }
            },
            justificacion: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese la justificación del proyecto'
                    }
                }
            },
            descripcion: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese la descripción del proyecto'
                    }
                }
            },
            fecha: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese la fecha del proyecto'
                    }
                }
            },
            nombre_responsable_operativo: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese el nombre del resaponsable operativo del proyecto'
                    }
                }
            },
            cargo_responsable_operativo: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese el cargo del responsable operativo del proyecto'
                    }
                }
            },
            nombre_titular: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese el nombre del titular del proyecto'
                    }
                }
            },
            responsable_ficha: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese un responsable de la ficha'
                    }
                }
            },
            autorizado_por: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese quien autorizó la ficha'
                    }
                }
            },
        }
    });

    $('#agregarProyecto').on('click', function () {
        if($('#responsable_operativo_id').val() != '' && $('#subprograma_id').val() != '' && $('#numero').val() != '' && $('#nombre').val() != '' && $('#tipo').val() != '' &&
            $('#version').val() != '' && $('#objetivo').val() != '' && $('#justificacion').val() != '' && $('#descripcion').val() != '' && $('#fecha').val() != '' &&
            $('#nombre_responsable_operativo').val() != '' && $('#cargo_responsable_operativo').val() != '' && $('#nombre_titular').val() != '' && $('#responsable_ficha').val() != '' &&
        $('#autorizado_por').val() != ''){
            var responsable_operativo_id = $('#responsable_operativo_id').val()
            var subprograma_id = $('#subprograma_id').val()
            var numero = $('#numero').val()
            var nombre = $('#nombre').val()
            var tipo = $('#tipo').val()
            var version = $('#version').val()
            var objetivo = $('#objetivo').val()
            var justificacion = $('#justificacion').val()
            var descripcion = $('#descripcion').val()
            var fecha = $('#fecha').val()
            var nombre_responsable_operativo = $('#nombre_responsable_operativo').val()
            var cargo_responsable_operativo = $('#cargo_responsable_operativo').val()
            var nombre_titular = $('#nombre_titular').val()
            var responsable_ficha = $('#responsable_ficha').val()
            var autorizado_por = $('#autorizado_por').val()
            $.ajax({
                type: 'POST',
                url: base_url+'inicio/info/postProyecto/',
                data: { responsable_operativo_id, subprograma_id, numero, nombre, tipo, version, objetivo, justificacion, descripcion, fecha, nombre_responsable_operativo, cargo_responsable_operativo, nombre_titular, responsable_ficha, autorizado_por },
                success: function (data) {
                    if(data === '400'){
                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Hubo un problema al agregar, intentalo nuevamente'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'El proyecto ha sido agregado con éxito.',
                            showConfirmButton: false,
                            timer: 4500
                        })
                        setTimeout(function () {
                            window.location.href = base_url+'inicio/proyectos/action/'+data
                        }, 1000);
                        // setTimeout(location.reload(),3500);
                    }
                },
                error: function (e) {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Los datos requeridos no han sido llenados correctamente'
                    });
                    /* $("#output").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false); */

                }
            });
        } else {
            return
        }
    });

    $('#actualizarProyecto').on('click', function () {
        var responsable_operativo_id = $('#responsable_operativo_id').val()
        var subprograma_id = $('#subprograma_id').val()
        var numero = $('#numero').val()
        var nombre = $('#nombre').val()
        var tipo = $('#tipo').val()
        var version = $('#version').val()
        var objetivo = $('#objetivo').val()
        var justificacion = $('#justificacion').val()
        var descripcion = $('#descripcion').val()
        var fecha = $('#fecha').val()
        var nombre_responsable_operativo = $('#nombre_responsable_operativo').val()
        var cargo_responsable_operativo = $('#cargo_responsable_operativo').val()
        var nombre_titular = $('#nombre_titular').val()
        var responsable_ficha = $('#responsable_ficha').val()
        var autorizado_por = $('#autorizado_por').val()
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            type: 'POST',
            url: base_url+'inicio/info/putProyecto/'+proyecto,
            data: { responsable_operativo_id, subprograma_id, numero, nombre, tipo, version, objetivo, justificacion, descripcion, fecha, nombre_responsable_operativo, cargo_responsable_operativo, nombre_titular, responsable_ficha, autorizado_por },
            success: function (data) {
                console.log(data)
                if(data === '400'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Hubo un problema al actualizar, intentalo nuevamente',
                        timer: 5000
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'El proyecto ha sido actualizado con éxito.',
                        showConfirmButton: false,
                        timer: 5000
                    })
                    setTimeout(function () {
                        // location.reload()
                        window.location.href = base_url+'inicio/proyectos'
                    }, 1000)
                }
            },
            error: function (e) {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e
                });
            }
        });
    })

    $('#addMetaPrincipal').on('click', function() {
        $('#btnCrearMetaPrincipal').css('display','block');
        $('#metaPrincipalModal').modal('show')
    })

    $('#editarMetaPrincipal').on('click', function() {
        $('#btnEditMetaPrincipal').css('display','block');
        var id = $('#editarMetaPrincipal').data('info');
        $.ajax({
            url: base_url+'inicio/info/getMetaPrincipal/'+id,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            method: "GET",
            success: function(data) {
                $('#tMetaPrincipal').val(data.nombre)
                if(data.tmc == '0'){
                    $("#customRadioInline2").attr('checked', true);
                    $("#selectUnidad").css('display', 'block')
                    $("#unidadMedidaP").val(data.unidad)
                } else {
                    $("#customRadioInline1").attr('checked', true);
                }
                $('#metaPrincipalModal').modal('show')
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    $('#btnCancelMetaPrincipal').on('click', function() {
        $('#btnEditMetaPrincipal').css('display','none');
        $('#btnCrearMetaPrincipal').css('display','none');
        $('#tMetaPrincipal').val('');
        $('#metaPrincipalModal').modal('hide');
    })

    $('#btnEditMetaPrincipal').on('click', function() {
        var nombre = $('#tMetaPrincipal').val()
        var tmc = $('input:radio[name=customRadioInline1]:checked').val()
        var id = $('#editarMetaPrincipal').data('info');
        if(tmc == 1){
            $.ajax({
                url: base_url+'inicio/info/putMetaPrincipal/'+id,
                method: "POST",
                data: { nombre, tmc },
                success: function(data) {
                    swal.fire({
                        icon: 'success',
                        title: 'La meta principal ha sido actualizada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnEditMetaPrincipal').css('display','none');
                    $('#metaPrincipalModal').modal('hide')
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                },
                error: function(data) {
                    console.log(data);
                }
            })
        } else {
            var unidadMedida = $('#unidadMedidaP').val()
            $.ajax({
                url: base_url+'inicio/info/putMetaPrincipalE/'+id,
                method: "POST",
                data: { nombre, tmc, unidadMedida },
                success: function(data) {
                    swal.fire({
                        icon: 'success',
                        title: 'La meta principal ha sido actualizada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnEditMetaPrincipal').css('display','none');
                    $('#metaPrincipalModal').modal('hide')
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
    });

    $('#btnCrearMetaPrincipal').on('click', function() {
        var nombre = $('#tMetaPrincipal').val()
        if($("input[name='customRadioInline1']:radio").is(':checked')){
            var tmc = 1
        } else {
            var tmc = 0
        }
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        if(tmc == 1){
            $.ajax({
                url: base_url+'inicio/info/postMetaPrincipal',
                method: "POST",
                data: { nombre, proyecto, tmc },
                success: function(data) {
                    swal.fire({
                        icon: 'success',
                        title: 'La meta principal ha sido actualizada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnCrearMetaPrincipal').css('display','none');
                    $('#metaPrincipalModal').modal('hide')
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                },
                error: function(data) {
                    console.log(data);
                }
            })
        } else {
            var unidadMedida = $('#unidadMedidaP').val()
            $.ajax({
                url: base_url+'inicio/info/postMetaPrincipalE',
                method: "POST",
                data: { nombre, proyecto, tmc, unidadMedida },
                success: function(data) {
                    swal.fire({
                        icon: 'success',
                        title: 'La meta principal ha sido actualizada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnCrearMetaPrincipal').css('display','none');
                    $('#metaPrincipalModal').modal('hide')
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }
    });

    $("#customRadioInline1").click(function () {
        $('#selectUnidad').css('display', 'none')
    });

    $("#customRadioInline2").click(function () {
        $('#selectUnidad').css('display', 'block')
    });

    $('#addMetaComplementaria').on('click', function() {
        $('#btnCrearMetaComplementaria').css('display','block');
        $('#metaComplementariaModal').modal('show')
    })

    $('#btnCancelMetaComplementaria').on('click', function() {
        $('#btnEditMetaComplementaria').css('display','none');
        $('#btnCrearMetaComplementaria').css('display','none');
        $('#tMetaComplementaria').val('')
        $('#unidad_medida_id').val('')
        $('#ordenMetaC').val('')
        $('#pesoMetaC').val('')
        $('#idMetaComplementaria').val('')
        $('#metaComplementariaModal').modal('hide');
    })

    $('#btnCancelMesesMetas').on('click', function() {
        $('#cmeta').val('')
        $('#cmes').val('')
        $('#numeroMetaC').val('')
        $('#mesesMetasComplementariasModal').modal('hide');
    })

    $('#btnCancelMesesMetaP').on('click', function() {
        $('#pmeta').val('')
        $('#pmes').val('')
        $('#numeroMetaP').val('')
        $('#mesesMetaPrincipalModal').modal('hide');
    })

    $('#btnEditMetaComplementaria').on('click', function() {
        var nombre = $('#tMetaComplementaria').val()
        var unidad = $('#unidad_medida_id').val()
        var orden = $('#ordenMetaC').val()
        var peso = $('#pesoMetaC').val()
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        var id = $('#idMetaComplementaria').val();
        $.ajax({
            url: base_url+'inicio/info/putMetaComplementaria/'+id,
            method: "POST",
            data: { proyecto, nombre, unidad, orden, peso },
            success: function(data) {
                console.log(data)
                if(data === '420'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El peso acumulado sobrepasa el 100%'
                    });
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'La meta complementaria ha sido actualizada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#btnEditMetaPrincipal').css('display','none');
                    $('#metaPrincipalModal').modal('hide')
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $('#btnCrearMetaComplementaria').on('click', function() {
        var nombre = $('#tMetaComplementaria').val()
        var unidad = $('#unidad_medida_id').val()
        var orden = $('#ordenMetaC').val()
        var peso = $('#pesoMetaC').val()
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'inicio/info/postMetaComplementaria',
            method: "POST",
            data: { nombre, proyecto, unidad, orden, peso },
            success: function(data) {
                console.log(data);
                if(data === '420'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No se puede insertar una nueva meta complementaria debido a que los pesos ya suman el 100%'
                    });
                }else if(data === '422') {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No se puede insertar esta meta complementaria ya que el peso total sobre pasa el 100%'
                    });
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'La meta complementaria ha sido agregada con éxito.',
                        showConfirmButton: false,
                        timer: 4500
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
    });

    $('#addIndicador').on('click', function() {
        $('#btnCrearIndicador').css('display','block');
        $('#indicadoresModal').modal('show')
    })

    $('#btnCancelIndicadores').on('click', function() {
        $('#btnEditMetaComplementaria').css('display','none');
        $('#btnCrearMetaComplementaria').css('display','none');
        $('#metaIdIndicador').val('')
        $('#unidadIndicador').val('')
        $('#dimension_id').val('')
        $('#frecuencia_id').val('')
        $('#tIndicador').val('')
        $('#definicionIndicador').val('')
        $('#metodoCalculoIndicador').val('')
        $('#metaIndicador').val('')
        $('#indicadoresModal').modal('hide');
    })

    $('#btnEditIndicador').on('click', function() {
        var metaId = $('#metaIdIndicador').val()
        var unidad = $('#unidadIndicador').val()
        var dimension = $('#dimension_id').val()
        var frecuencia = $('#frecuencia_id').val()
        var nombre = $('#tIndicador').val()
        var definicion = $('#definicionIndicador').val()
        var metodo = $('#metodoCalculoIndicador').val()
        var meta = $('#metaIndicador').val()
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        var id = $('#idIndicador').val()
        $.ajax({
            url: base_url+'inicio/info/putIndicador/'+id,
            method: "POST",
            data: { proyecto, metaId, unidad, dimension, frecuencia, nombre, definicion, metodo, meta },
            success: function(data) {
                swal.fire({
                    icon: 'success',
                    title: 'El indicador ha sido actualizado con éxito.',
                    showConfirmButton: false,
                    timer: 4500
                })
                $('#btnEditIndicador').css('display','none');
                $('#indicadoresModal').modal('hide')
                setTimeout(function () {
                    location.reload()
                    $('#tabIndica').addClass('active')
                }, 1000)
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $('#btnCrearIndicador').on('click', function() {
        var metaId = $('#metaIdIndicador').val()
        var unidad = $('#unidadIndicador').val()
        var dimension = $('#dimension_id').val()
        var frecuencia = $('#frecuencia_id').val()
        var nombre = $('#tIndicador').val()
        var definicion = $('#definicionIndicador').val()
        var metodo = $('#metodoCalculoIndicador').val()
        var meta = $('#metaIndicador').val()
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'inicio/info/postIndicador',
            method: "POST",
            data: { proyecto, metaId, unidad, dimension, frecuencia, nombre, definicion, metodo, meta },
            success: function(data) {
                swal.fire({
                    icon: 'success',
                    title: 'El indicador ha sido creado con éxito.',
                    showConfirmButton: false,
                    timer: 4500
                })
                $('#btnCrearIndicador').css('display','none');
                $('#indicadoresModal').modal('hide')
                setTimeout(function () {
                    location.reload()
                }, 1000)
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    /**
     * Bloque para acciones sustantivas
     */
    $('#addAccion').on('click', function() {
        $('#btnCrearAccion').css('display','block');
        $('#accionesSustantivasModal').modal('show')
    })

    $('#btnCancelAccion').on('click', function() {
        $('#btnEditAccion').css('display','none');
        $('#btnCrearAccion').css('display','none');
        $('#descripcionAccion').val('')
        $('#numeroAccion').val('')
        $('#idAccion').val('')
        $('#accionesSustantivasModal').modal('hide');
    })

    $('#btnEditAccion').on('click', function() {
        var numero = $('#numeroAccion').val()
        var descripcion = $('#descripcionAccion').val()
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        var id = $('#idAccion').val()
        $.ajax({
            url: base_url+'inicio/info/putAccionesSustantivas/'+id,
            method: "POST",
            data: { proyecto, numero, descripcion },
            success: function(data) {
                swal.fire({
                    icon: 'success',
                    title: 'La acción sustantiva ha sido actualizada con éxito.',
                    showConfirmButton: false,
                    timer: 4500
                })
                $('#btnEditAccion').css('display','none');
                $('#accionesSustantivasModal').modal('hide')
                setTimeout(function () {
                    location.reload()
                }, 1000)
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $('#btnCrearAccion').on('click', function() {
        var numero = $('#numeroAccion').val()
        var descripcion = $('#descripcionAccion').val()
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        var id = $('#idAccion').val()
        $.ajax({
            url: base_url+'inicio/info/postAccionesSustantivas',
            method: "POST",
            data: { proyecto, numero, descripcion },
            success: function(data) {
                swal.fire({
                    icon: 'success',
                    title: 'La acción sustantiva ha sido creada con éxito.',
                    showConfirmButton: false,
                    timer: 4500
                })
                $('#btnCrearAccion').css('display','none');
                $('#accionesSustantivasModal').modal('hide')
                setTimeout(function () {
                    location.reload()
                }, 1000)
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $('#btnEditMesesMetas').on('click', function () {
        var meta = $('#cmeta').val()
        var numero = $('#numeroMetaC').val()
        var mes = $('#cmes').val()
        $.ajax({
            url: base_url+'inicio/info/putMesMetas',
            method: "POST",
            data: { meta, mes, numero },
            success: function(data) {
                if(data === '420'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No se puede insertar una nueva meta complementaria debido a que los pesos ya suman el 100%'
                    });
                }else {
                    swal.fire({
                        icon: 'success',
                        title: 'El mes de la meta complementaria ha sido actualizado con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#cmeta').val('')
                    $('#cmes').val('')
                    $('#mesesMetasComplementariasModal').modal('hide')
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

    $('#btnEditMesesMetaP').on('click', function () {
        var meta = $('#pmeta').val()
        var numero = $('#numeroMetaP').val()
        var mes = $('#pmes').val()
        $.ajax({
            url: base_url+'inicio/info/putMesMetas',
            method: "POST",
            data: { meta, mes, numero },
            success: function(data) {
                if(data === '420'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No se puede insertar una nueva meta principal debido a que los pesos ya suman el 100%'
                    });
                }else {
                    swal.fire({
                        icon: 'success',
                        title: 'El mes de la meta principal ha sido actualizado con éxito.',
                        showConfirmButton: false,
                        timer: 4500
                    })
                    $('#pmeta').val('')
                    $('#pmes').val('')
                    $('#mesesMetaPrincipalModal').modal('hide')
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

    $('#addEjecucion').on('click', function (){
        $('#ejecucionModal').modal('show');
        $('#btnCrearEjecucion').css('display', 'block')
    })

    $("[name='checkboxEnero']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxFebrero']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxMarzo']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxAbril']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxMayo']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxJunio']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxJulio']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxAgosto']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxSeptiembre']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxOctubre']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxNoviembre']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });
    $("[name='checkboxDiciembre']").bootstrapSwitch({
        onText: 'SI',
        offText: 'NO'
    });

    $('#btnCrearEjecucion').on('click', function() {
        var ejecuta = []
        for(var i = 1; i <= 12; i++){
            if($('#CustomCheck'+i).is(':checked')){
                ejecuta.push('1')
            } else {
                ejecuta.push('0')
            }
        }
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'inicio/info/postEjecucionProyecto',
            method: "POST",
            data: { proyecto, ejecuta },
            success: function(data) {
                swal.fire({
                    icon: 'success',
                    title: 'El periodo de ejecución del proyecto ha sido agregado con éxito.',
                    showConfirmButton: false,
                    timer: 4500
                })
                $('#btnCrearAccion').css('display','none');
                $('#accionesSustantivasModal').modal('hide')
                setTimeout(function () {
                    location.reload()
                }, 1000)
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    $('#editarEjecucion').on('click', function () {
        $('#btnEditEjecucion').css('display', 'block')
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'inicio/info/getEjecucion/'+proyecto,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            method: "GET",
            success: function(data) {
                $.each(data.meses, function(i,m){
                    $('#CustomCheck'+m).prop('checked', true)
                })
                $('#ejecucionModal').modal('show')
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    $('#btnEditEjecucion').on('click', function () {
        var meses = []
        for(var i = 1; i <= 12; i++){
            if($('#CustomCheck'+i).is(':checked')){
                meses.push('1')
            } else {
                meses.push('0')
            }
        }
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'inicio/info/putEjecucion',
            method: "POST",
            data: { proyecto, meses },
            success: function(data) {
                console.log(data)
                swal.fire({
                    icon: 'success',
                    title: 'La ejecución del proyecto ha sido actualizada correctamente',
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
})
