$(document).ready(function () {

    $('.notice').delay(3000).fadeOut()

    $('#ingreso').formValidation({
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
            usuario: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese un usuario'
                    },
                    stringLength: {
                        min: 4,
                        max: 80,
                        message: 'Por favor ingrese un usuario válido entre 4 y 250 caracteres'
                    }
                }
            },
            pass: {
                validators: {
                    notEmpty: {
                        message: 'Por favor ingrese una contraseña'
                    },
                    stringLength: {
                        min: 4,
                        max: 80,
                        message: 'Por favor ingrese una contraseña valido 4 y 250 caracteres'
                    }
                }
            }
        }
    });
});
