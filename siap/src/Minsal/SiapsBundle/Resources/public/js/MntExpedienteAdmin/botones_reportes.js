$(document).ready(function() {
    $('#exportar_hoja_calculo').click(function() {
        if ($('.ui-paging-info').text() != 'Sin registros que mostrar') {
            url = Routing.generate('_exportar_reporte') + '/expedientes_creados/xls?fecha_inicio=' + $('#fecha_inicio').val() + '&fecha_fin=' + $('#fecha_fin').val()+ '&usuario=' + $('select[id$="usuario"] option:selected').val();
            window.open(url, '_blank');
            return false;
        }
        else {
            return false;
        }

    });
    
    $('#exportar_pdf').click(function() {
        if ($('.ui-paging-info').text() != 'Sin registros que mostrar') {
            url = Routing.generate('_exportar_reporte') + '/expedientes_creados/PDF?fecha_inicio=' + $('#fecha_inicio').val() + '&fecha_fin=' + $('#fecha_fin').val()+ '&usuario=' + $('select[id$="usuario"] option:selected').val();
            window.open(url, '_blank');
            return false;
        }
        else {
            return false;
        }

    });
});

