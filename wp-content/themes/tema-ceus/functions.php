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

	register_nav_menu('navbar', __('Navbar', 'your-theme'));


	if (function_exists('add_image_size')) {
		add_theme_support('post-thumbnails');
	}

	if (function_exists('add_image_size')) {
		add_image_size('home-thumb', 250, 166);
	}

	//Permite adicionar no post ou página uma imagem com tamanho personalizado, nesse caso a home-thumb já definida anteriormente com 250X147
	function custom_choose_sizes($sizes) {
		$custom_sizes = array(
			'home-thumb' => 'Tamanho Personalizado'
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

	//wp_register_script('bootstrap_js', STM_THEME_URL . 'js/bootstrap.js', false, false);

	wp_register_script('bootstrap_4_popper_js',  'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js', false, '1.14.6', true);
	wp_register_script('bootstrap_4_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js', false, '4.2.1', true);


	wp_register_script('modal_on_load_js', STM_THEME_URL . 'js/modal_on_load.js', false, true);
	wp_register_script('wow_js', STM_THEME_URL . 'js/wow.min.js', array('jquery'), 1.0, true);
	wp_register_script('jquery_waituntilexists', STM_THEME_URL . 'js/jquery.waituntilexists.js', array('jquery'), 1.0, true);
	wp_register_script('scripts_js', STM_THEME_URL . 'js/scripts.js', array('jquery'), 1.0, true);
	wp_register_script('jquery.event.move_js', STM_THEME_URL . 'js/jquery.event.move.js', array('jquery'), 1.0, true);


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

/*function paginacao2($query) {

	echo '<nav id="pagination">';
	global $wp_query;

	$pagina_atual = (int) $wp_query->get('paged');

	if (!$pagina_atual)
		$pagina_atual = 1;

	$total_paginas = (int) $query->max_num_pages;

	echo paginate_links(
		array(
			//'base' => str_replace($total_paginas + 1, '%#%', get_pagenum_link($total_paginas + 1)),
			'base' => @add_query_arg('page','%#%'),
			'current' => $pagina_atual,
			'total' => $total_paginas,
			'end_size'  => 1,
			'mid_size'  => 2,
			'show_all' => false,
			'prev_next' => true,
			'prev_text' => __('<<'),
			'next_text' => __('>>'),
		)
	);
	echo '</nav>';
}*/

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

/*
function incluir_titulo_nos_thumbnails($post_id, $xml_node, $is_update ) {
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$post =  get_post($post_id);

	$my_post = array(
		'ID' => $post_thumbnail_id,
		'post_title' => $post->post_title,
	);
	// Update do post dentro do Banco de Dados
	wp_update_post($my_post);


}
add_action( 'pmxi_saved_post', 'incluir_titulo_nos_thumbnails', 10, 3 );*/

/*if ( current_user_can('contributor') && !current_user_can('upload_files') )
	add_action('admin_init', 'allow_contributor_uploads');
function allow_contributor_uploads() {
	$contributor = get_role('contributor');
	$contributor->add_cap('upload_files');
}*/

add_image_size( 'admin-list-thumb', 80, 80, false );

// Adicionando a classe css img-fluid em todas as imagens dentro do the_content
/*function img_responsive($content){
	return str_replace('<img ','<img class="img-fluid" ', $content);
}
add_filter('the_content','img_responsive');*/

/*function add_image_responsive_class($content) {
	global $post;
	$pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
	$replacement = '<img$1class="$2 img-fluid"$3>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
add_filter('the_content', 'add_image_responsive_class');*/

/*function add_image_class_post_content ($class){
	$class .= ' img-fluid';
	return $class;
}
add_filter('get_image_tag_class','add_image_class_post_content');*/

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

/*//Add Open Graph Meta Info from the actual article data, or customize as necessary
function facebook_open_graph() {
	global $post;
	if ( !is_singular()) //if it is not a post or a page
		return;
	if($excerpt = $post->post_excerpt)
	{
		$excerpt = strip_tags($post->post_excerpt);
		$excerpt = str_replace("", "'", $excerpt);
	}
	else
	{
		$excerpt = get_bloginfo('description');
	}

	//You'll need to find you Facebook profile Id and add it as the admin
	//echo '<meta property="fb:admins" content="XXXXXXXXX-fb-admin-id"/>';
	echo '<meta property="og:title" content="' . get_the_title() . '"/>';
	echo '<meta property="og:description" content="' . $excerpt . '"/>';
	echo '<meta property="og:type" content="article"/>';
	echo '<meta property="og:url" content="' . get_permalink() . '"/>';
	//Let's also add some Twitter related meta data
	//echo '<meta name="twitter:card" content="summary" />';
	//This is the site Twitter @username to be used at the footer of the card
	//echo '<meta name="twitter:site" content="@site_user_name" />';
	//This the Twitter @username which is the creator / author of the article
	//echo '<meta name="twitter:creator" content="@username_author" />';

	// Customize the below with the name of your site
	echo '<meta property="og:site_name" content="'.STM_SITE_NAME.'. '.STM_SITE_DESCRIPTION.'"/>';
	if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
		//Create a default image on your server or an image in your media library, and insert it's URL here
		$default_image=STM_URL."/wp-content/uploads/2019/07/EDUCAÇÃO-1.png";
		echo '<meta property="og:image" content="' . $default_image . '"/>';
	}
	else{
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
	}

	echo "
	";
}
add_action( 'wp_head', 'facebook_open_graph', 5 );*/

/**
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes tot support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 */
/*function wcag_nav_menu_link_attributes( $atts, $item, $args ) {

	// Add [aria-haspopup] and [aria-expanded] to menu items that have children
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = "true";
		$atts['aria-expanded'] = "false";
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'wcag_nav_menu_link_attributes', 10, 4 );
*/


define('STM_URL', get_home_url());
define('STM_THEME_URL', get_bloginfo('template_url') . '/');
define('STM_SITE_NAME', get_bloginfo('name'));
define('STM_SITE_DESCRIPTION', get_bloginfo('description'));
define('__ROOT__', dirname(dirname(__FILE__)).'/sme-portal-institucional');

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
        'capability'	=> 'publish_pages',
        //'redirect'		=> false
    ));
	
	acf_add_options_sub_page(array(
        'page_title' 	=> 'Configurações da Busca Manual',
        'menu_title'	=> 'Busca Manual',
        'parent_slug'	=> 'conf-geral',
        'capability'	=> 'publish_pages',
    ));
	
	acf_add_options_sub_page(array(
        'page_title' 	=> 'Configurações de tutoriais',
        'menu_title'	=> 'Inclusão de tutoriais',
        'parent_slug'	=> 'conf-geral',
        'capability'	=> 'publish_pages',
    ));

	acf_add_options_sub_page(array(
        'page_title' 	=> 'Analytics',
        'menu_title'	=> 'Analytics',
        'parent_slug'	=> 'conf-geral',
        'capability'	=> 'publish_pages',
		'post_id' 		=> 'conf-analytics',
    ));

	if( is_super_admin() ){
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Informações Rodapé',
			'menu_title'	=> 'Rodapé',
			'parent_slug'	=> 'conf-geral',
			'capability'	=> 'publish_pages',
			'post_id' => 'conf-rodape',
		));
	}
    
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





