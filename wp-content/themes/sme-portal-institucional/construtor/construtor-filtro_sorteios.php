<?php

    global $has_posts;
    $titulo = get_sub_field('titulo');
    wp_enqueue_style('select2-css');        
    wp_enqueue_script('select2-js');    

    $api_url = getenv('TAGS_API');

    // Faz a requisição à API
   $response = wp_remote_get( $api_url, [
        'timeout' => 30, // Sets the timeout to 30 seconds
    ]);

    //echo '<pre>';
    //print_r($response);
    //echo '</pre>';

    // Verifica se não houve erro
    if (is_wp_error($response)) {
        error_log('Erro ao buscar tags: ' . $response->get_error_message());
        //return [];
    }

    // Decodifica o JSON da resposta
    $tags = json_decode(wp_remote_retrieve_body($response), true);

    //echo '<pre>';
    //print_r($tags);
    //echo '</pre>';


    function formatar_data($data_original) {
        if (empty($data_original)) return '';
        
        try {
            $data = new DateTime($data_original);
            return $data->format('d/m/Y');
        } catch (Exception $e) {
            return $data_original;
        }
    }

    $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'aberto'; // padrão "aberto"

?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button 
                        class="nav-link <?= $filtro === 'aberto' ? 'active' : '' ?>" 
                        id="sort-ativos-tab" 
                        data-toggle="tab" 
                        data-target="#sort-ativos" 
                        type="button" 
                        role="tab" 
                        aria-controls="sort-ativos" 
                        aria-selected="<?= $filtro === 'aberto' ? 'true' : 'false' ?>"
                    >
                        Inscrições Abertas
                    </button>
                    <button 
                        class="nav-link <?= $filtro === 'encerrado' ? 'active' : '' ?>" 
                        id="sort-encerrados-tab" 
                        data-toggle="tab" 
                        data-target="#sort-encerrados" 
                        type="button" 
                        role="tab" 
                        aria-controls="sort-encerrados" 
                        aria-selected="<?= $filtro === 'encerrado' ? 'true' : 'false' ?>"
                    >
                        Inscrições Encerradas
                    </button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade <?= $filtro === 'aberto' ? 'show active' : '' ?>" id="sort-ativos" role="tabpanel" aria-labelledby="sort-ativos-tab">
                    <form action="<?= get_the_permalink(); ?>" method="get" class="filtro-sorteios">
                
                        <?php if($titulo): ?>
                            <div class="title-form">
                                <h2><?= $titulo; ?></h2>
                            </div>
                        <?php endif; ?>

                        <div class="form-row mb-2">
                            <div class="col">
                                <label for="nome-evento-ativo" class="form-label">Busque pelo Nome do Evento</label>
                                <input type="text" class="form-control" name="nome-evento" id="nome-evento-ativo" placeholder="Digite o nome ou parte do nome do evento" value="<?php echo isset($_GET['nome-evento']) ? esc_attr($_GET['nome-evento']) : ''; ?>">
                            </div>
                            <div class="invalid-feedback fieldError" style="display: none;">
                                Preencha ao menos um dos campos do formulário.
                            </div>
                        </div>

                        <div class="form-row"> 
                            
                            <div class="col-md-6 date-group mb-2">
                                <label class="form-label" for="dataInicio">Busque por intervalo de datas</label>
                                <div class="form-row align-items-center">                            
                                    <div class="col-12 col-sm">                                
                                        <input 
                                            type="date" 
                                            class="form-control" 
                                            name="dataInicio" 
                                            id="dataInicio"
                                            value="<?php echo isset($_GET['dataInicio']) ? esc_attr($_GET['dataInicio']) : ''; ?>"
                                        >
                                    </div>
                                    <div class="col-12 col-sm-auto align-self-end text-center">
                                        <span class="text-muted">até</span>
                                    </div>
                                    <div class="col-12 col-sm">                                
                                        <input 
                                            type="date" 
                                            class="form-control" 
                                            name="dataFim" 
                                            id="dataFim"
                                            value="<?php echo isset($_GET['dataFim']) ? esc_attr($_GET['dataFim']) : ''; ?>"
                                        >
                                    </div>
                                </div>

                                <div class="invalid-feedback dataError" style="display: none;">
                                    A data de início não pode ser maior que a data final!
                                </div>
                            </div>

                            
                            
                            <div class="col-md-6 mb-2">
                                <label for="local-ativo" class="form-label">Busque pelo Local do Evento</label>

                                <select class="form-control select-local" id="local-ativo" name="local">
                                    <option value=''>Digite ou selecione um local</option>
                                    <?php if ($tags) : ?>
                                        <?php foreach ($tags as $tag) : ?>
                                            <option 
                                                value="<?php echo esc_attr($tag['id']); ?>" 
                                                <?php echo (isset($_GET['local']) && $_GET['local'] == $tag['id']) ? 'selected' : ''; ?>
                                            >
                                                <?php echo esc_html($tag['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>
                        
                        <!-- Botão de submit (opcional) -->
                        <div class="form-row mt-3">
                            <div class="col-12 d-flex justify-content-end">
                                <input type="hidden" name="filtro" value="aberto">
                                <a href="<?= get_the_permalink(); ?>" class="btn btn-outline-primary mr-2">Limpar filtros</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar Eventos</button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="tab-pane fade <?= $filtro === 'encerrado' ? 'show active' : '' ?>" id="sort-encerrados" role="tabpanel" aria-labelledby="sort-encerrados-tab">
                    <form action="<?= get_the_permalink(); ?>" method="get" class="filtro-sorteios">
                
                        <?php if($titulo): ?>
                            <div class="title-form">
                                <h2><?= $titulo; ?></h2>
                            </div>
                        <?php endif; ?>

                        <div class="form-row mb-2">
                            <div class="col">
                                <label for="nome-evento" class="form-label">Busque pelo Nome do Evento</label>
                                <input type="text" class="form-control" name="nome-evento" id="nome-evento" placeholder="Digite o nome ou parte do nome do evento" value="<?php echo isset($_GET['nome-evento']) ? esc_attr($_GET['nome-evento']) : ''; ?>">
                            </div>
                            <div class="invalid-feedback fieldError" style="display: none;">
                                Preencha ao menos um dos campos do formulário.
                            </div>
                        </div>

                        <div class="form-row"> 
                            
                            <div class="col-md-6 date-group mb-2">
                                <label class="form-label" for="dataInicio">Busque por intervalo de datas</label>
                                <div class="form-row align-items-center">                            
                                    <div class="col-12 col-sm">                                
                                        <input 
                                            type="date" 
                                            class="form-control" 
                                            name="dataInicio" 
                                            id="dataInicio"
                                            value="<?php echo isset($_GET['dataInicio']) ? esc_attr($_GET['dataInicio']) : ''; ?>"
                                        >
                                    </div>
                                    <div class="col-12 col-sm-auto align-self-end text-center">
                                        <span class="text-muted">até</span>
                                    </div>
                                    <div class="col-12 col-sm">                                
                                        <input 
                                            type="date" 
                                            class="form-control" 
                                            name="dataFim" 
                                            id="dataFim"
                                            value="<?php echo isset($_GET['dataFim']) ? esc_attr($_GET['dataFim']) : ''; ?>"
                                        >
                                    </div>
                                </div>

                                <div class="invalid-feedback dataError" style="display: none;">
                                    A data de início não pode ser maior que a data final!
                                </div>
                            </div>

                            
                            
                            <div class="col-md-6 mb-2">
                                <label for="opcoes" class="form-label">Busque pelo Local do Evento</label>

                                <select class="form-control select2-search" id="opcoes" name="local">
                                    <option value=''>Digite ou selecione um local</option>
                                    <?php if ($tags) : ?>
                                        <?php foreach ($tags as $tag) : ?>
                                            <option 
                                                value="<?php echo esc_attr($tag['id']); ?>" 
                                                <?php echo (isset($_GET['local']) && $_GET['local'] == $tag['id']) ? 'selected' : ''; ?>
                                            >
                                                <?php echo esc_html($tag['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>
                        
                        <!-- Botão de submit (opcional) -->
                        <div class="form-row mt-3">
                            <div class="col-12 d-flex justify-content-end">
                                <input type="hidden" name="filtro" value="encerrado">
                                <a href="<?= get_the_permalink(); ?>" class="btn btn-outline-primary mr-2">Limpar filtros</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar Eventos</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
            
        </div>
        
    </div>
</div>

<?php
// Array para armazenar as partes do texto
$partes_texto = [];

if(isset($_GET['nome-evento']) && $_GET['nome-evento'] != ''){
    $partes_texto[] = sanitize_text_field($_GET['nome-evento']);
}

// Verifica e processa as datas
$data_inicio = isset($_GET['dataInicio']) ? sanitize_text_field($_GET['dataInicio']) : '';
$data_fim = isset($_GET['dataFim']) ? sanitize_text_field($_GET['dataFim']) : '';

if (!empty($data_inicio) && !empty($data_fim)) {
    if (!empty($partes_texto)) {
            $partes_texto[] = "| " . formatar_data($data_inicio) . " até " . formatar_data($data_fim);
    } else {
        $partes_texto[] = formatar_data($data_inicio) . " até " . formatar_data($data_fim);
    }    
}

// Verifica e processa o local (tag)
if (isset($_GET['local']) && !empty($_GET['local'])) {
    $id_procurado = $_GET['local']; // ID que você quer encontrar

    // Encontra o índice da tag com o ID especificado
    $indice = array_search($id_procurado, array_column($tags, 'id'));
    
    if ($indice !== false) {
        if (!empty($partes_texto)) {
            $partes_texto[] = "| " . $tags[$indice]['name'];
        } else {
            $partes_texto[] = $tags[$indice]['name'];
        }
    }
}

// Monta o texto final se houver filtros
if (!empty($partes_texto)) {
    if($_GET['filtro'] == 'aberto'){
        $textoTitulo = "SORTEIOS - Inscrições Abertas";
        $status_prefix = '';
    } else if($_GET['filtro'] == 'encerrado'){
        $textoTitulo = "SORTEIOS - Inscrições Encerradas";
        $status_prefix = 'ENCERRADO - ';
    }
    echo '<div class="container">';
        echo '<div class="row">';
            echo '<div class="col-sm-12">';
                echo '<div class="resultados-filtro mb-4">';
                    echo '<a href="' . get_the_permalink() . '"><strong>' . $textoTitulo . '</strong></a> / Resultados para: ' . implode(' ', $partes_texto);
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
}
?>

<?php
    if(isset($_GET['filtro'])){
        
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $qtd = get_sub_field('qtd');
        global $has_posts;

        if(!$qtd)
            $qtd = 15;

        $current_date = date('Ymd');

        $args = [    
            'per_page' => $qtd,
            'page' => $paged,
            'fields' => 'id,title,content,excerpt,date,slug,meta,thumbnail' // Solicite todos os campos 
        ];

        if(isset($_GET['nome-evento']) && !empty($_GET['nome-evento'])){
            $args['search'] = sanitize_text_field($_GET['nome-evento']);
        }

        if(isset($_GET['local']) && !empty($_GET['local'])){
            $args['tag_ids'] = sanitize_text_field($_GET['local']);
        }

        // Se houver AMBOS dataInicio e dataFim
        if( isset($_GET['dataInicio']) && $_GET['dataInicio'] != '' && isset($_GET['dataFim']) && $_GET['dataFim'] != ''){
            $data_inicial = $_GET['dataInicio'] . ' 00:00:00';
            $data_final   = $_GET['dataFim'] . ' 23:59:59';

            $args['meta_query'][] = json_encode(
                [
                    array(
                        [
                            'key'     => 'evento_datas_$_data', // % pega qualquer índice do repeater
                            'value'   => [ $data_inicial, $data_final ],
                            'compare' => 'BETWEEN',
                            'type'    => 'DATETIME',
                        ]
                    ),                
                ]
            );
        }

        $meta_query = array(
            'relation' => 'AND', // ou 'OR'
        );

        // Condição de datas
        if( !empty($_GET['dataInicio']) && !empty($_GET['dataFim']) ){
            $data_inicial = $_GET['dataInicio'] . ' 00:00:00';
            $data_final   = $_GET['dataFim'] . ' 23:59:59';

            $meta_query[] = array(
                'relation' => 'OR',
                [
                    'key'     => 'evento_datas_$_data',
                    'value'   => [ $data_inicial, $data_final ],
                    'compare' => 'BETWEEN',
                    'type'    => 'DATETIME',
                ],
                [
                    'key'     => 'evento_datas_$_data',
                    'compare' => 'NOT EXISTS',
                ],
            );
        }

        if ( isset($_GET['filtro']) && !empty($_GET['filtro']) ){
            $filtro = $_GET['filtro'];
            $hoje = date('Y-m-d');
            if ( $filtro === 'aberto' ) {
                $meta_query[] = array(
                    'key'     => 'enc_inscri',
                    'value'   => $hoje,
                    'compare' => '>=',
                    'type'    => 'DATE', // ou 'DATETIME' se o ACF salva com hora
                );
            } else if ( $filtro === 'encerrado' ) {
                $meta_query[] = array(
                    'key'     => 'enc_inscri',
                    'value'   => $hoje,
                    'compare' => '<',
                    'type'    => 'DATE', // ou 'DATETIME' se o ACF salva com hora
                );
            }
        }

        /*
        if ( isset($_GET['filtro']) && !empty($_GET['filtro']) ) {
            $filtro = $_GET['filtro'];
            $hoje = date('Y-m-d');

            if ( $filtro === 'aberto' ) { 
                $args['meta_query'][] = json_encode(
                    [
                        array(
                            [
                                'key'     => 'enc_inscri',
                                'value'   => $hoje,
                                'compare' => '>=',
                                'type'    => 'DATE', // ou 'DATETIME' se o ACF salva com hora
                            ]
                        ),                
                    ]
                );
            }

            if ( $filtro === 'encerrado' ) {
                $args['meta_query'][] = json_encode(
                    [
                        array(
                            [
                                'key'     => 'enc_inscri',
                                'value'   => $hoje,
                                'compare' => '<',
                                'type'    => 'DATE', // ou 'DATETIME' se o ACF salva com hora
                            ]
                        ),                
                    ]
                );
            }
        }*/

        $args['meta_query'] = json_encode($meta_query);

        $request_args = [
            'timeout' => 30, // Timeout de 30 segundos
            'sslverify' => false // Desativa verificação SSL em localhost
        ];

        if (  $_GET['filtro'] === 'encerrado' ) {
            $args['status'] = 'encerrados';
        }

        $response = wp_remote_get(
            add_query_arg($args, getenv('SORTEIOS_API')),
            $request_args
        );

        // Verifica se a requisição foi bem sucedida
        if (is_wp_error($response)) {
            echo '<div class="error">Erro ao carregar os eventos: ' . $response->get_error_message() . '</div>';
        } else {
            $events = json_decode(wp_remote_retrieve_body($response), true);
            $total_events = wp_remote_retrieve_header($response, 'X-WP-Total');
            $total_pages = wp_remote_retrieve_header($response, 'X-WP-TotalPages');
            
            if (empty($events) || ($timestamp_fim < $timestamp_atual && !empty($data_fim) ) ) {
                if(isset($_GET)){
                    echo '<div class="container">';
                        echo '<div class="no-results">';
                            echo '<h2 class="search-title">';
                                echo '<span class="azul-claro-acervo"><strong>0</strong></span><strong> resultados</strong>';
                            echo '</h2>';
                            echo '<img src="https://educacao.sme.prefeitura.sp.gov.br/wp-content/themes/sme-portal-institucional/img/search-empty.png" alt="Imagem ilustrativa para nenhum resultado de busca encontrado" class="img-fluid">';
                            echo '<p>Nenhum evento encontrado para os filtros aplicados</p>';
                        echo '</div>';
                    echo '</div>';
                }else{
                    echo '<div class="container">';
                        echo '<div class="no-results">';
                            echo '<h2 class="search-title">';
                                echo '<span class="azul-claro-acervo"><strong>0</strong></span><strong> resultados</strong>';
                            echo '</h2>';
                            echo '<img src="https://educacao.sme.prefeitura.sp.gov.br/wp-content/themes/sme-portal-institucional/img/search-empty.png" alt="Imagem ilustrativa para nenhum resultado de busca encontrado" class="img-fluid">';
                            echo '<p>Nenhum evento encontrado para os filtros aplicados</p>';
                        echo '</div>';
                    echo '</div>';
                }
            } else {

                //echo "<pre>";
                //print_r($events);        
                //echo "</pre>";

                $has_posts = true;
                
                echo '<div class="container">';
                    echo '<div class="row">';
                        
                    foreach ($events as $event) {
                        
                        ?>
                            <div class="col-md-4 mb-4">

                                <div class="item-sorteio">
                                    <div class="row m-0">

                                        <div class="col-12 p-0">
                                            <?php if (!empty($event['thumbnail'])): ?>
                                                <div class="event-thumbnail">
                                                    <img src="<?php echo esc_url($event['thumbnail']); ?>" alt="<?php echo esc_attr($event['title']); ?>" class="img-fluid">
                                                </div>
                                            <?php else: ?>
                                                <div class="event-thumbnail">
                                                    <img class="img-fluid" src="<?php echo esc_url( get_field( 'imagem_placeholder', 'placeholders' )['url'] ?? '' ); ?>" width="100%">
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-12">
                                            <p class="data">
                                                <?php
                                                    
                                                    if( isset( $event['subtitulo'] ) && !empty( $event['subtitulo'] ) ){
                                                        echo esc_html( $event['subtitulo'] );	
                                                    }
                                                ?>
                                            </p>
                                        </div>

                                        <div class="col-12 col-md-9 mb-2">
                                            <h3><a href="<?= get_home_url(); ?>/sorteio/<?= esc_html($event['id']); ?>"><?= $status_prefix . esc_html($event['title']); ?></a></h3>
                                        </div>
                                        
                                        <div class="col-12 col-md-3 mb-2">
                                            <?php
                                                $total_like1 = $event['likes'];
                                                if($total_like1 == 1){
                                                    $text_total = 'like';
                                                } else {
                                                    $text_total = 'likes';
                                                }
                                
                                                echo '<div class="post_like">';
                                                    echo '<p class="text-center pp_like ' . $likes . '">' . $total_like1 . ' ' . $text_total . '<br><i class="fa fa-heart" aria-hidden="true"></i></p>';
                                                echo '</div>';
                                            ?>
                                        </div>

                                    </div>
                                    
                                </div>
                                
                            </div>
                        <?php
                    }

                    echo '</div>';
                
                echo '</div>';
                
                // Paginação
                if ($total_pages > 1) {
                    echo '<div class="container">';
                        echo '<div class="row">';
                            echo '<div class="col-12">';
                                echo '<div class="pagination d-flex justify-content-center">';
                                echo paginate_links([
                                    'base' => get_pagenum_link(1) . '%_%',
                                    'format' => 'page/%#%',
                                    'current' => $args['page'],
                                    'total' => $total_pages,
                                    'prev_text' => __('« Anterior'),
                                    'next_text' => __('Próxima »'),
                                ]);
                            echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }

            }
        }

    }

?>

<script>

    jQuery(document).ready(function() {

        // Inicializa o Select2
        jQuery('.select-local, .select2-search').select2({
            placeholder: "Digite ou selecione um local",
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Nenhum local encontrado";
                },
                searching: function() {
                    return "Buscando…";
                },
                inputTooShort: function() {
                    return "Digite pelo menos um caractere";
                },
            }
        });        

        jQuery('.tab-pane.active .select2-search').trigger('change.select2');

        // Validação de datas
        jQuery('.filtro-sorteios').on('submit', function(e) {
            const form = jQuery(this);

            const nomeEvento = form.find('input[name="nome-evento"]').val().trim();
            const dataInicio = form.find('input[name="dataInicio"]').val();
            const dataFim = form.find('input[name="dataFim"]').val();
            const local = form.find('select[name="local"]').val();

            const errorMsgData = form.find('.dataError');   // mensagens de data
            const errorMsgField = form.find('.fieldError'); // mensagens gerais
            const inputInicio = form.find('input[name="dataInicio"]');
            const inputFim = form.find('input[name="dataFim"]');

            // Reset de erros visuais
            errorMsgData.hide();
            errorMsgField.hide();
            inputInicio.removeClass('is-invalid');
            inputFim.removeClass('is-invalid');

            let hasError = false;

            // 1. Pelo menos um campo deve ser preenchido
            if (!nomeEvento && !dataInicio && !dataFim && !local) {
                hasError = true;
                errorMsgField.text("Preencha ao menos um dos campos do formulário.").show();
            }

            // 2. Se preencher apenas uma das datas → erro
            if ((dataInicio && !dataFim) || (!dataInicio && dataFim)) {
                hasError = true;
                errorMsgData.text("Preencha as duas datas.").show();
                if (!dataInicio) inputInicio.addClass('is-invalid');
                if (!dataFim) inputFim.addClass('is-invalid');
            }

            // 3. Se ambas preenchidas, validar intervalo
            if (dataInicio && dataFim) {
                const inicio = new Date(dataInicio);
                const fim = new Date(dataFim);

                if (inicio > fim) {
                    hasError = true;
                    errorMsgData.text("A data de início não pode ser maior que a final.").show();
                    inputInicio.addClass('is-invalid');
                    inputFim.addClass('is-invalid');
                }
            }

            if (hasError) {
                e.preventDefault(); // Impede envio
            }
        });


        // ---- Sincronização entre os dois forms ----
        function syncFields(selector) {
            jQuery(document).on('input change', selector, function(e, triggeredBySync) {
                if (triggeredBySync) return; // evita loop infinito

                const name = jQuery(this).attr('name');
                const value = jQuery(this).val();

                // Atualiza os outros campos de mesmo name
                jQuery(`input[name="${name}"], select[name="${name}"]`).not(this).each(function() {
                    if (jQuery(this).val() !== value) {
                        jQuery(this).val(value).trigger('change', [true]); 
                    }
                });
            });
        }

        // Sincronizar estes campos:
        syncFields('input[name="nome-evento"]');
        syncFields('input[name="dataInicio"]');
        syncFields('input[name="dataFim"]');
        syncFields('select[name="local"]');

    });

</script>