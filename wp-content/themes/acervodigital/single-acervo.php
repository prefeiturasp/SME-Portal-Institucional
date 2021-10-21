<?php get_header(); 

function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>

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
					$indice = count($stringSeparada);
					$indice = $indice - 1;
					$type = get_post_type();
					$postid = get_the_ID();

					$class = generateRandomString();

					$partional = array();

					// Check value exists.
					if( have_rows('arquivos_particionados') ):

						// Loop through rows.
						while ( have_rows('arquivos_particionados') ) : the_row();
							
							if( get_row_layout() == 'adicionar_arquivos' ):
								$text = get_sub_field('arquivo');
								$partional[] = $text;													
							endif;

						// End loop.
						endwhile;

					endif;

					$tipo = get_field('tipos_de_documentos'); // Tipo de documento
				?>

				<div class="col-sm-12 mb-4">
					<a href="javascript:history.back()"><i class="fa fa-chevron-left" aria-hidden="true"></i> Voltar ao resultado de busca</a>
				</div>

				<div class="col-sm-12 d-lg-none d-xl-none">
					<p class='title-acervo title-mobile'><strong><?php the_title(); ?></strong></p>
					<div class="infos mt-3 d-flex justify-content-between">
						<p>
							<?php 
								$categories = get_the_terms(get_the_ID(), 'categoria_acervo' );
								$n = 0;
								foreach($categories as $categoria){
									if($n == 0){
										echo "<a href='" . get_home_url() . "/?avanc=1&categ=1&s=&categ_acervo=" . $categoria->term_id . "'>" . $categoria->name . "</a>";
									} else {
										echo " / <a href='" . get_home_url() . "/?avanc=1&categ=1&s=&categ_acervo=" . $categoria->term_id . "'>" . $categoria->name . "</a>";
									}
									$n++;
								}									
							?>
						</p>
					</div>
				</div>

				<div class="col-md-4 col-12">

					<div class="mask-detail">
						<img src="<?php
							  if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[$indice] == 'pdf'){
								 echo $file['icon']; 
							  }else if(get_field('substituir_capa_acervo_digital') == '' && ($stringSeparada[$indice] == 'xlsx' || $stringSeparada[$indice] == 'xls') ){
								echo 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-xls.jpg';
							  }else if(get_field('substituir_capa_acervo_digital') == '' && ($stringSeparada[$indice] == 'docx' || $stringSeparada[$indice] == 'doc') ){
								echo 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-doc.jpg';
							  }else if(get_field('substituir_capa_acervo_digital') == '' && ($stringSeparada[$indice] == 'pptx' || $stringSeparada[$indice] == 'ppt') ){
								echo 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-doc.jpg';
							  }else if(get_field('substituir_capa_acervo_digital') != ''){
								 echo get_field('substituir_capa_acervo_digital'); 
							  }else if($file['url']){
								 echo $file['url'];
							  } else {
								  echo 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-doc.jpg';
							  }
							  ?>" alt="<?php the_field('campo_alt_acervo_digital'); ?>" class='shadow-sm img-mobile'>
					</div>
					<?php 
						if($file['url'] != ''){
							$url = $file['url']; 
						} elseif($partional){
							$url = $partional[0];
							$stringSeparada = explode(".", $url);
							$indice = count($stringSeparada);
							$indice = $indice - 1;
						}else{
							$url = false;
						}
					?>
					
						<button type="button" class="btn btn-view mb-2" data-toggle="modal" data-target=".<?php echo $class; ?>"><i class="fa fa-search" aria-hidden="true"></i> Visualizar</button>
					
						<?php if($stringSeparada[$indice] == 'jpg' || $stringSeparada[$indice] == 'jpeg' || $stringSeparada[$indice] == 'png' || $stringSeparada[$indice] == 'gif' || $stringSeparada[$indice] == 'webp') : ?>

												

							<div class="modal <?php echo $class; ?>" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<p class="modal-title"><?php the_title(); ?></p>
											<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<?php if($url) : ?>
												<img src="<?php echo $url; ?>" class="img-fluid d-block mx-auto py-2">
											<?php else: ?>
												<p>Visualização não disponível.</p>
											<?php endif; ?>
										</div>															
									</div>
								</div>
							</div>

						<?php else : ?>

							<div class="modal fade bd-example-modal-lg <?php echo $class; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-xl">

									

									<div class="modal-content">

										<div class="modal-header">
											<p class="modal-title"><?php the_title(); ?></p>
											<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body">
											<div class="embed-responsive embed-responsive-16by9">
												<iframe title="doc" type="application/pdf" src="https://docs.google.com/gview?url=<?php echo $url; ?>&amp;embedded=true" class="jsx-690872788 eafe-embed-file-iframe"></iframe>
											</div>
										</div>

									</div>
								</div>
							</div>

						<?php endif; ?>

					<?php
						if($file['url'] != ''){
							?>
							<a href="<?php echo $file['url']; ?>" id="download_link" target="_blank" download>
								<button type="button" class="btn btn-down btn-primary mb-2"><i class="fa fa-download" aria-hidden="true"></i> Baixar documento</button>
							</a>
							<?php
						}
					?>
							

						<?php
							if(!$file){
								$a = 1;
								if( have_rows('arquivos_particionados') ):
								?>
									<div class="dropdown" style="display: initial;">
										<button class="btn btn-down btn-primary mb-1 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Baixar documento
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<?php
												while ( have_rows('arquivos_particionados') ) : the_row();
													if( get_row_layout() == 'adicionar_arquivos' ):
														?>
														<a href="<?php echo $text = get_sub_field('arquivo'); ?>" class="dropdown-item" id="download_link" target="_blank" download>
															Baixar Arquivo <?php echo $a++; ?>
														</a>
														<?php
													endif;
												endwhile;											
										?>
										</div>
									</div>
									
								<?php
								endif;
								
							}
						?>

					<?php if(get_field('diario_oficial') && $tipo == 'proposta_formativa'): ?>
							<a href="<?php the_field('diario_oficial') ?>" id="download_link" target="_blank" download>
								<button type="button" class="btn btn-primary mb-2 btn-diario">Ver no Diário Oficial</button>
							</a>
					<?php endif; ?>
										
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

					$allItens = array();
					$allItens['modalidade'] = get_field('modalidade_acervo_digital'); // Modalidade
					$allItens['componente'] = get_field('componente_acervo_digital'); // Componente
					$allItens['mes'] = get_field('mes_da_publicacao_acervo_digital'); // Mes			
					$allItens['ano'] = get_field('ano_da_publicacao_acervo_digital'); // Ano
					$allItens['formacao'] = get_field('formacao_acervo_digital'); // Tipo de Formação
					$allItens['promotora'] = get_field('area_promotora'); // Area Promotora
					$allItens['alvo'] = get_field('publico_alvo'); // publico_alvo
					$allItens['despacho'] = get_field('numero_de_despacho_de_homologacao'); // Numero Despacho
					$allItens['proposta'] = get_field('numero_da_proposta_de_validacao'); // Numero Proposta
					$allItens['comunicado'] = get_field('numero_do_comunicado'); // Numero Comunicado
					$allItens['periodo'] = get_field('periodo_de_inscricao'); // Periodo Inscricao
					
					$allItens['autor'] = get_field('autor_acervo_digital'); // Autor
					$allItens['setor'] = get_field('setor_acervo_digital'); // Setor
					$allItens['idioma'] = get_field('idioma_acervo_digital'); //Idioma
					$allItens['pagina'] = get_field('pagina_do_diario_oficial'); //Pagina Diario Oficial
					
					// Tipo
					if($partional && !$file){
						$formats = array();
						foreach($partional as $format){
							$format = explode(".", $format);
							$formats[] = $format[6];											
						}
						// Remover formatos duplicados
						$formats = array_unique($formats);
						$allItens['tipo'] = implode(", ", $formats);						
					}
					elseif($stringSeparada[1] != ''){
						$allItens['tipo'] = $stringSeparada[1];
					}else{
						$allItens['tipo'] = 'DIVERSOS';
					}
					// Tamanho
					if( $file['filesize']  != ''){
						$allItens['tamanho'] = size_format( $file['filesize'] );
					}else{
						$allItens['tamanho'] = 'INDEFINIDO';
					}
					// Qtd Visualizações					
					function title_filter_total( $where, &$wp_query ){
						global $wpdb;
						if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
							$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( like_escape( $search_term ) ) . '\'';
						}
						return $where;
					}

					function retornaNumero_total($posttype) {	
						$args = array(
							'post_type' => $posttype,
							'posts_per_page' => -1,
							'search_prod_title' => get_the_title(),
							'post_status' => 'publish',
							'orderby'     => 'title', 
							'order'       => 'ASC'
						);

						add_filter( 'posts_where', 'title_filter_total', 10, 2 );
						$wp_query = new WP_Query($args);
						remove_filter( 'posts_where', 'title_filter_total', 10 );

						$contador = 0;
						echo '<div style="display: none">';
						$artigo = get_posts(
							array(
								's' => 'Alimentação Escolar',
								'post_type' => $posttype,
								'numberposts' => -1,
								'post_status' => 'any',
							));
						echo '</div>';

						foreach ($artigo as $article) { 
						$contador++;
						//var_dump($article);
						}
						//return $contador;
						return $wp_query->found_posts;
					}
					$allItens['views'] = retornaNumero_total(('acesso'));

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
			
			
						<div class="col-md-8">
						<div class="row">
						<div class="col-sm-12 mb-4">
							<h1 class='title-acervo d-none d-lg-block d-xl-block'><strong><?php the_title(); ?></strong></h1>
							<div class="infos mt-3 d-flex justify-content-between">
								<p class='d-none d-lg-block d-xl-block'>
									<?php 
										$categories = get_the_terms(get_the_ID(), 'categoria_acervo' );
										$n = 0;
										foreach($categories as $categoria){
											if($n == 0){
												echo "<a href='" . get_home_url() . "/?avanc=1&categ=1&s=&categ_acervo=" . $categoria->term_id . "'>" . $categoria->name . "</a>";
											} else {
												echo " / <a href='" . get_home_url() . "/?avanc=1&categ=1&s=&categ_acervo=" . $categoria->term_id . "'>" . $categoria->name . "</a>";
											}
											$n++;
										}									
									?>
								</p>
								<div class="share">
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
							</div>
							
						</div>

						<div class="col-sm-12 tabs-acervo">
							<ul class="nav nav-tabs">
								<li><a data-toggle="tab" href="#descri" class="active">Descrição</a></li>
								<li><a data-toggle="tab" href="#especi">Especificações</a></li>
							</ul>

							<div class="tab-content">
								<div id="descri" class="tab-pane fade in active show">
									<p><?php the_field('descricao_acervo_digital'); ?></p>
								</div>
								<div id="especi" class="tab-pane fade">
									<div class="row table-especificacoes">
									<?php
										$contador = 0;
										foreach($allItens as $chave => $item){
												
											if($allItens[$chave] != '' || $allItens[$chave][0] != ''){
												$contador++;

												if($chave == 'modalidade'): ?>
													<div class="col-6 espec-element">
														<strong>Modalidade de ensino</strong><br>
														<?php
														$modalidades = $item;

														if($modalidades != '' && ($tipo == 'publicacoes_institucionais' || $tipo == 'proposta_formativa') ){
															$n = 0;									
															if( $modalidades ):
																foreach( $modalidades as $modalidade ):
																	if($n == 0){
																		echo "<a href='" . get_home_url() . "/?avanc=1&modal=1&s=&modalidade%5B%5D=" . $modalidade->term_id . "'>" . $modalidade->name . "</a>";
																	} else {
																		echo " / <a href='" . get_home_url() . "/?avanc=1&modal=1&s=&modalidade%5B%5D=" . $modalidade->term_id . "'>" . $modalidade->name . "</a>";
																	}
																	$n++;																
																endforeach;
															endif; 
														}
														?>
													</div>
												<?php elseif($chave == 'componente'): ?>
													<div class="col-6 espec-element">
														<strong>Componente curricular</strong><br>
														<?php
															$terms = $item;
															if($item != '' /*&& $tipo == 'publicacoes_institucionais'*/ ){
																$n = 0;
																if( $terms ):
																	foreach( $terms as $term ):
																		if($n == 0){
																			echo "<a href='" . get_home_url() . "/?avanc=1&comp=1&s=&componente%5B%5D=" . $term->term_id . "'>" . $term->name . "</a>";
																		} else {
																			echo " / <a href='" . get_home_url() . "/?avanc=1&comp=1&s=&componente%5B%5D=" . $term->term_id . "'>" . $term->name . "</a>";
																		}
																		$n++;															
																	endforeach;
																endif;  
															} 
														?>
													</div>
												<?php elseif($chave == 'formacao'): ?>
													<div class="col-6 espec-element">
														<strong>Tipo de Formação</strong><br>
														<?php
															$terms = $item;
															if($item != '' /*&& $tipo == 'publicacoes_institucionais'*/ ){
																$n = 0;
																if( $terms ):
																	foreach( $terms as $term ):
																		if($n == 0){
																			echo "<a href='" . get_home_url() . "/?avanc=1&forma=1&s=&formab[]=" . $term->term_id . "'>" . $term->name . "</a>";
																		} else {
																			echo " / <a href='" . get_home_url() . "/?avanc=1&forma=1&s=&formab[]=" . $term->term_id . "'>" . $term->name . "</a>";
																		}
																		$n++;															
																	endforeach;
																endif;  
															} else {
																echo "-";
															}
														?>
													</div>
												<?php elseif($chave == 'promotora'): ?>
													<div class="col-6 espec-element">
														<strong>Área promotora</strong><br>
														<?php
															$terms = $item;
															if($item != '' /*&& $tipo == 'publicacoes_institucionais'*/ ){
																$n = 0;
																if( $terms ):
																	foreach( $terms as $term ):
																		if($n == 0){
																			echo "<a href='" . get_home_url() . "/?avanc=1&area=1&s=&areab=" . $term->term_id . "'>" . $term->name . "</a>";
																		} else {
																			echo " / <a href='" . get_home_url() . "/?avanc=1&area=1&s=&areab=" . $term->term_id . "'>" . $term->name . "</a>";
																		}
																		$n++;															
																	endforeach;
																endif;  
															}
														?>
													</div>
												<?php elseif($chave == 'alvo'): ?>
													<div class="col-6 espec-element">
														<strong>Público alvo</strong><br>
														<?php
															$terms = $item;
															if($item != '' /*&& $tipo == 'publicacoes_institucionais'*/ ){
																$n = 0;
																if( $terms ):
																	foreach( $terms as $term ):
																		if($n == 0){
																			echo "<a href='" . get_home_url() . "/?avanc=1&alvo=1&s=&alvob=" . $term->term_id . "'>" . $term->name . "</a>";
																		} else {
																			echo " / <a href='" . get_home_url() . "/?avanc=1&alvo=1&s=&alvob=" . $term->term_id . "'>" . $term->name . "</a>";
																		}
																		$n++;															
																	endforeach;
																endif;  
															} 
														?>
													</div>															
												<?php elseif($chave == 'autor'): ?>
													<div class="col-6 espec-element">
														<strong>Autor</strong><br>
														<?php
															$autores = $item;
															if($autores != '' || $autores[0] != ''){
																$n = 0;
																if( $autores ):
																	foreach( $autores as $autor ):
																		if($n == 0){
																			echo "<a href='" . get_home_url() . "/?avanc=1&aut=1&s=&autor=" . $autor->slug . "'>" . $autor->name . "</a>";
																		} else {
																			echo " / <a href='" . get_home_url() . "/?avanc=1&aut=1&s=&autor=" . $autor->slug . "'>" . $autor->name . "</a>";
																		}
																		$n++;																	
																	endforeach;
																endif;
															}
														?>
													</div>
												<?php elseif($chave == 'setor'): ?>
													<div class="col-6 espec-element">
														<strong>Setor</strong><br>
														<?php
															$setores = $item;
															if($setores != '' || $setores[0] != 0){
																$n = 0;
																if( $setores ):
																	foreach( $setores as $setor ):
																		if($n == 0){
																			echo "<a href='" . get_home_url() . "/?avanc=1&set=1&s=&setor%5B%5D=" . $setor->term_id . "'>" . $setor->name . "</a>";
																		} else {
																			echo " / <a href='" . get_home_url() . "/?avanc=1&set=1&s=&setor%5B%5D=" . $setor->term_id . "'>" . $setor->name . "</a>";
																		}
																		$n++;																	
																	endforeach;
																endif;
															}
														?>
													</div>
												<?php elseif($chave == 'despacho'): ?>
													<div class="col-6 espec-element">
														<strong>Nº de despacho de homologação</strong><br>
														<?php echo "<a href='" . get_home_url() . "/?avanc=1&desp=1&s=&despb=" . $item . "'>" . $item . "</a>"; ?>
													</div>
												<?php elseif($chave == 'pagina'): ?>
													<div class="col-6 espec-element">
														<strong>Página do Diário Oficial</strong><br>
														<?php echo $item; ?>
													</div>
												<?php elseif($chave == 'proposta'): ?>
													<div class="col-6 espec-element">
														<strong>Nº da proposta de validação</strong><br>
														<?php echo $item; ?>
													</div>
												<?php elseif($chave == 'comunicado'): ?>
													<div class="col-6 espec-element">
														<strong>Número do comunicado</strong><br>
														<?php echo $item; ?>
													</div>
												<?php elseif($chave == 'periodo'): ?>
													<div class="col-6 espec-element">
														<strong>Período de inscrição</strong><br>
														<?php echo $item; ?>
													</div>
												<?php elseif($chave == 'mes'):?>
													<div class="col-6 espec-element">
														<strong>Mês de publicação</strong><br>
														<?php echo $item; ?>
													</div>
												<?php elseif($chave == 'ano'):?>
													<div class="col-6 espec-element">
														<strong>Ano de publicação</strong><br>
														<?php echo "<a href='" . get_home_url() . "/?avanc=1&tano=1&s=&ano%5B%5D=" . $item . "'>" . $item . "</a>";?>
													</div>
												<?php elseif($chave == 'tipo'):?>
													<div class="col-6 espec-element">
														<strong>Tipo</strong><br>
														<span class="upper"><?php echo $item; ?></span>
													</div>
												<?php elseif($chave == 'tamanho'): ?>
													<div class="col-6 espec-element">
														<strong>Tamanho do documento</strong><br>
														<?php echo $item; ?>
													</div>
												<?php elseif($chave == 'idioma'): ?>
													<div class="col-6 espec-element">
														<strong>Idioma</strong><br>
														<?php
															$idiomas = $item;
															if($idiomas != '' || $idiomas[0] != ''){
																$n = 0;
																if( $idiomas ):
																	foreach( $idiomas as $idioma ):
																		if($n == 0){
																			echo "<a href='" . get_home_url() . "/?avanc=1&idi=1&s=&idioma%5B%5D=" . $idioma->term_id . "'>" . $idioma->name . "</a>";
																		} else {
																			echo " / <a href='" . get_home_url() . "/?avanc=1&idi=1&s=&idioma%5B%5D=" . $idioma->term_id . "'>" . $idioma->name . "</a>";
																		}
																		$n++;															
																	endforeach;
																endif;
															}
														?>
													</div>															
												<?php elseif($chave == 'views'): ?>
													<div class="col-6 espec-element">
														<strong>Número de visualizações</strong><br>
														<?php echo $item; ?>
													</div>
												<?php endif;
											}
										}

										//print_r($contador);
									?>

									<?php if($contador % 2 == 1): ?>
										<div class="col-6 espec-element">&nbsp;</div>
									<?php endif; ?>

									<?php 
										$palavras = get_the_terms(get_the_ID(), 'palavra' );
										if($palavras != '' || $palavras[0] != ''):
									?>
																						
											<div class="col-12 espec-element">
												<strong>Palavras-chave</strong><br>
												<span class='single-palavras'>
													<?php
														
														$n = 0;
														if($palavras){
															foreach($palavras as $palavra){
																if($n == 0){
																	echo "<a href='" . get_home_url() . "/?avanc=1&chave=1&s=&palavra=" . $palavra->term_id . "'>" . $palavra->name . "</a>";
																} else {
																	echo " <a href='" . get_home_url() . "/?avanc=1&chave=1&s=&palavra=" . $palavra->term_id . "'>" . $palavra->name . "</a>";
																}
																$n++;
															}
														} else {
															echo "-";
														}
														
													?>
												</span>
											</div>
										
									<?php endif; ?>
								</div>								
							</div>
						</div>

						<div class="col-12 mb-3">
						
						</div>	
					</div>
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

}	jQuery( "#download_link" ).click(function() {

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