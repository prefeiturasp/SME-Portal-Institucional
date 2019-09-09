<?php

namespace Classes\ModelosDePaginas\PaginaMaisNoticias;


class PaginaMaisNoticiasTitulo extends PaginaMaisNoticias
{

	public function __construct()
	{
		$this->cabecalho();
	}

	public function cabecalho(){
		?>
		<article class="col-12">
			<h1 id="mais-noticias" class="titulos_internas mb-lg-5">Mais Notícias</h1>
		</article>
		<?php


	}

}