<?php

namespace Classes\TemplateHierarchy;

use Classes\Lib\Util;

class LoopSingleAgendaConselho extends Util
{
	public function __construct()
	{
		$util = new Util($this->page_id);
		$util->montaHtmlLoopPadraoAgendaConselho();

	}

}