</section>
<!--main-->

<footer style="background: #363636; color: #fff;">
	<div class="container pt-3 pb-3" id="irrodape">
		<div class="row">
			<div class="col-sm-3 align-middle d-flex align-items-center logo-rodape">
			<a href="https://www.capital.sp.gov.br/"><img src="<?php the_field('logo_prefeitura','conf-rodape'); ?>" alt="<?php bloginfo('name'); ?>"></a>
			</div>
			<div class="col-sm-3 align-middle bd-contact">
				<p class='footer-title'><?php the_field('nome_da_secretaria','conf-rodape'); ?></p>
				<?php the_field('endereco_da_secretaria','conf-rodape'); ?>
			</div>
			<div class="col-sm-3 align-middle">
				<p class='footer-title'>Contatos</p>
				<p><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:<?php the_field('telefone','conf-rodape'); ?>"><?php the_field('telefone','conf-rodape'); ?></a></p>
				<?php if(get_field('email','conf-rodape')) :?>
				<p><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:<?php the_field('email','conf-rodape'); ?>"><?php the_field('email','conf-rodape'); ?></a></p>
				<?php endif; ?>
				<?php if(get_field('texto_link','conf-rodape') && get_field('link_adicional','conf-rodape')) :?>
				<p><i class="fa fa-comment" aria-hidden="true"></i> <a href="<?php the_field('link_adicional','conf-rodape'); ?>"><?php the_field('texto_link','conf-rodape'); ?></a></p>
				<?php endif; ?>
				
			</div>
			<div class="col-sm-3 align-middle">				
				<p class='footer-title'>Redes sociais</p>				
				<?php 
					// Verifica se existe Redes Sociais
					if( have_rows('redes_sociais', 'conf-rodape') ):
						
						echo '<div class="row redes-footer">';						
						
							while( have_rows('redes_sociais', 'conf-rodape') ) : the_row();
								
								$rede_url = get_sub_field('url_rede'); 
								$rede_texto = get_sub_field('texto_alternativo');								
								$rede_rodape = get_sub_field('tipo_de_icone_rodape');
								$rede_r_imagem = get_sub_field('imagem_rodape');
								$rede_r_icone = get_sub_field('icone_rodape');								
								
							?>
								<div class="col rede-rodape">
									<a href="<?php echo $rede_url; ?>">
										<?php if($rede_rodape == 'imagem' && $rede_r_imagem != '') : ?>
											<img src="<?php echo $rede_r_imagem; ?>" alt="<?php echo $rede_texto; ?>">
										<?php elseif($rede_rodape == 'icone' && $rede_r_icone != ''): ?>
											<i class="fa <?php echo $rede_r_icone; ?>" aria-hidden="true" title="<?php echo $rede_texto; ?>"></i>
										<?php endif; ?>
									</a>
								</div>
							<?php
								

							// End loop.
							endwhile;

						echo '</div>';
					
					endif;
				?>
			</div>
		</div>
	</div>
</footer>
<div class="subfooter rodape-api-col">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<p>Prefeitura Municipal de São Paulo - Viaduto do Chá, 15 - Centro - CEP: 01002-020</p>
			</div>
		</div>
	</div>
</div>

<div class="voltar-topo">
	<a href="#" id="toTop" style="display: none;">
		<i class="fa fa-arrow-up" aria-hidden="true"></i>
		<p>Voltar ao topo</p>
		<img src="https://via.placeholder.com/40x80" alt="" srcset="">
	</a>
</div>
<?php
	$user = get_current_user_id();
	if($_GET['feedback'] && $user){
		update_user_meta( $user, 'feed_resp', 1 );
	}
	$modal = get_field('ativar_modal');
	$exibi = get_field('tempo_de_exibicao');
	
	$count = get_user_meta( $user, 'wp_login_count', true );
	$feed =  get_user_meta( $user, 'feed_resp', true );
	$img = get_field('imagem_modal');
	$titulo = get_field('titulo_modal');
	$mensagem = get_field('mensagem_modal');
	$botao_url = get_field('botao_modal');
	$botao_nome = get_field('nome_botao_modal');
	print_r($feed);
?>
<?php if(!$feed): ?>
	<?php if( ($modal && $exibi == 'all') || ($modal && $exibi != 'all' && $count >= $exibi) ): ?>	
		<!-- Bootstrap Modal -->
		<div class="modal fade" id="popup" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content -->
				<div class="modal-content">
					<!-- Modal header -->  
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>&nbsp;</h4>
					</div>

					<!-- Modal body -->  
					<div class="modal-body">

						<?php if($img): ?>
							<img src="<?= $img['url']; ?>" alt="<?= $img['alt']; ?>">
						<?php endif; ?>

						<?php if($titulo): ?>
							<h2><?= $titulo; ?></h2>
						<?php endif; ?>

						<?php if($mensagem): ?>
							<p><?= $mensagem; ?></p>
						<?php endif; ?>

					</div>
					<!-- Modal footer -->  
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-primary" data-dismiss="modal"> Ver depois </button>
						<?php if($botao_url): ?>
							<a href="<?= $botao_url; ?>?feedback=1" class="btn btn-primary"><?= $botao_nome; ?></a>
						<?php endif; ?>
					</div>
				</div> <!-- // .modal-content -->
			</div> <!-- // .modal-dialog -->
		</div> <!-- // #myModal -->
	<?php endif; ?>
<?php endif; ?>

<?php wp_footer() ?>
<script src="//api.handtalk.me/plugin/latest/handtalk.min.js"></script>
<script>
	
	//var ht = new HT({
        //token: "aa1f4871439ba18dabef482aae5fd934"
    //});

	document.onkeyup = PresTab;
 
	function PresTab(e)	{
		var keycode = (window.event) ? event.keyCode : e.keyCode;
		

		if (keycode == 9){
			jQuery('.cabecalho-acessibilidade').show();	
			jQuery(" a[accesskey='1']").focus();
			document.onkeyup = null;
		}
	}

	jQuery('.container-a-icones-home').click(function(){
		jQuery('.container-a-icones-home').removeClass('active');
		jQuery(this).addClass('active');
	});

	jQuery( function ( $ ) {
		// Focus styles for menus when using keyboard navigation


		// Properly update the ARIA states on focus (keyboard) and mouse over events
		$( '[role="menubar"]' ).on( 'focus.aria', '[aria-haspopup="true"]', function ( ev ) {
			$( ev.currentTarget ).attr( 'aria-expanded', true );
			$(this).parent().attr( 'aria-expanded', true );
			$(this).parent().attr( 'aria-haspopup', true );
		} );

		// Properly update the ARIA states on blur (keyboard) and mouse out events
		$( '[role="menubar"]' ).on( 'blur.aria', '[aria-haspopup="true"]', function ( ev ) {
			$( ev.currentTarget ).attr( 'aria-expanded', false );
			$(this).parent().attr( 'aria-expanded', false );
			$(this).parent().attr( 'aria-haspopup', false );

			//$(this).click();
		} );
		
	} );

	jQuery(document).ready(function($){

		// Start
		// sessionStorage.getItem('key');
		if (sessionStorage.getItem("story") !== 'true') {
			// sessionStorage.setItem('key', 'value'); pair
			sessionStorage.setItem("story", "true");
			// Calling the bootstrap modal
			$("#popup").modal();
		}
		// End

		// Do not include the code below, it is just for the 'Reset Session' button in the viewport.
		// This is same as closing the browser tab.
		//$('#reset-session').on('click',function(){
			//sessionStorage.setItem('story','');
		//});

	});
</script>
</body>
</html>