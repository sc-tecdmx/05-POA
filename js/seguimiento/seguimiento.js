function verDetallesGenerales(id, mes) {
    $('#descripcion').empty()
    $.ajax({
        url: base_url+'inicio/seguimiento/getDescripciones/'+id+'/'+mes,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            $('#detallesMetaPrincipal').modal('show')
            for(var i = 0; i < data.detalles.length; i++){
                if(data.detalles[i] != '' || data.detalles[i] != null){
                    $('#descripcion').append('<li>'+data.detalles[i]+'</li>')
                }
            }
        },
        error: function(data) {
            console.log(data);
        }
    })
}

function seguimientoMetaPrincipal(id)
{
    $('#seguimientoPrincipalNormalModal').modal('show')
    $('#idMetaPrincipalNormal').val(id)
}

function seguimientoPrincipalPorcentajes(meta)
{
    $('#seguimientoPrincipalPorcentajesModal').modal('show')
    $('#idMetaPrincipalPorcentaje').val(meta)
}

function darSeguimientoNormal(meta)
{
    $('#seguimientoNormalModal').modal('show')
    $('#idMetaComplementariaNormal').val(meta)
}

function limpiarSeguimientoNormal()
{
    $('#idMetaComplementariaNormal').val('')
    $('#mes_id').val('')
    $('#numero').val('')
    $('#explicacion').val('')
}

function darSeguimientoPorcentajes(meta)
{
    $('#seguimientoPorcentajeModal').modal('show')
    $('#idMetaComplementariaPorcentaje').val(meta)
}

function limpiarSeguimientoPorcentaje()
{
    $('#idMetaComplementariaNormal').val('')
    $('#mes_id').val('')
    $('#numero').val('')
    $('#numero_resueltos').val('')
    $('#explicacion').val('')
}

function changeMonth()
{
	const mes = $('#mesIdR').val()
	const meta = $('#idMetaComplementariaNormal').val()
	$('#numero').val('')
	$('#explicacion').val('')
	$.ajax({
		url: base_url+'inicio/seguimiento/getAvanceMetaMesCambioNormal/'+meta+'/'+mes,
		dataType: 'json',
		contentType: "application/json; charset=utf-8",
		method: "GET",
		success: function(data) {
			console.log(data)
			$('#numero').val(data.numero)
			$('#explicacion').val(data.explicacion)
		},
		error: function(data) {
			console.log(data);
		}
	})
}

function changeMonthPercentage()
{
	const mes = $('#mesIdR').val()
	const meta = $('#idMetaComplementariaPorcentaje').val()
	$('#numero_resueltos').val('')
	$('#numeror').val('')
	$('#explicacionR').val('')
	$.ajax({
		url: base_url+'inicio/seguimiento/getAvanceMetaMesCambio/'+meta+'/'+mes,
		dataType: 'json',
		contentType: "application/json; charset=utf-8",
		method: "GET",
		success: function(data) {
			console.log(data)
			$('#numero_resueltos').val(data.atendidos)
			$('#numeror').val(data.recibidos)
			$('#explicacionR').val(data.explicacion)
		},
		error: function(data) {
			console.log(data);
		}
	})
}

function showDescription(meta, mes)
{
	$('#explicacionMes').empty()
	$.ajax({
		url: base_url+'inicio/seguimiento/getDescriptionGoal/'+meta+'/'+mes,
		dataType: 'json',
		contentType: "application/json; charset=utf-8",
		method: "GET",
		success: function(data) {
			const description = data.description.replace(/\n/g, "<br />")
			$('#explicacionMes').html(description)
			$('#explicacionModal').modal('show')
		},
		error: function(data) {
			console.log(data);
		}
	})
}

