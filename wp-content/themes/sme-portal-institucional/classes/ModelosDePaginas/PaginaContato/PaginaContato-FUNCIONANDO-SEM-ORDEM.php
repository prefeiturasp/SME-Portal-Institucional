<?php


namespace Classes\ModelosDePaginas\PaginaContato;


class PaginaContato
{
	public function __construct()
	{
		$this->getTaxonomiasContato();
	}

	public function getTaxonomiasContato(){

		$taxonomia = array(
			'caterorias-contato',
		);

		$args = array(
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

		$terms = get_terms($taxonomia, $args);

		foreach ($terms as $term){
			$this->exibeCamposCadastrados($term->term_id, $term->name, true);
			$this->getContatosTaxonomia($term->term_id);
		}

		/*$taxonomia = array(
			'caterorias-contato',
		);

		$args=array(
			'order'             => 'ASC',
			'hide_empty'        => false,
		);

		$terms = get_terms($taxonomia, $args);

		$my_new_array = array();
		foreach ( $terms as $term ) {
			$issue_date = get_post_meta($term->term_id, 'campo_contato_nivel', true);
			$my_new_array[$issue_date] = array(
				$term->name,
				$term->slug,
				$term->term_id,
			);
		}

		echo '<pre>';
		var_dump($my_new_array);
		echo '</pre>';

		ksort( $my_new_array, SORT_NUMERIC );

		foreach ( $my_new_array as $issue_date => $term_name ) {
			echo "<li>" . $term_name . " | " . $issue_date . "</li>";
		}*/

	}


	public function getContatosTaxonomia($term_id){

		$args = array(
			'post_type' => 'contato',
			'tax_query' => array(
				array(
					'taxonomy' => 'caterorias-contato',
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

		echo '<div class="container">';
		echo '<div class="col-6">';

		echo $this->montaTituloCamposCadastrados($term_name, $nivel_superior);

		$campo_contato = get_post_meta($term_id, 'campo_contato', true);
		$campo_contato_nivel = get_post_meta($term_id, 'campo_contato_nivel', true);

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

}