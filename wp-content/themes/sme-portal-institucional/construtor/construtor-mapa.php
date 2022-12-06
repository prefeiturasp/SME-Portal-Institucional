<?php    
    $mapas = get_sub_field('mapas');
    //MapLeaFlet
    wp_register_style( 'leaflet.css','https://unpkg.com/leaflet@1.6.0/dist/leaflet.css', null, '1.6.0', 'all' );
    wp_enqueue_style('leaflet.css');
    wp_register_script('leaflet.js', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.js', null, '1.6.0', false);
    wp_enqueue_script('leaflet.js');    
?>
<script>

window.onload = function() {

    <?php foreach($mapas as $key => $mapa): ?>
	
        //seta coordenadas inicial do mapa pegando o primeiro valor da lista de contatos
        var latlng<?= $key; ?> = jQuery('.story<?= $key; ?>').data().point.split(',');
        var lat<?= $key; ?> = latlng<?= $key; ?>[0];
        var lng<?= $key; ?> = latlng<?= $key; ?>[1];

        map<?= $key; ?> = L.map('map<?= $key; ?>', { center: [lat<?= $key; ?>, lng<?= $key; ?>], zoom: 17 });

        //monta a imagem do mapa
        L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        subdomains: ['a', 'b', 'c']
        }).addTo( map<?= $key; ?> )

        //adiciona marcadores iniciais dos contatos
        jQuery('.story<?= $key; ?>').each(function(i) {
            if (jQuery(this).attr('data-point') != null + i + 1) {
                    
                jQuery(this).each(function() {
                    //console.log(jQuery(this).attr('data-point'));
                    
                    // pega lat e lng das class ".story" por data attribute
                    var latlng = jQuery(this).data().point.split(',');
                    var lat =  latlng[0];
                    var lng = latlng[1];
                    var desc = latlng[2];
                    var end = latlng[3];
                    var zoom = 17;
                            
                    // adiciona marcadores
                    var marker = L.marker([lat, lng] ).bindPopup(desc).addTo(map<?= $key; ?>);
                    // adiciona no mapa
                    map<?= $key; ?>.setView([lat, lng], zoom);
                    
                });
            }
        });
    
    <?php endforeach; ?>
	
}

</script>
<?php foreach($mapas as $key => $mapa): ?>
    <a href="#map<?= $key; ?>" class="story<?= $key; ?> d-none" data-point="<?= $mapa['latitude']; ?>,<?= $mapa['longitude']; ?>,<?= $mapa['texto_do_marcador']; ?>"> &nbsp;destacar no mapa</a>
    <div id="map<?= $key; ?>" style="min-height: 300px; margin-bottom: 20px;"></div>
<?php endforeach; ?>
