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
		//$this->montaHtmlCalendario();
		//$this->insereDivRecebeData();
		$this->montaHtmlMaisEventos();
		$this->fechaContainer($container_calendario_tags);
	}
	
	public function montaHtmlMaisEventos(){
	?>
		<div class="container">
			<div class="row">
				<div class="col-sm-8 reverse">
					<h1 class="mb-4" id="">Agenda da DRE Guaianases</h1>
	<?php
		// Numbered Pagination
	
	
	

		$args = array(
			'post_type' => 'agenda',
			'posts_per_page' => 6,
    		//'paged' => $paged,
			'meta_key'     => 'data_do_evento',
			'orderby' => 'meta_value_num',
    		'order' => 'DESC',
			//'meta_value'   => $data_recebida_ao_clicar, // change to how "event date" is stored
			'meta_compare' => '=',
		);
		$query = new \WP_Query( $args );
		


		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			?>
			<article class="col-lg-12 col-xs-12">
				<div class="agenda mb-4">
					<div class="order_hri"><?php
					//converte campo hora por extenso para ordenar
					 //$hri = $this->getCamposPersonalizados('hora_do_evento');
					 //echo $hri=date('His',$hri);?></div>
					
					<hr>
					<!--Data do evento-->
					<div id="eventos-agenda" class="horario d-inline"><?= $this->getCamposPersonalizados('data_do_evento').' das ' ?></div>
					<!--Data do evento-->
					
					<!--Hora do evento-->
					<div class="horario d-inline"><?= $this->getCamposPersonalizados('hora_do_evento') ?>
                        <?php if($this->getCamposPersonalizados('fim_do_evento') !== null && $this->getCamposPersonalizados('fim_do_evento') !== ''){
                            echo 'às '.$this->getCamposPersonalizados('fim_do_evento');
                        }?>
                    </div> |
					<!--Hora do evento-->

                    <!--Nome do evento-->
                    <div class="evento d-inline"><?= get_the_title()?></div>
                    <!--Nome do evento-->
					
					<!--Paulta-->
					<div class="local"><?php 					
						if ($this->getCamposPersonalizados('pauta_assunto') !== null && $this->getCamposPersonalizados('pauta_assunto') !== ''){
					?>
					<div class="local"><strong>Pauta/Assunto:</strong> <?= $this->getCamposPersonalizados('pauta_assunto') ?></div>
					<?php } ?></div>
					<!--Paulta-->
					<br>
					<!--Endereço-->
					<div class="local"><?php
						if ($this->getCamposPersonalizados('endereco_do_evento') !== null && $this->getCamposPersonalizados('endereco_do_evento') !== ''){
					?>
						<div class="local"><strong>Local:</strong> <?= $this->getCamposPersonalizados('endereco_do_evento') ?></div>
					<!--Endereço-->
					
					<!--Participantes-->
					<div class="local">	
					<?php 					
					if ($this->getCamposPersonalizados('participantes_do_evento') !== null && $this->getCamposPersonalizados('participantes_do_evento') !== ''){
					?>
					<div class="local"><strong>Participantes:</strong> <?= $this->getCamposPersonalizados('participantes_do_evento') ?></div>
					<?php } ?></div>
					<!--Participantes-->
					
					<!--Tags agenda-->
                    <p><?php $tag_list = $tags = get_the_term_list( $post->ID, 'agenda-tag', '<div class="local tag-mobile"><strong>Tags:</strong> <span class="agenda_tag">','</span><span class="agenda_tag">','</span></div>');
                        print $tag_list; ?></p>
					<!--Tags agenda-->
						
					
					<?php } ?></div>
					
				</div>
				
			</article>
			
		
		<?php
		
		endwhile;
			
		else:
			echo '<p><strong>Não existem eventos cadastrados nesta data</strong></p>';
		endif;
		wp_reset_postdata();
		?>
				</div>
		<div class="col-sm-4 reverse mb-4">
            <span class="filtro-busca">
                <div class="form-group border-filtro">
                    <label for="usr"><strong><h2>Refine a sua busca</h2></strong></label>
                </div>
				<div class="form-group">
                    <label for="sel1"><strong>Filtre por data</strong></label>
                    <input class="form-control" type="date" id="example-date-input">
                </div>
                <div class="form-group">
                    <label for="usr"><strong>Filtre por um termo</strong></label>
                    <input class ='form-control' type = 'text' placeholder = 'Buscar'>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-sm float-right">Refinar busca</button>
                </div>
            </span>
			
		</div>
			</div>
		</div>
		<?php
	}

	public function montaHtmlCalendario(){
		?>
		<script>pageSize = 3;</script>
		<section class="col-lg-6 col-xs-12">
			<h1 class="mb-5" id="agenda">Agenda da DRE</h1>
            <!--<div class="container-loading-agenda-secretario">
                <img src="<?/*= STM_URL*/?>/wp-content/uploads/2019/10/loading.gif" alt="Carregando Agenda do Secretário">
            </div>-->
			<section class="calendario-agenda-sec d-block mb-5 border-bottom pb-5"></section>
		</section>


		<?php
	}

	public function insereDivRecebeData(){
		?>
		<section class="col-lg-6 col-xs-12">
			<h2 class="data_agenda mb-4 pb-2 border-bottom">Dia do Evento</h2>
			<section id="mostra_data"></section>
			<!-- Monta a lista ordenada por horário -->
			<section class="agenda-ordenada"></section>
            <!-- Monta a paginação -->
            <ul class="pagination" id="pagin">
            </ul>
		</section>
		<?php
	}

}
