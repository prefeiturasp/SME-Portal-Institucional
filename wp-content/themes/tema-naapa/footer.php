</section>
<!--main-->

<footer style="background: #363636;color: #fff;margin-left: -15px;margin-right: -15px;">
	<div class="container pt-3 pb-3" id="irrodape">
		<div class="row">
			<div class="col-sm-3 align-middle d-flex align-items-center">
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
    
        if( have_rows('fx_flex_layout', get_the_ID()) ):
            while( have_rows('fx_flex_layout', get_the_ID() ) ): the_row();
            
                if( get_row_layout() == 'fx_linha_coluna_3b1' ):
                    while( have_rows('fx_coluna_1_3b1') ): the_row();
                        if( get_row_layout() == 'quem_cuida_listagem' ):
                            $qtd = get_sub_field('quantidade');
                        elseif( get_row_layout() == 'se_liga_listagem' ):
                            $qtd = get_sub_field('quantidade');
                        endif;
                    endwhile;
                endif;

                if( get_row_layout() == 'fx_linha_coluna_1' ):
                    while( have_rows('fx_coluna_1_1') ): the_row();
                        if( get_row_layout() == 'posts_quebrada' ):
                            $qtd = get_sub_field('quantidade');
                        endif;
                    endwhile;
                endif;

            endwhile;
        endif;
   

    if(!$qtd){
        $qtd = 10;
    }
 ?>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/gridify.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.mask.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
        
    <script>
		var $s = jQuery.noConflict();

        // Quem Cuida
        $s(function () {
           
            var ppp = <?php echo $qtd; ?>; // Post per page
            var pageNumber = 1;
            <?php if(get_the_ID() == 656): ?>
                var type = 'post';
            <?php else: ?>
                var type = 'quem-cuida';
            <?php endif; ?>

            <?php if($_GET['filter'] && $_GET['filter'] ): ?>
                var filter = '<?php echo $_GET['filter']; ?>';
            <?php elseif(get_queried_object()->term_id): ?>
                var filter = '<?php echo get_queried_object()->term_id; ?>';
            <?php else: ?>
                var filter = '';
            <?php endif; ?>

            function load_posts(){
                pageNumber++;
                var str = '&pageNumber=' + pageNumber + '&ppp=' + ppp + '&type=' + type + '&filter=' + filter + '&action=more_post_ajax';
                jQuery.ajax({
                    type: "POST",
                    dataType: "html",
                    url: ajaxurl,
                    data: str,
                    success: function(data){
                        var $data = jQuery(data);
                        if($data.length){
                            jQuery("#ajax-posts").append($data);
                            jQuery("#more_posts").attr("disabled",false);
                        } else{
                            jQuery("#more_posts").attr("disabled",true);
                        }
                    },
                    error : function(jqXHR, textStatus, errorThrown) {
                        $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    }

                });
                return false;
            }
            var $s = jQuery.noConflict();

            $s("#more_posts").on("click",function(){ // When btn is pressed.
                $s("#more_posts").attr("disabled",true); // Disable the button, temp.
                load_posts();
                $s(this).insertAfter('#ajax-posts'); // Move the 'Load More' button to the end of the the newly added posts.
            });
    
        });

        // Na Quebrada
        $s(function () {
           
           var ppp = <?php echo $qtd; ?>; // Post per page
           var pageNumber = 1;

           <?php if($_GET['filter'] && $_GET['filter'] ): ?>
               var filter = '<?php echo $_GET['filter']; ?>';
           <?php elseif(get_queried_object()->term_id): ?>
               var filter = '<?php echo get_queried_object()->term_id; ?>';
           <?php else: ?>
               var filter = '';
           <?php endif; ?>

           function load_quebrada(){
               pageNumber++;
               var str = '&pageNumber=' + pageNumber + '&ppp=' + ppp + '&filter=' + filter + '&action=more_post_quebrada';
               jQuery.ajax({
                   type: "POST",
                   dataType: "html",
                   url: ajaxurl,
                   data: str,
                   success: function(data){
                       var $data = jQuery(data);
                       if($data.length){
                           jQuery(".all-itens").append($data);
                           jQuery("#more_quebrada").attr("disabled",false);
                           gridify.reInit();
                       } else{
                           jQuery("#more_quebrada").attr("disabled",true);
                       }
                   },
                   error : function(jqXHR, textStatus, errorThrown) {
                       $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                   }

               });
               gridify.reInit();
               return false;
           }
           
           $s("#more_quebrada").on("click",function(){ // When btn is pressed.
                $s("#more_quebrada").attr("disabled",true); // Disable the button, temp.               
                gridify.destroy();
                load_quebrada();
                $s(this).insertAfter('.all-itens'); // Move the 'Load More' button to the end of the the newly added posts.               
           });
           
        });

        <?php if ( is_search() ) : ?>           
        
            // Busca
            $s(function () {
            
                var ppp = 10; // Post per page
                var pageNumber = 1;

                <?php if($_GET['filter'] && $_GET['filter'] ): ?>
                var filter = '<?php echo $_GET['filter']; ?>';
                <?php elseif(get_queried_object()->term_id): ?>
                var filter = '<?php echo get_queried_object()->term_id; ?>';
                <?php else: ?>
                var filter = '';
                <?php endif; ?>

                <?php if($_GET['s'] && $_GET['s'] != '') : ?>
                    var search = '<?php echo $_GET['s']; ?>';
                <?php else: ?>
                var search = '';
                <?php endif; ?>

                function load_busca(){
                    pageNumber++;
                    var str = '&pageNumber=' + pageNumber + '&ppp=' + ppp + '&search=' + search + '&filter=' + filter + '&action=more_post_busca';
                    jQuery.ajax({
                        type: "POST",
                        dataType: "html",
                        url: ajaxurl,
                        data: str,
                        success: function(data){
                            var $data = jQuery(data);
                            if($data.length){
                                jQuery("#ajax-posts").append($data);
                                jQuery("#more_busca").attr("disabled",false);
                                gridify.reInit();
                            } else{
                                jQuery("#more_busca").attr("disabled",true);
                            }
                        },
                        error : function(jqXHR, textStatus, errorThrown) {
                            $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                        }

                    });
                    gridify.reInit();
                    return false;
                }
                
                $s("#more_busca").on("click",function(){ // When btn is pressed.
                        $s("#more_busca").attr("disabled",true); // Disable the button, temp.               
                        load_busca();
                        $s(this).insertAfter('#ajax-posts'); // Move the 'Load More' button to the end of the the newly added posts.               
                });
            
            });

        <?php endif; ?>

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

        document.onkeyup = PresTab;
 
        function PresTab(e)	{
            var keycode = (window.event) ? event.keyCode : e.keyCode;
            

            if (keycode == 9){
                jQuery('.cabecalho-acessibilidade').show();	
                jQuery(" a[accesskey='1']").focus();
                document.onkeyup = null;
            }
        }

        
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
    
    
    <?php if($_SESSION['success']): ?>
        <script>
            Swal.fire(
            'Publicação enviada para análise!',
            'Após a aprovação do administrador seu conteúdo estará disponível.',
            'success'
            )
        </script>
    <?php endif; ?>

    
        <?php
        global $wp;
        $url = home_url( $wp->request );

        if(strpos($url, 'comment-page-1') !== false): ?>
            <script>
            Swal.fire(
            'Comentário enviado para análise!',
            'Após a aprovação do administrador seu comentário será publicado.',
            'success'
            )
        </script>

        <?php endif; ?>

    <script>
        $s(document).ready(function() {

            (function($) {
                //$s('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');

                $s('.tab ul.tabs li a').click(function(g) {
                    var tab = $s(this).closest('.tab'),
                        index = $s(this).closest('li').index();


                    if ($s(this).closest('li').hasClass('current')) {

                        $s(this).closest('li').removeClass('current');
                        tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideUp();

                    } else {

                        tab.find('ul.tabs > li').removeClass('current');
                        $s(this).closest('li').addClass('current');
                        tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
                        tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
                    }



                    g.preventDefault();
                });
            })(jQuery);

        });
    </script>
</body>
</html>