$(document).ready(function(){
  var working = false;
  $('.loginForm').on('submit', function(e) {
    e.preventDefault();
    $(".spinner").html("");
    if (working) return;
    working = true;
    var $this = $(this),
    $state = $this.find('button > .state');
    $this.addClass('loading');
    $state.html('Validando');
    $.ajax({
      url: "login.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){
        console.log(data);
		    if(data.toString()!=="0"){
          var datos = data.split("-");
          //$.cookie("user", data);
          $.cookie("tipo", datos[1]);
          $.cookie("usuario", datos[2]);
          $.cookie("user", datos[3]);
          setTimeout(function() {
            $this.addClass('ok');
            $state.html('Bienvenido');
            setTimeout(function() {
              location.href="html/ltr/inicio.php";
            }, 800);
          }, 3000);
        } else{
          $("#user").css("border-color", "red");
          $("#user").attr("placeholder", "Correo y/o contraseña incorrectos");
          /*setTimeout(function() {
            $(".spinner").html("X");

            setTimeout(function() {
              $state.html('Entrar');
              $this.removeClass('warn loading');
              working = false;
            }, 1200);
          }, 2000);*/
        }
      }
    });
  });
});
