<?php
/* Inicialização das Classes */
require_once __ROOT__.'/classes/LoadDependences.php';
require_once __ROOT__.'/classes/Lib/Util.php';
require_once __ROOT__.'/classes/Header/Header.php';


////////////CPTS//////////////
require_once __ROOT__.'/classes/Usuarios/Editor/Editor.php';
require_once __ROOT__.'/classes/Usuarios/Colaborador/Colaborador.php';
require_once __ROOT__.'/classes/Usuarios/Administrador/Administrador.php';
require_once __ROOT__.'/classes/Usuarios/EnviarParaRevisao.php';
require_once __ROOT__.'/classes/Usuarios/CamposAdicionais.php';


////////////TUTORIAL//////////////
require_once __ROOT__.'/classes/tutorial/tutorial.php';


////////////CPTS//////////////
require_once __ROOT__.'/classes/Cpt/Cpt.php';
require_once __ROOT__.'/classes/Cpt/CptPosts.php';
require_once __ROOT__.'/classes/Cpt/CptPages.php';
require_once __ROOT__.'/classes/Cpt/CptCard.php';
require_once __ROOT__.'/classes/Cpt/CptAgendaConselho.php';
require_once __ROOT__.'/classes/Cpt/CptMediaImages.php';
require_once __ROOT__.'/classes/Cpt/CptAba.php';
require_once __ROOT__.'/classes/Cpt/CptBotao.php';

////////////TEMPLATE HIERARACHY//////////////
require_once __ROOT__.'/classes/TemplateHierarchy/Page.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingleCard.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingleAgendaConselho.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingle.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleCabecalho.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleMenuInterno.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleNoticiaPrincipal.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleMaisRecentes.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleRelacionadas.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/GetTipoDePost.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/SearchForm.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/LoopSearch.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/SearchFormSingle.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/LoopSearchSingle.php';

////////////MODELOS DE PÁGINAS//////////////
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicial.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialIconesDetectMobile.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialIcones.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/Mobile/PaginaInicialIconesMobile.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaquePrimaria.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaqueSecundarias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialTwitter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNewsletter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialFacebook.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaCards/PaginaCards.php';
require_once __ROOT__.'/classes/ModelosDePaginas/AgendaConselho/PaginaAgendaConselho.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaImagemVideo/PaginaImagemVideo.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaLayoutColunas/PaginaLayoutColunas.php';
require_once __ROOT__.'/classes/ModelosDePaginas/ModelosDePaginaRemoveThemeSupport.php';
//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbas.php';
//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbasTitulos.php';
//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbasContato.php';
//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbasBotoes.php';
//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbasAcoesDestaque.php';
//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbasConteudos.php';
//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaBotoes/PaginaBotoes.php';

////////////BREADCRUMB//////////////
require_once __ROOT__.'/classes/Breadcrumb/Breadcrumb.php';


/* Inicialização CPTs */
$cptPostsExtend = new \Classes\Cpt\CptPosts();
$cptPagessExtend = new \Classes\Cpt\CptPages();
$taxonomiaMediaImages = new \Classes\Cpt\CptMediaImages();


////////////CRIAÇÃO DOS CPTS//////////////
$cptCard = new \Classes\Cpt\Cpt('card', 'card', 'Card', 'Todos os Cards', 'Cards', 'Card', 'categorias-card', 'Categorias de Cards', 'Categoria de Card', 'dashicons-feedback', true);
$cptCardExtend = new \Classes\Cpt\CptCard();

$cptAgendaConselho = new \Classes\Cpt\Cpt('agendaconselho', 'agendaconselho', 'Agenda Conselho', 'Todos as Agendas', 'Agendas Conselho', 'Agenda Conselho', '', '', '', 'dashicons-feedback', true);
$cptAgendaConselhoExtend = new \Classes\Cpt\CptAgendaConselho();

//$cptAbas = new \Classes\Cpt\Cpt('aba', 'aba', 'Cadastro de Abas', 'Todos as Abas', 'Abas', 'Cadastro de Abas', 'categorias-aba', 'Categorias de Abas', 'Categoria de Aba', 'dashicons-index-card' , true);
//$cptAbasExtend = new \Classes\Cpt\CptAba();

//$cptBotao = new \Classes\Cpt\Cpt('botao', 'botao', 'Cadastro de Botões', 'Todos os Botões', 'Botões', 'Cadastro de Botões', 'categorias-botao', 'Categorias de Botões', 'Categoria de Botão', 'dashicons-external' , true);
//$cptBotaoExtend = new \Classes\Cpt\CptBotao();

