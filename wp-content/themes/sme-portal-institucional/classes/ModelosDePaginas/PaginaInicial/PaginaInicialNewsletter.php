<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialNewsletter
{
	public function __construct()
	{
		$this->montaHtmlNewsletter();
	}

	public function montaHtmlNewsletter(){
		?>
		<section class="col-12">
			<article class="bg-white shadow-sm text-center p-3 mb-3 mb-xs-4">
				<h2 class="font-weight-bold mb-2">
					<i class="fa fa-envelope text-primary"></i>
					Assine Nossa Newsletter
				</h2>
				<p>
					Receba nossas novidades e fique por dentro de tudo o que acontece na Secretaria Municipal de Educação.
                </p>
				<?= do_shortcode('[contact-form-7 id="18931" title="Newsletter"]'); ?>
			</article>

		</section>

		<?php
	}

}