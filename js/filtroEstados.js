const baseUrl = base_url + 'home/filtro/';
var info = null;

$(document).ready(function () {
    if(baseUrl != null) {
        getCondition();
        statesForm();
        getStatesQry();
        getFirstFilter();
    }
});

function getCondition() {
    $.get( baseUrl +  'get_filtro', function( data ) {
        let jsonData = JSON.parse(data);
        //console.log(data);
        $.each(jsonData, function (i, e) {
            let name =  e.nombre_estado;
            $('.estadoName').append('<li class="text-white"><span  class="nav-link-text">' + name.toUpperCase() + '</span></li>');
        });
    });
}

function statesForm() {
    $.get( baseUrl +  'get_menu_qry', function( data ) {
        //console.log(data);
        let jsonData = JSON.parse(data);

        $.each(jsonData, function (i, e) {
            let name =  e.nombre_estado;
            let cantidad = e.cantidad;
            let id = e.id_estados;
            let inputSelectCheck = '<div class="col-md-6">' +
                '                        <div class="form-group">' +
                '                            <label for="edo'+ id +'">' +
                '                            <input type="checkbox" id="edo'+ id +'" name="edo['+ id +']" value="'+ id +'"> ' + name.toUpperCase() +
                '                            <span class="badge badge-pill badge-primary">'+ cantidad +'</span></label>' +
                '                        </div>' +
                '                    </div>';

            $('#estados-select').append(inputSelectCheck);
        });
    });
}

function m(status) {
    if (status == true) {
        location.reload(true);
    } else {
        return false;
    }
}

function m_1(status) {
    if (status == true) {
        location.reload(true);
    } else {
        return false;
    }
}
function getStatesQry() {
    $('#selector-estados').on("submit", function (event) {
        event.preventDefault();
        let query = JSON.stringify($(this).serializeArray());
        $.post(baseUrl + 'post_states', {edo: query}, function (data) {
            //console.log(data);
            m(true);
        });
        $('#exampleModal1').modal('hide');
    });
   /*if (m(info)) {
       console.log(m(info));
   }*/
}

function getFirstFilter() {
    $('#refresh-filter').on("click", function (event) {
        event.preventDefault();
        //let query = JSON.stringify($(this).serializeArray());
        $.post(baseUrl + 'first_condition', {req: true}, function (data) {
            //console.log(data);
            m_1(true);
        });
        //$('#exampleModal1').modal('hide');
    });
   /*if (m(info)) {
       console.log(m(info));
   }*/
}
