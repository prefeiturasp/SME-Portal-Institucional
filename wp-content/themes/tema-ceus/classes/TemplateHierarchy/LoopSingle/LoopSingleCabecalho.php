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
		$local = get_field('localizacao', $post->ID); 
		$zona = get_group_field( 'informacoes_basicas', 'zona_sp', $local );
		?>
		<div class="evento-title mt-3 mb-3 col-12 color-<?php echo $zona; ?>" id="Noticias">
            <div class="container">
                <div class="row bg-event-title py-4">
                    <div class="col-md-5 offset-md-1">

						<?php 
							//$featured_img_url = get_the_post_thumbnail_url($post->ID, 'thumb-eventos');
							$imgSelect = get_field('capa_do_evento', $post->ID);							
                            $featured_img_url = wp_get_attachment_image_src($imgSelect, 'thumb-eventos');
							if($featured_img_url){
								$imgEvento = $featured_img_url[0];
								//$thumbnail_id = get_post_thumbnail_id( $post->ID );
								$alt = get_post_meta($imgSelect, '_wp_attachment_image_alt', true);  
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

						$atividadesTotal = count($atividades);

						if($atividadesTotal > 1){
							foreach($atividades as $atividade){
								if($atividade->parent != 0){
									$listaAtividades[] = $atividade->name;
								} 
							}
						} else {
							$listaAtividades[] = $atividades[0]->name;
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

						<h1 class="m-0 py-3 w-100"><?php echo get_the_title(); ?></h1>
						
						<?php
							$post_categories = wp_get_post_categories( $post->ID );
							$local = get_field('localizacao', $post->ID); 
						?>

						<p class="evento-unidade m-0 w-100">
							<?php if($local == 31244): ?>
								<?php echo get_the_title($local); ?>
							<?php else: ?>
								<a href="<?php echo get_the_permalink($local); ?>"><?php echo get_the_title($local); ?></a>
							<?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        
	}
}