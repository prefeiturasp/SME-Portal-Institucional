<?php

$blocoTitulo = get_sub_field('fx_cl1_bloco_noticias_titulo');
$blocoColunas = get_sub_field('fx_cl1_bloco_noticias_colunas');
$blocoNoticias = get_sub_field('fx_cl1_bloco_noticias_selecione_noticias');
$link_botao = get_sub_field('link_botao');
$texto_botao = get_sub_field('texto_botao');

echo '<section class="container lista-noticias my-4">';
    echo '<div class="row">';
        echo '<div class="col-sm-12 lista-noticias-titulo">';
            echo '<p>' . $blocoTitulo . '</p>';
        echo '</div>';

        if($blocoNoticias) :

            foreach($blocoNoticias as $noticia):
                
                // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                $thumbs = get_thumb($noticia);

                // Obtém a editoria atribuída ao post
                $editorias = get_the_terms($noticia, 'editoria');

                if (!empty($editorias) && !is_wp_error($editorias)) {
                    // Como só pode ter uma, pegamos a primeira
                    $editoria = $editorias[0];
                
                    // Pega a cor do ACF (campo "cor")
                    $cor_editoria = get_field('cor', 'editoria_' . $editoria->term_id);                        
                }
        
            ?>
                <div class="col-sm-12 col-md-6 col-lg-<?php echo $blocoColunas; ?> lista-noticia">
                    <a href="<?php echo get_the_permalink($noticia); ?>">
                        <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
                        <?php $titulo_noticia = get_field( 'titulo_destaque', $noticia ) ?: get_the_title( $noticia ); ?>
                        <?php if($cor_editoria): ?>
                            <p style="color:<?php echo $cor_editoria; ?>;"><?php echo esc_html( $titulo_noticia ); ?></p>
                        <?php else: ?>
                            <p><?php echo esc_html( $titulo_noticia ); ?></p>
                        <?php endif; ?>
                    </a>
                </div>

            <?php
            // reset variaveis
            $editorias = '';
            $cor_editoria = '';
            
            endforeach;
        
        endif;

        if($link_botao && $texto_botao):
            echo '<div class="col-sm-12 text-center mt-3">';
                echo '<a href="' . $link_botao . '" class="btn-bloco-noticias">' . $texto_botao . '</a>';
            echo '</div>';
        endif;

    echo '</div>';
echo '</section>';