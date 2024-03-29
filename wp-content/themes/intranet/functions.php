<?php
// Desabilitando o Gutemberg
add_filter('use_block_editor_for_post', '__return_false');

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

// Remover a tag p da category_description
remove_filter('term_description', 'wpautop');
// Remover a tag p do the_excerpt()
remove_filter('the_excerpt', 'wpautop');

add_action('after_setup_theme', 'custom_setup');

function custom_setup() {
	if ( !( current_user_can('editor') || current_user_can('administrator') ) && !is_admin() ) {
		show_admin_bar(false);
	}
	add_action('wp_enqueue_scripts', 'custom_formats');
	add_filter('get_image_tag_class', 'image_tag_class');
	add_action('login_head', 'custom_login_logo');
	add_filter('login_headerurl', 'my_login_logo_url');
	add_filter('login_headertitle', 'my_login_logo_url_title');
	add_action( 'widgets_init', 'theme_slug_widgets_init' );

	register_nav_menus(array(
		'primary' => __('Menu Superior', 'THEMENAME'),
	));

	register_nav_menus(array(
		'primary_parc' => __('Menu Superior Parceiras', 'THEMENAME'),
	));

	register_nav_menu('navbar', __('Navbar', 'your-theme'));


	if (function_exists('add_image_size')) {
		add_theme_support('post-thumbnails');
	}

	if (function_exists('add_image_size')) {
		add_image_size('home-thumb', 250, 166);
		add_image_size('default-image', 825, 470, true);
		add_image_size('img-dest', 1000, 400, true);
	}

	//Permite adicionar no post ou página uma imagem com tamanho personalizado, nesse caso a home-thumb já definida anteriormente com 250X147
	function custom_choose_sizes($sizes) {
		$custom_sizes = array(
			'home-thumb' => 'Tamanho Personalizado',
			'default-image' => 'Tamanho Padrão',
			'img-dest' => 'Imagem de Destaque'
		);
		return array_merge($sizes, $custom_sizes);
	}

	add_filter('image_size_names_choose', 'custom_choose_sizes');

// Limita o Numero de palavras da função the_excerpt(), nesse caso em 20
	function wpdev_custom_excerpt_length() {
		return 20;
	}
	add_filter('excerpt_length', 'wpdev_custom_excerpt_length');

	function theme_slug_widgets_init()
	{

		register_sidebar(array(
			'name' => 'Rodape Esquerda',
			'id' => 'sidebar-4',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<p class="titulo-rodape">',
			'after_title' => '</p>',
		));

		register_sidebar(array(
			'name' => 'Rodape Centro',
			'id' => 'sidebar-5',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<p class="titulo-rodape">',
			'after_title' => '</p>',
		));


		register_sidebar(array(
			'name' => 'Rodape Direita',
			'id' => 'sidebar-6',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<p class="titulo-rodape">',
			'after_title' => '</p>',
		));

		register_sidebar(array(
			'name' => 'Facebook Home',
			'id' => 'sidebar-7',
			'before_widget' => '',
			'after_widget' => '',
			//'before_title' => '<p class="titulo-rodape">',
			//'after_title' => '</p>',
		));
	}


//////////////////////////////////////////////////////////////////////////
///        FUNCAO PARA TROCAR BACKGROUND                            /////
////////////////////////////////////////////////////////////////////////


	$defaults = array(
		'default-color' => '',
		'default-image' => '',
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => ''
	);
	add_theme_support('custom-background', $defaults);


//////////////////////////////////////////////////////////////////////////
///        FUNCAO HEADER, PARA TROCAR O CABEÃ‡ALHO                   /////
////////////////////////////////////////////////////////////////////////
	$defaults = array(
		'default-image' => '',
		'width' => 0,
		'height' => 0,
		'flex-height' => false,
		'flex-width' => false,
		'uploads' => true,
		'random-default' => false,
		'header-text' => true,
		'default-text-color' => '',
		'wp-head-callback' => '',
		'admin-head-callback' => '',
		'admin-preview-callback' => '',
	);
	add_theme_support('custom-header', $defaults);


//////////////////////////////////////////////////////////////////////////
///        FUNCAO HEADER, PARA TROCAR O lOGOTIPO                    /////
////////////////////////////////////////////////////////////////////////
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );


}

function custom_formats() {

	//wp_register_style('bootstrap_css', STM_THEME_URL . 'css/bootstrap.css', null, null, 'all');
	wp_register_style('bootstrap_4_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css', null, '4.2.1', 'all');

	wp_register_style('animate_css', STM_THEME_URL . 'css/animate.css', null, null, 'all');
	wp_register_style('hamburger_menu_icons_css', STM_THEME_URL . 'css/hamburger_menu_icons.css', null, null, 'all');
	wp_register_style('hover-effects_css', STM_THEME_URL . 'css/hover-effects.css', null, null, 'all');
	wp_register_style('default_ie', STM_THEME_URL . 'css/ie6.1.1.css', null, null, 'all');
	wp_register_style('font_awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_register_style('style', get_stylesheet_uri(), null, null, 'all');
	wp_register_style('slick_css', STM_THEME_URL . 'css/slick.css', null, null, 'all');
	wp_register_style('slick_theme_css', STM_THEME_URL . 'css/slick-theme.css', null, null, 'all');

	//wp_register_script('bootstrap_js', STM_THEME_URL . 'js/bootstrap.js', false, false);

	wp_register_script('bootstrap_4_popper_js',  'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js', false, '1.14.6', true);
	wp_register_script('bootstrap_4_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', false, '4.2.1', true);


	wp_register_script('modal_on_load_js', STM_THEME_URL . 'js/modal_on_load.js', false, true);
	wp_register_script('wow_js', STM_THEME_URL . 'js/wow.min.js', array('jquery'), 1.0, true);
	wp_register_script('jquery_waituntilexists', STM_THEME_URL . 'js/jquery.waituntilexists.js', array('jquery'), 1.0, true);
	wp_register_script('scripts_js', STM_THEME_URL . 'js/scripts.js', array('jquery'), 1.0, true);
	wp_register_script('jquery.event.move_js', STM_THEME_URL . 'js/jquery.event.move.js', array('jquery'), 1.0, true);
	wp_register_script('slick_min_js', STM_THEME_URL . 'js/slick.min.js', array('jquery'), 1.0, true);
	wp_register_script('slick_func_js', STM_THEME_URL . 'js/slick-func.js', array('jquery'), 1.0, true);
	wp_register_script('lightbox_js', STM_THEME_URL . 'js/jquery-simple-lightbox.js', array('jquery'), 1.0, true);


	global $wp_styles;
	$wp_styles->add_data('default_ie', 'conditional', 'IE 6');
	wp_enqueue_style('bootstrap_4_css');

	wp_enqueue_style('animate_css');
	wp_enqueue_style('hamburger_menu_icons_css');
	wp_enqueue_style('hover-effects_css');
	wp_enqueue_style('default_ie');
	wp_enqueue_style('font_awesome');
	wp_enqueue_style('style');

	wp_enqueue_script('jquery');

	wp_enqueue_script('bootstrap_4_popper_js');
	wp_enqueue_script('bootstrap_4_js');

	wp_enqueue_script('modal_on_load_js');
	wp_enqueue_script('wow_js');
	wp_enqueue_script('jquery_waituntilexists');
	wp_enqueue_script('scripts_js');
	wp_enqueue_script('jquery.event.move_js');
}

// **************** Scripts para fazer o efeito de rolagem do menu funcionar corretamente ****************

/* Função para adicionar classes ao li a do menu wp-nav-menu para fazer o efeito de scroll */
function adicionar_nav_class($output) {
	$output = preg_replace('/<a/', '<a class="nav-link scroll"', $output, -1);
	return $output;
}
add_filter('wp_nav_menu', 'adicionar_nav_class');



// **************** FIM dos Scripts para fazer o efeito de rolagem do menu funcionar corretamente ****************

/* Função para adicionar classes a imagem que vem da biblioteca de midia */
function image_tag_class($class) {
	$class .= ' img-fluid';
	return $class;
}

function paginacao() {
	echo '<nav id="pagination" class="container">';
	global $wp_query;
	$pagina_atual = (int) $wp_query->get('paged');
	if (!$pagina_atual)
		$pagina_atual = 1;
	$total_paginas = (int) $wp_query->max_num_pages;
	echo paginate_links(
		array(
			'current' => $pagina_atual,
			'total' => $total_paginas,
			'base' => str_replace($total_paginas + 1, '%#%', get_pagenum_link($total_paginas + 1)),
			'prev_next'         => True,
			'prev_text'          	=> __('<i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i>'),
			'next_text'          	=> __('<i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i>'),
		)
	);
	echo '</nav>';
}


function custom_login_logo() {
//Altera o logo
	echo '<style type="text/css">
.login h1 a{ background-size: 273px 159px !important; width:323px; height:159px }
h1 a { background-image: url(' . get_bloginfo('template_directory') . '/img/logo_admin.png) !important; }
</style>';

//Altera a Imagem do Background
	echo '<style type="text/css">
body { background-image: url(' . get_bloginfo('template_directory') . '/img/bg-background.png) !important; }
</style>';
}

//Link na tela de login para a pÃ¡gina inicial
function my_login_logo_url() {
	return STM_URL;
}

function my_login_logo_url_title() {
	return STM_SITE_NAME;
}

// Adicionando alt e title nas images
add_filter( 'wp_get_attachment_image_attributes','getAltTitleImagesThePostThumbnail', 10, 2 );
function getAltTitleImagesThePostThumbnail( $attr=null, $attachment = null ) {

	//$img_title = trim( strip_tags( $attachment->post_title ) );
	$img_alt = trim( strip_tags( $attachment->post_excerpt ) );

/*	if (!$img_alt){
		$img_alt = $img_title;
	}*/

	$attr['alt'] = $img_alt;
	//$attr['title'] = $img_title;


	return $attr;
}


function incluir_nome_nos_anexos($post_id, $xml_node, $is_update)
{
	$xml_node = (array) $xml_node;
	$nome_dos_arquivos = $xml_node['Files_Nomes_Dos_Arquivos'];
	$pieces = explode(',', $nome_dos_arquivos);
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$post =  get_post($post_id);

	$attachments = get_posts( array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_parent' => $post_id,
		'orderby'	=> 'ID',
		'order'	=> 'ASC',
		'exclude'     => $post_thumbnail_id
	) );

	if ($attachments) {
		foreach ($attachments as $index => $attachment) {

			$my_post = array(
				'ID' => $attachment->ID,
				'post_title' => $pieces[$index], // FINAL
				'post_excerpt' => $post->post_excerpt,
				'post_content' => $post->post_excerpt,
			);
			// Update do post dentro do Banco de Dados
			wp_update_post($my_post);

		}
	}
}

