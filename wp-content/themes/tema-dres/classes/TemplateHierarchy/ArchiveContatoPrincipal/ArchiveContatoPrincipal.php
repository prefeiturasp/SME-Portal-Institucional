<?php
namespace Classes\TemplateHierarchy\ArchiveContatoPrincipal;

class ArchiveContatoPrincipal{
    public function __construct(){
        $this->montaHtmlContatoPrincipal();
    }
    public function montaHtmlContatoPrincipal(){
        ?>
        <div class="container">
            <div class="row">
                <div class="col pp_titulo"><h1>Programas e Projetos</h1></div>
            </div>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php
                $counter++;
                if ($counter === 1) {//verifica se é a 1º coluna
                    echo '<div class="row">';//Inicia a row
                }
                ?>
                <div class="col-sm-6 col-lg-3">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('programa-projeto', array('class' => 'img-fluid alignleft pp_thumbnail'));
                    }?>
                    <a href="<?php the_permalink(); ?>">
                        <h3><?php the_title(); ?></h3>
                    </a>
                    <p class="pp_resumo d-none d-sm-block"><?php the_excerpt(); ?></p>
                </div>
                <?php
                if ($counter === 4) { //atigiu 4 colunas
                    $counter = 0; //reseta contador
                    echo '</div>'; //fecha row
                }
                ?>
            <?php endwhile; else: ?>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <p><?php _e('Não existem Programas e Projetos cadastrados.', 'sme-portal-institucional'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
?>