<?php
namespace Classes\TemplateHierarchy\LoopQuebrada;
class LoopQuebradaNoticiaPrincipal extends LoopQuebrada
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
						<div class="col-12">
							<div class="content-quebrada">
								<div class="row">
									<div class="col-12 col-md-5">
										<?php
											$arquivo = get_field('arquivo');
											if($arquivo){
												$type = get_post_mime_type($arquivo);
											}

											if($type == 'video/mp4'){
												echo do_shortcode('[videopack id="' . $arquivo . '"][/videopack]');
											} elseif ( has_post_thumbnail() ) {     
												$thumbId = get_post_thumbnail_id();
												$alt = get_post_meta($thumbId, '_wp_attachment_image_alt', true);

												echo '<img src="' . get_the_post_thumbnail_url(get_the_ID(),'full') . '" alt="' . $alt . '" class="thumb-post">';
											}
											
											
										?>
									</div>

									<div class="col-12 col-md-7">
										<div class="single-quebrada-infos d-flex align-content-between flex-wrap h-100">
											
											<div class="single-categ d-flex justify-content-between cuida-infos w-100">												
												<div class="quebrada-categs">
													<?php
														$categories = get_the_terms(get_the_ID(), 'categoria-quebrada');
														$separator = ' / ';
														$output = '';

														if ( ! empty( $categories ) ) {
															foreach( $categories as $category ) {
																$output .= '<a class="cuida-categ quebrada-categ" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
															}
															echo trim( $output, $separator );
														}
													?>
												</div>

												<div class="cuida-date">
													<?php echo get_the_date( 'd/m/Y \à\s H\hi' ); ?>
												</div>
																				
											</div>

											<div class="w-100 mb-3">
												<div class="primary-titile">
													<h1><?php the_title(); ?></h1>
													<?php
														$value = get_field( "insira_o_subtitulo", get_the_ID() );
														if($value){
															echo '<h3>' . $value . '</h3>';
														}
													?>
												</div>
												
												<?php the_content(); ?>
											</div>
											
											<div class="w-100 quebrada-user mb-4">
												<?php 
													$nome = get_field('nome');
													if(!$nome || $nome == ''){
														$nome = 'Turma do NAAPA';
													}
													echo 'por ' . $nome;
												?>
											</div>
											
											<div class="align-mobile">
												<div class="w-100 quebrada-likes likes-post mb-4">												
													<?php 
														global $wpdb;
														$l = 0;
														$postid = get_the_id();
														$clientip  = get_client_ip();
														$row1 = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid' AND clientip = '$clientip'");
														if(!empty($row1)){
															$l = 1;
														}
														$totalrow1 = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid'");
														$total_like1 = $wpdb->num_rows;
													?>

													<div class="post_like">
														<a class="pp_like <?php if($l==1) {echo "likes"; } ?>" href="#" data-id="<?php echo get_the_id(); ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></i> <span><?php echo $total_like1; ?> <?php echo $total_like1 == 1 ? 'like' : 'likes'; ?></span></a>	
													</div>
												</div>

												<div class="cuida-share w-100">
													<?php echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_tkbt"]'); ?>
												</div>
											</div>																						

										</div>

										
									</div>
								</div>
								
								
							</div>
							
						</div>						
					</div>
				</div>				

			<?php
				
			endwhile;
		endif;
		wp_reset_query();
	}
	
}
