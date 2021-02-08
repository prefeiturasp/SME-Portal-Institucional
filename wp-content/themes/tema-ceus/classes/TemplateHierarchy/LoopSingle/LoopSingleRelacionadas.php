<?php

namespace Classes\TemplateHierarchy\LoopSingle;


class LoopSingleRelacionadas extends LoopSingle
{
	private $id_post_atual;
	protected $args_relacionadas;
	protected $query_relacionadas;

	public function __construct($id_post_atual)
	{
		$this->id_post_atual = $id_post_atual;
		//$this->init();
		$this->my_related_posts();
	}


	public function getComplementosRelacionadas($id_post){
		$dt_post = get_the_date('d/m/Y g\hi');
		$categoria = get_the_category($id_post)[0]->name;

		return '<p class="fonte-doze font-italic mb-0">Publicado em: '.$dt_post.' - em '.$categoria.'</p>';


	}

	public function compareByTimeStamp($time1, $time2){ 
		if (strtotime($time1) < strtotime($time2)) 
			return -1; 
		else if (strtotime($time1) > strtotime($time2))  
			return 1; 
		else
			return 0; 
	} 

	public function convertData($data){ 
		$dataEvento = $data;

		$dataEvento = explode("-", $dataEvento);
		$mes = $monthName = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
		$data = $dataEvento[2] . " " . $mes . " " . $dataEvento[0];

		return $data;
	} 
	
	public function my_related_posts() {
		global $post;		
		$group_field = get_field( "tipo_de_evento", $post->ID );
		if(!$group_field['evento_principal']) :
	?>
		<div class="end-footer py-4 col-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
						
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

                        <div class="end-title-unidade my-3">
                            <p><?php echo $unidades; ?></p>
						</div>

						<?php
							$categories = get_the_category();
							$category_id = $categories[0]->cat_ID;
							
							$end = get_field('endereco_ceu', 'category_' . $category_id);
							$email = get_field('email_ceu', 'category_' . $category_id);
							$tel = get_field('telefone_ceu', 'category_' . $category_id);
							$mapa = get_field('iframe_mapa_ceu', 'category_' . $category_id);
						?>
						
                        <div class="end-infos">
							<?php if($end != ''): ?>								
								<p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $end; ?></p>
							<?php endif; ?>

							<?php if($email != ''): ?>								
								<p><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $email; ?></p>
							<?php endif; ?>

							<?php if($tel != ''): ?>								
								<p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $tel; ?></p>
							<?php endif; ?>
                            
                        </div>
                    </div>

                    <div class="col-md-6">
						<?php if($mapa != ''): ?>								
							<?php echo $mapa; ?>
						<?php endif; ?>                        
                    </div>
                </div>
            </div>
		</div>
		
		<?php
		else:

			$args = array(
				'post_type' => 'post',
				'meta_query'	=> array(
					'relation'		=> 'AND',					
					array(
						'key'	  	=> 'tipo_de_evento_selecione_o_evento',
						'value'	  	=> $post->ID,
						'compare' 	=> '=',
					)
				),
			);

			

			$diasEventos = array();
			$atividadesEventos = array();
			$unidadesEventos = array();

			
			// The Query
			$the_query = new \WP_Query( $args );

			// The Loop
			if ( $the_query->have_posts() ) {
				
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$campos = get_field('data', get_the_ID());

					$atividadesEventos[] = get_the_terms( $post->ID, 'atividades_categories' );
					$unidadesEventos[] = get_the_terms( $post->ID, 'category' );

					if($campos){

						if($campos['tipo_de_data'] == 'data'){ // Se for do tipo data
							
							$diasEventos[] = $campos['data'];

						}elseif($campos['tipo_de_data'] == 'periodo'){

							$diasEventos[] = $campos['data']; // data inicio
							$diasEventos[] = $campos['data_final']; // data final

						}
					}
					
				}
				
			}

			$filtroAtividades = array();

			foreach($atividadesEventos as $atividades){

				foreach($atividades as $atividade){
					if($atividade->parent == 0){
						$filtroAtividades[] = $atividade->term_id;
					}
				}

			}

			
			$filtroAtividades = array_unique($filtroAtividades);

			$filtroUnidades = array();

			foreach($unidadesEventos as $unidades){

				foreach($unidades as $unidade){
					if($unidade->parent == 0){
						$filtroUnidades[] = $unidade->term_id;
					}
				}

			}

