<?php
namespace Classes\ModelosDePaginas\PaginaEnquete;


use Classes\PaginaFilha\PaginaFilha;

class PaginaEnquete
{
	private  $pageIDfilha;
	private  $escolha_a_categoria_de_enquete;
	private  $status_enquete;
	private  $url_enquete;
	private  $url_resultado;
	private  $data_de_encerramento_enquete;
	private  $args_enquete;
	private  $query_enquete;

	public function __construct()
	{
		$this->pageIDfilha = PaginaFilha::getIdPaginaCorreta();
		$this->escolha_a_categoria_de_enquete = get_field('escolha_a_categoria_de_enquete', $this->pageIDfilha);
		$this->montaQueryEnquete();
		$this->montaHtmlEnquete();
	}

	public function getStatusEnquete(){
		$this->status_enquete = get_field('status_da_enquete');

		return $this->status_enquete;
	}

	public function montaHtmlAlertEnquete($status){

		$titulo = get_the_title();

		if ($status === 'em_breve'){

			$html = "<div class='alert alert-light border text-dark' role='alert'>
					<i class='fas fa-list-ul mr-3'></i>{$titulo}";
			$html.= '<span class="badge badge-primary mt-n1 ml-3">Em Breve</span>
				</div>';

		}elseif ($status === 'ativa'){
			$this->url_enquete = get_field('url_da_enquete');
			$html = "<div class='alert alert-light border text-dark' role='alert'>
					<i class='fas fa-list-ul mr-3'></i>
					<a class='texto-preto' href='{$this->url_enquete}' target='_blank'>{$titulo}</a>";
			$html.= '</div>';

		}elseif ($status === 'encerrada'){
			$this->url_resultado = get_field('url_resultado');
			$this->data_de_encerramento_enquete = get_field('data_de_encerramento_enquete');

			$html = "<div class='alert alert-light border text-dark' role='alert'>
					<i class='fas fa-list-ul mr-3'></i>{$titulo}";
			$html.= "<small class='ml-4 mt-n1 text-primary'>Enquete encerrada em {$this->data_de_encerramento_enquete}. <a target='_blank' href='{$this->url_resultado}'>Acesse aqui os resultados</a></small>
				</div>";
		}
		return $html;
	}

	public function montaQueryEnquete(){

		$this->args_enquete = array(
			'post_type' => 'enquete',
			'orderby' => 'date',
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => $this->escolha_a_categoria_de_enquete->taxonomy,
					'field' => 'term_id',
					'terms' => $this->escolha_a_categoria_de_enquete->term_id,
				)
			)
		);

		$this->query_enquete = new \WP_Query($this->args_enquete);
	}

	public function montaHtmlEnquete(){

		if ($this->query_enquete->have_posts()) :

			echo '<div class="container">';

			while ($this->query_enquete->have_posts()) : $this->query_enquete->the_post();
				echo $this->montaHtmlAlertEnquete($this->getStatusEnquete());
			endwhile;

			echo '</div>';

			endif;

			wp_reset_postdata();
	}
}