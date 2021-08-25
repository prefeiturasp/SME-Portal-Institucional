<?php

$noticiasDest = get_sub_field('noticias');

if($noticiasDest): // repetidor
    ?>
        
        <div class='container mt-5'>
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <?php if($noticiasDest[0] != ''): ?>
                        <div class="news-dest dest-one dest-two">
                            <a href="<?php echo get_the_permalink($noticiasDest[0]); ?>">
                                <?php
                                    // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                    $thumbs = get_thumb($noticiasDest[0], 'default-image');
                                    $categories = get_the_terms($noticiasDest[0], 'categoria-cuida');
                                    $separator = ' / ';
                                    $output = '';
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <?php
                                        if ( ! empty( $categories ) ) {
                                            foreach( $categories as $category ) {
                                                $output .= '<a class="categ" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                                            }
                                            echo trim( $output, $separator );
                                        }
                                    ?>
                                    <p><a href="<?php echo get_the_permalink($noticiasDest[0]); ?>"><?php echo get_the_title($noticiasDest[0]); ?></a></p>
                                </div>
                            </a>
                        </div>
                        
                    <?php endif; ?>
                </div>
                <div class="col-sm-12 col-md-4">
                    
                    <?php if($noticiasDest[1] != ''): ?>
                        
                        <div class="news-dest dest-two">
                            <a href="<?php echo get_the_permalink($noticiasDest[1]); ?>">
                                <?php
                                    // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                    $thumbs = get_thumb($noticiasDest[1], 'default-image');
                                    $categories = get_the_terms($noticiasDest[1], 'categoria-cuida');
                                    $separator = ' / ';
                                    $output = '';
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <?php
                                        if ( ! empty( $categories ) ) {
                                            foreach( $categories as $category ) {
                                                $output .= '<a class="categ" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                                            }
                                            echo trim( $output, $separator );
                                        }
                                    ?>
                                    <p><a href="<?php echo get_the_permalink($noticiasDest[1]); ?>"><?php echo get_the_title($noticiasDest[1]); ?></a></p>
                                </div>
                            </a>
                        </div>
                        
                    <?php endif; ?>

                    <?php if($noticiasDest[2] != ''): ?>
                        
                        <div class="news-dest dest-three">
                            <a href="<?php echo get_the_permalink($noticiasDest[2]); ?>">
                                <?php
                                    // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                    $thumbs = get_thumb($noticiasDest[2], 'default-image');
                                    $categories = get_the_terms($noticiasDest[2], 'categoria-cuida');
                                    $separator = ' / ';
                                    $output = '';
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <?php
                                        if ( ! empty( $categories ) ) {
                                            foreach( $categories as $category ) {
                                                $output .= '<a class="categ" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                                            }
                                            echo trim( $output, $separator );
                                        }
                                    ?>
                                    <p><a href="<?php echo get_the_permalink($noticiasDest[2]); ?>"><?php echo get_the_title($noticiasDest[2]); ?></a></p>
                                </div>
                            </a>
                        </div>
                        
                    <?php endif; ?>

                </div>
                
            </div>
        </div>

    <?php 
endif;