			$filtroUnidades = array_unique($filtroUnidades);
			
			
			wp_reset_postdata();
			
			usort($diasEventos, array($this, 'compareByTimeStamp')); // Ondena por data
			$diasEventos = array_unique($diasEventos); // remove datas iguais
		?>

		<div class="container mt-3 px-0">
		
			<div class="search-home search-event py-4 col-12" id='programacao'>
				<div class="container">
					
					<div class="row">
						<div class="col-sm-12 text-center">							
							<?php 

								// Unidades
								$unidades = get_terms( array( 
									'taxonomy' => 'category',
									'parent'   => 0,                                
									'hide_empty' => false,
									'exclude' => 1
								) );								
							?>
						</div>
						<form action="<?php echo get_the_permalink(); ?>" class="row col-sm-12">
							
							<div class="col-sm-12 col-md-6 px-1">
								<label for="atividades">Atividade(s) de interesse</label>
								<select name="atividades[]" multiple="multiple" class="ms-list-1" id="atividades">
									<?php foreach($filtroAtividades as $term):
										$showAtividade = get_term_by('id', $term, 'atividades_categories');
									?>
										<option value="<?php echo $term; ?>"><?php echo $showAtividade->name; ?></option>
									<?php endforeach; ?>                                                        
								</select>
							</div>

							<div class="col-sm-12 col-md-6 px-1">
								<label for="detalhes">Detalhe(s) de atividade(s)</label>
								<select name="atividadesInternas[]" multiple="multiple" class="ms-list-2" id="detalhes">                                
								</select>
							</div>

							<div class="col-sm-5 mt-3 px-1">
								<label for="tipoData">Data</label>
								<select name='data' class="form-control" id="tipoData">
									<option value="" disabled selected>Selecione a data</option>
									
									<?php foreach($diasEventos as $dia) : ?>
										<option value="<?php echo $dia; ?>"><?php echo $this->convertData($dia); ?></option>
									<?php endforeach; ?>  
								</select>
							</div>

							

							<div class="col-sm-12 col-md-6 mt-3 px-1">
								<label for="unidades">CEUs</label>
								<select name="unidades[]" multiple="multiple" class="ms-list-5" id="unidades">
									<?php foreach($filtroUnidades as $term):
										$showAtividade = get_term_by('id', $term, 'category');
									?>
										<option value="<?php echo $term; ?>"><?php echo $showAtividade->name; ?></option>
									<?php endforeach; ?>      
								</select>
							</div>

							
							<div class="col-sm-1 text-right mt-3" style="align-self: flex-end;">
								<button type="submit" class="btn btn-search rounded-0">Buscar</button>
							</div>
							
						</form> <!-- end form -->
					</div> <!-- end row -->
				</div>
			</div>

		</div>

		<?php
						
			if( isset($_GET['data']) && $_GET['data'] != ''){
				$diaEvento = $_GET['data'];

				$diaEvento = str_replace('-', '', $diaEvento);

				$args['meta_query'][] = array (
					'key' => 'data_data',
					'value'     => $diaEvento,
					'compare'   => '=',
				);
			}

			if( isset($_GET['atividades']) && $_GET['atividades'] != ''){
				$atividades = $_GET['atividades'];
				
				$args['tax_query'][] = array (
					'taxonomy' => 'atividades_categories',
					'field'    => 'term_id',
					'terms'    => $atividades,
				);
			}

			if( isset($_GET['atividadesInternas']) && $_GET['atividadesInternas'] != ''){
				$atividadesInternas = $_GET['atividadesInternas'];
				
				$args['tax_query'][] = array (
					'taxonomy' => 'atividades_categories',
					'field'    => 'term_id',
					'terms'    => $atividadesInternas,
				);
			}

			if( isset($_GET['unidades']) && $_GET['unidades'] != ''){
				$unidades = $_GET['unidades'];
				
				$args['tax_query'][] = array (
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $unidades,
				);
			}
			
			// The Query
			$the_query = new \WP_Query( $args );
			
