<?php
    $titulo = get_sub_field('titulo');
    $personagens = get_field('personagens','conf-turma');
    //echo "<pre>";
    //print_r($personagens);
    //echo "</pre>";
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="turma-naapa">
                <div class="title-special d-flex align-items-center justify-content-between">
                    <h2 style="border-color: #FFC701;"><?php echo $titulo ? $titulo : "A turma do NAAPA"; ?></h2>
                </div>

                <div class="tab">

                    <ul class="tabs row">
                        <?php foreach($personagens as $personagen): ?>
                            <li class="col">
                                <a href="#"><img src="<?php echo wp_get_attachment_url( $personagen['imagem_do_personagem'] ); ?>" class="img-fluid"></a>
                            </li>
                        <?php endforeach; ?>                        
                    </ul>
                    <!-- / tabs -->

                    <div class="tab_content">
                        
                        <?php foreach($personagens as $personagen): ?>
                            <div class="tabs_item">
                                <div class="row">
                                    <div class="col-md-7">
                                    <img src="<?php echo wp_get_attachment_url( $personagen['imagem_do_texto'] ); ?>" class="img-fluid">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <div class="turma-text">
                                            <div class="turma-title"><?php echo $personagen['nome_do_personagem']; ?></div>
                                            <div class="turma-descri">
                                                <?php echo $personagen['descritivo_do_personagem']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / tabs_item -->
                        <?php endforeach; ?>

                    </div>
                    <!-- / tab_content -->
                </div>
                <!-- / tab -->
            </div>
        </div>
    </div>
</div>