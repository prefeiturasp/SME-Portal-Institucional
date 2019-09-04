<?php

namespace Classes\TemplateHierarchy\LoopSingle;


class LoopSingleNoticiaPrincipal extends LoopSingle
{

	public function __construct()
	{
		$this->init();
	}

	public function init()
	{

		$this->montaHtmlNoticiaPrincipal();
	}

	public function montaHtmlNoticiaPrincipal(){
		if (have_posts()):
			while (have_posts()): the_post();

			echo '<article class="col-lg-8 col-sm-12 border-bottom">';
                echo '<h1 class="titulo-noticia-principal mb-3" id="'.get_post_field( 'post_name', get_post() ).'">'.get_the_title().'</h1>';
				echo $this->getSubtitulo(get_the_ID());
				$this->getAutor();
				//$this->getMidiasSociais();
				the_content();
				$this->getArquivosAnexos();
				$this->getCategorias(get_the_ID());
			echo '</article>';
			endwhile;
		endif;
		wp_reset_query();
	}

	public function getAutor(){
		$usuario = wp_get_current_user();
		$autor = get_the_author_meta('display_name', $usuario->ID);
		echo '<span class="display-autor">Por '.$autor.' - '.get_the_date('d/m/Y g\hi').'</span>';


	}

	public function getMidiasSociais(){
	    /*Utilizando as classes de personalização do Plugin Add This*/
		?>
		<div id="container-midias-sociais-loop-single" class="addthis_toolbox addthis_default_style addthis_32x32_style">
			<a target="_self" class="addthis_button_whatsapp"></a>
			<a target="_self" class="addthis_button_facebook"></a>
			<a target="_self" class="addthis_button_twitter"></a>
			<a target="_self" class="addthis_button_print"></a>
			<a target="_self" class="addthis_button_compact"></a>
		</div>
		<?php
	}

	public function getArquivosAnexos(){
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => get_the_ID(),
			'orderby'	=> 'ID',
			'order'	=> 'ASC',
			'exclude'     => get_post_thumbnail_id()
		) );

		if ( $attachments ) {
			echo '<section id="arquivos-anexos">';
			echo '<h2>Arquivos Anexos</h2>';
			foreach ( $attachments as $attachment ) {
			    echo '<article>';
				echo '<p><a target="_blank" style="font-size:26px" href="'.$attachment->guid.'"><i class="fa fa-file-text-o fa-3x" aria-hidden="true"></i> Ir para '. $attachment->post_title.'</a></p>';
				echo '<article>';
			}
			echo '</section>';
		}
    }

    public function getCategorias($id_post){
		$categorias = get_the_category($id_post);

		foreach ($categorias as $categoria){
			$category_link = get_category_link( $categoria->term_id );
		    echo '<a href="'.$category_link.'"><span class="badge badge-pill badge-light border p-2 m-2 font-weight-normal">ir para '.$categoria->name.'</span></a>';
        }
	}

}