$(document).ready(function() {
    $("#tPacientesEmergencias").jqGrid({
        url: Routing.generate('cargar_emergencias'),
        postData: $('#buscarForm').serialize(),
        datatype: 'json',
        altRows: true,
        height: "100%",
        hidegrid: false,
        caption: "Detalle de Emergencias",
        colNames: ['id','Acciones','NEC', 'Nombre del Paciente','Apellido Paciente', 'F. NAC.','No. Urgencia','Fecha de Emergencia' ],
        colModel: [
            {name: 'id', index: 'numero', editable: false, width: 125},
            {name: 'acciones', index: 'acciones', editable: false, width: 250, align: "center"},
            {name: 'numero', index: 'numero', editable: false, width: 125},
            {name: 'nombre_paciente', index: 'nombre_paciente', editable: false, width: 325},
            {name: 'apellido_paciente', index: 'apellido_paciente', editable: false, width: 325},
            {name: 'fecha_nacimiento', index: 'fecha_nacimiento', editable: false, width: 175, align: "center"},
            {name: 'numero_urgencia', index: 'numero_urgencia', editable: false, width: 120, align: "center"},
            {name: 'fecha_emergencia', index: 'fecha_emergencia', editable: false, width: 150, align: "center"},
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
    ).hideCol(['id']);;
    
/*para exportar reportes
    $('#exportar_hoja_calculo').click(function() {
        if ($('.ui-paging-info').text() != 'Sin registros que mostrar') {
            if ($('#servicio_ingreso').val() == '')
                url = Routing.generate('total_ingresos') + '/rpt_resumen_ingresos/XLS/' + $('#fecha_inicio').val() + '/' + $('#fecha_fin').val();
            else
                url = Routing.generate('total_ingresos') + '/rpt_resumen_ingresos/XLS/' + $('#fecha_inicio').val() + '/' + $('#fecha_fin').val() + '/' + $('#servicio_ingreso').val();
            window.open(url, '_blank');
            return false;
        }
        else {
            return false;
        }

    });
    $('#exportar_pdf').click(function() {
        if ($('.ui-paging-info').text() != 'Sin registros que mostrar') {
            if ($('#servicio_ingreso').val() == '')
                url = Routing.generate('total_ingresos') + '/rpt_resumen_ingresos/PDF/' + $('#fecha_inicio').val() + '/' + $('#fecha_fin').val();
            else
                url = Routing.generate('total_ingresos') + '/rpt_resumen_ingresos/PDF/' + $('#fecha_inicio').val() + '/' + $('#fecha_fin').val() + '/' + $('#servicio_ingreso').val();
            window.open(url, '_blank');
            return false;
        }
        else {
            return false;
        }
    });
*/
});

