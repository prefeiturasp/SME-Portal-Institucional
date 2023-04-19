<?php
use Classes\ModelosDePaginas\PaginaAgendaSecretario\PaginaAgendaSecretario;
use Classes\TemplateHierarchy\ArchiveAgendaNew\ArchiveAgendaNew;

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

$args = array(
    'post_type' => 'agendanew',    
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
        }
    } else {
        $datas[] = get_field('data_do_evento');
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

?>

<input type="hidden" name="array_datas_agenda" id="array_datas_agenda" value="<?= $marc; ?>">

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