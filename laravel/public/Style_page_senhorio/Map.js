var map;
var directionsService;
var directionsDisplay;
var originMarker;

async function initMap() {
    var coimbra = {lat: 40.35827117617252, lng: -7.8569972177657075};
    map = new google.maps.Map(document.getElementById('map'), {
        center: coimbra,
        zoom: 15
    });
    const icon_m = "https://img.icons8.com/emoji/48/school-emoji.png";
    var estgoh_m = { lat: 40.361008858094266, lng: -7.861192556524104 };
     new google.maps.Marker({
        position: estgoh_m,
        icon:icon_m,
        map: map
    });
    directionsService =  new google.maps.DistanceMatrixService();
    directionsDisplay = new google.maps.DirectionsRenderer();
    directionsDisplay.setMap(map);

    map.addListener('click', function(event) {
        placeOriginMarker(event.latLng);
    });
}

function placeOriginMarker(location) {
    if (originMarker && originMarker.setMap) {
        originMarker.setMap(null);
    }
    const icon_casa_m = "https://img.icons8.com/plasticine/75/order-delivered.png";
    originMarker = new google.maps.Marker({
        position: location,
        icon:icon_casa_m,
        map: map
    });
    calcularDistancia(originMarker.getPosition());
}

function calcularDistancia(origin) {
    var estgoh = { lat: 40.361008858094266, lng: -7.861192556524104 };
    let  infoWindow = new google.maps.InfoWindow({
        position: origin,
    });
    directionsService.getDistanceMatrix(
        {
            origins: [origin],
            destinations: [estgoh],
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false,
        }, callback);

    function callback(response, status) {
        if (status == 'OK') {
            var origins = response.originAddresses;
            var destinations = response.destinationAddresses;

            for (var i = 0; i < origins.length; i++) {
                var results = response.rows[i].elements;
                for (var j = 0; j < results.length; j++) {
                    var element = results[j];
                    var distance = element.distance.text;
                    document.getElementById('local').innerHTML = distance+" info"+ origin;
                }
            }
        } else {
            window.alert('Erro ao calcular a distância: ' + status);
        }
    }
}
