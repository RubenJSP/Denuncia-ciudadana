<?php
    require_once 'userData.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <script type="text/javascript" src="map.js"></script>
</head>
<body>
    <header class="header">
        <div class="logo">
            <h2>Denuncia Ciudadana</h2>
        </div>
        <div class="opciones">
            <ul>
                <?php
                    if($datos['tipo']!=2){
                        echo '<li><a href="mapa.php"><i class="fas fa-user"></i> '. $datos['nombre'].'</a> </li>
                    <li><a href="reportes.php"><i class="fas fa-flag-checkered"></i> Mis Reportes</a> </li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a> </li>';
                    }else{
                        echo  '<li><a href="admin.php"><i class="fas fa-user-shield"></i> '. $datos['nombre'].'</a> </li> <li><a href="register.php"><i class="fas fa-users"></i> Registrar administrador</a> </li>
                        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a> </li>';
                    }
                 ?>
                
            </ul>
        </div>
    </header>