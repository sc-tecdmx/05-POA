$(document).ready(function () {
$('#usuario_form').formValidation({
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
      	nombre: {
              validators: {
                  notEmpty: {
                      message: 'Este campo es requerido'
                  },
                  stringLength: {
                      min: 4,
                      max: 80,
                      message: 'Por favor ingrese valor válido entre 4 y 80 caracteres'
                  }

              }
          },
          correo: {
              validators: {
                  notEmpty: {
                      message: 'Este campo es requerido'
                  },
                  stringLength: {
                      min: 4,
                      max: 80,
                      message: 'Por favor ingrese valor válido entre 4 y 80 caracteres'
                  },
                  emailAddress: {
                      message: 'Por favor ingrese un correo electrónico válido '
                  }
              }
          },
          usuario: {
              validators: {
                  notEmpty: {
                      message: 'Este campo es requerido'
                  },
                  stringLength: {
                      min: 4,
                      max: 80,
                      message: 'Por favor ingrese valor válido entre 4 y 80 caracteres'
                  }
              }
          },

           pass: {
              validators: {
                  notEmpty: {
                      message: 'Este campo es requerido'
                  },
                   stringLength: {
                      min: 4,
                      max: 80,
                      message: 'Por favor ingrese valor válido entre 4 y 80 caracteres'
                  }

              }
          },
          pass2: {
              validators: {
                  notEmpty: {
                      message: 'Por favor ingrese un correo'
                  },
                  stringLength: {
                      min: 4,
                      max: 80,
                      message: 'Por favor ingrese valor válido entre 4 y 80 caracteres'
                  },

              }
          },

        }
      });
});
