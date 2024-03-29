<?php
//conteudo flexivel Botão
if( have_rows('fx_botao_2_4') ):
    echo '<div class="row">';
        while ( have_rows('fx_botao_2_4') ) : the_row();
            // Responsivo
            if( get_row_layout() == 'fx_cl1_botao_2_4' ):
                //loop de botões responsivos
                echo '<div class="col-12 text-center">';
                    echo '<a href="'.get_sub_field('fx_url_botao_2_4').'"><button type="button" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg">'.get_sub_field('fx_nome_botao_2_4').'</button></a>';
                echo '</div>';
            endif;

            // Bloco
            if( get_row_layout() == 'fx_cl1_botao_bloco_2_4' ):
                //loop de botões responsivos
                echo '<div class="col-12 text-center">';
                    echo '<a href="'.get_sub_field('fx_url_botao_2_4').'"><button type="button" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_2_4').'</button></a>';
                echo '</div>';
            endif;

            // Fixo
            if( get_row_layout() == 'fx_cl1_botao_fixo_2_4' ):
                //loop de botões responsivos
                echo '<div class="col-12 text-center">';
                    echo '<a href="'.get_sub_field('fx_url_botao_2_4').'"><button type="button" class="btn mb-3 bt_fx btn-'.$colorbtn['value'].' btn-lg" style="width: ' . get_sub_field('fx_tamanho_botao_2_4') . 'px;">'.get_sub_field('fx_nome_botao_2_4').'</button></a>';
                echo '</div>';
            endif;
        endwhile;
    echo '</div>';
else :
endif;	