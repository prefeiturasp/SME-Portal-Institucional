<?php
/*
Template Name: Search Page
*/
?>
<?php
get_header(); ?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container mt-5 mb-5">
				<div class="row">
						<div class="col-sm-12">
							<h3 class="search-title">
							<span class="azul-claro-acervo"><strong><?php echo $wp_query->found_posts; ?></strong></span> <?php _e( 'Resultados para ', 'locale' ); ?>: <strong> <?php the_search_query(); ?> </strong>
							</h3>
						</div>
						<div class="col-sm-8 mt-3 mb-5">
							<?php
							if(have_posts()):
							while(have_posts()): the_post();
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
							<?php
							endwhile;
							else:
							echo 'Sem conteudo';
							endif;
							?>
							<div class="col-sm-12 mt-5 mb-5 text-center">
								<?php
								if(function_exists('wp_pagenavi'))
								wp_pagenavi(); ?>
							</div>
						</div>
						<div class="col-sm-4 mt-5 mb-5">
							FILTROS
						</div>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->
<?php get_footer();