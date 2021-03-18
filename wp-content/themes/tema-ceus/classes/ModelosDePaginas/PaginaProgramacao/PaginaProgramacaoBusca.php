<?php


namespace Classes\ModelosDePaginas\PaginaProgramacao;


class PaginaProgramacaoBusca
{

    public function __construct()
	{
		$this->getBusca();
	}

	public function getBusca(){
    ?>
        <div class="search-home py-4" id='programacao'>
            <div class="container">
                
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h1>Encontre atividades que você goste</h1>
                        <p>As melhores atividades diretamente dos CEUs para a comunidade</p>
                        <?php 
                            
                            // Atividades
                            $terms = get_terms( array( 
                                'taxonomy' => 'atividades_categories',
                                'parent'   => 0,                                
                                'hide_empty' => false
                            ) );

                            // Publico Alvo
                            $publicos = get_terms( array( 
                                'taxonomy' => 'publico_categories',
                                'parent'   => 0,                                
                                'hide_empty' => false
                            ) );

                            // Faixa Etaria
                            $faixas = get_terms( array( 
                                'taxonomy' => 'faixa_categories',
                                'parent'   => 0,                                
                                'hide_empty' => false
                            ) );

                            // Unidades
                            $unidades = get_terms( array( 
                                'taxonomy' => 'category',
                                'parent'   => 0,                                
                                'hide_empty' => false,
                                'exclude' => 1
                            ) );

                            // Periodo
                            $periodos = get_terms( array( 
                                'taxonomy' => 'periodo_categories',
                                'parent'   => 0,                                
                                'hide_empty' => false,
                                'exclude' => 1
                            ) );

                            //echo "<pre>";
                            //print_r($terms);
                            //echo "</pre>";

                            
                        ?>
                    </div>
                    <form action="<?php echo home_url( '/' ); ?>"  id="searchform" class="row col-sm-12">
                        <input id="prodId" name="tipo" type="hidden" value="programacao">
                        <input name="s" type="hidden" value="busca">
                        <div class="col-sm-3 mt-2 px-1">
                            <select name="atividades[]" multiple="multiple" class="ms-list-1" style="">
                                <?php foreach($terms as $term): ?>
                                    <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                                <?php endforeach; ?>                                                        
                            </select>
                        </div>

                        <div class="col-sm-3 mt-2 px-1">
                            <select name="atividadesInternas[]" multiple="multiple" class="ms-list-2" style="">                                
                            </select>
                        </div>

                        <div class="col-sm-3 mt-2 px-1">
                            <select name="publico[]" multiple="multiple" class="ms-list-3" style="">                        
                                <?php foreach ($publicos as $publico): ?>
                                    <option value="<?php echo $publico->term_id; ?>"><?php echo $publico->name; ?></option>
                                <?php endforeach; ?>                    
                            </select>
                        </div>

                        <div class="col-sm-3 mt-2 px-1">
                            <select name="faixaEtaria[]" multiple="multiple" class="ms-list-4" style="">                        
                                <?php foreach ($faixas as $faixa): ?>
                                    <option value="<?php echo $faixa->term_id; ?>"><?php echo $faixa->name; ?></option>
                                <?php endforeach; ?>                      
                            </select>
                        </div>

                        <div class="col-sm-3 mt-3 px-1">
                            <select name="unidades[]" multiple="multiple" class="ms-list-5" style="">
                                <?php
                                        $currentID = get_the_id();
                                        $argsUnidades = array(
                                            'post_type' => 'unidade',
                                            'posts_per_page' => -1,
                                            'post__not_in' => array(31675, 31244),
                                        );

                                        $todasUnidades = new \WP_Query( $argsUnidades );
                
                                        // The Loop
                                        if ( $todasUnidades->have_posts() ) {
                                            
                                            while ( $todasUnidades->have_posts() ) {
                                                $todasUnidades->the_post();
                                                if($currentID == get_the_id() ) {
                                                    echo '<option selected value="' . get_the_id() .'">' . get_the_title() .'</option>';
                                                } else {
                                                    echo '<option value="' . get_the_id() .'">' . get_the_title() .'</option>';
                                                }
                                                
                                            }
                                        
                                        }
                                        wp_reset_postdata();
                                    ?>      
                            </select>
                        </div>

                        <div class="col-sm-3 mt-3 px-1">
                        <select name='tipoData' class="form-control" id="tipoData">
                            <option value="" disabled selected>Selecione o tipo de data</option>
                            <option value='dia_semana'>Dia da Semana</option>
                            <option value='intervalo'>Intervalo de data</option>
                            <option value='mes'>Mês</option>
                        </select>
                        </div>

                        <div class="col-sm-3 mt-3 px-1">
                            
                            <div id='date-range' style='display: none;'>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start" />
                                    <span class="input-group-addon">até</span>
                                    <input type="text" class="input-sm form-control" name="end" />
                                </div>
                            </div>
                            <div id="date-periode">
                                <select name="data[]" multiple="multiple" class="ms-list-10" style="">                        
                                    <option value="" disabled selected>Selecione a(s) data(s)</option>                   
                                </select>
                            </div>
                            
                        </div>

                        <div class="col-sm-3 mt-3 px-1">
                            <select name="periodos[]" multiple="multiple" class="ms-list-8" style="">                        
                                <option value='manha'>Manhã</option>
                                <option value='tarde'>Tarde</option>
                                <option value='noite'>Noite</option>                        
                            </select>
                        </div>
                        <div class="col-sm-12 text-right mt-3">
                            <button type="submit" class="btn btn-search rounded-0">Buscar</button>
                        </div>
                        
                    </form> <!-- end form -->
                </div> <!-- end row -->
            </div>
        </div>
    <?php
	}


}