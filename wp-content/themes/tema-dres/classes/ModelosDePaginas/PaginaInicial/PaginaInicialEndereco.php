<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialEndereco
{

	public function __construct()
	{
		$this->montaHtmlEndereco();
	}

	public function montaHtmlEndereco(){
		?>
		<section class="container mt-5 mb-5 noticias">
            <article class="row mb-4">
                <article class="col-lg-12 col-xs-12">
                    <h2 class="border-bottom">Endereços e responsáveis</h2>
                </article>
            </article>
		</section>
		<section class="container mt-5 mb-5">
            <article class="row mb-4">
                <article style="padding-right: 40px;" class="col-lg-8 col-xs-8">
                    
					
					

				AQUI LOOP CONTATOS PRINCIPAIS
					
					
					
				<button class="btn btn-primary btn-sm btn-block bg-azul-escuro font-weight-bold text-white">Outros Contatos</button>
                </article>
				<article  class="col-lg-4 col-xs-4">
					<p><img src="//geo0.ggpht.com/cbk?panoid=2HwY-Isz1zqUPDghXI3sww&output=thumbnail&cb_client=maps_sv.tactile.gps&thumb=2&w=450&h=300&yaw=124.77337&pitch=0&thumbfov=100"></p>
					<p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14630.514230655346!2d-46.41574905486125!3d-23.54585848657684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce644c97569a6d%3A0x1be5d2a9ee3fd810!2sR.%20Agapito%20Maluf%2C%2058%20-%20Vila%20Princesa%20Isabel%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2008410-131!5e0!3m2!1spt-BR!2sbr!4v1579892040432!5m2!1spt-BR!2sbr" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe></p>
                </article>
            </article>
		</section>
		<?php
	}

}