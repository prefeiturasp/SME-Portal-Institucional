<?php

namespace Classes\ModelosDePaginas\PaginaAbas;


class PaginaAbaTitulos extends PaginaAbas
{

	public function __construct()
	{
		parent::__construct();
		$this->getTituloAbas();
	}

	public function getTituloAbas(){
		$titulos_abas_tags = array('section', 'article', 'ul');
		$titulos_abas_css = array('row', 'col-lg-12 col-sm-12 mb-5 pl-0 pr-0', 'nav nav-tabs nav-fill border-0 w-100 fonte-doze coordenadorias-tabs');
		$this->abreContainer($titulos_abas_tags, $titulos_abas_css);

		foreach ($this->getQueryAbas() as $index => $aba){
			echo '<li class="nav-item text-center">';
			if ($index == 0){
				$css_active = 'active';
				$aria_selected = 'true';
			}else{
				$css_active = '';
				$aria_selected = 'false';
			}
			echo '<a class="'.$css_active.' nav-link border d-flex align-items-center text-dark" id="tab_'.$aba->ID.'" data-toggle="tab" href="#id_'.$aba->ID.'" role="tab" aria-controls="id_'.$aba->ID.'" aria-selected="'.$aria_selected.'">';
			echo $aba->post_title;
			echo '</a>';
			echo '</li>';
		}
		$this->fechaContainer($titulos_abas_tags);
	}
}