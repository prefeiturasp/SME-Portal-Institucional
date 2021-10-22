<?php get_header(); ?>

	<div class="container-fluid">	
		<div class="search-home py-4" id='programacao'>
            <div class="container">
                
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h1>Encontre atividades que você goste</h1>
                        <p>As melhores atividades diretamente dos CEUs para a comunidade</p>
                        <?php 
                            
                            // Atividades
                            $terms = get_terms( array( 
                                'taxonomy' => 'atividades_categories',
                                'parent'   => 0,                                
                                'hide_empty' => false
                            ) );

                            // Publico Alvo
                            $publicos = get_terms( array( 
                                'taxonomy' => 'publico_categories',
                                'parent'   => 0,                                
                                'hide_empty' => false
                            ) );

                            // Faixa Etaria
                            $faixas = get_terms( array( 
                                'taxonomy' => 'faixa_categories',
                                'parent'   => 0,                                
                                'hide_empty' => false
                            ) );

                            // Unidades
                            $unidades = get_terms( array( 
                                'taxonomy' => 'category',
                                'parent'   => 0,                                
                                'hide_empty' => false,
                                'exclude' => 1
                            ) );

                            // Periodo
                            $periodos = get_terms( array( 
                                'taxonomy' => 'periodo_categories',
                                'parent'   => 0,                                
                                'hide_empty' => false,
                                'exclude' => 1
                            ) );

                            //echo "<pre>";
                            //print_r($terms);
                            //echo "</pre>";

                            
                        ?>
                    </div>
                    <form action="<?php echo home_url( '/' ); ?>"  id="searchform" class="row col-sm-12">
                        <input id="prodId" name="tipo" type="hidden" value="programacao">
                        <input name="s" type="hidden" value="busca">
                        <div class="col-sm-3 mt-2 px-1">
                            <select name="atividades[]" multiple="multiple" class="ms-list-1" style="">
                                <?php foreach($terms as $term): ?>
                                    <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                                <?php endforeach; ?>                                                        
                            </select>
                        </div>

                        <div class="col-sm-3 mt-2 px-1">
                            <select name="atividadesInternas[]" multiple="multiple" class="ms-list-2" style="">                                
                            </select>
                        </div>

                        <div class="col-sm-3 mt-2 px-1">
                            <select name="publico[]" multiple="multiple" class="ms-list-3" style="">                        
                                <?php foreach ($publicos as $publico): ?>
                                    <option value="<?php echo $publico->term_id; ?>"><?php echo $publico->name; ?></option>
                                <?php endforeach; ?>                    
                            </select>
                        </div>

                        <div class="col-sm-3 mt-2 px-1">
                            <select name="faixaEtaria[]" multiple="multiple" class="ms-list-4" style="">                        
                                <?php foreach ($faixas as $faixa): ?>
                                    <option value="<?php echo $faixa->term_id; ?>"><?php echo $faixa->name; ?></option>
                                <?php endforeach; ?>                      
                            </select>
                        </div>

                        <div class="col-sm-3 mt-3 px-1">
                            
							<select name="unidades[]" multiple="multiple" class="ms-list-5" style="">
								<?php
									$currentID = get_the_id();
									$argsUnidades = array(
										'post_type' => 'unidade',
										'posts_per_page' => -1,
										'post__not_in' => array(31244, 31675),
									);

									$todasUnidades = new \WP_Query( $argsUnidades );
			
									// The Loop
									if ( $todasUnidades->have_posts() ) {
										
										while ( $todasUnidades->have_posts() ) {
											$todasUnidades->the_post();
											if($currentID == get_the_id() ) {
												echo '<option selected value="' . get_the_id() .'">' . get_the_title() .'</option>';
											} else {
												echo '<option value="' . get_the_id() .'">' . get_the_title() .'</option>';
											}
											
										}
									
									}
									wp_reset_postdata();
								?>      
                            </select>
                        </div>

                        <div class="col-sm-3 mt-3 px-1">
                        <select name='tipoData' class="form-control" id="tipoData">
                            <option value="" disabled selected>Selecione o tipo de data</option>
                            <option value='dia_semana'>Dia da Semana</option>
                            <option value='intervalo'>Intervalo de data</option>
                            <option value='mes'>Mês</option>
                        </select>
                        </div>

                        <div class="col-sm-3 mt-3 px-1">
                            
                            <div id='date-range' style='display: none;'>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start" />
                                    <span class="input-group-addon">até</span>
                                    <input type="text" class="input-sm form-control" name="end" />
                                </div>
                            </div>
                            <div id="date-periode">
                                <select name="data[]" multiple="multiple" class="ms-list-10" style="">                        
                                    <option value="" disabled selected>Selecione a(s) data(s)</option>                   
                                </select>
                            </div>
                            
                        </div>

                        <div class="col-sm-3 mt-3 px-1">
							<select name="periodos[]" multiple="multiple" class="ms-list-8" style="">                        
								<option value='manha'>Manhã</option>
                                <option value='tarde'>Tarde</option>
                                <option value='noite'>Noite</option>                          
                            </select>
                        </div>
                        <div class="col-sm-12 text-right mt-3">
                            <button type="submit" class="btn btn-search rounded-0">Buscar</button>
                        </div>
                        
                    </form> <!-- end form -->
                </div> <!-- end row -->
            </div>
        </div>

		<?php
			
			$paged = 1;
			if ( get_query_var('paged') ) $paged = get_query_var('paged');
			if ( get_query_var('page') ) $paged = get_query_var('page');
			
			$args = array(
				'post_type' => 'post',
				'paged' => $paged,
				'posts_per_page' => 20,			
				'tax_query' => array(
					'relation' => 'AND',
				),
							
			);

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

			if( isset($_GET['publico']) && $_GET['publico'] != ''){
				$publico = $_GET['publico'];
				
				$args['tax_query'][] = array (
					'taxonomy' => 'publico_categories',
					'field'    => 'term_id',
					'terms'    => $publico,
				);

				//echo "<pre>";
				//print_r($args);
				//echo "</pre>";
			}

			if( isset($_GET['faixaEtaria']) && $_GET['faixaEtaria'] != ''){
				$faixaEtaria = $_GET['faixaEtaria'];
				
				$args['tax_query'][] = array (
					'taxonomy' => 'faixa_categories',
					'field'    => 'term_id',
					'terms'    => $faixaEtaria,
				);
			}

			if( isset($_GET['unidades']) && $_GET['unidades'] != ''){
				$unidades = $_GET['unidades'];
				
				foreach($unidades as $unidade){
					$unidadesBusca = array(
						'key'	 	=> 'localizacao',
						'value'	  	=> $unidade
					);
					$unidadesBusca2 = array(
						'key' => 'ceus_participantes_$_localizacao_serie',
						'value'	  	=> $unidade
					);
				}

				$args['meta_query'] = array(
					'relation'	=> 'OR',
					array(
						'key'	 	=> 'localizacao',
						'value'	  	=> 31675
					),
					array(
						'key'	 	=> 'localizacao',
						'value'	  	=> 31675
					),
					$unidadesBusca,
					$unidadesBusca2					
				);
			}

			if( isset($_GET['periodos']) && $_GET['periodos'] != ''){
				$periodos = $_GET['periodos'];

				$args['meta_query'] = array(
					'relation'	=> 'OR',
				);

				if(in_array('manha', $periodos)){
					$args['meta_query'][] = array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'	 	=> 'horario_hora',
								'value' => '00:00:00',
								'compare' => '>='
							),
							array(
								'key'	 	=> 'horario_hora_periodo_0_periodo_hora_inicio',
								'value' => '00:00:00',
								'compare' => '>='
							),
						),
	
						array(
							'relation' => 'OR',
							array(
								'key'	 	=> 'horario_hora',
								'value' => '11:59:59',
								'compare' => '<='
							),
							array(
								'key'	 	=> 'horario_hora_periodo_0_periodo_hora_inicio',
								'value' => '11:59:59',
								'compare' => '<='
							),	
						),
					);
				}

				if(in_array('tarde', $periodos)){
					$args['meta_query'][] = array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'	 	=> 'horario_hora',
								'value' => '12:00:00',
								'compare' => '>='
							),
							array(
								'key'	 	=> 'horario_hora_periodo_0_periodo_hora_inicio',
								'value' => '12:00:00',
								'compare' => '>='
							),
						),
	
						array(
							'relation' => 'OR',
							array(
								'key'	 	=> 'horario_hora',
								'value' => '18:59:59',
								'compare' => '<='
							),
							array(
								'key'	 	=> 'horario_hora_periodo_0_periodo_hora_inicio',
								'value' => '18:59:59',
								'compare' => '<='
							),	
						),
					);
				}

				if(in_array('noite', $periodos)){
					$args['meta_query'][] = array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'	 	=> 'horario_hora',
								'value' => '19:00:00',
								'compare' => '>='
							),
							array(
								'key'	 	=> 'horario_hora_periodo_0_periodo_hora_inicio',
								'value' => '19:00:00',
								'compare' => '>='
							),
						),
	
						array(
							'relation' => 'OR',
							array(
								'key'	 	=> 'horario_hora',
								'value' => '23:59:59',
								'compare' => '<='
							),
							array(
								'key'	 	=> 'horario_hora_periodo_0_periodo_hora_inicio',
								'value' => '23:59:59',
								'compare' => '<='
							),	
						),
					);
				}

				
								
								
			}

			if( isset($_GET['tipoData']) && $_GET['tipoData'] != ''){
				$tipoData = $_GET['tipoData'];

				// Dia da semana
				if($tipoData == 'dia_semana'){

					if( isset($_GET['data']) && $_GET['data'] != ''){
						$diasSemana = $_GET['data'];

						$diasBusca = array();

						foreach($diasSemana as $dia){
							$diasBusca = array(
								'key'	 	=> 'data_semana',
								'value'	  	=> $dia,
								'compare' 	=> 'LIKE',
							);
						}

						$args['meta_query'] = array(
							'relation'	=> 'OR',
							$diasBusca						
						);	
					}
				}

				// Intervalo de data
				if($tipoData == 'intervalo'){

					if( isset($_GET['start']) && $_GET['start'] != ''){
						$dtInicial = $_GET['start'];
						$dtFinal = $_GET['end'];

						$dtInicial = explode("/", $dtInicial);
                        $dtFinal = explode("/", $dtFinal);

						$args['meta_query'] = array(
							'relation'	=> 'AND'			
						);	

						$args['meta_query'][] = array (
							'key' => 'data_data',
							'value'     => $dtInicial[2] . $dtInicial[1] . $dtInicial[0],
							'compare'   => '>=',
							'type'      => 'DATE',
						);
						
						$args['meta_query'][] = array (
							'key' => 'data_data',
							'value'     => $dtFinal[2] . $dtFinal[1] . $dtFinal[0],
							'compare'   => '<=',
							'type'      => 'DATE',
						);						
					}
				}


				// Mes
				if($tipoData == 'mes'){

					if( isset($_GET['data']) && $_GET['data'] != ''){
						$meses = $_GET['data'];

						$args['meta_query'] = array(
							'relation'	=> 'OR'			
						);

						foreach($meses as $mes){
							$args['meta_query'][] = array (
								'relation' => 'AND',
								array(
									'key' => 'data_data',
									'value'     => date("Y") . $mes . '01',
									'compare'   => '>=',
									'type'      => 'DATE',
								),
								array(
									'key' => 'data_data',
									'value'     => date("Y") . $mes . '31',
									'compare'   => '<=',
									'type'      => 'DATE',
								),
							);
						}
						

						//print_r($meses);
					}
				}
				
			}

			$query = new WP_Query( $args );

			?>
			<div class="container">
				<div class="row">
					<div class="col-sm-12 mt-4 atividades-found">
						<?php 
							$count = $query->found_posts;
							if($count == 1){						 					
								echo '<p class="mb-0"><span>' . $count . '</span> ATIVIDADE ENCONTRADA</p>';
							} else {
								echo '<p class="mb-0"><span>' . $count . '</span> ATIVIDADES ENCONTRADAS</p>';
							}
						 ?>
					</div>
				</div>
			</div>
			
			<?php

			// The Loop
			if ( $query->have_posts() ) {
				echo '<div class="tema-eventos my-4">';
            	echo '<div class="container">';
                echo '<div class="row">';
					while ( $query->have_posts() ) {
						$query->the_post();
					?>
						<div class="col-sm-3">
							<div class="card-eventos mb-4">
								<div class="card-eventos-img">
									<?php 
										$imgSelect = get_field('capa_do_evento', $eventoInterno->ID);
										$tipo = get_field('tipo_de_evento_selecione_o_evento', $eventoInterno->ID);
										$online = get_field('tipo_de_evento_online', $eventoInterno->ID);

										$featured_img_url = wp_get_attachment_image_src($imgSelect, 'recorte-eventos');
										if($featured_img_url){
											$imgEvento = $featured_img_url[0];
											//$thumbnail_id = get_post_thumbnail_id( $eventoInterno->ID );
											$alt = get_post_meta($imgSelect, '_wp_attachment_image_alt', true);  
										} else {
											$imgEvento = 'https://via.placeholder.com/820x380';
											$alt = get_the_title($eventoInterno->ID);
										}
									?>
									<a href="<?php get_the_permalink($eventoInterno->ID);?>"><img src="<?php echo $imgEvento; ?>" class="img-fluid d-block" alt="<?php echo $alt; ?>"></a>
									<?php if($tipo && $tipo != '') : 
										echo '<span class="flag-pdf-full">';
											echo get_the_title($tipo);
										echo '</span>';
									endif; ?>
									<?php if($online && $online != '') : 
										if($tipo && $tipo != ''){
											$customClass = 'mt-tags';
										}
										echo '<span class="flag-pdf-full ' . $customClass . '">';
											echo "Online";
										echo '</span>';
									endif; ?>
								</div>
								<div class="card-eventos-content p-2">
									<div class="evento-categ border-bottom pb-1">
										<?php
											$atividades = get_the_terms( get_the_id(), 'atividades_categories' );
											
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
															
											$campos = get_field('data', $eventoID);
											$tipoEvento = get_field('tipo_de_evento_tipo', $eventoID);
											
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

											if($tipoEvento == 'serie'){
												$participantes = get_field('ceus_participantes',  $eventoID);
												$countPart = count($participantes);
												$countPart = $countPart - 1;
												
												$dtInicial = $participantes[0]['data_serie'];
												$dtFinal = $participantes[$countPart]['data_serie'];

												if($dtInicial['tipo_de_data'] == 'data' && $dtFinal['tipo_de_data'] == 'data'){
													
													$dataInicial = explode("-", $dtInicial['data']);
													$dataFinal = explode("-", $dtFinal['data']);
													$mes = date('M', mktime(0, 0, 0, $dataFinal[1], 10));
													$mes = translateMonth($mes);

													$data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];

													$dataFinal = $data;

												} else {
													$dataFinal = 'Múltiplas Datas';
												}											
											}
										?>
										<p class="mb-0">
											<i class="fa fa-calendar" aria-hidden="true"><span>icone calendario</span></i> <?php echo $dataFinal; ?>
											<br>
											<?php
												// Exibe os horários
												$horario = get_field('horario', $eventoID);

												

												if($horario['selecione_o_horario'] == 'horario'){
													$hora = $horario['hora'];
												} elseif($horario['selecione_o_horario'] == 'periodo'){
													
													$hora = '';
													$k = 0;
													
													foreach($horario['hora_periodo'] as $periodo){
														//print_r($periodo['periodo_hora_final']);
														
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
                                                <i class="fa fa-clock-o" aria-hidden="true"><span>icone horario</span></i> <?php echo convertHour($hora); ?>
                                            <?php endif; ?>
											<?php if($tipoEvento == 'serie'): ?>
												<i class="fa fa-clock-o" aria-hidden="true"><span>icone horario</span></i> Múltiplos Horários
											<?php endif; ?>
										</p>
										<?php
											$local = get_field('localizacao', get_the_ID());                                                        
											if($local == '31675' || $local == '31244'):
										?>
											<p class="mb-0 mt-1 evento-unidade no-link"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></p>
										<?php elseif($tipoEvento == 'serie') : ?>
											<p class="mb-0 mt-1 evento-unidade no-link"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> Múltiplas Unidades</p>
										<?php else: ?>
											<p class="mb-0 mt-1 evento-unidade"><a href="<?php echo get_the_permalink($local); ?>"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></a></p>
										<?php endif; ?>
								</div>
							</div>
                    	</div>

					<?php
					}
				echo '</div>';
				echo '</div>';
				echo '</div>';
			} else {
			
			}
			/* Restore original Post Data */
			
			wp_reset_postdata();

			

			//print_r($query);
		?>

		<div class="container mt-4">
			<div class="row">
				<div class="col-sm-12">
					<div class="pagination-prog text-center">
						<?php wp_pagenavi( array( 'query' => $query ) ); ?>
					</div>
				</div>
			</div>
		</div>
		

		<br><br>
	</div>

<?php get_footer();