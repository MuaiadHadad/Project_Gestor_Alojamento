var mapQuarto;
var directionsServiceQuarto;
var directionsDisplayQuarto;
var originMarkerQuarto;

async function initMapQuarto() {
    var coimbraQuarto = {lat: 40.35827117617252, lng: -7.8569972177657075};
    mapQuarto = new google.maps.Map(document.getElementById('mapPorQuarto'), {
        center: coimbraQuarto,
        zoom: 15
    });
    directionsServiceQuarto =  new google.maps.DistanceMatrixService();
    directionsDisplayQuarto = new google.maps.DirectionsRenderer();
    directionsDisplayQuarto.setMap(mapQuarto);

    mapQuarto.addListener('click', function(event) {
        placeOriginMarkerQuarto(event.latLng);
    });
}

function placeOriginMarkerQuarto(locationQuarto) {
    if (originMarkerQuarto && originMarkerQuarto.setMap) {
        originMarkerQuarto.setMap(null);
    }
    originMarkerQuarto = new google.maps.Marker({
        position: locationQuarto,
        map: mapQuarto
    });
    calcularDistanciaQuarto(originMarkerQuarto.getPosition());
}

function calcularDistanciaQuarto(originQuarto) {
    var estgohQuarto = { lat: 40.3586, lng: -7.8574 };
    directionsServiceQuarto.getDistanceMatrix(
        {
            origins: [originQuarto],
            destinations: [estgohQuarto],
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false,
        }, callbackQuarto);

    function callbackQuarto(response, status) {
        if (status == 'OK') {
            var origins = response.originAddresses;
            var destinations = response.destinationAddresses;

            for (var i = 0; i < origins.length; i++) {
                var results = response.rows[i].elements;
                for (var j = 0; j < results.length; j++) {
                    var element = results[j];
                    var distance = element.distance.text;
                    document.getElementById('localPorQuarto').innerHTML = distance+" info"+ originQuarto;
                }
            }
        } else {
            window.alert('Erro ao calcular a distância: ' + status);
        }
    }
}
