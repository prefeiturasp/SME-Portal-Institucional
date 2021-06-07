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


function wpse60590_remove_metaboxes() {
    remove_meta_box( 'palavradiv' , 'acervo' , 'normal' ); 
    remove_meta_box( 'categoria_acervodiv' , 'acervo' , 'normal' ); 
    remove_meta_box( 'autordiv' , 'acervo' , 'normal' );
    remove_meta_box( 'setordiv' , 'acervo' , 'normal' ); 
    remove_meta_box( 'idiomadiv' , 'acervo' , 'normal' ); 
    remove_meta_box( 'modalidadediv' , 'acervo' , 'normal' ); 
    remove_meta_box( 'componentediv' , 'acervo' , 'normal' ); 
    remove_meta_box( 'formacaodiv' , 'acervo' , 'normal' ); 
    remove_meta_box( 'promotoradiv' , 'acervo' , 'normal' ); 
    remove_meta_box( 'publicodiv' , 'acervo' , 'normal' ); 
}
add_action( 'admin_menu' , 'wpse60590_remove_metaboxes' );

function wd_admin_menu_rename() {
    global $menu; // Global to get menu array
    $menu[10][0] = 'Arquivos'; // Change name of posts to portfolio
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
		$value = 114; // id do portugues dentro da taxinomia idioma
	}
  return $value;
}

// Ocultar itens do menu
add_action( 'admin_init', 'wpse_136058_remove_menu_pages' );

function wpse_136058_remove_menu_pages() {
    remove_menu_page( 'edit.php?post_type=download' ); // Ocultar Downloads
    remove_menu_page( 'edit.php?post_type=acesso' ); // Ocultar Acessos
}

// Desabilitar funcoes de usuarios
remove_role( 'subscriber' ); // Assinante
remove_role( 'author' ); // Autor