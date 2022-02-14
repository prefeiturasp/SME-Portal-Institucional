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
			<div class="col-sm-3 align-middle text-center">				
				<a class="sa sat seloa mt-1" href="http://selodigital.imprensaoficial.com.br/validacao/SMPED/0118119073598c7823" target="_blank">
					<img src="<?= STM_THEME_URL ?>/img/sa2.svg" alt="Este sitio possui um selo de acessibilidade digital.">
					<div class="st"><div>Selo de Acessibilidade Digital</div>Nº do Selo: 2020-AD/102<br>Validade: 18/12/2022<br>Clique para mais informações
					</div>
				</a>
				<p><figure>
					<a href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.pt_BR">
						<img src="https://educacao.sme.prefeitura.sp.gov.br/wp-content/uploads/2019/07/by-nc-sa-2.png" alt="Logotipo Creative Commons. Ir para um link externo da Página Inicial da Creative Commons que é uma organização mundial sem fins lucrativos que permite o compartilhamento e a reutilização da criatividade e do conhecimento por meio do fornecimento de ferramentas gratuitas."/>
					</a>
					<p class="mt-2">Esta obra está licenciada com uma Licença Creative Commons
						Atribuição-NãoComercial-CompartilhaIgual 4.0 Internacional </p>
				</figure></p>
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
<?php wp_footer() ?>
<script src="//api.handtalk.me/plugin/latest/handtalk.min.js"></script>
<script>
    var ht = new HT({
        token: "aa1f4871439ba18dabef482aae5fd934"
    });

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
</script>
</body>
</html>