add_action('pmxi_saved_post', 'incluir_nome_nos_anexos', 10, 3);

add_image_size( 'admin-list-thumb', 80, 80, false );

// Retirando a tag <p> antes e depois de um iframe dentro do the_content
function remove_some_ptags( $content ) {
	$content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	$content = preg_replace('/<p>\s*(<script.*>*.<\/script>)\s*<\/p>/iU', '\1', $content);
	$content = preg_replace('/<p>\s*(<iframe.*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
	return $content;
}
add_filter( 'the_content', 'remove_some_ptags' );

// Removendo o atributo title dos menus
function my_menu_notitle( $menu ){
	return $menu = preg_replace('/ title=\"(.*?)\"/', '', $menu );

}
add_filter( 'wp_nav_menu', 'my_menu_notitle' );
add_filter( 'wp_page_menu', 'my_menu_notitle' );
add_filter( 'wp_list_categories', 'my_menu_notitle' );

/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}

// POSTS MAIS VISTOS  (NO FUNCTIONS)
function shapeSpace_popular_posts($post_id) {
	$count_key = 'popular_posts';
	$count = get_post_meta($post_id, $count_key, true);
	if ($count == '') {
		$count = 0;
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
	} else {
		$count++;
		update_post_meta($post_id, $count_key, $count);
	}
}
function shapeSpace_track_posts($post_id) {
	if (!is_single()) return;
	if (empty($post_id)) {
		global $post;
		$post_id = $post->ID;
	}
	shapeSpace_popular_posts($post_id);
}
add_action('wp_head', 'shapeSpace_track_posts');

function redireciona_paginas_pendentes(){
	if( is_404() ){
		global $wpdb;
		$querystr = "
			 SELECT $wpdb->posts.post_title 
			FROM $wpdb->posts
			WHERE $wpdb->posts.post_status = 'pending' 
			AND $wpdb->posts.post_type = 'page'
			ORDER BY $wpdb->posts.post_date DESC
 ";
		$pageposts = $wpdb->get_results($querystr, OBJECT);
		$slug_nome_das_paginas = [];
		foreach ($pageposts as $page){
			$slug_nome_das_paginas[] = sanitize_title($page->post_title);
		}
		$uri = trim($_SERVER['REQUEST_URI'], '/');
		$segments = explode('/', $uri);
		$slug_index = count($segments);

		$page_slug = $segments[$slug_index - 1];

		if (in_array($page_slug, $slug_nome_das_paginas)){
			wp_redirect(STM_URL.'/conteudo-em-atualizacao/');
		}



	}
}
add_action('template_redirect', 'redireciona_paginas_pendentes');

define('STM_URL', get_home_url());
define('STM_THEME_URL', get_bloginfo('template_url') . '/');
define('STM_SITE_NAME', get_bloginfo('name'));
define('STM_SITE_DESCRIPTION', get_bloginfo('description'));
define('__ROOT__', dirname(dirname(__FILE__)).'/intranet');

if ($_GET && $_GET['lang'] == 'en') {
	require_once('includes/en.php');
} else {
	require_once('includes/pt.php');
}

// Inicialização das Classes
require_once 'classes/init.php';

require_once('classes/wp_bootstrap_navwalker.php');

// Carrega contador de visualizações de noticias
require 'includes/cont_visualizacao.php';

///////////////////////////////////////////////////////////////////////////////
/////////////////////habilita carregar SVG no wordpress////////////////////////
///////////////////////////////////////////////////////////////////////////////
function cc_mime_types($mimes) {
       $mimes['svg'] = 'image/svg+xml';
       return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

////////Habilita Opções Gerais ACF////////
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Configurações Gerais',
        'menu_title'	=> 'Opções Gerais',
        'menu_slug' 	=> 'conf-geral',
        'position' 		=> '3',
		'update_button' => __('Atualizar', 'acf'),
        'capability'	=> 'publish_pages',
        //'redirect'		=> false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Alerta da Página Inicial',
        'menu_title'	=> 'Alerta da Página Inicial',
        'parent_slug'	=> 'conf-geral',
		'capability'	=> 'publish_pages',
		'update_button' => __('Atualizar', 'acf'),
		'updated_message' => __("Alerta da Página Inicial atualizado com sucesso", 'acf'),
    ));	
	
	acf_add_options_sub_page(array(
        'page_title' 	=> 'Configurações da Busca Manual',
        'menu_title'	=> 'Busca Manual',
        'parent_slug'	=> 'conf-geral',
		'capability'	=> 'publish_pages',
		'update_button' => __('Atualizar', 'acf'),
		'updated_message' => __("Configurações da Busca atualizado com sucesso", 'acf'),
	));
	
	acf_add_options_sub_page(array(
        'page_title' 	=> 'Configurações de tutoriais',
        'menu_title'	=> 'Inclusão de tutoriais',
        'parent_slug'	=> 'conf-geral',
        'capability'	=> 'publish_pages',
		'update_button' => __('Atualizar', 'acf'),
		'updated_message' => __("Tutoriais atualizado com sucesso", 'acf'),
    ));

	acf_add_options_sub_page(array(
        'page_title' 	=> 'Analytics',
        'menu_title'	=> 'Analytics',
        'parent_slug'	=> 'conf-geral',
        'capability'	=> 'publish_pages',
		'post_id' 		=> 'conf-analytics',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Informações Rodapé e Topo',
        'menu_title'	=> 'Rodapé e Topo',
        'parent_slug'	=> 'conf-geral',
        'capability'	=> 'publish_pages',
		'post_id' => 'conf-rodape',
		'update_button' => __('Atualizar', 'acf'),
		'updated_message' => __("Informações do Rodapé e Topo atualizados com sucesso", 'acf'),
    ));

	acf_add_options_sub_page(array(
        'page_title' 	=> 'Redirecionamentos',
        'menu_title'	=> 'Redirecionamentos',
        'parent_slug'	=> 'conf-geral',
        'capability'	=> 'publish_pages',
		'update_button' => __('Atualizar', 'acf'),
		'updated_message' => __("Redirecionamentos atualizado com sucesso", 'acf'),
    ));

}
///////////////////////////////////////////////////////////////////

