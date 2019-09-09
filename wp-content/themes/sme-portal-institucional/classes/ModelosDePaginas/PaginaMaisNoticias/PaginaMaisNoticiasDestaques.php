<?php

namespace Classes\ModelosDePaginas\PaginaMaisNoticias;


class PaginaMaisNoticiasDestaques extends PaginaMaisNoticias
{
	private $destaque_principal;
	private $segundo_destaque;
	private $terceiro_destaque;
	private $quarto_destaque;
	private $quinto_destaque;

	public function __construct()
	{
		$this->destaque_principal = get_field('escolha_o_destaque_principal', get_the_ID());
		$this->segundo_destaque = get_field('escolha_o_segundo_destaque', get_the_ID());
		$this->terceiro_destaque = get_field('escolha_o_terceiro_destaque', get_the_ID());
		$this->quarto_destaque = get_field('escolha_o_quarto_destaque', get_the_ID());
		$this->quinto_destaque = get_field('escolha_o_quinto_destaque', get_the_ID());

		$this->init();
	}

	public function init(){
		echo '<section class="col-lg-8 col-sm-12 border-bottom">';

		$this->getDestaquePrincial();

		echo '<section class="row">';
		$this->getDestaquesSecundarios($this->segundo_destaque->ID);
		$this->getDestaquesSecundarios($this->terceiro_destaque->ID);
		$this->getDestaquesSecundarios($this->quarto_destaque->ID);
		$this->getDestaquesSecundarios($this->quinto_destaque->ID);
		echo '</section>';

		echo '</article>';
	}

	public function getDestaquePrincial(){
		?>
		<section class="card bg-dark text-white mb-3 border-0">
			<figure class="m-0 p-0">
				<img src="<?= get_the_post_thumbnail_url($this->destaque_principal->ID) ?>" class="img-fluid card-img" alt="">
			</figure>
			<article class="card-img-overlay h-100 d-flex flex-column justify-content-end">
				<h2 class="card-title mais-noticias-destaque-principal"><a href="<?= get_the_permalink($this->destaque_principal->ID) ?>"><?= get_the_title($this->destaque_principal->ID) ?></a></h2>
				<p class="card-text"><?= get_the_excerpt($this->destaque_principal->ID) ?></p>
			</article>

		</section>
		<?php

	}

	public function getDestaquesSecundarios($post_id){
		?>

		<section class="col-6">
			<article class="card border-0">
				<img src="<?= get_the_post_thumbnail_url($post_id) ?>" class="img-fluid card-img-top" alt="">
				<div class="card-body">
					<a href="<?= get_the_permalink($this->destaque_principal->ID) ?>"><h2 class="card-title"><?= get_the_title($post_id) ?></h2></a>
				</div>
			</article>

		</section>

		<?php

	}

}