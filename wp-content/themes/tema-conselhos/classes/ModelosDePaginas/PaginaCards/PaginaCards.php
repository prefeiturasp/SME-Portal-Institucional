<?php

namespace Classes\ModelosDePaginas\PaginaCards;

use Classes\Lib\Util;
use Classes\TemplateHierarchy\ArchiveContato\ExibirContatosTodasPaginas;

class PaginaCards extends Util
{
	protected $page_id;
	protected $args_cards;
	protected $query_cards;

	public function __construct()
	{		
		$this->page_id = get_the_ID();
		$util = new Util($this->page_id);
		$util->montaHtmlLoopPadrao();
		$this->montaUltimaAtualizacao();
		$this->montaQueryCards();
		$this->montaHtmlCards();

	}

	
	public function montaUltimaAtualizacao(){
		$new_query = new \WP_Query( array(
			'posts_per_page' => 1,
			'post_type'      => 'card',
		) );

		while ( $new_query->have_posts() ) : $new_query->the_post();  

		?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 mb-4">
					Atualizado em <time datetime="<?php the_modified_time('Y-m-d'); ?>"><?php the_modified_time('d/m/Y'); ?></time>
				</div>
			</div>
		</div>
		<?php 

		endwhile;  
		wp_reset_postdata();
	}
	
	

	public function montaQueryCards()
	{
		$taxonomia_cards = $this->getCamposPersonalizados('escolha_a_categoria_de_cards_que_deseja_exibir')->slug;

		$this->args_cards = array(
			'post_type' => 'card',
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'categorias-card',
					'field' => 'slug',
					'terms' => $taxonomia_cards,
				),
			),
		);
		$this->query_cards = new \WP_Query($this->args_cards);

	}
	
	public function montaHtmlCards()
	{
		?>
		<div class="container">
					<div class="row">
		<?php
		
		if ($this->query_cards->have_posts()) : while ($this->query_cards->have_posts()) : $this->query_cards->the_post();
			?>		
					<div class="col-sm-3">
						<article class="card-header card-header-card text-white font-weight-bold bg-color-titulo-cards">
							<h2 class="fonte-catorze">
								<a class="text-white stretched-link" href="<?php
										if(get_the_title() == 'COMO PARTICIPAR'){
											echo get_site_url().'/agenda-do-conselho/';
										}else{
											the_permalink();
										}
									?>">
									
									<?= get_the_title() ?>
								</a>
							</h2>
						</article>
						<article class="card-body">
							<div class="card-text">
								<?= get_the_excerpt() ?>
							</div>
						</article>
					</div>  
		<?php
		endwhile;
		endif;
		
		?>
			</div>
		</div> 
		<?php
		wp_reset_postdata();
	}
}