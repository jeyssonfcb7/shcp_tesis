/*  src/Minsal/SeguimientoBundle/Resource/public/js/SecIngreso/edit.html.twig
 *  Se utiliza para la creación y actualización de los ingresos.
 */

$(document).ready(function() {

    $('select[id$="_idEstablecimientoReferencia"]').select2({
        placeholder: 'Seleccionar...',
        allowClear: true,
        width: '100%'
    });

    $('select[id$="_idProcedenciaIngreso"]').prepend('<option/>').val(function() {
        return $('[selected]', this).val();
    });
    $('select[id$="_idProcedenciaIngreso"]').select2({
        placeholder: 'Seleccione la procedencia del ingreso...',
        allowClear: true,
        width: '100%'
    });

    $('select[id$="_idCircunstanciaIngreso"]').prepend('<option/>').val(function() {
        return $('[selected]', this).val();
    });
    $('select[id$="_idCircunstanciaIngreso"]').select2({
        placeholder: 'Seleccione la circunstancia del ingreso...',
        allowClear: true,
        width: '100%'
    });

    $('select[id$="_idAtenAreaModEstab"]').prepend('<option/>').val(function() {
        return $('[selected]', this).val();
    });
    $('select[id$="_idAtenAreaModEstab"]').select2({
        placeholder: 'Seleccionar...',
        allowClear: true,
        width: '100%'
    });

    $('select[id$="_hora_hour"]').prepend('<option/>').val(function() {
        return $('[selected]', this).val();
    });
    $('select[id$="_hora_hour"]').select2({
        placeholder: 'Hora...',
        allowClear: true
    });

    $('select[id$="_hora_minute"]').prepend('<option/>').val(function() {
        return $('[selected]', this).val();
    });
    $('select[id$="_hora_minute"]').select2({
        placeholder: 'Minutos...',
        allowClear: true
    });

    $('select[id$="_idAmbienteIngreso"]').select2({
        placeholder: 'Seleccionar...',
        allowClear: true,
        width: '100%'
    });

    $('select[id$="_idTipoAccidente"]').select2({
        placeholder: 'Seleccione si existiera...',
        allowClear: true,
        width: '100%'

    });

    $('select[id$="_idEmpleado"]').select2({
        placeholder: 'Seleccionar...',
        allowClear: true,
        width: '100%'
    });

    /*COLOCAR LOS DATEPICKER Y LOS IMPUT MASK A LOS CAMPOS DE FECHA*/

    if ($('input[id$="_fecha"]').val() == '')
        $('input[id$="_fecha"]').datepicker().mask("99-99-9999").datepicker("setDate", "0");
    else
        $('input[id$="_fecha"]').datepicker().mask("99-99-9999");
    $('input[id$="_fechaProbableParto"]').datepicker({
        minDate: "-0m",
        maxDate: "+9m"
    }).mask("99-99-9999");



    /*OCULTAR LO RELACIONADO A LO OBSTETRICO*/
    $('div[id$="_embarazada"]').hide();
    $('div[id$="_fechaProbableParto"]').hide();
    $('div[id$="_semanasAmenorrea"]').hide();

    /*VALIDAR SI ES MUJER Y SI ESTA EMBARAZADA*/
    if ($("#sexo").val() == 2 && $("#embarazo").val() == '1')
        $('div[id$="_embarazada"]').show();

    /*AL DAR CLIC EN EMBARAZADA */
    //$('input:checkbox[name*="embarazada"]').click(function() {
    //if (
    
    if ($('input:checkbox[name*="embarazada"]').prop('checked')) {
        $('div[id$="_fechaProbableParto"]').show();
        $('div[id$="_semanasAmenorrea"]').show();
    } else {
        $('div[id$="_fechaProbableParto"]').hide();
        $('div[id$="_semanasAmenorrea"]').hide();
    }
    $('input:checkbox[name*="embarazada"]').on('ifChecked', function(event) {
        $('div[id$="_fechaProbableParto"]').show();
        $('div[id$="_semanasAmenorrea"]').show();
    });

    $('input:checkbox[name*="embarazada"]').on('ifUnchecked', function(event) {
        $('div[id$="_fechaProbableParto"]').hide();
        $('div[id$="_semanasAmenorrea"]').hide();
        $('input[id$="_fechaProbableParto"]').val('');
        $('input[id$="_semanasAmenorrea"]').val('');
    });
    //});
    $('select[id$="_idAtenAreaModEstab"]').on("change", function(e) {
        $('select[id$="idAmbienteIngreso"]').children().remove();

        $('select[id$="idAmbienteIngreso"]').prepend('<option/>').val(function() {
            return $('[selected]', this).val();
        });
        $('select[id$="idAmbienteIngreso"]').select2({
            placeholder: 'Seleccionar...',
            allowClear: true,
            width: '100%'
        });

        if (e.val) {
            $.getJSON(Routing.generate('get_servicios_hospitalarios') + '?idAtenAreaModEstab=' + e.val, function(data) {
                $.each(data.especialidades, function(indice, aux) {
                    if (aux.nombreAmbiente != "") {
                        $('select[id$="idAmbienteIngreso"]').append($('<option>', {value: aux.id, text: aux.nombreAmbiente}));
                    }
                });

                $('select[id$="idAmbienteIngreso"]').append($('<option>', {value: 'n', text: '-------------------', disabled: true}));
                $.getJSON(Routing.generate('get_servicios_hospitalarios_otros') + '?idAtenAreaModEstab=' + e.val, function(data) {
                    $.each(data.especialidades, function(indice, aux) {
                        if (aux.nombreAmbiente != "") {
                            $('select[id$="idAmbienteIngreso"]').append($('<option>', {value: aux.id, text: aux.nombreAmbiente}));
                        }
                    });
                });
                $('select[id$="idAmbienteIngreso"]').select2('readonly', false);
            });
        } else {
            $('select[id$="idAmbienteIngreso"]').select2('readonly', true);
        }
    });

    /*CARGAR LAS ESPECIALIDADES DE HOSPITALIZACION*/

    if ($('select[id$="_idAtenAreaModEstab"]').select2('val') == '') {
        $.getJSON(Routing.generate('get_especialidad_ingresos'),
                function(data) {
                    $('select[id$="_idAtenAreaModEstab"]').children().remove();
                    $('select[id$="_idAtenAreaModEstab"]').append('<option></option>');
                    $.each(data.especialidades, function(indice, aux) {
                        $('select[id$="_idAtenAreaModEstab"]').append($('<option>', {value: aux.id, text: aux.nombre}));
                    });
                    $('select[id$="_idAtenAreaModEstab"]').select2('readonly', false);
                    $('select[id$="_idProcedenciaIngreso"]').focus();
                });
    } else {

        $.getJSON(Routing.generate('get_especialidad_ingresos'),
                function(data) {
                    var aux2 = $('select[id$="_idAtenAreaModEstab"]').select2('val');
                    $('select[id$="_idAtenAreaModEstab"]').children().remove();
                    $('select[id$="_idAtenAreaModEstab"]').append('<option></option>');
                    $.each(data.especialidades, function(indice, aux) {
                        $('select[id$="_idAtenAreaModEstab"]').append($('<option>', {value: aux.id, text: aux.nombre}));
                    });
                    $('select[id$="_idAtenAreaModEstab"]').select2('val', aux2);
                    $('select[id$="_idAtenAreaModEstab"]').select2('readonly', false);
                    $('select[id$="_idProcedenciaIngreso"]').focus();
                });
    }
    
    if ($('select[id$="_idAtenAreaModEstab"]').select2('val') != '') {
        var aux2 = $('select[id$="idAmbienteIngreso"]').select2('val');

        $('select[id$="_idAmbienteIngreso"]').children().remove();
        $('select[id$="_idAmbienteIngreso"]').prepend('<option/>').val(function() {
            return $('[selected]', this).val();
        });
        $('select[id$="_idAmbienteIngreso"]').select2({
            placeholder: 'Seleccionar...',
            allowClear: true,
            width: '100%'
        });
        var especialidad = $('select[id$="_idAtenAreaModEstab"]').select2('val');
        $.getJSON(Routing.generate('get_servicios_hospitalarios') + '?idAtenAreaModEstab=' + especialidad, function(data) {
            $.each(data.especialidades, function(indice, aux) {
                if (aux.nombreAmbiente != "") {
                    $('select[id$="idAmbienteIngreso"]').append($('<option>', {value: aux.id, text: aux.nombreAmbiente}));
                }
            });

            $('select[id$="idAmbienteIngreso"]').append($('<option>', {value: 'n', text: '-------------------', disabled: true}));
            $.getJSON(Routing.generate('get_servicios_hospitalarios_otros') + '?idAtenAreaModEstab=' + especialidad, function(data) {
                $.each(data.especialidades, function(indice, aux) {
                    if (aux.nombreAmbiente != "") {
                        $('select[id$="idAmbienteIngreso"]').append($('<option>', {value: aux.id, text: aux.nombreAmbiente}));
                    }
                });
            });
            $('select[id$="idAmbienteIngreso"]').select2('readonly', false);
            $('select[id$="idAmbienteIngreso"]').select2('val', aux2);
        });
    } else {
        $('select[id$="idAmbienteIngreso"]').children().remove();

        $('select[id$="idAmbienteIngreso"]').prepend('<option/>').val(function() {
            return $('[selected]', this).val();
        });
        $('select[id$="idAmbienteIngreso"]').select2({
            placeholder: 'Seleccionar...',
            allowClear: true
        });

        $('select[id$="idAmbienteIngreso"]').select2('readonly', true);
    }
    /*COLOCAR HORA ACTUAL DEL SISTEMA*/
    if ($('select[id$="_hora_hour"]').select2('val') == '') {
        var dia = new Date();
        $('select[id$="_hora_hour"]').select2('val',dia.getHours());
        $('select[id$="_hora_minute"]').select2('val',dia.getMinutes());
    }
});