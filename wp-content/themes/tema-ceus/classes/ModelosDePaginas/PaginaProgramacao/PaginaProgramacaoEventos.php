<?php


namespace Classes\ModelosDePaginas\PaginaProgramacao;


class PaginaProgramacaoEventos
{

    public function __construct()
	{
		$this->getEventos();
	}

	public function getEventos(){
    ?>
        <?php

            $temaEventos = get_field('eventos');

            //echo "<pre>";
            //print_r($temaEventos);
            //echo "</pre>";
        ?>

        <?php foreach($temaEventos as $evento) : ?>

            <div class="tema-eventos my-4">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 tema-eventos-title mb-3">
                            <h3><?php echo $evento['titulo']; ?></h3>
                        </div>
                        <?php
                            $eventosLista = $evento['eventos'];
                            foreach($eventosLista as $eventoInterno) :
                        ?>
                            <div class="col-sm-3">
                                <div class="card-eventos">
                                    <div class="card-eventos-img">
                                        <?php 
                                            //$featured_img_url = get_the_post_thumbnail_url($eventoInterno->ID, 'thumb-eventos');
                                            $imgSelect = get_field('capa_do_evento', $eventoInterno->ID);
                                            $featured_img_url = wp_get_attachment_image_src($imgSelect, 'thumb-eventos');
                                            if($featured_img_url){
                                                $imgEvento = $featured_img_url[0];
                                                //$thumbnail_id = get_post_thumbnail_id( $eventoInterno->ID );
                                                $alt = get_post_meta($imgSelect, '_wp_attachment_image_alt', true);  
                                            } else {
                                                $imgEvento = 'https://via.placeholder.com/575x297';
                                                $alt = get_the_title($eventoInterno->ID);
                                            }
                                        ?>
                                        <a href="#"><img src="<?php echo $imgEvento; ?>" class="img-fluid d-block" alt="<?php echo $alt; ?>"></a>
                                    </div>
                                    <div class="card-eventos-content p-2">
                                        <div class="evento-categ border-bottom pb-1">
                                            <?php
                                                $atividades = get_the_terms( $eventoInterno->ID, 'atividades_categories' );
                                                $listaAtividades = array();
                                                foreach($atividades as $atividade){
                                                    if($atividade->parent != 0){
                                                        $listaAtividades[] = $atividade->name;
                                                    }
                                                }

                                                $total = count($listaAtividades); 
                                                $k = 0;
                                                $showAtividades = '';

                                                foreach($listaAtividades as $atividade){
                                                    $k++;
                                                    if($total - $k == 1 || $total - $k == 0){
                                                        $showAtividades .= $atividade . " ";
                                                    } elseif($total != $k){
                                                        $showAtividades .= $atividade . ", ";
                                                    } else {
                                                        $showAtividades .= "e " . $atividade;
                                                    }
                                                }
                                            ?>
                                            <a href="#"><?php echo $showAtividades; ?></a>
                                        </div>
                                        <h3><a href="<?php echo get_the_permalink(); ?>"><?php echo $eventoInterno->post_title; ?></a></h3>
                                        <?php
                                            $campos = get_field('data', $eventoInterno->ID);
                                            
                                            // Verifica se possui campos
                                            if($campos){

                                                //print_r($campos);

                                                if($campos['tipo_de_data'] == 'data'){ // Se for do tipo data
                                                    
                                                    $dataEvento = $campos['data'];

                                                    $dataEvento = explode("-", $dataEvento);
                                                    $mes = $monthName = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
                                                    $data = $dataEvento[2] . " " . $mes . " " . $dataEvento[0];

                                                    $dataFinal = $data;

                                                } elseif($campos['tipo_de_data'] == 'semana'){ // se for do tipo semana
                                                    
                                                    $semana = $campos['dia_da_semana'];													
													
                                                    $diasSemana = array();

                                                    foreach($semana as $dias){

                                                        $total = count($dias['selecione_os_dias']); 
                                                        $i = 0;
                                                        $diasShow = '';
                                                        
                                                        foreach($dias['selecione_os_dias'] as $diaS){
                                                            $i++;
                                                            //echo $dia . "<br>";
                                                            if($total - $i == 1){
                                                                $diasShow .= $diaS . " ";
                                                            } elseif($total != $i){
                                                                $diasShow .= $diaS . ", ";
                                                            } else {
                                                                $diasShow .= "e " . $diaS;
                                                            }	
                                                                                                                    
                                                        }

                                                        $show[] = $diasShow;
                                                    }
                                                    
                                                    $totalDias = count($show);
                                                    $j = 0;	
                                                    
                                                    $dias = '';

                                                    foreach($show as $diaShow){
                                                        $j++;
                                                        if($j == 1){
                                                            $dias .= $diaShow . " ";                                                        
                                                        } else {
                                                            $dias .= "/ " . $diaShow;
                                                        }
                                                    }

                                                    $dataFinal = $dias; 

                                                    $dias = '';
                                                    $show = '';
                                                    
                                                } elseif($campos['tipo_de_data'] == 'periodo'){
                                                    
                                                    $dataInicial = $campos['data'];
                                                    $dataFinal = $campos['data_final'];

                                                    if($dataFinal){ // Verifica se possui a data final
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $dataFinal = explode("-", $dataFinal);
                                                        $mes = $monthName = date('M', mktime(0, 0, 0, $dataFinal[1], 10));

                                                        $data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];

                                                        $dataFinal = $data;
                                                    } else { // Se nao tiver a final mostra apenas a inicial
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $mes = $monthName = date('M', mktime(0, 0, 0, $dataInicial[1], 10));
                                                        $data = $dataInicial[2] . " " . $mes . " " . $dataInicial[0];

                                                        $dataFinal = $data;
                                                    }

                                                }

                                            } 
                                        ?>
                                        <p class="mb-0">
                                            <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $dataFinal; ?>
                                            <br>
                                            <?php
                                               // Exibe os horários
                                                        $horario = get_field('horario', $eventoInterno->ID);

                                                        

