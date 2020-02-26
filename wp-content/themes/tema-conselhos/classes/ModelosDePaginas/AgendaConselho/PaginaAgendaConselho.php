<?php

namespace Classes\ModelosDePaginas\AgendaConselho;

use Classes\Lib\Util;

class PaginaAgendaConselho extends Util
{
	protected $page_id;
	protected $args_agendaconselho;
	protected $query_agendaconselho;

	public function __construct()
	{		
		$this->page_id = get_the_ID();
		$util = new Util($this->page_id);
		//$util->montaHtmlLoopPadrao();
		//$this->montaUltimaAtualizacao();
		$this->montaQueryAgendaConselho();
		$this->montaHtmlAgendaConselho();

	}

	
	public function montaUltimaAtualizacaoAgenda(){
		$new_query = new \WP_Query( array(
			'posts_per_page' => 1,
			'post_type'      => 'agendaconselho',
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
	
	

	public function montaQueryAgendaConselho()
	{

		$this->args_agendaconselho = array(
			'post_type' => 'agendaconselho',
			'posts_per_page' => -1,
			//'orderby' => 'menu_order',
			//'order' => 'ASC',
		);
		$this->query_agendaconselho = new \WP_Query($this->args_agendaconselho);

	}
	
	public function montaHtmlAgendaConselho()
	{
		?>
		<div class="container">
					<div class="row">
		<?php
		
		if ($this->query_agendaconselho->have_posts()) : while ($this->query_agendaconselho->have_posts()) : $this->query_agendaconselho->the_post();
			?>		
				<div class="col-sm-12 mb-4">
					<h1 class="mb-4"><?= get_the_title() ?></h1>
					<p class"mb-4"><?= the_content() ?></p>

					<!--AGENDA JANEIRO-->
					<?php
					if( have_rows('agenda_janeiro') ):
						echo '<strong><h2>Agenda Janeiro</h2></strong>';
					endif;
					?>
					<?php
					if( have_rows('agenda_janeiro') ):
						while ( have_rows('agenda_janeiro') ) : the_row();
							?>
								<p>
								<?php the_sub_field('data-agconselho'); ?><br>
								<?php the_sub_field('inicio-agconselho'); ?><br>
								<?php the_sub_field('final-agconselho'); ?><br>
								<?php the_sub_field('pauta-agconselho'); ?><br>
								<?php the_sub_field('local-agconselho'); ?><br>
								<?php the_sub_field('link-agconselho'); ?><br>
								</p>
								<hr>
							<?php
						endwhile;
					endif;
					?>
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