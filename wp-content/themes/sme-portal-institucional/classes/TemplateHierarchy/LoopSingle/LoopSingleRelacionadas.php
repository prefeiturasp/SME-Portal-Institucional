<?php

namespace Classes\TemplateHierarchy\LoopSingle;


class LoopSingleRelacionadas extends LoopSingle
{
	private $id_post_atual;
	protected $args_relacionadas;
	protected $query_relacionadas;

	public function __construct($id_post_atual)
	{
		$this->id_post_atual = $id_post_atual;
		$this->init();
	}

	public function init(){
		$this->getQueryRelacionadas();
		$this->montaHtmlRelacionadas();

	}

	public function getQueryRelacionadas(){
		$categories = get_the_category($this->id_post_atual);

		if ($categories) {
			$category_ids = array();
			foreach ($categories as $individual_category) {
				$category_ids[] = $individual_category->term_id;
			}
		}

			$this->args_relacionadas = array(
                'category__in' => $category_ids,
                'posts_per_page' => 5,
                'caller_get_posts'=>1,
				'orderby'        => 'rand',
                'exclude'=> $this->id_post_atual,
                'post_in'  => get_the_tag_list($this->id_post_atual)
		);
		$this->query_relacionadas = get_posts($this->args_relacionadas);
	}

	public function montaHtmlRelacionadas(){

		$container_mais_noticias_tags = array('section','section');
		$container_mais_noticias_css = array('row','col-lg-8 col-sm-12 mt-5');
		$this->abreContainer($container_mais_noticias_tags, $container_mais_noticias_css);
		echo '<h3 class="fonte-vintequatro mb-4 pb-2 font-weight-bold">RELACIONADAS</h3>';

		foreach ($this->query_relacionadas as $query){
			?>
			<div class="row mb-5">
				<div class="col-lg-12">
					<?php
					$thumb = get_the_post_thumbnail_url($query->ID);
					if ($thumb){
						echo '<figure class=" m-0">';
						echo '<img src="'.$thumb.'" class="img-fluid rounded float-left mr-4 w-25" alt="'.$query->post_title.'"/>';
						echo '</figure>';
					}
					?>
					<h4 class="fonte-dezoito font-weight-bold mb-2">
						<a class="text-decoration-none text-dark" href="<?= $query->guid ?>">
							<?= $query->post_title ?>
						</a>
					</h4>
					<p class="fonte-dezesseis mb-2">
						<?= $query->post_excerpt ?>
					</p>
					<?= $this->getComplementosRelacionadas($query->ID); ?>
				</div>
			</div>
			<?php
		}

		$this->fechaContainer($container_mais_noticias_tags);

	}

	public function getComplementosRelacionadas($id_post){
		$dt_post = get_the_date('d/m/Y g\hi');
		$categoria = get_the_category($id_post)[0]->name;

		return '<p class="fonte-doze font-italic mb-0">Publicado em: '.$dt_post.' - em '.$categoria.'</p>';


	}

}