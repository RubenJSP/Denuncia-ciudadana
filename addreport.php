<?php include('template/header.php');  ?>
<?php
     if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    if(!isset($_SESSION['user'])) 
    { 
       header("Location: index.php");
    }
    $Msjerror = "";
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      $Msjerror = $_SESSION['message'];
      unset($_SESSION['message']);
    }
    if($Msjerror==='OK'){
        $Msjerror = "";
    }
?>
  <script>
        var map
        function initMap() {
            var latA
            var lonA
            if ("geolocation" in navigator){ 
                navigator.geolocation.getCurrentPosition(function(position){ 
                    latA = position.coords.latitude
                    lonA = position.coords.longitude
                })
            }else{
                latA = 24.142582
                lonA = -110.312658
            }
            if(latA==null && lonA == null){
                latA = 24.142582
                lonA = -110.312658
            }
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 24.142582, lng: -110.312658},
                zoom: 15,
                streetViewControl: false,
                mapTypeControl: false
            })
            var myLatlng = new google.maps.LatLng(latA, lonA);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                animation: google.maps.Animation.DROP,
                draggable:true
            })
            marker.addListener( 'dragend', function (event){
                //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                document.getElementById("ll").value = this.getPosition().lat()
                document.getElementById("lg").value = this.getPosition().lng()
            })
        } 	

    </script>
    <div class="firstP">
        <H4>Seleccionar Ubicación:</H4>
    </div>
    <div class="mapS" id="map" style="border: 1px solid #000;">

    </div>
    <div class="data-report">
        <form method="POST" action="upload.php" enctype="multipart/form-data">
            <input type="hidden" name="lat" id="ll">
            <input type="hidden" name="long" id="lg">

            <div class="row">
                <label> <b>Tipo de Reporte:</b></label>
                <select name="option" style="height: 40px; border-radius: 3px;">
                    <option value="Bache">Bache</option>
                    <option value="Animal">Animal Muerto</option>
                    <option value="Arroyo">Arroyo Corriendo</option>
                    <option value="Fuego">Incendio en Terreno</option>
                </select>
            </div>
            <div class="row">
                <label><b>Imagen: (Opcional)</b></label> 
                <input name="uploadedFile" type="file"/>
            </div>
            <div class="row">
                <label><b>Comentario: (Opcional)</b></label> 
                <textarea id='com' name="comentary" cols="40" rows="5"></textarea>
            </div>
            <div class="row">
                <label><?php echo $Msjerror ?></label> 
            </div>
            <div style="width: 100%; display: flex; align-items: center; justify-content: center;">
                <input type="submit" value="Registrar" name="uploadBtn" class="btn btn-primary" style="width: 15%;">
            </div>
        </form>
    </div>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_a1sSLqq6Wcq3hrBMAGeBybVq9CrJrDU&callback=initMap">
    </script>
    <?php include 'template/footer.php'; ?>
</body>
</html>