<?php

namespace Classes\ModelosDePaginas\PaginaAgendaSecretario;


use Classes\Lib\Util;

class PaginaAgendaSecretario extends Util
{
	protected $page_id;


	public function __construct()
	{
		$this->page_id = get_the_ID();
		$util = new Util($this->page_id);
		$util->montaHtmlLoopPadrao();

		$this->abreContainerCalendario();
		$this->montaHtmlCalendario();
		$this->insereDivRecebeData();
		$this->fechaContainerCalendario();
	}

	public function montaHtmlCalendario(){
		?>
		<section class="col-lg-6 col-xs-12">
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


	public function abreContainerCalendario(){
		?>
		<section class="container mb-5">
			<section class="row">
		<?php
	}

	public function fechaContainerCalendario(){
		?>
			</section>
		</section>
		<?php
	}

}