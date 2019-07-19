<?php

namespace Classes\ModelosDePaginas\PaginaOrganograma;


class PaginaOrganogramaSecretario extends PaginaOrganograma
{

	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		// Secretario
		$this->setTaxonomyName(self::SLUG_TAXONOMIA_SECRETARIO);
		$classes_divs_secretario = array('card-deck', 'card shadow-sm border-0 bg-azul-escuro text-white text-center font-weight-bold mt-4 mb-2', 'card-body');
		$classe_p_secretario = 'card-text';
		$this->abreDivs(null, $classes_divs_secretario);
		$this->montaHtmlNameTaxonomy($classe_p_secretario);
		$this->fechaDivs($classes_divs_secretario);
	}

}