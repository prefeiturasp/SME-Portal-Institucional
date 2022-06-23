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
		$mes = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
		$mes = translateMonth($mes);
		$data = $dataEvento[2] . " " . $mes . " " . $dataEvento[0];

		return $data;
	} 
	
	public function my_related_posts() {
		global $post;
		$tipoEvento = get_field('tipo_de_evento_tipo', $post->ID);
		$group_field = get_field( "tipo_de_evento", $post->ID );
		if($group_field['evento_principal'] == 'parte' || $group_field['tipo'] == 'singular') :

			$local = get_field('localizacao', $post->ID);							
			$infosBasicas = get_field('informacoes_basicas', $local);
			$zona = get_group_field( 'informacoes_basicas', 'zona_sp', $local );

	?>
		<?php if($local == '31675' || $local == '31244'): ?>

		<?php else : ?>
		<div class="end-footer py-4 col-12 color-<?php echo $zona; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">

                        <div class="end-title-unidade my-3">
                            <p><?php echo get_the_title($local); ?></p>
						</div>
						
                        <div class="end-infos">
							<p>
								<?php 
									if($infosBasicas['endereco'] && $infosBasicas['endereco'] != ''){
										echo $infosBasicas['endereco'];
									}

									if($infosBasicas['numero'] && $infosBasicas['numero'] != ''){
										echo ', ' . $infosBasicas['numero'];
									}

									if($infosBasicas['complemento'] && $infosBasicas['complemento'] != ''){
										echo ' - ' . $infosBasicas['complemento'];
									}

									if($infosBasicas['bairro'] && $infosBasicas['bairro'] != ''){
										echo ' - ' . $infosBasicas['bairro'];
									}

									if($infosBasicas['cep'] && $infosBasicas['cep'] != ''){
										echo ' - CEP: ' . $infosBasicas['cep'];
									}
								?>
							</p>

							<?php if($infosBasicas['email'] != ''): ?>								
								<p><i class="fa fa-envelope" aria-hidden="true"></i> 
								<?php 
									$email_primary = $infosBasicas['email']['email_principal'];
									$email_second = $infosBasicas['email']['email_second'];

									if($email_primary && $email_primary != ''){
										echo $email_primary;
									}
								
									if($email_second && $email_second != ''){
										foreach($email_second as $email){
											echo '<br>' . $email['email'];
										}
									}                        
								?>
								</p>
							<?php endif; ?>

							<?php if($infosBasicas['telefone'] != ''): ?>								
								<p><i class="fa fa-phone" aria-hidden="true"></i> 
									<?php 
										$tel_primary = $infosBasicas['telefone']['telefone_principal'];
										$tel_second = $infosBasicas['telefone']['tel_second'];

										if($tel_primary && $tel_primary != ''){
											echo $tel_primary;
										}
									
										if($tel_second && $tel_second != ''){
											foreach($tel_second as $tel){
												echo ' / ' . $tel['telefone_sec'];
											}
										}                        
									?>
								</p>
							<?php endif; ?>
                            
                        </div>
                    </div>

                    <div class="col-md-6">
						<div id="map" style="width: 100%; height: 350px;"></div>
                        <a href="#map" class="story" data-point="<?php echo $infosBasicas['latitude']; ?>,<?php echo $infosBasicas['longitude']; ?>,<div class='marcador-unidade  color-<?php echo $infosBasicas['zona_sp']; ?>'><p class='marcador-title'><?php echo get_the_title($local); ?></p><p><?php echo $infosBasicas['endereco'];?> nº <?php echo $infosBasicas['numero']; ?> - <?php echo $infosBasicas['bairro']; ?></p><p>CEP: <?php echo $infosBasicas['cep']; ?></p></div>,<?php echo $infosBasicas['zona_sp']; ?>" style="display: none;"> &nbsp;destacar no mapa</a></span>                  
                    </div>
                </div>
            </div>
		</div>
		<?php endif; ?>		
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
					$unidadesEventos[] = get_field('localizacao', $post->ID);

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

				if($atividades != ''){
					foreach($atividades as $atividade){
						if($atividade->parent == 0){
							$filtroAtividades[] = $atividade->term_id;
						}
					}
				}				

			}

			
			$filtroAtividades = array_unique($filtroAtividades);

			$filtroUnidades = array_unique($unidadesEventos);
			
			wp_reset_postdata();
			
			usort($diasEventos, array($this, 'compareByTimeStamp')); // Ondena por data
			$diasEventos = array_unique($diasEventos); // remove datas iguais
		?>

		<?php if($tipoEvento != 'serie'): ?>

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
										<?php foreach($filtroUnidades as $term): ?>
											<option value="<?php echo $term; ?>"><?php echo get_the_title($term); ?></option>
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

		<?php endif; ?>

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
				
				$unidades = $_GET['unidades'];
				$unidadesBusca = array();

				$unidadesBusca['relation'] = 'OR';

				foreach($unidades as $unidade){
					$unidadesBusca[] = array(
						'key'	 	=> 'localizacao',
						'value'	  	=> $unidade
					);
					$unidadesBusca[] = array(
						'key' => 'ceus_participantes_$_localizacao_serie',
						'value'	  	=> $unidade
					);
				}

				

				$args['meta_query'][] = array(
					//'relation'	=> 'OR',				
					$unidadesBusca				
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
																							
												$featured_img_url = wp_get_attachment_image_src($imgSelect, 'recorte-eventos');
												if($featured_img_url){
													$imgEvento = $featured_img_url[0];													
													$alt = get_post_meta($imgSelect, '_wp_attachment_image_alt', true);  
												} else {
													$imgEvento = 'https://via.placeholder.com/640x350';
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
																$listaAtividades[] = $atividade->term_id;
															} 
														}
													} else {
														$listaAtividades[] = $atividades[0]->term_id;
													}

													$total = count($listaAtividades); 
													$k = 0;
													$showAtividades = '';

													foreach($listaAtividades as $atividade){
														$k++;
														if($k == 1){
															$showAtividades .= '<a href="' . get_home_url() . '?s&atividadesInternas[]=' . $atividade . '">' . get_term( $atividade )->name . "</a>";
														} else {
															$showAtividades .= ' ,<a href="' . get_home_url() . '?s&atividadesInternas[]=' . $atividade . '">' . get_term( $atividade )->name . "</a>";
														}
													}
												?>
												<?php echo $showAtividades; ?>
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
														$mes = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
														$mes = translateMonth($mes);
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
															$mes = date('M', mktime(0, 0, 0, $dataFinal[1], 10));
															$mes = translateMonth($mes);

															$data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];

															$dataFinal = $data;
														} else { // Se nao tiver a final mostra apenas a inicial
															$dataInicial = explode("-", $dataInicial);
															$mes = date('M', mktime(0, 0, 0, $dataInicial[1], 10));
															$mes = translateMonth($mes);
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

															$hora .= ' às ' . $periodo['periodo_hora_final'];

														}
														
														$k++;
														
													}

												}else {
													$hora = '';
												}
												?>
												<?php if($hora) : ?>                                           
													<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo convertHour($hora); ?>
												<?php endif; ?>
											</p>
											<?php
												$local = get_field('localizacao', get_the_ID());                                                        
												if($local == '31675' || $local == '31244'):
											?>
												<p class="mb-0 mt-1 evento-unidade no-link"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></p>
											<?php else: ?>
												<p class="mb-0 mt-1 evento-unidade"><a href="<?php echo get_the_permalink($local); ?>"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></a></p>
											<?php endif; ?>
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