////////Ordena Relação de posts do ACF por data////////
function my_relationship_query( $args, $field, $post_id ) {
	
    // only show children of the current post being edited
    //$args['post_parent'] = $post_id;
	$args['orderby'] = 'date';
	$args['order'] = 'DESC';
	
	// return
    return $args;
    
}
// filter for every field
add_filter('acf/fields/relationship/query', 'my_relationship_query', 10, 3);

//força posicionamento dos campos ACF
function prefix_reset_metabox_positions(){
  delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_post' );
  delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_page' );
  delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_custom_post_type' );
}
add_action( 'admin_init', 'prefix_reset_metabox_positions' );


//habilita revisões para o ACF
add_filter( 'rest_prepare_revision', function($response, $post){
	$data = $response->get_data();
	$data['acf'] = get_fields( $post->ID );

	return rest_ensure_response( $data );
}, 10, 2);

//habilita atualizações para o ACF
function my_acf_save_post( $post_id ) {

  // bail out early if we don't need to update the date
  if( is_admin() || $post_id == 'new' ) {
     return;
   }

   global $wpdb;

   $datetime = date("Y-m-d H:i:s");

   $query = "UPDATE $wpdb->posts
	     SET
              post_modified = '$datetime'
             WHERE
              ID = '$post_id'";

    $wpdb->query( $query );

}

// run after ACF saves the $_POST['acf'] data
add_action('acf/save_post', 'my_acf_save_post', 20);

//coloca data atual no campo data no ACF
function my_acf_default_date($field){
	$field['default_value'] = date('dmY');
	return $field;
}
add_filter('acf/load_field/name=data_da_atualizacao_organograma','my_acf_default_date');

add_filter( 'request', 'my_request_filter' );
function my_request_filter( $query_vars ) {
    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
        global $no_search_results;
        $no_search_results = TRUE;
    }
    return $query_vars;
}

function template_chooser($template){    
  global $wp_query;  
  global $no_search_results;
  $post_type = get_query_var('post_type');
  if( $wp_query->is_search && $post_type == 'concurso' )   
  {
    return locate_template('search_concurso.php');  //  redirect to archive-search.php
  }
  return $template;   
}
add_filter('template_include', 'template_chooser');

// Adiciona o title como parametro no wp_query
add_filter( 'posts_where', 'title_like_posts_where', 10, 2 );
function title_like_posts_where( $where, $wp_query ) {
    global $wpdb;
    if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $post_title_like ) ) . '%\'';
    }
    return $where;
}


add_action('pre_user_query','wpse_27518_pre_user_query');
function wpse_27518_pre_user_query($user_search) {
    global $wpdb,$current_screen;

    if ( 'users' != $current_screen->id ) 
        return;

    $vars = $user_search->query_vars;

    if('setor' == $vars['orderby']) 
    {
        $user_search->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='setor')"; 
        $user_search->query_orderby = ' ORDER BY UPPER(m1.meta_value) '. $vars['order'];
    } 
    
}

// Remove o campo "Additional Capabilities" do editor de usuario
add_filter( 'ure_show_additional_capabilities_section', '__return_false' );

function get_first_image( $post_id ) {

    $post = get_post($post_id );
	$content = $post->post_content;
	$regex = '/src="([^"]*)"/';
	preg_match_all( $regex, $content, $matches );																			

	$re = '/-\d+[Xx]\d+\./';
	$str = $matches[1][0];
	$subst = '.';

	$result = preg_replace($re, $subst, $str, 1);
	
	$idImage = attachment_url_to_postid( $result );

	if($idImage != 0){
		return $idImage;
	} else {
		return false;
	}

}

function get_thumb( $post_id ){

	$result = array();

	$imgSelect = get_the_post_thumbnail_url($post_id, 'default-image');	
	$firstImage = get_first_image($post_id);

	if($imgSelect){

		$thumbnail_id = get_post_thumbnail_id( $post_id );
		$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 

		if(!$alt){
			$alt = get_the_title($post_id);
		}

		$result[0] = $imgSelect;
		$result[1] = $alt;

	} elseif($firstImage){
		
		$imgOne = wp_get_attachment_image_src($firstImage, 'default-image');
		$alt = get_post_meta($firstImage, '_wp_attachment_image_alt', true);
		
		$imgSlide = $imgOne[0];
		if(!$alt){
			$alt = get_the_title($post_id);
		}

		$result[0] = $imgSlide;
		$result[1] = $alt;

	} else {
		$imgSlide = 'https://hom-educacao.sme.prefeitura.sp.gov.br/wp-content/uploads/2020/03/placeholder06.jpg';
		if(!$alt){
			$alt = get_the_title($post_id);
		}

		$result[0] = $imgSlide;
		$result[1] = $alt;
	}

	return $result;
}

// Unifica o array multidimensional em array unico
function array_flatten($array) { 
	if (!is_array($array)) { 
	  return FALSE; 
	} 
	$result = array(); 
	foreach ($array as $key => $value) { 
	  if (is_array($value)) { 
		$result = array_merge($result, array_flatten($value)); 
	  } 
	  else { 
		$result[$key] = $value; 
	  } 
	} 
	return $result; 
}

// Filtra as paginas que grupo pertence

function wp37_limit_posts_to_author($query) {

	// pega as informacoes do usuario logado
	$user = wp_get_current_user();

	// 	filtra as paginas pelo grupo pertencente
	if( $_GET['filter'] == 'grupo' && $user->roles[0] == 'contributor')  {
		
		$variable = get_user_meta($user->ID, 'grupo', true);
		$variable = array_flatten($variable);
        $variable = array_unique($variable);
		
		$pages = array();

		if($variable && $variable != ''){
            foreach($variable as $grupo){
				$pages[] = get_post_meta($grupo, 'selecionar_paginas', true);
				$pages[] = get_post_meta($grupo, 'contatos_sme', true);
			}
        }

		$pages = array_flatten($pages);
        $pages = array_unique($pages);
		
		//print_r($variable);
		$query->set('post__in', $pages);
	} 

	// 	filtra as paginas por grupos
	if( $_GET['grupo_id'] != '')  {
		
		$grupo = $_GET['grupo_id'];

		if($grupo && $grupo != ''){   
			if($_GET['post_type'] == 'contato'){
				$pages = get_post_meta($grupo, 'contatos_sme', true);
			} else {
				$pages = get_post_meta($grupo, 'selecionar_paginas', true);
			}
        }

		$pages = array_flatten($pages);
        $pages = array_unique($pages);
		
		//print_r($variable);
		$query->set('post__in', $pages);
	}	
	
	return $query;
	
}
add_filter('pre_get_posts', 'wp37_limit_posts_to_author');

// Adiciona o filtro Minhas Paginas
function wp38_add_movies_filter($views){
	
	// pega as informacoes do usuario logado
	$user = wp_get_current_user();

	if($user->roles[0] == 'contributor'){

		if( $_GET['filter'] == 'grupo' ){

			$views['grupos'] = "<a href='" . admin_url('edit.php?post_type=page&filter=grupo') . "' class='current'>Minhas Páginas</a>";
		return $views;

		} else {
			$views['grupos'] = "<a href='" . admin_url('edit.php?post_type=page&filter=grupo') . "'>Minhas Páginas</a>";
		return $views;
		}
	}

	return $views;
}
 
add_filter('views_edit-page', 'wp38_add_movies_filter');

// Altera a URL de Paginas para colaboladores
add_action('admin_menu', 'add_custom_link_into_appearnace_menu');
function add_custom_link_into_appearnace_menu() {
	global $submenu;
	
    // pega as informacoes do usuario logado
	$user = wp_get_current_user();
	
	if($user->roles[0] == 'contributor'){		
		$submenu['edit.php?post_type=page'][5][2] = 'edit.php?post_type=page&filter=grupo';
		$submenu['edit.php?post_type=contato'][5][2] = 'edit.php?post_type=contato&filter=grupo';
	}
}

// Adiciona o filtro Meus Contatos
function contatos_filter($views){

	// pega as informacoes do usuario logado
	$user = wp_get_current_user();

	if($user->roles[0] == 'contributor'){

		if( $_GET['filter'] == 'grupo' ){

			$views['grupos'] = "<a href='" . admin_url('edit.php?post_type=contato&filter=grupo') . "' class='current'>Meus Contatos</a>";
		return $views;

		} else {
			$views['grupos'] = "<a href='" . admin_url('edit.php?post_type=contato&filter=grupo') . "'>Meus Contatos</a>";
		return $views;
		}
	}

	return $views;
}

