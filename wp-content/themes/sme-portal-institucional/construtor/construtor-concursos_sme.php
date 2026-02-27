<?php
    $titulo = get_sub_field('titulo');
    if($_GET['view'] == 'all' && get_sub_field('titulo_ver_todos') != ''){
        $titulo = get_sub_field('titulo_ver_todos');
    }
    $legenda = get_sub_field('legenda');
    $verTodos = get_sub_field('ativar_ver_todos');
    $cargos = array();

    // Pegar somente o ano das datas e agrupa-los
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

    // Converter a data para o padrao dd/mm/aaaa
    function convertDate($date){
        $newDate = explode('-', $date);
        
        $dataPadrao = $newDate[2] . '/' . $newDate[1] . '/' . $newDate[0];
        return $dataPadrao;
    }

    $args = array(
        'post_type' => 'concurso',
        'posts_per_page' => 999,
        'orderby' => 'title',
        'order' => 'ASC',
    );

    // The Query
    $the_query = new WP_Query( $args );
    
    // The Loop
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $cargos[] = get_the_id();
            $anoHomolog[] = get_field("homologacao");
            $anoValidade[] = get_field( "validade");
            $status[] = get_field("status");
        }
        wp_reset_postdata();      
    } 
    /* Restore original Post Data */
    wp_reset_postdata();

    //echo "<pre>";
    //print_r($anoValidade);
    //echo "</pre>";
?>

<?php if(isset($_GET['view']) && $_GET['view'] == 'all'): ?>
    <div class="container-fluid p-0 mt-4 mb-5">
        <div class="ver-todos">
            <p><a href="<?= get_the_permalink(); ?>">Voltar para a busca</a></p>
        </div>        
    </div>
<?php endif; ?>

