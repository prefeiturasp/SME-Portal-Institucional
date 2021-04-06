<?php

if(get_sub_field('fx_slides_1_1')) :									 

    echo '<div class="slide-principal mt-3 mb-3">';
        echo '<div class="container">';
            echo '<div class="row">';
                
                $slidesNoticias = get_sub_field('fx_slides_1_1');
                $qtSlide = count($slidesNoticias);
                $l = 0;
                $m = 0;
                //echo $qtSlide;													
                
                echo '<div id="carouselExampleIndicators" class="carousel slide col-sm-12" data-ride="carousel">';
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

                    echo '<div class="carousel-inner border">';

                        foreach($slidesNoticias as $slide): ?>
                            <div class="carousel-item <?php if($l == 0){echo 'active';} ?>">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <?php                                                 
                                            // Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
                                            $thumbs = get_thumb($slide);                                            
                                        ?>
                                        <a href="<?php get_the_permalink($slide); ?>"><img class="d-block w-100" src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>"></a>
                                    </div>
                                    <div class="col-sm-5"> 
                                        <div class="carousel-title">
                                            <p><a href="<?php get_the_permalink($slide); ?>"><?php echo get_the_title($slide); ?></a></p>
                                        </div>                                            
                                    </div>
                                </div>
                            </div>
                        
                        
                        <?php
                            $l++;
                        endforeach;
                            

                    echo '</div>';

                    // Setas do SLide
                    echo '<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">';
                    echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                    echo '<span class="sr-only">Previous</span>';
                    echo '</a>';
                    echo '<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">';
                    echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                    echo '<span class="sr-only">Next</span>';
                    echo '</a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

endif; // fx_slides_1_1