<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialNoticiasDestaqueSecundarias extends PaginaInicial
{

    private $cont;

	public function __construct()
	{
		$noticias_secundarias_tags = array('section');
		$noticias_secundarias_css = array('col-lg-6 col-xs-12');
		$this->abreContainer($noticias_secundarias_tags, $noticias_secundarias_css);
		$this->montaQueryNoticiasHomeSecundarias(2);
		$this->montaHtmlLoopNoticias();
		//$this->montaQueryNoticiasHomeSecundarias(3);
		//$this->montaHtmlLoopNoticias();
		$this->montaHtmlBotaoMaisNoticias();
		$this->fechaContainer($noticias_secundarias_tags);

		$this->cont = 0;
	}

	public function montaQueryNoticiasHomeSecundarias($posicao_destaque)
	{
		$this->args_noticas_home_secundarias = array(
			'post_type' => 'post',
			'meta_query' => array(
				array(
					'relation' => 'AND',
					array(
						'key'	 	=> 'deseja_que_este_post_apareca_na_home',
						'value'	  	=> 'sim',
						'compare' 	=> '=',
					),
					array(
						'key'	  	=> 'posicao_de_destaque_deste_post',
						'value'	  	=> $posicao_destaque,
						'compare' 	=> 'IN',
					),
				)
			),
			'orderby' => 'date',
			'order' => 'DESC',
			'cat' => $this->getCamposPersonalizados('escolha_a_categoria_de_noticias_a_exibir')->term_id,
			'posts_per_page' => 1,
			'post__not_in' => array($this->id_noticias_home_principal),			
			'post_status' => 'publish'
		);
		$this->query_noticias_home_secundarias = new \WP_Query($this->args_noticas_home_secundarias);
	}



	public function montaHtmlLoopNoticias()
	{

		$posts = get_field('segundo_destaque','option');

		if( $posts ): ?>
			<?php foreach( $posts as $p ): 
				if($p->post_status == 'publish') :
			?>
				<article class="row mb-4 b-home border-bottom">
					<div class="col-12 col-md-5 mb-1">
						<img class="img-fluid rounded float-left mr-4 img-noticias-destaques-secundarias desc2-img-home" src="<?php echo get_the_post_thumbnail_url( $p->ID ); ?>" alt="">
					</div>
					<div class="col-12 col-md-7">
						<h3 class="fonte-catorze font-weight-bold">
							<a class="text-dark" href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a>
						</h3>
						<?php if(get_field('insira_o_subtitulo', $p->ID)) : ?>
							<section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?php the_field('insira_o_subtitulo', $p->ID); ?></p></span></section>
						<?php elseif(get_the_excerpt($p->ID )): ?>
							<section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?php echo get_the_excerpt($p->ID ); ?></p></span></section>
						<?php endif; ?>
					</div>
				</article>
				<?php else: 
							
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 1,
						'orderby' => 'date',
						'order' => 'DESC',
						'offset' => '1'
					);
					
					// The Query
					query_posts( $args );
					
					// The Loop
					while ( have_posts() ) : the_post(); ?>

						<article class="row mb-4 b-home border-bottom">
							<div class="col-12 col-md-5 mb-1">
								<img class="img-fluid rounded float-left mr-4 img-noticias-destaques-secundarias desc2-img-home" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
							</div>
							<div class="col-12 col-md-7">
								<h3 class="fonte-catorze font-weight-bold">
									<a class="text-dark" href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
								</h3>
								<?php if(get_field('insira_o_subtitulo')) : ?>
									<section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?php the_field('insira_o_subtitulo'); ?></p></span></section>
								<?php elseif(get_the_excerpt()): ?>
									<section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?php echo get_the_excerpt(); ?></p></span></section>
								<?php endif; ?>
							</div>
						</article>

					<?php
					endwhile;
					
					// Reset Query
					wp_reset_query();

				endif; ?>
			<?php endforeach; ?>
		<?php endif;


		$posts = get_field('terceiro_destaque','option');
		if( $posts ): ?>
			<?php foreach( $posts as $p ): 
				if($p->post_status == 'publish') :
			?>
				<article class="row mb-4 b-home border-bottom">
					<div class="col-12 col-md-5 mb-1">
						<img class="img-fluid rounded float-left mr-4 img-noticias-destaques-secundarias desc2-img-home" src="<?php echo get_the_post_thumbnail_url( $p->ID ); ?>" alt="">
					</div>
					<div class="col-12 col-md-7">
						<h3 class="fonte-catorze font-weight-bold">
							<a class="text-dark" href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a>
						</h3>
						<?php if(get_field('insira_o_subtitulo', $p->ID)) : ?>
							<section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?php the_field('insira_o_subtitulo', $p->ID); ?></p></span></section>
						<?php elseif(get_the_excerpt($p->ID )): ?>
							<section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?php echo get_the_excerpt($p->ID ); ?></p></span></section>
						<?php endif; ?>
					</div>
				</article>
				<?php else: 
							
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 1,
						'orderby' => 'date',
						'order' => 'DESC',
						'offset' => '2'
					);
					
					// The Query
					query_posts( $args );
					
					// The Loop
					while ( have_posts() ) : the_post(); ?>

						<article class="row mb-4 b-home border-bottom">
							<div class="col-12 col-md-5 mb-1">
								<img class="img-fluid rounded float-left mr-4 img-noticias-destaques-secundarias desc2-img-home" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
							</div>
							<div class="col-12 col-md-7">
								<h3 class="fonte-catorze font-weight-bold">
									<a class="text-dark" href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
								</h3>
								<?php if(get_field('insira_o_subtitulo')) : ?>
									<section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?php the_field('insira_o_subtitulo'); ?></p></span></section>
								<?php elseif(get_the_excerpt()): ?>
									<section class="fonte-doze"><span class="mb-3 "><p class="mb-3 "><?php echo get_the_excerpt(); ?></p></span></section>
								<?php endif; ?>
							</div>
						</article>

					<?php
					endwhile;
					
					// Reset Query
					wp_reset_query();

				endif; ?>
			<?php endforeach; ?>
		<?php endif;

		wp_reset_postdata();
		?>

		<?php

	}

}