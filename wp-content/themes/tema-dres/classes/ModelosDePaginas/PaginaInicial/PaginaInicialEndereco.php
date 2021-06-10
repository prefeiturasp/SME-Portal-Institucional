<?php
namespace Classes\ModelosDePaginas\PaginaInicial;

class PaginaInicialEndereco
{

	public function __construct()
	{
		$this->montaHtmlEndereco();

	}

	public function montaHtmlEndereco(){
		?>
        <script>
            jQuery(document).ready(function ($) {
                $("#btn-outroscontatos").click(function () {
                    window.location.href="<?php echo get_site_url(); ?>/outroscontatos/";
                });
            });
        </script>
		<section class="container mt-5 mb-5 noticias">
            <article class="row mb-4">
                <article class="col-lg-12 col-xs-12">
                    <h2 class="border-bottom">Endereços e responsáveis</h2>
                </article>
            </article>
		</section>
		<div class="container">
            <div class="row ">
                <div class="col-sm-8 mb-4">
                    <?php
                    query_posts( array(
                        'post_type'  => 'contatoprincipal',
                        'orderby' => 'menu_order',
                        //'orderby' => array('menu_order', 'title'),
                        'order' =>'ASC'
                    ));
                    ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-sm-12 mb-4 border-bottom">
                            <span class="row mb-2"><strong><?php the_title(); ?></strong></span>
                            <?php if( get_field('principal_diretor') !== '' && get_field('principal_diretor') !== null){ ?>
                                <span class="row "><strong>Diretor(a):&nbsp;</strong><?php the_field('principal_diretor'); ?></span>
                            <?php } ?>
                            <?php if( get_field('principal_responsavel') !== '' && get_field('principal_responsavel') !== null){ ?>
                                <span class="row "><strong>Responsável:&nbsp;</strong><?php the_field('principal_responsavel'); ?></span>
                            <?php } ?>
                            <?php if( get_field('principal_logradouro') !== '' && get_field('principal_logradouro') !== null){ ?>
                            <span class="row "><strong>Endereço:&nbsp;</strong>
                                <?php the_field('principal_logradouro'); ?>,<?php the_field('principal_numero'); ?><?php if(get_field('complemento') !== '' && get_field('complemento') !== null){ echo ' - '; the_field('complemento'); }?> - <?php the_field('principal_bairro'); ?> - CEP: <?php the_field('principal_cep');?>

								- <a href="#map" class="story" data-point="<?php the_field('principal_latitude'); ?>,<?php the_field('principal_longitude'); ?>,<strong><?php the_title(); ?></strong><br><?php the_field('principal_logradouro'); ?> nº <?php the_field('principal_numero'); ?><?php if(get_field('complemento') !== '' && get_field('complemento') !== null){ echo ' - '; the_field('complemento'); }?><br><?php the_field('principal_bairro'); ?><br>CEP: <?php the_field('principal_cep');?>,<?php the_field('principal_logradouro'); ?>&nbsp;<?php the_field('principal_numero'); ?>&nbsp;<?php the_field('principal_bairro'); ?>"> &nbsp;destacar no mapa</a></span>
                            <?php } ?>
                            <?php if( get_field('principal_telefone_1') !== '' && get_field('principal_telefone_1') !== null){ ?>
                                <span class="row "><strong>Telefone:&nbsp;</strong><?php the_field('principal_telefone_1'); ?></span>
                            <?php } ?>
                            <?php if( get_field('principal_telefone_2') !== '' && get_field('principal_telefone_2') !== null){ ?>
                                <span class="row "><strong>Telefone:&nbsp;</strong><?php the_field('principal_telefone_2'); ?></span>
                            <?php } ?>
                            <?php if( get_field('principal_email') !== '' && get_field('principal_email') !== null){ ?>
                                <span class="row mb-4"><strong>E-mail:&nbsp;</strong> <a href="mailto:<?php the_field('principal_email'); ?>"><?php the_field('principal_email'); ?></a></span>
                            <?php } ?>

                        </div>
                    <?php endwhile;?>

                    <button id="btn-outroscontatos" class="btn btn-primary btn-sm btn-block bg-azul-escuro font-weight-bold text-white">Outros Contatos</button>

				</div>
				
				
				<div class="col-sm-4 mb-4">
					<p><img src="<?php the_field('foto_do_gabinete', 'option'); ?>" width="100%"></p>
					<div id="results"/></div>
					<p id="map" style="width: 100%; min-height: 300px;"></p>
					<!--<div class="move">
						
					</div>-->
					<!--<p class="move">MAPA<img src="http://localhost/SME-Portal-Institucional/diretoria-regional-de-educacao-guaianases/wp-content/uploads/sites/4/2020/01/mapa.jpg" width="100%"></p>-->					
                </div>
			
				
				
            </div>

		</div>


		<?php
	}
}