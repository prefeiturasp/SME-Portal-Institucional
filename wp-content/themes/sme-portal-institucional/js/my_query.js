jQuery(document).ready(function($) {

    acf.addAction("new_field/key=field_618d77f0f3fe0", function ($field) {        
        
        $field.on("change", function (e) {
           
            var pauta = $field.$el.closest('.acf-fields').find('.pauta textarea');
            var participantes = $field.$el.closest('.acf-fields').find('.participantes textarea').attr("id");
            var endereco = $field.$el.closest('.acf-fields').find('.endereco select').attr("id");
            var end_manual = $field.$el.closest('.acf-fields').find('.end_manual');
            let tinyInstance = tinyMCE.editors[participantes];
            //console.log(endereco);

            
            var compromisso = $field.val();

            if(compromisso == 'outros'){

                pauta.val('');
                tinyInstance.setContent('');
                $('#' + endereco).val('outros');
                end_manual.removeClass('acf-hidden');

            } else {
                var data = {
                    'action': 'my_action',
                    'compromisso': compromisso    
                };
                    
                $.ajax({
                    url: ajax_object.ajax_url,
                    type : 'post',
                    data: data,
                    dataType: 'json',
                    success: function( data ) {
                        
                        //console.log(data);

                        pauta.val(data.pauta_assunto);
                        $('#' + endereco).val(data.endereco_do_evento);
                        tinyInstance.setContent(data.participantes_evento);
                        end_manual.addClass('acf-hidden');
                    }
                })
            }

        });
    });

    acf.addAction("new_field/key=field_64f61da9fd408", function ($field) {        
        
        $field.on("change", function (e) {
           
            var pauta = $field.$el.closest('.acf-fields').find('.pauta textarea');
            var participantes = $field.$el.closest('.acf-fields').find('.participantes textarea').attr("id");
            var endereco = $field.$el.closest('.acf-fields').find('.endereco select').attr("id");
            var end_manual = $field.$el.closest('.acf-fields').find('.end_manual');
            let tinyInstance = tinyMCE.editors[participantes];
            //console.log(endereco);

            
            var compromisso = $field.val();

            if(compromisso == 'outros'){

                pauta.val('');
                tinyInstance.setContent('');
                $('#' + endereco).val('outros');
                end_manual.removeClass('acf-hidden');

            } else {
                var data = {
                    'action': 'my_action',
                    'compromisso': compromisso    
                };
                    
                $.ajax({
                    url: ajax_object.ajax_url,
                    type : 'post',
                    data: data,
                    dataType: 'json',
                    success: function( data ) {
                        
                        //console.log(data);

                        pauta.val(data.pauta_assunto);
                        $('#' + endereco).val(data.endereco_do_evento);
                        tinyInstance.setContent(data.participantes_evento);
                        end_manual.addClass('acf-hidden');
                    }
                })
            }

        });
    });

   /* console.log('Teste');
	
	var field = acf.getField('field_618d77f0f3fe0');
    var vally = field.val();

    console.log(vally);
	
	field.on('change', function( e ){

        var vally = field.val();
        console.log(vally);
        /*	
        var data = {
            'action': 'my_action',
            'userno': vally    
        };
            
        $.ajax({
            url: ajax_object.ajax_url,
            type : 'post',
            data: data,
            dataType: 'json',
            success: function( data ) {
            
                $('#acf-field_5c3daeb8608ae').val(data.heightno);
                $('#acf-field_5c3daf8f608af').val(data.weightno);
                $('#acf-field_5c3dafc1608b1').val(data.ageno);
                $('#acf-field_5c3dafa5608b0').val(data.bodyfatno);
            }
        })
        
        
    });
    */
	
});