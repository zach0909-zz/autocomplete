var map;
function initialize(){
    var coords = {lat: 31.0461, lng: 34.8516};
    var options = {
        zoom: 18,
        center: new google.maps.LatLng(coords.lat, coords.lng)
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), options);
    
}

