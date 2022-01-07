</section>
<!--main-->

<footer style="background: #363636;color: #fff;margin-left: -15px;margin-right: -15px;">
	<div class="container pt-3 pb-3" id="irrodape">
		<div class="row">
			<div class="col-sm-3 align-middle d-flex align-items-center footer-logo">
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
		</div>
	</div>
</footer>
<div class="subfooter rodape-api-col" style="margin-left: -15px;margin-right: -15px;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<p>Prefeitura Municipal de São Paulo - Viaduto do Chá, 15 - Centro - CEP: 01002-020</p>
			</div>
		</div>
	</div>
</div>		
<?php wp_footer() ?>

<?php 
    $unidades = get_unidades();

    $marcadores = array();

    $p = 0;

    foreach ($unidades as $unidade){
        $zona = get_group_field( 'informacoes_basicas', 'zona_sp', $unidade );
        $endereco = get_group_field( 'informacoes_basicas', 'endereco', $unidade );
        $numero = get_group_field( 'informacoes_basicas', 'numero', $unidade );
        $bairro = get_group_field( 'informacoes_basicas', 'bairro', $unidade );
        $cep = get_group_field( 'informacoes_basicas', 'cep', $unidade );
        $emails = get_group_field( 'informacoes_basicas', 'email', $unidade );        
        $tels = get_group_field( 'informacoes_basicas', 'telefone', $unidade ); 

        //print_r($emails);

        $marcadores[$p][] = "<div class='marcador-unidade color-" . $zona . "'>
                                <p class='marcador-title'><a href='". get_the_permalink($unidade) ."'>" . get_the_title($unidade) . "</a></p>
                                <p><i class='fa fa-map-marker' aria-hidden='true'></i> " . nomeZona($zona) . " • " . $endereco . ", ". $numero ." - " . $bairro . " - CEP: " . $cep . "</p>
                                
                                <p><i class='fa fa-phone' aria-hidden='true'></i> " . $tels['telefone_principal'] ."</p>
                                <p><i class='fa fa-envelope' aria-hidden='true'></i> " . $emails['email_principal'] ."</p>
                            </div>";
        $marcadores[$p][] = get_group_field( 'informacoes_basicas', 'latitude', $unidade );
        $marcadores[$p][] = get_group_field( 'informacoes_basicas', 'longitude', $unidade );
        $marcadores[$p][] = get_group_field( 'informacoes_basicas', 'zona_sp', $unidade );

        $p++;
    }

    //print_r($unidades);
?>
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

        $s( ".tab-mobile" ).click(function() {
            $s('#filtroBusca').modal('toggle');
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

    <script type="text/javascript">
        var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })

        
    </script>

