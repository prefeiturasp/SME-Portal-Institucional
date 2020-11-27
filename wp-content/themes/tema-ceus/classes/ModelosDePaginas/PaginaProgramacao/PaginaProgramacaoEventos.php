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
                                            $featured_img_url = get_the_post_thumbnail_url($eventoInterno->ID, 'thumb-eventos');
                                            if($featured_img_url){
                                                $imgEvento = $featured_img_url;
                                                $thumbnail_id = get_post_thumbnail_id( $eventoInterno->ID );
                                                $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);  
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

                                                if($campos['tipo_de_data'] == 'data'){ // Se for do tipo data
                                                    $dataInicial = $campos['data'];
                                                    $dataFinal = $campos['data_final'];

                                                    if($dataFinal){ // Verifica se possui a data final
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $dataFinal = explode("-", $dataFinal);
                                                        $mes = $monthName = date('M', mktime(0, 0, 0, $dataFinal[1], 10));

                                                        $data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];
                                                    } else { // Se nao tiver a final mostra apenas a inicial
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $mes = $monthName = date('M', mktime(0, 0, 0, $dataInicial[1], 10));
                                                        $data = $dataInicial[2] . " " . $mes . " " . $dataInicial[0];
                                                    }
                                                } elseif($campos['tipo_de_data'] == 'semana'){ // se for do tipo semana
                                                    $semana = $campos['semana'];
                                                    
                                                    $total = count($semana); 
                                                    $i = 0;
                                                    $dias = '';

                                                    foreach($semana as $dia){
                                                        $i++;
                                                        if($total - $i == 1){
                                                            $dias .= $dia . " ";
                                                        } elseif($total != $i){
                                                            $dias .= $dia . ", ";
                                                        } else {
                                                            $dias .= "e " . $dia;
                                                        }
                                                    }

                                                    $data = $dias; 
                                                }

                                            }
                                        ?>
                                        <p class="mb-0">
                                            <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $data; ?>
                                            <br>
                                            <?php
                                                // Exibe os horários
                                                $horario = get_field('horario', $eventoInterno->ID);

                                                if($horario['horario']){
                                                    $hora = $horario['horario'];
                                                } else {
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