<br>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="row container-taxonomias">
        <div class='col-12'>
            <h2 class="titulo-taxonomias"><i class="fa fa-th-large"></i>
				<?php the_title(); ?>
            </h2>
			<?php the_content(); ?>
        </div>
    </div>

	<?php
	$attachments = get_posts( array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_parent' => $post->ID,
		'orderby'	=> 'ID',
		'order'	=> 'ASC',
		'exclude'     => get_post_thumbnail_id()
	) );



	echo '<pre>';
	//var_dump($attachments);
	echo '</pre>';

	if ( $attachments ) {
		echo '<h2>Arquivos Anexos</h2>';

		foreach ( $attachments as $attachment ) {

			$attachment_ollyver = get_post($attachment->ID);

			if ($attachment_ollyver->post_type === 'attachment') {

				echo '<pre>';
				//var_dump($attachment_ollyver);
				echo '</pre>';
			}

			echo '<pre>';
			echo '<a target="_blank" style="font-size:26px" href="'.$attachment->guid.'"><i class="fa fa-file-text-o fa-3x" aria-hidden="true"></i> '. $attachment->post_title.'</a>';
			echo '</pre>';

			/*                $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
							$thumbimg = wp_get_attachment_link( $attachment->ID, 'thumbnail-size', true );
							echo '<li class="' . $class . ' data-design-thumbnail">' . $thumbimg . '</li>';*/
		}

	}

	?>

	<?php comments_template() ?>
<?php



endwhile;
else: ?>
    <p>
		<?php _e('Não existem posts cadastrados.', 'site-profissional'); ?>
    </p>
<?php endif; ?>



<br/>
<div class="row container-taxonomias padding-bottom-15">
    <div class="col-12 text-right">
        <a class="btn btn-success" href="javascript:history.back();"><< Voltar</a>
    </div>
</div>
