<?php
namespace Classes\TemplateHierarchy\LoopCuida;
class LoopCuidaNoticiaPrincipal extends LoopCuida
{
	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		$this->montaHtmlNoticiaPrincipal();
	}
	public function montaHtmlNoticiaPrincipal(){
		if (have_posts()):
			while (have_posts()): the_post();
				
			?>
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-8">
							<div class="single-cuida-title">
								<div class="single-categ">
									<?php
										$categories = get_the_terms(get_the_ID(), 'categoria-cuida');
										$separator = ' / ';
										$output = '';

										if ( ! empty( $categories ) ) {
											foreach( $categories as $category ) {
												$output .= '<a class="cuida-categ" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
											}
											echo trim( $output, $separator );
										}
									?>									
								</div>
								<div class="primary-titile">
									<h1><?php the_title(); ?></h1>
									<?php
										$value = get_field( "insira_o_subtitulo", get_the_ID() );
										if($value){
											echo '<h3>' . $value . '</h3>';
										}
									?>
								</div>
								<div class="d-flex justify-content-between cuida-infos">									
									<div class="cuida-date">
										Publicado em: <?php echo get_the_date( 'd/m/Y \à\s H\hi' ); ?>
									</div>
									<div class="cuida-share">
										<?php echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_tkbt"]'); ?>
									</div>
								</div>
							</div>
							<?php
								if ( has_post_thumbnail() ) {     
									$thumbId = get_post_thumbnail_id();
									$alt = get_post_meta($thumbId, '_wp_attachment_image_alt', true);

									echo '<img src="' . get_the_post_thumbnail_url(get_the_ID(),'default-image') . '" alt="' . $alt . '" class="thumb-post">';
								}
							
								the_content(); 
							?>

							<div class="cuida-relateds">
								<?php
									//Get array of terms
									$terms = get_the_terms( get_the_ID() , 'categoria-cuida', 'string');
									//Pluck out the IDs to get an array of IDS
									$term_ids = wp_list_pluck($terms,'term_id');

									//Query posts with tax_query. Choose in 'IN' if want to query posts with any of the terms
									//Chose 'AND' if you want to query for posts with all terms
									$second_query = new \WP_Query( array(
										'post_type' => 'quem-cuida',
										'tax_query' => array(
														array(
															'taxonomy' => 'categoria-cuida',
															'field' => 'id',
															'terms' => $term_ids,
															'operator'=> 'IN' //Or 'AND' or 'NOT IN'
														)),
										'posts_per_page' => 3,
										'ignore_sticky_posts' => 1,
										'orderby' => 'rand',
										'post__not_in'=>array(get_the_ID())
									) );

									//Loop through posts and display...
										if($second_query->have_posts()) {
											echo '<p class="related-title">VOCÊ PODE CURTIR TAMBÉM</p>';

											while ($second_query->have_posts() ) : $second_query->the_post(); ?>
											<div class="row mx-0 cuida-list-item">
												<div class="col-12 col-md-4">
													<?php $thumbs = get_thumb(get_the_ID(), 'cuida-news'); ?>
													<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid"></a>
												</div>
												<div class="col-12 col-md-8">
													<?php
														$categories = get_the_terms(get_the_ID(), 'categoria-cuida');
														$separator = ' / ';
														$output = '';
													?>
													<div class="d-flex justify-content-between cuida-infos">
														<div class="cuida-categs">
															<?php
																if ( ! empty( $categories ) ) {
																	foreach( $categories as $category ) {
																		$output .= '<a class="cuida-categ" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
																	}
																	echo trim( $output, $separator );
																}
															?>
														</div>
														<div class="cuida-date">
															<?php echo get_the_date( 'd/m/Y \à\s H\hi' ); ?>
														</div>
													</div>
													<h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
													<?php
														$sub = get_field( "insira_o_subtitulo", get_the_ID() );
														if($sub){
															echo "<p>" . $sub . "</p>";
														} else {
															echo "<p>" . get_the_excerpt() . "</p>";
														}
													?>													
												</div>                    
											</div>
											<?php endwhile; wp_reset_query();
										}

								?>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<?php dynamic_sidebar('quem-cuida'); ?>
						</div>
					</div>
				</div>				

			<?php
				
			endwhile;
		endif;
		wp_reset_query();
	}
	
}