/*function remove_editor() {
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $template = get_post_meta($id, '_wp_page_template', true);
        switch ($template) {
            case 'pagina-modelo-1.php':
            remove_post_type_support('page', 'editor');
            break;
            default :
            // Don't remove any other template.
            break;
        }
    }
	if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $template = get_post_meta($id, '_wp_page_template', true);
        switch ($template) {
            case 'pagina-modelo-2.php':
            remove_post_type_support('page', 'editor');
            break;
            default :
            // Don't remove any other template.
            break;
        }
    }
}
add_action('init', 'remove_editor');*/

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

// Altera o nome do menu de Post para Eventos

function change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Eventos';
    $submenu['edit.php'][5][0] = 'Eventos';
	$submenu['edit.php'][10][0] = 'Adicionar Evento';
	$submenu['edit.php'][15][0] = 'Unidades';
	$submenu['edit.php'][16][0] = 'Tags';	
    echo '';
}
function change_post_object() {
    global $wp_post_types;
    $labels = $wp_post_types['post']->labels;
    $labels->name = 'Eventos';
    $labels->singular_name = 'Evento';
    $labels->add_new = 'Adicionar Evento';
    $labels->add_new_item = 'Adicionar Evento';
    $labels->edit_item = 'Editar Evento';
    $labels->new_item = 'Evento';
    $labels->view_item = 'Ver Evento';
    $labels->search_items = 'Buscar Eventos';
    $labels->not_found = 'Nenhum Evento encontrado';
    $labels->not_found_in_trash = 'Nenhum Evento encontrado no Lixo';
    $labels->all_items = 'Todos Eventos';
    $labels->menu_name = 'Eventos';
	$labels->name_admin_bar = 'Eventos';
}
 
add_action( 'admin_menu', 'change_post_label' );
add_action( 'init', 'change_post_object' );


// Altera nomes de Categorias para Unidades
function revcon_change_cat_object() {
    global $wp_taxonomies;
    $labels = &$wp_taxonomies['category']->labels;
    $labels->name = 'Unidades';
    $labels->singular_name = 'Unidade';
    $labels->add_new = 'Add Unidade';
    $labels->add_new_item = 'Adicionar Unidade';
    $labels->edit_item = 'Editar Unidade';
    $labels->new_item = 'Unidade';
    $labels->view_item = 'Ver Unidade';
    $labels->search_items = 'Buscar Unidades';
    $labels->not_found = 'Nenhuma Unidade encontrada';
    $labels->not_found_in_trash = 'Nenhuma Unidade encontrada na lixeira';
    $labels->all_items = 'Todas as Unidades';
    $labels->menu_name = 'Unidades';
    $labels->name_admin_bar = 'Unidades';
}
add_action( 'init', 'revcon_change_cat_object' );

// Altera o icone dos Posts (Unidades)
function replace_admin_menu_icons_css() {
    ?>
    <style>
        .dashicons-admin-post:before{
			content: '\f508';
		}
    </style>
    <?php
}

add_action( 'admin_head', 'replace_admin_menu_icons_css' );

