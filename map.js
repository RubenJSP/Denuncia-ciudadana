
function addMark(lat, long, type){
    var myLatlng = new google.maps.LatLng(lat, long);
    var icono;
    switch(type){
        case 'Arroyo': 
            icono = "http://localhost/webProyect/icos/water_drop.png" 
            break
        case 'Bache': 
            icono = "http://localhost/webProyect/icos/hole.png" 
            break
        case 'Animal': 
            icono = "http://localhost/webProyect/icos/animal.png" 
            break
        case 'Reparación': 
            icono = "http://localhost/webProyect/icos/shovel.png" 
            break
    }

    var marker = new google.maps.Marker({
        position: myLatlng, 
        map: map,
        icon: icono,
        title: type
    }); 
}
