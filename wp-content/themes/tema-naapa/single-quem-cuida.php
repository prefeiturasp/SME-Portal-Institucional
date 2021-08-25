<?php
use Classes\TemplateHierarchy\LoopCuida\LoopCuida;
get_header();
setPostViews(get_the_ID());
$loop_single = new LoopCuida();
//contabiliza visualizações de noticias
 /*echo getPostViews(get_the_ID());*/
get_footer();
?>
