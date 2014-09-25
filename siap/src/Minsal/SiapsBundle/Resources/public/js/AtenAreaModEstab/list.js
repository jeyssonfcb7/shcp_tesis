$(document).ready(function() {
    $('#reporte').click(function() {
        url = Routing.generate('_report_show') + '/rCarteraServicios/PDF';
        window.open(url, '_blank');
        return false;
    });

});

