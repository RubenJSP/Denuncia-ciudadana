<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>REGISTRO</title>
	<link rel="stylesheet" type="text/css" href="RegisterStyle.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="ValidateRegister.js"></script>
</head>
<body class="body">
	<header>
		
	</header>
	<form action="registerUser.php" method="POST" class="register-container" onsubmit="return validate();">
		<div class="title-bar">	<h2> CREAR CUENTA </h2>	</div>
		<div id="itemCont" class="item-container">
			<div class="input-container">
				<label>Nombre:</label>
				<input type="text" id="nombre" name="name" placeholder="Nombre" class="input-text"  required>
			</div>
			<div class="input-container">
				<label>Apellido paterno: </label>
				<input type="text" id="apellido_1" name="aP" placeholder="Apellido paterno" class="input-text" required >
			</div>
			<div class="input-container">
				<label>Apellido materno: </label>
				<input type="text" id="apellido_2" name="aM" placeholder="Apellido materno" class="input-text" required>
			</div>
		</div>

		<div class="item-container">
			<div class="input-container">
				<label>Correo electrónico: </label>
				<input type="email" id="correo_1" name="e1" placeholder="Correo electrónico" class="input-text" required>
			</div>
			<div class="input-container">
				<label>Confirmar correo electrónico: </label>
				<input type="email" id="correo_2" placeholder="Correo electrónico" class="input-text" required>
			</div>
		</div>

		<div class="item-container">
			<div class="input-container">
				<label>Contraseña: </label>
				<input type="password" id="pass_1" name="pass" placeholder="Contraseña" class="input-text" required>
			</div>
			<div class="input-container">
				<label>Confirmar contraseña: </label>
				<input type="password" id="pass_2" placeholder="Contraseña" class="input-text" required >
			</div>
		</div>

		<div class="item-container">
			<div class="input-container">
				<label>Fecha de nacimiento: </label>
				<input type="date" id="fecha" name="dat" class="input-text">
			</div>
		</div>

		<div class="item-container" style="flex-direction: column; align-items: center; justify-content: center; padding-top: 30px;">
			<input type="submit" value="Registrarme" class="btn btn-primary" style="width: 30%; height:50px">
			<a href="index.php">Ya tengo una cuenta</a>
		</div>

		<div id="error" class="item-container" style="flex-direction: column; align-items: center; justify-content: center; padding-top: 10px;"> <?php 
				if(isset($_GET['exist']))
					echo '<div class="alert alert-danger" role="alert">
						  	El correo electrónico ingresado ya existe
						</div>';
			 ?> </div>

	</form>
</body>
</html>