			// The Loop
			if ( $the_query->have_posts() ) {

				echo '<div class="tema-eventos my-4 col-12">';
                	echo '<div class="container px-0">';
						echo '<div class="row">';
						
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
							?>
								<div class="col-sm-3">
									<div class="card-eventos">
										<div class="card-eventos-img">
											<?php 
												
												$imgSelect = get_field('capa_do_evento', get_the_ID());
												$tipo = get_field('tipo_de_evento_selecione_o_evento', get_the_ID());
																							
												$featured_img_url = wp_get_attachment_image_src($imgSelect, 'thumb-eventos');
												if($featured_img_url){
													$imgEvento = $featured_img_url[0];													
													$alt = get_post_meta($imgSelect, '_wp_attachment_image_alt', true);  
												} else {
													$imgEvento = 'https://via.placeholder.com/575x297';
													$alt = get_the_title(get_the_ID());
												}
											?>
											<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $imgEvento; ?>" class="img-fluid d-block" alt="<?php echo $alt; ?>"></a>
											
											<?php if($tipo && $tipo != '') : 
												echo '<span class="flag-pdf-full">';
													echo get_the_title($tipo);
												echo '</span>';
											endif; ?>

										</div>
										<div class="card-eventos-content p-2">
											<div class="evento-categ border-bottom pb-1">
												<?php
													$atividades = get_the_terms( get_the_ID(), 'atividades_categories' );
													
													$listaAtividades = array();

													$atividadesTotal = count($atividades);

													if($atividadesTotal > 1){
														foreach($atividades as $atividade){
															if($atividade->parent != 0){
																$listaAtividades[] = $atividade->name;
															} 
														}
													} else {
														$listaAtividades[] = $atividades[0]->name;
													}

													$total = count($listaAtividades); 
													$k = 0;
													$showAtividades = '';

													foreach($listaAtividades as $atividade){
														$k++;
														if($total - $k == 1 || $total - $k == 0){
															$showAtividades .= $atividade . " ";
														} elseif($total != $k){
															$showAtividades .= $atividade . ", ";
														} else {
															$showAtividades .= "e " . $atividade;
														}
													}
												?>
												<a href="#"><?php echo $showAtividades; ?></a>
											</div>
											<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
											<?php
												$campos = get_field('data', get_the_ID());
												
												// Verifica se possui campos
												if($campos){

													//print_r($campos);


													if($campos['tipo_de_data'] == 'data'){ // Se for do tipo data
														
														$dataEvento = $campos['data'];

														$dataEvento = explode("-", $dataEvento);
														$mes = $monthName = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
														$data = $dataEvento[2] . " " . $mes . " " . $dataEvento[0];

														$dataFinal = $data;

														

													} elseif($campos['tipo_de_data'] == 'semana'){ // se for do tipo semana
														
														$semana = $campos['dia_da_semana'];													
														
														$diasSemana = array();

														foreach($semana as $dias){

															$total = count($dias['selecione_os_dias']); 
															$i = 0;
															$diasShow = '';
															
															foreach($dias['selecione_os_dias'] as $diaS){
																$i++;
																if($total - $i == 1){
																	$diasShow .= $diaS . " ";
																} elseif($total != $i){
																	$diasShow .= $diaS . ", ";
																} else {
																	$diasShow .= "e " . $diaS;
																}	
																														
															}
															$show = array();
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

														$dias = '';
														$show = '';
														
													} elseif($campos['tipo_de_data'] == 'periodo'){
														
														$dataInicial = $campos['data'];
														$dataFinal = $campos['data_final'];

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

														

													}

												} 
											?>
											<p class="mb-0">
												<i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $dataFinal; ?>
												<br>
												<?php
												// Exibe os horários
															$horario = get_field('horario', get_the_ID());

															

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

																		$hora .= ' ás ' . $periodo['periodo_hora_final'];

																	}
																	
																	$k++;
																	
																}

															}else {
																$hora = '';
															}
												?>
												<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $hora; ?>
											</p>
											<?php
												$post_categories = wp_get_post_categories( get_the_ID() );
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
											<p class="mb-0 mt-1 evento-unidade"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $unidades; ?></a></p>
										</div>
									</div>
									<?php 
										
										$term_obj_list = get_the_terms( get_the_ID(), 'atividades_categories' );
										$terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
										
									?>
								</div>

							<?php
								
							}

						echo '</div>';
					echo '</div>';
				echo '</div>';

			} else {
				// no posts found
			}
			/* Restore original Post Data */
			wp_reset_postdata();
			
		endif;
		
	}
	

}