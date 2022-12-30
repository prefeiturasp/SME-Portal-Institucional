<div class="bg-bloco-parceiros mt-5">
    <div class="container pt-5 pb-5">
        <div class="row">
            <h2 class="col-12 title-bloc-parceiros mt-3 mb-3 text-center">Parceiros do projeto</h2>
        </div>
        <div class="row">
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
                'posts_per_page' => -1,
                'post_type'      => 'parceiros',
                'orderby' => 'date',
                'order' => 'ASC',
            ) );
            $count_parceiros = 0;
            while ( $new_query->have_posts() ) : $new_query->the_post();
                ?>
                <div class="col-6 col-md-4 col-lg-2 mt-4 mb-4">
                    <a href="<?= get_the_permalink(); ?>"><img src="<?php the_field('foto_principal_parceiro') ?>" alt="<?php the_title(); ?>"  width="176" height="56">
                </div>
                <?php
                $count_parceiros++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>