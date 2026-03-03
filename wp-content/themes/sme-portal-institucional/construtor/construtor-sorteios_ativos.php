<?php

    if(!isset($_GET['filtro'])){

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $qtd = get_sub_field('qtd');
        global $has_posts;

        if(!$qtd)
            $qtd = 10;

        $current_date = date('Ymd');

        $args = [    
            'per_page' => $qtd,
            'page' => $paged,
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
        if ($timestamp_inicio && $timestamp_inicio < $timestamp_atual) {
            $data_inicio = $current_date;
        }

        if ($timestamp_fim && $timestamp_fim < $timestamp_atual) {
            $data_fim = $current_date;
        }

        // Se NÃO houver filtro por data
        if (empty($data_inicio) && empty($data_fim)) {
            $args['meta_query'] = json_encode(array(
                [
                'key' => 'enc_inscri',
                'value' => $current_date,
                'compare' => '>=',
                'type' => 'DATE',
                ]
            ));
        }

        // Se houver APENAS dataInicio
        elseif (!empty($data_inicio) && empty($data_fim)) {
            $args['meta_query'] = json_encode(array(
                [
                'key' => 'enc_inscri',
                'value' => $data_inicio,
                'compare' => '>=',
                'type' => 'DATE',
                ]
            ));
        }

        // Se houver APENAS dataFim
        elseif (empty($data_inicio) && !empty($data_fim)) { 
            $args['meta_query'] = json_encode(
                [
                    array(
                        [
                            'key' => 'enc_inscri',
                            'value' => $current_date,
                            'compare' => '>=',
                            'type' => 'DATE',
                        ]
                    ),

                    array(
                        [
                            'key' => 'enc_inscri',
                            'value' => $data_fim,
                            'compare' => '<=',
                            'type' => 'DATE',
                        ]
                    )
                ]
            );
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
                            'compare' => '<=',
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
                            echo '<p>Não há eventos com inscrições abertas no momento.</p>';
                        echo '</div>';
                    echo '</div>';
                }else{
                    echo '<div class="container">';
                        echo '<div class="no-results">';
                            echo '<h2 class="search-title">';
                                echo '<span class="azul-claro-acervo"><strong>0</strong></span><strong> resultados</strong>';
                            echo '</h2>';
                            echo '<img src="https://educacao.sme.prefeitura.sp.gov.br/wp-content/themes/sme-portal-institucional/img/search-empty.png" alt="Imagem ilustrativa para nenhum resultado de busca encontrado" class="img-fluid">';
                            echo '<p>Nenhum evento encontrado para os filtros informados</p>';
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

                                <div class="item-sorteio">
                                    <div class="row m-0">

                                        <div class="col-4 p-0">
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

                                        <div class="col-8">                                       

                                            <div class="row">
                                                <div class="col-12 col-md-9">
                                                    <h3><a href="<?= get_home_url(); ?>/sorteio/<?= esc_html($event['id']); ?>"><?php echo esc_html($event['title']); ?></a></h3>
                                                </div>
                                                
                                                <div class="col-12 col-md-3">
                                                    <?php
                                                        $total_like1 = $event['likes'];
                                                        if($total_like1 == 1){
                                                            $text_total = 'like';
                                                        } else {
                                                            $text_total = 'likes';
                                                        }
                                        
                                                        echo '<div class="post_like">';
                                                            echo '<p class="text-center pp_like ' . $likes . '"><img src=' . get_template_directory_uri() . '/img/icone-likes.svg alt="like"><br>' . $total_like1 . ' ' . $text_total . '</p>';
                                                        echo '</div>';
                                                    ?>
                                                </div>
                                            </div>


                                            <p class="data">
                                                <?php
                                                    
                                                    if( isset( $event['subtitulo'] ) && !empty( $event['subtitulo'] ) ){
                                                        echo esc_html( $event['subtitulo'] );	
                                                    }
                                                ?>
                                            </p>

                                            <div class="infos-evento">
                                                <?php
                                                    if( isset( $event['local_nome'] ) && !empty( $event['local_nome'] ) ){
                                                        echo 'Local: ' . esc_html( $event['local_nome'] );	
                                                    }
                                                ?>
                                            </div>

                                            <?php if ( isset( $event['post_type'] ) && !empty( $event['post_type'] ) ) : 
                                                    if($event['post_type'] == 'cortesias'){
                                                        $class_tag = 'cortesia-tag';
                                                    }
                                            ?>
                                                <span class="post-type-tag <?= $class_tag ?? '' ?>">
                                                    <?php echo esc_html( mb_strtoupper( $event['post_type'] ) ); ?>
                                                </span>
                                            <?php endif; ?>

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

        if($has_posts): ?>
            <style>
                .no-results{
                    display: none;
                }
            </style>	
        <?php endif;

    } // fim if filtro