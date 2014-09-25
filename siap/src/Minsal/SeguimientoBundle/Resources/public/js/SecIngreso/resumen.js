$(document).ready(function() {
    $('#resultadoBusqueda').load(Routing.generate('buscar_ingresos'));
     $('#lresultado').show();
    $('#resultadoBusqueda').show();
});