add_filter('views_edit-contato', 'contatos_filter');

// Incluir CSS no admin
function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}

add_action('admin_enqueue_scripts', 'admin_style');

//remover opções de cores do perfil de usuários
function admin_color_scheme() {
	global $_wp_admin_css_colors;
	$_wp_admin_css_colors = 0;
}
add_action('admin_head', 'admin_color_scheme');

//remove avisos de atualizações do wordpress, temas e plugins
add_filter( 'pre_site_transient_update_core','remove_core_updates' );
add_filter( 'pre_site_transient_update_plugins','remove_core_updates' );
add_filter( 'pre_site_transient_update_themes','remove_core_updates' );

function remove_core_updates(){
    global $wp_version;
    return(object) array(
        'last_checked' => time(),
        'version_checked' => $wp_version
    );
}


// Filtrar usuarios por grupo
function filter_users_by_grupo_id( $query ) {
    global $pagenow;

    
	if ( is_admin() && 
         'users.php' == $pagenow && 
         isset( $_GET[ 'grupo_id' ] ) && 
         !empty( $_GET[ 'grupo_id' ] ) 
       ) {
        $section = $_GET[ 'grupo_id' ];
        $meta_query = array(
            array(
				'key' => 'grupo', // name of custom field
				'value' => '"' . $section . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
				'compare' => 'LIKE'
			)
        );
		
        $query->set( 'meta_key', 'grupo' );
        $query->set( 'meta_query', $meta_query );
		
    }
}
add_filter( 'pre_get_users', 'filter_users_by_grupo_id' );

// Aumenta o tamanho do seletor de paginas
function custom_acf_css() {
	global $typenow;
    if( 'editores_portal' == $typenow ){
		echo '<style>
			.acf-relationship .list {
				height: 500px;
			}
		</style>';
	}

}
add_action('admin_head', 'custom_acf_css');