// Incluir taxonomia Categoria
function atividades_taxonomy() {
    register_taxonomy(
        'atividades_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'post',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Atividades', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'atividades',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'atividades_taxonomy');

// Incluir taxonomia Publico
function publico_taxonomy() {
    register_taxonomy(
        'publico_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'post',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Publico', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'publico',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'publico_taxonomy');

// Incluir taxonomia Faixa Etaria
function faixa_taxonomy() {
    register_taxonomy(
        'faixa_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'post',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Faixa Etaria', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'faixa',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'faixa_taxonomy');

// Incluir taxonomia Faixa Etaria
function periodo_taxonomy() {
    register_taxonomy(
        'localidade',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'post',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Localidade', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'localidade',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'periodo_taxonomy');


function template_chooser($template){    
	global $wp_query;  
	global $no_search_results;
	$post_type = get_query_var('tipo');
	if( $wp_query->is_search && $post_type == 'programacao' )   
	{
	  return locate_template('search_programacao.php');  //  redirect to archive-search.php
	}
	return $template;   
}
add_filter('template_include', 'template_chooser');

// Thumbnail Customizadas
add_image_size( 'recorte-eventos', 640, 350, true ); // Slide
add_image_size( 'categoria-eventos', 350, 350, true ); // Categorias

// Inserir tamanho minimo para upload de imagens
add_filter('wp_handle_upload_prefilter','tc_handle_upload_prefilter');
function tc_handle_upload_prefilter($file) {
    // Debugging...
    //return array("error"=> print_r( $_POST, true ) );
    //return array("error"=> print_r( $file, true ) );
    //return array("error"=> print_r( $GLOBALS, true ) );
    
    $img = getimagesize( $file['tmp_name'] );
    $minimum = array( 'width' => '640', 'height' => '350' );
    $width = $img[0];
    $height = $img[1];

    if ( $width < $minimum['width'] || $height < $minimum['height'])
        return array( "error"=>"As dimensões da imagem são muito pequenas. A tamanho mínimo é {$minimum['width']}px de largura e {$minimum['height']}px de altura. Sua imagem tem o tamanho de {$width}x{$height}px.");
    else
        return $file; 
}

add_action( 'init',  function() {
    add_rewrite_rule( 'page/([a-z0-9-]+)[/]?$', 'index.php?page=$matches[1]', 'top' );
} );


$user_edit_limit = new NS_User_Edit_Limit(
    66,       // User ID we want to limit
    [20434]   // Array of parent page IDs user is allowed to edit
                
);

class NS_User_Edit_Limit {

    /**
     * Store the ID of the user we want to control, and the
     * posts we will let the user edit.
     */
    private $user_id = 0;
    private $allowed = array();

    public function __construct( $user_id, $allowed ) {

        // Save the ID of the user we want to limit.
        $this->user_id = $user_id;

        // Expand the list of allowed pages to include sub pages
        $all_pages = new WP_Query( array(
            'post_type' => 'page',
            'posts_per_page' => -1,
        ) );            
        foreach ( $allowed as $page ) {
            $this->allowed[] = $page;
            $sub_pages = get_page_children( $page, $all_pages );
            foreach ( $sub_pages as $sub_page ) {
                $this->allowed[] = $sub_page->ID;
            }
        }

        // For the prohibited user...
        // Remove the edit link from the front-end as needed
        add_filter( 'get_edit_post_link', array( $this, 'remove_edit_link' ), 10, 3 );
        add_action( 'admin_bar_menu', array( $this, 'remove_wp_admin_edit_link' ), 10, 1 );
        // Remove the edit link from wp-admin as needed
        add_action( 'page_row_actions', array( $this, 'remove_page_list_edit_link' ), 10, 2 );
    }

    /**
     * Helper functions that check if the current user is the one
     * we want to limit, and check if a specific post is in our
     * list of posts that we allow the user to edit.
     */
    private function is_user_limited() {
        $current_user = wp_get_current_user();
        return ( $current_user->ID == $this->user_id );
    }
    private function is_page_allowed( $post_id ) {
        return in_array( $post_id, $this->allowed );
    }

    /**
     * Removes the edit link from the front-end as needed.
     */
    public function remove_edit_link( $link, $post_id, $test ) {
        /**
         * If...
         * - The limited user is logged in
         * - The page the edit link is being created for is not in the allowed list
         * ...return an empty $link. This also causes edit_post_link() to show nothing.
         *
         * Otherwise, return link as normal.
         */
        if ( $this->is_user_limited() && !$this->is_page_allowed( $post_id ) ) {
            return '';
        }
        return $link;
    }

    /**
     * Removes the edit link from WP Admin Bar
     */
    public function remove_wp_admin_edit_link( $wp_admin_bar ) {
        /**
         *  If:
         *  - We're on a single page
         *  - The limited user is logged in
         *  - The page is not in the allowed list
         *  ...Remove the edit link from the WP Admin Bar
         */
        if ( 
            is_page() &&
            $this->is_user_limited() &&
            !$this->is_page_allowed( get_post()->ID )
        ) {
            $wp_admin_bar->remove_node( 'edit' );
        }
    }

    /**
     * Removes the edit link from WP Admin's edit.php
     */
    public function remove_page_list_edit_link( $actions, $post ) {
        /**
         * If:
         * -The limited user is logged in
         * -The page is not in the allowed list
         * ...Remove the "Edit", "Quick Edit", and "Trash" quick links.
         */
        if ( 
            $this->is_user_limited() &&
            !$this->is_page_allowed( $post->ID )
        ) {
            unset( $actions['edit'] );
            unset( $actions['inline hide-if-no-js']);
            unset( $actions['trash'] );
        }
        return $actions;
    }
}


function my_remove_meta_boxes() {
    remove_meta_box( 'atividades_categoriesdiv', 'post', 'side' );
    remove_meta_box( 'publico_categoriesdiv', 'post', 'side' );
	remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );
	remove_meta_box( 'faixa_categoriesdiv', 'post', 'side' );
	remove_meta_box( 'postimagediv', 'post', 'side' );
	//remove_meta_box( 'categorydiv', 'post', 'side' );
	remove_meta_box( 'localidadediv', 'post', 'side' );
}
add_action( 'admin_menu' , 'my_remove_meta_boxes' );

// Remove o campo "Additional Capabilities" do editor de usuario
add_filter( 'ure_show_additional_capabilities_section', '__return_false' );

// Filtra as unidades que grupo pertence
function wp37_limit_posts_to_author($query) {

	// pega as informacoes do usuario logado
	$user = wp_get_current_user();

	// 	filtra as unidades pelo grupo pertencente
	if( $_GET['filter'] == 'grupo' && ($user->roles[0] == 'contributor' || $user->roles[0] == 'editor'))  {
		$variable = get_user_meta($user->ID,'grupo',true);		
		$pages = array();
		if($variable && $variable !=''){
			foreach($variable as $grupo){
				$pages[] = get_post_meta($grupo, 'unidades', true);
			}		
			$pages = array_flatten($pages);
			$pages = array_unique($pages);
			$query->set('post__in', $pages);
		} else {
			$query->set('post_type', 'empty');
		}
		
	} 
	
	// 	filtra os eventos pelo grupo pertencente
	if( $_GET['filter'] == 'grupo' && $_GET['list'] == 'evento' && ($user->roles[0] == 'contributor' || $user->roles[0] == 'editor') ){

		global $wpdb;
		
		// pega as unidades permitidas para edicao do grupo
        $variable2 = get_user_meta($user->ID,'grupo',true);

		if($variable2 && $variable2 !=''){
			if($variable2 && $variable2 != ''){
				foreach($variable2 as $variable){
					$unidades2[] = get_post_meta($variable, 'unidades', true);
				}
			}
	
			$unidades2 = array_flatten($unidades2);
			$unidades2 = array_unique($unidades2);
			
			//print_r($unidades2);
	
			$showEventos = array();
	
			foreach ($unidades2 as $unidade){
				$showEventos[] = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'localizacao' AND meta_value = $unidade ORDER BY post_id" );
			}
			
			$arraySingle = call_user_func_array('array_merge', $showEventos);			
						
			$result = array_unique($arraySingle);
			if($result){
				$query->set('post__in', $result);
			} else {
				$query->set('post_type', 'empty');
			}
			
		} else {
			$query->set('post_type', 'empty');
		}		
		
	}
	
	return $query;
	
}
add_filter('pre_get_posts', 'wp37_limit_posts_to_author');

// Adiciona o filtro Minhas unidades
function wp37_add_movies_filter($views){
	
	// pega as informacoes do usuario logado
	$user = wp_get_current_user();
	
	if($user->roles[0] == 'contributor' || $user->roles[0] == 'editor'){

		if( $_GET['filter'] == 'grupo' ){

			$views['grupos'] = "<a href='" . admin_url('edit.php?&post_type=unidade&filter=grupo') . "' class='current'>Minhas Unidades</a>";
		return $views;

		} else {
			$views['grupos'] = "<a href='" . admin_url('edit.php?&post_type=unidade&filter=grupo') . "'>Minhas Unidades</a>";
		return $views;
		}

	}

	return $views;
}
 
add_filter('views_edit-unidade', 'wp37_add_movies_filter');

// Adiciona o filtro Meus Eventos
function wp38_add_movies_filter($views){
	// pega as informacoes do usuario logado
	$user = wp_get_current_user();

	if($user->roles[0] == 'contributor' || $user->roles[0] == 'editor'){

		if( $_GET['filter'] == 'grupo' ){

			$views['grupos'] = "<a href='" . admin_url('edit.php?list=evento&filter=grupo') . "' class='current'>Meus Eventos</a>";
		return $views;

		} else {
			$views['grupos'] = "<a href='" . admin_url('edit.php?list=evento&filter=grupo') . "'>Meus Eventos</a>";
		return $views;
		}
	}

	return $views;
}
 
add_filter('views_edit-post', 'wp38_add_movies_filter');

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


// Altera a URL de Eventos e Unidades para colaboladores
add_action('admin_menu', 'add_custom_link_into_appearnace_menu');
function add_custom_link_into_appearnace_menu() {
	global $submenu;
	
    // pega as informacoes do usuario logado
	$user = wp_get_current_user();
	
	if($user->roles[0] == 'contributor' || $user->roles[0] == 'editor'){		
		$submenu['edit.php'][5][2] = 'edit.php?list=evento&filter=grupo';
		$submenu['edit.php?post_type=unidade'][5][2] = 'edit.php?post_type=unidade&filter=grupo';
	}
}


// Carrega todas as localizacoes do grupo para o usuario
add_filter('acf/load_field/name=localizacao', 'populateUserGroups');
add_filter('acf/load_field/name=localizacao_serie', 'populateUserGroups');

function populateUserGroups( $field ){	
	
	// reset choices
	$field['choices'] = array();

	$user = wp_get_current_user();

	// usuarios que ficam foram da regra
	$allowed_roles = array( 'administrator' );
    
    if ( array_intersect( $allowed_roles, $user->roles ) ) {
        $args = array(
			'post_type' => 'unidade',
			'posts_per_page'    =>  -1,
			'orderby' => 'title',
    		'order'   => 'ASC',		
		);
		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();
			$field['choices'][ get_the_id() ] = get_the_title();			
		endwhile;

		wp_reset_postdata();
		
		//print_r($query);
    } else {
		$variable = get_user_meta($user->ID,'grupo',true);

		$pages = get_post_meta($variable, 'unidades', true);
		if($pages && $pages != ""){
			foreach ($pages as $page) {
				$field['choices'][ $page ] = get_the_title($page);
			}
		}
		
	}

	return $field;
}


add_filter('redirect_canonical','pif_disable_redirect_canonical');

function pif_disable_redirect_canonical($redirect_url) {
    if (is_singular()) $redirect_url = false;
return $redirect_url;
}

//MapLeaFlet
wp_register_style( 'leaflet.css','https://unpkg.com/leaflet@1.6.0/dist/leaflet.css', null, '1.6.0', 'all' );
wp_enqueue_style('leaflet.css');
wp_register_script('leaflet.js', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.js', null, '1.6.0', false);
wp_enqueue_script('leaflet.js');

function my_enqueue_scripts() {
	if ( (is_single() && 'unidade' == get_post_type()) || (is_single() && 'post' == get_post_type())){
		wp_register_script('mapsceus-leaflet.js', get_template_directory_uri() . '/js/mapsceus-leaflet.js', array('jquery'), 1.0 ,false);
		wp_enqueue_script('mapsceus-leaflet.js');
	}
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );



// Geocoder
wp_register_style( 'leaflet-geocoder-locationiq.min.css','https://maps.locationiq.com/v2/libs/leaflet-geocoder/1.9.6/leaflet-geocoder-locationiq.min.css', null, '1.6.0', 'all' );
wp_enqueue_style('leaflet-geocoder-locationiq.min.css');

wp_register_script('leaflet-unwired.js', 'https://tiles.unwiredlabs.com/js/leaflet-unwired.js?v=1', null, '1.6.0', false);
wp_enqueue_script('leaflet-unwired.js');

wp_register_script('leaflet-hash.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet-hash/0.2.1/leaflet-hash.min.js', null, '1.6.0', false);
wp_enqueue_script('leaflet-hash.min.js');

wp_register_script('leaflet-geocoder-locationiq.min.js', 'https://maps.locationiq.com/v2/libs/leaflet-geocoder/1.9.6/leaflet-geocoder-locationiq.min.js', null, '1.6.0', false);
wp_enqueue_script('leaflet-geocoder-locationiq.min.js');

function get_unidades(){
	$args = array(
		'post_type' => 'unidade',
		'post__not_in' => array(31244, 31675),
		'posts_per_page' => -1
	);

	$idUnidades = array();
	
	// The Query
	$the_query = new WP_Query( $args );
	
	// The Loop
	if ( $the_query->have_posts() ) {
		
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$idUnidades[] = get_the_id();
		}
		
	} 
	/* Restore original Post Data */
	wp_reset_postdata();

	return $idUnidades;
}

if ( function_exists( 'get_field' ) ) {
	function get_group_field( string $group, string $field, $post_id = 0 ) {
		$group_data = get_field( $group, $post_id );
		if ( is_array( $group_data ) && array_key_exists( $field, $group_data ) ) {
			return $group_data[ $field ];
		}
		return null;
	}
}


/**** Ajax Busca ****/

function cc_post_title_filter($where, &$wp_query) {
    global $wpdb;
    if ( $search_term = $wp_query->get( 'cc_search_post_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like( $search_term ) . '%\'';
    }
    return $where;
}

// the ajax function
add_action('wp_ajax_data_fetch','data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

    add_filter( 'posts_where', 'cc_post_title_filter', 10, 2 );
	$the_query = new WP_Query( array( 'posts_per_page' => 10,
									  'post_status' => 'publish',
									  'cc_search_post_title' => esc_attr( $_POST['keyword'] ), 
									  'post_type' => 'unidade' ) );
	remove_filter( 'posts_where', 'cc_post_title_filter', 10 );

    if( $the_query->have_posts() ) :
		echo "<ul class='' id='unidade-list'>";
		echo "<li class='disable-link'>Unidades</li>";
        while( $the_query->have_posts() ): $the_query->the_post();
			$campos = get_field( 'informacoes_basicas', get_the_id() );
			//print_r($campos);
	?>

		<li class=""><a href="#map" class="story" onclick="alerta(this)" data-point="<?php echo $campos['latitude']; ?>,<?php echo $campos['longitude']; ?>"><div class="name"><?php echo get_the_title(); ?></div><div class="address"><?php echo $campos['endereco']; ?>, <?php echo $campos['numero']; ?> - <?php echo $campos['bairro']; ?> - CEP: <?php echo $campos['cep']; ?></div></a></li>

        <?php endwhile;
		echo "<li class='disable-link'>Endereços</li>";
		echo '</ul>';
        wp_reset_postdata();  
    
    endif;
        die();
}

// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
<script type="text/javascript">
	

function fetchResults(){
	var keyword = jQuery('.leaflet-locationiq-input').val();
	if(keyword == ""){
		jQuery('#datafetch').html("");
		jQuery('#unidades-mapa').html("");
	} else {
		jQuery.ajax({
			url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
			type:"post",
			data: { action: 'data_fetch', keyword: keyword  },
			success: function(data) {

				//jQuery('.leaflet-locationiq-results').append("<span>Aqui</span>");

				/*
				if (jQuery(".leaflet-locationiq-list")[0]){
					// Do something if class exists
					jQuery('.leaflet-locationiq-results').html( data );
				} else {
					// Do something if class does not exist
					jQuery('.leaflet-locationiq-results').html( data );
				}
				*/
				jQuery('#unidade-list').remove();
				jQuery('.leaflet-locationiq-list').prepend( data );
				//console.log(data);
			},
			//error : function(error){ console.log(error) }
		});
	}

}
</script>

<?php
}

function nomeZona($zona){
	if($zona == 'norte'){
		return "Zona Norte";
	} elseif($zona == 'sul'){
		return "Zona Sul";
	} elseif($zona == 'leste'){
		return "Zona Leste";
	} elseif($zona == 'oeste'){
		return "Zona Oeste";
	}
}

function clearPhone($phone){
	$clear = preg_replace("/[^0-9]/", "", $phone);

	return $clear;
}

// Ocultar itens do menu por tipor de usuario
function wpdocs_remove_menus(){	
	remove_menu_page( 'edit-comments.php' ); //Comentarios
	
	if(!is_super_admin()){		
		remove_menu_page( 'themes.php' ); //Aparencia
		remove_menu_page( 'tools.php' ); //Ferramentas
		remove_menu_page( 'options-general.php' ); //Configuracoes
		remove_menu_page( 'edit.php?post_type=acf-field-group' ); //Campos Personalizados
	}
}
add_action( 'admin_menu', 'wpdocs_remove_menus' );

add_filter('acf/fields/relationship/query/name=carrocel', 'my_acf_fields_relationship_query', 10, 3);
function my_acf_fields_relationship_query( $args, $field, $post_id ) {
		
	$args['meta_query'] = array(
		'relation' => 'OR',
        array(
            'key'     => 'localizacao',
            'value'   => $post_id,
        ),
        array(
            'key'     => 'localizacao',
            'value'   => 31675,
        ),		
		array(
			'key'		=> 'ceus_participantes_$_localizacao_serie',
			'compare'	=> '=',
			'value'		=> $post_id,
		),
    );

    return $args;
}

function convertHour($hora){	
	$hora = str_replace('00min', '', $hora);
	$hora = ltrim($hora, '0');

	//print_r($hora);

	return $hora;
}

// Incluir CSS no admin
function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');


function translateMonth($date){
	$mes = '';
	
	switch ($date) {
		case 'Feb':
			$mes = 'Fev';
			break;
		case 'Apr':
			$mes = 'Abr';
			break;
		case 'May':
			$mes = 'Mai';
			break;
		case 'Aug':
			$mes = 'Ago';
			break;
		case 'Sep':
			$mes = 'Set';
			break;
		case 'Oct':
			$mes = 'Out';
			break;
		case 'Dec':
			$mes = 'Dez';
			break;
	}

	if($mes){
		return $mes;
	} else {
		return $date;
	}	
}

add_filter('acf/fields/post_object/query/name=selecione_o_evento', 'my_acf_fields_post_object_query', 10, 3);
function my_acf_fields_post_object_query( $args, $field, $post_id ) {

	$args['meta_query'] = array(
		'relation' => 'AND',
        array(
            'key'     => 'tipo_de_evento_evento_principal',
            'value'   => 'principal',
			'compare' 	=> '=',
        )
    );

    return $args;
}

// Desabilitar funcoes de usuarios
remove_role( 'subscriber' ); // Assinante
remove_role( 'author' ); // Autor

// Renomear tipo de usuario Contribuidor para Colaborador
add_action( 'wp_roles_init', static function ( \WP_Roles $roles ) {
    $roles->roles['contributor']['name'] = 'Colaborador';
    $roles->role_names['contributor'] = 'Colaborador';
} );

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

##################
function wpza_replace_repeater_field( $where ) {
	$where = str_replace( "meta_key = 'ceus_participantes_$", "meta_key LIKE 'ceus_participantes_%", $where );
	return $where;
}
add_filter( 'posts_where', 'wpza_replace_repeater_field' );

add_filter('acf/fields/relationship/result', 'my_acf_fields_relationship_result', 10, 4);
function my_acf_fields_relationship_result( $text, $post, $field, $post_id ) {
    $page_views = get_field( 'localizacao', $post->ID );
    $tipo = get_field( 'tipo_de_evento_tipo', $post->ID );
	if($tipo == 'serie'){
		$title = 'Múltiplas Unidades';
	} else {
		$title = get_the_title($page_views);
	}
	
    if( $title ) {
        $text .= ' ' . sprintf( '(%s)', $title );
    }
    return $text;
}

add_action('admin_menu', 'my_remove_sub_menus');
function my_remove_sub_menus() {
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}

// Alterar place cadastro/edicao Sobre o CEU
function wpb_change_title_text( $title ){
	$screen = get_current_screen(); 
	if  ( 'unidade' == $screen->post_type ) {
		 $title = 'Digite o nome do CEU';
	} 
	return $title;}
 
add_filter( 'enter_title_here', 'wpb_change_title_text' );

// Funcao para ativar ordenacao
function sortable_destaque_column( $columns )    {
    $columns['destaque'] =  'destaque';
    return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'sortable_destaque_column' ); // Evento Destaque

// Funcao para ordernar
function orderby_destaque_column( $query ) {
    global $pagenow;

    if ( ! is_admin() || 'edit.php' != $pagenow || ! $query->is_main_query()  )  {
        return;
    }

    $orderby = $_GET['orderby'];

    print_r($orderby);

    switch ( $orderby ) {
        case 'destaque':
            $query->set( 'meta_key', 'evento_destaque_home' );
            $query->set( 'orderby', 'meta_value' );
            break;

        default:
            break;
    }

}
add_action( 'pre_get_posts', 'orderby_destaque_column' );

// Ocultar campo Destaque Home para não Admins
add_action('admin_head', 'hide_event_css');
function hide_event_css () {   

    global $current_user;
    if (is_admin() && is_user_logged_in() && !in_array('administrator', $current_user->roles)) {
        echo '<style>';        
            echo 'div.dest-home{display: none;}'; 
            echo 'div.sub-admin{width: 100% !important;}';
			echo '.tipo-evento .acf-radio-list li:nth-child(3){display: none;}';
			echo '.sobre-evento .acf-radio-list li:nth-child(1){display: none;}';
			echo '.cptImageSize-thumbnail{display: none;} ';
			echo '.cptImageSize-categoria-eventos{display: none;}';
        echo '</style>';
    }
}

// Criar Ação em Massa - Marcar destaque home / Remover destaque home
add_filter('bulk_actions-edit-post', function($bulk_actions) {
	
	global $current_user;
    
	if (is_admin() && is_user_logged_in() && in_array('administrator', $current_user->roles)) {
		$bulk_actions['aplicar-destaque'] = __('Marcar destaque home', 'txtdomain');
		$bulk_actions['remover-destaque'] = __('Remover destaque home', 'txtdomain');		
	}

	return $bulk_actions;
});

add_filter('handle_bulk_actions-edit-post', function($redirect_url, $action, $post_ids) {
	// Aplicar
	if ($action == 'aplicar-destaque') {
		foreach ($post_ids as $post_id) {
			update_post_meta($post_id, 'evento_destaque_home', '1');
		}
		$redirect_url = add_query_arg('aplicar-destaque', count($post_ids), $redirect_url);
	}

	// Remover
	if ($action == 'remover-destaque') {
		foreach ($post_ids as $post_id) {
			update_post_meta($post_id, 'evento_destaque_home', '0');
		}
		$redirect_url = add_query_arg('remover-destaque', count($post_ids), $redirect_url);
	}
	return $redirect_url;

}, 10, 3);


// ACF - Filtrar Posts do Slide por Eventos em Destaque
add_filter('acf/fields/relationship/query/name=slide', 'acf_filter_destaque', 10, 3);
add_filter('acf/fields/relationship/query/name=eventos', 'acf_filter_destaque', 10, 3);
function acf_filter_destaque( $args, $field, $post_id ) {

    $meta_query = array(
		array(
		  'key' => 'evento_destaque_home',
		  'value' => 1,
		  'compare' => 'LIKE'
		)
	  );
	
	// the correct argument key is 'meta_query'
	$args['meta_query'] = $meta_query;

	// return
	 return $args;
}

// Alterar paleta de cores do admin para 'Amanhecer'
add_filter( 'get_user_option_admin_color', 'update_user_option_admin_color', 5 );

function update_user_option_admin_color( $color_scheme ) {
    $color_scheme = 'sunrise';

    return $color_scheme;
}

// Ocultar Unidades(Categorias) e Tags de Eventos(Posts)
add_filter( 'quick_edit_show_taxonomy', function( $show, $taxonomy_name, $view ) {

    if ( 'category' == $taxonomy_name ){
		return false;
	}

	if ( 'post_tag' == $taxonomy_name ){
		return false;
	}

    return $show;
}, 10, 3 );

// Alterar email novo usuarios
add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3 );

function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
    
	// Gerar uma chave de verificacao
	$key = get_password_reset_key( $user );
    
	// Editar conteudo do Email
    $message = sprintf(__('Nome de usuário: ')) . rawurlencode($user->user_login) . "\r\n\r\n";
    $message .= 'Para definir sua senha, visite o seguinte endereço:' . "\r\n\r\n";
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . "\r\n\r\n";
    $message .= "Para acesso à página de login:" . "\r\n\r\n";
    $message .= network_site_url("wp-login.php", 'login') . "\r\n\r\n";
    $wp_new_user_notification_email['message'] = $message;

    // Para alterar o cabecalho do email edite a linha abaixo
	//$wp_new_user_notification_email['headers'] = 'From: MyName<example@domain.ext>'; // this just changes the sender name and email to whatever you want (instead of the default WordPress <wordpress@domain.ext>

    // retorna o conteudo do email
	return $wp_new_user_notification_email;
}

add_filter('wp_insert_post_data', 'change_post_status', '100');

function change_post_status($data)
{
    if( current_user_can('contributor') && ($data['post_type'] == 'post' || $data['post_type'] == 'unidade') )
    {
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        //then set the fields you want to update
		if($data['post_status'] == 'publish'){
			$data['post_status'] = 'pending';
		}		
    }
    return $data;
}


// Permitir que colaboradores possam ver o preview dos posts
function jv_change_post( $posts ) {
    if(is_preview() && !empty($posts)){        
        $posts[0]->post_status = 'publish';
    }

    return $posts;
}
add_filter( 'posts_results', 'jv_change_post', 10, 2 );

// Salvar Custom Fields durante o Salvamento Automatico
function hcf_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }

	
	// Localizacao
	if( isset($_POST['acf']["field_5fc7ce0712c45"]) && $_POST['acf']["field_5fc7ce0712c45"] != '' ){
		update_post_meta(
			$post_id,
			'localizacao',
			sanitize_text_field( $_POST['acf']["field_5fc7ce0712c45"] )
		);
	}

	// Tipo do Evento
	if( isset($_POST['acf']["field_6005f25ba8021"]["field_6005f287a8022"]) && $_POST['acf']["field_6005f25ba8021"]["field_6005f287a8022"] != '' ){
		update_post_meta(
			$post_id,
			'tipo_de_evento_tipo',
			sanitize_text_field( $_POST['acf']["field_6005f25ba8021"]["field_6005f287a8022"] )
		);
	}

	// Inscricoes
	if( isset($_POST['acf']["field_6086de280d929"]["field_6086de450d92a"]) && $_POST['acf']["field_6086de280d929"]["field_6086de450d92a"] != '' ){
		update_post_meta(
			$post_id,
			'inscricoes_info_inscricoes',
			sanitize_text_field( $_POST['acf']["field_6086de280d929"]["field_6086de450d92a"] )
		);
	}

	// Descricao
	if( isset($_POST['acf']["field_6005f383003ea"]) && $_POST['acf']["field_6005f383003ea"] != '' ){
		update_post_meta(
			$post_id,
			'descricao',
			$_POST['acf']["field_6005f383003ea"]
		);
	}
	
}
add_action( 'save_post', 'hcf_save' );

