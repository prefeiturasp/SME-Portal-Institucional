<?php
/*
 * Template Name: Página Agenda do Secretário
 * Description: Página Agenda do Secretário, página que exibe a agenda do Secretário
 */

use Classes\ModelosDePaginas\PaginaAgendaSecretario\PaginaAgendaSecretario;

get_header();

$pagina_agenda_secretario = new PaginaAgendaSecretario();

get_footer();



