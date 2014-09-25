//FUNCIÓN QUE SE UTILIZA PARA PERMITIR SOLO LETRAS Y UN SOLO ESPACIO.
//QUITANDO TODA TILDE, DIERESIS,ETC
function limpiar_nombres(text) {
    var text = text.toLowerCase(); // a minusculas
    text = text.replace(/[áàäâå]/, 'a');
    text = text.replace(/[éèëê]/, 'e');
    text = text.replace(/[íìïî]/, 'i');
    text = text.replace(/[óòöô]/, 'o');
    text = text.replace(/[úùüû]/, 'u');
    text = text.replace(/[ýÿ]/, 'y');
    text = text.replace(/[^a-zA-ZñÑ\s]/g, '');
    text = text.replace(/\s{2,}/, ' ');
    text = text.toUpperCase();
    return text;
}

/* Convertir Hora segun formato de 12 o 24 Horas */
function formatTime_12_24(convertFormat, strTime) {
    var time  = false;
    var regex = null;
    
    if(convertFormat == "12") {
        regex   = /^([0-1]?\d|2[0-3]):([0-5]\d):([0-5]\d)$/i;
    } else {
        if(convertFormat == "24") {
            regex   = /^([0]\d|[1][0-2]):([0-5]\d):([0-5]\d)\s?(?:AM|PM)$/i;
        }
    }

    if (regex != null && regex.test(strTime)) {
        if(convertFormat == "24") {
            var arrayTime = strTime.split(":");
            var restTime  = arrayTime[2].split(" ");
            var hours     = Number(arrayTime[0]);
            var minutes   = Number(arrayTime[1]);
            var seconds   = Number(restTime[0]);
            var meridian  = restTime[1];

            if (meridian == "PM" && hours < 12)
                hours = hours + 12;
            
            if(meridian == "AM" && hours == 12)
                hours = hours - 12;

            if (hours < 10)
                hours = "0" + hours.toString();

            if (minutes < 10)
                minutes = "0" + minutes.toString();

            if (seconds < 10)
                seconds = "0" + seconds.toString();

            time = hours + ":" + minutes + ":" + seconds;
        } else {
            var arrayTime = strTime.split(":");
            var hours     = Number(arrayTime[0]);
            var minutes   = Number(arrayTime[1]);
            var seconds   = Number(arrayTime[2]);
            var meridian  = "AM";

            if (hours >= 12) {
                hours = hours - 12;
                meridian = "PM";
            }
            
            if (hours == 0) {
                hours = 12;
            }

            if (hours < 10)
                hours = "0" + hours.toString();

            if (minutes < 10)
                minutes = "0" + minutes.toString();

            if (seconds < 10)
                seconds = "0" + seconds.toString();

            time = hours + ":" + minutes + ":" + seconds + " " + meridian;
        }
    }

    return time;
}

function defalutlModalBodyMessage(e) {
    
    e = typeof e !== 'undefined' ? e : '';

    var html = '<div class="alert alert-block alert-error">\
                <h4>Error al cargar el elemento</h4>\
                Lo sentimos, hubo un problema al cargar la vista, \
                por favor intente nuevamente.<br /> \
                Si el problema persiste por favor contacte al administrador...</div>';

    if(e != '') {
        html = html + '<p><b>Detalle del Error</b><br />' + e + '</p>';
    }
    return html;
}

/*
 * Funcion que facilita mostrar los Message Dialog
 * Parametros:
 *      title: titulo de dialog
 *      msg: mensaje dentro del dialog
 *      dialogClass: [dialog-warning | dialog-error | dialog-info | dialog-success] 
 */

