<?php
    $cor = get_sub_field('cor');
    $titulo = get_sub_field('titulo');
    $url = get_sub_field('url');
    $conteudo = get_sub_field('conteudo');
?>
<article class="card-header card-header-card text-white font-weight-bold" style="background: <?= $cor; ?> !important">
    <h2 class="fonte-catorze">
        <?php if($url): ?>
            <a class="text-white no-external" href="<?= $url; ?>">
                <?php 
                    if($titulo)
                        echo $titulo;
                ?>
            </a>
        <?php else: ?>
            <span class="text-white">
                <?php 
                    if($titulo)
                        echo $titulo;
                ?>
            </span>
        <?php endif; ?>
    </h2>
</article>
<article class="card-body">
    <div class="card-text">
        <?php 
            if($conteudo)
                echo $conteudo;
        ?>
    </div>
</article>