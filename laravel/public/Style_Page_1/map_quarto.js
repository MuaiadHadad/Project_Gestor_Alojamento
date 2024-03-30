function initMap() {
    const myLatLng = { lat: 40.35827117617252, lng: -7.8569972177657075 };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: myLatLng,
    });
    var estgoh = { lat: 40.361008858094266, lng: -7.861192556524104 };
    originMarker = new google.maps.Marker({
        position: estgoh,
        map: map
    });
}
