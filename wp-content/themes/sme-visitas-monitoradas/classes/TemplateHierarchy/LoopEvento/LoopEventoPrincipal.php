<?php
namespace Classes\TemplateHierarchy\LoopEvento;
class LoopEventoPrincipal extends LoopEvento
{
	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		$this->montaHtmlEventoPrincipal();
	}
	public function montaHtmlEventoPrincipal(){
		if (have_posts()):
			while (have_posts()): the_post();
			?>
				<div class="row m-0">
					<div class="event-content col-md-5 my-4">
						<h2>Sobre este evento</h2>
						<?= get_the_content(); ?>
						<a href="#" class="btn visitas-btn mt-4">Fazer inscrição</a>
					</div>
				</div>				
			<?php
			endwhile;
		endif;
		wp_reset_query();
	}	
}