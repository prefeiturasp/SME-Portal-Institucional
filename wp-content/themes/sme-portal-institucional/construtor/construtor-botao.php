<?php

$chave = 'fx_botao_' . $args['key'];
$texto = 'fx_nome_botao_' . $args['key'];
$url = 'fx_url_botao_' . $args['key'];
$tamanho = 'fx_tamanho_botao_' . $args['key'];
$responsivo = 'fx_cl1_botao_' . $args['key'];
$bloco = 'fx_cl1_botao_bloco_' . $args['key'];
$fixo = 'fx_cl1_botao_fixo_' . $args['key'];

//conteudo flexivel Botão
if( have_rows($chave) ):
    echo '<div class="row">';
        while ( have_rows($chave) ) : the_row();

            // Responsivo
            if( get_row_layout() == $responsivo ):
                //loop de botões responsivos
                $align = get_sub_field('alinhamento');
                $icone = get_sub_field('icone');
                echo '<div class="col-12 align-' . $align .'">';
                    if($icone){                        
                        echo '<a href="'.get_sub_field($url).'"><button type="button" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg"><img src="' . $icone . '"> '. get_sub_field($texto).'</button></a>';
                    } else {
                        echo '<a href="'.get_sub_field($url).'"><button type="button" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg">'.get_sub_field($texto).'</button></a>';
                    }                    
                echo '</div>';
            endif;

            // Bloco
            if( get_row_layout() == $bloco ):
                //loop de botões bloco
                $icone = get_sub_field('icone');
                $estilo = get_sub_field('estilo');
                echo '<div class="col-12 text-center">';
                    if($icone){                        
                        echo '<a href="'.get_sub_field($url).'" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block no-external btn-' . $estilo . '"><img src="' . $icone . '"> '. get_sub_field($texto).'</a>';
                    } else {
                        echo '<a href="'.get_sub_field($url).'" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block no-external btn-' . $estilo . '">'.get_sub_field($texto).'</a>';
                    }
                
                echo '</div>';
            endif;

            // Fixo
            if( get_row_layout() == $fixo ):
                //loop de botões fixo
                $align = get_sub_field('alinhamento');
                $icone = get_sub_field('icone');
                echo '<div class="col-12 align-' . $align .'">';
                    if($icone){                        
                        echo '<a href="'.get_sub_field($url).'"><button type="button" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg" style="width: ' . get_sub_field($tamanho) . 'px;"><img src="' . $icone . '"> '. get_sub_field($texto).'</button></a>';
                    } else {
                        echo '<a href="'.get_sub_field($url).'"><button type="button" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg" style="width: ' . get_sub_field($tamanho) . 'px;">'.get_sub_field($texto).'</button></a>';
                    }
                echo '</div>';
            endif;

        endwhile;
    echo '</div>';
else :
endif;