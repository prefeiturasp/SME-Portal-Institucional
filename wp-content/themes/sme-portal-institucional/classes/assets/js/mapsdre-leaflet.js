window.onload = function() {
	
	//matem o focu no mapa
	jQuery( "#map2" ).mouseover(function() {
	  jQuery('#map2').focus();
	});
	
	
	//seta coordenadas inicial do mapa pegando o primeiro valor da lista de contatos
	var latlng = jQuery('.storyb').data().point.split(',');
	var lat = latlng[0];
	var lng = latlng[1];
	map = L.map('map', { center: [lat, lng], zoom: 17 });
	map2 = L.map('map2', { center: [lat, lng], zoom: 17 });

	var latlng2 = jQuery('.story').data().point.split(',');
	
	//monta a imagem do mapa
	L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	  subdomains: ['a', 'b', 'c']
	}).addTo( map )

	//monta a imagem do mapa
	L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	  subdomains: ['a', 'b', 'c']
	}).addTo( map2 )

	//adiciona marcadores iniciais dos contatos
	jQuery('.story').each(function(i) {
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
				var marker = L.marker([lat, lng] ).bindPopup(desc).addTo(map);
				// adiciona no mapa
				map.setView([lat, lng], zoom);
                
            });
        }
    });
	
	//adiciona link aos marcadores
	jQuery('.story').on('click', function(){
		// pega lat e lng das class ".story" por data attribute
		var latlng = jQuery(this).data().point.split(',');
		var lat = latlng[0];
		var lng = latlng[1];
		var desc = latlng[2];
		var zoom = 17;
			
		//alert(lat + lng + desc);
		
		// adiciona marcadores
	 	var marker = L.marker([lat, lng] ).bindPopup(desc).addTo(map).openPopup();
		// adiciona no mapa
		map.setView([lat, lng], zoom);
	})
}
