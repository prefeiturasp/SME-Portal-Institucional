<?php

namespace Classes\TemplateHierarchy;


use Classes\Lib\Util;

class Page extends Util
{
	protected $page_id;

	public function __construct()
	{
		$this->page_id = get_the_ID();
		$util = new Util($this->page_id);
		$this->montaHtmlLoopPadrao();
	}

}