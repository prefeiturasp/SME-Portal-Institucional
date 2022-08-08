<?php
/* Inicialização das Classes */

require_once __ROOT__.'/classes/LoadDependences.php';
require_once __ROOT__.'/classes/Lib/Util.php';
require_once __ROOT__.'/classes/Lib/SimpleXLSXGen.php';

require_once __ROOT__.'/classes/Header/Header.php';

require_once __ROOT__.'/classes/Usuarios/Editor/Editor.php';
require_once __ROOT__.'/classes/Usuarios/Colaborador/Colaborador.php';
require_once __ROOT__.'/classes/Usuarios/Administrador/Administrador.php';
//require_once __ROOT__.'/classes/Usuarios/Dre/Dre.php';
require_once __ROOT__.'/classes/Usuarios/EnviarParaRevisao.php';
require_once __ROOT__.'/classes/Usuarios/CamposAdicionais.php';

//tutorial
require_once __ROOT__.'/classes/tutorial/tutorial.php';

require_once __ROOT__.'/classes/Cpt/Cpt.php';
require_once __ROOT__.'/classes/Cpt/CptPosts.php';
require_once __ROOT__.'/classes/Cpt/CptPages.php';
require_once __ROOT__.'/classes/Cpt/CptCard.php';
require_once __ROOT__.'/classes/Cpt/CptAgendaSecretario.php';
require_once __ROOT__.'/classes/Cpt/CptAgendaSecretarioNew.php';
require_once __ROOT__.'/classes/Cpt/CptContato.php';
require_once __ROOT__.'/classes/Cpt/CptBotao.php';
require_once __ROOT__.'/classes/Cpt/CptCurriculoDaCidade.php';
require_once __ROOT__.'/classes/Cpt/CptConcursos.php';
require_once __ROOT__.'/classes/Cpt/CptSetor.php';

// Agenda DREs
require_once __ROOT__.'/classes/Cpt/CptAgendaDreBt.php'; // DRE Butanta
require_once __ROOT__.'/classes/Cpt/CptAgendaDreCs.php'; // DRE Capela do Socorro
require_once __ROOT__.'/classes/Cpt/CptAgendaDreFb.php'; // DRE Freguesia/Brasilandia

require_once __ROOT__.'/classes/TemplateHierarchy/Page.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Tag.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingleCard.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingle.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleCabecalho.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleMenuInterno.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleNoticiaPrincipal.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleMaisRecentes.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleRelacionadas.php';

require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgendaGetDatasEventos.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveContato/ArchiveContatoMetabox.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveContato/ArchiveContato.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveContato/ExibirContatosTodasPaginas.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgenda.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgendaAjaxCalendario.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaNew/ArchiveAgendaGetDatasEventosNew.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaNew/ArchiveAgendaNew.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaNew/ArchiveAgendaAjaxCalendarioNew.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveCurriculoDaCidade/ArchiveCurriculoDaCidade.php';

require_once __ROOT__.'/classes/TemplateHierarchy/Search/GetTipoDePost.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/SearchForm.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/LoopSearch.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/SearchFormSingle.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/LoopSearchSingle.php';

require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicial.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialIconesDetectMobile.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialIcones.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/Mobile/PaginaInicialIconesMobile.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaquePrimaria.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaqueSecundarias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialTwitter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNewsletter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialFacebook.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbas.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbasContato.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbasBotoes.php';
require_once __ROOT__.'/classes/ModelosDePaginas/LandingPages/Modelo_1.php';
require_once __ROOT__.'/classes/ModelosDePaginas/LandingPages/Modelo_2.php';
require_once __ROOT__.'/classes/ModelosDePaginas/Layout/construtor.php';


require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasArrayIdNoticias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasMenu.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasTitulo.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasDestaques.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasProgramasProjetos.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasMaisLidas.php';
require_once __ROOT__ .'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasOutrasNoticias.php';
require_once __ROOT__ .'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasNewsletter.php';

/*
require_once __ROOT__ .'/classes/ModelosDePaginas/PaginaMapaDres/PaginaMapaDres.php';
require_once __ROOT__ .'/classes/ModelosDePaginas/PaginaMapaDres/PaginaMapaDresMapa.php';
require_once __ROOT__ .'/classes/ModelosDePaginas/PaginaMapaDres/PaginaMapaDresBotoes.php';
require_once __ROOT__ .'/classes/ModelosDePaginas/PaginaMapaDres/PaginaMapaDresBlocosDeTextosAdicionais.php';
*/

