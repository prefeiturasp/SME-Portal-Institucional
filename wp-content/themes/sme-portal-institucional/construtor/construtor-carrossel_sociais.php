<?php
$titulo = get_sub_field('titulo');
?>

<div class="linha-com-titulo mt-3 mb-3">
  <h2 class="mb-0"><?= $titulo; ?></h2>
  <div class="linhas">
    <div class="linha color1"></div>
    <div class="linha color2"></div>
    <div class="linha color3"></div>
  </div>
</div>

<?php

if(get_sub_field('conteudos')) :									 

    echo '<div class="slide-principal slide-social mt-3 mb-3">';
        echo '<div class="container">';
            echo '<div class="row">';
                
                $slidesConteudos = get_sub_field('conteudos');
                $qtSlide = count($slidesConteudos);
                $l = 0;
                $m = 0;
                //echo $qtSlide;													
                
                echo '<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">';

                    echo '<div class="carousel-inner border">';

                        foreach($slidesConteudos as $slide): ?>
                            <div class="carousel-item <?php if($l == 0){echo 'active';} ?>">
                                <?php if($slide['conteudo']) : ?>

                                    <?php if($slide['rede'] == 'face'): ?>
                                        <?= do_shortcode( '[facebook_posts numero="' . $slide['ordem'] . '"]' ); ?>
                                    <?php elseif($slide['rede'] == 'insta'): ?>
                                        <?= do_shortcode( '[instagram_posts numero="' . $slide['ordem'] . '"]' ); ?>
                                    <?php endif; ?>

                                    <?php if($slide['icone']) : ?>
                                        <img src="<?= $slide['icone']['url'] ?>" alt="<?= $slide['icone']['alt'] ?>" class="img-fluid icone-slide">                                        
                                    <?php endif; ?>
                                    
                                <?php else : ?>

                                    <a href="<?= $slide['link'] ?>">
                                        <img class="d-block w-100" src="<?= $slide['imagem']['url'] ?>" alt="<?= $slide['imagem']['alt'] ?>">
                                        <?php if($slide['icone']) : ?>
                                            <img src="<?= $slide['icone']['url'] ?>" alt="<?= $slide['icone']['alt'] ?>" class="img-fluid icone-slide">                                        
                                        <?php endif; ?>
                                    </a>

                                <?php endif; ?>
                            </div>
                        <?php
                            $l++;
                        endforeach;
                            

                    echo '</div>';

                    echo '<ol class="carousel-indicators">';
                    
                    
                        while($m < $qtSlide) :
                            if($m == 0){
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $m . '" class="' . $active . '"></li>';
                        
                            $m++;
                        endwhile;
                        
                    echo '</ol>';

                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

endif; // fx_slides_1_1