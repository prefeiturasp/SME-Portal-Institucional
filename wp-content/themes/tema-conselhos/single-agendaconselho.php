<?php
use Classes\TemplateHierarchy\LoopAgenda\LoopAgenda;
get_header();

$loop_single = new LoopAgenda();
//contabiliza visualizações de noticias
setPostViews(get_the_ID()); /*echo getPostViews(get_the_ID());*/
get_footer();