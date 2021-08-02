<?php



//Default

//require_once 'core/index.php';



//Enqueues

require_once 'core/enqueue.php';



//Classes

require_once 'core/classes/ctp.php';

require_once 'core/classes/taxonomia.php';

require_once 'core/classes/tag.php';



//Modify Wordpress

require_once 'core/modify.php';



//Client suport

require_once 'core/suport.php';



//ACF

require_once 'core/acf.php';



//Users

require_once 'core/users/user.php';



//Notices admin

require_once 'core/notices.php';



//tutorial

require_once 'core/tutorial.php';

//metricas

require_once 'core/metricas.php';




/*//Count access acervo

function gt_get_post_view() {

    $count = get_post_meta( get_the_ID(), 'post_views_count', true );

    return $count;

}

function gt_set_post_view() {

    $key = 'post_views_count';

    $post_id = get_the_ID();

    $count = (int) get_post_meta( $post_id, $key, true );

    $count++;

    update_post_meta( $post_id, $key, $count );

}

function gt_posts_column_views( $columns ) {

    $columns['post_views'] = 'Visualizações';

    return $columns;

}

function gt_posts_custom_column_views( $column ) {

    if ( $column === 'post_views') {

        echo gt_get_post_view();

    }

}

add_filter( 'manage_posts_columns', 'gt_posts_column_views' );

add_action( 'manage_posts_custom_column', 'gt_posts_custom_column_views' );





//Count download Acervo

function update_counter_ajax() {

$postID = trim($_POST['post_id']);

$count_key = 'download';

$counter = get_post_meta($postID, $count_key, true);

    if($counter==''){

        $count = 1;

        delete_post_meta($postID, $count_key);

        add_post_meta($postID, $count_key, '1');

    }else{

        $counter++;

        update_post_meta($postID, $count_key, $counter);

    }

wp_die();

}

function gt_get_downloads_view() {

    $count = get_post_meta( get_the_ID(), 'download', true );

    return $count;

}

function gt_downloads_column_views( $columns ) {

    $columns['download'] = 'Downloads';

    return $columns;

}

function gt_downloads_custom_column_views( $column ) {

    if ( $column === 'download') {

        echo gt_get_downloads_view();

    }

}

add_action('wp_ajax_update_counter', 'update_counter_ajax');

add_action('wp_ajax_nopriv_update_counter', 'update_counter_ajax');

add_filter( 'manage_posts_columns', 'gt_downloads_column_views' );

add_action( 'manage_posts_custom_column', 'gt_downloads_custom_column_views' );*/





//pega ip do visitante
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
get_client_ip();




//Remove hierarquia Taxonomia Palavra Chave

function wpse_58799_remove_parent_category()

{

    if ( 'palavra' != $_GET['taxonomy'] )

        return;



    $parent = 'parent()';



    if ( isset( $_GET['action'] ) )

        $parent = 'parent().parent()';



    ?>

        <script type="text/javascript">

            jQuery(document).ready(function($)

            {     

                $('label[for=parent]').<?php echo $parent; ?>.remove();       

            });

        </script>

    <?php

}

add_action( 'admin_head-edit-tags.php', 'wpse_58799_remove_parent_category' );





//adiciona ACF na busca do wordpress
function my_pre_get_posts( $query ) {
	// do not modify queries in the admin
	if( is_admin() ) {
		return $query;
	}
	// only modify queries for 'event' post type
	if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'acervo' ) {
		// allow the url to alter the query
		if( isset($_GET['ano_da_publicacao_acervo_digital']) ) {
    		$query->set('meta_key', 'ano_da_publicacao_acervo_digital');
			$query->set('meta_value', $_GET['ano_da_publicacao_acervo_digital']);
    	} 
	}
	// return
	return $query;
}

add_action('pre_get_posts', 'my_pre_get_posts');


// Remove a taxomia da lateral do editor
function wpse60590_remove_metaboxes() {
    remove_meta_box( 'palavradiv' , 'acervo' , 'normal' ); // Remove Palavra
    remove_meta_box( 'categoria_acervodiv' , 'acervo' , 'normal' ); // Remove Categoria
    remove_meta_box( 'autordiv' , 'acervo' , 'normal' ); // Remove Autor
    remove_meta_box( 'setordiv' , 'acervo' , 'normal' ); // Remove Setor
    remove_meta_box( 'idiomadiv' , 'acervo' , 'normal' ); // Remove Idioma
    remove_meta_box( 'modalidadediv' , 'acervo' , 'normal' ); // Remove Modalidade
    remove_meta_box( 'componentediv' , 'acervo' , 'normal' ); // Remove Componente
    remove_meta_box( 'formacaodiv' , 'acervo' , 'normal' ); // Remove Formacao
    remove_meta_box( 'promotoradiv' , 'acervo' , 'normal' ); // Remove Promotora
    remove_meta_box( 'publicodiv' , 'acervo' , 'normal' ); // Remove Publico
}
add_action( 'admin_menu' , 'wpse60590_remove_metaboxes' );

