<?php
    $titulo = get_sub_field('titulo');
    $qtd = get_sub_field('quantidade');
?>

<div class="container" id="publicacoes">
    <?php if($titulo): ?>
        <div class="quebrada-title"><?php echo $titulo; ?></div>
    <?php endif; ?>

    
    <div class="cuida-filters">
        
        <div class="filter-list">
            <?php
                $terms = get_terms( array(
                    'taxonomy' => 'categoria-quebrada',
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
                        <a href="<?php echo $current . '?filter=' . $term->term_id;?>#publicacoes" class="filter-link"><?php echo $term->name; ?></a> 
                    <?php
                    endif;
                endforeach; ?>

        </div>
    </div>
        
    
    <?php
        
        $args = array(
            'post_type' => 'na-quebrada',
            'posts_per_page' => $qtd,
            'post_status' => 'publish',
        );

        if($_GET['filter'] && $_GET['filter'] ){
            $args['tax_query'][] = array(
                    'taxonomy' => 'categoria-quebrada',   // taxonomy name
                    'field' => 'term_id',           // term_id, slug or name
                    'terms' => $_GET['filter'],                  // term id, term slug or term name
            );									
        }

        // The Query
        $the_query = new WP_Query( $args );
        
        // The Loop
        if ( $the_query->have_posts() ) {
            echo '<div class="all-itens" data-gridify="4-columns">';
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
            ?>
                <div class="item">
                    <div class="item-content">
                        <a href="<?php echo get_the_permalink(); ?>">
                            <img class="img-fluid" src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>">
                        </a>
                        <div class="infos-quebrada d-flex justify-content-between">
                            <div class="quebrada-likes">
                                <?php
                                    global $wpdb;
                                    $postid = get_the_id();                                    
                                    $totalrow1 = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid'");
                                    $total_like = $wpdb->num_rows;
                                ?>
                                <i class="fa fa-heart" aria-hidden="true"></i> <?php echo $total_like == 1 ? $total_like . ' like' : $total_like . ' likes'; ?>
                            </div>
                            <div class="quebrada-date">
                                <?php echo get_the_date( 'd/m/Y \à\s H\hi' ); ?>
                            </div>                    
                        </div>
                        <a href="<?php echo get_the_permalink(); ?>">
                            <div class="item-title"><?php echo get_the_title(); ?></div>
                        </a>
                        <div class="item-autor">
                            <?php 
                                if(get_field('nome')){
                                    echo 'por ' . get_field('nome');
                                } else {
                                    echo 'por Turma do NAAPA';
                                }
                            ?>
                        </div>                
                    </div>            
                </div>

            <?php
            }
            echo '</div>';
        } else {
            // no posts found
        }
        /* Restore original Post Data */
        
        wp_reset_postdata();
        ?>

    <button id="more_quebrada">Veja mais</button>
</div>