<?php

namespace Classes\Cpt;


class CptOutrosContatos extends Cpt{
	public function __construct(){
        $this->cptSlug = self::getCptSlugExtend();
        $this->name = self::getNameExtend();
        $this->todosOsItens = self::getTodosOsItensExtend();
        add_action('init', array($this, 'register'));
		add_filter('manage_posts_columns', array($this, 'exibe_cols'), 10, 2);
		add_action('manage_' . $this->cptSlug . '_posts_custom_column', array($this, 'cols_content'));
		add_filter('manage_edit-' . $this->cptSlug . '_sortable_columns', array($this, 'cols_sort'));
		add_filter('request', array($this, 'orderby'));
	}

	function orderby($vars)
	{
		if (is_admin()) {
			if (isset($vars['orderby']) && $vars['orderby'] == 'menu_order') {
				$vars['orderby'] = 'menu_order';
			}

		}
		return $vars;
	}

	// Permitindo a ordenação das colunas exibidas no Dashboard
	function cols_sort($cols)
	{
		$cols['menu_order'] = 'menu_order';
		return $cols;
	}

	//Exibindo as informações correspondentes de cada coluna
	public function cols_content($col)
	{
		global $post;
		switch ($col) {
			case 'menu_order':
				$order = $post->menu_order;
				echo $order;
				break;
			default:
				break;

		}
	}

	//Exibindo as colunas no Dashboard
	public function exibe_cols($cols, $post_type)
	{
		if ($post_type == $this->cptSlug) {
			$cols['menu_order'] = 'Ordenação';
		}
		return $cols;
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
            //'capability_type' => 'post',
			'capability_type' => array('outroscontatos','outroscontatoss'),
			'capabilities' => array(
				'edit_post' => 'edit_outroscontatos',
				'edit_posts' => 'edit_outroscontatoss',
				'edit_published_posts ' => 'edit_published_outroscontatoss',
				'read_post' => 'read_outroscontatos',
				'read_private_posts' => 'read_private_outroscontatoss',
				'delete_post' => 'delete_outroscontatos',
				'delete_published_posts' => 'delete_published_outroscontatoss',
			),
			'map_meta_cap'        => true,
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 10,
            //'menu_icon'   => 'dashicons-image-filter',
            'exclude_from_search' => true,
            'show_in_rest' => true,
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('title','page-attributes'),
            //'supports' => array('title', 'editor', 'thumbnail'),
        );

        register_post_type($this->cptSlug, $args);
        remove_post_type_support( $this->cptSlug, 'editor' );
        //remove_post_type_support( $this->cptSlug, 'title' );
        flush_rewrite_rules();
    }

}