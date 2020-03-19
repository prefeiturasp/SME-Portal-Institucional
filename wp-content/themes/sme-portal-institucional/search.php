<?php get_header(); ?>

<?php

function busca_multisite()
{

    $termo_buscado = get_search_query(); //termo da busca
    
    $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
    $periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';
    $tipoconteudo = isset($_GET['tipoconteudo']) ? $_GET['tipoconteudo'] : '';
    $categoria = isset($_GET['category']) ? $_GET['category'] : '';
    $ano = isset($_GET['ano']) ? $_GET['ano'] : '';
    $sites = array(
        's' => $termo_buscado,
        'site__in' => (array(
            '1',
            '2',
            '3',
            '4'
        )) ,
        //informa a lista de sites que deseja ter nos resultados da busca
        'paged' => $paged,
        'orderby' => 'publish_date',
        'order' => 'DESC',
        'public' => 'true',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'date_query' => [
            [
                'after'     => '- '.$periodo.' hours',  
                'inclusive' => true,
                'year' => intval($ano),
            ],
        ],
        'post_type' => (array( $tipoconteudo )),     
        'category_name' => $categoria
    );


    foreach (get_sites($sites) as $blog)
    {
        switch_to_blog($blog->blog_id);
        $busca_geral = new WP_Query( $sites );
        if ($busca_geral->have_posts())
        {
            while ($busca_geral->have_posts())
            {
                $busca_geral->the_post();

?>

   <div class="row">

    <div class="col-sm-4">

	<?php
	if (has_post_thumbnail() != ''){
		echo '<figure class="">';
		the_post_thumbnail('medium', array(
			'class' => 'img-fluid rounded float-left'
		));
		echo '</figure>';
	}else{
	?>
	<figure>
		<img class="img-fluid rounded float-left" src="" width="100%">
	</figure>
	<?php
	}
    ?>

    </div>

	  <div class="col-sm-8">

		  <h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>

		  <div><?php the_excerpt(); ?></div>

		  <span>Publicado em: <?php	the_time('d/m/Y H:m:s');?>
		  </span> - <span>
		  em: <a href="<?php echo get_site_url(); ?>"><?php echo get_bloginfo('description'); ?></a>
		  </span>

	  </div>

   </div>

   <hr>

<?php
            }
        }else{
            echo 'Não foi encontrado resultado para a pesquisa:' . '' . '"' . $termo_buscado . '"';
            break;
        }
?>
<div class="paginacao-atual">
	<?php
        echo paginate_links(array(
            'format' => 'page/%#%',
            'current' => $paged,
            'total' => $busca_geral->max_num_pages,
            'mid_size' => 2,
            'prev_text' => __('<<') ,
            'next_text' => __('>>')
        ));
	?>
</div>
<?php  restore_current_blog();
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
<form name="filtrosX" method="get" action="" >

               <div class="form-group border-filtro">
                    <label for="usr"><strong><h2>Refine a sua busca</h2></strong></label>
               </div>

                <div class="form-group">
                    <label for="usr"><strong>Busque por um termo</strong></label>
                    <input class ='form-control' type = 'text' name="s" placeholder = 'Buscar'>
                </div>
                <div class="form-group">

<label for="sel2"><strong>Filtre por categorias</strong></label>

<select class="form-control" name="category" id="sel2">
<?php 
$current = get_current_site();

// rob: pega cats de todos sites
$blogs = get_blog_list( 0, 'all' );

echo  "<option value=''>Selecione</option>";

foreach ( $blogs as $blog ) {
    switch_to_blog( $blog['blog_id'] );
    $args = array(
        'hide_empty' => false
    );
    $categories = get_categories( $args );
//    var_dump($categories);
    foreach ( $categories as $category ) {

        $link = ( $category->name );
        $name = $category->name;
        echo  "<option value='".$link."'>".$name."</option>";

        // printf( '<a href="%s" title="%s">%s</a> ', $link, $name, $name );
    }

}
switch_to_blog( $current->id );
?>
</select>

</div>

               <div class="form-group">

                    <label for="sel1"><strong>Filtre por tipo de conteúdo</strong></label>

                    

                    <select name="tipoconteudo" class="form-control"  id="sel1">
                    
                    <?php 
$current = get_current_site();
echo  "<option value=''>Selecione o tipo</option>";
//rob: pega todos tipos de post (inclusive indesejáveis, então precisa excluir, no array abaixo)
$excluidos = array('wp_block'); 
$blogs = get_blog_list( 0, 'all' );


foreach ( $blogs as $blog ) {
    switch_to_blog( $blog['blog_id'] );
    $args = array(
        'hide_empty' => false
    );
    $categories = get_categories( $args );
    foreach (get_post_types() as $posttipo ) {
        if(!in_array($posttipo, $excluidos)){
        echo  "<option value='".$posttipo."'>".$posttipo."</option>";
}
        // printf( '<a href="%s" title="%s">%s</a> ', $link, $name, $name );
    }

}
switch_to_blog( $current->id );
?>
           <script>

           </script>
                     

                    </select>

                </div>

                <div class="form-group">

                    <label for="sel2"><strong>Filtre por um período</strong></label>

                    <select name="periodo" class="form-control" id="sel3">

                        <option value="">Todos os períodos</option>

                        <option value="1">Última hora</option>

                        <option value="24">Últimas 24 horas</option>

                        <option value="168">Última semana</option>

                        <option value="5040">Último mês</option>

                        <option value="1839600">Último ano</option>

                    </select>

                </div>

                <div class="form-group">

<label for="sel2"><strong>Filtre por ano</strong></label>

<select name="ano" class="form-control" id="sel3">
    <option value="">Todos os anos</option>
    <option value="2020">2020</option>
    <option value="2019">2019</option>
    <option value="2018">2018</option>
    <option value="2017">2017</option>
    <option value="2016">2016</option>
    <option value="2015">2015</option>
    <option value="2014">2014</option>
    <option value="2013">2013</option>
</select>

</div>

                <div class="form-group">
                    <script>
                    function limpaFiltro(){
                        setTimeout(() => {
                            window.location = window.location.pathname+"?s=";
                        }, 100);
                    }
                    </script>
                    <button onclick="limpaFiltro()"  type="button" class="btn btn-warning btn-sm float-left">Limpar filtros</button>
                    <button  type="submit" class="btn btn-primary btn-sm float-right">Refinar busca</button>

                </div>

            </span>

                               </div>

 

                </div>

</div>    </div>            
</form>              

<?php get_footer(); ?>