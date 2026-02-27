<?php

$noticiasDest = get_sub_field('fx_fl1_noticias');

if($noticiasDest): // repetidor
    ?>
        
        
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <?php if($noticiasDest[0] != ''):
                        // Obtém a editoria atribuída ao post
                        $editorias = get_the_terms($noticiasDest[0], 'editoria');

                        if (!empty($editorias) && !is_wp_error($editorias)) {
                            // Como só pode ter uma, pegamos a primeira
                            $editoria = $editorias[0];
                        
                            // Pega a cor do ACF (campo "cor")
                            $cor_editoria = get_field('cor', 'editoria_' . $editoria->term_id);                        
                        }                      
                    ?>
                        <div class="news-dest dest-one dest-two">
                            <a href="<?php echo get_the_permalink($noticiasDest[0]); ?>">
                                <?php
                                    // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                    $thumbs = get_thumb($noticiasDest[0], 'default-image');
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <?php
                                        $titulo = get_field('titulo_destaque', $noticiasDest[0]);
                                        if($titulo == ''){
                                            $titulo = get_the_title($noticiasDest[0]);
                                        }
                                    ?>
                                    <?php if($cor_editoria): ?>
                                        <p style="color:<?php echo $cor_editoria; ?>;"><?php echo $titulo; ?></p>
                                    <?php else: ?>
                                        <p><?php echo $titulo; ?></p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        
                    <?php 
                    $cor_editoria = '';
                    endif; ?>
                </div>
                <div class="col-sm-12 col-md-4">
                    
                    <?php if($noticiasDest[1] != ''): 
                        // Obtém a editoria atribuída ao post
                        $editorias = get_the_terms($noticiasDest[1], 'editoria');

                        if (!empty($editorias) && !is_wp_error($editorias)) {
                            // Como só pode ter uma, pegamos a primeira
                            $editoria = $editorias[0];
                        
                            // Pega a cor do ACF (campo "cor")
                            $cor_editoria = get_field('cor', 'editoria_' . $editoria->term_id);                        
                        }
                    ?>
                        
                        <div class="news-dest dest-two">
                            <a href="<?php echo get_the_permalink($noticiasDest[1]); ?>">
                            <?php
                                    // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                    $thumbs = get_thumb($noticiasDest[1], 'destaque-small');
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <?php
                                        $titulo = get_field('titulo_destaque', $noticiasDest[1]);
                                        if($titulo == ''){
                                            $titulo = get_the_title($noticiasDest[1]);
                                        }
                                    ?>
                                    <?php if($cor_editoria): ?>
                                        <p style="color:<?php echo $cor_editoria; ?>;"><?php echo $titulo; ?></p>
                                    <?php else: ?>
                                        <p><?php echo $titulo; ?></p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        
                    <?php 
                        $cor_editoria = '';
                        endif; ?>

                    <?php if($noticiasDest[2] != ''): 
                    
                        // Obtém a editoria atribuída ao post
                        $editorias = get_the_terms($noticiasDest[2], 'editoria');

                        if (!empty($editorias) && !is_wp_error($editorias)) {
                            // Como só pode ter uma, pegamos a primeira
                            $editoria = $editorias[0];
                        
                            // Pega a cor do ACF (campo "cor")
                            $cor_editoria = get_field('cor', 'editoria_' . $editoria->term_id);                        
                        }
                    
                    ?>
                        
                        <div class="news-dest dest-three">
                            <a href="<?php echo get_the_permalink($noticiasDest[2]); ?>">
                            <?php
                                    // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                    $thumbs = get_thumb($noticiasDest[2], 'destaque-small');
                                ?>
                                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                                <div class="dest-title">
                                    <?php
                                        $titulo = get_field('titulo_destaque', $noticiasDest[2]);
                                        if($titulo == ''){
                                            $titulo = get_the_title($noticiasDest[2]);
                                        }
                                    ?>
                                    <?php if($cor_editoria): ?>
                                        <p style="color:<?php echo $cor_editoria; ?>;"><?php echo $titulo; ?></p>
                                    <?php else: ?>
                                        <p><?php echo $titulo; ?></p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        
                    <?php 
                        $cor_editoria = '';
                        endif; 
                    ?>

                </div>
                
            </div>
       

    <?php 
endif;