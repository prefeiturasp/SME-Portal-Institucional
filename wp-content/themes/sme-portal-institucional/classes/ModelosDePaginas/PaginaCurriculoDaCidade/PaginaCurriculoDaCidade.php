<?php

namespace Classes\ModelosDePaginas\PaginaCurriculoDaCidade;


use Classes\Lib\Util;

class PaginaCurriculoDaCidade extends Util
{

	protected $page_id;

	public function __construct()
	{
		echo '<h1>Entrei Página Currículo da Cidade</h1>';

		$source = 'http://localhost/furuba-educacao-intranet/wp-content/uploads/2019/08/declaracao_cruzeiro.pdf';



		$this->page_id = get_the_ID();
		$util = new Util($this->page_id);
		$util->montaHtmlLoopPadrao();

		$this->genPdfThumbnail($source);
	}

	public 	function genPdfThumbnail($source)
	{
		$i = new \WP_Image_Editor_Imagick($source);
		//$image = new \WP_Image_Editor_Imagick($source);

		echo '<pre>';
		var_dump($i);
		echo '</pre>';
	}

}