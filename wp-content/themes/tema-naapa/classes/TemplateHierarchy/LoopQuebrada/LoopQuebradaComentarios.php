<?php

namespace Classes\TemplateHierarchy\LoopQuebrada;

class LoopQuebradaComentarios extends LoopQuebrada
{

	public function __construct()
	{
		$this->comentarioDetalheNoticia();
	}

	public function comentarioDetalheNoticia(){
		global $post;
		
		?>
		<div class="container">
			<div class="col-12 mt-4 mb-2 p-0">				
				</div>
                <div class="form-coments">
                    <?php 
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                    ?>
                </div>
			</div>
		</div>
        <?php
        
	}
}