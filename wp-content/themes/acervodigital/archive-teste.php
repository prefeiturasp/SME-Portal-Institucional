
<main class="mt-5 mb-5">
    <section>
        <div class="container"> 
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="mt-3 mb-3">Últimos documentos adicionados</h2>
                </div>
                <?php
                $loop = new WP_Query( array(
                    'post_type' => array(
                        'acervo',
                    ),
                    'taxonomy'   => 'acervo',
                    'order' => 'ASC',
                    'posts_per_page' => -1
                  )
                );
                ?>
                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                <?php
                                $file = get_field('arquivo_acervo_digital');
                                $stringSeparada = explode(".", $file['filename']);
                                $type = get_post_type();

                                ?>
                                <div class="col-sm-6 mb-3 ">
                                    <div class="row acervo-display">
                                        <div style="
                                                    background-image: url(<?php
                                                      if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'pdf'){
                                                         echo $file['icon']; 
                                                      }else if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'xlsx'){
                                                         echo $file['icon'];
                                                      }else if(get_field('substituir_capa_acervo_digital') != ''){
                                                         echo get_field('substituir_capa_acervo_digital'); 
                                                      }else{
                                                         echo $file['url'];
                                                      }
                                                      ?>);
                                                    " class="col-sm-4 flag">
                                            <span class="flag-pdf">
                                                <?php
                                                echo $stringSeparada[1]; 
                                                ?>
                                            </span>
                                        </div>
                                        <div class="col-sm-8 mt-3 mb-3">
                                            <h3 class="azul-claro-acervo"><strong><?php the_title(); ?></strong></h3>
                                            <div class="cat-flag mb-3"><?php echo $type; ?></div>
                                            <p><?php get_field('descricao_acervo'); ?></p>
                                            <p><strong>Última atualização:</strong> <?php the_time('d/m/Y' );?></p>
                                            <p><strong>Palavras chaves: </strong>               
                                                <?php the_tags( '<span class="custom-tags">', '', '<span>' );?>
                                            </p>
                                            <div class="links-flag">
                                                <a href="<?php the_permalink(); ?>">Visualizar</a>
                                                <a href="<?php the_permalink(); ?>">Ver detalhes</a>
                                                <a href="<?php echo $file['url'] ?>">Fazer download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <?php
                    if( have_rows('arquivos_do_repositorio') ):

                        while ( have_rows('arquivos_do_repositorio') ) : the_row();

                            if( get_row_layout() == 'adiciona_acervo_digital' ):

                                $file = get_sub_field('arquivo_acervo_digital');
                                $stringSeparada = explode(".", $file['filename']);
                                $type = get_post_type();

                                ?>
                                <div class="col-sm-6 mb-3 ">
                                    <div class="row acervo-display">
                                        <div style="
                                                    background-image: url(<?php
                                                      if(get_sub_field('capa_acervo') == '' && $stringSeparada[1] == 'pdf'){
                                                         echo $file['icon']; 
                                                      }else if(get_sub_field('capa_acervo') == '' && $stringSeparada[1] == 'xlsx'){
                                                         echo $file['icon'];
                                                      }else if(get_sub_field('capa_acervo') != ''){
                                                         echo get_sub_field('capa_acervo'); 
                                                      }else{
                                                         echo $file['url'];
                                                      }
                                                      ?>);
                                                    " class="col-sm-4 flag">
                                            <span class="flag-pdf">
                                                <?php
                                                echo $stringSeparada[1]; 
                                                ?>
                                            </span>
                                        </div>
                                        <div class="col-sm-8 mt-3 mb-3">
                                            <h3 class="azul-claro-acervo"><strong><?php the_title(); ?></strong></h3>
                                            <div class="cat-flag mb-3"><?php echo $type; ?></div>
                                            <p><?php get_sub_field('descricao_acervo'); ?></p>
                                            <p><strong>Última atualização:</strong> <?php the_time('d/m/Y' );?></p>
                                            <p><strong>Palavras chaves: </strong>               
                                                <?php the_tags( '<span class="custom-tags">', '', '<span>' );?>
                                            </p>
                                            <div class="links-flag">
                                                <a href="<?php the_permalink(); ?>">Visualizar</a>
                                                <a href="<?php the_permalink(); ?>">Ver detalhes</a>
                                                <a href="<?php echo $file['url'] ?>">Fazer download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endwhile;
                    endif;
                    ?>  
                <?php endwhile; wp_reset_query(); ?>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>