                                                        if($horario['selecione_o_horario'] == 'horario'){
                                                            $hora = $horario['hora'];
                                                        } elseif($horario['selecione_o_horario'] == 'periodo'){
                                                            
                                                            $hora = '';
                                                            $k = 0;
                                                            
                                                            foreach($horario['hora_periodo'] as $periodo){
                                                                //print_r($periodo['periodo_hora_final']);
                                                                
                                                                if($periodo['periodo_hora_inicio']){

                                                                    if($k > 0){
                                                                        $hora .= ' / ';
                                                                    }

                                                                    $hora .= $periodo['periodo_hora_inicio'];

                                                                } 
                                                                
                                                                if ($periodo['periodo_hora_final']){

                                                                    $hora .= ' ás ' . $periodo['periodo_hora_final'];

                                                                }
                                                                
                                                                $k++;
                                                                
                                                            }

                                                        }else {
                                                            $hora = '';
                                                        }
                                            ?>
                                            <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $hora; ?>
                                        </p>
                                        <?php
                                            $post_categories = wp_get_post_categories( $eventoInterno->ID );
                                            $cats = array();
                                            
                                            foreach($post_categories as $c){
                                                $cat = get_category( $c );
                                                $cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
                                            }

                                            $total = count($post_categories); 
                                            $j = 0;
                                            $unidades = '';

                                            foreach($cats as $unidade){
                                                $j++;
                                                if($total - $j == 1 || $total - $j == 0){
                                                    $unidades .= $unidade['name'] . " ";
                                                } elseif($total != $j){
                                                    $unidades .= $unidade['name'] . ", ";
                                                } else {
                                                    $unidades .= "e " . $unidade['name'];
                                                }
                                            }


                                            
                                        ?>
                                        <p class="mb-0 mt-1 evento-unidade"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $unidades; ?></a></p>
                                    </div>
                                </div>
                                <?php 
                                    //$campos = get_field('horario', $eventoInterno->ID);
                                    $term_obj_list = get_the_terms( $eventoInterno->ID, 'atividades_categories' );
                                    $terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
                                    //echo "<pre>";
                                    //print_r($listaAtividades);
                                    //echo "</pre>";
                                ?>
                            </div>
                        <?php
                            endforeach;
                        ?>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

        
    <?php
	}


}