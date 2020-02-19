<?php

namespace Classes;

use Classes\ModelosDePaginas\PaginaContato\PaginaContatoMetabox;
use Classes\TemplateHierarchy\ArchiveAgenda\ArchiveAgendaAjaxCalendario;
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
		wp_register_style('pagina-inicial', STM_THEME_URL . 'classes/assets/css/pagina-inicial.css', null, null, 'all');
		wp_enqueue_style('pagina-inicial');
		
		//MapLeaFlet
		wp_register_style( 'leaflet.css','https://unpkg.com/leaflet@1.6.0/dist/leaflet.css', null, '1.6.0', 'all' );
		wp_enqueue_style('leaflet.css');
		wp_register_script('leaflet.js', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.js', null, '1.6.0', false);
		wp_enqueue_script('leaflet.js');
		wp_register_script('mapsdre-leaflet.js', STM_THEME_URL . 'classes/assets/js/mapsdre-leaflet.js', array('jquery'), 1.0 ,false);
		wp_enqueue_script('mapsdre-leaflet.js');
		
		
		// Agenda da DRE
		wp_register_style('agenda-dre', STM_THEME_URL . 'classes/assets/css/agenda-dre.css', null, null, 'all');
		wp_enqueue_style('agenda-dre');
		wp_register_script('moment_with_locales',  STM_THEME_URL . 'classes/assets/js/ion.calendar-2.0.2/js/moment-with-locales.js', array ('jquery'), false, false);
		wp_register_script('ion_calendar',  STM_THEME_URL . 'classes/assets/js/ion.calendar-2.0.2/js/ion.calendar.js', array ('jquery'), false, false);
		wp_enqueue_script('moment_with_locales');
		wp_enqueue_script('ion_calendar');
		wp_register_script('ajax-agenda-dre',  STM_THEME_URL . 'classes/assets/js/ajax-agenda-dre.js', array ('jquery'), false, false);
		wp_enqueue_script('ajax-agenda-dre');
		
		wp_localize_script('ajax-agenda-dre', 'bloginfo', array('ajaxurl' => admin_url('admin-ajax.php')));
		add_action('wp_ajax_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendario(), 'montaHtmlListaEventos' ));
		add_action('wp_ajax_nopriv_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendario(), 'montaHtmlListaEventos'));
		add_action('wp_ajax_recebeDadosAjax', array(new ArchiveAgendaGetDatasEventos(), 'recebeDadosAjax' ));
		add_action('wp_ajax_nopriv_recebeDadosAjax', array(new ArchiveAgendaGetDatasEventos(), 'recebeDadosAjax'));

		// Breadcrumb
		wp_register_style('breadcrumb', STM_THEME_URL . 'classes/assets/css/breadcrumb.css', null, null, 'all');
		wp_enqueue_style('breadcrumb');

		// Loop Single
		wp_register_style('loop-single', STM_THEME_URL . 'classes/assets/css/loop-single.css', null, null, 'all');
		wp_enqueue_style('loop-single');

		// Página Mais Notícias
		wp_register_style('pagina-mais-noticias', STM_THEME_URL . 'classes/assets/css/pagina-mais-noticias.css', null, null, 'all');
		wp_enqueue_style('pagina-mais-noticias');

	}

	public function custom_formats_admin(){


	}
}

new LoadDependences();