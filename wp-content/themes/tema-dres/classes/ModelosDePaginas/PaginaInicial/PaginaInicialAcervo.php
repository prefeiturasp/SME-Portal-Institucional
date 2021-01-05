<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialAcervo
{

    public function __construct()
    {
        $this->montaHtmlAcervo();
    }

    public function montaHtmlAcervo()
    {
        
        $titulo = get_field('titulo_acervo','option');
        $conteudo = get_field('texto_acervo', 'option');
        ?>
        
        <container>

            <?php if($titulo): ?>
                <section class="container mt-3 mb-3 noticias">
                    <article class="row mb-4">
                        <article class="col-lg-12 col-xs-12">
                            <h2 class="border-bottom"><?php echo $titulo; ?></h2>
                        </article>
                    </article>
                </section>
            <?php endif; ?>

            <?php if($conteudo): ?>
                <section class="container mt-3 mb-5">
                    <article class="row mb-4">
                        <article style="padding-right: 40px;" class="col-sm-12">
                            <?php echo $conteudo; ?>
                        </article>                    
                    </article>
                </section>
            <?php endif; ?>
            
        </container>

        <?php
    }

}