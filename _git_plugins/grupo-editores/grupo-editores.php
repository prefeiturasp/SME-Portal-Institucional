<?php
/*
Plugin Name: Grupos Editores
Description:  Plugin Criado para controlar os editores dos portais
Author: Felipe Viana
Version: 1.0.0
Author URI: https://www.amcom.com.br/
*/


// Post Type Grupos
function wporg_custom_post_type() {
    register_post_type('editores_portal',
        array(
            'labels'      => array(
                'name'          => __( 'Editores Portal', 'textdomain' ),
                'singular_name' => __( 'Editor Portal', 'textdomain' ),
            ),
            'public'      => true,
            'has_archive' => true,
			'rewrite'     => array( 'slug' => 'editores_portal' ), // my custom slug
			'capabilities' => array(
				'edit_post'          => 'update_core',
				'read_post'          => 'update_core',
				'delete_post'        => 'update_core',
				'edit_posts'         => 'update_core',
				'edit_others_posts'  => 'update_core',
				'delete_posts'       => 'update_core',
				'publish_posts'      => 'update_core',
				'read_private_posts' => 'update_core'
			),
        )
    );
}

add_action('init', 'wporg_custom_post_type');

// Controle de paginas permitidas
function wpse_user_can_edit( $user_id, $page_id ) {

    // Id da pagina corrente da lista
    $page = get_post( $page_id );
 	
    // pega as informacoes do usuario logado
    $user = wp_get_current_user($user_id);

    // usuarios que ficam foram da regra
	$allowed_roles = array( 'editor', 'administrator' );
	if ( array_intersect( $allowed_roles, $user->roles ) ) {
        // se estiverem na lista todas as paginas sao permitidas para edicao
        return true;
	}

    // pega o grupo que o usuario pertence
    $variable = get_field('grupo', 'user_' . $user_id);

    // verifica se esta liberado para editar todas paginas
	$todos = get_field('todas_as_paginas', $variable);

	if($todos){
		return true;
	} else {	
        // pega as paginas permitidas para edicao pelo grupo
        $pages = get_field('selecionar_paginas', $variable);

        // se a pagina corrente esta na lista de paginas do grupo libera para edicao
        if( in_array($page_id, $pages) ){
			return true;
		} else {
			return false;
		}
	} 
	
 }

 //
 add_filter( 'map_meta_cap', function ( $caps, $cap, $user_id, $args ) {

    // capability atribuida
    $to_filter = [ 'edit_post', 'delete_post', 'edit_page', 'delete_page', 'edit_others_pages' ];

    // If the capability being filtered isn't of our interest, just return current value
    if ( ! in_array( $cap, $to_filter, true ) ) {
        return $caps;
    }

    // First item in $args array should be page ID
    if ( ! $args || empty( $args[0] ) || ! wpse_user_can_edit( $user_id, $args[0] ) ) {
        // User is not allowed, let's tell that to WP
        return [ 'do_not_allow' ];
    }
    // Otherwise just return current value
    return $caps;

}, 10, 4 );