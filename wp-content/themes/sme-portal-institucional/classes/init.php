<?php
/* Inicialização das Classes */

require_once __ROOT__.'/classes/LoadDependences.php';
require_once __ROOT__.'/classes/Lib/Util.php';
require_once __ROOT__.'/classes/Lib/SimpleXLSXGen.php';

require_once __ROOT__.'/classes/Header/Header.php';

require_once __ROOT__.'/classes/Usuarios/Editor/Editor.php';
require_once __ROOT__.'/classes/Usuarios/Colaborador/Colaborador.php';
require_once __ROOT__.'/classes/Usuarios/Administrador/Administrador.php';
require_once __ROOT__.'/classes/Usuarios/Dre/Dre.php';
require_once __ROOT__.'/classes/Usuarios/Conselho/Conselho.php';
require_once __ROOT__.'/classes/Usuarios/ColabPublicador/ColabPublicador.php';
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
//require_once __ROOT__.'/classes/Cpt/CptOrganograma.php';
//require_once __ROOT__.'/classes/Cpt/CptAba.php';
require_once __ROOT__.'/classes/Cpt/CptBotao.php';
require_once __ROOT__.'/classes/Cpt/CptCurriculoDaCidade.php';
require_once __ROOT__.'/classes/Cpt/CptConcursos.php';
require_once __ROOT__.'/classes/Cpt/CptSetor.php';
require_once __ROOT__.'/classes/Cpt/CptFaqs.php';

// Agenda DREs
require_once __ROOT__.'/classes/Cpt/CptAgendaDreBt.php'; // DRE Butanta
require_once __ROOT__.'/classes/Cpt/CptAgendaDreCs.php'; // DRE Capela do Socorro
require_once __ROOT__.'/classes/Cpt/CptAgendaDreFb.php'; // DRE Freguesia/Brasilandia

// Agenda Conselhos
require_once __ROOT__.'/classes/Cpt/CptAgendaConselho.php';

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
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgendaAjaxCalendarioNew.php';

require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaDre/ArchiveAgendaDre.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaDre/ArchiveAgendaAjaxCalendarioDre.php';

require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaNew/ArchiveAgendaGetDatasEventosNew.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaNew/ArchiveAgendaNew.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaNew/ArchiveAgendaAjaxCalendarioNew.php';


//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaDetectMobile.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganograma.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaConselhos.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaSecretario.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaAssessorias.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaCoordenadorias.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaDres.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaRodape.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaMobile.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaConselhosMobile.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaSecretarioMobile.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaAssessoriasMobile.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaCoordenadoriasMobile.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaDresMobile.php';
//require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaRodape.php';


require_once __ROOT__.'/classes/TemplateHierarchy/Search/GetTipoDePost.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/SearchForm.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/LoopSearch.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/SearchFormSingle.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/LoopSearchSingle.php';


require_once __ROOT__.'/classes/ModelosDePaginas/Layout/construtor.php';

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

//$cptAgendaSecretario = new \Classes\Cpt\Cpt('agenda', 'agenda', 'Agenda do Secretário', 'Todos os Eventos', 'Eventos', 'Eventos', null, null, null, 'dashicons-calendar-alt', true);
//$cptAgendaSecretarioExtend = new \Classes\Cpt\CptAgendaSecretario();

$cptAgendaSecretario = new \Classes\Cpt\Cpt('agendanew', 'agendanew', 'Agenda do Secretário', 'Todos os Eventos', 'Eventos', 'Eventos', null, null, null, 'dashicons-calendar-alt', true);
$cptAgendaSecretarioNewExtend = new \Classes\Cpt\CptAgendaSecretarioNew();

$cptContatoSme = new \Classes\Cpt\Cpt('contato', 'contato', 'Contatos SME', 'Todos os Contatos', 'Contatos', 'Contato', null, null, null,'dashicons-email-alt', true);
$cptContatoSmeExtend = new \Classes\Cpt\CptContato();
//$cptOrganograma = new \Classes\Cpt\Cpt('organograma', 'organograma', 'Organograma', 'Todos os Itens', 'Organogramas', 'Organograma', 'categorias-organograma', 'Categorias de Organograma', 'Categoria de Organograma', 'dashicons-networking', true );

//$cptAbas = new \Classes\Cpt\Cpt('aba', 'aba', 'Cadastro de Abas', 'Todos as Abas', 'Abas', 'Cadastro de Abas', 'categorias-aba', 'Categorias de Abas', 'Categoria de Aba', 'dashicons-index-card' , true);
//$cptAbasExtend = new \Classes\Cpt\CptAba();

