$(document).ready(function() {
    $("#tBuscarPaciente").jqGrid({
        url: Routing.generate('cargar_ingresos'),
        postData: $('#buscarForm').serialize(),
        datatype: 'json',
        altRows: true,
        height: "100%",
        width: "100%",
        hidegrid: false,
        colNames: ['idPaciente', 'Acciones', 'No. Expediente', 'Apellidos', 'Nombres', 'F. NAC.', 'Servicio \n Ingreso', 'Diagnóstico \n Presuntivo', 'Fecha de Ingreso'],
        colModel: [
            {name: 'id', index: 'id', editable: false},
            {name: 'acciones', index: 'acciones', editable: false, width: 100, align: "center"},
            {name: 'nec', index: 'nec', editable: false, width: 100, align: "center"},
            {name: 'apellidos', index: 'apellidos', editable: false, width: 200},
            {name: 'nombres', index: 'nombres', editable: false, width: 200},
            {name: 'fecha_nacimiento', index: 'fecha_nacimiento', editable: false, width: 70, align: "center"},
            {name: 'servicio', index: 'servicio', editable: false, width: 100, align: "center"},
            {name: 'diagnostico', index: 'diagnostico', editable: false, width: 100, align: "center"},
            {name: 'fecha_ingreso', index: 'fecha_ingreso', editable: false, width: 80, align: "center"}
        ],
        multiselect: false,
        rowNum: 10,
        rowList: [10, 20, 30],
        loadonce: true,
        pager: jQuery('#pBuscarPaciente'),
        viewrecords: true,
        loadComplete: function() {
            $('#lregistro').text('Total de pacientes: ' + $(this).getGridParam('records'));
        },
        gridComplete: function() {
            var ids = jQuery("#tBuscarPaciente").jqGrid('getDataIDs');
            for (var i = 0; i < ids.length; i++) {
                var cl = ids[i];
                if (cl != 0) {
                    ce = "<a class=\"btn sonata-action-element\" href=\"" + cl + "\/view\"><i class=\"icon-folder-open\"></i>Detalle</a>";
                    jQuery("#tBuscarPaciente").jqGrid('setRowData', ids[i], {acciones: ce});
                }
            }
        }
    })
            .jqGrid('navGrid', '#pBuscarPaciente',
            {edit: false, add: false, del: false, search: false, refresh: false}
    ).hideCol(['id']);
});