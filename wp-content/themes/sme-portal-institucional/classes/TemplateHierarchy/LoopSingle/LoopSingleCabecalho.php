<?php

namespace Classes\TemplateHierarchy\LoopSingle;


use Classes\TemplateHierarchy\Search\SearchSingle;

class LoopSingleCabecalho extends LoopSingle
{

	public function __construct()
	{
		$this->cabecalhoDetalheNoticia();
	}

	public function cabecalhoDetalheNoticia(){
		?>
		<div class="col-lg-6 col-sm-6 d-flex justify-content-lg-start justify-content-center">
			<h2 class="titulos_internas mb-lg-5">Notícias</h2>
		</div>
		<div class="col-lg-6 col-sm-6 d-flex justify-content-lg-end justify-content-center">
			<input type="text" class="form-control w-auto mb-lg-0 mb-4" />
		</div>
		<?php
	}

}