<?php
$eventoDestaques= get_sub_field('evento_em_destaque');
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div id="bannerhome" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover">
                <ul class="carousel-indicators carousel-indicators-banner">
                    <?php
                    $countSliderIndicator = 0;
                    foreach ($eventoDestaques as $eventoDestaque){
                        ?>
                        <li data-target="#bannerhome" data-slide-to="<?php echo $countSliderIndicator; ?>" class="<?php if($countSliderIndicator === 0){echo 'active';} ?>"></li>
                        <?php
                        $countSliderIndicator++;
                    }
                    ?>
                </ul>
                <div class="carousel-inner">
                    <?php
                    $countSlider = 0;
                    foreach ($eventoDestaques as $eventoDestaque){
                        $eventID = $eventoDestaque->ID;
                        $img = get_field('foto_do_evento', $eventID);
                        ?>
                        <div class="carousel-item bannerhome-item <?php if($countSlider === 0){echo 'active';} ?>">
                            <img class="bannerhome-img" src="<?php echo $img['url'] ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                            <div class="bannerhome-content">
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <div class="infoline-ajust">
                                            <span class="info-date-banner">
                                            <?php
                                            if( have_rows('agenda', $eventID) ):
                                                $countData = 0;
                                                while( have_rows('agenda', $eventID) ) : the_row();
                                                    $date_variable = get_sub_field('data_hora');
                                                    $date_format_in = 'd/m/Y g:i a';
                                                    $date_format_out = 'd';
                                                    $date = DateTime::createFromFormat( $date_format_in, $date_variable );
                                                    ?>
                                                    <?php echo $date->format( $date_format_out ); ?>
                                                    <?php
                                                    if($countData === 0){
                                                        echo ' a ';
                                                    }
                                                    ?>
                                                    <?php
                                                    $countData++;
                                                endwhile;
                                            else :
                                            endif;
                                            ?> de Junho
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="bannerhome-title"><?php echo $eventoDestaque->post_title; ?></div>
                                    </div>
                                    <div class="col-sm-3 text-right">
                                        <button type="button" class="btn visitas-btn">Fazer inscrição</button>
                                    </div>
                                </div>
                                <div class="row bannerhome-infoline">
                                    <div class="col-sm-12">
                                        <div class="infoline-ajust">
                                            <span class="info-local-banner">Shopping Iguatemi, Jardim Paulistano</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                <div class="col-sm-12">
                                    <span class="pill pill-verde">
                                        <img src="/wp-content/uploads/2022/07/livre.png" alt="<?php echo $eventoDestaque->post_title; ?>">
                                        <?php
                                        $faixas = get_field('faixa_etaria', $eventID);
                                        echo $faixas->name;
                                        ?>
                                    </span>
                                    <span class="pill pill-azul">
                                        <img src="/wp-content/uploads/2022/07/cinemas.png" alt="<?php echo $eventoDestaque->post_title; ?>">
                                        Cinemas
                                    </span>
                                    <span class="pill pill-cinza">
                                        <img src="/wp-content/uploads/2022/07/parceiros.png" alt="<?php echo $eventoDestaque->post_title; ?>">
                                        Parceiro
                                    </span>
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $countSlider++;
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#bannerhome" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#bannerhome" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        </div>
    </div>
</div>

