<?php
namespace Classes\TemplateHierarchy\LoopSingle;
class LoopSingleNoticiaPrincipal extends LoopSingle
{
	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		$this->montaHtmlNoticiaPrincipal();
	}
	public function montaHtmlNoticiaPrincipal(){
		if (have_posts()):
			while (have_posts()): the_post();
				echo '<article class="col-sm-12 border-bottom">';
			?>
				
				<div class="evento-informacoes mt-4">
					<div class="container p-0">
						<div class="row">

							<div class="col-md-7 evento-descri">
								<h4>Descritivo do evento:</h4>
								
								<?php the_content(); ?>
								
								<?php
									$flyer = get_field('adicionar_midia');
									
								if(isset($flyer)): ?>
									<div class="flyer-evento py-3">
										<?php if($flyer['url']): ?>
											<img src="<?php echo $flyer['url']; ?>" alt="<?php echo $flyer['alt']; ?>" class="img-fluid d-block mx-auto w-75" alt="">
										<?php endif; ?>
										<?php if($flyer['caption']): ?>
											<p class="text-center"><?php echo $flyer['caption']; ?></p>
										<?php endif; ?>											
									</div>
								<?php endif; ?>

							</div>

							<?php 
								$classi = get_field('classificacao_etaria');
								$espaco = get_field('local_espaco');
								$inscri = get_field('inscricoes');
								$datas = get_field('data'); // Datas
								$end = get_field('endereco'); // Datas
							?>

							<div class="col-md-5 evento-details">
								<table class="table border-right border-left border-bottom">                            
									<tbody>

										<?php
											// Verifica se possui campos
                                            if($datas){

                                                if($datas['tipo_de_data'] == 'data'){ // Se for do tipo data
                                                    $dataInicial = $datas['data'];
                                                    $dataFinal = $datas['data_final'];

                                                    if($dataFinal){ // Verifica se possui a data final
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $dataFinal = explode("-", $dataFinal);
                                                        $mes = $monthName = date('M', mktime(0, 0, 0, $dataFinal[1], 10));

                                                        $data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];
                                                    } else { // Se nao tiver a final mostra apenas a inicial
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $mes = $monthName = date('M', mktime(0, 0, 0, $dataInicial[1], 10));
                                                        $data = $dataInicial[2] . " " . $mes . " " . $dataInicial[0];
                                                    }
                                                } elseif($datas['tipo_de_data'] == 'semana'){ // se for do tipo semana
													$semana = $datas['dia_da_semana'];
													
													
													$diasSemana = array();

													foreach($semana as $dias){

														$total = count($dias['selecione_os_dias']); 
														$i = 0;
														$diasShow = '';
														
														foreach($dias['selecione_os_dias'] as $diaS){
															$i++;
															//echo $dia . "<br>";
															if($total - $i == 1){
																$diasShow .= $diaS . " ";
															} elseif($total != $i){
																$diasShow .= $diaS . ", ";
															} else {
																$diasShow .= "e " . $diaS;
															}	
																													
														}

														$show[] = $diasShow;
														
													}

													$totalDias = count($show);
													$j = 0;	
													
													$dias = '';

                                                    foreach($show as $diaShow){
                                                        $j++;
                                                        if($j == 1){
                                                            $dias .= $diaShow . " ";                                                        
                                                        } else {
                                                            $dias .= "/ " . $diaShow;
                                                        }
                                                    }

													$dataFinal = $dias; 
													
                                                }

                                            }
                                        ?>

										<tr>
											<th scope="row" class="align-middle"><i class="fa fa-calendar" aria-hidden="true"></i></th>
											<td><?php echo $dataFinal; ?></td>                                    
										</tr>

										<?php if($classi != '') : ?>
											<tr>
												<th scope="row" class="align-middle"><i class="fa fa-users" aria-hidden="true"></i></th>
												<td><?php echo $classi; ?></td>                                    
											</tr>
										<?php endif; ?>		
										
										<?php
											global $post;
											$post_categories = wp_get_post_categories( $post->ID );
											$cats = array();
											
											foreach($post_categories as $c){
												$cat = get_category( $c );
												$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
											}

											$total = count($post_categories); 
											$j = 0;
											$unidades = '';

											foreach($cats as $unidade){
												$j++;
												if($total - $j == 1 || $total - $j == 0){
													$unidades .= $unidade['name'] . " ";
												} elseif($total != $j){
													$unidades .= $unidade['name'] . ", ";
												} else {
													$unidades .= "e " . $unidade['name'];
												}
											}
											
										?>

										<tr>
											<th scope="row" class="align-middle"><i class="fa fa-map-marker" aria-hidden="true"></i></th>
											<td><strong><?php echo $unidades; ?></strong>
											
												<?php if($end != '') : ?>
													<br>
													<?php echo $end; ?>
												<?php endif; ?>	
											</td>                                    
										</tr>

										<?php if($espaco != '') : ?>
											<tr>
												<th scope="row" class="align-middle"><i class="fa fa-street-view" aria-hidden="true"></i></th>
												<td><?php echo $espaco; ?></td>                                    
											</tr>
										<?php endif; ?>

										<?php if($inscri != '') : ?>
											<tr>
												<th scope="row" class="align-middle"><i class="fa fa-ticket" aria-hidden="true"></i></th>
												<td><?php echo $inscri; ?></td>                                    
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>

			<?php
				echo '</article>';
			endwhile;
		endif;
		wp_reset_query();
	}
	public function getDataPublicacaoAlteracao(){
		//padrão de horario G\hi
		echo '<span class="display-autor">Publicado em: '.get_the_date('d/m/Y G\hi').' | Atualizado em: '.get_the_modified_date('d/m/Y').'</span>';
	}

	public function getMidiasSociais(){
		/*Utilizando as classes de personalização do Plugin Add This*/
		if (STM_URL === 'http://localhost/furuba-educacao-intranet'){
			echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_d2ly"]');
		}else {
			echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_q0q4"]');
		}
	}
	public function getArquivosAnexos(){
		$unsupported_mimes  = array( 'image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/tiff', 'image/x-icon' );
		$all_mimes          = get_allowed_mime_types();
		$accepted_mimes     = array_diff( $all_mimes, $unsupported_mimes );

		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'post_mime_type'    => $accepted_mimes,
			'posts_per_page' => -1,
			'post_parent' => get_the_ID(),
			'orderby'	=> 'ID',
			'order'	=> 'ASC',
			'exclude'     => get_post_thumbnail_id()
		) );
		if ( $attachments ) {
			echo '<section id="arquivos-anexos">';
			echo '<h2>Arquivos Anexos</h2>';
			foreach ( $attachments as $attachment ) {
				echo '<article>';
				echo '<p><a target="_blank" style="font-size:26px" href="'.$attachment->guid.'"><i class="fa fa-file-text-o fa-3x" aria-hidden="true"></i> Ir para '. $attachment->post_title.'</a></p>';
				echo '<article>';
			}
			echo '</section>';
		}
	}
	public function getCategorias($id_post){
		$categorias = get_the_category($id_post);
		foreach ($categorias as $categoria){
			$category_link = get_category_link( $categoria->term_id );
			echo '<a href="'.$category_link.'"><span class="badge badge-pill badge-light border p-2 m-2 font-weight-normal">ir para '.$categoria->name.'</span></a>';
		}
	}
}
