<?php
use Classes\Header\Header;
?>
<!doctype html>
<html lang="pt-br">
<head>
	<?php
	if (function_exists('get_field')){
        $tituloPagina = get_field("insira_o_title_desejado");
	    $descriptionPagina = get_field("insira_a_description_desejada");
    }
	if (is_front_page()) {
		if (trim($tituloPagina != "")) { ?>
            <title><?php echo $tituloPagina ?></title>
		<?php } else { ?>
            <title><?php echo STM_SITE_NAME ?> - Home</title>
		<?php }

		if (trim($descriptionPagina != "")) { ?>
            <meta name="description" content="<?php echo $descriptionPagina ?>."/>
		<?php } else { ?>
            <meta name="description" content="<?php echo STM_SITE_NAME ?>. <?php echo STM_SITE_DESCRIPTION ?>"/>
		<?php }
	} elseif (is_category() || is_tax()) {
		$queried_object = get_queried_object();
		$taxonomy = $queried_object->taxonomy;
		$term_id = $queried_object->term_id;
		
        if (function_exists('get_field')){
            $tituloCategoria = get_field('insira_o_title_desejado', $taxonomy . '_' . $term_id);
            $descriptionCategoria = get_field("insira_a_description_desejada", $taxonomy . '_' . $term_id);
        }

		if (trim($tituloCategoria != "")) { ?>
            <title><?php echo $tituloCategoria ?></title>
		<?php } else { ?>
            <title><?php wp_title('', true, '-'); ?> - <?php echo STM_SITE_NAME ?></title>
		<?php }

		if (trim($descriptionCategoria != "")) { ?>
            <meta name="description"
                  content="<?php echo $descriptionCategoria ?>."/>
		<?php } else { ?>
            <meta name="description" content="<?php echo STM_SITE_NAME ?>. <?php echo STM_SITE_DESCRIPTION ?>"/>
		<?php }

	} else {
		if (trim($tituloPagina != "")) { ?>
            <title><?php echo $tituloPagina ?></title>
		<?php } else { ?>
            <title><?php wp_title('', true, '-'); ?> - <?php echo STM_SITE_NAME ?></title>
		<?php }

		if (trim($descriptionPagina != "")) { ?>
            <meta name="description" content="<?php echo $descriptionPagina ?>."/>
		<?php } else { ?>
            <meta name="description"
                  content="<?php wp_title('', true, '-'); ?> - <?php echo STM_SITE_DESCRIPTION ?>"/>
		<?php }
	}
	?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Secretaria Municipal de Educação de São Paulo">

	<?php wp_head() ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-149756375-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-149756375-1');
    </script>
    
    <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/5a2df64151ea7e12d55494267/c9466a177cfa11afee4e2e22b.js");</script>

</head>

