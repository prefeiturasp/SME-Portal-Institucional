<?php

if(get_sub_field('fx_sanfona_1_1'))://repeater
    //loop sanfona
    echo '<div id="accordion">';
        $count=mt_rand(1,99);
        while(has_sub_field('fx_sanfona_1_1'))://verifica conteudo no repeater
            $count++;
            //echo $count;
              echo '<div class="card sanfona">';
                echo '<div class="card-header">';
                  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse'.$count.'">';
                    echo '<strong>'.get_sub_field('fx_nome_sanfona_1_1').'</strong>';
                  echo '</a>';
                echo '</div>';
                echo '<div id="collapse'.$count.'" class="collapse" data-parent="#accordion">';
                  echo '<div class="card-body">';
                    echo get_sub_field('fx_editor_sanfona_1_1');
                  echo '</div>';
                echo '</div>';
              echo '</div>';
        endwhile;
    echo '</div>';		
endif;