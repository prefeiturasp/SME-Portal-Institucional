<?php
/*
Plugin Name: Grupos Ceus
Description:  Plugin Criado para controlar os editores dos CEUs
Author: Felipe Viana
Version: 1.0.0
Author URI: http://ma.tt/
*/


// Excluir Categorias
add_action('init', 'wporg_custom_post_type');

// Controle de paginas permitidas
function wpse_user_can_edit( $user_id, $page_id ) {

    $eventos = array();

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

    //return true;

 
    // pega o grupo que o usuario pertence
    $variable = get_field('grupo', 'user_' . $user_id);

    // verifica se esta liberado para editar todas paginas
	$todos = get_field('todas_as_paginas', $variable);

	if($todos){
		return true;
	} else {	
        
        // pega as unidades permitidas para edicao do grupo
        $unidades = get_field('unidades', $variable);

        $args = array(
			'post_type' => 'post',
            'posts_per_page'    =>  -1,
            'meta_query' => array(
                'relation' => 'OR',
            ),
        );
        
        foreach ($unidades as $unidade){
            
            $args['meta_query'][] = array (
                'key' => 'localizacao',
                'value'     => $unidade,
            );
        }

        $validPosts = array();
        $this_post = array();
        $id_pot = array();
        $i = 0;

        $my_query = new WP_Query($args);

        if($my_query->have_posts()) {
            while($i < $my_query->post_count) : 
                $post = $my_query->posts;

                if(!in_array($post[$i]->ID, $id_pot)){
                    $this_post['id'] = $post[$i]->ID;
                    $this_post['post_content'] = $post[$i]->post_content;
                    $this_post['post_title'] = $post[$i]->post_title;
                    $this_post['guid'] = $post[$i]->guid;

                    $id_pot[] = $post[$i]->ID;
                    array_push($validPosts, $this_post);

                }

                $post = '';
                $i++;

            endwhile;
        }
        

        $result = array_merge($unidades, $id_pot);

        // se a pagina corrente esta na lista de paginas do grupo libera para edicao
        if( in_array($page_id, $result)  ){
			return true;
		} else {
			return false;
		}
	} 
	
 }


 //
 add_filter( 'map_meta_cap', function ( $caps, $cap, $user_id, $args ) {

    // capability atribuida
    $to_filter = [ 'edit_post', 'delete_post', 'edit_page', 'delete_page', 'edit_concurso', 'edit_unidade' ];
    
    //echo "<pre>";
    //print_r($cap);
    //echo "</pre>";

    // If the capability being filtered isn't of our interest, just return current value
    if ( ! in_array( $cap, $to_filter, true ) ) {
        return $caps;
    }

    //print_r($args);

    // First item in $args array should be page ID
    if ( ! $args || empty( $args[0] ) || ! wpse_user_can_edit( $user_id, $args[0] ) ) {
        // User is not allowed, let's tell that to WP
        return [ 'do_not_allow' ];
    }
    // Otherwise just return current value
    return $caps;

}, 10, 4 );


// Post Type Grupos
function wporg_custom_post_type() {
    register_post_type('wporg_unidades',
        array(
            'labels'      => array(
                'name'          => __( 'Editores CEUs', 'textdomain' ),
                'singular_name' => __( 'Editor CEU', 'textdomain' ),
            ),
            'public'      => true,
            'has_archive' => true,
			'rewrite'     => array( 'slug' => 'unidades' ), // my custom slug
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

