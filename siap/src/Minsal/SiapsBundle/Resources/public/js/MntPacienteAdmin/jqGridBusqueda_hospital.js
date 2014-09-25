$(document).ready(function() {
    $("#tBuscarPaciente").jqGrid({
        url: Routing.generate('cargar_paciente') + '?tipo_busqueda=' + $('#tipo').val(),
        postData: $('#buscarForm').serialize(),
        datatype: 'json',
        altRows: true,
        height: "100%",
        width: "100%",
        hidegrid: false,
        colNames: ['idPaciente', 'Acciones', 'NEC', 'Apellidos', 'Nombres', 'F. NAC.', 'Documento', 'Nombre Madre', 'Conocido por','Servicio Ingreso', 'Diagnóstico Presuntivo', 'Fecha de Ingreso'],
        colModel: [
            {name: 'id', index: 'id', editable: false},
            {name: 'acciones', index: 'acciones', editable: false, width: 100, align: "center"},
            {name: 'nec', index: 'nec', editable: false, width: 100, align: "center"},
            {name: 'apellidos', index: 'apellidos', editable: false, width: 200},
            {name: 'nombres', index: 'nombres', editable: false, width: 200},
            {name: 'fecha_nacimiento', index: 'fecha_nacimiento', editable: false, width: 85, align: "center"},
            {name: 'documento', index: 'documento', editable: false, width: 130, align: "center"},
            {name: 'nombre_madre', index: 'nombre_madre', editable: false, width: 240},
            {name: 'conocido_por', index: 'conocido_por', editable: false, width: 200},
            {name: 'servicio', index: 'servicio', editable: false, width: 150, align: "center"},
            {name: 'diagnostico', index: 'diagnostico', editable: false, width: 200, align: "center"},
            {name: 'fecha_ingreso', index: 'fecha_ingreso', editable: false, width: 120, align: "center"}

        ],
        multiselect: false,
        rowNum: 10,
        rowList: [10, 20, 30],
        loadonce: true,
        pager: jQuery('#pBuscarPaciente'),
        viewrecords: true,
        loadComplete: function() {
            $('#lregistro').text('Total de registros: ' + $(this).getGridParam('records'));
            /*if ($('#tipo').val() == 'g'){
             $("#capturar").show();
             $('#buscar').show();
             }else{
             $('#buscar').hide();
             }*/

        },
    }).jqGrid('navGrid', '#pBuscarPaciente',
            {edit: false, add: false, del: false, search: false, refresh: false}
    )
            .hideCol(['id']);
});

