<?php
namespace Classes\ModelosDePaginas\PaginaEscolas;

class PaginaEscolas
{

	public function __construct()
	{
		$this->loadDependencesPublic();

	}

	public function buscaEscola(){
		?>

		<div class="container">


            <form id="formulario_busca_escola">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="busca_escola">Busca de Escolas</label>
                        <input type="text" class="form-control" id="busca_escola" name="busca_escola" placeholder="Digite o nome de uma escola">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="busca_tipo_de_escola">Tipo de Escola</label>
                        <select class="form-control" id="busca_tipo_de_escola" name="busca_tipo_de_escola">
                            <option value="">Selecione uam opção</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="busca_dre">Busca DRE</label>
                        <select class="form-control" id="busca_dre" name="busca_dre">


                        </select>
                    </div>
                    <button id="form_submit" name="form_submit" class="btn btn-primary" type="submit">Buscar Escolas</button>
                </div>
            </form>
            <br>

            <!--Div que exibira os dados das escolas via AJAX-->
            <div id="container_tabela_busca_escola"></div>

		</div>

		<?php
	}

	public function loadDependencesPublic(){
		//if (!is_admin()){
		add_action('init', array($this, 'custom_formats_public'));
		//}
	}

	public function custom_formats_public(){

		wp_register_script('ajax-escolas-public.js', STM_THEME_URL . 'classes/assets/js/ajax-escolas-public.js', array('jquery'), 1.0, false);
		wp_enqueue_script('ajax-escolas-public.js');

		wp_register_script('jquery.simplePagination.js', STM_THEME_URL . 'classes/assets/js/jquery.simplePagination.js', array('jquery'), 1.0, false);
		wp_enqueue_script('jquery.simplePagination.js');

		wp_register_script('jquery.twbsPagination.js', STM_THEME_URL . 'classes/assets/js/jquery.twbsPagination.js', array('jquery'), 1.0, false);
		wp_enqueue_script('jquery.twbsPagination.js');

		wp_enqueue_script( 'jquery-ui-autocomplete' );

		wp_register_style( 'jquery-ui-styles','https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
		wp_enqueue_style( 'jquery-ui-styles' );
	}

}

new PaginaEscolas();