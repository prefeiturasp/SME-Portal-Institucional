<?php
add_action( 'init', 'create_tag_taxonomies', 0 );

//create two taxonomies, genres and tags for the post type "tag"
function create_tag_taxonomies() 
{
  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Filtros', 'taxonomy general name' ),
    'singular_name' => _x( 'Fitro', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Filtros' ),
    'popular_items' => __( 'Popular Filtro' ),
    'all_items' => __( 'Todos os Filtros' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Filtro' ), 
    'update_item' => __( 'Atualizar Filtro' ),
    'add_new_item' => __( 'Adicionar novo Filtro' ),
    'new_item_name' => __( 'Novo nome do Filtro' ),
    'separate_items_with_commas' => __( 'Separe filtros com virgulas' ),
    'add_or_remove_items' => __( 'Adicionar ou remover filtros' ),
    'choose_from_most_used' => __( 'Escolha entre as filtros mais usados' ),
    'menu_name' => __( 'Filtros' ),
  ); 

  register_taxonomy('filtro','transparencia',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'filtro' ),
  ));
}