<?php

use Classes\TemplateHierarchy\ArchiveOrganograma\ArchiveOrganograma;

get_header();

$archive_organograma = new ArchiveOrganograma();
$archive_organograma->init();

get_footer();
