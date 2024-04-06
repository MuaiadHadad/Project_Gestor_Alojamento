var letValue = document.getElementById('letValue').dataset.let;
var matches = letValue.match(/\(([^,]+),\s*([^)]+)\)/);
var latitude = parseFloat(matches[1].trim());
var longitude = parseFloat(matches[2].trim());
function initMap() {
    const myLatLng = { lat: 40.35827117617252, lng: -7.8569972177657075 };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: myLatLng,
    });
    const icon_escola = "https://img.icons8.com/emoji/55/school-emoji.png";
    var estgoh = { lat: 40.361008858094266, lng: -7.861192556524104 };
     new google.maps.Marker({
        position: estgoh,
        icon:icon_escola,
        map: map,
        title: "Hello World!",
    });
    const icon_casa = "https://img.icons8.com/plasticine/75/order-delivered.png";
    var casa = { lat: latitude, lng: longitude };
    new google.maps.Marker({
        position: letValue,
        icon:icon_casa,
        map: map,
        title: "Hello World!",
    });
}
