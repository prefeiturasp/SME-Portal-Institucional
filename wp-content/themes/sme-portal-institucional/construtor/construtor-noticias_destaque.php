<?php

$noticiasDest = get_sub_field('fx_fl1_noticias');

if($noticiasDest): // repetidor
    ?>
        
        
            <div class="row">
                <div class="col-sm-12">
                    <?php if($noticiasDest[0] != ''): ?>
                        <div class="news-dest dest-one dest-two">
                            <a href="<?php echo get_the_permalink($noticiasDest[0]); ?>">
                                <?php
                                    // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                    $thumbs = get_thumb($noticiasDest[0], 'default-image');
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <p><?php echo get_the_title($noticiasDest[0]); ?></p>
                                </div>
                            </a>
                        </div>
                        
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    
                    <?php if($noticiasDest[1] != ''): ?>
                        
                        <div class="news-dest dest-two">
                            <a href="<?php echo get_the_permalink($noticiasDest[1]); ?>">
                            <?php
                                    // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                    $thumbs = get_thumb($noticiasDest[1], 'default-image');
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <p><?php echo get_the_title($noticiasDest[1]); ?></p>
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
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <p><?php echo get_the_title($noticiasDest[2]); ?></p>
                                </div>
                            </a>
                        </div>
                        
                    <?php endif; ?>

                </div>
                
            </div>
       

    <?php 
endif;