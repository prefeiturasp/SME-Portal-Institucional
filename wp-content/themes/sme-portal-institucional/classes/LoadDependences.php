<?php

namespace Classes;


use Classes\ModelosDePaginas\PaginaAgendaSecretario\PaginaAgendaSecretario;
use Classes\ModelosDePaginas\PaginaAgendaSecretario\PaginaAgendaSecretarioAjaxCalendario;
use Classes\ModelosDePaginas\PaginaContato\PaginaContatoMetabox;

class LoadDependences
{
	public function __construct()
	{
		$this->loadDependencesPublic();
		$this->loadDependencesAdmin();
	}

	public function loadDependencesPublic(){
		//if (!is_admin()){
			add_action('init', array($this, 'custom_formats_public'));
		//}
	}
	public function loadDependencesAdmin(){
		if (is_admin()){
			//add_action('init', array($this, 'custom_formats_admin'));
		}
	}

	public function custom_formats_public(){
		// Página Inicial
		wp_register_style('pagina-inicial', STM_THEME_URL . 'classes/assets/css/pagina-inicial.css', null, null, 'all');
		wp_enqueue_style('pagina-inicial');

		// Página Agenda do Secretário
		wp_register_script('moment_with_locales',  STM_THEME_URL . 'classes/assets/js/ion.calendar-2.0.2/js/moment-with-locales.js', array ('jquery'), false, true);
		wp_register_script('ion_calendar',  STM_THEME_URL . 'classes/assets/js/ion.calendar-2.0.2/js/ion.calendar.js', array ('jquery'), false, true);
		wp_enqueue_script('moment_with_locales');
		wp_enqueue_script('ion_calendar');

		wp_register_script('ajax-agenda-secretario',  STM_THEME_URL . 'classes/assets/js/ajax-agenda-secretario.js', array ('jquery'), false, true);
		wp_enqueue_script('ajax-agenda-secretario');
		wp_localize_script('ajax-agenda-secretario', 'bloginfo', array('ajaxurl' => admin_url('admin-ajax.php')));
		add_action('wp_ajax_montaHtmlListaEventos', array(new PaginaAgendaSecretarioAjaxCalendario(), 'montaHtmlListaEventos' ));
		add_action('wp_ajax_nopriv_montaHtmlListaEventos', array(new PaginaAgendaSecretarioAjaxCalendario(), 'montaHtmlListaEventos'));

		// Contatos SME
		wp_enqueue_script('jquery-ui-sortable');
		wp_register_script('ajax-contato-sme',  STM_THEME_URL . 'classes/assets/js/ajax-contato-sme.js', array ('jquery'), false, true);
		wp_enqueue_script('ajax-contato-sme');
		add_action('wp_ajax_criaCamposContato', array(new PaginaContatoMetabox(), 'criaCamposContato' ));
		add_action('wp_ajax_nopriv_criaCamposContato', array(new PaginaContatoMetabox(), 'criaCamposContato'));

		wp_register_style('contatos-sme', STM_THEME_URL . 'classes/assets/css/contatos-sme.css', null, null, 'all');
		wp_enqueue_style('contatos-sme');

	}

	public function custom_formats_admin(){


	}
}

new LoadDependences();