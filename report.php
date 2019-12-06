<?php
 	include('template/header.php');
 	require_once 'userData.php';
 	require_once 'genInfo.php';
 	if(!isset($_SESSION))
 		session_start();

	if(!isset($_SESSION['user'])) 
    { 
       header("Location: index.php");
    }
    $dat= '';
	  require_once 'conection.php';

	 if(isset($_GET['msj'])){
	 	if($_GET['msj'] == '1'){
	  	echo'<div style="text-align: center;" class="alert alert-success" role="alert">
		  Se ha finalizado el reporte.
		</div>';
	  }else{
	  	echo'<div style="text-align: center;" class="alert alert-success" role="alert">
		  Se ha cancelado el reporte.
		</div>';
	  }
	 }


	function getReports($id){
	  	 $dbh = connectDB();
            $query = 'SELECT * FROM denuncias WHERE idDenuncia = :idDenuncia';
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':idDenuncia', $id);
            $stm->execute();
            $data = $stm->fetch();
            return $data;
        }
            $myID= $datos['idUser'];
            $uName = $datos['nombre'];
            $tipo = $datos['tipo'];
        if(isset($_GET['report'])){
			$id= $_GET['report'];
			$dat = getReports($id);
			$guestName = getGenInfo($dat['idUser']);
			$_SESSION['actual'] = $id;
        }
        function loadChat($id, $myID, $uName, $tipo){
			$dbh = connectDB();
            $query = 'SELECT * FROM comentarios WHERE idDenuncia = :idDenuncia';
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':idDenuncia', $id);
            $stm->execute();
            $type='';
 			$otherName = '';
             while($row=$stm->fetch()){
             	 $otherName = getGenInfo($row['idUser']);
	             if($tipo==1){
	             	if($myID==$row['idUser'])
	             		$type .= '<li><i class="fas fa-user"></i> '.$uName.': '.$row['mensaje'].'</li>';
	             	else
	             		$type .= '<li><i class="fas fa-user-shield"></i>'.$otherName['nombre'].'(Admin): '.$row['mensaje'].'</li>';
	             }else{
	             	if($myID==$row['idUser'])
	             		$type .= '<li><i class="fas fa-user-shield"></i>'.$uName.'(Admin): '.$row['mensaje'].'</li>';
	             	else{
	             		if($otherName['tipo']!=2)
	             		$type .= '<li><i class="fas fa-user"></i>'.$otherName['nombre'].': '.$row['mensaje'].'</li>';
	             		else
	             			$type .= '<li><i class="fas fa-user-shield"></i>'.$otherName['nombre'].'(Admin): '.$row['mensaje'].'</li>';
	             	}
	             }
             }

            return $type;	
        }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reporte <?php echo $dat['tipo'];  ?></title>
		<link rel="stylesheet" type="text/css" href="style2.css">
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
</head>

</head>
<body>
	<div class="map" id="map" style="width: 70%; border: 1px solid #000;"> </div>
	<script>
        var map
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: <?php echo $dat['latitud'];?>, lng: <?php echo $dat['longitud'];?>},
                zoom:18,
                streetViewControl: false,
                mapTypeControl: false
            })
            
           <?php
           	 echo 'addMark('.$dat['latitud'].','.$dat['longitud'].',"'.$dat['tipo'].'")';
           ?>
        } 	
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_a1sSLqq6Wcq3hrBMAGeBybVq9CrJrDU&callback=initMap">
    </script>

	<div class="container" style="display: flex;">
		<div class="container" style="margin-top: 0px;">
			<div class="img-View" style="width: 50%;">
				<img src="uploaded_files/<?php echo $dat['img']; ?>">
			</div>
			<div class="info-cont" style="word-wrap: break-word;">
				<ul>
					<li><b>Tipo de reporte:</b> <?php echo $dat['tipo']; ?> </li>
					<li><b>Estatus del reporte:</b> <?php echo $dat['estatus']; ?> </li>
					<li><b>Descripción:</b> <?php echo $dat['descripcion']; ?> </li>
					<?php  if($tipo!=1) echo '<li><b>Reporta:</b> '.$guestName['nombre'].' '.$guestName['apellidoPaterno'].' '.$guestName['apellidoMaterno'].'</li>'; ?>
				</ul>
				<div class="controls">
					<?php

					if($tipo!=1){
						
						echo '<div style="display: flex;">';
						if($dat['estatus']!="Finalizado")
						echo'<a href="status.php?end=Finalizado" class="btn btn-success" style="margin-right: 8px;">Finalizada</a>';
						
						if($dat['estatus']!="Cancelado")
						echo'<a href="status.php?cancel=Cancelado" class="btn btn-warning" style="margin-right: 		8px;">Cancelar</a>';
						
						echo '<a Onclick="return ConfirmDelete();" href="status.php?delete=eliminar" class="btn btn-danger">Eliminar reporte</a>';
						echo '</div>';
					}

					 ?>
					<script>
					    function ConfirmDelete()
					    {
					      var x = confirm("Se eliminará el reporte ¿Desea continuar?");
					      if (x)
					          return true;
					      else
					        return false;
					    }
					</script>  
					
				</div>
			</div>
		</div>
			
	
		<form action="saveCom.php" method="POST" style="margin-bottom: 70px;">
			<div class="container">
				<h6>Comentarios: </h6>
				<div class="chat" style="margin-bottom: 10px;"> 
					<ul>
						<?php echo loadChat($id, $myID, $uName, $tipo);  ?>
					</ul>
				</div>
					<div style="display: flex; flex-direction: column; width: 100%;">
						<H6>Escribe un comentario: </H6>
						<input type="hidden" name="idUser" value="<?php echo $datos['idUser']; ?>">
						<input type="hidden" name="idDenuncia" value="<?php echo $dat['idDenuncia']; ?>">
						<textarea name="mensaje" rows="4" cols="50"></textarea>	
						<input type="submit" class="btn btn-primary" name="" value="Enviar" style="width: 200px; margin: 10px 0 10px;">
					</div>
			</div>	
		</form>	
	</div>

	<?php include 'template/footer.php'; ?>
</body>
</html>



