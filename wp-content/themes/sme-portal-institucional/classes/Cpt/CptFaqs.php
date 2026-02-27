<?php

namespace Classes\Cpt;


class CptFaqs extends Cpt
{
	public function __construct(){
		$this->cptSlug = self::getCptSlugExtend();
		$this->name = self::getNameExtend();
		$this->todosOsItens = self::getTodosOsItensExtend();
		$this->dashborarIcon = self::getDashborarIconExtendExtend();

		add_action('init', array($this, 'register'));

		//Alterando e Exibindo as colunas no Dashboard que vem por padrão na classe CPT
		add_filter('manage_posts_columns', array($this, 'exibe_cols'), 10, 2);
		add_action('manage_' . $this->cptSlug . '_posts_custom_column', array($this, 'cols_content'));
		
		// Filtro por categoria
		add_filter('pre_get_posts', array($this, 'filter_categ_portais'), 10, 2);
	}

	function filter_categ_portais($query) {

		if($_GET['categorias_faqs']){
			$tax = array(
				array(
					'taxonomy' => 'categorias-faqs',
					'field' => 'term_id',
					'terms' => $_GET['categorias_faqs'],
				)
			);
			
			$query->set('tax_query', $tax);
		}		
		
		return $query;
		
	}
	

	public function exibe_cols($cols, $post_type){
		if ($post_type == $this->cptSlug) {
			unset($cols['tags'], $cols['author'],$cols['categoria'],$cols['comments'], $cols['post_views'], $cols['date'] );
			$cols['author'] = 'Autor';			
			$cols['categorias-faqs'] = 'Categoria';					
			$cols['date'] = 'Data';
		}
		return $cols;
	}

	//Exibindo as informações correspondentes de cada coluna
	public function cols_content($col){
		global $post;
		switch ($col) {

			case 'categorias-faqs':
				$categorias = get_the_terms( $post->ID, 'categorias-faqs' );
				//$terms_string = join(', ', wp_list_pluck($categorias, 'name'));
				$i = 0;
				if($categorias){
					foreach($categorias as $categoria){
						if($i == 0){
							echo '<a href="' . get_home_url() . '/wp-admin/edit.php?post_type=educacao-faq&categorias_faqs=' . $categoria->term_id . '">' . $categoria->name . '</a>';
						} else {
							echo ', <a href="' . get_home_url() . '/wp-admin/edit.php?post_type=educacao-faq&categorias_faqs=' . $categoria->term_id . '">' . $categoria->name . '</a>';
						}
						$i++;
					}
				}				
				break;
			
		}
	}

	/**
	 * Alterando as configurações que vem por padrão na classe CPT (Adicionando suporte a thumbnail)
	 */
	public function register(){
		$labels = array(
			'name' => _x($this->name, 'post type general name'),
			'singular_name' => _x($this->name, 'post type singular name'),
			'all_items' => _x( $this->todosOsItens, 'Admin Menu todos os itens'),
			'add_new' => _x('Adicionar nova ', 'Nova pergunta'),
			'add_new_item' => __('Nova pergunta'),
			'edit_item' => __('Editar pergunta'),
			'new_item' => __('Nova pergunta'),
			'view_item' => __('Ver pergunta'),
			'search_items' => __('Procurar perguntas'),
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
			'rewrite' => array( 'with_front' => false ),
			'capability_type' => array('faq','faqs'),
			'capabilities' => array(
				'edit_post' => 'edit_faq',
				'edit_posts' => 'edit_faqs',
				'edit_published_posts ' => 'edit_published_faqs',
				'read_post' => 'read_faq',
				'read_private_posts' => 'read_private_faqs',
				'delete_post' => 'delete_faq',
				'delete_published_posts' => 'delete_published_faqs',
			),
			'map_meta_cap'        => true,			
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => 10,
			'menu_icon'   => 'dashicons-text-page',
			'exclude_from_search' => true,
			'show_in_rest' => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			//'supports' => array('excerpt', 'title'),
		);

		register_post_type($this->cptSlug, $args);

		flush_rewrite_rules();
		
		register_taxonomy(
			'categorias-faqs',
			$this->cptSlug,
			array(
				"hierarchical" => true,
				"label" => 'Categorias FAQ',
				"singular_label" => 'Categoria FAQ',	
				'map_meta_cap'        => true,
				// Definido as capacidades para a taxonomia tag. Se torna uma Tag porque o 'hierarchical'  => false,
				'capabilities' => array(
					'manage_terms'=>'manage_faqs',
					'edit_terms'=>'edit_faqs',
					'delete_terms'=>'delete_faqs',
					'assign_terms'=>'assign_faqs',
				)
			)
		);
		
	}
}