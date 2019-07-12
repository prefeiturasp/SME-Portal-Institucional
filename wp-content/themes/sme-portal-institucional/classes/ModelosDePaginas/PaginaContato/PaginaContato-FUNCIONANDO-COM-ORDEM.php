<?php


namespace Classes\ModelosDePaginas\PaginaContato;


class PaginaContato
{

	const TAXONOMIA = 'categorias-contato';
	protected $args_terms;
	protected $terms;

	public function __construct()
	{
		$this->getTermosTaxonomiasContato();


	}

	public function getTermosTaxonomiasContato(){

		$this->args_terms = array(
			'orderby'           => 'meta_value_num',
			'order'             => 'ASC',
			'hide_empty'        => false,
			'exclude'           => array(),
			'exclude_tree'      => array(),
			'include'           => array(),
			'number'            => '',
			'fields'            => 'all',
			'slug'              => '',
			'parent'            => '',
			'hierarchical'      => true,
			'child_of'          => 0,
			'childless'         => false,
			'get'               => '',
			'name__like'        => '',
			'description__like' => '',
			'pad_counts'        => false,
			'offset'            => '',
			'search'            => '',
			'cache_domain'      => 'core'

		);

		$this->terms = get_terms(self::TAXONOMIA, $this->args_terms);


		for ($i = 1; $i <= 10; $i++) {
			$this->getDadosTaxonomiasContato($i);
		}
	}





	public function getDadosTaxonomiasContato($nivel){

		$novo_array = array();

		foreach ($this->terms as $term){
			$campo_contato_nivel = get_post_meta($term->term_id, 'campo_contato_nivel', true);
			$novo_array[] = ['termo_id' => $term->term_id, 'termo_nome' =>$term->name,  'ordenacao' => $campo_contato_nivel ];
		}

		echo '<pre>';
		//var_dump($novo_array);
		echo '</pre>';

		foreach ($novo_array as $array){

			if ($array['ordenacao'] == $nivel) {
				$this->exibeCamposCadastrados($array['termo_id'], $array['termo_nome'], true);
				$this->getContatosTaxonomia($array['termo_id']);
			}
		}
	}


	public function getContatosTaxonomia($term_id){

		$args = array(
			'post_type' => 'contato',
			'tax_query' => array(
				array(
					'taxonomy' => 'categorias-contato',
					'field' => 'term_id',
					'terms' => $term_id,
				)
			)
		);

		$posts_array = get_posts( $args );

		foreach ($posts_array as $cpt){
			$this->exibeCamposCadastrados($cpt->ID, $cpt->post_title);
		}
	}

	public function exibeCamposCadastrados($term_id, $term_name, $nivel_superior=null){

		$campo_contato = get_post_meta($term_id, 'campo_contato', true);



		echo '<div class="container">';
		echo '<div class="col-6">';

		echo $this->montaTituloCamposCadastrados($term_name, $nivel_superior);



		$array_tipo_de_campo=[];
		$array_valor_do_campo=[];

		if ($campo_contato) {

			foreach ($campo_contato as $index => $valor) {
				if ($index == 'tipo') {
					foreach ($valor as $tipo) {
						$array_tipo_de_campo[] = $tipo;
					}
				}
				if ($index == 'valor') {
					foreach ($valor as $v) {
						$array_valor_do_campo[] = $v;
					}
				}
			}
		}

		foreach($array_tipo_de_campo as $key => $value) {
			$data[] = array('tipo' => $value, 'valor' => $array_valor_do_campo[$key]);
		}

		if ($data) {

			foreach ($data as $d) {
				if ($d['tipo'] == 'email'){
					echo '<p>'.$this->getNomeTipoCampo($d['tipo']).'<a href="mailto: '.esc_attr($d['valor']).'">'.esc_attr($d['valor']).'</a></p>';
				}else{
					echo '<p>'.$this->getNomeTipoCampo($d['tipo']).esc_attr($d['valor']).'</p>';
				}

			}
		}

		echo '</div>'; // col-6
		echo '</div>'; // container
	}

	public function montaTituloCamposCadastrados($term_name, $nivel_superior=null){
		if ($nivel_superior) {
			return '<h4 class="titulo-nivel-superior">' . $term_name . '</h4>';
		}else{
			return '<h4 class="titulo-nivel-nao-superior">' . $term_name . '</h4>';
		}
	}

	public function getNomeTipoCampo($tipo_de_campo){
		switch ($tipo_de_campo) {
			case 'text':
				return '';
			//break;
		}
		switch ($tipo_de_campo) {
			case 'tel':
				return '<span>Telefone: </span>';
			//break;
		}

		switch ($tipo_de_campo) {
			case 'email':
				return '<span>Email: </span>';
			//break;
		}

	}

	public function teste(){

		$args = array(
			'taxonomy' =>  'categorias-contato',
			'orderby' =>  'meta_value_num',
			'order' =>  'ASC',
			'hide_empty' =>  false,
			'hierarchical' =>  false,
			'parent' =>  0,
			'meta_query' => array(
				'key' => 'escolha_o_nivel_desta_categoria_de_contato',
				'type' => 'NUMERIC',
			),
		);

		$terms = get_terms( $args );

		echo '<pre>';
		var_dump($terms);
		echo '</pre>';

	}

}