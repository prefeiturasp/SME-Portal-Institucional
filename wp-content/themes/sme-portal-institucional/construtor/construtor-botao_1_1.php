<?php

//conteudo flexivel Botão
if( have_rows('fx_botao_1_1') ):
    echo '<div class="row mt-3 mb-3">';
        while ( have_rows('fx_botao_1_1') ) : the_row();
            if( get_row_layout() == 'fx_cl1_botao_1_1' ):
                    //loop de botões responsivos
                    echo '<div class="col">';
                        echo '<a href="'.get_sub_field('fx_url_botao_1_1').'"><button type="button" class="btn bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_1_1').'</button></a>';
                    echo '</div>';
            endif;
        endwhile;
    echo '</div>';
else :
endif;