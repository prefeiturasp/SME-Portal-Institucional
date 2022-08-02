<div class="filtro-busca">
    <div class="filter-sidebar">
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col-12 text-left"><span class="btn-filtros-close"><img src="https://visitas.rafaelhsouza.com.br/img/fechar.png" alt="Fechar"> Fechar</span></div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col-12 mt-3 mb-2"><h3 class="title-top-filter">Filtro Avançado</h3></div>
                <div class="col-12 mt-3 mb-2">
                    <h4 class="title-ad-filter">Tipos de transporte</h4>
                    <select class="form-control" id="tipodetransporte" multiple="multiple">
                        <?php
                        $tipo_transportes = get_terms( array(
                            'taxonomy' => 'tipo-transporte',
                            'hide_empty' => false,
                        ) );
                        foreach ($tipo_transportes as $tipo_transporte){
                            if($tipo_transporte->slug != 'proprio-ue'){
                                ?>
                                <option value="<?php echo $tipo_transporte->slug; ?>"><?php echo $tipo_transporte->name; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 mt-3 mb-2">
                    <h4 class="title-ad-filter">Gênero</h4>
                    <select class="form-control" id="tipogenero"  multiple="multiple">
                        <?php
                        $generos = get_terms( array(
                            'taxonomy' => 'genero',
                            'hide_empty' => false,
                        ) );
                        foreach ($generos as $genero){
                            ?>
                            <option value="<?php echo $genero->slug; ?>"><?php echo $genero->name; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 mt-3 mb-2">
                    <h4 class="title-ad-filter">Acessibilidade</h4>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="eventosacessiveis" name="customCheck" class="custom-control-input">
                        <label class="custom-control-label" for="eventosacessiveis">Eventos acessíveis</label>
                    </div>
                </div>
                <div class="col-12 mt-4 mb-2">
                    <button type="button" class="btn-limpar-filtros">Limpar filtros</button>
                    <button type="button" class="btn-aplicar-filtros">Aplicar filtros</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm-10">
                <div class="row mb-2">
                    <div class="col-sm-3 pr-2 pl-2">
                        <div class="form-group icon-group">
                            <span class="icon-control icon-control-busca"></span>
                            <input type="text" class="form-control icon-control-inpt" placeholder="Busque um evento">
                        </div>
                    </div>
                    <div class="col-sm-3 pr-2 pl-2">
                        <div class="form-group icon-group">
                            <span class="icon-control icon-control-parceiro"></span>
                            <input type="text" id="TipoParceiros" class="form-control icon-control-inpt" placeholder="Busque por parceiro">
                        </div>
                    </div>
                    <div class="col-sm-3 pr-2 pl-2">
                        <div class="form-group icon-group" >
                            <span class="icon-control icon-control-calendario"></span>
                            <input type="text" id="inputDate" class="form-control icon-control-inpt" placeholder="Quando?">
                        </div>
                    </div>
                    <div class="col-sm-3 pr-2 pl-2">
                        <div class="form-group icon-group">
                            <span class="icon-control icon-control-classificacao"></span>
                            <select class="form-control icon-control-inpt" id="exampleFormControlSelect1">
                                <option selected disabled>Classificação</option>
                                <?php
                                $faixaetarias = get_terms( array(
                                    'taxonomy' => 'faixa-etaria',
                                    'hide_empty' => false,
                                ) );
                                foreach ($faixaetarias as $faixa_etaria){
                                    ?>
                                    <option value="<?php echo $faixa_etaria->slug; ?>"><?php echo $faixa_etaria->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pr-2 pl-2">
                        <span class="pill-all">Todos</span>
                        <?php
                        $tipo_espacos = get_categories('taxonomy=tipo-espaco&type=evento');
                        foreach ($tipo_espacos as $tipo_espaco){
                            $termoidimage = $tipo_espaco->taxonomy . '_' . $tipo_espaco->term_id;
                            $imageTax = get_field('icone_tax', $termoidimage);
                            ?>
                            <span class="pill-one pill-icon" data-local="<?php echo $tipo_espaco->slug; ?>"><img src="<?php echo $imageTax; ?>" alt="<?php echo $tipo_espaco->slug; ?>"><?php echo $tipo_espaco->name; ?></span>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="row">
                    <div class="col-sm-12 mb-2 text-right pr-0 pl-0">
                        <button type="button" class="btn-buscar">Buscar eventos</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-right pr-0 pl-0">
                        <span class="btn-filtros"><img src="https://visitas.rafaelhsouza.com.br/img/filtro.png" alt="Filtros">Filtros</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>