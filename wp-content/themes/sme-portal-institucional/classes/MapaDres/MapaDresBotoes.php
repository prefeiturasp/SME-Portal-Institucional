<?php

namespace Classes\MapaDres;


class MapaDresBotoes extends MapaDres
{
	const TAXONOMIA = 'categorias-contato';
	private $id_taxonomia_dres;

	public function __construct()
	{
		$this->getBotoesDres();
	}

	public function getIdTaxonomiaDres(){
		$this->id_taxonomia_dres = get_term_by('slug', 'diretorias-regionais-de-educacao-dres', 'categorias-contato');
		return $this->id_taxonomia_dres->term_id;
	}

	public function getBotoesDres(){

		$term_children = get_term_children( $this->getIdTaxonomiaDres(), self::TAXONOMIA );

		foreach ( $term_children as $child ) {
			$term = get_term_by( 'id', $child, self::TAXONOMIA );
			?>
	    	<div id="container-div-dre-<?= $term->slug ?>" class="card-deck justify-content-center">
				<div class="card border-0 btn-block mb-2">
	
					<div class="card-header container-titulo-botoes ">
						<h2 class="mt-2 mb-2 text-center fonte-catorze">
							<a id="dre-<?= $term->slug ?>" class="a-click-botao font-weight-bold text-decoration-none collapsed" data-toggle="collapse" data-target="#div-dre-<?= $term->slug ?>" aria-expanded="false" aria-controls="div-dre-<?= $term->slug ?>" href=""><?= $term->name ?></a>
						</h2>
					</div>
					<div id="div-dre-<?= $term->slug ?>" class="fade collapse dre-atual ">
						<div class="card-body card-body-mapa-dres mb-3 rounded-bottom">

							<?php $this->exibeCamposCadastrados($term->term_id); ?>
	
						</div>
					</div>
	
				</div>
			</div>
		<?php
		}
	}
}