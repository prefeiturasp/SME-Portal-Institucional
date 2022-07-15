<?php
$titleNews = get_sub_field('titulo');
$descNews = get_sub_field('descricao');
$txtBtnNews = get_sub_field('texto_botao');
$imgNews = get_sub_field('imagem');
?>
<div class="container blc-news p-5">
    <div class="row">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <h2 class="title-news"><?php echo $titleNews; ?></h2>
                        <p class="desc-news"><?php echo $descNews; ?></p>
                        <div class="form-news">
                            <div><input type="text" placeholder="Nome"></div>
                            <div><input type="text" placeholder="Seu melhor e-mail"></div>
                            <button class="btn"><?php echo $txtBtnNews; ?></button>
                        </div>
                    </div>
                    <div class="col-sm-5"><img src="<?php echo $imgNews; ?>" alt="<?php echo $titleNews; ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>