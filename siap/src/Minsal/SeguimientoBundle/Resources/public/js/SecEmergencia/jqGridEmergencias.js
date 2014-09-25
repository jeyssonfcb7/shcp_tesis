$(document).ready(function() {
    $("#tPacientesEmergencias").jqGrid({
        url: Routing.generate('pacientes_en_emergencia'),
        postData: $('#pacientesEmergencia').serialize(),
        datatype: 'json',
        altRows: true,
        height: "100%",
        hidegrid: false,
        caption: "Detalle de Emergencias",
        colNames: ['Número Expediente', 'Nombre del Paciente', 'F. NAC.','Fecha de Emergencia','No. de Emergencia' ],
        colModel: [
            {name: 'numero', index: 'numero', editable: false, width: 125},
            {name: 'nombre_paciente', index: 'nombre_paciente', editable: false, width: 325},
            {name: 'fecha_nacimiento', index: 'fecha_nacimiento', editable: false, width: 175, align: "center"},
            {name: 'fecha_emergencia', index: 'fecha_emergencia', editable: false, width: 120, align: "center"},
            {name: 'numero_emergencia', index: 'numero_emergencia', editable: false, width: 150, align: "center"}
        ],
        multiselect: false,
        rowNum: 20,
        rowList: [20, 40, 60],
        loadonce: true,
        autowidth:true,
        pager: jQuery('#pagerpacientesEmergencias'),
        viewrecords: true,
        loadComplete: function() {
            $('#lregistro').text('Total de registros: ' + $(this).getGridParam('records'));                        
        }
    }).jqGrid('navGrid', '#pagerpacientesEmergencias',
            {edit: false, add: false, del: false, search: false, refresh: false}
    );
    
//para exportar reportes
    $('#exportar_hoja_calculo').click(function() {
        alert('hola');
        if ($('.ui-paging-info').text() != 'Sin registros que mostrar') {
            url = Routing.generate('total_emergencias') + '/rpt_resumen_emergencias/XLS/' + $('#fecha_inicio').val() + '/' + $('#fecha_fin').val();
            window.open(url, '_blank');
            return false;
        }
        else {
            return false;
        }

    });
    $('#exportar_pdf').click(function() {
        if ($('.ui-paging-info').text() != 'Sin registros que mostrar') {
            url = Routing.generate('total_emergencias') + '/rpt_resumen_emergencias/PDF/' + $('#fecha_inicio').val() + '/' + $('#fecha_fin').val();
            window.open(url, '_blank');
            return false;
        }
        else {
            return false;
        }
    });

});

