<?php


namespace Classes\TemplateHierarchy\Search;


class SearchSingle
{
	private $s;

	public function __construct()
	{
		$this->searchFormClipping();
	}

	public function searchFormClipping()
	{
		?>

		<h4><i class="fa fa-search"></i> <?php echo 'Buscar' ?></h4>
		<form action="<?php echo home_url('/'); ?>" method="get" class="form-inline">
			<fieldset>
				<input type="hidden" name="tipo" value="clipping">

				<div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="row">
						<input style="width: 100%" type="text" name="s" id="search" value="<?php the_search_query(); ?>" class="form-control" placeholder="<?php _e('Resultados para: ', "wpbootstrap"); ?>"/>
					</div>
				</div>

				<div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<button type="submit" class="btn btn-success btn-block"><?php _e(BUSCAR, 'wpbootstrap'); ?></button>
				</div>

			</fieldset>
		</form>
		<br>
		<?php

	}


	public function montaQuerySearchSingle($args)
	{

		$args = array(
			'post_type' => 'post',
			'paged' => get_query_var('paged'),
			's' => $this->s,
		);

		$argumentos = new \WP_Query($args);
		?>
		<?php if ($argumentos->have_posts()) : ?>
		<div class="row ">
		<?php $this->searchFormClipping(); ?>
		<h4><i class="fa fa-check-square-o" aria-hidden="true"></i> <?= 'Resultado da Busca' ?> "<?= $this->s ?>" .</h4>
		<?php
		while ($argumentos->have_posts()) : $argumentos->the_post(); ?>

			<div class='container-pagina-clipping'>

				<?php if (has_post_thumbnail()) { ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large', array('class' => 'img-responsive aligncenter img-thumbnail')); ?></a>
				<?php } ?>
				<h2 class="subtitulo-pagina-clipping"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>



				<a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a>

			</div>
		<?php
		endwhile;
		?>

	<?php else: ?>

		<br/>
		<div class="row row-com-margin">
			<?php $this->searchFormClipping(); ?>
			<h4><i class="fa fa-exclamation-triangle"></i> <?= 'Nenhum Resultado Encontrado' ?> "<?= $this->s ?>"
				<br><?= 'Tente outra Pesquisa' ?></h4>
			<br/>
		</div>
	<?php endif; ?>
		<?php //paginacao_clipping() ?>
		</div>
		<br/>
		<?php

	}


}