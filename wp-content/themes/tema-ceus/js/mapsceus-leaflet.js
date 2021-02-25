window.onload = function() {

    //matem o focu no mapa
    jQuery("#map").mouseover(function() {
        jQuery('#map').focus();
    });


    //seta coordenadas inicial do mapa pegando o primeiro valor da lista de contatos
    var latlng = jQuery('.story').data().point.split(',');
    //console.log(latlng);
    var lat = latlng[0];
    var lng = latlng[1];

    var tileLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: false
    });

    var map = L.map('map', {
            zoomControl: true,
            layers: [tileLayer],
            maxZoom: 18,
            minZoom: 6
        })
        .setView([lat, lng], 17);


    jQuery("a[href='#chegar']").on("click", function(e) {
        map.invalidateSize(true);
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
        setTimeout(function() {
            map.invalidateSize();
        }, 200);
    });

    //adiciona marcadores iniciais dos contatos
    //jQuery('.story').each(function(i) {
    //if (jQuery(this).attr('data-point') != null + i + 1) {

    jQuery(this).each(function() {
        //console.log(jQuery(this).attr('data-point'));

        // pega lat e lng das class ".story" por data attribute
        //var latlng = jQuery(this).data().point.split(',');
        var lat = latlng[0];
        var lng = latlng[1];
        var desc = latlng[2];
        var zoom = 17;


        // adiciona marcadores
        var marker = L.marker([lat, lng]).bindPopup(desc).addTo(map);

        // adiciona no mapa
        map.setView([lat, lng], zoom);

    });
    //}
    //});

}