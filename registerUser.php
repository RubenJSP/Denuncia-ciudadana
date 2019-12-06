<?php
	require_once('conection.php');
	require_once 'userData.php';
	$tipo = 1;
	if(!isset($_SESSION)){
 		session_start();

	 }
	 if(isset($_SESSION)){
	 	if(isset($_SESSION['user'])){
	 		if($datos['tipo'] != 1)
	 			$tipo = 2;
	 	}
	 }


	if(isset($_POST['name']))
		$nombre = $_POST['name'];
	if(isset($_POST['aP']))
		$aP = $_POST['aP'];
	if(isset($_POST['aM']))
		$aM = $_POST['aM'];
	if(isset($_POST['e1']))
		$mail = $_POST['e1'];
	if(isset($_POST['pass']))
		$pass = $_POST['pass'];
	if(isset($_POST['dat']))
		$fecha = $_POST['dat'];

	

	function saveUser($nombre, $aP, $aM, $mail, $pass, $fecha, $tipo) 
			{
					$dbh = connectDB();
					$query = 'INSERT INTO users (nombre,apellidoPaterno,apellidoMaterno,eMail,pass,fechaDeNacimiento,tipo)VALUES(:name, :aP, :aM, :mail,:pass, :fecha, :type)';
					$stm = $dbh->prepare($query);
					$stm->bindParam(':name', $nombre);
					$stm->bindParam(':aP', $aP);
					$stm->bindParam(':aM', $aM);
					$stm->bindParam(':mail', $mail);
					$stm->bindParam(':pass', $pass);
					$stm->bindParam(':fecha', $fecha);
					$stm->bindParam(':type', $tipo);
					$stm->execute();
				}

	 function findMail($mail){
            $dbh = connectDB();
            $query = 'SELECT * FROM users WHERE eMail = :mail';
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':mail', $mail);
            $stm->execute();
            $data = $stm->fetch();
            return $data;
    	}

				if(isset($_POST['name'])){
					$match = findMail($mail);

					if($mail != $match['eMail'])
					saveUser($nombre, $aP, $aM, $mail, $pass, $fecha, $tipo);
					else
					 header("Location: register.php?exist=yes");	

				}




?>
<!DOCTYPE html>
<html>
<head>
	<title>REGISTRO</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<style> 
		.done{
			margin: 150px auto;
			width: 100%;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}

	</style>
</head>
<body>
	<div class="done">
		<?php
			if(isset($_SESSION['user'])){
				if($datos['tipo']!=1)
					header("Location: admin.php");
				else
					header("Location: logout.php");

			}


		?>
			<div class="alert alert-success" role="alert">
	  			Su registro se completó correctamente, ahora puede iniciar sesión.
			</div>
			<a class="btn btn-primary" href="index.php">Iniciar sesión</a>
	</div>


</body>
</html>