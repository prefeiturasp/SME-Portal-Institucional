<?php
use Classes\Header\Header;
?>
<!doctype html>
<html lang="pt-br">
<head>
	<?php
	$tituloPagina = get_field("insira_o_title_desejado");
	$descriptionPagina = get_field("insira_a_description_desejada");
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

		$tituloCategoria = get_field('insira_o_title_desejado', $taxonomy . '_' . $term_id);
		$descriptionCategoria = get_field("insira_a_description_desejada", $taxonomy . '_' . $term_id);

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
    <meta name="author" content="Ollyver Ottoboni">

	<?php wp_head() ?>

</head>

<body>
<section id="main" role="main">
    <header class="bg-light pref-menu fonte-dez">

            <section class="row cabecalho-cinza-escuro">
                <section class="container">
                    <section class="row">
                        <article class="col-lg-6 col-xs-12 d-flex justify-content-start">
                            <ul class="list-inline mt-3 mb-0">
                                <?php
                                $slug_titulo = new Header();
                                ?>
                                <li class="list-inline-item"><a accesskey="1" href="#<?= $slug_titulo->getSlugTitulo() ?>" class="text-white">Ir ao Conteúdo <span class="span-accesskey">1</a></li>
                                <li class="list-inline-item"><a href="#irmenu" accesskey="2" class="text-white">Ir para menu principal <span class="span-accesskey">2</span></a></li>
                                <li class="list-inline-item"><a href="#search-front-end" accesskey="3" class="text-white">Ir para busca <span class="span-accesskey">3</span></a></li>
                                <li class="list-inline-item"><a href="#irrodape" accesskey="4" class="text-white">Ir para rodapé <span class="span-accesskey">4</span></a></li>
                            </ul>
                        </article>

                        <article class="col-lg-6 col-xs-12 d-flex justify-content-end">
                            <ul class="list-inline mt-3">
                                <li class="list-inline-item"><a href="<?= STM_URL ?>/acessibilidade/" accesskey="5" class="text-white">Acessibilidade <span class="span-accesskey">5</span> </a></li>
                            </ul>
                            <?php dynamic_sidebar('Rodape Esquerda') ?>
                        </article>

                    </section>
                </section>

            </section>

            <section class="row cabecalho-cinza-claro">

                <section class="container">
                    <section class="row">
                        <article class="col-lg-6 col-xs-12 d-flex justify-content-start">
                            <ul class="list-inline mt-2 mb-0">
                                <li class="list-inline-item"><a class="text-white" href="http://transparencia.prefeitura.sp.gov.br/acesso-a-informacao">Acesso à informação e-sic <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span> </a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://www.prefeitura.sp.gov.br/cidade/secretarias/ouvidoria/fale_com_a_ouvidoria/index.php?p=464">Ouvidoria <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                                <li class="list-inline-item"><a class="text-white" href="http://transparencia.prefeitura.sp.gov.br/Paginas/home.aspx">Portal da Transparência <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://sp156.prefeitura.sp.gov.br/portal/servicos">SP 156 <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                            </ul>
                        </article>
                        <article class="col-lg-6 col-xs-12 d-flex justify-content-end">
                            <ul class="list-inline mt-2 mb-2 midias-sociais">
                                <li class="list-inline-item"><a class="text-white" href="https://www.facebook.com/EducaPrefSP/"><img src="<?= STM_URL ?>/wp-content/uploads/2019/09/icone-facebook-topo.png" alt="Ir para Facebook da Secretaria Muncipal de Educação de São Paulo"></a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://www.instagram.com/educaprefsp/"><img src="<?= STM_URL ?>/wp-content/uploads/2019/09/icone-instagram-topo.png" alt="Ir para Instagram da Secretaria Muncipal de Educação de São Paulo"></a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://twitter.com/EducaPrefSP?ref_src=twsrc%5Etfw%7Ctwcamp%5Eembeddedtimeline%7Ctwterm%5Eprofile%3AEducaPrefSP&ref_url=https%3A%2F%2Fhom-portal.sme.prefeitura.sp.gov.br%2F"><img src="<?= STM_URL ?>/wp-content/uploads/2019/09/icone-twitter-topo.png" alt="Ir para Twitter da Secretaria Muncipal de Educação de São Paulo"></a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://www.youtube.com/c/EducaPrefSP/"><img src="<?= STM_URL ?>/wp-content/uploads/2019/09/icone-youtube-topo.png" alt="Ir para YouTube da Secretaria Muncipal de Educação de São Paulo"></a></li>
                            </ul>
                        </article>
                    </section>
                </section>
            </section>


		<?php \Classes\TemplateHierarchy\Search\SearchForm::searchFormHeader() ?>

    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light menu-topo">
        <section class="container">
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
            <form>
                <fieldset>
                    <legend>Mostra e Esconde Menu</legend>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#irmenu"
                            aria-controls="irmenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </fieldset>
            </form>

            <div class="collapse navbar-collapse justify-content-end" id="irmenu">
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
        </section>
    </nav>
<?php new \Classes\Breadcrumb\Breadcrumb(); ?>