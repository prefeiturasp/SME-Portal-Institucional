<?php
/*
 * Template Name: Página Botões
 * Description: Página Botões, página que exibe título, texto, categoria de botões
 */

use Classes\ModelosDePaginas\PaginaBotoes\PaginaBotoes;

get_header();
$pagina_abas = new PaginaBotoes();
$pagina_abas->init();
get_footer();



