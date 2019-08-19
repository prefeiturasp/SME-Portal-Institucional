<?php

namespace Classes\TemplateHierarchy\Search;


class LoopSearch
{
	protected $search;
	protected $argsSearch;
	protected $querySearch;

	public function __construct()
	{
		$this->search = get_query_var('s');
		$this->montaTituloBusca();
		$this->montaQuerySearch();
		$this->montaHtmlSearch();

	}


	public function montaTituloBusca()
	{
		?>
        <div class="container padding-top-15 padding-bottom-30">
            <div class="row">
                <h2 style="margin-left: 15px;">
                    <i class="fa fa-search-plus"></i> Resultados da pesquisa para "<?= $this->search ?>"</h2>
            </div>
        </div>
		<?php
	}

	public function montaQuerySearch()
	{

		$this->argsSearch = array(
			'post_type' => array('post','page'),
			'post_parent' => 0,
			'paged' => get_query_var('paged'),
			's' => $this->search,
		);

		$this->querySearch = new \WP_Query($this->argsSearch);
	}

	public function montaHtmlSearch()
	{
		?>

        <div class="container">

			<?php if ($this->querySearch->have_posts()) :

				while ($this->querySearch->have_posts()) : $this->querySearch->the_post(); ?>

                    <div class="row mb-4">
                        <div class="col-lg-12 pb-4 border-bottom">
							<?php

					        if (has_post_thumbnail()){
								echo '<figure class=" m-0">';
								the_post_thumbnail('medium', array('class' => 'img-fluid rounded float-left mr-4 w-25'));
								echo '</figure>';
							}
							?>
                            <h4 class="fonte-dezoito font-weight-bold mb-2">
                                <a class="text-decoration-none text-dark" href="<?php the_permalink() ?>">
									<?= get_the_title(); ?>
                                </a>
                            </h4>
                            <p class="fonte-dezesseis mb-2">
								<?php the_excerpt(); ?>
                            </p>

                            <div class="col-12">
                                <a class="btn btn-primary" href="<?php the_permalink(); ?>"><?php echo VEJAMAIS ?></a>
                            </div>

                        </div>
                    </div>

				<?php
                    endwhile;
				else:
                $this->montaHtmlNenhumPostEncontrado();
            endif;

			wp_reset_postdata();
			?>
            <br/>

			<?php paginacao($this->querySearch); ?>

            <div class="row container-taxonomias padding-bottom-15">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <a class="btn btn-primary" href="javascript:history.back();"><< Voltar</a>
                </div>
            </div>

        </div>

		<?php
	}

	public function montaHtmlNenhumPostEncontrado(){
	    ?>

        <div class="container">
            <div class="row">
                <h3 class="cem-porcento"><i class="fa fa-exclamation-triangle"></i> Nenhum resultado encontrado para "<?= $this->search ?>".</h3>
                <h3 class="cem-porcento">Tente uma pesquisa diferente ou utilize o menu acima para navegar.</h3>
                <br/>

                <?php SearchForm::searchFormLoopSearch() ?>

            </div>
        </div>

        <?php
    }



}