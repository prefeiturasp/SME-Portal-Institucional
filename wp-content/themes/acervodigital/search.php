<?php

/*

Template Name: Search Page

*/

?>

<?php

get_header(); ?>

<div class="wrap">

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">
			<section class="bg-busca pt-5 pb-5" style="background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
	background: linear-gradient(0deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('<?php the_field('banner_busca','option');?>');">

			<div class="container">

				<div class="row">

					<div class="col-sm-12 mt-5 mb-5 text-center">

						<h1 class="mb-3"><?php the_field('titulo_busca','options'); ?></h1>

						<p><?php the_field('texto_busca','options'); ?></p>

						<div class="row">
							<div class="col-sm-1"></div>
							<div class="col-sm-10">
								<?php get_search_form(); ?>
							</div>
							<div class="col-sm-1"></div>
						</div>

					</div>

				</div>

			</div>

		</section>		

			<div class="container mt-5 mb-5">

				<div class="row">

						<div class="col-sm-12">

							<h3 class="search-title">

							<span class="azul-claro-acervo"><strong><?php echo $wp_query->found_posts; ?></strong></span> <?php _e( 'Resultados para ', 'locale' ); ?>: <strong> <?php the_search_query(); ?> </strong>

							</h3>

						</div>

						<div class="col-sm-8 mt-3 mb-5">

							<?php

							if(have_posts()):

							while(have_posts()): the_post();

							$file = get_field('arquivo_acervo_digital');

							$stringSeparada = explode(".", $file['filename']);

							$type = get_post_type();

							?>

							<div class="row">

								<div class="col-sm-12">

									<div class="row acervo-display">

										<div class="col-sm-4 view-tag flag">

											<img src="

														<?php

													  if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'pdf'){

														 echo $file['icon']; 

													  }else if(get_field('substituir_capa_acervo_digital') == '' && $stringSeparada[1] == 'xlsx'){

														 echo $file['icon'];

													  }else if(get_field('substituir_capa_acervo_digital') != ''){

														 echo get_field('substituir_capa_acervo_digital'); 

													  }else{

														 echo $file['url'];

													  }

													  ?>		

													  " alt="">			

											<span class="flag-pdf-full">

												<?php
												if($stringSeparada[1] != ''){
													echo $stringSeparada[1];
												}else{
													echo 'Varios arquivos';
												}
												?>

											</span>

										</div>

										<div class="col-sm-8 mt-3 mb-3">

											<h3 class="azul-claro-acervo"><strong><?php the_title(); ?></strong></h3>

											<div class="cat-flag mb-4"><?php echo  strip_tags (get_the_term_list(get_the_ID(), 'categoria_acervo', '', ' / ', '')); ?></div>

											<p><?php the_field('descricao_acervo_digital'); ?></p>

											<p><strong>Ano de publicação:</strong>

												<?php the_field('ano_da_publicacao_acervo_digital'); ?>

											&nbsp;&nbsp;&nbsp;<strong>Palavras chaves: </strong>				

												<?php echo  strip_tags (get_the_term_list(get_the_ID(), 'palavra', '', ' / ', '')); ?>

											</p>

											<div class="links-flag">

												<a href="<?php the_permalink(); ?>">Visualizar</a>

												<a href="<?php the_permalink(); ?>">Ver detalhes</a>

												<a href="<?php
														 if($file['url'] != ''){
															echo $file['url']; 
														 }else{
															 the_permalink();
														 }
														 ?>">Fazer download</a>

											</div>

										</div>

									</div>

								</div>

							</div>

							<?php

							endwhile;

							else:

							echo 'Sem conteudo';

							endif;

							?>

							<div class="col-sm-12 mt-5 mb-5 text-center">

								<?php

								if(function_exists('wp_pagenavi'))

								wp_pagenavi(); ?>

							</div>

						</div>

						<div class="col-sm-4 mt-3 mb-5">
							<p><strong>Filtros</strong></p>
							<form method="get" class="text-left" action="<?php echo esc_url( home_url( '/acervo' ) ) ?>">
								<fieldset>
									<input type="hidden" name="s" class="form-control" value="<?php echo $_GET["s"] ?>"/>
									<div class="mt-3 mb-3">
										<label for="type"><strong>Categoria:</strong></label>
										<select id="type" name="categoria_acervo" class="selectpicker form-control" data-live-search="true" onchange="form.submit()">
										   <?php $project_types = get_categories('taxonomy=categoria_acervo'); ?>
										   <option value="<?php echo $_GET["categoria_acervo"] ?>">
											   <?php
											   $cat = $_GET["categoria_acervo"];
											   $catCorrigida = str_replace('-', ' ', $cat);
											    if($_GET["categoria_acervo"] != ''){
													echo $catCorrigida;
												}else{ echo 'Selecione a categoria';}  ?>
										</option>
										   <?php foreach ($project_types as $project_type) { ?>
												<?php
													if($project_type->slug != $_GET["categoria_acervo"]){
														echo '<option value="'.$project_type->slug.'">'.$project_type->name.'</option>';
													}
												?>
										   <?php } ?>
										</select>
									</div>
									<?php /*?><div class="mt-3 mb-3">
										<label for="type"><strong>Ano de publicação</strong></label>
										<select id="ano_select_box" name="ano_da_publicacao_acervo_digital" class="selectpicker form-control" data-live-search="true" onchange="form.submit()">
											<option value="<?php echo $_GET["ano_da_publicacao_acervo_digital"] ?>">
											   <?php
											    if($_GET["ano_da_publicacao_acervo_digital"] != ''){
													echo $_GET["ano_da_publicacao_acervo_digital"];
												}else{ echo 'Selecione o ano';}  ?>
											</option>
											<?php
											$loop2 = new WP_Query( array(
												'post_type' => 'acervo',
												'posts_per_page' => -1
											  )
											);
											?>
											<?php while ( $loop2->have_posts() ) : $loop2->the_post(); ?>
											  <option value="<?php echo the_field('ano_da_publicacao_acervo_digital'); ?>">
												  <?php echo the_field('ano_da_publicacao_acervo_digital'); ?>
											  </option>
											<?php endwhile;
											wp_reset_query(); ?>
										</select>
									</div><?php */?>
									<div class="mt-3 mb-3">
										<label for="type"><strong>Ano de publicação</strong></label>
										<select id="ano_select_box" name="ano_da_publicacao_acervo_digital" class="selectpicker form-control" data-live-search="true" onchange="form.submit()">
											<option value="<?php echo $_GET["ano_da_publicacao_acervo_digital"] ?>">
											   <?php
											    if($_GET["ano_da_publicacao_acervo_digital"] != ''){
													echo $_GET["ano_da_publicacao_acervo_digital"];
												}else{ echo 'Selecione o ano';}  ?>
											</option>
											  <option value="2020">2020</option>
											  <option value="2019">2019</option>
											  <option value="2018">2018</option>
											  <option value="2017">2017</option>
											  <option value="2016">2016</option>
											  <option value="2015">2015</option>
											  <option value="2014">2014</option>
											  <option value="2013">2013</option>
											  <option value="2012">2012</option>
											  <option value="2011">2011</option>
											  <option value="2010">2010</option>
											  <option value="2009">2009</option>
											  <option value="2008">2008</option>
											  <option value="2007">2007</option>
											  <option value="2006">2006</option>
											  <option value="2005">2005</option>
											  <option value="2004">2004</option>
											  <option value="2003">2003</option>
											  <option value="2002">2002</option>
											  <option value="2001">2001</option>
											  <option value="2000">2000</option>
											wp_reset_query(); ?>
										</select>
									</div>
									
									
									
									
									
									
									<div class="mt-3 mb-3">
										<label for="type"><strong>Idioma:</strong></label>
										<select id="type" name="idioma" class="selectpicker form-control" data-live-search="true" onchange="form.submit()">
										   <?php $project_types = get_categories('taxonomy=idioma'); ?>
										   <option value="<?php echo $_GET["idioma"] ?>">
											   <?php
											   $cat = $_GET["idioma"];
											   $catCorrigida = str_replace('-', ' ', $cat);
											    if($_GET["idioma"] != ''){
													echo $catCorrigida;
												}else{ echo 'Selecione o idioma';}  ?>
										</option>
										   <?php foreach ($project_types as $project_type) { ?>
												<?php
													if($project_type->slug != $_GET["idioma"]){
														echo '<option value="'.$project_type->slug.'">'.$project_type->name.'</option>';
													}
												?>
										   <?php } ?>
										</select>
									</div>
									<div class="mt-3 mb-3">
										<label for="type"><strong>Autor:</strong></label>
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
									<div class="mt-3 mb-3">
										<label for="type"><strong>Setor:</strong></label>
										<select id="type" name="setor" class="selectpicker form-control" data-live-search="true" onchange="form.submit()">
										   <?php $project_types = get_categories('taxonomy=setor'); ?>
										   <option value="<?php echo $_GET["setor"] ?>">
											   <?php
											   $cat = $_GET["setor"];
											   $catCorrigida = str_replace('-', ' ', $cat);
											    if($_GET["setor"] != ''){
													echo $catCorrigida;
												}else{ echo 'Selecione o setor';}  ?>
										</option>
										   <?php foreach ($project_types as $project_type) { ?>
												<?php
													if($project_type->slug != $_GET["setor"]){
														echo '<option value="'.$project_type->slug.'">'.$project_type->name.'</option>';
													}
												?>
										   <?php } ?>
										</select>
									</div>
								</fieldset>
							</form>
							

						</div>

				</div>

			</div>

		</main><!-- #main -->

	</div><!-- #primary -->

</div><!-- .wrap -->

<?php get_footer();