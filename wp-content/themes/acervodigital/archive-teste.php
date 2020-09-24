<?php
// Protect against arbitrary paged values
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
 
$args = array(
    'post_type' => 'acervo',
    'post_status'=>'publish',
    'posts_per_page' => 2,
    'paged' => $paged,
);
 
$the_query = new WP_Query($args);
?>
 
<?php if ( $the_query->have_posts() ) : ?>
     
    <?php while ( $the_query->have_posts() ) : $the_query->the_post();
        // Post content goes here...
    endwhile; ?>
 
    <div class="pagination">
        <?php
        echo paginate_links( array(
            'format'  => 'page/%#%',
            'current' => $paged,
            'total'   => $the_query->max_num_pages,
            'mid_size'        => 2,
            'prev_text'       => __('&laquo; Prev Page'),
            'next_text'       => __('Next Page &raquo;')
        ) );
        ?>
    </div>
     
<?php endif; ?>