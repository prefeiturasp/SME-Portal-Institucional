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
		<div class="col-lg-6 col-xs-12">
			<div class="calendario-agenda-sec d-block mb-5 border-bottom pb-5 "></div>
			<div class="fonte-doze mb-5">
				Mais informações:
				Assessoria de Imprensa do Secretário emaildosecretario@sme.prefeitura.sp.gov.br 1234-5678
			</div>
		</div>


		<?php
	}

	public function insereDivRecebeData(){
	    ?>
        <div class="col-lg-6 col-xs-12">
            <h2 class="data_agenda mb-4 pb-2 border-bottom"></h2>
            <div id="mostra_data"></div>
        </div>
        <?php
    }


	public function abreContainerCalendario(){
		?>
		<div class="container mb-5">
			<div class="row">
		<?php
	}

	public function fechaContainerCalendario(){
		?>
			</div>
		</div>
		<?php
	}

}