<?php

namespace Classes\ModelosDePaginas\PaginaMaisNoticias;


class PaginaMaisNoticiasDestaques extends PaginaMaisNoticias
{
	private $destaque_principal;

	public function __construct()
	{

		$this->montaHtmlLoopMaisNoticiaPrincipal();	
		$this->montaTituloMaisNoticias();
		$this->montaQueryloopMaisNoticias();
	}

	
	public function montaHtmlLoopMaisNoticiaPrincipal()	{
		?>
		<div class="row mb-4">
		<?php
			$posts = get_field('mais_primeiro_destaque','option');
		
			if( $posts ): ?>
					<?php foreach( $posts as $p ): ?>
                    <section class="col-sm-12 rounded">
					        <article class="card h-100 rounded border-0">
                                <img class="rounded" src="<?php echo get_the_post_thumbnail_url( $p->ID ); ?>" width="100%">
                                <article style="max-height: 130px !important; margin-top: auto !important;" class="card-img-overlay bg-home-desc h-auto rounded-bottom container-img-noticias-destaques-primaria">
                                    <h3 class="fonte-catorze font-weight-bold">
                                        <a class="text-white" href="<?php echo get_permalink( $p->ID ); ?>">
											<?php echo get_the_title( $p->ID ); ?>

                                        </a>
                                    </h3>
                                    <section class="card-text text-white fonte-doze"><p class="mb-3 "><?php echo get_the_excerpt($p->ID ); ?></p></section>
                                </article>
                            </article>
                    </section>
					<?php endforeach; ?>
			<?php endif;
		wp_reset_postdata();
		?>
		</div>
		<?php

	}
	
	public function montaTituloMaisNoticias(){
		?>
		<div class="row mb-2">
			<div class="col-sm-12">
				<h3>RECENTES</h3>
			</div>
		</div>
		<?php
	}
	
	public function montaQueryloopMaisNoticias(){
		//pega ID do destaque e remove ele na query
		$dest_mais_noticias = get_field('mais_primeiro_destaque','option');
		if( $dest_mais_noticias ): ?>
					<?php foreach( $dest_mais_noticias as $dpimage ): ?>
					<?php endforeach; ?>
			<?php endif;
		wp_reset_postdata();
		
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		$new_query = new \WP_Query( array(
			'post_type' => 'post',
			'paged' => $paged,
			'orderby' => 'date',
			'order' => 'DESC',
			'posts_per_page' => 5,
			'post__not_in' => array( $dpimage->ID,  ),
		) );

		while ( $new_query->have_posts() ) : $new_query->the_post();  

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
							<span>Publicado em: <?php the_time('d/m/Y') ?> </span> 
							<?php /* - <span> em: <a href="<?php echo get_site_url(); ?>"><?php echo get_bloginfo('description'); ?></a></span> */ ?>
						</div>
					</div>
					<hr>
		<?php

		endwhile;
		
		?><div class="paginacao-atual"><?php
		echo paginate_links( array(
            'format'    => 'page/%#%',
            'current'   => $paged,
            'total'     => $new_query->max_num_pages,
            'mid_size'  => 2,
			'prev_text' => __('<<'),
            'next_text' => __('>>'),
        ) );
		?></div><?php
		
		wp_reset_postdata();
		
	}
	

}