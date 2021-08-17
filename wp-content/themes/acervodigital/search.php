<?php
/*
Template Name: Search Page
*/
?>

<?php get_header(); 

function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>

<div class="wrap">

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">
			<section class="bg-busca busca-const" style="background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
	background: linear-gradient(0deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('<?php the_field('banner_busca','option');?>');">

			<div class="container">

				<div class="row">
					<div class="col-sm-8 offset-sm-2 pt-4 mt-5 mb-5 text-center text-busca">
						<h1 class="mb-3"><?php the_field('titulo_busca','options'); ?></h1>
						<p><?php the_field('texto_busca','options'); ?></p>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-10 offset-sm-1">
						<?php get_search_form(); ?>
					</div>
				</div>

			</div>

		</section>		

			<div class="container mt-5 mb-5">

				<div class="row">
						<div class="col-12 d-none d-lg-block d-xl-block">
							<p class="title-filter">Refine por</p>
						</div>
						<div class="col-md-3 mb-5 d-none d-lg-block d-xl-block">								
							<div class="acord-busca my-3">									

								<form method="get" class="text-left" action="<?php echo esc_url( home_url() ) ?>">
									
									<input type="hidden" name="s" value="<?php echo $_GET['s']; ?>">

									<?php if($_GET['avanc'] && $_GET['avanc'] ){ ?>
										<input type="hidden" name="avanc" value="1">					
									<?php } ?>

									<?php if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] ){ ?>
										<input type="hidden" name="categoria_acervo" value="<?php echo $_GET['categoria_acervo']; ?>">					
									<?php } ?>

									<div class="panel-group" id="accordion">
										<div class="panel panel-default">
											<div class="panel-heading">
												<p class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseCateg">
													Categoria
													</a>
												</p>
											</div>
											<div id="collapseCateg" class="panel-collapse collapse in show">
												<div class="panel-body">
													<?php
														$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
														if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
															$newlink = removeParam($actual_link, 'categoria_acervo');

															$idcateg = $_GET['categoria_acervo'];
															echo "<p><a href='" . $newlink . "'><i class='fa fa-angle-left' aria-hidden='true'></i> " . get_term( $idcateg )->name . "</a></p>";
														} else {
															$categorias = array();
															$args = array(
																's' => $_GET['s'],
																'tax_query' => array(
																	'relation' => 'AND',										
																)
															);
															if($_GET['avanc'] && $_GET['avanc'] != ''){
																if($_GET['modalidade'] && $_GET['modalidade'] ){
																	$args['tax_query'][] = array(
																			'taxonomy' => 'modalidade',   // taxonomy name
																			'field' => 'term_id',           // term_id, slug or name
																			'terms' => $_GET['modalidade'],                  // term id, term slug or term name
																	);									
																}
																
																if($_GET['componente'] && $_GET['componente'] ){
																	$args['tax_query'][] = 	array(
																			'taxonomy' => 'componente',   // taxonomy name
																			'field' => 'term_id',           // term_id, slug or name
																			'terms' => $_GET['componente'],                  // term id, term slug or term name
																		
																	);
																}
								
																if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
																	$args['tax_query'][] = 	array(
																			'taxonomy' => 'idioma',   // taxonomy name
																			'field' => 'term_id',           // term_id, slug or name
																			'terms' => $_GET['idioma'],                  // term id, term slug or term name
																		
																	);
																}
																
																if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
																	$args['tax_query'][] = 	array(
																			'taxonomy' => 'setor',   // taxonomy name
																			'field' => 'term_id',           // term_id, slug or name
																			'terms' => $_GET['setor'],                  // term id, term slug or term name
																		
																	);
																}
								
																if($_GET['autor'] && $_GET['autor'] != ''){
																	$args['tax_query'][] = 	array(
																			'taxonomy' => 'autor',   // taxonomy name
																			'field' => 'term_id',           // term_id, slug or name
																			'terms' => $_GET['autor'],                  // term id, term slug or term name
																		
																	);
																}
								
																if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
																	$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
																	$args['meta_value'] = $_GET['ano']; 
																}
								
																if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
																	$args['tax_query'][] = 	array(
																			'taxonomy' => 'categoria_acervo',   // taxonomy name
																			'field' => 'term_id',           // term_id, slug or name
																			'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
																		
																	);
																}

																if($_GET['palavra'] && $_GET['palavra'] != ''){
																	$args['tax_query'][] = 	array(
																			'taxonomy' => 'palavra',   // taxonomy name
																			'field' => 'term_id',           // term_id, slug or name
																			'terms' => $_GET['palavra'],                  // term id, term slug or term name
																		
																	);
																}
															}
															$the_query = new WP_Query( $args ); 

															if($the_query->have_posts()):

																while($the_query->have_posts()): $the_query->the_post();
																	//echo strip_tags (get_the_term_list(get_the_ID(), 'categoria_acervo', '', ' / ', ''));
																	$term_list = wp_get_post_terms( get_the_ID(), 'categoria_acervo', array( 'fields' => 'ids' ) );
																	foreach($term_list as $categoria){
																		$categorias[] = $categoria;
																	}
																	
																endwhile;
															endif;
															
															$categorias = array_unique($categorias);								
															foreach($categorias as $categoria){
																echo "<p><a href='" . $actual_link . "&categoria_acervo=" . $categoria . "'>" . get_term( $categoria )->name . "</a></p>";
															}
														}
														
													?>
												</div>
											</div>
										</div>

										<?php // Modalidade
											$modalidades = array();
											$modalidadeBusca = array();
											if($_GET['modalidade'] && $_GET['modalidade'] != ''){
												$modalidadeBusca = $_GET['modalidade'];
											}
											$args = array(
												's' => $_GET['s'],
												'tax_query' => array(
													'relation' => 'AND',										
												)
											);
											if($_GET['avanc'] && $_GET['avanc'] != ''){
												if($_GET['modalidade'] && $_GET['modalidade'] ){
													$args['tax_query'][] = array(
															'taxonomy' => 'modalidade',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['modalidade'],                  // term id, term slug or term name
													);									
												}
												
												if($_GET['componente'] && $_GET['componente'] ){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'componente',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['componente'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'idioma',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['idioma'],                  // term id, term slug or term name
														
													);
												}
												
												if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'setor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['setor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['autor'] && $_GET['autor'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'autor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['autor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
													$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
													$args['meta_value'] = $_GET['ano']; 
												}
				
												if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'categoria_acervo',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
														
													);
												}

												if($_GET['palavra'] && $_GET['palavra'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'palavra',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['palavra'],                  // term id, term slug or term name
														
													);
												}
											}
											$the_query = new WP_Query( $args );
											if($the_query->have_posts()):

												while($the_query->have_posts()): $the_query->the_post();
													$term_list = wp_get_post_terms( get_the_ID(), 'modalidade', array( 'fields' => 'ids' ) );
													foreach($term_list as $modalidade){
														$modalidades[] = $modalidade;
													}
													
												endwhile;

												$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
												$modalidades = array_unique($modalidades);
												if($modalidades && $modalidades !=''):
												?>
													<div class="panel panel-default">
														<div class="panel-heading">
															<p class="panel-title">
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseModal">
																Modalidade de ensino
																</a>
															</p>
														</div>
														<div id="collapseModal" class="panel-collapse collapse in show">
															<div class="panel-body">
																<?php
																	foreach($modalidades as $modalidade): 
																		$check = '';
																		if( in_array($modalidade, $modalidadeBusca) ){
																			$check = 'checked';
																		}
																	?>
																		<div class="form-check">
																			<input class="form-check-input" name='modalidade[]' <?php echo $check; ?> type="checkbox" <?php echo $check; ?> value="<?php echo $modalidade; ?>" id="modalidade" onchange="this.form.submit()">
																			<label class="form-check-label" for="modalidade">
																				<?php echo get_term( $modalidade )->name; ?>
																			</label>
																		</div>
																	<?php
																	endforeach;
																?>
															</div>
														</div>
													</div>
												<?php endif; // modalidades	?>														
										<?php endif; ?>

										<?php // Componente
											$componentes = array();
											$componenteBusca = array();
											if($_GET['componente'] && $_GET['componente'] != ''){
												$componenteBusca = $_GET['componente'];
											}
											$args = array(
												's' => $_GET['s'],
												'tax_query' => array(
													'relation' => 'AND',										
												)
											);
											if($_GET['avanc'] && $_GET['avanc'] != ''){
												if($_GET['modalidade'] && $_GET['modalidade'] ){
													$args['tax_query'][] = array(
															'taxonomy' => 'modalidade',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['modalidade'],                  // term id, term slug or term name
													);									
												}
												
												if($_GET['componente'] && $_GET['componente'] ){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'componente',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['componente'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'idioma',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['idioma'],                  // term id, term slug or term name
														
													);
												}
												
												if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'setor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['setor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['autor'] && $_GET['autor'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'autor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['autor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
													$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
													$args['meta_value'] = $_GET['ano']; 
												}
				
												if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'categoria_acervo',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
														
													);
												}

												if($_GET['palavra'] && $_GET['palavra'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'palavra',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['palavra'],                  // term id, term slug or term name
														
													);
												}
											}
											$the_query = new WP_Query( $args );
											if($the_query->have_posts()):

												while($the_query->have_posts()): $the_query->the_post();
													$term_list = wp_get_post_terms( get_the_ID(), 'componente', array( 'fields' => 'ids' ) );
													foreach($term_list as $componente){
														$componentes[] = $componente;
													}
													
												endwhile;

												$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
												$componentes = array_unique($componentes);
												if($componentes && $componentes !=''):
												?>
													<div class="panel panel-default">
														<div class="panel-heading">
															<p class="panel-title">
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseComp">
																Componente curricular
																</a>
															</p>
														</div>
														<div id="collapseComp" class="panel-collapse collapse in show">
															<div class="panel-body">
																<?php
																	foreach($componentes as $componente): 
																		$check = '';
																		if( in_array($componente, $componenteBusca) ){
																			$check = 'checked';
																		}
																	?>
																		<div class="form-check">
																			<input class="form-check-input" name='componente[]' type="checkbox" <?php echo $check; ?> value="<?php echo $componente; ?>" id="componente" onchange="this.form.submit()">
																			<label class="form-check-label" for="componente">
																				<?php echo get_term( $componente )->name; ?>
																			</label>
																		</div>
																	<?php
																	endforeach;
																?>
															</div>
														</div>
													</div>
												<?php endif; // componente 	?>														
										<?php endif; ?>
										
										<?php // Ano
											$anos = array();
											$anoBusca = array();
											if($_GET['ano'] && $_GET['ano'] != ''){
												$anoBusca = $_GET['ano'];
											}
											$args = array(
												's' => $_GET['s'],
												'tax_query' => array(
													'relation' => 'AND',										
												)
											);
											if($_GET['avanc'] && $_GET['avanc'] != ''){
												if($_GET['modalidade'] && $_GET['modalidade'] ){
													$args['tax_query'][] = array(
															'taxonomy' => 'modalidade',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['modalidade'],                  // term id, term slug or term name
													);									
												}
												
												if($_GET['componente'] && $_GET['componente'] ){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'componente',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['componente'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'idioma',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['idioma'],                  // term id, term slug or term name
														
													);
												}
												
												if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'setor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['setor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['autor'] && $_GET['autor'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'autor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['autor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
													$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
													$args['meta_value'] = $_GET['ano']; 
												}
				
												if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'categoria_acervo',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
														
													);
												}

												if($_GET['palavra'] && $_GET['palavra'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'palavra',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['palavra'],                  // term id, term slug or term name
														
													);
												}
											}
											$the_query = new WP_Query( $args );
											if($the_query->have_posts()):
										
												while($the_query->have_posts()): $the_query->the_post();
													$ano = get_field('ano_da_publicacao_acervo_digital', get_the_ID());
													if($ano && $ano != ''){
														$anos[] = $ano;		
													}																				
												endwhile;

												$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
												$anos = array_unique($anos);
												if($anos && $anos !=''):
												?>
													<div class="panel panel-default">
														<div class="panel-heading">
															<p class="panel-title">
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseAno">
																Ano
																</a>
															</p>
														</div>
														<div id="collapseAno" class="panel-collapse collapse in show">
															<div class="panel-body">
																<?php
																	foreach($anos as $ano): 
																		$check = '';
																		if( in_array($ano, $anoBusca) ){
																			$check = 'checked';
																		}
																	?>
																		<div class="form-check">
																			<input class="form-check-input" name='ano[]' <?php echo $check; ?> type="checkbox" value="<?php echo $ano; ?>" id="ano" onchange="this.form.submit()">
																			<label class="form-check-label" for="ano">
																				<?php echo $ano; ?>
																			</label>
																		</div>
																	<?php
																	endforeach;
																?>
															</div>
														</div>
													</div>
												<?php endif; // anos 	?>														
										<?php endif; ?>												

										<div class="panel panel-default">
											<div class="panel-heading">
												<p class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseAutor">
													Autor
													</a>
												</p>
											</div>
											<div id="collapseAutor" class="panel-collapse collapse in">
												<div class="panel-body">
													<label for="type">Busque pelo nome:</label>
													<select id="type" name="autor" class="selectpicker form-control" data-live-search="true" onchange="form.submit()">
														<?php $project_types = get_categories('taxonomy=autor'); ?>
														<option value="<?php echo $_GET["autor"] ?>">
															<?php
															$cat = $_GET["autor"];
															$catCorrigida = str_replace('-', ' ', $cat);
															if($_GET["autor"] != ''){
																echo $catCorrigida;
															}else{ echo 'Selecione o autor';}  ?>
													</option>
														<?php foreach ($project_types as $project_type) { ?>
															<?php
																if($project_type->slug != $_GET["autor"]){
																	echo '<option value="'.$project_type->slug.'">'.$project_type->name.'</option>';
																}
															?>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>

										<?php // Idioma
											$idiomas = array();
											$idiomaBusca = array();
											if($_GET['idioma'] && $_GET['idioma'] != ''){
												$idiomaBusca = $_GET['idioma'];
											}
											
											$args = array(
												's' => $_GET['s'],
												'tax_query' => array(
													'relation' => 'AND',										
												)
											);
											if($_GET['avanc'] && $_GET['avanc'] != ''){
												if($_GET['modalidade'] && $_GET['modalidade'] ){
													$args['tax_query'][] = array(
															'taxonomy' => 'modalidade',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['modalidade'],                  // term id, term slug or term name
													);									
												}
												
												if($_GET['componente'] && $_GET['componente'] ){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'componente',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['componente'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'idioma',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['idioma'],                  // term id, term slug or term name
														
													);
												}
												
												if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'setor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['setor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['autor'] && $_GET['autor'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'autor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['autor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
													$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
													$args['meta_value'] = $_GET['ano']; 
												}
				
												if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'categoria_acervo',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
														
													);
												}
												if($_GET['palavra'] && $_GET['palavra'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'palavra',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['palavra'],                  // term id, term slug or term name
														
													);
												}
											}
											$the_query = new WP_Query( $args );
											if($the_query->have_posts()):

												while($the_query->have_posts()): $the_query->the_post();
													$term_list = wp_get_post_terms( get_the_ID(), 'idioma', array( 'fields' => 'ids' ) );
													foreach($term_list as $idioma){
														$idiomas[] = $idioma;
													}
													
												endwhile;

												$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
												$idiomas = array_unique($idiomas);	
												if($idiomas && $idiomas !=''):
												?>
													<div class="panel panel-default">
														<div class="panel-heading">
															<p class="panel-title">
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseIdioma">
																Idioma
																</a>
															</p>
														</div>
														<div id="collapseIdioma" class="panel-collapse collapse in">
															<div class="panel-body">
																<?php
																	foreach($idiomas as $idioma): 
																		$check = '';
																		if( in_array($idioma, $idiomaBusca) ){
																			$check = 'checked';
																		}
																	?>
																		<div class="form-check">
																			<input class="form-check-input" name='idioma[]' <?php echo $check; ?> type="checkbox" value="<?php echo $idioma; ?>" id="idioma" onchange="this.form.submit()">
																			<label class="form-check-label" for="idioma">
																				<?php echo get_term( $idioma )->name; ?>
																			</label>
																		</div>
																	<?php
																	endforeach;
																?>
															</div>
														</div>
													</div>
												<?php endif; // Idiomas 	?>														
										<?php endif; ?>

										<?php // Setor
											$setores = array();
											$setorBusca = array();
											if($_GET['setor'] && $_GET['setor'] != ''){
												$setorBusca = $_GET['setor'];
											}
											$args = array(
												's' => $_GET['s'],
												'tax_query' => array(
													'relation' => 'AND',										
												)
											);
											if($_GET['avanc'] && $_GET['avanc'] != ''){
												if($_GET['modalidade'] && $_GET['modalidade'] ){
													$args['tax_query'][] = array(
															'taxonomy' => 'modalidade',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['modalidade'],                  // term id, term slug or term name
													);									
												}
												
												if($_GET['componente'] && $_GET['componente'] ){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'componente',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['componente'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'idioma',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['idioma'],                  // term id, term slug or term name
														
													);
												}
												
												if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'setor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['setor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['autor'] && $_GET['autor'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'autor',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['autor'],                  // term id, term slug or term name
														
													);
												}
				
												if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
													$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
													$args['meta_value'] = $_GET['ano']; 
												}
				
												if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'categoria_acervo',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
														
													);
												}

												if($_GET['palavra'] && $_GET['palavra'] != ''){
													$args['tax_query'][] = 	array(
															'taxonomy' => 'palavra',   // taxonomy name
															'field' => 'term_id',           // term_id, slug or name
															'terms' => $_GET['palavra'],                  // term id, term slug or term name
														
													);
												}
											}
											$the_query = new WP_Query( $args );
											if($the_query->have_posts()):

												while($the_query->have_posts()): $the_query->the_post();
													$term_list = wp_get_post_terms( get_the_ID(), 'setor', array( 'fields' => 'ids' ) );
													foreach($term_list as $setor){
														$setores[] = $setor;
													}
													
												endwhile;

												$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
												$setores = array_unique($setores);		
												if($setores && $setores !=''):
												?>
													<div class="panel panel-default">
														<div class="panel-heading">
															<p class="panel-title">
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSetor">
																Setor responsável
																</a>
															</p>
														</div>
														<div id="collapseSetor" class="panel-collapse collapse in">
															<div class="panel-body">
																<?php
																	foreach($setores as $setor):
																		$check = '';
																		if( in_array($setor, $setorBusca) ){
																			$check = 'checked';
																		}
																	?>
																		<div class="form-check">
																			<input class="form-check-input" name='setor[]' type="checkbox" <?php echo $check; ?> value="<?php echo $setor; ?>" id="setor" onchange="this.form.submit()">
																			<label class="form-check-label" for="setor">
																				<?php echo get_term( $setor )->name; ?>
																			</label>
																		</div>
																	<?php
																	endforeach;
																?>
															</div>
														</div>
													</div>
												<?php endif; // Setores	?>														
										<?php endif; ?>
										
									</div>									
								</form>
							</div>														

						</div>

						<div class="col-md-9 mt-3 mb-5">
							<?php
								$countBusca = 0;
								if($_GET['modalidade'] && $_GET['modalidade'] != ''){									
									$nMod = count($_GET['modalidade']);
									$countBusca = $countBusca + $nMod;
								}

								if($_GET['componente'] && $_GET['componente'] != ''){
									$nComp = count($_GET['componente']);
									$countBusca = $countBusca + $nComp;
								}

								if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != ''){
									$nAno = count($_GET['ano']);
									$countBusca = $countBusca + $nAno;
								}

								if($_GET['autor'] && $_GET['autor'] != ''){
									$nAut = count($_GET['autor']);
									$countBusca = $countBusca + $nAut;
								}

								if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
									$nSet = count($_GET['setor']);
									$countBusca = $countBusca + $nSet;
								}
								if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
									$nIdi = count($_GET['idioma']);
									$countBusca = $countBusca + $nIdi;
								}
								if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
									$countBusca++;
								}
								$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

								$args = array(
									's' => $_GET['s'],
									'posts_per_page' => 12,
									'paged' => $paged,
									'tax_query' => array(
										'relation' => 'AND',										
									)
								);

								if($_GET['modalidade'] && $_GET['modalidade'] ){
									$args['tax_query'][] = array(
											'taxonomy' => 'modalidade',   // taxonomy name
											'field' => 'term_id',           // term_id, slug or name
											'terms' => $_GET['modalidade'],                  // term id, term slug or term name
									);									
								}
								
								if($_GET['componente'] && $_GET['componente'] ){
									$args['tax_query'][] = 	array(
											'taxonomy' => 'componente',   // taxonomy name
											'field' => 'term_id',           // term_id, slug or name
											'terms' => $_GET['componente'],                  // term id, term slug or term name
										
									);
								}

								if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
									$args['tax_query'][] = 	array(
											'taxonomy' => 'idioma',   // taxonomy name
											'field' => 'term_id',           // term_id, slug or name
											'terms' => $_GET['idioma'],                  // term id, term slug or term name
										
									);
								}
								
								if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
									$args['tax_query'][] = 	array(
											'taxonomy' => 'setor',   // taxonomy name
											'field' => 'term_id',           // term_id, slug or name
											'terms' => $_GET['setor'],                  // term id, term slug or term name
										
									);
								}

								if($_GET['autor'] && $_GET['autor'] != ''){
									$args['tax_query'][] = 	array(
											'taxonomy' => 'autor',   // taxonomy name
											'field' => 'term_id',           // term_id, slug or name
											'terms' => $_GET['autor'],                  // term id, term slug or term name
										
									);
								}

								if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
									$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
									$args['meta_value'] = $_GET['ano']; 
								}

								if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
									$args['tax_query'][] = 	array(
											'taxonomy' => 'categoria_acervo',   // taxonomy name
											'field' => 'term_id',           // term_id, slug or name
											'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
										
									);
								}

								if($_GET['palavra'] && $_GET['palavra'] != ''){
									$args['tax_query'][] = 	array(
											'taxonomy' => 'palavra',   // taxonomy name
											'field' => 'term_id',           // term_id, slug or name
											'terms' => $_GET['palavra'],                  // term id, term slug or term name
										
									);
								}
								$the_query = new WP_Query( $args );
							?>							
							<div class="row">

								<?php if($_GET['chave'] && $_GET['palavra'] != ''): ?>
									<div class="col-12">
										<p class="search-title"><span class="azul-claro-acervo"><strong>Buscando por:</strong></span> Palavra-chave - <?php echo get_term( $_GET['palavra'] )->name; ?></p>
									</div>
								<?php endif; ?>

								<?php if($_GET['categ'] && $_GET['categoria_acervo'] != ''): ?>
									<div class="col-12">
										<p class="search-title"><span class="azul-claro-acervo"><strong>Buscando por:</strong></span> Categoria - <?php echo get_term( $_GET['categoria_acervo'] )->name; ?></p>
									</div>
								<?php endif; ?>

								<?php if($_GET['modal'] && $_GET['modalidade'][0] != ''): ?>
									<div class="col-12">
										<p class="search-title"><span class="azul-claro-acervo"><strong>Buscando por:</strong></span> Modalidade de ensino - <?php echo get_term( $_GET['modalidade'][0] )->name; ?></p>
									</div>
								<?php endif; ?>

								<?php if($_GET['comp'] && $_GET['componente'][0] != ''): ?>
									<div class="col-12">
										<p class="search-title"><span class="azul-claro-acervo"><strong>Buscando por:</strong></span> Componente curricular - <?php echo get_term( $_GET['componente'][0] )->name; ?></p>
									</div>
								<?php endif; ?>

								<?php if($_GET['tano'] && $_GET['ano'][0] != ''): ?>
									<div class="col-12">
										<p class="search-title"><span class="azul-claro-acervo"><strong>Buscando por:</strong></span> Ano - <?php echo $_GET['ano'][0]; ?></p>
									</div>
								<?php endif; ?>

								<?php if($_GET['aut'] && $_GET['autor'] != ''): ?>
									<div class="col-12">
										<p class="search-title"><span class="azul-claro-acervo"><strong>Buscando por:</strong></span> Autor - <?php echo get_term_by( 'slug', $_GET['autor'], 'autor' )->name; ?></p>
									</div>
								<?php endif; ?>

								<?php if($_GET['set'] && $_GET['setor'][0] != ''): ?>
									<div class="col-12">
										<p class="search-title"><span class="azul-claro-acervo"><strong>Buscando por:</strong></span> Setor - <?php echo get_term( $_GET['setor'][0] )->name; ?></p>
									</div>
								<?php endif; ?>

								<?php if($_GET['idi'] && $_GET['idioma'][0] != ''): ?>
									<div class="col-12">
										<p class="search-title"><span class="azul-claro-acervo"><strong>Buscando por:</strong></span> Idioma - <?php echo get_term( $_GET['idioma'][0] )->name; ?></p>
									</div>
								<?php endif; ?>

								<div class="col-6">
									<h2 class="search-title">
										<span class="azul-claro-acervo"><strong><?php echo $the_query->found_posts; ?></span> 
											<?php _e( 'resultados', 'locale' ); ?></strong>
									</h2>
								</div>
								<div class="col-6 text-right">
									<button type="button" class="btn btn-outline-primary btn-avanc-f btn-avanc btn-avanc-m d-lg-none d-xl-none b-0" data-toggle="modal" data-target="#filtroBusca">
										<i class="fa fa-filter" aria-hidden="true"></i> Filtrar 
										<?php if($countBusca > 0): ?>
											<span class="badge badge-primary"><?php echo $countBusca; ?></span>
										<?php endif; ?>
									</button>
								</div>
							</div>
							
							
							<div class="row">
								<?php	
								
								if($the_query->have_posts()):

									while($the_query->have_posts()): $the_query->the_post();

									$file = get_field('arquivo_acervo_digital');

									$stringSeparada = explode(".", $file['filename']);

									$type = get_post_type();

									$partional = array();

									// Check value exists.
									if( have_rows('arquivos_particionados') ):

										// Loop through rows.
										while ( have_rows('arquivos_particionados') ) : the_row();

											// Case: Paragraph layout.
											if( get_row_layout() == 'adicionar_arquivos' ):
												$text = get_sub_field('arquivo');
												$partional[] = $text;
												// Do something...
												//echo "<pre>";
												//print_r($text);
												//echo "</pre>";
											// Case: Download layout.
											elseif( get_row_layout() == 'download' ): 
												$file = get_sub_field('file');
												// Do something...

											endif;

										// End loop.
										endwhile;

										

									// No value.
									else :
										// Do something...
									endif;
									//echo "<pre>";
									//print_r($partional);
									//echo "</pre>";
								?>

								

									<div class="col-6 col-sm-6 col-md-4 p-3 acervo-display">

										<div class="row m-0">

											<div class="col-sm-12 view-tag flag">

												<div class="img-mask shadow-sm">
													<img src="

														<?php

														if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'pdf'){

														echo $file['icon']; 

														}else if(get_field('substituir_capa_acervo_digital') == '' && ($stringSeparada[1] == 'xlsx' || $stringSeparada[1] == 'xls') ){

														echo 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-xls.jpg';

														}else if(get_field('substituir_capa_acervo_digital') == '' && ($stringSeparada[1] == 'docx' || $stringSeparada[1] == 'doc') ){

														echo 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-doc.jpg';

														}else if(get_field('substituir_capa_acervo_digital') == '' && ($stringSeparada[1] == 'pptx' || $stringSeparada[1] == 'ppt') ){

														echo 'https://hom-acervodigital.sme.prefeitura.sp.gov.br/wp-content/uploads/2021/08/acervo-doc.jpg';

														}else if(get_field('substituir_capa_acervo_digital') != ''){

														echo get_field('substituir_capa_acervo_digital'); 

														}else{

														echo $file['url'];

														}

														?>		

														" alt="capa do Acervo">

														<span class="flag-pdf-full">

															<?php
																if($partional && !$file){
																	$formats = array();

																	foreach($partional as $format){
																		$format = explode(".", $format);
																		$formats[] = $format[6];
																	}

																	// Remover formatos duplicados
																	$formats = array_unique($formats);

																	echo implode(", ", $formats);														
																} else {
																	echo $stringSeparada[1]; 
																}
															?>

														</span>
												</div>														

											</div>

											<div class="col-sm-12 mt-3 mb-3 p-0">

												<h3 class="azul-claro-acervo"><strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong></h3>

												<div class="links-flag">
													<div class="cat-flag mb-2"><?php echo  strip_tags (get_the_term_list(get_the_ID(), 'categoria_acervo', '', ' / ', '')); ?></div>
													

													<div class="btn-acervo d-flex justify-content-between">
														
														<a href="<?php the_permalink(); ?>" class='btn btn-outline-primary'>Ver detalhes</a>
																										
														<?php if($file && !$partial) : ?>
															<a href="<?php
																if($file['url'] != ''){
																	echo $file['url']; 
																}else{
																	the_permalink();
																}
																?>" class='p3-4'>Baixar</a>
														<?php endif; ?>

														<?php if($partional && !$file) : ?>
															<div class="dropdown show">
																<a class="btn dropdown-toggle" class='px-3' href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Baixar
																</a>

																<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
																	<?php $a = 1;
																		foreach($partional as $arquivo) : ?>
																		<a href="<?php echo $arquivo; ?>" class="dropdown-item" id="download_link" target="_blank" download>
																			Baixar Arquivo <?php echo $a++; ?>
																		</a>
																	<?php endforeach; ?>
																</div>
															</div>
															
														<?php endif; ?>
														
													</div>

													
													
													

												</div>

											</div>

										</div>

									</div>

								

								<?php

								endwhile;
								?>
							</div>

							<?php
							else: ?>

							<img src="<?php echo get_bloginfo('template_directory') ?>/images/search-empty.png" alt="Nenhum conteuúdo encontrado" class='empty-search responsive-img'>

							<?php

							endif;

							?>

							<div class="col-sm-12 mt-5 mb-5 text-center">

								<?php

								if(function_exists('wp_pagenavi'))

								wp_pagenavi(array( 'query' => $the_query )); ?>

							</div>

						</div>

						

				</div>

			</div>

		</main><!-- #main -->

	</div><!-- #primary -->

