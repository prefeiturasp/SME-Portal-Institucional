<?php

namespace Classes\TemplateHierarchy\LoopCuida;

use Classes\TemplateHierarchy\Search\SearchFormSingle;

class LoopCuidaCabecalho extends LoopCuida
{

	public function __construct()
	{
		$this->cabecalhoDetalheNoticia();
	}

	public function cabecalhoDetalheNoticia(){
		global $post;
		
		?>
		<div class="container">
			<div class="col-12 mt-4 mb-2 p-0">
				<div class="title-special d-flex align-items-center justify-content-between">
					<h2 class="text-left tx_fx_#000000" style="color: #000000; border-color: #cf443c">PARA QUEM CUIDA</h2>
				</div>
			</div>
		</div>
        <?php
        
	}
}