<?php

namespace Classes\ModelosDePaginas;


class ModelosDePaginaRemoveThemeSupport
{

	protected $page_id;
	protected $page_template_slug;

	public function __construct()
	{
		$this->page_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
		$this->page_template_slug = get_page_template_slug($this->page_id);
		add_action( 'admin_init', array($this,'removeThemeSupport' ), 10,2);
		add_filter( 'theme_page_templates', array($this, 'removePageTemplateForContributor'));

	}

	public function removePageTemplateForContributor($pages_templates){
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;

		if ($roles[0] == 'contributor') {
			unset( $pages_templates['page.php'] );
			unset( $pages_templates['pagina-agenda-secretario.php'] );
			unset( $pages_templates['pagina-contato-sme.php'] );
			unset( $pages_templates['pagina-escolas.php'] );
			unset( $pages_templates['pagina-inicial.php'] );
			unset( $pages_templates['pagina-organograma.php'] );
		}
		return $pages_templates;
	}

	public function removeThemeSupport()
	{
		if ($this->page_template_slug === 'pagina-layout-colunas.php'){
			remove_post_type_support( 'page', 'editor' );
			remove_post_type_support( 'page', 'thumbnail' );
		}elseif ($this->page_template_slug === 'pagina-imagem-video.php'){
			remove_post_type_support( 'page', 'thumbnail' );
		}
	}
}

new ModelosDePaginaRemoveThemeSupport();