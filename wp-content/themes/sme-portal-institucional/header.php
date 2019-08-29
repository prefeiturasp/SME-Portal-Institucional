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

	<?php

        wp_head()

    ?>

</head>

<body>
<section id="main" role="main">
    <header class="bg-light pref-menu fonte-dez">
        <section class="container">
            <section class="row">

                <article class="col-lg-6 col-xs-12 d-flex justify-content-start">
                    <ul class="list-inline mt-3">
						<?php
						$slug = get_queried_object()->post_name;
						?>
                        <li class="list-inline-item"><a href="#<?= $slug ?>" class="text-secondary">Ir ao Conteúdo</a></li>
                        <li class="list-inline-item">A+</li>
                        <li class="list-inline-item">A-</li>
                        <li class="list-inline-item">BR</li>
                        <li class="list-inline-item">
                            <a class="text-secondary" href="https://www.facebook.com/EducaPrefSP/"><span class="esconde-item-acessibilidade">Ir para Facebook da Secerataria Muncipal de Educação de São Paulo</span><i class="fa fa-facebook-square"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-secondary" href="https://www.instagram.com/?hl=pt-br"><span class="esconde-item-acessibilidade">Ir para Instagram da Secerataria Muncipal de Educação de São Paulo</span><i class="fa fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-secondary" href="https://twitter.com/EducaPrefSP?ref_src=twsrc%5Etfw%7Ctwcamp%5Eembeddedtimeline%7Ctwterm%5Eprofile%3AEducaPrefSP&ref_url=https%3A%2F%2Fhom-portal.sme.prefeitura.sp.gov.br%2F"><span class="esconde-item-acessibilidade">Ir para Twitter da Secerataria Muncipal de Educação de São Paulo</span><i class="fa fa-twitter-square"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-secondary" href="https://www.youtube.com/"><span class="esconde-item-acessibilidade">Ir para YouTube da Secerataria Muncipal de Educação de São Paulo</span><i class="fa fa-youtube"></i></a>
                        </li>
                    </ul>
                </article>

                <article class="col-lg-6 col-xs-12 d-flex justify-content-end">
                    <ul class="list-inline mt-3">
                        <li class="list-inline-item"><a class="text-secondary" href="http://transparencia.prefeitura.sp.gov.br/acesso-a-informacao">Acesso à informação e-sic <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span> </a></li>
                        <li class="list-inline-item"><a class="text-secondary" href="https://www.prefeitura.sp.gov.br/cidade/secretarias/ouvidoria/fale_com_a_ouvidoria/index.php?p=464">Ouvidoria <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                        <li class="list-inline-item"><a class="text-secondary" href="http://transparencia.prefeitura.sp.gov.br/Paginas/home.aspx">Portal da Transparência <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                        <li class="list-inline-item"><a class="text-secondary" href="https://sp156.prefeitura.sp.gov.br/portal/servicos">SP 156 <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                    </ul>
                </article>

            </section>
        </section>
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
                    <img class="img-fluid" src="<?php echo $image[0] ?>" alt="<?php echo STM_SITE_NAME ?>  <?php echo STM_SITE_DESCRIPTION ?>"/>
                </a>
            </p>
            <form>
                <fieldset>
                    <legend>Mostra e Esconde Menu</legend>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </fieldset>
            </form>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
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
				<?php \Classes\TemplateHierarchy\Search\SearchForm::searchFormHeader() ?>
            </div>
        </section>
    </nav>
<?php new \Classes\Breadcrumb\Breadcrumb(); ?>