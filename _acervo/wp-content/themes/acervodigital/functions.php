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






//Count access acervo
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
add_action( 'manage_posts_custom_column', 'gt_downloads_custom_column_views' );





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