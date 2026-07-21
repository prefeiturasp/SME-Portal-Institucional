<?php
/**
 * Template Name: Gratuidade e Cortesias Externo
 */

wp_enqueue_script('datatables');
wp_enqueue_style('datatables');
wp_register_style('slick', STM_THEME_URL . 'classes/assets/css/slick.css', null, null, 'all');
wp_enqueue_style('slick');

wp_register_style('slick-theme', STM_THEME_URL . 'classes/assets/css/slick-theme.css', null, null, 'all');
wp_enqueue_style('slick-theme');

global $wp_query;
get_header();

$sorteio_data = $wp_query->sorteio_data;
$tipo_administracao = isset( $sorteio_data['meta']['administracao_ingressos'] ) ? $sorteio_data['meta']['administracao_ingressos'] : 'ascom';
$qtd_ingressos_inscrito = isset( $sorteio_data['meta']['quantidade_ingressos_inscrito'] ) ? $sorteio_data['meta']['quantidade_ingressos_inscrito'] : 1;
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
$premios = $sorteio_data['premios'];

// echo '<pre>';
// print_r($sorteio_data);
// echo '</pre>';
?>

<main id="primary" class="site-main pt-5" style="background: #F5F6F8;">
    <?php if (isset($sorteio_data['error'])) : ?>
        <!-- Seção de Erro -->
        <article class="sorteio-error">

            <div class="bg_fx_azul lk_fx_azul fx_all mb-5">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-sm-12 tx_fx_branco  mt-3 mb-3 col-bt-azul ">
                            <div class="container">
                                <h1 class="text-left mt-3 mb-3 tx_fx_">Erro ao carregar o evento</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="entry-content">
                <div class="error-message">
                    <p><strong><?= esc_html($sorteio_data['message']); ?></strong></p>
                    <p>ID do post: <?= esc_html(get_query_var('external_sorteio_id')); ?></p>
                    
                    <?php if (current_user_can('manage_options')) : ?>
                        <details class="error-details">
                            <summary>Detalhes técnicos</summary>
                            <pre><?= esc_html($sorteio_data['details']); ?></pre>
                        </details>
                        <p><small>Esta mensagem só é visível para administradores.</small></p>
                    <?php endif; ?>
                </div>
                
                <a href="<?= home_url('/sorteios/'); ?>" class="button">
                    Voltar para a lista de eventos
                </a>
            </div>
        </article>
        
    <?php else : ?>        

        <!-- Seção de Sorteio Válido -->
        <div class="container">
            
            <article class="sorteio-externo content-sorteio" data-tipo-evento="<?php echo esc_html( $sorteio_data['meta']['tipo_evento'] ); ?>">
                <div class="row">

                    <div class="col-12 col-lg-8">
                        <div class="infos-topo-noticia">

                            <div class="row">
                                <div class="col-11">
                                    <h2 class="titulo-noticia-principal mb-3" id="sorteio-<?php echo esc_html($sorteio_data['id']); ?>"><?= esc_html($sorteio_data['title']); ?></h2>
                                </div>
                                <div class="col-1 pl-0">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <div class="likes">
                                            <?php
                                                $total_like1 = $sorteio_data['likes'];
                                                if($total_like1 == 1){
                                                    $text_total = 'like';
                                                } else {
                                                    $text_total = 'likes';
                                                }
                                
                                                echo '<div class="post_like">';
                                                    echo '<p class="text-center pp_like ' . $likes . '"><span class="icon-like"></span> ' . $total_like1 . ' ' . $text_total . '</p>';
                                                echo '</div>';
                                            ?>                                                            
                                        </div>											
                                    </div>
                                </div>
                            </div>
                        
                            <div class="sorteio-subtitulo">
                                <p><?= $sorteio_data['subtitulo']; ?></p>                               
                            </div>                            
                            
                            <?php if (!empty($sorteio_data['thumbnail'])): ?>
                                <div class="event-thumbnail image-wrapper mb-4">
                                    <img src="<?= esc_url($sorteio_data['thumbnail']); ?>" alt="<?= esc_attr($sorteio_data['title']); ?>" class="img-fluid">
                                    <?php if($sorteio_data['post_status'] == 'encerrado'): ?>
                                        <div class="overlay-encerrado"></div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-lg-none">
                            <div class="informacoes-evento">
                                <?php
                                        echo '<table>';
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-question" aria-hidden="true"></i></td>';
                                            echo '<td><strong>' . esc_html($sorteio_data['title']) . '</strong></td>';
                                        echo '</tr>';

                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';

                                        if($genero){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-ticket" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Tipo de Evento: </strong>' . $genero . '</td>';
                                            echo '</tr>';
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }

                                        if($tipo_evento === 'data' && $dataEvento){
                                            $qtd = $sorteio_data['meta']['evento_datas'];
                                            if($qtd > 1){
                                                $label = '<strong>Datas: </strong><br>';
                                            } else {
                                                $label = '<strong>Data: </strong><br>';
                                            }
                                            echo '<tr>';                                            
                                                    echo '<td class="align-top"><i class="fa fa-calendar-o" aria-hidden="true"></i></td>';
                                            
                                                    echo '<td>' . $label . $dataEvento . '</td>';
                                            echo '</tr>';                        
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }

                                        if($tipo_evento === 'periodo' && $periodo_evento){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-calendar-o" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Período: </strong>' . $periodo_evento . '</td>';
                                            echo '</tr>';
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }

                                        if($tipo_evento === 'premio' && !(empty($premios))){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-gift" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Premiação: </strong>';
                                                    echo '<ul>';
                                                    foreach($premios as $premio){
                                                        echo '<li>' . $premio . '</li>';
                                                    }
                                                    echo '</ul>';
                                                echo '</td>';
                                            echo '</tr>';
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }

                                        if($duracao){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-clock-o" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Duração: </strong>' . $duracao . '</td>';
                                            echo '</tr>';
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }

                                        if($class_indicativa){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-users" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Classificação Indicativa: </strong>' . $class_indicativa . '</td>';
                                            echo '</tr>';
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }

                                        if($local){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-building-o" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Local: </strong>' . $local . '</td>';
                                            echo '</tr>';
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }

                                        if($endereco){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-map-marker" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Endereço: </strong>' . $endereco . '</td>';
                                            echo '</tr>';
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }

                                        $adicionais = $sorteio_data['meta']['links_adicionais'];
                                        $adm_ingressos = $sorteio_data['meta']['administracao_ingressos'];
                                        $links_adicionais = montar_links_adicionais($sorteio_data['meta']);

                                        if($adm_ingressos == 'parceiro' && $adicionais > 0 && $link){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-link" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Link para mais informações:</strong>';
                                                    echo '<ul>';
                                                        if ($tituloLink) {
                                                            echo '<li><a href="' . $link . '" target="_blank">' . $tituloLink . '</a></li>';
                                                        } else {
                                                            echo '<li><a href="' . $link . '" target="_blank">Saiba Mais</a></li>';
                                                        }
                                                        foreach ($links_adicionais as $link) {
                                                            if (empty($link['link_infos']) && empty($link['texto_do_link'])) {
                                                                continue;
                                                            } elseif(empty($link['texto_do_link']) && !empty($link['link_infos'])) {
                                                                $link['texto_do_link'] = $link['link_infos'];
                                                            }
                                                            echo '<li><a href="' . $link['link_infos'] . '" target="_blank">' . $link['texto_do_link'] . '</a></li>';
                                                        }
                                                    echo '</ul>';
                                                echo '</td>';
                                            echo '</tr>';

                                        } else {
                                            if($link){
                                                if ($tituloLink) {
                                                    echo '<tr>';
                                                        echo '<td class="align-top"><i class="fa fa-link" aria-hidden="true"></i></td>';
                                                        echo '<td><strong>Link para mais informações: </strong><a href="' . $link . '" target="_blank">' . $tituloLink . '</a></td>';
                                                    echo '</tr>';
                                                } else {
                                                    echo '<tr>';
                                                        echo '<td class="align-top"><i class="fa fa-link" aria-hidden="true"></i></td>';
                                                        echo '<td><strong>Link para mais informações: </strong><a href="' . $link . '" target="_blank">Saiba Mais</a></td>';
                                                    echo '</tr>';
                                                }
                                            }
                                        }

                                        

                                        $dateTime = \DateTime::createFromFormat('Ymd', $dataEncerra);

                                        if($dateTime && $dataEncerra){
                                            echo '<tr>';
                                                echo '<td class="align-top"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></td>';
                                                echo '<td><strong>Inscrições até: </strong>' . $dateTime->format('d/m/Y') . '</td>';
                                            echo '</tr>';
                                            echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                        }
                                            

                                    echo '</table>';
                            
                                    echo '<span class="post-type-tag cortesia-tag"><i class="fa fa-bolt" aria-hidden="true"></i> Ordem de Inscrição</span>';
                                ?>
                            </div>
                        </div>

                        <div class="entry-content infos-noticia">
                            <?= wp_kses_post($sorteio_data['content']);

                            $regras_info = $sorteio_data['meta']['regras_informacoes_evento'];

                            if($regras_info){
                                echo '<p class="title-info">Informações importantes:</p>';
                                echo wpautop($regras_info);
                            }                            
                            ?>
                        </div>

                            <?php if($dataAtual <= $dataEncerra && $datasDisponiveis): ?>

                                <?php
                                    if($exibe_resultado_pagina == '1' && !empty($listaSorteados)) {
                                        
                                                                                 
                                        echo '<div class="mb-4 texto-lista-participantes">';
                                            echo '<div class="col">';
                                                echo '<span class="title-info">Lista de participantes</span>';
                                                echo '<p>Se o seu nome estiver na lista de participantes, acompanhe o e-mail cadastrado para verificar se há necessidade de confirmação da participação.</p>';
                                            echo '</div>';
                                        echo '</div>';
                                        
                                        
                                        if(!empty($listaSorteados)){
                                            echo '<div class="accordion" id="accordion-sorteados">';
                                                foreach ($listaSorteados as $item) {
                                                    echo $item;
                                                }
                                            echo '</div>';
                                        }
                                    }
                                ?>

                                <div class="col-12 mt-5 p-0 order-3" id="form-wrapper">
                                    <div class="form-inscricao">
                                        <div class="form-title">
                                            <h3>Preencha o formulário abaixo com seus dados:</h3>                                        
                                        </div>

                                        <form action="#" method="post" id="form-inscri" class="form-inscri">	

                                            <input type="hidden" name="external_cortesia_id" id="external_cortesia_id" value="<?= esc_attr(get_query_var('external_sorteio_id')); ?>">
                                            <?php wp_nonce_field('processar_inscricao_action', 'inscricao_nonce'); ?>

                                            <div class="form-row">
                                                
                                                <div class="form-group col-12 col-md-9">
                                                    <label for="nomeComp">Nome completo <span>*</span></label>
                                                    <input type="text" class="form-control" name="nomeComp" id="nomeComp" placeholder="Insira seu nome completo">  
                                                </div>
                                                <div class="form-group col-12 col-md-3">
                                                    <label for="cpf">CPF <span>*</span></label>
                                                    <input type="text" name="cpf" class="form-control" id="cpf" placeholder="000.000.000-00">    
                                                </div>

                                            </div>

                                            <div class="form-row">

                                                <div class="form-group col-12 col-md-5" id="grupo-email-institucional">
                                                    <label for="emailInsti">
                                                        E-mail Institucional <span>*</span>
                                                        <i
                                                            class="fa fa-info-circle text-info"
                                                            aria-hidden="true"
                                                            data-toggle="tooltip"
                                                            title='&#9888; Certifique-se de que o e-mail informado foi digitado corretamente, pois ele será utilizado para enviar as próximas orientações do evento, caso você seja contemplado(a).'
                                                            >
                                                        </i>
                                                    </label>
                                                    <input type="email" name="emailInsti" class="form-control" id="emailInsti" placeholder="Insira seu e-mail institucional">
                                                </div> 
                                                <div class="form-group col-12 col-md-4">
                                                    <label for="emailSec">E-mail Secundário <span>*</span></label>
                                                    <input type="email"  name="emailSec" class="form-control" id="emailSec" placeholder="email@provedor.com.br">
                                                </div>
                                                <div class="form-group col-12 col-md-3">
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

                                                <div class="form-group col-12 col-md-3">
                                                    <label for="telCom">Telefone Comercial</label>
                                                    <input type="text" name="telCom" class="form-control" id="telCom" placeholder="(00) 0000-0000">
                                                </div>
                                                <div class="form-group col-12 col-md-3">
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
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="uniSetor">Unidade Escolar ou Setor <span>*</span></label>
                                                    <input type="text" name="uniSetor" class="form-control" id="uniSetor" placeholder="Nome da Unidade Escolar ou Setor">
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

                                                <?php if ( $tipo_evento === 'data' ) : ?>
                                                    <div class="form-row px-1 pt-2 pb-4">
                                                        <?php if ( intval( $qtd_ingressos_inscrito ) === 1 ) : ?>
                                                            <span class="texto-apoio">Preencha os dados acima para realizar sua solicitação, conforme as regras e disponibilidade.</span>
                                                        <?php else : ?>
                                                            <span class="texto-apoio">
                                                                Escolha a data em que deseja participar do evento e informe quantos ingressos você precisa.
                                                                O limite é de <?php echo esc_html( $qtd_ingressos_inscrito . ' ' . _n( 'ingresso', 'ingressos', (int) $qtd_ingressos_inscrito ) ); ?> por inscrito.
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ( $tipo_evento === 'periodo' ) : ?>
                                                    <div class="form-row px-1 pt-2 pb-4">
                                                        <?php if ( intval( $qtd_ingressos_inscrito ) === 1 ) : ?>
                                                            <span class="texto-apoio">Preencha os dados acima para realizar sua solicitação, conforme as regras e disponibilidade.</span>
                                                        <?php else : ?>
                                                            <span class="texto-apoio">
                                                                Solicite seus ingressos informando os dados acima e a quantidade desejada.
                                                                A utilização deverá ocorrer dentro do período indicado na descrição do evento.
                                                                O limite é de <?php echo esc_html( $qtd_ingressos_inscrito . ' ' . _n( 'ingresso', 'ingressos', (int) $qtd_ingressos_inscrito ) ); ?> por inscrito, conforme disponibilidade.
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ( $tipo_evento === 'premio' ) : ?>
                                                    <div class="form-row px-1 pt-2 pb-4">
                                                        <?php if ( intval( $qtd_ingressos_inscrito ) === 1 ) : ?>
                                                            <span class="texto-apoio">Preencha os dados acima para realizar sua solicitação, conforme as regras e disponibilidade.</span>
                                                        <?php else : ?>
                                                            <span class="texto-apoio">
                                                                Selecione o prêmio e informe a quantidade que deseja.
                                                                O limite é de <?php echo esc_html( $qtd_ingressos_inscrito . ' ' . _n( 'unidade', 'unidades', (int) $qtd_ingressos_inscrito ) ); ?> por inscrito.
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ( $tipo_evento === 'periodo' ) : ?>
                                                    <input type="hidden" name="data" value="<?php echo esc_html( $datasDisponiveis[0]['id'] ?? '' ); ?>">
                                                <?php endif; ?>

                                                <?php if ($datasDisponiveis && $tipo_evento != 'periodo' ) : ?>
                                                    <div class="form-group col-12" id="grupo-datas">
                                                        <?php if ( $tipo_evento === 'premio' ) : ?>
                                                            <label for="datas-disponiveis">Selecione o prêmio que deseja: <span>*</span></label>
                                                        <?php else : ?>
                                                            <label for="datas-disponiveis">Selecione a data que deseja participar: <span>*</span></label>
                                                        <?php endif; ?>

                                                        <div class="datas-select my-3">
                                                            <?php foreach ( $datasDisponiveis as $data ) : ?>                                                       
                                                                <div class="form-check">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="data"
                                                                        value="<?php echo esc_attr( $data['id'] ); ?>"
                                                                        id="data-<?php echo esc_html( $data['id'] ); ?>"
                                                                    >
                                                                    <?php
                                                                        $dias_semana = [
                                                                            'Sunday' => 'domingo',
                                                                            'Monday' => 'segunda-feira',
                                                                            'Tuesday' => 'terça-feira',
                                                                            'Wednesday' => 'quarta-feira',
                                                                            'Thursday' => 'quinta-feira',
                                                                            'Friday' => 'sexta-feira',
                                                                            'Saturday' => 'sábado',
                                                                        ];
                                                                                                                                        
                                                                        $dataObj = DateTime::createFromFormat('Y-m-d H:i:s', $data['data_evento']);
                                                                        $dataFormatada = $dataObj ? $dataObj->format('d/m à\s H\hi') : '';
                                                                        $dia_semana = $dataObj ? $dias_semana[$dataObj->format('l')] : '';
                                                                        $dataFormatada = str_replace('h00', 'h', $dataFormatada);
                                                                        $dataFormatada .= ", {$dia_semana}";
                                                                    ?>

                                                                    <label class="form-check-label" for="data-<?php echo esc_html( $data['id'] ); ?>">
                                                                        <?php if($tipo_evento == 'premio'): ?>
                                                                            <?php echo esc_html( $data['premio'] ); ?>
                                                                        <?php else: ?>
                                                                            <?php echo esc_html( $dataFormatada ); ?>
                                                                        <?php endif; ?>
                                                                    </label>
                                                                </div>                                                        
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <?php if ( intval( $qtd_ingressos_inscrito ) > 1 ) : ?>

                                                <?php if ( $tipo_evento != 'premio' ) : ?>
                                                    <div class="form-row">
                                                        <div class="form-group col">
                                                            <label for="disciplina">Quantidade de ingressos: <span>*</span></label>
                                                            <input
                                                                type="number"
                                                                name="qtd"
                                                                class="form-control"
                                                                id="qtd"
                                                                placeholder="Informe quantos ingressos você precisa"
                                                                min="1"
                                                                max="<?php echo esc_html( $qtd_ingressos_inscrito ); ?>"
                                                                >
                                                        </div>							
                                                    </div>
                                                <?php else : ?>

                                                    <div class="form-row">
                                                        <div class="form-group col">
                                                            <label for="disciplina">Quantidade: <span>*</span></label>
                                                            <input
                                                                type="number"
                                                                name="qtd"
                                                                class="form-control"
                                                                id="qtd"
                                                                placeholder="Informe a quantidade que você precisa"
                                                                min="1"
                                                                max="<?php echo esc_html( $qtd_ingressos_inscrito ); ?>"
                                                                >
                                                        </div>							
                                                    </div>
                                                <?php endif; ?>

                                            <?php endif; ?>

                                            <?php if ( intval( $qtd_ingressos_inscrito ) === 1 ) : ?>
                                                <input type="hidden" name="qtd" id="qtd" value="1">
                                            <?php endif; ?>
                                            
                                            <div class="form-row mt-2">
                                                <div class="form-group col">

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="ciente" value="1" id="ciente">
                                                        <label class="form-check-label d-block termos" for="ciente">
                                                            Declaro estar ciente de que, após a solicitação da cortesia, poderei ser contatado(a) por e-mail para confirmar minha participação ou a retirada do benefício, dentro do prazo estabelecido pelo parceiro. A não confirmação dentro do prazo poderá resultar na perda do direito ao benefício.
                                                        </label>
                                                    </div>

                                                </div>							
                                            </div>

                                            <div class="buttons-group text-right">
                                                <a href="javascript:history.back()" class="btn btn-outline mr-4">Voltar</a> 
                                                <input type="submit" value="Enviar" class="btn btn-principal" id="botaoEnviar">
                                            </div>
                                            
                                            <div class="form-loading-overlay" id="formLoadingOverlay">
                                                <div class="form-loading-content">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/classes/assets/img/load-32_256.gif" alt="Carregando" class="w-50">
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>

                            <?php else: 
                                if($exibe_resultado_pagina == '1') {
                                                                             
                                    echo '<div class="mb-4 texto-lista-participantes">';
                                        echo '<div class="col">';
                                            echo '<span class="title-info">Lista de participantes</span>';
                                            echo '<p>Se o seu nome estiver na lista de participantes, acompanhe o e-mail cadastrado para verificar se há necessidade de confirmação da participação.</p>';
                                        echo '</div>';
                                    echo '</div>';
                                       
                                    
                                    if(!empty($listaSorteados)){
                                         echo '<div class="accordion" id="accordion-sorteados">'; 
                                            foreach ($listaSorteados as $item) {
                                                echo $item;
                                            }
                                         echo '</div>'; 
                                    }
                                } else { ?>
                                    <?php if ( $dataAtual > $dataEncerra ) : ?>
                                        <div class="msg-encerrado text-center">                                            
                                            <?php if ( $tipo_administracao === 'parceiro' ) : ?>
                                                <div class="icone-alerta">
                                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                </div>
                                                <h3>Inscrições Encerradas!</h3>
                                                <p>
                                                    A administração desta gratuidade/cortesia foi realizada pelo site do parceiro<br>
                                                    Para informações sobre o resultado, consulte o site do parceiro.
                                                </p>
                                            <?php elseif (  $tipo_evento === 'premio' ) : ?>
                                                <div class="msg-encerrado text-center">
                                                    <div class="icone-alerta">
                                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                    </div>
                                                    <h3>Prêmios esgotados!</h3>
                                                    <p>No momento, não há opções disponíveis para solicitação.</p>
                                                </div>
                                            <?php else : ?>
                                                <div class="icone-alerta">
                                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                </div>
                                                <h3>Inscrições Encerradas!</h3>
                                                <p>O período de inscrições foi encerrado. Fique de olho em nosso site para futuras oportunidades!</p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                            <?php } endif; ?>

                    </div>

                    <div class="d-none d-lg-block col-12 col-lg-4">
                        <div class="informacoes-evento">
                            <?php
                                    echo '<table>';
                                    echo '<tr>';
                                        echo '<td class="align-top"><i class="fa fa-question" aria-hidden="true"></i></td>';
                                        echo '<td><strong>' . esc_html($sorteio_data['title']) . '</strong></td>';
                                    echo '</tr>';

                                    echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';

                                    if($genero){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-ticket" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Tipo de Evento: </strong>' . $genero . '</td>';
                                        echo '</tr>';
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }

                                    if($tipo_evento === 'data' && $dataEvento){
                                        $qtd = $sorteio_data['meta']['evento_datas'];
                                        if($qtd > 1){
                                            $label = '<strong>Datas: </strong><br>';
                                        } else {
                                            $label = '<strong>Data: </strong><br>';
                                        }
                                        echo '<tr>';                                            
                                                echo '<td class="align-top"><i class="fa fa-calendar-o" aria-hidden="true"></i></td>';
                                           
                                                echo '<td>' . $label . $dataEvento . '</td>';
                                        echo '</tr>';                        
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }

                                    if($tipo_evento === 'periodo' && $periodo_evento){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-calendar-o" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Período: </strong>' . $periodo_evento . '</td>';
                                        echo '</tr>';
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }

                                    if($tipo_evento === 'premio' && !(empty($premios))){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-gift" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Premiação: </strong>';
                                                echo '<ul>';
                                                foreach($premios as $premio){
                                                    echo '<li>' . $premio . '</li>';
                                                }
                                                echo '</ul>';
                                            echo '</td>';
                                        echo '</tr>';
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }

                                    if($duracao){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-clock-o" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Duração: </strong>' . $duracao . '</td>';
                                        echo '</tr>';
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }

                                    if($class_indicativa){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-users" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Classificação Indicativa: </strong>' . $class_indicativa . '</td>';
                                        echo '</tr>';
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }

                                    if($local){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-building-o" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Local: </strong>' . $local . '</td>';
                                        echo '</tr>';
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }

                                    if($endereco){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-map-marker" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Endereço: </strong>' . $endereco . '</td>';
                                        echo '</tr>';
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }

                                    $adicionais = $sorteio_data['meta']['links_adicionais'];
                                    $adm_ingressos = $sorteio_data['meta']['administracao_ingressos'];
                                    $links_adicionais = montar_links_adicionais($sorteio_data['meta']);

                                    if($adm_ingressos == 'parceiro' && $adicionais > 0 && $link){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-link" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Link para mais informações:</strong>';
                                                echo '<ul>';
                                                    if ($tituloLink) {
                                                        echo '<li><a href="' . $link . '" target="_blank">' . $tituloLink . '</a></li>';
                                                    } else {
                                                        echo '<li><a href="' . $link . '" target="_blank">Saiba Mais</a></li>';
                                                    }
                                                    foreach ($links_adicionais as $link) {
                                                        if (empty($link['link_infos']) && empty($link['texto_do_link'])) {
                                                            continue;
                                                        } elseif(empty($link['texto_do_link']) && !empty($link['link_infos'])) {
                                                            $link['texto_do_link'] = $link['link_infos'];
                                                        }
                                                        echo '<li><a href="' . $link['link_infos'] . '" target="_blank">' . $link['texto_do_link'] . '</a></li>';
                                                    }
                                                echo '</ul>';
                                            echo '</td>';
                                        echo '</tr>';

                                    } else {
                                        if($link){
                                            if ($tituloLink) {
                                                echo '<tr>';
                                                    echo '<td class="align-top"><i class="fa fa-link" aria-hidden="true"></i></td>';
                                                    echo '<td><strong>Link para mais informações: </strong><a href="' . $link . '" target="_blank">' . $tituloLink . '</a></td>';
                                                echo '</tr>';
                                            } else {
                                                echo '<tr>';
                                                    echo '<td class="align-top"><i class="fa fa-link" aria-hidden="true"></i></td>';
                                                    echo '<td><strong>Link para mais informações: </strong><a href="' . $link . '" target="_blank">Saiba Mais</a></td>';
                                                echo '</tr>';
                                            }
                                        }
                                    }

                                    

                                    $dateTime = \DateTime::createFromFormat('Ymd', $dataEncerra);

                                    if($dateTime && $dataEncerra){
                                        echo '<tr>';
                                            echo '<td class="align-top"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></td>';
                                            echo '<td><strong>Inscrições até: </strong>' . $dateTime->format('d/m/Y') . '</td>';
                                        echo '</tr>';
                                        echo '<tr><td colspan="2"><span class="divisor"></span></td></tr>';
                                    }
                                           

                                echo '</table>';
                        
                                echo '<span class="post-type-tag cortesia-tag"><i class="fa fa-bolt" aria-hidden="true"></i> Ordem de Inscrição</span>';
                            ?>
                        </div>
                    </div>

                </div>                
            </article>

        </div>

        <div class="py-5 posts-recentes">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="recentes-title d-flex justify-content-between align-items-center">
                                <?php $link = get_field('pag_sorteios', 'conf-lateral'); ?>
                                <h3>Eventos Recentes</h3>
                                <div class="recentes-nav">
                                    <?php
                                        if($link){
                                            echo '<a href="' . get_permalink($link) . '">Ver todos</a>';
                                        }
                                    ?>
                                    <button class="recentes-nav-prev btn"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                                    <button class="recentes-nav-next btn"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            
                            <?php
                                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                                $qtd = 12;                            
                                
                                $current_date = date('Ymd');
                                $args = [                                    
                                    'per_page' => $qtd,
                                    'post__not_in' => $sorteio_data['id'],
                                    'page' => $paged,
                                    'ignore_sticky_posts' => 1,
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
                                        echo '<div class="recent-posts-slider">';
                                            foreach ($events as $event) : ?>
                                                <div class="carrosel-sorteio">
                                                    <div class="item-sorteio item-ativos">
                                                        <div class="row h-100 m-0">

                                                            <a href="<?php echo esc_url( get_home_url() . '/sorteio/' . $event['id'] ); ?>" class="col-12 col-md-6 p-0 image-wrapper">
                                                                <div class="event-thumbnail">
                                                                    <div class="bg" style="background-image: url('<?php echo esc_url( $event['thumbnail'] ); ?>');"></div>
                                                                    <img src="<?php echo esc_url($event['thumbnail']); ?>" alt="<?php echo esc_attr($event['title']); ?>" class="img-fluid">
                                                                    <?php if ( $event['status'] == 'encerrados' ) : ?>
                                                                        <div class="overlay-encerrado"></div>
                                                                    <?php endif; ?>
                                                                </div>
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
                                                                            ?>
                                                                        </div>

                                                                        <?php if ( isset( $event['post_type'] ) && !empty( $event['post_type'] ) ) : 
                                                                            if($event['post_type'] == 'cortesias'){
                                                                                $class_tag = 'cortesia-tag';
                                                                                $label_tag = 'Ordem de Inscrição';
                                                                                $label_icon = 'fa fa-bolt';
                                                                            } else {
                                                                                $class_tag = '';
                                                                                $label_tag = 'Sorteio';
                                                                                $label_icon = 'fa fa-cube';
                                                                            }
                                                                            ?>
                                                                            <span class="post-type-tag mt-auto <?= $class_tag ?? '' ?>">
                                                                                <i class="<?php echo esc_html( $label_icon ); ?>" aria-hidden="true"></i>
                                                                                <?= esc_html( $label_tag ); ?>
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    
                                                                    </div>
                                                                    
                                                                    <div class="col-12 col-md-2 pl-0">
                                                                        <?php
                                                                            $total_like1 = $event['likes'];
                                                                            if($total_like1 == 1){
                                                                                $text_total = 'like';
                                                                            } else {
                                                                                $text_total = 'likes';
                                                                            }
                                                            
                                                                            echo '<div class="post_like">';
                                                                                echo '<p class="text-center pp_like ' . $likes . '"><img src=' . get_template_directory_uri() . '/img/icone-likes.svg alt="like" class="mx-auto my-0">' . $total_like1 . ' ' . $text_total . '</p>';
                                                                            echo '</div>';
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                        <?php
                                            endforeach;
                                        echo '</div>';
                                    }
                                }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</main>

