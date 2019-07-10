<?php

namespace Classes\ModelosDePaginas\PaginaImagemVideo;


use Classes\Lib\Util;

class PaginaImagemVideo extends Util
{
	protected $page_id;
	protected $page_template_slug;
	const MODELO_DE_PAGINA = 'pagina-imagem-video.php';

	public function __construct()
	{
		$this->page_id = get_the_ID();

		$util = new Util($this->page_id);

		$this->montaHtmlLoopPadrao();
	}

	public function getImagemOuVideo(){

		$escolha = $this->getCamposPersonalizados('deseja_exibir_imagem_ou_video');

		if ($escolha == 'imagem'){
			$this->getImagem();
		}else{
			$this->getVideo();
		}
	}

	public function getImagem(){

		$imagem = $this->getCamposPersonalizados('insira_a_imagem_desta_pagina');

			echo '<div class="row mb-4">';
			echo '<div class="col">';
			echo '<img src="'.$imagem["url"].'">';
			echo '</div>';
			echo '</div>';
	}

	public function getVideo(){

		$video = $this->getCamposPersonalizados('insira_o_video_desta_pagina');
		echo '<div class="embed-responsive embed-responsive-16by9 mb-4">';
		echo apply_filters('the_content', $video);
		echo '</div>';
	}

	public function montaHtmlLoopPadrao()
	{
		echo '<div class="container">';
		if (have_posts()) : while (have_posts()) : the_post();
			?>
			<div class="row">
				<div class="col-lg-9 col-xs-12">
					<h1 class="titulos_internas mb-5" id="<?= $this->page_slug ?>"><?php the_title(); ?></h1>

					<?php echo $this->getSubtitulo($this->page_id)?>
					<?= $this->getImagemOuVideo(); ?>
					<?php if (has_post_thumbnail()) {
						the_post_thumbnail('thumbnail', array('class' => 'ml-5 float-right'));
					} ?>
					<?php the_content(); ?>
				</div>
			</div>
		<?php
		endwhile;
		endif;
		wp_reset_query();
		echo '</div>'; //container
	}
}