require_once __ROOT__.'/classes/BuscaDeEscolas/BuscaDeEscolasRewriteUrl.php';
require_once __ROOT__.'/classes/BuscaDeEscolas/BuscaDeEscolas.php';

require_once __ROOT__.'/classes/Breadcrumb/Breadcrumb.php';

require_once __ROOT__.'/classes/ModelosDePaginas/ModelosDePaginaRemoveThemeSupport.php';

require_once __ROOT__.'/classes/Cpt/CptMediaImages.php';

/* Inicialização CPTs */
$cptPostsExtend = new \Classes\Cpt\CptPosts();
$cptPagessExtend = new \Classes\Cpt\CptPages();
//$cptCard = new \Classes\Cpt\Cpt('card', 'card', 'Card', 'Todos os Cards', 'Cards', 'Card', 'categorias-card', 'Categorias de Cards', 'Categoria de Card', 'dashicons-feedback', true);
//$cptCardExtend = new \Classes\Cpt\CptCard();

$cptAgendaSecretario = new \Classes\Cpt\Cpt('agenda', 'agenda', 'Agenda do Secretário', 'Todos os Eventos', 'Eventos', 'Eventos', null, null, null, 'dashicons-calendar-alt', true);
$cptAgendaSecretarioExtend = new \Classes\Cpt\CptAgendaSecretario();

$cptAgendaSecretario = new \Classes\Cpt\Cpt('agendanew', 'agendanew', 'Agenda do Secretário', 'Todos os Eventos', 'Eventos', 'Eventos', null, null, null, 'dashicons-calendar-alt', true);
$cptAgendaSecretarioNewExtend = new \Classes\Cpt\CptAgendaSecretarioNew();

$cptContatoSme = new \Classes\Cpt\Cpt('contato', 'contato', 'Contatos SME', 'Todos os Contatos', 'Contatos', 'Contato', null, null, null,'dashicons-email-alt', true);
$cptContatoSmeExtend = new \Classes\Cpt\CptContato();
$taxonomiaMediaImages = new \Classes\Cpt\CptMediaImages();

$cptCurriculoDaCidade = new \Classes\Cpt\Cpt('curriculo-da-cidade', 'curriculo-da-cidade', 'Currículo da Cidade', 'Todos os Currículos', 'Currículos da Cidade', 'Currículo da Cidade', 'categorias-curriculo-da-cidade', 'Categorias de Currículos', 'Categoria de Currículo', 'dashicons-format-image', true);
$cptCurriculoDaCidadeExtende = new \Classes\Cpt\CptCurriculoDaCidade();

// Concursos
$cptConcursos = new \Classes\Cpt\Cpt('concurso', 'concurso', 'Cadastro de Concurso', 'Todos os Concursos', 'Concursos', 'Cadastro de Concurso', '', '', '', 'dashicons-external' , true);
$cptConcursosExtend = new \Classes\Cpt\CptConcursos();

$cptSetor = new \Classes\Cpt\Cpt('setor', 'setor', 'Cadastro Setor', 'Todos os Setores', 'Setores', 'Setores', '', '', '', 'dashicons-format-image', true);
$cptSetorExtende = new \Classes\Cpt\CptSetor();

// DRE Butanta
$cptDreBt = new \Classes\Cpt\Cpt('agenda-dre-bt', 'agenda-dre-bt', 'DRE Butantã', 'Todos os Eventos', 'Eventos', 'Eventos', '', '', '', 'dashicons-format-image', true);
$cptDreBtExtende = new \Classes\Cpt\CptAgendaDreBt();

// DRE Capela do Socorro
$cptDreCs = new \Classes\Cpt\Cpt('agenda-dre-cs', 'agenda-dre-cs', 'DRE Capela do Socorro', 'Todos os Eventos', 'Eventos', 'Eventos', '', '', '', 'dashicons-format-image', true);
$cptDreCsExtende = new \Classes\Cpt\CptAgendaDreCs();

// DRE Freguesia/Brasilandia
$cptDreFb = new \Classes\Cpt\Cpt('agenda-dre-fb', 'agenda-dre-fb', 'DRE Freg/Brasilandia', 'Todos os Eventos', 'Eventos', 'Eventos', '', '', '', 'dashicons-format-image', true);
$cptDreFbExtende = new \Classes\Cpt\CptAgendaDreFb();