function clean($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.										 
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

// Inclui o JS para alterar o tipo de campo no alt das imagens
function custom_admin_js() {
    $url = get_bloginfo('template_directory') . '/js/wp-admin.js';
    echo '"<script type="text/javascript" src="'. $url . '"></script>"';
}
add_action('admin_footer', 'custom_admin_js');

// Altera o texto da label
add_filter(  'gettext',  'dirty_translate'  );
add_filter(  'ngettext',  'dirty_translate'  );
function dirty_translate( $translated ) {
     $words = array(
            // 'word to translate' => 'translation'
            'Texto alternativo' => 'Descrição para acessibilidade'
     );
$translated = str_ireplace(  array_keys($words),  $words,  $translated );
return $translated;
}

add_filter( 'wp_insert_post_data', 're_aprove', '99', 2 );
function re_aprove( $data, $postarr ) {
	
	$user = wp_get_current_user();
	if ( in_array( 'contributor', (array) $user->roles ) ) {
		if ( 'publish' === $data['post_status'] ) {
            $data['post_status'] = 'pending';
        }
	}
    
    return $data;
}

// Compare dates ASC
function sort_objects_by_date($a, $b) {
	if($a->post_date == $b->post_date){ return 0 ; }
		return ($a->post_date > $b->post_date) ? -1 : 1;
}

function wcag_nav_menu_link_attributes( $atts, $item, $depth ) {

    // Add [aria-haspopup] and [aria-expanded] to menu items that have children
    $item_has_children = in_array( 'menu-item-has-children', $item->classes );
    if ( $item_has_children ) {
        $atts['role'] = "button";
        $atts['aria-expanded'] = "false";
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'wcag_nav_menu_link_attributes', 10, 4 );

// Desabilitar funcoes de usuarios
remove_role( 'subscriber' ); // Assinante
remove_role( 'author' ); // Autor

// Renomear tipo de usuario Contribuidor para Colaborador
add_action( 'wp_roles_init', static function ( \WP_Roles $roles ) {
    $roles->roles['contributor']['name'] = 'Colaborador';
    $roles->role_names['contributor'] = 'Colaborador';
} );

function str_replace_assoc(array $replace, $subject) {
	return str_replace(array_keys($replace), array_values($replace), $subject);   
}

function convert_chars_url($string){

	$replace = array(
		'a%CC%80' => '(.*)', // à
		'a%CC%81' => '(.*)', // á
		'a%CC%82' => '(.*)', // â
		'a%CC%83' => '(.*)', // ã
		'à' => '(.*)', // à
		'á' => '(.*)', // á
		'â' => '(.*)', // â
		'ã' => '(.*)', // ã
		'e%CC%80' => '(.*)', // è
		'e%CC%81' => '(.*)', // é
		'e%CC%82' => '(.*)', // ê
		'è' => '(.*)', // è
		'é' => '(.*)', // é
		'ê' => '(.*)', // ê
		'%C3%A9' => '(.*)',
		'i%CC%80' => '(.*)', // ì
		'i%CC%81' => '(.*)', // í
		'i%CC%82' => '(.*)', // î
		'ì' => '(.*)', // ì
		'í' => '(.*)', // í
		'î' => '(.*)', // î
		'o%CC%80' => '(.*)', // ò
		'o%CC%81' => '(.*)', // ó
		'o%CC%82' => '(.*)', // ô
		'o%CC%83' => '(.*)', // õ
		'ò' => '(.*)', // ò
		'ó' => '(.*)', // ó
		'ô' => '(.*)', // ô
		'õ' => '(.*)', // õ
		'u%CC%80' => '(.*)', // ù
		'u%CC%81' => '(.*)', // ú
		'u%CC%82' => '(.*)', // û
		'ù' => '(.*)', // ù
		'ú' => '(.*)', // ú
		'û' => '(.*)', // û
		'ç' => '(.*)', // ç
	);
	$retorno = str_replace_assoc($replace,$string);
	return $retorno;
}

function redirects_admin() {
	$links = '';
	$alllinks = get_field('redirecionar','option');

	foreach($alllinks as $link){
		$origem = $link['origem'];
		$origem = str_replace('https://educacao.sme.prefeitura.sp.gov.br', '', $origem);
		$origem = str_replace('http://educacao.sme.prefeitura.sp.gov.br', '', $origem);
		$origem = convert_chars_url($origem);
		
		if (strpos($origem, '/uploads/') == false) {
			$lastChar = substr($origem, -1);
			if($lastChar == '/'){
				$origem = substr($origem, 0, -1);				
				$origem = '^' . $origem . '(\/|)$';
			} else {
				$origem = '^' . $origem . '(\/|)$';
			}
		}

		$destino = $link['destino'];
		$links .= 'RedirectMatch 301 ' . $origem . ' ' . $destino . PHP_EOL;
	}

	$path = ABSPATH;
    $htaccess_content = file_get_contents( $path . '.htaccess' );
    $filtered_htaccess_content = trim( preg_replace( '/\# REDIRECTS[\s\S]+?# END REDIRECTS/si',
	 '# REDIRECTS' . PHP_EOL 
	 . $links . 
	 PHP_EOL . '# END REDIRECTS', 
	 $htaccess_content ) );

    //print_r($filtered_htaccess_content);
    $fp = fopen( $path . '.htaccess','w+');
    if($fp)
    {
        fwrite($fp, $filtered_htaccess_content);
        fclose($fp);
    }
}
add_action('acf/save_post', 'redirects_admin'); 

// Ordenar Objeto de Posts por data - ACF
add_filter('acf/fields/post_object/query', 'my_acf_fields_post_object_query', 10, 3);
function my_acf_fields_post_object_query( $args, $field, $post_id ) {

    // modify the order
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';

    return $args;
}

// Definir imagem destacada padrao

function fpw_post_info( $id, $post ) {

	$firstImage = get_first_image($post->ID);

    if( has_post_thumbnail( $post->ID ) ){

		$idThumb = get_post_thumbnail_id($post->ID);
		set_post_thumbnail( $post->ID, $idThumb );

	} elseif($firstImage){

		set_post_thumbnail( $post->ID, $firstImage );

	} else {

		delete_post_meta( $post->ID, '_thumbnail_id' );
		set_post_thumbnail( $post->ID, 28528 );
		
	}
}
add_action( 'publish_post', 'fpw_post_info', 10, 2 );

// Gerar string aleatoria
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Listar apenas pagina atual e as subpaginas
add_filter('acf/fields/relationship/query/name=menu_lateral_principal', 'change_posts_order', 10, 3);
add_filter('acf/fields/relationship/query/name=outros_pagina', 'change_posts_order', 10, 3);
function change_posts_order( $args, $field, $post_id ){

	$pages = array();
	$pages[] = $post_id;

	$getpages = get_pages(array( 'child_of' => $post_id) );

	foreach($getpages as $page){
		$pages[] = $page->ID;
	}

	$args['post__in'] = $pages;

    return $args;
}

add_filter('redirect_canonical','pif_disable_redirect_canonical');

function pif_disable_redirect_canonical($redirect_url) {
    if (is_singular()) $redirect_url = false;
return $redirect_url;
}

// Desabilitar colunas do Yoast no listagem de noticias e paginas
add_filter( 'manage_edit-post_columns', 'yoast_seo_admin_remove_columns', 10, 1 );
add_filter( 'manage_edit-page_columns', 'yoast_seo_admin_remove_columns', 10, 1 );

function yoast_seo_admin_remove_columns( $columns ) {
  unset($columns['wpseo-score-readability']);
  unset($columns['wpseo-title']);
  unset($columns['wpseo-metadesc']);
  unset($columns['wpseo-focuskw']);
  unset($columns['wpseo-links']);
  unset($columns['wpseo-linked']);
  return $columns;
}

// Move Yoast Meta Box to bottom
function yoasttobottom() {
	return 'low';
}

add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
  wp_enqueue_style( 'dashicons' );
}

/**
 * Relacionamento Reciproco / Grupos e Paginas
 * Entre dois campos de relacionamento que pertencem a diferentes tipos de postagem
 */
// Defina as chaves de campo para os dois campos de relacionamento
$key_a = 'field_5fecb928c7571'; // Grupos
$key_b = 'field_616875a8b6c80'; // Paginas

// Adicione o filtro ao primeiro campo de relacionamento
// A chave deve corresponder a $ key_a acima
add_filter(
    'acf/update_value/key=field_5fecb928c7571',
    function ($value, $post_id, $field) use ($key_a, $key_b) {
        return acf_reciprocal_relationship($value, $post_id, $field, $key_a, $key_b);
    },
    10, 5
);

// Adicione o filtro ao segundo campo de relacionamento
// A chave deve corresponder a $ key_b acima
add_filter(
    'acf/update_value/key=field_616875a8b6c80',
    function ($value, $post_id, $field) use ($key_a, $key_b) {
        return acf_reciprocal_relationship($value, $post_id, $field, $key_a, $key_b);
    },
    10, 5
);


/**
 * Quando um campo de relacionamento é definido, um relacionamento recíproco
 * também é definido no tipo de post de destino.
 *
 * @param [type] $value
 * @param [type] $post_id
 * @param [type] $field
 * @param [type] $key_a
 * @param [type] $key_b
 * @return void
 */
function acf_reciprocal_relationship($value, $post_id, $field, $key_a, $key_b)
{
    // descobrir em que lado estamos trabalhando e configurar as variáveis
    // $key_a representa o campo para as postagens atuais
    // e $key_b representa o campo em postagens relacionadas
    if ($key_a !== $field['key']) {
        $temp = $key_a;
        $key_a = $key_b;
        $key_b = $temp;
    }

    // obter os dois campos
    // esta funcao do ACF obtem od valores dos campos
    $field_a = acf_get_field($key_a);
    $field_b = acf_get_field($key_b);

    // defina os nomes dos campos para verificar em cada postagem
    $name_a = $field_a['name'];
    $name_b = $field_b['name'];

    // obtem o valor do campo da postagem atual
	// e verifica se ela precisa ser atualizada

	$old_values = get_post_meta($post_id, $name_a, true);
    // verificar se o valor contem um array
    if (!is_array($old_values)) {
        if (empty($old_values)) {
            $old_values = array();
        } else {
            $old_values = array($old_values);
        }
    }
    // define novos valores para $value
    $new_values = $value;
    // verificar se o valor contem um array
    if (!is_array($new_values)) {
        if (empty($new_values)) {
            $new_values = array();
        } else {
            $new_values = array($new_values);
        }
    }


    $add = $new_values;
    $delete = array_diff($old_values, $new_values);

    // reordene os arrays para evitar possiveis erros de indice invalido
    $add = array_values($add);
    $delete = array_values($delete);

    if (!count($add) && !count($delete)) {
        // se nao tiver diferenca
        // nao ha nada pra fazer
        return $value;
    }

    // deleta o primeiro
    // passa por todos os posts que precisam ter a relacao removida
    for ($i=0; $i<count($delete); $i++) {
        $related_values = get_post_meta($delete[$i], $name_b, true);
        if (!is_array($related_values)) {
            if (empty($related_values)) {
                $related_values = array();
            } else {
                $related_values = array($related_values);
            }
        }

        $related_values = array_diff($related_values, array($post_id));
        // insere o novo valor
        update_post_meta($delete[$i], $name_b, $related_values);
        // insere a chave do acf
        update_post_meta($delete[$i], '_'.$name_b, $key_b);
    }


    for ($i=0; $i<count($add); $i++) {
        $related_values = get_post_meta($add[$i], $name_b, true);
        if (!is_array($related_values)) {
            if (empty($related_values)) {
                $related_values = array();
            } else {
                $related_values = array($related_values);
            }
        }
        if (!in_array($post_id, $related_values)) {
            // add new relationship if it does not exist
            $related_values[] = $post_id;
        }
        // atualiza os valores
        update_post_meta($add[$i], $name_b, $related_values);
        // insere a chave do acf
        update_post_meta($add[$i], '_'.$name_b, $key_b);
    }

    return $value;
}

// Desabilitar coluna Descricao para Comprimissos dentro da Agenda
add_filter('manage_edit-compromisso_columns', function ( $columns ) 
{
    if( isset( $columns['description'] ) )
        unset( $columns['description'] );   

    return $columns;
} );

// Desabilitar campo Descricao para Comprimissos dentro da Agenda

function hide_description_row() {
    echo "<style> .term-description-wrap { display:none; } </style>";
}

add_action( "compromisso_edit_form", 'hide_description_row');
add_action( "compromisso_add_form", 'hide_description_row');

// Inserir as opções no campo Compromisso no cadastro da Agenda
add_filter( 'acf/load_field/name=compromisso', function( $field ) {
  
	// Get all taxonomy terms
	$compromissos = get_terms( array(
	  'taxonomy' => 'compromisso',
	  'hide_empty' => false
	) );
	
	// Add each term to the choices array.
	// Example: $field['choices']['review'] = Review
	$field['choices']['outros'] = 'Outros';
	foreach ( $compromissos as $type ) {
	  $field['choices'][$type->term_id] = $type->name;
	}
  
	return $field;
} );

// Inserir as opções no campo Endereço no cadastro da Agenda
add_filter( 'acf/load_field/name=endereco_evento', function( $field ) {
  
	// Get all taxonomy terms
	$compromissos = get_terms( array(
	  'taxonomy' => 'endereco',
	  'hide_empty' => false
	) );
	
	// Add each term to the choices array.
	// Example: $field['choices']['review'] = Review
	$field['choices']['outros'] = 'Outros';
	foreach ( $compromissos as $type ) {
	  $field['choices'][$type->term_id] = $type->name;
	}
  
	return $field;
} );

/// Incluir JS de preenchimento e Ajax no Admin
function enqueue_scripts_back_end(){
	//wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/my_query.js', array('jquery'));
	
	wp_localize_script( 'ajax-script', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	
}
add_action('admin_enqueue_scripts','enqueue_scripts_back_end');

// Recupera os valores dentro de Compromisso
add_action( 'wp_ajax_my_action', 'my_action' );
function my_action() {
	

	global $wpdb;
	
	$compromisso = intval( $_POST['compromisso'] );
	
	$pauta_assunto = get_field('pauta_assunto', 'term_' . $compromisso); 
	$participantes_evento = get_field('participantes_evento', 'term_' . $compromisso);
	$endereco_do_evento = get_field('endereco_do_evento', 'term_' . $compromisso);
	
	echo json_encode(array(
		'pauta_assunto' => $pauta_assunto,
		'participantes_evento' => $participantes_evento,
		'endereco_do_evento' => $endereco_do_evento
	));
	
	wp_die();
	
}

// Ordenar Nova Agenda por data por padrão
add_filter( 'parse_query', 'sort_posts_by_meta_value' );
 
function sort_posts_by_meta_value($query) {
    global $pagenow;
    if (is_admin() && $pagenow == 'edit.php' &&
        isset($_GET['post_type']) && $_GET['post_type']=='agendanew' &&
        !isset($_GET['orderby']) )  {
        $query->query_vars['orderby'] = 'meta_value_num date';
        $query->query_vars['meta_key'] = 'data_do_evento';
    }

	return $query;
}

// Ordenar Nova Agenda por data ao clicar em ordenacao
add_filter( 'parse_query', 'sort_agenda_by_date' );
 
function sort_agenda_by_date($query) {
    global $pagenow;
    if (is_admin() && $pagenow == 'edit.php' &&
        isset($_GET['post_type']) && $_GET['post_type']=='agendanew' &&
        isset($_GET['orderby'])  && $_GET['orderby'] == 'data_evento')  {
        $query->query_vars['orderby'] = 'meta_value_num date';
        $query->query_vars['meta_key'] = 'data_do_evento';
    }

	return $query;
}

// Filtrar Nova Agenda por mes / ano
add_filter( 'parse_query', 'filter_agenda_by_date' );
 
function filter_agenda_by_date($query) {
    global $pagenow;
    if (is_admin() && $pagenow == 'edit.php' &&
        isset($_GET['post_type']) && $_GET['post_type']=='agendanew' &&
        isset($_GET['search_year']) )  {
			
			$mesBusca = $_GET['search_month'];
			$anoBusca = $_GET['search_year'];

			$start = $anoBusca . '-' . $mesBusca . '-01';
			$end = $anoBusca . '-' . $mesBusca . '-31';

			$query->query_vars['orderby'] = 'meta_value_num date';
			$query->query_vars['meta_query'] = array(
				'relation' => 'AND',
				array(
					'key' => 'data_do_evento',
					'value' => $start,
					'compare' => '>=',
					'type' => 'DATE'
				),

				array(
					'key' => 'data_do_evento',
					'value' => $end,
					'compare' => '<=',
					'type' => 'DATE'
				),
			);
    }

	return $query;
}

// Inclusao do filtro por mes / ano
add_action('restrict_manage_posts','filtering_month',10);
function filtering_month($post_type){
    
	if('agendanew' !== $post_type){
      return; //filter your post
    }
        
    //Lista de Meses.
    $meses = array(
		'01' => 'Janeiro',
		'02' => 'Fevereiro',
		'03' => 'Março',
		'04' => 'Abril',
		'05' => 'Maio',
		'06' => 'Junho',
		'07' => 'Julho',
		'08' => 'Agosto',
		'09' => 'Setembro',
		'10' => 'Outubro',
		'11' => 'Novembro',
		'12' => 'Dezembro',
	);

	// Mes Atual
	$month = date('m');

   //build a custom dropdown list of values to filter by
    echo '<select id="my-loc" name="search_month">';    
    foreach($meses as $key => $location){
      $select = ($month == $key) ? ' selected="selected"':'';
      echo '<option value="'.$key.'"'.$select.'>' . $location . ' </option>';
    }
    echo '</select>';


	// Ano Atual
	$year = date('Y');
	$previousyear = $year -1;
	$nextyear = $year +1;

	//build a custom dropdown list of values to filter by
    echo '<select id="my-loc" name="search_year">';        
    echo '<option value="'.$previousyear.'">' . $previousyear . ' </option>';
	echo '<option value="'.$year.'" selected="selected">' . $year . ' </option>';
	echo '<option value="'.$nextyear.'">' . $nextyear . ' </option>'; 
    echo '</select>';
}

add_filter('months_dropdown_results', '__return_empty_array');

// Adicionar busca em Atributos de Paginas > Ascendente 
function custom_scripts_wpse_215576() {
    //Chosen CSS file
    wp_enqueue_style('chose-style', get_template_directory_uri().'/css/chosen.css');
    //Chosen JS file
    wp_enqueue_script( 'chosen-script', get_template_directory_uri() . '/js/chosen.jquery.min.js', array(), '1.4.2', true );
}
add_action( 'admin_enqueue_scripts', 'custom_scripts_wpse_215576' );


// Incluir Meta Key nas buscas
add_action('pre_get_posts', 'my_search_query'); // add the special search fonction on each get_posts query (this includes WP_Query())
function my_search_query($query) {
    if ($query->is_search() and $query->query_vars and $query->query_vars['s'] and $query->query_vars['s_meta_keys']) { // if we are searching using the 's' argument and added a 's_meta_keys' argument
        global $wpdb;
        $search = $query->query_vars['s']; // get the search string
        $ids = array(); // initiate array of martching post ids per searched keyword
        foreach (explode(' ',$search) as $term) { // explode keywords and look for matching results for each
            $term = trim($term); // remove unnecessary spaces
            if (!empty($term)) { // check the the keyword is not empty
                $query_posts = $wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE post_status='publish' AND ((post_title LIKE '%%%s%%') OR (post_content LIKE '%%%s%%'))", $term, $term); // search in title and content like the normal function does
                $ids_posts = [];
                $results = $wpdb->get_results($query_posts);
                if ($wpdb->last_error)
                    die($wpdb->last_error);
                foreach ($results as $result)
                    $ids_posts[] = $result->ID; // gather matching post ids
                $query_meta = [];
                foreach($query->query_vars['s_meta_keys'] as $meta_key) // now construct a search query the search in each desired meta key
					//$where = str_replace("meta_key = 'fx_flex_layout_$", "meta_key LIKE 'fx_flex_layout_%", $where);
					//$where = str_replace("meta_key = 'fx_coluna_1_1_$", "meta_key LIKE 'fx_coluna_1_1_%", $where);
					//$meta_key = str_replace('fx_flex_layout_$_fx_coluna_1_1_$_fx_editor_1_1', 'fx_flex_layout_%_fx_coluna_1_1_%_fx_editor_1_1', $meta_key);
					$query_meta[] = $wpdb->prepare("meta_key='%s' AND meta_value LIKE '%%%s%%'", $meta_key, $term);
                $query_metas = $wpdb->prepare("SELECT * FROM {$wpdb->postmeta} WHERE ((".implode(') OR (',$query_meta)."))");
                $ids_metas = [];
                $results = $wpdb->get_results($query_metas);
                if ($wpdb->last_error)
                    die($wpdb->last_error);
                foreach ($results as $result)
                    $ids_metas[] = $result->post_id; // gather matching post ids
                $merged = array_merge($ids_posts,$ids_metas); // merge the title, content and meta ids resulting from both queries
                $unique = array_unique($merged); // remove duplicates
                if (!$unique)
                    $unique = array(0); // if no result, add a "0" id otherwise all posts wil lbe returned
                $ids[] = $unique; // add array of matching ids into the main array
            }
        }
        if (count($ids)>1)
            $intersected = call_user_func_array('array_intersect',$ids); // if several keywords keep only ids that are found in all keywords' matching arrays
        else
            $intersected = $ids[0]; // otherwise keep the single matching ids array
        $unique = array_unique($intersected); // remove duplicates
        if (!$unique)
            $unique = array(0); // if no result, add a "0" id otherwise all posts wil lbe returned
        unset($query->query_vars['s']); // unset normal search query
        $query->set('post__in',$unique); // add a filter by post id instead
    }
}

// Alterar placeholder cadastro/edicao Agenda do Secretario
function wpb_change_title_text( $title ){
	$screen = get_current_screen(); 
	if  ( 'agendanew' == $screen->post_type ) {
		 $title = 'Digite a data dos compromissos';
	} 
	return $title;}

add_filter( 'enter_title_here', 'wpb_change_title_text' );

// Incluir div envolta do embed de video automatico do WordPress
add_filter( 'embed_oembed_html', 'tdd_oembed_filter', 10, 4 ) ; 
function tdd_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<div class="video-container">'.$html.'</div>';
    return $return;
}

// Paginas em rascunho e pendendentes no seletor de subpaginas
add_filter( 'page_attributes_dropdown_pages_args', 'so_3538267_enable_drafts_parents' );
add_filter( 'quick_edit_dropdown_pages_args', 'so_3538267_enable_drafts_parents' );

function so_3538267_enable_drafts_parents( $args )
{
    $args['post_status'] = 'draft,publish,pending,private';
    return $args;
}

// Inclui o JS para alterar o tipo de campo no alt das imagens
function custom_subpage_js() {
	//$url = get_bloginfo('template_directory') . '/js/subpages.js';	
    //echo '"<script type="text/javascript" src="'. $url . '"></script>"';

    echo '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';    
	$pagina = $_GET['post'];
	$pages = get_pages('child_of='.$pagina.'&sort_column=title&post_status=draft,publish,pending,private');
	$paginas = '';
	foreach($pages as $page){
		$paginas .= '<input type="checkbox" class="checkboxAll" name="type" value="' . $page->ID . '" /> ' . $page->post_title . '<br>';
	}
	?>
		<script>
			jQuery(document).ready(function($) {				

				function ajaxSubmit(pages) {

					var data = {
						action: 'subpages_private',
						page: pages
					};

					jQuery.ajax({
						type: "POST",
						url: "/wp-admin/admin-ajax.php",
						data: data,
						success: function(data){
							Swal.fire('Páginas alteradas com sucesso!', '', 'success');
						},
						error: function (request, status, error) {
							//alert(request.responseText);
						}
					});

					return false;
				}



				jQuery("#visibility-radio-private").click(function(){

					Swal.fire({
						title: 'Atenção',
						icon: 'question',
						html: '<h3>Esta página possui subpaginas, deseja transformá-las em Privadas?</h3>' +
							  '<div class="pages-modal">' +							  
							  '<?= $paginas; ?>' +
							  '</div>',
						showDenyButton: true,
						showCloseButton: true,
						confirmButtonText: 'Salvar',
						denyButtonText: 'Não alterar',
					}).then((result) => {
						/* Read more about isConfirmed, isDenied below */
						if (result.isConfirmed) {
							var yourArray = []

							jQuery("input:checkbox[name=type]:checked").each(function(){
								yourArray.push($(this).val());
							});

							ajaxSubmit(yourArray);							

						} else if (result.isDenied) {
							Swal.fire('Ação cancelada', '', 'error')
						}
					})
					//ajaxSubmit(); 
				});
			});
		</script>
	<?php
}

// Alerta subpagina
add_action( 'admin_init', 'alert_subpage' );

function alert_subpage() {
    global $pagenow;
    if ( 'post.php' === $pagenow && isset($_GET['post']) && 'page' === get_post_type( $_GET['post'] ) ){
		$pagina = $_GET['post'];

		$pages = get_pages('child_of='.$pagina.'&sort_column=menu_order&post_status=draft,publish,pending,private');

		//echo "<pre>";
		//print_r($pages);
		//echo "</pre>";

		if($pages){
			add_action('admin_footer', 'custom_subpage_js');
		}

    }
}

function subpages_private(){
	$paginas = $_POST['page'];

	foreach($paginas as $pagina){
		$post_data = array(
			'ID' => $pagina,
			'post_status' => 'private'
		);	
		wp_update_post( $post_data );
	}

	print_r($data);

	wp_die();
}
add_action('wp_ajax_subpages_private', 'subpages_private');
add_action('wp_ajax_nopriv_subpages_private', 'subpages_private');

// Incluir Pagina Exportar Usuarios no menu Usuarios
add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page');

function wpdocs_register_my_custom_submenu_page() {
    add_submenu_page(
        'users.php',
        'Exportar Usuarios',
        'Exportar Usuarios',
        'manage_options',
        'export-users',
        'wpdocs_my_custom_submenu_page_callback' );
}

function wpdocs_my_custom_submenu_page_callback() {
    echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
        echo '<h2>Exportar Usuarios</h2><br>';
		$blogusers = get_users( array( 'fields' => array( 'id', 'user_login', 'user_email' ) ) );
		$usuarios = array();

		foreach($blogusers as $user){
			$user_meta = get_userdata($user->id);
			$user_roles = $user_meta->roles;
			$setor = get_field('setor', 'user_'. $user->id );
			$grupos = get_field('grupo', 'user_'. $user->id );
			$grupoTitle = '';
			$i = 0;
			if($grupos && $grupos != '' && $grupos[0] != ''){
				foreach($grupos as $grupo){
					if($i == 0){
						$grupoTitle .= get_the_title($grupo);
					} else {
						$grupoTitle .= ', ' . get_the_title($grupo);
					}
					$i++;
				}				
			}

			$usuarios[] = array(
				'id' => $user->id,
				'login' => $user->user_login,
				'email' => $user->user_email,
				'funcao' => $user_roles[0],
				'grupos' => $grupoTitle,
				'setor' => $setor
			);

		}

		//echo "<pre>";
		//print_r($usuarios);
		//echo "</pre>";
	?>

		<form action="<?= get_template_directory_uri(); ?>/export-users.php">
			<select name="funcao" id="">
				<option value="all">Todos</option>
				<option value="administrator">Administrador</option>
				<option value="editor">Editor</option>
				<option value="contributor">Colaborador</option>
			</select>
			<input type="submit" value="Exportar" class="button action">
		</form>

	<?php
    echo '</div>';
}

// Incluir Pagina Importar Usuarios no menu Usuarios
add_action('admin_menu', 'cadastro_usuarios_core_sso');

function cadastro_usuarios_core_sso() {
    add_submenu_page(
        'users.php',
        'Importar Usuarios',
        'Importar Usuarios',
        'manage_options',
        'import-users',
        'incluir_cadastro_usuarios_core_sso' );
}

function incluir_cadastro_usuarios_core_sso(){
	include('includes/usuarios/cadastro_usuarios.php');
}

// Incluir Pagina Atualizar Usuarios no menu Usuarios
add_action('admin_menu', 'atualizar_usuarios_core_sso');

function atualizar_usuarios_core_sso() {
    add_submenu_page(
        'users.php',
        'Atualizar Usuarios',
        'Atualizar Usuarios',
        'manage_options',
        'update-users',
        'incluir_atualizar_usuarios_core_sso' );
}

function incluir_atualizar_usuarios_core_sso(){
	include('includes/usuarios/atualizar_usuarios.php');
}

add_action('pre_get_posts', 'my_make_search_exact', 10);
function my_make_search_exact($query){

    if(!is_admin() && $query->is_main_query() && $query->is_search) :
        $query->set('exact', true);
    endif;

}

// define the media_send_to_editor callback 
function filter_media_send_to_editor( $html, $send_id, $attachment ) { 
    if (get_post_mime_type( $send_id ) == "application/pdf") {
		//$meta = get_post_meta( $send_id, '_wp_attachment_metadata', true );
		//$meta = wp_get_attachment_image_src( $send_id, 'medium' );
		//$html .= print_r($meta, true);

		$arquivo = wp_get_attachment_image_src( $send_id, 'full' );
		$arquivoMedium = wp_get_attachment_image_src( $send_id, 'medium' );
		
		if($attachment['url']){			
			$html = '<a href="' . $attachment['url'] . '"><img class="size-medium img-fluid" width="' . $arquivoMedium[1] . '" height="' . $arquivoMedium[2] . '" src="' . $arquivo[0] . '"></a>';
		} else {
			$html = '<img class="size-medium img-fluid" width="' . $arquivoMedium[1] . '" height="' . $arquivoMedium[2] . '" src="' . $arquivo[0] . '">';
		}
	}
	
    return $html; 
};

add_filter( 'media_send_to_editor', 'filter_media_send_to_editor', 11, 3 );

// Inclui link esqueceu a senha
add_filter('login_form_middle','lost_pass');
function lost_pass(){
    
	//Output your HTML
	$link = get_field('link', $post_id);
	$additional_field = '';
	if($link){
		$additional_field .= '<div class="lost-pass">
	   	<p class="pass-text m-0">Na senha, digite a mesma senha do Sistema de Gestão Pedagógica (SGP) e Plateia. Caso esqueça sua senha e necessite redefinir, a mesma será aplicada
		para os outros acessos (Portais e Sistemas) da SME.</p>
	   	<p><a href="' . $link . '">Esqueceu sua senha?</a></p>
	   
	</div>';
   }
	
	$additional_field .= '<div class="login-custom-field-wrapper">
        <input type="hidden" value="1" name="login_page"></label>
    </div>';

    return $additional_field;
}

// Retorna dia da semana
function getDay($dia_num){
    $diasMapa = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
    return $diasMapa[$dia_num];
}

// Retorna primeira letra das palavras
function firstLetter($words){
	$palavras = explode(" ", $words);
	$acronym = "";

	foreach ($palavras as $w) {
		$acronym .= $w[0];
	}
	return $acronym;
}

// Converto o mês para portugues
function converter_mes($mes){
	switch ($mes) {
		case '01':
			return "Jan";
			break;
		case '02':
			return "Fev";
			break;
		case '03':
			return "Mar";
			break;
		case '04':
			return "Abr";
			break;
		case '05':
			return "Mai";
			break;
		case '06':
			return "Jun";
			break;
		case '07':
			return "Jul";
			break;
		case '08':
			return "Ago";
			break;
		case '09':
			return "Set";
			break;
		case '10':
			return "Out";
			break;
		case '11':
			return "Nov";
			break;
		case '12':
			return "Dez";
			break;
	}
}

// Pega o nome da categoria no Acervo Digital
function get_tax_name($tax, $id){

	$url = 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-json/wp/v2/' . $tax . '/' . $id ;

	$cURLConnection = curl_init();
	curl_setopt($cURLConnection, CURLOPT_URL, $url);
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	$taxList = curl_exec($cURLConnection);
	curl_close($cURLConnection);

	$taxResponse = json_decode($taxList);
	return $taxResponse->name;
}

// Pega o a url do arquivo no Acervo Digital
function get_file_url($id){
	$url = 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-json/wp/v2/media/' . $id ;

	$cURLConnection = curl_init();
	curl_setopt($cURLConnection, CURLOPT_URL, $url);
	curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

	$mediaList = curl_exec($cURLConnection);
	curl_close($cURLConnection);

	$mediaResponse = json_decode($mediaList);
	return $mediaResponse->source_url;
}

// Incluir a opacao de Limpar o contador dos usuarios
add_filter('bulk_actions-users', function($bulk_actions) {
	$bulk_actions['limpar-contator'] = __('Limpar Contator', 'txtdomain');
	return $bulk_actions;
});

// Acao para limpar o contador e a resposta de feedback
add_filter('handle_bulk_actions-users', function($redirect_url, $action, $users) {
	if ($action == 'limpar-contator') {
		//print_r($users);
		foreach ($users as $user_id) {
			update_user_meta($user_id, 'wp_login_count', '');
			update_user_meta($user_id, 'feed_resp', '');
		}
		$redirect_url = add_query_arg('activate-user', count($users), $redirect_url);
	}
	return $redirect_url;
}, 10, 3);

function destroy_sessions() {
	$sessions->destroy_all();//destroys all sessions
	wp_clear_auth_cookie();//clears cookies regarding WP Auth
}
add_action('wp_logout', 'destroy_sessions');

// Validar Senha
add_action('wp_ajax_valida_user','valida_user');
add_action('wp_ajax_nopriv_valida_user','valida_user');
function valida_user(){
	$curl = curl_init();

	curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://hom-smeintegracaoapi.sme.prefeitura.sp.gov.br/api/v1/autenticacao',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
				"login": "' . $_POST['user'] . '",
				"senha": "' . $_POST['atual'] . '"
			}',
			CURLOPT_HTTPHEADER => array(
					'x-api-eol-key: fe8c65abfac596a39c40b8d88302cb7341c8ec99',
					'Content-Type: application/json-patch+json'
			),
	));

	$response = curl_exec($curl);
	$info = curl_getinfo($curl);

	curl_close($curl);
	//print_r($info);
	echo $info['http_code'];
	die();
}