add_filter( 'posts_where', 'wpse18703_posts_where', 10, 2 );
function wpse18703_posts_where( $where, &$wp_query )
{
    global $wpdb;
    if ( $wpse18703_title = $wp_query->get( 'wpse18703_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( $wpdb->esc_like( $wpse18703_title ) ) . '%\'';
    }
    return $where;
}

function wd_admin_menu_rename() {
    global $menu; // Global to get menu array
    global $submenu;
    $menu[10][0] = 'Arquivos'; // Change name of posts to portfolio  
    $submenu['upload.php'][10][0] = 'Adicionar novo';
}
add_action( 'admin_menu', 'wd_admin_menu_rename' );

add_action( 'admin_head', 'admin_head_script' );

function admin_head_script(){
    global $pagenow, $title;

    if ($pagenow == 'upload.php') {            
        $title = 'Biblioteca de Arquivos';    
    } // end pagenow
}

// Define o idioma padrao para Portugues no acervo
add_filter('acf/load_value/key=field_5efbf013703c5', 'kiteboat_set_tax_default', 20, 3);

function kiteboat_set_tax_default( $value, $post_id, $field ) {
	if ($value === false && get_post_status($post_id) == 'auto-draft') {
        // Esse id correponde ao do site atual nao sendo um valor fixo, em caso de migracao ou duplicidade de ambientes verificar o id do idioma desejado
		$value = 43; // id do portugues dentro da taxinomia idioma
	}
  return $value;
}

// Ocultar itens do menu
add_action( 'admin_init', 'wpse_136058_remove_menu_pages' );

function wpse_136058_remove_menu_pages() {
    remove_menu_page( 'edit.php?post_type=download' ); // Ocultar Downloads
    remove_menu_page( 'edit.php?post_type=acesso' ); // Ocultar Acessos
}

// Desabilita o tipo de usuario
remove_role( 'subscriber' );
remove_role( 'author' );

// Ocultar itens do menu para usuarios que não sao ASCOM ou AMCOM
function hide_menu() {
     
	$user = get_current_user_id(); // pega o ID usuario logado
    $setor = get_field('setor', 'user_' . $user); // pega o setor do usuario logado

    if($setor == 'AMCom' || $setor == 'ASCOM'){
       
    } else {
        remove_menu_page( 'themes.php' ); // Aparencias
        remove_menu_page( 'plugins.php' ); // Plugins
        remove_menu_page( 'tools.php' ); // Ferramentas
        remove_menu_page( 'edit.php?post_type=acf-field-group' ); // Campos Personalizados
        remove_menu_page( 'options-general.php' ); // Configuracoes
        remove_menu_page( 'wp-mail-smtp' ); // WP Mails SMTP
    }      
    
}
add_action('admin_head', 'hide_menu', 5, 1);

// Cria uma nova coluna
function register_custom_user_column($columns) {
    $columns['setor'] = 'Setor';
    return $columns;
}

add_action('manage_users_columns', 'register_custom_user_column');

// Insere o valor na coluna
function register_custom_user_column_view($value, $column_name, $user_id) {
    
    $setor = get_field('setor', 'user_' . $user_id); // pega o setor do usuario logado
    
    if($column_name == 'setor'){
        if($setor){
            return $setor;
        } else {
            return 'Nenhum setor cadastrado';
        }
    } 
    return $value;

}

add_action('manage_users_custom_column', 'register_custom_user_column_view', 10, 3);

// Adicionar o botão de ordenacao na coluna
function sortable_setor_column( $columns ) {
    $columns['setor'] = 'setor';
    return $columns;
}
add_filter( 'manage_users_sortable_columns', 'sortable_setor_column' );

// Ordena usuarios pela coluna "Setor"
add_action("pre_get_users", function ($WP_User_Query) {

    if (    isset($WP_User_Query->query_vars["orderby"])
        &&  ("setor" === $WP_User_Query->query_vars["orderby"])
    ) {
        $WP_User_Query->query_vars["meta_key"] = "setor";
        $WP_User_Query->query_vars["orderby"] = "meta_value";
    }

}, 10, 1);

// Remover o campor "Additional Capabilities" do editor do usuarios
add_filter( 'ure_show_additional_capabilities_section', '__return_false' );

// Altera o texto da label
add_filter(  'gettext',  'dirty_translate'  );
add_filter(  'ngettext',  'dirty_translate'  );
function dirty_translate( $translated ) {
     $words = array(
            // 'termo para traducao' => 'traducao'
            'Enviar nova mídia' => 'Enviar novo arquivo',
            'Editar mídia' => 'Editar arquivo'
     );
$translated = str_ireplace(  array_keys($words),  $words,  $translated );
return $translated;
}

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
	}

add_action( 'widgets_init', 'theme_slug_widgets_init' );


add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
    add_image_size( 'capa-acervo', 372, 479, true ); // (cropped)
}

function removeParam($url, $varname){
    $parsedUrl = parse_url($url);
    $query = array();

    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $query);
        unset($query[$varname]);
    }

    $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
    $query = !empty($query) ? '?'. http_build_query($query) : '';

    return $parsedUrl['scheme']. '://'. $parsedUrl['host']. $path. $query;
}