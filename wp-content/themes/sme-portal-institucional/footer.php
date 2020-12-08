</section>
<!--main-->

<footer style="background: #363636; color: #fff;">
	<div class="container pt-5 pb-5">
		<div class="row">
			<div class="col-sm-3 align-middle d-flex align-items-center">
				<img src="<?php the_field('logo_prefeitura','conf-rodape'); ?>" alt="<?php bloginfo('name'); ?>">
			</div>
			<div class="col-sm-3 align-middle bd-contact">
				<p><h2><?php the_field('nome_da_secretaria','conf-rodape'); ?></h2></p>
				<p><?php the_field('endereco_da_secretaria','conf-rodape'); ?></p>
			</div>
			<div class="col-sm-3 align-middle">
				<p><h2>Contatos</h2></p>
				<p><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:<?php the_field('telefone','conf-rodape'); ?>"><?php the_field('telefone','conf-rodape'); ?></a></p>
				<p><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:<?php the_field('email','conf-rodape'); ?>"><?php the_field('email','conf-rodape'); ?></a></p>
				<p><h2>Redes sociais</h2></p>
				<?php 
					$facebook = get_field('icone_facebook','conf-rodape');
					$instagram = get_field('icone_instagram','conf-rodape');
					$twitter = get_field('icone_twitter','conf-rodape');
					$youtube = get_field('icone_youtube','conf-rodape');
				?>
				<div class="row redes-footer">

					<?php if($facebook) : ?>
						<div class="col rede-rodape">
							<a href="<?php the_field('url_facebook','conf-rodape'); ?>">
							<img src="<?php echo $facebook; ?>" alt="Facebook"></a>
						</div>
					<?php endif; ?>

					<?php if($instagram) : ?>
						<div class="col rede-rodape">
							<a href="<?php the_field('url_instagram','conf-rodape'); ?>">
							<img src="<?php echo $instagram; ?>" alt="Instagram"></a>
						</div>
					<?php endif; ?>

					<?php if($twitter) : ?>
						<div class="col rede-rodape">
							<a href="<?php the_field('url_twitter','conf-rodape'); ?>">
							<img src="<?php echo $twitter; ?>" alt="Twitter"></a>
						</div>
					<?php endif; ?>

					<?php if($youtube) : ?>
						<div class="col rede-rodape">
							<a href="<?php the_field('url_youtube','conf-rodape'); ?>">
							<img src="<?php echo $youtube; ?>" alt="YouTube"></a>
						</div>
					<?php endif; ?>

					
				</div>
			</div>
			<div class="col-sm-3 align-middle text-center">				
				<p class="mt-1"><a class="sa sat seloa" href="http://selodigital.imprensaoficial.com.br/validacao/SMPED/011e4eebb735e428dd" target="_blank">
                        <img src="<?= STM_THEME_URL ?>/img/sa2.svg" alt="Este sitio possui um selo de acessibilidade digital.">
                        
                    </a></p>
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
				<p>&copy<?php echo date('Y'); ?> - SECRETARIA MUNICIPAL DE EDUCAÇÃO — Rua Borges Lagoa, 1230 — Vila Clementino — CEP: 04038-003</p>
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
</script>
</body>
</html>