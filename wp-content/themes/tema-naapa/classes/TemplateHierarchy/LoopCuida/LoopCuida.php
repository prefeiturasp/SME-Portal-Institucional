<?php

namespace Classes\TemplateHierarchy\LoopCuida;

use Classes\Lib\Util;

class LoopCuida extends Util
{

	public function __construct()
	{
		$this->init();
	}

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container-fluid single-cuida', 'row');
		$this->abreContainer($container_geral_tags, $container_geral_css);

		new LoopCuidaCabecalho();
		new LoopCuidaNoticiaPrincipal();

		$this->fechaContainer($container_geral_tags);
	}



}