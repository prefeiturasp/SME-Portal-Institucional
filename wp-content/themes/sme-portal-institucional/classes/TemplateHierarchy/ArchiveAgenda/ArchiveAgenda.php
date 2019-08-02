<?php

namespace Classes\TemplateHierarchy\ArchiveAgenda;


use Classes\Lib\Util;

class ArchiveAgenda extends Util
{

	public function __construct()
	{
	    $container_calendario_tags = array('section', 'section');
	    $container_calendario_css = array('container mb-5', 'row');
	    $this->abreContainer($container_calendario_tags, $container_calendario_css);
		$this->montaHtmlCalendario();
		$this->insereDivRecebeData();
		$this->fechaContainer($container_calendario_tags);
	}

	public function montaHtmlCalendario(){
		?>
		<section class="col-lg-6 col-xs-12">
			<h1 class="mb-5" id="agenda-do-secretario-de-educacao">Agenda do Secretário de Educação</h1>
			<section class="calendario-agenda-sec d-block mb-5 border-bottom pb-5 "></section>
			<article class="fonte-doze mb-5">
				Mais informações:
				Assessoria de Imprensa do Secretário emaildosecretario@sme.prefeitura.sp.gov.br 1234-5678
			</article>
		</section>


		<?php
	}

	public function insereDivRecebeData(){
		?>
		<section class="col-lg-6 col-xs-12">
			<h2 class="data_agenda mb-4 pb-2 border-bottom"></h2>
			<section id="mostra_data"></section>
		</section>
		<?php
	}
}