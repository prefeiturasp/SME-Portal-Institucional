<?php

namespace Classes\TemplateHierarchy\LoopAgenda;

use Classes\Lib\Util;

class LoopAgenda extends Util
{

	public function __construct()
	{
		$this->init();
	}

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container', 'row');
		$this->abreContainer($container_geral_tags, $container_geral_css);

		new LoopAgendaPrincipal();
		new LoopAgendaEventos(get_the_ID());

		$this->fechaContainer($container_geral_tags);
	}



}