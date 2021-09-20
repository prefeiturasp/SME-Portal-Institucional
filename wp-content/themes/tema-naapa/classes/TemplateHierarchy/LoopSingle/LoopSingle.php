<?php

namespace Classes\TemplateHierarchy\LoopSingle;

use Classes\Lib\Util;

class LoopSingle extends Util
{

	public function __construct()
	{
		$this->init();
	}

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container-fluid single-cuida single-liga', 'row');
		$this->abreContainer($container_geral_tags, $container_geral_css);

		new LoopSingleCabecalho();
		new LoopSingleNoticiaPrincipal();

		$this->fechaContainer($container_geral_tags);
	}



}