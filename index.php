<?php
	  require_once 'userData.php';

	if(!isset($_SESSION))
		session_start();

	if(isset($_SESSION['user'])){
		if($datos['tipo']!=2)
			header("Location: mapa.php");
		else
			header("Location: admin.php");
	}
	if(isset($_GET['done'])){


		echo '<div class="alert alert-success" role="alert" style="margin:10px auto; width:800px;">
	  			Su registro se completó correctamente, ahora puede iniciar sesión.
			</div>';
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Iniciar sesión</title>
	<link rel="stylesheet" type="text/css" href="RegisterStyle.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</head>
<body>
	<form id="loginFrm" method="POST" class="register-container" style="width: 700px; border-radius: 5px;">
		<div class="title-bar">	<h2> Iniciar sesión </h2>	</div>
		<div class="item-container" style="flex-direction: column;">
			<div class="input-container" style="margin-bottom: 20px;">
				<label>Correo electrónico:</label>
				<input type="email" id="mail" name="correo" placeholder="Correo electrónico" class="input-text"  required>
			</div>
			<div class="input-container">
				<label>Contraseña:</label>
				<input type="password" id="pass" name="password" placeholder="Contraseña" class="input-text"  required>
			</div>
			<div class="item-container" style="flex-direction: column; align-items: center; justify-content: center; padding-top: 30px;">
			<input type="submit" id="go" value="Iniciar sesión" class="btn btn-primary" style="width: 30%; height:50px">
			<a href="register.php">¿No tienes una cuenta?</a>
		</div>
		</div>
	</form>
	 <script type="text/javascript" src="validateLogin.js"></script>
</body>
</html>