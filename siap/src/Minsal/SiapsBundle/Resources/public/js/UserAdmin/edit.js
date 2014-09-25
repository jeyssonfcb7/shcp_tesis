$(document).ready(function() {
    $(":submit").click(function() {
        if (!$('input:checkbox[name*="groups"]').is(':checked')) {
            $("body").append('<div id="dialog-message"></div>');
            $("#dialog-message").empty();
            $("#dialog-message").append('<p><span class="glyphicon glyphicon-exclamation-sign"></span> Debe de seleccinoar un rol para el usuario</p>');
            $("#dialog-message").dialog({
                dialogClass: "dialog-error",
                modal: true,
                title: 'Grupo no seleccionado',
                width: 500,
                buttons: {
                    Aceptar: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
            return false;
        }
    });
    
    $('input[id$="_username"]').focusout(function(){
        $('input[id$="_email"]').val($('input[id$="_username"]').val()+'@salud.gob.sv');
        $('input[id$="_plainPassword_first"]').focus();
    }); 
    
    $('input[id$="_enabled"]').attr("checked","checked");
});

