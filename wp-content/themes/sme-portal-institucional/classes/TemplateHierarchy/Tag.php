<?php

namespace Classes\TemplateHierarchy;
use Classes\Lib\Util;

class PaginaTag
{
	public function __construct()
	{
		$this->page_id = $page_id;
		//$this->montaHtmlPaginaTag();
		$this->montaHtmlTAG();

	}
	
	public function montaHtmlTAG(){
		?>
		<div class="container mt-4 mb-4">
			<section class="row container-post-categorias">
			<?php
			while (have_posts()) : the_post();

				$post_thumbnail_id = get_post_thumbnail_id( $post_id );
				$image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);
				?>
				<article class='col-12 col-md-4 mt-4 mb-4'>
					<?php if (has_post_thumbnail()) { ?>
						<figure>
							<img alt="<?= $image_alt ?>" class="img-fluid aligncenter img-thumbnail" src="<?= get_the_post_thumbnail_url() ?>"/>
						</figure>
					<?php } ?>
					<h3 class="titulo-post-categorias"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<?php the_excerpt(); ?>

				</article>
				<?php
				$conta_posts++;
			endwhile;
			?>
			</section>
		</div>
		<?php
	}
	
	public function montaHtmlPaginaTag(){

		echo '<section class="container">';
		if (have_posts()) : while (have_posts()) : the_post();
			?>
			<article class="row">
				<article class="col-lg-12 col-xs-12">
					<h1 class="mb-4" id="<?= $this->page_slug ?>"><?php the_title(); ?></h1>
				</article>
			</article>


			<article class="row">
				<article class="col-lg-9 col-xs-12">

					<?php the_content(); ?>
				</article>
			</article>
		<?php
		endwhile;
		endif;
		wp_reset_query();
		echo '</section>'; //container
	}
	
}

?>