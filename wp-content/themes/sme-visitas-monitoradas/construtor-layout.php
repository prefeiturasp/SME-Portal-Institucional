<?php
/*
 * Template Name: Construtor de páginas
 * Description: Modelo para construção de páginas dinamicas
 */

use Classes\ModelosDePaginas\Layout\Construtor;

get_header();
$Construtor = new Construtor();
get_footer();