$(document).ready(function(){
    $('#btnCancelDetalles').on('click', function(){
        $('#descripcion').empty()
        $('#detallesMetaPrincipal').modal('hide')
    })

    $('#numero_resueltos').focus(function(){
        if($('#numeror').val() == 0){
            $('#numero_resueltos').attr('readonly', 'readonly')
        } else {
            $('#numero_resueltos').removeAttr('readonly')
        }
    })

    $('#btnCancelSeguimientoNormal').on('click', function () {
        limpiarSeguimientoNormal()
        $('#seguimientoNormalModal').modal('hide')
    })

    $('#btnAddSeguimientoNormal').on('click', function () {
        const meta = $('#idMetaComplementariaNormal').val()
        const mes = $('#mes_id').val()
        const numero = $('#numero').val()
        const explicacion = $('#explicacion').val()
        const url = window.location.pathname;
        const proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'seguimiento/metasComplementarias/putSeguimientoNormal',
            type: 'POST',
            data: { meta, mes, numero, explicacion, proyecto },
            success: function(data) {
                if(data === '422'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número alcanzado es mayor al programado.'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'El avance de la meta ha sido guardado con éxito.',
                        showConfirmButton: false,
                        timer: 5000
                    })
                    limpiarSeguimientoNormal()
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

    $('#btnCancelSeguimientoPorcentaje').on('click', function () {
        limpiarSeguimientoPorcentaje()
        $('#seguimientoPorcentajeModal').modal('hide')
    })

    $('#btnAddSeguimientoPorcentaje').on('click', function () {
        const meta = $('#idMetaComplementariaPorcentaje').val()
        const mes = $('#mesIdR').val()
        const resueltos = $('#numero_resueltos').val()
        const numero = $('#numeror').val()
        const explicacion = $('#explicacionR').val()
        const url = window.location.pathname;
        const proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'inicio/seguimiento/putSeguimientoPorcentaje',
            type: 'POST',
            data: { meta, mes, resueltos, numero, explicacion, proyecto },
            success: function(data) {
                if(data === '422'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número de atendidos es mayor al número de recibidos.'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'El avance de la meta ha sido guardado con éxito.',
                        showConfirmButton: false,
                        timer: 5000
                    })
                    limpiarSeguimientoPorcentaje()
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

    $('#btnAddSeguimientoPrincipalNormal').on('click', function () {
        const meta = $('#idMetaPrincipalNormal').val()
        const mes = $('#mes_id').val()
        const numero = $('#numero').val()
        const explicacion = $('#explicacion').val()
        const url = window.location.pathname;
        const proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'seguimiento/metaPrincipal/putSeguimientoPrincipalNormal',
            type: 'POST',
            data: { meta, mes, numero, explicacion, proyecto },
            success: function(data) {
                if(data === '422'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número alcanzado es mayor al programado.'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'El avance de la meta ha sido guardado con éxito.',
                        showConfirmButton: false,
                        timer: 5000
                    })
                    limpiarSeguimientoNormal()
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

    $('#btnAddSeguimientoPrincipalPorcentaje').on('click', function () {
        const meta = $('#idMetaPrincipalPorcentaje').val()
        const mes = $('#mesIdR').val()
        const resueltos = $('#numero_resueltos').val()
        const numero = $('#numeror').val()
        const explicacion = $('#explicacionR').val()
        const url = window.location.pathname;
        const proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            url: base_url+'seguimiento/metaPrincipal/putSeguimientoPorcentajePrincipal',
            type: 'POST',
            data: { meta, mes, resueltos, numero, explicacion, proyecto },
            success: function(data) {
                if(data === '422'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número de atendidos es mayor al número de recibidos.'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'El avance de la meta ha sido guardado con éxito.',
                        showConfirmButton: false,
                        timer: 5000
                    })
                    limpiarSeguimientoPorcentaje()
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

    $("input[name=gridRadios]").on('click', function () {
        $('#selectAvance').empty();
        $('#selectAvance').append('<option value="">- Selecciona uno -</option>');
        if($('input:radio[name=gridRadios]:checked').val() == 'mensual'){
            $.ajax({
                url: base_url+'inicio/seguimiento/getMesesHabilitados',
                dataType: 'json',
                contentType: "application/json; charset=utf-8",
                method: "GET",
                success: function(data) {
                    for(var i = 0; i < data.mes.length; i++){
                        $('#selectAvance').append('<option value="'+data.mes[i]+'">'+data.nombre[i]+'</option>');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        } else {
            $.ajax({
                url: base_url+'inicio/seguimiento/getMesesTrimestrales/',
                dataType: 'json',
                contentType: "application/json; charset=utf-8",
                method: "GET",
                success: function(data) {
                    console.log(data)
                    for(var i = 0; i < data.mes.length; i++){
                        $('#selectAvance').append('<option value="'+data.valor[i]+'">'+data.mes[i]+'</option>');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    })

    $('#selectAvance').on('change', function () {
        $('#principal').empty()
        if($('input:radio[name=gridRadios]:checked').val() == 'mensual'){
            const mes = $('#selectAvance').val()
            const url = window.location.pathname;
			const arrayUrl = url.split('/')
			const proyecto = arrayUrl[5]
            $.ajax({
                url: base_url+'inicio/seguimiento/getMesDetalles',
                type: 'POST',
                data: { mes, proyecto },
                success: function(data) {
                    $('#tablaAvances').css('display', 'block')
                    // $('#tablaMetaPrincipal tbody').append('<tr><td colspan="8">'+data+'</td></tr>')
                    $('#tablaAvances').html(data)
                },
                error: function(data) {
                    console.log(data);
                }
            });
        } else if($('input:radio[name=gridRadios]:checked').val() == 'trimestral') {
            var mes = $('#selectAvance').val()
			if (mes) {
				const url = window.location.pathname;
				const arrayUrl = url.split('/')
				const proyecto = arrayUrl[5]
				console.log(proyecto)
				$.ajax({
					url: base_url+'inicio/seguimiento/getTrimestralDetalles',
					type: 'POST',
					data: { mes, proyecto },
					success: function(data) {
						$('#tablaAvances').css('display', 'block')
						$('#tablaAvances').html(data)
					},
					error: function(data) {
						console.log(data);
					}
				});
			}
        }
    })

    $('#btnCancelAvanceMP').on('click', function () {
        $('#metaId').val()
        $('#mesesMetaPrincipalModal').modal('show')
    })

    $('#btnAgregarAvanceMP').on('click', function () {
        var meta = $('#metaId').val()
        var numero = $('#numero').val()
        var mes = $('#mes_id').val()
        var explicacion = $('#explicacion').val()
        var resueltos = $('#numero_resueltos').val()
        var url = window.location.pathname;
        var proyecto = url.substring(url.lastIndexOf('/') + 1);
        $.ajax({
            type: 'POST',
            url: base_url+'inicio/seguimiento/putSeguimiento',
            data: { meta, proyecto, mes, numero, explicacion, resueltos },
            success: function (data) {
                console.log(data)
                if(data === '422'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El valor registrado en atendidos es mayor al recibido.'
                    });
                } else if(data == '420'){
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El número registrado es mayor al programado.'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'El avance de la meta ha sido guardado con éxito.',
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
        })
    })

	$('#btnCancelExplicacionModal').on('click', function () {
		$('#explicacionMes').empty()
		$('#explicacionModal').modal('hide')
	})
})
