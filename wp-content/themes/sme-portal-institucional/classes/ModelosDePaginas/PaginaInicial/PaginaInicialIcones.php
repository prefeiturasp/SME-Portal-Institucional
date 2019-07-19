<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialIcones extends PaginaInicial
{
	public function __construct()
	{
		$this->criaArrayIconesTitulosIcones();

				?>
		<section class="bg-cinza-claro areas-menu overflow-hidden">
		<article class="container">
		<article class="row">
		<article class="col-lg-12 col-xs-12">
		<?php
		$Icones_menu_icones_tags = array('section','article','article','article');
		$Icones_menu_icones_css = array('bg-cinza-claro areas-menu overflow-hidden','container','row','col-lg-12 col-xs-12');

		$this->abreContainerHtmlIconesMenuIcones();
		$this->montaHtmlIcones();
		$this->montaHtmlMenuIcones();
		$this->fechaContainerHtmlIconesMenuIcones();
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


}