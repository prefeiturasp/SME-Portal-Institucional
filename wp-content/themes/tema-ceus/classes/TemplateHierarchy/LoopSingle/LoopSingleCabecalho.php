<?php

namespace Classes\TemplateHierarchy\LoopSingle;

use Classes\TemplateHierarchy\Search\SearchFormSingle;

class LoopSingleCabecalho extends LoopSingle
{

	public function __construct()
	{
		$this->cabecalhoDetalheNoticia();
	}

	public function cabecalhoDetalheNoticia(){
		global $post;
		?>
		<div class="evento-title mt-3 mb-3 col-12">
            <div class="container">
                <div class="row bg-event-title py-4">
                    <div class="col-md-5 offset-md-1">
						<!-- <img src="http://via.placeholder.com/485x246" alt="" class="img-fluid"> -->

						<?php 
							$featured_img_url = get_the_post_thumbnail_url($post->ID, 'thumb-eventos');
							if($featured_img_url){
								$imgEvento = $featured_img_url;
								$thumbnail_id = get_post_thumbnail_id( $post->ID );
								$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);  
							} else {
								$imgEvento = 'https://via.placeholder.com/485x246';
								$alt = get_the_title($post->ID);
							}
						?>
						<img src="<?php echo $imgEvento; ?>" class="img-fluid d-block" alt="<?php echo $alt; ?>">

                    </div>

                    <div class="col-md-5 evento-infos d-flex align-content-between flex-wrap">
						
					<?php
						$atividades = get_the_terms( $post->ID, 'atividades_categories' );
						$listaAtividades = array();
						foreach($atividades as $atividade){
							if($atividade->parent != 0){
								$listaAtividades[] = $atividade->name;
							}
						}

						$total = count($listaAtividades); 
						$k = 0;
						$showAtividades = '';

						foreach($listaAtividades as $atividade){
							$k++;
							if($total - $k == 1 || $total - $k == 0){
								$showAtividades .= $atividade . " ";
							} elseif($total != $k){
								$showAtividades .= $atividade . ", ";
							} else {
								$showAtividades .= "e " . $atividade;
							}
						}
					?>
					
					
						<p class="categ-dest w-100 m-0">
							<?php echo $showAtividades; ?>
                        </p>

						<h3 class="m-0 py-3 w-100"><?php echo get_the_title(); ?></h3>
						
						<?php
							$post_categories = wp_get_post_categories( $post->ID );
							$cats = array();
							
							foreach($post_categories as $c){
								$cat = get_category( $c );
								$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
							}

							$total = count($post_categories); 
							$j = 0;
							$unidades = '';

							foreach($cats as $unidade){
								$j++;
								if($total - $j == 1 || $total - $j == 0){
									$unidades .= $unidade['name'] . " ";
								} elseif($total != $j){
									$unidades .= $unidade['name'] . ", ";
								} else {
									$unidades .= "e " . $unidade['name'];
								}
							}
							
						?>

                        <p class="evento-unidade m-0 w-100">
							<?php echo $unidades; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        
	}
}