<?php

namespace Classes\ModelosDePaginas\PaginaAbas;


use Classes\Lib\Util;

class PaginaAbas extends Util
{
	protected $page_id;
	protected $deseja_exibir_endereco;
	protected $escolha_o_endereco;
	protected $deseja_exibir_categoria_de_botoes;
	protected $escolha_a_categoria_de_botoes;

	public function __construct()
	{
		$this->page_id = get_the_ID();
		$util = new Util($this->page_id);
		$util->montaHtmlLoopPadrao();
	}

}