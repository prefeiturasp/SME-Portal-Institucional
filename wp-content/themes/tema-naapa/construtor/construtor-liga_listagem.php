<div class="container">

    <div class="row px-0">
        <div class="cuida-filters d-none d-md-block">
            <p>filtrar por:</p>
            <div class="filter-list liga-filter">
                <?php
                    $terms = get_terms( array(
                        'taxonomy' => 'category',
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
        
        <div class="btn-filter">
            <button type="button" class="btn btn-outline-primary btn-avanc-f btn-avanc btn-avanc-m d-block d-md-none b-0 btn-liga" data-toggle="modal" data-target="#filtroBusca">
                <i class="fa fa-filter" aria-hidden="true"></i> Filtrar 
                <?php if($countBusca > 0): ?>
                    <span class="badge badge-primary"><?php echo $countBusca; ?></span>
                <?php endif; ?>
            </button>
            <?php if($_GET['filter'] && $_GET['filter'] != ''): ?>
                <span class="badge badge-primary">1</span>
            <?php endif; ?>
        </div>
        

        <!-- Modal -->
        <div class="modal right fade filter-liga" id="filtroBusca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <p class="modal-title" id="myModalLabel2">Filtrar por:</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>				
                    </div>

                    <div class="modal-body">

                        <div class="cuida-filters">
                            
                            <div class="filter-list liga-filter">
                                <?php
                                    $terms = get_terms( array(
                                        'taxonomy' => 'category',
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

                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->
    </div>    

    <div id="ajax-posts" class="row">
        <?php
            $postsPerPage = get_sub_field('quantidade');
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $postsPerPage,                
            );

            if($_GET['filter'] && $_GET['filter'] ){
                $args['tax_query'][] = array(
                        'taxonomy' => 'category',   // taxonomy name
                        'field' => 'term_id',           // term_id, slug or name
                        'terms' => $_GET['filter'],                  // term id, term slug or term name
                );									
            }
            
            $loop = new WP_Query($args);

            while ($loop->have_posts()) : $loop->the_post();
        ?>

            <div class="row mx-0 cuida-list-item">
                <div class="col-4">
                    <?php $thumbs = get_thumb(get_the_ID(), 'cuida-news'); ?>
                    <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid"></a>
                </div>
                <div class="col-8">
                    <?php
                        $categories = get_the_terms(get_the_ID(), 'category');
                        $separator = ' / ';
                        $output = '';
                    ?>
                    <div class="d-flex justify-content-between cuida-infos">
                        <div class="cuida-categs liga-categs">
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
    
    <button id="more_posts" class="more-liga">Veja mais</button>
</div>