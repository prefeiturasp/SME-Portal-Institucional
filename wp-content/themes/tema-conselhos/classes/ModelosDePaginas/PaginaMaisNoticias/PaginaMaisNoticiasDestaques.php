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

        PaginaMaisNoticiasArrayIdNoticias::setArrayIdNoticias($this->destaque_principal->ID);
        PaginaMaisNoticiasArrayIdNoticias::setArrayIdNoticias($this->segundo_destaque->ID);
        PaginaMaisNoticiasArrayIdNoticias::setArrayIdNoticias($this->terceiro_destaque->ID);
        PaginaMaisNoticiasArrayIdNoticias::setArrayIdNoticias($this->quarto_destaque->ID);
        PaginaMaisNoticiasArrayIdNoticias::setArrayIdNoticias($this->quinto_destaque->ID);

		echo '<section class="col-lg-8 col-sm-12">';

		$this->getDestaquePrincial();

		echo '<section class="row">';
		$this->getDestaquesSecundarios($this->segundo_destaque->ID);
		$this->getDestaquesSecundarios($this->terceiro_destaque->ID);
		$this->getDestaquesSecundarios($this->quarto_destaque->ID);
		$this->getDestaquesSecundarios($this->quinto_destaque->ID);
		echo '</section>';

		echo '</section>';
	}

	public function getAltThumbnail($post_id){
		$thumbnail_id = get_post_thumbnail_id( $post_id );
		$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

		return $alt;
    }

	public function getDestaquePrincial(){

		if ($this->destaque_principal) {
			?>
            <section class="card bg-dark text-white mb-3">
                <figure class="m-0 p-0">
                    <img src="<?= get_the_post_thumbnail_url($this->destaque_principal->ID) ?>" class="img-fluid card-img" alt='<?= $this->getAltThumbnail($this->destaque_principal->ID) ?>'>
                </figure>
                <article class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                    <h2 class="card-title mais-noticias-destaque-principal">
                        <a class="text-white" href="<?= get_the_permalink($this->destaque_principal->ID) ?>"><?= get_the_title($this->destaque_principal->ID) ?></a>
                    </h2>

                    <?php
                    if ($this->getSubtitulo($this->destaque_principal->ID)) { ?>
                        <?= $this->getSubtitulo($this->destaque_principal->ID, 'p', 'card-text texto-mais-noticias-destaques') ?>
                    <?php } ?>
                </article>

            </section>
            <div class="w-100 pb-1 mb-3 border-bottom"></div>
			<?php
		}

	}

	public function getDestaquesSecundarios($post_id){
		if ($post_id) {
			?>
            <section class="col-6">
                <article class="card border-0">
                    <img src="<?= get_the_post_thumbnail_url($post_id) ?>" class="img-fluid card-img-top" alt='<?= $this->getAltThumbnail($post_id) ?>'>
                    <div class="card-body pl-0 pr-0">
                        <a href="<?= get_the_permalink($post_id) ?>">
                            <h2 class="card-title mais-noticias-titulo-destaque-secundarios"><?= get_the_title($post_id) ?></h2>
                        </a>
                    </div>
                </article>
            </section>
			<?php
		}
	}
}