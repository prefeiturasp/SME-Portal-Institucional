<?php

namespace Classes\Cpt;


class CptConcursos extends Cpt
{
	public function __construct(){
		$this->cptSlug = self::getCptSlugExtend();
		$this->name = self::getNameExtend();
		$this->todosOsItens = self::getTodosOsItensExtend();
		$this->dashborarIcon = self::getDashborarIconExtendExtend();

		add_action('init', array($this, 'register'));

		//Alterando e Exibindo as colunas no Dashboard que vem por padrão na classe CPT
		add_filter('manage_posts_columns', array($this, 'exibe_cols'), 10, 2);
	}

	public function exibe_cols($cols, $post_type)
	{
		if ($post_type == $this->cptSlug) {
			unset($cols['tags'], $cols['author'],$cols['categories'],$cols['comments'] );
		}
		return $cols;
	}

	/**
	 * Alterando as configurações que vem por padrão na classe CPT (Adicionando suporte a thumbnail)
	 */
	public function register()
	{
		$labels = array(
			'name' => _x($this->name, 'post type general name'),
			'singular_name' => _x($this->name, 'post type singular name'),
			'all_items' => _x( $this->todosOsItens, 'Admin Menu todos os itens'),
			'add_new' => _x('Adicionar Concurso ', 'Novo item'),
			'add_new_item' => __('Novo Item'),
			'edit_item' => __('Editar Item'),
			'new_item' => __('Novo Item'),
			'view_item' => __('Ver Item'),
			'search_items' => __('Procurar Itens'),
			'not_found' => __('Nenhum registro encontrado'),
			'not_found_in_trash' => __('Nenhum registro encontrado na lixeira'),
			'parent_item_colon' => '',
			'menu_name' => $this->name.'s'
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'public_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => array('concurso','concursos'),
			'capabilities' => array(
				'edit_post' => 'edit_concurso',
				'edit_posts' => 'edit_concursos',
				'edit_published_posts ' => 'edit_published_concursos',
				'edit_others_posts' => 'edit_others_concursos',
				'read_post' => 'read_concurso',
				'read_private_posts' => 'read_private_concursos',
				'delete_post' => 'delete_concurso',
				'delete_published_posts' => 'delete_published_concursos',
				'publish_posts' => 'publish_concursos'
			),
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => 10,
			'menu_icon'   => $this->dashborarIcon,
			'exclude_from_search' => true,
			'show_in_rest' => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'supports' => array('excerpt', 'revisions'),
		);

		register_post_type($this->cptSlug, $args);

		flush_rewrite_rules();

		
	}
}