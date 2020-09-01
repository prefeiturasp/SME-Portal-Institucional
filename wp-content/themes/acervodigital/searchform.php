<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
		<span class="screen-reader-text"><?php _x( 'Pesquisar por:', 'label' )?></span>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-6">
				<input type="search" minlength="4" class="form-control search-field" placeholder="Busque por título de documento ou palavra-chave" value="<?php echo get_search_query() ?>" name="s" />
			</div>
			<div class="col-2 text-left">
				<button type="submit" class="btn btn-primary search-submit">Buscar</button>
			</div>
			<div class="col-sm-2"></div>
		</div>
</form>