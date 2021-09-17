<?php
/**
 * @package WordPress
 * @subpackage Theme_Compat
 * @deprecated 3.0.0
 *
 * This file is here for backward compatibility with old themes and will be removed in a future version
 *
 */
_deprecated_file(
/* translators: %s: template name */
	sprintf(__('Theme without %s'), basename(__FILE__)),
	'3.0.0',
	null,
	/* translators: %s: template name */
	sprintf(__('Please include a %s template in your theme.'), basename(__FILE__))
);

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if (post_password_required()) { ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?></p>
	<?php
	return;
}
?>

<div class="d-flex align-items-center justify-content-between">
	<h3>COMENTÁRIOS</h3>
	<?php if (have_comments()) : ?>
		<p>(
			<?php
			if (1 == get_comments_number()) {								
				echo '1 comentário';
			} else {
				echo get_comments_number() . ' comentários';
			}
			?>
		)</p>
	<?php endif; ?>
</div>


	<?php
	// Customizando os campos do comment_form()
	$comment_args = array('title_reply' => '',
		'fields' => apply_filters('comment_form_default_fields', array(
				'author' => '<div class="row"><div class="form-group col"><label for="author">' . __('Name'). '*' . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
					'<input placeholder="Digite seu nome e  sobrenome" class="form-control" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . $html_req . ' />' . 
					'<div class="invalid-tooltip">Nome e Sobrenome são inválidos.</div></div>',
				'url' => '<div class="form-group col"><label for="url">' . __('Apelido (Opcional)') . '</label> ' .
					'<input placeholder="Digite seu apelido" class="form-control" id="url" name="url" ' . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '" /></div></div>',
				
			)
		),
		'comment_field' => '<div class="form-group" style="position-relative"><label for="comment">' . _x('Comment', 'noun') . '*</label> <textarea placeholder="Adicione seu comentário para esse conteúdo" class="form-control" rows="3" id="comment" name="comment" maxlength="500" aria-required="true" required="required"></textarea>' .
		'<div class="invalid-tooltip">No mínimo 10 e no máximo 500 caracteres.</div></div>',
					wp_nonce_field( 'user_check', 'hdn_hash' ),
		'class_submit' => 'btn btn-primary btn-comment',
		'label_submit' => 'Enviar'
	);

	comment_form($comment_args);
	?>


<!-- You can start editing here. -->
<?php if (have_comments()) : ?>
	
	
	<div class="comments-list mt-5 mb-4">
		<?php
		wp_list_comments( array(
			'style'      => '',
			'short_ping' => true,
				'callback' => 'better_commets'
		) );
		?>
	</div>

	<div id="load_more" class='mb-5'>        
		Ver mais comentários
    </div>


<?php endif;