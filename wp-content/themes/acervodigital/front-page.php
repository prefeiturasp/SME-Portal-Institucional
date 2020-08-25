<?php
	if ( is_front_page() ) :
	    get_header( 'front' );
	else :
	    get_header();
	endif;
?>
<section class="bg-busca" style="background: linear-gradient(0deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('<?php the_field('banner_busca','option');?>');">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1><?php the_field('titulo_busca','options'); ?></h1>
				<p><?php the_field('texto_busca','options'); ?></p>
			</div>
		</div>
	</div>
</section>
<main class="mt-5 mb-5">
	<section>
		<div class="container-fluid">
				<div class="col-sm-12">
					<h2 class="mt-3 mb-3">Últimos documentos adicionados</h2>
				</div>	
			<div class="row">
				<?php 
				$terms = get_field('categorias_home' , 'options');
				if( $terms ): ?>
				    <?php foreach( $terms as $term ): ?>
				    	<div class="col-sm-2 cat-home">
				    		<div style="background: url('<?php the_field('banner_busca','option');?>'); ">
					    		<div class="cat-home-inter">
							        <a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
							        	<?php echo esc_html( $term->name ); ?>	
							        </a>
						        </div>
					        </div>
				        </div>
				    <?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>