<?php

namespace Classes\TemplateHierarchy\LoopSingle;


class LoopSingleRelacionadas extends LoopSingle
{
	private $id_post_atual;
	protected $args_relacionadas;
	protected $query_relacionadas;

	public function __construct($id_post_atual)
	{
		$this->id_post_atual = $id_post_atual;
		//$this->init();
		$this->my_related_posts();
	}


	public function getComplementosRelacionadas($id_post){
		$dt_post = get_the_date('d/m/Y g\hi');
		$categoria = get_the_category($id_post)[0]->name;

		return '<p class="fonte-doze font-italic mb-0">Publicado em: '.$dt_post.' - em '.$categoria.'</p>';


	}
	
	public function my_related_posts() {
	?>
		<div class="end-footer py-4 col-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
						
						<?php
							global $post;
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

                        <div class="end-title-unidade my-3">
                            <p><?php echo $unidades; ?></p>
						</div>

						<?php
							$categories = get_the_category();
							$category_id = $categories[0]->cat_ID;
							
							$end = get_field('endereco_ceu', 'category_' . $category_id);
							$email = get_field('email_ceu', 'category_' . $category_id);
							$tel = get_field('telefone_ceu', 'category_' . $category_id);
							$mapa = get_field('iframe_mapa_ceu', 'category_' . $category_id);
						?>
						
                        <div class="end-infos">
							<?php if($end != ''): ?>								
								<p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $end; ?></p>
							<?php endif; ?>

							<?php if($email != ''): ?>								
								<p><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $email; ?></p>
							<?php endif; ?>

							<?php if($tel != ''): ?>								
								<p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $tel; ?></p>
							<?php endif; ?>
                            
                        </div>
                    </div>

                    <div class="col-md-6">
						<?php if($mapa != ''): ?>								
							<?php echo $mapa; ?>
						<?php endif; ?>                        
                    </div>
                </div>
            </div>
		</div>
		
	<?php
		
	}
	

}