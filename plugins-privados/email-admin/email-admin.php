<?php

/*
Plugin Name: Emails Admin Portal
Plugin URI: http://educacao.sme.prefeitura.sp.gov.br
Description: Envio de emails para admins para notícias e páginas pendentes.
Version: 1.0
Author: AMcom
Author URI: https://www.amcom.com.br
*/

function post_unpublished( $new_status, $old_status, $post ) {
    if (  $old_status == 'publish' && $new_status == 'pending' ) {
        
        if ( ! $post_type = get_post_type_object( $post->post_type ) )
        return;

        //if($post_type->labels->singular_name != 'Noticia' || $post_type->labels->singular_name != 'Página')
        //return;
        
        $emailto = array();

       
        $adminUsers = get_users('role=Administrator'); // Uuarios do tipo admin
        $editorUsers = get_users('role=Editor'); // Uuarios do tipo Editor       
        
        $portalusers = array_merge($adminUsers, $editorUsers); // todos os usuarios em um array
    
        // ultimo usuario que editou o post ou autor do post
        $lastAuthor = get_post_meta( get_the_ID(), '_edit_last', true );

        if($lastAuthor && $lastAuthor != ''){
            $grupos = get_field('grupo', 'user_' . $lastAuthor);

			$relation['relation'] = 'OR';
			foreach($grupos as $grupo){
				$relation[] = array(
					'key' => 'grupo',
					'value' => $grupo,
					'compare' => 'LIKE'
				);                
			}  
			
			$args = array(
				'role' => 'publicador', 
				'meta_query'=>array(
					'relation' => 'AND',         
						array(
							$relation
						),       
					
				)
			);

            $publiUsers = get_users( $args ); // Uuarios do tipo Colaborador Publicador

            if($publiUsers && $publiUsers[0] != ''){
                $portalusers = array_merge($portalusers, $publiUsers); // todos os usuarios em um array
            }
        }


        foreach ($portalusers as $user) {
            // Obtém o valor do campo emails_alerta
			$emails_alerta = get_field('emails_alerta', 'user_' . $user->ID);

			// Verifica se o campo não está ativado
			if (!$emails_alerta) {
				// Adiciona o usuário ao array
				$emailto[] = $user->user_email;
			}            
        }        
        

        // usuarios que nao receberao email
        $removeUser = array('ollyver.ottoboni@amcom.com.br', 'ollyverottoboni@gmail.com');

        $emailto = array_diff($emailto, $removeUser);
       
        if($post_type->labels->singular_name == 'Contatos SME' ){
            // Assunto do email"
            $subject = 'Um dos ' . $post_type->labels->singular_name . ' foi editado no portal.';

        } elseif($post_type->labels->singular_name == 'Cadastro de Concurso') {
            // Assunto do email"
            $subject = 'Um ' . $post_type->labels->singular_name . ' foi editado no portal.';

        } else {
            // Assunto do email"
            $subject = 'Uma ' . $post_type->labels->singular_name . ' foi editada no portal.';
        }

        //Link para editar
        $link = get_edit_post_link( $post->ID );
        $link = str_replace('&amp;' , '&', $link);

        if($post_type->labels->singular_name == 'Contatos SME' ){
            // Corpo do email
            $message = 'O Contato dentro de ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '"' . " foi editado no portal.\nPara visualizar as alterações acesse: " . get_permalink( $post->ID ) . "\nPara publicar acesse: " . $link;
        
        } elseif($post_type->labels->singular_name == 'Cadastro de Concurso') {
            // Corpo do email
            $message = 'O Concurso dentro do ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '"' . " foi editado no portal.\nPara visualizar as alterações acesse: " . get_permalink( $post->ID ) . "\nPara publicar acesse: " . $link;

        } else {
            // Corpo do email
            $message = 'A ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '"' . " foi editada no portal.\nPara visualizar as alterações acesse: " . get_permalink( $post->ID ) . "\nPara publicar acesse: " . $link;
            //$message .= "\n\n" . implode(",", $emailto);
        }

        //$emailto2 = '';

        wp_mail( $emailto, $subject, $message );
        
    }

    if (  ($old_status == 'draft' && $new_status == 'pending') || ($old_status == 'auto-draft' && $new_status == 'pending') ) {
        
        if ( ! $post_type = get_post_type_object( $post->post_type ) )
        return;

        //if($post_type->labels->singular_name != 'Noticia' || $post_type->labels->singular_name != 'Página')
        //return;
        
        $emailto = array();

       
        $adminUsers = get_users('role=Administrator'); // Uuarios do tipo admin
        $editorUsers = get_users('role=Editor'); // Uuarios do tipo Editor        
        
        $portalusers = array_merge($adminUsers, $editorUsers); // todos os usuarios em um array
    
        // ultimo usuario que editou o post ou autor do post
        $lastAuthor = get_post_meta( get_the_ID(), '_edit_last', true );

        if($lastAuthor && $lastAuthor != ''){
            $grupos = get_field('grupo', 'user_' . $lastAuthor);

			$relation['relation'] = 'OR';
			foreach($grupos as $grupo){
				$relation[] = array(
					'key' => 'grupo',
					'value' => $grupo,
					'compare' => 'LIKE'
				);                
			}  
			
			$args = array(
				'role' => 'publicador', 
				'meta_query'=>array(
					'relation' => 'AND',         
						array(
							$relation
						),       
					
				)
			);

            $publiUsers = get_users( $args ); // Uuarios do tipo Colaborador Publicador

            if($publiUsers && $publiUsers[0] != ''){
                $portalusers = array_merge($portalusers, $publiUsers); // todos os usuarios em um array
            }
        }

        foreach ($portalusers as $user) {
            // Obtém o valor do campo emails_alerta
			$emails_alerta = get_field('emails_alerta', 'user_' . $user->ID);

			// Verifica se o campo não está ativado
			if (!$emails_alerta) {
				// Adiciona o usuário ao array
				$emailto[] = $user->user_email;
			}
        }        
        

        // usuarios que nao receberao email
        $removeUser = array('ollyver.ottoboni@amcom.com.br', 'ollyverottoboni@gmail.com');

        $emailto = array_diff($emailto, $removeUser);
       
        if($post_type->labels->singular_name == 'Contatos SME' ){
            // Assunto do email"
            $subject = 'Um dos ' . $post_type->labels->singular_name . ' foi editado no portal.';

        } elseif($post_type->labels->singular_name == 'Cadastro de Concurso') {
            // Assunto do email"
            $subject = 'Um ' . $post_type->labels->singular_name . ' foi editado no portal.';

        } else {
            // Assunto do email"
            $subject = 'Uma ' . $post_type->labels->singular_name . ' foi editada no portal.';
        }

        //Link para editar
        $link = get_edit_post_link( $post->ID );
        $link = str_replace('&amp;' , '&', $link);

        if($post_type->labels->singular_name == 'Contatos SME' ){
            // Corpo do email
            $message = 'O Contato dentro de ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '"' . " foi editado no portal.\nPara visualizar as alterações acesse: " . get_permalink( $post->ID ) . "\nPara publicar acesse: " . $link;
        
        } elseif($post_type->labels->singular_name == 'Cadastro de Concurso') {
            // Corpo do email
            $message = 'O Concurso dentro do ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '"' . " foi editado no portal.\nPara visualizar as alterações acesse: " . get_permalink( $post->ID ) . "\nPara publicar acesse: " . $link;

        } else {
            // Corpo do email
            $message = 'A ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '"' . " foi editada no portal.\nPara visualizar as alterações acesse: " . get_permalink( $post->ID ) . "\nPara publicar acesse: " . $link;
            //$message .= "\n\n" . implode(",", $emailto);
            //$message .= "\n\n" . $new_status;
        }

        //$emailto2 = '';

        wp_mail( $emailto, $subject, $message );
        
    }
}
add_action( 'transition_post_status', 'post_unpublished', 100, 3 );