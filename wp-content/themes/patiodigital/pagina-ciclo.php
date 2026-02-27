<?php
/*
 * Template Name: Página Ciclo de Inovação
 * Description: Página Ciclo de Inovação. Exibe a o texto padrão, os ciclos e mais duas áreas de editor.
 */


use Classes\PaginaFilha\PaginaFilha;
use Classes\ModelosDePaginas\PaginaCiclo\PaginaCiclo;

global $post;

// $page_ID_filha veio do loop-front-page ou do modelo-com-pagina-filha.php
$descobrirSePaginaFilha = new PaginaFilha($post, $page_ID_filha);
$retornoSePaginaFilha = $descobrirSePaginaFilha->getRetornoSePaginaFilha();

$modelo_de_pagina = new PaginaCiclo();

if (!$retornoSePaginaFilha) {
	get_footer();
}