// Alterar Senha
add_action('wp_ajax_altera_senha','altera_senha');
add_action('wp_ajax_nopriv_altera_senha','altera_senha');
function altera_senha(){
	$curl = curl_init();

	$retorno = array();
	$campos = array('Usuario' => $_POST['user'],'Senha' => $_POST['nova1']);

	// Given password
	$password = $_POST['nova1'];

	// Validate password strength
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8 || strlen($password) > 12) {
		$retorno['code'] = 401;
		$retorno['body'] = 'A senha deve ter entre 8 e 12 caracteres e deve incluir pelo menos uma letra maiúscula, um número e um caractere especial.';
	}else{
		curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://hom-smeintegracaoapi.sme.prefeitura.sp.gov.br/api/AutenticacaoSgp/AlterarSenha',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $campos,
				CURLOPT_HTTPHEADER => array(
						'x-api-eol-key: fe8c65abfac596a39c40b8d88302cb7341c8ec99',
						'Content-Type: multipart/form-data'
				),
		));
		
		$response = curl_exec($curl);
		$info = curl_getinfo($curl);

		curl_close($curl);
		//print_r($info);
		//echo $info['http_code'];
		
		$retorno['code'] = $info['http_code'];
		$retorno['body'] = $response;
	}

	
	echo json_encode($retorno);
	die();
}

