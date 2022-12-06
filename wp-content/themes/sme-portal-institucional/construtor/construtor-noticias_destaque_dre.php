<section class="container mt-5 noticias">
    <section class="row">
                   
        <?php
            $selecao = get_sub_field('tipo_de_selecao');
            $categorias = get_sub_field('categoria');
            $noticias = get_sub_field('noticias');
            $maisNoticias = get_sub_field('link_mais_noticias');
			
            $args = array(
                'post_type' => 'post',                    
                'posts_per_page' => 3,
            );

            if($selecao){
                $args['post__in'] = $noticias;
            } else {
                $args['cat'] = $categorias;
            }

            $query = new WP_Query( $args );
            $count = 0;
            if ($query->have_posts()) : 

                while ($query->have_posts()) : $query->the_post();
                    if($count == 0):
                ?>
                    <section class="col-lg-6 col-xs-12 mb-xs-4 rounded">
                        <article class="card h-100 rounded border-0">
                            <?php
                                // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                $thumbs = get_thumb($noticiasDest[0], 'default-image');
                            ?>
                            <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="rounded img-fluid">
                            <article class="card-img-overlay bg-home-desc h-auto rounded-bottom container-img-noticias-destaques-primaria">
                                <h3 class="fonte-catorze font-weight-bold">
                                    <a class="text-white" href="<?= get_the_permalink(); ?>">
                                        <?= get_the_title(); ?>
                                    </a>
                                </h3>
                                <section class="card-text text-white fonte-doze"><p class="mb-3 "><?= get_field('insira_o_subtitulo'); ?></p></section>
                            </article>
                        </article>
                    </section>
                <?php else: ?>

                    <?php if($count == 1): ?>
                        <section class="col-lg-6 col-xs-12">
                    <?php endif; ?>
                    
                    <article class="row mb-4 b-home border-bottom">
                        <div class="col-12 col-md-5 mb-1">                            
                            <?php
                                // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                $thumbs = get_thumb($noticiasDest[0], 'default-image');
                            ?>
                            <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid rounded float-left mr-4 img-noticias-destaques-secundarias desc2-img-home">
                        </div>
                        <div class="col-12 col-md-7">
                            <h3 class="fonte-catorze font-weight-bold">
                                <a class="text-dark" href="<?= get_the_permalink(); ?>"><?= get_the_title(); ?></a>
                            </h3>
                            <section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?= get_field('insira_o_subtitulo'); ?></p></span></section>
                        </div>
                    </article>
                <?php
                    endif;
                    $count++;
                endwhile;
                    if($maisNoticias):
                ?>
                     <section class="row">
                        <article class="col-lg-12 col-xs-12 container-btn-mais-noticias">
                            <form>
                                <fieldset>
                                    <legend>Ir para mais notícias</legend>
                                    <a href="<?= $maisNoticias; ?>" class="btn btn-primary btn-sm btn-block bg-azul-escuro font-weight-bold text-white">Mais notícias</a>
                                </fieldset>
                            </form>
                        </article>
                    </section>   
                <?php
                    endif; 
                    echo '</section>';
                    
            else:
                echo '<p class="agenda agenda-new"><strong>Não existem eventos cadastrados nesta data</strong></p>';
            endif;
            wp_reset_postdata();
        ?>
		
    </section>
</section>