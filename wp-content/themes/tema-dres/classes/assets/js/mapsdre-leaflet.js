window.onload = function() {
	
	//matem o focu no mapa
	jQuery( "#map" ).mouseover(function() {
	  jQuery('#map').focus();
	});
	
	
	//seta coordenadas inicial do mapa pegando o primeiro valor da lista de contatos
	var latlng = jQuery('.story').data().point.split(',');
	var lat = latlng[0];
	var lng = latlng[1];
	map = L.map('map', { center: [lat, lng], zoom: 17 });
	
	//monta a imagem do mapa
	L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	  subdomains: ['a', 'b', 'c']
	}).addTo( map )

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
				
				//verifica se o valor veio vazio do cadastro
				/*if(lat == '' || lng == ''){			
				   }*/

				// busca latitude e longitude dinamico
					/*jQuery.getJSON('https://nominatim.openstreetmap.org/search?format=json&limit=5&q=' + end, function(data) {
						
					  var items = [];

						  jQuery.each(data, function(key, val) {
							bb = val.boundingbox;
							latitude = val.lat;
							longitude = val.lon;
							items.push( latitude + longitude  );
						  });			

						alert(end + latitude + longitude);

					});*/
				
						
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
