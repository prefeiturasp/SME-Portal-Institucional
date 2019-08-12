<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialFacebook
{

	public function __construct()
	{
		$this->montaHtmlFacebook();
	}

	public function montaHtmlFacebook(){
		?>
		<article class="col-12">
            <div class="embed-responsive embed-responsive-21by9">
                <iframe class="embed-responsive-item" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FEducaPrefSP%2F&width=500&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1629372850659932" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
            </div>
		</article>
		<?php
	}

}