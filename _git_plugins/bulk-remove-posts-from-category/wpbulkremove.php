<?php
/*
 * 
 * Bulk remove posts from category
 * 
 * Plugin Name: Bulk remove posts from category
 * Plugin URI:   https://masterns-studio.com/code-factory/wordpress-plugin/bulk-remove-from-category/
 * Description: Bulk remove posts from category
 * Version: 3.1.1
 * Author: MasterNs
 * Author URI: https://masterns-studio.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Tested up to: 5.5
 * Text Domain: bulk-remove-posts-from-category
 * Domain Path: languages/
 * 
 * WC tested up to: 4.4.1
 * 
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
*
* add admin files
*
*/

add_action( 'admin_enqueue_scripts', 'wpbulkremove_enqueue' );
function wpbulkremove_enqueue($hook) {
	$screen = get_current_screen();
	$can_run = false;
	$cpt_tax = '';
	
	if (( 'edit-post' === $screen->id )||('edit-product' === $screen->id)) {
		$can_run = true;	
	} else {
		$post_type = $screen->post_type;
		$taxonomies = get_object_taxonomies($post_type, 'objects');
			foreach($taxonomies as $tax){
				if($tax->hierarchical){
					$can_run = true;
					$cpt_tax = $tax->name;
				}
			}
	}
	
	if($can_run){
		$my_js_ver  = date("ymd.Gis", filemtime( plugin_dir_path( __FILE__ ) . '/js/wpbulkremove.js' ));
		$my_css_ver = date("ymd.Gis", filemtime( plugin_dir_path( __FILE__ ) . '/css/wpbulkremove_style.css' ));
		
		wp_enqueue_style('wpbulkremove_style', plugins_url('/css/wpbulkremove_style.css', __FILE__), false,   $my_css_ver);	     
		wp_enqueue_script( 'wpbulkremove-js', plugins_url('/js/wpbulkremove.js', __FILE__), array(), $my_js_ver);
		$wpbulkremove_array = array(
			'wpbulkremove_string' => __( 'Remover da categoria', 'bulk-remove-posts-from-category' ),
			'wpbulkremove_type' => $screen->id,
			'wpbulkremove_tax' => $cpt_tax
		);
		wp_localize_script( 'wpbulkremove-js', 'wpbulkremove', $wpbulkremove_array );
	}
}

/*
*
* ajax hook
*
*/

add_action( 'wp_ajax_masterns_bulk_remove_cat', 'masterns_bulk_remove_cat_edit_hook' ); 
function masterns_bulk_remove_cat_edit_hook() {

	if( empty( $_POST[ 'post_ids' ] ) ) {
		die();
	}	
	if( empty( $_POST[ 'catout' ] ) ) {
		die();
	}
	
	if( $_POST[ 'type' ] == 'edit-post' ) {
		$bulktax = 'category';
	} elseif($_POST[ 'type' ] == 'edit-product') {
		$bulktax = 'product_cat';
	} else {
		$bulktax = $_POST[ 'taxonomy' ];
	}
 
	foreach( $_POST[ 'post_ids' ] as $id ) {
		$post_id = (int)$id;
		foreach( $_POST[ 'catout' ] as $cat ) {
			$cat_id = (int)$cat;			
			$rem = wp_remove_object_terms( $post_id, $cat_id, $bulktax );
		}
	} 
	die();
}





