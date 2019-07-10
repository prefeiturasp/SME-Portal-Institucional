<?php
/*
 * Template Name: Página Enquete
 * Description: Página Enquete. Exibe a categoria de enquete definida.
 */


use Classes\PaginaFilha\PaginaFilha;
use Classes\ModelosDePaginas\PaginaEnquete\PaginaEnquete;

global $post;

// $page_ID_filha veio do loop-front-page ou do modelo-com-pagina-filha.php
$descobrirSePaginaFilha = new PaginaFilha($post, $page_ID_filha);
$retornoSePaginaFilha = $descobrirSePaginaFilha->getRetornoSePaginaFilha();

$modelo_de_pagina = new PaginaEnquete();

if (!$retornoSePaginaFilha) {
	get_footer();
}


