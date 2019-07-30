<?php
use Classes\BuscaDeEscolas\BuscaDeEscolas;

get_header();

$modelo_de_pagina = new BuscaDeEscolas();
$modelo_de_pagina->buscaEscola();

get_footer();