// Alterar cor padrao do admin
add_filter( 'get_user_option_admin_color', 'update_user_option_admin_color', 5 );

function update_user_option_admin_color( $color_scheme ) {
    $color_scheme = 'sunrise';

    return $color_scheme;
}

if ( (! empty($GLOBALS['pagenow']) && 'post.php' === $GLOBALS['pagenow']) ||  (! empty($GLOBALS['pagenow']) && 'edit.php' === $GLOBALS['pagenow']))
    add_action('admin_footer', 'trash_click_message');
function trash_click_message() {
    echo <<<JQUERY
<script>
	jQuery( function($) {       
		$('.edit-php a.submitdelete, .post-php a.submitdelete').click( function( event ) {
			if( ! confirm( 'Você realmente deseja mover para a lixeira?' ) ) {
				event.preventDefault();
			}           
		});
	});
</script>
JQUERY;
}

function wpse95147_filter_wp_title( $title ) {
    if ( is_single() || ( is_home() && !is_front_page() ) || ( is_page() && !is_front_page() ) ) {
        $title = single_post_title( '', false );
    }
    return $title;
}
add_filter( 'wp_title', 'wpse95147_filter_wp_title' );

// Criar tabela para armazenar os likes
function post_like_table_create() {

	global $wpdb;
	$table_name = $wpdb->prefix. "post_like_table";
	global $charset_collate;
	$charset_collate = $wpdb->get_charset_collate();
	global $db_version;
	
	if( $wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") != $table_name)
	{ $create_sql = "CREATE TABLE " . $table_name . " (
	id INT(11) NOT NULL auto_increment,
	postid INT(11) NOT NULL ,
	
	clientip VARCHAR(40) NOT NULL ,
	
	PRIMARY KEY (id))$charset_collate;";
	require_once(ABSPATH . "wp-admin/includes/upgrade.php");
	dbDelta( $create_sql );
	}
	
	
	//register the new table with the wpdb object
	if (!isset($wpdb->post_like_table))
	{
	$wpdb->post_like_table = $table_name;
	//add the shortcut so you can use $wpdb->stats
	$wpdb->tables[] = str_replace($wpdb->prefix, '', $table_name);
	}
	
}
add_action( 'init', 'post_like_table_create');
	
