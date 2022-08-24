<?php    
    $texto = get_sub_field('texto_do_marcador');
    $latitude = get_sub_field('latitude');
    $longitude = get_sub_field('longitude');
    //MapLeaFlet
    wp_register_style( 'leaflet.css','https://unpkg.com/leaflet@1.6.0/dist/leaflet.css', null, '1.6.0', 'all' );
    wp_enqueue_style('leaflet.css');
    wp_register_script('leaflet.js', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.js', null, '1.6.0', false);
    wp_enqueue_script('leaflet.js');
    wp_register_script('mapsdre-leaflet.js', STM_THEME_URL . 'classes/assets/js/mapsdre-leaflet.js', array('jquery'), 1.0 ,false);
    wp_enqueue_script('mapsdre-leaflet.js');
?>
<a href="#map" class="story d-none" data-point="<?= $latitude; ?>,<?= $longitude; ?>,<?= $texto; ?>"> &nbsp;destacar no mapa</a>
<div id="map" style="min-height: 300px;"></div>