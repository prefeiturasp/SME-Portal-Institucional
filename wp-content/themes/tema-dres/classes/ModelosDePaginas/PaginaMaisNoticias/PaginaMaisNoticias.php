<?php

namespace Classes\ModelosDePaginas\PaginaMaisNoticias;

use Classes\Lib\Util;

class PaginaMaisNoticias extends Util
{

	public function __construct()
	{

	}

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container', 'row');
		$this->abreContainer($container_geral_tags, $container_geral_css);
			new PaginaMaisNoticiasTitulo();
		$this->fechaContainer($container_geral_tags);
		?>
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<?php
						new PaginaMaisNoticiasDestaques();
					?>
				</div>
				<div class="col-sm-4 mb-4">
					<span class="filtro-busca mb-4">
                <div class="form-group border-filtro">
                    <label for="usr"><strong><h2>Refine a sua busca</h2></strong></label>
                </div>
                <div class="form-group">
                    <label for="usr"><strong>Filtre por um termo</strong></label>
                    <input class ='form-control' type = 'text' placeholder = 'Buscar'>
                </div>
                <div class="form-group">
                    <label for="sel1"><strong>Filtre por tipo de conteúdo</strong></label>
                    <select class="form-control" onchange="location = this.value;" id="sel1">
                        <option value="">Todos os períodos</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel2"><strong>Filtre por um período</strong></label>
                    <select class="form-control" <!--onchange="location = this.value;"--> id="sel2">
                        <option value="">Todos os períodos</option>
                        <option value="">Últimas 24 horas</option>
                        <option value="">Última semana</option>
                        <option value="">Último mês</option>
                        <option value="">Último ano</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel2"><strong>Filtre por setores</strong></label>
                    <select class="form-control" <!--onchange="location = this.value;"--> id="sel2">
                        <option value="">Todos os períodos</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-sm float-right">Refinar busca</button>
                </div>
            </span>
					<?php new PaginaMaisNoticiasMaisLidas(); ?>
				</div>
			</div>
		</div>
		<?php
		

		//new PaginaMaisNoticiasProgramasProjetos();

		$container_outras_noticias_e_newsletter_tags = array('section', 'section');
		$container_outras_noticias_e_newsletter_css = array('container', 'row');
		$this->abreContainer($container_outras_noticias_e_newsletter_tags, $container_outras_noticias_e_newsletter_css);

		//new PaginaMaisNoticiasOutrasNoticias();
		//new PaginaMaisNoticiasNewsletter();

		$this->fechaContainer($container_outras_noticias_e_newsletter_tags);


	}

}