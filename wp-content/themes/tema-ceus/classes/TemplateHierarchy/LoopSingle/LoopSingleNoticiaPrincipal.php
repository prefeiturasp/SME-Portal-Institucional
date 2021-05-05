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
								
								<?php echo get_field('descricao'); ?>
								
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
								$categories = get_the_category();
								$category_id = $categories[0]->cat_ID;

								$classi = get_field('faixa');
								$espaco = get_field('local_espaco');
								$inscri = get_field('inscricoes');
								$datas = get_field('data'); // Datas
								$horario = get_field('horario');
								
								
								$tipo = get_field('tipo_de_evento_selecione_o_evento', get_the_ID());
							?>

							<div class="col-md-5 evento-details">
								<table class="table border-right border-left border-bottom">                            
									<tbody>
										
										<?php if($tipo && $tipo != '') : ?>
											<tr>
												<th scope="row" class="align-middle bg-tipo"><i class="fa fa-globe" aria-hidden="true"></i></th>
												<td class="py-4 bg-tipo">
													<p class='m-0'>	
														Esse evento pertence a: “<strong><?php echo get_the_title($tipo); ?></strong>”.<br>
														<strong><a href="<?php echo get_the_permalink($tipo); ?>">Clique aqui</a></strong> para conferir o restante da programação
													</p></td>                                    
											</tr>
										<?php endif; ?>

										<?php
											// Verifica se possui campos
                                            if($datas){

                                                if($datas['tipo_de_data'] == 'data'){ // Se for do tipo data
													
													$dataEvento = $datas['data'];

                                                    $dataEvento = explode("-", $dataEvento);
                                                    $mes = $monthName = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
                                                    $data = $dataEvento[2] . " " . $mes . " " . $dataEvento[0];

													$dataFinal = $data;
													
                                                } else if($datas['tipo_de_data'] == 'periodo'){
													
													$dataInicial = $datas['data'];
                                                    $dataFinal = $datas['data_final'];

                                                    if($dataFinal){ // Verifica se possui a data final
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $dataFinal = explode("-", $dataFinal);
                                                        $mes = $monthName = date('M', mktime(0, 0, 0, $dataFinal[1], 10));

                                                        $data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];

                                                        $dataFinal = $data;
                                                    } else { // Se nao tiver a final mostra apenas a inicial
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $mes = $monthName = date('M', mktime(0, 0, 0, $dataInicial[1], 10));
                                                        $data = $dataInicial[2] . " " . $mes . " " . $dataInicial[0];

                                                        $dataFinal = $data;
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
															} elseif($total == 1){
																$diasShow = $diaS;
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

										<?php
											// Exibe os horários

											if($horario['selecione_o_horario'] == 'horario'){
												$hora = $horario['hora'];
											} elseif($horario['selecione_o_horario'] == 'periodo'){
												
												$hora = '';
												$k = 0;
												
												foreach($horario['hora_periodo'] as $periodo){
													
													if($periodo['periodo_hora_inicio']){

														if($k > 0){
															$hora .= ' / ';
														}

														$hora .= $periodo['periodo_hora_inicio'];

													} 
													
													if ($periodo['periodo_hora_final']){

														$hora .= ' às ' . $periodo['periodo_hora_final'];

													}
													
													$k++;
													
												}

											}else {
												$hora = '';
											}
										?>

										<tr>
											<th scope="row" class="align-middle"><i class="fa fa-clock-o" aria-hidden="true"></i></th>
											<td><?php echo $hora; ?></td> 
										</tr>

										<?php if($classi != '') : ?>
											<tr>
												<th scope="row" class="align-middle"><i class="fa fa-users" aria-hidden="true"></i></th>
												<td><?php 
													//echo $classi;
													$m = 0;
													foreach($classi as $faixa){
														echo "<p class='m-0'>";
															if($faixa['faixa_etaria'][0] != ''){
																$term = get_term( $faixa['faixa_etaria'][0], 'faixa_categories' );
																echo "<strong>" . $term->name . "</strong>";
															}

															if($faixa['data_faixa'] != ''){
																echo " - " . $faixa['data_faixa'];
															}

															if($faixa['horario_faixa'] != ''){
																echo " - " . $faixa['horario_faixa'];
															}

														echo "</p>";
													}
													//print_r($classi);
												?></td>                                    
											</tr>
										<?php endif; ?>		
										
										<?php
											global $post;
											$local = get_field('localizacao', $post->ID); 
										?>

										<tr>
											<th scope="row" class="align-middle"><i class="fa fa-map-marker" aria-hidden="true"></i></th>
											<?php if($local == 31202): ?>
												<td><p class="m-0">Consulte abaixo CEUs participantes</p></td>
											<?php elseif($local == 31248): ?>
												<td><p class="m-0">Para toda a rede</p></td>
											<?php else: ?>
												<td><strong><?php echo get_the_title($local); ?></strong>
												<?php 
													$end = get_field('informacoes_basicas', $local);
													
													if($end != '') : ?>
														<br>
														<?php echo $end['endereco'] . ', ' . $end['numero'] . ' - ' .$end['bairro'] . ' - CEP: ' .$end['cep']; ?>
													<?php endif; ?>	
												</td>
											<?php endif; ?>                                
										</tr>

										<?php if($espaco != '') : ?>
											<tr>
												<th scope="row" class="align-middle"><i class="fa fa-street-view" aria-hidden="true"></i></th>
												<td><?php echo $espaco->name;?></td>                                    
											</tr>
										<?php endif; ?>

										<?php if($inscri != '') : ?>
											<tr>
												<th scope="row" class="align-middle"><i class="fa fa-ticket" aria-hidden="true"></i></th>
												<?php if($inscri['info_inscricoes'] != '' && $inscri['link_inscricoes'] != "") : ?>
													<td><a href="<?php echo $inscri['link_inscricoes']; ?>"><?php echo $inscri['info_inscricoes']; ?></a></td>
												<?php elseif($inscri['info_inscricoes'] != '') : ?>
													<td><?php echo $inscri['info_inscricoes']; ?></td>
												<?php endif; ?>                                  
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
