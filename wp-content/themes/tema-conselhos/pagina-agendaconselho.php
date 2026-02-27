<?php
/*
 * Template Name: Página Agenda Conselho
 * Description: Página Agenda Conselho, página que exibe conteudo escolhido
 */

use Classes\ModelosDePaginas\AgendaConselho\PaginaAgendaConselho;

get_header();

$pagina_agendaconselho = new PaginaAgendaConselho();

get_footer();



