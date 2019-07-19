<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialNoticiasDestaqueSecundarias extends PaginaInicial
{

	public function __construct()
	{
		$noticias_secundarias_tags = array('section');
		$noticias_secundarias_css = array('col-lg-6 col-xs-12');
		$this->abreContainer($noticias_secundarias_tags, $noticias_secundarias_css);
		$this->montaQueryNoticiasHomeSecundarias();
		$this->montaHtmlLoopNoticiasSecundarias();
		$this->montaHtmlBotaoMaisNoticias();
		$this->fechaContainer($noticias_secundarias_tags);
	}

	public function montaQueryNoticiasHomeSecundarias()
	{
		$this->args_noticas_home_secundarias = array(
			'post_type' => 'post',

			'meta_query' => array(
				//'relation' => '', // Optional argument.
				array(
					'relation' => 'AND',
					array(
						'key'	 	=> 'deseja_que_este_post_apareca_na_home',
						'value'	  	=> 'sim',
						'compare' 	=> '=',
					),
					array(
						'key'	  	=> 'posicao_de_destaque_deste_post',
						'value'	  	=> array(2,3),
						'compare' 	=> 'IN',
					),
				)
			),
			'orderby' => 'meta_value_num',
			'meta_key'  => 'posicao_de_destaque_deste_post',
			'order' => 'ASC',
			'cat' => $this->getCamposPersonalizados('escolha_a_categoria_de_noticias_a_exibir')->term_id,
			'posts_per_page' => 2,
			'post__not_in' => array($this->id_noticias_home_principal),
		);
		$this->query_noticias_home_secundarias = new \WP_Query($this->args_noticas_home_secundarias);
	}



	public function montaHtmlLoopNoticiasSecundarias()
	{

		if ($this->query_noticias_home_secundarias->have_posts()) : while ($this->query_noticias_home_secundarias->have_posts()) : $this->query_noticias_home_secundarias->the_post();
			?>

			<article class="row mb-4 pb-4 border-bottom">
				<article class="col-lg-12">
					<?php if (has_post_thumbnail()) {
						the_post_thumbnail('large', array('class' => 'img-fluid rounded float-left mr-4'));
					}
					?>
					<h2 class="fonte-catorze font-weight-bold">
						<a class="text-dark" href="<?= get_the_permalink() ?>">
							<?= get_the_title() ?>
						</a>
					</h2>
					<p class="fonte-doze">
						<?= get_the_excerpt() ?>
					</p>
				</article>
			</article>
		<?php
		endwhile;
		endif;
		wp_reset_postdata();
		?>

		<?php

	}

	public function montaHtmlBotaoMaisNoticias(){
		?>

		<section class="row">
			<article class="col-lg-12 col-xs-12">
				<button type="button" class="btn btn-primary btn-sm btn-block bg-azul-escuro font-weight-bold">Mais
					notícias
				</button>
			</article>
		</section>

		<?php
	}

}