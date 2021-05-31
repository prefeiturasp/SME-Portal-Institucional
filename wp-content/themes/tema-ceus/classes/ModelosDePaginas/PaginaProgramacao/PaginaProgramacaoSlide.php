<?php


namespace Classes\ModelosDePaginas\PaginaProgramacao;


class PaginaProgramacaoSlide
{

    public function __construct()
	{
		$this->getSlide();
	}

	public function getSlide(){
    ?>
        <div class="slide-principal mt-3 mb-3">
            <div class="container">
                <div class="row">
                    <?php 
                        $slides = get_field('slide');
                        $qtSlide = count($slides);
                        $l = 0;
                        $m = 0;
                        //echo $qtSlide;
                        
                    ?>
                    <div id="carouselExampleIndicators" class="carousel slide col-sm-12" data-ride="carousel">
                        <ol class="carousel-indicators">
                          
                          
                            <?php while($m < $qtSlide) : ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $m; ?>" class="<?php if($m == 0){echo 'active';} ?>"></li>
                            <?php 
                                $m++;
                                endwhile; ?>
                        </ol>
                        <div class="carousel-inner border">

                            <?php foreach($slides as $slide): ?>
                                <div class="carousel-item <?php if($l == 0){echo 'active';} ?>">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <?php 
                                                //$featured_img_url = get_the_post_thumbnail_url($slide->ID, 'slide-eventos');
                                                $imgSelect = get_field('capa_do_evento', $slide->ID);
                                                $featured_img_url = wp_get_attachment_image_src($imgSelect, 'slide-eventos');
                                                
                                                if($featured_img_url){
                                                    $imgSlide = $featured_img_url[0];
                                                } else {
                                                    $imgSlide = 'http://via.placeholder.com/820x380';
                                                }
                                            ?>
                                            <img class="d-block w-100" src="<?php echo  $imgSlide; ?>" alt="Slide ">
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="carousel-categ">
                                                <?php
                                                    $atividades = get_the_terms( $slide->ID, 'atividades_categories' );
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
                                            
                                                <p><a href="#"><?php echo $showAtividades; ?></a></p> 
                                            </div>

                                            <div class="carousel-title">
                                                <p><a href="<?php echo get_permalink( $slide->ID ); ?>"><?php echo $slide->post_title; ?></a></p>
                                            </div>
                                            <?php 
                                                $subTitle = get_field('subtitulo', $slide->ID);
                                                if($subTitle):
                                            ?>
                                                <div class="carousel-subtitle">
                                                    <p>- <?php echo $subTitle; ?></p>
                                                </div>

                                            <?php endif; ?>

                                            <div class="carousel-data">
                                                <?php
                                                    $campos = get_field('data', $slide->ID);
                                                    
                                                    // Verifica se possui campos
                                                    if($campos){

                                                        if($campos['tipo_de_data'] == 'data'){ // Se for do tipo data

                                                            $dataEvento = $campos['data'];

                                                            $dataEvento = explode("-", $dataEvento);
                                                            $mes = $monthName = date('M', mktime(0, 0, 0, $dataEvento[1], 10));
                                                            $data = $dataEvento[2] . " " . $mes . " " . $dataEvento[0];

                                                            $dataFinal = $data;

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
                                                        }

                                                    }
                                                ?>
                                                <p class="mb-0">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $dataFinal; ?>
                                                    <br>
                                                    <?php
                                                        // Exibe os horários
                                                        $horario = get_field('horario', $slide->ID);

                                                        

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
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo convertHour($hora); ?>
                                                </p>
                                                <?php
                                                    $local = get_field('localizacao', $slide->ID);                                                        
                                                    if($local == '31675' || $local == '31244'):
                                                ?>
                                                    <p class="mb-0 mt-1 evento-unidade no-link"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></p>
                                                <?php else: ?>
                                                    <p class="mb-0 mt-1 evento-unidade"><a href="<?php echo get_the_permalink($local); ?>"><i class="fa fa-map-marker" aria-hidden="true"><span>icone unidade</span></i> <?php echo get_the_title($local); ?></a></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                $l++;
                                endforeach; ?>

                            


                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                </div>
            </div>
        </div>
    <?php
	}


}