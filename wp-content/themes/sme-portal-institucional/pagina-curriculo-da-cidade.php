<?php
/*
 * Template Name: Página Currículo da Cidade
 * Description: Página Currículo da Cidade, página que contém título, breve descrição, todos os documentos relacionados ao Currículo da Cidade, imagem da capa de cada documento.
 */

use Classes\ModelosDePaginas\PaginaCurriculoDaCidade\PaginaCurriculoDaCidade;

get_header();
$pagina_curriculo_da_cidade = new PaginaCurriculoDaCidade();
get_footer();



