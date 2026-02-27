<?php

namespace Classes\TemplateHierarchy\Portfolio;


class ArchiveCptPortfolioAdminMenuPage
{

	public function __construct()
	{
		add_action('admin_menu', array($this, 'configuracoesCptPortfolio'));

		add_action('admin_init', array($this, 'addOptionDescricaoPortfolio'));
		add_action('admin_init', array($this, 'addSettingsDescricaoPortfolio'));

		add_action('admin_init', array($this, 'addOptionGridLayoutPortfolio'));
		add_action('admin_init', array($this, 'addSettingsGridLayoutPortfolio'));
	}

	function configuracoesCptPortfolio()
	{
		// Criando o item Configurações Portfolio no CPT Portfolio
		//add_submenu_page('menu-personalizado', 'Página de opções Submenu Home', 'Home', 'manage_options', 'menu-personalizado' );

		add_submenu_page('edit.php?post_type=portfolio', 'Configurações Portfolio','Configurações Portfolio','manage_options','pagina-configuracoes-portfolio',array($this, 'pagina_de_configuracoes'));

	}

	public 	function pagina_de_configuracoes() {

	    echo '<h2>Portfolio Configurações</h2>';

		settings_errors();

		$active_tab = (isset($_GET['tab'])) ? $_GET['tab'] : 'tab-descricao-portfolio';

		?>
		 <h2 class="nav-tab-wrapper">
				<?php
				$tabs = array(
					'tab-descricao-portfolio' => 'Descrição do Portfolio',
					'tab-layout-portfolio' => 'Grid Layout',
				);
				foreach ($tabs as $tab => $label) {
					printf('<a href="%s" class="nav-tab%s">%s</a>', admin_url('admin.php?page=pagina-configuracoes-portfolio&tab=' . $tab), ($tab == $active_tab) ? ' nav-tab-active' : '', $label);
				}
				?>
            </h2>
        <?php

		if ($active_tab == 'tab-descricao-portfolio') {

			echo '<form method="post" action="options.php">';
			settings_fields('descricao-portfolio');
			do_settings_sections('descricao-portfolio');
			submit_button();
			echo '</form>';

		}elseif ($active_tab == 'tab-layout-portfolio'){

			echo '<form method="post" action="options.php">';
			settings_fields('grid_layout_portfolio');
			do_settings_sections('grid_layout_portfolio');
			submit_button();
			echo '</form>';

        }
	}

	// Descrição Portfolio
	public function addOptionDescricaoPortfolio(){
		$descricao_portfolio = get_option('descricao_portfolio');
	    if (!$descricao_portfolio || !is_array($descricao_portfolio)) {
			//Serializando os dados
			$descricao_portfolio = array(
				'descricao_portfolio' => '',
			);
			add_option('descricao_portfolio', $descricao_portfolio, false, false);
		}

    }
	public function addSettingsDescricaoPortfolio(){
		$descricao_portfolio = get_option('descricao_portfolio');
		add_settings_section('descricao-porfolio-section', 'Insira a Descrição do Portfólio', '' /*array($this, 'section')*/, 'descricao-portfolio');
		add_settings_field(
			'descricao-portfolio',
			'Descrição do Portfolio',
			array($this, 'callback_descricao_portolio'),
			'descricao-portfolio',
			'descricao-porfolio-section',
			array(
				'name' => 'descricao_portfolio',
				'value' => $descricao_portfolio,
			)
		);
		register_setting('descricao-portfolio', 'descricao_portfolio', array($this, 'sanitizeDescricaoPortfolio'));
	}

    public function callback_descricao_portolio($args){
	    echo "<textarea id='{$args["name"]}' name='{$args["name"]}' cols='80' rows='10'>{$args["value"]}</textarea><br>";
    }

    public function sanitizeDescricaoPortfolio($textarea){
	    return sanitize_textarea_field($textarea);
    }
	// Fim Descrição Portfolio

    // Grid Layout Portfolio
    public function addOptionGridLayoutPortfolio(){
		$grid_layout_portfolio = get_option('grid_layout_portfolio');
		if (!$grid_layout_portfolio || !is_array($grid_layout_portfolio)) {
			//Serializando os dados
			$grid_layout_portfolio = array(
				'qtd_colunas_por_linha' => '',
			);
			add_option('grid_layout_portfolio', $grid_layout_portfolio, false, false);
		}

    }

    public function addSettingsGridLayoutPortfolio(){
		$grid_layout_portfolio = get_option('grid_layout_portfolio');

		add_settings_section('grid_layout_portfolio_section', 'Configurações de exibição do portfolio', '' /*array($this, 'section')*/, 'grid_layout_portfolio');
		add_settings_field(
			'qtd_colunas_por_linha',
			'Quantidade de colunas por linha* (Obrigatório)',
			array($this, 'callback_qtd_colunas_por_linha'),
			'grid_layout_portfolio',
			'grid_layout_portfolio_section',
			array(
				'name' => 'qtd_colunas_por_linha',
				'value' => $grid_layout_portfolio['qtd_colunas_por_linha'],
			)
		);

		register_setting('grid_layout_portfolio', 'grid_layout_portfolio', array($this, 'sanitizeGridLayoutPortfolio'));

	}


	public function callback_qtd_colunas_por_linha($args){
	 	echo '<input required type="number" class="regular-text"  name="grid_layout_portfolio['.$args["name"].']" value="'.$args["value"].'"/>';
	}

	public function sanitizeGridLayoutPortfolio($input){
	    foreach ($input as $value){
	        if (trim($value == '')) {
				$input = false;
				add_settings_error(
					'requiredTextFieldEmpty',
					'empty',
					'Os campos são obrigatórios!!',
					'error'
				);
				break;
			}elseif (!is_numeric($value) ){
				$input = false;
				add_settings_error(
					'requiredNumber',
					'notNumber',
					'Somente números são permitidos!!',
					'error'
				);
				break;
            }
        }
		return $input;
    }

	// Fim Grid Layout Portfolio

}

new ArchiveCptPortfolioAdminMenuPage();