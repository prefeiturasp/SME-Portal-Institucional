<?php


namespace Classes\TemplateHierarchy\Search;


class SearchFormSingle
{
	public function __construct(){}

	public static function searchFormHeader(){
	    ?>
        <div class="col-lg-6 col-sm-6 d-flex justify-content-lg-end justify-content-center">
            <form action="<?php echo home_url( '/' ); ?>" method="get" class="navbar-form navbar-left" style="padding-top: 12px;">
                <input type="hidden" name="tipo" value="post">
                <fieldset>
                    <legend>Campo de Busca de informações</legend>
                    <div class="input-group mb-3">
                        <label class="esconde-item-acessibilidade" for="search-loop">Campo de Busca de informações</label>
                        <input type="text" id="search-loop"  name="s" placeholder="<?php _e(BUSCAR,"wpbootstrap"); ?>" value="<?php the_search_query(); ?>" class="form-control" />
                        <div class="input-group-append">
                            <button type="submit" class="btn bt-search-topo"><?php _e('<i class="fa fa-search"></i>','wpbootstrap'); ?></button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php
	}


}