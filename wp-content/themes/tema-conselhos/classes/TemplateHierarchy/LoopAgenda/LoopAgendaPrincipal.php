<?php
namespace Classes\TemplateHierarchy\LoopAgenda;
class LoopAgendaPrincipal extends LoopAgenda
{
	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		$this->montaHtmlPrincipal();
	}
	public function montaHtmlPrincipal(){
		if (have_posts()):
			while (have_posts()): the_post();
				echo '<article class="col-lg-12 col-sm-12">';
					$this->getDataPublicacaoAlteracao();
					echo '<h1 class="mb-3" id="'.get_post_field( 'post_name', get_post() ).'">'.get_the_title().'</h1>';
					the_content();
				echo '</article>';
			endwhile;
		endif;
		wp_reset_query();
	}
	public function getDataPublicacaoAlteracao(){
	
		echo '<p>Atualizado em <time datetime="' . get_the_modified_time('Y-m-d') . '">' . get_the_modified_time('d/m/Y') .'</time></p>';
		//padrão de horario G\hi
		//echo '<span class="display-autor">Publicado em: '.get_the_date('d/m/Y G\hi').' | Atualizado em: '.get_the_modified_date('d/m/Y').'</span>';
	
	}
	
}
