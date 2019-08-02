<?php
/* Inicialização das Classes */
require_once __ROOT__.'/classes/LoadDependences.php';
require_once __ROOT__.'/classes/Lib/Util.php';

require_once __ROOT__.'/classes/Usuarios/Editor/Editor.php';
require_once __ROOT__.'/classes/Usuarios/Colaborador/Colaborador.php';
require_once __ROOT__.'/classes/Usuarios/EnviarParaRevisao.php';

require_once __ROOT__.'/classes/Cpt/Cpt.php';
require_once __ROOT__.'/classes/Cpt/CptPosts.php';
require_once __ROOT__.'/classes/Cpt/CptPages.php';
require_once __ROOT__.'/classes/Cpt/CptCard.php';
require_once __ROOT__.'/classes/Cpt/CptAgendaSecretario.php';
require_once __ROOT__.'/classes/Cpt/CptContato.php';
require_once __ROOT__.'/classes/Cpt/CptOrganograma.php';
require_once __ROOT__.'/classes/Cpt/CptBotao.php';

require_once __ROOT__.'/classes/TemplateHierarchy/Page.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingleCard.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveContato/ArchiveContatoMetabox.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveContato/ArchiveContato.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgenda.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgenda/ArchiveAgendaAjaxCalendario.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaDetectMobile.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganograma.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaConselhos.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaSecretario.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaAssessorias.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaCoordenadorias.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/ArchiveOrganogramaDres.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaMobile.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaConselhosMobile.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaSecretarioMobile.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaAssessoriasMobile.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaCoordenadoriasMobile.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveOrganograma/Mobile/ArchiveOrganogramaDresMobile.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/SearchForm.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/LoopSearch.php';

require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicial.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialIcones.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaquePrimaria.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaqueSecundarias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialTwitter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNewsletter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNuvemDeTags.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaCards/PaginaCards.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaImagemVideo/PaginaImagemVideo.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaLayoutColunas/PaginaLayoutColunas.php';
//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbaTrait.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbas.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbaTitulos.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbaBotoes.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbaConteudos.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbaEnderecos.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAbas/PaginaAbaAcoesDestaque.php';

require_once __ROOT__.'/classes/BuscaDeEscolas/BuscaDeEscolasRewriteUrl.php';
require_once __ROOT__.'/classes/BuscaDeEscolas/BuscaDeEscolas.php';

require_once __ROOT__.'/classes/Breadcrumb/Breadcrumb.php';

require_once __ROOT__.'/classes/ModelosDePaginas/ModelosDePaginaRemoveThemeSupport.php';

/* Inicialização CPTs */
$cptPostsExtend = new \Classes\Cpt\CptPosts();
$cptPagessExtend = new \Classes\Cpt\CptPages();
$cptCard = new \Classes\Cpt\Cpt('card', 'card', 'Card', 'Todos os Cards', 'Cards', 'Card', 'categorias-card', 'Categorias de Cards', 'Categoria de Card', 'dashicons-feedback');
$cptCardExtend = new \Classes\Cpt\CptCard();

$cptAgendaSecretario = new \Classes\Cpt\Cpt('agenda', 'agenda', 'Agenda do Secretário', 'Todos os Eventos', 'Eventos', 'Eventos', null, null, null, 'dashicons-calendar-alt');
$cptAgendaSecretarioExtend = new \Classes\Cpt\CptAgendaSecretario();
$cptContatoSme = new \Classes\Cpt\Cpt('contato', 'contato', 'Contatos SME', 'Todos os Contatos', 'Contatos', 'Contato', 'categorias-contato', 'Categorias de Contatos', 'Categoria de Contato','dashicons-email-alt');
$cptContatoSmeExtend = new \Classes\Cpt\CptContato();
$cptOrganograma = new \Classes\Cpt\Cpt('organograma', 'organograma', 'Organograma', 'Todos os Itens', 'Organogramas', 'Organograma', 'categorias-organograma', 'Categorias de Organograma', 'Categoria de Organograma', 'dashicons-networking' );

$cptAbas = new \Classes\Cpt\Cpt('aba', 'aba', 'Cadastro de Abas', 'Todos as Abas', 'Abas', 'Cadastro de Abas', 'categorias-aba', 'Categorias de Abas', 'Categoria de Aba', 'dashicons-index-card' );

$cptBotao = new \Classes\Cpt\Cpt('botao', 'botao', 'Cadastro de Botões', 'Todos os Botões', 'Botões', 'Cadastro de Botões', 'categorias-botao', 'Categorias de Botões', 'Categoria de Botão', 'dashicons-external' );
$cptBotaoExtend = new \Classes\Cpt\CptBotao();