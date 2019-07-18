<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


use Classes\Lib\Util;

class PaginaInicial extends Util
{
	protected $array_icone_titulo_icone_id_menu_icone = array();

	// Notícias
	protected $categoria_noticias_home;
	protected $id_noticias_home_principal;
	protected $args_noticas_home_principal;
	protected $query_noticias_home_principal;
	protected $args_noticas_home_secundarias;
	protected $query_noticias_home_secundarias;

	public function __construct()
	{
		$this->page_id = get_the_ID();
		$this->page_slug = get_queried_object()->post_name;

		$util = new Util($this->page_id);

		$this->criaArrayIconesTitulosIcones();



		// Classe Util
		$util->montaHtmlLoopPadrao();

		$this->abreContainerHtmlIconesMenuIcones();
		$this->montaHtmlIcones();
		$this->montaHtmlMenuIcones();
		$this->fechaContainerHtmlIconesMenuIcones();

		$this->abreContainerHtmlNoticiasHome();

		$this->montaQueryNoticiasHomePrincipal();
		$this->montaHtmlLoopNoticiaPrincipal();

		$this->abreContainerNoticiasSecundarias();
		$this->montaQueryNoticiasHomeSecundarias();
		$this->montaHtmlLoopNoticiasSecundarias();
		$this->montaHtmlBotaoMaisNoticias();
		$this->fechaContainerNoticiasSecundarias();

		$this->fechaContainerHtmlNoticiasHome();

		$this->abreContainerHtmlTwitterNewsletter();
		$this->montaHtmlTwitter();
		$this->montaHtmlNewsletter();

		$this->fechaContainerHtmlTwitterNewsletter();
	}

	public function criaArrayIconesTitulosIcones()
	{
		array_push($this->array_icone_titulo_icone_id_menu_icone, array("url_icone" => $this->getCamposPersonalizados('escolha_o_primeiro_icone')['url'], "titulo_icone" => $this->getCamposPersonalizados('escolha_o_titulo_do_primeiro_icone'), "menu_icone" => $this->getCamposPersonalizados('escolha_o_menu_do_primeiro_icone')));
		array_push($this->array_icone_titulo_icone_id_menu_icone, array("url_icone" => $this->getCamposPersonalizados('escolha_o_segundo_icone')['url'], "titulo_icone" => $this->getCamposPersonalizados('escolha_o_titulo_do_segundo_icone'), "menu_icone" => $this->getCamposPersonalizados('escolha_o_menu_do_segundo_icone')));
		array_push($this->array_icone_titulo_icone_id_menu_icone, array("url_icone" => $this->getCamposPersonalizados('escolha_o_terceiro_icone')['url'], "titulo_icone" => $this->getCamposPersonalizados('escolha_o_titulo_do_terceiro_icone'), "menu_icone" => $this->getCamposPersonalizados('escolha_o_menu_do_terceiro_icone')));
	}


	public function montaHtmlIcones()
	{
		?>
        <ul class="card-group nav" role="tablist">
			<?php
			foreach ($this->array_icone_titulo_icone_id_menu_icone as $icone) {
				?>
                <li class="card rounded-0 border-0 bg-cinza pt-5 pb-3">
                    <a id="tab_<?= $icone['menu_icone'] ?>" data-toggle="tab" href="#menu_<?= $icone['menu_icone'] ?>"
                       role="tab" aria-controls="aria_controls_<?= $icone['menu_icone'] ?>" aria-selected="false"
                       class="d-flex justify-content-center align-items-center">
                        <img src="<?= $icone['url_icone'] ?>" class="icones-home">
                    </a>
                    <div class="card-body text-center">
                        <p class="card-text"><?= $icone['titulo_icone'] ?></p>
                    </div>
                </li>
				<?php
			}
			?>
        </ul>
		<?php
	}

