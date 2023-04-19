<?php
$user = wp_get_current_user();
$rf = get_field('rf', 'user_' . $user->ID);
$email = $user->user_email;
$verifyEmail = explode('@', $email);

if($rf == $verifyEmail[0]){
    wp_redirect( home_url('index.php/perfil?atualizar=1') ); 
	exit;
}
?>

<?php get_header(); ?>
    <div class="container">
        <div class="row">
			<?php if($_GET['s'] && $_GET['s'] != ''): ?>

				<?php
					$countBusca = 0;

					if($_GET['s'] && $_GET['s'] != '')
						$countBusca++;

					if($_GET['categoria'] && $_GET['categoria'] != '')
						$countBusca++;

					if($_GET['date-ini'] && $_GET['date-ini'] != '')
						$countBusca++;

					if($_GET['date-end'] && $_GET['date-end'] != '')
						$countBusca++;

				?>

				<div class="col-md-12 mb-4 d-none d-md-block">
					<form class="form-recados" action="<?= get_home_url(); ?>">
						<div class="row">

							<div class="col-12">
								<div class="form-group">
									<label for="busca">Buscar por termo</label>
									<input type="text" value="<?= $_GET['s']; ?>" class="form-control" id="busca" name="s" placeholder="Busque por termo ou palavra-chave">
								</div>
							</div>

							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="categoria">Filtrar por categoria</label>
									<select class="form-control" id="categoria" name="categoria">
										<option value="" selected>Selecione uma categoria</option>
										<option value="destaque" <?= $_GET['categoria'] == 'destaque' ? 'selected' : ''; ?>>Recados</option>
										<option value="cursos" <?= $_GET['categoria'] == 'cursos' ? 'selected' : ''; ?>>Cursos</option>
										<option value="portais" <?= $_GET['categoria'] == 'portais' ? 'selected' : ''; ?>>Portais e Sistemas</option>
									</select>
								</div>
							</div>

							<div class="col-12 col-md-3">
								<div class="form-group">
									<label for="data-ini">Filtrar por intervalo de datas</label>
									<input type="date" id="data-ini" name="date-ini" value="<?= $_GET['date-ini']; ?>" max="<?= date("Y-m-d"); ?>" <?= $_GET['categoria'] == 'portais' ? 'disabled' : ''; ?>>
								</div>
							</div>

							<div class="col-12 col-md-3">
								<div class="form-group">
									<label for="data-end">&nbsp;</label>
									<input type="date" id="data-end" name="date-end" value="<?= $_GET['date-end']; ?>" max="<?= date("Y-m-d"); ?>" <?= $_GET['categoria'] == 'portais' ? 'disabled' : ''; ?>>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group d-flex justify-content-end">
									<button type="button" class="btn btn-outline-primary mr-3" id="limpar" onclick="window.location.href='<?= get_home_url() . '/?s=' . $_GET['s']; ?>'">Limpar filtros</button>
									<button type="submit" class="btn btn-primary">Filtrar</button>
								</div>
							</div>

						</div>
					</form>
				</div>

				<div class="col-12 d-md-none">
					<button type="button" class="btn btn-outline-primary btn-avanc-f btn-avanc btn-avanc-m mb-4" data-toggle="modal" data-target="#filtroBusca">
						<i class="fa fa-filter" aria-hidden="true"></i> Filtrar 
						<?php if($countBusca > 0): ?>
							<span class="badge badge-primary"><?php echo $countBusca; ?></span>
						<?php endif; ?>
					</button>
				</div>

				<div class="col-md-12 mb-4">

					<?php
						
						$allResults = array();
						$i = 0;
						
						$types = array('destaque', 'cursos', 'portais');
						if($_GET['categoria'] && $_GET['categoria'] != '')						
							$types = array($_GET['categoria']);

							//switch_to_blog( $site->blog_id );

							if(isset($_GET['s'])):
									$query = $_GET['s'];
									
									foreach($types as $type){

										if($type == 'cursos'){

											$qtd = 99;
											$url = 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-json/wp/v2/acervo/?per_page=' . $qtd . '&filter[categoria_acervo]=acesso-a-informacao';
											
											if($_GET['s'] && $_GET['s'] != ''){
												$busca = str_replace(' ', '+', $_GET['s']);
												$url .= '&search=' . $busca; 
											} 

											if($_GET['date-ini'] && $_GET['date-ini'] != '')
												$url .= '&after=' . $_GET['date-ini'] . 'T00:00:01';

											if($_GET['date-end'] && $_GET['date-end'] != '')
												$url .= '&before=' . $_GET['date-end'] . 'T23:59:59';  
												
											//echo $url;
										
											$headers = [];
											$ch = curl_init();
											curl_setopt($ch, CURLOPT_URL, $url);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
											curl_setopt($ch, CURLOPT_HEADERFUNCTION,
												function ($curl, $header) use (&$headers) {
													$len = strlen($header);
													$header = explode(':', $header, 2);
													if (count($header) < 2) // ignore invalid headers
														return $len;

													$headers[strtolower(trim($header[0]))][] = trim($header[1]);

													return $len;
												}
											);
											$response = curl_exec($ch);                
											
											$jsonArrayResponse = json_decode($response);
											

											if($jsonArrayResponse && $jsonArrayResponse[0] != ''){
												foreach($jsonArrayResponse as $curso){
													$allResults[$i]['id'] = $curso->id;
													$allResults[$i]['titulo'] = $curso->title->rendered;
													$allResults[$i]['url'] = $curso->link;
													$allResults[$i]['num_hom'] = $curso->numero_de_despacho_de_homologacao;
													$allResults[$i]['pg_do'] = $curso->pagina_do_diario_oficial;
													$allResults[$i]['type'] = 'cursos';
													$old_date_timestamp = strtotime($curso->date);        
													$data = getDay(date('w', $old_date_timestamp)) . ', ' . converter_mes(date('m', $old_date_timestamp)) . ' ' . date('d', $old_date_timestamp) . ' às ' . date('H\hi\m\i\n', $old_date_timestamp);
													$allResults[$i]['data_curso'] = $data;
													$allResults[$i]['area_promotora'] = $curso->area_promotora;
													$arquivo = '';
													if($curso->arquivo_acervo_digital && $curso->arquivo_acervo_digital != '')
														$arquivo = get_file_url($curso->arquivo_acervo_digital);
													
													if($curso->arquivos_particionados_0_arquivo && $curso->arquivos_particionados_0_arquivo != '')
														$arquivo = get_file_url($curso->arquivos_particionados_0_arquivo);
													
													$allResults[$i]['arquivo'] = $arquivo;

													$i++;
												}
											}

										} else {
											$after = '';
											$before = '';
											if($_GET['date-ini'] && $_GET['date-ini'] != '' && $type != 'portais')
												$after = $_GET['date-ini'];

											if($_GET['date-end'] && $_GET['date-end'] != '' && $type != 'portais')
												$before = $_GET['date-end'];

											$args = array( 
												's' => $query,
												'posts_per_page' => -1,
												'post_type' => $type,
												'post_status' => 'publish',
												'orderby' => 'relevance',
												'date_query' => array(
													array(
														'after'     => $after,
														'before'    => $before,
														'inclusive' => true,
													),
												),
											);

											// Incluir subtitulo da busca de noticias
											
											if($type == 'post'){
												$args['s_meta_keys'] = array('insira_o_subtitulo');
											}
								
											$the_query = new WP_Query( $args );
											

											// The Loop
											if ( $the_query->have_posts() ) {
												//echo '<ul>';
												//echo '<h3>Site: ' . $site->path . '</h3>';
												while ( $the_query->have_posts() ) {
													$the_query->the_post();
													//echo '<li>' . get_the_title() . ' - ' . $site->path . '( ' . get_post_type() . ' )' . '</li>';
													$allResults[$i]['id'] = get_the_id();
													$allResults[$i]['titulo'] = get_the_title();												
													$allResults[$i]['resumo'] = get_field('insira_o_subtitulo');												

													if($type == 'destaque'){
														$categorias = get_the_terms(get_the_ID(), 'categorias-destaque');
														$tags = get_the_terms(get_the_ID(), 'tags-destaque');
														$image = get_template_directory_uri() . '/img/categ-destaques.jpg';
														if($categorias)
															$image = get_field('imagem_principal', 'categorias-destaque_' . $categorias[0]->term_id);
															
													}

													$allResults[$i]['conteudo'] = get_the_content();
													$allResults[$i]['categorias'] = $categorias;
													$allResults[$i]['tags'] = $tags;												
													$allResults[$i]['url'] = get_field('insira_link');
													if($type == 'destaque')
														$allResults[$i]['url'] = get_field('insira_o_link');
													$allResults[$i]['url_video'] = get_field('url_do_video');
													$allResults[$i]['image_anexo'] = get_field('selecione_imagem');												
													$allResults[$i]['type'] = get_post_type();
													$allResults[$i]['image'] = $image;
													$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
													$allResults[$i]['alt']  = get_post_meta ( $thumbnail_id, '_wp_attachment_image_alt', true );
													$allResults[$i]['data_semana']  = getDay(get_the_date('w'));
													$allResults[$i]['data_dia_mes'] = get_the_date('M d');
													$allResults[$i]['data_hora']  = get_the_date('H\hi\m\i\n');												

													$i++;
												}
												//echo '</ul>';
											} else {
												// no posts found
											}
											/* Restore original Post Data */
											wp_reset_postdata();

										}

									}

							endif;
									
						

						//$type = array_column($allResults, 'type');
						//array_multisort($type, SORT_DESC, $allResults);
						

						$pagina = ! empty( $_GET['pagina'] ) ? (int) $_GET['pagina'] : 1;
						$total = count( $allResults ); //total items in array    
						$limit = 10; //per page    
						$totalPages = ceil( $total/ $limit ); //calculate total pages
						$pagina = max($pagina, 1); //get 1 page when $_GET['page'] <= 0
						$pagina = min($pagina, $totalPages); //get last page when $_GET['page'] > $totalPages
						$offset = ($pagina - 1) * $limit;
						if( $offset < 0 ) $offset = 0;

						$allResults = array_slice( $allResults, $offset, $limit );
						if($allResults):
							foreach($allResults as $result):
							?>
								<?php if($result['type'] == 'destaque'): ?>

									<div class="recado-categ">
										<p>Categoria: Recados</p>
									</div>
									<div class="recado">
										<div class="row">
											<div class="col-3 col-md-2 img-column">
												
												<?php
													$categorias = get_the_terms($result['id'], 'categorias-destaque');
													
													if($categorias)
														$image = get_field('imagem_principal', 'categorias-destaque_' . $categorias[0]->term_id);
														$i = 0;
												?>
												<?php if($image): ?>
													<img src="<?= $image['url']; ?>" class="img-fluid rounded d-none d-sm-none d-md-block" alt="Imagem de ilustração categoria">
                                    				<img src="<?= $image['sizes']['thumbnail']; ?>" class="img-fluid rounded d-md-none" alt="Imagem de ilustração categoria">
												<?php else: ?>
													<img src="<?= get_template_directory_uri(); ?>/img/categ-destaques.jpg" class="img-fluid rounded" alt="Imagem de ilustração categoria">
												<?php endif; ?>

											</div>

											<div class="col-9 col-md-10">
												
												<p class="data"><?= $result['data_semana']; ?>, <?= $result['data_dia_mes']; ?> às <?= $result['data_hora']; ?></p>
												
												<?php if($result['tags']): ?>
													<div class="tags-recados">
														<?php 
															foreach($result['tags'] as $tag){
																$cor = get_field('cor_principal', 'tags-destaque_' . $tag->term_id);
																echo '<a href="' . get_home_url() . '/index.php/mural-de-recados/?tag=' . $tag->term_id . '" target="_blank" style="background: ' . $cor . '">' . firstLetter($tag->name) . '</a> ';
															}
														?>
													</div>
												<?php endif; ?>

												
												<h2><?= $result['titulo']; ?></h2>
												<?php
													$subtitulo = $result['resumo'];
													if($subtitulo && $subtitulo != '')
														echo '<p>' . $subtitulo . '</p>';
												?>

												<?php if($result['categorias']): ?>
													<p class="categs">
														<?php
															$j = 0;
															foreach($result['categorias'] as $term){
																if($j == 0){
																	echo '<a href="' . get_home_url() . '/index.php/mural-de-recados/?categoria=' . $term->term_id . '">' . $term->name . '</a>';
																} else {
																	echo ', <a href="' . get_home_url() . '/index.php/mural-de-recados/?categoria=' . $term->term_id . '">' . $term->name . '</a>';
																}
																$j++;
															}                                        
														?>
													</p>
												<?php endif; ?>
												
												<hr>
												<a class="btn-collapse collapsed" data-toggle="collapse" href="#collapse<?= $result['id']; ?>" role="button" aria-expanded="false" aria-controls="collapse<?= $result['id']; ?>">
													<span class="button-more">ver mais <i class="fa fa-chevron-down" aria-hidden="true"></i></span><span class="button-less">ver menos <i class="fa fa-chevron-up" aria-hidden="true"></i></span>
												</a> 
												
											</div>
										</div>

										<div class="collapse" id="collapse<?=$result['id']; ?>">
											<div class="recado-content">
												<?php 
													$content = apply_filters('the_content', $result['conteudo']);
												?>
												<?= $content; ?>
												<?php if( $result['url'] ): ?>
													<p class="link-externo"><a href="<?= $result['url']; ?>">Ver link externo</a></p>
												<?php endif; ?>
											</div>
											<?php if($result['url_video']): ?>
												<div class="recado-video">
													<div class="embed-container">
														<?php the_field('url_do_video', $result['id']); ?>
													</div>                                    
												</div>
											<?php endif; ?>

											<?php if($result['image_anexo']): ?>
												<div class="recado-video">                                    
													<?php $imagem = $result['image_anexo']; ?>
													<img src="<?= $imagem['url']; ?>" alt="<?= $imagem['alt']; ?>">
												</div>
											<?php endif; ?>
										</div>

									</div>
								
								<?php elseif($result['type'] == 'portais'): ?>

									<div class="portais-categ">
										<p>Categoria: Portais e Sistemas</p>
									</div>

									<div class="lista-portais">
										<div class="portal">
											<div class="row">
												<div class="col-sm-2 d-flex justify-content-center">
													<?php
														$imagem = get_field('imagem_destacada', $result['id']);
														$imagemPadrao = get_template_directory_uri() . '/img/categ-portais.jpg';
														if($imagem['sizes']['admin-list-thumb'])
															$imagemPadrao = $imagem['sizes']['admin-list-thumb'];
													?>

													<a href="<?= get_field('insira_link', $result['id']); ?>" target="_blank"><img src="<?= $imagemPadrao; ?>" alt="Imagem de ilustração categoria" srcset=""></a>
														
												</div>

												<div class="col-sm-10">                                        
													<h3><a href="<?= get_field('insira_link', $result['id']); ?>" target="_blank"><?= $result['titulo']; ?></a></h3>
													<hr>
													<?php 
														$content = apply_filters('the_content', $result['conteudo']);
														echo $content;
													?>
												</div>                          
										</div>
									</div>
								<?php else: ?>
									
									<div class="cursos-categ">
										<p>Categoria: Cursos</p>
									</div>
									<div class="curso">
										<p class="date">
										
											<?php if($result['num_hom'] && $result['num_hom'] != ''): ?>
												Homologação <?= $result['num_hom']; ?> -                                 
											<?php endif; ?>
											<?= $result['data_curso']; ?>

											<?php if($result['pg_do'] && $result['pg_do'] != ''): ?>
												- página <?= $result['pg_do']; ?>                              
											<?php endif; ?>
										</p>
										<h2><a target="_blank" href="<?= $result['url']; ?>"><?= $result['titulo']; ?></a></h2>
										<?php if($result['area_promotora'] && $result['area_promotora'][0] != ''): ?>
											<p class="promotora"><strong>Área promotora: </strong>
												<?php
													$i = 0;
													foreach($result['area_promotora'] as $area){
														if($i == 0){
															echo get_tax_name('promotora', $area);
														} else {
															echo '/ ' . get_tax_name('promotora', $area);
														}
														$i++;
													}
												?>
											</p>
										<?php endif; ?>                        
										<hr>                        
									
										<?php
											$arquivo = $result['arquivo'];
											
											if($arquivo && $arquivo != ''){ 
																				
											?>                           

											<i class="fa fa-search" aria-hidden="true"></i> <a href="#modal-<?=$result['id']; ?>" class="link" data-toggle="modal" data-target="#modal-<?=$result['id']; ?>">Visualizar</a> / 

												<?php if(substr($arquivo, -3) == 'jpg' || substr($arquivo, -3) == 'jpeg' || substr($arquivo, -3) == 'png' || substr($arquivo, -3) == 'gif' || substr($arquivo, -3) == 'webp') : ?>
										
													<!-- Modal -->
													<div class="modal fade" id="modal-<?=$result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<p class="modal-title"><?= $result['titulo']; ?></p>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<?php if($arquivo) : ?>
																		<img src="<?php echo $arquivo; ?>" class="img-fluid d-block mx-auto py-2">
																	<?php else: ?>
																		<p>Visualização não disponível.</p>
																	<?php endif; ?>
																</div>															
															</div>
														</div>
													</div>

												<?php elseif(substr($arquivo, -3) == 'pdf'): ?>

													<div class="modal fade" id="modal-<?=$result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-xl">
															<div class="modal-content">

																<div class="modal-header">
																	<p class="modal-title"><?= $result['titulo']; ?></p>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>

																<div class="modal-body">
																	<div class="embed-responsive embed-responsive-16by9">                                                        
																		<iframe style="largura: 718px; altura: 700px;" src="<?= $arquivo; ?>" frameborder="0"></iframe>
																	</div>
																</div>

															</div>
														</div>
													</div>

												<?php else : ?>
													
													<div class="modal fade" id="modal-<?=$result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														<div class="modal-dialog modal-xl">
															<div class="modal-content">

																<div class="modal-header">
																	<p class="modal-title"><?= $result['titulo']; ?></p>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
																	<span aria-hidden="true">&times;</span>
																	</button>
																</div>

																<div class="modal-body">
																	<div class="embed-responsive embed-responsive-16by9">
																		<iframe title="doc" type="application/pdf" src="https://docs.google.com/gview?url=<?php echo $arquivo; ?>&amp;embedded=true" class="jsx-690872788 eafe-embed-file-iframe"></iframe>
																	</div>
																</div>

															</div>
														</div>
													</div>

												<?php endif;                              
											}
												
										?> 
									
										<a href="<?= $result['url']; ?>" class="link" target="_blank" rel="noopener noreferrer">Ver detalhes no Acervo Digital</a>

									</div>

								<?php endif; ?>
							<?php
							endforeach;
						else:
						?>
							<div class="no-results">
								<h2 class="search-title">
									<span class="azul-claro-acervo"><strong>0</strong></span><strong> 
										resultados</strong>
								</h2>
								<img src="<?php echo get_template_directory_uri(); ?>/img/search-empty.png" alt="Imagem ilustrativa para nenhum resultado de busca encontrado" />
								<p>Não há conteúdo disponível para o termo buscado. Por favor faça uma nova busca.</p>
							</div>
							

						<?php
						endif;
												

						$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
						$new_url = preg_replace('/&?pagina=[^&]*/', '', $actual_link);

						//echo $new_url;
						
					?>
					
					<?php if($allResults && $totalPages > 1):?>
						<div class="pagination-prog">
							<div class="wp-pagenavi">
								<div style="text-align: center;display: flex;align-items: center;justify-content: center; margin-top: 10px;">
									<a class="aaa paginationA " href="<?php echo $new_url . '&pagina=1'?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a><!--Ir para o primeiro-->
									<a class="1bbb paginationB <?=$pagina >= 4 ? 'ok' : 'd-none';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 3);?>"><?=$pagina - 3;?></a>
									<a class="2bbb paginationB <?=$pagina >= 3 ? 'ok' : 'd-none';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 2);?>"><?=$pagina - 2;?></a>
									<a class="3ccc paginationB <?=$pagina >= 2 ? 'ok' : 'd-none';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 1);?>"><?=$pagina - 1;?></a>
									<a class="eee paginationA active" href="<?php echo $new_url . '&pagina=' . $pagina;?>"><?=$pagina;?></a>
									<a class="4bbb paginationB <?=$totalPages > $pagina + 1 ? 'ok' : 'd-none';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 1);?>"><?=$pagina + 1;?></a>
									<a class="5bbb paginationB <?=$totalPages > $pagina + 2  ? 'ok' : 'd-none';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 2);?>"><?=$pagina + 2;?></a>
									<a class="6ccc paginationB <?=$totalPages > $pagina + 3 ? 'ok' : 'd-none';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 3);?>"><?=$pagina + 3;?></a>
									<a class="paginationB <?=$totalPages > 1 && $pagina != $totalPages ? 'ok' : 'd-none';?>" href="<?php echo $new_url . '&pagina=' . $totalPages;?>"><?=$totalPages;?></a>					
									<a class="d paginationA" href="<?php echo $new_url . '&pagina=' . $totalPages;?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a><!--Ir para o ultimo-->
								</div>
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

