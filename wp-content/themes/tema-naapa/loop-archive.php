<div class="col-12 mt-4 mb-4 p-0"><div class="title-special d-flex align-items-center justify-content-between"><h2 class="text-left tx_fx_#000000" style="color: #000000; border-color: #cf443c">CATEGORIA - <?php echo get_queried_object()->name; ?></h2></div></div>

<div class="row">
    <div class="col-md-8">
        <div class="container mb-5" style="margin-top: 15px;">

            <div id="ajax-posts" class="row">
                <?php
                    $postsPerPage = 10;
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $postsPerPage,                
                    );
                    
                    $args['tax_query'][] = array(
                            'taxonomy' => 'category',   // taxonomy name
                            'field' => 'term_id',           // term_id, slug or name
                            'terms' => get_queried_object()->term_id,                  // term id, term slug or term name
                    );									
                    
                    
                    $loop = new WP_Query($args);

                    while ($loop->have_posts()) : $loop->the_post();
                ?>

                    <div class="row mx-0 cuida-list-item">
                        <div class="col-12 col-md-4">
                            <?php $thumbs = get_thumb(get_the_ID(), 'cuida-news'); ?>
                            <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid"></a>
                        </div>
                        <div class="col-12 col-md-8">
                            <?php
                                $categories = get_the_terms(get_the_ID(), 'category');
                                $separator = ' / ';
                                $output = '';
                            ?>
                            <div class="d-flex justify-content-between cuida-infos">
                                <div class="cuida-categs">
                                    <?php
                                        if ( ! empty( $categories ) ) {
                                            foreach( $categories as $category ) {
                                                $output .= '<a class="cuida-categ" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                                            }
                                            echo trim( $output, $separator );
                                        }
                                    ?>
                                </div>
                                <div class="cuida-date">
                                    <?php echo get_the_date( 'd/m/Y \à\s H\hi' ); ?>
                                </div>
                            </div>
                            <h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <?php
                                $sub = get_field( "insira_o_subtitulo", get_the_ID() );
                                if($sub){
                                    echo "<p>" . $sub . "</p>";
                                } else {
                                    echo "<p>" . get_the_excerpt() . "</p>";
                                }
                            ?>
                        </div>                    
                    </div>

                <?php
                        endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <button id="more_posts">Veja mais</button>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <?php dynamic_sidebar('se-liga'); ?>
    </div>
</div>
