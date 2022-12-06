<?php
$datas = array();
$sel_dre = get_sub_field('selecione_a_dre');
$args = array(
    'post_type' => $sel_dre,    
    'posts_per_page' => -1
);
$query = new \WP_Query( $args );

if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
    $datas[] = get_field('data_do_evento');
endwhile;

endif;
wp_reset_postdata();

$marc = '[';
$i = 0;
foreach($datas as $data){
    $data = str_replace('/', '\/', $data);
    if($i == 0){
        $marc .= '&quot;' . $data . '&quot;';
    } else {
        $marc .= ',&quot;' . $data . '&quot;';
    }
    $i++;
}

$marc .= ']';

?>

<input type="hidden" name="array_datas_agenda" id="array_datas_agenda" value="[&quot;13\/08\/2022&quot;]">
<input type="hidden" name="array_datas_agenda" id="array_datas_agenda" value="<?= $marc; ?>">
<div class="mt-5">
    <?php

    use Classes\TemplateHierarchy\ArchiveAgendaDre\ArchiveAgendaDre;
    $pagina_agenda_secretario = new ArchiveAgendaDre('dre-bt');

    //$pagina_agenda_secretario->nome = 'dre-bt';
    ?>
</div>
<style>
    .agenda{
        display: none !important;
    }

    .agenda.agenda-dre{
        display: block !important;
    }
</style>