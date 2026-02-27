<?php
$eleitoral = get_field('ativar_periodo','periodo-eleitoral');
$noticias = get_field('ocultar_noticias','periodo-eleitoral');

if($eleitoral && !current_user_can('administrator') && $noticias){
    $url = get_field('url_redirect','periodo-eleitoral');
    if($url == ''){
        $url = get_home_url();
    }
    wp_redirect($url);
}
use Classes\TemplateHierarchy\LoopSingle\LoopSingle;
get_header();
$loop_single = new LoopSingle();
//contabiliza visualizações de noticias
setPostViews(get_the_ID()); /*echo getPostViews(get_the_ID());*/
get_footer();