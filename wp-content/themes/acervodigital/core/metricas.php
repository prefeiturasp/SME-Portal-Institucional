<?php

class metricas_create{
 
    function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }
 
    function admin_menu() {
        add_menu_page(
            __( 'Metricas', 'textdomain' ),//page title
            __( 'Metricas', 'textdomain' ),//menu title
            'manage_options',//Capability
            'metricas_slug',//slug
            array(
                $this,
                'conteudo_metricas'
            ),
			'dashicons-chart-area',//icon
			4//position	
        );
    }
 
    function conteudo_metricas() {
        $wp_root_path = str_replace('/wp-content/themes', '', get_theme_root());

		echo('<iframe style=" width: 100%; height: 88vh; padding-top: 45px; " src="'.get_home_url().'/sistema-semanas.php"/>');
    }
}
 
new metricas_create;