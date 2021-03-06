</section>
<!--main-->

<footer style="background: #363636; color: #fff;">
	<div class="container pt-5 pb-5">
		<div class="row">
			<div class="col-sm-3 align-middle">
				<img src="<?php the_field('logo_prefeitura','conf-rodape'); ?>" alt="<?php bloginfo('name'); ?>">
			</div>
			<div class="col-sm-3 align-middle">
				<p><h2><?php the_field('nome_da_secretaria','conf-rodape'); ?></h2></p>
				<p><?php the_field('endereco_da_secretaria','conf-rodape'); ?></p>
			</div>
			<div class="col-sm-3 align-middle">
				<p><h2>Contatos</h2></p>
				<p><a href="tel:<?php the_field('telefone','conf-rodape'); ?>"><?php the_field('telefone','conf-rodape'); ?></a></p>
				<p><a href="mailto:<?php the_field('email','conf-rodape'); ?>"><?php the_field('email','conf-rodape'); ?></a></p>
				<p><figure>
                        <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.pt_BR">
                            <img src="https://educacao.sme.prefeitura.sp.gov.br/wp-content/uploads/2019/07/by-nc-sa-2.png" alt="Logotipo Creative Commons. Ir para um link externo da Página Inicial da Creative Commons que é uma organização mundial sem fins lucrativos que permite o compartilhamento e a reutilização da criatividade e do conhecimento por meio do fornecimento de ferramentas gratuitas."/>
                        </a>
                        <p class="mt-2">Esta obra está licenciada com uma Licença Creative Commons
                            Atribuição-NãoComercial-CompartilhaIgual 4.0 Internacional </p>
                    </figure></p>
			</div>
			<div class="col-sm-3 align-middle">
				<div class="row">
					<div class="col rede-rodape">
						<a href="<?php the_field('url_facebook','conf-rodape'); ?>">
						<img src="<?php the_field('icone_facebook','conf-rodape'); ?>" alt="Facebook"></a>
					</div>
					<div class="col rede-rodape">
						<a href="<?php the_field('url_instagram','conf-rodape'); ?>">
						<img src="<?php the_field('icone_instagram','conf-rodape'); ?>" alt="Instagram"></a>
					</div>
					<div class="col rede-rodape">
						<a href="<?php the_field('url_twitter','conf-rodape'); ?>">
						<img src="<?php the_field('icone_twitter','conf-rodape'); ?>" alt="Twitter"></a>
					</div>
					<div class="col rede-rodape">
						<a href="<?php the_field('url_youtube','conf-rodape'); ?>">
						<img src="<?php the_field('icone_youtube','conf-rodape'); ?>" alt="YouTube"></a>
					</div>
				</div>
				<p class="mt-4"><a class="sa sat seloa" href="http://selodigital.imprensaoficial.com.br/validacao/SMPED/011e4eebb735e428dd" target="_blank">
                        <img src="<?= STM_THEME_URL ?>/img/sa2.svg" alt="Este sitio possui um selo de acessibilidade digital.">
                        <div class="st"><div>Selo de Acessibilidade Digital</div>Nº: 20630686115146508509<br>Validade: 18/12/2020<br><span>Clique para mais informações</span>
                        </div>
                    </a></p>
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