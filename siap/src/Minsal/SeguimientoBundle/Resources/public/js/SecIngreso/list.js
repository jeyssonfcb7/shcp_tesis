$(document).ready(function() {
    $('select[id$="servicio_ingreso"]').prepend('<option/>').val(function(){ return $('[selected]',this).val(); });
    $('select[id$="servicio_ingreso"]').select2({
        placeholder: 'Seleccionar...',
        allowClear:  true,
        width:       '50%'
    });

    $("#fecha_nacimiento").datepicker().mask("99-99-9999");
    $("#nec").focus();

    //PASANDO A MAYUSCULAS LOS ELEMENTOS
    $("#primer_apellido").keyup(function() {
        $(this).val(limpiar_nombres($("#primer_apellido").val()));
    });
    $("#segundo_apellido").keyup(function() {
        $(this).val(limpiar_nombres($("#segundo_apellido").val()));
    });

    $("#apellido_casada").keyup(function() {
        $(this).val(limpiar_nombres($("#apellido_casada").val()));
    });

    $("#primer_nombre").keyup(function() {
        $(this).val(limpiar_nombres($("#primer_nombre").val()));
    });

    $("#segundo_nombre").keyup(function() {
        $(this).val(limpiar_nombres($("#segundo_nombre").val()));
    });

    $("#tercer_nombre").keyup(function() {
        $(this).val(limpiar_nombres($("#tercer_nombre").val()));
    });

    $.getJSON(Routing.generate('get_servicios_hospitalarios_todos'),
            function(data) {
                $.each(data.especialidades, function(indice, aux) {
                    $('#servicio_ingreso').append('<option value="' + aux.id + '">' + aux.nombre + '</option>');
                });
            });

    $("#buscar").click(function() {
        if ($("#nec").val() != '') {
            regexp = /^[0-9]{1,}$/;
            var valores = $("#nec").val().split('-');
            if (valores.length > 2) {//VERIFICA SI TIENE MAS DE DOS GUIONES
                /*PARA MOSTRAR MENSAJE DE ERROR DE FORMATO DE EXPEDIENTE
                 * PRIMERO SE CREA O ELIMINA EL ELEMENTO
                 * LUEGO SE CREA CON EL MENSAJE ADECUADO Y SE COLOCA
                 * LUEGO DEL FORMULARIO PARA ABRIRSE.
                 * */
                ($('#error')) ? $('#error').remove() : '';
                var elem = $("<div id='error' title='Error de Formato de Expediente'><center>" +
                        "El formato del número de expediente no es el adecuado."
                        + "</center></div>");
                elem.insertAfter($("#buscarForm"));
                $("#error").dialog({
                    close: function() {
                        $("#nec").val('');
                        $("#nec").focus();
                    }
                });
                return false;
            } else {
                if (!regexp.test(valores[0])) {//CONTIENE LETRAS EN INFINITO
                    /*PARA MOSTRAR MENSAJE DE ERROR DE FORMATO DE EXPEDIENTE
                     * PRIMERO SE CREA O ELIMINA EL ELEMENTO
                     * LUEGO SE CREA CON EL MENSAJE ADECUADO Y SE COLOCA
                     * LUEGO DEL FORMULARIO PARA ABRIRSE.
                     * */
                    ($('#error')) ? $('#error').remove() : '';
                    var elem = $("<div id='error' title='Error de escritura'><center>" +
                            "El Número de Expediente no puede contener letras"
                            + "</center></div>");
                    elem.insertAfter($("#buscarForm"));
                    $("#error").dialog({
                        close: function() {
                            $("#nec").val('');
                            $("#nec").focus();
                        }
                    });
                    return false;
                } else {
                    if (valores.length > 1) {
                        if (!regexp.test(valores[1])) {
                            /*PARA MOSTRAR MENSAJE DE ERROR DE FORMATO DE EXPEDIENTE
                             * PRIMERO SE CREA O ELIMINA EL ELEMENTO
                             * LUEGO SE CREA CON EL MENSAJE ADECUADO Y SE COLOCA
                             * LUEGO DEL FORMULARIO PARA ABRIRSE.
                             * */
                            ($('#error')) ? $('#error').remove() : '';
                            var elem = $("<div id='error' title='Error de escritura'><center>" +
                                    "El Número de Expediente no puede contener letras"
                                    + "</center></div>");
                            elem.insertAfter($("#buscarForm"));
                            $("#error").dialog({
                                close: function() {
                                    $("#nec").val('');
                                    $("#nec").focus();
                                }
                            });
                            return false;
                        } else {
                            $("#capturar").show();
                            $('#resultadoBusqueda').load(Routing.generate('buscar_ingresos'));
                            $('#resultadoBusqueda').show();
                            // $("#buscarGlobal").show();
                            //$("#buscar").show();
                        }
                    } else {
                        $("#capturar").show();
                        $('#resultadoBusqueda').load(Routing.generate('buscar_ingresos'));
                        $('#resultadoBusqueda').show();
                        // $("#buscarGlobal").show();
                        //$("#buscar").show();
                    }
                }
            }
        } else {
            if ($("#servicio_ingreso").val() != '') {
                $('#resultadoBusqueda').load(Routing.generate('buscar_ingresos'));
                $('#lresultado').show();
                $('#resultadoBusqueda').show();
            } else {
                if ($("#nec").val() != '') {

                    $('#resultadoBusqueda').load(Routing.generate('buscar_ingresos'));
                    $('#lresultado').show();
                    $('#resultadoBusqueda').show();
                } else {
                    if ($("#fecha_nacimiento").val() != '') {
                        $('#resultadoBusqueda').load(Routing.generate('buscar_ingresos'));
                        $('#lresultado').show();
                        $('#resultadoBusqueda').show();
                    }
                    else {
                        if ($("#primer_apellido").val() == '' && $("#primer_nombre").val() == '') {
                            //SE ELIMINA O SE CREA EL ELEMENTO
                            ($('#error')) ? $('#error').remove() : '';
                            //SE LE ASIGNA VALOR AL ELEMENTO
                            var elem = $("<div id='error' title='Campos Obligatorios'>" +
                                    "Los campos:\n\
                <ul><li> <strong>Primer Apellido</strong> </li><li><strong>Primer Nombre</strong></li></ul>\n\
                <center>Son obligatorios<center></div>");
                            //SE AGREGA LUEGO DEL FORMULARIO
                            elem.insertAfter($("#buscarForm"));
                            //SE DEFINEN LAS PROPIEDADES DE LA VENTANA Y SE ABRE.
                            $("#error").dialog({
                                close: function() {
                                    $("#primer_apellido").focus();
                                }
                            });
                        } else {
                            $('#resultadoBusqueda').load(Routing.generate('buscar_ingresos'));
                            $('#lresultado').show();
                            $('#resultadoBusqueda').show();
                        }
                    }
                }
            }
        }
        return false;   
    });

    $('#lresultado').hide();

});