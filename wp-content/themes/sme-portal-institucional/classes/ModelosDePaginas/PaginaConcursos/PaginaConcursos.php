<?php

namespace Classes\ModelosDePaginas\PaginaConcursos;

use Classes\Lib\Util;
use Classes\TemplateHierarchy\ArchiveContato\ExibirContatosTodasPaginas;

class PaginaConcursos extends Util
{
	protected $page_id;
	protected $args_concursos;
    protected $query_concursos;
    protected $getYear;

	public function __construct()
	{
		$this->page_id = get_the_ID();
		$util = new Util($this->page_id);
        $util->montaHtmlLoopPadrao();
		$this->montaQueryConcurso();
		$this->montaHtmlConcurso();

		$contato_todas_paginas = new ExibirContatosTodasPaginas($this->page_id);
		$contato_todas_paginas->init();


    }
    
    

	public function montaQueryConcurso()
	{
        
        
		$this->args_concurso = array(
            'post_type' => 'concurso',
            'posts_per_page' => 999999,
            'orderby' => 'title',
            'order' => 'ASC',
		);
        $this->query_concurso = new \WP_Query($this->args_concurso);
        

	}

	public function montaHtmlConcurso()
	{
        
        function convertDate($date){
            $newDate = explode('-', $date);
            
            $dataPadrao = $newDate[2] . '/' . $newDate[1] . '/' . $newDate[0];
            return $dataPadrao;
        }

        $lastEdit = new \WP_Query( array(
            'post_type'   => 'concurso',
            'posts_per_page' => 1,
            'orderby'     => 'modified',
        ));

        $date = $lastEdit->post->post_modified;
        $lastEdit = new \DateTime($date);

        $lista = $_GET['view'];
        if(!$lista){
            echo '<section class="container">';
            echo '<section class="row">';
            echo '<section class="col-lg-12 col-xs-12 d-flex align-content-start flex-wrap">';

            function getAno($anos) {

                $allyears = array();
                $returnYears = array();
        
                foreach($anos as $rdate){
                    $year = explode('-', $rdate);
                    $allyears[] = $year[0];
                }

                rsort($allyears);

                $arrlength = count($allyears);

                for($x = 0; $x < $arrlength; $x++) {
                    $returnYears[] = $allyears[$x];              
                } 

                $returnYears = array_unique($returnYears);
        
                return $returnYears;
            }

            $titleConc = array();
            $anoHomolog = array();
            $anoValidade = array();
            $status = array();

            if ($this->query_concurso->have_posts()) : while ($this->query_concurso->have_posts()) : $this->query_concurso->the_post();

                
                $titleConc[] = get_the_title();
                $anoHomolog[] = get_field( "homologacao");
                $anoValidade[] = get_field( "validade");
                $status[] = get_field( "status");


            endwhile;
            endif;
            wp_reset_postdata();
        ?>
            
            <div class="shadow-sm col-md-10 p-3 mb-3 bg-white rounded">
                
                <form class="needs-validation" novalidate action="<?php echo site_url('/concursos-sme/'); ?>" method="get" id="searchform">
                    <div class="form-row">
                        <div class="col-md-12 my-3">
                            
                            <div class="input-group btn-busca">                            
                                <input type="text" class="form-control" placeholder="Pesquisar" name='s'>
                                <button type="submit" alt='Buscar por concursos' class="btn rounded-circle"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>     
                                    
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltipUsername">Cargo/ Função</label>
                            <div class="input-group">                            
                                <select name='cargo' class="custom-select">
                                    <option selected value=''>Selecione um cargo</option>
                                    <?php 
                                        foreach($titleConc as $title){
                                            echo "<option value='$title'>$title</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="validationTooltipUsername">Homologação</label>
                            <div class="input-group">                            
                                <select name="ano-hom" class="custom-select">
                                    <option selected value=''>Selecione ano</option>
                                    <?php
                                        $anosHomolog = getAno($anoHomolog);
                                        foreach($anosHomolog as $ano){
                                            echo "<option value='$ano'>$ano</option>";
                                        }                                    
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="validationTooltipUsername">Validade</label>
                            <div class="input-group">                            
                                <select name="ano-val" class="custom-select">
                                    <option selected value=''>Selecione ano</option>
                                    <?php
                                        $anosValidade = getAno($anoValidade);
                                        foreach($anosValidade as $ano){
                                            echo "<option value='$ano'>$ano</option>";
                                        }                                    
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="validationTooltipUsername">Status</label>
                            <div class="input-group">                            
                                <select name="status" class="custom-select">
                                    <option selected value=''>Selecione</option>
                                    <?php 
                                        $status = array_unique($status);
                                        foreach($status as $statu){
                                            echo "<option value='$statu'>$statu</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    
                    <input type="hidden" name="post_type" value="concurso" />
                    
                </form>

                <hr>

            </div>

            <div class="shadow-sm col-md-10 p-3 mb-1 bg-white rounded concurso-legendas">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <p><strong>LEGENDA:</strong></p>
                        <?php echo get_field( "legenda_coluna_1"); ?>
                    </div>
                    <div class="col-md-6">
                        <br>
                        <?php echo get_field( "legenda_coluna_2"); ?>
                    </div>
                    
                </div>
            </div>

            <div class="col-md-10 mb-3 text-atualiza">
                <p class="text-right">Ultima Atualização: <?php echo $lastEdit->format('d/m/Y'); ?></p>
            </div>

            <div class="col-md-10 mb-5 text-center">
                <h3><a href="<?php echo site_url('/concursos-sme/?view=lista'); ?>">Ver todos os consursos SME</a></h3>              
            </div>

        <?php 
            echo '</section>';
            echo '</section>';
            echo '</section>';

        }
        
        // ver lista completa 
        if($lista){
            echo '<section class="container">';
            echo '<section class="row">';
            echo '<section class="col-lg-12 col-xs-12 d-flex align-content-start flex-wrap">';
        ?>
            <div class="col-md-12 mt-4 text-atualiza">
                <p class="text-right mb-1">Ultima Atualização: <?php echo $lastEdit->format('d/m/Y'); ?></p>
            </div>
        <?php
            echo '<table class="table table-bordered shadow-sm rouded">';
        ?>
            <tr>
                <td colspan='5' class='py-3'><i class="fa fa-users text-primary" aria-hidden="true"></i>&nbsp; Formação dos Profissionais</td>
            </tr>
            <tr class='text-center'>
                <th>Cargo</th>
                <th>Homologação</th>
                <th>Validade</th>
                <th>Última chamada</th>
                <th>Últimos convocados</th>
            </tr>
        <?php

            
                if ($this->query_concurso->have_posts()) : while ($this->query_concurso->have_posts()) : $this->query_concurso->the_post();

        ?>
                <tr>

                    <?php
                        $titleurl = get_field( "link_noticias");
                        if($titleurl) :
                    ?>                                    
                       <td class='align-middle'><a href="<?php echo $titleurl; ?>"><strong><?php the_title(); ?><strong></a></td>
                    <?php else: ?>
                        <td class='align-middle'><strong><?php echo get_the_title(); ?></strong></td>
                    <?php endif; ?>
                    
                    
                    <?php
                        // Verifica data de hologacao
                        $datahom = get_field("homologacao");
                        if($datahom):
                        
                        $dtHomolog = convertDate($datahom);
                    ?>
                            
                        <?php
                            // Verifica se tem DOC
                            $dochom = get_field( "doc_homologacao");
                            if($dochom):
                        ?>
                            <td class='text-center align-middle'><strong><a href="<?php echo $dochom; ?>">DOC - <?php echo $dtHomolog; ?></a></strong></td>
                        <?php else: ?>
                            <td class='text-center align-middle'><?php echo $dtHomolog; ?></td>
                        <?php endif; ?>
                    
                    <?php else: ?>
                        <td class='text-center align-middle'>-</td>
                    <?php endif; ?>


                    <?php
                        // Verifica data de Validade
                        $validade = get_field("validade");
                
                        if($validade):
                        
                        $dtValidade = convertDate($validade);
                    ?>

                        <td class='text-center align-middle'><?php echo $dtValidade; ?></td>
                    
                    <?php else: ?>
                        <td class='text-center align-middle'>-</td>
                    <?php endif; ?>    
                    
                    
                    
                    
                    
                    <?php
                        // Verifica data de hologacao
                        $datahom = get_field("ultima_chamada");
                        if($datahom):
                        
                        $dtHomolog = convertDate($datahom);
                    ?>
                            
                        <?php
                            // Verifica se tem DOC
                            $dochom = get_field( "doc_ultima_chamada");
                            if($dochom):
                        ?>
                            <td class='text-center align-middle'><strong><a href="<?php echo $dochom; ?>">DOC - <?php echo $dtHomolog; ?></a></strong></td>
                        <?php else: ?>
                            <td class='text-center align-middle'><?php echo $dtHomolog; ?></td>
                        <?php endif; ?>
                    
                    <?php else: ?>
                        <td class='text-center align-middle'>-</td>
                    <?php endif; ?>


                    <?php
                        // Verifica Ultimos Convocados
                        $ultimos_convocados = get_field("ultimos_convocados");
                
                        if($ultimos_convocados):
                        
                       
                    ?>

                        <td class='text-center align-middle'><strong><?php echo $ultimos_convocados; ?></strong></td>
                    
                    <?php else: ?>
                        <td class='text-center align-middle'>-</td>
                    <?php endif; ?>    
                    
                </tr>
                
        <?php      

                endwhile;
                endif;
                wp_reset_postdata();
            echo '</table>';
        ?>
            <div class="shadow-sm col-md-12 p-3 mt-3 mb-5 rounded concurso-legendas">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <p><strong>LEGENDA:</strong></p>
                        <?php echo get_field( "legenda_coluna_1"); ?>
                    </div>
                    <div class="col-md-6">
                        <br>
                        <?php echo get_field( "legenda_coluna_2"); ?>
                    </div>
                    
                </div>
            </div>

            <div class="col-md-12 mb-5 text-center">
                <h3><a href="<?php echo get_the_permalink(); ?>">Voltar para a busca</a></h3>              
            </div>
        <?php
            echo '</table>';
            echo '</section>';
            echo '</section>';
            echo '</section>';
        
        }
    }

}