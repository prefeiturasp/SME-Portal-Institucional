<?php
/*
Plugin Name: Emails de Inscrição
Plugin URI: http://educacao.sme.prefeitura.sp.gov.br
Description: Envio de emails para inscricoes nos ecentos.
Version: 1.0
Author: AMcom
Author URI: https://www.amcom.com.br
*/

function post_unpublished( $new_status, $old_status, $post ) {
    if ( $new_status == 'pending' ) {
        
        if ( ! $post_type = get_post_type_object( $post->post_type ) )
        return;

       
        if($post_type->labels->singular_name == 'Inscrições' ){
            // Assunto do email"
            $subject = $_POST['user_inscri'] . ", sua solicitação de inscrição foi enviada!";
        } 

        //Link para editar
        $link = get_edit_post_link( $post->ID );
        $link = str_replace('&amp;' , '&', $link);

        if($post_type->labels->singular_name == 'Inscrições' ){
            // Corpo do email
            $message = "Prezado(a) " . $_POST['user_inscri'] . ",<br><br>";

            $message .= "Recebemos a sua inscrição para o evento <strong>" . get_the_title($post->ID) . "</strong>, com solicitação de visita a ser realizada em <strong>" . $_POST['data_hora'] . "</strong> com <strong>" . $_POST['estudantes'] . "</strong> estudantes. A solicitação já foi enviada para a área responsável e, em breve, enviaremos o retorno.<br><br>";

            $message .= "<strong>Importante: esse não é um e-mail de confirmação da Visita. Aguarde o contato de DICEU para esta confirmação.</strong><br><br>";

            $message .= "Atenciosamente,<br>";
            $message .= "Equipe Visitas Monitoradas<br><br>";

            $message .= "<img src='https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/logo-visitas.png' alt='Logo Visitas Monitoradas'>";

                        
            //$emailto2 = 'felipe.almeida@amcom.com.br';
            $emailto = $_POST['email_resp'];
            $content_type = function() { return 'text/html'; };
            add_filter( 'wp_mail_content_type', $content_type );
            wp_mail( $emailto, $subject, $message );
            remove_filter( 'wp_mail_content_type', $content_type );
        } 
        
    }
}
add_action( 'transition_post_status', 'post_unpublished', 10, 3 );