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
		$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$this->args_agendaconselho = array(
			'post_type' => 'agendaconselho',
			'posts_per_page' => 1,
			'paged' => $paged,
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
					echo '<hr>';
					echo '<strong><h2>Agenda Janeiro</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_janeiro') ):
					while ( have_rows('agenda_janeiro') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA JANEIRO-->
				
				<!--AGENDA FEVEREIRO-->
				<?php
				if( have_rows('agenda_fevereiro') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Fevereiro</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_fevereiro') ):
					while ( have_rows('agenda_fevereiro') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA FEVEREIRO-->
				
				<!--AGENDA MARCO-->
				<?php
				if( have_rows('agenda_marco') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Março</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_marco') ):
					while ( have_rows('agenda_marco') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA MARCO-->
				
				<!--AGENDA ABRIL-->
				<?php
				if( have_rows('agenda_abril') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Abril</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_abril') ):
					while ( have_rows('agenda_abril') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA ABRIL-->
				
				<!--AGENDA MAIO-->
				<?php
				if( have_rows('agenda_maio') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Maio</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_maio') ):
					while ( have_rows('agenda_maio') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA MAIO-->
				
				<!--AGENDA JUNHO-->
				<?php
				if( have_rows('agenda_junho') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Junho</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_junho') ):
					while ( have_rows('agenda_junho') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA JUNHO-->
				
				<!--AGENDA JULHO-->
				<?php
				if( have_rows('agenda_julho') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Julho</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_julho') ):
					while ( have_rows('agenda_julho') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA JULHO-->
				
				<!--AGENDA AGOSTO-->
				<?php
				if( have_rows('agenda_agosto') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Agosto</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_agosto') ):
					while ( have_rows('agenda_agosto') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA AGOSTO-->
				
				<!--AGENDA SETEMBRO-->
				<?php
				if( have_rows('agenda_setembro') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Setembro</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_setembro') ):
					while ( have_rows('agenda_setembro') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA SETEMBRO-->
				
				<!--AGENDA OUTUBRO-->
				<?php
				if( have_rows('agenda_outubro') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Outubro</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_outubro') ):
					while ( have_rows('agenda_outubro') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA OUTUBRO-->
				
				<!--AGENDA NOVEMBRO-->
				<?php
				if( have_rows('agenda_novembro') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Novembro</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_novembro') ):
					while ( have_rows('agenda_novembro') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA NOVEMBRO-->
				
				<!--AGENDA DEZEMBRO-->
				<?php
				if( have_rows('agenda_dezembro') ):
					echo '<hr>';
					echo '<strong><h2>Agenda Dezembro</h2></strong>';
				endif;
				?>
				<?php
				if( have_rows('agenda_dezembro') ):
					while ( have_rows('agenda_dezembro') ) : the_row();
						?>
						<p>
						<span class="datahr-agenda"><strong><?php the_sub_field('data-agconselho'); ?>
								<?php
									if(get_sub_field('inicio-agconselho') != ''){
										 echo ' - '.get_sub_field('inicio-agconselho');
									}
								?>
								<?php
									if(get_sub_field('final-agconselho') != '' && get_sub_field('inicio-agconselho') != ''){
										 echo ' às '.get_sub_field('final-agconselho');
									}
								?>
						</strong></span><br>
						<?php
							if(get_sub_field('pauta-agconselho') != ''){
								echo '<strong>Paulta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('local-agconselho') != ''){
								echo '<strong>Local:</strong> '.get_sub_field('local-agconselho').'<br>';
							}
						?>
						<?php
							if(get_sub_field('link-agconselho') != ''){
								echo '<strong>Link:</strong> <a href="'.get_sub_field('link-agconselho').'">'.get_sub_field('link-agconselho').'</a><br>';
							}
						?>
						</p>
						<?php
					endwhile;
				endif;
				?>
				<!--AGENDA DEZEMBRO-->
				
			</div> 
		<?php
		endwhile;
		?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 mb-4">
					<div class="paginacao-atual">
						<?php
							echo paginate_links( array(
								'format'    => 'page/%#%',
								'current' 	=> $this->args_agendaconselho['paged'],
								'total'   	=> $this->query_agendaconselho->max_num_pages,
								'end_size'  => 1,
								'mid_size'  => 2,
								'show_all' => false,
								'prev_next' => true,
								'prev_text' => __('<<'),
								'next_text' => __('>>'),
							) );
						?>
					</div>
				</div>
			</div>
		</div>
		
		<?php
		endif;
		?>
			</div>
		</div> 
		<?php
		wp_reset_postdata();
	}
}