<?php

namespace Classes\TemplateHierarchy\LoopUnidades;

class LoopUnidadesCabecalho extends LoopUnidades{

	public function __construct()
	{
		$this->cabecalhoUnidade();
	}

	public function cabecalhoUnidade(){
        $infoBasicas = get_field('informacoes_basicas');
        //echo "<pre>";
        //print_r($infoBasicas['horario']);
        //echo "</pre>";
    ?>
        <div class="container color-<?php echo $infoBasicas['zona_sp']; ?>" id="Noticias">
            <div class="row info-title border-bottom mb-3">
                <div class="col-md-9 col-sm-12">
                    <h1><?php echo get_the_title(); ?></h1>
                    <p><?php echo $infoBasicas['dre_pertencente']; ?></p>                    
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <select class="form-control" name="forma" onchange="location = this.value;">
                            <option disabled selected value> Selecione outra unidade </option>
                            <?php
                                $argsUnidades = array(
                                    'post_type' => 'unidade',
                                    'posts_per_page' => -1,
                                    'orderby' => 'title',
                                    'order' => 'ASC',
                                    'post__not_in' => array(31244),
                                );

                                $todasUnidades = new \WP_Query( $argsUnidades );
        
                                // The Loop
                                if ( $todasUnidades->have_posts() ) {
                                    
                                    while ( $todasUnidades->have_posts() ) {
                                        $todasUnidades->the_post();
                                        echo '<option value="' . get_the_permalink() .'">' . get_the_title() .'</option>';
                                    }
                                
                                }
                                wp_reset_postdata();
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row info-contacts">            
                <div class="col-sm-12 col-md-4">
                    <p class="title-unidade">Endereço</p>
                    <p class='mb-0'>
                        <?php 
                            if($infoBasicas['endereco'] && $infoBasicas['endereco'] != ''){
                                echo $infoBasicas['endereco'];
                            }

                            if($infoBasicas['numero'] && $infoBasicas['numero'] != ''){
                                echo ', ' . $infoBasicas['numero'];
                            }

                            if($infoBasicas['complemento'] && $infoBasicas['complemento'] != ''){
                                echo ' - ' . $infoBasicas['complemento'];
                            }

                            if($infoBasicas['bairro'] && $infoBasicas['bairro'] != ''){
                                echo ' - ' . $infoBasicas['bairro'];
                            }

                            if($infoBasicas['cep'] && $infoBasicas['cep'] != ''){
                                echo ' - CEP: ' . $infoBasicas['cep'];
                            }
                        ?>
                    </p>
                </div>
                <div class="col-sm-12 col-md-4">
                    <p class="title-unidade">Contato</p>
                    <p class='mb-0'>
                        <?php 
                            $tel_primary = $infoBasicas['telefone']['telefone_principal'];
                            $tel_second = $infoBasicas['telefone']['tel_second'];

                            if($tel_primary && $tel_primary != ''){
                                echo $tel_primary;
                            }
                        
                            if($tel_second && $tel_second != ''){
                                foreach($tel_second as $tel){
                                    echo ' / ' . $tel['telefone_sec'];
                                }
                            }                        
                        ?>
                    </p>
                    <p class='mb-0'>
                        <?php 
                            $email_primary = $infoBasicas['email']['email_principal'];
                            $email_second = $infoBasicas['email']['email_second'];

                            if($email_primary && $email_primary != ''){
                                echo $email_primary;
                            }
                        
                            if($email_second && $email_second != ''){
                                foreach($email_second as $email){
                                    echo '<br>' . $email['email'];
                                }
                            }                        
                        ?>
                    </p>
                </div>
                <div class="col-sm-12 col-md-4">
                    <p class="title-unidade">Horário de funcionamento</p>
                    <p class='mb-0'>
                        <?php
                            $horario = $infoBasicas['horario'];
                            
                            if($horario['dia_abertura'] && $horario['dia_abertura'] != ''){
                                echo $horario['dia_abertura'];
                            }

                            if($horario['dia_fechamento'] && $horario['dia_fechamento'] != ''){
                                echo ' a ' . $horario['dia_fechamento'];
                            }

                            if($horario['horario_abertura'] && $horario['horario_abertura'] != ''){
                                echo ' das ' . $horario['horario_abertura'];
                            }

                            if($horario['horario_fechamento'] && $horario['horario_fechamento'] != ''){
                                echo ' as ' . $horario['horario_fechamento'];
                            }
                        ?>
                    </p>
                    <?php if($horario['horario_de_funcionamento'] && $horario['horario_de_funcionamento'] != '') : ?>
                        <p class='mb-0'>
                            <?php 
                                foreach($horario['horario_de_funcionamento'] as $horario){
                                    if($horario['data_inicial'] && $horario['data_inicial'] != ''){
                                        echo $horario['data_inicial'];
                                    }
        
                                    if($horario['data_final'] && $horario['data_final'] != ''){
                                        echo ' e ' . $horario['data_final'];
                                    }
        
                                    if($horario['hora_abertura'] && $horario['hora_abertura'] != ''){
                                        echo ' das ' . $horario['hora_abertura'];
                                    }
        
                                    if($horario['hora_fechamento'] && $horario['hora_fechamento'] != ''){
                                        echo ' às ' . $horario['hora_fechamento'];
                                    }
                                }
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php
        
    }

}