<?php

class tutorial_create{
 
    function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }
 
    function admin_menu() {
        add_menu_page(
            __( 'Tutoriais', 'textdomain' ),//page title
            __( 'Tutoriais', 'textdomain' ),//menu title
            'manage_options',//Capability
            'tutorial_slug',//slug
            array(
                $this,
                'conteudo_tutorial'
            ),
			'dashicons-laptop',//icon
			3//position	
        );
    }
 
    function conteudo_tutorial() {
		echo '<hr> ';
		if( have_rows('cadastro_de_tutoriais','option') ):
			while ( have_rows('cadastro_de_tutoriais','option') ) : the_row();
			?>
			<div style="width: fit-content; display: inline-grid; padding: 10px; text-align: center; margin: 5px; border: solid 1px #000; height: 350px; overflow-y: scroll; max-width: 400px;">
					<h3><?php the_sub_field('nome_tutorial'); ?></h3>
				<?php
					if(get_sub_field('arquivo_tutorial') != ''){
						?>
						<video width="400" height="230" controls>
						  <source src="<?php the_sub_field('arquivo_tutorial'); ?>" type="video/mp4">
						</video>
						<?php
					}
				?>
					
					<p><?php the_sub_field('descricao_tutorial'); ?></p>
				<?php
					if(get_sub_field('botao_tutorial') != ''){
						?>
							<p><a href="<?php the_sub_field('botao_tutorial'); ?>"><button>Ver documentação</button></a></p>
						<?php
					}
				?>
					
			</div>
			<?php
			endwhile;
		else :
		endif;
    }
}
 
new tutorial_create;