<?php

/*
Plugin Name: Emails Admin CEUs
Plugin URI: http://educacao.sme.prefeitura.sp.gov.br
Description: Envio de emails para admins em eventos e unidades pendentes.
Version: 1.0
Author: AMcom
Author URI: https://www.amcom.com.br
*/

function post_unpublished( $new_status, $old_status, $post ) {
    if ( ($old_status == 'publish' || $old_status =='new')  &&  $new_status == 'pending' ) {
        
        if ( ! $post_type = get_post_type_object( $post->post_type ) )
        return;
        
        $emailto = array();
        
        $adminUsers = get_users('role=Administrator'); // Uuarios do tipo admin

        if ( $id = get_post_meta(get_the_id(), '_edit_last', true ) ){
            $grupoUser = get_field('grupo', 'user_' . $id);  
        }

        if($grupoUser && $grupoUser != ''){
            foreach($grupoUser as $grupo){
                $relation[] = array(
                    'key' => 'grupo',
                    'value' => $grupo,
                    'compare' => 'LIKE'
                );
            }
        }

        $args = array(
            'role' => 'editor',
            'meta_query'=>array(
    
                array(
    
                    'relation' => 'AND',

                    array(
                        'relation' => 'OR',
                        $relation
                    ),
                
                )
            )
        );    
        
        $editorUsers = get_users( $args ); // Uuarios do tipo Editor        
        
        if($editorUsers && $editorUsers != ''){
            $portalusers = array_merge($adminUsers, $editorUsers); // todos os usuarios em um array
        } else {
            $portalusers = $adminUsers; 
        }
        
       
        foreach ($portalusers as $user) {
            $emailto[] = $user->user_email;
        }

        // usuarios que nao receberao email
        $removeUser = array('ollyver.ottoboni@amcom.com.br', 'ollyverottoboni@gmail.com', 'felipe.almeida@amcom.com.br');

        $emailto = array_diff($emailto, $removeUser);
       
        // Assunto do email"
        $subject = 'O ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '"' . ' foi editada no portal.';

        //Link para editar
        $link = get_edit_post_link( $post->ID );
        $link = str_replace('&amp;' , '&', $link);

        // Corpo do email
        $message = 'O ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '"' . " foi editado no portal.\nPara visualizar as alterações acesse: " . get_permalink( $post->ID ) . "\nPara publicar acesse: " . $link;

        // evia o email
        wp_mail( $emailto, $subject, $message );
    }
}
add_action( 'transition_post_status', 'post_unpublished', 10, 3 );