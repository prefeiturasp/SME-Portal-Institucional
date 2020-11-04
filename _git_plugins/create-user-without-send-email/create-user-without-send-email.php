<?php
/*
  Plugin Name: SME Novo Usuario
  Plugin URI: http://www.mooveagency.com
  Description: Criar usuario sem enviar email padrao
  Version: 1.0.1.
  Author: AMCOM
  Author URI: http://www.mooveagency.com
  License: GPLv2
  Text Domain: create-user-withou-send-email
 */

// no need on cron job
if (defined('DOING_CRON') || isset($_GET['doing_wp_cron'])) {
    return;
}


if (!is_multisite()) {
    return false;
}

// fire in administration only
if (is_admin()) {
    require_once('php/cuwp.php');
    $mdu = new CUWP_Create_User_With_Password();
}

/**
 * Install
 */
function cuwp_activate()
{
    /*
    // store old message in option
    $old_message = get_site_option('welcome_user_email');
    update_option('cuwp_welcome_user_email', $old_message);

    // set new message
    $text_var = 'Dear User, \n' . 'Thank you for the registration. Please check the email address provided for login details. \n' . '--The Team @ SITE_NAME \n';
    $text = __($text_var, 'create-user-with-password-multisite');

    update_site_option('welcome_user_email', $text);
    */
}

register_activation_hook(__FILE__, 'cuwp_activate');

/**
 * Deactivation
 */
function cuwp_deactivate()
{
    // set old message back
    $old_message = get_option('cuwp_welcome_user_email');
    update_site_option('welcome_user_email', $old_message);

    // delete option with the message
    delete_option('cuwp_welcome_user_email');
}

register_deactivation_hook(__FILE__, 'cuwp_deactivate');