add_action( 'admin_head-edit.php', 'hide_unidade_categ' );

function hide_unidade_categ() 
{
    // Ocultar Filtro "Categorias" na listagem de unidades
    global $current_screen;
    if( 'unidade' != $current_screen->post_type)
        return;
    ?>
        <style>
            .postform { display:none }
        </style>
    <?php
}


// Inclusao do filtro por unidade

add_action('restrict_manage_posts','filtering_unidade',10);
function filtering_unidade($post_type){
    
	if('post' !== $post_type){
      return; //filter your post
    }

	$user = wp_get_current_user();

	if($user->roles[0] == 'administrator'){		

		$unidades = array();
		$i = 0;
		$allUnidades = new WP_Query( array(
			'post_type' => 'unidade',
			'posts_per_page' => -1,
			'orderby'	=> 'title',
			'order'	=> 'ASC',
			'meta_key' => '',
			'meta_value' => '',		
		) );

		
		if ($allUnidades->have_posts()) {
			while ($allUnidades->have_posts()) {
				$allUnidades->the_post();
				
				$unidades[$i]['ID'] = get_the_ID();
				$unidades[$i]['post_title'] =  get_the_title();
				$unidades[$i] = (object) $unidades[$i];

				$i++;
			}
		}

		wp_reset_postdata();
		
	}
	
	if($user->roles[0] == 'contributor' || $user->roles[0] == 'editor'){		
		
		$grupos = get_user_meta($user->ID,'grupo',true);		
		$allUnidades = array();
		$unidades = array();
		$i = 0;
		
		if($grupos && $grupos !=''){
			foreach($grupos as $grupo){
				$allUnidades[] = get_post_meta($grupo, 'unidades', true);
			}		
			$allUnidades = array_flatten($allUnidades);
			$allUnidades = array_unique($allUnidades);

			foreach($allUnidades as $unidade){				
				$unidades[$i]['ID'] = $unidade;
				$unidades[$i]['post_title'] =  get_the_title($unidade);
				$unidades[$i] = (object) $unidades[$i];
				$i++;
			}
		}
	}
      

	// Unidade Selecionada
	$unidadeSelect = $_GET['search_unidade'];

   //build a custom dropdown list of values to filter by
    echo '<select id="my-loc" name="search_unidade">';
		if($user->roles[0] == 'contributor' || $user->roles[0] == 'editor'){
			$selecionado = ($_GET['list'] == 'evento') ? ' selected="selected"':'';
			echo '<option value="minhas-unidades" ' . $selecionado . '>Minhas Unidades</option>';
		}
		$selecionado = ($_GET['search_unidade'] == 'all') ? ' selected="selected"':'';
		echo '<option value="all" ' . $selecionado . '>Todas as Unidades</option>';		
		foreach($unidades as $unidade){
			$select = ($unidadeSelect == $unidade->ID) ? ' selected="selected"':'';
			echo '<option value="'.$unidade->ID.'"'.$select.'>' . $unidade->post_title . ' </option>';
		}

    echo '</select>';
	
}

