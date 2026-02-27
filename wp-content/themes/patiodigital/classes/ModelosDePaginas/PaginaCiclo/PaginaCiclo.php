<?php

namespace Classes\ModelosDePaginas\PaginaCiclo;
use Classes\PaginaFilha\PaginaFilha;

class PaginaCiclo
{
	private  $pageIDfilha;
	private  $texto_complementar;

	public function __construct()
	{
		$this->pageIDfilha = PaginaFilha::getIdPaginaCorreta();
		$this->montaHtmlPaginaCiclo();
	}

	public function getTextoComplementar(){
		$this->texto_complementar = get_field('texto_complementar_ciclo_inovacao', $this->pageIDfilha);
		echo '<div class="row margin-top-30">';
			echo '<div class="container">';
				echo '<div class="col-12">';
					echo $this->texto_complementar;
				echo '</div>';
			echo '</div>';
		echo '</div>';

	}

	public function montaHtmlPaginaCiclo(){
		?>

		<div class="prototipacao text-white p-4 position-relative">
			<div class="container">
				<div class="row">
					<div class="col-lg-2">
						<div class="border border-white rounded-circle d-flex justify-content-center align-items-center">
							<i class="fas fa-lightbulb"></i>
						</div>
						<div class="line-white-bot d-none d-lg-block"></div>
					</div>
					<div class="col-lg-10">
						<h2 class="text-uppercase">1º Prototipação Participativa</h2>
						<h3>Encontros Abertos + Oficinas "mão na massa"</h3>
						<p>Debates informais na SME que reúnem interessados em temas de tecnologia e/ou dados em educação. Hackdays, maratonas ou outros momentos de esforços concentrado para explorar soluções.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="lancamentos text-white p-4 position-relative">
			<div class="line-white-top d-none d-lg-block"></div>
			<div class="container">
				<div class="row">
					<div class="col-lg-2">
						<div class="border border-white rounded-circle d-flex justify-content-center align-items-center">
							<i class="fas fa-bullhorn"></i>
						</div>
						<div class="line-white-bot d-none d-lg-block"></div>
					</div>
					<div class="col-lg-10">
						<h2 class="text-uppercase">2º Lançamentos do Desafio</h2>
						<h3>Seleção de Apps + Hackatona</h3>
						<p>Editais para apresentação de projetos a partir de desafios da SME. Os projetos selecionados participam de esforço concentrado e apresentam seus protótipos: Seleção do protótipo vencedor.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="desenvolvimento text-white p-4 position-relative">
			<div class="line-white-top d-none d-lg-block"></div>
			<div class="container">
				<div class="row">
					<div class="col-lg-2">
						<div class="border border-white rounded-circle d-flex justify-content-center align-items-center">
							<i class="fas fa-rocket"></i>
						</div>
						<div class="line-white-bot d-none d-lg-block"></div>
					</div>
					<div class="col-lg-10">
						<h2 class="text-uppercase">3º Desenvolvimento Aberto</h2>
						<h3>Códigos Abertos</h3>
						<p>Os protótipos selecionados devem ser desenvolvidos em repositórios e licenças abertas.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="solucoes text-white p-4 position-relative">
			<div class="line-white-top d-none d-lg-block"></div>
			<div class="container">
				<div class="row">
					<div class="col-lg-2">
						<div class="border border-white rounded-circle d-flex justify-content-center align-items-center">
							<i class="fas fa-mobile-alt"></i>
						</div>
					</div>
					<div class="col-lg-10">
						<h2 class="text-uppercase">4º Soluções</h2>
						<h3>Banco de Apps</h3>
						<p>As soluções desenvolvidas pela SME ficarão disponíveis para outros municípios.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
		$this->getTextoComplementar();
	}

}