
/*!
 * Start Bootstrap - SB Admin v4.0.0-beta.2 (https://startbootstrap.com/template-overviews/sb-admin)
 * Copyright 2013-2017 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-sb-admin/blob/master/LICENSE)
 */
function getResponsablesOperativos(unidad, index)
{
	if($('#customCheck'+index).is(':checked')){
		$.ajax({
			url: base_url+'usuarios/usuarios/getResponsablesOperativos/'+unidad,
			method: "GET",
			success: function(data) {
				if(data != '400'){
					$('#responsables'+index).html(data)
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
	} else {
		$('#responsables'+index).empty()
	}
}

function getPermisos()
{
	var url = window.location.pathname;
	var usuario = url.substring(url.lastIndexOf('/') + 1);
	$.ajax({
		url: base_url+'usuarios/infoUsuarios/getPermisos/'+usuario,
		dataType: 'json',
		contentType: "application/json; charset=utf-8",
		method: "GET",
		success: function(data) {
			console.log(data)
			$('#permiso').selectpicker('val', data.tipo)
			$('#ejercicio').selectpicker('val', data.ejercicios)
			$.each(data.unidades, function(index, value){
				// console.log(value.unidad)
				$('#areaSelect'+value.unidad).selectpicker('val', value.responsables);
			})
		},
		error: function(data) {
			console.log(data);
		}
	})
}

$(document).ready(function () {

	getPermisos()

	$("#tabla_acciones").DataTable({
		"language": {
			"url": "js/spanish.json"
		},
		"sDom": '<"top"fli>rt<"bottom"ip><"clear">'
	});

	$("#tablaUsuarios").DataTable({
		"language": {
			"url": "js/spanish.json"
		},
	});

	$("#tabla_permisos").DataTable({
		"language": {
			"url": "js/spanish.json"
		},
		"sDom": '<"top"fli>rt<"bottom"ip><"clear">'
	});


	$("#tabla_inversiones").DataTable({
		"language": {
			"url": "js/spanish.json"
		}
	});

    $("#dataTable").DataTable({
      "columns": [{"defaultContent": ""},{"defaultContent": ""},{"defaultContent": ""},{"defaultContent": ""},{"defaultContent": ""}],
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
		"autoWidth": true,
		"sDom": '<"top"fli>rt<"bottom"ip><"clear">',
        "language": {

	"sProcessing":     "Procesando...",
	"sLengthMenu":     "Mostrar _MENU_ registros",
	"sZeroRecords":    "No se encontraron resultados",
	"sEmptyTable":     "Ningún dato disponible en esta tabla",
	"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	"sInfoPostFix":    "",
	"sSearch":         "Buscar:",
	"sUrl":            "",
	"sInfoThousands":  ",",
	"sLoadingRecords": "Cargando...",
	"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
	},
	"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	}

        }
    });

	$('#btnAsignar').on('click', function () {
		const permiso = $('#permiso').val()
		const ejercicios = $('#ejercicio').val()
		const maxres = $('#totalResponsables').val()
		let responsables = []
		console.log($('.unidad1').selectpicker('val'))
		// checar porque no se esta recogiendo los valores de las unidades
		for(let i = 1; i <= maxres; i++){
			if($('.unidad'+i).selectpicker('val') != []){
				let max = $('.unidad'+i).selectpicker('val').length
				let responsablesOperativos = $('.unidad'+i).selectpicker('val')
				for(let j = 0; j < max; j++){
					responsables.push(responsablesOperativos[j])
				}
				// responsables[i] = Array.from($('.unidad'+i).selectpicker('val'))
			}
		}
		const url = window.location.pathname;
		const usuario = url.substring(url.lastIndexOf('/') + 1);
		console.log(responsables);
		$.ajax({
			url: base_url+'usuarios/infoUsuarios/postPermisos',
			method: "POST",
			data: { permiso, ejercicios, responsables, usuario },
			success: function(data) {
				console.log(data)
				swal.fire({
					icon: 'success',
					title: 'Los permisos han sido asignados con éxito.',
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
		})
	})
});
