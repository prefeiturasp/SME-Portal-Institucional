<?php get_header(); ?>

	<div class="container">

		<div class="container">	

			<div class="row px-0">
				<div class="cuida-filters filter-search">
					<p>filtrar por:</p>
					<div class="filter-list">
						<?php
							
							if($_GET['filter'] && $_GET['filter'] != ''){
								$active = $_GET['filter'];
							}
							function retornaNome($type){
								if($type == 'post'){
									return 'SE LIGA!';
								} elseif($type == 'page') {
									return 'PÁGINA';
								} elseif($type == 'quem-cuida') {
									return 'PARA QUEM CUIDA';
								} elseif($type == 'na-quebrada') {
									return 'O QUE ROLA NA QUEBRADA';
								}
							}

							$terms = array('post', 'page', 'quem-cuida', 'na-quebrada');
							$current = get_home_url();
							foreach($terms as $term):
								if($active == $term):
								?>        
									<a href="<?php echo $current;?>?s=<?php echo $_GET['s']; ?>" class="filter-link filter-active type-<?php echo $term; ?>"><i class="fa fa-check" aria-hidden="true"></i> <?php echo retornaNome($term); ?></a>                       
								
								<?php else: ?>
									<a href="<?php echo $current . '?s=' . $_GET['s'] . '&filter=' . $term;?>" class="filter-link type-<?php echo $term; ?>"><?php echo retornaNome($term); ?></a> 
								<?php
								endif;
							endforeach; ?>

					</div>
				</div>
			</div> 

			<div class="row">
				<div class="col-md-8">
					<div id="ajax-posts" class="row">
						<?php
							
							$paged = 1;
							if ( get_query_var('paged') ) $paged = get_query_var('paged');
							if ( get_query_var('page') ) $paged = get_query_var('page');

							if($_GET['filter']){
								$postType = $_GET['filter'];
							} else {
								$postType = array('post', 'page', 'quem-cuida', 'na-quebrada');
							}
							
							$args = array(
								'post_type' => $postType,
								's' => $_GET['s'],
								'paged' => $paged,
								'orderby' => 'date',
            					'order'   => 'DESC',
								'posts_per_page' => 10,
							);
							$loop = new WP_Query($args);

							while ($loop->have_posts()) : $loop->the_post();
								$type = get_post_type();
						?>

							<div class="row mx-0 cuida-list-item type-<?php echo $type; ?>">
								<div class="col-12 col-md-4">
									<?php $thumbs = get_thumb(get_the_ID(), 'cuida-news'); ?>
									<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid"></a>
								</div>
								<div class="col-12 col-md-8">
									<?php										
										if($type == 'post'){
											$categories = get_the_terms(get_the_ID(), 'category');
										} elseif($type == 'quem-cuida'){
											$categories = get_the_terms(get_the_ID(), 'categoria-cuida');
										}
										
										$separator = ' / ';
										$output = '';
									?>
									<div class="d-flex justify-content-between cuida-infos">
										<div class="cuida-categs liga-categs">
											<?php
												if($type == 'na-quebrada'){
													$output = '';
													$categories = '';
													echo '<a href="' . get_the_permalink(423) . '">O QUE ROLA NA QUEBRADA</a>';
												}

												if($type == 'page'){
													$output = '';
													$categories = '';
													echo "Página: " . get_the_title();
												}

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

									<?php if($type == 'page'): ?>
										<h2><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_excerpt();?></a></h2>
										
									<?php else: ?>
										<h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); echo " - " . get_post_type();?></a></h2>
										<?php
											$sub = get_field( "insira_o_subtitulo", get_the_ID() );
											if($sub){
												echo "<p>" . $sub . "</p>";
											} else {
												echo "<p>" . get_the_excerpt() . "</p>";
											}
										?>
									<?php endif; ?>
								</div>                    
							</div>

						<?php
								endwhile;
						wp_reset_postdata();
						?>
					</div>

					<button id="more_busca">Veja mais</button>
				</div>
			</div>
		</div>
		
		<div class="container mt-4">
			<?php $personagens = get_field('personagens','conf-turma'); ?>
			<div class="row">
				<div class="col-12">
					<div class="turma-naapa">
						<div class="title-special d-flex align-items-center justify-content-between">
							<h2 style="border-color: #FFC701;">A turma do NAAPA</h2>
						</div>

						<div class="tab">

							<ul class="tabs row">
								<?php foreach($personagens as $personagen): ?>
									<li class="col">
										<a href="#"><img src="<?php echo wp_get_attachment_url( $personagen['imagem_do_personagem'] ); ?>" class="img-fluid"></a>
									</li>
								<?php endforeach; ?>                        
							</ul>
							<!-- / tabs -->

							<div class="tab_content mb-0">
								
								<?php foreach($personagens as $personagen): ?>
									<div class="tabs_item">
										<div class="row">
											<div class="col-md-7">
											<img src="<?php echo wp_get_attachment_url( $personagen['imagem_do_texto'] ); ?>" class="img-fluid">
											</div>
											<div class="col-md-4 d-flex align-items-center">
												<div class="turma-text">
													<div class="turma-title"><?php echo $personagen['nome_do_personagem']; ?></div>
													<div class="turma-descri">
														<?php echo $personagen['descritivo_do_personagem']; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- / tabs_item -->
								<?php endforeach; ?>

							</div>
							<!-- / tab_content -->
						</div>
						<!-- / tab -->
					</div>
				</div>
			</div>

		</div>

		
		<div class="container mt-4">
			<div class="row">
				<div class="col-sm-12">
					<div class="pagination-prog text-center">
						<?php //wp_pagenavi( array( 'query' => $query ) ); ?>
					</div>
				</div>
			</div>
		</div>
		

		<br><br>
	</div>

<?php get_footer();