<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v9.0&appId=635401619866547&autoLogAppEvents=1" nonce="XHGXF3d7"></script>
<section id="main" role="main">
    <header class="pref-menu fonte-dez">

            <section class="row cabecalho-acessibilidade" style='display: none;'>
                <section class="container">
                    <section class="row">
                        <article class="col-lg-8 col-xs-12 d-flex justify-content-start">
                            <ul class="list-inline list-inline-mob my-3">
                                <?php
                                $slug_titulo = new Header();
                                ?>
                                <li class="list-inline-item"><a accesskey="1" id="1" href="#<?= $slug_titulo->getSlugTitulo() ?>" >Ir ao Conteúdo <span class="span-accesskey">1</a></li>
                                <li class="list-inline-item"><a accesskey="2" id="2" href="#irmenu"  >Ir para menu principal <span class="span-accesskey">2</span></a></li>
                                <li class="list-inline-item"><a accesskey="3" id="3" href="#search-front-end"  >Ir para busca <span class="span-accesskey">3</span></a></li>
                                <li class="list-inline-item"><a accesskey="4" id="4" href="#irrodape"  >Ir para rodapé <span class="span-accesskey">4</span></a></li>
                                <li class="list-inline-item"><a href="<?= STM_URL ?>/acessibilidade/" accesskey="5">Acessibilidade <span class="span-accesskey">5</span> </a></li>
                            </ul>
                        </article>

                        <article class="col-lg-4 col-xs-12 d-flex justify-content-md-end justify-content-start">
                            <?php dynamic_sidebar('Rodape Esquerda') ?>
                        </article>

                    </section>
                </section>

            </section>

            <section class="row cabecalho-cinza-claro">

                <section class="container">
                    <section class="row">
                        <article class="col-8 col-lg-6 col-xs-12 d-flex justify-content-start">
                            <ul class="list-inline my-3">
                                <li class="list-inline-item"><a class="text-white" href="http://esic.prefeitura.sp.gov.br/Account/Login.aspx">Acesso à informação e-sic <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span> </a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://www.prefeitura.sp.gov.br/cidade/secretarias/ouvidoria/fale_com_a_ouvidoria/index.php?p=227268">Ouvidoria <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                                <li class="list-inline-item"><a class="text-white" href="http://transparencia.prefeitura.sp.gov.br/">Portal da Transparência <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://sp156.prefeitura.sp.gov.br/portal/servicos">SP 156 <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                            </ul>
                        </article>
                        <article class="col-4 col-lg-6 col-xs-12 d-flex justify-content-end align-items-center">
                            <?php 
                                if (function_exists('have_rows')){
                                    // Verifica se existe Redes Sociais
                                    if( have_rows('redes_sociais', 'conf-rodape') ):
                                        
                                        echo '<ul class="list-inline mt-2 mb-2 midias-sociais">';						
                                        
                                            while( have_rows('redes_sociais', 'conf-rodape') ) : the_row();
                                                
                                                $rede_url = get_sub_field('url_rede'); 
                                                $rede_texto = get_sub_field('texto_alternativo');
                                                $rede_topo = get_sub_field('tipo_de_icone_topo');
                                                $rede_t_imagem = get_sub_field('imagem_topo');
                                                $rede_t_icone = get_sub_field('icone_topo');                                            
                                                
                                            ?>
                                                
                                                <li class="list-inline-item">
                                                    <a class="text-white" href="<?php echo $rede_url; ?>">
                                                        <?php if($rede_topo == 'imagem' && $rede_t_imagem != '') : ?>
                                                            <img src="<?php echo $rede_t_imagem; ?>" alt="<?php echo $rede_texto; ?>">
                                                        <?php elseif($rede_topo == 'icone' && $rede_t_icone != ''): ?>
                                                            <i class="fa <?php echo $rede_t_icone; ?>" aria-hidden="true" title="<?php echo $rede_texto; ?>"><span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></i>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php
                                                

                                            // End loop.
                                            endwhile;

                                        echo '</ul>';
                                    
                                    endif;
                                }
                            ?>
                        </article>
                    </section>
                </section>
            </section>

            <section class='row logo-principal'>

                <div class="container">
                    <div class="row py-3">

                        <div class="col-3 d-flex d-sm-flex d-md-none mobile-menu">
                            <button type="button" class="btn btn-menu" data-toggle="modal" data-target="#menu">
                                <i class="fa fa-bars" aria-hidden="true"></i> MENU
                            </button>

                            <!-- Modal -->
                            <div class="modal left fade" id="menu" tabindex="-1" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header d-block d-md-none">
                                            <?= STM_SITE_NAME; ?>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>

                                        <div class="modal-body">
                                            <?php
                                                wp_nav_menu(array(
                                                    'menu' => 'primary',
                                                    'theme_location' => 'primary',
                                                    'depth' => 2,
                                                    'container_id' => 'bs-example-navbar-collapse-1',
                                                    'menu_class' => 'navbar-nav mr-auto nav nav-tabs',
                                                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                                    'walker'            => new WP_Bootstrap_Navwalker(),
                                                ));
                                            ?>
                                        </div>

                                    </div>
                                    <!-- modal-content -->
                                </div>
                                <!-- modal-dialog -->
                            </div>
                            <!-- modal -->
                            
                        </div>

                        <div class="col-6 col-md-3 order-1 order-md-1">
                            <?php
                            // Traz o Logotipo cadastrado no Admin
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $image = wp_get_attachment_image_src($custom_logo_id, 'full');
                            ?>
                            <p class="logo-topo">
                                <a class="brand" href="<?php echo STM_URL ?>">
                                    <img class="img-fluid" src="<?php echo $image[0] ?>" alt="Logotipo da Secretaria Municipal de Educação - Ir para a página principal"/>
                                </a>
                            </p>
                        </div>

                        <div class="col-sm-12 col-md-6 d-flex align-items-center order-3 order-md-2">
                            <?php \Classes\TemplateHierarchy\Search\SearchForm::searchFormHeader() ?>
                        </div>

                        <div class="col-3 col-md-3  d-flex align-items-center order-2 order-md-3 profile-menu">
                            <?php 
                                $user = wp_get_current_user();
                                $profileLink = get_home_url() . '/index.php/perfil';
                                if(current_user_can('administrator'))
                                    $profileLink = get_home_url() . '/wp-admin/profile.php';
                                
                                $name = explode(" ", $user->data->display_name);
                                $displayName = $name[0];
                                if($name[1] && $name[1] != '')
                                    $displayName .= ' ' . substr($name[1], 0, 1) . '.';


                                //echo "<pre>";
                                //print_r($name);
                                //echo "</pre>";

                            ?>
                            <div class="navbar-nav ml-auto">                                
                                <div class="nav-item dropdown profile-menus">
                                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
                                        <?php
                                            $image_id = get_field('imagem', 'user_' . get_current_user_id());
                                            $image_profile = $img_atts = wp_get_attachment_image_src($image_id, 'thumbnail');
                                                                        
                                            if($image_profile[0]):
                                        ?>
                                            <img src="<?= $image_profile[0]; ?>" alt="Imagem de perfil">
                                        <?php else: ?>
                                            <img src="<?= get_template_directory_uri() . '/img/user-image.jpg'; ?>" class="avatar" alt="Avatar"> 
                                        <?php endif; ?>
                                        <span><?= $displayName; ?></span> <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <?php
                                            $image_id = get_field('imagem', 'user_' . get_current_user_id());
                                            $image_profile = $img_atts = wp_get_attachment_image_src($image_id, 'thumbnail');
                                                                        
                                            if($image_profile[0]):
                                        ?>
                                            <img src="<?= $image_profile[0]; ?>" alt="Imagem de perfil">
                                        <?php else: ?>
                                            <img src="<?= get_template_directory_uri() . '/img/user-image.jpg'; ?>" class="avatar" alt="Avatar"> 
                                        <?php endif; ?>
                                        <p><?= $displayName; ?></p>
                                        <div class="dropdown-divider"></div>
                                        <a href="<?= $profileLink; ?>" class="dropdown-item">Perfil</a>
                                        <!-- <a href="#" class="dropdown-item">Acesse seu e-mail <strong>@SME</strong></a>
                                        <a href="#" class="dropdown-item">Acesse seu e-mail <strong>@EDU</strong></a>-->                                     
                                        <a href="<?= wp_logout_url(); ?>" class="dropdown-item">Sair</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </section>

		

    </header>
    
    <nav class="navbar navbar-expand-lg menu-topo mb-5 d-none d-md-block">
        <section class="container">
			
            <form>
                <fieldset>
                    <legend>Mostra e Esconde Menu</legend>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#irmenu" aria-controls="irmenu" aria-expanded="false">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                </fieldset>
            </form>

            <nav class="collapse navbar-collapse justify-content-between w-100" id="irmenu" aria-label="Menu Principal">
                <?php
				wp_nav_menu(array(
					'menu' => 'primary',
					'theme_location' => 'primary',
					'depth' => 2,
					'container_id' => 'bs-example-navbar-collapse-1',
					'menu_class' => 'navbar-nav mr-auto nav d-flex justify-content-between',
					'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
					'walker'            => new WP_Bootstrap_Navwalker(),
                    'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
				));
				?>

            </nav>
        </section>
    </nav>
    
<?php
    if(is_search())
    new \Classes\Breadcrumb\Breadcrumb();
?>