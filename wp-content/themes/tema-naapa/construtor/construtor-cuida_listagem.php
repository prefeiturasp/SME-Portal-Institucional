<div class="container">

    <div class="row px-0">
        <div class="cuida-filters">
            <p>filtrar por:</p>
            <div class="filter-list">
                <?php
                    $terms = get_terms( array(
                        'taxonomy' => 'categoria-cuida',
                        'hide_empty' => true,
                    ) );

                    if($_GET['filter'] && $_GET['filter'] != ''){
                        $active = $_GET['filter'];
                    }

                    $current = get_the_permalink(get_the_ID());
                    foreach($terms as $term):
                        if($active == $term->term_id):
                        ?>        
                            <a href="<?php echo $current;?>" class="filter-link filter-active"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $term->name; ?></a>                       
                        
                        <?php else: ?>
                            <a href="<?php echo $current . '?filter=' . $term->term_id;?>" class="filter-link"><?php echo $term->name; ?></a> 
                        <?php
                        endif;
                    endforeach; ?>

            </div>
        </div>
    </div>    

    <div id="ajax-posts" class="row">
        <?php
            $postsPerPage = get_sub_field('quantidade');
            $args = array(
                'post_type' => 'quem-cuida',
                'posts_per_page' => $postsPerPage,                
            );

            if($_GET['filter'] && $_GET['filter'] ){
                $args['tax_query'][] = array(
                        'taxonomy' => 'categoria-cuida',   // taxonomy name
                        'field' => 'term_id',           // term_id, slug or name
                        'terms' => $_GET['filter'],                  // term id, term slug or term name
                );									
            }
            
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
                        $categories = get_the_terms(get_the_ID(), 'categoria-cuida');
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