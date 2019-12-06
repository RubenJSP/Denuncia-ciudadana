<?php
if(!isset($_SESSION))
 		session_start();
	require_once ('conection.php');
	
	if(!isset($_SESSION['user'])) 
    { 
       header("Location: index.php");
    }
    function saveComent($idDenuncia, $idUser,$msj){
    	$dbh = connectDB();
		$query = 'INSERT INTO comentarios (mensaje,idDenuncia,idUser)VALUES(:mensaje,:idDenuncia,:idUser)';
		$stm = $dbh->prepare($query);
		$stm->bindParam(':mensaje', $msj);
		$stm->bindParam(':idDenuncia', $idDenuncia);
		$stm->bindParam(':idUser', $idUser);
		$stm->execute();
    }

	if(isset($_POST['mensaje'])){
		$mensaje =$_POST['mensaje'];
		$idUser = $_POST['idUser'];
		$idDenuncia = $_SESSION['actual'];
		saveComent($idDenuncia, $idUser,$mensaje);
      	header("Location: report.php?report=".$idDenuncia);	
	}
?>