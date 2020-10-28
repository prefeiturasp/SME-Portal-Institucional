<?php
/*
Plugin Name: Grupos Ceus
Description:  Plugin Criado para controlar os editores dos CEUs
Author: Felipe Viana
Version: 1.0.0
Author URI: http://ma.tt/
*/


// Excluir Categorias dos grupos
add_filter('list_terms_exclusions', 'yoursite_list_terms_exclusions', 9999, 2);

function yoursite_list_terms_exclusions( $exclusions, $args ) {

	
    global $wpdb;

    $term_get = 'category';

    $a = $wpdb->get_results($wpdb->prepare("SELECT t.name,t.slug,t.term_group,x.term_taxonomy_id,x.term_id,x.taxonomy,x.description,x.parent,x.count FROM {$wpdb->prefix}term_taxonomy x LEFT JOIN {$wpdb->prefix}terms t ON (t.term_id = x.term_id) WHERE x.taxonomy=%s;",$term_get));

    $option = [];

    foreach ($a as $term) {
        $option[] = $term->term_id;        
    }
	
    $categs = $option;
    
	$user = wp_get_current_user(); 
	$author_id = $user->ID;
	$author_group = get_field('grupo', 'user_'. $author_id);

	$terms = get_field('categorias', $author_group);
    
    
    //echo "aqui:";
    //print_r($result);
	
    global $pagenow;
    if (in_array($pagenow,array('post.php','post-new.php')) && !current_user_can('see_special_cats')) {
        $result = array_diff($categs, $terms);
        $exclusions = "{$exclusions} AND t.term_id NOT IN (" . implode(', ', $result) .")";
    }
    return $exclusions;
}


/*
## Nao utilizadas por enquanto
// Definir categorias por padrao selecionadas 
add_action( 'admin_head-post-new.php', 'wpse_72603_default_categories' );
add_action( 'admin_head-post.php', 'wpse_72603_default_categories' );

//
function wpse_72603_default_categories()
{
    global $current_screen;

    // If not our post type, do nothing
    if( 'post' != $current_screen->post_type )
        return;
    ?>
    <script language="javascript" type="text/javascript">
        jQuery(document).ready(function($) 
        {
            // Hide the "Most used" tab
            $('#category-tabs .hide-if-no-js').remove();

            // Tick the checkboxes of categories 3 and 9
            $('#in-category-4, #in-category-9').attr('checked', true);

            // Disable the clicks in categories 3 and 9
            $('#in-category-4, #in-category-9, #in-popular-category-9')
            .click(function() { return false; });
        });
    </script>
    <?php
}
*/

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