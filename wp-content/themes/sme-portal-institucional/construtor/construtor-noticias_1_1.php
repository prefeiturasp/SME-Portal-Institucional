<div class="container">
    <div  id="noticias_fx" class="row overflow-auto aaa">
        <?php query_posts(array(
            'cat' => get_sub_field('fx_noticias_1_1'),
            'post_per_page' => -1
        )); ?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php
                // Obtém a editoria atribuída ao post
                $editorias = get_the_terms(get_the_ID(), 'editoria');

                if (!empty($editorias) && !is_wp_error($editorias)) {
                    // Como só pode ter uma, pegamos a primeira
                    $editoria = $editorias[0];
                
                    // Pega a cor do ACF (campo "cor")
                    $cor_editoria = get_field('cor', 'editoria_' . $editoria->term_id);                        
                }
            ?>
            <div class="col-sm-4 text-center">
                <?php
                    $thumbs = get_thumb(get_the_id(), 'default-image'); 
                ?>
                <img src="<?php echo $thumbs[0]; ?>" width="100%" alt="<?php echo $thumbs[1]; ?>">
                <?php if($cor_editoria): ?>
                    <p><a href="<?php echo get_permalink(); ?>" style="color:<?php echo $cor_editoria; ?>;"><h3><?php the_title(); ?></h3></a></p>
                <?php else: ?>
                    <p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
                <?php endif; ?>
            </div>
        <?php endwhile; 
        // reset variaveis
        $editorias = '';
        $cor_editoria = '';
        
        endif; ?>
        <?php wp_reset_query(); ?>
    </div>
</div>