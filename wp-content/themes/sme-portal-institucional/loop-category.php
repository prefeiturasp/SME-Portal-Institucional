<?php
if (have_posts()) :
	$conta_posts = 0;
	?>
    <section class="row container-post-categorias">
	<?php
	while (have_posts()) : the_post();

		if ($conta_posts == 3) {
			?>
            </section>
            <section class="row container-post-categorias">
			<?php
			$conta_posts = 0;
		}
		?>

		<?php
		switch ($conta_posts) {
			case 0:
				$classe_animacao = 'wow fadeInLeftBig';
				$delay_animacao = 'data-wow-delay="0.1s"';
				break;

			case 1:
				$classe_animacao = 'wow zoomIn';
				$delay_animacao = 'data-wow-delay="0.8s"';
				break;

			case 2:
				$classe_animacao = 'wow fadeInRightBig';
				$delay_animacao = 'data-wow-delay="0.9s"';
				break;

			default:
				$classe_animacao = 'wow fadeIn';
				$delay_animacao = 'data-wow-delay="0.5s"';
				break;
		}
		?>

        <article class='col-12 col-md-12 col-lg-4 col-xl-4 post-categorias <?php echo $classe_animacao; ?>' <?php echo $delay_animacao; ?>>
			<?php if (has_post_thumbnail()) { ?>
                <figure>
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large', array('class' => 'img-fluid aligncenter img-thumbnail')); ?></a>
                </figure>
			<?php } ?>
            <h3 class="titulo-post-categorias"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a>

        </article>
		<?php
		$conta_posts++;

// colocando uma animação diferente para cada post


	endwhile;
	?>
    </section>

<?php else:
	?>
    <p>
		<?php _e('Não existem posts cadastrados.', 'sme-portal-institucional'); ?>
    </p>
<?php endif; ?>
<br/>
<?php //wp_pagenavi();    ?>
<section class="row padding-bottom-15">
    <article class="col-12 text-right">
        <a class="btn btn-danger" href="javascript:history.back();"><?php echo VOLTAR ?></a>
    </article>
</section>
