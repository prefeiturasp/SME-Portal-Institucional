<?php

namespace Classes\TemplateHierarchy\LoopQuebrada;

use Classes\Lib\Util;

class LoopQuebrada extends Util
{

	public function __construct()
	{
		$this->init();
	}

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container-fluid single-quebrada', 'row');
		$this->abreContainer($container_geral_tags, $container_geral_css);

		new LoopQuebradaCabecalho();
		new LoopQuebradaNoticiaPrincipal();

		$this->fechaContainer($container_geral_tags);
	}



}