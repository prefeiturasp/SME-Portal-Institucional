<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicial
{
	// Ícones
	protected $page_id;
	protected $page_slug;
	protected $primeiro_icone;
	protected $titulo_primeiro_icone;
	protected $menu_primeiro_icone;
	protected $segundo_icone;
	protected $titulo_segundo_icone;
	protected $menu_segundo_icone;
	protected $terceiro_icone;
	protected $titulo_terceiro_icone;
	protected $menu_terceiro_icone;
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
		$this->getCamposPersonalizados();

		$this->criaArrayIconesTitulosIcones();
		$this->montaHtmlLoopPadrao();

		$this->abreContainerHtmlIconesMenuIcones();
		$this->montaHtmlIcones();
		$this->montaHtmlMenuIcones();
		$this->fechaContainerHtmlIconesMenuIcones();

		$this->abreContainerHtmlNoticiasHome();
		$this->montaQueryNoticiasHomePrincipal();
		$this->montaHtmlLoopNoticiaPrincipal();
		$this->montaQueryNoticiasHomeSecundarias();
		$this->montaHtmlLoopNoticiasSecundarias();
		$this->fechaContainerHtmlNoticiasHome();

		$this->abreContainerHtmlTwitterNewsletter();
		$this->montaHtmlTwitter();
		$this->montaHtmlNewsletter();

		$this->fechaContainerHtmlTwitterNewsletter();


	}

	public function montaHtmlLoopPadrao()
	{

		echo '<div class="container">';
		if (have_posts()) : while (have_posts()) : the_post();
			?>
            <div class="row">
                <div class="col-12">
                    <h1 id="<?= $this->page_slug ?>"><?php the_title(); ?></h1>
					<?php if (has_post_thumbnail()) {
						the_post_thumbnail('thumbnail', array('class' => 'img-fluid alignright img-thumbnail'));
					} ?>
					<?php the_content(); ?>
                </div>
            </div>
		<?php
		endwhile;
		endif;
		echo '</div>'; //container
	}

	public function getCamposPersonalizados()
	{
		// Ícones, titulo dos ícones e menu dos ícones
		$this->primeiro_icone = get_field('escolha_o_primeiro_icone', $this->page_id);
		$this->titulo_primeiro_icone = get_field('escolha_o_titulo_do_primeiro_icone', $this->page_id);
		$this->menu_primeiro_icone = get_field('escolha_o_menu_do_primeiro_icone', $this->page_id);

		$this->segundo_icone = get_field('escolha_o_segundo_icone', $this->page_id);
		$this->titulo_segundo_icone = get_field('escolha_o_titulo_do_segundo_icone', $this->page_id);
		$this->menu_segundo_icone = get_field('escolha_o_menu_do_segundo_icone', $this->page_id);

		$this->terceiro_icone = get_field('escolha_o_terceiro_icone', $this->page_id);
		$this->titulo_terceiro_icone = get_field('escolha_o_titulo_do_terceiro_icone', $this->page_id);
		$this->menu_terceiro_icone = get_field('escolha_o_menu_do_terceiro_icone', $this->page_id);

		// Noticias Home
		$this->categoria_noticias_home = get_field('escolha_a_categoria_de_noticias_a_exibir', $this->page_id);

	}

	public function criaArrayIconesTitulosIcones()
	{
		array_push($this->array_icone_titulo_icone_id_menu_icone, array("url_icone" => $this->primeiro_icone['url'], "titulo_icone" => $this->titulo_primeiro_icone, "menu_icone" => $this->menu_primeiro_icone));
		array_push($this->array_icone_titulo_icone_id_menu_icone, array("url_icone" => $this->segundo_icone['url'], "titulo_icone" => $this->titulo_segundo_icone, "menu_icone" => $this->menu_segundo_icone));
		array_push($this->array_icone_titulo_icone_id_menu_icone, array("url_icone" => $this->terceiro_icone['url'], "titulo_icone" => $this->titulo_terceiro_icone, "menu_icone" => $this->menu_terceiro_icone));
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
                        <img src="<?= $icone['url_icone'] ?>" class="" alt="">
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
		echo '<div class="tab-content menu-completo bg-cinza-ativo">';

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

		echo '</div>';

	}

	public function montaQueryNoticiasHomePrincipal()
	{
		$this->args_noticas_home_principal = array(
			'post_type' => 'post',
			'orderby' => 'date',
			'order' => 'DESC',
			'cat' => $this->categoria_noticias_home->term_id,
			'posts_per_page' => 1,
		);
		$this->query_noticias_home_principal = new \WP_Query($this->args_noticas_home_principal);

	}

	public function montaHtmlLoopNoticiaPrincipal()
	{

		if ($this->query_noticias_home_principal->have_posts()) : while ($this->query_noticias_home_principal->have_posts()) : $this->query_noticias_home_principal->the_post();
			$this->id_noticias_home_principal = get_the_ID();
			?>
            <div class="col-lg-6 col-xs-12 mb-xs-4">
                <div class="card h-100 rounded border-0">
					<?php if (has_post_thumbnail()) {
						the_post_thumbnail('large', array('class' => 'card-img'));
					} else {
						echo '<img src="https://dummyimage.com/535x325/4F4F4F/4F4F4F" class="card-img" alt="">';
					}
					?>
                    <div class="card-img-overlay bg-azul-claro h-auto rounded-bottom">
                        <h2 class="fonte-catorze font-weight-bold">
                            <a class="text-white" href="<?= get_the_permalink() ?>">
								<?= get_the_title() ?>
                            </a>
                        </h2>
                        <p class="card-text text-white fonte-doze">
							<?= get_the_excerpt() ?>
                        </p>
                    </div>
                </div>
            </div>

		<?php
		endwhile;
		endif;

	}

	public function montaQueryNoticiasHomeSecundarias()
	{
		$this->args_noticas_home_secundarias = array(
			'post_type' => 'post',
			'orderby' => 'date',
			'order' => 'DESC',
			'cat' => $this->categoria_noticias_home->term_id,
			'posts_per_page' => 2,
			'post__not_in' => array($this->id_noticias_home_principal),
		);
		$this->query_noticias_home_secundarias = new \WP_Query($this->args_noticas_home_secundarias);
	}

	public function montaHtmlLoopNoticiasSecundarias()
	{
		echo '<div class="col-lg-6 col-xs-12">';
		if ($this->query_noticias_home_secundarias->have_posts()) : while ($this->query_noticias_home_secundarias->have_posts()) : $this->query_noticias_home_secundarias->the_post();
			?>

            <div class="row mb-4 pb-4 border-bottom">
                <div class="col-lg-12">
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
                </div>
            </div>
		<?php
		endwhile;
		endif;
		?>
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <button type="button" class="btn btn-primary btn-sm btn-block bg-azul-escuro font-weight-bold">Mais
                    notícias
                </button>
            </div>
        </div>
		<?php
		echo '</div>';
	}

	public function montaHtmlTwitter(){
	    ?>
        <div class="col-lg-6 col-xs-12 mb-xs-4">
            <a class="twitter-timeline" data-lang="pt" data-height="395"
               href="https://twitter.com/EducaPrefSP">Tweets by EducaPrefSP</a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <?php
    }

    public function montaHtmlNewsletter(){
	    ?>
        <div class="col-lg-6 col-xs-12">
            <div class="bg-white shadow-sm text-center p-3 mb-3 mb-xs-4">
                <h2 class="font-weight-bold mb-2">
                    <i class="fa fa-envelope text-primary"></i>
                    Assine Nossa Newsletter
                </h2>
                <div class="w-100 mx-auto p-2 pb-0 mb-2">
                    Receba nossas novidades e fique por dentro de tudo o que acontece na Secretaria Municipal de Educação.
                </div>
        <?= do_shortcode('[contact-form-7 id="18931" title="Newsletter"]'); ?>

	    <?php
    }

	public function abreContainerHtmlIconesMenuIcones()
	{
		?>
        <div class="bg-cinza-claro areas-menu overflow-hidden">
        <div class="container">
        <div class="row">
        <div class="col-lg-12 col-xs-12">
		<?php
	}

	public function fechaContainerHtmlIconesMenuIcones()
	{
		?>
        </div>
        </div>
        </div>
        </div>
		<?php
	}

	public function abreContainerHtmlNoticiasHome()
	{
		?>
        <div class="container mt-5 mb-5 noticias">
        <div class="row mb-4">
            <div class="col-lg-12 col-xs-12">
                <h2 class="border-bottom">Notícias</h2>
            </div>
        </div>
        <div class="row">
		<?php
	}

	public function fechaContainerHtmlNoticiasHome()
	{
		?>

        </div>
        </div>
		<?php

	}

	public function abreContainerHtmlTwitterNewsletter()
	{
		?>
        <div class="bg-light pt-5 pb-5 area-social">
        <div class="container">
        <div class="row">
		<?php
	}

	public function fechaContainerHtmlTwitterNewsletter()
	{
		?>
        </div>
        </div>
        </div>
        </div>
		<?php
	}

}