<?php

/*
 * Template Name: Concursos
 * Description: Página para exibir todos os concursos cadastrados no site
 */

use Classes\ModelosDePaginas\PaginaConcursos\PaginaConcursos;

get_header();

$pagina_concursos = new PaginaConcursos();

get_footer();
