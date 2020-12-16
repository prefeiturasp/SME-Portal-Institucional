<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialNoticiasDestaquePrimaria extends PaginaInicial
{

	public function __construct()
	{
		$this->montaQueryNoticiasHomePrincipal();
		$this->montaHtmlLoopNoticiaPrincipal();

	}

	public function montaQueryNoticiasHomePrincipal(){
		$this->args_noticas_home_principal = array(
			'post_type' => 'post',
			'post_status' => array('publish'),
			'meta_query' => array(
				//'relation' => '', // Optional argument.
				array(
					'relation' => 'AND',
					array(
						'key'	 	=> 'deseja_que_este_post_apareca_na_home',
						'value'	  	=> 'sim',
						'compare' 	=> '=',
					),
					array(
						'key'	  	=> 'posicao_de_destaque_deste_post',
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
				)
			),
			'orderby' => 'date',
			'order' => 'DESC',
			'cat' => $this->getCamposPersonalizados('escolha_a_categoria_de_noticias_a_exibir')->term_id,
			'posts_per_page' => 1,
		);
		$this->query_noticias_home_principal = new \WP_Query($this->args_noticas_home_principal);

	}

	public function montaHtmlLoopNoticiaPrincipal()	{
		

			$posts = get_field('primeiro_destaque','option');

			//echo "<pre>";
			//print_r($posts);
			//echo "</pre>";

			if( $posts ): ?>
					<?php foreach( $posts as $p ): 
						if($p->post_status == 'publish') :	
					?>
						<section class="col-lg-6 col-xs-12 mb-xs-4 rounded">
							<article class="card h-100 rounded border-0">
								<img class="rounded" src="<?php echo get_the_post_thumbnail_url( $p->ID ); ?>" width="100%">
								<article class="card-img-overlay bg-home-desc h-auto rounded-bottom container-img-noticias-destaques-primaria">
									<h3 class="fonte-catorze font-weight-bold">
										<a class="text-white" href="<?php echo get_permalink( $p->ID ); ?>">
											<?php echo get_the_title( $p->ID ); ?>

										</a>
									</h3>
									<?php if(get_field('insira_o_subtitulo', $p->ID)) : ?>
										<section class="card-text text-white fonte-doze"><p class="mb-3 "><?php the_field('insira_o_subtitulo', $p->ID); ?></p></section>
									<?php elseif(get_the_excerpt($p->ID )): ?>
										<section class="card-text text-white fonte-doze"><p class="mb-3 "><?php echo get_the_excerpt($p->ID ); ?></p></section>
									<?php endif; ?>
								</article>
							</article>
						</section>
						<?php else: 
							
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 1,
								'orderby' => 'date',
								'order' => 'DESC',
							);
							
							// The Query
							query_posts( $args );
							
							// The Loop
							while ( have_posts() ) : the_post(); ?>

								<section class="col-lg-6 col-xs-12 mb-xs-4 rounded">
									<article class="card h-100 rounded border-0">
										<img class="rounded" src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%">
										<article class="card-img-overlay bg-home-desc h-auto rounded-bottom container-img-noticias-destaques-primaria">
											<h3 class="fonte-catorze font-weight-bold">
												<a class="text-white" href="<?php echo get_permalink(); ?>">
													<?php echo get_the_title(); ?>
												</a>
											</h3>
											<?php if(get_field('insira_o_subtitulo')) : ?>
												<section class="card-text text-white fonte-doze"><p class="mb-3 "><?php the_field('insira_o_subtitulo'); ?></p></section>
											<?php elseif(get_the_excerpt()): ?>
												<section class="card-text text-white fonte-doze"><p class="mb-3 "><?php echo get_the_excerpt(); ?></p></section>
											<?php endif; ?>
										</article>
									</article>
								</section>

							<?php
							endwhile;
							
							// Reset Query
							wp_reset_query();

						endif; ?>
					<?php endforeach; ?>
			<?php endif;
		wp_reset_postdata();

	}



}