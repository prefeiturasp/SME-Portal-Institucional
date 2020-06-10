<?php get_header(); ?>
<main>
	<div class="container-fluid busca-home">
		<div class="row">
			<div class="col-sm-12">

			</div>
		</div>
	</div>
	<div class="container">
		
		<div class="row">
				<div class="col-sm-12">
					<h2 class="mt-3 mb-3">Últimos documentos adicionados</h2>
				</div>
				<?php
				$loop = new WP_Query( array(
					'post_type' => array(
						'transparencia',
					),
					'taxonomy'   => 'transparencia',
					'order' => 'DESC',
					'posts_per_page' => 6
				  )
				);
				?>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<?php
						$file = get_field('arquivo_acervo');
						$type = get_post_type();
						$stringSeparada = explode(".", $file['filename']);
					?>
					<div class="col-sm-6 mb-3 ">
						<div class="row acervo-display">
							<div style="
										background-image: url(<?php
										  if(get_field('capa_acervo') == '' && $stringSeparada[1] == 'pdf'){
											 echo $file['icon']; 
										  }else if(get_field('capa_acervo') == '' && $stringSeparada[1] == 'xlsx'){
											 echo $file['icon'];
										  }else if(get_field('capa_acervo') != ''){
											 echo the_field('capa_acervo'); 
										  }else{
											 echo $file['url'];
										  }
										  ?>);
										" class="col-sm-4 flag">
								<span class="flag-pdf">
									<?php
									
									echo $stringSeparada[1]; 
									?>
								</span>
								<?php /*?><img src="<?php
										  if(get_field('capa_acervo') == '' && $stringSeparada[1] == 'pdf'){
											 echo $file['icon']; 
										  }else if(get_field('capa_acervo') == '' && $stringSeparada[1] == 'xlsx'){
											 echo $file['icon'];
										  }else if(get_field('capa_acervo') != ''){
											 echo the_field('capa_acervo'); 
										  }else{
											 echo $file['url'];
										  }
										  ?>"><?php */?>
							</div>
							<div class="col-sm-8 mt-3 mb-3">
								<h3 class="azul-claro-acervo"><strong><?php the_title(); ?></strong></h3>
								<div class="cat-flag mb-3"><?php echo $type; ?></div>
								<p><?php the_field('descricao_acervo'); ?></p>
								<p><strong>Última atualização:</strong> <?php the_time('d/m/Y' );?></p>
								<p><strong>Tags: </strong>				
									<?php the_tags( '<span class="custom-tags">', '', '<span>' );?>
								</p>
								<div class="links-flag">
									<a href="<?php the_permalink(); ?>">Visualizar</a>
									<a href="<?php the_permalink(); ?>">Ver detalhes</a>
									<a href="<?php echo $file['url'] ?>">Fazer download</a>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; wp_reset_query(); ?>
			
		</div>
	</div>
</main>
<?php get_footer(); ?>