<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialFacebook
{

	public function __construct()
	{
		$this->montaHtmlFacebook();
	}

	public function montaHtmlFacebook(){
		?>
		<article class="col-12 col-md-6">
			<?php dynamic_sidebar('Facebook Home'); ?>
		</article>
		<?php
	}

}