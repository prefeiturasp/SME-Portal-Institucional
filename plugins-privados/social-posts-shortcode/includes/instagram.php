<?php

function get_instagram_posts($limit = 3) {
    $user_id = getenv('IG_USER_ID');
    $access_token = getenv('IG_ACCESS_TOKEN');
    $cache_key = 'instagram_posts_cache_' . $user_id;
    $fallback_key = 'instagram_posts_backup';

    if (!$user_id || !$access_token) {
        sps_notify_api_failure_once('instagram', 'Credenciais ausentes (variáveis de ambiente).');
        return get_option($fallback_key) ?: [];
    }

    $cached = get_transient($cache_key);
    if ($cached !== false) return $cached;

    $url = "https://graph.facebook.com/v19.0/{$user_id}/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,timestamp&access_token={$access_token}&limit={$limit}";
    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        sps_notify_api_failure_once('instagram', 'Erro ao conectar com a API: ' . $response->get_error_message());
        sps_log_error('Instagram', $response->get_error_message());
        return get_option($fallback_key) ?: [];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['data'])) {
        sps_notify_api_failure_once('instagram', 'Resposta inválida da API do Instagram.');
        return get_option($fallback_key) ?: [];
    }

    set_transient($cache_key, $data['data'], HOUR_IN_SECONDS);
    update_option($fallback_key, $data['data']);
    delete_transient('instagram_api_error_notified');

    return $data['data'];
}

function render_instagram_posts($atts) {
    $atts = shortcode_atts(['numero' => 1], $atts);
    $index = max(0, min(2, intval($atts['numero']) - 1));

    $posts = get_instagram_posts(3);
    if (empty($posts) || !isset($posts[$index])) return '<p>Publicação não encontrada.</p>';

    $post = $posts[$index];
    $img = ($post['media_type'] === 'VIDEO' && isset($post['thumbnail_url'])) ? $post['thumbnail_url'] : ($post['media_url'] ?? '');
    $link = esc_url($post['permalink']);

    if (!$img) return '<p>Publicação não contém imagem.</p>';

    $html = '<div class="instagram-post">';
    $alt = isset($post['caption']) ? esc_attr($post['caption']) : 'Post do Instagram';
    $html .= "<a href=\"$link\" target=\"_blank\"><img src=\"$img\" alt=\"$alt\" style=\"aspect-ratio: 4/5; width: 100%; height: auto; object-fit: cover;\" /></a>";
    $html .= '</div>';

    return $html;
}

add_shortcode('instagram_posts', 'render_instagram_posts');