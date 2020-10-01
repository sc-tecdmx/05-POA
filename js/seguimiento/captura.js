$(document).ready(function() {
    /* $('#numero').keyup(function(){
        if($('#numero').val() == 0){
            $('#numero_resueltos').attr('readonly', 'readonly')
        }
    }) */

    $('#numero_resueltos').focus(function(){
        if($('#numero').val() == 0){
            console.log('entre')
            $('#numero_resueltos').attr('readonly', 'readonly')
        } else {
            $('#numero_resueltos').removeAttr('readonly')
        }
    })
})
