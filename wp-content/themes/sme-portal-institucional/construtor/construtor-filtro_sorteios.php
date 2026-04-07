<?php

    global $has_posts;
    $titulo = get_sub_field('titulo');
    wp_enqueue_style('select2-css');        
    wp_enqueue_script('select2-js');    

    $api_url = getenv('TAGS_API');
    $tipos_evento_api_url = getenv('TIPO_EVENTO_API');

    // Faz a requisição à API
   $response = wp_remote_get( $api_url, [
        'timeout' => 30, // Sets the timeout to 30 seconds
    ]);

    $tipo_evento_response = wp_remote_get( $tipos_evento_api_url, [
        'timeout' => 30,
    ]);

    //echo '<pre>';
    //print_r($response);
    //echo '</pre>';

    // Verifica se não houve erro
    if (is_wp_error($response)) {
        error_log('Erro ao buscar tags: ' . $response->get_error_message());
        $tags = [];
    } else {
        // Decodifica o JSON da resposta
        $tags = json_decode(wp_remote_retrieve_body($response), true);
    }

    if ( is_wp_error( $tipo_evento_response ) ) {
        error_log('Erro ao buscar os tipos de evento: ' . $response->get_error_message());
        $tipos_evento = [];
    } else {
        // Decodifica o JSON da resposta
        $tipos_evento = json_decode( wp_remote_retrieve_body( $tipo_evento_response ), true );
    }

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
        <div class="col-sm-12 mb-4" id="filtro-eventos">

            <nav>

                <?php if($titulo): ?>
                    <div class="title-form">
                        <h2><?= $titulo; ?></h2>
                    </div>
                <?php endif; ?>

                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button 
                        class="nav-link <?= $filtro === 'aberto' ? 'active' : '' ?> col-12 col-md-4" 
                        id="sort-ativos-tab" 
                        data-toggle="tab" 
                        data-target="#sort-ativos" 
                        type="button" 
                        role="tab" 
                        aria-controls="sort-ativos" 
                        aria-selected="<?= $filtro === 'aberto' ? 'true' : 'false' ?>"
                    >
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/img/inscricoes-abertas-icon.png' ); ?>" alt="Inscrições abertas">
                        Inscrições Abertas
                    </button>
                    <button 
                        class="nav-link <?= $filtro === 'encerrado' ? 'active' : '' ?> col-12 col-md-4" 
                        id="sort-encerrados-tab" 
                        data-toggle="tab" 
                        data-target="#sort-encerrados" 
                        type="button" 
                        role="tab" 
                        aria-controls="sort-encerrados" 
                        aria-selected="<?= $filtro === 'encerrado' ? 'true' : 'false' ?>"
                    >
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/img/inscricoes-encerradas-icon.png' ); ?>" alt="Inscrições abertas">
                        Inscrições Encerradas
                    </button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">

                <!-- Tab de eventos ativos -->
                <div class="tab-pane fade <?= $filtro === 'aberto' ? 'show active' : '' ?>" id="sort-ativos" role="tabpanel" aria-labelledby="sort-ativos-tab">
                    <form action="<?= get_the_permalink(); ?>" method="get" class="filtro-sorteios">
                
                        <div class="form-row mb-2">
                            <div class="col-md-6">
                                <label for="nome-evento-ativo" class="form-label">Busque pelo Nome do Evento</label>
                                <input type="text" class="form-control" name="nome-evento" id="nome-evento-ativo" placeholder="Digite o nome ou parte do nome do evento" value="<?php echo isset($_GET['nome-evento']) ? esc_attr($_GET['nome-evento']) : ''; ?>">

                                <div class="invalid-feedback fieldError" style="display: none;">
                                    Preencha ao menos um dos campos do formulário.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tipo-evento-ativo" class="form-label">Tipo de Evento</label>
                                <select class="form-control select-tipo-evento" id="tipo-evento-ativo" name="tipo-evento">
                                    <option value="">Tipo de Evento</option>
                                    <?php if ( $tipos_evento ) : ?>
                                        <?php foreach ( $tipos_evento as $tipo_evento ) : ?>
                                            <option 
                                                value="<?php echo esc_attr($tipo_evento['id']); ?>" 
                                                <?php echo (isset($_GET['tipo-evento']) && $_GET['tipo-evento'] == $tipo_evento['id']) ? 'selected' : ''; ?>
                                            >
                                                <?php echo esc_html($tipo_evento['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>

                        <div class="form-row"> 
                            <div class="col-12 col-md-9 mt-3">
                                <div class="form-row mais-filtros" style="display: none;"> 
                                    <div class="col-md-8 date-group mb-2">
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

                                    <div class="col-md-4 mb-2">
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
                            </div>

                            <!-- Botão de submit (opcional) -->
                            <div class="col-12 col-md-3 d-flex align-items-end justify-content-end my-2 form-buttons">
                                <input type="hidden" name="filtro" value="aberto">
                                <a href="<?= get_the_permalink(); ?>" class="btn mr-2 no-external">Limpar filtros</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                            </div>
                        </div>

                        <span class="expandir-filtros py-2 px-3"><i class="fa fa-angle-down fa-lg" aria-hidden="true"></i></span>
                    </form>
                </div>
                
                <!-- Tab de eventos encerrados -->
                <div class="tab-pane fade <?= $filtro === 'encerrado' ? 'show active' : '' ?>" id="sort-encerrados" role="tabpanel" aria-labelledby="sort-encerrados-tab">
                    <form action="<?= get_the_permalink(); ?>" method="get" class="filtro-sorteios">

                        <div class="form-row mb-2">
                            <div class="col-md-6">
                                <label for="nome-evento" class="form-label">Busque pelo Nome do Evento</label>
                                <input type="text" class="form-control" name="nome-evento" id="nome-evento" placeholder="Digite o nome ou parte do nome do evento" value="<?php echo isset($_GET['nome-evento']) ? esc_attr($_GET['nome-evento']) : ''; ?>">

                                <div class="invalid-feedback fieldError" style="display: none;">
                                    Preencha ao menos um dos campos do formulário.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="opcoes" class="form-label">Tipo de Evento</label>
                                <select class="form-control select-tipo-evento-encerrado" id="tipo-evento-encerrado" name="tipo-evento">
                                    <option value="">Tipo de Evento</option>
                                    <?php if ( $tipos_evento ) : ?>
                                        <?php foreach ( $tipos_evento as $tipo_evento ) : ?>
                                            <option 
                                                value="<?php echo esc_attr($tipo_evento['id']); ?>" 
                                                <?php echo (isset($_GET['tipo-evento']) && $_GET['tipo-evento'] == $tipo_evento['id']) ? 'selected' : ''; ?>
                                            >
                                                <?php echo esc_html($tipo_evento['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row"> 

                            <div class="col-12 col-md-9 mt-3">
                                <div class="form-row mais-filtros" style="display: none;">
                                    <div class="col-md-8 date-group mb-2">
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
                            
                                    <div class="col-md-4 mb-2">
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
                            </div>

                            <!-- Botão de submit (opcional) -->
                            <div class="col-12 col-md-3 d-flex align-items-end justify-content-end my-2 form-buttons">
                                <input type="hidden" name="filtro" value="encerrado">
                                <a href="<?= get_the_permalink(); ?>" class="btn mr-2 no-external">Limpar filtros</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                            </div>
                        </div>
                    
                        <span class="expandir-filtros py-2 px-3"><i class="fa fa-angle-down fa-lg" aria-hidden="true"></i></span>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>

<?php
// Array para armazenar as partes do texto
$partes_texto = [];

// Adiciona, a partir do term_id, o nome do termo buscado, no array $partes_texto.
function adicionar_nome_termo_lista( array $lista_termos, int $termo_id, array &$partes_texto ) {

    // Encontra o índice da tag com o ID especificado
    $indice = array_search ($termo_id, array_column( $lista_termos, 'id' ) );
    
    if ( $indice !== false ) {
        if ( !empty( $partes_texto ) ) {
            $partes_texto[] = "| " . $lista_termos[$indice]['name'];
        } else {
            $partes_texto[] = $lista_termos[$indice]['name'];
        }
    }
}

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
    adicionar_nome_termo_lista( $tags, $id_procurado, $partes_texto );
}

// Verifica e processa o tipo de evento (genero)
if (isset($_GET['tipo-evento']) && !empty($_GET['tipo-evento'])) {

    $id_procurado = $_GET['tipo-evento'];
    adicionar_nome_termo_lista( $tipos_evento, $id_procurado, $partes_texto );
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

        if( isset( $_GET['tipo-evento'] ) && !empty( $_GET['tipo-evento'] ) ){
            $args['genero_ids'] = sanitize_text_field( $_GET['tipo-evento'] );
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
                        <div class="col-md-6 mb-4">
                            <div class="item-sorteio item-ativos">
                                <div class="row h-100 m-0">

                                    <a href="<?php echo esc_url( get_home_url() . '/sorteio/' . $event['id'] ); ?>" class="col-12 col-md-6 p-0 image-wrapper">
                                        <div class="event-thumbnail">
                                            <div class="bg" style="background-image: url('<?php echo esc_url( $event['thumbnail'] ); ?>');"></div>
                                            <img src="<?php echo esc_url($event['thumbnail']); ?>" alt="<?php echo esc_attr($event['title']); ?>" class="img-fluid">
                                        </div>

                                        <?php if ( isset( $filtro ) && $filtro == 'encerrado' ) : ?>
                                            <div class="overlay-encerrado"></div>
                                        <?php endif; ?>
                                    </a>

                                    <div class="col-12 col-md-6 mt-md-0 pl-md-2 mt-2 pl-0">                                       

                                        <div class="row h-100">
                                            <div class="col-12 col-md-10 d-flex flex-column pr-0">
                                                <h3><a href="<?= get_home_url(); ?>/sorteio/<?= esc_html($event['id']); ?>" class="no-external"><?php echo esc_html($event['title']); ?></a></h3>

                                                <div class="infos-evento my-2">
                                                    <p class="data">
                                                        <?php                                                                
                                                            if( isset( $event['subtitulo'] ) && !empty( $event['subtitulo'] ) ){
                                                                echo esc_html( $event['subtitulo'] );	
                                                            }
                                                        ?>
                                                    </p>

                                                    <?php if ( isset( $event['local_nome'] ) && !empty( $event['local_nome'] ) ) : ?>
                                                        <p class="local"><strong>Local: </strong><?php echo esc_html( $event['local_nome'] ); ?></p>
                                                    <?php endif; ?>

                                                    <?php
                                                    if ( $filtro != 'encerrado' ) {
                                                        if( isset( $event['meta']['tipo_evento'] ) && !empty( $event['meta']['tipo_evento'] ) ) {
                                                            $tipo_evento = esc_html( $event['meta']['tipo_evento'] );

                                                            if ( $tipo_evento == 'premio' ) {
                                                                echo '<p><strong>Prêmio:</strong> Consulte detalhes</p>';
                                                            } elseif ( $tipo_evento == 'data' ) {
                                                                $datas_disponiveis = $event['datas_disponiveis'] ?? [];
                                                                if( !empty( $datas_disponiveis ) ) {

                                                                    $total = count($datas_disponiveis);
                                                                    $lista_datas = [];

                                                                    foreach ( array_chunk( $datas_disponiveis, 3 )[0] as $data ) {
                                                                        $dt = new DateTime($data);
                                                                        $data = ( $total > 1 ) ? $dt->format( 'd/m' ) : $dt->format( 'd/m/Y' );

                                                                        $hora = $dt->format( 'H' );
                                                                        $minuto = $dt->format( 'i' );
                                                                        $hora_fomatada = $minuto == '00' ? "{$hora}h" : "{$hora}h{$minuto}";

                                                                        $data_formatada = "{$data} {$hora_fomatada}";
                                                                        $lista_datas[] = $data_formatada;
                                                                    }
                                                                        
                                                                    echo '<p class="datas-disponiveis"><strong>' . _n( 'Data', 'Datas', $total ) . ':</strong> ' . implode( ' | ', $lista_datas ) . '</p>';

                                                                    if ( $total >= 3 ) {
                                                                        echo '<a href="' . get_home_url(); ?>/sorteio/<?= esc_html($event['id']) . '" class="no-external">Ver todas as datas e horários</a>';
                                                                    }
                                                                }
                                                            } elseif ($tipo_evento == 'periodo') {
                                                                echo '<p><strong>Periodo:</strong> ' . esc_html( $event['meta']['evento_periodo_descricao'] ) . '</p>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>

                                                <?php if ( isset( $event['post_type'] ) && !empty( $event['post_type'] ) ) : 
                                                        if($event['post_type'] == 'cortesias'){
                                                            $class_tag = 'cortesia-tag';
                                                        } else {
                                                            $class_tag = '';
                                                        }
                                                ?>
                                                    <span class="post-type-tag mt-auto <?= $class_tag ?? '' ?>">
                                                        <?= esc_html( $event['post_type'] ); ?>
                                                    </span>
                                                <?php endif; ?>
                                            
                                            </div>
                                            
                                            <div class="col-12 col-md-2">
                                                <?php
                                                    $total_like1 = $event['likes'];
                                                    if($total_like1 == 1){
                                                        $text_total = 'Like';
                                                    } else {
                                                        $text_total = 'Likes';
                                                    }
                                    
                                                    echo '<div class="post_like">';
                                                        echo '<p class="text-center pp_like ' . $likes . '"><img src=' . get_template_directory_uri() . '/img/icone-likes.svg alt="like"><br>' . $total_like1 . ' ' . $text_total . '</p>';
                                                    echo '</div>';
                                                ?>
                                            </div>
                                        </div>
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

        const expandirFiltros = sessionStorage.getItem('expandir-filtro-eventos');
        const params = new URLSearchParams(window.location.search);

            if (params.toString().length > 0) {
                jQuery('html, body').animate({
                    scrollTop: jQuery('#filtro-eventos').offset().top - 20
                }, 500);
            }

        if ( expandirFiltros ) {
            toggleFiltrosEventos();
        }

        jQuery('.expandir-filtros').on('click', function () {
            console.log('expandir')
            toggleFiltrosEventos()
        })

        // Função para ocultar e exibir os campos adicionais no filtro de eventos
        function toggleFiltrosEventos() {

            let $filtrosContainer =  jQuery('.mais-filtros');
            let $btnExpandirFiltros = jQuery('.expandir-filtros i');
            
            if ($filtrosContainer.hasClass('filtros-ativos')) {
                $filtrosContainer.slideUp(300).removeClass('filtros-ativos')
                $btnExpandirFiltros.removeClass('fa-angle-up').addClass('fa-angle-down');
                sessionStorage.removeItem('expandir-filtro-eventos')
            } else {
                $filtrosContainer.slideDown(300).addClass('filtros-ativos');
                $btnExpandirFiltros.removeClass('fa-angle-down').addClass('fa-angle-up');
                sessionStorage.setItem('expandir-filtro-eventos', true);
            }
        }

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
        
        jQuery('#tipo-evento-ativo, #tipo-evento-encerrado').select2({
            placeholder: "Tipo de Evento",
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Nenhum tipo de evento encontrado";
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
            const tipoEvento = form.find('select[name="tipo-evento"]').val();

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
            if (!nomeEvento && !dataInicio && !dataFim && !local && !tipoEvento) {
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
        syncFields('select[name="tipo-evento"]');
    });

</script>