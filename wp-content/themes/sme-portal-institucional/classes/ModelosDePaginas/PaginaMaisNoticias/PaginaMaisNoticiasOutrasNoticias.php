<?php

namespace Classes\ModelosDePaginas\PaginaMaisNoticias;


class PaginaMaisNoticiasOutrasNoticias extends PaginaMaisNoticias
{
	private $args_outras_noticias;
	private $query_outras_noticias;

	public function __construct()
	{
		$this->queryOutrasNoticias();
		$this->montaHtmlOutrasNoticias();
	}

	public function queryOutrasNoticias(){
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$this->args_outras_noticias = array(
			'post_type' => 'post',
			'posts_per_page'=> 5,
			'paged'=> $paged,
			'exclude' => PaginaMaisNoticiasArrayIdNoticias::getArrayIdNoticias(),
		);

		$this->query_outras_noticias = get_posts($this->args_outras_noticias);
	}

	public function montaHtmlOutrasNoticias(){

		$container_mais_noticias_tags = array( 'section');
		$container_mais_noticias_css = array('col-lg-8 col-sm-12 mt-5');
		$this->abreContainer($container_mais_noticias_tags, $container_mais_noticias_css);
		echo '<p class="fonte-vintequatro mb-4 pb-2 font-weight-bold"><a class="text-dark" href="#" id="outrasNoticias">OUTRAS NOTÍCIAS</a></p>';

		foreach ($this->query_outras_noticias as $query){

		    PaginaMaisNoticiasArrayIdNoticias::setArrayIdNoticias($query->ID)
			?>
			<section class="row mb-5">
				<article class="col-lg-12">
					<?php
					$thumb = get_the_post_thumbnail_url($query->ID);
					$url = get_the_permalink($query->ID);
					if ($thumb){
						echo '<figure class=" m-0">';
						echo '<img src="'.$thumb.'" class="img-fluid rounded float-left mr-4 w-25" alt="'.$query->post_title.'"/>';
						echo '</figure>';
					}
					?>
					<h4 class="fonte-dezoito font-weight-bold mb-2">
						<a class="text-decoration-none text-dark" href="<?= $url ?>">
							<?= $query->post_title ?>
						</a>
					</h4>
                    <?php
                    echo $this->getSubtitulo($query->ID, 'p')
                    ?>

				</article>
			</section>
			<?php
		}

		$this->paginacao_mais_noticias($this->query_outras_noticias);

		$this->fechaContainer($container_mais_noticias_tags);

	}

	public function paginacao_mais_noticias( $wp_query = null, $echo = true ) {
		if ( null === $wp_query ) {
			global $wp_query;
		}

		$posts_para_excluir_da_lista = count(PaginaMaisNoticiasArrayIdNoticias::getArrayIdNoticias());
		$published_posts = (wp_count_posts()->publish)-$posts_para_excluir_da_lista;
		$posts_per_page = 5;
		$page_number_max = ceil($published_posts / $posts_per_page);

		$pages = paginate_links( [
				'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'format'       => '?paged=%#%',
				'current'      => max( 1, get_query_var( 'paged' ) ),
				'total'        => $page_number_max,
				'type'         => 'array',
				'show_all'     => false,
				'end_size'     => 0,
				'mid_size'     => 2,
				'prev_next'    => true,
				'prev_text'    => __( '«' ),
				'next_text'    => __( '»' ),
				'add_args'     => false,
				'add_fragment' => '#outrasNoticias'
			]
		);
		if ( is_array( $pages ) ) {

			$pagination = '<div class="pagination"><ul class="pagination">';

			foreach ($pages as $page) {
				$pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
			}
			$pagination .= '</ul></div>';
			if ( $echo ) {
				echo $pagination;
			} else {
				return $pagination;
			}
		}
		return null;
	}

}