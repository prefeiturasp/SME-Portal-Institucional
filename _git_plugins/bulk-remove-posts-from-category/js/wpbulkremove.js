jQuery(document).ready(function() {
	$text = wpbulkremove.wpbulkremove_string;
    $addhtml = '<div id="remcat" class="inline-edit-group wp-clearfix"><input type="checkbox" name="remove_cat" value="open"><span class="checkbox-title">'+ $text +'</span></div>';
	jQuery('.inline-edit-col-center.inline-edit-categories .inline-edit-col').append($addhtml);
	
	var valor = jQuery('.post_type_page').val();

	if(valor == 'Array'){
		jQuery('.post_type_page').val('post');
	}

	console.log(jQuery('.post_type_page').val());
});

jQuery(document).on('change', '#remcat input', function() {
	var $bulktype = wpbulkremove.wpbulkremove_type; 
	var $bulktax = wpbulkremove.wpbulkremove_tax; 
		if($bulktype == 'edit-post'){
			var $ini = 'post_category[]';
		} else if($bulktype == 'edit-product') {
			var $ini = 'tax_input[product_cat][]';
		} else {
			var $ini = 'tax_input['+$bulktax+'][]';
		}
 var $repl = 'post_out_category';
 var $list = jQuery(this).closest('.inline-edit-col').find('ul.cat-checklist');
        if (jQuery(this).is(':checked')) {
            $list.addClass('red');
			jQuery('#remcat').addClass('red');
			$list.find('input').each(function() {
				jQuery(this).attr('name',$repl);
			});
        } else {
            $list.removeClass('red');
			jQuery('#remcat').removeClass('red');
			$list.find('input').each(function() {
				jQuery(this).attr('name',$ini);
			});
        }
});
jQuery(function($){
	$( 'body' ).on( 'click', 'input[name="bulk_edit"]', function() {
		
		$( this ).after('<span class="spinner is-active"></span>');
 
		var $bulktype = wpbulkremove.wpbulkremove_type; 
		var $bulktax = wpbulkremove.wpbulkremove_tax; 
		var bulk_edit_row = $( 'tr#bulk-edit' );
		remcat = bulk_edit_row.find( 'input[name="remove_cat"]' ).is(':checked') ? 1 : 0;
   
		if(remcat == 1){
				post_ids = new Array();
				catout = new Array();
				bulk_edit_row.find('input[name="post_out_category"]:checked').each(function() {
				   catout.push($(this).val());
				});
				
	 
				bulk_edit_row.find( '#bulk-titles' ).children().each( function() {
					post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
				});
				
				
				$.ajax({
					url: ajaxurl, 
					type: 'POST',
					async: true,
					cache: false,
					data: {
						action: 'masterns_bulk_remove_cat',
						post_ids: post_ids, 
						catout: catout, 
						remcat: remcat,
						type: $bulktype,
						taxonomy: $bulktax
					}				
				});
		}
	});
});