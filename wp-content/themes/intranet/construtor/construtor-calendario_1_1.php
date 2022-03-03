<?php
use Classes\ModelosDePaginas\PaginaAgendaSecretario\PaginaAgendaSecretario;
use Classes\TemplateHierarchy\ArchiveAgendaNew\ArchiveAgendaNew;
?>
<style>
    .agenda{
        display: none;
    }

    .agenda.agenda-new{
        display: block;
    }
</style>
<div class="container">
    <div class="calendario-construtor">
        <h3>Calendário Escolar</h3>
        
        <?php $pagina_agenda_secretario = new ArchiveAgendaNew(); ?>
    </div>
</div>