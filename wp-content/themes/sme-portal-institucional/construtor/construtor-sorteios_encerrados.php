<?php
    if(!isset($_GET['filtro'])){
        // Slick
        wp_register_style('slick', STM_THEME_URL . 'classes/assets/css/slick.css', null, null, 'all');
        wp_enqueue_style('slick');

        wp_register_style('slick-theme', STM_THEME_URL . 'classes/assets/css/slick-theme.css', null, null, 'all');
        wp_enqueue_style('slick-theme');

        $qtd = get_sub_field('qtd');
        $colunas = get_sub_field('colunas');
        $titulo = get_sub_field('titulo');
        $link = get_sub_field('link_ver_todos');
        $calc = (1360 / $colunas) - 30;
        global $has_posts;

        if (!empty($_GET)) {
            $link .= (strpos($link, '?') === false ? '?' : '&') . http_build_query($_GET);
        }

        if(!$qtd)
            $qtd = 10;

        $current_date = date('Ymd');
        $args = [
            'per_page' => $qtd,
            'fields' => 'id,title,content,excerpt,date,slug,meta,thumbnail' // Solicite todos os campos 
        ];

        $data_inicio = isset($_GET['dataInicio']) ? sanitize_text_field($_GET['dataInicio']) : '';
        $data_fim = isset($_GET['dataFim']) ? sanitize_text_field($_GET['dataFim']) : '';

        $data_inicio = $data_inicio ? date('Y-m-d', strtotime($data_inicio)) : '';
        $data_fim = $data_fim ? date('Y-m-d', strtotime($data_fim)) : '';

        // Converte para timestamp e aplica validação
        $timestamp_inicio = $data_inicio ? strtotime($data_inicio) : false;
        $timestamp_fim = $data_fim ? strtotime($data_fim) : false;
        $timestamp_atual = strtotime($current_date);

        // Ajusta as datas para não serem menores que a atual
        if ($timestamp_inicio && $timestamp_inicio >= $timestamp_atual) {
            $data_inicio = $current_date;
        }

        if ($timestamp_fim && $timestamp_fim >= $timestamp_atual) {
            $data_fim = $current_date;
        }

        if(!$data_fim){
            $data_fim = $current_date;
        }

        if($data_fim == $current_date){
            $compare = '<';
        } else{
            $compare = '<=';
        }


        // Se NÃO houver filtro por data
        if (empty($data_inicio) && empty($data_fim)) {
            $args['meta_query'] = json_encode(array(
                [
                'key' => 'enc_inscri',
                'value' => $current_date,
                'compare' => '<',
                'type' => 'DATE',
                ]
            ));
        }

        // Se houver APENAS dataInicio
        elseif (empty($data_inicio) && !empty($data_fim)) { 
            $args['meta_query'] = json_encode(
                [
                    array(
                        [
                            'key' => 'enc_inscri',
                            'value' => $data_inicio,
                            'compare' => '>=',
                            'type' => 'DATE',
                        ]
                    ),

                    array(
                        [
                            'key' => 'enc_inscri',
                            'value' => $data_fim,
                            'compare' => $compare,
                            'type' => 'DATE',
                        ]
                    )
                ]
            );
        }

        // Se houver APENAS dataFim
        elseif (empty($data_inicio) && !empty($data_fim)) {

            $args['meta_query'] = json_encode(array(
                [
                'key' => 'enc_inscri',
                'value' => $data_fim,
                'compare' => $compare, // enc_inscri < dataFim (não precisa comparar com current_date)
                'type' => 'DATE',
                ]
            ));
        }

        // Se houver AMBOS dataInicio e dataFim
        elseif (!empty($data_inicio) && !empty($data_fim)) {

            $args['meta_query'] = json_encode(
                [
                    array(
                        [
                            'key' => 'enc_inscri',
                            'value' => $data_inicio,
                            'compare' => '>=',
                            'type' => 'DATE',
                        ]
                    ),

                    array(
                        [
                            'key' => 'enc_inscri',
                            'value' => $data_fim,
                            'compare' => $compare,
                            'type' => 'DATE',
                        ]
                    )
                ]
            );
        }

        if(isset($_GET['local']) && !empty($_GET['local'])){
            $args['tag_ids'] = sanitize_text_field($_GET['local']);
        }

        $request_args = [
            'timeout' => 30, // Timeout de 30 segundos
            'sslverify' => false // Desativa verificação SSL em localhost
        ];

        $response = wp_remote_get(
            add_query_arg($args, getenv('SORTEIOS_API').'?status=encerrados'),
            $request_args
        );

        // Verifica se a requisição foi bem sucedida
        if (is_wp_error($response)) {
            echo '<div class="error">Erro ao carregar os eventos: ' . $response->get_error_message() . '</div>';
        } else {
            $events = json_decode(wp_remote_retrieve_body($response), true);
            $total_events = wp_remote_retrieve_header($response, 'X-WP-Total');
            $total_pages = wp_remote_retrieve_header($response, 'X-WP-TotalPages');
            
            if (empty($events)) :?>
                <div class="container">
                    <div class="no-results">
                        <h2 class="search-title">
                            <span class="azul-claro-acervo"><strong>0</strong></span><strong> 
                                resultados</strong>
                        </h2>
                        <img src="https://educacao.sme.prefeitura.sp.gov.br/wp-content/themes/sme-portal-institucional/img/search-empty.png" alt="Imagem ilustrativa para nenhum resultado de busca encontrado" class="img-fluid">
                        <p>Nenhum evento encontrado para os filtros informados</p>
                    </div>
                </div>
            <?php else : 
                $has_posts = true;
            ?>

                <div class="container">
                    
                    <div class="row">
                        <div class="col-12 p-0">

                            <div class="title-ativi">
                                <?php
                                if($titulo)
                                    echo '<h2>' . $titulo . '</h2>';
                                ?>
                                <hr>
                                <?php
                                    if($link)
                                        echo '<a href="' . $link . '">Ver todos</a>';
                                ?>
                            </div>

                            <div class="sorteios">
                
                                <?php if($events): ?>
                                    <?php foreach ($events as $event) :?>
                                        <div style="width: <?= $calc . 'px'; ?>">
                                            
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
                                                        <?php if ( isset( $event['post_type'] ) && !empty( $event['post_type'] ) ) : ?>
                                                            <span class="post-type-tag position-absolute">
                                                                <?php echo esc_html( mb_strtoupper( $event['post_type'] ) ); ?>
                                                            </span>
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
                                                        <h3><a href="<?= get_home_url(); ?>/sorteio/<?= esc_html($event['id']); ?>">ENCERRADO - <?php echo esc_html($event['title']); ?></a></h3>
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
                                                                echo '<p class="text-center pp_like ' . $likes . '">' . $total_like1 . ' ' . $text_total . '</span><br><i class="fa fa-heart" aria-hidden="true"></i><span></p>';
                                                            echo '</div>';
                                                        ?>
                                                    </div>
                
                                                </div>
                                                
                                            </div>
                
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                
                            </div> <!-- sorteios -->
                        </div> <!-- col-12 -->
                    </div> <!-- row -->
                    
                </div> <!-- container -->

            <?php
            endif;

        }

        ?>




        <?php
        // Portais e Sistemas
        wp_register_script('slick',  STM_THEME_URL . 'classes/assets/js/slick.js', array ('jquery'), false, false);
        wp_enqueue_script('slick');

        ?>

        <script>
            var $s = jQuery.noConflict();
            $s(document).ready(function(){
                $s('.sorteios').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    prevArrow:'<span class="slick-arrow arrow-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>',
                    nextArrow:'<span class="slick-arrow arrow-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>',
                    responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                infinite: true,
                dots: true
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
                });
            });
        </script>

        <?php if($has_posts): ?>
            <style>
                .no-results{
                    display: none;
                }
            </style>	
        <?php endif;

    } // fim if filtro