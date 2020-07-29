$(document).ready(function(){

    $('.notice').delay(3000).fadeOut(/*function(){$(this).remove()}*/)

    $("#sidebarToggle").on('click',function(){
        if($("#angle_r").is(":visible")){
            $("#angle_l").show();
            $("#angle_r").hide();
        }
        else{
            $("#angle_l").hide();
            $("#angle_r").show();
        }
    })

})
