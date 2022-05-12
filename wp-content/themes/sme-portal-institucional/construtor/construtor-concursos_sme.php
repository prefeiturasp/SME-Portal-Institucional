<?php
    $titulo = get_sub_field('titulo');
    $legenda = get_sub_field('legenda');
    $verTodos = get_sub_field('ativar_ver_todos');
    $cargos = array();

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
            $status[] = get_field( "status");
        }        
    } 
    /* Restore original Post Data */
    wp_reset_postdata();

    //echo "<pre>";
    //print_r($anoValidade);
    //echo "</pre>";
?>

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
                    <input type="text" id="labelTermos" class="form-control" placeholder="Busque por título ou palavra-chave">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="labelTermos">Cargo/ Função</label>
                    <select class="form-control">
                        <option>Selecione um cargo/função</option>
                        <?php 
                            foreach($cargos as $title){
                                echo "<option value='$title'>" . get_the_title($title) . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            

            <div class="col-md-4 mb-2">
                <div class="form-group">
                    <label for="labelTermos">Homologação</label>
                    <select class="form-control">
                        <option>Selecione o ano</option>
                        <?php
                            $anosHomolog = getAno($anoHomolog);
                            $anosHomolog = array_filter($anosHomolog);
                            foreach($anosHomolog as $ano){
                                echo "<option value='$ano'>$ano</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="labelTermos">Validade</label>
                    <select class="form-control">
                        <option>Selecione o ano</option>
                        <?php
                            $anosValidade = getAno($anoValidade);
                            $anosValidade = array_filter($anosValidade);
                            foreach($anosValidade as $ano){
                                echo "<option value='$ano'>$ano</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="labelTermos">Status</label>
                    <select class="form-control">
                        <option>Selecione o status</option>
                        <?php
                            $status = array_unique($status);
                            foreach($status as $statu){
                                echo "<option value='$statu'>$statu</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <input type="hidden" name="filter" value="1">
                    <button type="button" class="btn btn-outline-primary mr-md-3" id="limpar" onclick="window.location.href='https://hom-intranet.sme.prefeitura.sp.gov.br/index.php/beneficios/ingressos-do-plateia/'">Limpar filtros</button>
                    <button type="submit" class="btn btn-primary" id="filtrar">Filtrar</button>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <?php if($legenda && $legenda != ''): ?>
            <div class="col-12 concurso-legenda">
                <p class="m-0"><strong>Legenda:</strong></p>
                <?= $legenda; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if($verTodos): ?>
    <div class="container-fluid p-0">
        <div class="ver-todos">
            <p><a href="<?= get_the_permalink(); ?>?view=all">Ver todos os concursos SME</a></p>
        </div>        
    </div>
<?php endif; ?>