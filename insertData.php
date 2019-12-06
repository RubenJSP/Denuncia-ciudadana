<?php
	require_once 'conection.php';
	function saveReport($lat, $long,$tipo,$desc,$img,$fecha,$id,$estatus){
		$dbh = connectDB();
		$query = 'INSERT INTO denuncias (latitud,longitud,tipo,descripcion,img,fechaRegistro,idUser, estatus)VALUES(:lat, :long, :tipo, :descp,:img, :fecha, :user, :estatus)';
		$stm = $dbh->prepare($query);
		$stm->bindParam(':lat', $lat);
		$stm->bindParam(':long', $long);
		$stm->bindParam(':tipo', $tipo);
		$stm->bindParam(':descp', $desc);
		$stm->bindParam(':img', $img);
		$stm->bindParam(':fecha', $fecha);
		$stm->bindParam(':user', $id);
		$stm->bindParam(':estatus', $estatus);
		$stm->execute();
	}

?>