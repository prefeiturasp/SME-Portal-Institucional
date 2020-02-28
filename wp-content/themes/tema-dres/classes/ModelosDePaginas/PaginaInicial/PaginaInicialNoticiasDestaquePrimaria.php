<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialNoticiasDestaquePrimaria extends PaginaInicial
{

	public function __construct()
	{
		$this->montaQueryNoticiasHomePrincipal();
		$this->montaHtmlLoopNoticiaPrincipal();

	}

	public function montaQueryNoticiasHomePrincipal(){
		$this->args_noticas_home_principal = array(
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
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
				)
			),
			'orderby' => 'date',
			'order' => 'DESC',
			'cat' => $this->getCamposPersonalizados('escolha_a_categoria_de_noticias_a_exibir')->term_id,
			'posts_per_page' => 1,
		);
		$this->query_noticias_home_principal = new \WP_Query($this->args_noticas_home_principal);

	}

	public function montaHtmlLoopNoticiaPrincipal()	{

			$posts = get_field('primeiro_destaque','option');

			if( $posts ): ?>
					<?php foreach( $posts as $p ): ?>
                    <section class="col-lg-6 col-xs-12 mb-xs-4 rounded">
					        <article class="card h-100 rounded border-0">
                                <img class="rounded" src="<?php echo get_the_post_thumbnail_url( $p->ID ); ?>" width="100%">
                                <article class="card-img-overlay bg-home-desc h-auto rounded-bottom container-img-noticias-destaques-primaria">
                                    <h3 class="fonte-catorze font-weight-bold">
                                        <a class="text-white" href="<?php echo get_permalink( $p->ID ); ?>">
											<?php echo get_the_title( $p->ID ); ?>

                                        </a>
                                    </h3>
                                    <section class="card-text text-white fonte-doze"><p class="mb-3 "><?php echo get_the_excerpt($p->ID ); ?></p></section>
                                </article>
                            </article>
                    </section>
					<?php endforeach; ?>
			<?php endif;
		wp_reset_postdata();

	}



}