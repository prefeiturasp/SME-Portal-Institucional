<?php
/*use Classes\TemplateHierarchy\Search\GetTipoDePost;*/
get_header(); ?>
    <!--new GetTipoDePost();-->

    <!--Libera CTPs para a Busca-->
<?php
add_filter( 'pre_get_posts', 'cpt_busca' );
function cpt_busca( $search ) {
    if ( $search->is_search ) {
		$search->set('post_type', array( 'post', 'page', 'card', 'programa-projeto' ));
	}
	return $search;
}
?>
<!--Limita quantidade de posts na busca-->
<?php
function custom_posts_per_page($query) {
	if (is_search()) {
		$query->set('posts_per_page', 50);
	}
}
add_action('pre_get_posts', 'custom_posts_per_page');
?>

<!--Busca Manual-->
<?php
$campo_de_busca = get_search_query();

$texto_buscado_agenda = array('agenda', 'Agenda', 'agenda secretario' , 'agenda secretário' , 'agenda do secretario' , 'agenda do secretário');
if (in_array($campo_de_busca, $texto_buscado_agenda)) { ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-8 pb-4 border-bottom">
                    <h2>Agenda do Secretário de Educação</h2>
                    <div class="col-12"><a class="btn btn-primary" href="<?= STM_URL .'/'. 'agenda'.'/'?>">Visualizar</a></div>
            </div>
        </div>
    </div>
    <?php }

$texto_buscado_organograma = array('organograma', 'Organograma');
if (in_array($campo_de_busca, $texto_buscado_organograma)) { ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-8 pb-4 border-bottom">
                <h2>Organograma — Secretaria Municipal de Educação</h2>
                <div class="col-12"><a class="btn btn-primary" href="<?= STM_URL .'/'. 'organograma'.'/'?>">Visualizar</a></div>
            </div>
        </div>
    </div>
<?php }

$texto_buscado_mapa_dres = array('Mapa Dres', 'Mapa das Dres', 'mapa dres', 'mapa das dres', 'DRE s', 'dres');
if (in_array($campo_de_busca, $texto_buscado_mapa_dres)) { ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-8 pb-4 border-bottom">
                <h2>Mapa das DRE's — Diretorias Regionais de Educação</h2>
                <div class="col-12"><a class="btn btn-primary" href="<?= STM_URL .'/'. 'mapa-dres'.'/'?>">Visualizar</a></div>
            </div>
        </div>
    </div>
<?php }

$texto_buscado_curriculo_da_cidade = array('Curriculo da Cidade', 'curriculo da cidade', 'Currículo da Cidade', 'currículo da cidade');
if (in_array($campo_de_busca, $texto_buscado_curriculo_da_cidade)) { ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-8 pb-4 border-bottom">
                <h2>Curriculo da Cidade</h2>
                <div class="col-12"><a class="btn btn-primary" href="<?= STM_URL .'/'. 'curriculo-da-cidade'.'/'?>">Visualizar</a></div>
            </div>
        </div>
    </div>
<?php }

$texto_buscado_busca_de_escolas = array('Escolas', 'escola', 'Busca de Escolas', 'busca de escolas', 'busca de escola', 'encontrar uma escola');
if (in_array($campo_de_busca, $texto_buscado_busca_de_escolas)) { ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-8 pb-4 border-bottom">
                <h2>Encontre a Escola Desejada</h2>
                <div class="col-12"><a class="btn btn-primary" href="<?= STM_URL .'/'. 'busca-de-escolas'.'/'?>">Visualizar</a></div>
            </div>
        </div>
    </div>
<?php }

?>


<?php
$searchfor = get_search_query(); // Obtem a consulta de pesquisa para exibição
?>
<?php $query_string=esc_attr($query_string); // Elimina potencial MySQL-injections
$blogs = get_blog_list( 0,'all' ); // Seta todos os site do multisite

/*$blogs = get_blog_list( 1 ); // Seta todos os site do multisite*/

foreach ( $blogs as $blog ): switch_to_blog($blog['blog_id']); //faz a busca site por site

	$search = new WP_Query($query_string);
	if ($search->found_posts>0) {
		foreach ( $search->posts as $post ) {
			setup_postdata($post);
			$author_data = get_userdata(get_the_author_meta('ID'));

			?>
			<div class="container">
				<div class="row mb-4">
					<div class="col-sm-4 pb-4 border-bottom">
						<?php
						if (has_post_thumbnail()) {
							echo '<figure class="">';
							the_post_thumbnail('medium', array('class' => 'img-fluid rounded float-left'));
							echo '</figure>';
						}
						?>
					</div>
					<div class="col-sm-8 pb-4 border-bottom">
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<!--por --><?php /*the_author_posts_link();*/?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div id="entry-content"><?php the_excerpt(); ?>
							</div>
							<?php get_the_archive_description(); ?>
						</div>
                        <br>
						<span>Publicação: <?php the_time('d/m/Y') ?> </span><span> em: <a href="<?php echo get_site_url(); ?>"><?php echo get_bloginfo(); ?></a></span>

					</div>

				</div>
			</div>
			<?php

		}
	}else{
	    ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Nenhum resultado encontrado na pesquisa.</h2>
                </div>
            </div>
        </div>
        <?php
        break;
    }?>


    <?php
endforeach;

restore_current_blog(); //Reseta e volta para o site atual
?>

<?php
get_footer()
?>