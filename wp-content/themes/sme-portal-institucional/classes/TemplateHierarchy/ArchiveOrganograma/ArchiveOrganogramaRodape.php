<?php

namespace Classes\TemplateHierarchy\ArchiveOrganograma;


class ArchiveOrganogramaRodape
{
	public function __construct()
	{
		$this->montaHtmlRodape();
	}

	public function montaHtmlRodape(){
		?>
		<a class="btn btn-primary btn-lg btn-block rodape-bt-unidades-escolares mt-5" href="<?= STM_URL ?>/escolaaberta">Unidades Escolares</a>

		<p class="mt-5 mb-4 text-center"><strong><a class="rodape-links" href="<?= STM_URL ?>/wp-content/uploads/2020/09/organograma-decreto-59.660.jpg">Download do organograma</a></strong></p>

		<p class="text-center"><strong><a class="rodape-links" href="<?= STM_URL.'/contato/'?>">Ver telefones e emails de contato</a></strong></p>
		<?php
	}



}