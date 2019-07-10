<?php
/*
 * Template Name: Página Escolas
 * Description: Página que Consome a Api do Escola Aberta.
 */

use Classes\ModelosDePaginas\PaginaEscolas\PaginaEscolas;

get_header();

$modelo_de_pagina = new PaginaEscolas();
$modelo_de_pagina->buscaEscola();

get_footer();


