<?php
/*
 * Template Name: Página Busca
 * Description: Página Abas, página que exibe título, texto, contato e categoria de botões
 */
?>

<?php get_header(); ?>
    <div class="container">
        <div class="row">
			<?php if($_GET['busca_s'] && $_GET['busca_s'] != ''): ?>

				<div class="col-12 mb-5">
					<form action="<?= get_home_url() . '/busca-validacao'; ?>">
                    
                        <div class="form-row">

                            <div class="form-group col">
                                <div class="row">
                                    <div class="col-4 text-left">
                                        <label for="usr">Busque por um termo</label>
                                        <input class='form-control' type='text' name="busca_s" placeholder='Buscar' value="<?=$_GET['busca_s']?>"></input>
                                    
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
                                                } else if(site == 'noticia'){
                                                    removerOptgroup('PÁGINA', 'NOTÍCIA');
                                                } else {
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
                                            <optgroup label="PÁGINA" <?=$_GET['tipoconteudo'] == 'noticia' ? "style='display: none;'" : '' ?>>
                                                <option <?=$_GET['site'] == 'portal' ? "selected" : '' ?> value="portal">SME Portal Educação</option>								
                                            </optgroup>
                                            
                                            <optgroup label="NOTÍCIA" <?=$_GET['tipoconteudo'] == 'pagina' ? "style='display: none;'" : '' ?>>
                                                <option <?=$_GET['site'] == 'noticia-portal1' ? "selected" : '' ?> value="noticia-portal1">SME Portal</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-butanta1' ? "selected" : '' ?> value="noticia-dre-butanta1">DRE Butantã</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-campo-limpo1' ? "selected" : '' ?> value="noticia-dre-campo-limpo1">DRE Campo Limpo</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-capela-socorro1' ? "selected" : '' ?> value="noticia-dre-capela-socorro1">DRE Capela do Socorro</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-freguesia-brasilandia1' ? "selected" : '' ?> value="noticia-dre-freguesia-brasilandia1">DRE Freguesia/Brasilândia</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-guaianases1' ? "selected" : '' ?> value="noticia-dre-guaianases1">DRE Guaianases</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-ipiranga1' ? "selected" : '' ?> value="noticia-dre-ipiranga1">DRE Ipiranga</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-itaquera1' ? "selected" : '' ?> value="noticia-dre-itaquera1">DRE Itaquera</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-jacana-tremembe1' ? "selected" : '' ?> value="noticia-dre-jacana-tremembe1">DRE Jaçanã/Tremembé</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-penha1' ? "selected" : '' ?> value="noticia-dre-penha1">DRE Penha</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-pirituba1' ? "selected" : '' ?> value="noticia-dre-pirituba1">DRE Pirituba</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-santo-amaro1' ? "selected" : '' ?> value="noticia-dre-santo-amaro1">DRE Santo Amaro</option>							
                                                <option <?=$_GET['site'] == 'noticia-dre-sao-mateus1' ? "selected" : '' ?> value="noticia-dre-sao-mateus1">DRE São Mateus</option>								
                                                <option <?=$_GET['site'] == 'noticia-dre-sao-miguel1' ? "selected" : '' ?> value="noticia-dre-sao-miguel1">DRE São Miguel</option>                                    
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group mb-3 col-2 d-flex align-items-end justify-content-between">
                                <script>
                                    function limpaFiltro() {
                                        setTimeout(() => {
                                            window.location = window.location.pathname + "?busca_s=<?=$_GET['busca_s'];?>";
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
						$sites = array();
						$allResults = array();
						$i = 0;

						// Pega o site atual
						$siteAtual[] = get_current_blog_id();

						$allSites = array();
						$allSites[] = 1; // Portal						
						$allSites[] = 5; // CME
						$allSites[] = 4; // CAE
						$allSites[] = 6; // CACSFUNDEB
						$allSites[] = 7; // CRECE

						// remove o site atual da listagem
						$diff = array_diff( $allSites, $siteAtual );
											
						// Inclui o site atual como primeiro da lista
						$sites[] = (object) array('blog_id' => $siteAtual[0]);

						// Nova ordenacao de sites
						foreach($diff as $site){
							$sites[] = (object) array('blog_id' => $site);
						}

						$types = array('page', 'programa-projeto', 'card', 'post');

						$contBusca = array(
							'portal' => 1,							
							'cme-conselho' => 5,
							'cae-conselho' => 4,
							'cacsfundeb' => 6,
							'crece' => 7,
						);

						$categNoticias = array(
							'noticia-dre-butanta1' => 23,
							'noticia-dre-campo-limpo1' => 83,
							'noticia-dre-capela-socorro1' => 115,
							'noticia-dre-freguesia-brasilandia1' => 114,
							'noticia-dre-guaianases1' => 81,
							'noticia-dre-ipiranga1' => 48,
							'noticia-dre-itaquera1' => 75,
							'noticia-dre-jacana-tremembe1' => 89,
							'noticia-dre-penha1' => 113,
							'noticia-dre-pirituba1' => 37,
							'noticia-dre-santo-amaro1' => 31,
							'noticia-dre-sao-mateus1' => 42,
							'noticia-dre-sao-miguel1' => 112,
						);

						if($_GET['tipoconteudo'] && $_GET['tipoconteudo']){
							$arr = preg_split('/(?<=[a-z])(?=[0-9]+)/i', $_GET['tipoconteudo']);
                            $sites = array();
							if(is_user_logged_in()){
								//print_r($arr[0]);
							}
							if(str_contains($arr[0], 'pagina')){
								$types = array('page', 'programa-projeto', 'card');

                                foreach($contBusca as $blog){
                                    $sites[] = (object) array('blog_id' => $blog);
                                }
							} elseif(str_contains($arr[0], 'noticia')) {
								$types = array('post');
                                $sites[] = (object) array('blog_id' => 1);
							}                 
							
						}

                        if($_GET['site'] && $_GET['site'] != ''){							
							$sites = array();                      
							$sites[] = (object) array('blog_id' => 1);
						}

						foreach ( $sites as $site ) {
							
							switch_to_blog( $site->blog_id );

							if(isset($_GET['busca_s'])):
									$query = $_GET['busca_s'];

									
									foreach($types as $type){

										if(is_user_logged_in()){
											//print_r($site->blog_id);
										}

										
										
										$args = array( 
											's' => $query,
											'posts_per_page' => -1,
											'post_type' => $type,
											'post_status' => 'publish',
											'orderby' => 'relevance',
										);

										if($site->blog_id == 1){
											if($_GET['site'] && $_GET['site'] != ''){
												$categoria = $_GET['site'];
												$args['cat'] = $categNoticias[$categoria];
											}
										}										

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
												$allResults[$i]['titulo'] = get_the_title();
												
												if( get_field('insira_o_subtitulo') ){
													$allResults[$i]['resumo'] = get_field('insira_o_subtitulo');
												} else {
													$allResults[$i]['resumo'] = get_the_excerpt();
												}
												
												$allResults[$i]['url'] = get_the_permalink();
												$allResults[$i]['type'] = get_post_type();
												$allResults[$i]['image'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
												$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
												$allResults[$i]['alt']  = get_post_meta ( $thumbnail_id, '_wp_attachment_image_alt', true );
												$allResults[$i]['data']  = get_the_time('d/m/Y G\hi');
												$allResults[$i]['site_url'] = get_site_url();
												$allResults[$i]['site_nome'] = get_bloginfo('title');

												$i++;
											}
											//echo '</ul>';
										} else {
											// no posts found
										}
										/* Restore original Post Data */
										wp_reset_postdata();

									}

							endif;
									
							restore_current_blog();
						}						

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
								<div class="row">
									<div class="col-sm-4">
										
										<?php if($result['image'] && $result['image'] != ''): ?>
											<figure>
												<?php $alt = $result['alt'] != '' ? $result['alt'] : $result['titulo']; ?>
												<img class="img-fluid rounded float-left" src="<?=$result['image'];?>" alt="<?=$alt;?>" width="100%">
											</figure>
										<?php else: ?>
											<figure>
												<img class="img-fluid rounded float-left" src="https://educacao.sme.prefeitura.sp.gov.br/wp-content/uploads/2020/06/placeholder-sme.jpg" width="100%">
											</figure>
										<?php endif; // Imagem ?>
										
									</div>
									<div class="col-sm-8">
										<h2><a href="<?=$result['url'];?>"> <?=$result['titulo'];?></a></h2>								
										<p><?=$result['resumo'];?></p>   <!--Mostra resumo-->
																		
										<?php if($result['type'] != ''): ?>
											<strong>Tipo:</strong> 
											<span class="tagcolor">
												<?php $tipopost = $result['type'];
												if( $tipopost == "post" ) echo  'Notícia';
												if( $tipopost == "programa-projeto" ) echo  'Página';
												if( $tipopost == "card" ) echo  'página';
												if( $tipopost == "page" ) echo  'Página'; ?>
											</span><br>
										<?php endif; ?>
										
										<span><strong>Publicado em:</strong> <?=$result['data'];?> </span> -

										<span><strong>Site:</strong>
											<a href="<?=$result['site_url'];?>">
												<?=$result['site_nome'];?>
											</a>
										</span><br>

									</div>

								</div>
								<hr>
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
						
					?>
					
					<?php if($allResults && $totalPages > 1):?>
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