</div><!-- .wrap -->

<!-- Modal -->
<div class="modal right fade" id="filtroBusca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<p class="modal-title" id="myModalLabel2">Refine por:</p>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>				
			</div>

			<div class="modal-body">
				<div class="acord-busca my-3">
					<form method="get" class="text-left" action="<?php echo esc_url( home_url() ) ?>">
						
						<input type="hidden" name="s" value="<?php echo $_GET['s']; ?>">									
						

						<div class="panel-group" id="accordionMob">
							<div class="panel panel-default">
								<div class="panel-heading">
									<p class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMob" href="#collapseCategMob">
										Categoria
										</a>
									</p>
								</div>
								<div id="collapseCategMob" class="panel-collapse collapse in show">
									<div class="panel-body">
										<?php
											$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
											if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
												$newlink = removeParam($actual_link, 'categoria_acervo');

												$idcateg = $_GET['categoria_acervo'];
												echo "<p><a href='" . $newlink . "'><i class='fa fa-angle-left' aria-hidden='true'></i> " . get_term( $idcateg )->name . "</a></p>";
											} else {
												$categorias = array();
												$args = array(
													's' => $_GET['s'],
													'tax_query' => array(
														'relation' => 'AND',										
													)
												);
												if($_GET['avanc'] && $_GET['avanc'] != ''){
													if($_GET['modalidade'] && $_GET['modalidade'] ){
														$args['tax_query'][] = array(
																'taxonomy' => 'modalidade',   // taxonomy name
																'field' => 'term_id',           // term_id, slug or name
																'terms' => $_GET['modalidade'],                  // term id, term slug or term name
														);									
													}
													
													if($_GET['componente'] && $_GET['componente'] ){
														$args['tax_query'][] = 	array(
																'taxonomy' => 'componente',   // taxonomy name
																'field' => 'term_id',           // term_id, slug or name
																'terms' => $_GET['componente'],                  // term id, term slug or term name
															
														);
													}
					
													if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
														$args['tax_query'][] = 	array(
																'taxonomy' => 'idioma',   // taxonomy name
																'field' => 'term_id',           // term_id, slug or name
																'terms' => $_GET['idioma'],                  // term id, term slug or term name
															
														);
													}
													
													if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
														$args['tax_query'][] = 	array(
																'taxonomy' => 'setor',   // taxonomy name
																'field' => 'term_id',           // term_id, slug or name
																'terms' => $_GET['setor'],                  // term id, term slug or term name
															
														);
													}
					
													if($_GET['autor'] && $_GET['autor'] != ''){
														$args['tax_query'][] = 	array(
																'taxonomy' => 'autor',   // taxonomy name
																'field' => 'term_id',           // term_id, slug or name
																'terms' => $_GET['autor'],                  // term id, term slug or term name
															
														);
													}
					
													if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
														$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
														$args['meta_value'] = $_GET['ano']; 
													}
					
													if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
														$args['tax_query'][] = 	array(
																'taxonomy' => 'categoria_acervo',   // taxonomy name
																'field' => 'term_id',           // term_id, slug or name
																'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
															
														);
													}

													if($_GET['palavra'] && $_GET['palavra'] != ''){
														$args['tax_query'][] = 	array(
																'taxonomy' => 'palavra',   // taxonomy name
																'field' => 'term_id',           // term_id, slug or name
																'terms' => $_GET['palavra'],                  // term id, term slug or term name
															
														);
													}
												}
												$the_query = new WP_Query( $args ); 

												if($the_query->have_posts()):

													while($the_query->have_posts()): $the_query->the_post();
														//echo strip_tags (get_the_term_list(get_the_ID(), 'categoria_acervo', '', ' / ', ''));
														$term_list = wp_get_post_terms( get_the_ID(), 'categoria_acervo', array( 'fields' => 'ids' ) );
														foreach($term_list as $categoria){
															$categorias[] = $categoria;
														}
														
													endwhile;
												endif;
												
												$categorias = array_unique($categorias);								
												foreach($categorias as $categoria){
													echo "<p><a href='" . $actual_link . "&categoria_acervo=" . $categoria . "'>" . get_term( $categoria )->name . "</a></p>";
												}
											}
											
										?>
									</div>
								</div>
							</div>

							<?php // Modalidade
								$modalidades = array();
								$modalidadeBusca = array();
								if($_GET['modalidade'] && $_GET['modalidade'] != ''){
									$modalidadeBusca = $_GET['modalidade'];
								}
								$args = array(
									's' => $_GET['s'],
									'tax_query' => array(
										'relation' => 'AND',										
									)
								);
								if($_GET['avanc'] && $_GET['avanc'] != ''){
									if($_GET['modalidade'] && $_GET['modalidade'] ){
										$args['tax_query'][] = array(
												'taxonomy' => 'modalidade',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['modalidade'],                  // term id, term slug or term name
										);									
									}
									
									if($_GET['componente'] && $_GET['componente'] ){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'componente',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['componente'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'idioma',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['idioma'],                  // term id, term slug or term name
											
										);
									}
									
									if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'setor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['setor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['autor'] && $_GET['autor'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'autor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['autor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
										$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
										$args['meta_value'] = $_GET['ano']; 
									}
	
									if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'categoria_acervo',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
											
										);
									}

									if($_GET['palavra'] && $_GET['palavra'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'palavra',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['palavra'],                  // term id, term slug or term name
											
										);
									}
								}
								$the_query = new WP_Query( $args );
								if($the_query->have_posts()):

									while($the_query->have_posts()): $the_query->the_post();
										$term_list = wp_get_post_terms( get_the_ID(), 'modalidade', array( 'fields' => 'ids' ) );
										foreach($term_list as $modalidade){
											$modalidades[] = $modalidade;
										}
										
									endwhile;

									$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									$modalidades = array_unique($modalidades);
									if($modalidades && $modalidades !=''):
									?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<p class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMob" href="#collapseModalMob">
													Modalidade de ensino
													</a>
												</p>
											</div>
											<div id="collapseModalMob" class="panel-collapse collapse in show">
												<div class="panel-body">
													<?php
														foreach($modalidades as $modalidade): 
															$check = '';
															if( in_array($modalidade, $modalidadeBusca) ){
																$check = 'checked';
															}
														?>
															<div class="form-check">
																<input class="form-check-input" name='modalidade[]' <?php echo $check; ?> type="checkbox" <?php echo $check; ?> value="<?php echo $modalidade; ?>" id="modalidade">
																<label class="form-check-label" for="modalidade">
																	<?php echo get_term( $modalidade )->name; ?>
																</label>
															</div>
														<?php
														endforeach;
													?>
												</div>
											</div>
										</div>
									<?php endif; // modalidades	?>														
							<?php endif; ?>

							<?php // Componente
								$componentes = array();
								$componenteBusca = array();
								if($_GET['componente'] && $_GET['componente'] != ''){
									$componenteBusca = $_GET['componente'];
								}
								$args = array(
									's' => $_GET['s'],
									'tax_query' => array(
										'relation' => 'AND',										
									)
								);
								if($_GET['avanc'] && $_GET['avanc'] != ''){
									if($_GET['modalidade'] && $_GET['modalidade'] ){
										$args['tax_query'][] = array(
												'taxonomy' => 'modalidade',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['modalidade'],                  // term id, term slug or term name
										);									
									}
									
									if($_GET['componente'] && $_GET['componente'] ){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'componente',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['componente'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'idioma',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['idioma'],                  // term id, term slug or term name
											
										);
									}
									
									if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'setor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['setor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['autor'] && $_GET['autor'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'autor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['autor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
										$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
										$args['meta_value'] = $_GET['ano']; 
									}
	
									if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'categoria_acervo',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
											
										);
									}

									if($_GET['palavra'] && $_GET['palavra'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'palavra',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['palavra'],                  // term id, term slug or term name
											
										);
									}
								}
								$the_query = new WP_Query( $args );
								if($the_query->have_posts()):

									while($the_query->have_posts()): $the_query->the_post();
										$term_list = wp_get_post_terms( get_the_ID(), 'componente', array( 'fields' => 'ids' ) );
										foreach($term_list as $componente){
											$componentes[] = $componente;
										}
										
									endwhile;

									$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									$componentes = array_unique($componentes);
									if($componentes && $componentes !=''):
									?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<p class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMob" href="#collapseCompMob">
													Componente curricular
													</a>
												</p>
											</div>
											<div id="collapseCompMob" class="panel-collapse collapse in show">
												<div class="panel-body">
													<?php
														foreach($componentes as $componente): 
															$check = '';
															if( in_array($componente, $componenteBusca) ){
																$check = 'checked';
															}
														?>
															<div class="form-check">
																<input class="form-check-input" name='componente[]' type="checkbox" <?php echo $check; ?> value="<?php echo $componente; ?>" id="componente">
																<label class="form-check-label" for="componente">
																	<?php echo get_term( $componente )->name; ?>
																</label>
															</div>
														<?php
														endforeach;
													?>
												</div>
											</div>
										</div>
									<?php endif; // componente 	?>														
							<?php endif; ?>
							
							<?php // Ano
								$anos = array();
								$anoBusca = array();
								if($_GET['ano'] && $_GET['ano'] != ''){
									$anoBusca = $_GET['ano'];
								}
								$args = array(
									's' => $_GET['s'],
									'tax_query' => array(
										'relation' => 'AND',										
									)
								);
								if($_GET['avanc'] && $_GET['avanc'] != ''){
									if($_GET['modalidade'] && $_GET['modalidade'] ){
										$args['tax_query'][] = array(
												'taxonomy' => 'modalidade',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['modalidade'],                  // term id, term slug or term name
										);									
									}
									
									if($_GET['componente'] && $_GET['componente'] ){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'componente',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['componente'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'idioma',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['idioma'],                  // term id, term slug or term name
											
										);
									}
									
									if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'setor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['setor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['autor'] && $_GET['autor'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'autor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['autor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
										$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
										$args['meta_value'] = $_GET['ano']; 
									}
	
									if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'categoria_acervo',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
											
										);
									}

									if($_GET['palavra'] && $_GET['palavra'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'palavra',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['palavra'],                  // term id, term slug or term name
											
										);
									}
								}
								$the_query = new WP_Query( $args );
								if($the_query->have_posts()):
							
									while($the_query->have_posts()): $the_query->the_post();
										$ano = get_field('ano_da_publicacao_acervo_digital', get_the_ID());
										if($ano && $ano != ''){
											$anos[] = $ano;		
										}																				
									endwhile;

									$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									$anos = array_unique($anos);
									if($anos && $anos !=''):
									?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<p class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMob" href="#collapseAnoMob">
													Ano
													</a>
												</p>
											</div>
											<div id="collapseAnoMob" class="panel-collapse collapse in show">
												<div class="panel-body">
													<?php
														foreach($anos as $ano): 
															$check = '';
															if( in_array($ano, $anoBusca) ){
																$check = 'checked';
															}
														?>
															<div class="form-check">
																<input class="form-check-input" name='ano[]' <?php echo $check; ?> type="checkbox" value="<?php echo $ano; ?>" id="ano">
																<label class="form-check-label" for="ano">
																	<?php echo $ano; ?>
																</label>
															</div>
														<?php
														endforeach;
													?>
												</div>
											</div>
										</div>
									<?php endif; // anos 	?>														
							<?php endif; ?>												

							<div class="panel panel-default">
								<div class="panel-heading">
									<p class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMob" href="#collapseAutorMob">
										Autor
										</a>
									</p>
								</div>
								<div id="collapseAutorMob" class="panel-collapse collapse in">
									<div class="panel-body">
										<label for="type">Busque pelo nome:</label>
										<select id="type" name="autor" class="selectpicker form-control" data-live-search="true" onchange="form.submit()">
											<?php $project_types = get_categories('taxonomy=autor'); ?>
											<option value="<?php echo $_GET["autor"] ?>">
												<?php
												$cat = $_GET["autor"];
												$catCorrigida = str_replace('-', ' ', $cat);
												if($_GET["autor"] != ''){
													echo $catCorrigida;
												}else{ echo 'Selecione o autor';}  ?>
										</option>
											<?php foreach ($project_types as $project_type) { ?>
												<?php
													if($project_type->slug != $_GET["autor"]){
														echo '<option value="'.$project_type->slug.'">'.$project_type->name.'</option>';
													}
												?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<?php // Idioma
								$idiomas = array();
								$idiomaBusca = array();
								if($_GET['idioma'] && $_GET['idioma'] != ''){
									$idiomaBusca = $_GET['idioma'];
								}
								
								$args = array(
									's' => $_GET['s'],
									'tax_query' => array(
										'relation' => 'AND',										
									)
								);
								if($_GET['avanc'] && $_GET['avanc'] != ''){
									if($_GET['modalidade'] && $_GET['modalidade'] ){
										$args['tax_query'][] = array(
												'taxonomy' => 'modalidade',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['modalidade'],                  // term id, term slug or term name
										);									
									}
									
									if($_GET['componente'] && $_GET['componente'] ){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'componente',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['componente'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'idioma',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['idioma'],                  // term id, term slug or term name
											
										);
									}
									
									if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'setor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['setor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['autor'] && $_GET['autor'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'autor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['autor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
										$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
										$args['meta_value'] = $_GET['ano']; 
									}
	
									if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'categoria_acervo',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
											
										);
									}
									if($_GET['palavra'] && $_GET['palavra'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'palavra',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['palavra'],                  // term id, term slug or term name
											
										);
									}
								}
								$the_query = new WP_Query( $args );
								if($the_query->have_posts()):

									while($the_query->have_posts()): $the_query->the_post();
										$term_list = wp_get_post_terms( get_the_ID(), 'idioma', array( 'fields' => 'ids' ) );
										foreach($term_list as $idioma){
											$idiomas[] = $idioma;
										}
										
									endwhile;

									$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									$idiomas = array_unique($idiomas);	
									if($idiomas && $idiomas !=''):
									?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<p class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMob" href="#collapseIdiomaMob">
													Idioma
													</a>
												</p>
											</div>
											<div id="collapseIdiomaMob" class="panel-collapse collapse in">
												<div class="panel-body">
													<?php
														foreach($idiomas as $idioma): 
															$check = '';
															if( in_array($idioma, $idiomaBusca) ){
																$check = 'checked';
															}
														?>
															<div class="form-check">
																<input class="form-check-input" name='idioma[]' <?php echo $check; ?> type="checkbox" value="<?php echo $idioma; ?>" id="idioma">
																<label class="form-check-label" for="idioma">
																	<?php echo get_term( $idioma )->name; ?>
																</label>
															</div>
														<?php
														endforeach;
													?>
												</div>
											</div>
										</div>
									<?php endif; // Idiomas 	?>														
							<?php endif; ?>

							<?php // Setor
								$setores = array();
								$setorBusca = array();
								if($_GET['setor'] && $_GET['setor'] != ''){
									$setorBusca = $_GET['setor'];
								}
								$args = array(
									's' => $_GET['s'],
									'tax_query' => array(
										'relation' => 'AND',										
									)
								);
								if($_GET['avanc'] && $_GET['avanc'] != ''){
									if($_GET['modalidade'] && $_GET['modalidade'] ){
										$args['tax_query'][] = array(
												'taxonomy' => 'modalidade',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['modalidade'],                  // term id, term slug or term name
										);									
									}
									
									if($_GET['componente'] && $_GET['componente'] ){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'componente',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['componente'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['idioma'] && $_GET['idioma'] != '' && $_GET['idioma'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'idioma',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['idioma'],                  // term id, term slug or term name
											
										);
									}
									
									if($_GET['setor'] && $_GET['setor'] != '' && $_GET['setor'][0] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'setor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['setor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['autor'] && $_GET['autor'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'autor',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['autor'],                  // term id, term slug or term name
											
										);
									}
	
									if($_GET['ano'] && $_GET['ano'] != '' && $_GET['ano'][0] != '' ){
										$args['ano_da_publicacao_acervo_digital'] = '';           // term id, term slug or term name
										$args['meta_value'] = $_GET['ano']; 
									}
	
									if($_GET['categoria_acervo'] && $_GET['categoria_acervo'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'categoria_acervo',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['categoria_acervo'],                  // term id, term slug or term name
											
										);
									}

									if($_GET['palavra'] && $_GET['palavra'] != ''){
										$args['tax_query'][] = 	array(
												'taxonomy' => 'palavra',   // taxonomy name
												'field' => 'term_id',           // term_id, slug or name
												'terms' => $_GET['palavra'],                  // term id, term slug or term name
											
										);
									}
								}
								$the_query = new WP_Query( $args );
								if($the_query->have_posts()):

									while($the_query->have_posts()): $the_query->the_post();
										$term_list = wp_get_post_terms( get_the_ID(), 'setor', array( 'fields' => 'ids' ) );
										foreach($term_list as $setor){
											$setores[] = $setor;
										}
										
									endwhile;

									$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									$setores = array_unique($setores);		
									if($setores && $setores !=''):
									?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<p class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionMob" href="#collapseSetorMob">
													Setor responsável
													</a>
												</p>
											</div>
											<div id="collapseSetorMob" class="panel-collapse collapse in">
												<div class="panel-body">
													<?php
														foreach($setores as $setor):
															$check = '';
															if( in_array($setor, $setorBusca) ){
																$check = 'checked';
															}
														?>
															<div class="form-check">
																<input class="form-check-input" name='setor[]' type="checkbox" <?php echo $check; ?> value="<?php echo $setor; ?>" id="setor">
																<label class="form-check-label" for="setor">
																	<?php echo get_term( $setor )->name; ?>
																</label>
															</div>
														<?php
														endforeach;
													?>
												</div>
											</div>
										</div>
									<?php endif; // Setores	?>														
							<?php endif; ?>
						</div>

						<button type="submit" class="btn btn-primary btn-filtro">Aplicar filtros</button>

					</form>
				</div>	
			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->

<?php get_footer();