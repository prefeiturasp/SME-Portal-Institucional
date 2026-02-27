<?php
/**
 * Plugin Name: Social Posts Shortcode
 * Description: Exibe os últimos posts do Facebook e Instagram via shortcode.
 * Version: 1.1
 * Author: Spassu Tecnologia
 */

define('SPS_PATH', plugin_dir_path(__FILE__));

require_once SPS_PATH . 'includes/helpers.php';
require_once SPS_PATH . 'includes/notifiers.php';
require_once SPS_PATH . 'includes/facebook.php';
require_once SPS_PATH . 'includes/instagram.php';