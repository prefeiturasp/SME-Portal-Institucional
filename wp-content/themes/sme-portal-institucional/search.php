<?php get_header(); ?>
    <div class="container">
        <div class="row">
			<?php if($_GET['s'] && $_GET['s'] != ''): ?>

				<div class="col-md-8 mb-4">

					<?php
						$sites = array();
						$allResults = array();
						$i = 0;

						// Pega o site atual
						$siteAtual[] = get_current_blog_id();

						$allSites = array();
						$allSites[] = 1; // Portal
						$allSites[] = 8; // DRE Butanta
						$allSites[] = 20; // DRE Campo Limpo
						$allSites[] = 9; // DRE Capela Socorro
						$allSites[] = 10; // DRE Freguesia
						$allSites[] = 11; // DRE Guainases
						$allSites[] = 12; // DRE Ipiranga
						$allSites[] = 13; // DRE Itaquera
						$allSites[] = 14; // DRE Jacana
						$allSites[] = 15; // DRE Penha
						$allSites[] = 16; // DRE Pirituba
						$allSites[] = 17; // DRE Santo Amaro
						$allSites[] = 18; // DRE Sao Mateus
						$allSites[] = 19; // DRE Sao Miguel
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

						//echo "<pre>";
						//print_r($sites);
						//echo "</pre>";

						$types = array('page', 'programa-projeto', 'card', 'post');

						$contBusca = array(
							'portal' => 1,
							'dre-butanta' => 8,
							'dre-campo-limpo' => 20,
							'dre-capela-socorro' => 9,
							'dre-freguesia-brasilandia'	=> 10,
							'dre-guaianases' => 11,
							'dre-ipiranga' => 12,
							'dre-itaquera' => 13,
							'dre-jacana-tremembe' => 14,
							'dre-penha' => 15,
							'dre-pirituba' => 16,
							'dre-santo-amaro' => 17,
							'dre-sao-mateus' => 18,
							'dre-sao-miguel' => 19,
							'cme-conselho' => 5,
							'cae-conselho' => 4,
							'cacsfundeb' => 6,
							'crece' => 7,
						);

						if($_GET['tipoconteudo'] && $_GET['tipoconteudo'] != ''){
							$arr = preg_split('/(?<=[a-z])(?=[0-9]+)/i', $_GET['tipoconteudo']);
							if(is_user_logged_in()){
								//print_r($arr);
							}
							if(str_contains($arr[0], 'pagina')){
								$types = array('page', 'programa-projeto', 'card');
							} elseif(str_contains($arr[0], 'noticia')) {
								$types = array('post');
							}
							$sites = array();                      
							$sites[] = (object) array('blog_id' => $arr[1]);
						}

						if($_GET['site'] && $_GET['site'] != ''){
							$sites = array();                      
							$sites[] = (object) array('blog_id' => $contBusca[$_GET['site']]);
						}

						foreach ( $sites as $site ) {
							
							switch_to_blog( $site->blog_id );

							if(isset($_GET['s'])):
									$query = $_GET['s'];

									
									foreach($types as $type){
										
										$args = array( 
											's' => $query,
											'posts_per_page' => -1,
											'post_type' => $type,
											'post_status' => 'publish',
											'orderby' => 'relevance',
											//'order'   => 'DESC',
											//'sentence' => true,
											//'exact'     => true,
										);

										if($_GET['periodo'] && $_GET['periodo'] != ''){
											$periodo = $_GET['periodo'];
											if($periodo === '1'){
												$args['date_query'] = array(
													'after'     => '1 hour ago'
												);
											} elseif($periodo === '24'){
												$args['date_query'] = array(
													'after'     => '1 day ago'
												);
											} elseif($periodo === '168'){
												$args['date_query'] = array(
													'after'     => '1 week ago'
												);
											} elseif($periodo === '5040'){
												$args['date_query'] = array(
													'after'     => '1 month ago'
												);
											} elseif($periodo === '1839600'){
												$args['date_query'] = array(
													'after'     => '1 year ago'
												);
											}
										}

										if($_GET['ano'] && $_GET['ano'] != ''){
											$args['date_query'] = array(
												'year'     => $_GET['ano'],
											);
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

						//$type = array_column($allResults, 'type');
						//array_multisort($type, SORT_DESC, $allResults);

						//echo "<pre>";
						//print_r($allResults);
						//echo "</pre>";

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
						
						//echo "<pre>";
						//print_r($allResults);
						//echo "</pre>";

						//echo 'Total Resultados: '. $total;
						//echo "<br>";
						//echo 'Paginas: '. $totalPages;
						//echo "<br>";
						//echo 'Paginas Atual: '. $pagina;
						//echo "<br>";
						//echo $offset;
						//echo "<br>";
						//echo "<br>";

						$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
						$new_url = preg_replace('/&?pagina=[^&]*/', '', $actual_link);

						//echo $new_url;
						
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

				<div class="col-md-4 mb-5">
					<form action="<?php echo get_home_url(); ?>">                    

						<div class="form-group border-filtro">
							<label for="usr"><strong>
									<h2>Refine a sua busca</h2>
								</strong></label>
						</div>

						<div class="form-group">
							<label for="usr"><strong>Busque por um termo</strong></label>
							<input class='form-control' type='text' name="s" placeholder='Buscar' value="<?=$_GET['s']?>"></input>
							
							<input id="enviar-busca-home" name="enviar-busca-home" type="hidden" class="btn btn-outline-secondary bt-search-topo" value="Buscar"> </input>
							
						</div>

						<div class="form-group">
							<label for="sel1"><strong>Filtre por tipo de conteúdo</strong></label>
							<select name="tipoconteudo" onCha class="form-control" id="sel1c">
								<option value="">Selecione o tipo</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-portal1' ? "selected" : '' ?> value="pagina-portal1">Página em SME Portal Educação</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-portal1' ? "selected" : '' ?> value="noticia-portal1">Notícia em SME Portal Educação</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-butanta8' ? "selected" : '' ?> value="pagina-dre-butanta8">Página em DRE Butantã</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-butanta8' ? "selected" : '' ?> value="noticia-dre-butanta8">Notícia em DRE Butantã</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-campo-limpo20' ? "selected" : '' ?> value="pagina-dre-campo-limpo20">Página em DRE Campo Limpo</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-campo-limpo20' ? "selected" : '' ?> value="noticia-dre-campo-limpo20">Notícia em DRE Campo Limpo</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-capela-socorro9' ? "selected" : '' ?> value="pagina-dre-capela-socorro9">Página em DRE Capela do Socorro</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-capela-socorro9' ? "selected" : '' ?> value="noticia-dre-capela-socorro9">Notícia em DRE Capela do Socorro</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-freguesia-brasilandia10' ? "selected" : '' ?> value="pagina-dre-freguesia-brasilandia10">Página em DRE Freguesia/Brasilândia</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-freguesia-brasilandia10' ? "selected" : '' ?> value="noticia-dre-freguesia-brasilandia10">Notícia em DRE Freguesia/Brasilândia</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-guaianases11' ? "selected" : '' ?> value="pagina-dre-guaianases11">Página em DRE Guaianases</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-guaianases11' ? "selected" : '' ?> value="noticia-dre-guaianases11">Notícia em DRE Guaianases</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-ipiranga12' ? "selected" : '' ?> value="pagina-dre-ipiranga12">Página em DRE Ipiranga</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-ipiranga12' ? "selected" : '' ?> value="noticia-dre-ipiranga12">Notícia em DRE Ipiranga</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-itaquera13' ? "selected" : '' ?> value="pagina-dre-itaquera13">Página em DRE Itaquera</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-itaquera13' ? "selected" : '' ?> value="noticia-dre-itaquera13">Notícia em DRE Itaquera</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-jacana-tremembe14' ? "selected" : '' ?> value="pagina-dre-jacana-tremembe14">Página em DRE Jaçanã/Tremembé</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-jacana-tremembe14' ? "selected" : '' ?> value="noticia-dre-jacana-tremembe14">Notícia em DRE Jaçanã/Tremembé</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-penha15' ? "selected" : '' ?> value="pagina-dre-penha15">Página em DRE Penha</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-penha15' ? "selected" : '' ?> value="noticia-dre-penha15">Notícia em DRE Penha</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-pirituba16' ? "selected" : '' ?> value="pagina-dre-pirituba16">Página em DRE Pirituba</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-pirituba16' ? "selected" : '' ?> value="noticia-dre-pirituba16">Notícia em DRE Pirituba</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-santo-amaro17' ? "selected" : '' ?> value="pagina-dre-santo-amaro17">Página em DRE Santo Amaro</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-santo-amaro17' ? "selected" : '' ?> value="noticia-dre-santo-amaro17">Notícia em DRE Santo Amaro</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-sao-mateus18' ? "selected" : '' ?> value="pagina-dre-sao-mateus18">Página em DRE São Mateus</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-sao-mateus18' ? "selected" : '' ?> value="noticia-dre-sao-mateus18">Notícia em DRE São Mateus</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-dre-sao-miguel19' ? "selected" : '' ?> value="pagina-dre-sao-miguel19">Página em DRE São Miguel</option>
								<option <?=$_GET['tipoconteudo'] == 'noticia-dre-sao-miguel19' ? "selected" : '' ?> value="noticia-dre-sao-miguel19">Notícia em DRE São Miguel</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-cme-conselho5' ? "selected" : '' ?> value="pagina-cme-conselho5">Página em CME Conselho</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-cae-conselho4' ? "selected" : '' ?> value="pagina-cae-conselho4">Página em CAE Conselho</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-cacsfundeb6' ? "selected" : '' ?> value="pagina-cacsfundeb6">Página em CACSFUNDEB Conselho</option>
								<option <?=$_GET['tipoconteudo'] == 'pagina-crece7' ? "selected" : '' ?> value="pagina-crece7">Página em CRECE Conselho</option>
							</select>
							<script>
								const sites = [];
								sites[1]= "portal";
								sites[8]= "dre-butanta";
								sites[20]= "dre-campo-limpo";
								sites[9]= "dre-capela-socorro";
								sites[10]= "dre-freguesia-brasilandia";
								sites[11]= "dre-guaianases";
								sites[12]= "dre-ipiranga";
								sites[13]= "dre-itaquera";
								sites[14]= "dre-jacana-tremembe";
								sites[15]= "dre-penha";
								sites[16]= "dre-pirituba";
								sites[17]= "dre-santo-amaro";

								sites[18]= "dre-sao-mateus";
								sites[19]= "dre-sao-miguel";
								sites[5]= "cme-conselho";
								sites[4]= "cae-conselho";
								sites[6]= "cacsfundeb";
								sites[7]= "crece";

								jQuery('#sel1c').on('change', function() {                                
									var site = this.value.replace(/[^0-9]/g,'');
									console.log( site );

									//jQuery("#sel3sites option:selected").removeAttr("selected");
									jQuery("#sel3sites").val(sites[site]);
								});
							</script>
						</div>

						<div class="form-group">
							<label for="sel2"><strong>Filtre por um período</strong></label>
							<select name="periodo" class="form-control" id="sel2">	
								<option value="">Todos os períodos</option>
								<option <?=$_GET['periodo'] == '1' ? 		"selected" : 'n' ?> value="1">Última hora</option>
								<option <?=$_GET['periodo'] == '24' ? 		"selected" : 'n' ?> value="24">Últimas 24 horas</option>
								<option <?=$_GET['periodo'] == '168' ? 		"selected" : 'n' ?> value="168">Última semana</option>
								<option <?=$_GET['periodo'] == '5040' ? 	"selected" : 'n' ?> value="5040">Último mês</option>
								<option <?=$_GET['periodo'] == '1839600' ?  "selected" : 'n' ?> value="1839600">Último ano</option>
							</select>
						</div>

						<div class="form-group">
							<label for="sel3"><strong>Filtre por ano</strong></label>
							<select name="ano" class="form-control" id="sel3">                               
								<?php 
									$ano_agora = date('Y');
									$date_range = range(2013, $ano_agora);
									$anosArray = $date_range;

									echo '<div class="transportX" style="display:none;"><option value="">Todos os anos</option>';				
										(sort($anosArray));
										
										foreach ((array_unique($anosArray)) as $ano) {
											$ano == $_GET['ano'] ? $isselected = 'selected' : $isselected = '';
											echo '<option '.$isselected.' value="'.$ano.'">'.$ano.'</option>';			
										}
									echo '</div>';
								?>
							</select>
						</div>

						<div class="form-group">

							<label for="sel3sites"><strong>Filtre por site</strong></label>
							<select name="site" class="form-control" id="sel3sites">

								<option value="">Todos os sites</option>
								<option <?=$_GET['site'] == 'portal' ? "selected" : '' ?> value="portal">SME Portal Educação</option>
								<option <?=$_GET['site'] == 'dre-butanta' ? "selected" : '' ?> value="dre-butanta">DRE Butantã</option>
								<option <?=$_GET['site'] == 'dre-campo-limpo' ? "selected" : '' ?> value="dre-campo-limpo">DRE Campo Limpo</option>
								<option <?=$_GET['site'] == 'dre-capela-socorro' ? "selected" : '' ?> value="dre-capela-socorro">DRE Capela do Socorro</option>
								<option <?=$_GET['site'] == 'dre-freguesia-brasilandia' ? "selected" : '' ?> value="dre-freguesia-brasilandia">DRE Freguesia/Brasilândia</option>
								<option <?=$_GET['site'] == 'dre-guaianases' ? "selected" : '' ?> value="dre-guaianases">DRE Guaianases</option>
								<option <?=$_GET['site'] == 'dre-ipiranga' ? "selected" : '' ?> value="dre-ipiranga">DRE Ipiranga</option>
								<option <?=$_GET['site'] == 'dre-itaquera' ? "selected" : '' ?> value="dre-itaquera">DRE Itaquera</option>
								<option <?=$_GET['site'] == 'dre-jacana-tremembe' ? "selected" : '' ?> value="dre-jacana-tremembe">DRE Jaçanã/Tremembé</option>
								<option <?=$_GET['site'] == 'dre-penha' ? "selected" : '' ?> value="dre-penha">DRE Penha</option>
								<option <?=$_GET['site'] == 'dre-pirituba' ? "selected" : '' ?> value="dre-pirituba">DRE Pirituba</option>
								<option <?=$_GET['site'] == 'dre-santo-amaro' ? "selected" : '' ?> value="dre-santo-amaro">DRE Santo Amaro</option>
								<option <?=$_GET['site'] == 'dre-sao-mateus' ? "selected" : '' ?> value="dre-sao-mateus">DRE São Mateus</option>
								<option <?=$_GET['site'] == 'dre-sao-miguel' ? "selected" : '' ?> value="dre-sao-miguel">DRE São Miguel</option>
								<option <?=$_GET['site'] == 'cme-conselho' ? "selected" : '' ?> value="cme-conselho">CME Conselho</option>
								<option <?=$_GET['site'] == 'cae-conselho' ? "selected" : '' ?> value="cae-conselho">CAE Conselho</option>
								<option <?=$_GET['site'] == 'cacsfundeb' ? "selected" : '' ?> value="cacsfundeb">CACSFUNDEB Conselho</option>
								<option <?=$_GET['site'] == 'crece' ? "selected" : '' ?> value="crece">CRECE Conselho</option>
							</select>
						</div>

						<div class="form-group mb-3">
							<script>
								function limpaFiltro() {
									setTimeout(() => {
										window.location = window.location.pathname + "?s=<?=$_GET['s'];?>";
									}, 100);
								}
							</script>
							<button onclick="limpaFiltro()" type="button" class="btn btn-refinar btn-sm float-left">Limpar filtros</button>
							<button type="submit" class="btn btn-primary btn-sm float-right">Refinar busca</button>

						</div>

					</form>
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