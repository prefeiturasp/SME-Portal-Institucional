<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialEscolares
{

	public function __construct()
	{
		$this->montaHtmlEscolares();
	}

	public function montaHtmlEscolares(){
		?>
		<script>
			jQuery(document).ready(function ($) {
				//////////////Conta a Qt de Ceus e imprime//////////////////////
				var el = document.getElementById('cont-ceus');
				lines = el.innerHTML.replace(/ |^\s+|\s+$/g,'').split('\n'),
				lineCount = lines.length;
				document.getElementById('cont_ceus').innerHTML = lineCount;
				//alert(lineCount); 
				//////////////Conta a Qt de Ceus e imprime//////////////////////
			});
		</script>
		<container>
		<section class="container mt-5 mb-5 noticias">
            <article class="row mb-4">
                <article class="col-lg-12 col-xs-12">
                    <h2 class="border-bottom">Unidades Escolares e CEUs</h2>
                </article>
            </article>
		</section>
		<section class="container mt-5 mb-5">
            <article class="row mb-4">
                <article style="padding-right: 40px;" class="col-lg-8 col-xs-8">
                    <p>Os <strong>Centros Educacionais Unificados</strong> da DRE Guainases falam alguma coisa, o que podemos falar sobre eles? Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. No box ao lado você encontra os links para a página de cada CEU.</p>
					<p>Qual pode ser a introdução sobre as <strong>Unidades Escolares</strong> e o Escola Aberta? Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <a href="#"><strong>Escola Aberta</strong></a> tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                </article>
				<article style="border: solid 1px #ddd; margin-left: -15px; border-radius: 3px; padding: 20px 10px 2px 20px;" class="col-lg-4 col-xs-4">
                    <p>A Diretoria Regional de Educação de Guaianases possui <span id="cont_ceus"></span> Centros Educacionais Unificados (CEU):</p>
					<div id="cont-ceus">
						<strong>CEU Água Azul</strong><br>
						<strong>CEU Jambeiro</strong><br>
						<strong>CEU Inácio Monteiro</strong><br>
						<strong>CEU Lajeado</strong><br>
						
					</div>
					<p><a href="#"><strong>Ir para a página dos CEUs - link externo</strong></a></p>
                </article>
            </article>
		</section>
		</container>

		<?php
	}

}