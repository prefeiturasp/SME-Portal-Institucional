<?php

function get_facebook_posts($limit = 3) {
    $page_id = getenv('FB_PAGE_ID');
    $access_token = getenv('FB_ACCESS_TOKEN');
    $cache_key = 'facebook_posts_cache_' . $page_id;
    $fallback_key = 'facebook_posts_fallback_' . $page_id;

    if (!$page_id || !$access_token) {
        sps_notify_api_failure_once('facebook', 'Credenciais ausentes (variáveis de ambiente).');
        return get_option($fallback_key) ?: [];
    }

    $cached = get_transient($cache_key);
    if ($cached !== false) return $cached;

    $url = "https://graph.facebook.com/v19.0/{$page_id}/posts?fields=id,message,permalink_url,attachments{media,type}&access_token={$access_token}&limit={$limit}";
    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        sps_notify_api_failure_once('facebook', 'Erro ao conectar com a API: ' . $response->get_error_message());
        sps_log_error('Facebook', $response->get_error_message());
        return get_option($fallback_key) ?: [];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['data'])) {
        sps_notify_api_failure_once('facebook', 'Resposta inválida da API do Facebook.');
        return get_option($fallback_key) ?: [];
    }

    set_transient($cache_key, $data['data'], HOUR_IN_SECONDS);
    update_option($fallback_key, $data['data']);
    delete_transient('facebook_api_error_notified');

    return $data['data'];
}

function render_facebook_posts($atts) {
    $atts = shortcode_atts(['numero' => 1], $atts);
    $index = max(0, min(2, intval($atts['numero']) - 1));

    $posts = get_facebook_posts(3);
    if (empty($posts) || !isset($posts[$index])) return '<p>Não foi possível carregar a publicação solicitada.</p>';

    $post = $posts[$index];
    $img = $post['attachments']['data'][0]['media']['image']['src'] ?? '';
    $link = esc_url($post['permalink_url']);

    $html = '<div class="facebook-post">';
    $html .= $img ? "<a href=\"$link\" target=\"_blank\"><img src=\"" . esc_url($img) . "\" style=\"max-width:100%;height:auto;\" /></a>" :
                    "<a href=\"$link\" target=\"_blank\">Ver publicação</a>";
    $html .= '</div>';

    return $html;
}

add_shortcode('facebook_posts', 'render_facebook_posts');