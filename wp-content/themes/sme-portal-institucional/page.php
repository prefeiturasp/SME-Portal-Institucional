<?php

$eleitoral = get_field('ativar_periodo','periodo-eleitoral');
$pages = get_field('ocultar_paginas','periodo-eleitoral');
$current_id = get_the_ID();
if($eleitoral && !current_user_can('administrator')){
    $url = get_field('url_redirect','periodo-eleitoral');
    if($url == ''){
        $url = get_home_url();
    }
    if(in_array($current_id, $pages)){
        wp_redirect($url);
    }    
}

use Classes\TemplateHierarchy\Page;

get_header();

$pagina_page = new Page();
//contabiliza visualizações de noticias
setPostViews(get_the_ID());  //echo getPostViews(get_the_ID());
get_footer();