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
	
	
	
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		$args = array(
			'post_type' => 'agenda',
			'posts_per_page' => 5,
    		'paged' => $paged,
			'meta_key'     => 'data_do_evento',
			'orderby' => 'meta_value_num',
    		'order' => 'DESC',
			//'meta_value'   => $data_recebida_ao_clicar, // change to how "event date" is stored
			'meta_compare' => '=',
		);
		$query = new \WP_Query( $args );
		
		
		function tirarAcentos($string){
				$comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');
				$semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u','u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0','U', 'U', 'U');

				return str_replace($comAcentos, $semAcentos, $string);
		}
		
		$campo_de_busca_agenda =  strtoupper(tirarAcentos($_GET['agenda-dre']));
		
		$campo_de_busca_data =  $_GET['data-agenda-dre'];
		$campo_data_format = date("d/m/Y", strtotime($campo_de_busca_data));
		

		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			
			$campo1 = strtoupper (tirarAcentos(get_the_title()));
			$campo2 = strtoupper (tirarAcentos(get_field('pauta_assunto')));
			$campo3 = strtoupper (tirarAcentos(get_field('endereco_do_evento')));

			$campo_data = get_field('data_do_evento');
		
			$buscas_tags = wp_list_pluck( get_the_terms( get_the_ID(), 'agenda-tag' ), 'name');
						$items = array();
						$count = 0;
						foreach( $buscas_tags as $busca_tag ) {
							$items[$count++] = strtoupper(tirarAcentos($busca_tag)); 
						}
						
			$frase = explode(' ',$campo1);
			$pauta = explode(' ',$campo2);
			$local = explode(' ',$campo3);

		
			/*echo '<pre>';
			var_dump($items);
			echo '</pre>';*/


			if(in_array( $campo_de_busca_agenda ,$frase ) || 
			   $campo_de_busca_agenda == $campo1		  || 
			   //in_array( $campo_de_busca_agenda ,$pauta ) ||
			   in_array( $campo_de_busca_agenda ,$items ) ||
			   in_array( $campo_de_busca_agenda ,$local ) &&
				$campo_data_format == $campo_data		  

			  ){
				?>
					<article id="agenda" class="col-lg-12 col-xs-12">
				<div class="agenda mb-4">
					<div class="order_hri"><?php
					//converte campo hora por extenso para ordenar
					// $hri = $this->getCamposPersonalizados('hora_do_evento');
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
					<?php 
						$terms_tags = wp_list_pluck( get_the_terms( get_the_ID(), 'agenda-tag' ), 'name');
						foreach( $terms_tags as $term_tag ) {
						echo '<a href="?agenda-dre='.$term_tag.'" style="color:white" class="tagcolor">' .$term_tag. '</a> ';
						}
					?>
					<!--Tags agenda-->
						
					<?php } ?></div>
					
				</div>
				
			</article>
				<?php
			} else if(
				$campo_data_format == $campo_data && $campo_de_busca_agenda == ''	  

			  ){
				?>
					<article id="agenda" class="col-lg-12 col-xs-12">
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
					 <?php 
							$terms = wp_list_pluck( get_the_terms( get_the_ID(), 'agenda-tag' ), 'name');
							foreach( $terms as $term ) {
							echo '<a href="?agenda-dre='.$term.'" style="color:white" class="tagcolor">' .$term. '</a> ';
							}
						?>
					<!--Tags agenda-->
						
					<?php } ?></div>
					
				</div>
				
			</article>
				<?php
			}
			?>
			
			
		
		<?php
		
		
		endwhile;
		
		
		else:
		
			
		endif;

		wp_reset_postdata();
		
		
		if($campo_de_busca_agenda == '' && $campo_de_busca_data == ''){
			echo '<span id="agenda">Informe uma data ou termo para a busca avançada!<span>';	
		}
		
		?>
		<span id="aviso-agenda"></span>
		<script>
			const agenda = document.getElementById("agenda");
			if (agenda !== null) {
			 // alert("O elemento #filho existe em #agenda");
			} else {
				document.getElementById("aviso-agenda").innerHTML = 'Não exite resultado para o valor informado';
			  //alert("O elemento #filho não existe em #agenda");
			}
		</script>			
					
				</div>

		<div class="col-sm-4 reverse mb-4">

            <span class="filtro-busca">
				<form role="search" action="<?php echo site_url('/agenda/'); ?>" method="get" id="searchform">
                <div class="form-group border-filtro">
                    <label for="usr"><strong><h2>Busca Avançada</h2></strong></label>
                </div>
				<div class="form-group">
                    <label for="sel1"><strong>Filtre por data</strong></label>
                    <input class="form-control" type="date" name="data-agenda-dre" id="example-date-input">
                </div>
                <div class="form-group">
                    <label for="usr"><strong>Filtre por um termo</strong></label>
					<input class ='form-control' type="text" name="agenda-dre" placeholder="Buscar agenda"/>
                </div>
                <div class="form-group">
					<input class="btn btn-primary btn-sm float-right" type="submit" alt="Buscar agenda" value="Buscar agenda" />
                </div>
				</form>
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
