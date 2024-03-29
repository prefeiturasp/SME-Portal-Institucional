<?php

//força posicionamento dos campos ACF no admin
function prefix_reset_metabox_positions(){
  delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_post' );
  delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_page' );
  delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_custom_post_type' );
}
add_action( 'admin_init', 'prefix_reset_metabox_positions' );

////////Habilita Opções Gerais ACF////////
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Configurações Gerais',
        'menu_title'	=> 'Opções Gerais',
        'menu_slug' 	=> 'conf-geral',
        'position' 		=> '3',
        'capability'	=> 'acf_options',
        //'redirect'		=> false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Informações Gerais',
        'menu_title'	=> 'Informações',
        'parent_slug'	=> 'conf-geral',
		'capability'	=> 'acf_options',
    ));
	
	acf_add_options_sub_page(array(
        'page_title' 	=> 'Personalização do tema',
        'menu_title'	=> 'Personalização',
        'parent_slug'	=> 'conf-geral',
		'capability'	=> 'acf_options',
    ));
	
	acf_add_options_sub_page(array(
        'page_title' 	=> 'Configurações de suporte',
        'menu_title'	=> 'Suporte',
        'parent_slug'	=> 'conf-geral',
		'capability'	=> 'acf_options',
    ));


}


//Gera arquivo css com PHP e ACF
function generate_options_css() {
    $ss_dir = get_stylesheet_directory();
    ob_start(); // Capture all output into buffer
    require($ss_dir . '/assets/css/acf.css.php'); // Grab the custom-style.php file
    $css = ob_get_clean(); // Store output in a variable, then flush the buffer
    file_put_contents($ss_dir . '/assets/css/custom-styles-acf.css', $css, LOCK_EX); // Save it as a css file
}
add_action( 'wp_enqueue_scripts', 'generate_options_css', 20 ); //Parse the output and write the CSS file on post save



//Gera miniatura para PDF
function acf_change_icon_on_files ( $icon, $mime, $attachment_id ){ // Display thumbnail instead of document.png
		
		if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) === false && $mime === 'application/pdf' ){
			$get_image = wp_get_attachment_image_src ( $attachment_id, 'full' );
			if ( $get_image ) {
				$icon = $get_image[0];
			} 
		}
		return $icon;
	}
	
	add_filter( 'wp_mime_type_icon', 'acf_change_icon_on_files', 10, 3 );


//habilita revisoes para o acf
add_filter( 'rest_prepare_revision', function( $response, $post ) {
    $data = $response->get_data();

    $data['acf'] = get_fields( $post->ID );

    return rest_ensure_response( $data );
}, 10, 2 );