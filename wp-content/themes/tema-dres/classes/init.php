<?php
/* Inicialização das Classes */

require_once __ROOT__.'/classes/LoadDependences.php';
require_once __ROOT__.'/classes/Lib/Util.php';
require_once __ROOT__.'/classes/Header/Header.php';
require_once __ROOT__.'/classes/Breadcrumb/Breadcrumb.php';
require_once __ROOT__.'/classes/ModelosDePaginas/ModelosDePaginaRemoveThemeSupport.php';

///////////////////////////////////////USUARIOS///////////////////////////////////////
require_once __ROOT__.'/classes/Usuarios/Editor/Editor.php';
require_once __ROOT__.'/classes/Usuarios/Colaborador/Colaborador.php';
require_once __ROOT__.'/classes/Usuarios/Administrador/Administrador.php';
require_once __ROOT__.'/classes/Usuarios/Dre/Dre.php';
require_once __ROOT__.'/classes/Usuarios/EnviarParaRevisao.php';
require_once __ROOT__.'/classes/Usuarios/CamposAdicionais.php';
///////////////////////////////////////USUARIOS///////////////////////////////////////

//////////////////////////////////////////TUTORIAL/////////////////////////////////////////
require_once __ROOT__.'/classes/tutorial/tutorial.php';

//////////////////////////////////////////CPT/////////////////////////////////////////
require_once __ROOT__.'/classes/Cpt/Cpt.php';
require_once __ROOT__.'/classes/Cpt/CptPosts.php';
require_once __ROOT__.'/classes/Cpt/CptPages.php';
require_once __ROOT__.'/classes/Cpt/CptAgendaDre.php';
require_once __ROOT__.'/classes/Cpt/CptContatoPrincipal.php';
require_once __ROOT__.'/classes/Cpt/CptOutrosContatos.php';
//require_once __ROOT__.'/classes/Cpt/CptMediaImages.php';
//////////////////////////////////////////CPT/////////////////////////////////////////

//////////////////////////////////////////TEMPLATE HIERARCHY/////////////////////////////////////////
require_once __ROOT__.'/classes/TemplateHierarchy/Page.php';
require_once __ROOT__.'/classes/TemplateHierarchy/tag.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingle.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleCabecalho.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleMenuInterno.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleNoticiaPrincipal.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleMaisRecentes.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleRelacionadas.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveContatoPrincipal/ArchiveContatoPrincipal.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOutrosContatos/ArchiveOutrosContatos.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgenda.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgendaAjaxCalendario.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgendaGetDatasEventos.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/GetTipoDePost.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/SearchForm.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/LoopSearch.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/SearchFormSingle.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/LoopSearchSingle.php';
//////////////////////////////////////////TEMPLATE HIERARCHY/////////////////////////////////////////

////////////////////////////////////MODELO DE PAGINAS///////////////////////////////////////
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicial.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaquePrimaria.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaqueSecundarias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialEscolares.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialAcervo.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialAgenda.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialEndereco.php';



require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasArrayIdNoticias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasMenu.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasTitulo.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasDestaques.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasProgramasProjetos.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasMaisLidas.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasOutrasNoticias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaMaisNoticias/PaginaMaisNoticiasNewsletter.php';
////////////////////////////////////MODELO DE PAGINAS///////////////////////////////////////

////////////////////////////////////INICIALIZAÇÃO CPTS////////////////////////////////////////
$cptPostsExtend = new \Classes\Cpt\CptPosts();
$cptPagessExtend = new \Classes\Cpt\CptPages();
////////////////////////////////////INICIALIZAÇÃO CPTS////////////////////////////////////////

//////////////////////////////////////AGENDA DRE//////////////////////////////////////
$cptAgendaDre = new \Classes\Cpt\Cpt('agenda', 'agenda', 'Agenda da DRE', 'Todos os Eventos', 'Eventos', 'Eventos', null, null, null, 'dashicons-calendar-alt', true);
$cptAgendaDreExtend = new \Classes\Cpt\CptAgendaDre();
//////////////////////////////////////AGENDA DRE//////////////////////////////////////

//////////////////////////////////////CONTATOS PRINCIPAIS//////////////////////////////////////
$cptContatoPrincipal = new \Classes\Cpt\Cpt('contatoprincipal', 'contatoprincipal', 'Contatos Principais', 'Todos os Contatos', 'Contatos', 'Contatos', null, null, null, 'dashicons-calendar-alt', true);
$cptContatoPrincipalExtend = new \Classes\Cpt\CptContatoPrincipal();
////////////////////////////////////////AGENDA DRE//////////////////////////////////////

////////////////////////////////////// OUTROS CONTATOS//////////////////////////////////////
$cptOutrosContatos = new \Classes\Cpt\Cpt('outroscontatos', 'outroscontatos', 'Outros Contatos', 'Todos os Contatos', 'Contatos', 'Contatos', null, null, null, 'dashicons-calendar-alt', true);
$cptOutrosContatosExtend = new \Classes\Cpt\CptOutrosContatos();
//////////////////////////////////////AGENDA DRE//////////////////////////////////////

//$taxonomiaMediaImages = new \Classes\Cpt\CptMediaImages();