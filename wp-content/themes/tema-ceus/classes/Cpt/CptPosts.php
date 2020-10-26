<?php

namespace Classes\Cpt;


class CptPosts extends Cpt
{
	public function __construct()
	{
		add_filter('manage_posts_columns', array($this, 'exibe_cols'), 10, 2);
		add_action( 'manage_posts_custom_column' , array($this, 'cols_content'), 10, 2 );
	}

	// add featured thumbnail to admin post columns
	public function exibe_cols($cols, $post_type) {
		if ($post_type === 'post') {
			$columns = array(
				'cb' => '<input type="checkbox" />',
				'title' => 'Title',
				'author' => 'Author',
				'categories' => 'Categories',
				'tags' => 'Tags',
				'comments' => '<span class="vers"><div title="Comments" class="comment-grey-bubble"></div></span>',
				'featured_thumb' => 'Thumbnail',
				'destaque' => 'Destaque',
				'posicao_destaque' => 'Posição Destaque',
				'date' => 'Date',

			);

			return $columns;
		}else{
			return $cols;
		}

	}

	public function cols_content($column) {
		switch ( $column ) {
			case 'featured_thumb':
				echo '<a href="' . get_edit_post_link() . '">';
				echo the_post_thumbnail( 'admin-list-thumb' );
				echo '</a>';
				break;

			case 'destaque':
				echo $this->getDestaque();
				break;

			case 'posicao_destaque':
				$posicao_destaque = get_field('posicao_de_destaque_deste_post');
				echo '<h4>'.$posicao_destaque.'</h4>';
				break;



		}
	}

	public function getDestaque(){
		$destaque = get_field('deseja_que_este_post_apareca_na_home');
		if ($destaque == 'sim'){
			return '<h4>Sim</h4>';
		}else{
			return '<h4>Não</h4>';
		}

	}

}