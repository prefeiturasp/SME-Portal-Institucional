<?php

$datas = array();
$sel_dre = get_sub_field('selecione_a_dre');

function data_periodo($dataIni, $dataFin){
	$dataIni = implode('-', array_reverse(explode('/', $dataIni)));
	$dataFin = implode('-', array_reverse(explode('/', $dataFin)));

    $inicial = new DateTime( $dataIni );
    $final = new DateTime( $dataFin );
    $final = $final->modify( '+1 day' ); 

    $intervalo = new DateInterval('P1D');
    $periodo = new DatePeriod($inicial, $intervalo ,$final);

    return $periodo;
}

$datas = array();
$anos = array();

$args = array(
    'post_type' => $sel_dre,    
    'posts_per_page' => -1
);
$query = new \WP_Query( $args );

if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
    $tipo = get_field('tipo_de_data');
    if($tipo){
        $dataIni = get_field('data_do_evento');
	    $dataFin = get_field('data_evento_final');
        $periodo = data_periodo($dataIni, $dataFin);
        foreach ($periodo as $key => $value) {
            $datas[] = $value->format('d/m/Y');
            $anos[] = intval($value->format('Y'));
        }
    } else {
        $datas[] = get_field('data_do_evento');

        $dataString = get_field('data_do_evento');
        $dataObjeto = \DateTime::createFromFormat('d/m/Y', $dataString);
        $ano = substr($dataString, -4);

        $anos[] = intval($ano);
    }

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

$anos = array_unique($anos);
$anos = array_filter($anos);

$menorAno = min($anos);
$maiorAno = max($anos);

?>
<style>
    .agenda-new,
    .agenda{
        display: none;
    }

    .agenda-dre{
        display: block;
    }
</style>
<input type="hidden" name="array_datas_agenda" id="array_datas_agenda" value="[&quot;13\/08\/2022&quot;]">
<input type="hidden" name="array_datas_agenda" id="array_datas_agenda" value="<?= $marc; ?>">
<input type="hidden" name="array_anos" id="array_anos" value="<?= $menorAno . '-' . $maiorAno; ?>">
<div class="mt-5 classe-aqui">
    <?php

    use Classes\TemplateHierarchy\ArchiveAgendaDre\ArchiveAgendaDre;
    $pagina_agenda_secretario = new ArchiveAgendaDre($sel_dre);

    //$pagina_agenda_secretario->nome = 'dre-bt';
    ?>
</div>