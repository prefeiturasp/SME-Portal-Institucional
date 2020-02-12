<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


use Classes\Lib\Util;

class PaginaInicial extends Util
{
	//protected $array_icone_titulo_icone_id_menu_icone = array();

	// Notícias
	protected $categoria_noticias_home;
	protected $id_noticias_home_principal;
	protected $args_noticas_home_principal;
	protected $query_noticias_home_principal;
	protected $args_noticas_home_secundarias;
	protected $query_noticias_home_secundarias;

	public function __construct()
	{
		$this->page_id = get_the_ID();
		$this->page_slug = get_queried_object()->post_name;
		$util = new Util($this->page_id);
		// Classe Util
		$this->montaHtmlBreadcrumb();
		$util->montaHtmlLoopPadrao();
		
		$this->init();
	}
	
	public function montaHtmlBreadcrumb(){
		?>
			<div class="container">
				<div class="row">
					<nav>
						<ol id="breadcrumb" class="breadcrumb bg-transparent pl-1">
							<li class="item-home breadcrumb-item">
								<a class="bread-link bread-home" href="https://educacao.sme.prefeitura.sp.gov.br">SME Portal Institucional</a>
							</li>
							<li class="separator separator-home">  /  </li>
							<li class="item-home breadcrumb-item">
								<a class="bread-link bread-home" href="https://educacao.sme.prefeitura.sp.gov.br">DREs - Diretorias Regionais de Educação</a>
							</li>
							<li class="separator separator-home">  /  </li>
							<li class="item-current item-archive"><strong class="bread-current bread-archive">Diretoria Regional de Educação Guaianases</strong></li>
						</ol>
					</nav>
				</div>
			</div>
		<?php
	}

	public function init(){
		$this->tituloNoticias();
		
        $noticias_home_tags = array('section','section');
        $noticias_home_css = array('container mt-5 noticias','row');
        $this->abreContainer($noticias_home_tags, $noticias_home_css);
		new PaginaInicialNoticiasDestaquePrimaria();
		new PaginaInicialNoticiasDestaqueSecundarias();
		$this->fechaContainer($noticias_home_tags);
		new PaginaInicialAgenda();
		new PaginaInicialEscolares();
		new PaginaInicialEndereco();
    }

    public function tituloNoticias(){
	    ?>
        <section class="container mb-5 noticias">
            <article class="row mb-4">
                <article class="col-lg-12 col-xs-12">
                    <h2 class="border-bottom">Notícias</h2>
                </article>
            </article>
        </section>
        <?php
    }



}