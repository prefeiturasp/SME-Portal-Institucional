<?php
$idTaxEvento = get_sub_field('escolha_evento');
$term = get_term( $idTaxEvento );
?>
<div class="container mt-5 mb-5">
    <?php
    $arrow_query = new WP_Query( array(
        'posts_per_page' => 10,
        'post_type'      => 'evento',
        'orderby' => 'date',
        'order' => 'ASC',
        'tax_query' => array(
            array (
                'taxonomy' => 'tipo-espaco',
                'field' => 'id',
                'terms' => $idTaxEvento,
            )
        ),
    ) );
    $count_arrow = 0;
    while ( $arrow_query->have_posts() ) : $arrow_query->the_post();
        $count_arrow++;
    endwhile;
    wp_reset_postdata();
    ?>
    <div class="row mt-2 mb-2">
        <div class="carousel-multiple-title col-sm-6">
            <h2 class="title-carousel-eventos"><?php echo $term->name; ?></h2>
        </div>
        <div class="col-sm-6 text-right">
            <a class="<?php if($count_arrow < 5){ echo 'd-none';} ?>" href="#<?php echo $term->slug; ?>" data-slide="prev">
                <img src="/wp-content/uploads/2022/07/arrow-left.png" alt="esquerda">
            </a>
            <a class="<?php if($count_arrow < 5){ echo 'd-none';} ?>" href="#<?php echo $term->slug; ?>" data-slide="next">
                <img src="/wp-content/uploads/2022/07/arrow-right.png" alt="direita">
            </a>
        </div>
    </div>
    <div class="row mt-2 mb-3">
        <div class="divhr mt-2 mb-2"></div>
    </div>
    <div class="p-3 m-n3 overflow-hidden">
        <div id="<?php echo $term->slug; ?>" class="carousel <?php echo $term->slug; ?> slide carousel-multiple" data-ride="carousel" data-interval="<?php if($count_arrow < 5){ echo 'd-none';}else{echo '99999';} ?>" data-pause="hover"
             data-maximum-items-per-slide="4">
            <div class="row position-relative">
                <div class="row carousel-inner mx-0">
                    <?php
                    if( have_rows('construtor_home') ):
                        while ( have_rows('construtor_home') ) : the_row();
                            if( get_row_layout() == 'adicionar_evento'):
                                echo get_sub_field('carousel_eventos_home').'<br>';
                                echo '<hr>';
                            elseif( get_row_layout() == 'adiconar_newsletter'):
                                echo get_sub_field('titulo').'<br>';
                                echo '<hr>';
                            endif;
                        endwhile;
                    endif;
                    $new_query = new WP_Query( array(
                        'posts_per_page' => 10,
                        'post_type'      => 'evento',
                        'orderby' => 'date',
                        'order' => 'ASC',
                        'tax_query' => array(
                            array (
                                'taxonomy' => 'tipo-espaco',
                                'field' => 'id',
                                'terms' => $idTaxEvento,
                            )
                        ),
                    ) );
                    $count_evento = 0;
                    while ( $new_query->have_posts() ) : $new_query->the_post();
                        ?>
                        <div class="carousel-item col-sm-6 col-md-4 col-lg-3 <?php if($count_evento === 0){echo 'active';} ?>">
                            <div class="content-carousel">
                                <div class="content-carousel-img">
                                    <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="<?php echo the_title(); ?>">
                                </div>
                                <div class="inner-content-carousel">
                                    <div class="data-content-carousel mt-2 mb-2">20,21 - Junho</div>
                                    <div class="title-content-carousel mt-2 mb-2"><?php the_title(); ?></div>
                                    <div class="desc-content-carousel mt-2 mb-2">Shopping Iguatemi, Jardim Paulistano</div>
                                    <div class="pills mt-3 mb-3">
                                    <span class="pill-out pill-green">
                                        <img src="/wp-content/uploads/2022/07/livre.png" alt="Livre">
                                        Livre
                                    </span>
                                    <span class="pill-out">
                                        <img src="/wp-content/uploads/2022/07/teatro.png" alt="Cinemas">
                                        Cinemas
                                    </span>
                                    <span class="pill-out">
                                        <img src="/wp-content/uploads/2022/07/busque-por-parceiro.png" alt="Parceiros">
                                        Parceiro
                                    </span>
                                    </div>
                                    <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                                </div>
                            </div>
                        </div>
                        <?php
                        $count_evento++;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(function () {
        jQuery(".<?php echo $term->slug; ?>").on("slide.bs.carousel", function (e) {
            var itemsPerSlide = parseInt(jQuery(this).attr('data-maximum-items-per-slide')),
                totalItems = jQuery(".carousel-item", this).length,
                reserve = 1,//do not change
                $itemsContainer = jQuery(".carousel-inner", this),
                it = (itemsPerSlide + reserve) - (totalItems - e.to);

            if (it > 0) {
                for (var i = 0; i < it; i++) {
                    jQuery(".carousel-item", this)
                        .eq(e.direction == "left" ? i : 0)
                        // append slides to the end/beginning
                        .appendTo($itemsContainer);
                }
            }
        });
    });
</script>

