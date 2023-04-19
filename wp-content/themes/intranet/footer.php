</section>
<!--main-->

<footer style="background: #363636; color: #fff;" class="mt-3">
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
	//print_r($feed);
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="<?= get_template_directory_uri(); ?>/js/image-uploader.js"></script>
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

	document.querySelector('.custom-file-input').addEventListener('change',function(e){
		var fileName = document.getElementById("customFile").files[0].name;
		var nextSibling = e.target.nextElementSibling
		nextSibling.innerText = fileName + ' selecionado'
	});

	function calcelMural(){
		Swal.fire({
			title: '<strong>Atenção</u></strong>',
			icon: 'question',
			html: 'Deseja cancelar o cadastro da publicação?',
			showCloseButton: true,
			showCancelButton: false,
			showDenyButton: true,
			focusConfirm: false,
			confirmButtonText:
				'Não',
			confirmButtonAriaLabel: 'Cancelar ação',
			denyButtonText:
				'Sim',
			cancelButtonAriaLabel: 'Confirmar ação'
		}).then((result) => {
			/* Se for clicado no SIM */
		 	if (result.isDenied) {
				window.location.href = "<?= get_home_url(); ?>/index.php/mural-dos-professores/";
			}
		})
	}

	jQuery(document).ready(function($){		

		$('.input-images').imageUploader({
			label: 'Clique ou arraste a imagem para esta área para carregar. Adicione até 4 imagens nos formatos JPG, JPEG ou PNG.',
			maxSize: 1 * 1024 * 1024,
			maxFiles: 4
		});		

		$('#mural-enviar').submit(function(e){
			
			// Nome obrigatorio
			var nome = $('#nome').val();
			if(!nome){
				Swal.fire({
					icon: 'error',
					title: 'Atenção',
					text: 'O campo Nome é obrigatório.',
				});
				//e.preventDefault();
				return false;
			}

			// Nome da entidade obrigatorio
			var nome_ent = $('#nome_ent').val();
			if(!nome_ent){
				Swal.fire({
					icon: 'error',
					title: 'Atenção',
					text: 'O campo Nome da entidade é obrigatório.',
				});
				//e.preventDefault();
				return false;
			}

			// Título para publicação obrigatorio
			var title = $('#title').val();
			if(!title){
				Swal.fire({
					icon: 'error',
					title: 'Atenção',
					text: 'O campo Título para publicação é obrigatório.',
				});
				//e.preventDefault();
				return false;
			}

			if ($('#customFile').get(0).files.length === 0) {
				Swal.fire({
					icon: 'error',
					title: 'Atenção',
					text: 'O campo Imagem destaque é obrigatório.',
				});
				//e.preventDefault();
				return false;
			}

			// Validar o tamanho da imagem
			var fileInput = $('#customFile');
			var maxSize = fileInput.data('max-size');
			if(fileInput.get(0).files.length){
				var fileSize = fileInput.get(0).files[0].size;  //in bytes
				//console.log(fileSize);
				if(fileSize>maxSize){
					Swal.fire({
						icon: 'error',
						title: 'Atenção',
						text: 'A imagem não pode ter mais que 1mb.',
					});
					e.preventDefault();
					return false;
				}
			}

			// Descricao obrigatorio
			var conteudo = $('#descricao_publi').val();
			if(!conteudo){
				Swal.fire({
					icon: 'error',
					title: 'Atenção',
					text: 'O campo Descrição da publicação é obrigatório.',
				});
				//e.preventDefault();
				return false;
			}

			if(!$('input[name="auto_publi"]').is(':checked')){
				Swal.fire({
					icon: 'error',
					title: 'Atenção',
					text: 'Você precisa aceitar o termo de autorização de publicação.',
				});
				return false;
			}

			if(!$('input[name="auto_compa"]').is(':checked')){
				Swal.fire({
					icon: 'error',
					title: 'Atenção',
					text: 'Você precisa aceitar o termo de autorização para compartilhamento.',
				});
				return false;
			}
			
		});		

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
		$('#reset-session').on('click',function(){
			sessionStorage.setItem('story','');
		});

		$('#acf-field_62420050a8eb3').mask('(00) 00000-0000');
		$('#user-cpf').mask('000.000.000-00');

		$('#acf-field_6241ffb3bf190').change(function() {
			//Use $option (with the "$") to see that the variable is a jQuery object
			var $option = $(this).find('option:selected');
			//Added with the EDIT
			var value = $option.val();//to get content of "value" attrib
			//var text = $option.text();//to get <option>Text</option> content
			if(value == 'Outro'){
				$('.hide-input').show();
			} else {
				$('.hide-input').hide();
			}
		});

		$(".password-type").append('<i class="fa fa-eye-slash" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>');

		function alterar_senha(rf, senha1, senha2){
			$.ajax({
				url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
				type:"post",
				data: { action: 'altera_senha', user: rf, nova1: senha1, nova2: senha2 },
				success: function(data) {
				
					
					//jQuery('.leaflet-locationiq-list').prepend( data );
					var obj = JSON.parse(data);

					console.log(obj);

					if(obj.code == 200){
						$("#senha-atual").val("");
						$("#senha-nova").val("");
						$("#senha-repita").val("");
						$('#modalPass').modal('hide');

						Swal.fire({
							icon: 'success',
							title: 'Senha alterada com sucesso',
							text: 'A sua senha foi alterada com sucesso!',
						})
					} else if(obj.code == 401){
						Swal.fire({
							icon: 'error',
							title: 'Senha não alterada',
							text: obj.body,
						})
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Erro',
							text: 'Não foi possível alterar sua senha! Tente novamente.',
						})
					}
				},
				error : function(error){ console.log(error) }
			});
		}

		function validar_usuario(rf, atual, nova1, nova2){
			$.ajax({
				url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
				type:"post",
				data: { action: 'valida_user', user: rf, atual: atual },
				success: function(data) {
				
					
					//jQuery('.leaflet-locationiq-list').prepend( data );
					//var obj = JSON.parse(data);
					var obj = data;

					if(obj == 200){
						alterar_senha(rf, nova1, nova2);
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Erro',
							text: 'Sua senha atual está incorreta!',
						})
					}
				},
				error : function(error){ console.log(error) }
			});
		}


		$("#alterPass").click(function(){
			var rf = $("#user-rf").html();
			var atual = $("#senha-atual").val();
			var nova1 = $("#senha-nova").val();
			var nova2 = $("#senha-repita").val();
			var ciente = $('#ciencia-senha:checked').length;            

			if($('#ciencia-senha:checked').length < 1){
				Swal.fire({
					icon: 'error',
					title: 'Erro',
					text: 'Você precisa confirmar o termo de ciência para troca da senha.',
				});
			} else if(!atual || !nova1 || !nova2){
				Swal.fire({
					icon: 'error',
					title: 'Senhas obrigatórias',
					text: 'Preencha todos os campos de senha.',
				});
			} else if(nova1 == nova2){				
				validar_usuario(rf, atual, nova1, nova2);
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Senhas diferentes',
					text: 'As novas senhas não conferem, por gentileza revise e tente novamente.',
				});
			}
		});

		// Inclui botao hide/show no campo de senha
		$(".senha-atual").append('<i class="fa fa-eye-slash" id="senha-atual-show" style="margin-left: -30px; cursor: pointer;"></i>');

		const senhaAtualShow = document.querySelector('#senha-atual-show');
		const senhaAtual = document.querySelector('#senha-atual'); 
		
		senhaAtualShow.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = senhaAtual.getAttribute('type') === 'password' ? 'text' : 'password';
			senhaAtual.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
			this.classList.toggle('fa-eye');
		});

		// Inclui botao hide/show no campo de nova senha
		$(".senha-nova").append('<i class="fa fa-eye-slash" id="senha-nova-show" style="margin-left: -30px; cursor: pointer;"></i>');

		const senhaNovaShow = document.querySelector('#senha-nova-show');
		const senhaNova = document.querySelector('#senha-nova'); 
		
		senhaNovaShow.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = senhaNova.getAttribute('type') === 'password' ? 'text' : 'password';
			senhaNova.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
			this.classList.toggle('fa-eye');
		});

		$("#newPass").click(function(){
			alert('AQui');
			var nova1 = $("#senha-nova").val();
			var nova2 = $("#senha-repita").val();
			var ciente = $('#ciencia-senha:checked').length;
            

			if($('#ciencia-senha:checked').length < 1){
				Swal.fire({
					icon: 'error',
					title: 'Erro',
					text: 'Você precisa confirmar o termo de ciência para troca da senha.',
				});
			} else if(!nova1 || !nova2){
				Swal.fire({
					icon: 'error',
					title: 'Senhas obrigatórias',
					text: 'Preencha todos os campos de senha.',
				});
			} else if(nova1 == nova2){				
				//validar_usuario(rf, atual, nova1, nova2);
				//alert('tudo certo');
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Senhas diferentes',
					text: 'As novas senhas não conferem, por gentileza revise e tente novamente.',
				});
			}

			
		});

		// Inclui botao hide/show no campo de repita senha
		$(".senha-repita").append('<i class="fa fa-eye-slash" id="senha-repita-show" style="margin-left: -30px; cursor: pointer;"></i>');

		const senhaRepitaShow = document.querySelector('#senha-repita-show');
		const senhaRepita = document.querySelector('#senha-repita'); 
		
		senhaRepitaShow.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = senhaRepita.getAttribute('type') === 'password' ? 'text' : 'password';
			senhaRepita.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
			this.classList.toggle('fa-eye');
		});		
		
	});
</script>
<?php if($_GET['updated']): ?>
	<script>
		Swal.fire({
			icon: 'success',
			title: 'Dados atualizados',
			text: 'Seus dados foram atualizados com sucesso!',
		});
	</script>
<?php endif; ?>
<?php if($_GET['publicacao'] == 'success'): ?>
	<script>
		Swal.fire({
			icon: 'success',
			title: 'Obrigada por compartilhar sua prática',
			text: 'Suas postagens serão moderadas pelo administrador do site antes de serem postadas.',
		});
	</script>
<?php endif; ?>
<script>
    tinymce.init({
      selector: '.mural-textarea',
	  menubar: false,
	  block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3',
      plugins: 'lists textcolor',
      toolbar: 'undo redo | blocks | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | forecolor',
      language: 'pt_BR'
    });	
</script>

</body>
</html>