// Desativar select de categoria padrao do WP
global $pagenow;
if(is_admin() && $pagenow == 'edit.php'){
	add_filter('wp_dropdown_cats', '__return_false');
}

// Filtra as unidades que grupo pertence
add_filter('pre_get_posts', 'limit_events_group');
function limit_events_group($query) {

	// pega as informacoes do usuario logado
	$user = wp_get_current_user();

	// 	filtra as unidades pelo grupo pertencente
	if( $_GET['search_unidade'] && $_GET['search_unidade'] != '' && $_GET['search_unidade'] != 'all' )  {

		if($_GET['search_unidade'] == 'minhas-unidades'){
			wp_redirect( 'edit.php?list=evento&filter=grupo' ); 
			exit;
		}		
		
		if($query->is_main_query()){
			$meta_query = array(
				'relation' => 'OR',
				array(
					'key'     => 'localizacao',
					'value'   => $_GET['search_unidade'],
				),					
				array(
					'key'		=> 'ceus_participantes_$_localizacao_serie',
					'compare'	=> '=',
					'value'		=> $_GET['search_unidade'],
				),
			);
			
			$query->set( 'meta_query', $meta_query );			
		}	

	}

	return $query;
	wp_reset_postdata();
}

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

// Pega as informacoes do usuario logado
$user = wp_get_current_user();

