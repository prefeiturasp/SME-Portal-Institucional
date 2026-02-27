<?php
$api_url = getenv('CEU_API');
$response = wp_remote_get($api_url);

if (is_wp_error($response)) {
    echo 'Erro ao carregar os destaques.';
    return;
}

$data = json_decode(wp_remote_retrieve_body($response));

//echo "<pre>";
//print_r($data);
//echo "</pre>";


$titulo = get_sub_field('titulo');
?>
<div class="conteudo-slide-ceus">
    <div class="titulo-slide-ceus pt-3 pb-3">
        <div class="row">
            <div class="col-12 col-md-9">
                <h2 class="mb-0"><?= $titulo; ?></h2>
            </div>
            <?php if ( $ver_todos = get_sub_field( 'link_ver_outros_ceus' ) ) : ?>
                <div class="col-12 col-md-3 link-prog text-right">
                    <a href="<?php echo esc_url( $ver_todos['url'] ); ?>" target="<?php echo esc_attr( $ver_todos['target'] ) ?>" class="no-external">
                        <?php echo esc_html( !empty( $ver_todos['title'] ) ? $ver_todos['title'] : 'Ver todos' ); ?>
                    </a>  
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php

    if($data) :									 

        echo '<div class="slide-principal slide-ceus mt-3 mb-3">';
            echo '<div class="container">';
                echo '<div class="row">';
                    
                    $slidesConteudos = $data;
                    $qtSlide = count($slidesConteudos);
                    $l = 0;
                    $m = 0;
                    //echo $qtSlide;													
                    
                    echo '<div id="carrosselCeus" class="carousel slide" data-ride="carousel">';

                        echo '<div class="carousel-inner">';

                            foreach($slidesConteudos as $slide): ?>
                                <div class="carousel-item <?php if($l == 0){echo 'active';} ?>">                                                                        
                                    <a href="<?= $slide->link; ?>">
                                        <img class="d-block w-100" src="<?= $slide->img; ?>" alt="imagem de destaque">                                    
                                    </a>
                                    <a href="<?= $slide->link; ?>" class="no-external">
                                        <h2><?= $slide->post_title; ?></h2>                                    
                                    </a>

                                    <div class="container">
                                        <div class="row flex-nowrap info-slide-ceus">

                                            <div class="col d-flex text-left">
                                                <i class="fa fa-calendar mr-2 mt-1"></i>
                                                <span><?= $slide->data; ?></span>
                                            </div>

                                            <?php if($slide->hora) : ?>
                                                <div class="col d-flex justify-content-center">
                                                    <i class="fa fa-clock-o mr-2 mt-1"></i>
                                                    <span><?= $slide->hora; ?></span>
                                                </div>
                                            <?php endif; ?>

                                            <div class="col d-flex justify-content-end">
                                                <i class="fa fa-map-marker mr-2 mt-1"></i>
                                                <span><a href="<?= $slide->local_link; ?>" class="no-external"><?= $slide->local; ?></a></span>
                                            </div>

                                        </div>
                                    </div>
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
                                echo '<li data-target="#carrosselCeus" data-slide-to="' . $m . '" class="' . $active . '"></li>';
                            
                                $m++;
                            endwhile;
                            
                        echo '</ol>';

                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

    endif; // fx_slides_1_1
?>

</div>