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
    const icon = "https://img.icons8.com/emoji/48/school-emoji.png";
    var estgoh_q = { lat: 40.361008858094266, lng: -7.861192556524104 };
    new google.maps.Marker({
        position: estgoh_q,
        icon:icon,
        map: mapQuarto
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
    const icon_casa_q = "https://img.icons8.com/plasticine/75/order-delivered.png";
    originMarkerQuarto = new google.maps.Marker({
        position: locationQuarto,
        icon:icon_casa_q,
        map: mapQuarto
    });
    calcularDistanciaQuarto(originMarkerQuarto.getPosition());
}

function calcularDistanciaQuarto(originQuarto) {
    var estgohQuarto = { lat: 40.361008858094266, lng: -7.861192556524104 };
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
                    document.getElementById('Distancia').value = element.distance.text;
                    document.getElementById('letLag').value = originQuarto;
                    document.getElementById('localPorQuarto').innerHTML = distance;
                }
            }
        } else {
            window.alert('Erro ao calcular a distância: ' + status);
        }
    }
}
