<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialIcones extends PaginaInicial
{
	public function __construct()
	{

		$this->criaArrayIconesTitulosIcones();

		$Icones_menu_icones_tags = array('section','article','article','article');
		$Icones_menu_icones_css = array('bg-cinza-claro areas-menu overflow-hidden','container','row','col-lg-12 col-xs-12');

		//$this->abreContainer($Icones_menu_icones_tags, $Icones_menu_icones_css);
		$this->montaHtmlIcones();
		$this->montaHtmlMenuIcones();
		//$this->fechaContainer($Icones_menu_icones_tags);
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
        <div class="container">
            <ul class="card-group nav" role="tablist">
				<?php foreach ($this->array_icone_titulo_icone_id_menu_icone as $icone) { ?>

                    <li id="tab_<?= $icone['menu_icone'] ?>" class="container-a-icones-home card rounded-0 border-0 pt-5 pb-3">
                        <a id="tab_<?= $icone['menu_icone'] ?>" data-toggle="tab" href="#menu_<?= $icone['menu_icone'] ?>"
                           role="tab" aria-selected="false"
                           class="a-icones-home d-flex justify-content-center align-items-center">
                            <img src="<?= $icone['url_icone'] ?>" class="icones-home" alt="Ícone <?= $icone['titulo_icone'] ?>">
                        </a>
                        <div class="card-body text-center">
                            <p class="card-text titulo-icones"><?= $icone['titulo_icone'] ?></p>
                        </div>
                    </li>
				<?php } ?>
            </ul>
        </div>
		<?php
	}

	public function montaHtmlMenuIcones()
	{
		echo '<section class="tab-content bg-cinza-ativo">';

		foreach ($this->array_icone_titulo_icone_id_menu_icone as $icone) {

		   // echo '<div class="tab-pane fade container" id="menu_' . $icone['menu_icone'] . '" role="tabpanel" aria-labelledby="tab_' . $icone['menu_icone'] . '">';

		    ?>

           <section class="tab-pane fade container" id="menu_<?= $icone['menu_icone'] ?>" role="tabpanel" aria-labelledby="tab_<?= $icone['menu_icone'] ?>">

                <nav class="navbar navbar-expand-lg nav-icones-menu">


                    <article class="collapse navbar-collapse">
						<?php
						wp_nav_menu(array(
							'menu' => $icone['menu_icone'],
							//'theme_location' => 'primary',
							'depth' => 2,
							//'container_id' => 'bs-example-navbar-collapse-1',
							'menu_class' => 'navbar-nav mr-auto nav nav-tabs ul-icones-home',
							'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
							'walker'            => new \WP_Bootstrap_Navwalker(),
						));
						?>

                    </article>

                </nav>
            </section>

            <?php

		}

		echo '</section>';

	}

/*	public function montaHtmlMenuIcones()
	{
		echo '<article class="tab-content bg-cinza-ativo">';

		foreach ($this->array_icone_titulo_icone_id_menu_icone as $icone) {

			if ($icone['menu_icone']) {
				wp_nav_menu(array(
					'menu' => $icone['menu_icone'],
					'theme_location' => 'primary',
					'depth' => 2,
					'container' => false,
					'items_wrap' => '<div class="tab-pane fade container" id="menu_' . $icone['menu_icone'] . '" role="tabpanel" aria-labelledby="tab_' . $icone['menu_icone'] . '"><ul class="nav nav-pills container-menu-icones-home">%3$s</ul></div>'
				));
			}

		}

		echo '</article>';

	}*/

}