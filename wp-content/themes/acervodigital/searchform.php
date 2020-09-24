<div id="simpleform">
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/acervo' ) ) ?>">
		<?php /*?><span class="screen-reader-text"><?php _x( 'Pesquisar por:', 'label' )?></span><?php */?>
	<div class="row" >
	<div class="col-sm-8"><input type="search" minlength="3" class="form-control search-field" placeholder="Busque por título de documento ou palavra-chave" value="<?php echo get_search_query() ?>" name="s" /></div>
	<div class="col-sm-2 text-left"><button type="submit" class="btn btn-primary search-submit">Buscar</button></div>
	<div class="col-sm-2 text-left bs-center">
		<a id="show" >Busca avançada</a>
	</div>
	</div>
</form>
</div>

<div id="advancedform" style="display: none">
<form method="get" class="text-left" action="<?php echo esc_url( home_url( '/acervo' ) ) ?>">
	<fieldset>
		<div class="row">
			<div class="col-sm-10 p-4 bg-white">
				<div class="row">
					<div class="col-sm-12 mt-2 mb-2">
						<input type="search" minlength="3" name="s" class="form-control" value="<?php echo $_GET["s"] ?>" placeholder="Busque por título de documento ou palavra-chave"/>
					</div>
					<div class="col-sm-6 mt-2 mb-2">
						<label for="type">Categoria:</label>
						<select id="type" name="categoria_acervo" class="selectpicker form-control" data-live-search="true">
						   <?php $project_types = get_categories('taxonomy=categoria_acervo'); ?>
						   <option value="">Selecione a categoria</option>
						   <?php foreach ($project_types as $project_type) { ?>
							  <option value="<?php echo $project_type->slug; ?>">
								 <?php echo $project_type->name; ?>
							  </option>
						   <?php } ?>
						</select>
					</div>
					<div class="col-sm-6 mt-2 mb-2">
						<label for="type">Palavra Chave:</label>
						<select id="type" name="palavra" class="selectpicker form-control" data-live-search="true">
						   <?php $project_types = get_categories('taxonomy=palavra'); ?>
						   <option value="">Escreva a palavra chave</option>
						   <?php foreach ($project_types as $project_type) { ?>
							  <option value="<?php echo $project_type->slug; ?>">
								 <?php echo $project_type->name; ?>
							  </option>
						   <?php } ?>
						</select>
					</div>
					<div class="col-sm-3 mt-2 mb-2">
						<?php /*?><label for="type">Mês de publicação</label>
						<select id="type" name="s" class="selectpicker form-control" data-live-search="true">
							<option value="">Selecione o mês</option>
							  <option value="01">Janeiro</option>
							  <option value="02">Fevereiro</option>
							  <option value="03">Março</option>
						</select><?php */?>
						<label for="type">Idioma da publicação</label>
						<select id="type" name="idioma" class="selectpicker form-control" data-live-search="true">
						   <?php $project_types = get_categories('taxonomy=idioma'); ?>
						   <option value="">Selecione o idioma</option>
						   <?php foreach ($project_types as $project_type) { ?>
							  <option value="<?php echo $project_type->slug; ?>">
								 <?php echo $project_type->name; ?>
							  </option>
						   <?php } ?>
						</select>
					</div>
					<div class="col-sm-3 mt-2 mb-2">
						<label for="type">Ano de publicação</label>
						<select id="ano_select" name="ano_da_publicacao_acervo_digital" class="selectpicker form-control" data-live-search="true" >
							<?php
							$loop = new WP_Query( array(
								'post_type' => 'acervo',
								'posts_per_page' => -1
							  )
							);
							?>
							<option value="">Selecione o ano</option>
							<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
							  <option value="<?php echo the_field('ano_da_publicacao_acervo_digital'); ?>">
								  <?php echo the_field('ano_da_publicacao_acervo_digital'); ?>
							  </option>
							<?php endwhile;
							wp_reset_query(); ?>
						</select>
					</div>
					<div class="col-sm-3 mt-2 mb-2">
						<label for="type">Setor responsável</label>
						<select id="type" name="setor" class="selectpicker form-control" data-live-search="true">
						   <?php $project_types = get_categories('taxonomy=setor'); ?>
						   <option value="">Selecione o setor</option>
						   <?php foreach ($project_types as $project_type) { ?>
							  <option value="<?php echo $project_type->slug; ?>">
								 <?php echo $project_type->name; ?>
							  </option>
						   <?php } ?>
						</select>
					</div>
					<div class="col-sm-3 mt-2 mb-2">
						<label for="type">Autor:</label>
						<select id="type" name="autor" class="selectpicker form-control" data-live-search="true">
						   <?php $project_types = get_categories('taxonomy=autor'); ?>
						   <option value="">Escreva o nome do autor</option>
						   <?php foreach ($project_types as $project_type) { ?>
							  <option value="<?php echo $project_type->slug; ?>">
								 <?php echo $project_type->name; ?>
							  </option>
						   <?php } ?>
						</select>
					</div>
					<div class="col-sm-12 mt-2 mb-2 text-right">
						<button class="btn btn-primary search-submit" type="submit">Refinar busca</button>
					</div>
				</div>
			</div>
			<div class="col-sm-2 bs-center">
				<a id="hide">Busca simples</a>
			</div>
		</div>
</fieldset>
</form>
</div>
