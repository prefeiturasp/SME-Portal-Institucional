<?php

function sps_notify_api_failure_once($platform, $custom_message = null) {
    $transient_key = "{$platform}_api_error_notified";
    if (get_transient($transient_key)) return;

    $admin_email = get_option('admin_email');
    $subject = "Erro ao acessar a API do " . ucfirst($platform);
    $message = $custom_message ?: "O plugin não conseguiu obter novos posts do $platform.";
    $message .= "\n\nHora do erro: " . current_time('mysql');

    wp_mail($admin_email, $subject, $message);
    set_transient($transient_key, true, 12 * HOUR_IN_SECONDS);
}

add_action('admin_notices', function () {
    foreach (['facebook', 'instagram'] as $platform) {
        if (get_transient("{$platform}_api_error_notified")) {
            echo '<div class="notice notice-error is-dismissible">';
            echo "<p><strong>Erro ao acessar a API do " . ucfirst($platform) . ":</strong> o site está usando posts armazenados como backup. Verifique as credenciais no painel do desenvolvedor.</p>";
            echo '</div>';
        }
    }
});