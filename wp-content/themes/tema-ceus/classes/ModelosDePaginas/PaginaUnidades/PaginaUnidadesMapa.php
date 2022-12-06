<?php

namespace Classes\ModelosDePaginas\PaginaUnidades;


class PaginaUnidadesMapa
{
    public function __construct(){
		$this->getMapa();
	}

	public function getMapa(){
        
    ?>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 offset-md-8 select-unidades">
                    <?php
                        echo '<div class="form-group">
                        <select class="form-control" name="forma" onchange="location = this.value;">
                            <option disabled selected value> Ir para a página da unidade </option>';
                            
                                $argsUnidades = array(
                                    'post_type' => 'unidade',
                                    'posts_per_page' => -1,
                                    'orderby' => 'title',
                                    'order' => 'ASC',
                                    'post__not_in' => array(31244),
                                );

                                $todasUnidades = new \WP_Query( $argsUnidades );
        
                                // The Loop
                                if ( $todasUnidades->have_posts() ) {
                                    
                                    while ( $todasUnidades->have_posts() ) {
                                        $todasUnidades->the_post();
                                        echo '<option value="' . get_the_permalink() .'">' . get_the_title() .'</option>';
                                    }
                                
                                }
                                wp_reset_postdata();
                            
                            echo '</select>
                        </div>';
                    ?>
                
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <div class="row m-0">
                <div class="col-sm-4 p-0 p-list">

                    <div class="filtro-zonas-button open-close">
                        <button id="collpaseContent" class="openbtn closeContent" onclick="openUnidades()"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>
                    </div>
                
                    <div class="unidades-busca">
                        <div id="search-box"></div>
                        <button class="btn-unidade" data-toggle="modal" data-target="#locationModal"><i class="fa fa-crosshairs" aria-hidden="true"></i></button>
                        <div class="" id='unidades-mapa'></div>
                    </div>

                    <div class="filtro-zonas-button">
                        <button class="openbtn" onclick="openNav()">Filtrar por zona <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                    </div>

                    <div class="filtro-zonas">
                        <div id="mySidebar" class="sidebar">
                            
                            <div class="filtro-zonas-button voltar">
                                <button class="openbtn" onclick="closeNav()"><i class="fa fa-chevron-left" aria-hidden="true"></i> Voltar </button>
                            </div>

                            <form id="mainForm" name="mainForm">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="zona" id="todos" value="all" checked>
                                    <label class="form-check-label" for="todos">
                                        Todos
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="zona" id="central" value="central">
                                    <label class="form-check-label" for="central">
                                        Zona Central
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="zona" id="leste" value="leste">
                                    <label class="form-check-label" for="leste">
                                        Zona Leste
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="zona" id="norte" value="norte">
                                    <label class="form-check-label" for="norte">
                                        Zona Norte
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="zona" id="oeste" value="oeste">
                                    <label class="form-check-label" for="oeste">
                                        Zona Oeste
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="zona" id="sul" value="sul">
                                    <label class="form-check-label" for="sul">
                                        Zona Sul
                                    </label>
                                </div>
                            </form>

                        </div>
                    </div>
                    
                    <?php
                        $args = array(
                            'post_type' => 'unidade',
                            'post__not_in' => array(31244, 31675),
                            'order' => 'ASC',
                            'orderby' => 'title',
                            'posts_per_page' => -1
                        );
                        
                        // The Query
                        $the_query = new \WP_Query( $args );

                        
                        
                        // The Loop
                        if ( $the_query->have_posts() ) {
                            echo '<ul class="lista-unidades hidemapa">';
                            while ( $the_query->have_posts() ) {
                                $the_query->the_post();
                                $zona = get_group_field( 'informacoes_basicas', 'zona_sp', get_the_id() );
                                $latitude = get_group_field( 'informacoes_basicas', 'latitude', get_the_id() );
                                $longitude = get_group_field( 'informacoes_basicas', 'longitude', get_the_id() );
                                $endereco = get_group_field( 'informacoes_basicas', 'endereco', get_the_id() );
                                $numero = get_group_field( 'informacoes_basicas', 'numero', get_the_id() );
                                $bairro = get_group_field( 'informacoes_basicas', 'bairro', get_the_id() );
                                $cep = get_group_field( 'informacoes_basicas', 'cep', get_the_id() );
                                $emails = get_group_field( 'informacoes_basicas', 'email', get_the_id() );
                                $tels = get_group_field( 'informacoes_basicas', 'telefone', get_the_id() );
                                
                                echo '<li>
                                        <a href="#map" class="story" onclick="alerta(this)" data-point="' . $latitude . ',' . $longitude . '">
                                        <p class="unidades-title">' . get_the_title() . '</p>
                                        </a>
                                        <p>' . nomeZona($zona) . ' • ' . $endereco . ', '. $numero .' - ' . $bairro . ' - CEP: ' . $cep . '</p>
                                        <p>
                                            <a href="mailto:' . $emails['email_principal'] .'">' . $emails['email_principal'] .'</a><br>
                                            <div class="d-flex justify-content-between">
                                                <a href="tel:' . clearPhone($tels['telefone_principal']) . '">' . $tels['telefone_principal'] .'</a>
                                                <a href="' . get_the_permalink() . '">Ir para a página <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                            </div>
                                        </p>
                                      </li>';
                            }
                            echo '</ul>';
                        } else {
                            // no posts found
                        }
                        /* Restore original Post Data */
                        wp_reset_postdata();    
                    ?>                    
                </div>
                <div class="col-sm-8 p-0 p-map">

                    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true" data-backdrop="false"> 
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">                            
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p>Usar minha localização para encontrar os CEUs mais próximos.</p>
                                    <button type="button" class="btn btn-location" data-dismiss="modal" onclick="getLocation()"><i class="fa fa-globe" aria-hidden="true"></i> Usar minha localização</button>
                                </div>                            
                            </div>
                        </div>
                    </div>

                    <div id="map"></div>
                </div>
            </div>
        </div>
    <?php
    }
}