//remove o botao de edicao rapida
function remove_quick_edit( $actions ) {
    unset($actions['inline hide-if-no-js']);
    return $actions;
}

// Se o usuarios nao por admin remove os botoes de edicao rapida
if ( !current_user_can('edit_plugins') ) {
    add_filter('page_row_actions','remove_quick_edit',10,1);
    add_filter('post_row_actions','remove_quick_edit',10,1);
}

// remove o editor de link permanente
function hide_permalink() {
    return '';
}

// Se usuario nao for admin remove o botao de editar o link permanente
if ( !current_user_can('edit_plugins') ) {
	add_filter( 'get_sample_permalink_html', 'hide_permalink' );
}

// Filtrar os usuarios por grupo do usuarios que estiver logado
function modify_user_list($query){
    $user = wp_get_current_user();

    //if( ! current_user_can( 'edit_user' ) ) return $query;
	if ( !current_user_can( 'manage_options' ) ) {
		$user_id = $user->ID; 
		$user_group = get_user_meta($user_id, 'grupo', true);
		
		$meta_query = array(
			'relation' => 'OR',
		);
		if($user_group){
			foreach($user_group as $group){
				$meta_query[] = array(
					'key' => 'grupo', // name of custom field
					'value' => $group, // matches exaclty "123", not just 123. This prevents a match for "1234"
					'compare' => 'LIKE'
				);
			}
		}
		$query->set( 'meta_query', $meta_query );
	}

}
add_action('pre_get_users', 'modify_user_list');

