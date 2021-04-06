<div  id="noticias_fx" class="row overflow-auto">
    <?php query_posts(array(
        'cat' => get_sub_field('fx_noticias_1_1'),
        'post_per_page' => -1
    )); ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="col-sm-4 text-center">
            <?php
            $image_id = get_post_thumbnail_id();
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
            ?>
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%" alt="<?php echo $image_alt; ?>">
            <p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
        </div>
    <?php endwhile; endif; ?>
    <?php wp_reset_query(); ?>
</div>