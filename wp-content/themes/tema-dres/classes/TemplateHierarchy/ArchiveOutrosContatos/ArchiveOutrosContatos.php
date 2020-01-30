<?php
namespace Classes\TemplateHierarchy\ArchiveOutrosContatos;

class ArchiveOutrosContatos{
    public function __construct(){
        $this->montaHtmlOutrosContatos();
    }
    public function montaHtmlOutrosContatos(){
        ?>
        <section class="container mt-5 mb-5">
            <article class="row mb-4">
                <article style="padding-right: 40px;" class="col-sm-12">

                    <?php
                    query_posts( array(
                        'post_type'  => 'outroscontatos',
                        'orderby' => 'post__in',
                        'order' =>'DESC'
                    ));
                    ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-sm-12 mb-4 border-bottom">
                            <span class="row mb-2"><strong><?php the_title(); ?></strong></span>
                            <?php if( get_field('contato_diretor') !== '' && get_field('contato_diretor') !== null){ ?>
                                <span class="row "><strong>Diretor(a):&nbsp;</strong><?php the_field('contato_diretor'); ?></span>
                            <?php } ?>
                            <?php if( get_field('contato_responsavel') !== '' && get_field('contato_responsavel') !== null){ ?>
                                <span class="row "><strong>Responsável:&nbsp;</strong><?php the_field('contato_responsavel'); ?></span>
                            <?php } ?>
                            <?php if( get_field('contato_logradouro') !== '' && get_field('contato_logradouro') !== null){ ?>
                                <span class="row "><strong>Endereço:&nbsp;</strong><?php the_field('contato_logradouro'); ?>,<?php the_field('contato_numero'); ?> - <?php the_field('contato_bairro'); ?> - CEP: <?php the_field('contato_cep'); ?></span>
                            <?php } ?>
                            <?php if( get_field('contato_telefone_1') !== '' && get_field('contato_telefone_1') !== null){ ?>
                                <span class="row "><strong>Telefone:&nbsp;</strong><?php the_field('contato_telefone_1'); ?></span>
                            <?php } ?>
                            <?php if( get_field('contato_telefone_2') !== '' && get_field('contato_telefone_2') !== null){ ?>
                                <span class="row "><strong>Telefone:&nbsp;</strong><?php the_field('contato_telefone_2'); ?></span>
                            <?php } ?>
                            <?php if( get_field('contato_email') !== '' && get_field('contato_email') !== null){ ?>
                                <span class="row mb-4"><strong>E-mail:&nbsp;</strong> <a href="mailto:<?php the_field('contato_email'); ?>"><?php the_field('contato_email'); ?></a></span>
                            <?php } ?>
                        </div>
                    <?php endwhile;?>
                </article>
            </article>
        </section>
        <?php
    }
}
?>