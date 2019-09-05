<?php

namespace Classes\MaisNoticias;


class MaisNoticias
{
	private $argsMaisNoticias;
	private $queryMaisNoticias;

	public function __construct()
	{
        $this->init();
	}

	public function init(){
        $this->queryMaisNoticias();
        $this->htmlMaisNoticias();
	}

	public function queryMaisNoticias(){
		$this->argsMaisNoticias = array(
			'post_type' => 'post',
			'post_per_page' => 100,
		);

		$this->queryMaisNoticias = new \WP_Query($this->argsMaisNoticias);
	}

	public function htmlMaisNoticias(){

            if ($this->queryMaisNoticias->have_posts()) :

				echo '<section class="container">';

				echo '<h1 class="mb-5" id="mais-noticias">Mais Notícias</h1>';
                    echo '<section class="row container-post-categorias">';



                    while ($this->queryMaisNoticias->have_posts()): $this->queryMaisNoticias->the_post();

                        $post_thumbnail_id = get_post_thumbnail_id(  );
                        $image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);
                        ?>
                        <article class='col-12 col-md-4'>
                            <?php if (has_post_thumbnail()) { ?>
                                <figure>
                                    <img alt="<?= $image_alt ?>" class="img-fluid aligncenter img-thumbnail" src="<?= get_the_post_thumbnail_url() ?>"/>
                                </figure>
                            <?php } ?>
                            <h2 class="titulo-post-categorias"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <?php the_excerpt(); ?>

                        </article>
                    <?php

                    endwhile;

                    echo '</section>';
				echo '</section>';

            endif;
	}
}