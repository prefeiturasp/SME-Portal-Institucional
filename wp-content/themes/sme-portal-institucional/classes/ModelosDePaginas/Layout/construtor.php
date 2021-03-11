<?php

namespace Classes\ModelosDePaginas\Layout;

use Classes\Lib\Util;

function clean($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.										 
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

class Construtor extends Util
{
	
	public function __construct()
	{
		$this->ExecutaJquery();
		$this->montaHtmlConstrutor();

	}
	
	public function ExecutaJquery(){
		?>
		<script>
			jQuery(document).ready(function(){
				jQuery("table").addClass('table-responsive'); //ativa tabela responsiva
				jQuery(".nav-tabs li:first-child a").addClass('active'); //ativa a primeira aba
				jQuery(".tab-content div:first-child").addClass('active'); //ativa a primeira aba
				//jQuery("#collapse1").addClass('show'); //ativa sanfona 1
				//jQuery("#collapsea1").addClass('show'); //ativa sanfona 2
				//jQuery("#collapseb1").addClass('show'); //ativa sanfona 3
				jQuery(".card-header").on('click', function(){
					jQuery(".card-header").removeClass('bg-sanfona-active');
					jQuery(this).addClass('bg-sanfona-active');
				});
			});
		</script>
		<?php
	}

	public function montaHtmlConstrutor(){
		global $post;
		$post_slug = $post->post_name;
		?>
<div id="<?php echo $post_slug; ?>" class="container-fluid">
	<div class="row">
<?php
//banner
if(get_field('fx_flex_habilitar_banner') != null){
	$imagem_banner = get_field('fx_flex_banner');//Pega todos os valores da imagem no array
	echo '<div class="bn_fx_banner"><img src="'.$imagem_banner['url'].'" width="100%" alt="'.$imagem_banner['alt'].'"></div>';
}
		
if( have_rows('fx_flex_layout') ):
    while( have_rows('fx_flex_layout') ): the_row();
		
		
		////////////////////////////// Inicio 1 Coluna ///////////////////////////////
        if( get_row_layout() == 'fx_linha_coluna_1' ):
					//Personalização da coluna
					$background = get_sub_field('fx_fundo_da_coluna_1_1');
					$color = get_sub_field('fx_cor_do_texto_coluna_1_1');
					$link = get_sub_field('fx_cor_do_link_coluna_1_1');
					$colorbtn = get_sub_field('fx_cor_do_botao_coluna_1_1');
					
		        	//conteudo flexivel 1 coluna
					if( have_rows('fx_coluna_1_1') ):
						echo '<div class="bg_fx_'.$background['value'].' lk_fx_'.$link['value'].' fx_all">';//fundo e link
						echo '<div class="container">';//bootstrap container
						echo '<div class="row">';//bootstrap row
						echo '<div class="col-sm-12 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_1_1') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_1_1' ):
									//echo '<h1 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_1').'</h1>';
									$cab_h = get_sub_field('cabecalho_h_construtor_1_1');
									$ali_h = get_sub_field('alinhar_h_construtor_1_1');
									//echo $cab_h['value'];
									if($cab_h['value'] == 'h1'){
										echo '<h1 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_1').'</h1>';
									}elseif ($cab_h['value'] == 'h2') {
										echo '<h2 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_1').'</h2>';
									}else{
										echo '<h1 class="text-left mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_1').'</h1>';
									}
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_1' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_1_1').'</div>';
								//editor Wysiwyg com fundo
								elseif( get_row_layout() == 'fx_cl1_editor_fundo_1_1' ): 
									echo '<div style="background: url('.get_sub_field('imagem_de_fundo').')" class="mt-3 mb-3 bg_img_fix">'.get_sub_field('fx_editor_1_1').'</div>';
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_1_1' ):
									?>
									<div  id="noticias_fx" class="row overflow-auto">
									<?php query_posts(array(
										'cat' => get_sub_field('fx_noticias_1_1'),
										'post_per_page' => -1
									)); ?>
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
										<div class="col-sm-4 text-center">
											<?php
											$image_id = get_post_thumbnail_id();
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
											?>
											<img src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%" alt="<?php echo $image_alt; ?>">
											<p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
										</div>
									<?php endwhile; endif; ?>
									<?php wp_reset_query(); ?>
									</div>
									<?php
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_1' ): 
									echo '<div class="mt-3 mb-3 video-1">'.get_sub_field('fx_video_1_1').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_1' ): 
									$imagem_1_1 = get_sub_field('fx_imagem_1_1');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_1_1') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_1_1') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_1_1['url'] ?>" width="100%" alt="<?php echo $imagem_1_1['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_1_1['url'].'" width="100%" alt="'.$imagem_1_1['alt'].'">';
									}
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_1_1' ): 		
									if(get_sub_field('fx_abas_1_1'))://repeater

										//loop menu aba
										echo '<ul class="nav nav-tabs">';
											$count=0;
											 
											while(has_sub_field('fx_abas_1_1'))://verifica conteudo no repeater
												$count++;
												//echo $count;
												$aba_title = get_sub_field('fx_nome_abas_1_1');
												$id_aba = clean($aba_title);
												echo '<li class="nav-item">';
													echo '<a class="nav-link" data-toggle="tab" href="#aba'. $count. $id_aba. '"><strong>'.get_sub_field('fx_nome_abas_1_1').'</strong></a>';
												echo '</li>';
											endwhile;
										echo '</ul>';
		
										//loop conteudo aba
										echo '<div class="tab-content">';
												$count=0;
										while(has_sub_field('fx_abas_1_1'))://verifica se editor no repeater
												$count++;
												//echo $count;
												$aba_title = get_sub_field('fx_nome_abas_1_1');
												$id_aba = clean($aba_title);
											echo '<div class="tab-pane container mt-3 mb-3" id="aba'. $count. $id_aba. '">'.get_sub_field('fx_editor_abas_1_1').'</div>';
		
										endwhile;
										echo '</div>';
		
									 endif;
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_1_1' ): 		
									if(get_sub_field('fx_sanfona_1_1'))://repeater
										//loop sanfona
										echo '<div id="accordion">';
											$count=mt_rand(1,99);
											while(has_sub_field('fx_sanfona_1_1'))://verifica conteudo no repeater
												$count++;
												//echo $count;
												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse'.$count.'">';
														echo '<strong>'.get_sub_field('fx_nome_sanfona_1_1').'</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse'.$count.'" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('fx_editor_sanfona_1_1');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';
											endwhile;
										echo '</div>';		
									 endif;
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_1' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_1' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_1_1') ):
										echo '<div class="row mt-3 mb-3">';
											while ( have_rows('fx_botao_1_1') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_1_1' ):
														//loop de botões responsivos
														echo '<div class="col">';
															echo '<a href="'.get_sub_field('fx_url_botao_1_1').'"><button type="button" class="btn bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_1_1').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;

								
								//Contatos em camadas
								elseif( get_row_layout() == 'fx_cl1_contato_camadas_1_1' ): 
									
									//contatos selecionados									
									if(get_sub_field('contatos'))://repeater
										
										// gerar numero aleatorio
										$count = mt_rand(10,99);
										$count2 = $count;
										
										echo '<div class="row">';
											echo "<div class='col-sm-12 mb-4' id='lista-contatos'>";
												echo "<ul>";										

													while(has_sub_field('contatos')):
														// menu de ancora
														$principal = get_sub_field('contato_principal');
													
														if($principal && $principal != ''){
															
															foreach($principal as $contato){
																echo "<li class='mb-3'><a href='#" . $count ."'>" . get_the_title($contato) . "</a></li>";
															}
																	
														}

														$count++;													
													endwhile;

												echo "</ul>";
											echo "</div>"; // end col-sm-12
										echo "</div>"; // end row
										
										
										//loop contatos
										echo '<div class="row">';
											
											
											while(has_sub_field('contatos'))://verifica conteudo no repeater
												
												
												echo "<div class='col-sm-12 contacts-list' id='" . $count2 . "'>";

													// Contato principal	
													$principal = get_sub_field('contato_principal');

													foreach($principal as $contato){

														echo '<h2>' . get_the_title($contato) . '</h2>';

														echo "<div class='col-sm-12 mb-3'>";

															// pega os campos de cada contato
															$rows = get_field('campos_contato', $contato);
															
															if( $rows ) {
																
																foreach( $rows as $row ) {
																	// verifica se os campos estao vazios
																	if( $row['nome_campo'] && $row['nome_campo'] != '' && $row['informacao_campo'] && $row['informacao_campo'] != ''){
																		
																		// verifica o tipo do campos
																		if($row['tipo_de_campo'] == 'telefone'){
																			
																			$telefone = $row['informacao_campo']; // pega o campo telefone
																			$telefone = preg_replace('/[^A-Za-z0-9\-]/', '', $telefone); // remove os caracteres especiais
																			$telefone = str_replace('-', '', $telefone); // troca o - por vazio

																			echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='tel:" . $telefone ."'>" . $row['informacao_campo'] . "</a></p>";
																		} elseif($row['tipo_de_campo'] == 'email'){

																			echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='mailto:" . $row['informacao_campo'] ."'>" . $row['informacao_campo'] . "</a></p>";
																		
																		} elseif($row['tipo_de_campo'] == 'url'){

																			echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='" . $row['informacao_campo'] ."'>" . $row['informacao_campo'] . "</a></p>";
																		
																		} else {
																			echo "<p class='mb-0'>" . $row['nome_campo'] . ": " . $row['informacao_campo'] . "</p>";
																		}
																	}
																	
																}
																
															}

														echo "</div>";

													}

												

													
													// Contato secundario	
													$secundario = get_sub_field('contato_secundario');
													if($secundario && $secundario != ''):
														echo "<div class='col-sm-12'>";

															echo "<div class='row d-flex align-items-stretch'>";

																foreach($secundario as $contato){

																	echo "<div class='col-12 col-sm-6 col-md-4 mb-3 d-flex second-contact'>";
																		echo '<div class="border p-3 rounded w-100">';

																		echo '<h3>' . get_the_title($contato) . '</h3>';
																	
																		// pega os campos de cada contato
																		$rows = get_field('campos_contato', $contato);
																		
																		if( $rows ) {
																			
																			foreach( $rows as $row ) {
																				// verifica se os campos estao vazios
																				if( $row['nome_campo'] && $row['nome_campo'] != '' && $row['informacao_campo'] && $row['informacao_campo'] != ''){
																					
																					// verifica o tipo do campos
																					if($row['tipo_de_campo'] == 'telefone'){
																						
																						$telefone = $row['informacao_campo']; // pega o campo telefone
																						$telefone = preg_replace('/[^A-Za-z0-9\-]/', '', $telefone); // remove os caracteres especiais
																						$telefone = str_replace('-', '', $telefone); // troca o - por vazio

																						echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='tel:" . $telefone ."'>" . $row['informacao_campo'] . "</a></p>";
																					} elseif($row['tipo_de_campo'] == 'email'){

																						echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='mailto:" . $row['informacao_campo'] ."'>" . $row['informacao_campo'] . "</a></p>";
																					
																					} elseif($row['tipo_de_campo'] == 'url'){

																						echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='" . $row['informacao_campo'] ."'>" . $row['informacao_campo'] . "</a></p>";
																					
																					} else {
																						echo "<p class='mb-0'>" . $row['nome_campo'] . ": " . $row['informacao_campo'] . "</p>";
																					}
																				}
																				
																			}
																			
																		}

																		echo "</div>"; // end border

																	echo "</div>";

																} // end foreach

															echo "</div>"; // end row													 

														echo "</div>"; // end col-sm-12
													endif;

													echo "<p class='mb-0 mt-3 text-right'><a href='#lista-contatos'>voltar para o topo</a></p>";
													echo "<hr>";

												echo "</div>";

												//echo get_sub_field('contato_principal') . "<br>";
												//echo get_sub_field('contato_secundario') . "<br>";

												$count2++;
											endwhile;

										echo '</div>';		
									endif;
																
								elseif( get_row_layout() == 'fx_cl1_contato_individual_1_1' ):
									
									if(get_sub_field('contatos_individuais'))://repeater

										while(has_sub_field('contatos_individuais'))://verifica conteudo no repeater
										
										
											echo "<div class='col-sm-12 contacts-list p-0'>";

												// Contato principal	
												$lista_contatos = get_sub_field('lista_contatos');

												foreach($lista_contatos as $contato){													

													echo "<div class='col-sm-12 mb-3 p-0'>";

														echo '<h3>' . get_the_title($contato) . '</h3>';

														// pega os campos de cada contato
														$rows = get_field('campos_contato', $contato);
														
														if( $rows ) {
															
															foreach( $rows as $row ) {
																// verifica se os campos estao vazios
																if( $row['nome_campo'] && $row['nome_campo'] != '' && $row['informacao_campo'] && $row['informacao_campo'] != ''){
																	
																	// verifica o tipo do campos
																	if($row['tipo_de_campo'] == 'telefone'){
																		
																		$telefone = $row['informacao_campo']; // pega o campo telefone
																		$telefone = preg_replace('/[^A-Za-z0-9\-]/', '', $telefone); // remove os caracteres especiais
																		$telefone = str_replace('-', '', $telefone); // troca o - por vazio

																		echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='tel:" . $telefone ."'>" . $row['informacao_campo'] . "</a></p>";
																	} elseif($row['tipo_de_campo'] == 'email'){

																		echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='mailto:" . $row['informacao_campo'] ."'>" . $row['informacao_campo'] . "</a></p>";
																	
																	} elseif($row['tipo_de_campo'] == 'url'){

																		echo "<p class='mb-0'><strong>" . $row['nome_campo'] . "</strong>: <a href='" . $row['informacao_campo'] ."'>" . $row['informacao_campo'] . "</a></p>";
																	
																	} else {
																		echo "<p class='mb-0'>" . $row['nome_campo'] . ": " . $row['informacao_campo'] . "</p>";
																	}
																}
																
															}
															
														}

													echo "</div>";

												}


												echo "<hr>";

											echo "</div>";

											//echo get_sub_field('contato_principal') . "<br>";
											//echo get_sub_field('contato_secundario') . "<br>";

											
										endwhile;

									endif; // contatos_individuais

								// Slide de Noticias
								elseif( get_row_layout() == 'fx_cl1_slide_noticias_1_1' ):

									if(get_sub_field('fx_slides_1_1')) :									 

										echo '<div class="slide-principal mt-3 mb-3">';
											echo '<div class="container">';
												echo '<div class="row">';
													
													$slidesNoticias = get_sub_field('fx_slides_1_1');
													$qtSlide = count($slidesNoticias);
													$l = 0;
													$m = 0;
													//echo $qtSlide;													
													
													echo '<div id="carouselExampleIndicators" class="carousel slide col-sm-12" data-ride="carousel">';
														echo '<ol class="carousel-indicators">';
														
														
															while($m < $qtSlide) :
																if($m == 0){
																	$active = 'active';
																} else {
																	$active = '';
																}
																echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $m . '" class="' . $active . '"></li>';
															
																$m++;
															endwhile;
															
														echo '</ol>';

														echo '<div class="carousel-inner border">';

															foreach($slidesNoticias as $slide): ?>
																<div class="carousel-item <?php if($l == 0){echo 'active';} ?>">
																	<div class="row">
																		<div class="col-sm-12 col-md-7">
																			<?php                                                 
																				 $imgSelect = get_the_post_thumbnail_url($slide, 'slide-noticias');
																				 
																				 $featured_img_url =  $imgSelect;
																				 
																				 if($featured_img_url){
																					 $imgSlide =  $imgSelect;
																				 } else {
																					 $imgSlide = 'http://via.placeholder.com/656x304';
																				 }                                               
																			?>
																			<a href="<?php echo get_the_permalink($slide); ?>"><img class="d-block w-100" src="<?php echo  $imgSlide; ?>" alt="Slide "></a>
																		</div>
																		<div class="col-sm-12 col-md-5"> 
																			<div class="carousel-title">
																			<p><a href="<?php echo get_the_permalink($slide); ?>"><?php echo get_the_title($slide); ?></a></p>
																			</div>                                            
																		</div>
																	</div>
																</div>
															
															
															<?php
																$l++;
															endforeach;
																

														echo '</div>';

														// Setas do SLide
														echo '<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">';
														echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
														echo '<span class="sr-only">Previous</span>';
														echo '</a>';
														echo '<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">';
														echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
														echo '<span class="sr-only">Next</span>';
														echo '</a>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
										echo '</div>';

									endif; // fx_slides_1_1

								// Acesso Rapido
								elseif( get_row_layout() == 'fx_cl1_acesso_rapido_1_1' ):									

									if(get_sub_field('fx_acessos_1_1')) :
									

										echo '<session class="container-fluid container-fluid-botoes-persona">';

											echo '<div class="container">';

												echo '<div class="row">';

													echo '<div class="col-sm-12">';

														echo '<ul class="card-group nav m-0 acesso-rapido" role="tablist">';

															$acessosRapido = get_sub_field('fx_acessos_1_1');

															//echo "<pre>";
															//print_r($acessosRapido);
															//echo "</pre>";

															foreach($acessosRapido as $acessos):
															?>
																<li id="tab_<?php echo $acessos['menu']; ?>" class="container-a-icones-home card rounded-0 border-0">

																	<a id="tab_<?php echo $acessos['menu']; ?>" data-toggle="tab" href="#menu_<?php echo $acessos['menu']; ?>" role="tab" aria-selected="false" class="a-icones-home ">

																		<div class="row w-100">

																			<div class="col-sm-4 pr-0">
																				<div class="icon-card">
																					<img src="<?php echo $acessos['icone']['sizes']['thumbnail']; ?>" class="img-fluid" alt="<?php echo $acessos['icone']['alt']; ?>">
																				</div>
																			</div>

																			<div class="col-sm-8 pr-0 d-flex align-items-center">
																				<div class="card-body text-center px-0">
																					<p class="card-text"><?php echo $acessos['titulo']; ?></p>
																				</div>
																			</div>

																		</div>

																		<div class="acesso-mobile">
																			<?php
																				wp_nav_menu(array(
																					'menu' => $acessos['menu'],
																					'depth' => 2,
																					'menu_class' => 'navbar-nav m-auto nav nav-tabs',
																					'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
																					'walker'            => new \WP_Bootstrap_Navwalker(),
																				));
																			?>
																		</div>
																		
																	</a>

																</li>
															<?php
															endforeach;

															
																			
														echo '</ul>';
													echo '</div>';                  

												echo '</div>';
											echo '</div>';
										echo '</session>';
										
										
										echo '<section class="tab-content container acesso-rapido-menu">';
																
											foreach($acessosRapido as $acessos):

												echo '<section class="tab-pane fade container p-0 my-3" id="menu_' . $acessos['menu'] . '" role="tabpanel" aria-labelledby="' . $acessos['menu'] . '">';
									
													echo '<nav class="navbar navbar-expand-lg nav-icones-menu">';


														echo '<article class="collapse navbar-collapse">';
														
															wp_nav_menu(array(
																'menu' => $acessos['menu'],
																'depth' => 2,
																'menu_class' => 'navbar-nav m-auto nav nav-tabs',
																'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
																'walker'            => new \WP_Bootstrap_Navwalker(),
															));
															
														echo '</article>';

													echo '</nav>';																						

												echo '</section>';

											endforeach;
										echo '</section>';
										

									endif; // end fx_acessos_1_1

								// Bloco Noticias
								elseif( get_row_layout() == 'fx_cl1_bloco_noticias_1_1' ):

									$blocoTitulo = get_sub_field('fx_cl1_bloco_noticias_titulo');
									$blocoColunas = get_sub_field('fx_cl1_bloco_noticias_colunas');
									$blocoNoticias = get_sub_field('fx_cl1_bloco_noticias_selecione_noticias');
									
									echo '<section class="container lista-noticias mt-4">';
										echo '<div class="row">';
											echo '<div class="col-sm-12 lista-noticias-titulo">';
												echo '<p>' . $blocoTitulo . '</p>';
											echo '</div>';

											if($blocoNoticias) :

												foreach($blocoNoticias as $noticia):
																									
													$imgSelect = get_the_post_thumbnail_url($noticia, 'slide-noticias');
													$thumbnail_id = get_post_thumbnail_id( $noticia );
													$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
													
													$featured_img_url =  $imgSelect;
													
													if($featured_img_url){
														$imgSlide =  $imgSelect;
														if(!$alt){
															$alt = get_the_title();
														}
													} else {
														$imgSlide = 'http://via.placeholder.com/656x304';
														$alt = get_the_title();
													}                                               
											
												?>
													<div class="col-sm-12 col-md-6 col-lg-<?php echo $blocoColunas; ?> lista-noticia">
														<a href="<?php echo get_the_permalink($noticia); ?>">
															<img src="<?php echo $imgSlide; ?>" alt="<?php echo $alt; ?>" class="img-fluid">
															<p><?php echo get_the_title($noticia); ?></p>
														</a>
													</div>

												<?php
												endforeach;
											
											endif;

										echo '</div>';
									echo '</section>';


								// Bloco Redes Sociais
								elseif( get_row_layout() == 'fx_fl1_bloco_rede_1_1' ):
									
									if(get_sub_field('fx_fl1_selecione_rede_1_1') == 'insta'):
								?>

										<div class="container">	
											<div class="row social-block">
												<div class="col-sm-12 col-md-5">
													<?php if(get_sub_field('fx_fl1_titulo_1_1')): ?>
														<p><?php echo get_sub_field('fx_fl1_titulo_1_1'); ?></p>
													<?php endif; ?>

													<?php if(get_sub_field('fx_fl1_descricao_1_1')): ?>
														<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_1_1'); ?></p>
													<?php endif; ?>

													<hr>

													<?php if(get_sub_field('fx_fl1_pagina_1_1')): ?>
														<a href="<?php echo get_sub_field('fx_fl1_pagina_1_1'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-instagram" aria-hidden="true"></i> | Instagram</button></a>
													<?php endif; ?>
													
												</div>
												<div class="col-sm-12 col-md-7">
													<?php if(get_sub_field('fx_fl1_shortcode_1_1')):
														$short = get_sub_field('fx_fl1_shortcode_1_1');
														echo do_shortcode($short);
													endif; ?>
													
												</div>
											</div>
										</div>

								<?php
									elseif(get_sub_field('fx_fl1_selecione_rede_1_1') == 'face'):
								?>
									<div class="row social-block">
										<div class="col-sm-12 col-md-5">

											<?php if(get_sub_field('fx_fl1_titulo_1_1')): ?>
												<p><?php echo get_sub_field('fx_fl1_titulo_1_1'); ?></p>
											<?php endif; ?>

											<?php if(get_sub_field('fx_fl1_descricao_1_1')): ?>
												<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_1_1'); ?></p>
											<?php endif; ?>

											<hr>
											<?php if(get_sub_field('fx_fl1_pagina_1_1')): ?>
												<a href="<?php echo get_sub_field('fx_fl1_pagina_1_1'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-facebook-square" aria-hidden="true"></i> | Facebook</button></a>
											<?php endif; ?>
						
										</div>
										<div class="col-sm-12 col-md-7">
											<div class="fb-page" data-href="<?php echo get_sub_field('fx_fl1_pagina_1_1'); ?>" data-tabs="timeline" data-width="" data-height="310" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/EducaPrefSP/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/EducaPrefSP/">Secretaria Municipal de Educação de São Paulo</a></blockquote></div>
										</div>
									</div>
								<?php
									elseif(get_sub_field('fx_fl1_selecione_rede_1_1') == 'ytube'):
								?>
									<div class="container">
										<div class="row social-block">
											<div class="col-sm-12 col-md-6">
												
												<?php if(get_sub_field('fx_fl1_titulo_1_1')): ?>
													<p><?php echo get_sub_field('fx_fl1_titulo_1_1'); ?></p>
												<?php endif; ?>

												<?php if(get_sub_field('fx_fl1_descricao_1_1')): ?>
													<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_1_1'); ?></p>
												<?php endif; ?>		

												<?php if(get_sub_field('fx_fl1_pagina_1_1')): ?>
													<a href="<?php echo get_sub_field('fx_fl1_pagina_1_1'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-youtube-play" aria-hidden="true"></i> | Youtube</button></a>
												<?php endif; ?>
												
											</div>												
											<div class="col-sm-12 col-md-6">
												<?php
													if(get_sub_field('fx_fl1_video_1_1')) :
														$url = get_sub_field('fx_fl1_video_1_1');
														parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
												?>
													<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $my_array_of_vars['v']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php
									endif;
								endif; //fx_fl1_bloco_rede_1_1

							endwhile;
						echo '</div>';//bootstrap col
						echo '</div>';//bootstrap row
						echo '</div>';//bootstrap container
						echo '</div>';//fundo
					endif;
		////////////////////////////// Final 1 Coluna///////////////////////////////

		////////////////////////////// Inicio Sanfona DRE ///////////////////////////////
        elseif( get_row_layout() == 'sanfona_dre' ):
					
						echo '<div class="container">';//bootstrap container
						echo '<div class="row">';//bootstrap row
						echo '<div class="col-sm-8">';
						echo '<img src="https://hom-educacao.sme.prefeitura.sp.gov.br/wp-content/uploads/2020/08/Mapa.png" width="100%">';
						echo '</div>';
						echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
								
										//sanfona DRE
										echo '<div id="accordion">';
												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse1">';
														echo '<strong>1 - Diretoria Regional de Educação Butantã</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse1" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_butanta');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse2">';
														echo '<strong>2 - Diretoria Regional de Educação Campo Limpo</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse2" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_campo_limpo');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse3">';
														echo '<strong>3 - Diretoria Regional de Educação Capela do Socorro</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse3" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_capela_do_socorro');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse4">';
														echo '<strong>4 - Diretoria Regional de Educação Freguesia/Brasilândia</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse4" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_freguesia_brasilandia');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse5">';
														echo '<strong>5 - Diretoria Regional de Educação Guaianases</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse5" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_guaianases');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse6">';
														echo '<strong>6 - Diretoria Regional de Educação Ipiranga</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse6" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_ipiranga');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse7">';
														echo '<strong>7 - Diretoria Regional de Educação Itaquera</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse7" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_itaquera');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse8">';
														echo '<strong>8 - Diretoria Regional de Educação Jaçanã/Tremembé</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse8" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_jacanatremembe');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse9">';
														echo '<strong>9 - Diretoria Regional de Educação Penha</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse9" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_penha');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse10">';
														echo '<strong>10 - Diretoria Regional de Educação Pirituba</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse10" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_pirituba');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse11">';
														echo '<strong>11 - Diretoria Regional de Educação Santo Amaro</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse11" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_santo_amaro');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse12">';
														echo '<strong>12 - Diretoria Regional de Educação São Mateus</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse12" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_sao_mateus');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

												  echo '<div class="card sanfona">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapse13">';
														echo '<strong>13 - Diretoria Regional de Educação São Miguel</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapse13" class="collapse" data-parent="#accordion">';
													  echo '<div class="card-body">';
														echo get_sub_field('dre_sao_miguel');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';

										echo '</div>';
								

						echo '</div>';//bootstrap col
						echo '</div>';//bootstrap row
						echo '</div>';//bootstrap container

		////////////////////////////// Final sanfona DRE///////////////////////////////
		
		////////////////////////////// Inicio 2 Colunas ///////////////////////////////
        elseif( get_row_layout() == 'fx_linha_coluna_2' ):
					//Personalização da coluna
					$background = get_sub_field('fx_fundo_da_coluna_1_1');
					$color = get_sub_field('fx_cor_do_texto_coluna_1_1');
					$link = get_sub_field('fx_cor_do_link_coluna_1_1');
					$colorbtn = get_sub_field('fx_cor_do_botao_coluna_1_1');
					
					echo '<div class="bg_fx_'.$background['value'].' lk_fx_'.$link['value'].' fx_all">';//fundo e link
					echo '<div class="container">';//bootstrap container
					echo '<div class="row">';//bootstrap row
					
					//conteudo flexivel 2 colunas esquerda
					if( have_rows('fx_coluna_1_2') ):
						echo '<div class="col-sm-6 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_1_2') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_1_2' ):
									//echo '<h1 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h1>';
									$cab_h = get_sub_field('cabecalho_h_construtor_1_2');
									$ali_h = get_sub_field('alinhar_h_construtor_1_2');
									//echo $cab_h['value'];
									if($cab_h['value'] == 'h1'){
										echo '<h1 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h1>';
									}elseif ($cab_h['value'] == 'h2') {
										echo '<h2 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h2>';
									}else{
										echo '<h2 class="text-left mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h2>';
									}
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_1_2').'</div>';
								//editor Wysiwyg com fundo
								elseif( get_row_layout() == 'fx_cl1_editor_fundo_1_2' ): 
									echo '<div style="background: url('.get_sub_field('imagem_de_fundo').')" class="mt-3 mb-3 bg_img_fix">'.get_sub_field('fx_editor_1_2').'</div>';
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
									?>
									<div  id="noticias_fx" class="row overflow-auto">
									<?php query_posts(array(
										'cat' => get_sub_field('fx_noticias_1_2'),
										'post_per_page' => -1
									)); ?>
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
										<div class="col-sm-6 mt-3 mb-3 text-center">
											<?php
											$image_id = get_post_thumbnail_id();
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
											?>
											<img src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%" alt="<?php echo $image_alt; ?>">
											<p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
										</div>
									<?php endwhile; endif; ?>
									<?php wp_reset_query(); ?>
									</div>
									<?php
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
									echo '<div class="mt-3 mb-3 video-2">'.get_sub_field('fx_video_1_2').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
									$imagem_1_2 = get_sub_field('fx_imagem_1_2');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_1_2') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_1_2') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_1_2['url'] ?>" width="100%" alt="<?php echo $imagem_1_2['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_1_2['url'].'" width="100%" alt="'.$imagem_1_2['alt'].'">';
									}
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
									if(get_sub_field('fx_abas_1_2'))://repeater
										
										//loop menu aba
										echo '<ul class="nav nav-tabs mb-3 mt-3">';
											$count_1_2=0;
											while(has_sub_field('fx_abas_1_2'))://verifica conteudo no repeater
												$count_1_2++;
												//echo $count;
												$aba_title_1_2 = get_sub_field('fx_nome_abas_1_2');
												$id_aba_1_2 = clean($aba_title);
												echo '<li class="nav-item">';
													echo '<a class="nav-link" data-toggle="tab" href="#abaa'. $count_1_2 . $id_aba_1_2 .'"><strong>'.get_sub_field('fx_nome_abas_1_2').'</strong></a>';
												echo '</li>';
											endwhile;
										echo '</ul>';
		
										//loop conteudo aba
										echo '<div class="tab-content mb-3 mt-3">';
												$count_1_2=0;
										while(has_sub_field('fx_abas_1_2'))://verifica se editor no repeater
												$count_1_2++;
												//echo $count;
												$aba_title_1_2 = get_sub_field('fx_nome_abas_1_2');
												$id_aba_1_2 = clean($aba_title);
											echo '<div class="tab-pane container mt-3 mb-3" id="abaa'. $count_1_2 . $id_aba_1_2 .'">'.get_sub_field('fx_editor_abas_1_2').'</div>';
		
										endwhile;
										echo '</div>';
		
									 endif;
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
									if(get_sub_field('fx_sanfona_1_2'))://repeater
										//loop sanfona
										echo '<div id="accordiona" class="mt-3 mb-3">';
											$count_a=0;
											while(has_sub_field('fx_sanfona_1_2'))://verifica conteudo no repeater
												$count_a++;
												//echo $count;
												  echo '<div class="card sanfona ">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapsea'.$count_a.'">';
														echo '<strong>'.get_sub_field('fx_nome_sanfona_1_2').'</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapsea'.$count_a.'" class="collapse" data-parent="#accordiona">';
													  echo '<div class="card-body">';
														echo get_sub_field('fx_editor_sanfona_1_2');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';
											endwhile;
										echo '</div>';		
									 endif;
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_1_2') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_1_2') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_1_2' ):
														//loop de botões responsivos
														echo '<div class="col">';
															echo '<a href="'.get_sub_field('fx_url_botao_1_2').'"><button type="button" class="btn mt-1 mb-1 bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_1_2').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;

								// Bloco Redes Sociais
								elseif( get_row_layout() == 'fx_fl1_bloco_rede_1_2' ):
									if(get_sub_field('fx_fl1_selecione_rede_1_2') == 'insta'):
								?>

										<div class="container">	
											<div class="row social-block">
												<div class="col-sm-12 col-md-5">
													<?php if(get_sub_field('fx_fl1_titulo_1_2')): ?>
														<p><?php echo get_sub_field('fx_fl1_titulo_1_2'); ?></p>
													<?php endif; ?>

													<?php if(get_sub_field('fx_fl1_descricao_1_2')): ?>
														<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_1_2'); ?></p>
													<?php endif; ?>

													<hr>

													<?php if(get_sub_field('fx_fl1_pagina_1_2')): ?>
														<a href="<?php echo get_sub_field('fx_fl1_pagina_1_2'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-instagram" aria-hidden="true"></i> | Instagram</button></a>
													<?php endif; ?>
													
												</div>
												<div class="col-sm-12 col-md-7">
													<?php if(get_sub_field('fx_fl1_shortcode_1_2')):
														$short = get_sub_field('fx_fl1_shortcode_1_2');
														echo do_shortcode($short);
													endif; ?>
													
												</div>
											</div>
										</div>

								<?php
									elseif(get_sub_field('fx_fl1_selecione_rede_1_2') == 'face'):
								?>
									<div class="row social-block">
										<div class="col-sm-12 col-md-5">

											<?php if(get_sub_field('fx_fl1_titulo_1_2')): ?>
												<p><?php echo get_sub_field('fx_fl1_titulo_1_2'); ?></p>
											<?php endif; ?>

											<?php if(get_sub_field('fx_fl1_descricao_1_2')): ?>
												<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_1_2'); ?></p>
											<?php endif; ?>

											<hr>
											<?php if(get_sub_field('fx_fl1_pagina_1_2')): ?>
												<a href="<?php echo get_sub_field('fx_fl1_pagina_1_2'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-facebook-square" aria-hidden="true"></i> | Facebook</button></a>
											<?php endif; ?>
						
										</div>
										<div class="col-sm-12 col-md-7">
											<div class="fb-page" data-href="<?php echo get_sub_field('fx_fl1_pagina_1_2'); ?>" data-tabs="timeline" data-width="" data-height="310" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/EducaPrefSP/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/EducaPrefSP/">Secretaria Municipal de Educação de São Paulo</a></blockquote></div>
										</div>
									</div>
								<?php
									elseif(get_sub_field('fx_fl1_selecione_rede_1_2') == 'ytube'):
								?>
									<div class="container">
										<div class="row social-block">
											<div class="col-sm-12">
												
												<?php if(get_sub_field('fx_fl1_titulo_1_2')): ?>
													<p><?php echo get_sub_field('fx_fl1_titulo_1_2'); ?></p>
												<?php endif; ?>

												<?php if(get_sub_field('fx_fl1_descricao_1_2')): ?>
													<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_1_2'); ?></p>
												<?php endif; ?>		

												<?php if(get_sub_field('fx_fl1_pagina_1_2')): ?>
													<a href="<?php echo get_sub_field('fx_fl1_pagina_1_2'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-youtube-play" aria-hidden="true"></i> | Youtube</button></a>
												<?php endif; ?>
												
											</div>												
											<div class="col-sm-12 mt-4">
												<?php
													if(get_sub_field('fx_fl1_video_1_2')) :
														$url = get_sub_field('fx_fl1_video_1_2');
														parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
												?>
													<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $my_array_of_vars['v']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php
									endif;
								endif;

							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
					//conteudo flexivel 2 colunas direita
					if( have_rows('fx_coluna_2_2') ):
						echo '<div class="col-sm-6 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_2_2') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_2_2' ):
									//echo '<h1 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h1>';
									$cab_h = get_sub_field('cabecalho_h_construtor_2_2');
									$ali_h = get_sub_field('alinhar_h_construtor_2_2');
									//echo $cab_h['value'];
									if($cab_h['value'] == 'h1'){
										echo '<h1 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h1>';
									}elseif ($cab_h['value'] == 'h2') {
										echo '<h2 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h2>';
									}else{
										echo '<h1 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h1>';
									}
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_2_2').'</div>';
								//editor Wysiwyg com fundo
								elseif( get_row_layout() == 'fx_cl1_editor_fundo_2_2' ): 
									echo '<div style="background: url('.get_sub_field('imagem_de_fundo').')" class="mt-3 mb-3 bg_img_fix">'.get_sub_field('fx_editor_2_2').'</div>';
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
									?>
									<div  id="noticias_fx" class="row overflow-auto">
									<?php query_posts(array(
										'cat' => get_sub_field('fx_noticias_2_2'),
										'post_per_page' => -1
									)); ?>
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
										<div class="col-sm-6 mt-3 mb-3 text-center">
											<?php
											$image_id = get_post_thumbnail_id();
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
											?>
											<img src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%" alt="<?php echo $image_alt; ?>">
											<p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
										</div>
									<?php endwhile; endif; ?>
									<?php wp_reset_query(); ?>
									</div>
									<?php
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
									echo '<div class="mt-3 mb-3 video-2">'.get_sub_field('fx_video_2_2').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
									$imagem_2_2 = get_sub_field('fx_imagem_2_2');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_2_2') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_2_2') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_2_2['url'] ?>" width="100%" alt="<?php echo $imagem_2_2['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_2_2['url'].'" width="100%" alt="'.$imagem_2_2['alt'].'">';
									}
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
									if(get_sub_field('fx_abas_2_2'))://repeater
										
										//loop menu aba
										echo '<ul class="nav nav-tabs mb-3 mt-3">';
											$count_2_2=0;
											while(has_sub_field('fx_abas_2_2'))://verifica conteudo no repeater
												$count_2_2++;
												//echo $count;
												$aba_title_2_2 = get_sub_field('fx_nome_abas_2_2');
												$id_aba_2_2 = clean($aba_title);
												echo '<li class="nav-item">';
													echo '<a class="nav-link" data-toggle="tab" href="#abab' . $count_2_2 . $id_aba_2_2 . '"><strong>'.get_sub_field('fx_nome_abas_2_2').'</strong></a>';
												echo '</li>';
											endwhile;
										echo '</ul>';
		
										//loop conteudo aba
										echo '<div class="tab-content mb-3 mt-3">';
												$count_2_2=0;
										while(has_sub_field('fx_abas_2_2'))://verifica se editor no repeater
												$count_2_2++;
												//echo $count;
												$aba_title_2_2 = get_sub_field('fx_nome_abas_2_2');
												$id_aba_2_2 = clean($aba_title);
											echo '<div class="tab-pane container mt-3 mb-3" id="abab'. $count_2_2 . $id_aba_2_2 .'">'.get_sub_field('fx_editor_abas_2_2').'</div>';
		
										endwhile;
										echo '</div>';
		
									 endif;
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
									if(get_sub_field('fx_sanfona_2_2'))://repeater
										//loop sanfona
										echo '<div id="accordionb" class="mt-3 mb-3">';
											$countb=0;
											while(has_sub_field('fx_sanfona_2_2'))://verifica conteudo no repeater
												$countb++;
												//echo $count;
												  echo '<div class="card sanfona ">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapseb'.$countb.'">';
														echo '<strong>'.get_sub_field('fx_nome_sanfona_2_2').'</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapseb'.$countb.'" class="collapse" data-parent="#accordionb">';
													  echo '<div class="card-body">';
														echo get_sub_field('fx_editor_sanfona_2_2');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';
											endwhile;
										echo '</div>';		
									 endif;
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_2_2') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_2_2') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_2_2' ):
														//loop de botões responsivos
														echo '<div class="col">';
															echo '<a href="'.get_sub_field('fx_url_botao_2_2').'"><button type="button" class="btn mt-1 mb-1 bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_2_2').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;									

								// Bloco Redes Sociais
								elseif( get_row_layout() == 'fx_fl1_bloco_rede_2_2' ):
									if(get_sub_field('fx_fl1_selecione_rede_2_2') == 'insta'):
								?>

										<div class="container">	
											<div class="row social-block">
												<div class="col-sm-12 col-md-5">
													<?php if(get_sub_field('fx_fl1_titulo_2_2')): ?>
														<p><?php echo get_sub_field('fx_fl1_titulo_2_2'); ?></p>
													<?php endif; ?>

													<?php if(get_sub_field('fx_fl1_descricao_2_2')): ?>
														<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_2_2'); ?></p>
													<?php endif; ?>

													<hr>

													<?php if(get_sub_field('fx_fl1_pagina_2_2')): ?>
														<a href="<?php echo get_sub_field('fx_fl1_pagina_2_2'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-instagram" aria-hidden="true"></i> | Instagram</button></a>
													<?php endif; ?>
													
												</div>
												<div class="col-sm-12 col-md-7">
													<?php if(get_sub_field('fx_fl1_shortcode_2_2')):
														$short = get_sub_field('fx_fl1_shortcode_2_2');
														echo do_shortcode($short);
													endif; ?>
													
												</div>
											</div>
										</div>

								<?php
									elseif(get_sub_field('fx_fl1_selecione_rede_2_2') == 'face'):
								?>
									<div class="row social-block">
										<div class="col-sm-12 col-md-5">

											<?php if(get_sub_field('fx_fl1_titulo_2_2')): ?>
												<p><?php echo get_sub_field('fx_fl1_titulo_2_2'); ?></p>
											<?php endif; ?>

											<?php if(get_sub_field('fx_fl1_descricao_2_2')): ?>
												<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_2_2'); ?></p>
											<?php endif; ?>

											<hr>
											<?php if(get_sub_field('fx_fl1_pagina_2_2')): ?>
												<a href="<?php echo get_sub_field('fx_fl1_pagina_2_2'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-facebook-square" aria-hidden="true"></i> | Facebook</button></a>
											<?php endif; ?>
						
										</div>
										<div class="col-sm-12 col-md-7">
											<div class="fb-page" data-href="<?php echo get_sub_field('fx_fl1_pagina_2_2'); ?>" data-tabs="timeline" data-width="" data-height="310" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/EducaPrefSP/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/EducaPrefSP/">Secretaria Municipal de Educação de São Paulo</a></blockquote></div>
										</div>
									</div>
								<?php
									elseif(get_sub_field('fx_fl1_selecione_rede_2_2') == 'ytube'):
								?>
									<div class="container">
										<div class="row social-block">
											<div class="col-sm-12">
												
												<?php if(get_sub_field('fx_fl1_titulo_2_2')): ?>
													<p><?php echo get_sub_field('fx_fl1_titulo_2_2'); ?></p>
												<?php endif; ?>

												<?php if(get_sub_field('fx_fl1_descricao_2_2')): ?>
													<p class='social-descri'><?php echo get_sub_field('fx_fl1_descricao_2_2'); ?></p>
												<?php endif; ?>		

												<?php if(get_sub_field('fx_fl1_pagina_2_2')): ?>
													<a href="<?php echo get_sub_field('fx_fl1_pagina_2_2'); ?>"><button type="button" class="btn btn-primary btn-sm px-3 my-3"><i class="fa fa-youtube-play" aria-hidden="true"></i> | Youtube</button></a>
												<?php endif; ?>
												
											</div>												
											<div class="col-sm-12 mt-4">
												<?php
													if(get_sub_field('fx_fl1_video_2_2')) :
														$url = get_sub_field('fx_fl1_video_2_2');
														parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
												?>
													<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $my_array_of_vars['v']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php
									endif;
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
						echo '</div>';//bootstrap row
						echo '</div>';//bootstrap container
						echo '</div>';//fundo
		////////////////////////////// Final 2 Colunas ///////////////////////////////
		
        ////////////////////////////// Inicio 3 Colunas ///////////////////////////////
        elseif( get_row_layout() == 'fx_linha_coluna_3' ):
					//Personalização da coluna
					$background = get_sub_field('fx_fundo_da_coluna_1_1');
					$color = get_sub_field('fx_cor_do_texto_coluna_1_1');
					$link = get_sub_field('fx_cor_do_link_coluna_1_1');
					$colorbtn = get_sub_field('fx_cor_do_botao_coluna_1_1');
					
					echo '<div class="bg_fx_'.$background['value'].' lk_fx_'.$link['value'].' fx_all">';//fundo e link
					echo '<div class="container">';//bootstrap container
					echo '<div class="row">';//bootstrap row
		        	//conteudo flexivel 3 colunas (primeira coluna)
					if( have_rows('fx_coluna_1_3') ):
						echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_1_3') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_1_3' ):
									echo '<h2 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_3').'</h2>';
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_3' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_1_3').'</div>';
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_3' ): 
									echo '<div class="mt-3 mb-3 video-3">'.get_sub_field('fx_video_1_3').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_3' ): 
									$imagem_1_3 = get_sub_field('fx_imagem_1_3');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_1_3') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_1_3') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_1_3['url'] ?>" width="100%" alt="<?php echo $imagem_1_3['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_1_3['url'].'" width="100%" alt="'.$imagem_1_3['alt'].'">';
									}
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_3' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_3' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_1_3') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_1_3') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_1_3' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_1_3').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_1_3').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
					//conteudo flexivel 3 colunas (segunda coluna)
					if( have_rows('fx_coluna_2_3') ):
						echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_2_3') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_2_3' ):
									echo '<h2 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_3').'</h2>';
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_3' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_2_3').'</div>';
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_3' ): 
									echo '<div class="mt-3 mb-3 video-3">'.get_sub_field('fx_video_2_3').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_2_3' ): 
									$imagem_2_3 = get_sub_field('fx_imagem_2_3');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_2_3') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_2_3') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_2_3['url'] ?>" width="100%" alt="<?php echo $imagem_2_3['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_2_3['url'].'" width="100%" alt="'.$imagem_2_3['alt'].'">';
									}
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_3' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_3' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_2_3') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_2_3') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_2_3' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_2_3').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_2_3').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
		
					//conteudo flexivel 3 colunas (terceira coluna)
					if( have_rows('fx_coluna_3_3') ):
						echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_3_3') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_3_3' ):
									echo '<h2 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_3_3').'</h2>';
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_3_3' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_3_3').'</div>';
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_3_3' ): 
									echo '<div class="mt-3 mb-3 video-3">'.get_sub_field('fx_video_3_3').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_3_3' ): 
									$imagem_3_3 = get_sub_field('fx_imagem_3_3');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_3_3') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_3_3') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_3_3['url'] ?>" width="100%" alt="<?php echo $imagem_3_3['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_3_3['url'].'" width="100%" alt="'.$imagem_3_3['alt'].'">';
									}
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_3_3' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_3_3' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_3_3') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_3_3') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_3_3' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_3_3').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_3_3').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
						echo '</div>';//bootstrap row
						echo '</div>';//bootstrap container
						echo '</div>';//fundo
		////////////////////////////// Final 3 Colunas ///////////////////////////////
		
		////////////////////////////// Inicio 4 Colunas ///////////////////////////////
        elseif( get_row_layout() == 'fx_linha_coluna_4' ):
					//Personalização da coluna
					$background = get_sub_field('fx_fundo_da_coluna_1_1');
					$color = get_sub_field('fx_cor_do_texto_coluna_1_1');
					$link = get_sub_field('fx_cor_do_link_coluna_1_1');
					$colorbtn = get_sub_field('fx_cor_do_botao_coluna_1_1');
					
					echo '<div class="bg_fx_'.$background['value'].' lk_fx_'.$link['value'].' fx_all">';//fundo e link
					echo '<div class="container">';//bootstrap container
					echo '<div class="row">';//bootstrap row
		        	//conteudo flexivel 4 colunas (primeira coluna)
					if( have_rows('fx_coluna_1_4') ):
						echo '<div class="col-sm-3 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_1_4') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_1_4' ):
									echo '<h2 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_4').'</h2>';
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_4' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_1_4').'</div>';
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_4' ): 
									echo '<div class="mt-3 mb-3 video-4">'.get_sub_field('fx_video_1_4').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_4' ): 
									$imagem_1_4 = get_sub_field('fx_imagem_1_4');//Pega todos os valores da imagem no array
									//echo the_sub_field('fx_imagem_url_1_4');
									if(get_sub_field('fx_imagem_url_1_4') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_1_4') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_1_4['url'] ?>" width="100%" alt="<?php echo $imagem_1_4['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_1_4['url'].'" width="100%" alt="'.$imagem_1_4['alt'].'">';
									}
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_4' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_4' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_1_4') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_1_4') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_1_4' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_1_4').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_1_4').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
					//conteudo flexivel 4 colunas (segunda coluna)
					if( have_rows('fx_coluna_2_4') ):
						echo '<div class="col-sm-3 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_2_4') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_2_4' ):
									echo '<h2 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_4').'</h2>';
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_4' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_2_4').'</div>';
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_4' ): 
									echo '<div class="mt-3 mb-3 video-4">'.get_sub_field('fx_video_2_4').'</div>';
								//imagem responsiva

								elseif( get_row_layout() == 'fx_cl1_imagem_2_4' ): 
									$imagem_2_4 = get_sub_field('fx_imagem_2_4');//Pega todos os valores da imagem no array

									if(get_sub_field('fx_imagem_url_2_4') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_2_4') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_2_4['url'] ?>" width="100%" alt="<?php echo $imagem_2_4['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_2_4['url'].'" width="100%" alt="'.$imagem_2_4['alt'].'">';
									}
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_4' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_4' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_2_4') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_2_4') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_2_4' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_2_4').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_2_4').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
		
					//conteudo flexivel 4 colunas (terceira coluna)
					if( have_rows('fx_coluna_3_4') ):
						echo '<div class="col-sm-3 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_3_4') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_3_4' ):
									echo '<h2 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_3_4').'</h2>';
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_3_4' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_3_4').'</div>';
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_3_4' ): 
									echo '<div class="mt-3 mb-3 video-4">'.get_sub_field('fx_video_3_4').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_3_4' ): 
									$imagem_3_4 = get_sub_field('fx_imagem_3_4');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_3_4') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_3_4') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_3_4['url'] ?>" width="100%" alt="<?php echo $imagem_3_4['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_3_4['url'].'" width="100%" alt="'.$imagem_3_4['alt'].'">';
									}
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_3_4' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_3_4' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_3_4') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_3_4') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_3_4' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_3_4').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_3_4').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
					//conteudo flexivel 4 colunas (quarta coluna)
					if( have_rows('fx_coluna_4_4') ):
						echo '<div class="col-sm-3 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_4_4') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_4_4' ):
									echo '<h2 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_4_4').'</h2>';
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_4_4' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_4_4').'</div>';
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_4_4' ): 
									echo '<div class="mt-3 mb-3 video-4">'.get_sub_field('fx_video_4_4').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_4_4' ): 
									$imagem_4_4 = get_sub_field('fx_imagem_4_4');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_4_4') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_4_4') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_4_4['url'] ?>" width="100%" alt="<?php echo $imagem_4_4['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_4_4['url'].'" width="100%" alt="'.$imagem_4_4['alt'].'">';
									}
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_4_4' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_4_4' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_4_4') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_4_4') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_4_4' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_4_4').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_4_4').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
						echo '</div>';//bootstrap row
						echo '</div>';//bootstrap container
						echo '</div>';//fundo
		////////////////////////////// Final 3 Colunas ///////////////////////////////



		////////////////////////////// Inicio 1/3 Colunas ///////////////////////////////
        elseif( get_row_layout() == 'fx_linha_coluna_1b3' ):
					//Personalização da coluna
					$background = get_sub_field('fx_fundo_da_coluna_1_1');
					$color = get_sub_field('fx_cor_do_texto_coluna_1_1');
					$link = get_sub_field('fx_cor_do_link_coluna_1_1');
					$colorbtn = get_sub_field('fx_cor_do_botao_coluna_1_1');
					
					echo '<div class="bg_fx_'.$background['value'].' lk_fx_'.$link['value'].' fx_all">';//fundo e link
					echo '<div class="container">';//bootstrap container
					echo '<div class="row">';//bootstrap row
		        	//conteudo flexivel 2 colunas esquerda
					if( have_rows('fx_coluna_1_1b3') ):

						echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_1_1b3') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_1_2' ):
									//echo '<h1 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_1').'</h1>';
									$cab_h = get_sub_field('cabecalho_h_construtor_1_2');
									$ali_h = get_sub_field('alinhar_h_construtor_1_2');
									//echo $cab_h['value'];
									if($cab_h['value'] == 'h1'){
										echo '<h1 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h1>';
									}elseif ($cab_h['value'] == 'h2') {
										echo '<h2 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h2>';
									}else{
										echo '<h1 class="text-left mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h1>';
									}
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_1_2').'</div>';
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
									?>
									<div  id="noticias_fx" class="row overflow-auto">
									<?php query_posts(array(
										'cat' => get_sub_field('fx_noticias_1_2'),
										'post_per_page' => -1
									)); ?>
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
										<div class="col-sm-6 mt-3 mb-3 text-center">
											<?php
											$image_id = get_post_thumbnail_id();
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
											?>
											<img src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%" alt="<?php echo $image_alt; ?>">
											<p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
										</div>
									<?php endwhile; endif; ?>
									<?php wp_reset_query(); ?>
									</div>
									<?php
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
									echo '<div class="mt-3 mb-3 video-2">'.get_sub_field('fx_video_1_2').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
									$imagem_1_2 = get_sub_field('fx_imagem_1_2');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_1_2') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_1_2') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_1_2['url'] ?>" width="100%" alt="<?php echo $imagem_1_2['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_1_2['url'].'" width="100%" alt="'.$imagem_1_2['alt'].'">';
									}
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
									if(get_sub_field('fx_abas_1_2'))://repeater
										
										//loop menu aba
										echo '<ul class="nav nav-tabs mb-3 mt-3">';
											$count_1_2=0;
											while(has_sub_field('fx_abas_1_2'))://verifica conteudo no repeater
												$count_1_2++;
												//echo $count;
												$aba_title_1_2 = get_sub_field('fx_nome_abas_1_2');
												$id_aba_1_2 = clean($aba_title);
												echo '<li class="nav-item">';
													echo '<a class="nav-link" data-toggle="tab" href="#abaa' . $count_1_2 . $id_aba_1_2 . '"><strong>'.get_sub_field('fx_nome_abas_1_2').'</strong></a>';
												echo '</li>';
											endwhile;
										echo '</ul>';
		
										//loop conteudo aba
										echo '<div class="tab-content mb-3 mt-3">';
												$count_1_2=0;
										while(has_sub_field('fx_abas_1_2'))://verifica se editor no repeater
												$count_1_2++;
												//echo $count;
												$aba_title_1_2 = get_sub_field('fx_nome_abas_1_2');
												$id_aba_1_2 = clean($aba_title);
											echo '<div class="tab-pane container mt-3 mb-3" id="abaa' . $count_1_2 . $id_aba_1_2 . '">'.get_sub_field('fx_editor_abas_1_2').'</div>';
		
										endwhile;
										echo '</div>';
		
									 endif;
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
									if(get_sub_field('fx_sanfona_1_2'))://repeater
										//loop sanfona
										echo '<div id="accordiona" class="mt-3 mb-3">';
											$count_a=0;
											while(has_sub_field('fx_sanfona_1_2'))://verifica conteudo no repeater
												$count_a++;
												//echo $count;
												  echo '<div class="card sanfona ">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapsea'.$count_a.'">';
														echo '<strong>'.get_sub_field('fx_nome_sanfona_1_2').'</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapsea'.$count_a.'" class="collapse" data-parent="#accordiona">';
													  echo '<div class="card-body">';
														echo get_sub_field('fx_editor_sanfona_1_2');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';
											endwhile;
										echo '</div>';		
									 endif;
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_1_2') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_1_2') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_1_2' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_1_2').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_1_2').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
					//conteudo flexivel 2 colunas direita
					if( have_rows('fx_coluna_2_1b3') ):
						echo '<div class="col-sm-8 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_2_1b3') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_2_2' ):
									//echo '<h1 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_1').'</h1>';
									$cab_h = get_sub_field('cabecalho_h_construtor_2_2');
									$ali_h = get_sub_field('alinhar_h_construtor_2_2');
									//echo $cab_h['value'];
									if($cab_h['value'] == 'h1'){
										echo '<h1 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h1>';
									}elseif ($cab_h['value'] == 'h2') {
										echo '<h2 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h2>';
									}else{
										echo '<h1 class="text-left mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h1>';
									}
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_2_2').'</div>';
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
									?>
									<div  id="noticias_fx" class="row overflow-auto">
									<?php query_posts(array(
										'cat' => get_sub_field('fx_noticias_2_2'),
										'post_per_page' => -1
									)); ?>
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
										<div class="col-sm-6 mt-3 mb-3 text-center">
											<?php
											$image_id = get_post_thumbnail_id();
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
											?>
											<img src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%" alt="<?php echo $image_alt; ?>">
											<p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
										</div>
									<?php endwhile; endif; ?>
									<?php wp_reset_query(); ?>
									</div>
									<?php
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
									echo '<div class="mt-3 mb-3 video-2">'.get_sub_field('fx_video_2_2').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
									$imagem_2_2 = get_sub_field('fx_imagem_2_2');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_2_2') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_2_2') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_2_2['url'] ?>" width="100%" alt="<?php echo $imagem_2_2['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_2_2['url'].'" width="100%" alt="'.$imagem_2_2['alt'].'">';
									}
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
									if(get_sub_field('fx_abas_2_2'))://repeater
										
										//loop menu aba
										echo '<ul class="nav nav-tabs mb-3 mt-3">';
											$count_2_2=0;
											while(has_sub_field('fx_abas_2_2'))://verifica conteudo no repeater
												$count_2_2++;
												//echo $count;
												$aba_title_2_2 = get_sub_field('fx_nome_abas_2_2');
												$id_aba_2_2 = clean($aba_title);
												echo '<li class="nav-item">';
													echo '<a class="nav-link" data-toggle="tab" href="#abab' . $count_2_2 . $id_aba_2_2 . '"><strong>'.get_sub_field('fx_nome_abas_2_2').'</strong></a>';
												echo '</li>';
											endwhile;
										echo '</ul>';
		
										//loop conteudo aba
										echo '<div class="tab-content mb-3 mt-3">';
												$count_2_2=0;
										while(has_sub_field('fx_abas_2_2'))://verifica se editor no repeater
												$count_2_2++;
												//echo $count;
												$aba_title_2_2 = get_sub_field('fx_nome_abas_2_2');
												$id_aba_2_2 = clean($aba_title);
											echo '<div class="tab-pane container mt-3 mb-3" id="abab' . $count_2_2 . $id_aba_2_2 . '">'.get_sub_field('fx_editor_abas_2_2').'</div>';
		
										endwhile;
										echo '</div>';
		
									 endif;
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
									if(get_sub_field('fx_sanfona_2_2'))://repeater
										//loop sanfona
										echo '<div id="accordionb" class="mt-3 mb-3">';
											$countb=0;
											while(has_sub_field('fx_sanfona_2_2'))://verifica conteudo no repeater
												$countb++;
												//echo $count;
												  echo '<div class="card sanfona ">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapseb'.$countb.'">';
														echo '<strong>'.get_sub_field('fx_nome_sanfona_2_2').'</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapseb'.$countb.'" class="collapse" data-parent="#accordionb">';
													  echo '<div class="card-body">';
														echo get_sub_field('fx_editor_sanfona_2_2');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';
											endwhile;
										echo '</div>';		
									 endif;
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_2_2') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_2_2') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_2_2' ):
														//loop de botões responsivos
														echo '<div class="col">';
															echo '<a href="'.get_sub_field('fx_url_botao_2_2').'"><button type="button" class="btn mt-1 mb-1 bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_2_2').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
						echo '</div>';//bootstrap row
						echo '</div>';//bootstrap container
						echo '</div>';//fundo
		////////////////////////////// Final 1/3 Colunas ///////////////////////////////


		////////////////////////////// Inicio 3/1 Colunas ///////////////////////////////
        elseif( get_row_layout() == 'fx_linha_coluna_3b1' ):
					//Personalização da coluna
					$background = get_sub_field('fx_fundo_da_coluna_1_1');
					$color = get_sub_field('fx_cor_do_texto_coluna_1_1');
					$link = get_sub_field('fx_cor_do_link_coluna_1_1');
					$colorbtn = get_sub_field('fx_cor_do_botao_coluna_1_1');
					
					echo '<div class="bg_fx_'.$background['value'].' lk_fx_'.$link['value'].' fx_all">';//fundo e link
					echo '<div class="container">';//bootstrap container
					echo '<div class="row">';//bootstrap row
		        	//conteudo flexivel 2 colunas esquerda
					if( have_rows('fx_coluna_1_3b1') ):

						echo '<div class="col-sm-8 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_1_3b1') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_1_2' ):
									//echo '<h1 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_1').'</h1>';
									$cab_h = get_sub_field('cabecalho_h_construtor_1_2');
									$ali_h = get_sub_field('alinhar_h_construtor_1_2');
									//echo $cab_h['value'];
									if($cab_h['value'] == 'h1'){
										echo '<h1 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h1>';
									}elseif ($cab_h['value'] == 'h2') {
										echo '<h2 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h2>';
									}else{
										echo '<h1 class="text-left mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_2').'</h1>';
									}
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_1_2').'</div>';
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
									?>
									<div  id="noticias_fx" class="row overflow-auto">
									<?php query_posts(array(
										'cat' => get_sub_field('fx_noticias_1_2'),
										'post_per_page' => -1
									)); ?>
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
										<div class="col-sm-6 mt-3 mb-3 text-center">
											<?php
											$image_id = get_post_thumbnail_id();
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
											?>
											<img src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%" alt="<?php echo $image_alt; ?>">
											<p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
										</div>
									<?php endwhile; endif; ?>
									<?php wp_reset_query(); ?>
									</div>
									<?php
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
									echo '<div class="mt-3 mb-3 video-2">'.get_sub_field('fx_video_1_2').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
									$imagem_1_2 = get_sub_field('fx_imagem_1_2');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_1_2') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_1_2') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_1_2['url'] ?>" width="100%" alt="<?php echo $imagem_1_2['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_1_2['url'].'" width="100%" alt="'.$imagem_1_2['alt'].'">';
									}
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
									if(get_sub_field('fx_abas_1_2'))://repeater
										
										//loop menu aba
										echo '<ul class="nav nav-tabs mb-3 mt-3">';
											$count_1_2=0;
											while(has_sub_field('fx_abas_1_2'))://verifica conteudo no repeater
												$count_1_2++;
												//echo $count;
												$aba_title_1_2 = get_sub_field('fx_nome_abas_1_2');
												$id_aba_1_2 = clean($aba_title);
												echo '<li class="nav-item">';
													echo '<a class="nav-link" data-toggle="tab" href="#abaa' . $count_1_2 . $id_aba_1_2 . '"><strong>'.get_sub_field('fx_nome_abas_1_2').'</strong></a>';
												echo '</li>';
											endwhile;
										echo '</ul>';
		
										//loop conteudo aba
										echo '<div class="tab-content mb-3 mt-3">';
												$count_1_2=0;
										while(has_sub_field('fx_abas_1_2'))://verifica se editor no repeater
												$count_1_2++;
												//echo $count;
												$aba_title_1_2 = get_sub_field('fx_nome_abas_1_2');
												$id_aba_1_2 = clean($aba_title);
											echo '<div class="tab-pane container mt-3 mb-3" id="abaa' . $count_1_2 . $id_aba_1_2 . '">'.get_sub_field('fx_editor_abas_1_2').'</div>';
		
										endwhile;
										echo '</div>';
		
									 endif;
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
									if(get_sub_field('fx_sanfona_1_2'))://repeater
										//loop sanfona
										echo '<div id="accordiona" class="mt-3 mb-3">';
											$count_a=mt_rand(1,99);
											while(has_sub_field('fx_sanfona_1_2'))://verifica conteudo no repeater
												$count_a++;
												//echo $count;
												  echo '<div class="card sanfona ">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapsea'.$count_a.'">';
														echo '<strong>'.get_sub_field('fx_nome_sanfona_1_2').'</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapsea'.$count_a.'" class="collapse" data-parent="#accordiona">';
													  echo '<div class="card-body">';
														echo get_sub_field('fx_editor_sanfona_1_2');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';
											endwhile;
										echo '</div>';		
									 endif;
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_1_2') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_1_2') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_1_2' ):
														//loop de botões responsivos
														echo '<div class="col">';
															echo '<a href="'.get_sub_field('fx_url_botao_1_2').'"><button type="button" class="btn mt-1 mb-1 bt_fx btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_1_2').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
					//conteudo flexivel 2 colunas direita
					if( have_rows('fx_coluna_2_3b1') ):
						echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_2_3b1') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_2_2' ):
									//echo '<h1 class="mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_1_1').'</h1>';
									$cab_h = get_sub_field('cabecalho_h_construtor_2_2');
									$ali_h = get_sub_field('alinhar_h_construtor_2_2');
									//echo $cab_h['value'];
									if($cab_h['value'] == 'h1'){
										echo '<h1 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h1>';
									}elseif ($cab_h['value'] == 'h2') {
										echo '<h2 class="text-'.$ali_h['value'].' mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h2>';
									}else{
										echo '<h1 class="text-left mt-3 mb-3 tx_fx_'.$color['value'].'">'.get_sub_field('fx_titulo_2_2').'</h1>';
									}
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
									echo '<div class="mt-3 mb-3">'.get_sub_field('fx_editor_2_2').'</div>';
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
									?>
									<div  id="noticias_fx" class="row overflow-auto">
									<?php query_posts(array(
										'cat' => get_sub_field('fx_noticias_2_2'),
										'post_per_page' => -1
									)); ?>
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
										<div class="col-sm-6 mt-3 mb-3 text-center">
											<?php
											$image_id = get_post_thumbnail_id();
											$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
											?>
											<img src="<?php echo get_the_post_thumbnail_url(); ?>" width="100%" alt="<?php echo $image_alt; ?>">
											<p><a href="<?php echo get_permalink(); ?>"><h3><?php the_title(); ?></h3></a></p>
										</div>
									<?php endwhile; endif; ?>
									<?php wp_reset_query(); ?>
									</div>
									<?php
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
									echo '<div class="mt-3 mb-3 video-2">'.get_sub_field('fx_video_2_2').'</div>';
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
									$imagem_2_2 = get_sub_field('fx_imagem_2_2');//Pega todos os valores da imagem no array
									if(get_sub_field('fx_imagem_url_2_2') != ''){
										?>
										  <a href="<?php echo the_sub_field('fx_imagem_url_2_2') ?>">
										  	<img class="mt-3 mb-3" src="<?php echo $imagem_2_2['url'] ?>" width="100%" alt="<?php echo $imagem_2_2['alt'] ?>">
										  </a>
										<?php
									}else{
										echo '<img class="mt-3 mb-3" src="'.$imagem_2_2['url'].'" width="100%" alt="'.$imagem_2_2['alt'].'">';
									}
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
									if(get_sub_field('fx_abas_2_2'))://repeater
										
										//loop menu aba
										echo '<ul class="nav nav-tabs mb-3 mt-3">';
											$count_2_2=0;
											while(has_sub_field('fx_abas_2_2'))://verifica conteudo no repeater
												$count_2_2++;
												//echo $count;
												$aba_title_2_2 = get_sub_field('fx_nome_abas_2_2');
												$id_aba_2_2 = clean($aba_title);
												echo '<li class="nav-item">';
													echo '<a class="nav-link" data-toggle="tab" href="#abab' . $count_2_2 . $id_aba_2_2 . '"><strong>'.get_sub_field('fx_nome_abas_2_2').'</strong></a>';
												echo '</li>';
											endwhile;
										echo '</ul>';
		
										//loop conteudo aba
										echo '<div class="tab-content mb-3 mt-3">';
												$count_2_2=0;
										while(has_sub_field('fx_abas_2_2'))://verifica se editor no repeater
												$count_2_2++;
												//echo $count;
												$aba_title_2_2 = get_sub_field('fx_nome_abas_2_2');
												$id_aba_2_2 = clean($aba_title);
											echo '<div class="tab-pane container mt-3 mb-3" id="abab' . $count_2_2 . $id_aba_2_2 . '">'.get_sub_field('fx_editor_abas_2_2').'</div>';
		
										endwhile;
										echo '</div>';
		
									 endif;
								//Sanfona

								elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
									if(get_sub_field('fx_sanfona_2_2'))://repeater
										//loop sanfona
										echo '<div id="accordionb" class="mt-3 mb-3">';
											$countbf=mt_rand(1,99);
											while(has_sub_field('fx_sanfona_2_2'))://verifica conteudo no repeater
												$countbf++;
												
												  echo '<div class="card sanfona ">';
													echo '<div class="card-header">';
													  echo '<a class="collapsed card-link" data-toggle="collapse" href="#collapseb'.$countbf.'">';
														echo '<strong>'.get_sub_field('fx_nome_sanfona_2_2').'</strong>';
													  echo '</a>';
													echo '</div>';
													echo '<div id="collapseb'.$countbf.'" class="collapse" data-parent="#accordionb">';
													  echo '<div class="card-body">';
														echo get_sub_field('fx_editor_sanfona_2_2');
													  echo '</div>';
													echo '</div>';
												  echo '</div>';
												  
											endwhile;
										echo '</div>';		
									 endif;
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
									echo '<div class="mt-3 mb-3 hr-divisor">';
										if(get_sub_field('divisor_hr') == linhaazul){
											echo '<hr class=" hr-divisor-azul">';
										}elseif (get_sub_field('divisor_hr') == linhagrafite) {
											echo '<hr class=" hr-divisor-grafite">';
										}else{
											echo '<hr class=" hr-divisor-branca">';
										}
									echo '</div>';
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
									//conteudo flexivel Botão
									if( have_rows('fx_botao_2_2') ):
										echo '<div class="row">';
											while ( have_rows('fx_botao_2_2') ) : the_row();
												if( get_row_layout() == 'fx_cl1_botao_2_2' ):
														//loop de botões responsivos
														echo '<div class="col-sm-12">';
															echo '<a href="'.get_sub_field('fx_url_botao_2_2').'"><button type="button" class="btn mt-1 mb-1 bt_fx_100 btn-'.$colorbtn['value'].' btn-lg btn-block">'.get_sub_field('fx_nome_botao_2_2').'</button></a>';
														echo '</div>';
												endif;
											endwhile;
										echo '</div>';
									else :
									endif;	
								endif;
							endwhile;
						echo '</div>';//bootstrap col

					endif;//-------------------------------------------------------------
		
						echo '</div>';//bootstrap row
						echo '</div>';//bootstrap container
						echo '</div>';//fundo
		////////////////////////////// Final 1/3 Colunas ///////////////////////////////


        endif;
    endwhile;
endif;
		
?>
	</div>
</div>
		<?php
	}
}