<?php 
    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    $validade = 'unidade';
    $url = get_home_url() . "/conteudo-em-manutencao";

    if (strpos($actual_link, $validade) !== false) {
        wp_redirect( $url );
        exit;
    } 
?>
<?php get_header() ?>
<section class="container fundo-branco">
    <?php
    get_template_part('loop', '404');
    ?>
</section>
<?php get_footer() ?>
