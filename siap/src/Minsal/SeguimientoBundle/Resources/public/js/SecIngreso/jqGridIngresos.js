$(document).ready(function() {
    $("#tPacientesIngresados").jqGrid({
        url: Routing.generate('pacientes_ingresados'),
        postData: $('#pacientesIngresados').serialize(),
        datatype: 'json',
        altRows: true,
        height: "100%",
        hidegrid: false,
        caption: "Detalle de Ingresos",
        colNames: ['Número Expediente', 'Nombre del Paciente', 'F. NAC.','Fecha de Ingreso','Servicio Ingreso', 'Diagnóstico Presuntivo' ],
        colModel: [
            {name: 'numero', index: 'numero', editable: false, width: 125},
            {name: 'nombre_paciente', index: 'nombre_paciente', editable: false, width: 325},
            {name: 'fecha_nacimiento', index: 'fecha_nacimiento', editable: false, width: 175, align: "center"},
            {name: 'fecha_ingreso', index: 'fecha_ingreso', editable: false, width: 120, align: "center"},
            {name: 'servicio', index: 'servicio', editable: false, width: 150, align: "center"},
            {name: 'diagnostico', index: 'diagnostico', editable: false, width: 200, align: "center"}            
        ],
        multiselect: false,
        rowNum: 20,
        rowList: [20, 40, 60],
        loadonce: true,
        autowidth:true,
        pager: jQuery('#pagerpacientesIngresados'),
        viewrecords: true,
        loadComplete: function() {
            $('#lregistro').text('Total de registros: ' + $(this).getGridParam('records'));                        
        }
    }).jqGrid('navGrid', '#pagerpacientesIngresados',
            {edit: false, add: false, del: false, search: false, refresh: false}
    );
    
//para exportar reportes
    $('#exportar_hoja_calculo').click(function() {
        alert('hola');
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

});