<?php
// SLick Carousel - JS
wp_register_script('slick',  STM_THEME_URL . 'classes/assets/js/slick.js', array ('jquery'), false, false);
wp_enqueue_script('slick');
?>

<script>

    // Pega a listagem de dominios de e-mail que devem ser verificados.
    var validacaoConfig = {
        'listaDominiosEmail': <?php echo wp_json_encode( $sorteio_data['dominios_validacao'] ); ?>
    }

    var $s = jQuery.noConflict();
    $s(document).ready(function(){
        $s('.recent-posts-slider').slick({
			slidesToShow: 1,
			rows: 2,
			slidesPerRow: 2,
			arrows: true,
			adaptiveHeight: false,
			prevArrow: $s('.recentes-nav-prev'),
    		nextArrow: $s('.recentes-nav-next'),
			responsive: [
				{
					breakpoint: 768,
					settings: {
						rows: 1,
						slidesPerRow: 1
					}
				}
			]
		});
    });

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
                $(campo).next('.mensagem-erro').remove();
            }
        }

        function validarCPF(cpf) {
            const cpfLimpo = cpf.replace(/\D/g, '');
            return /^\d{11}$/.test(cpfLimpo);
        }

        // Função para validar o email digitado nos campos do formulário de inscrição
        function possuiDominioEmailSuspeito(email) {

            if (!email || !email.includes('@')) {
                return false;
            }
        
            const dominio = email
                .split('@')
                .pop()
                .toLowerCase()
                .trim();

            return validacaoConfig.listaDominiosEmail.map(item => item.toLowerCase()).includes(dominio);
        
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

                // Validação específica para o campo de e-mail secundário
                if (campo === '#emailSec') {
                    const emailInstitucional = $.trim($('#emailInsti').val());
                    const emailSecundario = $.trim($campo.val());

                    if (emailSecundario === '') {

                        removerMensagemErro($campo);
                        todosPreenchidos = false;
                        camposComErro.push(label);
                        if (exibirMensagens) adicionarMensagemErro($campo, 'Este campo é de preenchimento obrigatório.');

                    } else if (possuiDominioEmailSuspeito(emailSecundario)) {

                        removerMensagemErro($campo);
                        todosPreenchidos = false;
                        camposComErro.push(`${label} (verificar)`);
                    
                        if (exibirMensagens) {
                            adicionarMensagemErro(
                                $campo,
                                'O domínio informado parece estar incorreto. Verifique o e-mail digitado.'
                            );
                        }

                    } else if (emailSecundario === emailInstitucional) {
                        
                        removerMensagemErro($campo);
                        todosPreenchidos = false;
                        camposComErro.push(`${label} (inválido)`);
                        if (exibirMensagens) adicionarMensagemErro($campo, 'O e-mail secundário deve ser diferente do e-mail institucional.');
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
            const checkboxesDatas = $('input[type="radio"][name="data"]');
            const dataSelecionada = $('input[name="data"]:checked').length;
            const grupoDatas = $('#grupo-datas');
            const labelDatas = grupoDatas.find('label[for="datas-disponiveis"]');

            if (dataSelecionada === 0 && checkboxesDatas.length > 0) {
                todosPreenchidos = false;
                (tipo_sorteio == 'premio') ? camposComErro.push('Prêmio que deseja solicitar') : camposComErro.push('Data que deseja participar');
                if (exibirMensagens && grupoDatas.find('.mensagem-erro').length === 0) {
                    if (tipo_sorteio == 'premio') {
                        labelDatas.after('<br><span class="mensagem-erro">Selecione um prêmio.</span>');
                    } else {
                        labelDatas.after('<br><span class="mensagem-erro">Selecione uma data.</span>');
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
                    labelPrograma.after('<span class="mensagem-erro">Selecione uma opção.</span><br>');
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
                if (exibirMensagens && grupoEmailInst.find('.mensagem-erro').length === 0) {
                    grupoEmailInst.append('<span class="mensagem-erro">Preencha o e-mail institucional.</span>');
                    grupoEmailInst.find('.mensagem-erro').show();
                } else {
                    grupoEmailInst.find('.mensagem-erro').show();
                }
            } else if (!emailInst.includes('edu.sme.prefeitura.sp.gov.br')) {
                todosPreenchidos = false;
                camposComErro.push('E-mail Institucional');
                if (exibirMensagens && grupoEmailInst.find('.mensagem-erro').length === 0) {
                    grupoEmailInst.append('<span class="mensagem-erro">É obrigatório a utilização do e-mail institucional</span>');
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

        $('input[name="data"]').on('change', function () {
            validarCampos();
        });

        $('input[name="programa_estagio"]').on('change', function () {
            validarCampos();
        });

        validarCampos();

        const cpfInput = $('#cpf');
        const postIdInput = $('#external_cortesia_id');

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
                                const tipoEvento = $('.sorteio-externo').first().data('tipo-evento');
                                let alertTitle = 'Você já está inscrito';
                                let alertText = 'Caso queira cancelar sua inscrição, clique no botão "Cancelar Inscrição" abaixo.'


                                Swal.fire({
                                    icon: 'warning',
                                    title: alertTitle,
                                    text: alertText,
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
                                    text: 'Você está temporariamente impedido de se inscrever em novas oportunidades, devido à ausência em uma participação anterior. Você poderá realizar novas inscrições a partir de ' + response.data.data.data_permissao + '.',
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
                    confirmButtonColor: '#14447C'
                });
                return;
            }

            const emailPrincipal = $('#emailInsti').val();
            const emailSecundario = $('#emailSec').val();

            Swal.fire({
                html: `
                    <div class="text-left">
                        <h2 class="mb-4"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i> Confirme seus e-mails</h2>
                        <span>Antes de concluir sua inscrição, confira se os e-mails informados estão corretos:</span>

                        <div class="my-3">
                            <div><strong>E-mail principal:</strong> <strong class="new-text-primary">${emailPrincipal}</strong></div>
                            <div><strong>E-mail secundário:</strong> <strong class="new-text-primary">${emailSecundario}</strong></div>
                        </div>

                        <span>Toda comunicação sobre o evento, caso você seja contemplado(a), será enviada para esses e-mails.</span>

                        <p class="mt-4">Deseja continuar?</p>
                        <hr>
                    </div>
                `,
                width: 600,
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                confirmButtonColor: '#14447C',
                reverseButtons: true

            }).then((result) => {

                if (!result.isConfirmed) {
                    return;
                }

                const botaoEnviar = $('#botaoEnviar');
                const form = $(this)[0];
                const formOverlay = $('#formLoadingOverlay');

                botaoEnviar.prop('disabled', true);
                formOverlay.show();

                fetch('/wp-admin/admin-ajax.php?action=processar_inscricao_cortesia', {
                    method: 'POST',
                    body: new URLSearchParams(new FormData(form))
                })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.data?.message || 'Erro no servidor');
                    }

                    if (data.success) {
                        const tipoEvento = $('.sorteio-externo').first().data('tipo-evento');

                        form.reset();
                        $('.is-invalid').removeClass('is-invalid');
                        $('.mensagem-erro').remove();
                        formOverlay.hide();

                        let alertTitle = 'Sua inscrição foi realizada com sucesso!';
                        let alertHtml = '<p>Em breve enviaremos por e-mail as instruções para utilização do(s) ingresso(s).<br>Caso deseje cancelar sua inscrição, acesse novamente a mesma notícia, informe o CPF no formulário de inscrição e siga as instruções exibidas.</p>'

                        if (tipoEvento === 'premio') {
                            alertHtml = 'Em breve enviaremos por e-mail as instruções para retirada e utilização do prêmio selecionado.<br>Caso deseje cancelar sua inscrição, acesse novamente a mesma notícia, informe o CPF no formulário de inscrição e siga as instruções exibidas.';
                        }

                        Swal.fire({
                            icon: 'success',
                            title: alertTitle,
                            html: alertHtml,
                            confirmButtonText: 'Fechar',
                        });
                    } else if (data.data?.code === 400) {

                        exibirMensagemErroInscricao(data.data.response_completa);

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
                            text: 'Você está impedido de se inscrever, devido à sua ausência em um evento anterior. Você poderá realizar novas inscrições a partir de ' + data.data.response_completa?.data_permissao + '.',
                            confirmButtonText: 'Fechar',
                        });
                    } else {
                        throw new Error(data.data || 'Erro desconhecido');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro na inscrição',
                        text: 'Houve um erro ao realizar a inscrição. Tente novamente mais tarde.',
                        confirmButtonText: 'Fechar'
                    });
                })
                .finally(() => {
                    botaoEnviar.prop('disabled', false);
                    formOverlay.hide();
                });
                

            });
        });

        function exibirMensagemErroInscricao(response) {

            const tipoEvento = $('.sorteio-externo').first().data('tipo-evento');
            let title;
            let message;
            let stock;
            let quantityText;

            switch (response.error) {
                case 'insufficient_stock':
                    stock = parseInt(response.data.estoque_atual);
                    quantityText = (stock === 1) ? 'ingresso' : 'ingressos';

                    title = 'Ops!';
                    message = `A quantidade solicitada não está mais disponível no momento. Você pode solicitar até ${stock} ${quantityText} ou selecionar outra data/hora.`;

                    if ( tipoEvento === 'periodo' ) {
                        message = `A quantidade solicitada não está mais disponível no momento. Você pode solicitar até ${stock} ${quantityText}.`;
                    }

                    if ( tipoEvento === 'premio' ) {
                        quantityText = (stock === 1) ? 'prêmio' : 'prêmios';
                        message = `A quantidade solicitada não está mais disponível. Você pode solicitar até ${stock} ${quantityText} ou selecionar outra opção.`;
                    }

                    break;

                case 'no_stock':
                    verificaDisponibilidadeDatas();

                    title = 'Ops!';
                    message = 'Enquanto você preenchia o formulário, os ingressos para essa data/hora se esgotaram. Para continuar, selecione um novo dia.';

                    if ( tipoEvento === 'periodo' ) {
                        message = ' Enquanto você preenchia o formulário, os ingressos para este período se esgotaram. No momento, não há mais disponibilidade.';
                    }

                    if ( tipoEvento === 'premio' ) {
                        message = ' Enquanto você preenchia o formulário, os prêmios dessa opção se esgotaram. Para continuar, selecione outra premiação disponível.';
                    }
                    break;

                case 'invalid_quantity':
                    
                    title = 'Quantidade inválida!';
                    message = `Quantidade máxima excedida. O limite é de ${response.data.limite_por_usuario} por inscrito.`;

                    break;

                case 'zero_quantity':
                    
                    title = 'Quantidade inválida!';
                    message = 'Informe uma quantidade válida.';

                    break;
            }

            Swal.fire({
                icon: 'error',
                title: title,
                text: message,
                confirmButtonText: 'Fechar'
            });
        }

        // Função para ocultar o formulário caso todas as datas se esgotem durante a inscrição
        function verificaDisponibilidadeDatas() {
            const $grupoDatas = $('#grupo-datas');
            const $dataSelecionada = $('input[name="data"]:checked');
            const tipoEvento = $('.sorteio-externo').first().data('tipo-evento');

            $dataSelecionada.parent('.form-check').remove();

            if($grupoDatas.find('.form-check').length == 0) {
                $('.form-inscricao').remove();

                let titulo = 'Ingressos esgotados!';
                let conteudo = 'No momento, não há mais ingressos disponíveis para este evento.'

                if (tipoEvento === 'premio') {
                    titulo = 'Prêmios esgotados!';
                    conteudo = 'No momento, não há opções disponíveis para solicitação.'
                }

                $('.sorteio-externo .entry-content').after(`
                    <div class="msg-encerrado text-center">
                        <h3>${titulo}</h3>
                        <p>${conteudo}</p>
                    </div>
                `)
            }
        }
    });

    /* Scripts da tabela de listagem dos sorteados */
    jQuery(function ($) {
        $('table.datatables').each(function () {

            const $table = $(this);
            const count = $table.find('tbody tr').length;
            const $collapse = $table.closest('.collapse').parent();

            let currentTable = $table.DataTable({
                pageLength: 5,
                lengthChange: false,
                ordering: false,
                paging: count > 5,
                searching: true,
                info: false,
                stripeClasses: [],
                autoWidth: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                    paginate: {
                        previous: '<i class="fa fa-chevron-left"></i>',
                        next: '<i class="fa fa-chevron-right"></i>'
                    }
                },
                pagingType: "simple_numbers",
                dom: 'rtip',
            });

            $table.removeClass('dataTable');

            //Busca personalizada
            $collapse.find('.input-nome-participante').on('keyup', function() {
                currentTable.search($s(this).val()).draw();
            });

            // Botão limpar
            $collapse.find('.btn-limpar-filtro').on('click', function() {
                $collapse.find('.input-nome-participante').val('');
                currentTable.search('').draw();
            });
        });
    })

    /*
    Controla os eventos relacionados aos collapses de listagem
    dos participantes contemplados no evento.
    */
    jQuery(function($) {

        function atualizarFiltro($collapse, event) {

            const $bloco = $collapse.closest('.conteudo-tab-lista-sorteados');
            const $filter = $bloco.find('.filtro-contemplados');
            const showFilter = $bloco.find('.dataTables_paginate').length // Se a paginação estiver ativa, exibe também o filtro de busca

            if (event === 'hide.bs.collapse') {
                $filter.addClass('d-none');
            }

            if (showFilter && event === 'show.bs.collapse' ) {
                $filter.removeClass('d-none');
            }

        }

        $(document).on('show.bs.collapse', '#accordion-sorteados .collapse', function(){
            atualizarFiltro($(this), 'show.bs.collapse')
        });

        $(document).on('hide.bs.collapse', '#accordion-sorteados .collapse', function(){
            atualizarFiltro($(this), 'hide.bs.collapse')
        });
    })
</script>

<?php
function montar_links_adicionais(array $meta) {
    if (empty($meta['links_adicionais']) || !is_numeric($meta['links_adicionais'])) {
        return [];
    }

    $total = (int) $meta['links_adicionais'];
    $resultado = [];

    for ($i = 0; $i < $total; $i++) {

        $link  = $meta["links_adicionais_{$i}_link_infos"] ?? '';
        $texto = $meta["links_adicionais_{$i}_texto_do_link"] ?? '';

        // só adiciona se tiver conteúdo válido
        if (!empty($link) || !empty($texto)) {
            $resultado[] = [
                'link_infos'     => $link,
                'texto_do_link'  => $texto,
            ];
        }
    }

    return $resultado;
}
get_footer();