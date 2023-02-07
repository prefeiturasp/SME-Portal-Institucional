<?php
/*
 * Template Name: Construtor de páginas
 * Description: Modelo para construção de páginas dinamicas
 */

use Classes\ModelosDePaginas\Layout\Construtor;

$user = wp_get_current_user();
$rf = get_field('rf', 'user_' . $user->ID);
$email = $user->user_email;
$verifyEmail = explode('@', $email);

if($rf == $verifyEmail[0]){
    wp_redirect( home_url('index.php/perfil?atualizar=1') ); 
    exit;
}

get_header();
$Construtor = new Construtor();
//contabiliza visualizações de noticias
setPostViews(get_the_ID());  //echo getPostViews(get_the_ID());
get_footer();