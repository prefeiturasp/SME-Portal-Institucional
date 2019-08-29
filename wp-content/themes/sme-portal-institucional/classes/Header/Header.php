<?php

namespace Classes\Header;


class Header
{
	private $queried_object;
	private $slug_titulo;

	public function __construct()
	{
		$this->queried_object =  get_queried_object();
	}

	public function getSlugTitulo(){
		global $wp_query;
		if (is_archive()) {
			$this->slug_titulo = $this->queried_object->query_var;
		}elseif ($wp_query->get('custom_page') == 'busca-de-escolas'){
			$this->slug_titulo = 'busca-de-escolas';
		}elseif (is_tax()){

			$this->slug_titulo = 'busca-de-escolas';
		}else{
			$this->slug_titulo = $this->queried_object->post_name;
		}

		return $this->slug_titulo;

	}

}