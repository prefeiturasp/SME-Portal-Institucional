<?php
/**
 * Template Name: Sorteio Externo
 */

wp_enqueue_script('datatables');
wp_enqueue_style('datatables');

global $wp_query;
get_header();

$sorteio_data = $wp_query->sorteio_data;

//echo '<pre>';
//print_r($sorteio_data);
//echo '</pre>';
?>

<main id="primary" class="site-main">
    <?php if (isset($sorteio_data['error'])) : ?>
        <!-- Seção de Erro -->
        <article class="sorteio-error">

            <div class="bg_fx_azul lk_fx_azul fx_all mb-5">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-sm-12 tx_fx_branco  mt-3 mb-3 col-bt-azul ">
                            <div class="container">
                                <h1 class="text-left mt-3 mb-3 tx_fx_">Erro ao carregar sorteio</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="entry-content">
                <div class="error-message">
                    <p><strong><?= esc_html($sorteio_data['message']); ?></strong></p>
                    <p>ID do sorteio: <?= esc_html(get_query_var('external_sorteio_id')); ?></p>
                    
                    <?php if (current_user_can('manage_options')) : ?>
                        <details class="error-details">
                            <summary>Detalhes técnicos</summary>
                            <pre><?= esc_html($sorteio_data['details']); ?></pre>
                        </details>
                        <p><small>Esta mensagem só é visível para administradores.</small></p>
                    <?php endif; ?>
                </div>
                
                <a href="<?= home_url('/sorteios/'); ?>" class="button">
                    Voltar para a lista de sorteios
                </a>
            </div>
        </article>
        
    <?php else : ?>

        <div class="bg_fx_azul lk_fx_azul fx_all mb-5">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-sm-12 tx_fx_branco  mt-3 mb-3 col-bt-azul ">
                        <div class="container">
                            <h1 class="text-left mt-3 mb-3 tx_fx_"><?= esc_html($sorteio_data['title']); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de Sorteio Válido -->
        <div class="container">
            
            <article class="sorteio-externo" data-tipo-evento="<?php echo esc_html( $sorteio_data['meta']['tipo_evento'] ); ?>">
                <div class="row">

                    <div class="col-12 col-md-8">
                        <p class="data"><span class="display-autor">
                            <?php
                                if($sorteio_data['data_publicacao']){
                                    echo 'Publicado em: ' . $sorteio_data['data_publicacao'];
                                }

                                if($sorteio_data['data_atualizacao']){
                                    echo ' - Atualizado em: ' . $sorteio_data['data_atualizacao'];
                                }

                                if($sorteio_data['categorias']){
                                    echo ' - em ';
                                    foreach($sorteio_data['categorias'] as $categoria){
                                        if($i == 0){
                                            echo $categoria;
                                        } else {
                                            echo ', ' . $categoria;
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                        </span></p>
                        <div class="sorteio-subtitulo">
                            <p><?= $sorteio_data['subtitulo']; ?></p>
                            <hr>
                        </div>
                        
                        <?php if (!empty($sorteio_data['thumbnail'])): ?>
                            <div class="event-thumbnail mb-4">
                                <img src="<?= esc_url($sorteio_data['thumbnail']); ?>" alt="<?= esc_attr($sorteio_data['title']); ?>" class="img-fluid">
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?= wp_kses_post($sorteio_data['content']); ?>

                            <?php if($sorteio_data['meta']['tipo_evento'] == 'premio'): ?>
                                <p class="title-info mt-4">Informações:</p>
                            <?php else: ?>
                                <p class="title-info mt-4">Informação da Visita/Evento:</p>
                            <?php endif; ?>

                            <?php
                                $dataAtual = date('Ymd');
                                $dataEncerra = $sorteio_data['meta']['enc_inscri'];
                                $resumo = $sorteio_data['meta']['resumo'];
                                $link = $sorteio_data['meta']['link_infos'];
                                $tituloLink = $sorteio_data['meta']['texto_do_link'];
                                $o_que = $sorteio_data['title'];
                                $dataEvento = $sorteio_data['meta']['data_evento_form'];
                                $hora_evento = $sorteio_data['meta']['hora_evento'];
                                $genero = $sorteio_data['genero']; // Tipo de evento
                                $duracao = $sorteio_data['meta']['duracao'];
                                $class_indicativa = $sorteio_data['meta']['class_indicativa'];
                                $local = $sorteio_data['local'];
                                $local_outros = $sorteio_data['meta']['local_outros'];
                                $endereco = $sorteio_data['meta']['endereco'];
                                $exibe_resultado_pagina = $sorteio_data['meta']['exibe_resultado_pagina'];
                                $listaSorteados = $sorteio_data['sorteados'];
                                $datasDisponiveis = $sorteio_data['datas_dispo'];
                                $tipo_evento = $sorteio_data['meta']['tipo_evento'];
                                $periodo_evento = $sorteio_data['meta']['evento_periodo_descricao'];
                        
                                if($resumo){
                                    echo '<p><strong>Resumo:</strong> ' . $resumo . '</p>';
                                }

                                echo '<p>';
                                if($o_que){
                                    echo '<strong>O que é: </strong> ' . $o_que . '</br>';
                                }
                                if($tipo_evento === 'data' && $dataEvento){
                                    echo '<strong>Data: </strong> <div class="datas-eventos">' . $dataEvento . '</div>';
                                }
                                if($hora_evento){
                                    echo ' - ' . $hora_evento;
                                }

                                if($tipo_evento === 'periodo' && $periodo_evento){
                                    echo '<strong>Período: </strong> ' . $periodo_evento;
                                }

                                if( $tipo_evento === 'periodo' || $tipo_evento === 'data' ){
                                    echo '</br>';
                                }

                                if($genero){
                                    echo '<strong>Tipo de Evento: </strong> ' . $genero . '</br>';
                                }
                                if($duracao){
                                    echo '<strong>Duração: </strong> ' . $duracao . '</br>';
                                }
                                if($class_indicativa){
                                    echo '<strong>Classificação Indicativa: </strong> ' . $class_indicativa . '</br>';
                                }
                                if($local){
                                    echo '<strong>Local: </strong> ' . $local . '</br>';
                                }
                                if($endereco){
                                    echo '<strong>Endereço: </strong> ' . $endereco . '</br>';
                                }
                            echo '</p>';

                            if($link){
                                if ($tituloLink) {
                                    echo '<p><strong>Link para mais informações:</strong> <a href="' . $link . '" target="_blank">' . $tituloLink . '</a></p>';
                                } else {
                                    echo '<p><strong>Link para mais informações:</strong> <a href="' . $link . '" target="_blank">Saiba Mais</a></p>';
                                }
                            }

                            $regras_info = $sorteio_data['meta']['regras_info'];

                            if($regras_info){
                                echo '<hr>';
                                echo '<p class="title-info">Informações importantes:</p>';
                                echo wpautop($regras_info);
                            }

                            echo '<p class="title-info">Boa sorte a todos!</p>';
                            echo '<hr>';
                            ?>
                        </div>

                            <?php if($dataAtual <= $dataEncerra): ?>

                                <?php
                                    if($exibe_resultado_pagina == '1' && !empty($listaSorteados)) {
                                        
                                        if($tipo_evento == 'premio'){                                           
                                            echo '<div class="row mb-4">';
                                                echo '<div class="col">';
                                                    echo '<span class="title-info">Lista de contemplados do sorteio</span>';
                                                    echo '<p>Se o seu nome estiver entre os contemplados, acesse o e-mail cadastrado e verifique o local de retirada do seu prêmio.</p>';
                                                echo '</div>';
                                            echo '</div>';
                                        } else {                                            
                                            echo '<div class="row mb-4">';
                                                echo '<div class="col">';
                                                    echo '<span class="title-info">Lista de contemplados do sorteio</span>';
                                                    echo '<p>Se o seu nome estiver entre os contemplados, acesse o e-mail cadastrado e veja se é necessário confirmar sua presença.</p>';
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                        
                                        if(!empty($listaSorteados)){
                                            echo '<div class="accordion" id="accordion-sorteados">';
                                                foreach ($listaSorteados as $item) {
                                                    echo $item;
                                                }
                                            echo '</div>';
                                        }
                                    }
                                ?>

                                <div class="form-inscricao">
                                    <div class="form-title">
                                        <h3>Preencha o formulário abaixo com seus dados:</h3>

                                        <div class="inscri-limite">
                                            <?php
                                                
                                                $dateTime = \DateTime::createFromFormat('Ymd', $dataEncerra);

                                                if($dateTime){
                                                    echo '<p>Inscrições até ' . $dateTime->format('d/m/Y') . '</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>

                                    <form action="#" method="post" id="form-inscri" class="form-inscri">	

                                        <input type="hidden" name="external_sorteio_id" id="external_sorteio_id" value="<?= esc_attr(get_query_var('external_sorteio_id')); ?>">
                                        <?php wp_nonce_field('processar_inscricao_action', 'inscricao_nonce'); ?>

                                        <div class="form-row">
                                            
                                            <div class="form-group col">
                                                <label for="nomeComp">Nome completo <span>*</span></label>
                                                <input type="text" class="form-control" name="nomeComp" id="nomeComp" placeholder="Insira seu nome completo">
                                                
                                            </div>							
                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col" id="grupo-email-institucional">
                                                <label for="emailInsti">E-mail Institucional <span>*</span></label>
                                                <input type="text" name="emailInsti" class="form-control" id="emailInsti" placeholder="Insira seu e-mail institucional">
                                            </div>           
                                            
                                            <div class="form-group col">
                                                <label for="cpf">CPF <span>*</span></label>
                                                <input type="text" name="cpf" class="form-control" id="cpf" placeholder="000.000.000-00">    
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="emailSec">E-mail Secundário <span>*</span></label>
                                                <input type="text"  name="emailSec" class="form-control" id="emailSec" placeholder="email@provedor.com.br">
                                            </div>

                                            
                                            <div class="form-group col">
                                                <label for="celular">Telefone Celular <span>*</span></label>
                                                <input type="text" name="celular" class="form-control" id="celular" placeholder="(00) 0000-0000">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <?php                                
                                                $dres = array(
                                                    "SME",
                                                    "DRE Butantã",
                                                    "DRE Campo Limpo",
                                                    "DRE Capela do Socorro",
                                                    "DRE Freguesia/Brasilândia",
                                                    "DRE Guaianases",
                                                    "DRE Ipiranga",
                                                    "DRE Itaquera",
                                                    "DRE Jaçanã/Tremembé",
                                                    "DRE Penha",
                                                    "DRE Pirituba",
                                                    "DRE Santo Amaro",
                                                    "DRE São Mateus",
                                                    "DRE São Miguel",
                                                    "Outros"
                                                );
                                            ?>
                                            <div class="form-group col">
                                                <label for="dre">DRE/SME <span>*</span></label>

                                                <select class="form-control" name="dre" name="dre" id="dre">
                                                    <option value="">-- Selecione --</option>
                                                    <?php foreach ($dres as $opcao) : ?>
                                                        <option value="<?= esc_attr($opcao); ?>">
                                                            <?= esc_html($opcao); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group col">
                                                <label for="telCom">Telefone Comercial</label>
                                                <input type="text" name="telCom" class="form-control" id="telCom" placeholder="(00) 0000-0000">
                                            </div>
                                        </div>

                                        <div class="form-row">                            
                                            <div class="form-group col-12" id="grupo-programa">

                                                <label class="d-block mb-2">Atua em qual programa de estágio? <span>*</span></label>

                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="programa1" name="programa_estagio" class="custom-control-input" value="1">
                                                    <label class="custom-control-label" for="programa1">Aprender sem limite</label>
                                                </div>

                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="programa2" name="programa_estagio" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="programa2">Parceiros da aprendizagem</label>
                                                </div>

                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="programa3" name="programa_estagio" class="custom-control-input" value="3">
                                                    <label class="custom-control-label" for="programa3">Diversos</label>
                                                </div>

                                            </div>

                                            <div class="form-group col-12">
                                                <label for="uniSetor">Unidade Escolar ou Setor <span>*</span></label>
                                                <input type="text" name="uniSetor" class="form-control" id="uniSetor" placeholder="Nome da Unidade Escolar ou Setor">
                                            </div>
                                            <?php if($datasDisponiveis): ?>
                                                <div class="form-group col" id="grupo-datas">
                                                    <?php if ( $tipo_evento === 'premio' ) : ?>
                                                        <label for="datas-disponiveis">Selecione os prêmios que deseja participar do sorteio: <span>*</span></label>
                                                    <?php else : ?>
										                <label for="datas-disponiveis">Selecione a(s) data(s) que deseja participar: <span>*</span></label>
                                                    <?php endif; ?>
                                                
                                                    <?php foreach ( $datasDisponiveis as $selecao => $data ) : ?>                                                       
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    name="datas[]"
                                                                    value="<?= $selecao; ?>"
                                                                    id="data-<?= $selecao; ?>"
                                                                >
                                                                <?php
                                                                    $dataOriginal = $selecao;                                                                    
                                                                    $dataObj = DateTime::createFromFormat('Y-m-d H:i:s', $dataOriginal);
                                                                    $dataFormatada = $dataObj->format('d/m/Y H\hi');
                                                                    $dataFormatada = str_replace('h00', 'h', $dataFormatada);
                                                                ?>

                                                                <label class="form-check-label" for="data-<?= $selecao; ?>">
                                                                    <?php if($tipo_evento == 'premio'): ?>
                                                                        <?= $data; ?>
                                                                    <?php else: ?>
                                                                        <?= $dataFormatada; ?>
                                                                    <?php endif; ?>
                                                                </label>
                                                            </div>                                                        
                                                    <?php endforeach; ?>                                                
                                                </div>
                                            <?php endif; ?>

                                        </div>

                                        <?php if ( isset( $sorteio_data['meta']['tipo_evento'] ) && $sorteio_data['meta']['tipo_evento'] === 'periodo' ) : ?>
                                            <div class="form-row px-1 pt-2 pb-4">
                                                <em>Participe do sorteio informando os dados acima e, caso seja sorteado(a), poderá utilizar seu ingresso durante o período destacado na descrição do evento.</em>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="form-row">
                                            <div class="form-group col">

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="ciente" value="1" id="ciente">
                                                    <label class="form-check-label d-block" for="ciente">
                                                        Declaro estar ciente de que, em caso de contemplação, poderei ser contatado(a) por e-mail para confirmar minha participação ou a retirada do benefício, dentro do prazo estabelecido pelo parceiro. A não confirmação dentro do prazo poderá resultar na perda do direito ao benefício.
                                                    </label>
                                                </div>

                                                <?php /*
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remanescentes" value="1" id="remanescentes">
                                                    <label class="form-check-label" for="remanescentes">
                                                        Tenho disponibilidade para concorrer a eventuais ingressos remanescentes de outros sorteios que ocorrem essa semana para os quais não fiz a inscrição.
                                                    </label>
                                                </div>
                                                */ ?>

                                            </div>							
                                        </div>

                                        <div class="buttons-group text-right">
                                            <a href="javascript:history.back()" class="btn btn-outline-primary">Voltar</a> 
                                            <input type="submit" value="Enviar" class="btn btn-primary" id="botaoEnviar">
                                        </div>
                                        
                                        <div class="form-loading-overlay" id="formLoadingOverlay">
                                            <div class="form-loading-content">
                                                <img src="<?php echo get_template_directory_uri(); ?>/classes/assets/img/load-32_256.gif" alt="Carregando">
                                            </div>
                                        </div>

                                    </form>

                                </div>

                            <?php else: 
                                if($exibe_resultado_pagina == '1') {
                                    if($tipo_evento == 'premio'){                                           
                                            echo '<div class="row mb-4">';
                                                echo '<div class="col">';
                                                    echo '<span class="title-info">Lista de contemplados do sorteio</span>';
                                                    echo '<p>Se o seu nome estiver entre os contemplados, acesse o e-mail cadastrado e verifique o local de retirada do seu prêmio.</p>';
                                                echo '</div>';
                                            echo '</div>';
                                        } else {                                            
                                            echo '<div class="row mb-4">';
                                                echo '<div class="col">';
                                                    echo '<span class="title-info">Lista de contemplados do sorteio</span>';
                                                    echo '<p>Se o seu nome estiver entre os contemplados, acesse o e-mail cadastrado e veja se é necessário confirmar sua presença.</p>';
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    
                                    if(!empty($listaSorteados)){
                                         echo '<div class="accordion" id="accordion-sorteados">'; 
                                            foreach ($listaSorteados as $item) {
                                                echo $item;
                                            }
                                         echo '</div>'; 
                                    }
                                } else { ?>
                                    <div class="msg-encerrado text-center">
                                        <h3>Inscrições Encerradas!</h3>
                                        <p>O sorteio será realizado <?= $sorteio_data['meta']['data_sorteio_form']; ?> , <br>a lista de ganhadores será divulgada nesta página. Fique atento!</p>
                                    </div>
                            <?php } endif; ?>

                    </div>

                    <div class="col-12 col-md-4">
                        <div class="recados-destaques noticias-recentes">
                            <div class="recados-title d-flex justify-content-between align-items-center">
                                <?php $link = get_field('pag_sorteios', 'conf-lateral'); ?>
                                <h3>MAIS RECENTES</h3>
                                <?php
                                    if($link){
                                        echo '<a href="' . get_permalink($link) . '">Ver todos</a>';
                                    }
                                ?>
                            </div>
                            
                            <?php
                                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                                $qtd = 5;                            
                                
                                $current_date = date('Ymd');
                                $args = [
                                    'meta_query' => json_encode([
                                        [
                                            'key' => 'enc_inscri',
                                            'value' => $current_date,
                                            'compare' => '>=',
                                            'type' => 'DATE'
                                        ]
                                    ]),
                                    'per_page' => $qtd,
                                    'post__not_in' => $sorteio_data['id'],
                                    'page' => $paged,
                                    'fields' => 'id,title,content,excerpt,date,slug,meta,thumbnail' // Solicite todos os campos 
                                ];
                                
                                $request_args = [
                                    'timeout' => 30, // Timeout de 30 segundos
                                    'sslverify' => false // Desativa verificação SSL em localhost
                                ];
                                
                                $response = wp_remote_get(
                                    add_query_arg($args, getenv('SORTEIOS_API')),
                                    $request_args
                                );

                                if (is_wp_error($response)) {
                                    echo '<div class="error">Erro ao carregar os eventos: ' . $response->get_error_message() . '</div>';
                                } else {
                                    $events = json_decode(wp_remote_retrieve_body($response), true);
                                    $total_events = wp_remote_retrieve_header($response, 'X-WP-Total');
                                    $total_pages = wp_remote_retrieve_header($response, 'X-WP-TotalPages');
                                    
                                    if (empty($events)) {
                                        echo '<div class="no-events">';
                                        echo '<p>Não há eventos com inscrições abertas no momento.</p>';
                                        echo '</div>';
                                    } else {
                                        //echo "<pre>";
                                        //print_r($events);        
                                        //echo "</pre>";
                                        
                                            foreach ($events as $event) : ?>
                                                <div class="recado">
                                                    <div class="row">

                                                        <div class="col-3 pr-0">
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

                                                        <div class="col-9">
                                                            
                                                            <p class="data">
                                                                <?php 
                                                                    $dataOriginal = $event['date'];
                                                                    // Criar um objeto DateTime
                                                                    $dateTime = new DateTime($dataOriginal);

                                                                    // Nomes dos dias da semana em português
                                                                    $diasSemana = [
                                                                        'Domingo',
                                                                        'Segunda-feira',
                                                                        'Terça-feira',
                                                                        'Quarta-feira',
                                                                        'Quinta-feira',
                                                                        'Sexta-feira',
                                                                        'Sábado'
                                                                    ];

                                                                    // Nomes dos meses abreviados em português
                                                                    $mesesAbreviados = [
                                                                        'jan',
                                                                        'fev',
                                                                        'mar',
                                                                        'abr',
                                                                        'mai',
                                                                        'jun',
                                                                        'jul',
                                                                        'ago',
                                                                        'set',
                                                                        'out',
                                                                        'nov',
                                                                        'dez'
                                                                    ];

                                                                    // Extrair os componentes da data
                                                                    $diaSemana = $diasSemana[(int)$dateTime->format('w')];
                                                                    $mesAbreviado = $mesesAbreviados[(int)$dateTime->format('n') - 1];
                                                                    $diaMes = $dateTime->format('d');
                                                                    $hora = $dateTime->format('H');
                                                                    $minuto = $dateTime->format('i');

                                                                    // Formatar a data no novo formato
                                                                    $dataFormatada = sprintf(
                                                                        "%s, %s %s às %sh%smin",
                                                                        $diaSemana,
                                                                        $mesAbreviado,
                                                                        $diaMes,
                                                                        $hora,
                                                                        $minuto
                                                                    );

                                                                    echo $dataFormatada;
                                                                
                                                                    if( $event['categories'] && $event['post_type'] == 'sorteio' ){
                                                                        echo ' - em ' . $event['categories'];
                                                                    }

                                                                    if( $event['post_type'] == 'cortesias' ){
                                                                        echo ' - em Gratuidade e Cortesias';
                                                                    }
                                                                ?>
                                                            </p>
                                                            <span class="badge badge-pill badge-primary">
                                                                <?php echo esc_html( ucfirst( $event['post_type'] ) ); ?>
                                                            </span>
                                                            <h2><a href="<?= get_home_url(); ?>/sorteio/<?= esc_html($event['id']); ?>"><?php echo esc_html($event['title']); ?></a></h2>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="likes">
                                                                    <?php
                                                                        $total_like1 = $event['likes'];
                                                                        if($total_like1 == 1){
                                                                            $text_total = 'like';
                                                                        } else {
                                                                            $text_total = 'likes';
                                                                        }
                                                        
                                                                        echo '<div class="post_like">';
                                                                            echo '<p class="text-center pp_like ' . $likes . '"><i class="fa fa-heart" aria-hidden="true"></i> ' . $total_like1 . ' ' . $text_total . '</p>';
                                                                        echo '</div>';
                                                                    ?>                                                            
                                                                </div>											
                                                            </div>
                                                            
                                                        </div>

                                                    </div>
                                                </div>
                                        <?php
                                            endforeach;
                                       
                                    }
                                }

                            ?>
                        </div>
                    </div>
                </div>                
            </article>

            

        </div>

    <?php endif; ?>
</main>

<script>
    jQuery(document).ready(function ($) {

        // Máscaras dos inputs
        $('#cpf').mask('000.000.000-00');
        $('#celular').mask('(00) 00000-0000');
        $('#telCom').mask('(00) 0000-0000');

        const camposObrigatorios = [
            '#nomeComp',
            '#emailInsti',
            '#cpf',
            '#emailSec',
            '#celular',
            '#dre',
            '#uniSetor',
            '#ciente'
        ];

        let cpfCadastrado = false;

        function adicionarMensagemErro(campo, mensagem = 'Este campo é de preenchimento obrigatório.') {
            if ($(campo).is('input[type="checkbox"]')) {
                if ($(campo).closest('.form-check').find('.mensagem-erro').length === 0) {
                    $(campo).closest('.form-check').append('<span class="mensagem-erro">' + mensagem + '</span>');
                }
                $(campo).closest('.form-check').find('.mensagem-erro').show();
            } else {
                if ($(campo).next('.mensagem-erro').length === 0) {
                    $(campo).after('<span class="mensagem-erro">' + mensagem + '</span>');
                }
                $(campo).next('.mensagem-erro').show();
            }
        }

        function removerMensagemErro(campo) {
            if ($(campo).is('input[type="checkbox"]')) {
                $(campo).closest('.form-check').find('.mensagem-erro').hide();
            } else {
                $(campo).next('.mensagem-erro').hide();
            }
        }

        function validarCPF(cpf) {
            const cpfLimpo = cpf.replace(/\D/g, '');
            return /^\d{11}$/.test(cpfLimpo);
        }

        function validarCampos(exibirMensagens = false) {
            let tipo_sorteio = jQuery('.sorteio-externo').first().data('tipo-evento');
            let todosPreenchidos = true;
            let camposComErro = [];

            camposObrigatorios.forEach(function (campo) {
                const $campo = $(campo);
                const label = $(`label[for="${$campo.attr('id')}"]`).text().trim() || campo;

                if (campo === '#cpf') {
                    const cpfValue = $campo.val();
                    if ($.trim(cpfValue) === '') {
                        todosPreenchidos = false;
                        camposComErro.push(label);
                        if (exibirMensagens) adicionarMensagemErro($campo);
                    } else if (!validarCPF(cpfValue)) {
                        todosPreenchidos = false;
                        camposComErro.push(`${label} (inválido)`);
                        if (exibirMensagens) adicionarMensagemErro($campo, 'CPF inválido. O CPF deve ter 11 dígitos.');
                    } else {
                        removerMensagemErro($campo);
                    }
                    return;
                }

                if ($campo.is('input[type="checkbox"]')) {
                    if (!$campo.is(':checked')) {
                        todosPreenchidos = false;
                        camposComErro.push(label);
                        if (exibirMensagens) {
                            if ($campo.attr('id') === 'ciente') {
                                adicionarMensagemErro($campo, '<br>Você deve marcar esta opção para prosseguir.');
                            } else {
                                adicionarMensagemErro($campo);
                            }
                        }
                    } else {
                        removerMensagemErro($campo);
                    }
                } else if ($campo.is('select')) {
                    if ($campo.val() === '') {
                        todosPreenchidos = false;
                        camposComErro.push(label);
                        if (exibirMensagens) adicionarMensagemErro($campo);
                    } else {
                        removerMensagemErro($campo);
                    }
                } else {
                    if ($.trim($campo.val()) === '') {
                        todosPreenchidos = false;
                        camposComErro.push(label);
                        if (exibirMensagens) adicionarMensagemErro($campo);
                    } else {
                        removerMensagemErro($campo);
                    }
                }
            });

            // Validação de datas
            const checkboxesDatas = $('input[name="datas[]"]');
            const datasSelecionadas = $('input[name="datas[]"]:checked').length;
            const grupoDatas = $('#grupo-datas');
            const labelDatas = grupoDatas.find('label[for="datas-disponiveis"]');

            if (datasSelecionadas === 0 && checkboxesDatas.length > 0) {
                todosPreenchidos = false;
                (tipo_sorteio == 'premio') ? camposComErro.push('Prêmios que deseja participar') : camposComErro.push('Datas que deseja participar');
                if (exibirMensagens && grupoDatas.find('.mensagem-erro').length === 0) {
                    if (tipo_sorteio == 'premio') {
                        labelDatas.after('<br><span class="mensagem-erro">Selecione ao menos um prêmio.</span>');
                    } else {
                        labelDatas.after('<br><span class="mensagem-erro">Selecione ao menos uma data.</span>');
                    }
                    grupoDatas.find('.mensagem-erro').show();
                } else {
                    grupoDatas.find('.mensagem-erro').show();
                }
            } else {
                grupoDatas.find('.mensagem-erro').hide();
            }

            // Validação de programa_estagio (radios)
            const programaSelecionado = $('input[name="programa_estagio"]:checked').length;
            const grupoPrograma = $('#grupo-programa');
            const labelPrograma = grupoPrograma.find('label').first();

            if (programaSelecionado === 0) {
                todosPreenchidos = false;
                camposComErro.push('Programa de estágio');
                if (exibirMensagens && grupoPrograma.find('.mensagem-erro').length === 0) {
                    labelPrograma.after('<br><span class="mensagem-erro">Selecione uma opção.</span>');
                    grupoPrograma.find('.mensagem-erro').show();
                } else {
                    grupoPrograma.find('.mensagem-erro').show();
                }
            } else {
                grupoPrograma.find('.mensagem-erro').hide();
            }

            // Validação e-mail institucional
            const emailInst = $('#emailInsti').val().trim();
            const grupoEmailInst = $('#grupo-email-institucional');
            const labelEmailInst = grupoEmailInst.find('label');

            if (emailInst === '') {
                todosPreenchidos = false;
                camposComErro.push('E-mail Institucional');
                if (exibirMensagens && grupoEmailInst.find('.mensagem-erro').length === 0) {
                    labelEmailInst.after('<br><span class="mensagem-erro">Preencha o e-mail institucional.</span>');
                    grupoEmailInst.find('.mensagem-erro').show();
                } else {
                    grupoEmailInst.find('.mensagem-erro').show();
                }
            } else if (!emailInst.includes('edu.sme.prefeitura.sp.gov.br')) {
                todosPreenchidos = false;
                camposComErro.push('E-mail Institucional');
                if (exibirMensagens && grupoEmailInst.find('.mensagem-erro').length === 0) {
                    labelEmailInst.after('<br><span class="mensagem-erro">É obrigatório a utilização do e-mail institucional</span>');
                    grupoEmailInst.find('.mensagem-erro').show();
                } else {
                    grupoEmailInst.find('.mensagem-erro').html('É obrigatório a utilização do e-mail institucional').show();
                }
            } else {
                grupoEmailInst.find('.mensagem-erro').hide();
            }

            return { todosPreenchidos, camposComErro };
        }

        camposObrigatorios.forEach(function (campo) {
            $(campo).on('input change focus blur click', function () {
                validarCampos();
            });
        });

        $('input[name="datas[]"]').on('change', function () {
            validarCampos();
        });

        $('input[name="programa_estagio"]').on('change', function () {
            validarCampos();
        });

        validarCampos();

        const cpfInput = $('#cpf');
        const postIdInput = $('#external_sorteio_id');

        cpfInput.on('input', function () {
            const cpfValue = cpfInput.val();
            const postId = postIdInput.val();
            const cpfLimpo = cpfValue.replace(/\D/g, '');

            if (/^\d{11}$/.test(cpfLimpo)) {
                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    method: 'POST',
                    data: {
                        action: 'verificar_cpf',
                        cpf: cpfLimpo,
                        post_id: postId
                    },
                    success: function (response) {
                        if (response.data.success) {
                            cpfCadastrado = !!response.data.data.cadastrado;
                            cpfSancionado = !!response.data.data.sancao;
                            if (cpfCadastrado) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Você já está inscrito neste sorteio!',
                                    text: 'Caso queira cancelar sua inscrição, clique no botão "Cancelar Inscrição" abaixo.',
                                    showCancelButton: true,
                                    cancelButtonText: 'Fechar',
                                    cancelButtonColor: "#6E7881",
                                    showConfirmButton: true,
                                    confirmButtonText: 'Cancelar Inscrição',
                                    confirmButtonColor: "#DC3741",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const emails = response.data.data.emails_cadastrados;
                                        const emailsString = Object.values(emails)
                                            .filter(email => email && email.trim() !== '')
                                            .join('  |  ');
                                        Swal.fire({
                                        icon: 'warning',
                                        title: 'Solicitar cancelamento de inscrição',
                                        html: `
                                            <p>Enviaremos um link para finalização do cancelamento para o(s) e-mail(s) abaixo. Verifique sua caixa de entrada ou spam.</p>
                                            <em class="badge badge-light">${emailsString}</em>
                                        `,
                                        showCancelButton: true,
                                        cancelButtonText: 'Fechar',
                                        cancelButtonColor: "#6E7881",
                                        showConfirmButton: true,
                                        confirmButtonText: 'Confirmar Cancelamento',
                                        confirmButtonColor: "#DC3741",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Chamada AJAX para enviar_email_cancelar                                            
                                            $.ajax({
                                                url: '/wp-admin/admin-ajax.php',
                                                method: 'POST',
                                                data: {
                                                    action: 'enviar_email_cancelar',
                                                    cpf: cpfLimpo,
                                                    post_id: postId,
                                                },
                                                success: function(response) {
                                                    if (response.success) {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Cancelamento solicitado!',
                                                            text: response.data.message,
                                                            confirmButtonText: 'Fechar',
                                                        });
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Erro',
                                                            text: response.data.message,
                                                            confirmButtonText: 'Fechar',
                                                        });
                                                    }
                                                    console.log('Resposta do servidor:', response);
                                                },
                                                error: function(error) {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Erro ao solicitar cancelamento',
                                                        text: 'Tente novamente mais tarde.',
                                                        confirmButtonText: 'Fechar',
                                                    });
                                                    console.error('Erro ao enviar cancelamento:', error);
                                                }
                                            });

                                        }
                                    });
                                }
                                })
                            }

                            if (cpfSancionado) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Atenção',
                                    text: 'Você está impedido de se inscrever em qualquer sorteio, devido à sua ausência em um evento anterior. Você poderá participar de novos sorteios a partir de ' + response.data.data.data_permissao + '.',
                                    confirmButtonText: 'Fechar',
                                });
                            }
                            validarCampos();
                        } else {
                            console.log('Erro ao verificar CPF');
                        }                        
                    },
                    error: function () {
                        console.error('Erro na verificação do CPF');
                    }
                });
            } else {
                cpfCadastrado = false;
                removerMensagemErro('#cpf');
                adicionarMensagemErro('#cpf', 'CPF inválido. O CPF deve ter 11 dígitos.');
                validarCampos();
            }
        });

        // Envio AJAX
        $('#form-inscri').on('submit', function (event) {
            event.preventDefault();

            const { todosPreenchidos, camposComErro } = validarCampos(true);

            if (cpfCadastrado) {
                Swal.fire({
                    icon: 'warning',
                    title: 'CPF já cadastrado!',
                    text: 'Este CPF já está cadastrado para concorrer. Agora é só aguardar e torcer. Boa sorte!',
                    confirmButtonText: 'Fechar',
                });
                return;
            }

            if (!todosPreenchidos) {
                Swal.fire({
                    icon: 'error',
                    title: 'Preenchimento obrigatório!',
                    html: `<p>Por favor, preencha os seguintes campos obrigatórios:</p><ul style="text-align:left">${camposComErro.map(c => `<li>${c}</li>`).join('')}</ul>`,
                    confirmButtonText: 'Ok',
                });
                return;
            }

            const botaoEnviar = $('#botaoEnviar');
            const form = $(this)[0];
            const formOverlay = $('#formLoadingOverlay');

            botaoEnviar.prop('disabled', true);
            formOverlay.show();

            fetch('/wp-admin/admin-ajax.php?action=processar_inscricao', {
                method: 'POST',
                body: new URLSearchParams(new FormData(form))
            })
            .then(async response => {
                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.data?.message || 'Erro no servidor');
                }

                if (data.success) {
                    form.reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('.mensagem-erro').remove();
                    formOverlay.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Inscrição realizada com sucesso!',
                        html: '<p>Agora é só aguardar e torcer. Boa sorte!</p><p>Caso deseje cancelar sua inscrição, acesse novamente a mesma notícia do sorteio, informe o <strong>CPF</strong> no formulário de inscrição e siga as instruções exibidas.</p>',
                        confirmButtonText: 'Fechar',
                    });
                } else if (data.data?.code === 409) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'CPF já cadastrado para o sorteio!',
                        text: 'Este CPF já está cadastrado para concorrer. Agora é só aguardar e torcer. Boa sorte!',
                        confirmButtonText: 'Fechar',
                    });
                } else if (data.data?.code === 410) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        text: 'Você está impedido de se inscrever para este sorteio, devido à sua ausência em um evento anterior. Você poderá participar de novos sorteios a partir de ' + data.data.response_completa?.data_permissao + '.',
                        confirmButtonText: 'Fechar',
                    });
                } else {
                    throw new Error(data.data?.message || 'Erro desconhecido');
                }
                console.log(data);
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro na inscrição',
                    text: error.message,
                    confirmButtonText: 'Fechar'
                });
            })
            .finally(() => {
                botaoEnviar.prop('disabled', false);
                formOverlay.hide();
            });
        });
    });

    /* Scripts da tabela de listagem dos sorteados */
    jQuery(function ($) {
        $('table.datatables').each(function () {

            const $table = $(this);
            const count = $table.find('tbody tr').length;

            $table.DataTable({
                pageLength: 5,
                lengthChange: false,
                ordering: false,
                paging: count >= 5,
                searching: count >= 5,
                info: false,
                stripeClasses: [],
                autoWidth: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
                }
            });

            $table.removeClass('dataTable');
        });
    })
</script>
<?php
get_footer();