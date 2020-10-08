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

					<?php

					$idpost = get_the_ID();

					$ipacesso = get_client_ip();

					$titledoc = get_the_title();

					?>

					<?php

					$articles = get_posts(

					 array(

					  's' => $titledoc,

					  'numberposts' => -1,

					  'post_status' => 'any',

					  'post_type' => 'download',



					 )

					);

					?>

					<?php

					//executar depois do click

					// Cria post para registro de downloads.

					

					if(isset($_GET['ajaxify'])) {

					    echo 'ajaxifying';

					$download_data = array(

						'post_title'    => $titledoc,

						'post_type'     => 'download',

						'post_status'   => 'publish'

					);

					$download_id = wp_insert_post( $download_data );



					// Salva nome do documento.

					$field_key = "field_5f6a0eddf2ee2";

					$value = $titledoc;

					update_field( $field_key, $value, $download_id );

					// Salva id do documento.

					$field_key = "field_5f6a2e01aafb7";

					$value = $idpost;

					update_field( $field_key, $value, $download_id );

					// Salva ipdo visitante

					$field_key = "field_5f6a267742f16";

					$value = $ipacesso;

          update_field( $field_key, $value, $download_id );

        }

					?>

					<?php

					// Cria post para registro de visitas.

					$acesso_data = array(

						'post_title'    => $titledoc,

						'post_type'     => 'acesso',

						'post_status'   => 'publish'

					);

					$acesso_id = wp_insert_post( $acesso_data );



					// Salva nome do documento.

					$field_key = "field_5f6ac9d93c0a7";

					$value = $titledoc;

					update_field( $field_key, $value, $acesso_id );

					// Salva id do documento.

					$field_key = "field_5f6ac9d93c122";

					$value = $idpost;

					update_field( $field_key, $value, $acesso_id );

					// Salva ipdo visitante

					$field_key = "field_5f6ac9d93c0e6";

					$value = $ipacesso;

					update_field( $field_key, $value, $acesso_id );
					?>
			
			
						<div class="col-sm-6">
						<div class="row">
						<div class="col-12 mt-4 mb-4">
							<a rel="noopener" target="_blank" href="<?php echo $file['url']; ?>" id="view_link">
								<button type="button" class="btn btn-primary mr-3">Visualizar</button>
							</a>
							<?php
								if($file['url'] != ''){
									?>
									<a href="<?php echo $file['url']; ?>" id="download_link" target="_blank" download>
										<button type="button" class="btn btn-primary">Baixar documento</button>
									</a>
									<?php
								}
							?>
						</div>

						<div class="col-12 mb-3">
						<?php
							$a = 1;
								if( have_rows('arquivos_particionados') ):
									while ( have_rows('arquivos_particionados') ) : the_row();
										if( get_row_layout() == 'adicionar_arquivos' ):
											?>
											<a href="<?php echo $text = get_sub_field('arquivo'); ?>" id="download_link" target="_blank" download>
												<button type="button" class="btn btn-primary">Baixar parte <?php echo $a++; ?></button>
											</a>
											<?php
										endif;
									endwhile;
								else :
								endif;
							 ?>
						</div>
						
						
						<div class="col-12 mb-3">
							<h3><strong>Categoria</strong></h3>
							<p><?php echo  get_the_term_list(get_the_ID(), 'categoria_acervo', '', ' / ', ''); ?></p>
						</div>


						<?php
							$terms = get_field('autor_acervo_digital');
							if(get_field('autor_acervo_digital') != ''){
								?>
								<div class="col-6 mb-3">
									<h3><strong>Autor</strong></h3>
									<?php 
									if( $terms ): ?>
										<?php foreach( $terms as $term ): ?>
												<p><?php echo esc_html( $term->name ); ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<?php
							}
						?>

						
						<?php
							$terms = get_field('setor_acervo_digital');
							if(get_field('setor_acervo_digital') != ''){
								?>
								<div class="col-6 mb-3">
									<h3><strong>Setor</strong></h3>
									<?php 
									if( $terms ): ?>
										<?php foreach( $terms as $term ): ?>
												<p><?php echo esc_html( $term->name ); ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<?php
							}
						?>




						<div class="col-6 mb-3">
							<h3><strong>Ultima atualização</strong></h3>
							<p><?php the_time('d/m/Y' );?></p>
						</div>

						
						
						<?php
							$terms = get_field('modalidade_acervo_digital');
							if(get_field('modalidade_acervo_digital') != ''){
								?>
								<div class="col-6 mb-3">
									<h3><strong>Modalidade de ensino</strong></h3>
									<?php 
									if( $terms ): ?>
										<?php foreach( $terms as $term ): ?>
												<p><?php echo esc_html( $term->name ); ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<?php
							}
						?>

						

						<?php
							$terms = get_field('componente_acervo_digital');
							if(get_field('componente_acervo_digital') != ''){
								?>
								<div class="col-6 mb-3">
									<h3><strong>Componente curricular</strong></h3>
									<?php 
									if( $terms ): ?>
										<?php foreach( $terms as $term ): ?>
												<p><?php echo esc_html( $term->name ); ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<?php
							}
						?>

						


						<?php
							if(get_field('mes_da_publicacao_acervo_digital') != ''){
								?>
									<div class="col-6 mb-3">
										<h3><strong>Mês da Publicação</strong></h3>
										<p><?php the_field('mes_da_publicacao_acervo_digital'); ?></p>
									</div>
								<?php
							}
						?>
						

						
						<?php
							if(get_field('ano_da_publicacao_acervo_digital') != ''){
								?>
									<div class="col-6 mb-3">
										<h3><strong>Ano da Publicação</strong></h3>
										<p><?php the_field('ano_da_publicacao_acervo_digital'); ?></p>
									</div>
								<?php
							}
						?>


						<?php
							$terms = get_field('formacao_acervo_digital');
							if(get_field('formacao_acervo_digital') != ''){
								?>
								<div class="col-6 mb-3">
									<h3><strong>Tipo de Formação</strong></h3>
									<?php 
									if( $terms ): ?>
										<?php foreach( $terms as $term ): ?>
												<p><?php echo esc_html( $term->name ); ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<?php
							}
						?>

						
						<?php
							$terms = get_field('area_promotora');
							if(get_field('area_promotora') != ''){
								?>
								<div class="col-6 mb-3">
									<h3><strong>Área promotora</strong></h3>
									<?php 
									if( $terms ): ?>
										<?php foreach( $terms as $term ): ?>
												<p><?php echo esc_html( $term->name ); ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<?php
							}
						?>

						

						<?php
							if(get_field('numero_de_despacho_de_homologacao') != ''){
								?>
									<div class="col-6 mb-3">
										<h3><strong>Nº de despacho de homologação</strong></h3>
										<p><?php the_field('numero_de_despacho_de_homologacao'); ?></p>
									</div>
								<?php
							}
						?>

						
						<?php
							if(get_field('numero_da_proposta_de_validacao') != ''){
								?>
									<div class="col-6 mb-3">
										<h3><strong>Nº da proposta de validação</strong></h3>
										<p><?php the_field('numero_da_proposta_de_validacao'); ?></p>
									</div>
								<?php
							}
						?>

						
						<?php
							if(get_field('numero_do_comunicado') != ''){
								?>
									<div class="col-6 mb-3">
										<h3><strong>Nº do comunicado</strong></h3>
										<p><?php the_field('numero_do_comunicado'); ?></p>
									</div>
								<?php
							}
						?>

						

						<?php
							if(get_field('periodo_de_inscricao') != ''){
								?>
									<div class="col-6 mb-3">
										<h3><strong>Período de inscrição</strong></h3>
										<p><?php the_field('periodo_de_inscricao'); ?></p>
									</div>
								<?php
							}
						?>

						
						<?php
							$terms = get_field('publico_alvo');
							if(get_field('publico_alvo') != ''){
								?>
								<div class="col-6 mb-3">
									<h3><strong>Público alvo</strong></h3>
									<?php 
									if( $terms ): ?>
										<?php foreach( $terms as $term ): ?>
												<p><?php echo esc_html( $term->name ); ?></p>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<?php
							}
						?>



						<div class="col-6 mb-3">
							<h3><strong>Palavra Chave</strong></h3>
							<p><?php echo  get_the_term_list(get_the_ID(), 'palavra', '', ' - ', ''); ?></p>
						</div>

						
						<div class="col-6 mb-3">
							<h3><strong>Tipo de documento</strong></h3>
							<p class="cx_alta"><?php 
								if($stringSeparada[1] != ''){
									echo $stringSeparada[1];
								}else{
									echo 'DIVERSOS';
								}
								?></p>
						</div>


						<div class="col-6 mb-3">
							<h3><strong>Tamanho do documento</strong></h3>
							<p><?php
								if( $file['filesize']  != ''){
									echo size_format( $file['filesize'] );
								}else{
									echo 'INDEFINIDO';
								}
								?></p>
						</div>



						<div class="col-6 mb-3">
							<h3><strong>Idioma do documento</strong></h3>
							<?php 
							$terms = get_field('idioma_acervo_digital');
							if( $terms ): ?>
							    <?php foreach( $terms as $term ): ?>
							        <a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
							        	<?php echo esc_html( $term->name ); ?>	
							        </a>
							    <?php endforeach; ?>
							<?php endif; ?>
						</div>



						<div class="col-6 mb-3">
							<h3><strong>Quantidade de páginas</strong></h3>
							<p><?php the_field('qt_de_paginas_acervo_digital'); ?></p>
						</div>



						<div class="col-6 mb-3">
							<h3><strong>Quantidade de visualizações</strong></h3>
							<p>
							<?php 
							function retornaNumero($posttype) {
							$contador = 0;
							echo '<div style="display: none">';
							$artigo = get_posts(
							 array(
								's' => the_title(),
								'post_type' => $posttype,
							    'numberposts' => -1,
							    'post_status' => 'any',
							 ));
							echo '</div>';

							foreach ($artigo as $article) { 
							$contador++;
							//var_dump($article);
							}
							return $contador;
							}
							echo retornaNumero(('acesso'));
							?>  
							</p>
						</div>



						<div class="col-6 mb-3">
							<h3><strong>Quantidade de downloads</strong></h3>
							<p><?php echo retornaNumero(('download')); ?></p>
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



function ctDownload() {

    var href = new URL(window.location.href);

href.searchParams.set('ajaxify', '1');



  jQuery.ajax({url: href.toString(), success: function(result){

    console.log(result);

  }});

}





	jQuery( "#download_link" ).click(function() {

ctDownload();

	});

	

	jQuery( "#view_link" ).click(function() {

ctDownload();

	});

/*

		jQuery.ajax({



		 type:"POST",



		 url: 'https://hom-portal.sme.prefeitura.sp.gov.br/acervodigital/wp-admin/admin-ajax.php',



		 data: {



			'action':'update_counter',



			'post_id' : <?php global $post; echo $post->ID; ?>



		 }



		 });



			setTimeout("window.location.reload();", 2000);

*/

		 //window.location.reload();

</script>



<?php get_footer(); ?>