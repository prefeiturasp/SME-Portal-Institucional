<?php

	if ( is_front_page() ) :

	    get_header( 'front' );

	else :

	    get_header();

	endif;

?>


<section class="bg-busca pt-5 pb-5" style="background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
	background: linear-gradient(0deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('<?php the_field('banner_busca','option');?>');">

	<div class="container">

		<div class="row">

			<div class="col-sm-12 mt-5 mb-5 text-center">

				<h1 class="mb-3"><?php the_field('titulo_busca','options'); ?></h1>

				<p><?php the_field('texto_busca','options'); ?></p>
				
				<div class="row">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<?php get_search_form(); ?>
					</div>
					<div class="col-sm-1"></div>
				</div>

			</div>

		</div>

	</div>

</section>

<main class="mt-5 mb-5">

	<section>

		<div class="container-fluid">

				<div class="col-sm-12">

					<h1 class="titulo-home text-center mt-5 mb-5">Temas</h1>

				</div>
			
		</div>
		
		<div class="container">
			


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