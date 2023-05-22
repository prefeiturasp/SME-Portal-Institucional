<?php
/*
 * Template Name: Construtor de páginas
 * Description: Modelo para construção de páginas dinamicas
 */

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