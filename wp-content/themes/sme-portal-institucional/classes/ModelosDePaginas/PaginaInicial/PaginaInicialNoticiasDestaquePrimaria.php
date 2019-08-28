<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialNoticiasDestaquePrimaria extends PaginaInicial
{

	public function __construct()
	{
		$this->montaQueryNoticiasHomePrincipal();
		$this->montaHtmlLoopNoticiaPrincipal();

	}

	public function montaQueryNoticiasHomePrincipal()
	{
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

	public function montaHtmlLoopNoticiaPrincipal()
	{
		echo '<section class="col-lg-6 col-xs-12 mb-xs-4">';
		if ($this->query_noticias_home_principal->have_posts()) : while ($this->query_noticias_home_principal->have_posts()) : $this->query_noticias_home_principal->the_post();
			$this->id_noticias_home_principal = get_the_ID();
			?>

            <article class="card h-100 rounded border-0">
				<?php if (has_post_thumbnail()) {
					echo '<figure class="mb-0">';
					the_post_thumbnail('large', array('class' => 'card-img'));
					echo '</figure>';
				} else {
					echo '<figure>';
					echo '<img src="https://dummyimage.com/535x325/4F4F4F/4F4F4F" class="card-img" alt="Imagem de Exemplo">';
					echo '</figure>';
				}
				?>
                <article class="card-img-overlay bg-azul-claro h-auto rounded-bottom">
                    <h2 class="fonte-catorze font-weight-bold">
                        <a class="text-white" href="<?= get_the_permalink() ?>">
							<?= get_the_title() ?>
                        </a>
                    </h2>
                    <?php if (get_the_excerpt()){ ?>
                        <section class="card-text text-white fonte-doze">
                            <?= get_the_excerpt() ?>
                        </section>
                    <?php } ?>
                </article>
            </article>
		<?php
		endwhile;
		endif;
		echo '</section>';
		wp_reset_postdata();

	}



}