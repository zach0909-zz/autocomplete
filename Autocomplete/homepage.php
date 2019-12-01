
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    #map-canvas {
        width: 100%;
        height: 100%;
    }
    html { height: 80%; }
    body { height: 80%; }
    </style>
</head>
<body>
    
<input id="pac-input" class="controls" type="text" placeholder="Type your place here">
<div id="map-canvas"></div>
<script src="initializeMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=INSERT_API_KEY_HERE&callback=initialize&libraries=places"></script>
<script>
    var input = document.getElementById('pac-input');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input); //push input into map
    var infoWindow;
    infoWindow = new google.maps.InfoWindow;

    //get current location for distance matrix
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        infoWindow.setPosition(pos);
        infoWindow.setContent('This is your current location.');
        infoWindow.open(map);
        map.setCenter(pos);
        }, function() {
        handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
     

     function handleLocationError(browserHasGeolocation, infoWindow, pos) {
       infoWindow.setPosition(pos);
       infoWindow.setContent(browserHasGeolocation ?
                             'Error: The Geolocation service failed.' :
                             'Error: Your browser doesn\'t support geolocation.');
       infoWindow.open(map);
     }       


    var autocomplete = new google.maps.places.Autocomplete(input);

    google.maps.event.addListener(autocomplete, 'place_changed', function(){
        place = autocomplete.getPlace();
        
            navigator.geolocation.getCurrentPosition(function(position) {
           var pos = {
             lat: position.coords.latitude,
             lng: position.coords.longitude
           };

            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix(
                {
                    destinations: [new google.maps.LatLng({lat: place.geometry.location.lat(),lng: place.geometry.location.lng() })],
                    origins: [new google.maps.LatLng({lat: pos.lat,lng:pos.lng})],
                    travelMode: 'DRIVING',
                }, callback);
                
            });

            function callback(response, status) {
                if (status == 'OK') {
                    var origins = response.originAddresses;
                    var destinations = response.destinationAddresses;
                    
                    for (var i = 0; i < origins.length; i++) {
                    var results = response.rows[i].elements;
                    for (var j = 0; j < results.length; j++) {
                        var element = results[j];
                        var distance = element.distance.text;
                    }
                    infoWindow.setContent("Distance from your current location is:  " + distance);
                    infoWindow.open(map);

                    }
                }
            }
});
</script>
</body>
</html>