$taxonomiaMediaImages = new \Classes\Cpt\CptMediaImages();

// Concursos
$cptConcursos = new \Classes\Cpt\Cpt('concurso', 'concurso', 'Cadastro de Concurso', 'Todos os Concursos', 'Concursos', 'Cadastro de Concurso', '', '', '', 'dashicons-external' , true);
$cptConcursosExtend = new \Classes\Cpt\CptConcursos();

$cptSetor = new \Classes\Cpt\Cpt('setor', 'setor', 'Cadastro Setor', 'Todos os Setores', 'Setores', 'Setores', '', '', '', 'dashicons-format-image', true);
$cptSetorExtende = new \Classes\Cpt\CptSetor();

$cptFaq = new \Classes\Cpt\Cpt('educacao-faq', 'educacao-faq', 'FAQs', 'Todos as FAQs', 'FAQ', 'FAQ', null, null, null, 'dashicons-external', true);
$cptFaqExtend = new \Classes\Cpt\CptFaqs();

// DRE Butanta
$cptDreBt = new \Classes\Cpt\Cpt('agenda-dre-bt', 'agenda-dre-bt', 'DRE Butantã', 'Todos os Eventos', 'Eventos', 'Eventos', '', '', '', 'dashicons-format-image', true);
$cptDreBtExtende = new \Classes\Cpt\CptAgendaDreBt();

// DRE Capela do Socorro
$cptDreCs = new \Classes\Cpt\Cpt('agenda-dre-cs', 'agenda-dre-cs', 'DRE Capela do Socorro', 'Todos os Eventos', 'Eventos', 'Eventos', '', '', '', 'dashicons-format-image', true);
$cptDreCsExtende = new \Classes\Cpt\CptAgendaDreCs();

// DRE Freguesia/Brasilandia
$cptDreFb = new \Classes\Cpt\Cpt('agenda-dre-fb', 'agenda-dre-fb', 'DRE Freg/Brasilandia', 'Todos os Eventos', 'Eventos', 'Eventos', '', '', '', 'dashicons-format-image', true);
$cptDreFbExtende = new \Classes\Cpt\CptAgendaDreFb();

// Agenda Conselho
$cptAgendaConselhoCae = new \Classes\Cpt\Cpt('agendaconselhocae', 'agendaconselhocae', 'Agenda CAE Conselho de Alimentação Escolar', 'Todos as Agendas', 'Agendas CAE Conselho de Alimentação Escolar', 'Agenda CAE Conselho de Alimentação Escolar', '', '', '', 'dashicons-feedback', true);
$cptAgendaConselhoCaeExtend = new \Classes\Cpt\CptAgendaConselho();

$cptAgendaConselhoCme = new \Classes\Cpt\Cpt('agendaconselhocme', 'agendaconselhocme', 'Agenda CME Conselho Municipal de Educação', 'Todos as Agendas', 'Agendas CME Conselho Municipal de Educação', 'Agenda CME Conselho Municipal de Educação', '', '', '', 'dashicons-feedback', true);
$cptAgendaConselhoCmeExtend = new \Classes\Cpt\CptAgendaConselho();

$cptAgendaConselhoCacs = new \Classes\Cpt\Cpt('agendaconselhocacs', 'agendaconselhocacs', 'Agenda CACS Conselho de Acompanhamento e Controle Social do FUNDEB', 'Todos as Agendas', 'Agendas CACS Conselho de Acompanhamento e Controle Social do FUNDEB', 'Agenda CACS Conselho de Acompanhamento e Controle Social do FUNDEB', '', '', '', 'dashicons-feedback', true);
$cptAgendaConselhoCacsExtend = new \Classes\Cpt\CptAgendaConselho();

$cptAgendaConselhoCrece = new \Classes\Cpt\Cpt('agendaconselhocrece', 'agendaconselhocrece', 'Agenda CRECE Conselho de Representantes de Conselhos de Escola', 'Todos as Agendas', 'Agendas CRECE Conselho de Representantes de Conselhos de Escola', 'Agenda CRECE Conselho de Representantes de Conselhos de Escola', '', '', '', 'dashicons-feedback', true);
$cptAgendaConselhoCreceExtend = new \Classes\Cpt\CptAgendaConselho();