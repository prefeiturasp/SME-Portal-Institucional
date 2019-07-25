<?php
/* Inicialização das Classes */
require_once __ROOT__.'/classes/LoadDependences.php';
require_once __ROOT__.'/classes/Lib/Util.php';

require_once __ROOT__.'/classes/Usuarios/Editor/Editor.php';
require_once __ROOT__.'/classes/Usuarios/Colaborador/Colaborador.php';
require_once __ROOT__.'/classes/Usuarios/EnviarParaRevisao.php';

require_once __ROOT__.'/classes/TemplateHierarchy/Page.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingleCard.php';

require_once __ROOT__.'/classes/Cpt/Cpt.php';
require_once __ROOT__.'/classes/Cpt/CptPosts.php';
require_once __ROOT__.'/classes/Cpt/CptPages.php';
require_once __ROOT__.'/classes/Cpt/CptCard.php';
require_once __ROOT__.'/classes/Cpt/CptAgendaSecretario.php';
require_once __ROOT__.'/classes/Cpt/CptContato.php';
require_once __ROOT__.'/classes/Cpt/CptOrganograma.php';

require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicial.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialIcones.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaquePrimaria.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaqueSecundarias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialTwitter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNewsletter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNuvemDeTags.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaEscolas/PaginaEscolas.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaCards/PaginaCards.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaImagemVideo/PaginaImagemVideo.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAgendaSecretario/PaginaAgendaSecretario.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaAgendaSecretario/PaginaAgendaSecretarioAjaxCalendario.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaContato/PaginaContatoMetabox.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaContato/PaginaContato.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaLayoutColunas/PaginaLayoutColunas.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaOrganograma/PaginaOrganograma.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaOrganograma/PaginaOrganogramaConselhos.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaOrganograma/PaginaOrganogramaSecretario.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaOrganograma/PaginaOrganogramaAssessorias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaOrganograma/PaginaOrganogramaCoordenadorias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaOrganograma/PaginaOrganogramaDres.php';


require_once __ROOT__.'/classes/ModelosDePaginas/ModelosDePaginaRemoveThemeSupport.php';

//require_once __ROOT__.'/classes/ModelosDePaginas/PaginaLayoutColunas/PaginaLayoutColunasAdminSuporte.php';


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