function showDialogMsg(title, msg, dialogClass){
    if(jQuery('body #dialog-message').length > 0)
        jQuery('body #dialog-message').remove();

    jQuery("body").append('<div id="dialog-message"></div>');
    var element = jQuery('body #dialog-message');

    if (typeof dialogClass === "undefined" || dialogClass === null || dialogClass === '') {
        dialogClass = 'dialog-info'
    }

    if (typeof title === "undefined" || title === null || title === '') {
        switch(dialogClass.replace('dialog-','')) {
            case 'error':
                title = 'Ha ocurrido un Error!';
                break;
            case 'warning':
                title = 'Advertencia!';
                break;
            case 'success':
                title = 'Realizado correctamente!';
                break;
            default:
                title = 'Informaci&oacute;n';
                break;
        }
    }

    if (typeof msg === "undefined" || msg === null || msg === '') {
        switch(dialogClass.replace('dialog-','')) {
            case 'error':
                msg = 'Se ha producido un error inesperado! Por favor, verifique los datos ingresados e intente nuevamente.';
                break;
            case 'warning':
                msg = 'Atenci&oacute;n, verifique la información proporcionada y que los datos esten completos. Estos podría generar un error.';
                break;
            case 'success':
                msg = 'La acci&oacute;n se ha realizado correctamente.';
                break;
            default:
                msg = 'No se ha definido información a mostrar al usuario.';
        }
    }

    var msgWi = '';

    switch(dialogClass.replace('dialog-','')) {
        case 'error':
            msgWi = '<i class="icon-remove-sign"></i>&nbsp;&nbsp;'+msg;
            break;
        case 'warning':
            msgWi = '<i class="icon-warning-sign"></i>&nbsp;&nbsp;'+msg;
            break;
        case 'success':
            msgWi = '<i class="icon-ok-sign"></i>&nbsp;&nbsp;'+msg;
            break;
        default:
            msgWi = '<i class="icon-info-sign"></i>&nbsp;&nbsp;'+msg;
    }

    element.append(msgWi);

    element.dialog({
        dialogClass: dialogClass,
        modal: true,
        title: title,
        buttons: {
            Ok: function() {
                jQuery( this ).dialog( "close" );
            }
        }
    });
}

