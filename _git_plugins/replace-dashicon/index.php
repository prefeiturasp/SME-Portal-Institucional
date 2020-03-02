<?php
/*
Plugin Name: Replace DashIcon
Plugin URI: http://educacao.sme.prefeitura.sp.gov.br/
Description: Troca o Dashicon do menu do painel admin.
Author: Rafael Henrique de Souza
Version: 1.0
Author URI: https://rafaelhsouza.com.br/
*/

/////////////////////////////////////////////////////
///////Troca nome Post para Noticias/////////////////
/////////////////////////////////////////////////////
function nome_post_para_noticias() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Noticias';
    $submenu['edit.php'][5][0] = 'Noticias';
    $submenu['edit.php'][10][0] = 'Adicionar Noticias';
    $submenu['edit.php'][16][0] = 'Tags';
    echo '';
}
add_action( 'admin_menu', 'nome_post_para_noticias');
function posts_para_noticias() {
    global $wp_post_types;
    $labels = $wp_post_types['post']->labels;
    $labels->name = 'Noticias';
    $labels->singular_name = 'Noticia';
	$labels->menu_icon = 'dashicons-format-status';
    $labels->add_new = 'Adicionar Noticia';
    $labels->add_new_item = 'Adicionar Noticia';
    $labels->edit_item = 'Editar Noticia';
    $labels->new_item = 'Noticia';
    $labels->view_item = 'Ver Noticia';
    $labels->search_items = 'Buscar Noticia';
    $labels->not_found = 'Nenhuma Noticia encontrada';
    $labels->not_found_in_trash = 'Nenhuma noticia encontrada no Lixo';
    $labels->all_items = 'Todas Noticias';
    $labels->menu_name = 'Noticias';
    $labels->name_admin_bar = 'Noticias';
}
add_action( 'init', 'posts_para_noticias' );

/////////////////////////////////////////////////////
///////Troca os Dashicon do wp-admin/////////////////
/////////////////////////////////////////////////////
/*function custom_dashicon( $args, $post_type ) {
    if ( $post_type == 'agenda' ) {
        $args['menu_icon'] = 'dashicons-calendar-alt';
    }
	if ( $post_type == 'organograma' ) {
        $args['menu_icon'] = 'dashicons-text';
    }
	if ( $post_type == 'contato' ) {
        $args['menu_icon'] = 'dashicons-id-alt';
    }
	if ( $post_type == 'card' ) {
        $args['menu_icon'] = 'dashicons-excerpt-view';
    }
	if ( $post_type == 'post' ) {
        $args['menu_icon'] = 'dashicons-media-text';
    }
	if ( $post_type == 'aba' ) {
        $args['menu_icon'] = 'dashicons-image-flip-vertical';
    }
	if ( $post_type == 'botao' ) {
        $args['menu_icon'] = 'dashicons-editor-insertmore';
    }
	if ( $post_type == 'curriculo-da-cidade' ) {
        $args['menu_icon'] = 'dashicons-media-document';
    }
    return $args;
}
add_filter( 'register_post_type_args', 'custom_dashicon', 20, 2 );*/