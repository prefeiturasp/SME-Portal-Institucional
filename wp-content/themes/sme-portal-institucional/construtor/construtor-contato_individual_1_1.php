<?php

if(get_sub_field('contatos_individuais'))://repeater

    while(has_sub_field('contatos_individuais'))://verifica conteudo no repeater
    
    
        echo "<div class='col-sm-12 contacts-list p-0'>";

            // Contato principal	
            $lista_contatos = get_sub_field('lista_contatos');

            foreach($lista_contatos as $contato){													

                echo "<div class='col-sm-12 mb-3 p-0'>";

                    echo '<h3>' . get_the_title($contato) . '</h3>';

                    // pega os campos de cada contato
                    $rows = get_field('campos_contato', $contato);
                    
                    if( $rows ) {
                        
                        foreach( $rows as $row ) {
                            // verifica se os campos estao vazios
                            if( $row['nome_campo'] && $row['nome_campo'] != '' && $row['informacao_campo'] && $row['informacao_campo'] != ''){
                                
                                // verifica o tipo do campos
                                if($row['tipo_de_campo'] == 'telefone'){
                                    
                                    $telefone = $row['informacao_campo']; // pega o campo telefone
                                    $telefone = preg_replace('/[^A-Za-z0-9\-]/', '', $telefone); // remove os caracteres especiais
                                    $telefone = str_replace('-', '', $telefone); // troca o - por vazio

                                    echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='tel:" . $telefone ."'>" . $row['informacao_campo'] . "</a></p>";
                                } elseif($row['tipo_de_campo'] == 'email'){

                                    echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='mailto:" . $row['informacao_campo'] ."'>" . $row['informacao_campo'] . "</a></p>";
                                
                                } elseif($row['tipo_de_campo'] == 'url'){

                                    echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='" . $row['informacao_campo'] ."'>" . $row['informacao_campo'] . "</a></p>";
                                
                                } else {
                                    echo "<p class='mb-0'>" . $row['nome_campo'] . ": " . $row['informacao_campo'] . "</p>";
                                }
                            }
                            
                        }
                        
                    }

                echo "</div>";

            }


            echo "<hr>";

        echo "</div>";

        //echo get_sub_field('contato_principal') . "<br>";
        //echo get_sub_field('contato_secundario') . "<br>";

        
    endwhile;

endif; // contatos_individuais