<!-- Modal -->
<div class="modal right fade" id="filtroBusca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<p class="modal-title" id="myModalLabel2">Filtrar por:</p>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>				
			</div>

			<div class="modal-body">
				<div class="acord-busca my-2">
					<form method="get" class="text-left" action="<?= get_home_url(); ?>">
						
                        <div class="row">
                            <div class="col-12">
								<div class="form-group">
									<label for="busca">Buscar por termo</label>
									<input type="text" value="<?= $_GET['s']; ?>" class="form-control" id="busca" name="s" placeholder="Busque por termo ou palavra-chave">
								</div>
							</div>

							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="categoria">Filtrar por categoria</label>
									<select class="form-control" id="categoria" name="categoria">
										<option value="" selected>Selecione uma categoria</option>
										<option value="destaque" <?= $_GET['categoria'] == 'destaque' ? 'selected' : ''; ?>>Recados</option>
										<option value="cursos" <?= $_GET['categoria'] == 'cursos' ? 'selected' : ''; ?>>Cursos</option>
										<option value="portais" <?= $_GET['categoria'] == 'portais' ? 'selected' : ''; ?>>Portais e Sistemas</option>
									</select>
								</div>
							</div>

							<div class="col-12 col-md-3">
								<div class="form-group">
									<label for="data-ini">Filtrar por intervalo de datas</label>
									<input type="date" id="data-ini" name="date-ini" value="<?= $_GET['date-ini']; ?>" max="<?= date("Y-m-d"); ?>" <?= $_GET['categoria'] == 'portais' ? 'disabled' : ''; ?>>
								</div>
							</div>

							<div class="col-12 col-md-3">
								<div class="form-group">
									<label for="data-end">&nbsp;</label>
									<input type="date" id="data-end" name="date-end" value="<?= $_GET['date-end']; ?>" max="<?= date("Y-m-d"); ?>" <?= $_GET['categoria'] == 'portais' ? 'disabled' : ''; ?>>
								</div>
							</div>

                            <div class="col-12 btn-filtro">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-primary mr-3" id="limpar" onclick="window.location.href='<?= get_home_url() . '/?s=' . $_GET['s']; ?>'">Limpar filtros</button>
                                    <button type="submit" class="btn btn-primary" id="filtrar">Filtrar</button>
                                </div>
                            </div>

                        </div>

					</form>
				</div>	
			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->

<?php get_footer(); ?>