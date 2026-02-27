<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialEscolares
{

    public function __construct()
    {
        $this->montaHtmlEscolares();
    }

    public function montaHtmlEscolares()
    {
        ?>
        <script>
            jQuery(document).ready(function ($) {
                //////////////Conta a Qt de Ceus e imprime//////////////////////
                var el = document.getElementById('cont-ceus');
                lines = el.innerHTML.replace(/ |^\s+|\s+$/g, '').split('\n'),
                    lineCount = lines.length;
                document.getElementById('cont_ceus').innerHTML = lineCount;
                //alert(lineCount);
                //////////////Conta a Qt de Ceus e imprime//////////////////////
            });
        </script>
        <container>
            <section class="container mt-5 mb-5 noticias">
                <article class="row mb-4">
                    <article class="col-lg-12 col-xs-12">
                        <h2 class="border-bottom">Unidades Escolares e CEUs</h2>
                    </article>
                </article>
            </section>
            <section class="container mt-5 mb-5">
                <article class="row mb-4">
                    <article style="padding-right: 40px;" class="col-sm-8">
                        <?php the_field('texto_ceus', 'option'); ?>
                        <p><a href="<?php the_field('link_escola_aberta', 'option'); ?>"><strong>Ir para Escola Aberta - link externo</strong></a></p>
                    </article>
                    <article class="col-sm-4 ceus-home">
                        <p>A Diretoria Regional de Educação possui <span id="cont_ceus"></span> Centros
                            Educacionais Unificados (CEU):</p>
                        <div id="cont-ceus">
                            <?php
                            if (have_rows('nome_do_ceu', 'option')): ?>
                                <?php while (have_rows('nome_do_ceu', 'option')): the_row(); ?>
                                    <strong><?php the_sub_field('cadastro_do_ceu'); ?></strong><br>
                                <?php endwhile; ?>
                            <?php endif;
                            ?>
                        </div>
                        <p><a href="<?php the_field('link_ceu', 'option'); ?>"><strong>Ir para a página dos CEUs - link externo</strong></a></p>
                    </article>
                </article>
            </section>
        </container>

        <?php
    }

}