	public function montaHtmlMenuIcones()
	{
		echo '<section class="tab-content menu-completo bg-cinza-ativo">';

		foreach ($this->array_icone_titulo_icone_id_menu_icone as $icone) {

			if ($icone['menu_icone']) {
				wp_nav_menu(array(
					'menu' => $icone['menu_icone'],
					'theme_location' => 'primary',
					'depth' => 2,
					'container' => false,
					'items_wrap' => '<div class="tab-pane fade container" id="menu_' . $icone['menu_icone'] . '" role="tabpanel" aria-labelledby="tab_' . $icone['menu_icone'] . '"><ul class="nav nav-pills p-2">%3$s</ul></div>'
				));
			}

		}

		echo '</section>';

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
					    echo '<figure>';
						the_post_thumbnail('large', array('class' => 'card-img'));
						echo '</figure>';
					} else {
						echo '<figure>';
						echo '<img src="https://dummyimage.com/535x325/4F4F4F/4F4F4F" class="card-img" alt="">';
						echo '</figure>';
					}
					?>
                    <article class="card-img-overlay bg-azul-claro h-auto rounded-bottom">
                        <h2 class="fonte-catorze font-weight-bold">
                            <a class="text-white" href="<?= get_the_permalink() ?>">
								<?= get_the_title() ?>
                            </a>
                        </h2>
                        <p class="card-text text-white fonte-doze">
							<?= get_the_excerpt() ?>
                        </p>
                    </article>
                </article>
		<?php
		endwhile;
		endif;
		echo '</section>';
		wp_reset_postdata();

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

	public function abreContainerNoticiasSecundarias(){
		echo '<section class="col-lg-6 col-xs-12">';
    }

	public function fechaContainerNoticiasSecundarias(){
		echo '</section>';
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

	public function montaHtmlTwitter(){
	    ?>
        <section class="col-lg-6 col-xs-12 mb-xs-4">
            <a class="twitter-timeline" data-lang="pt" data-height="395"
               href="https://twitter.com/EducaPrefSP">Tweets by EducaPrefSP</a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </section>
        <?php
    }

    public function montaHtmlNewsletter(){
	    ?>
        <section class="col-lg-6 col-xs-12">
            <article class="bg-white shadow-sm text-center p-3 mb-3 mb-xs-4">
                <h2 class="font-weight-bold mb-2">
                    <i class="fa fa-envelope text-primary"></i>
                    Assine Nossa Newsletter
                </h2>
                <div class="w-100 mx-auto p-2 pb-0 mb-2">
                    Receba nossas novidades e fique por dentro de tudo o que acontece na Secretaria Municipal de Educação.
                </div>
                <?= do_shortcode('[contact-form-7 id="18931" title="Newsletter"]'); ?>
            </article>

            <?php $this->montaHtmlNuvemTags(); ?>

        </section>

	    <?php
    }

	public function montaHtmlNuvemTags(){

		echo '<section class="col">';

		$args = array(
			'smallest'                  => 8,
			'largest'                   => 22,
			'unit'                      => 'pt',
			'number'                    => 20,
			'format'                    => 'flat',
			'separator'                 => "\n",
			'orderby'                   => 'name',
			'order'                     => 'ASC',
			'exclude'                   => null,
			'include'                   => null,
			'topic_count_text_callback' => default_topic_count_text,
			'link'                      => 'view',
			'taxonomy'                  => 'post_tag',
			'echo'                      => true,
			'show_count'                  => 0,
			'child_of'                  => null, // see Note!
		);

		wp_tag_cloud($args);

		echo '</section>';
	}

	public function abreContainerHtmlIconesMenuIcones()
	{
		?>
        <section class="bg-cinza-claro areas-menu overflow-hidden">
        <article class="container">
        <article class="row">
        <article class="col-lg-12 col-xs-12">
		<?php
	}

	public function fechaContainerHtmlIconesMenuIcones()
	{
		?>
        </article>
        </article>
        </article>
        </section>
		<?php
	}

	public function abreContainerHtmlNoticiasHome()
	{
		?>
        <section class="container mt-5 mb-5 noticias">
        <article class="row mb-4">
            <article class="col-lg-12 col-xs-12">
                <h2 class="border-bottom">Notícias</h2>
            </article>
        </article>
        <section class="row">
		<?php
	}

	public function fechaContainerHtmlNoticiasHome()
	{
		?>

        </section>
        </section>
		<?php

	}

	public function abreContainerHtmlTwitterNewsletter()
	{
		?>
        <section class="bg-light pt-5 pb-5 area-social">
        <article class="container">
        <article class="row">
		<?php
	}

	public function fechaContainerHtmlTwitterNewsletter()
	{
		?>
        </article>
        </article>
        </section>

		<?php
	}

}