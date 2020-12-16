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
		//$this->init();
		$this->my_related_posts();
	}

	

	public function getComplementosRelacionadas($id_post){
		$dt_post = get_the_date('d/m/Y g\hi');
		$categoria = get_the_category($id_post)[0]->name;

		return '<p class="fonte-doze font-italic mb-0">Publicado em: '.$dt_post.' - em '.$categoria.'</p>';


	}
	
	public function my_related_posts() {
		$paged = ( get_query_var( 'page' ) ) ?  get_query_var( 'page' ) : 1;
		$args = array(
			'posts_per_page' => 5,
			'post_in' => get_the_tag_list(),
			'paged' => $paged
		);
		
		$the_query = new \WP_Query( $args );
		echo '<div class="container">';
		echo '<div class="row mt-4">';
		echo '<div class="col-sm-8"><h2>Relacionadas</h2>';
		echo '<div class="row">';
		while ( $the_query->have_posts() ) : $the_query->the_post();
		?>
			
			<div class="col-sm-4 mb-4">
				<img class="rounded " src="<?php the_post_thumbnail_url( 'related-post' ); ?>" width="100%">			
			</div>
			<div class="col-sm-8 mb-4">
				<h3 class="fonte-dezoito font-weight-bold mb-2">
					<a class="text-decoration-none text-dark" href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<?php
				//echo $this->getSubtitulo($query->ID, 'p', 'fonte-dezesseis mb-2')
				?>
				<?php
					if(get_field('insira_o_subtitulo', $query->ID) != ''){
						the_field('insira_o_subtitulo', $query->ID);
					}else if (get_field('insira_o_subtitulo', $query->ID) == ''){
						 echo get_the_excerpt($query->ID); 
					}
				?>
				<?= $this->getComplementosRelacionadas($query->ID); ?>
				
			</div>
			
		<?php
		endwhile;
			
		echo '</div></div></div></div>';
		
		wp_reset_postdata();
		
		?>
		<div class="paginacao-atual">
			<?php
			echo paginate_links( array(
				'base' => @add_query_arg('page','%#%'),
				'current' => $paged,
				'total'   => $the_query->max_num_pages,
				'end_size'  => 1,
				'mid_size'  => 2,
				'show_all' => false,
				'prev_next' => true,
				'prev_text' => __('<<'),
				'next_text' => __('>>'),
			) );
			?>
		</div>
		<?php
		
		//paginacao2($the_query);
	}
	

}