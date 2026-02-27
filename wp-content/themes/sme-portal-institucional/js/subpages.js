function selectAll(){
    alert('Aqui');
    jQuery('.checkboxAll').attr( 'checked', true );

    jQuery('.checkboxAll').each(function(){
        jQuery(".checkboxAll").prop('checked', true);
    });

    if(this.checked){
        jQuery('input:checkbox[name=type]').each(function(){
            jQuery("input:checkbox[name=type]").prop('checked', true);
        })
    }else{
        jQuery('input:checkbox[name=type]').each(function(){
            jQuery("input:checkbox[name=type]").prop('checked', false);
        })
    }
}