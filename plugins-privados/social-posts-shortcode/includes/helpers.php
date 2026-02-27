<?php

function sps_log_error($context, $message) {
    if (!WP_DEBUG_LOG) return;

    $log = '[' . current_time('mysql') . "] [$context] $message\n";
    error_log($log, 3, plugin_dir_path(__DIR__) . 'debug-social-posts.log');
}