// Mostrar os grupos que o usuario pertence no seletor de grupos de usuarios
add_filter('acf/fields/relationship/query/key=field_5f9843469209b', 'filter_groups_by_user', 10, 3);
function filter_groups_by_user() {
    $user = wp_get_current_user(); 
	$user_id = $user->ID; 
	$args['post_type'] = 'wporg_unidades';

	if( in_array('editor', $user->roles) ){
		$user_group = get_user_meta($user_id, 'grupo', true);		
		$args['post__in'] = $user_group;
	}	
	
    return $args;
}

// Ocultar contador de usuario na pagina users.php
add_action('admin_head', 'hide_counter_users');
function hide_counter_users() {
	global $pagenow;
	$user = wp_get_current_user();  

	if($pagenow == 'users.php' && !in_array('administrator', $user->roles)){
		echo '<style>
		.subsubsub .count {
			display: none;
		}
		</style>';
	}
	
}

// Ocultar seletor de cor
function admin_color_scheme() {
	global $_wp_admin_css_colors;
	$_wp_admin_css_colors = 0;
}
add_action('admin_head', 'admin_color_scheme');
add_filter( 'login_display_language_dropdown', '__return_false' );

#####
// ocultar campos na edicao do perfil do usuario
if ( ! function_exists( 'cor_remove_personal_options' ) ) {
	function cor_remove_personal_options( $subject ) {
		
		global $_wp_admin_css_colors;
		$_wp_admin_css_colors = 0;

		$subject = preg_replace('#<h2>'.__("Personal Options").'</h2>#s', '', $subject, 1); // Remover titulo "Opções pessoais"
		$subject = preg_replace('#<tr class="user-rich-editing-wrap(.*?)</tr>#s', '', $subject, 1); // Remover "Editor visual"
		$subject = preg_replace('#<tr class="user-comment-shortcuts-wrap(.*?)</tr>#s', '', $subject, 1); // Remover "Atalhos do teclado"
		$subject = preg_replace('#<tr class="show-admin-bar(.*?)</tr>#s', '', $subject, 1); // Remover "Barra de ferramentas"
		$subject = preg_replace('#<tr class="user-language-wrap(.*?)</tr>#s', '', $subject, 1); // Remover "Idioma"
		$subject = preg_replace('#<tr class="user-syntax-highlighting-wrap(.*?)</tr>#s', '', $subject, 1); // Remover "Destaque de sintaxe"
		
		return $subject;
	}

	function cor_profile_subject_start() {
		if ( ! current_user_can('manage_options') ) {
			ob_start( 'cor_remove_personal_options' );
		}
	}

	function cor_profile_subject_end() {
		if ( ! current_user_can('manage_options') ) {
			ob_end_flush();
		}
	}
}
add_action( 'admin_head', 'cor_profile_subject_start' );
add_action( 'admin_footer', 'cor_profile_subject_end' );
#####


