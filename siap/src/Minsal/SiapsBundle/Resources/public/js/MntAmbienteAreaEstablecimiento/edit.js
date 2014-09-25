$(document).ready(function() {

    $('#areas-modalidad').select2({
        placeholder: 'Seleccionar...',
        width:       '41.66666667%',
        allowClear:  true
    });

    $('select[id$="_idAtencion"]').select2({
        placeholder: 'Seleccionar...',
        width:       '41.66666667%',
        allowClear:  true
    });

    $('i').popover('show');
    //DESHABILITAR LAS ATENCIONES 
    $('select[id$="_idAtencion"]').attr('disabled', 'disabled');
    $('#por_sexo').attr('disabled', 'disabled');
    $('select[id$="_idServicioExternoEstablecimiento"]').attr('disabled', 'disabled');
    $('#numero_ambientes').attr('disabled', 'disabled');
    //CARGAR LAS MODALIDADES QUE TIENEN HOSPITALIZACIÓN PARA EL ESTABLECIMIENTO CONFIGURADO
    //SI NO POSEEN NINGUNA ENTONCES EL FORMULARIO ESTARÁ DESHABILITADO
    $.getJSON(Routing.generate('get_areas_modalidades'),
            function(data) {
                $.each(data.areas, function(indice, area) {
                    $('#areas-modalidad').append('<option value="' + area.id + '">' + area.nombre + '</option>');
                });
            });

    //CARGAS LAS ESPECIALIDADES Y SUBESPECIALIDADES DEL ÁREA DE HOSPITALIZACIÓN
    $('#areas-modalidad').change(function() {
        $('select[id$="_idAtencion"]').children().remove();
        $('select[id$="_idAtencion"]').append('<option></option>');
        if ($('#areas-modalidad').val() == 0)
            $('select[id$="_idAtencion"]').attr('disabled', 'disabled');
        else {
            $('#por_sexo').attr('disabled', 'disabled');
            $('#numero_ambientes').attr('disabled', 'disabled');
            $('input[name="btn_generar"]').hide();
            $('input[name="btn_guardar"]').hide();
            $('input[name="btn_guardar_otro"]').hide();
            $('#resultados').hide();
            $.getJSON(Routing.generate('get_especialidades_hospitalizacion') + '?idAreaModEstab=' + $('#areas-modalidad').val(),
                    function(data) {
                        $.each(data.especialidades, function(indice, especialidad) {
                            $('select[id$="_idAtencion"]').append('<option value="' + especialidad.id + '">' + especialidad.nombre + '</option>');
                        });
                        $('select[id$="_idAtencion"]').removeAttr('disabled');
                    });
        }
    });

    $('select[id$="_idAtencion"]').change(function() {
        $('#por_sexo').removeAttr('disabled');
        $('#numero_ambientes').removeAttr('disabled');
        $('input[name="btn_generar"]').show();
        $('input[name="btn_guardar"]').hide();
        $('input[name="btn_guardar_otro"]').hide();
        $('#resultados').hide();
    });
    $('input[name="btn_guardar"]').hide();
    $('input[name="btn_guardar_otro"]').hide();

    $('#resultados').hide();
    $('input[name="btn_generar"]').hide().click(function() {
        $('#resultados').load(Routing.generate('generar_servicios_hospitalarios') + '?idAtenAreaModEstab=' + $('select[id$="_idAtencion"]').val() + "&porSexo=" + $('#por_sexo').is(':checked') + "&numeroAmbientes=" + $('#numero_ambientes').val());
        $('#resultados').show();
        $('input[name="btn_guardar"]').show();
        $('input[name="btn_guardar_otro"]').show();
        $('#idAtenModEstab').val($('select[id$="_idAtencion"]').val());
    });

    $('form').submit(function() {
        $('select[id$="_idAtencion"]').removeAttr('disabled');
    });

});


