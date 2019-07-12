<?php

namespace Classes\ModelosDePaginas\PaginaLayoutColunas;


use Classes\Lib\Util;

class PaginaLayoutColunas extends Util
{
	protected $page_id;
	protected $escolha_a_quantidade_de_colunas_nesta_pagina;
	protected $insira_o_conteudo_para_uma_coluna;
	protected $insira_o_conteudo_da_primeira_coluna_duas_colunas;
	protected $insira_o_conteudo_da_segunda_coluna_duas_colunas;
	protected $insira_o_conteudo_da_primeira_coluna_tres_colunas;
	protected $insira_o_conteudo_da_segunda_coluna_tres_colunas;
	protected $insira_o_conteudo_da_terceira_coluna_tres_colunas;

	public function __construct()
	{


		$this->page_id = get_the_ID();
		$util = new Util($this->page_id);
		$util->montaHtmlLoopPadrao();

		$this->abreContainer();

		$this->getConteudoColunas();

		$this->fechaContainer();
	}

	public function abreContainer(){
		echo '<div class="container">';
		echo '<div class="row">';
	}

	public function fechaContainer(){
		echo '</div>';
		echo '</div>';
	}



	public function getConteudoColunas(){

		$this->escolha_a_quantidade_de_colunas_nesta_pagina = $this->getCamposPersonalizados('escolha_a_quantidade_de_colunas_nesta_pagina');
		
 		if ($this->escolha_a_quantidade_de_colunas_nesta_pagina == 'uma'){
 			$this->insira_o_conteudo_para_uma_coluna = $this->getCamposPersonalizados('insira_o_conteudo_para_uma_coluna');

 			$this->montaHtmlUmaColuna();

		}elseif ($this->escolha_a_quantidade_de_colunas_nesta_pagina == 'duas'){
 			$this->insira_o_conteudo_da_primeira_coluna_duas_colunas =  $this->getCamposPersonalizados('insira_o_conteudo_da_primeira_coluna_duas_colunas');
 			$this->insira_o_conteudo_da_segunda_coluna_duas_colunas =  $this->getCamposPersonalizados('insira_o_conteudo_da_segunda_coluna_duas_colunas');

			$this->montaHtmlDuasColunas();

		}elseif ($this->escolha_a_quantidade_de_colunas_nesta_pagina == 'tres'){
			$this->insira_o_conteudo_da_primeira_coluna_tres_colunas =  $this->getCamposPersonalizados('insira_o_conteudo_da_primeira_coluna_tres_colunas');
			$this->insira_o_conteudo_da_segunda_coluna_tres_colunas =  $this->getCamposPersonalizados('insira_o_conteudo_da_segunda_coluna_tres_colunas');
			$this->insira_o_conteudo_da_terceira_coluna_tres_colunas =  $this->getCamposPersonalizados('insira_o_conteudo_da_terceira_coluna_tres_colunas');

			$this->montaHtmlTresColunas();
		}
	}

	public function montaHtmlUmaColuna(){
		echo '<div class="col-12 col-md-12 col-lg-8 col-xl-8">';
		echo $this->insira_o_conteudo_para_uma_coluna;
		echo '</div>';

	}
	public function montaHtmlDuasColunas(){
		echo '<div class="col-12 col-md-12 col-lg-5 col-xl-5">';
		echo $this->insira_o_conteudo_da_primeira_coluna_duas_colunas;
		echo '</div>';

		echo '<div class="col-12 col-md-12 col-lg-5 col-xl-5">';
		echo $this->insira_o_conteudo_da_segunda_coluna_duas_colunas;
		echo '</div>';

	}
	public function montaHtmlTresColunas(){

		echo '<div class="col-12 col-md-12 col-lg-4 col-xl-4">';
		echo $this->insira_o_conteudo_da_primeira_coluna_tres_colunas;
		echo '</div>';

		echo '<div class="col-12 col-md-12 col-lg-4 col-xl-4">';
		echo $this->insira_o_conteudo_da_segunda_coluna_tres_colunas;
		echo '</div>';

		echo '<div class="col-12 col-md-12 col-lg-4 col-xl-4">';
		echo $this->insira_o_conteudo_da_terceira_coluna_tres_colunas;
		echo '</div>';

	}

}