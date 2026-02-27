<?php
/*
 * Template Name: Construtor de páginas
 * Description: Modelo para construção de páginas dinamicas
 */

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

use Classes\ModelosDePaginas\Layout\Construtor;

get_header();

if (!post_password_required()) {
    $Construtor = new Construtor();

    //contabiliza visualizações de noticias
    setPostViews(get_the_ID());  //echo getPostViews(get_the_ID());
} else {
    echo "<div class='container'>";
        echo "<div class='row'>";

            echo '<article class="col-lg-12 col-xs-12">';
                echo '<h1 class="mb-4">Protegido: ' . get_the_title() . '</h1>';
            echo '</article>';

            echo '<article class="col-lg-12 col-xs-12" id="conteudo">';
                echo '<article col-lg-12 col-xs-12 editor-content>';
                    echo get_the_password_form();
                echo '</article>';
            echo '</article>';

        echo "</div>";
    echo "</div>";
}

get_footer();