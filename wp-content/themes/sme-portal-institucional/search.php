<?php 
	get_header(); 
	$eleitoral = get_field('ativar_periodo','periodo-eleitoral');
	$noticias = get_field('ocultar_noticias','periodo-eleitoral');
	$pages_hide = get_field('ocultar_paginas','periodo-eleitoral');
?>

	<div class="container">
		<div class="row">
						
			<?php if($_GET['s'] && $_GET['s'] != ''): ?>

				<div class="col-12 mb-5">
					<form action="<?= get_home_url() . '/'; ?>">
					
						<div class="form-row">

							<div class="form-group col">
								<div class="row">
									<div class="col-4 text-left">
										<label for="usr">Busque por um termo</label>
										<input class='form-control' type='text' name="s" placeholder='Buscar' value="<?=$_GET['s']?>"></input>
									
										<input id="enviar-busca-home" name="enviar-busca-home" type="hidden" class="btn btn-outline-secondary bt-search-topo" value="Buscar"> </input>
									</div>
									<div class="col-4 text-left">
										<label for="sel1">Filtre por tipo de conteúdo</label>
										<select name="tipoconteudo" class="form-control" id="sel1c">
											<option value="">Selecione o tipo</option>
											<option <?=$_GET['tipoconteudo'] == 'pagina' ? "selected" : '' ?> value="pagina">Página</option>
											<option <?=$_GET['tipoconteudo'] == 'noticia' ? "selected" : '' ?> value="noticia">Notícia</option>								
											
										</select>
										<script>

											jQuery('#sel1c').on('change', function() {                                
												var site = this.value;
												//console.log( site );

												// Função para remover o optgroup
												function removerOptgroup(label, labelshow) {
													jQuery('optgroup[label="' + label + '"]').hide();
													jQuery('optgroup[label="' + labelshow + '"]').show();
													jQuery('#sel3sites').val('');
												}

												// validacao de selecao

												if(site == 'pagina'){
													removerOptgroup('NOTÍCIA', 'PÁGINA');
												} else if(site == 'noticia' || site == ''){
													jQuery('optgroup[label="NOTÍCIA"]').show();
													jQuery('optgroup[label="PÁGINA"]').show();
													jQuery('#sel3sites').val('');
												}
												

												//jQuery("#sel3sites option:selected").removeAttr("selected");
												//jQuery("#sel3sites").val(sites[site]);
											});
										</script>
									</div>
									<div class="col-4 text-left">
										<label for="sel3sites">Filtre por detalhe</label>
										<select name="site" class="form-control" id="sel3sites">

											<option value="">Selecionar</option>
											
											<optgroup label="NOTÍCIA" <?=$_GET['tipoconteudo'] == 'pagina' ? "style='display: none;'" : '' ?>>
												<option <?=$_GET['site'] == '1' ? "selected" : '' ?> value="1">SME Portal</option>								
												<option <?=$_GET['site'] == '23' ? "selected" : '' ?> value="23">DRE Butantã</option>								
												<option <?=$_GET['site'] == '83' ? "selected" : '' ?> value="83">DRE Campo Limpo</option>								
												<option <?=$_GET['site'] == '115' ? "selected" : '' ?> value="115">DRE Capela do Socorro</option>								
												<option <?=$_GET['site'] == '114' ? "selected" : '' ?> value="114">DRE Freguesia/Brasilândia</option>								
												<option <?=$_GET['site'] == '81' ? "selected" : '' ?> value="81">DRE Guaianases</option>								
												<option <?=$_GET['site'] == '48' ? "selected" : '' ?> value="48">DRE Ipiranga</option>								
												<option <?=$_GET['site'] == '75' ? "selected" : '' ?> value="75">DRE Itaquera</option>								
												<option <?=$_GET['site'] == '89' ? "selected" : '' ?> value="89">DRE Jaçanã/Tremembé</option>								
												<option <?=$_GET['site'] == '113' ? "selected" : '' ?> value="113">DRE Penha</option>								
												<option <?=$_GET['site'] == '37' ? "selected" : '' ?> value="37">DRE Pirituba</option>								
												<option <?=$_GET['site'] == '31' ? "selected" : '' ?> value="31">DRE Santo Amaro</option>							
												<option <?=$_GET['site'] == '42' ? "selected" : '' ?> value="42">DRE São Mateus</option>								
												<option <?=$_GET['site'] == '112' ? "selected" : '' ?> value="112">DRE São Miguel</option>                                    
											</optgroup>
										</select>
									</div>
								</div>

							</div>

							<div class="form-group mb-3 col-2 d-flex align-items-end justify-content-between">
								<script>
									function limpaFiltro() {
										setTimeout(() => {
											window.location = window.location.pathname + "?s=<?=$_GET['s'];?>";
										}, 100);
									}
								</script>
								<button onclick="limpaFiltro()" type="button" class="btn btn-refinar btn-sm float-left" style="width: 48%;">Limpar filtros</button>
								<button type="submit" class="btn btn-primary btn-sm float-right" style="width: 48%;">Buscar</button>

							</div>
						</div>

					</form>
				</div>

				<div class="col-12 col-lg-8 mb-4">

				<?php
					$types = ($eleitoral && $noticias) 
					? array('page', 'programa-projeto', 'card') 
					: array('page', 'programa-projeto', 'card', 'post');
				
					if (!empty($_GET['tipoconteudo'])) {
						$arr = preg_split('/(?<=[a-z])(?=[0-9]+)/i', $_GET['tipoconteudo']);
						$tipoconteudo = $arr[0] ?? '';
					
						$types = str_contains($tipoconteudo, 'pagina') 
							? array('page', 'programa-projeto', 'card') 
							: (str_contains($tipoconteudo, 'noticia') && !$eleitoral 
								? array('post') 
								: $types);
					}

					$paged = !empty( $_GET['pagina'] ) ? (int) $_GET['pagina'] : 1;

					$args = array(
						'post_type'      => $types,
						'post_status'    => 'publish',
						'posts_per_page' => 10,
						'orderby'        => 'date',
						'order'          => 'DESC',
						's'              => $_GET['s'],
						'paged'          => $paged,
					);

					if($eleitoral){
						$types = array('page', 'programa-projeto', 'card');
					} else {
						$types = array('page', 'programa-projeto', 'card', 'post');
					}

					// Paginas a serem ocultas no periodo eleitoral
					if($eleitoral && $pages_hide){
						$args['post__not_in'] = $pages_hide;
					}

					// Filtrar por categoria
					if($_GET['site'] && $_GET['site'] != ''){
						$args['cat'] = $_GET['site'];
					}

					// The Query.
					$the_query = new WP_Query( $args );

					// The Loop.
					if ( $the_query->have_posts() ) {
						
						while ( $the_query->have_posts() ) {
							$the_query->the_post();

							// Verifica se o post tem um subtítulo
							if( get_field('insira_o_subtitulo') ){
								$resumo = get_field('insira_o_subtitulo');
							} else {
								$resumo = get_the_excerpt();
							}

							$imagem = get_the_post_thumbnail_url(get_the_ID(), 'medium');

							// Verifica se a URL existe e não retorna 404
							if ( $imagem ) {
								$response = wp_remote_head($imagem); 
								$status_code = wp_remote_retrieve_response_code($response);

								if ( $status_code !== 200 ) {
									$imagem = ''; 
								}
							} else {
								$imagem = ''; 
							}

							$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
							$alt = get_post_meta ( $thumbnail_id, '_wp_attachment_image_alt', true );
							
						?>
								<div class="row">
									<div class="col-sm-4">
										
										<?php if($imagem && $imagem != ''): ?>
											<figure>
												<?php $alt != '' ? $alt : get_the_title(); ?>
												<img class="img-fluid rounded float-left" src="<?= $imagem; ?>" alt="<?= $alt; ?>" width="100%">
											</figure>
										<?php else: ?>
											<figure>
												<img class="img-fluid rounded float-left" src="<?php echo esc_url( get_field( 'imagem_placeholder', 'placeholders' )['url'] ?? '' ); ?>" width="100%">
											</figure>
										<?php endif; // Imagem ?>
										
									</div>
									<div class="col-sm-8">
										<h2><a href="<?= get_the_permalink(); ?>"> <?= get_the_title(); ?></a></h2>								
										<p><?= $resumo; ?></p>   <!--Mostra resumo-->
																		
										<?php if(get_post_type() != ''): ?>
											<strong>Tipo:</strong> 
											<span class="tagcolor">
												<?php $tipopost = get_post_type();
												if( $tipopost == "post" ) echo  'Notícia';
												if( $tipopost == "programa-projeto" ) echo  'Página';
												if( $tipopost == "card" ) echo  'página';
												if( $tipopost == "page" ) echo  'Página'; ?>
											</span><br>
										<?php endif; ?>
										
										<span><strong>Publicado em:</strong> <?= get_the_time('d/m/Y G\hi'); ?> </span><br>

									</div>

								</div>
								<hr>
						<?php
						} // end while
						
						
					} else { ?>
						<div class="no-results">
							<h2 class="search-title">
								<span class="azul-claro-acervo"><strong>0</strong></span><strong> 
									resultados</strong>
							</h2>
							<img src="<?php echo get_template_directory_uri(); ?>/img/search-empty.png" alt="Imagem ilustrativa para nenhum resultado de busca encontrado" />
							<p>Não há conteúdo disponível para o termo buscado. Por favor faça uma nova busca.</p>
						</div>
					<?php }

					$i = 0;
					$totalPages = $the_query->max_num_pages;
					$pagina = !empty( $_GET['pagina'] ) ? (int) $_GET['pagina'] : 1;
					$pagina = max($pagina, 1); //get 1 page when $_GET['page'] <= 0
					$pagina = min($pagina, $totalPages); //get last page when $_GET['page'] > $totalPages

					$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					$new_url = preg_replace('/&?pagina=[^&]*/', '', $actual_link);
					
					// Restaure os dados originais da postagem.
					wp_reset_postdata();

				?>

				<?php if($totalPages > 1):?>
					<div style="width:100%;text-align: center;">
						<div class="pagination <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']) > 1 && $GLOBALS['i'] !== $GLOBALS['paginacao'] ? 'ok' : 'dddnone';?>">
							<a href="<?php echo $new_url . '&pagina=' . ($pagina - 1);?>" class="anterior <?=$pagina > 1 ? 'ok' : 'dnone';?>">Anterior</a><!--Ir para o anterior-->
							<a class="aaa paginationA " href="<?php echo $new_url . '&pagina=1'?>">&laquo;</a><!--Ir para o primeiro-->                       
							
							
							<a class="1bbb paginationB <?=$pagina >= 4 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 3);?>"><?=$pagina - 3;?></a>
							<a class="2bbb paginationB <?=$pagina >= 3 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 2);?>"><?=$pagina - 2;?></a>
							<a class="3ccc paginationB <?=$pagina >= 2 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 1);?>"><?=$pagina - 1;?></a>

							
							<a class="eee paginationA active" href="<?php echo $new_url . '&pagina=' . $pagina;?>"><?=$pagina;?></a>

							<a class="4bbb paginationB <?=$totalPages > $pagina + 1 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 1);?>"><?=$pagina + 1;?></a>
							<a class="5bbb paginationB <?=$totalPages > $pagina + 2  ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 2);?>"><?=$pagina + 2;?></a>
							<a class="6ccc paginationB <?=$totalPages > $pagina + 3 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 3);?>"><?=$pagina + 3;?></a>

							<span class="paginationB <?=$totalPages > 1 && $pagina != $totalPages ? 'ok' : 'dnone';?>">...</span>
							<a class="paginationB <?=$totalPages > 1 && $pagina != $totalPages ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . $totalPages;?>"><?=$totalPages;?></a>
												
							<a class="d paginationA" href="<?php echo $new_url . '&pagina=' . $totalPages;?>">»</a><!--Ir para o ultimo-->
							<a href="<?php echo $new_url . '&pagina=' . ($pagina + 1);?>" class="proximo <?=$pagina != $totalPages  ? 'ok' : 'dnone';?>">Próximo</a><!--Ir para o próximo-->
						</div>
					</div>
				<?php endif; ?>
					
				</div>

			<?php else: ?>

				<div class="col-12">
					<p>Nenhum termo foi digitado.</p> 
					<p>Por favor faça uma nova pesquisa.</p>
				</div>

			<?php endif; ?>
				
		</div>
	</div>

<?php get_footer(); ?>