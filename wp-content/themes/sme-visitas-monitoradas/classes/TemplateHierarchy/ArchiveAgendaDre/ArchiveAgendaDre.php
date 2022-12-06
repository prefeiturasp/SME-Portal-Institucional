<?php

namespace Classes\TemplateHierarchy\ArchiveAgendaDre;


use Classes\Lib\Util;

class ArchiveAgendaDre extends Util
{

    public $nome;
	public function __construct($nome)
	{
        $this->nome = $nome;
		$this->page_id = get_the_ID();
	    $container_calendario_tags = array('section', 'section');
	    $container_calendario_css = array('container p-0', 'row');
        //$this->nome = $nome;
	    $this->abreContainer($container_calendario_tags, $container_calendario_css);
		$this->montaHtmlCalendario();
		$this->insereDivRecebeData();
		$this->fechaContainer($container_calendario_tags);
        //print_r($this);
	}

	public function montaHtmlCalendario(){        
		?>
		
		<section class="col-lg-12 col-xs-12 <?= $this->page_id; ?>">
			<span class='d-none' id='event-select'><?= $this->page_id; ?></span>
            <!--<div class="container-loading-agenda-secretario">
                <img src="<?/*= STM_URL*/?>/wp-content/uploads/2019/10/loading.gif" alt="Carregando Agenda do Secretário">
            </div>-->
			<section class="calendario-agenda-sec d-block mb-5 border-bottom pb-5"></section>
		</section>


		<?php
	}

	public function insereDivRecebeData(){
		?>
		<section class="col-lg-12 col-xs-12">
			<h2 class="data_agenda mb-4 pb-2 border-bottom">Dia do Evento</h2>
			<section id="mostra_data"></section>
			<!-- Monta a lista ordenada por horário -->
			<section class="agenda-ordenada"></section>
		</section>
		<?php
	}
}