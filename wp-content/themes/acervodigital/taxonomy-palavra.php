

				
					<?php get_header(); ?>
<main class="mt-5 mb-5">
	<section>
		<div class="container">	
			<div class="row">
				<div class="col-sm-12">
					<h2 class="mt-3 mb-3">Resultados de Palavras Chaves</h2>
				</div>
				<div class="col-sm-8 mt-3 mb-5">
				<?php
				$tax = $wp_query->get_queried_object();
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$loop = new WP_Query( array(
					'post_type' => array(
						'acervo',
					),
					'tax_query' => array(
			        array(
			        'taxonomy' => 'palavra',
			        //'paged' => $paged,
			        'field' => 'slug',
			        'terms' => $tax->slug,
			                )
			            ),
					'order' => 'ASC',
					//'posts_per_page' => 10
				  )
				);
				?>
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
								<?php
								$file = get_field('arquivo_acervo_digital');
								$stringSeparada = explode(".", $file['filename']);
								$type = get_post_type();

								?>
								<div class="row">
								<div class="col-sm-12">
									<div class="row acervo-display">
										<div class="col-sm-4 view-tag flag">
											<img src="
														<?php
													  if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'pdf'){
														 echo $file['icon']; 
													  }else if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'xlsx'){
														 echo $file['icon'];
													  }else if(get_field('substituir_capa_acervo_digital') != ''){
														 echo get_field('substituir_capa_acervo_digital'); 
													  }else{
														 echo $file['url'];
													  }
													  ?>		
													  " alt="">			
											<span class="flag-pdf-full">
												<?php
												echo $stringSeparada[1]; 
												?>
											</span>
										</div>
										<div class="col-sm-8 mt-3 mb-3">
											<h3 class="azul-claro-acervo"><strong><?php the_title(); ?></strong></h3>
											<div class="cat-flag mb-4"><?php echo  strip_tags (get_the_term_list(get_the_ID(), 'categoria_teste', '', ' / ', '')); ?></div>
											<p><?php the_field('descricao_acervo_digital'); ?></p>
											<p><strong>Ano de publicação:</strong>
												<?php the_field('ano_da_publicacao_acervo_digital'); ?>
											&nbsp;&nbsp;&nbsp;<strong>Palavras chaves: </strong>				
												<?php echo  strip_tags (get_the_term_list(get_the_ID(), 'palavra', '', ' / ', '')); ?>
											</p>
											<div class="links-flag">
												<a href="<?php the_permalink(); ?>">Visualizar</a>
												<a href="<?php the_permalink(); ?>">Ver detalhes</a>
												<a href="<?php echo $file['url'] ?>">Fazer download</a>
											</div>
										</div>
									</div>
								</div>
							</div>
					
				<?php endwhile;  ?>
							<div class="col-sm-12 mt-5 mb-5 text-center">
								<?php
								if(function_exists('wp_pagenavi'))
								wp_pagenavi(); ?>
							</div>
							<?php wp_reset_query(); ?>
				</div>
						<div class="col-sm-4 mt-5 mb-5">
							FILTROS
						</div>		
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>