// Add o JS
function theme_name_scripts() {
	wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/post-like.js', array('jquery'), '1.0.0', true );
	wp_localize_script( 'script-name', 'MyAjax', array(
	// URL to wp-admin/admin-ajax.php to process the request
	'ajaxurl' => admin_url( 'admin-ajax.php' ),
	// generate a nonce with a unique ID "myajax-post-comment-nonce"
	// so that you can check it later when an AJAX request is sent
	'security' => wp_create_nonce( 'my-special-string' )
	));
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
// The function that handles the AJAX request
	
function get_client_ip() {
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
	
function post_like_callback() {
	check_ajax_referer( 'my-special-string', 'security' );
	$postid = intval( $_POST['postid'] );
	$clientip = get_client_ip();
	$like = 0;
	$dislike = 0;
	$like_count = 0;

	//check if post id and ip present
	global $wpdb;
	$row = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid' AND clientip = '$clientip'");

	if(empty($row)){
		//insert row
		$wpdb->insert( $wpdb->post_like_table, array( 'postid' => $postid, 'clientip' => $clientip ), array( '%d', '%s' ) );
		//echo $wpdb->insert_id;
		$like=1;
	}

	if(!empty($row)){
		//delete row
		$wpdb->delete( $wpdb->post_like_table, array( 'postid' => $postid, 'clientip'=> $clientip ), array( '%d','%s' ) );
		$dislike = 1;
	}

	//calculate like count from db.
	$totalrow = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid'");
	$total_like = $wpdb->num_rows;
	$data = array( 'postid' => $postid,'likecount' => $total_like, 'clientip' => $clientip, 'like' => $like, 'dislike' => $dislike);
	echo json_encode($data);
	//echo $clientip;
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_post_like', 'post_like_callback' );
add_action( 'wp_ajax_nopriv_post_like', 'post_like_callback' );

add_filter( 'ajax_query_attachments_args', 'filterMediaLibrary', 10, 1 );
//add_action( 'pre_get_posts', 'filterMediaLibrary' );
function filterMediaLibrary($query = array()) {
    $query['post_parent__not_in'] = array(1454);
    return $query;
}