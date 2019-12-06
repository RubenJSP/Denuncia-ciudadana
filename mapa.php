<?php include('template/header.php'); ?>
<?php
    if(!isset($_SESSION['user'])) 
    { 
       header("Location: index.php");
    }
    require_once ('conection.php');
    function printMarkers(){
        $dbh = connectDB();
		$query = "SELECT * FROM denuncias";
		$stm = $dbh->prepare($query);
		$stm->setFetchMode(PDO::FETCH_ASSOC);
        $stm->execute();
        while($row=$stm->fetch()) {
            $lat = $row['latitud'];
            $long = $row['longitud'];
            $type = $row['tipo'];
            echo "addMark($lat,$long,'$type')";
            echo "\n";
        }
    }    
?>
    <header> <title>Mapa</title></header>
    <div class="map" id="map">
    </div>
    <div style="margin-bottom: 70px;">
            <button class="btn btn-primary mbt" style="padding:10px 50px 10px; margin-left: 150px;" id="btn-new" onclick="changePage();">Hacer Nuevo Reporte</button>

    </div>
    <script>
        var map
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 24.142582, lng: -110.312658},
                zoom: 15,
                streetViewControl: false,
                mapTypeControl: false
            })
            
            <?php
                printMarkers();
            ?>
        } 	

        function changePage(){
            location.href='addreport.php'
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_a1sSLqq6Wcq3hrBMAGeBybVq9CrJrDU&callback=initMap">
    </script>
    <?php include 'template/footer.php'; ?>
</body>
</html>