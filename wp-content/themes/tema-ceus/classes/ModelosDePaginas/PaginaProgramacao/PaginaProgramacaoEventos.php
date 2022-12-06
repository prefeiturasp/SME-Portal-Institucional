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
                <div class="container d-none d-md-block">
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
                                            //$featured_img_url = get_the_post_thumbnail_url($eventoInterno->ID, 'recorte-unidades');
                                            $imgSelect = get_field('capa_do_evento', $eventoInterno->ID);
                                            $tipo = get_field('tipo_de_evento_selecione_o_evento', $eventoInterno->ID);
                                            $online = get_field('tipo_de_evento_online', $eventoInterno->ID);
                                            $tipoEvento = get_field('tipo_de_evento_tipo', $eventoInterno->ID);

                                            $featured_img_url = wp_get_attachment_image_src($imgSelect, 'recorte-eventos');
                                            if($featured_img_url){
                                                $imgEvento = $featured_img_url[0];
                                                //$thumbnail_id = get_post_thumbnail_id( $eventoInterno->ID );
                                                $alt = get_post_meta($imgSelect, '_wp_attachment_image_alt', true);  
                                            } else {
                                                $imgEvento = get_template_directory_uri().'/img/placeholder_portal_ceus.jpg';
                                                $alt = get_the_title($eventoInterno->ID);
                                            }
                                        ?>
                                        <a href="<?php echo get_the_permalink($eventoInterno->ID); ?>"><img src="<?php echo $imgEvento; ?>" class="img-fluid d-block" alt="<?php echo $alt; ?>"></a>
                                        <?php if($tipo && $tipo != '') : 
                                            echo '<span class="flag-pdf-full">';
                                                echo get_the_title($tipo);
                                            echo '</span>';                                           
                                        endif; ?>                                      

                                        <?php if($online && $online != '') : 
                                            if($tipo && $tipo != ''){
                                                $customClass = 'mt-tags';
                                            }
                                            echo '<span class="flag-online flag-pdf-full ' . $customClass . '">';
                                                echo "Evento Online";
                                            echo '</span>';
                                        endif; ?>
                                    </div>
                                    <div class="card-eventos-content p-2">
                                        <div class="evento-categ border-bottom pb-1">
                                            <?php
                                                $atividades = get_the_terms( $eventoInterno->ID, 'atividades_categories' );
                                                $listaAtividades = array();

                                                $atividadesTotal = count($atividades);

                                                if($atividadesTotal > 1){
                                                    foreach($atividades as $atividade){
                                                        if($atividade->parent != 0){
                                                            $listaAtividades[] = $atividade->term_id;
                                                        } 
                                                    }
                                                } else {
                                                    $listaAtividades[] = $atividades[0]->term_id;
                                                }

                                                $total = count($listaAtividades); 
                                                $k = 0;
                                                $showAtividades = '';

                                                foreach($listaAtividades as $atividade){
                                                    $k++;
                                                    if($k == 1){
                                                        $showAtividades .= '<a href="' . get_home_url() . '?s&atividadesInternas[]=' . $atividade . '">' . get_term( $atividade )->name . "</a>";
                                                    } else {
                                                        $showAtividades .= ' ,<a href="' . get_home_url() . '?s&atividadesInternas[]=' . $atividade . '">' . get_term( $atividade )->name . "</a>";
                                                    }
                                                }
                                            ?>
                                            <?php echo $showAtividades; ?>
                                        </div>
                                        <h3><a href="<?php echo get_the_permalink($eventoInterno->ID); ?>"><?php echo $eventoInterno->post_title; ?></a></h3>
                                        <?php
                                            $campos = get_field('data', $eventoInterno->ID);
                                            
                                            // Verifica se possui campos
                                            if($campos){

                                                //print_r($campos);

                                                if($campos['tipo_de_data'] == 'data'){ // Se for do tipo data
                                                    
                                                    $dataEvento = $campos['data'];

                                                    $dataEvento = explode("-", $dataEvento);
                                                    $mes = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
                                                    $mes = translateMonth($mes);
                                                    $data = $dataEvento[2] . " " . $mes . " " . $dataEvento[0];

                                                    $dataFinal = $data;

                                                } elseif($campos['tipo_de_data'] == 'semana'){ // se for do tipo semana
                                                    
                                                    $semana = $campos['dia_da_semana'];
                                                    $diasSemana = array();
                                                    $show = array();

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
                                                            } elseif($total == 1){
                                                                $diasShow = $diaS;
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
                                                        $mes = date('M', mktime(0, 0, 0, $dataFinal[1], 10));
                                                        $mes = translateMonth($mes);

                                                        $data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];

                                                        $dataFinal = $data;
                                                    } else { // Se nao tiver a final mostra apenas a inicial
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $mes = date('M', mktime(0, 0, 0, $dataInicial[1], 10));
                                                        $mes = translateMonth($mes);
                                                        $data = $dataInicial[2] . " " . $mes . " " . $dataInicial[0];

                                                        $dataFinal = $data;
                                                    }

                                                }

                                            }

                                            if($tipoEvento == 'serie'){
												$participantes = get_field('ceus_participantes',  $eventoInterno->ID);
												$countPart = count($participantes);
												$countPart = $countPart - 1;
												
												$dtInicial = $participantes[0]['data_serie'];
												$dtFinal = $participantes[$countPart]['data_serie'];

												if($dtInicial['tipo_de_data'] == 'data' && $dtFinal['tipo_de_data'] == 'data'){
													
													$dataInicial = explode("-", $dtInicial['data']);
													$dataFinal = explode("-", $dtFinal['data']);
													$mes = date('M', mktime(0, 0, 0, $dataFinal[1], 10));
													$mes = translateMonth($mes);

													$data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];

													$dataFinal = $data;

												} else {
													$dataFinal = 'Múltiplas Datas';
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

                                                                    $hora .= ' às ' . $periodo['periodo_hora_final'];

                                                                }
                                                                
                                                                $k++;
                                                                
                                                            }

                                                        }else {
                                                            $hora = '';
                                                        }
                                            ?>
                                            <?php if($hora) : ?>                                           
                                                <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo convertHour($hora); ?>
                                            <?php endif; ?>
                                            <?php if($tipoEvento == 'serie'): ?>
												<i class="fa fa-clock-o" aria-hidden="true"><span>icone horario</span></i> Múltiplos Horários
											<?php endif; ?>
                                        </p>
                                        <?php
                                            $local = get_field('localizacao', $eventoInterno->ID);                                                        
                                            if($local == '31675' || $local == '31244'):
                                        ?>
                                            <p class="mb-0 mt-1 evento-unidade no-link"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></p>
                                        <?php elseif($tipoEvento == 'serie') : ?>
											<p class="mb-0 mt-1 evento-unidade no-link"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> Múltiplas Unidades</p>
										<?php else: ?>
                                            <p class="mb-0 mt-1 evento-unidade"><a href="<?php echo get_the_permalink($local); ?>"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></a></p>
                                        <?php endif; ?>
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

                <div class="swiper d-block d-md-none">

                    <div class="col-sm-12 tema-eventos-title mb-3">
                        <h3><?php echo $evento['titulo']; ?></h3>
                    </div>
                    
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                    <!-- Slides -->

                        <?php
                            $eventosLista = $evento['eventos'];
                            foreach($eventosLista as $eventoInterno) :
                        ?>
                            <div class="swiper-slide">
                                <div class="card-eventos">
                                    <div class="card-eventos-img">
                                        <?php 
                                            //$featured_img_url = get_the_post_thumbnail_url($eventoInterno->ID, 'recorte-unidades');
                                            $imgSelect = get_field('capa_do_evento', $eventoInterno->ID);
                                            $tipo = get_field('tipo_de_evento_selecione_o_evento', $eventoInterno->ID);
                                            $online = get_field('tipo_de_evento_online', $eventoInterno->ID);
                                            $tipoEvento = get_field('tipo_de_evento_tipo', $eventoInterno->ID);

                                            $featured_img_url = wp_get_attachment_image_src($imgSelect, 'recorte-eventos');
                                            if($featured_img_url){
                                                $imgEvento = $featured_img_url[0];
                                                //$thumbnail_id = get_post_thumbnail_id( $eventoInterno->ID );
                                                $alt = get_post_meta($imgSelect, '_wp_attachment_image_alt', true);  
                                            } else {
                                                $imgEvento = 'https://via.placeholder.com/640x350';
                                                $alt = get_the_title($eventoInterno->ID);
                                            }
                                        ?>
                                        <a href="<?php echo get_the_permalink($eventoInterno->ID); ?>"><img src="<?php echo $imgEvento; ?>" class="img-fluid d-block" alt="<?php echo $alt; ?>"></a>
                                        <?php if($tipo && $tipo != '') : 
                                            echo '<span class="flag-pdf-full">';
                                                echo get_the_title($tipo);
                                            echo '</span>';                                           
                                        endif; ?>                                      

                                        <?php if($online && $online != '') : 
                                            if($tipo && $tipo != ''){
                                                $customClass = 'mt-tags';
                                            }
                                            echo '<span class="flag-online flag-pdf-full ' . $customClass . '">';
                                                echo "Evento Online";
                                            echo '</span>';
                                        endif; ?>
                                    </div>
                                    <div class="card-eventos-content p-2">
                                        <div class="evento-categ border-bottom pb-1">
                                            <?php
                                                $atividades = get_the_terms( $eventoInterno->ID, 'atividades_categories' );
                                                $listaAtividades = array();

                                                $atividadesTotal = count($atividades);

                                                if($atividadesTotal > 1){
                                                    foreach($atividades as $atividade){
                                                        if($atividade->parent != 0){
                                                            $listaAtividades[] = $atividade->term_id;
                                                        } 
                                                    }
                                                } else {
                                                    $listaAtividades[] = $atividades[0]->term_id;
                                                }

                                                $total = count($listaAtividades); 
                                                $k = 0;
                                                $showAtividades = '';

                                                foreach($listaAtividades as $atividade){
                                                    $k++;
                                                    if($k == 1){
                                                        $showAtividades .= '<a href="' . get_home_url() . '?s&atividadesInternas[]=' . $atividade . '">' . get_term( $atividade )->name . "</a>";
                                                    } else {
                                                        $showAtividades .= ' ,<a href="' . get_home_url() . '?s&atividadesInternas[]=' . $atividade . '">' . get_term( $atividade )->name . "</a>";
                                                    }
                                                }
                                            ?>
                                            <?php echo $showAtividades; ?>
                                        </div>
                                        <h3><a href="<?php echo get_the_permalink($eventoInterno->ID); ?>"><?php echo $eventoInterno->post_title; ?></a></h3>
                                        <?php
                                            $campos = get_field('data', $eventoInterno->ID);
                                            
                                            // Verifica se possui campos
                                            if($campos){

                                                //print_r($campos);

                                                if($campos['tipo_de_data'] == 'data'){ // Se for do tipo data
                                                    
                                                    $dataEvento = $campos['data'];

                                                    $dataEvento = explode("-", $dataEvento);
                                                    $mes = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
                                                    $mes = translateMonth($mes);
                                                    $data = $dataEvento[2] . " " . $mes . " " . $dataEvento[0];

                                                    $dataFinal = $data;

                                                } elseif($campos['tipo_de_data'] == 'semana'){ // se for do tipo semana
                                                    
                                                    $semana = $campos['dia_da_semana'];
                                                    $diasSemana = array();
                                                    $show = array();

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
                                                            } elseif($total == 1){
                                                                $diasShow = $diaS;
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
                                                        $mes = date('M', mktime(0, 0, 0, $dataFinal[1], 10));
                                                        $mes = translateMonth($mes);

                                                        $data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];

                                                        $dataFinal = $data;
                                                    } else { // Se nao tiver a final mostra apenas a inicial
                                                        $dataInicial = explode("-", $dataInicial);
                                                        $mes = date('M', mktime(0, 0, 0, $dataInicial[1], 10));
                                                        $mes = translateMonth($mes);
                                                        $data = $dataInicial[2] . " " . $mes . " " . $dataInicial[0];

                                                        $dataFinal = $data;
                                                    }

                                                }

                                            }

                                            if($tipoEvento == 'serie'){
												$participantes = get_field('ceus_participantes',  $eventoInterno->ID);
												$countPart = count($participantes);
												$countPart = $countPart - 1;
												
												$dtInicial = $participantes[0]['data_serie'];
												$dtFinal = $participantes[$countPart]['data_serie'];

												if($dtInicial['tipo_de_data'] == 'data' && $dtFinal['tipo_de_data'] == 'data'){
													
													$dataInicial = explode("-", $dtInicial['data']);
													$dataFinal = explode("-", $dtFinal['data']);
													$mes = date('M', mktime(0, 0, 0, $dataFinal[1], 10));
													$mes = translateMonth($mes);

													$data = $dataInicial[2] . " a " .  $dataFinal[2] . " " . $mes . " " . $dataFinal[0];

													$dataFinal = $data;

												} else {
													$dataFinal = 'Múltiplas Datas';
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

                                                                    $hora .= ' às ' . $periodo['periodo_hora_final'];

                                                                }
                                                                
                                                                $k++;
                                                                
                                                            }

                                                        }else {
                                                            $hora = '';
                                                        }
                                            ?>
                                            <?php if($hora) : ?>                                           
                                                <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo convertHour($hora); ?>
                                            <?php endif; ?>
                                            <?php if($tipoEvento == 'serie'): ?>
												<i class="fa fa-clock-o" aria-hidden="true"><span>icone horario</span></i> Múltiplos Horários
											<?php endif; ?>
                                        </p>
                                        <?php
                                            $local = get_field('localizacao', $eventoInterno->ID);                                                        
                                            if($local == '31675' || $local == '31244'):
                                        ?>
                                            <p class="mb-0 mt-1 evento-unidade no-link"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></p>
                                        <?php elseif($tipoEvento == 'serie') : ?>
											<p class="mb-0 mt-1 evento-unidade no-link"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> Múltiplas Unidades</p>
										<?php else: ?>
                                            <p class="mb-0 mt-1 evento-unidade"><a href="<?php echo get_the_permalink($local); ?>"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        
                        <?php endforeach; ?>
                    </div>                 

                </div>
            </div>

        <?php endforeach; ?>

        
    <?php
	}


}