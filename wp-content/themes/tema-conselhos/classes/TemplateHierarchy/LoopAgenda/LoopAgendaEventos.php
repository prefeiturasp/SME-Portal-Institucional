<?php

namespace Classes\TemplateHierarchy\LoopAgenda;


class LoopAgendaEventos extends LoopAgenda
{
	private $id_post_atual;	

	public function __construct($id_post_atual)
	{
		$this->id_post_atual = $id_post_atual;
		$this->init();
	}

	public function init(){
		$this->montaHtmlRelacionadas();
	}	

	public function montaHtmlRelacionadas(){

		$container_mais_noticias_tags = array('section');
		$container_mais_noticias_css = array('col-lg-12 col-sm-12 mb-4');
		$this->abreContainer($container_mais_noticias_tags, $container_mais_noticias_css);
		
			// <!--AGENDA JANEIRO-->
				if( have_rows('agenda_janeiro', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Janeiro</h2></strong>';
				endif;
				
				if( have_rows('agenda_janeiro', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA JANEIRO-->

			// <!--AGENDA FEVEREIRO-->
				if( have_rows('agenda_fevereiro', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Fevereiro</h2></strong>';
				endif;
				
				if( have_rows('agenda_fevereiro', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA FEVEREIRO-->

			// <!--AGENDA MARCO-->
				if( have_rows('agenda_marco', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Março</h2></strong>';
				endif;
				
				if( have_rows('agenda_marco', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA MARCO-->

			// <!--AGENDA ABRIL-->
				if( have_rows('agenda_abril', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Abril</h2></strong>';
				endif;
				
				if( have_rows('agenda_abril', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA ABRIL-->

			// <!--AGENDA MAIO-->
				if( have_rows('agenda_maio', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Maio</h2></strong>';
				endif;
				
				if( have_rows('agenda_maio', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA MAIO-->

			// <!--AGENDA JUNHO-->
				if( have_rows('agenda_junho', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Junho</h2></strong>';
				endif;
				
				if( have_rows('agenda_junho', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA JUNHO-->

			// <!--AGENDA JULHO-->
				if( have_rows('agenda_julho', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Julho</h2></strong>';
				endif;
				
				if( have_rows('agenda_julho', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA JULHO-->

			// <!--AGENDA AGOSTO-->
				if( have_rows('agenda_agosto', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Agosto</h2></strong>';
				endif;
				
				if( have_rows('agenda_agosto', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA AGOSTO-->

			// <!--AGENDA SETEMBRO-->
				if( have_rows('agenda_setembro', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Setembro</h2></strong>';
				endif;
				
				if( have_rows('agenda_setembro', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA SETEMBRO-->

			// <!--AGENDA OUTUBRO-->
				if( have_rows('agenda_outubro', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Outubro</h2></strong>';
				endif;
				
				if( have_rows('agenda_outubro', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA OUTUBRO-->

			// <!--AGENDA NOVEMBRO-->
				if( have_rows('agenda_novembro', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Novembro</h2></strong>';
				endif;
				
				if( have_rows('agenda_novembro', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA NOVEMBRO-->

			// <!--AGENDA DEZEMBRO-->
				if( have_rows('agenda_dezembro', $this->id_post_atual) ):
					echo '<hr>';
					echo '<strong><h2>Agenda Dezembro</h2></strong>';
				endif;
				
				if( have_rows('agenda_dezembro', $this->id_post_atual) ):
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
								echo '<strong>Pauta/Assunto:</strong> '.get_sub_field('pauta-agconselho').'<br>';
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
			// <!--AGENDA DEZEMBRO-->

		$this->fechaContainer($container_mais_noticias_tags);

	}

}