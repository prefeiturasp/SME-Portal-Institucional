<?php

if(get_sub_field('fx_acessos_1_1')) :
									

    echo '<session class="container-fluid container-fluid-botoes-persona">';

        echo '<div class="container">';

            echo '<div class="row">';

                echo '<div class="col-sm-12">';

                    echo '<ul class="card-group nav m-0 acesso-rapido" role="tablist">';

                        $acessosRapido = get_sub_field('fx_acessos_1_1');
                        $i = 1;

                        foreach($acessosRapido as $acessos):
                            $cor = $acessos['cor_principal'];
                        ?>
                            <li id="tab_<?php echo $acessos['menu']; ?>" class="container-a-icones-home card rounded-0 border-0">

                                <a id="tab_<?php echo $acessos['menu']; ?>" data-toggle="tab" href="#menu_<?php echo $acessos['menu']; ?>" role="tab" aria-selected="false" class="a-icones-home ">

                                    <div class="row m-0 w-100">

                                        <?php if($acessos['icone']['sizes']['thumbnail']) : ?>

                                            <div class="col-sm-4 pl-0">
                                                <div class="icon-card">
                                                    <img src="<?php echo $acessos['icone']['sizes']['thumbnail']; ?>" class="img-fluid" alt="<?php echo $acessos['icone']['alt']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="card-body text-center px-0">
                                                    <p class="card-text"><?php echo $acessos['titulo']; ?></p>
                                                </div>
                                            </div>

                                        <?php else: ?>

                                            <div class="col-sm-12">                                                
                                                <?php if($cor): ?>
                                                    <div class="card-body text-center px-0">
                                                        <p class="card-text" style="color: <?php echo $cor; ?>;"><?php echo $acessos['titulo']; ?></p>
                                                    </div>
                                                    <hr style="border-color: <?php echo $cor; ?>;">
                                                <?php else: ?>
                                                    <div class="card-body text-center px-0">
                                                        <p class="card-text"><?php echo $acessos['titulo']; ?></p>
                                                    </div>
                                                    <hr>
                                                <?php endif; ?>
                                            </div>

                                        <?php endif; ?>

                                    </div>

                                    
                                </a>
                                
                                <div class="acesso-mobile ">
                                    <?php
                                        wp_nav_menu(array(
                                            'menu' => $acessos['menu'],
                                            'depth' => 2,
                                            'menu_class' => 'navbar-nav m-auto nav nav-tabs menu-color-' . $i,
                                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                            'walker'            => new \WP_Bootstrap_Navwalker(),
                                        ));
                                    ?>
                                </div>

                            </li>
                        <?php
                            $i++;
                        endforeach;

                        
                                        
                    echo '</ul>';
                echo '</div>';                  

            echo '</div>';
        echo '</div>';
    echo '</session>';
    
    
    echo '<section class="tab-content container acesso-rapido-menu">';
        $i = 1;                    
        foreach($acessosRapido as $acessos):
            $cor = $acessos['cor_principal'];
            echo '<section class="tab-pane fade container p-0 my-3" id="menu_' . $acessos['menu'] . '" role="tabpanel" aria-labelledby="' . $acessos['menu'] . '">';

                echo '<nav class="navbar navbar-expand-lg nav-icones-menu">';


                    echo '<article class="collapse navbar-collapse">';
                    
                        wp_nav_menu(array(
                            'menu' => $acessos['menu'],
                            'depth' => 2,
                            'menu_class' => 'navbar-nav m-auto nav nav-tabs menu-color-' . $i,
                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'            => new \WP_Bootstrap_Navwalker(),
                        ));
                        
                    echo '</article>';

                echo '</nav>';																						

            echo '</section>';

            echo '<style>';
                    echo '
                        .fx_all .acesso-rapido-menu .menu-color-' . $i .' .menu-item a, 
                        .fx_all .acesso-rapido-menu menu-color-' . $i .' .menu-item a.active,
                        .acesso-mobile .menu-color-' . $i .' .menu-item a, 
                        .acesso-mobile menu-color-' . $i .' .menu-item a.active{
                            border-color: ' . $cor . ';
                        }

                        .acesso-mobile .menu-color-' . $i .' .menu-item a, 
                        .acesso-mobile menu-color-' . $i .' .menu-item a.active{
                            border: 2px solid ' . $cor . ';
                            color: #323232;
                            background: #FFFFFF;
                            padding: 5px;
                        }
                    ';

                    echo '.fx_all .acesso-rapido-menu .menu-color-' . $i .' .menu-item .menu-item a, .fx_all .acesso-rapido-menu menu-color-' . $i .' .menu-item .menu-item a.active{
                        border-color: #FFFFFF;
                        box-shadow: initial;
                    }';

                    echo '.acesso-mobile .menu-color-' . $i .' .menu-item .dropdown-menu{
                        border: 2px solid ' . $cor . ';
                        padding: 5px;
                        border-radius: 8px;
                    }';

                    echo '.fx_all .acesso-rapido-menu .menu-color-' . $i .' .menu-item .dropdown-menu{
                        border: 2px solid ' . $cor . ';
                        padding: 5px;
                        border-radius: 8px;
                        top: 45px !important;
                    }';

                    echo '.fx_all .acesso-rapido-menu .menu-color-' . $i .' .menu-item .dropdown-menu .menu-item a{
                        border-bottom: 1px solid ' . $cor . ';
                        border-radius: 0;
                    }';

                    echo '.acesso-mobile .menu-color-' . $i .' .menu-item .dropdown-menu .menu-item a{
                        border: 0;
                        border-bottom: 2px solid ' . $cor . ';
                        border-radius: 0;
                        box-shadow: initial;
                    }';

                    echo '.fx_all .acesso-rapido-menu .menu-color-' . $i .' .menu-item .dropdown-menu .menu-item:last-child a {
                        border: none;
                    }';

                    echo '.acesso-mobile .menu-color-' . $i .' .menu-item .dropdown-menu .menu-item:last-child a {
                        border: none;
                    }';

                    
            echo '</style>';

            $i++;
        endforeach;
    echo '</section>';
    

endif; // end fx_acessos_1_1