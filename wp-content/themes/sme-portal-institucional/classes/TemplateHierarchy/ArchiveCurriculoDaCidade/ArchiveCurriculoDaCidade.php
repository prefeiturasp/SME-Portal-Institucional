<?php

namespace Classes\TemplateHierarchy\ArchiveCurriculoDaCidade;


use Classes\Lib\Util;

class ArchiveCurriculoDaCidade extends Util
{
	const TAXONOMIA = 'categorias-curriculo-da-cidade';
	protected $args_terms;
	protected $terms;
	protected $args_curriculos;
	protected $itens_curriculo;

	public function __construct()
	{
		$this->init();
	}

	public function init(){
		$container_html_tags = array('section');
		$container_html_css = array('container');
		$this->abreContainer($container_html_tags,$container_html_css);
		$this->exibeCabecalho();
		$this->getTermosTaxonomiasCurriculo();
		$this->exibeNomeTaxonomiaCurriculo();
		$this->fechaContainer($container_html_tags);
	}

	public function exibeCabecalho(){
	    ?>
        <article class="row">
            <article class="col-lg-12 col-xs-12">
                <h1 class="mb-5" id="curriculo-da-cidade">Currículo da Cidade</h1>
            </article>
        </article>
        <?php
    }

	public function getTermosTaxonomiasCurriculo(){

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
	}

	public function exibeNomeTaxonomiaCurriculo(){

		foreach ($this->terms as $term){

			echo '<div class="col-12 mb-4">';
			echo '<div class="row shadow-sm">';
			echo '<h2 class="col-12 pt-3 pb-1 pr-0 pl-4"> '.$term->name.'</h2>';
			$this->getCurriculosTaxonomia($term->term_id);
			echo '</div>';
			echo '</div>';

		}
	}

	public function getCurriculosTaxonomia($term_id){

		$this->args_curriculos = array(
			'post_type' => 'curriculo-da-cidade',
			'tax_query' => array(
				array(
					'taxonomy' => self::TAXONOMIA,
					'field' => 'term_id',
					'terms' => $term_id,
				)
			)
		);
		$this->itens_curriculo = get_posts( $this->args_curriculos );
		$this->exibeCurriculosTaxonomia();
	}

	public function exibeCurriculosTaxonomia(){
		foreach ($this->itens_curriculo as $post){
		    $ano_publicacao =  get_field('insira_o_ano_da_publicacao', $post->ID);
			?>
                <div class="col-6 col-md-2">

                    <div class="card border-0 curriculo-da-cidade-item">
                        <?php echo apply_filters('the_content', $post->post_content); ?>
                        <div class="card-body p-0 mt-3">
                            <h4 class="card-title text-left"><?php echo '<p> '.$post->post_title.'</p>'; ?></h4>
                        </div>
                        <div class="card-footer bg-transparent text-left pl-0">
                            <h6><?= $ano_publicacao ?></h6>
                        </div>
                    </div>

                </div>
			<?php
		}
	}
}