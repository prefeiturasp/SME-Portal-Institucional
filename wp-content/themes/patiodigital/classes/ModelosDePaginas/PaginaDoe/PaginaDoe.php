<?php

namespace Classes\ModelosDePaginas\PaginaDoe;


use Classes\PaginaFilha\PaginaFilha;

class PaginaDoe
{
	private  $pageIDfilha;
	private  $arquivo_pessoa_fisica;
	private  $arquivo_pessoa_juridica;

	public function __construct()
	{
		$this->pageIDfilha = PaginaFilha::getIdPaginaCorreta();
		$this->arquivo_pessoa_fisica = get_field('ficha_de_inscricao_pessoa_fisica', $this->pageIDfilha);
		$this->arquivo_pessoa_juridica = get_field('ficha_de_inscricao_pessoa_juridica', $this->pageIDfilha);
		$this->montaHtmlPaginaDoe();
	}



	public function montaHtmlPaginaDoe(){
		?>
		<div class="container">
			<div class="row">
				<div class="col-lg-4 text-center mt-4 mb-4">
					<img src="https://dummyimage.com/215x215/FFF/FFF" class="img-fluid rounded-circle border" alt="">
					<div class="clearfix w-50 mt-4 mx-auto">1. Baixe o edital para conhecer os termos e condições da doação</div>
				</div>
				<div class="col-lg-4 text-center mt-4 mb-4">
					<img src="https://dummyimage.com/215x215/FFF/FFF" class="img-fluid rounded-circle border" alt="">
					<div class="clearfix w-50 mt-4 mx-auto">2. Envie por e-mail a ficha preenchida (escolha a versão pessoa física ou jurídica abaixo)</div>
				</div>
				<div class="col-lg-4 text-center mt-4 mb-4">
					<img src="https://dummyimage.com/215x215/FFF/FFF" class="img-fluid rounded-circle border" alt="">
					<div class="clearfix w-50 mt-4 mx-auto">3. A proposta será analisada pelas áreas técnicas da Secretaria</div>
				</div>
			</div>
			<div class='alert alert-light border text-dark' role='alert'>
				<i class="fas fa-download mr-3"></i>
				<a class="texto-preto" href="<?= $this->arquivo_pessoa_fisica['url'] ?>" download> Ficha de Inscrição - Pessoa Física </a>
				<small class="ml-4 mt-n1 text-primary">Anexe a cópia dos documentos necessários descritos no edital</small>
			</div>

			<div class='alert alert-light border text-dark' role='alert'>
				<i class="fas fa-download mr-3"></i>
				<a class="texto-preto" href="<?= $this->arquivo_pessoa_juridica['url'] ?>" download> Ficha de Inscrição - Pessoa Jurídica </a>
				<small class="ml-4 mt-n1 text-primary">Anexe a cópia dos documentos necessários descritos no edital</small>
			</div>

		</div>

		<?php
	}

}