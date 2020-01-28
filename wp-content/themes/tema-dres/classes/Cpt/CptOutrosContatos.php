<?php

namespace Classes\Cpt;


class CptOutrosContatos extends Cpt{
	public function __construct(){
        $this->cptSlug = self::getCptSlugExtend();
        $this->name = self::getNameExtend();
        $this->todosOsItens = self::getTodosOsItensExtend();
        add_action('init', array($this, 'register'));
	}
    public function register(){
        $labels = array(
            'name' => _x($this->name, 'post type general name'),
            'singular_name' => _x($this->name, 'post type singular name'),
            'all_items' => _x( $this->todosOsItens, 'Admin Menu todos os itens'),
            'add_new' => _x('Adicionar contatos ', 'Novo item'),
            'add_new_item' => __('Novo Item'),
            'edit_item' => __('Editar Item'),
            'new_item' => __('Novo Item'),
            'view_item' => __('Ver Item'),
            'search_items' => __('Procurar Itens'),
            'not_found' => __('Nenhum registro encontrado'),
            'not_found_in_trash' => __('Nenhum registro encontrado na lixeira'),
            'parent_item_colon' => '',
            'menu_name' => $this->name
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'public_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 10,
            //'menu_icon'   => 'dashicons-image-filter',
            'exclude_from_search' => true,
            'show_in_rest' => true,
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('title'),
            //'supports' => array('title', 'editor', 'thumbnail'),
        );

        register_post_type($this->cptSlug, $args);
        remove_post_type_support( $this->cptSlug, 'editor' );
        //remove_post_type_support( $this->cptSlug, 'title' );
        flush_rewrite_rules();
    }

}