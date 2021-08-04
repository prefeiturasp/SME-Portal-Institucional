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
						echo '<div class="container-fluid p-0">';//bootstrap container
						echo '<div class="row">';//bootstrap row
						echo '<div class="col-sm-12 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
							while( have_rows('fx_coluna_1_1') ): the_row();
								//titulo
								if( get_row_layout() == 'fx_cl1_titulo_1_1' ):
									get_template_part( 'construtor/construtor', 'titulo_1_1' );

								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_1' ):
									get_template_part( 'construtor/construtor', 'editor_1_1' );
									
								//editor Wysiwyg com fundo
								elseif( get_row_layout() == 'fx_cl1_editor_fundo_1_1' ): 
									get_template_part( 'construtor/construtor', 'editor_fundo_1_1' );
								
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_1_1' ):
									get_template_part( 'construtor/construtor', 'noticias_categ_1_1' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_1' ): 
									get_template_part( 'construtor/construtor', 'video_1_1' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_1' ): 
									get_template_part( 'construtor/construtor', 'imagem_1_1' );
								
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_1_1' ): 		
									get_template_part( 'construtor/construtor', 'abas_1_1' );
								
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_1_1' ): 		
									get_template_part( 'construtor/construtor', 'sanfona_1_1' );

								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_1' ): 
									get_template_part( 'construtor/construtor', 'divisor_1_1' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_1' ): 
									get_template_part( 'construtor/construtor', 'botao_1_1' );
								
								//Contatos em camadas
								elseif( get_row_layout() == 'fx_cl1_contato_camadas_1_1' ): 
									get_template_part( 'construtor/construtor', 'contato_camadas_1_1' );
																
								//Contato Individual
								elseif( get_row_layout() == 'fx_cl1_contato_individual_1_1' ):
									get_template_part( 'construtor/construtor', 'contato_individual_1_1' );

								// Slide de Noticias
								elseif( get_row_layout() == 'fx_cl1_slide_noticias_1_1' ):
									get_template_part( 'construtor/construtor', 'slide_noticias_1_1' );

								// Slide de Noticias - Timer
								elseif( get_row_layout() == 'fx_cl1_slide_timer_1_1' ):
									get_template_part( 'construtor/construtor', 'slide_timer_1_1' );

								// Acesso Rapido
								elseif( get_row_layout() == 'fx_cl1_acesso_rapido_1_1' ):									
									get_template_part( 'construtor/construtor', 'acesso_rapido_1_1' );									

								// Bloco Noticias
								elseif( get_row_layout() == 'fx_cl1_bloco_noticias_1_1' ):
									get_template_part( 'construtor/construtor', 'bloco_noticias_1_1' );

								// Bloco Noticias - Timer
								elseif( get_row_layout() == 'fx_cl1_bloco_timer_1_1' ):
									get_template_part( 'construtor/construtor', 'bloco_noticias_timer_1_1' );

								// Bloco Redes Sociais
								elseif( get_row_layout() == 'fx_fl1_bloco_rede_1_1' ):
									get_template_part( 'construtor/construtor', 'bloco_rede_1_1' );

								// Noticias em destaque
								elseif( get_row_layout() == 'fx_cl1_noticias_destaque_1_1' ):
									get_template_part( 'construtor/construtor', 'noticias_destaque_1_1' );

								// Noticias mais lidas
								elseif( get_row_layout() == 'fx_cl1_mais_lidas_1_1' ):
									get_template_part( 'construtor/construtor', 'mais_lidas_1_1' );

								// Noticias mais lidas (Pagina)
								elseif( get_row_layout() == 'fx_cl1_mais_lidas_pag_1_1' ):
									get_template_part( 'construtor/construtor', 'mais_lidas_pag_1_1' );

								// Outras Noticias
								elseif( get_row_layout() == 'fx_cl1_outras_noticias' ):
									get_template_part( 'construtor/construtor', 'outras_noticias_1_1' );

								// Noticias DREs
								elseif( get_row_layout() == 'fx_cl1_noticias_dres' ):
									get_template_part( 'construtor/construtor', 'noticias_dres_1_1' );
								
								// Organograma DREs
								elseif( get_row_layout() == 'fx_cl1_organograma' ):
									get_template_part( 'construtor/construtor', 'organograma_1_1' );
								
								// Integracao Pagina
								elseif( get_row_layout() == 'integrar_pagina' ):

									$page = get_sub_field('selecionar_paginas');

									// Pega o content padrao do WP
									foreach( $page as $post){
										$content_post = get_post($post);
										$content = $content_post->post_content;
										$content = apply_filters('the_content', $content);
										$content = str_replace(']]>', ']]&gt;', $content);
										echo "<div class='container'>";
										echo "<div class='row'>";
										echo "<div class='col-sm-12'>";
											echo $content;
										echo "</div>";
										echo "</div>";
										echo "</div>";
									}
									
									// Pega o conteudo do construtor
									foreach( $page as $post ) : setup_postdata( $post );										

										if( have_rows('fx_flex_layout', $post) ):
											while( have_rows('fx_flex_layout', $post) ): the_row();
											
																					
												if( get_row_layout() == 'fx_linha_coluna_1' ):
													//Personalização da coluna
													$background = get_sub_field('fx_fundo_da_coluna_1_1');
													$color = get_sub_field('fx_cor_do_texto_coluna_1_1');
													$link = get_sub_field('fx_cor_do_link_coluna_1_1');
													$colorbtn = get_sub_field('fx_cor_do_botao_coluna_1_1');

																										
													//conteudo flexivel 1 coluna
													if( have_rows('fx_coluna_1_1', $post) ):
														echo '<div class="bg_fx_'.$background['value'].' lk_fx_'.$link['value'].' fx_all">';//fundo e link
														echo '<div class="container">';//bootstrap container
														echo '<div class="row">';//bootstrap row
														echo '<div class="col-sm-12 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
															while( have_rows('fx_coluna_1_1', $post) ): the_row();
																
																//titulo
																if( get_row_layout() == 'fx_cl1_titulo_1_1' ):
																	get_template_part( 'construtor/construtor', 'titulo_1_1' );

																//editor Wysiwyg
																elseif( get_row_layout() == 'fx_cl1_editor_1_1' ):
																	get_template_part( 'construtor/construtor', 'editor_1_1' );
																	
																//editor Wysiwyg com fundo
																elseif( get_row_layout() == 'fx_cl1_editor_fundo_1_1' ): 
																	get_template_part( 'construtor/construtor', 'editor_fundo_1_1' );
																
																//Loops noticias por categorias
																elseif( get_row_layout() == 'fx_cl1_noticias_1_1' ):
																	get_template_part( 'construtor/construtor', 'noticias_categ_1_1' );
																
																//Video Responsivo
																elseif( get_row_layout() == 'fx_cl1_video_1_1' ): 
																	get_template_part( 'construtor/construtor', 'video_1_1' );
																
																//imagem responsiva
																elseif( get_row_layout() == 'fx_cl1_imagem_1_1' ): 
																	get_template_part( 'construtor/construtor', 'imagem_1_1' );
																
																//abas
																elseif( get_row_layout() == 'fx_cl1_abas_1_1' ): 		
																	get_template_part( 'construtor/construtor', 'abas_1_1' );
																
																//Sanfona
																elseif( get_row_layout() == 'fx_cl1_sanfona_1_1' ): 		
																	get_template_part( 'construtor/construtor', 'sanfona_1_1' );

																//Divisor
																elseif( get_row_layout() == 'fx_fl1_divisor_1_1' ): 
																	get_template_part( 'construtor/construtor', 'divisor_1_1' );
																
																//botão centralizado
																elseif( get_row_layout() == 'fx_fl1_botao_1_1' ): 
																	get_template_part( 'construtor/construtor', 'botao_1_1' );
																
																//Contatos em camadas
																elseif( get_row_layout() == 'fx_cl1_contato_camadas_1_1' ): 
																	get_template_part( 'construtor/construtor', 'contato_camadas_1_1' );
																								
																//Contato Individual
																elseif( get_row_layout() == 'fx_cl1_contato_individual_1_1' ):
																	get_template_part( 'construtor/construtor', 'contato_individual_1_1' );

																// Slide de Noticias
																elseif( get_row_layout() == 'fx_cl1_slide_noticias_1_1' ):
																	get_template_part( 'construtor/construtor', 'slide_noticias_1_1' );

																// Acesso Rapido
																elseif( get_row_layout() == 'fx_cl1_acesso_rapido_1_1' ):									
																	get_template_part( 'construtor/construtor', 'acesso_rapido_1_1' );									

																// Bloco Noticias
																elseif( get_row_layout() == 'fx_cl1_bloco_noticias_1_1' ):
																	get_template_part( 'construtor/construtor', 'bloco_noticias_1_1' );

																// Bloco Redes Sociais
																elseif( get_row_layout() == 'fx_fl1_bloco_rede_1_1' ):
																	get_template_part( 'construtor/construtor', 'bloco_rede_1_1' );
																endif;

															endwhile;
														echo "</div>";
														echo "</div>";
														echo "</div>";
														echo "</div>";
													endif;

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
																		get_template_part( 'construtor/construtor', 'titulo_1_2' );

																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
																		get_template_part( 'construtor/construtor', 'editor_1_2' );
																	
																	//editor Wysiwyg com fundo
																	elseif( get_row_layout() == 'fx_cl1_editor_fundo_1_2' ): 
																		get_template_part( 'construtor/construtor', 'editor_fundo_1_2' );
																	
																	//Loops noticias por categorias
																	elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
																		get_template_part( 'construtor/construtor', 'noticias_1_2' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
																		get_template_part( 'construtor/construtor', 'video_1_2' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
																		get_template_part( 'construtor/construtor', 'imagem_1_2' );
																	
																	//abas
																	elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
																		get_template_part( 'construtor/construtor', 'abas_1_2' );
																	
																	//Sanfona
																	elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
																		get_template_part( 'construtor/construtor', 'sanfona_1_2' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
																		get_template_part( 'construtor/construtor', 'divisor_1_2' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
																		get_template_part( 'construtor/construtor', 'botao_1_2' );

																	// Bloco Redes Sociais
																	elseif( get_row_layout() == 'fx_fl1_bloco_rede_1_2' ):
																		get_template_part( 'construtor/construtor', 'bloco_rede_1_2' );
																	endif;

																endwhile;
															echo '</div>';//bootstrap col

														endif; // fx_coluna_1_2

														//conteudo flexivel 2 colunas direita
														if( have_rows('fx_coluna_2_2') ):
															echo '<div class="col-sm-6 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
																while( have_rows('fx_coluna_2_2') ): the_row();
																	//titulo
																	if( get_row_layout() == 'fx_cl1_titulo_2_2' ):
																		get_template_part( 'construtor/construtor', 'titulo_2_2' );

																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
																		get_template_part( 'construtor/construtor', 'editor_2_2' );
																	
																	//editor Wysiwyg com fundo
																	elseif( get_row_layout() == 'fx_cl1_editor_fundo_2_2' ): 
																		get_template_part( 'construtor/construtor', 'editor_fundo_2_2' );
																	
																	//Loops noticias por categorias
																	elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
																		get_template_part( 'construtor/construtor', 'noticias_2_2' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
																		get_template_part( 'construtor/construtor', 'video_2_2' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
																		get_template_part( 'construtor/construtor', 'imagem_2_2' );
																	
																	//abas
																	elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
																		get_template_part( 'construtor/construtor', 'abas_2_2' );
																	
																	//Sanfona
																	elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
																		get_template_part( 'construtor/construtor', 'sanfona_2_2' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
																		get_template_part( 'construtor/construtor', 'divisor_2_2' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
																		get_template_part( 'construtor/construtor', 'botao_2_2' );							

																	// Bloco Redes Sociais
																	elseif( get_row_layout() == 'fx_fl1_bloco_rede_2_2' ):
																		get_template_part( 'construtor/construtor', 'bloco_rede_2_2' );

																	endif;
																endwhile;
															echo '</div>';//bootstrap col
														endif; // fx_coluna_1_2

													echo '</div>';//bootstrap row
													echo '</div>';//bootstrap container
													echo '</div>';//fundo

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
																		get_template_part( 'construtor/construtor', 'titulo_3_1' );
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_1_3' ): 
																		get_template_part( 'construtor/construtor', 'editor_3_1' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_1_3' ): 
																		get_template_part( 'construtor/construtor', 'video_3_1' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_1_3' ): 
																		get_template_part( 'construtor/construtor', 'imagem_3_1' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_1_3' ): 
																		get_template_part( 'construtor/construtor', 'divisor_3_1' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_1_3' ): 
																		get_template_part( 'construtor/construtor', 'botao_3_1' );
																	endif;
																endwhile;
															echo '</div>';
														endif;

														//conteudo flexivel 3 colunas (segunda coluna)
														if( have_rows('fx_coluna_2_3') ):
															echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
																while( have_rows('fx_coluna_2_3') ): the_row();

																	//titulo
																	if( get_row_layout() == 'fx_cl1_titulo_2_3' ):
																		get_template_part( 'construtor/construtor', 'titulo_3_2' );
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_2_3' ): 
																		get_template_part( 'construtor/construtor', 'editor_3_2' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_2_3' ): 
																		get_template_part( 'construtor/construtor', 'video_3_2' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_2_3' ): 
																		get_template_part( 'construtor/construtor', 'imagem_3_2' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_2_3' ): 
																		get_template_part( 'construtor/construtor', 'divisor_3_2' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_2_3' ): 
																		get_template_part( 'construtor/construtor', 'botao_3_2' );
																	endif;

																endwhile;
															echo '</div>';
														endif;

														//conteudo flexivel 3 colunas (terceira coluna)
														if( have_rows('fx_coluna_3_3') ):
															echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
																while( have_rows('fx_coluna_3_3') ): the_row();
																	
																	//titulo
																	if( get_row_layout() == 'fx_cl1_titulo_3_3' ):
																		get_template_part( 'construtor/construtor', 'titulo_3_3' );
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_3_3' ): 
																		get_template_part( 'construtor/construtor', 'editor_3_3' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_3_3' ): 
																		get_template_part( 'construtor/construtor', 'video_3_3' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_3_3' ): 
																		get_template_part( 'construtor/construtor', 'imagem_3_3' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_3_3' ): 
																		get_template_part( 'construtor/construtor', 'divisor_3_3' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_3_3' ): 
																		get_template_part( 'construtor/construtor', 'botao_3_3' );
																	endif;

																endwhile;
															echo '</div>';
														endif;
													
													echo '</div>';//bootstrap row
													echo '</div>';//bootstrap container
													echo '</div>';//fundo
													
												
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
																		get_template_part( 'construtor/construtor', 'titulo_4_1' );									
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_1_4' ): 
																		get_template_part( 'construtor/construtor', 'editor_4_1' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_1_4' ): 
																		get_template_part( 'construtor/construtor', 'video_4_1' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_1_4' ): 
																		get_template_part( 'construtor/construtor', 'imagem_4_1' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_1_4' ): 
																		get_template_part( 'construtor/construtor', 'divisor_4_1' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_1_4' ): 
																		get_template_part( 'construtor/construtor', 'botao_4_1' );
																	endif;	
																
																endwhile;
															echo '</div>';
														endif;

														//conteudo flexivel 4 colunas (segunda coluna)
														if( have_rows('fx_coluna_2_4') ):
															echo '<div class="col-sm-3 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
																while( have_rows('fx_coluna_2_4') ): the_row();
																	//titulo
																	if( get_row_layout() == 'fx_cl1_titulo_2_4' ):
																		get_template_part( 'construtor/construtor', 'titulo_4_2' );									
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_2_4' ): 
																		get_template_part( 'construtor/construtor', 'editor_4_2' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_2_4' ): 
																		get_template_part( 'construtor/construtor', 'video_4_2' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_2_4' ): 
																		get_template_part( 'construtor/construtor', 'imagem_4_2' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_2_4' ): 
																		get_template_part( 'construtor/construtor', 'divisor_4_2' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_2_4' ): 
																		get_template_part( 'construtor/construtor', 'botao_4_2' );
																	endif;	
																endwhile;
															echo '</div>';
														endif;

														//conteudo flexivel 4 colunas (terceira coluna)
														if( have_rows('fx_coluna_3_4') ):
															echo '<div class="col-sm-3 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
																while( have_rows('fx_coluna_3_4') ): the_row();
																	//titulo
																	if( get_row_layout() == 'fx_cl1_titulo_3_4' ):
																		get_template_part( 'construtor/construtor', 'titulo_4_3' );									
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_3_4' ): 
																		get_template_part( 'construtor/construtor', 'editor_4_3' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_3_4' ): 
																		get_template_part( 'construtor/construtor', 'video_4_3' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_3_4' ): 
																		get_template_part( 'construtor/construtor', 'imagem_4_3' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_3_4' ): 
																		get_template_part( 'construtor/construtor', 'divisor_4_3' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_3_4' ): 
																		get_template_part( 'construtor/construtor', 'botao_4_3' );
																	endif;	
																endwhile;
															echo '</div>';
														endif;

														//conteudo flexivel 4 colunas (quarta coluna)
														if( have_rows('fx_coluna_4_4') ):
															echo '<div class="col-sm-3 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
																while( have_rows('fx_coluna_4_4') ): the_row();
																	//titulo
																	if( get_row_layout() == 'fx_cl1_titulo_4_4' ):
																		get_template_part( 'construtor/construtor', 'titulo_4_4' );									
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_4_4' ): 
																		get_template_part( 'construtor/construtor', 'editor_4_4' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_4_4' ): 
																		get_template_part( 'construtor/construtor', 'video_4_4' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_4_4' ): 
																		get_template_part( 'construtor/construtor', 'imagem_4_4' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_4_4' ): 
																		get_template_part( 'construtor/construtor', 'divisor_4_4' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_4_4' ): 
																		get_template_part( 'construtor/construtor', 'botao_4_4' );
																	endif;
																endwhile;
															echo '</div>';
														endif;

													echo '</div>';//bootstrap row
													echo '</div>';//bootstrap container
													echo '</div>';//fundo

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
																		get_template_part( 'construtor/construtor', 'titulo_3b_1' );
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
																		get_template_part( 'construtor/construtor', 'editor_3b_1' );
																	
																	//Loops noticias por categorias
																	elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
																		get_template_part( 'construtor/construtor', 'noticias_3b_1' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
																		get_template_part( 'construtor/construtor', 'video_3b_1' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
																		get_template_part( 'construtor/construtor', 'imagem_3b_1' );
																	
																	//abas
																	elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
																		get_template_part( 'construtor/construtor', 'abas_3b_1' );
																	
																	//Sanfona
																	elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
																		get_template_part( 'construtor/construtor', 'sanfona_3b_1' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
																		get_template_part( 'construtor/construtor', 'divisor_3b_1' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
																		get_template_part( 'construtor/construtor', 'botao_3b_1' );
																	endif;

																endwhile;
															echo '</div>';

														endif;

														//conteudo flexivel 2 colunas direita
														if( have_rows('fx_coluna_2_1b3') ):
															echo '<div class="col-sm-8 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
																while( have_rows('fx_coluna_2_1b3') ): the_row();
																	//titulo
																	if( get_row_layout() == 'fx_cl1_titulo_2_2' ):
																		get_template_part( 'construtor/construtor', 'titulo_1b_3' );

																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
																		get_template_part( 'construtor/construtor', 'editor_1b_3' );
																	
																	//Loops noticias por categorias
																	elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
																		get_template_part( 'construtor/construtor', 'noticias_1b_3' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
																		get_template_part( 'construtor/construtor', 'video_1b_3' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
																		get_template_part( 'construtor/construtor', 'imagem_1b_3' );
																	
																	//abas
																	elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
																		get_template_part( 'construtor/construtor', 'abas_1b_3' );
																	
																	//Sanfona
																	elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
																		get_template_part( 'construtor/construtor', 'sanfona_1b_3' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
																		get_template_part( 'construtor/construtor', 'divisor_1b_3' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
																		get_template_part( 'construtor/construtor', 'botao_1b_3' );
																	endif;
																endwhile;
															echo '</div>';
														endif;
													
													echo '</div>';//bootstrap row
													echo '</div>';//bootstrap container
													echo '</div>';//fundo

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
																		get_template_part( 'construtor/construtor', 'titulo_1_3b' );
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
																		get_template_part( 'construtor/construtor', 'editor_1_3b' );
																	
																	//Loops noticias por categorias
																	elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
																		get_template_part( 'construtor/construtor', 'noticias_1_3b' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
																		get_template_part( 'construtor/construtor', 'video_1_3b' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
																		get_template_part( 'construtor/construtor', 'imagem_1_3b' );
																	
																	//abas
																	elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
																		get_template_part( 'construtor/construtor', 'abas_1_3b' );
																	
																	//Sanfona
																	elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
																		get_template_part( 'construtor/construtor', 'sanfona_1_3b' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
																		get_template_part( 'construtor/construtor', 'divisor_1_3b' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
																		get_template_part( 'construtor/construtor', 'botao_1_3b' );
																	endif;
																endwhile;
															echo '</div>';

														endif;

														//conteudo flexivel 2 colunas direita
														if( have_rows('fx_coluna_2_3b1') ):
															echo '<div class="col-sm-4 tx_fx_'.$color['value'].'  mt-3 mb-3">';//bootstrap col
																while( have_rows('fx_coluna_2_3b1') ): the_row();
																	
																	//titulo
																	if( get_row_layout() == 'fx_cl1_titulo_2_2' ):
																		get_template_part( 'construtor/construtor', 'titulo_3_1b' );
																	
																	//editor Wysiwyg
																	elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
																		get_template_part( 'construtor/construtor', 'editor_3_1b' );
																	
																	//Loops noticias por categorias
																	elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
																		get_template_part( 'construtor/construtor', 'noticias_3_1b' );
																	
																	//Video Responsivo
																	elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
																		get_template_part( 'construtor/construtor', 'video_3_1b' );
																	
																	//imagem responsiva
																	elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
																		get_template_part( 'construtor/construtor', 'imagem_3_1b' );
																	
																	//abas
																	elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
																		get_template_part( 'construtor/construtor', 'abas_3_1b' );
																	
																	//Sanfona
																	elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
																		get_template_part( 'construtor/construtor', 'sanfona_3_1b' );
																	
																	//Divisor
																	elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
																		get_template_part( 'construtor/construtor', 'divisor_3_1b' );
																	
																	//botão centralizado
																	elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
																		get_template_part( 'construtor/construtor', 'botao_3_1b' );
																	endif;

																endwhile;
															echo '</div>';

														endif;

													echo '</div>';//bootstrap row
													echo '</div>';//bootstrap container
													echo '</div>';//fundo
												
												endif; // fx_linha_coluna_1b3
												 
						
											endwhile;
										endif;
										
										
									endforeach;
									wp_reset_postdata();

									//echo get_the_content($page[0]);

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
								get_template_part( 'construtor/construtor', 'sanfona_dre' );

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
									get_template_part( 'construtor/construtor', 'titulo_1_2' );

								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
									get_template_part( 'construtor/construtor', 'editor_1_2' );
								
								//editor Wysiwyg com fundo
								elseif( get_row_layout() == 'fx_cl1_editor_fundo_1_2' ): 
									get_template_part( 'construtor/construtor', 'editor_fundo_1_2' );
								
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
									get_template_part( 'construtor/construtor', 'noticias_1_2' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
									get_template_part( 'construtor/construtor', 'video_1_2' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
									get_template_part( 'construtor/construtor', 'imagem_1_2' );
								
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
									get_template_part( 'construtor/construtor', 'abas_1_2' );
								
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
									get_template_part( 'construtor/construtor', 'sanfona_1_2' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
									get_template_part( 'construtor/construtor', 'divisor_1_2' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
									get_template_part( 'construtor/construtor', 'botao_1_2' );

								// Bloco Redes Sociais
								elseif( get_row_layout() == 'fx_fl1_bloco_rede_1_2' ):
									get_template_part( 'construtor/construtor', 'bloco_rede_1_2' );
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
									get_template_part( 'construtor/construtor', 'titulo_2_2' );

								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
									get_template_part( 'construtor/construtor', 'editor_2_2' );
								
								//editor Wysiwyg com fundo
								elseif( get_row_layout() == 'fx_cl1_editor_fundo_2_2' ): 
									get_template_part( 'construtor/construtor', 'editor_fundo_2_2' );
								
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
									get_template_part( 'construtor/construtor', 'noticias_2_2' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
									get_template_part( 'construtor/construtor', 'video_2_2' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
									get_template_part( 'construtor/construtor', 'imagem_2_2' );
								
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
									get_template_part( 'construtor/construtor', 'abas_2_2' );
								
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
									get_template_part( 'construtor/construtor', 'sanfona_2_2' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
									get_template_part( 'construtor/construtor', 'divisor_2_2' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
									get_template_part( 'construtor/construtor', 'botao_2_2' );							

								// Bloco Redes Sociais
								elseif( get_row_layout() == 'fx_fl1_bloco_rede_2_2' ):
									get_template_part( 'construtor/construtor', 'bloco_rede_2_2' );	

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
										get_template_part( 'construtor/construtor', 'titulo_3_1' );
									
									//editor Wysiwyg
									elseif( get_row_layout() == 'fx_cl1_editor_1_3' ): 
										get_template_part( 'construtor/construtor', 'editor_3_1' );
									
									//Video Responsivo
									elseif( get_row_layout() == 'fx_cl1_video_1_3' ): 
										get_template_part( 'construtor/construtor', 'video_3_1' );
									
									//imagem responsiva
									elseif( get_row_layout() == 'fx_cl1_imagem_1_3' ): 
										get_template_part( 'construtor/construtor', 'imagem_3_1' );
									
									//Divisor
									elseif( get_row_layout() == 'fx_fl1_divisor_1_3' ): 
										get_template_part( 'construtor/construtor', 'divisor_3_1' );
									
									//botão centralizado
									elseif( get_row_layout() == 'fx_fl1_botao_1_3' ): 
										get_template_part( 'construtor/construtor', 'botao_3_1' );
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
										get_template_part( 'construtor/construtor', 'titulo_3_2' );
									
									//editor Wysiwyg
									elseif( get_row_layout() == 'fx_cl1_editor_2_3' ): 
										get_template_part( 'construtor/construtor', 'editor_3_2' );
									
									//Video Responsivo
									elseif( get_row_layout() == 'fx_cl1_video_2_3' ): 
										get_template_part( 'construtor/construtor', 'video_3_2' );
									
									//imagem responsiva
									elseif( get_row_layout() == 'fx_cl1_imagem_2_3' ): 
										get_template_part( 'construtor/construtor', 'imagem_3_2' );
									
									//Divisor
									elseif( get_row_layout() == 'fx_fl1_divisor_2_3' ): 
										get_template_part( 'construtor/construtor', 'divisor_3_2' );
									
									//botão centralizado
									elseif( get_row_layout() == 'fx_fl1_botao_2_3' ): 
										get_template_part( 'construtor/construtor', 'botao_3_2' );
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
										get_template_part( 'construtor/construtor', 'titulo_3_3' );
									
									//editor Wysiwyg
									elseif( get_row_layout() == 'fx_cl1_editor_3_3' ): 
										get_template_part( 'construtor/construtor', 'editor_3_3' );
									
									//Video Responsivo
									elseif( get_row_layout() == 'fx_cl1_video_3_3' ): 
										get_template_part( 'construtor/construtor', 'video_3_3' );
									
									//imagem responsiva
									elseif( get_row_layout() == 'fx_cl1_imagem_3_3' ): 
										get_template_part( 'construtor/construtor', 'imagem_3_3' );
									
									//Divisor
									elseif( get_row_layout() == 'fx_fl1_divisor_3_3' ): 
										get_template_part( 'construtor/construtor', 'divisor_3_3' );
									
									//botão centralizado
									elseif( get_row_layout() == 'fx_fl1_botao_3_3' ): 
										get_template_part( 'construtor/construtor', 'botao_3_3' );
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
									get_template_part( 'construtor/construtor', 'titulo_4_1' );									
								
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_4' ): 
									get_template_part( 'construtor/construtor', 'editor_4_1' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_4' ): 
									get_template_part( 'construtor/construtor', 'video_4_1' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_4' ): 
									get_template_part( 'construtor/construtor', 'imagem_4_1' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_4' ): 
									get_template_part( 'construtor/construtor', 'divisor_4_1' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_4' ): 
									get_template_part( 'construtor/construtor', 'botao_4_1' );
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
									get_template_part( 'construtor/construtor', 'titulo_4_2' );									
								
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_4' ): 
									get_template_part( 'construtor/construtor', 'editor_4_2' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_4' ): 
									get_template_part( 'construtor/construtor', 'video_4_2' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_2_4' ): 
									get_template_part( 'construtor/construtor', 'imagem_4_2' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_4' ): 
									get_template_part( 'construtor/construtor', 'divisor_4_2' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_4' ): 
									get_template_part( 'construtor/construtor', 'botao_4_2' );
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
									get_template_part( 'construtor/construtor', 'titulo_4_3' );									
								
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_3_4' ): 
									get_template_part( 'construtor/construtor', 'editor_4_3' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_3_4' ): 
									get_template_part( 'construtor/construtor', 'video_4_3' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_3_4' ): 
									get_template_part( 'construtor/construtor', 'imagem_4_3' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_3_4' ): 
									get_template_part( 'construtor/construtor', 'divisor_4_3' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_3_4' ): 
									get_template_part( 'construtor/construtor', 'botao_4_3' );
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
									get_template_part( 'construtor/construtor', 'titulo_4_4' );									
								
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_4_4' ): 
									get_template_part( 'construtor/construtor', 'editor_4_4' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_4_4' ): 
									get_template_part( 'construtor/construtor', 'video_4_4' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_4_4' ): 
									get_template_part( 'construtor/construtor', 'imagem_4_4' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_4_4' ): 
									get_template_part( 'construtor/construtor', 'divisor_4_4' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_4_4' ): 
									get_template_part( 'construtor/construtor', 'botao_4_4' );
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
									get_template_part( 'construtor/construtor', 'titulo_3b_1' );
								
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
									get_template_part( 'construtor/construtor', 'editor_3b_1' );
								
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
									get_template_part( 'construtor/construtor', 'noticias_3b_1' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
									get_template_part( 'construtor/construtor', 'video_3b_1' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
									get_template_part( 'construtor/construtor', 'imagem_3b_1' );
								
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
									get_template_part( 'construtor/construtor', 'abas_3b_1' );
								
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
									get_template_part( 'construtor/construtor', 'sanfona_3b_1' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
									get_template_part( 'construtor/construtor', 'divisor_3b_1' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
									get_template_part( 'construtor/construtor', 'botao_3b_1' );
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
									get_template_part( 'construtor/construtor', 'titulo_1b_3' );

								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
									get_template_part( 'construtor/construtor', 'editor_1b_3' );
								
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
									get_template_part( 'construtor/construtor', 'noticias_1b_3' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
									get_template_part( 'construtor/construtor', 'video_1b_3' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
									get_template_part( 'construtor/construtor', 'imagem_1b_3' );
								
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
									get_template_part( 'construtor/construtor', 'abas_1b_3' );
								
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
									get_template_part( 'construtor/construtor', 'sanfona_1b_3' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
									get_template_part( 'construtor/construtor', 'divisor_1b_3' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
									get_template_part( 'construtor/construtor', 'botao_1b_3' );
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
									get_template_part( 'construtor/construtor', 'titulo_1_3b' );
								
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_1_2' ): 
									get_template_part( 'construtor/construtor', 'editor_1_3b' );
								
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_1_2' ):
									get_template_part( 'construtor/construtor', 'noticias_1_3b' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_1_2' ): 
									get_template_part( 'construtor/construtor', 'video_1_3b' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_1_2' ): 
									get_template_part( 'construtor/construtor', 'imagem_1_3b' );
								
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_1_2' ): 		
									get_template_part( 'construtor/construtor', 'abas_1_3b' );
								
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_1_2' ): 		
									get_template_part( 'construtor/construtor', 'sanfona_1_3b' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_1_2' ): 
									get_template_part( 'construtor/construtor', 'divisor_1_3b' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_1_2' ): 
									get_template_part( 'construtor/construtor', 'botao_1_3b' );
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
									get_template_part( 'construtor/construtor', 'titulo_3_1b' );
								
								//editor Wysiwyg
								elseif( get_row_layout() == 'fx_cl1_editor_2_2' ): 
									get_template_part( 'construtor/construtor', 'editor_3_1b' );
								
								//Loops noticias por categorias
								elseif( get_row_layout() == 'fx_cl1_noticias_2_2' ):
									get_template_part( 'construtor/construtor', 'noticias_3_1b' );
								
								//Video Responsivo
								elseif( get_row_layout() == 'fx_cl1_video_2_2' ): 
									get_template_part( 'construtor/construtor', 'video_3_1b' );
								
								//imagem responsiva
								elseif( get_row_layout() == 'fx_cl1_imagem_2_2' ): 
									get_template_part( 'construtor/construtor', 'imagem_3_1b' );
								
								//abas
								elseif( get_row_layout() == 'fx_cl1_abas_2_2' ): 		
									get_template_part( 'construtor/construtor', 'abas_3_1b' );
								
								//Sanfona
								elseif( get_row_layout() == 'fx_cl1_sanfona_2_2' ): 		
									get_template_part( 'construtor/construtor', 'sanfona_3_1b' );
								
								//Divisor
								elseif( get_row_layout() == 'fx_fl1_divisor_2_2' ): 
									get_template_part( 'construtor/construtor', 'divisor_3_1b' );
								
								//botão centralizado
								elseif( get_row_layout() == 'fx_fl1_botao_2_2' ): 
									get_template_part( 'construtor/construtor', 'botao_3_1b' );
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