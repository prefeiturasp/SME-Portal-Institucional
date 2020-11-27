</section>
<!--main-->

<footer style="background: #363636; color: #fff;" id='irrodape'>
	<div class="container pt-5 pb-5">
		<div class="row">
			<div class="col-sm-3 align-middle">
				<img src="<?php the_field('logo_prefeitura','conf-rodape'); ?>" alt="<?php bloginfo('name'); ?>">
			</div>
			<div class="col-sm-3 align-middle">
				<h2><?php the_field('nome_da_secretaria','conf-rodape'); ?></h2>
				<?php the_field('endereco_da_secretaria','conf-rodape'); ?>
			</div>
			<div class="col-sm-3 align-middle">
				<h2>Contatos</h2>
				<p><a href="tel:<?php the_field('telefone','conf-rodape'); ?>"><?php the_field('telefone','conf-rodape'); ?></a></p>
                <?php
                    $email = the_field('email','conf-rodape');
                    if($email) : 
                ?>
                    <p><a href="mailto:<?php the_field('email','conf-rodape'); ?>"><?php the_field('email','conf-rodape'); ?></a></p>
                <?php endif; ?>
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
				<p class="mt-4"><a class="sa sat seloa" href="http://selodigital.imprensaoficial.com.br/validacao/SMPED/011e4eebb735e428dd">
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
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.multiselect.js"></script>

    <script>
		var $s = jQuery.noConflict();

        $s(function () {
            $s('.ms-list-1').multiselect({
                columns  : 1,
                search   : false,
                selectAll: false,
                texts    : {
                    placeholder: 'Selecione a(s) atividade(s) de interesse',
                    selectedOptions: ' selecionados'
                },
                maxHeight : 300,
                maxWidth: 245,
                onOptionClick :function( element, option ){
                    var thisOpt = $s(option);

                    
                    var selecionados = $s('.ms-list-1').val();

                    //console.log(selecionados);

                    if(selecionados != null){
                        $s('.ms-list-2').multiselect( 'disable', false );

                        $s.ajax({
                            type: "POST",
                            url: "<?php echo get_template_directory_uri(); ?>/get_category.php",
                            data: {data : selecionados}, 
                            cache: false,

                            success: function(res){
                                
                                var b = JSON.parse(res); 
                                var options = b;
                                console.log(b);
                                $s('.ms-list-2').multiselect('loadOptions', options );

                                if(b.length == 0){
                                    $s('.ms-list-2').multiselect( 'disable', true );
                                }
                            }
                        });

                    } else {
                        $s('.ms-list-2').multiselect( 'disable', true );
                    }                    

                    
                }
            });

            


            $s('.ms-list-2').multiselect({
                columns  : 1,
                search   : false,
                selectAll: false,
                texts    : {
                    placeholder: 'Selecione a(s) atividade(s) interna(s)',
                    selectedOptions: ' selecionados'
                },
                maxHeight : 300,
                maxWidth: 245
            });

            $s('.ms-list-2').multiselect( 'disable', true );

            $s('.ms-list-3').multiselect({
                columns  : 1,
                search   : false,
                selectAll: false,
                texts    : {
                    placeholder: 'Selecione o(s) público(s)',
                    selectedOptions: ' selecionados'
                },
                maxHeight : 300,
                maxWidth: 245
            });

            $s('.ms-list-4').multiselect({
                columns  : 1,
                search   : false,
                selectAll: false,
                texts    : {
                    placeholder: 'Selecione a(s) faixa(s) estária(s)',
                    selectedOptions: ' selecionados'
                },
                maxHeight : 300,
                maxWidth: 245
            });

            $s('.ms-list-5').multiselect({
                columns  : 1,
                search   : false,
                selectAll: false,
                texts    : {
                    placeholder: 'Selecione o(s) CEU(s)',
                    selectedOptions: ' selecionados'
                },
                maxHeight : 300,
                maxWidth: 245
            });

            $s('.ms-list-10').multiselect({
                columns  : 1,
                search   : false,
                selectAll: false,
                texts    : {
                    placeholder: 'Selecione a(s) data(s)',
                    selectedOptions: ' selecionados'
                },
                maxHeight : 300,
                maxWidth: 245,
                maxSelect: 1
            });
            $s('.ms-list-10').multiselect( 'disable', true );

            $s('.ms-list-8').multiselect({
                columns  : 1,
                search   : false,
                selectAll: false,
                texts    : {
                    placeholder: 'Selecione o período do dia',
                    selectedOptions: ' selecionados'
                },
                maxHeight : 300,
                maxWidth: 245
            });

            $s('#tipoData').change(function(){ 
                var value = $s(this).val();
                console.log(value);

                if(value == 'dia_semana'){
                    $s('.ms-list-10').multiselect( 'disable', false );
                    $s('.ms-list-10').multiselect('loadOptions', [{
                        name   :'Segunda',
                        value  :'segunda',
                        checked:false
                    },{
                        name   :'Terça',
                        value  :'terca',
                        checked:false
                    },{
                        name   :'Quarta',
                        value  :'quarta',
                        checked:false
                    },{
                        name   :'Quinta',
                        value  :'quinta',
                        checked:false
                    },{
                        name   :'Sexta',
                        value  :'sexta',
                        checked:false
                    },{
                        name   :'Sabado',
                        value  :'sabado',
                        checked:false
                    },{
                        name   :'Domingo',
                        value  :'domingo',
                        checked:false
                    }
                    ]);
                    $s('#date-range').hide();
                    $s('#date-periode').show();
                } else if(value == 'mes'){
                    $s('.ms-list-10').multiselect( 'disable', false );
                    $s('.ms-list-10').multiselect('loadOptions', [{
                        name   :'Janeiro',
                        value  :'01',
                        checked:false
                    },{
                        name   :'Fevereiro',
                        value  :'02',
                        checked:false
                    },{
                        name   :'Março',
                        value  :'03',
                        checked:false
                    },{
                        name   :'Abril',
                        value  :'04',
                        checked:false
                    },{
                        name   :'Maio',
                        value  :'05',
                        checked:false
                    },{
                        name   :'Junho',
                        value  :'06',
                        checked:false
                    },{
                        name   :'Julho',
                        value  :'07',
                        checked:false
                    },{
                        name   :'Agosto',
                        value  :'08',
                        checked:false
                    },{
                        name   :'Setembro',
                        value  :'09',
                        checked:false
                    },{
                        name   :'Outubro',
                        value  :'10',
                        checked:false
                    },{
                        name   :'Novembro',
                        value  :'11',
                        checked:false
                    },{
                        name   :'Dezembro',
                        value  :'12',
                        checked:false
                    }
                    ]);
                    $s('#date-range').hide();
                    $s('#date-periode').show();
                } else if(value == 'intervalo') {
                    $s('#date-range').show();
                    $s('#date-periode').hide();
                    $s('.ms-list-10').multiselect( 'disable', true );
                }
            });

			// DYNAMICALLY LOAD OPTIONS
			/*
            $s('.ms-list-1').multiselect( 'loadOptions', [{
                name   : 'Option Name 1',
                value  : 'option-value-1',
                checked: false,
                attributes : {
                    custom1: 'value1',
                    custom2: 'value2'
                }
            },{
                name   : 'Option Name 2',
                value  : 'option-value-2',
                checked: false,
                attributes : {
                    custom1: 'value1',
                    custom2: 'value2'
                }
            }]);

            */
    
        });

        // Carrocel
        $s('.carousel').carousel({
            interval: 8000
        });
	</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    <script>
        $s('#date-range .input-daterange').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR",
            autoclose: true
        });
    </script>

	<script src="//api.handtalk.me/plugin/latest/handtalk.min.js"></script>
	<script>
		var ht = new HT({
			token: "aa1f4871439ba18dabef482aae5fd934"
		});
	</script>
</body>
</html>