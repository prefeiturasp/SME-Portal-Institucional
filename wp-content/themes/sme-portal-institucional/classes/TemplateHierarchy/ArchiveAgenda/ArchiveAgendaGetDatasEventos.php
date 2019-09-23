<?php

namespace Classes\TemplateHierarchy\ArchiveAgenda;


class ArchiveAgendaGetDatasEventos
{
	const CPTAGENDA = 'agenda';
	private $args_ids;
	private $query_ids;
	private $array_ids;
	private $array_datas;
	private $array_nomes;

	public function __construct()
	{
/*		header('Content-Type: application/json');
		// An associative array
		$this->array_nomes = json_encode(array('Maria', "João"));

		$marks = json_encode(array("Peter"=>65, "Harry"=>80, "John"=>78, "Clark"=>90));

		echo '<pre>';
		echo $marks;
		echo '<br/>';
		echo $this->array_nomes;
		echo '</pre>';*/

		//echo '<input type="hidden" name="array_nomes", id="array_nomes", value="'.$marks.'">';
		//echo '<input type="hidden" name="array_nomes", id="array_nomes", value='.$this->array_nomes.'>';
		//echo '<input type="hidden" name="array_nomes", id="array_nomes" value='.$marks.'>';

		//echo '<input class="array_datas_agenda" type="hidden" name="array_datas_agenda[]" value="30/09/2019">';
		//echo '<input class="array_datas_agenda" type="hidden" name="array_datas_agenda[]" value="22/09/2019">';

		$this->init();


	}

	public function init(){

		$current_url = $_SERVER['REQUEST_URI'];
		$partes = explode("/", $current_url);

		if ($partes[1] === 'agenda' || $partes[2] === 'agenda') {
			$this->getTodosIdCtpAgenda();
			$this->getDatasCptAgenda();
		}
	}

	public function getTodosIdCtpAgenda(){

		$this->args_ids = array(
			'post_type' => self::CPTAGENDA,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_key' => 'data_do_evento',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'data_do_evento',
					'value' => date("d/m/Y"), // date format error
					'compare' => '<='
				)
			)

		);
		$this->query_ids = get_posts($this->args_ids);
		foreach ($this->query_ids as $item){
			$this->array_ids[] = $item->ID;
		}
	}

	public function getDatasCptAgenda(){

		foreach ($this->array_ids as $id){
			$this->array_datas[] = get_field('data_do_evento', $id);
			echo '<input class="array_datas_agenda" type="hidden" name="array_datas_agenda[]" value="'.get_field('data_do_evento', $id).'">';
		}
	}
}

new ArchiveAgendaGetDatasEventos;