<?php

namespace Classes;

use Classes\ModelosDePaginas\PaginaContato\PaginaContatoMetabox;
use Classes\TemplateHierarchy\ArchiveAgenda\ArchiveAgendaAjaxCalendario;
use Classes\TemplateHierarchy\ArchiveAgendaNew\ArchiveAgendaAjaxCalendarioNew;
use Classes\TemplateHierarchy\ArchiveAgenda\ArchiveAgendaGetDatasEventos;
use Classes\TemplateHierarchy\ArchiveContato\ArchiveContatoMetabox;

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
		if(!is_admin()){
			wp_register_style('pagina-inicial', STM_THEME_URL . 'classes/assets/css/pagina-inicial.css', null, null, 'all');
			wp_enqueue_style('pagina-inicial');
		}
		// Programas e Projetos
		//wp_register_style('programa-projeto', STM_THEME_URL . 'classes/assets/css/programa-projeto.css', null, null, 'all');
		//wp_enqueue_style('programa-projeto');
		
		// landpage
		if(!is_admin()){
			wp_register_style('lp-modelo-1', STM_THEME_URL . 'classes/assets/css/lp-modelo-1.css');
			wp_enqueue_style('lp-modelo-1');
		}
		if(!is_admin()){
			wp_register_style('lp-modelo-2', STM_THEME_URL . 'classes/assets/css/lp-modelo-2.css');
			wp_enqueue_style('lp-modelo-2');
		}
		//construtor
		if(!is_admin()){
			wp_register_style('construtor', STM_THEME_URL . 'classes/assets/css/construtor.css');
			wp_enqueue_style('construtor');
		}
		
		// Portais e Sistemas
		wp_register_script('jquery-mask',  'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js', array ('jquery'), false, false);
		wp_enqueue_script('jquery-mask');

		// Agenda do Secretário
		wp_register_style('agenda-secretario', STM_THEME_URL . 'classes/assets/css/agenda-secretario.css', null, null, 'all');
		wp_enqueue_style('agenda-secretario');
		wp_register_script('moment_with_locales',  STM_THEME_URL . 'classes/assets/js/ion.calendar-2.0.2/js/moment-with-locales.js', array ('jquery'), false, false);
		wp_register_script('ion_calendar',  STM_THEME_URL . 'classes/assets/js/ion.calendar-2.0.2/js/ion.calendar.js', array ('jquery'), false, false);
		wp_enqueue_script('moment_with_locales');
		wp_enqueue_script('ion_calendar');

		wp_register_script('ajax-agenda-secretario',  STM_THEME_URL . 'classes/assets/js/ajax-agenda-secretario.js', array ('jquery'), false, false);
		wp_enqueue_script('ajax-agenda-secretario');
		wp_localize_script('ajax-agenda-secretario', 'bloginfo', array('ajaxurl' => admin_url('admin-ajax.php')));
		add_action('wp_ajax_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendario(), 'montaHtmlListaEventos' ));
		add_action('wp_ajax_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendarioNew(), 'montaHtmlListaEventos' ));
		add_action('wp_ajax_nopriv_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendario(), 'montaHtmlListaEventos'));
		add_action('wp_ajax_nopriv_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendarioNew(), 'montaHtmlListaEventos'));

		add_action('wp_ajax_recebeDadosAjax', array(new ArchiveAgendaGetDatasEventos(), 'recebeDadosAjax' ));
		add_action('wp_ajax_nopriv_recebeDadosAjax', array(new ArchiveAgendaGetDatasEventos(), 'recebeDadosAjax'));


		// Contatos SME
		//wp_enqueue_script('jquery-ui-sortable');
		//wp_register_script('ajax-contato-sme',  STM_THEME_URL . 'classes/assets/js/ajax-contato-sme.js', array ('jquery'), false, false);
		//wp_enqueue_script('ajax-contato-sme');
		//add_action('wp_ajax_criaCamposContato', array(new ArchiveContatoMetabox(), 'criaCamposContato' ));
		//add_action('wp_ajax_nopriv_criaCamposContato', array(new ArchiveContatoMetabox(), 'criaCamposContato'));

		//wp_register_style('contatos-sme', STM_THEME_URL . 'classes/assets/css/contatos-sme.css', null, null, 'all');
		//wp_enqueue_style('contatos-sme');

		// Organograma
		//wp_register_style('organograma', STM_THEME_URL . 'classes/assets/css/organograma.css', null, null, 'all');
		//wp_enqueue_style('organograma');
		//wp_register_script('organograma',  STM_THEME_URL . 'classes/assets/js/organograma.js', array ('jquery'), false, false);
		//wp_enqueue_script('organograma');

		// Página Login
		wp_register_style('pagina-login', STM_THEME_URL . 'classes/assets/css/pagina-login.css', null, null, 'all');
		wp_enqueue_style('pagina-login');
		wp_register_script('pagina-login',  STM_THEME_URL . 'classes/assets/js/pagina-login.js', array ('jquery'), false, false);
		wp_enqueue_script('pagina-login');

		// Breadcrumb
		wp_register_style('breadcrumb', STM_THEME_URL . 'classes/assets/css/breadcrumb.css', null, null, 'all');
		wp_enqueue_style('breadcrumb');

		// Loop Single
		wp_register_style('loop-single', STM_THEME_URL . 'classes/assets/css/loop-single.css', null, null, 'all');
		wp_enqueue_style('loop-single');

		// Mural de recados
		wp_register_script('mural-recados-sme',  STM_THEME_URL . 'classes/assets/js/mural-recados-sme.js', array ('jquery'), false, false);
		wp_enqueue_script('mural-recados-sme');
		
		// Portais e Sistemas
		wp_register_script('portais-sistemas',  STM_THEME_URL . 'classes/assets/js/portais-sistemas.js', array ('jquery'), false, false);
		wp_enqueue_script('portais-sistemas');

	}

	public function custom_formats_admin(){


	}
}

new LoadDependences();