<?php
//conteudo flexivel Botão
if( have_rows('fx_botao_3_3') ):
    echo '<div class="row">';
        while ( have_rows('fx_botao_3_3') ) : the_row();
            if( get_row_layout() == 'fx_cl1_botao_3_3' ):
                    //loop de botões responsivos
                    echo '<div class="col-sm-12">';
                        echo '<a href="'.get_sub_field('fx_url_botao_3_3').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_3_3').'</button></a>';
                    echo '</div>';
            endif;
        endwhile;
    echo '</div>';
else :
endif;