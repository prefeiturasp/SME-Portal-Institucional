<?php
/*
 * Template Name: Página Doe
 * Description: Página Doe. Exibe a o texto padrão e os formuários para doação.
 */


use Classes\PaginaFilha\PaginaFilha;
use Classes\ModelosDePaginas\PaginaDoe\PaginaDoe;

global $post;

// $page_ID_filha veio do loop-front-page ou do modelo-com-pagina-filha.php
$descobrirSePaginaFilha = new PaginaFilha($post, $page_ID_filha);
$retornoSePaginaFilha = $descobrirSePaginaFilha->getRetornoSePaginaFilha();

$modelo_de_pagina = new PaginaDoe();

if (!$retornoSePaginaFilha) {
	get_footer();
}


