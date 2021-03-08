<?php


namespace Classes\ModelosDePaginas\PaginaUnidades;

use Classes\TemplateHierarchy\ArchiveContato\ArchiveContato;

class PaginaUnidades extends ArchiveContato
{

    public function __construct()
	{
		$this->init();
	}
    

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container-fluid', 'row');
		$this->abreContainer($container_geral_tags, $container_geral_css);

		//$this->getTituloPagina();
        
        $this->htmlMapaUnidades();        
	}

	public function getTituloPagina(){
		echo '<article class="col-12">';
	        echo '<h1 class="mb-4" id="'.get_queried_object()->post_name.'">'.get_the_title().'</h1>';
		echo '</article>';
    }


	public function htmlMapaUnidades(){
		?>

		<section class="col-12 p-0">            
            <?php new PaginaUnidadesMapa(); ?>
		</section>

		<?php
    }
}