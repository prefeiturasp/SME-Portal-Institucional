<?php get_header(); ?>
<section>
	<div class="container mt-4 mb-4">
		<div class="row">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				$args = array(
					'type' => get_post_type(),
					'orderby' => 'name',
					'order' => 'ASC'
				);
				$file = get_field('arquivo_acervo_digital');
				$stringSeparada = explode(".", $file['filename']);
				$type = get_post_type();
				$postid = get_the_ID();
				?>
			


				<div class="col-sm-12 mb-4">
					<h2><strong><?php the_title(); ?></strong></h2>
				</div>	
				<div class="col-sm-6">
					<img src="<?php
							  if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'pdf'){
								 echo $file['icon']; 
							  }else if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'xlsx'){
								 echo $file['icon'];
							  }else if(get_field('substituir_capa_acervo_digital') != ''){
								 echo get_field('substituir_capa_acervo_digital'); 
							  }else{
								 echo $file['url'];
							  }
							  ?>" alt="<?php the_field('campo_alt_acervo_digital'); ?>" width="100%">					
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-12 mt-4 mb-4">
							<a href="<?php echo $file['url']; ?>" id="view_link">
								<button type="button" class="btn btn-primary mr-3">Visualizar</button>
							</a>
							 
							<a href="<?php echo $file['url']; ?>" id="download_link" target="_blank" download>
								<button type="button" class="btn btn-primary">Baixar documento</button>
							</a>
						</div>
						<div class="col-12 mb-3">
							<h3><strong>Categoria</strong></h3>
							<p><?php echo  strip_tags (get_the_term_list(get_the_ID(), 'categoria_teste', '', ' / ', '')); ?></p>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Autor</strong></h3>
							<?php
							$autor = get_field_object('autor_acervo_digital');
							if( $autor['value'] ): ?>
								<p>
									<?php foreach( $autor['value'] as $value => $label ): ?>
										<span><?php echo $label['label']; ?></span>&nbsp; 
									<?php endforeach; ?>
								</p>
							<?php endif; ?>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Setor</strong></h3>
							<?php
							$setor = get_field_object('setor_acervo_digital');
							if( $setor['value'] ): ?>
								<p>
									<?php foreach( $setor['value'] as $value => $label ): ?>
										<span><?php echo $label['label']; ?></span>&nbsp; 
									<?php endforeach; ?>
								</p>
							<?php endif; ?>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Ultima atualização</strong></h3>
							<p><?php the_time('d/m/Y' );?></p>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Ano da Publicação</strong></h3>
							<p><?php the_field('ano_da_publicacao_acervo_digital'); ?></p>
						</div>
						<div class="col-12 mb-3">
							<h3><strong>Palavra Chave</strong></h3>
							<p><?php echo  strip_tags (get_the_term_list(get_the_ID(), 'palavra', '', ' / ', '')); ?></p>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Tipo de documento</strong></h3>
							<p class="cx_alta"><?php echo $stringSeparada[1]; ?></p>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Tamanho do documento</strong></h3>
							<p><?php echo size_format( $file['filesize'] );?></p>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Idioma do documento</strong></h3>
							<?php
							$idioma = get_field_object('idioma_acervo_digital');
							if( $idioma['value'] ): ?>
								<p>
									<?php foreach( $idioma['value'] as $value => $label ): ?>
										<span><?php echo $label['label']; ?></span>&nbsp; 
									<?php endforeach; ?>
								</p>
							<?php endif; ?>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Quantidade de páginas</strong></h3>
							<p><?php the_field('qt_de_paginas_acervo_digital'); ?></p>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Quantidade de visualizações</strong></h3>
							<p><?php 
								gt_set_post_view();
								echo gt_get_post_view();
								?>
							</p>
						</div>
						<div class="col-6 mb-3">
							<h3><strong>Quantidade de downloads</strong></h3>
							<p><?php echo get_post_meta($post->ID, 'download', true); ?></p>
						</div>
					</div>
				</div>	
				<div class="col-sm-12 mt-3 mb-3">
					Compartilhar: 
					<a href="mailto:?subject=&body=:%20" title="<?php the_title(); ?>" onclick="window.open('mailto:?subject=' + 'Acervo Digital SME' + '&body=' + encodeURIComponent(document.URL)); return false;">
						<img src="<?php echo get_template_directory_uri(); ?>/images/email-icon.png" width="32" alt="compartilhar no email">
					</a>
					<a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/images/twitter-icon.png" width="32" alt="compartilhar no twitter">
					</a>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/images/facebook-icon.png" width="32" alt="compartilhar no facebook">
					</a>
					<a href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/images/whatsapp-icon.png" width="32" alt="compartilhar no Whatsappl">
					</a>
				</div>	
				<div class="col-sm-12 mt-4 mb-4">
					<h3><strong>Descrição</strong></h3>
					<p><?php the_field('descricao_acervo_digital'); ?></p>
				</div>

			<?php endwhile; wp_reset_query(); ?>

		</div>
	</div>
</section>

<script>
	jQuery( "#download_link" ).click(function() {
		jQuery.ajax({
		 type:"POST",
		 url: 'https://hom-portal.sme.prefeitura.sp.gov.br/acervodigital/wp-admin/admin-ajax.php',
		 data: {
			'action':'update_counter',
			'post_id' : <?php global $post; echo $post->ID; ?>
		 }
		 });
			setTimeout("window.location.reload();", 2000);
		 //window.location.reload();
	});
</script>
<?php get_footer(); ?>