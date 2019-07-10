<?php

namespace Classes\Cpt;


class CptPages extends Cpt
{
	public function __construct()
	{
		add_filter( 'manage_pages_columns' , array($this, 'exibe_cols' ));
		add_action( 'manage_pages_custom_column' , array($this, 'cols_content'), 10, 2 );
	}

	// add featured thumbnail to admin post columns
	function exibe_cols($cols, $post_type) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Title',
			'author' => 'Author',
			'featured_thumb' => 'Thumbnail',
			'date' => 'Date',

		);
		return $columns;
	}

	function cols_content( $column) {
		switch ( $column ) {
			case 'featured_thumb':
				echo '<a href="' . get_edit_post_link() . '">';
				echo the_post_thumbnail( 'admin-list-thumb' );
				echo '</a>';
				break;

		}
	}


}