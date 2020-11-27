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
                                <?php foreach ($unidades as $unidade): ?>
                                    <option value="<?php echo $unidade->term_id; ?>"><?php echo $unidade->name; ?></option>
                                <?php endforeach; ?>     
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
                                <?php foreach ($periodos as $periodo): ?>
                                    <option value="<?php echo $periodo->term_id; ?>"><?php echo $periodo->name; ?></option>
                                <?php endforeach; ?>                        
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
				
				$args['tax_query'][] = array (
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $unidades,
				);
			}

			if( isset($_GET['periodos']) && $_GET['periodos'] != ''){
				$periodos = $_GET['periodos'];
				
				$args['tax_query'][] = array (
					'taxonomy' => 'periodo_categories',
					'field'    => 'term_id',
					'terms'    => $periodos,
				);
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
							<div class="card-eventos">
								<div class="card-eventos-img">
									<?php 
										$featured_img_url = get_the_post_thumbnail_url($eventoInterno->ID, 'thumb-eventos');
										if($featured_img_url){
											$imgEvento = $featured_img_url;
											$thumbnail_id = get_post_thumbnail_id( $eventoInterno->ID );
                                            $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
										} else {
											$imgEvento = 'https://via.placeholder.com/575x297';
                                            $alt = get_the_title($eventoInterno->ID);
										}
									?>
									<a href="#"><img src="<?php echo $imgEvento; ?>" class="img-fluid d-block" alt="<?php echo $alt; ?>"></a>
								</div>
								<div class="card-eventos-content p-2">
									<div class="evento-categ border-bottom pb-1">
										<?php
											$atividades = get_the_terms( get_the_ID(), 'atividades_categories' );
											$listaAtividades = array();
											foreach($atividades as $atividade){
												if($atividade->parent != 0){
													$listaAtividades[] = $atividade->name;
												}
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

											if($campos['tipo_de_data'] == 'data'){ // Se for do tipo data
												$dataInicial = $campos['data'];
												$dataFinal = $campos['data_final'];

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
											} elseif($campos['tipo_de_data'] == 'semana'){ // se for do tipo semana
												$semana = $campos['semana'];
												
												$total = count($semana); 
												$i = 0;
												$dias = '';

												foreach($semana as $dia){
													$i++;
													if($total - $i == 1){
														$dias .= $dia . " ";
													} elseif($total != $i){
														$dias .= $dia . ", ";
													} else {
														$dias .= "e " . $dia;
													}
												}

												$data = $dias; 
											}

										}
									?>
									<p class="mb-0">
										<i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $data; ?>
										<br>
										<?php
											// Exibe os horários
											$horario = get_field('horario', get_the_ID());

											if($horario['horario']){
												$hora = $horario['horario'];
											} else {
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