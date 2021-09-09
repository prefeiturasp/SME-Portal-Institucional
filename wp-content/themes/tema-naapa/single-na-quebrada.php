<?php
use Classes\TemplateHierarchy\LoopQuebrada\LoopQuebrada;
get_header();
setPostViews(get_the_ID());
$loop_single = new LoopQuebrada();
//contabiliza visualizações de noticias
 /*echo getPostViews(get_the_ID());*/
get_footer();
?>
