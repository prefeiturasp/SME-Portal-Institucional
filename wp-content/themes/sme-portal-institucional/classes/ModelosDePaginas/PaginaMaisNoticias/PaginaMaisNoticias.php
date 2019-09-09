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

		new PaginaMaisNoticiasMenu();
		new PaginaMaisNoticiasTitulo();

		new PaginaMaisNoticiasDestaques();



		$this->fechaContainer($container_geral_tags);
	}

}