<div class="container">
    <div class="row">
        <?php if($titulo && $titulo != ''): ?>
            <div class="col-12 concurso-titulo">
                <h2><?= $titulo; ?></h2>
            </div>
        <?php endif; ?>
    </div>

    <form class="form-concursos">
        <div class="row">
            <div class="col-md-6">       
                <div class="form-group">
                    <label for="labelTermos">Termo(s)</label>
                    <input type="text" name="search" id="labelTermos" value="<?= $_GET['search']; ?>" class="form-control" placeholder="Busque por título ou palavra-chave">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="labelTermos">Cargo/ Função</label>
                    <select class="form-control" name="cargo">
                        <option value="">Selecione um cargo/função</option>
                        <?php 
                            foreach($cargos as $title){
                                if($_GET['cargo'] == $title){
                                    echo "<option value='$title' selected>" . get_the_title($title) . "</option>";
                                } else {
                                    echo "<option value='$title'>" . get_the_title($title) . "</option>";
                                }                                
                            }
                        ?>
                    </select>
                </div>
            </div>
            

            <div class="col-md-4 mb-2">
                <div class="form-group">
                    <label for="labelTermos">Homologação</label>
                    <select class="form-control" name="ano-hom">
                        <option value="">Selecione o ano</option>
                        <?php
                            $anosHomolog = getAno($anoHomolog);
                            $anosHomolog = array_filter($anosHomolog);
                            foreach($anosHomolog as $ano){
                                if($_GET['ano-hom'] == $ano){
                                    echo "<option value='$ano' selected>$ano</option>";
                                } else {
                                    echo "<option value='$ano'>$ano</option>";
                                }                                
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="labelTermos">Validade</label>
                    <select class="form-control" name="ano-val">
                        <option value="">Selecione o ano</option>
                        <?php
                            $anosValidade = getAno($anoValidade);
                            $anosValidade = array_filter($anosValidade);
                            foreach($anosValidade as $ano){
                                if($_GET['ano-val'] == $ano){
                                    echo "<option value='$ano' selected>$ano</option>";
                                } else {
                                    echo "<option value='$ano'>$ano</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="labelTermos">Status</label>
                    <select class="form-control" name="status">
                        <option value="">Selecione o status</option>
                        <?php
                            $status = array_unique($status);
                            foreach($status as $statu){
                                if($_GET['status'] == $statu){
                                    echo "<option value='$statu' selected>$statu</option>";
                                } else {
                                    echo "<option value='$statu'>$statu</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <?php if($_GET['view'] == 'all'): ?>
                        <input type="hidden" name="view" value="all">
                        <button type="button" class="btn btn-outline-primary mr-md-3" id="limpar" onclick="window.location.href='<?= get_the_permalink()?>?view=all'">Limpar filtros</button>
                    <?php else: ?>
                        <input type="hidden" name="view" value="search">
                        <button type="button" class="btn btn-outline-primary mr-md-3" id="limpar" onclick="window.location.href='<?= get_the_permalink()?>'">Limpar filtros</button>
                    <?php endif; ?>                    
                    <button type="submit" class="btn btn-primary" id="filtrar">Filtrar</button>
                </div>
            </div>
        </div>
    </form>

    <?php if($_GET['view'] == 'all' || $_GET['view'] == 'search'): ?>
        
                <?php
                    // Filtro / Busca Palavra Chave
                    if(isset($_GET['search']) && $_GET['search'] != ''){
                        $args['s'] = $_GET['search'];
                    }

                    // Filtro / Busca Cargo ou Funcao
                    if($_GET['cargo'] && $_GET['cargo'] != ''){
                        $args['p'] = $_GET['cargo'];
                    }
                    
                    // Filtro / Busca Status
                    if($_GET['status'] && $_GET['status'] != ''){
                        $args['meta_key'] = 'status';
                        $args['meta_value']	= $_GET['status'];
                    }

                    // Filtro / Busca Homologacao
                    if(isset($_GET['ano-hom']) && $_GET['ano-hom'] != ''){
                        $ano_hom = $_GET['ano-hom'];
                        
                        $args['meta_query'][] = array (
                            'key' => 'homologacao',
                            'value'     => $ano_hom . '-01-01',
                            'compare'   => '>=',
                            'type'      => 'DATE',
                        );
                        
                        $args['meta_query'][] = array (
                            'key' => 'homologacao',
                            'value'     => $ano_hom . '-12-31',
                            'compare'   => '<=',
                            'type'      => 'DATE',
                        );
                    }

                    // Filtro / Busca Validade
                    if(isset($_GET['ano-val']) && $_GET['ano-val'] != ''){
                        $ano_val = $_GET['ano-val'];
                        
                        $args['meta_query'][] = array (
                            'key' => 'validade',
                            'value'     => $ano_val . '-01-01',
                            'compare'   => '>=',
                            'type'      => 'DATE',
                        );
                        
                        $args['meta_query'][] = array (
                            'key' => 'validade',
                            'value'     => $ano_val . '-12-31',
                            'compare'   => '<=',
                            'type'      => 'DATE',
                        );
                    }

                    // The Query
                    $the_query = new WP_Query( $args );
                    
                    // The Loop
                    if ( $the_query->have_posts() ) :
                ?>
                        <table class="table table-default table-bordered table-concursos d-none d-md-table">
                            <thead>
                                <tr>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Homologação</th>
                                    <th scope="col">Validade</th>
                                    <th scope="col">Última Chamada</th>
                                    <th scope="col">Status</th>
                                </tr>            
                            </thead>

                            <tbody>

                                <?php
                                
                                    while ( $the_query->have_posts() ) :
                                        $the_query->the_post();
                                ?>
                                    <tr>
                                        <!-- Link Noticia / Titulo -->
                                            <?php
                                                $titleurl = get_field( "link_noticias");
                                                if($titleurl) :
                                            ?>                                    
                                                <th scope="row" class='align-middle'><a href="<?= $titleurl; ?>"><strong><?= get_the_title($cargo); ?></strong></a></th>
                                            <?php else: ?>
                                                <th scope="row" class='align-middle'><strong><?= get_the_title($cargo); ?></strong></th>
                                            <?php endif; ?>
                                            
                                        <!-- Fim Link Noticia / Titulo -->
                                        
                                        <!-- Homologacao -->
                                            <?php
                                                // Verifica data de hologacao
                                                $datahom = get_field("homologacao");
                                                if($datahom):
                                                
                                                $dtHomolog = convertDate($datahom);
                                            ?>
                                                    
                                                <?php
                                                    // Verifica se tem DOC
                                                    $dochom = get_field("doc_homologacao");
                                                    if($dochom):
                                                ?>
                                                    <td class='align-middle'><strong><a href="<?php echo $dochom; ?>">DOC - <?php echo $dtHomolog; ?></a></strong></td>
                                                <?php else: ?>
                                                    <td class='align-middle'><?php echo $dtHomolog; ?></td>
                                                <?php endif; ?>
                                            
                                            <?php else: ?>
                                                <td class='align-middle'>-</td>
                                            <?php endif; ?>
                                        <!-- Fim Homologacao -->

                                        <!-- Validade -->
                                            <?php
                                                // Verifica data de Validade
                                                $validade = get_field("validade");                
                                                if($validade):                        
                                                    $dtValidade = convertDate($validade);
                                            ?>
                                                <td class='align-middle'><?php echo $dtValidade; ?></td>                    
                                            <?php else: ?>
                                                <td class='align-middle'>-</td>
                                            <?php endif; ?>
                                        <!-- Fim Validade -->
                                        
                                        <!-- Ultima Chamada -->
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
                                                    <td class='align-middle'><strong><a href="<?php echo $dochom; ?>">DOC - <?php echo $dtHomolog; ?></a></strong></td>
                                                <?php else: ?>
                                                    <td class='align-middle'><?php echo $dtHomolog; ?></td>
                                                <?php endif; ?>
                                            
                                            <?php else: ?>
                                                <td class='align-middle'>-</td>
                                            <?php endif; ?>
                                        <!-- Fim Ultima Chamada -->

                                        <td><?= get_field("status"); ?></td>
                                    </tr>
                                    <tr>
                                        <?php
                                            // Verifica Ultimos Convocados
                                            $ultimos_convocados = get_field("ultimos_convocados");
                                            $informacoes = get_field('mais_informacoes');
                                    
                                            if($ultimos_convocados):
                                        ?>

                                            <td colspan='5' class='align-middle'>
                                                <p class="m-0"><strong>Últimos convocados</strong></p>
                                                <?php echo $ultimos_convocados; ?>
                                                <?php 
                                                    if($informacoes){
                                                        echo "<hr>";
                                                        echo '<p class="m-0"><strong>Mais informações</strong></p>';
                                                        echo $informacoes;
                                                    }                                    
                                                ?>
                                            </td>
                                        
                                        <?php else: ?>
                                            <td colspan='5' class='align-middle'>
                                                <p class="m-0"><strong>Últimos convocados</strong></p>
                                                -
                                                <?php 
                                                    if($informacoes){
                                                        echo "<hr>";
                                                        echo '<p class="m-0"><strong>Mais informações</strong></p>';
                                                        echo $informacoes;
                                                    }                                    
                                                ?>
                                            </td>
                                        <?php endif; ?>    
                                        
                                    </tr>                        
                                <?php  endwhile; ?>
                            <tbody>

                        </table>
                    <?php else: ?>
                        
                        <div class="concursos-no-results">
                            <h2 class="search-title">
                                <span class="azul-claro"><strong>0</strong></span><strong> 
                                    resultados</strong>
                            </h2>
                            <img src="<?php echo get_bloginfo('template_directory') ?>/img/search-empty.png" alt="Nenhum conteuúdo encontrado" class='empty-search responsive-img'>
                            <p class="azul-claro">Não há conteúdo disponível para o termo buscado. Por favor faça uma nova busca.</p>
                        </div>
                        
                    <?php endif; 
                    wp_reset_postdata();
                    ?>
            

        
                <?php
                    // The Query
                    $the_query = new WP_Query( $args );
                    
                    // The Loop
                    if ( $the_query->have_posts() ) :
                ?>
                        <table class="table d-table table-default table-bordered d-sm-table d-md-none table-concursos-mobile">
                            <thead>                
                                <tr>
                                    <th scope="col" colspan="2">Cargo</th>
                                </tr>
                            </thead>

                            <tbody>
                    
                                <?php while ( $the_query->have_posts() ) :
                                    $the_query->the_post();
                                ?>
                                    <!-- Mobile -->
                                    <tr>
                                        <?php
                                            $titleurl = get_field( "link_noticias");
                                            if($titleurl) :
                                        ?>                                    
                                            <th scope="row" class='align-middle'><a href="<?= $titleurl; ?>"><strong><?= get_the_title(); ?></strong></a></th>
                                        <?php else: ?>
                                            <th scope="row" class='align-middle'><strong><?= get_the_title(); ?></strong></th>
                                        <?php endif; ?>
                                        
                                        <td width="40">
                                            <a class="" data-toggle="collapse" href="#collapse-<?= get_the_ID(); ?>" role="button" aria-expanded="false" aria-controls="collapse-<?= get_the_ID(); ?>">
                                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="p-0" style="border-top: 0;">
                                            <div class="collapse collapse-mobile" id="collapse-<?= get_the_ID(); ?>">
                                                <div class="card card-body">
                                                    <p class="m-0"><strong>Data Homologação</strong></p>
                                                    <!-- Homologacao -->
                                                        <?php
                                                            // Verifica data de hologacao
                                                            $datahom = get_field("homologacao");
                                                            if($datahom):
                                                            
                                                            $dtHomolog = convertDate($datahom);
                                                        ?>                                                        
                                                            <?php
                                                                // Verifica se tem DOC
                                                                $dochom = get_field("doc_homologacao");
                                                                if($dochom):
                                                            ?>
                                                                <p><strong><a href="<?php echo $dochom; ?>">DOC - <?php echo $dtHomolog; ?></a></strong></p>
                                                            <?php else: ?>
                                                                <p><?php echo $dtHomolog; ?></p>
                                                            <?php endif; ?>
                                                        
                                                        <?php else: ?>
                                                            <p>-</p>
                                                        <?php endif; ?>
                                                    <!-- Fim Homologacao -->

                                                    <p class="m-0"><strong>Validade</strong></p>
                                                    <!-- Validade -->
                                                        <?php
                                                            // Verifica data de Validade
                                                            $validade = get_field("validade");                
                                                            if($validade):                        
                                                                $dtValidade = convertDate($validade);
                                                        ?>
                                                            <p><?php echo $dtValidade; ?></p>                    
                                                        <?php else: ?>
                                                            <p>-</p>
                                                        <?php endif; ?>
                                                    <!-- Fim Validade -->
                                                    
                                                    <p class="m-0"><strong>Última Chamada</strong></p>
                                                    <!-- Ultima Chamada -->
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
                                                                <p><strong><a href="<?php echo $dochom; ?>">DOC - <?php echo $dtHomolog; ?></a></strong></p>
                                                            <?php else: ?>
                                                                <p><?php echo $dtHomolog; ?></p>
                                                            <?php endif; ?>
                                                        
                                                        <?php else: ?>
                                                            <p>-</p>
                                                        <?php endif; ?>
                                                    <!-- Fim Ultima Chamada -->

                                                    <p class="m-0"><strong>Status</strong></p>
                                                    <p><?= get_field("status"); ?></p>

                                                    <?php
                                                        // Verifica Ultimos Convocados
                                                        $ultimos_convocados = get_field("ultimos_convocados");
                                                        $informacoes = get_field('mais_informacoes');
                                                
                                                        if($ultimos_convocados):
                                                    ?>
                                                        <p class="m-0"><strong>Últimos convocados</strong></p>
                                                        <?php echo $ultimos_convocados; ?>
                                                        <?php 
                                                            if($informacoes){
                                                                echo '<div class="mais-info">';
                                                                    echo '<p class="m-0"><strong>Mais informações</strong></p>';
                                                                    echo $informacoes;
                                                                echo '</div>';
                                                            }                                    
                                                        ?>                                            
                                                    <?php else: ?>                                                
                                                        <p class="m-0"><strong>Últimos convocados</strong></p>
                                                        -
                                                        <?php 
                                                            if($informacoes){
                                                                echo '<div class="mais-info">';
                                                                    echo '<p class="m-0"><strong>Mais informações</strong></p>';
                                                                    echo $informacoes;
                                                                echo '</div>';
                                                            }                                    
                                                        ?>                                                
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>
                                        </td>                    
                                    </tr>
                
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        
                    <?php endif; 
                    wp_reset_postdata();
                ?>

        <?php

            $lastEdit = new WP_Query( array(
                'post_type'   => 'concurso',
                'posts_per_page' => 1,
                'orderby'     => 'modified',
            ));

            $date = $lastEdit->post->post_modified;
            $lastEdit = new DateTime($date);

            $pageDate = get_the_modified_time('Y-m-d H:i:s');
            $pageDate = new DateTime($pageDate);

            if($lastEdit > $pageDate){
                $dataShow = $lastEdit;
            } else {
                $dataShow = $pageDate;
            }

            if($dataShow && $dataShow != ''){
                echo "<p class='font-italic text-date-concursos'>Última Atualização: " . $dataShow->format('d/m/Y') . "</p>";
            }
        ?>

    <?php endif; ?>


    <div class="row">
        <?php if($legenda && $legenda != ''): ?>
            <div class="col-12 concurso-legenda">
                <p class="m-0"><strong>Legenda:</strong></p>
                <?= $legenda; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if($verTodos && !isset($_GET['view'])): ?>
    <div class="container-fluid p-0">
        <div class="ver-todos">
            <p><a href="<?= get_the_permalink(); ?>?view=all">Ver todos os concursos SME</a></p>
        </div>        
    </div>
<?php endif; ?>