<?php
use Classes\ModelosDePaginas\PaginaAgendaSecretario\PaginaAgendaSecretario;

use Classes\TemplateHierarchy\ArchiveAgenda\ArchiveAgenda;

get_header();
?>
    <style>
        .agenda{
            display: none;
        }

        .agenda.agenda-new{
            display: block;
        }
    </style>
<?php
$pagina_agenda_secretario = new ArchiveAgenda();

get_footer();