//Filtra por tipo de evento grande ou serie
function wpse45436_admin_posts_filter_restrict_manage_posts(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    if ('post' == $type){
        $values = array(
            'Grande evento' => 'outro',
            'Eventos em série' => 'serie',
        );
        ?>
        <select name="tipo">
            <option value=""><?php _e('Todos os tipos de eventos ', 'wose45436'); ?></option>
            <?php $current_v = isset($_GET['tipo'])? $_GET['tipo']:''; foreach ($values as $label => $value) {
                printf
                (
                    '<option value="%s"%s>%s</option>',
                    $value,
                    $value == $current_v? ' selected="selected"':'',
                    $label
                );
            }
            ?>
        </select>
    <?php } //if submitted filter by post meta
}

add_filter( 'parse_query', 'wpse45436_posts_filter' );
function wpse45436_posts_filter( $query ){
	global $pagenow;

	if ( is_admin() && 'edit.php' == $pagenow && $_GET['tipo'] != '' )  {
        $query->query_vars['meta_value'] = $_GET['tipo'];
    }
    
}
add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );

// Nao permitir a edicao de eventos para usuarios que nao sejam do mesmo grupo
global $pagenow;
global $current_user;
if (( $pagenow == 'post.php' ) || (get_post_type() == 'post')) {

    $evento = $_GET['post']; // Pegar ID do evento (post)
	if(get_post_type($_GET['post']) == 'unidade'){
		$unidade = $_GET['post'];
		$redirect = admin_url('edit.php?post_type=unidade&filter=grupo');
	} else {
		$unidade = get_field('localizacao', $evento); // Pegar a localizacao atribuida
		$redirect = admin_url('edit.php?list=evento&filter=grupo');
	}
    
    $user = get_currentuserinfo(); // Pegar informacoes do usuario logado

	if($user->roles[0] != 'administrator'){
		$grupos = get_field('grupo', 'user_' . $user->ID); // Grupo do usuario
	
		$unidades = array();

		if($grupos && $grupos != ''){
			foreach($grupos as $grupo){
				$unidades[] = get_field('unidades', $grupo);
			}
		}

		$unidades = call_user_func_array('array_merge', $unidades);
		$unidades = array_unique($unidades);
		
		if( !in_array($unidade, $unidades) ){
			wp_redirect( $redirect );
		}
	}
	
}