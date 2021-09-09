<?php

/*
Plugin Name: Emails Admin NAAPA
Plugin URI: http://educacao.sme.prefeitura.sp.gov.br
Description: Envio de emails para admins para notícias e páginas pendentes.
Version: 1.0
Author: AMcom
Author URI: https://www.amcom.com.br
*/

function post_unpublished( $new_status, $old_status, $post ) {
    if ( $new_status == 'pending' ) {
        
        if ( ! $post_type = get_post_type_object( $post->post_type ) )
        return;

       
        if($post_type->labels->singular_name == 'Na Quebrada' ){
            // Assunto do email"
            $subject = 'Uma nova publicação "O que rola na quebrada" foi adicionada no portal';
        } 

        //Link para editar
        $link = get_edit_post_link( $post->ID );
        $link = str_replace('&amp;' , '&', $link);

        if($post_type->labels->singular_name == 'Na Quebrada' ){
            // Corpo do email
            $message = 'A publicação "' . get_the_title($post->ID) . '"' . " foi adicionada ao portal.\nPara visualizar a publicação acesse: " . get_permalink( $post->ID ) . "\nPara publicar no portal acesse: " . $link;
            $emailto2 = 'felipe.almeida@amcom.com.br';
            wp_mail( $emailto2, $subject, $message );
        } 

        
        
    }
}
add_action( 'transition_post_status', 'post_unpublished', 100, 3 );