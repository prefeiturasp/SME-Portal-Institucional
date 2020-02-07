<?php get_header(); ?>

<?php

function busca_multisite(){

	$termo_buscado = get_search_query();//termo da busca

	/*$args = array(
		's' => $termo_buscado,
		'public' => true,
		'posts_per_page' => 100,
		'post_type'=> (array( 'post', 'page', 'agenda' , 'contatoprincipal', 'outroscontatos' )),

	);*/

	$sites = array(
		's' => $termo_buscado,
		'site__in' => (array( '1', '4' )),
		'orderby' => 'id',
		'order' => 'DESC',
		'public' => 'true',
		'post_status' => 'publish',
		'orderby' => 'publish_date',
		'posts_per_page' => -1,
		'post_type'=> (array( 'post', 'page', 'agenda' , 'contatoprincipal', 'outroscontatos' )),
	);
	foreach (get_sites($sites) as $blog){
		switch_to_blog($blog->blog_id);
			$busca_geral = new WP_Query( $sites);
			if ( $busca_geral->have_posts() ) {
				while ( $busca_geral->have_posts() ) {
					$busca_geral->the_post();
					?>
					<div class="row">
						<div class="col-sm-4">
							<?php
							if (has_post_thumbnail() != '') {
								echo '<figure class="">';
								the_post_thumbnail('medium', array('class' => 'img-fluid rounded float-left'));
								echo '</figure>';
							}else{
							    ?>
                                <figure>
                                    <img class="img-fluid rounded float-left" src="http://localhost/SME-Portal-Institucional/diretoria-regional-de-educacao-guaianases/wp-content/uploads/sites/4/2020/02/placeholder-1.jpg" width="100%">
                                </figure>
                                <?php
                            }
							?>
						</div>
						<div class="col-sm-8">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div><?php the_excerpt(); ?></div>
							<span>Publicado em: <?php the_time('d/m/Y') ?> </span> -
							<span> em: <a href="<?php echo get_site_url(); ?>"><?php echo get_bloginfo('description'); ?></a></span>
						</div>
					</div>
					<hr>
					<?php
				}
			}else{
				echo'Não foi encontrado resultado para a pesquisa:'.''.'"'.$termo_buscado.'"';
				break;
			}

		restore_current_blog();
	}
}
?>

<?php
function filtro_tipo_conteudo(){
	$post_types = get_post_types( $busca_geral, 'objects' );
	foreach ( $post_types as $post_type ) {
		if( $post_type->name == 'post' || $post_type->name == 'page' || $post_type->name == 'contatoprincipal' || $post_type->name == 'outroscontatos' ){
			echo '<option value="'.get_home_url().'/?s='.get_search_query().'&posttype='.$post_type->name.'">'.$post_type->labels->singular_name.'</option>';
		}
	}
}
?>

<?php
function filtro_tipo_sites(){
	foreach (get_sites() as $blog){
	  switch_to_blog($blog->blog_id);
		if(get_bloginfo() == 'SME Portal Institucional' || get_bloginfo() == 'Diretoria Regional de Educação Guaianases' ){
		    ?>
            <option value="<?php echo get_site_url(); ?>?s=<?php echo get_search_query(); ?>&posttype=<?php echo get_bloginfo(); ?>"><?php echo get_bloginfo('description'); ?></option>
<?php
        }
		?>
<?php
		restore_current_blog();
	}
}
?>

<div class="container ">
	<div class="row">
		<div class="col-sm-8">
			    <?php busca_multisite(); ?>
		</div>
		<div class="col-sm-4">
            <span class="filtro-busca">
                <div class="form-group border-filtro">
                    <label for="usr"><strong><h2>Refine a sua busca</h2></strong></label>
                </div>
                <div class="form-group">
                    <label for="usr"><strong>Filtre por um termo</strong></label>
                    <input class ='form-control' type = 'text' placeholder = 'Buscar'>
                </div>
                <div class="form-group">
                    <label for="sel1"><strong>Filtre por tipo de conteúdo</strong></label>
                    <select class="form-control" onchange="location = this.value;" id="sel1">
                        <?php filtro_tipo_conteudo(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel2"><strong>Filtre por um período</strong></label>
                    <select class="form-control" <!--onchange="location = this.value;"--> id="sel2">
                        <option value="">Todos os períodos</option>
                        <option value="">Últimas 24 horas</option>
                        <option value="">Última semana</option>
                        <option value="">Último mês</option>
                        <option value="">Último ano</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel2"><strong>Filtre por setores</strong></label>
                    <select class="form-control" <!--onchange="location = this.value;"--> id="sel2">
                        <?php filtro_tipo_sites(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-sm float-right">Refinar busca</button>
                </div>
            </span>
		</div>

	</div>
</div>


<?php get_footer(); ?>