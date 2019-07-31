<?php
/*
 * Template Name: Página Abas
 * Description: Página Abas, página que exibe título, texto, contato e categoria de botões
 */

use Classes\ModelosDePaginas\PaginaAbas\PaginaAbas;

get_header();
$pagina_abas = new PaginaAbas();
get_footer();



