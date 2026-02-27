<?php
$conselho = get_sub_field('select_conselho');

$new_query = new \WP_Query( array(
    'post_type' => $conselho,
	'posts_per_page' => 1,
	'paged' => $paged,
) );

//echo "<pre>";
//print_r($new_query);
//echo "</pre>";

while ( $new_query->have_posts() ) : $new_query->the_post();  

?>
	
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <h2 class="mb-4"><?= get_the_title() ?></h2>
                <p class="mb-4"><?= the_content() ?></p>

                <!--AGENDA JANEIRO-->
                <?php
                if( have_rows('agenda_janeiro') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Janeiro</h3></strong>';
                endif;
                ?>
                <?php
                    $i = 0;
                    if( have_rows('agenda_janeiro') ):
                        while ( have_rows('agenda_janeiro') ) : the_row();
                            if(get_sub_field('texto_aviso') != ''){
                                $texto = get_sub_field('texto_aviso');
                                echo '<p>' . $texto . '</p>';
                            } else {
                                if($i > 0){
                                    echo '<br>';
                                }
                                $i++;
                            ?>                                    
                                <span class="datahr-agenda">
                                    <strong>
                                        <?php 
                                            the_sub_field('data-agconselho'); 
                                            $inicio = get_sub_field('inicio-agconselho');
                                            $final = get_sub_field('final-agconselho');

                                            if($inicio){
                                                echo ' - ' . str_replace('h00', 'h', $inicio);
                                            }
                                            if($final && $inicio){
                                                echo ' às ' . str_replace('h00', 'h', $final);
                                            }
                                        ?>
                                    </strong>
                                </span><br>
                                <div class="infos-evento">
                                    <?php 
                                        $pauta = get_sub_field('pauta-agconselho');
                                        $local = get_sub_field('local-agconselho');
                                        $links = get_sub_field('links_adicionais');

                                        echo "<div class='pauta-assunto'>";
                                            echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                        echo "</div>";

                                        echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                        if($links){                                        
                                            foreach($links as $link){
                                                echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                            }
                                        }
                                    ?>
                                </div>                             
                            <?php
                            }
                        endwhile;
                    endif;
                ?>

                <!--AGENDA JANEIRO-->
                
                <!--AGENDA FEVEREIRO-->
                <?php
                if( have_rows('agenda_fevereiro') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Fevereiro</h3></strong>';
                endif;
                ?>
                <?php
                    $i = 0;
                    if( have_rows('agenda_fevereiro') ):
                        while ( have_rows('agenda_fevereiro') ) : the_row();
                            if(get_sub_field('texto_aviso') != ''){
                                $texto = get_sub_field('texto_aviso');
                                echo '<p>' . $texto . '</p>';
                            } else {
                                if($i > 0){
                                    echo '<br>';
                                }
                                $i++;
                            ?>                                    
                                <span class="datahr-agenda">
                                    <strong>
                                        <?php 
                                            the_sub_field('data-agconselho'); 
                                            $inicio = get_sub_field('inicio-agconselho');
                                            $final = get_sub_field('final-agconselho');

                                            if($inicio){
                                                echo ' - ' . str_replace('h00', 'h', $inicio);
                                            }
                                            if($final && $inicio){
                                                echo ' às ' . str_replace('h00', 'h', $final);
                                            }
                                        ?>
                                    </strong>
                                </span><br>
                                <div class="infos-evento">
                                    <?php 
                                        $pauta = get_sub_field('pauta-agconselho');
                                        $local = get_sub_field('local-agconselho');
                                        $links = get_sub_field('links_adicionais');

                                        echo "<div class='pauta-assunto'>";
                                            echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                        echo "</div>";

                                        echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                        if($links){                                        
                                            foreach($links as $link){
                                                echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                            }
                                        }
                                    ?>
                                </div>                                                        
                            <?php
                            }
                        endwhile;
                    endif;
                ?>
                <!--AGENDA FEVEREIRO-->
                
                <!--AGENDA MARCO-->
                <?php
                if( have_rows('agenda_marco') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Março</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_marco') ):
                    while ( have_rows('agenda_marco') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>
                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>                          
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA MARCO-->
                
                <!--AGENDA ABRIL-->
                <?php
                if( have_rows('agenda_abril') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Abril</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_abril') ):
                    while ( have_rows('agenda_abril') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>
                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA ABRIL-->
                
                <!--AGENDA MAIO-->
                <?php
                if( have_rows('agenda_maio') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Maio</h3></strong>';
                endif;
                ?>
                <?php
                    $i = 0;
                    if( have_rows('agenda_maio') ):
                        while ( have_rows('agenda_maio') ) : the_row();
                            if(get_sub_field('texto_aviso') != ''){
                                $texto = get_sub_field('texto_aviso');
                                echo '<p>' . $texto . '</p>';
                            } else {
                                if($i > 0){
                                    echo '<br>';
                                }
                                $i++;
                            ?>                                    
                                <span class="datahr-agenda">
                                    <strong>
                                        <?php 
                                            the_sub_field('data-agconselho'); 
                                            $inicio = get_sub_field('inicio-agconselho');
                                            $final = get_sub_field('final-agconselho');

                                            if($inicio){
                                                echo ' - ' . str_replace('h00', 'h', $inicio);
                                            }
                                            if($final && $inicio){
                                                echo ' às ' . str_replace('h00', 'h', $final);
                                            }
                                        ?>
                                    </strong>
                                </span><br>
                                <div class="infos-evento">
                                    <?php 
                                        $pauta = get_sub_field('pauta-agconselho');
                                        $local = get_sub_field('local-agconselho');
                                        $links = get_sub_field('links_adicionais');

                                        echo "<div class='pauta-assunto'>";
                                            echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                        echo "</div>";

                                        echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                        if($links){                                        
                                            foreach($links as $link){
                                                echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                            }
                                        }
                                    ?>
                                </div>
                            <?php
                            } 
                        endwhile;
                    endif;
                ?>

                <?php
                    if( have_rows('sem_eventos_maio') ):
                        while ( have_rows('sem_eventos_maio') ) : the_row();
                            if(get_sub_field('texto_aviso') != ''){
                                $texto = get_sub_field('texto_aviso');
                                echo '<p>' . $texto . '</p>';
                            }

                        endwhile;
                    endif;
                ?>

                <!--AGENDA MAIO-->
                
                <!--AGENDA JUNHO-->
                <?php
                if( have_rows('agenda_junho') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Junho</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_junho') ):
                    while ( have_rows('agenda_junho') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>

                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA JUNHO-->
                
                <!--AGENDA JULHO-->
                <?php
                if( have_rows('agenda_julho') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Julho</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_julho') ):
                    while ( have_rows('agenda_julho') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>
                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>                    
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA JULHO-->
                
                <!--AGENDA AGOSTO-->
                <?php
                if( have_rows('agenda_agosto') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Agosto</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_agosto') ):
                    while ( have_rows('agenda_agosto') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>
                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA AGOSTO-->
                
                <!--AGENDA SETEMBRO-->
                <?php
                if( have_rows('agenda_setembro') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Setembro</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_setembro') ):
                    while ( have_rows('agenda_setembro') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>
                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>               
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA SETEMBRO-->
                
                <!--AGENDA OUTUBRO-->
                <?php
                if( have_rows('agenda_outubro') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Outubro</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_outubro') ):
                    while ( have_rows('agenda_outubro') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>
                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>                
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA OUTUBRO-->
                
                <!--AGENDA NOVEMBRO-->
                <?php
                if( have_rows('agenda_novembro') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Novembro</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_novembro') ):
                    while ( have_rows('agenda_novembro') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>
                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>          
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA NOVEMBRO-->
                
                <!--AGENDA DEZEMBRO-->
                <?php
                if( have_rows('agenda_dezembro') ):
                    echo '<hr>';
                    echo '<strong><h3 class="titulo-agenda">Agenda Dezembro</h3></strong>';
                endif;
                ?>
                <?php
                $i = 0;
                if( have_rows('agenda_dezembro') ):
                    while ( have_rows('agenda_dezembro') ) : the_row();
                        if(get_sub_field('texto_aviso') != ''){
                            $texto = get_sub_field('texto_aviso');
                            echo '<p>' . $texto . '</p>';
                        } else {
                            if($i > 0){
                                echo '<br>';
                            }
                            $i++;
                        ?>                                    
                            <span class="datahr-agenda">
                                <strong>
                                    <?php 
                                        the_sub_field('data-agconselho'); 
                                        $inicio = get_sub_field('inicio-agconselho');
                                        $final = get_sub_field('final-agconselho');

                                        if($inicio){
                                            echo ' - ' . str_replace('h00', 'h', $inicio);
                                        }
                                        if($final && $inicio){
                                            echo ' às ' . str_replace('h00', 'h', $final);
                                        }
                                    ?>
                                </strong>
                            </span><br>
                            <div class="infos-evento">
                                <?php 
                                    $pauta = get_sub_field('pauta-agconselho');
                                    $local = get_sub_field('local-agconselho');
                                    $links = get_sub_field('links_adicionais');

                                    echo "<div class='pauta-assunto'>";
                                        echo $pauta ? '<strong>Pauta/Assunto: </strong> ' . $pauta . '' : '';
                                    echo "</div>";

                                    echo $local ? '<strong>Local:</strong> ' . $local . '<br>' : '';

                                    if($links){                                        
                                        foreach($links as $link){
                                            echo '<a href="'.$link['link'].'">'.$link['legenda'].'</a><br>';
                                        }
                                    }
                                ?>
                            </div>            
                        <?php
                        }
                    endwhile;
                endif;
                ?>
                <!--AGENDA DEZEMBRO-->
                
            </div>
        </div>
    </div>
<?php endwhile; ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="paginacao-atual">
                    <h3 class="text-center">Anos Anteriores</h3>
                    <?php
                        echo paginate_links( array(
                            'format'    => 'page/%#%',
                            'current' 	=> $paged,
                            'total'   	=> $new_query->max_num_pages,
                            'end_size'  => 3,
                            'mid_size'  => 3,
                            'show_all' => false,
                            'prev_next' => false,
                        ) );
                    ?>
                </div>
            </div>
        </div>
    </div>
		
	<?php
		 
wp_reset_postdata();