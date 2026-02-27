<?php

namespace Classes\ModelosDePaginas\PaginaMaisNoticias;

use Classes\Lib\Util;

class PaginaMaisNoticias extends Util
{

	public function __construct()
	{

	}

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container', 'row');
		$this->abreContainer($container_geral_tags, $container_geral_css);
			new PaginaMaisNoticiasTitulo();
		$this->fechaContainer($container_geral_tags);
		?>
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<?php
						new PaginaMaisNoticiasDestaques();
					?>
				</div>
				<div class="col-sm-4 mb-4 align-self-start">
					
					<?php new PaginaMaisNoticiasMaisLidas(); ?>
				</div>
			</div>
		</div>
		<?php
		

		//new PaginaMaisNoticiasProgramasProjetos();

		$container_outras_noticias_e_newsletter_tags = array('section', 'section');
		$container_outras_noticias_e_newsletter_css = array('container', 'row');
		$this->abreContainer($container_outras_noticias_e_newsletter_tags, $container_outras_noticias_e_newsletter_css);

		//new PaginaMaisNoticiasOutrasNoticias();
		//new PaginaMaisNoticiasNewsletter();

		$this->fechaContainer($container_outras_noticias_e_newsletter_tags);


	}

}