<?php if(is_page()) : ?>
    <script type="text/javascript">

        // Maps access token goes here
        //var key = 'pk.87f2d9fcb4fdd8da1d647b46a997c727';
        var key = 'pk.2217522833071a6e06b34ac78dfc05bc';

        // Initial map view
        var INITIAL_LNG = -46.6360999;
        var INITIAL_LAT = -23.5504533;

        // Change the initial view if there is a GeoIP lookup
        if (typeof Geo === 'object') {
            INITIAL_LNG = Geo.lon;
            INITIAL_LAT = Geo.lat;
        }
        // Add layers that we need to the map
        var streets = L.tileLayer.Unwired({
            key: key,
            scheme: "streets"
        });

        var tileLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: false
        });



        var map = L.map('map', {
            scrollWheelZoom: (window.self === window.top) ? true : false,
            dragging: (window.self !== window.top && L.Browser.touch) ? false : true,
            layers: [tileLayer],
            tap: (window.self !== window.top && L.Browser.touch) ? false : true,
        }).setView({
            lng: INITIAL_LNG,
            lat: INITIAL_LAT
        }, 11);
        var hash = new L.Hash(map);

        L.control.zoom({
            position: 'topright'
        }).addTo(map);

        // Add the 'layers' control
        L.control.layers({            
            "Completo" : tileLayer,
            "Ruas": streets,
        }, null, {
            position: "topright"
        }).addTo(map);

        // Add the 'scale' control
        L.control.scale().addTo(map);

        // Add geocoder
        var geocoder = L.control.geocoder(key, {
            fullWidth: 650,
            expanded: true,
            markers: true,
            attribution: null,
            url: 'https://api.locationiq.com/v1',
            placeholder: 'Encontre CEUs por nome ou endereço',
            textStrings: {                
                NO_RESULTS: 'Nenhum endereço encontrado.',
            },
            panToPoint: true,
            params: {
                countrycodes: 'BR'
            },
        }).addTo(map);

        // Focus to geocoder input
        geocoder.focus();

        geocoder.on('select', function(e) {
            if (typeof latlng == 'undefined') {
                // the variable is defined
                //alert('Aqui');
            }
            //console.log(e.latlng);
            map.setView([e.latlng.lat, e.latlng.lng], 15);
        });


        var newParent = document.getElementById('search-box');
        var oldParent = document.getElementsByClassName("leaflet-top leaflet-left")

        while (oldParent[0].childNodes.length > 0) {
            newParent.appendChild(oldParent[0].childNodes[0]);
        }

        <?php
            
            $js_array = json_encode($marcadores);
            echo "var javascript_array = ". $js_array . ";\n";
        ?>

                
        for (var i = 0; i < javascript_array.length; i++) {

            if(javascript_array[i][3] == 'norte'){
                myIcon = L.icon({
                    iconUrl: "<?php echo get_template_directory_uri() . '/img/pin-map-norte.png'; ?>",
                });
            } else if(javascript_array[i][3] == 'sul'){
                myIcon = L.icon({
                    iconUrl: "<?php echo get_template_directory_uri() . '/img/pin-map-sul.png'; ?>",
                });
            } else if(javascript_array[i][3] == 'leste'){
                myIcon = L.icon({
                    iconUrl: "<?php echo get_template_directory_uri() . '/img/pin-map-leste.png'; ?>",
                });
            } else if(javascript_array[i][3] == 'oeste'){
                myIcon = L.icon({
                    iconUrl: "<?php echo get_template_directory_uri() . '/img/pin-map-oeste.png'; ?>",
                });
            } else {
                myIcon = L.icon({
                    iconUrl: "<?php echo get_template_directory_uri() . '/img/pin-map-padrao.png'; ?>",
                });
            }

            marker = new L.marker([javascript_array[i][1], javascript_array[i][2]], {
                    icon: myIcon
                })
                .bindPopup(javascript_array[i][0])
                .addTo(map);
        }

        // Posição no navegador

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        }

        function showPosition(position) {
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            map.setView([position.coords.latitude, position.coords.longitude], 15);

            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery("#map").offset().top
            }, 1000);
        }        

        //adiciona link aos marcadores
        jQuery('.name .story').on('click', function(){
            // pega lat e lng das class ".story" por data attribute            
            var latlng = jQuery(this).data().point.split(',');
            var lat = latlng[0];
            var lng = latlng[1];
            var desc = latlng[2];
            var zoom = 17;
                            
            // adiciona marcadores
            var marker = L.marker([lat, lng] ).bindPopup(desc).addTo(map).openPopup();
            // adiciona no mapa
            map.setView([lat, lng], zoom);
        })

        function alerta(content){

            var latlng2 = content;
            var latlng = jQuery(latlng2).data().point.split(',');
            var lat = latlng[0];
            var lng = latlng[1];
            var desc = latlng[2];
            var zoom = 17;                
        
            // adiciona no mapa
            map.setView([lat, lng], zoom);

            // Oculta a lista de Unidades
            jQuery(".lista-unidades").addClass('hidemapa');
            jQuery("#collpaseContent").addClass('closeContent');
        }       

        var $div = jQuery(".leaflet-locationiq-search-icon");
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "class") {
                var attributeValue = jQuery(mutation.target).prop(mutation.attributeName);
                //console.log("Class attribute changed to:", attributeValue);
                fetchResults();
                }
            });
        });
        observer.observe($div[0], {
        attributes: true
        });

    </script>
    <?php  endif; ?>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".swiper", {
            slidesPerView: "auto",
            spaceBetween: 0,
            freeMode: true,
            loop: true,        
        });
    </script>
   
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "100%";
            document.getElementById("mySidebar").classList.add("sidebar-border");
            jQuery(".lista-unidades").removeClass('hidemapa');
            jQuery("#collpaseContent").removeClass('closeContent');
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("mySidebar").classList.remove("sidebar-border");
            jQuery("input[name=zona][value='all']").prop("checked",true);
            map.setView([-23.5501, -46.6359], 11);            
        }

        function openUnidades(){
            jQuery(".lista-unidades").toggleClass('hidemapa');
            jQuery("#collpaseContent").toggleClass('closeContent');
        }

        jQuery("input[name='zona']").click(function(){
            
            var zona = jQuery('input:radio[name=zona]:checked').val();           
            
            if(zona == 'norte'){                
                map.setView([-23.4768, -46.6457], 13);
                jQuery(".lista-unidades").addClass('hidemapa');
                jQuery("#collpaseContent").addClass('closeContent');
            }

            if(zona == 'leste'){                
                map.setView([-23.5791, -46.5046], 12);
                jQuery(".lista-unidades").addClass('hidemapa');
                jQuery("#collpaseContent").addClass('closeContent');
            }

            if(zona == 'oeste'){                
                map.setView([-23.5671, -46.7059], 13);
                jQuery(".lista-unidades").addClass('hidemapa');
                jQuery("#collpaseContent").addClass('closeContent');
            }

            if(zona == 'central'){                
                map.setView([-23.5425, -46.6340], 14);
                jQuery(".lista-unidades").addClass('hidemapa');
                jQuery("#collpaseContent").addClass('closeContent');
            }

            if(zona == 'sul'){                
                map.setView([-23.6867, -46.6900], 12);
                jQuery(".lista-unidades").addClass('hidemapa');
                jQuery("#collpaseContent").addClass('closeContent');
            }

            if(zona == 'all'){                
                map.setView([-23.5501, -46.6359], 11);
                jQuery(".lista-unidades").addClass('hidemapa');
                jQuery("#collpaseContent").addClass('closeContent');
            }
            
        });
    </script>

</body>
</html>