<?php

namespace Classes\ModelosDePaginas\PaginaInicial;

//namespace Classes\TemplateHierarchy\ArchiveAgenda;


use Classes\Lib\Util;

class PaginaInicialAgenda extends Util
{

	public function __construct()
	{
		//$this->montaHtmlAgenda();
		$container_calendario_tags = array('section', 'section');
	    $container_calendario_css = array('container mb-5', 'row');
	    $this->abreContainer($container_calendario_tags, $container_calendario_css);
		$this->montaHtmlCalendario();
		$this->insereDivRecebeData();
		$this->fechaContainer($container_calendario_tags);
	}

	public function montaHtmlCalendario(){
		?>
		<script>
			jQuery(document).ready(function ($) {
				//limitar quantidade de registros impressos
			    //pageSize = 2;
				$(".pagination").hide();
				$("#btn-mais-eventos").click(function () {
					window.location.href="<?php echo get_site_url(); ?>/agenda/";
				});
			});
		</script>
		<section class="container mt-5 mb-5 noticias">
            <article class="row mb-4">
                <article class="col-lg-12 col-xs-12">
                    <h2 class="border-bottom">Agenda</h2>
                </article>
            </article>
		</section>
		<section class="col-lg-6 col-xs-12">
			<section class="calendario-agenda-sec d-block mb-4 border-bottom pb-4"></section>
		</section>
		<?php
	}

	public function insereDivRecebeData(){
		?>
		<section class="col-lg-6 col-xs-12 mb-4">
			<h2 class="">Próximos eventos</h2>
			<section id="mostra_data"></section>
			<!-- Monta a lista ordenada por horário -->
			<div  id="style-2" class="overflow-auto"><section class="agenda-ordenada"></section></div>
            <!-- Monta a paginação -->
            <!--<ul class="pagination" id="pagin">
            </ul>-->
			<?php echo '<button id="btn-mais-eventos" class="btn btn-primary btn-sm btn-block bg-azul-escuro font-weight-bold text-white">Busca avançada de eventos</button>'; ?>
		</section>
		<?php
	}


}