<?php

namespace Classes\Cpt;


class CptDestaques extends Cpt
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
		
		// Filtro por categoria / tags
		add_filter('pre_get_posts', array($this, 'filter_categ_destaques'), 10, 2);
		add_filter('pre_get_posts', array($this, 'filter_tags_destaques'), 10, 2);
	}

	function filter_categ_destaques($query) {

		if($_GET['categorias_destaque']){
			$tax = array(
				array(
					'taxonomy' => 'categorias-destaque',
					'field' => 'term_id',
					'terms' => $_GET['categorias_destaque'],
				)
			);
			
			$query->set('tax_query', $tax);
		}		
		
		return $query;
		
	}

	function filter_tags_destaques($query) {

		if($_GET['tags_destaque']){
			$tax = array(
				array(
					'taxonomy' => 'tags-destaque',
					'field' => 'term_id',
					'terms' => $_GET['tags_destaque'],
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
			$cols['destaque_home'] = 'Destaque home <span class="dashicons dashicons-info"></span>';
			$cols['categorias-destaque'] = 'Categoria';
			$cols['tags-destaque'] = 'Tags/Etiquetas';
			$cols['date'] = 'Data';
		}
		return $cols;
	}

	//Exibindo as informações correspondentes de cada coluna
	public function cols_content($col){
		global $post;
		switch ($col) {
			case 'destaque_home':
				$data_do_evento = get_field('pagina_principal', $post->ID);
				$texto = '—';
				if($data_do_evento){
					$texto = 'Sim';
				}
				echo $texto;
				break;

			case 'categorias-destaque':
				$categorias = get_the_terms( $post->ID, 'categorias-destaque' );
				//$terms_string = join(', ', wp_list_pluck($categorias, 'name'));
				$i = 0;
				foreach($categorias as $categoria){
					if($i == 0){
						echo '<a href="' . get_home_url() . '/wp-admin/edit.php?post_type=destaque&categorias_destaque=' . $categoria->term_id . '">' . $categoria->name . '</a>';
					} else {
						echo ', <a href="' . get_home_url() . '/wp-admin/edit.php?post_type=destaque&categorias_destaque=' . $categoria->term_id . '">' . $categoria->name . '</a>';
					}
					$i++;
				}
				break;

			case 'tags-destaque':
				$tags = get_the_terms( $post->ID, 'tags-destaque' );
				//$terms_string = join(', ', wp_list_pluck($tags, 'name'));
				$i = 0;
				foreach($tags as $tag){
					if($i == 0){
						echo '<a href="' . get_home_url() . '/wp-admin/edit.php?post_type=destaque&tags_destaque=' . $tag->term_id . '">' . $tag->name . '</a>';
					} else {
						echo ', <a href="' . get_home_url() . '/wp-admin/edit.php?post_type=destaque&tags_destaque=' . $tag->term_id . '">' . $tag->name . '</a>';
					}
					$i++;
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
			'add_new' => _x('Adicionar Recado ', 'Novo item'),
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
			'rewrite' => array( 'with_front' => false ),			
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => 10,
			'menu_icon'   => 'dashicons-yes-alt',
			'exclude_from_search' => true,
			'show_in_rest' => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			//'supports' => array('excerpt', 'title'),
		);

		register_post_type($this->cptSlug, $args);

		flush_rewrite_rules();

		register_taxonomy(
			'categorias-destaque',
			$this->cptSlug,
			array(
				"hierarchical" => true,
				"label" => 'Categorias de Recados',
				"singular_label" => 'Categoria de Recado',	
			)
		);

		register_taxonomy(
			'tags-destaque',
			$this->cptSlug,
			array(
				"hierarchical" => false,
				"label" => 'Tags de Recados',
				"singular_label" => 'Tag de Recado',	
			)
		);
		
	}
}