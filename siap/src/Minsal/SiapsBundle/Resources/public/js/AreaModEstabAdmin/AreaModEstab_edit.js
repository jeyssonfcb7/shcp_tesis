$(document).ready(function() {
    $listado = $('ul[id$="_atenciones"]');
    $listado.hide();
    $capa_listado = $listado.parent().append('<div id="tree" style="width:50%;"></div>');
    
    $('select[id$="_idModalidadEstab"]').select2({
        placeholder: 'Seleccione...',
        allowClear:  true,
	width: 'resolve'
    });

    $('select[id$="_idAreaAtencion"]').select2({
        placeholder: 'Seleccione...',
        allowClear:  true,
	width: 'resolve'
    });
    
    
    $('select[id$="_idServicioExternoEstab"]').select2({
        placeholder: 'Seleccione...',
        allowClear:  true,
	width: 'resolve'
    });
    
    $("#tree").dynatree({
        checkbox: true,
        selectMode: 2,
        initAjax: {
            url: Routing.generate('get_atenciones')
        },        
        onClick: function(node, event) {
            // We should not toggle, if target was "checkbox", because this
            // would result in double-toggle (i.e. no toggle)
            if (node.getEventTargetType(event) != 'expander')
                if (node.getEventTargetType(event) == "title"){
                    node.toggleSelect();
                    if (node.isSelected())
                        $('input:checkbox[value="'+node.data.key+'"]').attr('checked', true);
                    else
                        $('input:checkbox[value="'+node.data.key+'"]').attr('checked', false);
                }
                else{
                    if (node.isSelected())
                        $('input:checkbox[value="'+node.data.key+'"]').attr('checked', false);
                    else
                        $('input:checkbox[value="'+node.data.key+'"]').attr('checked', true);
                }
        },
        onPostInit: function(isReloading, isError) {
            $('ul[id$="_atenciones"] input:checked').each(function(i, nodo){
                $("#tree").dynatree("getTree").selectKey($(nodo).val());
            });
        },
    });    
    
});