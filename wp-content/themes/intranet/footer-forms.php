</section>
<!--main-->
		
<?php wp_footer() ?>
<script src="//api.handtalk.me/plugin/latest/handtalk.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

		$("#conteudo a").each(function(){
			var href = $(this).attr('href');
			var valor = $(this).html();
			
							
				if( href && !href.startsWith('#') && !valor.includes('<button') && !valor.includes('<img') && !href.includes('tel:') && !href.includes('mailto:') && href != ''){
					if(!href.includes("https://educacao.sme.prefeitura.sp.gov.br") && !href.includes("http://educacao.sme.prefeitura.sp.gov.br")){
						$(this).html(valor + ' <span class="screen-reader-text">(Link para um novo sítio)</span><span aria-hidden="true" class="dashicons dashicons-external"></span>');
					}
				}

				if(valor.includes('<img')){
					if(!href.includes("https://educacao.sme.prefeitura.sp.gov.br") && !href.includes("http://educacao.sme.prefeitura.sp.gov.br")){
						$(this).html(valor + ' <span class="screen-reader-text">(Link para um novo sítio)</span>');
					}
				}
						
			
		});
		

		$("#newPassForm").submit(function(e){
			//$("#newPassForm").preventDefault();
			//e.preventDefault();


			var nova1 = $("#senha-nova").val();
			var nova2 = $("#senha-repita").val();
			var ciente = $('#ciencia-senha:checked').length;

			if($('#ciencia-senha:checked').length < 1){
				Swal.fire({
					icon: 'error',
					title: 'Atenção',
					text: 'Você precisa confirmar o termo de ciência para troca da senha.',
				});
				e.preventDefault();
			} else if(!nova1 || !nova2){
				Swal.fire({
					icon: 'error',
					title: 'Senhas obrigatórias',
					text: 'Preencha todos os campos de senha.',
				});
				e.preventDefault();
			} else if(nova1 == nova2){				
				//validar_usuario(rf, atual, nova1, nova2);
				//alert('tudo certo');
				if (nova1.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,12}$/)) {
					e.submit();
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Senhas inválida',
						text: 'Sua nova senha deve conter letras Maiúsculas, Minúsculas, números e símbolos. Por favor digite outra senha.',
					});
					e.preventDefault();
				}				
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Senhas diferentes',
					text: 'As novas senhas não conferem, por gentileza revise e tente novamente.',
				});
				e.preventDefault();
			}
			
		});
		
		//console.log('To aqui');

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
	} );
</script>
<?php if( isset($_GET['login']) && $_GET['login'] == 'new' ): ?>
	<script>
		Swal.fire({
			icon: 'success',
			title: 'Dados atualizados',
			text: 'Seus dados foram atualizados com sucesso!',
		});
	</script>
<?php endif; ?>
<?php if( isset($_GET['pass']) && $_GET['pass'] == 'new' ): ?>
	<script>
		Swal.fire({
			icon: 'error',
			title: 'Este link expirou',
			text: 'Solicite um novo link de recuperação de senha.',
		});
	</script>
<?php endif; ?>
</body>
</html>