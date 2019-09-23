<?php

namespace Classes\TemplateHierarchy\ArchiveAgenda;


use Classes\Lib\Util;

class ArchiveAgendaAjaxCalendario extends Util
{

    public function __construct()
	{
		$this->page_id = get_the_ID();
	}

	public function montaHtmlListaEventos(){

		if ($_POST['data_pt_br']) {

			$data_recebida_ao_clicar = $_POST['data_pt_br'];

			if ($data_recebida_ao_clicar) {
				$this->montaQueryAgenda($data_recebida_ao_clicar);
			}
		}

	}

	public function montaQueryAgenda($data_recebida_ao_clicar){
		$args = array(
			'post_type' => 'agenda',
			'meta_key'     => 'data_do_evento',
			'meta_value'   => $data_recebida_ao_clicar, // change to how "event date" is stored
			'meta_compare' => '=',
		);
		$query = new \WP_Query( $args );

		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			?>
			<article class="col-lg-12 col-xs-12">
				<div class="agenda mb-4">
					<div class="horario d-inline"><?= $this->getCamposPersonalizados('hora_do_evento') ?></div> -
					<div class="evento d-inline"><?= get_the_title()?></div>
					<div class="local"><?= $this->getCamposPersonalizados('endereco_do_evento') ?></div>
				</div>

			</article>
		<?php
		endwhile;
		else:
			echo '<p><strong>Não existem eventos cadastrados nesta data</strong></p>';
		endif;
		wp_reset_postdata();

	}

}