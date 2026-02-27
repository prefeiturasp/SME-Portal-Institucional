<?php

$titulo = get_sub_field('titulo');
$texto_outros = get_sub_field('texto_outros');
$link_outros = get_sub_field('link_outros');
$tipo_cont = get_sub_field('tipo_cont');
?>

<div class="titulo-bloco-dest pt-3 pb-3 mb-3">
    <div class="row">
        <div class="col-12 col-md-9">
            <h2 class="mb-0"><?= $titulo; ?></h2> 
        </div>
        <?php if($texto_outros || $link_outros):?>
            <div class="col-12 col-md-3 link-dest text-right">
                <a href="<?= $link_outros; ?>" class="no-external"><?= $texto_outros; ?></a>  
            </div>
        <?php endif; ?>
    </div>
   
</div>

<?php if($tipo_cont): ?>

    <?php
        $titulo = get_sub_field('titulo_manual');
        $descricao = get_sub_field('descri_manual');
        $imagem = get_sub_field('imagem_manual');
        $texto = get_sub_field('texto_link_manual');
        $link = get_sub_field('link_manual');
    ?>

    <div class="row mb-4 bloco-dest">
        <div class="col">
            <?php if($imagem): ?>
                <?php if($link): ?>
                    <a href="<?= $link; ?>" class="no-external">
                        <img src="<?= $imagem['sizes']['default-image']; ?>" alt="<?= $imagem['alt']; ?>" class="img-fluid">
                    </a>
                <?php else: ?>
                    <img src="<?= $imagem['sizes']['default-image']; ?>" alt="<?= $imagem['alt']; ?>" class="img-fluid">
                <?php endif; ?>
            <?php endif?>
        </div>
        <div class="col">
            <div class="titulo">
                <?php if($link): ?>
                    <a href="<?= $link; ?>" class="no-external"><?= $titulo; ?></a>
                <?php else: ?>
                    <?= $titulo; ?>
                <?php endif; ?>
            </div>
            <div class="descricao">
                <?= $descricao; ?>
            </div>
            <?php if($texto && $link): ?>
                <a href="<?= $link; ?>"><?= $texto; ?></a>
            <?php endif; ?>
        </div>
    </div>

<?php else: ?>
    <?php
        $noticia = get_sub_field('noticia');

        //echo "<pre>";
        //print_r($noticia);
        //echo "</pre>";

    ?>
    <div class="row mb-4 bloco-dest">
        <div class="col-12 col-md">
            <?php
                // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                $thumbs = get_thumb($noticia->ID, 'default-image');
            ?>
            <a href="<?= get_the_permalink($noticia->ID); ?>" class="no-external">
                <img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid">
            </a>
        </div>
        <div class="col-12 col-md">
            <div class="titulo">
                <a href="<?= get_the_permalink($noticia->ID); ?>" class="no-external">
                    <?php
                    $titulo_noticia = get_field( 'titulo_destaque', $noticia->ID ) ?: $noticia->post_title; 
                    echo esc_html( $titulo_noticia );
                    ?>
                </a>
            </div>
            <div class="descricao">
                <a href="<?= get_the_permalink($noticia->ID); ?>" class="no-external">
                    <?= get_field('insira_o_subtitulo', $noticia->ID); ?>
                </a>
            </div>
        </div>
    </div>
    
<?php endif; ?>