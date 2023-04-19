<?php

namespace Classes\TemplateHierarchy\ArchiveAgendaNew;


use Classes\Lib\Util;

class ArchiveAgendaAjaxCalendarioNew extends Util
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
		$ids = array();
		$args = array(
			'post_type' => 'agendanew',
			//'meta_key'     => 'data_do_evento',
			//'meta_value'   => $data_recebida_ao_clicar, // change to how "event date" is stored
			//'meta_compare' => '=',
			'posts_per_page' => -1,
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'data_do_evento',
					'value' => $data_recebida_ao_clicar,
					'compare' => '=',
				),							
			)
		);
		$query = new \WP_Query( $args );

		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			
			$ids[] = get_the_ID();

		endwhile;
		
		endif;
		wp_reset_postdata();

		$args = array(
			'post_type' => 'agendanew',
			//'meta_key'     => 'data_do_evento',
			//'meta_value'   => $data_recebida_ao_clicar, // change to how "event date" is stored
			//'meta_compare' => '=',
			'posts_per_page' => -1,
			'meta_query' => array(				
				array(
					'relation' => 'AND',
					array(
						'key' => 'data_do_evento',
						'value' => $data_recebida_ao_clicar,
						'type' => 'date',
						'compare' => '<='
					),
					array(
						'key' => 'data_evento_final',
						'value' => $data_recebida_ao_clicar,
						'type' => 'date',
						'compare' => '>='
					),
				),			
			)
		);
		$query = new \WP_Query( $args );

		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			
			$ids[] = get_the_ID();

		endwhile;		
		endif;
		wp_reset_postdata();

		$ids = array_unique($ids);

		if($ids && $ids != ''): 
			foreach($ids as $id): ?>
				<article class="col-lg-12 col-xs-12">
					<div class="agenda mb-4 agenda-new aaa">
						<?php
							$eventos = get_field('eventos_do_dia', $id);							
						?>
						<?php foreach($eventos as $evento): ?>
							<div class="agenda mb-4 agenda-new bbb">
								<div class="order_hri">
									<?php
										//converte campo hora por extenso para ordenar
										$hri = $evento['hora_evento'];
										echo $hri=date('His',$hri);
									?>
								</div>

								<div class="horario d-inline"><?= $evento['hora_evento']; ?> - <?= $evento['fim_evento']; ?></div> |
								<?php if( $evento['compromisso'] == 'outros' && $evento['nome_compromisso'] != '') :?>
									<div class="evento d-inline"><?= $evento['nome_compromisso'] ?></div>
								<?php else: ?>
									<div class="evento d-inline"><?= get_term( $evento['compromisso'] )->name; ?></div>
								<?php endif; ?>

								<?php if($evento['pauta_assunto'] != ''): ?>
									<div class="local"><strong>Pauta/Assunto:</strong> <?= $evento['pauta_assunto']; ?></div>
								<?php endif; ?>

								<?php if( $evento['endereco_evento'] == 'outros' && $evento['digite_o_endereco_do_evento'] != '') :?>
									<div class="local"><strong>Local:</strong> <?= $evento['digite_o_endereco_do_evento'] ?></div>
								<?php else: ?>
									<div class="local"><strong>Local:</strong> <?= get_term( $evento['endereco_evento'] )->name; ?> - <?= get_term( $evento['endereco_evento'] )->description; ?></div>
								<?php endif; ?>

								<?php if($evento['participantes_evento'] != ''): ?>
									<div class="local"><strong>Participantes:</strong><br><?= $evento['participantes_evento']; ?></div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
						
						<?php //} 
							echo'<script>
							//limpa div a cada click
							jQuery(".agenda-ordenada").html("");
							//ordena por hora
							jQuery(".agenda").sort(function(a, b) {

							if (a.textContent < b.textContent) {
								return -1;
							} else {
								return 1;
							}
							}).appendTo(".agenda-ordenada");
							//oculta campo hora
							jQuery(".order_hri").hide();
							</script>';
							?></div>
					</div>
					
				</article>
			<?php endforeach;
		else:
			echo '<p class="agenda agenda-new"><strong>Não existem eventos cadastrados nesta data</strong></p>';
		endif; // IDs

	}

}