$(document).ready(function() {
    $('#servicio_ingreso').select2({
      width: '60%',
      placeholder:'Seleccione...',
      allowClear:true
    });
  
    $("#fecha_inicio").datepicker().mask("99-99-9999");
    $("#fecha_fin").datepicker().mask("99-99-9999");

    $("#emitir_informe").click(function() {
        if ($("#fecha_inicio").val() == '' || $("#fecha_fin").val() == '') {
            ($('#error')) ? $('#error').remove() : '';
            var elem = $("<div id='error' title='Error de llenado'><center>" +
                    "Debe de seleccionar ambas fechas para generar el reporte."
                    + "</center></div>");
            elem.insertAfter($("#pacientesIngresados"));
            $("#error").dialog({
                close: function() {
                    if ($("#fecha_inicio").val() == '')
                        $("#fecha_inicio").focus();
                    else
                        $("#fecha_fin").focus();
                }
            });
        } else if( $("#fecha_inicio").datepicker("getDate") > $("#fecha_fin").datepicker("getDate")){
            ($('#error')) ? $('#error').remove() : '';
            var elem = $("<div id='error' title='Error de llenado'><center>" +
                    "La fecha de inicio debe de ser menor que la fecha fin."
                    + "</center></div>");
            elem.insertAfter($("#pacientesIngresados"));
            $("#error").dialog({
                close: function() {
                    $("#fecha_inicio").val('');
                    $("#fecha_fin").val('');
                    $("#fecha_inicio").focus();
                }
            });
        } else {
            $('#resultado').load(Routing.generate('buscar_ingresos_pacientes'), {'datos': $('#pacientesIngresados').serialize()});
        }
        return false;
    });

    $.getJSON(Routing.generate('get_servicios_hospitalarios_todos'),
            function(data) {
                $.each(data.especialidades, function(indice, aux) {
                    $('#servicio_ingreso').append('<option value="' + aux.id + '">' + aux.nombre + '</option>');
                });
            });
});