jQuery(document).ready(function($) {
    /***** Mosrtrar Mensajes de Error de Sonata y Esconderlos Automaticamente ******/

    $('i[class="ui-icon ui-icon-alert"]').attr("data-placement", "top");
    $('i[class="ui-icon ui-icon-alert"][data-title="error"]').attr("data-title", '<spam style="color: #b94a48;">Se ha producido un error:</spam>');
    $('i[class="ui-icon ui-icon-alert"]').popover('show');
    var popOverShow = true;
    var popOverClicked = false;
    var lastPopOverClicked = null;

    $('body').on('click', function(event) {


        if (popOverShow == true && popOverClicked == false) {
            $('i[class="ui-icon ui-icon-alert"]').popover('hide');
            popOverShow = false;
            lastPopOverClicked = null;
        }
        else {
            if (popOverShow == true && popOverClicked == true) {
                popOverShow = false;
                popOverClicked = false;
            }
            else {
                if (popOverShow == false && popOverClicked == true) {
                    popOverShow = true;
                    popOverClicked = false;
                }
                else {
                    popOverShow = false;
                    popOverClicked = false;
                    lastPopOverClicked = null;
                }
            }
        }

        lasElementClicked = event.target;

    });

    $('i[class="ui-icon ui-icon-alert"]').on('click', function(event) {

        if (lastPopOverClicked != null) { //Determina si hay un PopUp abierto y se ha dado click en otro diferente.
            if ($(this) != lastPopOverClicked && popOverShow == true) {
                lastPopOverClicked.popover('hide');       //Se cierra el PopUp ya abierto.
                popOverShow = false;
            }
        }

        popOverClicked = true;
        lastPopOverClicked = $(this);

    });
    /*********************************************/
	
	//Estandarización del uso de modal dentro del proyecto
    $('body').append('\
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
            <div class="modal-dialog">\
                <div class="modal-content">\
                    <div class="modal-header">\
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>\
                    </div>\
                    <div class="modal-body">\
                    </div>\
                    <div class="modal-footer">\
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #636363;font-weight: bold;">Cerrar</button>\
                    </div>\
                </div>\
            </div>\
        </div>');

    $("body").on('click', 'a[custom-modal="true"]', function(e){
        var currentIDM = $(this).attr("id");
        if (!(typeof modal_elements === 'undefined') && modal_elements.length != 0) {
            for (var i = 0; i < modal_elements.length; i++) {
                if (currentIDM == modal_elements[i].id) {
                    if (modal_elements[i].empty != true) {
                        /*Limpiando los elementos del modal*/
                        $('#myModal div.modal-header h4#myModalLabel').empty();
                        $('#myModal div.modal-body').empty();
                        $('#myModal div.modal-footer').empty();

                        /*Verificando el contendio a mostrar*/
                        if (typeof modal_elements[i].header === 'undefined' || modal_elements[i].header == '') {
                            modal_elements[i].header = 'Detalle';
                        }

                        if (typeof modal_elements[i].func === 'undefined' || modal_elements[i].func == '') {
                            modal_elements[i].func = 'defalutlModalBodyMessage';
                        }

                        if (typeof modal_elements[i].parameters === 'undefined' || modal_elements[i].func == '') {
                            var modalBody = window[modal_elements[i].func]();
                        } else {
                            var modalBody = window[modal_elements[i].func](modal_elements[i].parameters);
                        }

                        /*Estableciendo los nuevos valores del modal*/
                        $('#myModal div.modal-header h4#myModalLabel').append(modal_elements[i].header);
                        if (modalBody != '') {
                            $('#myModal div.modal-body').append(modalBody);
                            if (typeof modal_elements[i].closeBtnName === 'undefined' || modal_elements[i].closeBtnName == '') {
                                $('#myModal div.modal-footer').append(modal_elements[i].footer + '<button type="button" class="btn btn-default" data-dismiss="modal" style="color: #636363;font-weight: bold;">Cerrar</button>');
                            } else {
                                $('#myModal div.modal-footer').append(modal_elements[i].footer + '<button type="button" class="btn btn-default" data-dismiss="modal" style="color: #636363;font-weight: bold;">'+modal_elements[i].closeBtnName+'</button>');
                            }
                        } else {
                            $('#myModal div.modal-body').append(window['defalutlModalBodyMessage']());
                            $('#myModal div.modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal" style="color: #636363;font-weight: bold;">Cerrar</button>');
                        }

                        if (typeof modal_elements[i].afterLoadCallFunction !== 'undefined' && modal_elements[i].afterLoadCallFunction != '') {
                            window[modal_elements[i].afterLoadCallFunction]();
                        }

                        if (typeof modal_elements[i].widthModal !== 'undefined' && modal_elements[i].widthModal != '') {
                            /*$('div#myModal').css({ 'width': modal_elements[i].widthModal+'px', 'margin-left': '-'+(modal_elements[i].widthModal/2)+'px' });*/
                            $('div#myModal div.modal-dialog').css({ 'width': modal_elements[i].widthModal+'px' });
                        }

                    } else {
                        if (typeof modal_elements[i].emptyMessage === 'undefined') {
                            var mBody = '<i class="icon-exclamation-sign" style="margin-right:7px;"></i>\
                                         No se ha seleccionado ningun elemento del cual se puedan mostrar los detalles,\
                                         por favor seleccione uno e intente nuevamente.';

                            modal_elements[i].emptyMessage = [ {emptyMTitle: 'Elemento no seleccionado', emptyMBody: mBody } ];
                        } else  {
                            
                            if (typeof modal_elements[i].emptyMessage[0].emptyMTitle === 'undefined' || modal_elements[i].emptyMessage[0].emptyMTitle == '') {
                                modal_elements[i].emptyMessage[0].emptyMTitle = 'Elemento no seleccionado';
                            }

                            if (typeof modal_elements[i].emptyMessage[0].emptyMBody === 'undefined' || modal_elements[i].emptyMessage[0].emptyMBody == '') {
                                modal_elements[i].emptyMessage[0].emptyMBody = '<i class="icon-exclamation-sign" style="margin-right:7px;"></i>\
                                         No se ha seleccionado ningun elemento del cual se puedan mostrar los detalles,\
                                         por favor seleccione uno e intente nuevamente.';
                            }
                        }
                        
                        $('#myModal div.modal-header h4#myModalLabel').empty();
                        $('#myModal div.modal-body').empty();
                        $('#myModal div.modal-footer').empty();

                        $('#myModal div.modal-header h4#myModalLabel').append(modal_elements[i].emptyMessage[0].emptyMTitle);
                        $('#myModal div.modal-body').append(modal_elements[i].emptyMessage[0].emptyMBody);
                        $('#myModal div.modal-footer').append('<button class="action" data-dismiss="modal" aria-hidden="true"><span class="label">Cerrar</span></button>');
                    }
                }
            }
        } else {
            $('#myModal div.modal-header h4#myModalLabel').empty();
            $('#myModal div.modal-body').empty();
            $('#myModal div.modal-footer').empty();

            $('#myModal div.modal-header h4#myModalLabel').append('Error!!!');
            $('#myModal div.modal-body').append('<div class="alert alert-error">\
                                                     <h4>Ops! ha ocurrido un error</h4>\
                                                     Lo sentimos pero ha ocurrido un error, por favor intente nuevamente, si el problema persiste por favor contacte con el administrador\
                                                 </div>');
            $('#myModal div.modal-footer').append('<button class="action" data-dismiss="modal" aria-hidden="true"><span class="label">Cerrar</span></button>');

        }
    });
});