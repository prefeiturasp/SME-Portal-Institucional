<?php
/*
 * Template Name: Página Inicial do Portal
 * Description: Página Home do Novo Portal da SME. Traz o título, notícia principal, ícones personalizados, galeria de noticias, twitter, acesse nossa newsletter e nuvem de tags
 */

use Classes\ModelosDePaginas\PaginaInicial\PaginaInicial;

get_header();

$paginaInicial = new PaginaInicial();

get_footer();



